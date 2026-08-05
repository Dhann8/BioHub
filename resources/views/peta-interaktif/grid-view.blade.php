 <div id="grid-view" class="fixed inset-0 top-16 bg-white z-60 overflow-y-auto hidden">
    <div class="max-w-7xl mx-auto px-6 py-10">
      <div class="flex items-center justify-between mb-10">
        <div>
          <h2 class="text-3xl font-black text-gray-900">Katalog Spesies</h2>
          <p class="text-gray-500 text-sm mt-1">Menampilkan 120 spesies berdasarkan filter saat ini.</p>
        </div>
        <div class="flex items-center gap-2">
          <button onclick="toggleView('map')" class="bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold px-5 py-2.5 rounded-xl transition flex items-center gap-2">
            <i class="fa-solid fa-map"></i> Kembali ke Peta
          </button>
        </div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        @foreach($faunas as $fauna)
        @php
            $assignedRegion = "Semua Wilayah";
            if (str_contains(strtolower($fauna->local_name), 'sumatra')) $assignedRegion = "Sumatra";
            elseif (str_contains(strtolower($fauna->local_name), 'komodo')) $assignedRegion = "Nusa Tenggara & Bali";
            elseif (str_contains(strtolower($fauna->local_name), 'cendrawasih')) $assignedRegion = "Papua";
        @endphp
        <!-- Dynamic Card -->
        <div class="grid-card-container bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group"
             data-name="{{ strtolower($fauna->local_name) }}"
             data-status="{{ strtolower($fauna->iucn_status) }}"
             data-category="fauna"
             data-region="{{ $assignedRegion }}"
             >
          <div class="h-48 overflow-hidden relative cursor-pointer" onclick="openDrawer('fauna_{{ $fauna->id }}'); toggleView('map');">
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $fauna->image_url ?: 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_406677de74_9ea41c602647f79b.png' }}" alt="{{ $fauna->local_name }}" />
            <span class="absolute top-4 left-4 bg-status-{{ strtolower($fauna->iucn_status) }} text-white text-[10px] font-black px-3 py-1.5 rounded-lg shadow-lg">{{ $fauna->iucn_status }}</span>
          </div>
          <div class="p-6">
            <p class="text-[10px] font-bold text-amber-accent uppercase tracking-widest mb-1">{{ $fauna->taxonomy->class_name ?? 'Fauna' }}</p>
            <h3 class="font-black text-gray-900 mb-0.5">{{ $fauna->local_name }}</h3>
            <p class="text-xs italic text-gray-400 mb-4">{{ $fauna->scientific_name }}</p>
            <div class="flex items-center justify-between text-[10px] font-bold text-gray-400 uppercase border-t border-gray-50 pt-4">
              <span>Pop: <span class="text-gray-900">N/A</span></span>
              <span>Tren: <span class="text-status-{{ strtolower($fauna->iucn_status) }}">{{ $fauna->iucn_status }}</span></span>
            </div>
          </div>
        </div>
        @endforeach

        @foreach($herbals as $herbal)
        @php
            $assignedRegion = "Semua Wilayah";
            if (str_contains(strtolower($herbal->local_name), 'papua')) $assignedRegion = "Papua";
            if (str_contains(strtolower($herbal->local_name), 'jawa')) $assignedRegion = "Jawa";
        @endphp
        <!-- Dynamic Card -->
        <div class="grid-card-container hidden bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group"
             data-name="{{ strtolower($herbal->local_name) }}"
             data-status="lc"
             data-category="flora"
             data-region="{{ $assignedRegion }}"
             >
          <div class="h-48 overflow-hidden relative cursor-pointer" onclick="openDrawer('flora_{{ $herbal->id }}'); toggleView('map');">
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="{{ $herbal->image_url ?: 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_7ae549a4c2_576d1ef06a77f38a.png' }}" alt="{{ $herbal->local_name }}" />
            <span class="absolute top-4 left-4 bg-status-lc text-white text-[10px] font-black px-3 py-1.5 rounded-lg shadow-lg">LC</span>
          </div>
          <div class="p-6">
            <p class="text-[10px] font-bold text-amber-accent uppercase tracking-widest mb-1">{{ $herbal->plant_family ?? 'Flora' }}</p>
            <h3 class="font-black text-gray-900 mb-0.5">{{ $herbal->local_name }}</h3>
            <p class="text-xs italic text-gray-400 mb-4">{{ $herbal->scientific_name }}</p>
            <div class="flex items-center justify-between text-[10px] font-bold text-gray-400 uppercase border-t border-gray-50 pt-4">
              <span>Pop: <span class="text-gray-900">N/A</span></span>
              <span>Tren: <span class="text-status-lc">Stabil</span></span>
            </div>
          </div>
        </div>
        @endforeach
      </div>
    </div>
  </div>