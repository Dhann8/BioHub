@extends('layout.admin')
@section('content')

  <div class="flex min-h-screen bg-[#F8FAFC]">
    @include('components.admin.sidebar')
    <div class="flex-1 flex flex-col min-h-screen">

      {{-- HEADER HALAMAN HERBAL --}}
      <header id="header"
        class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between gap-4 sticky top-0 z-10">
        <div>
          <h1 class="text-xl font-bold text-gray-800">Herbal Management</h1>
        </div>
        <div class="flex items-center gap-3">
          <div class="relative cursor-pointer">
            <div
              class="w-9 h-9 bg-[#F8FAFC] border border-gray-200 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors">
              <i class="fa-solid fa-bell text-gray-500 text-sm"></i>
            </div>
          </div>
          <button onclick="exportHerbalToExcel()"
            id="btn-export-herbal"
            class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all shadow-sm cursor-pointer active:scale-95">
            <i class="fa-solid fa-file-excel text-xs"></i> Unduh Excel
          </button>
          <button onclick="openAddHerbalModal()"
            class="flex items-center gap-2 bg-[#1E4D2B] hover:bg-[#163a20] text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors shadow-sm cursor-pointer">
            <i class="fa-solid fa-plus text-xs"></i> Add New Herbal
          </button>
        </div>
      </header>

      {{-- BAGIAN KONTEN UTAMA --}}
      <main class="flex-1 px-6 py-6 space-y-6">

        @if(session('success'))
          <div
            class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs px-4 py-3 rounded-xl flex items-center gap-2">
            <i class="fa-solid fa-circle-check text-emerald-600"></i>
            {{ session('success') }}
          </div>
        @endif

        {{-- FITUR PENCARIAN & FILTER --}}
        <section id="filters"
          class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-wrap items-center gap-4">
          <form method="GET" action="{{ route('admin.herbal.index') }}" class="flex flex-wrap items-center gap-4 w-full">
            {{-- Input Cari Tanaman --}}
            <div class="relative flex-1 min-w-[240px]">
              <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
              </div>

              <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama tanaman atau manfaat..."
                class="w-full pl-9 pr-4 py-2 text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all" />
            </div>

            {{-- Filter Tingkat Bukti Klinis --}}
            <div class="min-w-[160px]">
              <select name="evidence_level"
                class="w-full text-xs border border-gray-200 rounded-xl px-3 py-2 bg-[#F8FAFC] focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-600 font-medium">
                <option value="">Tingkat Bukti (All)</option>
                <option value="Empirical" {{ request('evidence_level') === 'Empirical' ? 'selected' : '' }}>Empiris</option>
                <option value="Clinical_Trial" {{ request('evidence_level') === 'Clinical_Trial' ? 'selected' : '' }}>Uji
                  Klinis</option>
              </select>
            </div>

            <button type="submit"
              class="text-xs font-semibold bg-[#1E4D2B] text-white px-4 py-2 rounded-xl hover:bg-[#163a20] transition-colors">Cari</button>
            <a href="{{ route('admin.herbal.index') }}"
              class="text-xs font-semibold text-gray-500 hover:text-[#1E4D2B] px-2 transition-colors">Reset</a>
          </form>
        </section>

        {{-- TABEL DATA HERBAL --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
          <div class="overflow-x-auto">
            <table class="w-full text-left">
              <thead>
                <tr
                  class="bg-[#F8FAFC] border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                  <th class="px-6 py-4">Spesies Herbal</th>
                  <th class="px-4 py-4">Metode Pengolahan</th>
                  <th class="px-4 py-4 text-center">Tingkat Bukti</th>
                  <th class="px-4 py-4">Panduan Dosis</th>
                  <th class="px-6 py-4 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-50 text-sm">
                @forelse($herbals as $herbal)
                  <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                      <div class="flex items-center gap-4">
                        <div
                          class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0 flex items-center justify-center text-emerald-600 font-bold bg-emerald-50">
                          @if($herbal->image_url)
                            <img class="w-full h-full object-cover" src="{{ $herbal->image_url }}"
                              alt="{{ $herbal->local_name }}" />
                          @else
                            <i class="fa-solid fa-seedling text-lg"></i>
                          @endif
                        </div>
                        <div>
                          <p class="font-bold text-gray-900 text-xs">{{ $herbal->local_name }}</p>
                          <p class="text-xs text-gray-500 italic">{{ $herbal->scientific_name }}</p>
                          @if($herbal->plant_family)
                            <p class="text-[10px] text-gray-400">Famili: {{ $herbal->plant_family }}</p>
                          @endif
                        </div>
                      </div>
                    </td>
                    <td class="px-4 py-4 max-w-[200px] truncate text-gray-600 text-xs">
                      {{ $herbal->preparation_method ?? '-' }}
                    </td>
                    <td class="px-4 py-4 text-center">
                      @if($herbal->evidence_level === 'Clinical_Trial')
                        <span class="inline-block bg-blue-100 text-blue-700 font-bold text-[10px] px-2 py-1 rounded-full">Uji
                          Klinis</span>
                      @else
                        <span
                          class="inline-block bg-emerald-100 text-emerald-700 font-bold text-[10px] px-2 py-1 rounded-full">Empiris</span>
                      @endif
                    </td>
                    <td class="px-4 py-4 text-xs text-gray-600 max-w-[180px] truncate">
                      {{ $herbal->dosage_guide ?? '-' }}
                    </td>
                    <td class="px-6 py-4 text-right">
                      <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.herbal-details.index') }}?herbal_id={{ $herbal->id }}" title="View Detail"
                          class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-[#1E4D2B] hover:text-white transition-all flex items-center justify-center">
                          <i class="fa-solid fa-eye text-xs"></i>
                        </a>
                        <button onclick="openEditHerbalModal({{ json_encode($herbal) }})" title="Edit"
                          class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-amber-600 hover:text-white transition-all flex items-center justify-center">
                          <i class="fa-solid fa-pen text-xs"></i>
                        </button>
                        <form action="{{ route('admin.herbal.destroy', $herbal->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus data herbal ini?');">
                          @csrf
                          @method('DELETE')
                          <button type="submit" title="Delete"
                            class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-600 hover:text-white transition-all flex items-center justify-center">
                            <i class="fa-solid fa-trash-can text-xs"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="px-6 py-10 text-center text-gray-400">
                      <i class="fa-solid fa-seedling text-3xl mb-3 block text-gray-200"></i>
                      <p class="text-sm font-medium">Belum ada data tanaman herbal</p>
                      <p class="text-xs mt-1">Klik "Add New Herbal" untuk menambahkan data</p>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          {{-- FOOTER PAGINASI --}}
          <div class="px-6 py-4 bg-[#F8FAFC] border-t border-gray-100 flex items-center justify-between">
            <p class="text-xs text-gray-500 font-medium">Menampilkan {{ $herbals->count() }} entries</p>
            @if($herbals instanceof \Illuminate\Pagination\LengthAwarePaginator)
              <div class="text-xs">{{ $herbals->links() }}</div>
            @endif
          </div>
        </div>

      </main>
    </div>
  </div>

  {{-- ==================== MODAL TAMBAH HERBAL ==================== --}}
  <div id="add-herbal-modal"
    class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div
      class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden border border-gray-100 transform scale-95 transition-all duration-300"
      id="add-herbal-container">

      <div class="bg-[#1E4D2B] px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 bg-[#D97706] rounded-xl flex items-center justify-center text-white">
            <i class="fa-solid fa-seedling text-base"></i>
          </div>
          <div>
            <h3 class="text-base font-bold text-white leading-tight">Tambah Tanaman Herbal Baru</h3>
            <p class="text-xs text-white/70">Masukkan data dasar tanaman TOGA</p>
          </div>
        </div>
        <button onclick="closeAddHerbalModal()" type="button"
          class="text-white/60 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
          <i class="fa-solid fa-xmark text-lg"></i>
        </button>
      </div>

      <form action="{{ route('admin.herbal.store') }}" method="POST" enctype="multipart/form-data"
        class="p-6 space-y-4 max-h-[80vh] overflow-y-auto custom-scrollbar">
        @csrf

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Lokal <span
                class="text-red-500">*</span></label>
            <input type="text" name="local_name" required placeholder="Contoh: Jahe"
              class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 transition-all" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Ilmiah <span
                class="text-red-500">*</span></label>
            <input type="text" name="scientific_name" required placeholder="Contoh: Zingiber officinale"
              class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 transition-all italic" />
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Famili Tumbuhan</label>
            <input type="text" name="plant_family" placeholder="Contoh: Zingiberaceae"
              class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 transition-all" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Tingkat Bukti
              Ilmiah</label>
            <select name="evidence_level"
              class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 transition-all">
              <option value="Empirical">Empiris (Tradisional)</option>
              <option value="Clinical_Trial">Uji Klinis (Teruji)</option>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi <span
              class="text-red-500">*</span></label>
          <textarea name="description" rows="2" required placeholder="Deskripsi singkat tanaman herbal..."
            class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 resize-none transition-all"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Metode Pengolahan <span
                class="text-red-500">*</span></label>
            <textarea name="preparation_method" rows="2" required placeholder="Cara mengolah tanaman..."
              class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 resize-none transition-all"></textarea>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Panduan Dosis <span
                class="text-red-500">*</span></label>
            <textarea name="dosage_guide" rows="2" required placeholder="Takaran & frekuensi konsumsi..."
              class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 resize-none transition-all"></textarea>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Peringatan Keamanan</label>
          <input type="text" name="safety_warning" placeholder="Contoh: Hindari konsumsi berlebih pada ibu hamil"
            class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 transition-all" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Foto Herbal</label>
          <input type="file" name="image" accept="image/*"
            class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-gray-200 rounded-xl bg-[#F8FAFC]" />
        </div>

        <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
          <button type="button" onclick="closeAddHerbalModal()"
            class="flex-1 py-2.5 border border-gray-200 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-50 transition-colors">
            Batal
          </button>
          <button type="submit"
            class="flex-1 py-2.5 bg-[#1E4D2B] hover:bg-[#163a20] text-white text-xs font-semibold rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i> Tambah Herbal
          </button>
        </div>
      </form>
    </div>
  </div>

  {{-- ==================== MODAL EDIT HERBAL ==================== --}}
  <div id="edit-herbal-modal"
    class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div
      class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden border border-gray-100 transform scale-95 transition-all duration-300"
      id="edit-herbal-container">

      <div class="bg-amber-600 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 bg-white text-amber-600 rounded-xl flex items-center justify-center">
            <i class="fa-solid fa-pen text-base"></i>
          </div>
          <div>
            <h3 class="text-base font-bold text-white leading-tight">Edit Tanaman Herbal</h3>
            <p class="text-xs text-white/70">Perbarui data dasar tanaman TOGA</p>
          </div>
        </div>
        <button onclick="closeEditHerbalModal()" type="button"
          class="text-white/60 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
          <i class="fa-solid fa-xmark text-lg"></i>
        </button>
      </div>

      <form id="edit-herbal-form" action="" method="POST" enctype="multipart/form-data"
        class="p-6 space-y-4 max-h-[80vh] overflow-y-auto custom-scrollbar">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Lokal <span
                class="text-red-500">*</span></label>
            <input type="text" name="local_name" id="edit_h_local_name" required
              class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-all" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Ilmiah <span
                class="text-red-500">*</span></label>
            <input type="text" name="scientific_name" id="edit_h_scientific_name" required
              class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-all italic" />
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Famili Tumbuhan</label>
            <input type="text" name="plant_family" id="edit_h_plant_family"
              class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-all" />
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Tingkat Bukti
              Ilmiah</label>
            <select name="evidence_level" id="edit_h_evidence_level"
              class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-all">
              <option value="Empirical">Empiris (Tradisional)</option>
              <option value="Clinical_Trial">Uji Klinis (Teruji)</option>
            </select>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi <span
              class="text-red-500">*</span></label>
          <textarea name="description" id="edit_h_description" rows="2" required
            class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30 resize-none transition-all"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Metode Pengolahan <span
                class="text-red-500">*</span></label>
            <textarea name="preparation_method" id="edit_h_preparation_method" rows="2" required
              class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30 resize-none transition-all"></textarea>
          </div>
          <div>
            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Panduan Dosis <span
                class="text-red-500">*</span></label>
            <textarea name="dosage_guide" id="edit_h_dosage_guide" rows="2" required
              class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30 resize-none transition-all"></textarea>
          </div>
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Peringatan Keamanan</label>
          <input type="text" name="safety_warning" id="edit_h_safety_warning"
            class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-all" />
        </div>

        <div>
          <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Foto Herbal (biarkan kosong
            jika tidak diubah)</label>
          <input type="file" name="image" accept="image/*"
            class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer border border-gray-200 rounded-xl bg-[#F8FAFC]" />
        </div>

        <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
          <button type="button" onclick="closeEditHerbalModal()"
            class="flex-1 py-2.5 border border-gray-200 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-50 transition-colors">
            Batal
          </button>
          <button type="submit"
            class="flex-1 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
            <i class="fa-solid fa-check text-xs"></i> Perbarui Herbal
          </button>
        </div>
      </form>
    </div>
  </div>

  <script>
    function openAddHerbalModal() {
      document.getElementById('add-herbal-modal').classList.remove('opacity-0', 'pointer-events-none');
      document.getElementById('add-herbal-container').classList.replace('scale-95', 'scale-100');
    }
    function closeAddHerbalModal() {
      document.getElementById('add-herbal-modal').classList.add('opacity-0', 'pointer-events-none');
      document.getElementById('add-herbal-container').classList.replace('scale-100', 'scale-95');
    }

    function openEditHerbalModal(herbal) {
      const form = document.getElementById('edit-herbal-form');
      form.action = `{{ url('admin/herbal') }}/${herbal.id}`;
      document.getElementById('edit_h_local_name').value = herbal.local_name;
      document.getElementById('edit_h_scientific_name').value = herbal.scientific_name;
      document.getElementById('edit_h_plant_family').value = herbal.plant_family || '';
      document.getElementById('edit_h_evidence_level').value = herbal.evidence_level || 'Empirical';
      document.getElementById('edit_h_description').value = herbal.description;
      document.getElementById('edit_h_preparation_method').value = herbal.preparation_method || '';
      document.getElementById('edit_h_dosage_guide').value = herbal.dosage_guide || '';
      document.getElementById('edit_h_safety_warning').value = herbal.safety_warning || '';

      document.getElementById('edit-herbal-modal').classList.remove('opacity-0', 'pointer-events-none');
      document.getElementById('edit-herbal-container').classList.replace('scale-95', 'scale-100');
    }
    function closeEditHerbalModal() {
      document.getElementById('edit-herbal-modal').classList.add('opacity-0', 'pointer-events-none');
      document.getElementById('edit-herbal-container').classList.replace('scale-100', 'scale-95');
    }
  </script>

@endsection

@push('scripts')
  {{-- ==================== EXPORT EXCEL SCRIPT ==================== --}}
  <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
  <script>
  function exportHerbalToExcel() {
      const btn = document.getElementById('btn-export-herbal');
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i> Menyiapkan...';
      btn.disabled = true;

      try {
          const rows = document.querySelectorAll('tbody tr');
          const data = [
              ['No', 'Nama Lokal', 'Nama Ilmiah', 'Famili Tumbuhan', 'Metode Pengolahan', 'Tingkat Bukti', 'Panduan Dosis']
          ];

          let no = 1;
          rows.forEach((row) => {
              const cells = row.querySelectorAll('td');
              if (cells.length < 4) return;

              // Ambil semua tag <p> di cell pertama
              const pTags     = cells[0]?.querySelectorAll('p') || [];
              const namaLokal        = pTags[0]?.innerText?.trim() || '';
              const namaIlmiah       = pTags[1]?.innerText?.trim() || '';
              // Famili ada di p ke-3 jika ada (format: "Famili: xxx")
              const familiRaw        = pTags[2]?.innerText?.trim() || '';
              const famili           = familiRaw.replace('Famili: ', '') || '-';

              const metodePengolahan = cells[1]?.innerText?.trim() || '-';
              const tingkatBukti     = cells[2]?.innerText?.trim() || '-';
              const panduanDosis     = cells[3]?.innerText?.trim() || '-';

              if (namaLokal) {
                  data.push([no++, namaLokal, namaIlmiah, famili || '-', metodePengolahan, tingkatBukti, panduanDosis]);
              }
          });

          if (data.length <= 1) {
              alert('Tidak ada data herbal untuk diunduh.');
              return;
          }

          const wb = XLSX.utils.book_new();
          const ws = XLSX.utils.aoa_to_sheet(data);

          ws['!cols'] = [
              { wch: 5 }, { wch: 22 }, { wch: 25 }, { wch: 20 }, { wch: 35 }, { wch: 15 }, { wch: 35 }
          ];

          XLSX.utils.book_append_sheet(wb, ws, 'Daftar Herbal');

          const today = new Date().toISOString().slice(0, 10);
          XLSX.writeFile(wb, `laporan-herbal-${today}.xlsx`);
      } catch (err) {
          console.error(err);
          alert('Gagal mengekspor data. Silakan coba lagi.');
      } finally {
          btn.innerHTML = '<i class="fa-solid fa-file-excel text-xs"></i> Unduh Excel';
          btn.disabled = false;
      }
  }
  </script>
@endpush