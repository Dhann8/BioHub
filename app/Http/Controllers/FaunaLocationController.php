<?php

namespace App\Http\Controllers;

use App\Models\Fauna;
use App\Models\FaunaLocation;
use Illuminate\Http\Request;

class FaunaLocationController extends Controller
{
    /**
     * Menampilkan halaman daftar lokasi GIS fauna
     */
    public function index(Request $request)
    {
        $query = FaunaLocation::with('fauna');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('region_name', 'like', '%' . $search . '%')
                  ->orWhereHas('fauna', function ($fq) use ($search) {
                      $fq->where('local_name', 'like', '%' . $search . '%')
                         ->orWhere('scientific_name', 'like', '%' . $search . '%');
                  });
            });
        }

        if ($request->filled('fauna_id')) {
            $query->where('fauna_id', $request->fauna_id);
        }

        $locations = $query->latest()->paginate(12);
        $faunas = Fauna::orderBy('local_name')->get();
        $totalLocations = FaunaLocation::count();
        $totalMappedFaunas = FaunaLocation::distinct('fauna_id')->count('fauna_id');

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json($locations, 200);
        }

        return view('admin.fauna.locations', compact('locations', 'faunas', 'totalLocations', 'totalMappedFaunas'));
    }

    /**
     * Menyimpan lokasi baru untuk fauna
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fauna_id'    => 'required|exists:faunas,id',
            'region_name' => 'required|string|max:255',
            'latitude'    => 'required|numeric|between:-90,90',
            'longitude'   => 'required|numeric|between:-180,180',
        ], [
            'fauna_id.required'    => 'Spesies fauna wajib dipilih.',
            'fauna_id.exists'      => 'Spesies fauna tidak valid.',
            'region_name.required' => 'Nama wilayah wajib diisi.',
            'latitude.required'    => 'Latitude wajib diisi.',
            'latitude.between'     => 'Nilai Latitude harus di antara -90 dan 90.',
            'longitude.required'   => 'Longitude wajib diisi.',
            'longitude.between'    => 'Nilai Longitude harus di antara -180 dan 180.',
        ]);

        $location = FaunaLocation::create($validated);

        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json(['message' => 'Lokasi fauna berhasil ditambahkan', 'data' => $location], 201);
        }

        return redirect()->back()->with('success', 'Lokasi baru untuk fauna berhasil ditambahkan!');
    }

    /**
     * Menghapus data lokasi
     */
    public function destroy($id)
    {
        $location = FaunaLocation::findOrFail($id);
        $location->delete();

        if (request()->wantsJson() || request()->is('api/*')) {
            return response()->json(['message' => 'Lokasi fauna berhasil dihapus'], 200);
        }

        return redirect()->back()->with('success', 'Lokasi fauna berhasil dihapus!');
    }
}
