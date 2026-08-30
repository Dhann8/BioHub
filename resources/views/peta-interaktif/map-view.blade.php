<main class="flex pt-16 h-screen box-border relative overflow-hidden">
  <!-- MOBILE FILTER OVERLAY (Backdrop) -->
  <div id="mobile-filter-backdrop" onclick="toggleMobileSidebar(false)"
    class="fixed inset-0 bg-black/50 z-40 hidden transition-opacity"></div>

  <!-- SIDEBAR FILTER (Left) -->
  <aside id="map-sidebar"
    class="sidebar w-[320px] bg-white border-r border-gray-200 flex flex-col z-40 fixed inset-y-0 left-0 pt-16 lg:static lg:pt-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 shadow-xl lg:shadow-none">
    <!-- Sidebar Header (Mobile close button) -->
    <div class="px-6 pt-5 pb-3 flex items-center justify-between border-b border-gray-100 lg:hidden">
      <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
        <i class="fa-solid fa-sliders text-[#2E7D32]"></i> Filter Spasial
      </h2>
      <button onclick="toggleMobileSidebar(false)"
        class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center cursor-pointer">
        <i class="fa-solid fa-xmar k"></i>
      </button>
    </div>

    <div class="p-6 overflow-y-auto custom-scrollbar flex-1 space-y-6">
      <div class="hidden lg:flex items-center justify-between">
        <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest flex items-center gap-2">
          <i class="fa-solid fa-sliders text-[#2E7D32] text-xs"></i> Filter Spasial
        </h2>
        <span id="active-count-badge"
          class="text-[11px] font-bold text-[#2E7D32] bg-[#E8F5E9] px-2.5 py-0.5 rounded-full shadow-sm">
          Memuat Data...
        </span>
      </div>

      <!-- Category -->
      <div>
        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-3">Kategori Hayati</label>
        <div class="flex flex-col gap-2.5">
          <label id="label-cat-fauna"
            class="flex items-center justify-between p-3 rounded-xl border border-[#2E7D32] bg-[#E8F5E9]/60 cursor-pointer group transition-all">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg bg-[#2E7D32] text-white flex items-center justify-center shadow-sm">
                <i class="fa-solid fa-paw text-xs"></i>
              </div>
              <div>
                <span class="text-sm font-bold text-gray-800 block">Fauna Endemik</span>
                <span class="text-[10px] text-gray-500">Satwa khas Indonesia</span>
              </div>
            </div>
            <input type="checkbox" id="filter-cat-fauna" checked
              class="filter-cat w-4 h-4 rounded text-[#2E7D32] focus:ring-[#2E7D32] accent-[#2E7D32]" value="fauna">
          </label>

          <label id="label-cat-flora"
            class="flex items-center justify-between p-3 rounded-xl border border-[#2E7D32] bg-[#E8F5E9]/60 cursor-pointer group transition-all">
            <div class="flex items-center gap-3">
              <div class="w-8 h-8 rounded-lg bg-[#2E7D32] text-white flex items-center justify-center shadow-sm">
                <i class="fa-solid fa-seedling text-xs"></i>
              </div>
              <div>
                <span class="text-sm font-bold text-gray-800 block">Flora & Herbal (TOGA)</span>
                <span class="text-[10px] text-gray-500">Tanaman obat berkhasiat</span>
              </div>
            </div>
            <input type="checkbox" id="filter-cat-flora" checked
              class="filter-cat w-4 h-4 rounded text-[#2E7D32] focus:ring-[#2E7D32] accent-[#2E7D32]" value="flora">
          </label>
        </div>
      </div>

      <!-- Taxonomy Class Filter -->
      <div>
        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-2.5">Kelas Taksonomi</label>
        <div class="flex flex-wrap gap-1.5" id="taxonomy-filter-chips">
          <button type="button" onclick="setTaxonomyFilter('all')" data-tax="all"
            class="tax-chip px-2.5 py-1 rounded-lg text-xs font-bold transition-all bg-[#2E7D32] text-white shadow-sm">
            Semua
          </button>
          <button type="button" onclick="setTaxonomyFilter('Mamalia')" data-tax="Mamalia"
            class="tax-chip px-2.5 py-1 rounded-lg text-xs font-semibold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
            Mamalia
          </button>
          <button type="button" onclick="setTaxonomyFilter('Aves')" data-tax="Aves"
            class="tax-chip px-2.5 py-1 rounded-lg text-xs font-semibold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
            Aves / Burung
          </button>
          <button type="button" onclick="setTaxonomyFilter('Reptilia')" data-tax="Reptilia"
            class="tax-chip px-2.5 py-1 rounded-lg text-xs font-semibold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
            Reptilia
          </button>
          <button type="button" onclick="setTaxonomyFilter('Flora Herbal')" data-tax="Flora Herbal"
            class="tax-chip px-2.5 py-1 rounded-lg text-xs font-semibold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200">
            Herbal (TOGA)
          </button>
        </div>
      </div>

      <!-- Status IUCN -->
      <div>
        <div class="flex items-center justify-between mb-3">
          <label class="text-xs font-bold text-gray-500 uppercase tracking-wider">Status Konservasi (IUCN)</label>
          <button type="button" onclick="toggleAllStatusFilters()"
            class="text-[10px] text-[#2E7D32] font-semibold hover:underline">Pilih Semua</button>
        </div>
        <div class="space-y-2.5">
          <label class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition">
            <div class="flex items-center gap-2.5">
              <span class="w-3 h-3 rounded-full bg-status-cr"></span>
              <span class="text-xs font-semibold text-gray-700">Kritis (CR - Critically Endangered)</span>
            </div>
            <input type="checkbox" checked class="filter-status w-4 h-4 rounded accent-[#B71C1C]" value="cr">
          </label>

          <label class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition">
            <div class="flex items-center gap-2.5">
              <span class="w-3 h-3 rounded-full bg-status-en"></span>
              <span class="text-xs font-semibold text-gray-700">Terancam (EN - Endangered)</span>
            </div>
            <input type="checkbox" checked class="filter-status w-4 h-4 rounded accent-[#E65100]" value="en">
          </label>

          <label class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition">
            <div class="flex items-center gap-2.5">
              <span class="w-3 h-3 rounded-full bg-status-vu"></span>
              <span class="text-xs font-semibold text-gray-700">Rentan (VU - Vulnerable)</span>
            </div>
            <input type="checkbox" checked class="filter-status w-4 h-4 rounded accent-[#F57F17]" value="vu">
          </label>

          <label class="flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 cursor-pointer transition">
            <div class="flex items-center gap-2.5">
              <span class="w-3 h-3 rounded-full bg-status-lc"></span>
              <span class="text-xs font-semibold text-gray-700">Risiko Rendah / Stabil (LC)</span>
            </div>
            <input type="checkbox" checked class="filter-status w-4 h-4 rounded accent-[#1B5E20]" value="lc">
          </label>
        </div>
      </div>

      <!-- Region -->
      <div>
        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-3">Wilayah / Pulau</label>
        <div class="relative">
          <select id="filter-region"
            class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-xs font-semibold text-gray-700 focus:ring-2 focus:ring-[#2E7D32]/30 focus:border-[#2E7D32] outline-none cursor-pointer">
            <option value="Semua Wilayah">Semua Wilayah Indonesia</option>
            <option value="Sumatra">Pulau Sumatra</option>
            <option value="Jawa">Pulau Jawa</option>
            <option value="Kalimantan">Pulau Kalimantan</option>
            <option value="Sulawesi">Pulau Sulawesi</option>
            <option value="Papua">Pulau Papua</option>
            <option value="Nusa Tenggara & Bali">Bali & Nusa Tenggara</option>
            <option value="Maluku">Kepulauan Maluku</option>
          </select>
        </div>
        <p class="text-[10px] text-gray-400 mt-1.5"><i class="fa-solid fa-circle-info mr-1"></i>Peta akan otomatis
          memusatkan ke pulau pilihan</p>
      </div>

      <!-- Search Field -->
      <div>
        <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-3">Pencarian Cepat</label>
        <div class="relative">
          <input id="filter-search" type="text" placeholder="Cari nama lokal, ilmiah, habitat..."
            class="w-full bg-gray-50 border border-gray-200 rounded-xl pl-3.5 pr-9 py-2.5 text-xs text-gray-700 focus:ring-2 focus:ring-[#2E7D32]/30 focus:border-[#2E7D32] outline-none">
          <i
            class="fa-solid fa-magnifying-glass absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none"></i>
        </div>
      </div>
    </div>

    <!-- Sidebar Footer -->
    <div class="p-5 border-t border-gray-100 bg-gray-50/80 flex flex-col gap-2">
      <button id="apply-filter"
        class="w-full bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-bold py-2.5 rounded-xl transition flex items-center justify-center gap-2 text-xs shadow-sm shadow-green-900/10 cursor-pointer">
        <i class="fa-solid fa-check"></i> Terapkan Filter
      </button>
      <button id="reset-filter"
        class="w-full text-gray-500 hover:text-gray-800 text-xs font-semibold py-2 transition text-center cursor-pointer">
        <i class="fa-solid fa-rotate-left mr-1"></i> Reset Semua Filter
      </button>
    </div>
  </aside>

  <!-- MAIN MAP AREA -->
  <section id="map-main-wrapper" class="map-container flex-1 relative bg-[#e5f0f8] overflow-hidden">
    <!-- LEAFLET MAP CONTAINER -->
    <div id="map" class="w-full h-full"></div>

    <!-- Top Center: View Mode Switcher & Active Filter Chips -->
    <div
      class="absolute top-4 left-1/2 -translate-x-1/2 z-30 pointer-events-auto flex flex-col items-center gap-2 max-w-[90vw]">

      <!-- Active Filter Indicator Tags -->
      <div id="active-filter-chips"
        class="hidden flex flex-wrap items-center justify-center gap-1.5 bg-white/90 backdrop-blur-md py-1 px-3 rounded-full border border-gray-200 shadow-sm text-[11px]">
        <span class="text-gray-400 font-semibold text-[10px] mr-1">Filter Aktif:</span>
        <div id="chips-container" class="flex flex-wrap gap-1"></div>
        <button onclick="resetAllFilters()"
          class="text-[#B71C1C] hover:underline font-bold text-[10px] ml-1.5 cursor-pointer">
          Hapus Semua
        </button>
      </div>
    </div>

    <!-- Top Left: Mobile Filter Button -->
    <div class="absolute top-4 left-4 z-30 lg:hidden pointer-events-auto">
      <button onclick="toggleMobileSidebar(true)"
        class="bg-white/95 backdrop-blur-md hover:bg-white text-gray-800 font-bold px-3.5 py-2.5 rounded-xl shadow-lg border border-gray-200 flex items-center gap-2 text-xs transition cursor-pointer">
        <i class="fa-solid fa-sliders text-[#2E7D32]"></i>
        <span>Filter</span>
      </button>
    </div>

    <!-- Top Right: GIS Toolbox (Biogeography, Hotspots, Bookmarks, Fullscreen) -->
    <div class="absolute top-4 right-4 z-30 pointer-events-auto flex items-center gap-2">
      <!-- Bookmark Collection Button -->
      <button id="btn-open-collection" onclick="openCollectionModal()" title="Buka Koleksi Tersimpan"
        class="bg-white/95 backdrop-blur-md hover:bg-white text-gray-700 hover:text-[#2E7D32] font-bold px-3.5 py-2.5 rounded-xl shadow-lg border border-gray-200 flex items-center gap-2 text-xs transition cursor-pointer">
        <i class="fa-solid fa-bookmark text-[#D97706]"></i>
        <span class="hidden sm:inline">Koleksi</span>
        <span id="header-bookmark-badge"
          class="bg-[#E8F5E9] text-[#2E7D32] text-[10px] font-black px-1.5 py-0.5 rounded-full">0</span>
      </button>

      <!-- Biogeography Line Toggle (Garis Wallace & Weber) -->
      <button id="btn-toggle-wallace" onclick="toggleWallaceLine()"
        title="Tampilkan Garis Wallace & Weber (Batas Biogeografi)"
        class="bg-white/95 backdrop-blur-md hover:bg-white text-gray-700 font-semibold px-3 py-2.5 rounded-xl shadow-lg border border-gray-200 flex items-center gap-1.5 text-xs transition cursor-pointer">
        <i class="fa-solid fa-wave-square text-indigo-600"></i>
        <span class="hidden md:inline">Garis Wallace</span>
      </button>

      <!-- Conservation Hotspots Overlay Toggle -->
      <button id="btn-toggle-hotspots" onclick="toggleHotspotsLayer()"
        title="Tampilkan Taman Nasional & Zona Konservasi Utama"
        class="bg-white/95 backdrop-blur-md hover:bg-white text-gray-700 font-semibold px-3 py-2.5 rounded-xl shadow-lg border border-gray-200 flex items-center gap-1.5 text-xs transition cursor-pointer">
        <i class="fa-solid fa-shield-halved text-emerald-600"></i>
        <span class="hidden md:inline">Taman Nasional</span>
      </button>

      <!-- Fullscreen Button -->
      <button id="btn-fullscreen" onclick="toggleMapFullscreen()" title="Layar Penuh"
        class="bg-white/95 backdrop-blur-md hover:bg-white text-gray-700 hover:text-[#2E7D32] p-2.5 rounded-xl shadow-lg border border-gray-200 transition cursor-pointer flex items-center justify-center">
        <i id="fullscreen-icon" class="fa-solid fa-expand text-xs"></i>
      </button>
    </div>

    <!-- Bottom Left: Zoom, Recenter & Coordinates HUD -->
    <div class="absolute bottom-8 left-6 flex flex-col gap-2.5 z-30 pointer-events-auto">
      <div class="bg-white rounded-2xl shadow-xl border border-gray-100 flex flex-col overflow-hidden">
        <button id="btn-zoom-in" onclick="zoomInMap()" title="Perbesar Peta"
          class="p-3.5 hover:bg-gray-50 border-b border-gray-100 text-gray-700 hover:text-[#2E7D32] transition cursor-pointer flex items-center justify-center">
          <i class="fa-solid fa-plus text-sm"></i>
        </button>
        <button id="btn-zoom-out" onclick="zoomOutMap()" title="Perkecil Peta"
          class="p-3.5 hover:bg-gray-50 text-gray-700 hover:text-[#2E7D32] transition cursor-pointer flex items-center justify-center">
          <i class="fa-solid fa-minus text-sm"></i>
        </button>
      </div>

      <button id="btn-recenter" onclick="recenterMap()" title="Pusatkan ke Seluruh Indonesia / Lokasi Saya"
        class="bg-white p-3.5 rounded-2xl shadow-xl border border-gray-100 text-gray-700 hover:text-[#2E7D32] hover:bg-gray-50 transition cursor-pointer flex items-center justify-center">
        <i class="fa-solid fa-location-crosshairs text-sm"></i>
      </button>

      <!-- Coordinates & Zoom HUD (Desktop) -->
      <div id="coord-hud"
        class="hidden md:flex items-center gap-2 bg-white/90 backdrop-blur-md rounded-xl px-3 py-1.5 shadow-md border border-gray-200 text-[10px] font-mono text-gray-600">
        <i class="fa-solid fa-compass text-[#2E7D32]"></i>
        <span id="hud-latlng">Lat: -2.5000 | Lng: 118.0000</span>
        <span class="text-gray-300">|</span>
        <span id="hud-zoom">Zoom: 5x</span>
      </div>
    </div>

    <!-- Bottom Right: Map Legend & Base Layer Switcher -->
    <div
      class="absolute bottom-8 right-6 z-30 pointer-events-auto flex flex-col sm:flex-row items-end sm:items-center gap-3">
      <!-- IUCN Legend with quick-click filters -->
      <div
        class="bg-white/95 backdrop-blur-md rounded-2xl shadow-xl border border-gray-200/80 px-4 py-2.5 flex items-center gap-4 text-[11px]">
        <div class="flex items-center gap-1.5 cursor-pointer hover:opacity-80 transition"
          onclick="quickFilterStatus('cr')" title="Filter hanya Kritis (CR)">
          <span class="w-2.5 h-2.5 rounded-full bg-status-cr"></span>
          <span class="font-bold text-gray-700">CR</span>
        </div>
        <div class="flex items-center gap-1.5 cursor-pointer hover:opacity-80 transition"
          onclick="quickFilterStatus('en')" title="Filter hanya Terancam (EN)">
          <span class="w-2.5 h-2.5 rounded-full bg-status-en"></span>
          <span class="font-bold text-gray-700">EN</span>
        </div>
        <div class="flex items-center gap-1.5 cursor-pointer hover:opacity-80 transition"
          onclick="quickFilterStatus('vu')" title="Filter hanya Rentan (VU)">
          <span class="w-2.5 h-2.5 rounded-full bg-status-vu"></span>
          <span class="font-bold text-gray-700">VU</span>
        </div>
        <div class="flex items-center gap-1.5 cursor-pointer hover:opacity-80 transition"
          onclick="quickFilterStatus('lc')" title="Filter hanya Stabil/Herbal (LC)">
          <span class="w-2.5 h-2.5 rounded-full bg-status-lc"></span>
          <span class="font-bold text-gray-700">LC</span>
        </div>
      </div>

      <!-- Layer Switcher (Streets / Satellite) -->
      <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-1 flex items-center gap-1">
        <button id="btn-layer-streets" onclick="switchBaseLayer('streets')" title="Peta Topografi / Standar (OSM)"
          class="p-2.5 rounded-xl bg-[#2E7D32] text-white transition-all cursor-pointer shadow-sm">
          <i class="fa-solid fa-layer-group text-xs"></i>
        </button>
        <button id="btn-layer-satellite" onclick="switchBaseLayer('satellite')"
          title="Citra Satelit Resolusi Tinggi (Esri World Imagery)"
          class="p-2.5 rounded-xl text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition-all cursor-pointer">
          <i class="fa-solid fa-satellite text-xs"></i>
        </button>
      </div>
    </div>

    <!-- SPECIES QUICK VIEW DRAWER (Right Slide-out Panel) -->
    <div id="species-drawer"
      class="absolute top-0 right-0 h-full w-full sm:w-[420px] bg-white shadow-2xl z-50 drawer-transition drawer-closed flex flex-col border-l border-gray-200">
      <!-- Close Button (Floating on left edge) -->
      <button onclick="closeDrawer()"
        class="hidden sm:flex absolute top-5 left-[-44px] w-11 h-11 bg-white rounded-l-2xl shadow-xl border-y border-l border-gray-200 items-center justify-center text-gray-500 hover:text-gray-900 transition z-10 cursor-pointer">
        <i class="fa-solid fa-chevron-right"></i>
      </button>

      <div class="h-full flex flex-col overflow-y-auto custom-scrollbar">
        <!-- Image Header with gradient overlay -->
        <div class="h-[240px] relative bg-gray-900 flex-shrink-0">
          <img id="drawer-img" class="w-full h-full object-cover"
            src="https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_f191a65feb_5f140a97c0a105c1.png"
            alt="Detail Spesies" />
          <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>

          <!-- Mobile drawer close button inside image -->
          <button onclick="closeDrawer()"
            class="sm:hidden absolute top-4 right-4 w-9 h-9 rounded-full bg-black/60 text-white flex items-center justify-center backdrop-blur-sm cursor-pointer">
            <i class="fa-solid fa-xmark text-sm"></i>
          </button>

          <div class="absolute bottom-4 left-6 right-6">
            <span id="drawer-cat"
              class="text-[10px] font-extrabold text-[#D97706] uppercase tracking-widest mb-1 block">Fauna ·
              Mamalia</span>
            <h3 id="drawer-name" class="text-2xl font-black text-white leading-tight">Orangutan Sumatra</h3>
            <p id="drawer-latin" class="text-xs italic text-gray-300 mt-0.5">Pongo abelii</p>
          </div>
        </div>

        <!-- Content Body -->
        <div class="p-6 flex-1 flex flex-col">
          <!-- Badges -->
          <div class="flex flex-wrap gap-2 mb-6">
            <span id="drawer-status"
              class="bg-status-cr text-white text-[10px] font-black px-3 py-1.5 rounded-xl shadow-sm flex items-center gap-1.5 uppercase">
              <i class="fa-solid fa-triangle-exclamation"></i> Kritis (CR)
            </span>
            <span id="drawer-tag-origin"
              class="bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold px-3 py-1.5 rounded-xl flex items-center gap-1.5 uppercase">
              <i class="fa-solid fa-earth-asia"></i> Endemik Indonesia
            </span>
            <span id="drawer-tag-type"
              class="bg-gray-100 text-gray-700 text-[10px] font-bold px-3 py-1.5 rounded-xl flex items-center gap-1.5 uppercase">
              <i class="fa-solid fa-shield-halved"></i> Dilindungi
            </span>
          </div>

          <!-- Description / Habitat -->
          <div class="mb-6">
            <h4 id="drawer-section-title" class="text-xs font-black text-gray-400 uppercase tracking-widest mb-2">
              Habitat & Sebaran</h4>
            <p id="drawer-desc" class="text-xs text-gray-600 leading-relaxed">
              Deskripsi spesies akan tampil di sini.
            </p>
          </div>

          <!-- Distribution / Characteristic Stats -->
          <div id="drawer-stats-container" class="grid grid-cols-2 gap-3 mb-6">
            <div class="p-3.5 bg-gray-50 rounded-2xl border border-gray-100">
              <p id="drawer-stat1-label" class="text-[10px] font-bold text-gray-400 uppercase mb-0.5">Wilayah</p>
              <p id="drawer-stat1-val" class="text-xs font-black text-gray-800">Sumatra</p>
            </div>
            <div class="p-3.5 bg-gray-50 rounded-2xl border border-gray-100">
              <p id="drawer-stat2-label" class="text-[10px] font-bold text-gray-400 uppercase mb-0.5">Tren Populasi</p>
              <p id="drawer-stat2-val" class="text-xs font-black text-red-600 flex items-center gap-1">
                <i class="fa-solid fa-arrow-trend-down"></i> Menurun
              </p>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="flex flex-col gap-2.5 mt-auto">
            <a id="drawer-detail-btn" href="#"
              class="w-full bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-bold py-3.5 rounded-2xl transition shadow-md shadow-green-900/10 flex items-center justify-center gap-2 text-xs">
              <span>Lihat Profil Lengkap</span>
              <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
            <div class="flex items-center gap-2">
              <button id="drawer-bookmark-btn" onclick="toggleBookmarkCurrent()"
                class="flex-1 border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-3 rounded-2xl transition flex items-center justify-center gap-2 text-xs cursor-pointer">
                <i id="drawer-bookmark-icon" class="fa-regular fa-bookmark"></i>
                <span id="drawer-bookmark-text">Simpan</span>
              </button>
              <button onclick="shareCurrentLocation()" title="Salin Tautan / Bagikan Lokasi Ini"
                class="p-3 border border-gray-200 hover:bg-gray-50 text-gray-700 rounded-2xl transition flex items-center justify-center text-xs cursor-pointer">
                <i class="fa-solid fa-share-nodes"></i>
              </button>
            </div>
          </div>
        </div>

        <!-- Bottom Footer Info -->
        <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center gap-3">
          <div
            class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-[#2E7D32]">
            <i class="fa-solid fa-database text-xs"></i>
          </div>
          <div>
            <p class="text-[9px] font-bold text-gray-400 uppercase">Sumber Basis Data</p>
            <p class="text-[11px] font-bold text-gray-700">Nusantara BioHub GIS & IUCN Red List</p>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- SAVED COLLECTION (KOLEKSI SAYA) MODAL -->
<div id="collection-modal"
  class="fixed inset-0 bg-black/60 backdrop-blur-sm z-60 hidden items-center justify-center p-4">
  <div
    class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl border border-gray-100 flex flex-col max-h-[85vh] overflow-hidden">
    <!-- Modal Header -->
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
      <div class="flex items-center gap-3">
        <div
          class="w-10 h-10 rounded-2xl bg-[#E8F5E9] text-[#2E7D32] flex items-center justify-center text-lg shadow-sm">
          <i class="fa-solid fa-bookmark"></i>
        </div>
        <div>
          <h3 class="text-lg font-black text-gray-900">Koleksi Spesies Tersimpan</h3>
          <p class="text-xs text-gray-500">Daftar flora dan fauna yang telah Anda simpan di perangkat ini.</p>
        </div>
      </div>
      <button onclick="closeCollectionModal()"
        class="w-9 h-9 rounded-xl bg-gray-100 text-gray-500 hover:bg-gray-200 flex items-center justify-center transition cursor-pointer">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </div>

    <!-- Modal Body -->
    <div id="collection-items-container" class="p-6 overflow-y-auto custom-scrollbar flex-1 space-y-3">
      <!-- Dynamic list injected by JS -->
    </div>

    <!-- Modal Footer -->
    <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center justify-between">
      <button onclick="clearAllBookmarks()" class="text-xs font-semibold text-red-600 hover:underline cursor-pointer">
        <i class="fa-solid fa-trash mr-1"></i> Kosongkan Koleksi
      </button>
      <button onclick="closeCollectionModal()"
        class="bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-bold px-5 py-2.5 rounded-xl text-xs transition cursor-pointer">
        Tutup
      </button>
    </div>
  </div>
</div>