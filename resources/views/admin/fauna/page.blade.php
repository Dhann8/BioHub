@extends('layout.admin')
@section('content')

    <div class="flex min-h-screen bg-[#F8FAFC]">
        @include('components.admin.sidebar')
        <div class="flex-1 flex flex-col min-h-screen">

            <!-- TOP HEADER -->
            <header id="header"
                class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between gap-4 sticky top-0 z-10">
                <div>
                    <h1 class="text-xl font-bold text-gray-800">Fauna Management</h1>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative cursor-pointer">
                        <div
                            class="w-9 h-9 bg-[#F8FAFC] border border-gray-200 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors">
                            <i class="fa-solid fa-bell text-gray-500 text-sm"></i>
                        </div>
                    </div>
                    <button onclick="exportFaunaToExcel()"
                        id="btn-export-fauna"
                        class="flex items-center gap-2 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all shadow-sm cursor-pointer active:scale-95">
                        <i class="fa-solid fa-file-excel text-xs"></i> Unduh Excel
                    </button>
                    <button onclick="openAddSpeciesModal()"
                        class="flex items-center gap-2 bg-[#1E4D2B] hover:bg-[#163a20] text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors shadow-sm cursor-pointer">
                        <i class="fa-solid fa-plus text-xs"></i> Add New Species
                    </button>
                </div>
            </header>

            <!-- CONTENT BODY -->
            <main class="flex-1 px-6 py-6 space-y-6">

                <!-- FILTERS BAR -->
                <section id="filters"
                    class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-wrap items-center gap-4">
                    <!-- Search -->
                    <div class="relative flex-1 w-full">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </div>
                        <input type="text" id="filter-search" placeholder="Cari nama lokal atau nama ilmiah..."
                            class="w-full pl-9 pr-4 py-2 text-xs leading-none bg-[#F8FAFC] border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-gray-700 placeholder-gray-400" />
                    </div>

                    <!-- IUCN Filter -->
                    <div class="w-full sm:w-48 shrink-0">
                        <select id="filter-iucn"
                            class="w-full text-xs border border-gray-200 rounded-xl px-3 py-2 bg-[#F8FAFC] focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] text-gray-600 font-medium transition-all cursor-pointer">
                            <option value="">IUCN Status (All)</option>
                            <option value="CR">CR - Critically Endangered</option>
                            <option value="EN">EN - Endangered</option>
                            <option value="VU">VU - Vulnerable</option>
                            <option value="NT">NT - Near Threatened</option>
                            <option value="LC">LC - Least Concern</option>
                        </select>
                    </div>

                    <!-- Taxonomy Filter -->
                    <div class="w-full sm:w-44 shrink-0">
                        <select id="filter-class"
                            class="w-full text-xs border border-gray-200 rounded-xl px-3 py-2 bg-[#F8FAFC] focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] text-gray-600 font-medium transition-all cursor-pointer">
                            <option value="">Taxonomy Class</option>
                            <option value="Mammalia">Mammalia</option>
                            <option value="Aves">Aves</option>
                            <option value="Reptilia">Reptilia</option>
                            <option value="Amphibia">Amphibia</option>
                            <option value="Pisces">Pisces</option>
                        </select>
                    </div>

                    <!-- Reset -->
                    <div class="w-full md:w-auto flex justify-end shrink-0">
                        <button type="button" id="filter-reset"
                            class="text-xs font-semibold text-gray-500 hover:text-[#1E4D2B] px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors whitespace-nowrap">
                            <i class="fa-solid fa-rotate-left mr-1.5 text-[10px]"></i>Reset
                        </button>
                    </div>

                </section>
                @push('scripts')
                    <script src="{{ asset('js/admin/FilterFauna.js') }}"></script>
                @endpush

                <!-- TABLE CARD -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr
                                    class="bg-[#F8FAFC] border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                                    <th class="px-6 py-4">Spesies</th>
                                    <th class="px-4 py-4">Taksonomi</th>
                                    <th class="px-4 py-4 text-center">IUCN Status</th>
                                    <th class="px-4 py-4">Atribut</th>
                                    <th class="px-4 py-4">Fitur Fisik</th>
                                    <th class="px-6 py-4 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50 text-sm">
                                @forelse($faunas as $fauna)
                                    <tr class="fauna-row hover:bg-gray-50/50 transition-colors"
                                        data-name="{{ strtolower($fauna->local_name . ' ' . $fauna->scientific_name) }}"
                                        data-iucn="{{ $fauna->iucn_status }}"
                                        data-class="{{ strtolower($fauna->taxonomy->class_name ?? '') }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center gap-4">
                                                <div class="w-12 h-12 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                                    @if($fauna->image_url)
                                                        <img class="w-full h-full object-cover" src="{{ $fauna->image_url }}" alt="{{ $fauna->local_name }}" />
                                                    @else
                                                        <div class="w-full h-full bg-[#1E4D2B]/10 text-[#1E4D2B] flex items-center justify-center font-bold text-xs">
                                                            {{ strtoupper(substr($fauna->local_name, 0, 2)) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <p class="font-bold text-gray-900">{{ $fauna->local_name }}</p>
                                                    <p class="text-xs text-gray-500 italic">{{ $fauna->scientific_name }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="inline-flex items-center gap-1.5 text-gray-700">
                                                @if(($fauna->taxonomy->class_name ?? '') === 'Aves')
                                                    <i class="fa-solid fa-dove text-[#1E4D2B]"></i>
                                                @elseif(($fauna->taxonomy->class_name ?? '') === 'Reptilia')
                                                    <i class="fa-solid fa-frog text-[#1E4D2B]"></i>
                                                @else
                                                    <i class="fa-solid fa-shield-cat text-[#1E4D2B]"></i>
                                                @endif
                                                {{ $fauna->taxonomy->class_name ?? 'Fauna' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4 text-center">
                                            @php
                                                $iucnClasses = match($fauna->iucn_status) {
                                                    'CR', 'EN' => 'bg-red-100 text-red-600 border-red-200',
                                                    'VU' => 'bg-orange-100 text-orange-600 border-orange-200',
                                                    'NT' => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                                                    default => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                                                };
                                            @endphp
                                            <span class="inline-block {{ $iucnClasses }} font-bold text-[10px] px-2 py-1 rounded shadow-sm border">
                                                {{ $fauna->iucn_status }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4">
                                            <span class="text-xs font-medium px-2 py-1 bg-gray-100 text-gray-600 rounded">
                                                {{ $fauna->size ?? 'Sedang' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-4">
                                            @php
                                                $features = is_array($fauna->physical_features) ? $fauna->physical_features : (json_decode($fauna->physical_features, true) ?? []);
                                            @endphp
                                            <div class="flex flex-wrap gap-1 max-w-[180px]">
                                                @forelse($features as $feat)
                                                    <span class="text-[10px] bg-blue-50 text-blue-600 px-1.5 py-0.5 rounded border border-blue-100 font-medium">
                                                        {{ $feat }}
                                                    </span>
                                                @empty
                                                    <span class="text-[10px] text-gray-400 italic">Endemik</span>
                                                @endforelse
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex items-center justify-end gap-2">
                                                <a href="{{ route('detail-spesies', $fauna->id) }}" target="_blank" title="View Detail"
                                                    class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-[#1E4D2B] hover:text-white transition-all flex items-center justify-center">
                                                    <i class="fa-solid fa-eye text-xs"></i>
                                                </a>
                                                <button onclick="openEditSpeciesModal({{ json_encode($fauna) }})" title="Edit"
                                                    class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-amber-600 hover:text-white transition-all flex items-center justify-center">
                                                    <i class="fa-solid fa-pen text-xs"></i>
                                                </button>
                                                <form action="{{ route('admin.fauna.destroy', $fauna->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
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
                                        <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                            <i class="fa-solid fa-paw text-2xl mb-2 block"></i>
                                            Belum ada data fauna terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Footer -->
                    <div class="px-6 py-4 bg-[#F8FAFC] border-t border-gray-100 flex items-center justify-between">
                        <p class="text-xs text-gray-500 font-medium">
                            Menampilkan <span class="text-gray-900">{{ $faunas->firstItem() ?? 0 }}-{{ $faunas->lastItem() ?? 0 }}</span> dari <span class="text-gray-900">{{ $faunas->total() }}</span> entries
                        </p>
                        <div class="flex items-center gap-1">
                            {{ $faunas->links() }}
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>

@include('components.admin.modal-add-fauna')
@include('components.admin.modal-edit-fauna')

@endsection

@push('scripts')
{{-- ==================== EXPORT EXCEL SCRIPT ==================== --}}
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script>
function exportFaunaToExcel() {
    const btn = document.getElementById('btn-export-fauna');
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin text-xs"></i> Menyiapkan...';
    btn.disabled = true;

    try {
        // Kumpulkan semua baris fauna dari tabel
        const rows = document.querySelectorAll('tbody tr.fauna-row');
        const data = [
            ['No', 'Nama Lokal', 'Nama Ilmiah', 'Kelas Taksonomi', 'IUCN Status', 'Ukuran', 'Fitur Fisik']
        ];

        let no = 1;
        rows.forEach((row) => {
            if (row.style.display === 'none') return;
            const cells = row.querySelectorAll('td');
            // Ambil semua <p> dari cell pertama
            const pTags    = cells[0]?.querySelectorAll('p') || [];
            const namaLokal  = pTags[0]?.innerText?.trim() || '';
            const namaIlmiah = pTags[1]?.innerText?.trim() || '';
            const taksonomi  = cells[1]?.innerText?.trim() || '';
            const iucnStatus = cells[2]?.innerText?.trim() || '';
            const ukuran     = cells[3]?.innerText?.trim() || '';
            const fiturFisikEl = cells[4]?.querySelectorAll('span');
            const fiturFisik   = fiturFisikEl ? Array.from(fiturFisikEl).map(s => s.innerText.trim()).filter(Boolean).join(', ') : '';

            if (namaLokal) {
                data.push([no++, namaLokal, namaIlmiah, taksonomi, iucnStatus, ukuran, fiturFisik]);
            }
        });

        if (data.length <= 1) {
            alert('Tidak ada data fauna untuk diunduh.');
            return;
        }

        const wb = XLSX.utils.book_new();
        const ws = XLSX.utils.aoa_to_sheet(data);

        ws['!cols'] = [
            { wch: 5 }, { wch: 22 }, { wch: 25 }, { wch: 18 }, { wch: 14 }, { wch: 10 }, { wch: 35 }
        ];

        XLSX.utils.book_append_sheet(wb, ws, 'Daftar Fauna');

        const today = new Date().toISOString().slice(0, 10);
        XLSX.writeFile(wb, `laporan-fauna-${today}.xlsx`);
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
