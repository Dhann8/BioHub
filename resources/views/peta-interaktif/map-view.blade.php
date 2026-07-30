  <main class="flex pt-16 h-screen box-border">
    <!-- SIDEBAR FILTER (Left) -->
    <aside class="sidebar w-[320px] bg-white border-r border-gray-200 flex flex-col z-40 hidden lg:flex">
      <div class="p-6 overflow-y-auto custom-scrollbar flex-1">
        <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-6">Filter Pencarian</h2>
        
        <!-- Category -->
        <div class="mb-8">
          <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-3">Kategori Hayati</label>
          <div class="flex flex-col gap-2">
            <label class="flex items-center justify-between p-3 rounded-xl border border-[#2E7D32] bg-[#E8F5E9]/50 cursor-pointer group">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-[#2E7D32] text-white flex items-center justify-center">
                  <i class="fa-solid fa-paw text-xs"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Fauna Endemik</span>
              </div>
              <input type="checkbox" checked class="filter-cat w-4 h-4 rounded text-[#2E7D32] focus:ring-[#2E7D32]" value="fauna">
            </label>
            <label class="flex items-center justify-between p-3 rounded-xl border border-gray-100 bg-gray-50 hover:border-[#2E7D32] transition cursor-pointer group">
              <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-gray-200 text-gray-500 group-hover:bg-[#2E7D32] group-hover:text-white transition flex items-center justify-center">
                  <i class="fa-solid fa-tree text-xs"></i>
                </div>
                <span class="text-sm font-semibold text-gray-700">Flora Dilindungi</span>
              </div>
              <input type="checkbox" class="filter-cat w-4 h-4 rounded text-[#2E7D32] focus:ring-[#2E7D32]" value="flora">
            </label>
          </div>
        </div>

        <!-- Status IUCN -->
        <div class="mb-8">
          <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-3">Status Konservasi (IUCN)</label>
          <div class="space-y-2">
            <label class="flex items-center gap-3 cursor-pointer group">
              <input type="checkbox" class="filter-status w-4 h-4 rounded text-[#B71C1C] focus:ring-[#B71C1C]" value="cr">
              <span class="text-sm text-gray-600 group-hover:text-gray-900 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-status-cr"></span> Kritis (CR)
              </span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer group">
              <input type="checkbox" class="filter-status w-4 h-4 rounded text-[#D97706] focus:ring-[#D97706]" value="en">
              <span class="text-sm text-gray-600 group-hover:text-gray-900 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-status-en"></span> Terancam (EN)
              </span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer group">
              <input type="checkbox" class="filter-status w-4 h-4 rounded text-[#F57F17] focus:ring-[#F57F17]" value="vu">
              <span class="text-sm text-gray-600 group-hover:text-gray-900 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-status-vu"></span> Rentan (VU)
              </span>
            </label>
            <label class="flex items-center gap-3 cursor-pointer group">
              <input type="checkbox" class="filter-status w-4 h-4 rounded text-[#1B5E20] focus:ring-[#1B5E20]" value="lc">
              <span class="text-sm text-gray-600 group-hover:text-gray-900 flex items-center gap-2">
                <span class="w-2.5 h-2.5 rounded-full bg-status-lc"></span> Risiko Rendah (LC)
              </span>
            </label>
          </div>
        </div>

        <!-- Region -->
        <div class="mb-8">
          <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-3">Wilayah / Pulau</label>
          <select id="filter-region" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:ring-[#2E7D32] focus:border-[#2E7D32] outline-none">
            <option>Semua Wilayah</option>
            <option>Sumatra</option>
            <option>Jawa</option>
            <option>Kalimantan</option>
            <option>Sulawesi</option>
            <option>Papua</option>
            <option>Nusa Tenggara & Bali</option>
          </select>
        </div>

        <!-- Search Field -->
        <div class="mb-8">
          <label class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-3">Pencarian Lanjut</label>
          <div class="relative">
            <input id="filter-search" type="text" placeholder="Nama latin, habitat..." class="w-full bg-gray-50 border border-gray-200 rounded-xl p-3 text-sm focus:ring-[#2E7D32] focus:border-[#2E7D32] outline-none">
            <i class="fa-solid fa-sliders absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
          </div>
        </div>
      </div>

      <!-- Sidebar Footer -->
      <div class="p-6 border-t border-gray-100 bg-gray-50">
        <button id="apply-filter" class="w-full bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-bold py-3 rounded-xl transition flex items-center justify-center gap-2">
          Terapkan Filter
        </button>
        <button id="reset-filter" class="w-full text-gray-400 text-xs font-semibold py-3 hover:text-gray-600 transition">
          Reset Semua
        </button>
      </div>
    </aside>

    <!-- MAIN MAP AREA -->
    <section class="map-container flex-1 relative bg-blue-50">
      <!-- Simulated GIS Map -->
      <img class="w-full h-full object-cover grayscale-[0.2] brightness-[0.95]" src="https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_f128124791_88b0e2299cb95326.png" alt="detailed topographic and satellite map of Indonesia archipelago with bathymetry, soft green and blue" />
      
      <!-- Overlay: Map UI Elements -->
      <div class="absolute inset-0 pointer-events-none">
        
        <!-- Pins (Dynamic) -->
        @foreach($faunas as $index => $fauna)
          @php
            $top = 30 + ($index * 10) % 40;
            $left = 20 + ($index * 15) % 65;
            $assignedRegion = "Semua Wilayah";
            
            if (str_contains(strtolower($fauna->local_name), 'sumatra')) {
                $top = rand(35, 45); $left = rand(20, 30); $assignedRegion = "Sumatra";
            } elseif (str_contains(strtolower($fauna->local_name), 'komodo')) {
                $top = 65; $left = 55; $assignedRegion = "Nusa Tenggara & Bali";
            } elseif (str_contains(strtolower($fauna->local_name), 'cendrawasih')) {
                $top = 40; $left = 85; $assignedRegion = "Papua";
            }
          @endphp
          <div class="absolute pointer-events-auto map-pin-container" 
               style="top: {{ $top }}%; left: {{ $left }}%;"
               data-id="fauna_{{ $fauna->id }}"
               data-name="{{ strtolower($fauna->local_name) }}"
               data-status="{{ strtolower($fauna->iucn_status) }}"
               data-category="fauna"
               data-region="{{ $assignedRegion }}"
               onclick="openDrawer('fauna_{{ $fauna->id }}')">
            <div class="map-pin w-10 h-10 flex items-center justify-center bg-white rounded-full border-2 border-status-{{ strtolower($fauna->iucn_status) }}">
              <img class="w-8 h-8 rounded-full object-cover" src="{{ $fauna->image_url ?: 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_3a21343fd1_225b4e4a886799f4.png' }}" alt="{{ $fauna->local_name }}" />
              <span class="absolute -top-1 -right-1 w-3 h-3 bg-status-{{ strtolower($fauna->iucn_status) }} rounded-full border-2 border-white"></span>
            </div>
          </div>
        @endforeach

        @foreach($herbals as $index => $herbal)
          @php
            $top = 45 + ($index * 8) % 30;
            $left = 40 + ($index * 20) % 40;
            $assignedRegion = "Semua Wilayah";
            if (str_contains(strtolower($herbal->local_name), 'papua')) $assignedRegion = "Papua";
            if (str_contains(strtolower($herbal->local_name), 'jawa')) $assignedRegion = "Jawa";
          @endphp
          <div class="absolute pointer-events-auto map-pin-container hidden" 
               style="top: {{ $top }}%; left: {{ $left }}%;"
               data-id="flora_{{ $herbal->id }}"
               data-name="{{ strtolower($herbal->local_name) }}"
               data-status="lc"
               data-category="flora"
               data-region="{{ $assignedRegion }}"
               onclick="openDrawer('flora_{{ $herbal->id }}')">
            <div class="map-pin w-10 h-10 flex items-center justify-center bg-white rounded-full border-2 border-status-lc">
              <img class="w-8 h-8 rounded-full object-cover" src="{{ $herbal->image_url ?: 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_7ae549a4c2_576d1ef06a77f38a.png' }}" alt="{{ $herbal->local_name }}" />
              <span class="absolute -top-1 -right-1 w-3 h-3 bg-status-lc rounded-full border-2 border-white"></span>
            </div>
          </div>
        @endforeach

        <!-- Map Controls -->
        <div class="absolute bottom-8 left-8 flex flex-col gap-2 pointer-events-auto">
          <div class="bg-white rounded-xl shadow-lg border border-gray-100 flex flex-col overflow-hidden">
            <button class="p-3 hover:bg-gray-50 border-b border-gray-100 text-gray-600 transition"><i class="fa-solid fa-plus"></i></button>
            <button class="p-3 hover:bg-gray-50 text-gray-600 transition"><i class="fa-solid fa-minus"></i></button>
          </div>
          <button class="bg-white p-3 rounded-xl shadow-lg border border-gray-100 text-gray-600 hover:bg-gray-50 transition">
            <i class="fa-solid fa-location-crosshairs"></i>
          </button>
        </div>

        <div class="absolute bottom-8 right-8 pointer-events-auto flex items-center gap-3">
          <div class="bg-white/90 backdrop-blur-md rounded-2xl shadow-lg border border-gray-200 px-4 py-2.5 flex items-center gap-6">
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-status-cr"></span>
              <span class="text-[10px] font-bold text-gray-600 uppercase">Kritis</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-status-en"></span>
              <span class="text-[10px] font-bold text-gray-600 uppercase">Terancam</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="w-2.5 h-2.5 rounded-full bg-status-vu"></span>
              <span class="text-[10px] font-bold text-gray-600 uppercase">Rentan</span>
            </div>
          </div>
          <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-1 flex">
            <button class="p-2.5 rounded-lg bg-[#2E7D32] text-white transition"><i class="fa-solid fa-layer-group"></i></button>
            <button class="p-2.5 rounded-lg text-gray-500 hover:bg-gray-50 transition"><i class="fa-solid fa-satellite"></i></button>
          </div>
        </div>
      </div>

      <!-- SPECIES QUICK VIEW DRAWER (Right) -->
      <div id="species-drawer" class="absolute top-0 right-0 h-full w-[400px] bg-white shadow-2xl z-50 drawer-transition drawer-closed">
        <!-- Close Button -->
        <button onclick="closeDrawer()" class="absolute top-4 left-[-48px] w-12 h-12 bg-white rounded-l-xl shadow-lg border-y border-l border-gray-200 flex items-center justify-center text-gray-400 hover:text-gray-600">
          <i class="fa-solid fa-chevron-right"></i>
        </button>

        <div class="h-full flex flex-col overflow-y-auto custom-scrollbar">
          <!-- Image Header -->
          <div class="h-[260px] relative">
            <img id="drawer-img" class="w-full h-full object-cover" src="https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_f191a65feb_5f140a97c0a105c1.png" alt="Sumatran orangutan Pongo abelii close-up portrait" />
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
            <div class="absolute bottom-5 left-6 right-6">
              <span id="drawer-cat" class="text-[10px] font-bold text-amber-accent uppercase tracking-widest mb-1 block">Fauna Â· Primata</span>
              <h3 id="drawer-name" class="text-2xl font-black text-white leading-tight">Orangutan Sumatra</h3>
              <p id="drawer-latin" class="text-sm italic text-gray-300">Pongo abelii</p>
            </div>
          </div>

          <!-- Content -->
          <div class="p-8">
            <!-- Badges -->
            <div class="flex flex-wrap gap-2 mb-8">
              <span id="drawer-status" class="bg-status-cr text-white text-[10px] font-black px-3 py-1.5 rounded-lg shadow-sm flex items-center gap-1.5 uppercase">
                <i class="fa-solid fa-triangle-exclamation"></i> Kritis (CR)
              </span>
              <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1.5 uppercase">
                <i class="fa-solid fa-earth-asia"></i> Endemik
              </span>
              <span class="bg-gray-100 text-gray-600 text-[10px] font-bold px-3 py-1.5 rounded-lg flex items-center gap-1.5 uppercase">
                <i class="fa-solid fa-shield-halved"></i> Dilindungi
              </span>
            </div>

            <!-- Description -->
            <div class="mb-8">
              <h4 class="text-xs font-black text-gray-400 uppercase tracking-widest mb-3">Habitat & Distribusi</h4>
              <p id="drawer-desc" class="text-sm text-gray-600 leading-relaxed">
                Hanya ditemukan di bagian utara pulau Sumatra, Indonesia. Mereka mendiami hutan hujan dataran rendah dan hutan rawa gambut. Saat ini mereka terancam punah karena hilangnya habitat secara masif.
              </p>
            </div>

            <!-- Distribution Stats -->
            <div class="grid grid-cols-2 gap-4 mb-8">
              <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Populasi</p>
                <p class="text-sm font-black text-gray-800">~14.613</p>
              </div>
              <div class="p-4 bg-gray-50 rounded-2xl border border-gray-100">
                <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Tren</p>
                <p class="text-sm font-black text-red-600 flex items-center gap-1">
                  <i class="fa-solid fa-arrow-trend-down"></i> Menurun
                </p>
              </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col gap-3">
              <a id="drawer-detail-btn" href="{{ route('detail-spesies') }}" class="w-full bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-green-900/10 flex items-center justify-center gap-2">
                Lihat Profil Lengkap <i class="fa-solid fa-arrow-right"></i>
              </a>
              <button class="w-full border-2 border-gray-100 hover:bg-gray-50 text-gray-600 font-bold py-4 rounded-2xl transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Koleksi
              </button>
            </div>
          </div>

          <!-- Bottom Footer Info -->
          <div class="mt-auto p-6 bg-gray-50 border-t border-gray-100 flex items-center gap-4">
            <div class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-[#2E7D32]">
              <i class="fa-solid fa-flask text-sm"></i>
            </div>
            <div>
              <p class="text-[10px] font-bold text-gray-400 uppercase">Kontributor Riset</p>
              <p class="text-xs font-bold text-gray-700">LIPI & World Wildlife Fund</p>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
