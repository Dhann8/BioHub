@extends('layout.base')
@section('content')

  <main class="pt-24 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

      <div class="lg:col-span-9">

        <div class="mb-8">
          <h1 class="text-3xl font-black text-slate-900 mb-2">Riset Akademik & Literatur</h1>
          <p class="text-slate-500 max-w-2xl">Akses ribuan studi pada keanekaragaman hayati Indonesia, tanaman obat keluarga (TOGA), dan validasi farmakologis yang telah melalui proses *peer-review*.</p>

          <div class="mt-8 bg-white p-2 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row gap-2">
            <div class="flex-1 flex items-center gap-3 px-4 py-2">
              <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
              <input id="searchInput" type="text" placeholder="Cari berdasarkan judul riset, senyawa aktif (mis. Kurkumin), atau penulis..." class="w-full bg-transparent outline-none text-slate-700 text-sm" />
            </div>
            <button id="searchBtn" class="bg-green-primary hover:bg-green-dark text-white px-8 py-3 rounded-xl font-bold text-sm transition">
              Cari Repositori
            </button>
          </div>

          <!-- FILTERS -->
          <div class="flex flex-wrap gap-3 mt-4">
            <select id="filterYear" class="bg-white border border-slate-200 px-4 py-2 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-50 outline-none">
              <option value="">Tahun Publikasi</option>
              <option value="2025">2025</option>
              <option value="2024">2024</option>
              <option value="2023">2023</option>
              <option value="2022">2022</option>
              <option value="2021">2021</option>
            </select>
            <select id="filterType" class="bg-white border border-slate-200 px-4 py-2 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-50 outline-none">
              <option value="">Jenis Jurnal</option>
              <option value="Clinical Trial">Uji Klinis</option>
              <option value="In Vitro">In Vitro</option>
              <option value="Review">Ulasan</option>
            </select>
            <button id="clearFiltersBtn" class="text-xs font-bold text-green-primary hover:underline ml-auto">Hapus Semua Filter</button>
          </div>
        </div>

        <!-- RECENT RESEARCH STATS (Plotly Chart) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
          <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
              <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Tren Publikasi (2018-2024)</h3>
              <span class="text-xs text-green-primary font-bold"><i class="fa-solid fa-arrow-trend-up mr-1"></i>+12% Pertumbuhan</span>
            </div>
            <div id="trendChart" class="h-[200px] w-full"></div>
          </div>
          <div class="bg-green-primary p-6 rounded-2xl text-white flex flex-col justify-between">
            <div>
              <p class="text-green-pale/70 text-xs font-bold uppercase tracking-widest mb-1">Total Terindeks</p>
              <h2 class="text-4xl font-black">42.1k</h2>
              <p class="text-green-pale/80 text-xs mt-2 leading-relaxed">Makalah *peer-reviewed* di 248 jurnal internasional.</p>
            </div>
            <button class="bg-white/15 hover:bg-white/25 border border-white/30 text-white text-xs font-bold py-2 rounded-lg transition mt-4">
              Lihat Indeks Sitasi
            </button>
          </div>
        </div>

        <!-- PAPERS LIST -->
        <div class="space-y-4">
          <div class="flex items-center justify-between mb-2">
            <h2 id="paperCountText" class="font-black text-slate-900">Makalah Riset (0 Hasil)</h2>
            <div class="flex items-center gap-2 text-xs text-slate-500">
              Urutkan berdasarkan:
              <select id="sortSelect" class="bg-transparent font-bold text-slate-800 outline-none cursor-pointer">
                <option value="newest">Terbaru</option>
                <option value="most_cited">Paling Banyak Disitasi</option>
                <option value="most_viewed">Paling Banyak Dilihat</option>
              </select>
            </div>
          </div>

          <div id="papersList" class="space-y-4">
            <!-- Loading indicator or dynamic content will be placed here -->
            <div class="text-center py-8 text-slate-500">Memuat makalah...</div>
          </div>

          <!-- Pagination -->
          <div id="paginationContainer" class="flex items-center justify-center gap-2 mt-8">
            <!-- Dynamic pagination will be placed here -->
          </div>
        </div>
      </div>

      <!-- SIDEBAR -->
      <div class="lg:col-span-3 space-y-6">

        <!-- MOST CITED -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
          <div class="bg-slate-50 px-5 py-4 border-b border-slate-200">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider flex items-center gap-2">
              <i class="fa-solid fa-ranking-star text-amber-accent"></i> Paling Banyak Disitasi Bulan Ini
            </h3>
          </div>
          <div id="mostCitedList" class="p-5 space-y-4">
            <div class="text-center py-4 text-slate-500 text-xs">Memuat...</div>
          </div>
          <button class="w-full py-3 text-xs font-bold text-slate-500 hover:text-green-primary hover:bg-slate-50 transition border-t border-slate-100">Lihat Papan Peringkat</button>
        </div>

        <!-- LATEST SCIENTIFIC DISCOVERIES -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
          <div class="bg-slate-50 px-5 py-4 border-b border-slate-200">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider flex items-center gap-2">
              <i class="fa-solid fa-microscope text-green-primary"></i> Penemuan di Indonesia
            </h3>
          </div>
          <div class="p-4 space-y-4">
            <div class="relative rounded-xl overflow-hidden h-32 group">
              <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_fa75d00656_d270862a86c9baba.png" alt="rare red ginger subspecies documented in Sumatra rainforest, botanical discovery, professional photo" />
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent p-3 flex flex-col justify-end">
                <p class="text-[10px] font-bold text-amber-accent uppercase tracking-widest mb-0.5">Sumatra</p>
                <p class="text-xs font-bold text-white leading-snug">Subspesies Jahe Merah Baru Didokumentasikan</p>
              </div>
            </div>
            <div class="relative rounded-xl overflow-hidden h-32 group">
              <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_7b1d953c52_614434b97adde7e2.png" alt="indigenous medical plant knowledge mapping Kalimantan, ethnobotany field research, professional phot" />
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent p-3 flex flex-col justify-end">
                <p class="text-[10px] font-bold text-amber-accent uppercase tracking-widest mb-0.5">Kalimantan</p>
                <p class="text-xs font-bold text-white leading-snug">Peta Etnobotani Komunitas Dayak</p>
              </div>
            </div>
          </div>
          <button class="w-full py-3 text-xs font-bold text-slate-500 hover:text-green-primary hover:bg-slate-50 transition border-t border-slate-100">Lihat Blog Riset</button>
        </div>

        <!-- CONTRIBUTOR CTA -->
        <div class="bg-green-primary rounded-2xl p-6 text-white text-center">
          <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
          </div>
          <h4 class="font-bold mb-2">Publikasikan Karya Anda</h4>
          <p class="text-xs text-green-pale/80 leading-relaxed mb-6">Berkontribusi pada database keanekaragaman hayati terbesar di Indonesia dan jangkau ribuan peneliti.</p>
          <button class="w-full bg-white text-green-primary font-bold py-3 rounded-xl text-xs hover:bg-green-pale transition">Kirim Manuskrip</button>
        </div>

      </div>
    </div>
  </main>

  <script src="/js/Riset.js?v={{ time() }}"></script>

@endsection