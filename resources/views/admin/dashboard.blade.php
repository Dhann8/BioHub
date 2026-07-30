@extends('layout.admin')
@section('content')

    <div class="flex min-h-screen bg-[#F8FAFC]">
        @include('components.admin.sidebar')
        <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
            <!-- TOP HEADER -->
            <header id="header"
                class="bg-white border-b border-gray-200 px-6 py-4 flex items-center gap-4 sticky top-0 z-10 shadow-sm">
                <div class="flex-1">
                    <h1 class="text-lg font-bold text-[#1E4D2B] leading-tight">Dashboard Ringkasan & Moderasi Pakar</h1>
                    <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::now()->isoFormat('D MMMM YYYY') }} · Selamat
                        datang kembali, {{ Auth::user()->name }}</p>
                </div>

                <!-- Search -->
                <div class="relative w-72 hidden md:block">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm"></i>
                    </div>

                    <input type="text" placeholder="Cari data spesies, gejala, atau kontributor..."
                        class="w-full pl-9 pr-4 py-2 text-sm bg-[#F8FAFC] border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 placeholder-gray-400" />
                </div>

                <!-- Notification -->
                <div class="relative cursor-pointer">
                    <div
                        class="w-9 h-9 bg-[#F8FAFC] border border-gray-200 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors">
                        <i class="fa-solid fa-bell text-gray-500 text-sm"></i>
                    </div>
                    <span
                        class="absolute -top-1 -right-1 w-3.5 h-3.5 bg-red-500 rounded-full border-2 border-white flex items-center justify-center">
                        <span class="text-white text-[7px] font-bold">{{ $pendingCount }}</span>
                    </span>
                </div>

                <!-- Add Species -->
                <button onclick="openAddSpeciesModal()"
                    class="flex items-center gap-2 bg-[#1E4D2B] hover:bg-[#163a20] text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors shadow-sm cursor-pointer">
                    <i class="fa-solid fa-plus text-xs"></i> Add New Species
                </button>
            </header>

            <!-- CONTENT BODY -->
            <main class="flex-1 px-6 py-6 space-y-6">

                <!-- KPI CARDS -->
                <section id="kpi-section" class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

                    <!-- Card 1 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-start gap-4">
                        <div class="w-11 h-11 bg-[#1E4D2B]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-paw text-[#1E4D2B] text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Fauna Endemik</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalFauna }} <span
                                    class="text-base font-semibold text-gray-600">Spesies</span></p>
                            <p class="text-xs text-[#1E4D2B] font-medium mt-1 flex items-center gap-1"><i
                                    class="fa-solid fa-arrow-up text-[10px]"></i> Terverifikasi</p>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-start gap-4">
                        <div class="w-11 h-11 bg-emerald-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-leaf text-emerald-600 text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Total Tanaman TOGA</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalHerbal }} <span
                                    class="text-base font-semibold text-gray-600">Spesies</span></p>
                            <p class="text-xs text-emerald-600 font-medium mt-1 flex items-center gap-1"><i
                                    class="fa-solid fa-flask text-[10px]"></i> Formula Herbal</p>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-start gap-4">
                        <div class="w-11 h-11 bg-amber-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-clock text-[#D97706] text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Antrean Moderasi</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $pendingCount }} <span
                                    class="text-base font-semibold text-gray-600">Pengajuan</span></p>
                            <span
                                class="inline-flex items-center gap-1 bg-amber-100 text-[#D97706] text-[10px] font-bold px-2 py-0.5 rounded-full mt-1">
                                <i class="fa-solid fa-triangle-exclamation text-[9px]"></i> Butuh Verifikasi
                            </span>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-start gap-4">
                        <div class="w-11 h-11 bg-blue-100 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fa-solid fa-map-pin text-blue-600 text-lg"></i>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Titik Koordinat GIS</p>
                            <p class="text-2xl font-bold text-gray-900 mt-1">{{ $totalGis }} <span
                                    class="text-base font-semibold text-gray-600">Habitat</span></p>
                            <p class="text-xs text-blue-600 font-medium mt-1 flex items-center gap-1"><i
                                    class="fa-solid fa-earth-asia text-[10px]"></i> Peta Spasial</p>
                        </div>
                    </div>

                </section>

                <!-- MODERATION QUEUE TABLE (Full Width & Scrollable) -->
                <section id="moderation-section" class="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col">
                    <div class="px-5 pt-5 pb-3 border-b border-gray-100 flex items-center justify-between gap-3 flex-wrap">
                        <div>
                            <h2 class="text-sm font-bold text-gray-900">Antrean Usulan Data Komunitas</h2>
                            <p class="text-xs text-gray-400 mt-0.5">{{ $pendingCount }} pengajuan menunggu validasi pakar
                            </p>
                        </div>
                        <!-- Tabs -->
                        <div class="flex items-center bg-[#F8FAFC] rounded-xl border border-gray-200 p-1 gap-1">
                            <button
                                class="tab-btn active text-xs font-semibold px-3 py-1.5 rounded-lg bg-[#1E4D2B] text-white transition-all"
                                data-tab="all">Semua</button>
                            <button
                                class="tab-btn text-xs font-semibold px-3 py-1.5 rounded-lg text-gray-500 hover:text-gray-700 transition-all"
                                data-tab="fauna">Fauna</button>
                            <button
                                class="tab-btn text-xs font-semibold px-3 py-1.5 rounded-lg text-gray-500 hover:text-gray-700 transition-all"
                                data-tab="herbal">Herbal</button>
                        </div>
                    </div>

                    <!-- Table Scroll Container -->
                    <div class="overflow-x-auto overflow-y-auto max-h-[400px] custom-scrollbar">
                        <table class="w-full text-xs">
                            <thead class="sticky top-0 bg-[#F8FAFC] z-10">
                                <tr class="text-gray-500 uppercase tracking-wider border-b border-gray-100">
                                    <th class="text-left px-5 py-3 font-semibold">Tanggal</th>
                                    <th class="text-left px-4 py-3 font-semibold">Kontributor</th>
                                    <th class="text-left px-4 py-3 font-semibold">Kategori</th>
                                    <th class="text-left px-4 py-3 font-semibold">Judul Temuan</th>
                                    <th class="text-left px-4 py-3 font-semibold">Lokasi GIS</th>
                                    <th class="text-left px-4 py-3 font-semibold">Status</th>
                                    <th class="text-right px-5 py-3 font-semibold">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="queue-table-body" class="divide-y divide-gray-50">
                                @forelse($contributions as $item)
                                    <tr class="hover:bg-[#F8FAFC] transition-colors group" data-cat="{{ $item->category }}">
                                        <td class="px-5 py-3.5 text-gray-500 whitespace-nowrap">
                                            {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</td>
                                        <td class="px-4 py-3.5">
                                            <div class="flex items-center gap-2">
                                                <div
                                                    class="w-6 h-6 rounded-full bg-[#1E4D2B] text-white text-[10px] flex items-center justify-center font-bold">
                                                    {{ strtoupper(substr($item->author->name ?? 'U', 0, 1)) }}
                                                </div>
                                                <span
                                                    class="font-medium text-gray-800">{{ $item->author->name ?? 'Pengguna' }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3.5">
                                            @if($item->category === 'fauna')
                                                <span
                                                    class="bg-[#1E4D2B]/10 text-[#1E4D2B] font-semibold px-2 py-0.5 rounded-full capitalize">Fauna</span>
                                            @else
                                                <span
                                                    class="bg-emerald-100 text-emerald-700 font-semibold px-2 py-0.5 rounded-full capitalize">Herbal</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3.5 font-medium text-gray-800 max-w-[140px] truncate"
                                            title="{{ $item->title }}">
                                            {{ $item->title }}
                                        </td>
                                        <td class="px-4 py-3.5 text-gray-500 whitespace-nowrap">
                                            <i class="fa-solid fa-location-dot text-[#D97706] mr-1"></i>
                                            {{ $item->latitude && $item->longitude ? number_format($item->latitude, 2) . ', ' . number_format($item->longitude, 2) : 'Lokasi Terlampir' }}
                                        </td>
                                        <td class="px-4 py-3.5">
                                            @if($item->status === 'pending')
                                                <span
                                                    class="bg-amber-100 text-amber-700 font-semibold text-[10px] px-2 py-0.5 rounded-full capitalize">Pending</span>
                                            @elseif($item->status === 'approved')
                                                <span
                                                    class="bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-2 py-0.5 rounded-full capitalize">Approved</span>
                                            @else
                                                <span
                                                    class="bg-red-100 text-red-700 font-semibold text-[10px] px-2 py-0.5 rounded-full capitalize">Rejected</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3.5 text-right">
                                            <div class="flex items-center justify-end gap-1.5">
                                                <button onclick="approveRow(this)" data-id="{{ $item->id }}"
                                                    class="bg-[#1E4D2B] hover:bg-[#163a20] text-white text-[10px] font-semibold px-2.5 py-1.5 rounded-lg flex items-center gap-1 transition-colors">
                                                    <i class="fa-solid fa-check"></i> Approve
                                                </button>
                                                <button onclick="openReject(this)" data-id="{{ $item->id }}"
                                                    class="bg-red-50 hover:bg-red-100 text-red-600 text-[10px] font-semibold px-2.5 py-1.5 rounded-lg flex items-center gap-1 transition-colors border border-red-100">
                                                    <i class="fa-solid fa-xmark"></i> Reject
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr id="empty-row">
                                        <td colspan="7" class="px-5 py-8 text-center text-gray-400">
                                            <i class="fa-solid fa-inbox text-2xl mb-2 block"></i>
                                            Belum ada usulan data dari komunitas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Footer -->
                    <div class="px-5 py-3 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                        <span id="displayed-count-text">Menampilkan {{ count($contributions) }} pengajuan</span>
                    </div>
                </section>

                @push('scripts')
                    <script src="{{ asset('js/admin/FilterModeration.js') }}"></script>
                @endpush

                <!-- ANALYTICS & LOG ACTIVITY GRID -->
                <section id="analytics-section" class="grid grid-cols-1 xl:grid-cols-2 gap-5">

                    <!-- Widget 1: IUCN Status Distribution -->
                    <div id="iucn-widget" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Status Konservasi IUCN</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Distribusi Red List {{ $totalFauna }} Fauna Endemik
                                </p>
                            </div>
                            <span
                                class="text-xs bg-[#F8FAFC] border border-gray-200 text-gray-500 px-2 py-1 rounded-lg font-medium">{{ date('Y') }}</span>
                        </div>

                        <!-- Legend Bars -->
                        @php
                            $cr = $iucnCounts['CR'] ?? 0;
                            $en = $iucnCounts['EN'] ?? 0;
                            $vu = $iucnCounts['VU'] ?? 0;
                            $nt = $iucnCounts['NT'] ?? 0;
                            $lc = $iucnCounts['LC'] ?? 0;
                            $totalIucn = max(1, $totalFauna);
                        @endphp
                        <div class="space-y-3 mt-4">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-full bg-red-600 flex-shrink-0"></div>
                                    <span class="text-xs text-gray-600 font-medium">CR – Critically Endangered</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 w-24 bg-gray-100 rounded-full h-1.5">
                                        <div class="bg-red-600 h-1.5 rounded-full"
                                            style="width: {{ round(($cr / $totalIucn) * 100) }}%"></div>
                                    </div>
                                    <span
                                        class="text-xs font-bold text-gray-800 w-10 text-right">{{ round(($cr / $totalIucn) * 100) }}%
                                        · {{ $cr }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-full bg-orange-500 flex-shrink-0"></div>
                                    <span class="text-xs text-gray-600 font-medium">EN – Endangered</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 w-24 bg-gray-100 rounded-full h-1.5">
                                        <div class="bg-orange-500 h-1.5 rounded-full"
                                            style="width: {{ round(($en / $totalIucn) * 100) }}%"></div>
                                    </div>
                                    <span
                                        class="text-xs font-bold text-gray-800 w-10 text-right">{{ round(($en / $totalIucn) * 100) }}%
                                        · {{ $en }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-400 flex-shrink-0"></div>
                                    <span class="text-xs text-gray-600 font-medium">VU – Vulnerable</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 w-24 bg-gray-100 rounded-full h-1.5">
                                        <div class="bg-yellow-400 h-1.5 rounded-full"
                                            style="width: {{ round(($vu / $totalIucn) * 100) }}%"></div>
                                    </div>
                                    <span
                                        class="text-xs font-bold text-gray-800 w-10 text-right">{{ round(($vu / $totalIucn) * 100) }}%
                                        · {{ $vu }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-full bg-lime-500 flex-shrink-0"></div>
                                    <span class="text-xs text-gray-600 font-medium">NT – Near Threatened</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 w-24 bg-gray-100 rounded-full h-1.5">
                                        <div class="bg-lime-500 h-1.5 rounded-full"
                                            style="width: {{ round(($nt / $totalIucn) * 100) }}%"></div>
                                    </div>
                                    <span
                                        class="text-xs font-bold text-gray-800 w-10 text-right">{{ round(($nt / $totalIucn) * 100) }}%
                                        · {{ $nt }}</span>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-2.5 h-2.5 rounded-full bg-[#1E4D2B] flex-shrink-0"></div>
                                    <span class="text-xs text-gray-600 font-medium">LC – Least Concern</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 w-24 bg-gray-100 rounded-full h-1.5">
                                        <div class="bg-[#1E4D2B] h-1.5 rounded-full"
                                            style="width: {{ round(($lc / $totalIucn) * 100) }}%"></div>
                                    </div>
                                    <span
                                        class="text-xs font-bold text-gray-800 w-10 text-right">{{ round(($lc / $totalIucn) * 100) }}%
                                        · {{ $lc }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Widget 2: Activity Log -->
                    <div id="activity-widget" class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex-1">
                        <div class="flex items-center justify-between mb-4">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900">Log Aktivitas Terkini</h3>
                                <p class="text-xs text-gray-400 mt-0.5">Update sistem & tindakan moderasi</p>
                            </div>
                        </div>

                        <!-- Timeline -->
                        <div class="space-y-4 relative max-h-[300px] overflow-y-auto custom-scrollbar pr-1">
                            @forelse($recentLogs as $log)
                                <div class="flex items-start gap-3 relative">
                                    <div
                                        class="w-9 h-9 bg-[#1E4D2B]/10 rounded-full flex items-center justify-center flex-shrink-0 z-10">
                                        <i class="fa-solid fa-inbox text-[#1E4D2B] text-xs"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-xs font-semibold text-gray-800">{{ $log->title }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">Oleh {{ $log->author->name ?? 'Pengguna' }}
                                            · {{ ucfirst($log->category) }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">
                                            {{ $log->created_at ? $log->created_at->diffForHumans() : '-' }}</p>
                                    </div>
                                    <span
                                        class="bg-amber-100 text-amber-700 text-[9px] font-bold px-1.5 py-0.5 rounded flex-shrink-0 uppercase">{{ $log->status }}</span>
                                </div>
                            @empty
                                <div class="text-center py-6 text-xs text-gray-400">
                                    Belum ada aktivitas tercatat.
                                </div>
                            @endforelse
                        </div>
                    </div>

                </section>

            </main>
        </div>
    </div>

    <!-- REJECT MODAL -->
    <div id="reject-modal" class="fixed inset-0 bg-black/50 z-50 items-center justify-center p-4 backdrop-blur-sm hidden">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-xmark text-red-500"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-bold text-gray-900">Tolak Pengajuan</h3>
                        <p class="text-xs text-gray-400">Masukkan alasan penolakan</p>
                    </div>
                </div>
                <button onclick="closeReject()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fa-solid fa-times text-lg"></i>
                </button>
            </div>

            <div class="space-y-3">
                <div>
                    <label class="text-xs font-semibold text-gray-700 block mb-1.5">Alasan Penolakan <span
                            class="text-red-500">*</span></label>
                    <select
                        class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-red-200 bg-[#F8FAFC] text-gray-700">
                        <option value="">-- Pilih Alasan --</option>
                        <option>Data duplikat sudah ada di sistem</option>
                        <option>Informasi tidak lengkap atau tidak akurat</option>
                        <option>Lokasi koordinat tidak valid</option>
                        <option>Foto/bukti tidak memadai</option>
                        <option>Di luar cakupan area konservasi</option>
                        <option>Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="text-xs font-semibold text-gray-700 block mb-1.5">Catatan Tambahan</label>
                    <textarea rows="3" placeholder="Jelaskan detail alasan penolakan untuk kontributor..."
                        class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-red-200 bg-[#F8FAFC] resize-none placeholder-gray-400"></textarea>
                </div>
            </div>

            <div class="flex gap-3 mt-5">
                <button onclick="closeReject()"
                    class="flex-1 border border-gray-200 text-gray-600 text-sm font-semibold py-2.5 rounded-xl hover:bg-gray-50 transition-colors">Batal</button>
                <button onclick="confirmReject()"
                    class="flex-1 bg-red-600 hover:bg-red-700 text-white text-sm font-semibold py-2.5 rounded-xl transition-colors flex items-center justify-center gap-2">
                    <i class="fa-solid fa-xmark"></i> Konfirmasi Tolak
                </button>
            </div>
        </div>
    </div>

    @include('components.admin.modal-add-fauna')

@endsection