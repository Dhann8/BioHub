<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fauna;
use App\Models\Herbal;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    public function globalSearch(Request $request)
    {
        try {
            $keyword = trim($request->input('search'));
            $kategori = $request->input('kategori', 'all');

            if (empty($keyword)) {
                return response()->json([
                    'status' => 'not_found',
                    'message' => 'Silakan masukkan kata kunci pencarian.'
                ], 400);
            }

            // 1. Cari Fauna
            if ($kategori === 'fauna' || $kategori === 'all') {
                $fauna = Fauna::where('local_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('scientific_name', 'LIKE', "%{$keyword}%")
                    ->first();

                if ($fauna) {
                    return response()->json([
                        'status' => 'success',
                        'type' => 'fauna',
                        'redirect_url' => route('detail-spesies', ['id' => $fauna->id])
                    ]);
                }
            }

            // 2. Cari Herbal
            if ($kategori === 'herbal' || $kategori === 'flora' || $kategori === 'all') {
                $herbal = Herbal::where('local_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('scientific_name', 'LIKE', "%{$keyword}%")
                    ->first();

                if ($herbal) {
                    return response()->json([
                        'status' => 'success',
                        'type' => 'herbal',
                        'redirect_url' => route('detail-herbal', ['id' => $herbal->id])
                    ]);
                }
            }

            // 3. Jika Data Tidak Ditemukan
            return response()->json([
                'status' => 'not_found',
                'message' => 'Data tidak tersedia untuk "' . $keyword . '"'
            ], 404);

        } catch (\Throwable $e) {
            Log::error('Search Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan pada sistem.'
            ], 500);
        }
    }
}
