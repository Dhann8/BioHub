@extends('layout.admin')
@section('content')

  <div class="flex h-screen bg-[#F8FAFC] text-gray-800 overflow-hidden">
    @include('components.admin.sidebar')

    {{-- BAGIAN UTAMA --}}
    <div class="flex-1 flex flex-col h-screen overflow-hidden">

      {{-- Bagian Header & Navigasi Tab --}}
      <header class="bg-white border-b border-gray-100 pt-5 flex flex-col flex-shrink-0">
        <div class="px-6 flex items-center justify-between mb-4">
          <div>
            <h1 class="text-xl font-bold text-gray-800">Crowdsourcing Queue</h1>
          </div>
        <div class="flex items-center gap-3">
            @if($pendingCount > 0)
              <div
                class="bg-amber-50 text-amber-700 px-3 py-1.5 rounded-xl border border-amber-100 flex items-center gap-2">
                <i class="fa-solid fa-hourglass-half text-xs"></i>
                <span class="text-xs font-bold uppercase tracking-wider">{{ $pendingCount }} Menunggu Validasi</span>
              </div>
            @else
              <div
                class="bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-xl border border-emerald-100 flex items-center gap-2">
                <i class="fa-solid fa-circle-check text-xs"></i>
                <span class="text-xs font-bold uppercase tracking-wider">Semua Sudah Diverifikasi</span>
              </div>
            @endif
            @if(in_array($tab, ['approved', 'rejected']))
              <button onclick="exportHistoryToExcel()"
                id="btn-export-history"
                class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all shadow-sm cursor-pointer active:scale-95">
                <i class="fa-solid fa-file-excel text-xs"></i> Unduh History Excel
              </button>
            @endif
          </div>
        </div>

        {{-- Navigasi Tab Status Usulan --}}
        <div class="px-6 flex items-center gap-6 overflow-x-auto">
          @php
            $tabs = [
              ['key' => 'all-pending', 'label' => 'All Pending', 'count' => $pendingCount, 'color' => 'bg-[#1E4D2B]'],
              ['key' => 'fauna', 'label' => 'Fauna Submissions', 'count' => $faunaCount, 'color' => 'bg-gray-500'],
              ['key' => 'herbal', 'label' => 'Herbal Submissions', 'count' => $herbalCount, 'color' => 'bg-emerald-600'],
              ['key' => 'paper', 'label' => 'Makalah Riset', 'count' => $paperCount, 'color' => 'bg-blue-600'],
              ['key' => 'approved', 'label' => 'Approved History', 'count' => $approvedCount, 'color' => 'bg-blue-600'],
              ['key' => 'rejected', 'label' => 'Rejected History', 'count' => $rejectedCount, 'color' => 'bg-red-600'],
            ];
          @endphp
          @foreach($tabs as $t)
            <a href="{{ route('admin.crowdsourcing.index', ['tab' => $t['key'], 'search' => $search]) }}"
              class="pb-3 border-b-2 whitespace-nowrap text-sm font-medium transition-all
                        {{ $tab === $t['key'] ? 'border-[#1E4D2B] text-[#1E4D2B] font-bold' : 'border-transparent text-gray-400 hover:text-gray-700' }}">
              {{ $t['label'] }}
              @if($t['count'] > 0)
                <span
                  class="ml-1 text-[10px] {{ $tab === $t['key'] ? $t['color'] . ' text-white' : 'bg-gray-200 text-gray-600' }} px-1.5 py-0.5 rounded-full">{{ $t['count'] }}</span>
              @endif
            </a>
          @endforeach
        </div>
      </header>

      {{-- KONTEN UTAMA (TAMPILAN SPLIT KIRI-KANAN) --}}
      <div class="flex-1 flex overflow-hidden">

        {{-- Panel Kiri: Daftar Usulan dari Pengguna (40% Lebar Layar) --}}
        <div class="w-[40%] bg-white border-r border-gray-200 flex flex-col">
          {{-- Fitur Pencarian Usulan --}}
          <form method="GET" action="{{ route('admin.crowdsourcing.index') }}"
            class="p-4 border-b border-gray-100 flex-shrink-0">
            <input type="hidden" name="tab" value="{{ $tab }}">
            <div class="relative">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm"></i>
              </div>

              <input type="text" name="search" value="{{ $search }}" placeholder="Cari judul usulan..."
                class="w-full pl-9 pr-4 py-2 bg-[#F8FAFC] border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30" />
            </div>
          </form>

          {{-- Daftar Item Usulan --}}
          <div class="flex-1 overflow-y-auto scrollbar-thin divide-y divide-gray-50">
            @forelse($contributions as $item)
              @php
                $isActive = $selected && $selected->id === $item->id;
                $isFauna = $item->category === 'fauna';
              @endphp
              <a href="{{ route('admin.crowdsourcing.index', ['tab' => $tab, 'search' => $search, 'selected' => $item->id]) }}"
                class="block p-4 cursor-pointer hover:bg-[#f0f7f2] transition-colors
                          {{ $isActive ? 'bg-[#f0f7f2] border-l-4 border-[#1E4D2B]' : '' }}">
                <div class="flex items-start justify-between mb-1">
                  <span class="text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded
                                 {{ $isFauna ? 'text-[#1E4D2B] bg-[#1E4D2B]/10' : 'text-emerald-700 bg-emerald-100' }}">
                    {{ ucfirst($item->category) }}
                  </span>
                  <span class="text-[10px] text-gray-400">{{ $item->created_at->format('d M Y · H:i') }}</span>
                </div>
                <h3 class="text-sm font-bold text-gray-900 mb-1 truncate">{{ $item->title }}</h3>
                <div class="flex items-center gap-2">
                  <div
                    class="w-5 h-5 rounded-full bg-[#1E4D2B] flex items-center justify-center text-white text-[8px] font-bold flex-shrink-0">
                    {{ strtoupper(substr($item->author->name ?? 'U', 0, 1)) }}
                  </div>
                  <span class="text-xs text-gray-500 font-medium truncate">{{ $item->author->name ?? 'Unknown' }}</span>
                  @if($item->status !== 'pending')
                    <span
                      class="ml-auto text-[10px] font-bold px-1.5 py-0.5 rounded
                                     {{ $item->status === 'approved' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-600' }}">
                      {{ $item->status === 'approved' ? 'Approved' : 'Rejected' }}
                    </span>
                  @endif
                </div>
              </a>
            @empty
              <div class="p-8 text-center text-gray-400">
                <i class="fa-solid fa-inbox text-4xl mb-3 text-gray-200"></i>
                <p class="text-sm font-semibold">Tidak ada usulan</p>
                <p class="text-xs mt-1">Tidak ada data untuk tab ini.</p>
              </div>
            @endforelse
          </div>
        </div>

        {{-- Panel Kanan: Detail & Verifikasi Usulan (60% Lebar Layar) --}}
        <div class="w-[60%] bg-[#F8FAFC] flex flex-col overflow-hidden relative">

          @if($selected)
            {{-- Area Konten Detail --}}
            <div class="flex-1 overflow-y-auto p-6 scrollbar-thin pb-36">
              <div class="max-w-3xl mx-auto space-y-6">

                {{-- Pesan Sukses/Error --}}
                @if(session('success'))
                  <div
                    class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold px-4 py-3 rounded-xl flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    {{ session('success') }}
                  </div>
                @endif

                {{-- Penampil Foto Lampiran --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                  <div class="p-4 border-b border-gray-50 flex items-center justify-between bg-[#F8FAFC]">
                    <span class="text-xs font-bold text-[#1E4D2B] uppercase tracking-wider flex items-center gap-2">
                      <i class="fa-solid fa-camera"></i> Foto Temuan Lapangan
                    </span>
                    <span class="text-[10px] text-gray-400">{{ basename($selected->photo_url ?? 'Tidak ada foto') }}</span>
                  </div>
                  <div class="h-[300px] relative group bg-gray-100">
                    @if($selected->photo_url)
                      <img class="w-full h-full object-cover"
                        src="{{ Str::startsWith($selected->photo_url, '/storage') ? asset($selected->photo_url) : $selected->photo_url }}"
                        alt="{{ $selected->title }}" />
                      <div
                        class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                        <a href="{{ Str::startsWith($selected->photo_url, '/storage') ? asset($selected->photo_url) : $selected->photo_url }}"
                          target="_blank"
                          class="bg-white/90 text-gray-900 px-4 py-2 rounded-xl text-xs font-bold shadow-xl flex items-center gap-2">
                          <i class="fa-solid fa-expand"></i> Lihat Ukuran Penuh
                        </a>
                      </div>
                    @else
                      <div class="w-full h-full flex items-center justify-center text-gray-400">
                        <div class="text-center">
                          <i class="fa-solid fa-image text-5xl text-gray-200 mb-2"></i>
                          <p class="text-xs">Tidak ada foto</p>
                        </div>
                      </div>
                    @endif
                  </div>
                </div>

                {{-- Grid Informasi Metadata (Koordinat & Deskripsi) --}}
                <div class="grid grid-cols-2 gap-6">

                  {{-- Informasi Detail Submisi --}}
                  <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 space-y-4">
                    <h4 class="text-xs font-bold text-gray-900 uppercase tracking-widest border-b border-gray-50 pb-2">
                      Deskripsi Submisi</h4>
                    <div class="space-y-3">
                      <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Judul Temuan</p>
                        <p class="text-sm font-bold text-[#1E4D2B]">{{ $selected->title }}</p>
                      </div>
                      <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Kategori</p>
                        <p class="text-xs font-semibold text-gray-700">
                          <span
                            class="px-2 py-0.5 rounded text-[10px] {{ $selected->category === 'fauna' ? 'bg-[#1E4D2B]/10 text-[#1E4D2B]' : 'bg-emerald-100 text-emerald-700' }}">
                            {{ ucfirst($selected->category) }}
                          </span>
                        </p>
                      </div>
                      <div>
                        <p class="text-[10px] font-bold text-gray-400 uppercase">Deskripsi Kontributor</p>
                        <p class="text-xs text-gray-600 leading-relaxed italic">"{{ $selected->description }}"</p>
                      </div>
                      @if($selected->moderator_notes)
                        <div>
                          <p class="text-[10px] font-bold text-gray-400 uppercase">Catatan Moderator</p>
                          <p class="text-xs text-gray-600 leading-relaxed">{{ $selected->moderator_notes }}</p>
                        </div>
                      @endif
                    </div>
                  </div>

                  {{-- Peta / Titik Koordinat Lokasi --}}
                  <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 space-y-4">
                    <div class="flex items-center justify-between border-b border-gray-50 pb-2">
                      <h4 class="text-xs font-bold text-gray-900 uppercase tracking-widest">Koordinat Geospasial</h4>
                      @if($selected->latitude && $selected->longitude)
                        <span
                          class="text-[10px] font-medium text-blue-600 bg-blue-50 px-2 py-0.5 rounded border border-blue-100">GIS
                          Valid</span>
                      @else
                        <span
                          class="text-[10px] font-medium text-gray-400 bg-gray-50 px-2 py-0.5 rounded border border-gray-100">Tidak
                          Ada</span>
                      @endif
                    </div>
                    @if($selected->latitude && $selected->longitude)
                      <div id="mini-map" class="h-32 bg-gray-100 rounded-xl overflow-hidden relative z-0"></div>
                      <p class="text-[10px] text-gray-500 text-center">
                        <i class="fa-solid fa-location-dot text-red-500 mr-1"></i>
                        {{ $selected->latitude }}, {{ $selected->longitude }}
                      </p>
                      <script>
                        document.addEventListener('DOMContentLoaded', function () {
                          if (typeof L !== 'undefined') {
                            const map = L.map('mini-map', { zoomControl: false, scrollWheelZoom: false })
                              .setView([{{ $selected->latitude }}, {{ $selected->longitude }}], 10);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);
                            L.marker([{{ $selected->latitude }}, {{ $selected->longitude }}]).addTo(map);
                          }
                        });
                      </script>
                    @else
                      <div class="h-32 bg-gray-50 rounded-xl flex items-center justify-center text-gray-400">
                        <div class="text-center">
                          <i class="fa-solid fa-map-marked-alt text-3xl text-gray-200 mb-1"></i>
                          <p class="text-[10px]">Koordinat tidak tersedia</p>
                        </div>
                      </div>
                    @endif
                  </div>
                </div>

                {{-- Profil Singkat Pengirim (Kontributor) --}}
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                  <h4 class="text-xs font-bold text-gray-900 uppercase tracking-widest border-b border-gray-50 pb-2 mb-4">
                    Profil Kontributor</h4>
                  <div class="flex items-center gap-4">
                    <div
                      class="w-12 h-12 rounded-full bg-[#1E4D2B] flex items-center justify-center text-white font-bold text-lg flex-shrink-0">
                      {{ strtoupper(substr($selected->author->name ?? 'U', 0, 1)) }}
                    </div>
                    <div class="flex-1">
                      <p class="text-sm font-bold text-gray-900">{{ $selected->author->name ?? 'Unknown User' }}</p>
                      <p class="text-xs text-gray-500">{{ $selected->author->email ?? '' }}</p>
                      <p class="text-xs text-gray-400 mt-0.5">
                        Bergabung {{ $selected->author ? $selected->author->created_at->format('M Y') : '-' }}
                        @php
                          $contribCount = \App\Models\Contribution::where('user_id', $selected->user_id)->count();
                        @endphp
                        · {{ $contribCount }} Submisi Total
                      </p>
                    </div>
                    <div class="text-right">
                      @if($selected->status === 'pending')
                        <span class="text-[10px] font-bold px-2 py-1 bg-amber-100 text-amber-700 rounded-lg">Menunggu</span>
                      @elseif($selected->status === 'approved')
                        <span class="text-[10px] font-bold px-2 py-1 bg-blue-100 text-blue-700 rounded-lg">Disetujui</span>
                      @else
                        <span class="text-[10px] font-bold px-2 py-1 bg-red-100 text-red-600 rounded-lg">Ditolak</span>
                      @endif
                      @if($selected->reviewer)
                        <p class="text-[10px] text-gray-400 mt-1">oleh {{ $selected->reviewer->name }}</p>
                      @endif
                    </div>
                  </div>
                </div>

              </div>
            </div>

            {{-- BAR AKSI --}}
            @if($selected->status === 'pending')
              <div
                class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] z-30">
                <div class="max-w-4xl mx-auto space-y-3">
                  {{-- Input Catatan Moderasi --}}
                  <div class="relative">
                    <i class="fa-solid fa-comment-dots absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                    <input id="moderator-notes" type="text" placeholder="Masukkan catatan moderasi pakar (opsional)..."
                      class="w-full pl-9 pr-4 py-2.5 bg-[#F8FAFC] border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30" />
                  </div>
                  {{-- Tombol Aksi Moderasi --}}
                  <div class="flex items-center gap-3">
                    <form id="reject-form" action="{{ route('admin.contributions.reject', $selected->id) }}" method="POST"
                      class="flex-1">
                      @csrf
                      <input type="hidden" name="notes" id="reject-notes-input">
                      <button type="submit"
                        onclick="document.getElementById('reject-notes-input').value = document.getElementById('moderator-notes').value"
                        class="w-full bg-red-50 hover:bg-red-100 text-red-600 px-6 py-2.5 rounded-xl text-sm font-bold transition-all border border-red-100 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-xmark"></i> Tolak Usulan
                      </button>
                    </form>

                    <form id="approve-form" action="{{ route('admin.contributions.approve', $selected->id) }}" method="POST"
                      class="flex-1">
                      @csrf
                      <input type="hidden" name="notes" id="approve-notes-input">
                      <button type="submit"
                        onclick="document.getElementById('approve-notes-input').value = document.getElementById('moderator-notes').value"
                        class="w-full bg-[#1E4D2B] hover:bg-[#163a20] text-white px-8 py-2.5 rounded-xl text-sm font-bold transition-all shadow-lg shadow-[#1E4D2B]/20 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-check-double"></i> Setujui & Publish
                      </button>
                    </form>
                  </div>
                </div>
              </div>
            @else
              <div class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-4 z-30">
                <div class="max-w-4xl mx-auto flex items-center justify-center gap-3 text-sm text-gray-500">
                  @if($selected->status === 'approved')
                    <i class="fa-solid fa-circle-check text-blue-500"></i>
                    <span>Usulan ini telah <strong class="text-blue-700">disetujui</strong> dan dipublikasikan ke
                      database.</span>
                  @else
                    <i class="fa-solid fa-circle-xmark text-red-500"></i>
                    <span>Usulan ini telah <strong class="text-red-600">ditolak</strong>.</span>
                  @endif
                </div>
              </div>
            @endif

          @else
            {{-- Tampilan Kosong (Belum ada usulan dipilih) --}}
            <div class="flex-1 flex items-center justify-center text-center text-gray-400">
              <div>
                <i class="fa-solid fa-inbox text-6xl text-gray-200 mb-4"></i>
                <h3 class="font-bold text-gray-600 mb-1">Pilih Usulan</h3>
                <p class="text-xs text-gray-400 max-w-xs">Pilih salah satu usulan di panel kiri untuk melihat detail dan
                  melakukan verifikasi.</p>
              </div>
            </div>
          @endif

        </div>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
@php
$contributionsExport = $contributions->map(function($c) {
    return [
        'id'              => $c->id,
        'title'           => $c->title,
        'category'        => ucfirst($c->category),
        'status'          => ucfirst($c->status),
        'author'          => optional($c->author)->name ?? 'Unknown',
        'reviewer'        => optional($c->reviewer)->name ?? '-',
        'moderator_notes' => $c->moderator_notes ?? '-',
        'submitted_at'    => $c->created_at ? $c->created_at->format('d/m/Y H:i') : '-',
        'reviewed_at'     => $c->updated_at ? $c->updated_at->format('d/m/Y H:i') : '-',
    ];
});
@endphp
<script>
const _contributionsData = @json($contributionsExport);
const _activeTab = @json($tab);
</script>
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script>
function exportHistoryToExcel() {
    const btn = document.getElementById('btn-export-history');
    if (!btn) return;
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i> Menyiapkan...';
    btn.disabled = true;

    try {
        const tabLabel = _activeTab === 'approved' ? 'Approved' : 'Rejected';
        const data = [
            ['No', 'Judul Temuan', 'Kategori', 'Kontributor', 'Status', 'Direview Oleh', 'Catatan Moderator', 'Tanggal Submit', 'Tanggal Review']
        ];

        _contributionsData.forEach((item, index) => {
            data.push([
                index + 1,
                item.title,
                item.category,
                item.author,
                item.status,
                item.reviewer,
                item.moderator_notes,
                item.submitted_at,
                item.reviewed_at,
            ]);
        });

        if (data.length <= 1) {
            alert('Tidak ada data history untuk diunduh.');
            return;
        }

        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(data);

        ws['!cols'] = [
            { wch: 5 }, { wch: 30 }, { wch: 12 }, { wch: 22 }, { wch: 12 },
            { wch: 22 }, { wch: 35 }, { wch: 18 }, { wch: 18 }
        ];

        XLSX.utils.book_append_sheet(wb, ws, `${tabLabel} History`);

        const today = new Date().toISOString().slice(0, 10);
        XLSX.writeFile(wb, `laporan-history-${tabLabel.toLowerCase()}-${today}.xlsx`);
    } catch (err) {
        console.error(err);
        alert('Gagal mengekspor data. Silakan coba lagi.');
    } finally {
        btn.innerHTML = '<i class="fa-solid fa-file-excel text-xs"></i> Unduh History Excel';
        btn.disabled = false;
    }
}
</script>
@endpush