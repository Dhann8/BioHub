<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContributionController extends Controller
{
    /**
     * Tampilkan halaman Crowdsourcing Queue (Admin View)
     */
    public function adminIndex(Request $request)
    {
        $tab = $request->get('tab', 'all-pending');
        $selected_id = $request->get('selected');

        $pendingCount   = Contribution::where('status', 'pending')->count();
        $faunaCount     = Contribution::where('status', 'pending')->where('category', 'fauna')->count();
        $herbalCount    = Contribution::where('status', 'pending')->where('category', 'herbal')->count();
        $paperCount     = Contribution::where('status', 'pending')->where('category', 'paper')->count();
        $approvedCount  = Contribution::where('status', 'approved')->count();
        $rejectedCount  = Contribution::where('status', 'rejected')->count();

        $query = Contribution::with(['author:id,name,email', 'reviewer:id,name']);

        switch ($tab) {
            case 'fauna':
                $query->where('status', 'pending')->where('category', 'fauna');
                break;
            case 'herbal':
                $query->where('status', 'pending')->where('category', 'herbal');
                break;
            case 'paper':
                $query->where('status', 'pending')->where('category', 'paper');
                break;
            case 'approved':
                $query->where('status', 'approved');
                break;
            case 'rejected':
                $query->where('status', 'rejected');
                break;
            default: // all-pending
                $query->where('status', 'pending');
                break;
        }

        $search = $request->get('search');
        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $contributions = $query->latest()->get();

        // Selected contribution for detail panel
        $selected = null;
        if ($selected_id) {
            $selected = Contribution::with(['author', 'reviewer'])->find($selected_id);
        } elseif ($contributions->isNotEmpty()) {
            $selected = $contributions->first()->load(['author', 'reviewer']);
        }

        return view('admin.CrowdsourcingQueue.page', compact(
            'contributions', 'selected', 'tab', 'search',
            'pendingCount', 'faunaCount', 'herbalCount', 'paperCount', 'approvedCount', 'rejectedCount'
        ));
    }

    /**
     * API JSON index
     */
    public function index(Request $request)
    {
        $query = Contribution::with(['author:id,name,email', 'reviewer:id,name']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $contributions = $query->latest()->paginate(10);
        return response()->json($contributions, 200);
    }

    public function show($id)
    {
        $contribution = Contribution::with(['author:id,name,email', 'reviewer:id,name'])->findOrFail($id);
        return response()->json(['data' => $contribution], 200);
    }

    public function submitContribution(Request $request)
    {
        $validated = $request->validate([
            'category'    => 'required|in:fauna,herbal,paper',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'photo'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return response()->json(['message' => 'Anda harus masuk terlebih dahulu.'], 401);
        }

        $validated['user_id'] = $userId;
        $validated['status']  = 'pending';

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('contributions', 'public');
            $validated['photo_url'] = '/storage/' . $path;
        }

        unset($validated['photo']);

        $contribution = Contribution::create($validated);
        
        if ($request->wantsJson() || $request->is('api/*')) {
            return response()->json([
                'message' => 'Usulan Anda berhasil dikirim dan menunggu verifikasi Admin.',
                'data'    => $contribution
            ], 201);
        }

        return redirect()->back()->with('success', 'Kontribusi Anda berhasil dikirim dan sedang menunggu verifikasi admin. Terima kasih!');
    }

    public function moderateContribution(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected'
        ]);

        $contribution = Contribution::findOrFail($id);
        $contribution->status      = $validated['status'];
        $contribution->reviewed_by = Auth::id();
        $contribution->save();

        return response()->json([
            'message' => 'Status usulan berhasil diperbarui menjadi ' . $validated['status'],
            'data'    => $contribution->load('reviewer:id,name')
        ], 200);
    }

    public function approveContribution(Request $request, $id)
    {
        $contribution = Contribution::findOrFail($id);
        $contribution->status          = 'approved';
        $contribution->reviewed_by     = Auth::id();
        $contribution->moderator_notes = $request->input('notes');
        $contribution->save();

        if ($contribution->category === 'fauna') {
            $defaultTaxonomy = \App\Models\Taxonomy::first();
            \App\Models\Fauna::create([
                'taxonomy_id'     => $defaultTaxonomy ? $defaultTaxonomy->id : 1,
                'local_name'      => $contribution->title,
                'scientific_name' => $contribution->title,
                'iucn_status'     => 'LC',
                'description'     => $contribution->description,
                'image_url'       => $contribution->photo_url,
                'primary_habitat' => 'Habitat Usulan Komunitas',
            ]);
        } elseif ($contribution->category === 'herbal') {
            \App\Models\Herbal::create([
                'local_name'         => $contribution->title,
                'scientific_name'    => $contribution->title,
                'description'        => $contribution->description,
                'preparation_method' => 'Formula Komunitas',
                'dosage_guide'       => 'Sesuai Petunjuk Pakar',
                'evidence_level'     => 'Empirical',
                'image_url'          => $contribution->photo_url,
            ]);
        } elseif ($contribution->category === 'paper') {
            \App\Models\Paper::create([
                'title'            => $contribution->title,
                'authors'          => $contribution->author->name ?? 'Kontributor',
                'abstract'         => $contribution->description,
                'type'             => 'Riset Komunitas',
                'category'         => 'Umum',
                'publication_year' => date('Y'),
                'journal_name'     => 'Nusantara BioHub Community',
                'compounds'        => [],
                'views'            => 0,
                'citations'        => 0,
            ]);
        }

        return redirect()->route('admin.crowdsourcing.index')
            ->with('success', 'Usulan disetujui & data resmi disimpan ke database!');
    }

    public function rejectContribution(Request $request, $id)
    {
        $contribution = Contribution::findOrFail($id);
        $contribution->status          = 'rejected';
        $contribution->reviewed_by     = Auth::id();
        $contribution->moderator_notes = $request->input('notes');
        $contribution->save();

        return redirect()->route('admin.crowdsourcing.index')
            ->with('success', 'Usulan berhasil ditolak.');
    }
}
