<?php

namespace App\Http\Controllers;

use App\Models\Fauna;
use App\Models\Taxonomy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FaunaController extends Controller
{
    /**
     * Menampilkan daftar fauna dengan filter (untuk publik / web & API)
     */
    public function index(Request $request)
    {
        $query = Fauna::with(['taxonomy', 'locations']);

        // Filter Pencarian Nama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('local_name', 'like', '%' . $search . '%')
                  ->orWhere('scientific_name', 'like', '%' . $search . '%');
            });
        }

        // Filter Status IUCN
        if ($request->filled('iucn_status')) {
            $query->where('iucn_status', $request->iucn_status);
        }

        // Filter Taksonomi berdasarkan ID
        if ($request->filled('taxonomy_id')) {
            $query->where('taxonomy_id', $request->taxonomy_id);
        }

        // Filter Taksonomi berdasarkan nama (class_name) untuk wizard
        if ($request->filled('taxonomy')) {
            $taxonomyName = $request->taxonomy;
            $query->whereHas('taxonomy', function ($q) use ($taxonomyName) {
                $q->where('class_name', 'like', '%' . $taxonomyName . '%');
            });
        }

        // Filter Ukuran
        if ($request->filled('size')) {
            $query->where('size', $request->size);
        }

        // Filter Ciri Fisik (JSON)
        if ($request->filled('features')) {
            $features = is_array($request->features) ? $request->features : explode(',', $request->features);
            foreach ($features as $feature) {
                $query->whereJsonContains('physical_features', trim($feature));
            }
        }

        // Filter Wilayah
        if ($request->filled('region')) {
            $region = $request->region;
            $query->whereHas('locations', function ($q) use ($region) {
                $q->where('region_name', 'like', '%' . $region . '%');
            });
        }

        $perPage = $request->get('per_page', 12);
        $faunas = $query->latest()->paginate($perPage);
        $taxonomies = Taxonomy::all();

        // Respon JSON untuk Request API / AJAX
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($faunas, 200);
        }

        if ($request->is('admin/*')) {
            return view('admin.fauna.page', compact('faunas', 'taxonomies'));
        }

        return view('spesies.page', compact('faunas', 'taxonomies'));
    }

    /**
     * Detail Fauna
     */
    public function show($id)
    {
        $fauna = Fauna::with(['taxonomy', 'locations'])->findOrFail($id);

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json(['data' => $fauna], 200);
        }

        return view('users.fauna.show', compact('fauna'));
    }

    /**
     * Menyimpan data fauna baru
     */
    public function store(Request $request)
    {
        // Konversi input string koma ke array jika dikirim dari form biasa
        if ($request->filled('physical_features_input') && !$request->has('physical_features')) {
            $input = $request->input('physical_features_input');
            $request->merge([
                'physical_features' => array_filter(array_map('trim', explode(',', $input)))
            ]);
        }

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
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'region_name'       => 'nullable|string|max:255',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
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

        $locationData = [
            'region_name' => $validated['region_name'] ?? null,
            'latitude'    => $validated['latitude'] ?? null,
            'longitude'   => $validated['longitude'] ?? null,
        ];
        unset($validated['region_name'], $validated['latitude'], $validated['longitude']);

        $fauna = Fauna::create($validated);

        if (!empty($locationData['region_name'])) {
            $fauna->locations()->create([
                'region_name' => $locationData['region_name'],
                'latitude'    => $locationData['latitude'] ?? 0,
                'longitude'   => $locationData['longitude'] ?? 0,
            ]);
        }

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Data fauna berhasil ditambahkan', 'data' => $fauna->load('locations')], 201);
        }

        return redirect()->back()->with('success', 'Spesies fauna ' . $fauna->local_name . ' berhasil ditambahkan!');
    }

    /**
     * Memperbarui data fauna
     */
    public function update(Request $request, $id)
    {
        $fauna = Fauna::findOrFail($id);

        // Tambahkan parsing string ke array pada update
        if ($request->filled('physical_features_input') && !$request->has('physical_features')) {
            $input = $request->input('physical_features_input');
            $request->merge([
                'physical_features' => array_filter(array_map('trim', explode(',', $input)))
            ]);
        }

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
            'image'             => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'region_name'       => 'nullable|string|max:255',
            'latitude'          => 'nullable|numeric|between:-90,90',
            'longitude'         => 'nullable|numeric|between:-180,180',
        ]);

        if ($request->hasFile('image')) {
            // Hapus foto lama jika ada
            if ($fauna->image_url) {
                $oldPath = str_replace('/storage/', '', $fauna->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('fauna_images', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        unset($validated['image']);

        $regionName = $validated['region_name'] ?? null;
        $latitude = $validated['latitude'] ?? null;
        $longitude = $validated['longitude'] ?? null;
        unset($validated['region_name'], $validated['latitude'], $validated['longitude']);

        $fauna->update($validated);

        if (!empty($regionName)) {
            $fauna->locations()->create([
                'region_name' => $regionName,
                'latitude'    => $latitude ?? 0,
                'longitude'   => $longitude ?? 0,
            ]);
        }

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Data fauna berhasil diperbarui', 'data' => $fauna->load('locations')], 200);
        }

        return redirect()->back()->with('success', 'Data fauna berhasil diperbarui!');
    }

    /**
     * Hapus Data Fauna
     */
public function destroy($id)
{
    $fauna = Fauna::findOrFail($id);
    
    // 1. Hapus gambar dari storage jika ada
    if ($fauna->image_url) {
        $oldPath = str_replace('/storage/', '', $fauna->image_url);
        Storage::disk('public')->delete($oldPath);
    }

    // 2. Hapus relasi lokasi terlebih dahulu agar tidak kena Foreign Key Error
    if (method_exists($fauna, 'locations')) {
        $fauna->locations()->delete();
    }

    // 3. Hapus data fauna
    $fauna->delete();

    // 4. Return response sesuai request
    if (request()->wantsJson() || request()->is('api/*')) {
        return response()->json(['message' => 'Data fauna berhasil dihapus'], 200);
    }

    return redirect()->back()->with('success', 'Data fauna berhasil dihapus!');
}

    /**
     * Mendapatkan lokasi koordinat peta fauna
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