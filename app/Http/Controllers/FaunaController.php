<?php

namespace App\Http\Controllers;

use App\Models\Fauna;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FaunaController extends Controller
{
    /**
     * READ: Menampilkan Katalog Fauna dengan Filter Wizard & Live Search
     */
    public function index(Request $request)
    {
        $query = Fauna::with(['taxonomy', 'locations']);

        // 1. Live Search (Nama Lokal & Nama Ilmiah)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('local_name', 'like', '%' . $search . '%')
                  ->orWhere('scientific_name', 'like', '%' . $search . '%');
            });
        }

        // 2. Filter Status IUCN (CR, EN, VU, NT, LC)
        if ($request->filled('iucn_status')) {
            $query->where('iucn_status', $request->iucn_status);
        }

        // 3. Filter Kategori Taksonomi
        if ($request->filled('taxonomy_id')) {
            $query->where('taxonomy_id', $request->taxonomy_id);
        }

        // 4. [FILTER WIZARD] Ukuran Tubuh (Kecil, Sedang, Besar)
        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        // 5. [FILTER WIZARD] Fitur Unik (JSON Array Search)
        if ($request->filled('features')) {
            $features = is_array($request->features) ? $request->features : explode(',', $request->features);
            foreach ($features as $feature) {
                $query->whereJsonContains('physical_features', trim($feature));
            }
        }

        // 6. [FILTER WIZARD] Wilayah Habitat (Query Relasi FaunaLocations)
        if ($request->filled('region')) {
            $region = $request->region;
            $query->whereHas('locations', function ($q) use ($region) {
                $q->where('region_name', 'like', '%' . $region . '%');
            });
        }

        $faunas = $query->latest()->paginate(12);
        return response()->json($faunas, 200);
    }

    /**
     * READ DETAIL: Tampilkan Detail Satwa Spesifik
     */
    public function show($id)
    {
        $fauna = Fauna::with(['taxonomy', 'locations'])->findOrFail($id);
        return response()->json(['data' => $fauna], 200);
    }

    /**
     * CREATE: Tambah Data Satwa Baru (Admin Only)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'taxonomy_id'       => 'required|exists:taxonomies,id',
            'local_name'        => 'required|string|max:255',
            'scientific_name'   => 'required|string|max:255',
            'iucn_status'       => 'required|in:CR,EN,VU,NT,LC',
            'size'              => 'nullable|in:Kecil,Sedang,Besar',
            'physical_features' => 'nullable|array',
            'physical_features.*' => 'string',
            'primary_habitat'   => 'nullable|string|max:255',
            'description'       => 'required|string',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ], [
            'taxonomy_id.required' => 'Kategori taksonomi wajib dipilih.',
            'taxonomy_id.exists'   => 'Kategori taksonomi tidak ditemukan.',
            'local_name.required'  => 'Nama lokal wajib diisi.',
            'scientific_name.required' => 'Nama ilmiah wajib diisi.',
            'iucn_status.required' => 'Status IUCN wajib dipilih.',
            'iucn_status.in'       => 'Status IUCN tidak valid.',
            'size.in'              => 'Ukuran tubuh harus berupa Kecil, Sedang, atau Besar.',
            'description.required' => 'Deskripsi fauna wajib diisi.',
            'image.image'          => 'File foto harus berupa gambar.',
            'image.max'            => 'Ukuran foto maksimal 2MB.'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('fauna_images', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        unset($validated['image']);

        $fauna = Fauna::create($validated);
        return response()->json(['message' => 'Data fauna berhasil ditambahkan', 'data' => $fauna], 201);
    }

    /**
     * UPDATE: Perbarui Data Satwa
     */
    public function update(Request $request, $id)
    {
        $fauna = Fauna::findOrFail($id);

        $validated = $request->validate([
            'taxonomy_id'       => 'sometimes|required|exists:taxonomies,id',
            'local_name'        => 'sometimes|required|string|max:255',
            'scientific_name'   => 'sometimes|required|string|max:255',
            'iucn_status'       => 'sometimes|required|in:CR,EN,VU,NT,LC',
            'size'              => 'nullable|in:Kecil,Sedang,Besar',
            'physical_features' => 'nullable|array',
            'physical_features.*' => 'string',
            'primary_habitat'   => 'nullable|string|max:255',
            'description'       => 'sometimes|required|string',
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($fauna->image_url) {
                $oldPath = str_replace('/storage/', '', $fauna->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('fauna_images', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        unset($validated['image']);

        $fauna->update($validated);
        return response()->json(['message' => 'Data fauna berhasil diperbarui', 'data' => $fauna], 200);
    }

    /**
     * DELETE: Soft Delete Data Satwa
     */
    public function destroy($id)
    {
        $fauna = Fauna::findOrFail($id);
        $fauna->delete();

        return response()->json(['message' => 'Data fauna berhasil dihapus (soft delete)'], 200);
    }

    /**
     * READ: API Koordinat untuk Peta GIS Interaktif
     */
    public function getMapLocations()
    {
        $locations = Fauna::with('locations:id,fauna_id,region_name,latitude,longitude')
            ->select('id', 'local_name', 'scientific_name', 'iucn_status', 'image_url')
            ->has('locations')
            ->get();

        return response()->json($locations, 200);
    }
}