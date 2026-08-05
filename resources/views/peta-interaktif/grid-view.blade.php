  <div id="grid-view" class="fixed inset-0 top-16 bg-gray-50 z-30 overflow-y-auto hidden">
    <div class="max-w-7xl mx-auto px-6 py-8">
      <!-- Header -->
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8 bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
        <div>
          <div class="flex items-center gap-2 mb-1">
            <span class="w-2.5 h-2.5 rounded-full bg-[#2E7D32]"></span>
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900">Katalog Spesies Hayati</h2>
          </div>
          <p class="text-gray-500 text-xs sm:text-sm">
            Menampilkan <span id="grid-visible-count" class="font-bold text-[#2E7D32]">0</span> dari <span id="grid-total-count" class="font-bold text-gray-800">0</span> entitas hayati berdasarkan filter aktif.
          </p>
        </div>
        <div class="flex items-center gap-3">
          <button onclick="toggleView('map')" class="bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-bold px-5 py-3 rounded-2xl transition flex items-center gap-2 text-xs shadow-md shadow-green-900/10 cursor-pointer">
            <i class="fa-solid fa-map-location-dot"></i>
            <span>Kembali ke Peta</span>
          </button>
        </div>
      </div>

      <!-- Empty State Container -->
      <div id="grid-empty-state" class="hidden bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm">
        <div class="w-16 h-16 rounded-full bg-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-4 text-2xl">
          <i class="fa-solid fa-filter-circle-xmark"></i>
        </div>
        <h3 class="text-base font-bold text-gray-800 mb-1">Tidak ada spesies yang cocok</h3>
        <p class="text-xs text-gray-500 max-w-md mx-auto mb-6">Coba sesuaikan kata kunci pencarian atau aktifkan pilihan kategori dan status konservasi pada panel filter.</p>
        <button onclick="resetAllFilters()" class="bg-[#2E7D32] text-white font-bold px-5 py-2.5 rounded-xl text-xs hover:bg-[#1B5E20] transition cursor-pointer">
          Reset Filter
        </button>
      </div>

      <!-- Grid Cards -->
      <div id="grid-cards-container" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($faunas as $fauna)
        @php
            $assignedRegion = "Semua Wilayah";
            if ($fauna->locations && $fauna->locations->count() > 0) {
                $locName = strtolower($fauna->locations->first()->region_name);
                if (str_contains($locName, 'sumatra')) $assignedRegion = "Sumatra";
                elseif (str_contains($locName, 'jawa')) $assignedRegion = "Jawa";
                elseif (str_contains($locName, 'kalimantan')) $assignedRegion = "Kalimantan";
                elseif (str_contains($locName, 'sulawesi')) $assignedRegion = "Sulawesi";
                elseif (str_contains($locName, 'papua')) $assignedRegion = "Papua";
                elseif (str_contains($locName, 'bali') || str_contains($locName, 'nusa tenggara') || str_contains($locName, 'komodo') || str_contains($locName, 'flores')) $assignedRegion = "Nusa Tenggara & Bali";
                elseif (str_contains($locName, 'maluku')) $assignedRegion = "Maluku";
            }
            if ($assignedRegion == "Semua Wilayah") {
                $nameLower = strtolower($fauna->local_name . ' ' . $fauna->primary_habitat);
                if (str_contains($nameLower, 'sumatra')) $assignedRegion = "Sumatra";
                elseif (str_contains($nameLower, 'jawa') || str_contains($nameLower, 'ujung kulon')) $assignedRegion = "Jawa";
                elseif (str_contains($nameLower, 'kalimantan')) $assignedRegion = "Kalimantan";
                elseif (str_contains($nameLower, 'sulawesi') || str_contains($nameLower, 'anoa') || str_contains($nameLower, 'babirusa')) $assignedRegion = "Sulawesi";
                elseif (str_contains($nameLower, 'papua') || str_contains($nameLower, 'cendrawasih')) $assignedRegion = "Papua";
                elseif (str_contains($nameLower, 'komodo') || str_contains($nameLower, 'bali') || str_contains($nameLower, 'flores')) $assignedRegion = "Nusa Tenggara & Bali";
                elseif (str_contains($nameLower, 'maluku')) $assignedRegion = "Maluku";
            }
            $taxClass = $fauna->taxonomy->class_name ?? 'Mamalia';
        @endphp
        <!-- Fauna Card -->
        <div class="grid-card-container bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col"
             data-id="fauna_{{ $fauna->id }}"
             data-name="{{ strtolower($fauna->local_name . ' ' . $fauna->scientific_name . ' ' . $fauna->primary_habitat . ' ' . $taxClass) }}"
             data-status="{{ strtolower($fauna->iucn_status ?: 'lc') }}"
             data-category="fauna"
             data-taxonomy="{{ $taxClass }}"
             data-region="{{ $assignedRegion }}">
          <div class="h-48 overflow-hidden relative cursor-pointer bg-gray-100" onclick="selectSpeciesFromGrid('fauna_{{ $fauna->id }}')">
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $fauna->image_url ?: 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_406677de74_9ea41c602647f79b.png' }}" alt="{{ $fauna->local_name }}" />
            <span class="absolute top-3.5 left-3.5 bg-status-{{ strtolower($fauna->iucn_status ?: 'lc') }} text-white text-[10px] font-black px-2.5 py-1 rounded-lg shadow-md uppercase">
              {{ $fauna->iucn_status ?: 'LC' }}
            </span>
            <span class="absolute top-3.5 right-3.5 bg-white/90 backdrop-blur-sm text-gray-700 text-[10px] font-bold px-2 py-0.5 rounded-lg shadow-sm">
              <i class="fa-solid fa-paw text-[9px] text-[#2E7D32] mr-1"></i>Fauna
            </span>
          </div>
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <p class="text-[10px] font-extrabold text-[#D97706] uppercase tracking-widest mb-1">{{ $taxClass }} · {{ $assignedRegion }}</p>
              <h3 class="font-black text-gray-900 text-base mb-0.5 leading-snug">{{ $fauna->local_name }}</h3>
              <p class="text-xs italic text-gray-400 mb-3">{{ $fauna->scientific_name }}</p>
            </div>
            <div class="flex items-center justify-between text-[11px] font-bold text-gray-500 border-t border-gray-100 pt-3 mt-2">
              <span class="text-gray-400 font-semibold">{{ Str::limit($fauna->primary_habitat ?: 'Hutan Indonesia', 18) }}</span>
              <div class="flex items-center gap-2">
                <button onclick="selectSpeciesFromGrid('fauna_{{ $fauna->id }}')" title="Pusatkan di Peta" class="text-[#2E7D32] hover:text-[#1B5E20] font-bold flex items-center gap-1 text-xs cursor-pointer bg-emerald-50 px-2.5 py-1 rounded-lg">
                  <i class="fa-solid fa-location-dot text-[10px]"></i>
                  <span>Peta</span>
                </button>
                <a href="{{ route('detail-spesies', $fauna->id) }}" class="text-gray-400 hover:text-gray-700 p-1">
                  <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        @endforeach

        @foreach($herbals as $herbal)
        @php
            $assignedRegion = "Semua Wilayah";
            $nameLower = strtolower($herbal->local_name . ' ' . $herbal->origin_region . ' ' . $herbal->cultivation_zone);
            if (str_contains($nameLower, 'sumatra')) $assignedRegion = "Sumatra";
            elseif (str_contains($nameLower, 'jawa')) $assignedRegion = "Jawa";
            elseif (str_contains($nameLower, 'kalimantan')) $assignedRegion = "Kalimantan";
            elseif (str_contains($nameLower, 'sulawesi')) $assignedRegion = "Sulawesi";
            elseif (str_contains($nameLower, 'papua')) $assignedRegion = "Papua";
            elseif (str_contains($nameLower, 'lombok') || str_contains($nameLower, 'bali') || str_contains($nameLower, 'nusa tenggara')) $assignedRegion = "Nusa Tenggara & Bali";
            elseif (str_contains($nameLower, 'maluku')) $assignedRegion = "Maluku";
            else $assignedRegion = "Jawa";
        @endphp
        <!-- Flora Card -->
        <div class="grid-card-container bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group flex flex-col"
             data-id="flora_{{ $herbal->id }}"
             data-name="{{ strtolower($herbal->local_name . ' ' . $herbal->scientific_name . ' ' . $herbal->plant_family . ' ' . $herbal->description . ' flora herbal') }}"
             data-status="lc"
             data-category="flora"
             data-taxonomy="Flora Herbal"
             data-region="{{ $assignedRegion }}">
          <div class="h-48 overflow-hidden relative cursor-pointer bg-gray-100" onclick="selectSpeciesFromGrid('flora_{{ $herbal->id }}')">
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $herbal->image_url ?: 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_7ae549a4c2_576d1ef06a77f38a.png' }}" alt="{{ $herbal->local_name }}" />
            <span class="absolute top-3.5 left-3.5 bg-status-lc text-white text-[10px] font-black px-2.5 py-1 rounded-lg shadow-md uppercase">
              LC
            </span>
            <span class="absolute top-3.5 right-3.5 bg-white/90 backdrop-blur-sm text-gray-700 text-[10px] font-bold px-2 py-0.5 rounded-lg shadow-sm">
              <i class="fa-solid fa-seedling text-[9px] text-[#2E7D32] mr-1"></i>Flora
            </span>
          </div>
          <div class="p-5 flex-1 flex flex-col justify-between">
            <div>
              <p class="text-[10px] font-extrabold text-[#2E7D32] uppercase tracking-widest mb-1">{{ $herbal->plant_family ?? 'Herbal' }} · {{ $assignedRegion }}</p>
              <h3 class="font-black text-gray-900 text-base mb-0.5 leading-snug">{{ $herbal->local_name }}</h3>
              <p class="text-xs italic text-gray-400 mb-3">{{ $herbal->scientific_name }}</p>
            </div>
            <div class="flex items-center justify-between text-[11px] font-bold text-gray-500 border-t border-gray-100 pt-3 mt-2">
              <span class="text-emerald-700 font-bold bg-emerald-50 px-2 py-0.5 rounded-md text-[10px]">
                {{ $herbal->evidence_level == 'Clinical_Trial' ? 'Uji Klinis' : 'Empiris' }}
              </span>
              <div class="flex items-center gap-2">
                <button onclick="selectSpeciesFromGrid('flora_{{ $herbal->id }}')" title="Pusatkan di Peta" class="text-[#2E7D32] hover:text-[#1B5E20] font-bold flex items-center gap-1 text-xs cursor-pointer bg-emerald-50 px-2.5 py-1 rounded-lg">
                  <i class="fa-solid fa-location-dot text-[10px]"></i>
                  <span>Peta</span>
                </button>
                <a href="{{ route('detail-herbal', $herbal->id) }}" class="text-gray-400 hover:text-gray-700 p-1">
                  <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>