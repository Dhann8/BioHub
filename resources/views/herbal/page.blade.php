@extends('layout.base')

@section('content')

<main class="pt-32 pb-20 px-4">
    <div class="max-w-5xl mx-auto">
      
      <!-- Wizard Header -->
      <div class="text-center mb-12">
        <div class="inline-flex items-center gap-2 bg-[#FEF3C7] text-[#D97706] text-xs font-bold px-4 py-1.5 rounded-full mb-4 uppercase tracking-widest">
          <i class="fa-solid fa-mortar-pestle"></i> TOGA Wizard
        </div>
        <h1 class="text-3xl md:text-4xl font-black text-gray-900 mb-4">Konsultasi Mandiri Herbal Nusantara</h1>
        <p class="text-gray-500 text-base max-w-2xl mx-auto leading-relaxed">
          Temukan solusi alami dari tanaman obat keluarga (TOGA) berdasarkan keluhan kesehatan Anda melalui database kearifan lokal yang teruji.
        </p>
      </div>

      <!-- Step Indicator -->
      <div class="flex items-center justify-center gap-4 mb-12">
        <div id="dot-1" class="w-10 h-10 rounded-full bg-[#2E7D32] text-white flex items-center justify-center font-bold shadow-lg shadow-green-900/20">1</div>
        <div class="w-16 h-1 bg-gray-200 rounded-full">
            <div id="line-1" class="h-full bg-[#2E7D32] rounded-full w-0 transition-all duration-500"></div>
        </div>
        <div id="dot-2" class="w-10 h-10 rounded-full bg-gray-200 text-gray-400 flex items-center justify-center font-bold">2</div>
      </div>

      <!-- STEP 1: Symptom Selector -->
      <div id="step-1" class="wizard-step active">
        <div class="bg-white rounded-3xl p-8 md:p-12 shadow-sm border border-gray-100">
          <div class="mb-10">
            <h2 class="text-xl font-bold text-gray-900 mb-2">Apa yang Anda rasakan?</h2>
            <p class="text-sm text-gray-500">Pilih gejala yang paling sesuai untuk mendapatkan rekomendasi herbal.</p>
          </div>

          <!-- Search Symptom -->
          <div class="relative mb-8">
            <i class="fa-solid fa-magnifying-glass absolute left-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" placeholder="Cari gejala (misal: pusing, mual, pegal linu...)" class="w-full bg-gray-50 border border-gray-200 rounded-2xl py-4 pl-14 pr-6 focus:ring-2 focus:ring-[#2E7D32] outline-none text-gray-700 transition">
          </div>

          <!-- Symptom Grid -->
          <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-10">
            <button onclick="toggleSymptom(this)" class="symptom-card bg-white border border-gray-100 p-6 rounded-2xl text-center group transition">
              <div class="w-12 h-12 rounded-xl bg-[#E8F5E9] text-[#2E7D32] flex items-center justify-center mx-auto mb-4 group-hover:bg-[#2E7D32] group-hover:text-white transition">
                <i class="fa-solid fa-temperature-high text-xl"></i>
              </div>
              <span class="text-sm font-bold text-gray-700">Demam</span>
            </button>
            <button onclick="toggleSymptom(this)" class="symptom-card bg-white border border-gray-100 p-6 rounded-2xl text-center group transition">
              <div class="w-12 h-12 rounded-xl bg-[#FEF3C7] text-[#D97706] flex items-center justify-center mx-auto mb-4 group-hover:bg-[#D97706] group-hover:text-white transition">
                <i class="fa-solid fa-head-side-mask text-xl"></i>
              </div>
              <span class="text-sm font-bold text-gray-700">Batuk & Flu</span>
            </button>
            <button onclick="toggleSymptom(this)" class="symptom-card bg-white border border-gray-100 p-6 rounded-2xl text-center group transition">
              <div class="w-12 h-12 rounded-xl bg-[#E8F5E9] text-[#2E7D32] flex items-center justify-center mx-auto mb-4 group-hover:bg-[#2E7D32] group-hover:text-white transition">
                <i class="fa-solid fa-stomach text-xl"></i>
              </div>
              <span class="text-sm font-bold text-gray-700">Pencernaan</span>
            </button>
            <button onclick="toggleSymptom(this)" class="symptom-card bg-white border border-gray-100 p-6 rounded-2xl text-center group transition">
              <div class="w-12 h-12 rounded-xl bg-[#FEF3C7] text-[#D97706] flex items-center justify-center mx-auto mb-4 group-hover:bg-[#D97706] group-hover:text-white transition">
                <i class="fa-solid fa-head-side-virus text-xl"></i>
              </div>
              <span class="text-sm font-bold text-gray-700">Sakit Kepala</span>
            </button>
            <button onclick="toggleSymptom(this)" class="symptom-card bg-white border border-gray-100 p-6 rounded-2xl text-center group transition">
              <div class="w-12 h-12 rounded-xl bg-[#E8F5E9] text-[#2E7D32] flex items-center justify-center mx-auto mb-4 group-hover:bg-[#2E7D32] group-hover:text-white transition">
                <i class="fa-solid fa-joint text-xl"></i>
              </div>
              <span class="text-sm font-bold text-gray-700">Nyeri Sendi</span>
            </button>
            <button onclick="toggleSymptom(this)" class="symptom-card bg-white border border-gray-100 p-6 rounded-2xl text-center group transition">
              <div class="w-12 h-12 rounded-xl bg-[#FEF3C7] text-[#D97706] flex items-center justify-center mx-auto mb-4 group-hover:bg-[#D97706] group-hover:text-white transition">
                <i class="fa-solid fa-droplet text-xl"></i>
              </div>
              <span class="text-sm font-bold text-gray-700">Hipertensi</span>
            </button>
            <button onclick="toggleSymptom(this)" class="symptom-card bg-white border border-gray-100 p-6 rounded-2xl text-center group transition">
              <div class="w-12 h-12 rounded-xl bg-[#E8F5E9] text-[#2E7D32] flex items-center justify-center mx-auto mb-4 group-hover:bg-[#2E7D32] group-hover:text-white transition">
                <i class="fa-solid fa-hand-dots text-xl"></i>
              </div>
              <span class="text-sm font-bold text-gray-700">Gatal/Kulit</span>
            </button>
            <button onclick="toggleSymptom(this)" class="symptom-card bg-white border border-gray-100 p-6 rounded-2xl text-center group transition">
              <div class="w-12 h-12 rounded-xl bg-[#FEF3C7] text-[#D97706] flex items-center justify-center mx-auto mb-4 group-hover:bg-[#D97706] group-hover:text-white transition">
                <i class="fa-solid fa-moon text-xl"></i>
              </div>
              <span class="text-sm font-bold text-gray-700">Insomnia</span>
            </button>
          </div>

          <div class="flex justify-end">
            <button onclick="goToStep(2)" class="bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-bold px-10 py-4 rounded-2xl shadow-lg shadow-green-900/20 flex items-center gap-3 transition">
              Cari Rekomendasi <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- STEP 2: Results Grid -->
      <div id="step-2" class="wizard-step">
        <!-- Results Section -->
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
          <div>
            <h2 class="text-xl font-bold text-gray-900">Rekomendasi Herbal Ditemukan</h2>
            <p class="text-sm text-gray-500">Berdasarkan gejala: <span class="font-bold text-[#2E7D32]">Demam, Sakit Kepala</span></p>
          </div>
          <button onclick="goToStep(1)" class="text-[#2E7D32] font-bold text-sm flex items-center gap-2 hover:underline">
            <i class="fa-solid fa-arrow-left"></i> Ubah Gejala
          </button>
        </div>

        <!-- Disclaimer Banner -->
        <div class="bg-[#FEF3C7] border border-[#D97706]/20 rounded-2xl p-6 mb-10 flex gap-4">
          <div class="w-12 h-12 rounded-full bg-[#D97706] flex items-center justify-center text-white shrink-0">
            <i class="fa-solid fa-triangle-exclamation text-lg"></i>
          </div>
          <div>
            <h4 class="font-bold text-[#B45309] text-sm mb-1">Peringatan Medis</h4>
            <p class="text-[#B45309] text-xs leading-relaxed opacity-80">
              Informasi ini bersifat edukatif dan bukan pengganti saran medis profesional. Penggunaan ramuan herbal pada ibu hamil, anak-anak, atau kondisi penyakit kronis wajib dikonsultasikan dengan tenaga medis terlebih dahulu.
            </p>
          </div>
        </div>

        <!-- Plant Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          
          <!-- Card 1 -->
          <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="h-56 relative">
              <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1615485290382-441e4d049cb5?auto=format&fit=crop&w=800&q=80" alt="fresh ginger root with green leaves, Zingiber officinale, natural medicine herb, bright lighting" />
              <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-full px-3 py-1 text-[10px] font-bold text-[#2E7D32] border border-green-100">
                <i class="fa-solid fa-check-circle mr-1"></i> Aman Dikonsumsi
              </div>
            </div>
            <div class="p-8">
              <div class="mb-6">
                <h3 class="text-2xl font-black text-gray-900 mb-1">Jahe Merah</h3>
                <p class="text-sm italic text-gray-400">Zingiber officinale var. Rubrum</p>
              </div>
              
              <div class="space-y-4 mb-8">
                <div>
                  <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Kandungan Aktif</p>
                  <div class="flex flex-wrap gap-2">
                    <span class="bg-gray-50 text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded-lg">Gingerol</span>
                    <span class="bg-gray-50 text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded-lg">Shogaol</span>
                    <span class="bg-gray-50 text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded-lg">Zingeron</span>
                  </div>
                </div>
                <div>
                  <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Indikator Keamanan Dosis</p>
                  <div class="w-full bg-gray-100 safety-indicator overflow-hidden">
                    <div class="h-full bg-green-500 w-[90%]"></div>
                  </div>
                  <p class="text-[10px] text-gray-400 mt-1">Tingkat toksisitas sangat rendah</p>
                </div>
              </div>

              <div class="flex gap-3">
                <a href="detail-herbal.html" class="flex-1 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-bold py-3 rounded-xl transition text-center flex items-center justify-center">
                  Lihat Cara Racik
                </a>
                <button class="px-4 border border-gray-100 hover:bg-gray-50 text-gray-400 rounded-xl transition">
                  <i class="fa-solid fa-bookmark"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Card 2 -->
          <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="h-56 relative">
              <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1615485500704-8e990f9900f7?auto=format&fit=crop&w=800&q=80" alt="fresh turmeric root and slices, Curcuma longa, traditional indonesian spice, vibrant orange" />
              <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-full px-3 py-1 text-[10px] font-bold text-[#2E7D32] border border-green-100">
                <i class="fa-solid fa-check-circle mr-1"></i> Aman Dikonsumsi
              </div>
            </div>
            <div class="p-8">
              <div class="mb-6">
                <h3 class="text-2xl font-black text-gray-900 mb-1">Kunyit</h3>
                <p class="text-sm italic text-gray-400">Curcuma longa</p>
              </div>
              
              <div class="space-y-4 mb-8">
                <div>
                  <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Kandungan Aktif</p>
                  <div class="flex flex-wrap gap-2">
                    <span class="bg-gray-50 text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded-lg">Kurkuminoid</span>
                    <span class="bg-gray-50 text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded-lg">Desmetoksikurkumin</span>
                  </div>
                </div>
                <div>
                  <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Indikator Keamanan Dosis</p>
                  <div class="w-full bg-gray-100 safety-indicator overflow-hidden">
                    <div class="h-full bg-green-500 w-[85%]"></div>
                  </div>
                  <p class="text-[10px] text-gray-400 mt-1">Sangat aman untuk konsumsi harian</p>
                </div>
              </div>

              <div class="flex gap-3">
                <a href="detail-herbal.html" class="flex-1 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-bold py-3 rounded-xl transition text-center flex items-center justify-center">
                  Lihat Cara Racik
                </a>
                <button class="px-4 border border-gray-100 hover:bg-gray-50 text-gray-400 rounded-xl transition">
                  <i class="fa-solid fa-bookmark"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Card 3 -->
          <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="h-56 relative">
              <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1515586000433-45406d8e6662?auto=format&fit=crop&w=800&q=80" alt="Andrographis paniculata plant green leaves, Sambiloto herbal plant, bitter leaf medicine" />
              <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-full px-3 py-1 text-[10px] font-bold text-[#D97706] border border-amber-100">
                <i class="fa-solid fa-circle-info mr-1"></i> Perhatikan Dosis
              </div>
            </div>
            <div class="p-8">
              <div class="mb-6">
                <h3 class="text-2xl font-black text-gray-900 mb-1">Sambiloto</h3>
                <p class="text-sm italic text-gray-400">Andrographis paniculata</p>
              </div>
              
              <div class="space-y-4 mb-8">
                <div>
                  <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Kandungan Aktif</p>
                  <div class="flex flex-wrap gap-2">
                    <span class="bg-gray-50 text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded-lg">Andrografolida</span>
                    <span class="bg-gray-50 text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded-lg">Neoandrografolida</span>
                  </div>
                </div>
                <div>
                  <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Indikator Keamanan Dosis</p>
                  <div class="w-full bg-gray-100 safety-indicator overflow-hidden">
                    <div class="h-full bg-amber-500 w-[60%]"></div>
                  </div>
                  <p class="text-[10px] text-gray-400 mt-1">Konsumsi berlebih dapat menyebabkan mual</p>
                </div>
              </div>

              <div class="flex gap-3">
                <a href="detail-herbal.html" class="flex-1 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-bold py-3 rounded-xl transition text-center flex items-center justify-center">
                  Lihat Cara Racik
                </a>
                <button class="px-4 border border-gray-100 hover:bg-gray-50 text-gray-400 rounded-xl transition">
                  <i class="fa-solid fa-bookmark"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Card 4 -->
          <div class="bg-white rounded-3xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="h-56 relative">
              <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1598144247392-5b927d3b246a?auto=format&fit=crop&w=800&q=80" alt="fresh lemongrass bundle and stalks, Cymbopogon citratus, aromatic herbal plant" />
              <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm rounded-full px-3 py-1 text-[10px] font-bold text-[#2E7D32] border border-green-100">
                <i class="fa-solid fa-check-circle mr-1"></i> Aman Dikonsumsi
              </div>
            </div>
            <div class="p-8">
              <div class="mb-6">
                <h3 class="text-2xl font-black text-gray-900 mb-1">Serai Wangi</h3>
                <p class="text-sm italic text-gray-400">Cymbopogon nardus</p>
              </div>
              
              <div class="space-y-4 mb-8">
                <div>
                  <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Kandungan Aktif</p>
                  <div class="flex flex-wrap gap-2">
                    <span class="bg-gray-50 text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded-lg">Sitronela</span>
                    <span class="bg-gray-50 text-gray-600 text-[10px] font-bold px-2.5 py-1 rounded-lg">Geraniol</span>
                  </div>
                </div>
                <div>
                  <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2">Indikator Keamanan Dosis</p>
                  <div class="w-full bg-gray-100 safety-indicator overflow-hidden">
                    <div class="h-full bg-green-500 w-[95%]"></div>
                  </div>
                  <p class="text-[10px] text-gray-400 mt-1">Sangat aman digunakan dalam minuman/teh</p>
                </div>
              </div>

              <div class="flex gap-3">
                <a href="detail-herbal.html" class="flex-1 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-bold py-3 rounded-xl transition text-center flex items-center justify-center">
                  Lihat Cara Racik
                </a>
                <button class="px-4 border border-gray-100 hover:bg-gray-50 text-gray-400 rounded-xl transition">
                  <i class="fa-solid fa-bookmark"></i>
                </button>
              </div>
            </div>
          </div>

        </div>

        <!-- Pagination/Load More -->
        <div class="mt-12 text-center">
            <button class="text-[#2E7D32] font-bold text-sm border-2 border-[#2E7D32] px-8 py-3 rounded-2xl hover:bg-[#E8F5E9] transition">
                Tampilkan Lebih Banyak Herbal
            </button>
        </div>
      </div>

    </div>
  </main>
  
  <script src="{{ asset('js/FIlterHerbal.js') }}"></script>
@endsection