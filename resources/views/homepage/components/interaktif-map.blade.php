  <section id="map-preview" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 gap-4">
        <div>
          <div class="inline-flex items-center gap-2 bg-[#E8F5E9] text-[#2E7D32] text-xs font-semibold px-3 py-1.5 rounded-full mb-3">
            <i class="fa-solid fa-map-location-dot"></i> PETA INTERAKTIF
          </div>
          <h2 class="text-3xl md:text-4xl font-black text-gray-900">Peta Hotspot <span class="text-[#2E7D32]">Keanekaragaman Hayati</span></h2>
          <p class="text-gray-500 mt-2 max-w-xl text-sm leading-relaxed">Temukan persebaran spesies endemik dan area konservasi di seluruh penjuru Nusantara.</p>
        </div>
        <a href="peta-interaktif.html" class="inline-flex items-center gap-2 text-sm font-semibold text-[#2E7D32] hover:text-[#1B5E20] border border-[#2E7D32] rounded-xl px-5 py-2.5 transition self-start md:self-auto">
          Buka Peta Penuh <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
      </div>

      <!-- Map Container -->
      <div class="relative bg-[#E8F5E9] rounded-3xl overflow-hidden shadow-lg border border-green-100 h-[420px] md:h-[500px]">
        <img class="w-full h-full object-cover opacity-60" src="{{ asset('image/map.webp') }}" alt="stylized map of Indonesia archipelago islands, top-down view, teal and green colors, cartographic st" />
        <!-- Overlay Grid -->
        <div class="absolute inset-0 flex items-center justify-center">
          <!-- Simulated Map with SVG Pins -->
          <svg viewBox="0 0 900 400" class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
            <!-- Sumatra pin -->
            <g class="map-pin cursor-pointer" style="animation-delay: 0s">
              <circle cx="180" cy="190" r="16" fill="#2E7D32" opacity="0.25"/>
              <circle cx="180" cy="190" r="9" fill="#2E7D32"/>
              <circle cx="180" cy="190" r="4" fill="white"/>
            </g>
            <!-- Java pin -->
            <g class="map-pin cursor-pointer" style="animation-delay: 0.4s">
              <circle cx="350" cy="240" r="20" fill="#D97706" opacity="0.25"/>
              <circle cx="350" cy="240" r="11" fill="#D97706"/>
              <circle cx="350" cy="240" r="5" fill="white"/>
            </g>
            <!-- Kalimantan pin -->
            <g class="map-pin cursor-pointer" style="animation-delay: 0.8s">
              <circle cx="450" cy="160" r="18" fill="#2E7D32" opacity="0.25"/>
              <circle cx="450" cy="160" r="10" fill="#2E7D32"/>
              <circle cx="450" cy="160" r="4" fill="white"/>
            </g>
            <!-- Sulawesi pin -->
            <g class="map-pin cursor-pointer" style="animation-delay: 1.2s">
              <circle cx="600" cy="160" r="16" fill="#B71C1C" opacity="0.25"/>
              <circle cx="600" cy="160" r="9" fill="#B71C1C"/>
              <circle cx="600" cy="160" r="4" fill="white"/>
            </g>
            <!-- Papua pin -->
            <g class="map-pin cursor-pointer" style="animation-delay: 1.6s">
              <circle cx="790" cy="210" r="18" fill="#D97706" opacity="0.25"/>
              <circle cx="790" cy="210" r="10" fill="#D97706"/>
              <circle cx="790" cy="210" r="4" fill="white"/>
            </g>
            <!-- Bali/NTT pin -->
            <g class="map-pin cursor-pointer" style="animation-delay: 2s">
              <circle cx="510" cy="265" r="14" fill="#2E7D32" opacity="0.25"/>
              <circle cx="510" cy="265" r="8" fill="#2E7D32"/>
              <circle cx="510" cy="265" r="3.5" fill="white"/>
            </g>
          </svg>
        </div>

        <!-- Legend -->
        <div class="absolute bottom-5 left-5 bg-white/90 backdrop-blur-sm rounded-xl p-4 shadow text-xs">
          <p class="font-semibold text-gray-700 mb-2">Status IUCN</p>
          <div class="flex flex-col gap-1.5">
            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#B71C1C] inline-block"></span><span class="text-gray-600">Kritis (CR)</span></div>
            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#D97706] inline-block"></span><span class="text-gray-600">Terancam (EN)</span></div>
            <div class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-[#2E7D32] inline-block"></span><span class="text-gray-600">Rentan (VU)</span></div>
          </div>
        </div>

        <!-- Hotspot Info Bubble -->
        <div class="absolute top-5 right-5 bg-white/90 backdrop-blur-sm rounded-xl p-4 shadow text-xs max-w-[180px]">
          <p class="font-semibold text-gray-700 mb-1"><i class="fa-solid fa-fire text-[#D97706] mr-1"></i>Hotspot Aktif</p>
          <p class="text-gray-500">Kalimantan Timur — 120 spesies terancam punah terdeteksi</p>
          <a href="peta-interaktif.html" class="text-[#2E7D32] font-semibold mt-2 inline-block hover:underline">Lihat Detail →</a>
        </div>
      </div>

      <!-- Map Highlights -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-6">
        <div class="bg-[#E8F5E9] rounded-xl p-4 flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg bg-[#2E7D32] flex items-center justify-center shrink-0">
            <i class="fa-solid fa-tree text-white text-sm"></i>
          </div>
          <div>
            <p class="font-bold text-gray-800 text-sm">Kalimantan</p>
            <p class="text-xs text-gray-500">324 spesies endemik</p>
          </div>
        </div>
        <div class="bg-[#FEF3C7] rounded-xl p-4 flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg bg-[#D97706] flex items-center justify-center shrink-0">
            <i class="fa-solid fa-frog text-white text-sm"></i>
          </div>
          <div>
            <p class="font-bold text-gray-800 text-sm">Papua</p>
            <p class="text-xs text-gray-500">512 spesies unik</p>
          </div>
        </div>
        <div class="bg-[#E8F5E9] rounded-xl p-4 flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg bg-[#2E7D32] flex items-center justify-center shrink-0">
            <i class="fa-solid fa-fish text-white text-sm"></i>
          </div>
          <div>
            <p class="font-bold text-gray-800 text-sm">Sulawesi</p>
            <p class="text-xs text-gray-500">198 spesies kritis</p>
          </div>
        </div>
        <div class="bg-[#FEF3C7] rounded-xl p-4 flex items-center gap-3">
          <div class="w-9 h-9 rounded-lg bg-[#D97706] flex items-center justify-center shrink-0">
            <i class="fa-solid fa-seedling text-white text-sm"></i>
          </div>
          <div>
            <p class="font-bold text-gray-800 text-sm">Sumatra</p>
            <p class="text-xs text-gray-500">276 flora dilindungi</p>
          </div>
        </div>
      </div>
    </div>
  </section>