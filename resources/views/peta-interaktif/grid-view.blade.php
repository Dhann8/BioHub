 <div id="grid-view" class="fixed inset-0 top-16 bg-white z-[60] overflow-y-auto hidden">
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
        <!-- Sample Card 1 -->
        <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group">
          <div class="h-48 overflow-hidden relative">
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_406677de74_9ea41c602647f79b.png" alt="Sumatran tiger stalking in green grass, wildlife photography" />
            <span class="absolute top-4 left-4 bg-status-cr text-white text-[10px] font-black px-3 py-1.5 rounded-lg shadow-lg">CR</span>
          </div>
          <div class="p-6">
            <p class="text-[10px] font-bold text-amber-accent uppercase tracking-widest mb-1">Mammalia</p>
            <h3 class="font-black text-gray-900 mb-0.5">Harimau Sumatra</h3>
            <p class="text-xs italic text-gray-400 mb-4">Panthera tigris sumatrae</p>
            <div class="flex items-center justify-between text-[10px] font-bold text-gray-400 uppercase border-t border-gray-50 pt-4">
              <span>Pop: <span class="text-gray-900">~400</span></span>
              <span>Tren: <span class="text-status-cr">Kritis</span></span>
            </div>
          </div>
        </div>
        <!-- Card 2 -->
        <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 group">
          <div class="h-48 overflow-hidden relative">
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" src="https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_7ae549a4c2_576d1ef06a77f38a.png" alt="Rafflesia arnoldii flower in the wild, macro photography" />
            <span class="absolute top-4 left-4 bg-status-en text-white text-[10px] font-black px-3 py-1.5 rounded-lg shadow-lg">EN</span>
          </div>
          <div class="p-6">
            <p class="text-[10px] font-bold text-amber-accent uppercase tracking-widest mb-1">Flora</p>
            <h3 class="font-black text-gray-900 mb-0.5">Rafflesia Arnoldii</h3>
            <p class="text-xs italic text-gray-400 mb-4">Rafflesia arnoldii</p>
            <div class="flex items-center justify-between text-[10px] font-bold text-gray-400 uppercase border-t border-gray-50 pt-4">
              <span>Pop: <span class="text-gray-900">Langka</span></span>
              <span>Tren: <span class="text-status-en">Menurun</span></span>
            </div>
          </div>
        </div>
        <!-- Add more cards as needed -->
      </div>
    </div>
  </div>