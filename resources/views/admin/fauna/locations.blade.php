@extends('layout.admin')
@section('content')

<div class="flex min-h-screen bg-[#F8FAFC]">
    @include('components.admin.sidebar')
    
    <div class="flex-1 flex flex-col min-h-screen overflow-x-hidden">
        
        {{-- HEADER HALAMAN LOKASI FAUNA --}}
        <header id="header" class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between gap-4 sticky top-0 z-10">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Fauna Locations</h1>
            </div>
            
            <div class="flex items-center gap-3">
                <button onclick="openAddLocationModal()" class="flex items-center gap-2 bg-[#1E4D2B] hover:bg-[#163a20] text-white text-sm font-semibold px-4 py-2.5 rounded-xl transition-colors shadow-sm cursor-pointer">
                    <i class="fa-solid fa-plus text-xs"></i> Tambah Lokasi GIS
                </button>
            </div>
        </header>

        {{-- KONTEN UTAMA --}}
        <main class="flex-1 px-6 py-6 space-y-6">

            {{-- NOTIFIKASI SUKSES (Tampil setelah aksi berhasil) --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-medium px-4 py-3 rounded-xl flex items-center gap-2 shadow-sm">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-xs px-4 py-3 rounded-xl space-y-1">
                    @foreach($errors->all() as $error)
                        <p>â€¢ {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            {{-- KARTU STATISTIK DATA LOKASI --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" data-aos="fade-down" data-aos-duration="600">
                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Total Titik Lokasi</p>
                        <h3 class="text-2xl font-black text-gray-900 mt-1">{{ $totalLocations }}</h3>
                        <p class="text-[11px] text-emerald-600 font-medium mt-1"><i class="fa-solid fa-location-dot mr-1"></i> Terdaftar di Database</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center font-bold text-xl">
                        <i class="fa-solid fa-map-pin"></i>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Fauna Terpetakan</p>
                        <h3 class="text-2xl font-black text-gray-900 mt-1">{{ $totalMappedFaunas }}</h3>
                        <p class="text-[11px] text-blue-600 font-medium mt-1"><i class="fa-solid fa-paw mr-1"></i> Memiliki Koordinat</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-xl">
                        <i class="fa-solid fa-earth-asia"></i>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-400 font-semibold uppercase tracking-wider">Akses Peta Publik</p>
                        <h3 class="text-sm font-bold text-gray-900 mt-2">Web GIS Interactive</h3>
                        <a href="{{ route('map') }}" target="_blank" class="inline-flex items-center gap-1 text-xs text-[#1E4D2B] font-semibold hover:underline mt-1">
                            Buka Peta GIS <i class="fa-solid fa-[#1E4D2B] fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#1E4D2B] flex items-center justify-center font-bold text-xl">
                        <i class="fa-solid fa-map"></i>
                    </div>
                </div>
            </div>

            {{-- BAR FILTER PENCARIAN --}}
            <form method="GET" action="{{ route('admin.fauna-locations.index') }}" class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex flex-wrap items-center gap-4" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                {{-- Input Pencarian Lokasi --}}
                <div class="relative flex-1 min-w-[240px]">
                    {{-- Ikon Kaca Pembesar --}}
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm"></i>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama wilayah atau fauna..." 
                        class="w-full pl-9 pr-4 py-2 text-sm bg-[#F8FAFC] border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30" />
                </div>

                {{-- Filter Berdasarkan Spesies Fauna --}}
                <div class="min-w-[180px]">
                    <select name="fauna_id" onchange="this.form.submit()" class="w-full text-sm border border-gray-200 rounded-xl px-3 py-2 bg-[#F8FAFC] focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-600 font-medium">
                        <option value="">Semua Fauna</option>
                        @foreach($faunas as $fauna)
                            <option value="{{ $fauna->id }}" {{ request('fauna_id') == $fauna->id ? 'selected' : '' }}>
                                {{ $fauna->local_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit & Reset -->
                <button type="submit" class="bg-[#1E4D2B] text-white text-xs font-semibold px-4 py-2 rounded-xl hover:bg-[#163a20] transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.fauna-locations.index') }}" class="text-xs font-semibold text-gray-500 hover:text-[#1E4D2B] px-2 transition-colors">Reset</a>
            </form>

            {{-- TABEL DATA LOKASI FAUNA --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#F8FAFC] border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                                <th class="px-6 py-4">Spesies Fauna</th>
                                <th class="px-4 py-4">Nama Wilayah / Region</th>
                                <th class="px-4 py-4">Koordinat Spasial</th>
                                <th class="px-4 py-4">Tanggal Input</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            @forelse($locations as $loc)
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <!-- Fauna Info -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-lg overflow-hidden bg-gray-100 flex-shrink-0">
                                                @if($loc->fauna && $loc->fauna->image_url)
                                                    <img class="w-full h-full object-cover" src="{{ $loc->fauna->image_url }}" alt="{{ $loc->fauna->local_name }}" />
                                                @else
                                                    <div class="w-full h-full bg-[#1E4D2B]/10 text-[#1E4D2B] flex items-center justify-center font-bold text-xs">
                                                        {{ strtoupper(substr($loc->fauna->local_name ?? 'F', 0, 2)) }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div>
                                                <p class="font-bold text-gray-900 text-xs">{{ $loc->fauna->local_name ?? 'Fauna Dihapus' }}</p>
                                                <p class="text-[11px] text-gray-400 italic">{{ $loc->fauna->scientific_name ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Region Name -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <span class="text-xs font-semibold text-gray-800 bg-amber-50 text-amber-800 px-2.5 py-1 rounded-lg border border-amber-100 flex items-center gap-1.5 w-fit">
                                            <i class="fa-solid fa-location-dot text-amber-600"></i>
                                            {{ $loc->region_name }}
                                        </span>
                                    </td>

                                    <!-- Coordinates -->
                                    <td class="px-4 py-4 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <span class="text-[11px] font-mono bg-gray-100 text-gray-700 px-2 py-1 rounded border border-gray-200">
                                                Lat: {{ number_format($loc->latitude, 4) }}, Lng: {{ number_format($loc->longitude, 4) }}
                                            </span>
                                            <a href="https://maps.google.com/?q={{ $loc->latitude }},{{ $loc->longitude }}" target="_blank" title="Buka di Google Maps"
                                                class="text-xs text-blue-600 hover:text-blue-800 bg-blue-50 p-1.5 rounded hover:bg-blue-100 transition-colors">
                                                <i class="fa-solid fa-up-right-from-square"></i>
                                            </a>
                                        </div>
                                    </td>

                                    <!-- Date -->
                                    <td class="px-4 py-4 whitespace-nowrap text-xs text-gray-500">
                                        {{ $loc->created_at ? $loc->created_at->format('d M Y, H:i') : '-' }}
                                    </td>

                                    <!-- Action -->
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        <form action="{{ route('admin.fauna-locations.destroy', $loc->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus lokasi ini?');" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" title="Hapus Lokasi" class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-600 hover:text-white transition-all flex items-center justify-center">
                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                        <i class="fa-solid fa-map-location-dot text-3xl mb-2 block text-gray-300"></i>
                                        Belum ada data lokasi GIS fauna yang terdaftar.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Footer -->
                <div class="px-6 py-4 bg-[#F8FAFC] border-t border-gray-100 flex items-center justify-between">
                    <p class="text-xs text-gray-500 font-medium">
                        Menampilkan <span class="text-gray-900">{{ $locations->firstItem() ?? 0 }}-{{ $locations->lastItem() ?? 0 }}</span> dari <span class="text-gray-900">{{ $locations->total() }}</span> entries
                    </p>
                    <div class="flex items-center gap-1">
                        {{ $locations->links() }}
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

{{-- ==================== ADD LOCATION MODAL ==================== --}}
<div id="add-location-modal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 transform scale-95 transition-all duration-300" id="location-modal-container">
        
        <!-- Modal Header -->
        <div class="bg-[#1E4D2B] px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-amber-500 rounded-xl flex items-center justify-center text-white">
                    <i class="fa-solid fa-location-dot text-base"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white leading-tight">Tambah Lokasi GIS Fauna</h3>
                    <p class="text-xs text-white/70">Petakan koordinat habitat spesifik spesies</p>
                </div>
            </div>
            <button onclick="closeAddLocationModal()" type="button" class="text-white/60 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Modal Body (Form) -->
        <form action="{{ route('admin.fauna-locations.store') }}" method="POST" class="p-6 space-y-4">
            @csrf

            <!-- Pilih Fauna -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Spesies Fauna <span class="text-red-500">*</span></label>
                <select name="fauna_id" required class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800">
                    <option value="">-- Pilih Spesies Fauna --</option>
                    @foreach($faunas as $fauna)
                        <option value="{{ $fauna->id }}" {{ old('fauna_id') == $fauna->id ? 'selected' : '' }}>
                            {{ $fauna->local_name }} ({{ $fauna->scientific_name }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Nama Wilayah -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Wilayah / Region <span class="text-red-500">*</span></label>
                <input type="text" name="region_name" required placeholder="Contoh: Taman Nasional Ujung Kulon" value="{{ old('region_name') }}"
                    class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
            </div>

            <!-- 2 Column: Latitude & Longitude -->
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Latitude <span class="text-red-500">*</span></label>
                    <input type="number" step="any" name="latitude" required placeholder="-6.7500" value="{{ old('latitude') }}"
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Longitude <span class="text-red-500">*</span></label>
                    <input type="number" step="any" name="longitude" required placeholder="105.3333" value="{{ old('longitude') }}"
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                </div>
            </div>

            <!-- Form Actions -->
            <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeAddLocationModal()" class="flex-1 py-2.5 border border-gray-200 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" class="flex-1 py-2.5 bg-[#1E4D2B] hover:bg-[#163a20] text-white text-xs font-semibold rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Simpan Lokasi
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddLocationModal() {
        const modal = document.getElementById('add-location-modal');
        const container = document.getElementById('location-modal-container');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        container.classList.remove('scale-95');
        container.classList.add('scale-100');
    }

    function closeAddLocationModal() {
        const modal = document.getElementById('add-location-modal');
        const container = document.getElementById('location-modal-container');
        modal.classList.add('opacity-0', 'pointer-events-none');
        container.classList.remove('scale-100');
        container.classList.add('scale-95');
    }
</script>

@endsection

