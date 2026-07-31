<section id="hero" class="relative pt-16 h-[780px] overflow-hidden">
    <img class="absolute inset-0 w-full h-full object-cover" src="{{ asset('image/bg_hero.webp') }}" alt="Hero Background" />
    <div class="hero-bg absolute inset-0"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center items-center text-center">
      
      <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-white leading-tight max-w-4xl mb-5">
        Jelajahi Flora, Fauna <span class="text-[#f08000]">Endemik</span> &amp; Kearifan Herbal Nusantara
      </h1>
      <p class="text-white/80 text-lg max-w-2xl mb-10 leading-relaxed">
        Ensiklopedia digital terlengkap tentang keanekaragaman hayati Indonesia dari spesies endemik hingga ramuan tradisional yang telah teruji.
      </p>

      {{-- SEARCH FORM --}}
      <form id="heroGlobalSearchForm" class="w-full max-w-3xl bg-white rounded-2xl shadow-2xl p-2 flex flex-col sm:flex-row gap-2">
        <div class="flex-1 flex items-center gap-3 px-4">
          <i class="fa-solid fa-magnifying-glass text-gray-400 text-lg"></i>
          <input
            id="globalSearchInput"
            type="text"
            placeholder="Cari nama hewan, herbal (misal: Anoa, Kunyit)..."
            class="flex-1 outline-none text-gray-700 text-sm py-3 placeholder-gray-400 bg-transparent"
            required
          />
        </div>
        <div class="flex items-center gap-2 px-2 border-l border-gray-100">
          <select id="globalCategorySelect" class="text-sm text-gray-500 outline-none bg-transparent pr-2 cursor-pointer">
            <option value="all">Semua Kategori</option>
            <option value="fauna">Fauna Endemik</option>
            <option value="flora">Flora Dilindungi</option>
            <option value="herbal">Obat Herbal</option>
          </select>
        </div>
        <button type="submit" id="searchBtn" class="bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-semibold text-sm px-7 py-3 rounded-xl transition cursor-pointer flex items-center justify-center gap-2">
          <i class="fa-solid fa-search"></i>
          <span>Cari</span>
        </button>
      </form>

      <!-- Quick Filters -->
      <div class="flex flex-wrap justify-center gap-3 mt-5">
        <a href="{{ route('spesies', ['kategori' => 'fauna']) }}" class="flex items-center gap-2 bg-white/15 hover:bg-white/25 backdrop-blur-sm border border-white/30 text-white text-xs font-medium px-4 py-2 rounded-full transition">
          <i class="fa-solid fa-paw"></i>Fauna Endemik
        </a>
        <a href="{{ route('spesies', ['kategori' => 'flora']) }}" class="flex items-center gap-2 bg-white/15 hover:bg-white/25 backdrop-blur-sm border border-white/30 text-white text-xs font-medium px-4 py-2 rounded-full transition">
          <i class="fa-solid fa-seedling"></i>Flora Dilindungi
        </a>
        <a href="{{ route('herbal') }}" class="flex items-center gap-2 bg-white/15 hover:bg-white/25 backdrop-blur-sm border border-white/30 text-white text-xs font-medium px-4 py-2 rounded-full transition">
          <i class="fa-solid fa-mortar-pestle"></i>Obat Herbal
        </a>
        <a href="{{ route('map') }}" class="flex items-center gap-2 bg-white/15 hover:bg-white/25 backdrop-blur-sm border border-white/30 text-white text-xs font-medium px-4 py-2 rounded-full transition">
          <i class="fa-solid fa-map-location-dot"></i>Peta Spesies
        </a>
      </div>
    </div>
</section>

<script src="{{ asset('js/SeachHomepage.js') }}"></script>