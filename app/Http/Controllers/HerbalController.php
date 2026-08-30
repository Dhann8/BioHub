<?php

namespace App\Http\Controllers;

use App\Models\Herbal;
use App\Models\Symptom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HerbalController extends Controller
{
    // READ: Menampilkan Katalog Herbal (TOGA) dengan Search & Pagination
    public function index(Request $request)
    {
        $query = Herbal::with('symptoms');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('local_name', 'like', '%' . $search . '%')
                  ->orWhere('scientific_name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('evidence_level')) {
            $query->where('evidence_level', $request->evidence_level);
        }

        $herbals = $query->latest()->paginate(10);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($herbals, 200);
        }

        if ($request->is('admin/*')) {
            $symptoms = Symptom::orderBy('symptom_name')->get();
            return view('admin.herbal.page', compact('herbals', 'symptoms'));
        }

        return view('herbal.page', compact('herbals'));
    }

    // READ DETAIL: Tampilkan Detail Herbal Spesifik
    public function show($id)
    {
        $herbal = Herbal::with('symptoms')->findOrFail($id);
        return response()->json(['data' => $herbal], 200);
    }

    // CREATE: Tambah Data Herbal Baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'local_name'         => 'required|string|max:255',
            'scientific_name'    => 'required|string|max:255',
            'description'        => 'required|string',
            'preparation_method' => 'required|string',
            'dosage_guide'       => 'required|string',
            'safety_warning'     => 'nullable|string',
            'evidence_level'     => 'nullable|in:Empirical,Clinical_Trial',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'symptoms'           => 'nullable|array',
            'symptoms.*.id'      => 'exists:symptoms,id',
            'symptoms.*.plant_part_used' => 'nullable|string'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('herbal_images', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        unset($validated['image'], $validated['symptoms']);

        $herbal = Herbal::create($validated);

        // Attach relasi ke symptoms jika diberikan
        if ($request->has('symptoms') && is_array($request->symptoms)) {
            $attachData = [];
            foreach ($request->symptoms as $item) {
                $attachData[$item['id']] = ['plant_part_used' => $item['plant_part_used'] ?? null];
            }
            $herbal->symptoms()->attach($attachData);
        }

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Data herbal berhasil ditambahkan', 'data' => $herbal->load('symptoms')], 201);
        }

        return redirect()->route('admin.herbal.index')->with('success', 'Data herbal berhasil ditambahkan!');
    }

    // UPDATE: Perbarui Data Herbal
    public function update(Request $request, $id)
    {
        $herbal = Herbal::findOrFail($id);

        $validated = $request->validate([
            'local_name'         => 'sometimes|required|string|max:255',
            'scientific_name'    => 'sometimes|required|string|max:255',
            'description'        => 'sometimes|required|string',
            'preparation_method' => 'sometimes|required|string',
            'dosage_guide'       => 'sometimes|required|string',
            'safety_warning'     => 'nullable|string',
            'evidence_level'     => 'nullable|in:Empirical,Clinical_Trial',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {
            if ($herbal->image_url) {
                $oldPath = str_replace('/storage/', '', $herbal->image_url);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('image')->store('herbal_images', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        unset($validated['image']);

        $herbal->update($validated);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Data herbal berhasil diperbarui', 'data' => $herbal], 200);
        }

        return redirect()->route('admin.herbal.index')->with('success', 'Data herbal berhasil diperbarui!');
    }

    // READ & WIZARD: Symptom-to-Remedy Recommendation Engine
    public function findBySymptom(Request $request)
    {
        $symptomIds = $request->input('symptom_ids');

        if (is_string($symptomIds)) {
            $symptomIds = explode(',', $symptomIds);
        }

        $request->merge(['symptom_ids' => $symptomIds]);

        $request->validate([
            'symptom_ids'   => 'required|array',
            'symptom_ids.*' => 'exists:symptoms,id'
        ], [
            'symptom_ids.required' => 'Pilihlah minimal satu gejala penyakit.',
            'symptom_ids.*.exists' => 'Gejala yang dipilih tidak valid.'
        ]);

        // Algoritma pencocokan Many-to-Many
        $herbals = Herbal::whereHas('symptoms', function ($query) use ($symptomIds) {
            $query->whereIn('symptoms.id', $symptomIds);
        })->with(['symptoms' => function ($q) {
            $q->select('symptoms.id', 'symptom_name');
        }])->get();

        return response()->json([
            'status'      => 'success',
            'total_found' => $herbals->count(),
            'recommendations' => $herbals
        ], 200);
    }

    // DELETE: Soft Delete Data Herbal
    public function destroy($id)
    {
        $herbal = Herbal::findOrFail($id);
        $herbal->delete();

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json(['message' => 'Data herbal berhasil diarsipkan (soft delete)'], 200);
        }

        return redirect()->back()->with('success', 'Data herbal berhasil dihapus!');
    }
}
