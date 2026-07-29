<?php

namespace App\Http\Controllers;

use App\Models\Contribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContributionController extends Controller
{
    // READ: Tampilkan Daftar Usulan Komunitas (Filtered & Paginated)
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

    // READ DETAIL: Tampilkan Detail Usulan
    public function show($id)
    {
        $contribution = Contribution::with(['author:id,name,email', 'reviewer:id,name'])->findOrFail($id);
        return response()->json(['data' => $contribution], 200);
    }

    // CREATE: User Publik Memasukkan Usulan Data Baru
    public function submitContribution(Request $request)
    {
        $validated = $request->validate([
            'category'    => 'required|in:fauna,herbal',
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
            'latitude'    => 'nullable|numeric',
            'longitude'   => 'nullable|numeric',
            'photo'       => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ], [
            'category.required' => 'Kategori usulan wajib dipilih.',
            'category.in'       => 'Kategori harus fauna atau herbal.',
            'title.required'    => 'Judul usulan wajib diisi.',
            'description.required' => 'Deskripsi usulan wajib diisi.',
            'photo.required'    => 'Foto bukti pendukung wajib diunggah.',
            'photo.image'       => 'File foto harus berupa gambar.',
            'photo.max'         => 'Ukuran foto maksimal 2MB.'
        ]);

        $userId = Auth::id();
        if (!$userId) {
            return response()->json([
                'message' => 'Anda harus masuk terlebih dahulu untuk mengirimkan usulan.'
            ], 401);
        }

        $validated['user_id'] = $userId;
        $validated['status']  = 'pending';

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('contributions', 'public');
            $validated['photo_url'] = '/storage/' . $path;
        }

        unset($validated['photo']);

        $contribution = Contribution::create($validated);
        return response()->json([
            'message' => 'Usulan Anda berhasil dikirim dan menunggu verifikasi Admin.',
            'data'    => $contribution
        ], 201);
    }

    // UPDATE: Moderasi Admin (Approve / Reject)
    public function moderateContribution(Request $request, $id)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected'
        ], [
            'status.required' => 'Status moderasi wajib dipilih.',
            'status.in'       => 'Status harus approved atau rejected.'
        ]);

        $contribution = Contribution::findOrFail($id);
        $contribution->status = $validated['status'];
        $contribution->reviewed_by = Auth::id();
        $contribution->save();

        return response()->json([
            'message' => 'Status usulan berhasil diperbarui menjadi ' . $validated['status'],
            'data'    => $contribution->load('reviewer:id,name')
        ], 200);
    }
}
