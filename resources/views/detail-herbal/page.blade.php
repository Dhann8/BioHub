@extends('layout.base')
@section('content')

<main class="pt-24 pb-20 px-4">
    <div class="max-w-7xl mx-auto">
      
      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="homepage.html" class="hover:text-[#2E7D32]">Beranda</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="herbal.html" class="hover:text-[#2E7D32]">Database Herbal</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-gray-600 font-medium">Kunyit</span>
      </nav>

      <!-- HEADER SECTION -->
      <section class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 mb-8">
        <div class="grid lg:grid-cols-2">
          <!-- Image Gallery -->
          <div class="p-6 md:p-8">
            <div class="rounded-2xl overflow-hidden mb-4 aspect-[4/3]">
              <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1615485500704-8e990f9900f7?auto=format&fit=crop&w=800&q=80" alt="fresh turmeric roots and sliced turmeric pieces, vibrant orange color, high resolution botanical pho" />
            </div>
            <div class="grid grid-cols-4 gap-3">
              <div class="aspect-square rounded-xl overflow-hidden border-2 border-[#2E7D32]">
                <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1520412099551-62b6bafeb5bb?auto=format&fit=crop&w=800&q=80" alt="turmeric plant leaves Curcuma longa, green lush foliage" />
              </div>
              <div class="aspect-square rounded-xl overflow-hidden opacity-60 hover:opacity-100 transition cursor-pointer">
                <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1465146344425-f00d5f5c8f07?auto=format&fit=crop&w=800&q=80" alt="turmeric flowers Curcuma longa, white and yellow petals" />
              </div>
              <div class="aspect-square rounded-xl overflow-hidden opacity-60 hover:opacity-100 transition cursor-pointer">
                <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1615485290382-441e4d049cb5?auto=format&fit=crop&w=800&q=80" alt="dried turmeric powder in a wooden bowl" />
              </div>
              <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 flex items-center justify-center text-gray-400">
                <i class="fa-solid fa-plus"></i>
              </div>
            </div>
          </div>

          <!-- Quick Info -->
          <div class="p-6 md:p-8 md:pl-0 flex flex-col justify-center">
            <div class="flex flex-wrap gap-2 mb-4">
              <span class="bg-[#E8F5E9] text-[#2E7D32] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Tanaman Obat</span>
              <span class="bg-[#FEF3C7] text-[#D97706] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Aman</span>
              <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Endemik Asia</span>
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-2">Kunyit <span class="text-[#D97706]">(Curcuma)</span></h1>
            <p class="text-lg italic text-gray-400 mb-6 font-medium">Curcuma longa L.</p>
            
            <p class="text-gray-600 leading-relaxed mb-8 max-w-xl">
              Kunyit adalah tanaman rempah-rempah dan obat asli dari wilayah Asia Tenggara. Tanaman ini merupakan salah satu komponen utama dalam ramuan Jamu tradisional Indonesia karena kandungan kurkuminnya yang kaya akan manfaat kesehatan.
            </p>

            <div class="flex items-center gap-4 mb-8">
              <div class="flex items-center gap-2">
                <div class="flex -space-x-2">
                  <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80" class="w-8 h-8 rounded-full border-2 border-white" alt="voter">
                  <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80" class="w-8 h-8 rounded-full border-2 border-white" alt="voter">
                  <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80" class="w-8 h-8 rounded-full border-2 border-white" alt="voter">
                </div>
                <span class="text-xs text-gray-500 font-medium">Dipercaya oleh 12K+ Pengguna</span>
              </div>
              <div class="h-6 w-px bg-gray-200"></div>
              <div class="flex items-center gap-1 text-amber-500">
                <i class="fa-solid fa-star"></i>
                <span class="text-sm font-bold text-gray-900">4.9</span>
                <span class="text-xs text-gray-400 font-normal">(842 Ulasan)</span>
              </div>
            </div>

            <div class="flex flex-wrap gap-3">
              <button class="bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-bold px-8 py-3.5 rounded-2xl transition shadow-lg shadow-green-900/10 flex items-center gap-2">
                <i class="fa-solid fa-bookmark"></i> Simpan ke Koleksi
              </button>
              <button class="border-2 border-gray-100 hover:bg-gray-50 text-gray-600 font-bold px-6 py-3.5 rounded-2xl transition flex items-center gap-2">
                <i class="fa-solid fa-share-nodes"></i> Bagikan
              </button>
            </div>
          </div>
        </div>
      </section>

      <!-- TABBED CONTENT & SIDEBAR -->
      <div class="grid lg:grid-cols-3 gap-8">
        <!-- Left: Tabs Section -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100">
            <!-- Tab Headers -->
            <div class="flex border-b border-gray-100 px-6 md:px-8">
              <button onclick="openTab(event, 'botany')" class="tab-btn active px-6 py-5 text-sm font-semibold transition">Profil Botani</button>
              <button onclick="openTab(event, 'benefits')" class="tab-btn px-6 py-5 text-sm font-semibold transition">Manfaat & Riset</button>
              <button onclick="openTab(event, 'preparation')" class="tab-btn px-6 py-5 text-sm font-semibold transition">Cara Racik</button>
              <button onclick="openTab(event, 'safety')" class="tab-btn px-6 py-5 text-sm font-semibold transition text-red-500">Peringatan</button>
            </div>

            <!-- Tab Content -->
            <div class="p-8 md:p-10">
              
              <!-- Tab 1: Botany -->
              <div id="botany" class="tab-content active">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Karakteristik & Habitat</h3>
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                  <div>
                    <ul class="space-y-4">
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#2E7D32] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Genus & Famili</p>
                          <p class="text-sm text-gray-500">Curcuma, Zingiberaceae</p>
                        </div>
                      </li>
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#2E7D32] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Ciri Fisik</p>
                          <p class="text-sm text-gray-500">Batang semu, tinggi 40-100 cm. Rimpang berwarna oranye cerah.</p>
                        </div>
                      </li>
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#2E7D32] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Lingkungan Tumbuh</p>
                          <p class="text-sm text-gray-500">Dataran rendah hingga 1600 mdpl. Curah hujan 2000-4000 mm/tahun.</p>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="rounded-2xl overflow-hidden border border-gray-100 h-48 relative">
                    <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=800&q=80" alt="stylized map of indonesia showing turmeric distribution hotspots in Sumatra Java and Sulawesi, soft " />
                    <div class="absolute inset-0 flex items-center justify-center bg-black/10">
                      <span class="bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-lg text-[10px] font-bold text-gray-700 shadow-sm border border-gray-200">
                        <i class="fa-solid fa-location-dot text-red-500 mr-1"></i> Peta Distribusi
                      </span>
                    </div>
                  </div>
                </div>
                <p class="text-sm text-gray-600 leading-relaxed">
                  Kunyit berkembang biak dengan rimpang. Membutuhkan tanah yang gembur, subur, dan sedikit naungan untuk pertumbuhan optimal. Di Indonesia, sentra produksi utama berada di Jawa Tengah dan Jawa Timur.
                </p>
              </div>

              <!-- Tab 2: Benefits -->
              <div id="benefits" class="tab-content">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Manfaat Kesehatan & Bukti Ilmiah</h3>
                <div class="space-y-6">
                  <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h4 class="font-bold text-[#2E7D32] mb-2 flex items-center gap-2">
                      <i class="fa-solid fa-shield-virus"></i> Anti-Inflamasi Alami
                    </h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                      Kurkumin dalam kunyit adalah senyawa bioaktif yang memiliki sifat anti-inflamasi yang sangat kuat, sebanding dengan beberapa obat anti-inflamasi komersial tanpa efek samping sistemik.
                    </p>
                  </div>
                  <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h4 class="font-bold text-[#2E7D32] mb-2 flex items-center gap-2">
                      <i class="fa-solid fa-flask"></i> Antioksidan Tinggi
                    </h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                      Membantu menetralisir radikal bebas dan meningkatkan aktivitas enzim antioksidan dalam tubuh kita sendiri untuk melawan penuaan dini dan penyakit kronis.
                    </p>
                  </div>
                  <div class="p-4 border-l-4 border-blue-500 bg-blue-50">
                    <p class="text-xs text-blue-700 italic">
                      "Studi meta-analisis pada 2019 menunjukkan bahwa kurkumin efektif meredakan gejala nyeri sendi (osteoarthritis) secara signifikan." - Jurnal Kedokteran Indonesia.
                    </p>
                  </div>
                </div>
              </div>

              <!-- Tab 3: Preparation -->
              <div id="preparation" class="tab-content">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Cara Pengolahan & Dosis</h3>
                <div class="space-y-8">
                  <div>
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                      <span class="w-6 h-6 rounded-full bg-[#2E7D32] text-white text-[10px] flex items-center justify-center">1</span>
                      Minuman Jamu Kunyit Asam
                    </h4>
                    <p class="text-sm text-gray-600 mb-3">Rebus 2 rimpang kunyit (parut) dengan 500ml air, tambahkan asam jawa dan gula merah secukupnya.</p>
                    <div class="flex items-center gap-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">
                      <span><i class="fa-solid fa-clock mr-1"></i> 15 Menit</span>
                      <span><i class="fa-solid fa-fire mr-1"></i> Sedang</span>
                    </div>
                  </div>
                  <div>
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                      <span class="w-6 h-6 rounded-full bg-[#2E7D32] text-white text-[10px] flex items-center justify-center">2</span>
                      Dosis Keamanan
                    </h4>
                    <ul class="list-disc list-inside text-sm text-gray-600 space-y-2">
                      <li>Bubuk: 1.5 - 3 gram per hari.</li>
                      <li>Rimpang segar: 5 - 10 gram per hari.</li>
                      <li>Sebaiknya dikonsumsi setelah makan.</li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Tab 4: Safety -->
              <div id="safety" class="tab-content">
                <h3 class="text-xl font-bold text-red-600 mb-6">Kontraindikasi & Efek Samping</h3>
                <div class="space-y-6">
                  <div class="warning-box bg-[#FEF3C7] p-6 rounded-r-2xl">
                    <h4 class="font-bold text-[#B45309] mb-2 flex items-center gap-2">
                      <i class="fa-solid fa-triangle-exclamation"></i> Interaksi Obat
                    </h4>
                    <p class="text-sm text-[#B45309] opacity-80 leading-relaxed">
                      Kunyit dapat mengencerkan darah. Hindari konsumsi dalam dosis besar jika Anda sedang dalam pengobatan pengencer darah (Warfarin, Aspirin) atau akan menjalani operasi.
                    </p>
                  </div>
                  <div class="warning-box bg-[#FEF3C7] p-6 rounded-r-2xl">
                    <h4 class="font-bold text-[#B45309] mb-2 flex items-center gap-2">
                      <i class="fa-solid fa-person-pregnant"></i> Ibu Hamil & Menyusui
                    </h4>
                    <p class="text-sm text-[#B45309] opacity-80 leading-relaxed">
                      Konsumsi sebagai bumbu masakan aman, namun suplemen kunyit dosis tinggi tidak disarankan karena dapat merangsang kontraksi rahim.
                    </p>
                  </div>
                  <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h4 class="text-sm font-bold text-gray-800 mb-2">Efek Samping Umum (Langka)</h4>
                    <p class="text-sm text-gray-500">Mual, pusing, atau sakit perut jika dikonsumsi dalam dosis yang sangat berlebihan.</p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <!-- Right: Sidebar Widget -->
        <div class="space-y-8">
          <!-- Related Plants -->
          <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
            <h3 class="text-lg font-black text-gray-900 mb-6">Herbal Terkait</h3>
            <div class="space-y-4">
              <a href="detail-herbal.html" class="flex items-center gap-4 group">
                <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0">
                  <img class="w-full h-full object-cover group-hover:scale-110 transition duration-300" src="https://images.unsplash.com/photo-1509358271058-acd05cc93898?auto=format&fit=crop&w=800&q=80" alt="fresh temulawak curcuma zanthorrhiza rhizome roots" />
                </div>
                <div>
                  <h4 class="text-sm font-bold text-gray-800 group-hover:text-[#2E7D32] transition">Temulawak</h4>
                  <p class="text-xs text-gray-400 italic">Curcuma zanthorrhiza</p>
                </div>
              </a>
              <a href="detail-herbal.html" class="flex items-center gap-4 group">
                <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0">
                  <img class="w-full h-full object-cover group-hover:scale-110 transition duration-300" src="https://images.unsplash.com/photo-1540420773420-3366772f4999?auto=format&fit=crop&w=800&q=80" alt="kaempferia galanga kencur aromatic ginger roots" />
                </div>
                <div>
                  <h4 class="text-sm font-bold text-gray-800 group-hover:text-[#2E7D32] transition">Kencur</h4>
                  <p class="text-xs text-gray-400 italic">Kaempferia galanga</p>
                </div>
              </a>
              <a href="detail-herbal.html" class="flex items-center gap-4 group">
                <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0">
                  <img class="w-full h-full object-cover group-hover:scale-110 transition duration-300" src="https://images.unsplash.com/photo-1615485290382-441e4d049cb5?auto=format&fit=crop&w=800&q=80" alt="alpinia galanga lengkuas galangal roots" />
                </div>
                <div>
                  <h4 class="text-sm font-bold text-gray-800 group-hover:text-[#2E7D32] transition">Lengkuas</h4>
                  <p class="text-xs text-gray-400 italic">Alpinia galanga</p>
                </div>
              </a>
            </div>
            <a href="herbal.html" class="w-full mt-6 text-[#2E7D32] font-bold text-sm py-3 rounded-xl bg-[#E8F5E9] hover:bg-[#2E7D32] hover:text-white transition text-center flex items-center justify-center">
              Lihat Semua Database
            </a>
          </div>

          <!-- Contribution Widget -->
          <div class="bg-[#2E7D32] rounded-3xl p-8 text-white relative overflow-hidden">
            <img class="absolute inset-0 w-full h-full object-cover opacity-10" src="https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?auto=format&fit=crop&w=1600&q=80" alt="botanical drawing of plants in white outline on green background" />
            <div class="relative z-10">
              <h3 class="text-lg font-black mb-2">Bantu Kami Berbenah</h3>
              <p class="text-sm text-white/80 mb-6 leading-relaxed">Punya riset terbaru atau info tambahan tentang Kunyit? Laporkan perubahan data di sini.</p>
              <button class="w-full bg-white text-[#2E7D32] font-bold py-3 rounded-xl text-sm hover:bg-gray-100 transition shadow-lg shadow-black/10">
                Saran Pembaruan
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>
@endsection