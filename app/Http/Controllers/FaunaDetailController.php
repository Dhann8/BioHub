<?php

namespace App\Http\Controllers;

use App\Models\Fauna;
use App\Models\FaunaPhysicalCharacteristic;
use App\Models\FaunaEcologicalInfo;
use App\Models\FaunaGallery;
use App\Models\FaunaConservationProgram;
use App\Models\FaunaThreat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FaunaDetailController extends Controller
{
    /**
     * Tampilkan halaman pengelolaan detail fauna
     */
    public function index(Request $request)
    {
        $faunas = Fauna::orderBy('local_name')->get();
        
        $selectedFaunaId = $request->fauna_id ?: ($faunas->first() ? $faunas->first()->id : null);
        $selectedFauna = null;

        if ($selectedFaunaId) {
            $selectedFauna = Fauna::with([
                'taxonomy', 
                'physicalCharacteristics', 
                'ecologicalInfo', 
                'gallery', 
                'conservationPrograms', 
                'threats'
            ])->findOrFail($selectedFaunaId);
        }

        return view('admin.fauna.details', compact('faunas', 'selectedFauna'));
    }

    /**
     * Simpan / Perbarui semua detail fauna
     */
    public function update(Request $request, $id)
    {
        $fauna = Fauna::findOrFail($id);

        // 1. Update basic fauna detailed fields
        $fauna->update([
            'taxonomy_description' => $request->taxonomy_description,
            'lifespan'             => $request->lifespan,
            'offspring_count'      => $request->offspring_count,
            'gestation_period'     => $request->gestation_period,
            'social_pattern'       => $request->social_pattern,
            'iucn_code'            => $request->iucn_code,
            'iucn_description'     => $request->iucn_description,
            'legal_status'         => $request->legal_status,
            'population_trend'     => $request->population_trend,
        ]);

        // Handle Map Image Upload
        if ($request->hasFile('map_image')) {
            if ($fauna->map_image_url && !filter_var($fauna->map_image_url, FILTER_VALIDATE_URL)) {
                $oldMapPath = str_replace('/storage/', '', $fauna->map_image_url);
                Storage::disk('public')->delete($oldMapPath);
            }
            $path = $request->file('map_image')->store('fauna_maps', 'public');
            $fauna->update(['map_image_url' => '/storage/' . $path]);
        }

        // 2. Update Taxonomy details
        if ($fauna->taxonomy) {
            $fauna->taxonomy->update([
                'kingdom' => $request->kingdom ?: 'Animalia',
                'phylum'  => $request->phylum ?: 'Chordata',
                'order'   => $request->order,
                'family'  => $request->family,
            ]);
        }

        // 3. Update / Create Physical Characteristics
        $fauna->physicalCharacteristics()->updateOrCreate(
            ['fauna_id' => $fauna->id],
            [
                'size_and_weight'      => $request->size_and_weight,
                'distinctive_features' => $request->distinctive_features,
            ]
        );

        // 4. Update / Create Ecological Info
        $fauna->ecologicalInfo()->updateOrCreate(
            ['fauna_id' => $fauna->id],
            [
                'habitat_description' => $request->habitat_description,
                'diet_and_behavior'   => $request->diet_and_behavior,
                'quote'               => $request->quote,
            ]
        );

        // 5. Update Conservation Programs
        $fauna->conservationPrograms()->delete();
        if ($request->has('programs')) {
            foreach ($request->programs as $progText) {
                if (!empty(trim($progText))) {
                    $fauna->conservationPrograms()->create([
                        'title_or_description' => trim($progText)
                    ]);
                }
            }
        }

        // 6. Update Threats
        $fauna->threats()->delete();
        if ($request->has('threats')) {
            foreach ($request->threats as $threatData) {
                if (!empty($threatData['title'])) {
                    $fauna->threats()->create([
                        'title'       => $threatData['title'],
                        'description' => $threatData['description'] ?? '',
                        'icon'        => $threatData['icon'] ?? 'fa-solid fa-triangle-exclamation'
                    ]);
                }
            }
        }

        // 7. Update Gallery (Handle new images upload)
        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $index => $file) {
                $path = $file->store('fauna_galleries', 'public');
                $caption = $request->gallery_captions[$index] ?? null;
                $fauna->gallery()->create([
                    'image_url' => '/storage/' . $path,
                    'caption'   => $caption,
                ]);
            }
        }

        // Delete existing gallery item if requested
        if ($request->has('delete_gallery_ids')) {
            foreach ($request->delete_gallery_ids as $galId) {
                $galItem = FaunaGallery::find($galId);
                if ($galItem) {
                    if (!filter_var($galItem->image_url, FILTER_VALIDATE_URL)) {
                        $oldGalPath = str_replace('/storage/', '', $galItem->image_url);
                        Storage::disk('public')->delete($oldGalPath);
                    }
                    $galItem->delete();
                }
            }
        }

        return redirect()->back()->with('success', 'Semua detail spesifikasi fauna berhasil diperbarui!');
    }
}
