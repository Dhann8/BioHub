@extends('layout.base')

@section('content')
<main class="pt-32 pb-20 px-4">
  <div class="max-w-6xl mx-auto">

    <!-- Wizard Header -->
    <div class="text-center mb-12">
      <h1 class="text-3xl md:text-5xl font-black text-gray-900 mb-4">Identifikasi Spesies Endemik</h1>
      <p class="text-gray-500 text-base max-w-2xl mx-auto leading-relaxed">
        Gunakan filter atribut fisik dan wilayah untuk mengidentifikasi spesies liar unik Indonesia yang Anda temui atau ingin pelajari.
      </p>
    </div>

    <!-- Step Indicator -->
    <div class="flex items-center justify-center gap-4 mb-16">
      <div id="dot-1" class="w-12 h-12 rounded-full bg-[#1E4D2B] text-white flex items-center justify-center font-bold shadow-lg shadow-green-900/20">1</div>
      <div class="w-24 h-1 bg-gray-200 rounded-full overflow-hidden">
        <div id="line-1" class="h-full bg-[#1E4D2B] rounded-full w-0 transition-all duration-500"></div>
      </div>
      <div id="dot-2" class="w-12 h-12 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-bold">2</div>
    </div>

    <!-- STEP 1: Attribute & Location Selector -->
    <div id="step-1" class="wizard-step active">
      <div class="space-y-12">

        <!-- Taxonomy Section -->
        <section>
          <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center gap-2">
            <span class="w-2 h-6 bg-[#D97706] rounded-full"></span> 1. Klasifikasi Taksonomi
          </h3>
          <div class="grid grid-cols-2 md:grid-cols-5 gap-4" id="taxonomyGrid">
            <!-- Populated dynamically from API -->
            <button type="button" onclick="toggleActive(this)" data-value="Mamalia" class="selector-card bg-white border border-gray-100 p-6 rounded-2xl text-center group transition">
              <div class="w-12 h-12 rounded-xl bg-forest-pale text-forest-primary flex items-center justify-center mx-auto mb-4 group-hover:bg-forest-primary group-hover:text-white transition">
                <i class="fa-solid fa-paw text-xl"></i>
              </div>
              <span class="text-sm font-bold text-gray-700">Mamalia</span>
            </button>
            <button type="button" onclick="toggleActive(this)" data-value="Burung" class="selector-card bg-white border border-gray-100 p-6 rounded-2xl text-center group transition">
              <div class="w-12 h-12 rounded-xl bg-forest-pale text-forest-primary flex items-center justify-center mx-auto mb-4 group-hover:bg-forest-primary group-hover:text-white transition">
                <i class="fa-solid fa-dove text-xl"></i>
              </div>
              <span class="text-sm font-bold text-gray-700">Burung</span>
            </button>
            <button type="button" onclick="toggleActive(this)" data-value="Reptil" class="selector-card bg-white border border-gray-100 p-6 rounded-2xl text-center group transition">
              <div class="w-12 h-12 rounded-xl bg-forest-pale text-forest-primary flex items-center justify-center mx-auto mb-4 group-hover:bg-forest-primary group-hover:text-white transition">
                <i class="fa-solid fa-dragon text-xl"></i>
              </div>
              <span class="text-sm font-bold text-gray-700">Reptil</span>
            </button>
            <button type="button" onclick="toggleActive(this)" data-value="Amfibi" class="selector-card bg-white border border-gray-100 p-6 rounded-2xl text-center group transition">
              <div class="w-12 h-12 rounded-xl bg-forest-pale text-forest-primary flex items-center justify-center mx-auto mb-4 group-hover:bg-forest-primary group-hover:text-white transition">
                <i class="fa-solid fa-frog text-xl"></i>
              </div>
              <span class="text-sm font-bold text-gray-700">Amfibi</span>
            </button>
            <button type="button" onclick="toggleActive(this)" data-value="Serangga" class="selector-card bg-white border border-gray-100 p-6 rounded-2xl text-center group transition">
              <div class="w-12 h-12 rounded-xl bg-forest-pale text-forest-primary flex items-center justify-center mx-auto mb-4 group-hover:bg-forest-primary group-hover:text-white transition">
                <i class="fa-solid fa-bug text-xl"></i>
              </div>
              <span class="text-sm font-bold text-gray-700">Serangga</span>
            </button>
          </div>
        </section>

        <!-- Physical Attributes Section -->
        <section>
          <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center gap-2">
            <span class="w-2 h-6 bg-[#D97706] rounded-full"></span> 2. Atribut Fisik Utama
          </h3>
          <div class="grid md:grid-cols-3 gap-8">
            <!-- Size Selector -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
              <label class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 block">Ukuran Tubuh</label>
              <div class="flex flex-col gap-2">
                <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 cursor-pointer transition border border-transparent hover:border-gray-100">
                  <input type="radio" name="size" value="Kecil" class="w-4 h-4 text-forest-primary focus:ring-forest-primary">
                  <span class="text-sm font-medium text-gray-700">Kecil (0 - 50 cm)</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 cursor-pointer transition border border-transparent hover:border-gray-100">
                  <input type="radio" name="size" value="Sedang" class="w-4 h-4 text-forest-primary focus:ring-forest-primary">
                  <span class="text-sm font-medium text-gray-700">Sedang (50 - 150 cm)</span>
                </label>
                <label class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 cursor-pointer transition border border-transparent hover:border-gray-100">
                  <input type="radio" name="size" value="Besar" class="w-4 h-4 text-forest-primary focus:ring-forest-primary">
                  <span class="text-sm font-medium text-gray-700">Besar (> 150 cm)</span>
                </label>
              </div>
            </div>

            <!-- Color/Features Selector -->
            <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm md:col-span-2">
              <label class="text-xs font-black text-gray-400 uppercase tracking-widest mb-4 block">Fitur Unik</label>
              <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                <button type="button" onclick="toggleActive(this)" data-value="Tanduk/Cula" class="selector-card p-3 border border-gray-100 rounded-xl text-xs font-bold text-gray-600 flex items-center justify-center gap-2 transition">
                  <i class="fa-solid fa-crown text-forest-primary"></i> Tanduk/Cula
                </button>
                <button type="button" onclick="toggleActive(this)" data-value="Sayap" class="selector-card p-3 border border-gray-100 rounded-xl text-xs font-bold text-gray-600 flex items-center justify-center gap-2 transition">
                  <i class="fa-solid fa-feather text-forest-primary"></i> Sayap
                </button>
                <button type="button" onclick="toggleActive(this)" data-value="Sisik/Cangkang" class="selector-card p-3 border border-gray-100 rounded-xl text-xs font-bold text-gray-600 flex items-center justify-center gap-2 transition">
                  <i class="fa-solid fa-shield-halved text-forest-primary"></i> Sisik/Cangkang
                </button>
                <button type="button" onclick="toggleActive(this)" data-value="Bintik/Garis" class="selector-card p-3 border border-gray-100 rounded-xl text-xs font-bold text-gray-600 flex items-center justify-center gap-2 transition">
                  <i class="fa-solid fa-fingerprint text-forest-primary"></i> Bintik/Garis
                </button>
                <button type="button" onclick="toggleActive(this)" data-value="Ekor Panjang" class="selector-card p-3 border border-gray-100 rounded-xl text-xs font-bold text-gray-600 flex items-center justify-center gap-2 transition">
                  <i class="fa-solid fa-wave-square text-forest-primary"></i> Ekor Panjang
                </button>
                <button type="button" onclick="toggleActive(this)" data-value="Nokturnal" class="selector-card p-3 border border-gray-100 rounded-xl text-xs font-bold text-gray-600 flex items-center justify-center gap-2 transition">
                  <i class="fa-solid fa-moon text-forest-primary"></i> Nokturnal
                </button>
              </div>
            </div>
          </div>
        </section>

        <!-- Region Section -->
        <section>
          <h3 class="text-lg font-black text-gray-900 mb-6 flex items-center gap-2">
            <span class="w-2 h-6 bg-[#D97706] rounded-full"></span> 3. Wilayah Pengamatan
          </h3>
          <div class="flex flex-wrap gap-3">
            <button type="button" onclick="toggleActive(this)" data-value="Sumatra" class="selector-card bg-white border border-gray-100 px-6 py-3 rounded-full text-sm font-bold text-gray-600 transition">Sumatra</button>
            <button type="button" onclick="toggleActive(this)" data-value="Jawa" class="selector-card bg-white border border-gray-100 px-6 py-3 rounded-full text-sm font-bold text-gray-600 transition">Jawa</button>
            <button type="button" onclick="toggleActive(this)" data-value="Kalimantan" class="selector-card bg-white border border-gray-100 px-6 py-3 rounded-full text-sm font-bold text-gray-600 transition">Kalimantan</button>
            <button type="button" onclick="toggleActive(this)" data-value="Sulawesi" class="selector-card bg-white border border-gray-100 px-6 py-3 rounded-full text-sm font-bold text-gray-600 transition">Sulawesi</button>
            <button type="button" onclick="toggleActive(this)" data-value="Nusa Tenggara" class="selector-card bg-white border border-gray-100 px-6 py-3 rounded-full text-sm font-bold text-gray-600 transition">Nusa Tenggara</button>
            <button type="button" onclick="toggleActive(this)" data-value="Maluku" class="selector-card bg-white border border-gray-100 px-6 py-3 rounded-full text-sm font-bold text-gray-600 transition">Maluku</button>
            <button type="button" onclick="toggleActive(this)" data-value="Papua" class="selector-card bg-white border border-gray-100 px-6 py-3 rounded-full text-sm font-bold text-gray-600 transition">Papua</button>
          </div>
        </section>

        <div class="flex justify-center pt-8">
          <button type="button" onclick="goToStep(2)" class="bg-[#1E4D2B] hover:bg-[#0E2E1A] text-white font-bold px-12 py-5 rounded-2xl shadow-xl shadow-green-900/20 flex items-center gap-4 transition text-lg group">
            Cari Spesies <i class="fa-solid fa-magnifying-glass group-hover:scale-125 transition"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- STEP 2: Results Grid -->
    <div id="step-2" class="wizard-step">

      <!-- Results Header -->
      <div class="flex flex-col md:flex-row md:items-end justify-between mb-10 gap-6">
        <div>
          <h2 class="text-2xl font-black text-gray-900">Hasil Pencarian Spesies</h2>
          <p class="text-sm text-gray-500 mt-1">Ditemukan <span id="speciesCount" class="font-bold text-forest-primary">0 Spesies</span> yang cocok dengan kriteria Anda.</p>
        </div>
        <div class="flex items-center gap-3">
          <button type="button" onclick="goToStep(1)" class="bg-white border-2 border-gray-100 text-gray-600 font-bold px-5 py-3 rounded-xl text-sm flex items-center gap-2 hover:bg-gray-50 transition">
            <i class="fa-solid fa-sliders"></i> Sesuaikan Filter
          </button>
        </div>
      </div>

      <!-- Conservation Banner -->
      <div class="report-banner bg-white shadow-sm rounded-2xl p-6 mb-10 flex flex-col md:flex-row items-center gap-6 border border-gray-100 relative overflow-hidden">
        <div class="w-16 h-16 rounded-full bg-status-cr flex items-center justify-center text-white shrink-0 shadow-lg shadow-status-cr/20 z-10">
          <i class="fa-solid fa-bullhorn text-2xl animate-pulse"></i>
        </div>
        <div class="z-10 text-center md:text-left">
          <h4 class="font-black text-gray-900 mb-1 flex items-center justify-center md:justify-start gap-2">
            Peringatan Konservasi <span class="bg-status-cr text-white text-[10px] px-2 py-0.5 rounded uppercase">Urgent</span>
          </h4>
          <p class="text-sm text-gray-500 max-w-2xl">
            Jika Anda melihat spesies terancam punah dalam kondisi berbahaya atau di luar habitatnya, segera hubungi otoritas spesies liar setempat (<strong class="text-gray-800">Call Center BKSDA</strong>).
          </p>
        </div>
        <div class="md:ml-auto z-10">
          <a href="tel:123456" class="bg-status-cr hover:bg-red-800 text-white font-bold px-6 py-3 rounded-xl text-sm flex items-center gap-2 transition whitespace-nowrap">
            <i class="fa-solid fa-phone"></i> Laporkan (Hotline)
          </a>
        </div>
        <div class="absolute -right-8 -bottom-8 w-48 h-48 bg-status-cr/5 rounded-full"></div>
      </div>

      <!-- Loading State -->
      <div id="speciesLoading" class="text-center py-20 hidden">
        <div class="inline-flex flex-col items-center gap-4">
          <div class="w-14 h-14 rounded-full border-4 border-green-pale border-t-forest-primary animate-spin"></div>
          <p class="text-gray-500 font-semibold">Memuat data spesies...</p>
        </div>
      </div>

      <!-- Animal Results Grid -->
      <div id="speciesGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8"></div>

      <!-- Empty State -->
      <div id="speciesEmpty" class="hidden text-center py-20">
        <i class="fa-solid fa-magnifying-glass text-5xl text-gray-200 mb-4"></i>
        <p class="font-bold text-gray-600 mb-1">Tidak Ada Spesies Ditemukan</p>
        <p class="text-sm text-gray-400">Coba ubah atau hapus filter yang dipilih.</p>
      </div>

      <!-- Load More Button -->
      <div id="loadMoreContainer" class="mt-16 text-center hidden">
        <button id="loadMoreBtn" onclick="loadMoreSpecies()"
          class="text-forest-primary font-bold text-sm border-2 border-forest-primary px-10 py-4 rounded-2xl hover:bg-forest-pale transition flex items-center gap-2 mx-auto">
          Lihat Selengkapnya <i class="fa-solid fa-chevron-down text-xs"></i>
        </button>
      </div>

    </div>

  </div>
</main>

<script src="{{ asset('js/FilterSpesies.js') }}"></script>
@endsection
