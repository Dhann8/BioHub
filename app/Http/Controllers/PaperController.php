<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Paper;
use Illuminate\Http\Request;

class PaperController extends Controller
{
    public function index(Request $request)
    {
        $query = Paper::query();

        // 1. Pencarian Keyword (Judul / Author / Abstrak)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('authors', 'like', "%{$search}%")
                  ->orWhere('abstract', 'like', "%{$search}%");
            });
        }

        // 2. Filter Berdasarkan Tahun
        if ($request->filled('year')) {
            $query->where('publication_year', $request->year);
        }

        // 3. Filter Berdasarkan Tipe (Clinical Trial, In Vitro, dll)
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // 4. Sorting / Pengurutan (Default: Terbaru)
        $sortBy = $request->get('sort', 'newest');
        if ($sortBy === 'most_cited') {
            $query->orderBy('citations', 'desc');
        } elseif ($sortBy === 'most_viewed') {
            $query->orderBy('views', 'desc');
        } else {
            $query->orderBy('created_at', 'desc'); // Newest
        }

        // 5. Paginate 10 data per halaman
        $papers = $query->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $papers
        ]);
    }

    // Endpoint khusus sidebar "Most Cited This Month"
    public function mostCited()
    {
        $topPapers = Paper::orderBy('citations', 'desc')->take(3)->get();

        return response()->json([
            'status' => 'success',
            'data' => $topPapers
        ]);
    }

    public function download($id)
    {
        $paper = Paper::findOrFail($id);

        if ($paper->pdf_url) {
            return redirect($paper->pdf_url);
        }

        // Generate a simulated file since we don't have real PDFs in the seeder
        $content = "NUSANTARA BIOHUB - MAKALAH RISET\n";
        $content .= "====================================\n\n";
        $content .= "Judul: " . $paper->title . "\n";
        $content .= "Penulis: " . $paper->authors . "\n";
        $content .= "Jurnal: " . $paper->journal_name . " (" . $paper->publication_year . ")\n";
        $content .= "Tipe: " . $paper->type . " | Kategori: " . $paper->category . "\n\n";
        $content .= "Abstrak:\n" . $paper->abstract . "\n\n";
        $content .= "====================================\n";
        $content .= "Ini adalah makalah unduhan yang disimulasikan untuk tujuan demonstrasi.\n";

        $filename = \Illuminate\Support\Str::slug($paper->title) . '.txt';

        return response($content)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
}