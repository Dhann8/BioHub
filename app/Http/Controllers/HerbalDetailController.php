<?php

namespace App\Http\Controllers;

use App\Models\Herbal;
use App\Models\Symptom;
use App\Models\HerbalGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HerbalDetailController extends Controller
{
    /**
     * Tampilkan halaman pengelolaan detail herbal
     */
    public function index(Request $request)
    {
        $herbals = Herbal::orderBy('local_name')->get();

        $selectedHerbalId = $request->herbal_id ?: ($herbals->first() ? $herbals->first()->id : null);
        $selectedHerbal = null;

        if ($selectedHerbalId) {
            $selectedHerbal = Herbal::with([
                'symptoms',
                'activeCompounds',
                'gallery',
                'interactions',
            ])->findOrFail($selectedHerbalId);
        }

        $symptoms = Symptom::orderBy('symptom_name')->get();

        return view('admin.herbal.details', compact('herbals', 'selectedHerbal', 'symptoms'));
    }

    /**
     * Simpan / Perbarui semua detail herbal
     */
    public function update(Request $request, $id)
    {
        $herbal = Herbal::findOrFail($id);

        // 1. Update botanical & detail fields
        $herbal->update([
            'plant_family'          => $request->plant_family,
            'origin_region'         => $request->origin_region,
            'morphology_description'=> $request->morphology_description,
            'plant_parts'           => $request->plant_parts ? array_filter(array_map('trim', explode(',', $request->plant_parts))) : null,
            'cultivation_zone'      => $request->cultivation_zone,
            'preparation_method'    => $request->preparation_method,
            'dosage_guide'          => $request->dosage_guide,
            'safety_warning'        => $request->safety_warning,
            'evidence_level'        => $request->evidence_level,
            'description'           => $request->description,
        ]);

        // 2. Handle Map Image Upload
        if ($request->hasFile('map_image')) {
            if ($herbal->getRawOriginal('map_image_url') && !filter_var($herbal->getRawOriginal('map_image_url'), FILTER_VALIDATE_URL)) {
                $oldPath = str_replace('/storage/', '', $herbal->getRawOriginal('map_image_url'));
                Storage::disk('public')->delete($oldPath);
            }
            $path = $request->file('map_image')->store('herbal_maps', 'public');
            $herbal->update(['map_image_url' => '/storage/' . $path]);
        }

        // 3. Sync Symptoms (Many-to-Many)
        if ($request->has('symptom_ids')) {
            $attachData = [];
            foreach ((array)$request->symptom_ids as $index => $symId) {
                $plantPart = $request->plant_part_used[$index] ?? null;
                $attachData[$symId] = ['plant_part_used' => $plantPart];
            }
            $herbal->symptoms()->sync($attachData);
        } else {
            $herbal->symptoms()->detach();
        }

        // 4. Update Active Compounds (delete & recreate)
        $herbal->activeCompounds()->delete();
        if ($request->has('compounds')) {
            foreach ($request->compounds as $comp) {
                if (!empty(trim($comp['name'] ?? ''))) {
                    $herbal->activeCompounds()->create([
                        'compound_name'         => trim($comp['name']),
                        'pharmacological_effect' => $comp['effect'] ?? '',
                    ]);
                }
            }
        }

        // 5. Update Interactions / Contraindications
        $herbal->interactions()->delete();
        if ($request->has('interactions')) {
            foreach ($request->interactions as $inter) {
                if (!empty(trim($inter['title'] ?? ''))) {
                    $herbal->interactions()->create([
                        'title'       => trim($inter['title']),
                        'description' => $inter['description'] ?? '',
                        'severity'    => $inter['severity'] ?? 'Perhatian',
                    ]);
                }
            }
        }

        // 6. Gallery Upload
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $index => $file) {
                $path = $file->store('herbal_galleries', 'public');
                $caption = $request->gallery_captions[$index] ?? null;
                $herbal->gallery()->create([
                    'image_url' => '/storage/' . $path,
                    'caption'   => $caption,
                ]);
            }
        }

        // 7. Delete Gallery Items
        if ($request->has('delete_gallery_ids')) {
            foreach ($request->delete_gallery_ids as $galId) {
                $galItem = HerbalGallery::find($galId);
                if ($galItem) {
                    if (!filter_var($galItem->image_url, FILTER_VALIDATE_URL)) {
                        $oldPath = str_replace('/storage/', '', $galItem->image_url);
                        Storage::disk('public')->delete($oldPath);
                    }
                    $galItem->delete();
                }
            }
        }

        return redirect()->back()->with('success', 'Semua detail spesifikasi herbal berhasil diperbarui!');
    }
}
