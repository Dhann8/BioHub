@extends('layout.base')

@section('content')

  <main class="pt-24 pb-20 px-4">
    <div class="max-w-7xl mx-auto">

      <!-- BREADCRUMB -->
      <nav aria-label="breadcrumb" class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('homepage') }}" class="hover:text-[#1E4D2B]">Beranda</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('satwa') }}" class="hover:text-[#1E4D2B]">Fauna Finder</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-gray-600 font-medium">{{ $fauna->local_name }}</span>
      </nav>

      <!-- HEADER SECTION -->
      <section class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 mb-8">
        <div class="grid lg:grid-cols-2">

          <!-- Image Gallery -->
          <div class="p-6 md:p-8">
            <div class="rounded-2xl overflow-hidden mb-4 aspect-[4/3]">
              <img id="main-img"
                class="w-full h-full object-cover"
                src="{{ $fauna->image_url ?? 'https://images.unsplash.com/photo-1551085254-e96b210db58a?auto=format&fit=crop&w=800&q=80' }}"
                alt="{{ $fauna->local_name }} ({{ $fauna->scientific_name }})" />
            </div>
            <div class="grid grid-cols-4 gap-3">
              <div class="aspect-square rounded-xl overflow-hidden thumb thumb-active"
                onclick="switchImage(this,'{{ $fauna->image_url }}','{{ $fauna->local_name }}')">
                <img class="w-full h-full object-cover"
                  src="{{ $fauna->image_url ?? 'https://images.unsplash.com/photo-1551085254-e96b210db58a?auto=format&fit=crop&w=800&q=80' }}"
                  alt="{{ $fauna->local_name }}" />
              </div>
              <div class="aspect-square rounded-xl overflow-hidden thumb"
                onclick="switchImage(this,'https://images.unsplash.com/photo-1534188753412-3e26d0d618d6?auto=format&fit=crop&w=800&q=80','Karakteristik habitat')">
                <img class="w-full h-full object-cover"
                  src="https://images.unsplash.com/photo-1534188753412-3e26d0d618d6?auto=format&fit=crop&w=800&q=80"
                  alt="Habitat" />
              </div>
              <div class="aspect-square rounded-xl overflow-hidden thumb"
                onclick="switchImage(this,'https://images.unsplash.com/photo-1574063413132-355dbfd83e0c?auto=format&fit=crop&w=800&q=80','Visual keunikan fisik')">
                <img class="w-full h-full object-cover"
                  src="https://images.unsplash.com/photo-1574063413132-355dbfd83e0c?auto=format&fit=crop&w=800&q=80"
                  alt="Fitur fisik" />
              </div>
              <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 flex items-center justify-center text-gray-400 cursor-pointer hover:bg-gray-200 transition">
                <i class="fa-solid fa-plus"></i>
              </div>
            </div>
          </div>

          <!-- Quick Info -->
          <div class="p-6 md:p-8 md:pl-0 flex flex-col justify-center">
            <div class="flex flex-wrap gap-2 mb-4">
              <span class="bg-[#B71C1C]/10 text-[#B71C1C] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest flex items-center gap-1.5">
                <i class="fa-solid fa-triangle-exclamation"></i> Status IUCN: {{ $fauna->iucn_status }}
              </span>
              <span class="bg-[#E8F5E9] text-[#1E4D2B] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">{{ $fauna->taxonomy->class_name ?? 'Fauna' }}</span>
              <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                {{ $fauna->locations->pluck('region_name')->implode(', ') ?: 'Indonesia' }}
              </span>
            </div>

            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-2">
              {{ $fauna->local_name }}
            </h1>
            <p class="text-lg italic text-gray-400 mb-6 font-medium">{{ $fauna->scientific_name }}</p>

            <p class="text-gray-600 leading-relaxed mb-8 max-w-xl">
              {{ $fauna->description }}
            </p>

            <div class="flex items-center gap-4 mb-8">
              <div class="flex items-center gap-2">
                <div class="flex -space-x-2">
                  <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80" class="w-8 h-8 rounded-full border-2 border-white" alt="kontributor">
                  <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80" class="w-8 h-8 rounded-full border-2 border-white" alt="kontributor">
                  <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=150&q=80" class="w-8 h-8 rounded-full border-2 border-white" alt="kontributor">
                </div>
                <span class="text-xs text-gray-500 font-medium">Dipantau oleh 3.2K+ Komunitas</span>
              </div>
              <div class="h-6 w-px bg-gray-200"></div>
              <div class="flex items-center gap-1 text-amber-500">
                <i class="fa-solid fa-star"></i>
                <span class="text-sm font-bold text-gray-900">4.8</span>
                <span class="text-xs text-gray-400 font-normal">(316 Ulasan)</span>
              </div>
            </div>

            <div class="flex flex-wrap gap-3">
              <button id="btn-simpan" class="bg-[#1E4D2B] hover:bg-[#0E2E1A] text-white font-bold px-8 py-3.5 rounded-2xl transition shadow-lg shadow-green-900/10 flex items-center gap-2">
                <i class="fa-solid fa-bookmark"></i> Simpan ke Koleksi
              </button>
              <button id="btn-bagikan" class="border-2 border-gray-100 hover:bg-gray-50 text-gray-600 font-bold px-6 py-3.5 rounded-2xl transition flex items-center gap-2">
                <i class="fa-solid fa-share-nodes"></i> Bagikan
              </button>
              <a href="tel:021-5724241" class="border-2 border-[#B71C1C]/30 text-[#B71C1C] hover:bg-[#B71C1C]/5 font-bold px-6 py-3.5 rounded-2xl transition flex items-center gap-2">
                <i class="fa-solid fa-phone"></i> Laporkan
              </a>
            </div>
          </div>
        </div>
      </section>

      <!-- TABBED CONTENT & SIDEBAR -->
      <div class="grid lg:grid-cols-3 gap-8">

        <!-- Left: Tabs -->
        <div class="lg:col-span-2">
          <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100">
            <!-- Tab Headers -->
            <div class="flex border-b border-gray-100 px-6 md:px-8 overflow-x-auto">
              <button type="button" onclick="openTab(event,'taksonomi')" class="tab-btn active px-5 py-5 text-sm font-semibold transition whitespace-nowrap">Profil & Taksonomi</button>
              <button type="button" onclick="openTab(event,'perilaku')"  class="tab-btn px-5 py-5 text-sm font-semibold transition whitespace-nowrap">Perilaku & Ekologi</button>
              <button type="button" onclick="openTab(event,'konservasi')" class="tab-btn px-5 py-5 text-sm font-semibold transition whitespace-nowrap">Konservasi</button>
              <button type="button" onclick="openTab(event,'ancaman')"   class="tab-btn px-5 py-5 text-sm font-semibold transition text-red-600 whitespace-nowrap">Ancaman</button>
            </div>

            <!-- Tab Content -->
            <div class="p-8 md:p-10">

              <!-- Tab 1: Taksonomi -->
              <div id="taksonomi" class="tab-content active">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Klasifikasi & Karakteristik Fisik</h2>
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                  <div>
                    <ul class="space-y-4">
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#1E4D2B] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Kingdom &amp; Filum</p>
                          <p class="text-sm text-gray-500">Animalia – Chordata</p>
                        </div>
                      </li>
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#1E4D2B] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Ordo &amp; Famili</p>
                          <p class="text-sm text-gray-500">Artiodactyla – Bovidae</p>
                        </div>
                      </li>
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#1E4D2B] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Genus &amp; Spesies</p>
                          <p class="text-sm text-gray-500">Bubalus depressicornis</p>
                        </div>
                      </li>
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#1E4D2B] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Ukuran &amp; Berat</p>
                          <p class="text-sm text-gray-500">Panjang 160–170 cm; tinggi bahu 60–100 cm; berat 150–300 kg</p>
                        </div>
                      </li>
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#1E4D2B] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Ciri Khas</p>
                          <p class="text-sm text-gray-500">Tanduk lurus, pendek, dan meruncing ke belakang. Kulit tebal berwarna coklat gelap hingga hitam.</p>
                        </div>
                      </li>
                    </ul>
                  </div>
                  <div class="rounded-2xl overflow-hidden border border-gray-100 h-56 relative">
                    <img class="w-full h-full object-cover"
                      src="https://images.unsplash.com/photo-1524661135-423995f22d0b?auto=format&fit=crop&w=800&q=80"
                      alt="Peta distribusi Anoa di Sulawesi" />
                    <div class="absolute inset-0 flex items-center justify-center bg-black/10">
                      <span class="bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-lg text-[10px] font-bold text-gray-700 shadow-sm border border-gray-200">
                        <i class="fa-solid fa-location-dot text-red-500 mr-1"></i> Peta Distribusi – Sulawesi
                      </span>
                    </div>
                  </div>
                </div>
                <p class="text-sm text-gray-600 leading-relaxed">
                  Anoa dataran rendah (<em>Bubalus depressicornis</em>) merupakan satu dari dua spesies Anoa yang ada, satunya adalah Anoa Pegunungan (<em>Bubalus quarlesi</em>). Kedua spesies ini hanya ditemukan di Pulau Sulawesi dan pulau-pulau kecil di sekitarnya, menjadikannya satwa endemik yang sangat penting bagi biodiversitas Indonesia.
                </p>
              </div>

              <!-- Tab 2: Perilaku -->
              <div id="perilaku" class="tab-content">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Perilaku, Habitat &amp; Pola Hidup</h2>
                <div class="space-y-6">
                  <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h3 class="font-bold text-[#1E4D2B] mb-2 flex items-center gap-2">
                      <i class="fa-solid fa-tree"></i> Habitat Alami
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                      Anoa dataran rendah mendiami hutan hujan primer dataran rendah hingga ketinggian 1.000 mdpl, terutama di dekat sumber air seperti sungai dan rawa-rawa. Mereka sangat bergantung pada kerapatan tutupan hutan sebagai perlindungan dari predator dan aktivitas manusia.
                    </p>
                  </div>
                  <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h3 class="font-bold text-[#1E4D2B] mb-2 flex items-center gap-2">
                      <i class="fa-solid fa-moon"></i> Aktivitas &amp; Pola Makan
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                      Bersifat krepuskular (aktif saat fajar dan senja) dan sangat pemalu. Satwa herbivora ini memakan rumput, pakis, dedaunan muda, tunas bambu, dan buah-buahan yang jatuh. Biasanya hidup soliter atau berpasangan.
                    </p>
                  </div>
                  <div class="p-4 border-l-4 border-blue-500 bg-blue-50 rounded-r-2xl">
                    <p class="text-xs text-blue-700 italic">
                      "Anoa memiliki siklus reproduksi yang lambat — satu anak per kelahiran dengan masa kehamilan sekitar 275–315 hari, menjadikannya sangat rentan terhadap kepunahan." — Jurnal Konservasi Satwa Liar Indonesia, 2021.
                    </p>
                  </div>
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-2">
                    <div class="bg-[#E8F5E9] p-4 rounded-2xl text-center">
                      <p class="text-2xl font-black text-[#1E4D2B]">~20</p>
                      <p class="text-xs text-gray-500 mt-1 font-medium">Thn Harapan Hidup</p>
                    </div>
                    <div class="bg-[#E8F5E9] p-4 rounded-2xl text-center">
                      <p class="text-2xl font-black text-[#1E4D2B]">1</p>
                      <p class="text-xs text-gray-500 mt-1 font-medium">Anak per Kelahiran</p>
                    </div>
                    <div class="bg-[#E8F5E9] p-4 rounded-2xl text-center">
                      <p class="text-2xl font-black text-[#1E4D2B]">300</p>
                      <p class="text-xs text-gray-500 mt-1 font-medium">Hari Masa Hamil</p>
                    </div>
                    <div class="bg-[#E8F5E9] p-4 rounded-2xl text-center">
                      <p class="text-xl font-black text-[#1E4D2B]">Soliter</p>
                      <p class="text-xs text-gray-500 mt-1 font-medium">Pola Sosial</p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Tab 3: Konservasi -->
              <div id="konservasi" class="tab-content">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Status Konservasi &amp; Upaya Perlindungan</h2>
                <div class="space-y-8">
                  <div class="flex items-center gap-6 bg-[#E65100]/5 border border-[#E65100]/20 p-6 rounded-2xl">
                    <div class="w-16 h-16 rounded-2xl bg-[#E65100] flex items-center justify-center text-white shrink-0 shadow-lg">
                      <span class="font-black text-xl">EN</span>
                    </div>
                    <div>
                      <p class="text-xs font-black text-[#E65100] uppercase tracking-widest mb-1">Status IUCN Red List</p>
                      <h3 class="text-lg font-black text-gray-900">Endangered (Terancam)</h3>
                      <p class="text-sm text-gray-500">Penurunan populasi &gt;50% dalam 3 generasi terakhir. Populasi liar diperkirakan kurang dari 2.500 individu dewasa.</p>
                    </div>
                  </div>
                  <div>
                    <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                      <span class="w-6 h-6 rounded-full bg-[#1E4D2B] text-white text-[10px] flex items-center justify-center">1</span>
                      Perlindungan Hukum di Indonesia
                    </h3>
                    <p class="text-sm text-gray-600 mb-3">Dilindungi penuh oleh UU No. 5 Tahun 1990 tentang Konservasi SDAH dan PP No. 7 Tahun 1999. Perburuan atau perdagangan Anoa diancam hukuman penjara hingga 5 tahun dan denda Rp100 juta.</p>
                  </div>
                  <div>
                    <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                      <span class="w-6 h-6 rounded-full bg-[#1E4D2B] text-white text-[10px] flex items-center justify-center">2</span>
                      Program Penangkaran &amp; Riset
                    </h3>
                    <ul class="list-disc list-inside text-sm text-gray-600 space-y-2">
                      <li>Penangkaran ex-situ di Taman Safari Indonesia dan kebun binatang terakreditasi.</li>
                      <li>Program monitoring populasi liar di TN Bogani Nani Wartabone, Sulawesi Utara.</li>
                      <li>Kerjasama riset dengan BRIN dan Wildlife Conservation Society (WCS) Indonesia.</li>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- Tab 4: Ancaman -->
              <div id="ancaman" class="tab-content">
                <h2 class="text-xl font-bold text-red-600 mb-6">Ancaman Utama &amp; Faktor Kepunahan</h2>
                <div class="space-y-6">
                  <div class="danger-box bg-[#B71C1C]/5 p-6 rounded-r-2xl">
                    <h3 class="font-bold text-[#B71C1C] mb-2 flex items-center gap-2">
                      <i class="fa-solid fa-crosshairs"></i> Perburuan Liar (Poaching)
                    </h3>
                    <p class="text-sm text-[#B71C1C]/80 leading-relaxed">
                      Ancaman terbesar bagi kelangsungan hidup Anoa. Diburu untuk dagingnya, tanduknya sebagai trofi, serta dijual sebagai hewan peliharaan ilegal. Harga seekor Anoa di pasar gelap bisa mencapai puluhan juta rupiah.
                    </p>
                  </div>
                  <div class="warning-box bg-[#FEF3C7] p-6 rounded-r-2xl">
                    <h3 class="font-bold text-[#B45309] mb-2 flex items-center gap-2">
                      <i class="fa-solid fa-tree-city"></i> Kehilangan &amp; Fragmentasi Habitat
                    </h3>
                    <p class="text-sm text-[#B45309] opacity-80 leading-relaxed">
                      Alih fungsi hutan primer menjadi lahan pertanian, perkebunan sawit, dan pemukiman memotong jalur jelajah Anoa dan mengisolasi populasi, menghambat pertukaran genetik antar kelompok.
                    </p>
                  </div>
                  <div class="warning-box bg-[#FEF3C7] p-6 rounded-r-2xl">
                    <h3 class="font-bold text-[#B45309] mb-2 flex items-center gap-2">
                      <i class="fa-solid fa-virus"></i> Penyakit &amp; Kompetisi
                    </h3>
                    <p class="text-sm text-[#B45309] opacity-80 leading-relaxed">
                      Kontak dengan hewan ternak meningkatkan risiko penularan penyakit seperti Foot-and-Mouth Disease. Kompetisi dengan ternak juga mengurangi ketersediaan pakan alami di kawasan tepi hutan.
                    </p>
                  </div>
                  <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h3 class="text-sm font-bold text-gray-800 mb-2">Laju Penurunan Populasi</h3>
                    <p class="text-sm text-gray-500">Diperkirakan populasi Anoa dataran rendah menurun lebih dari 20% setiap dekade. Tanpa intervensi serius, spesies ini berpotensi masuk kategori Critically Endangered (CR) dalam 10–20 tahun ke depan.</p>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

        <!-- Right: Sidebar -->
        <div class="space-y-8">

          <!-- Related Animals -->
          <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
            <h3 class="text-lg font-black text-gray-900 mb-6">Satwa Terkait</h3>
            <div class="space-y-4">
              @foreach($relatedFaunas as $related)
                <a href="{{ route('detail-satwa', $related->id) }}" class="flex items-center gap-4 group">
                  <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                      src="{{ $related->image_url ?? 'https://images.unsplash.com/photo-1551085254-e96b210db58a?auto=format&fit=crop&w=800&q=80' }}"
                      alt="{{ $related->local_name }}" />
                  </div>
                  <div>
                    <h4 class="text-sm font-bold text-gray-800 group-hover:text-[#1E4D2B] transition">{{ $related->local_name }}</h4>
                    <p class="text-xs text-gray-400 italic">{{ $related->scientific_name }}</p>
                    <span class="text-[10px] font-bold text-[#E65100] bg-[#E65100]/10 px-2 py-0.5 rounded-full mt-1 inline-block">{{ $related->iucn_status }}</span>
                  </div>
                </a>
              @endforeach
            </div>
            <a href="{{ route('satwa') }}" class="w-full mt-6 text-[#1E4D2B] font-bold text-sm py-3 rounded-xl bg-[#E8F5E9] hover:bg-[#1E4D2B] hover:text-white transition flex items-center justify-center gap-2">
              <i class="fa-solid fa-list"></i> Lihat Semua Database
            </a>
          </div>

          <!-- Hotline Widget -->
          <div class="bg-[#B71C1C] rounded-3xl p-8 text-white relative overflow-hidden">
            <div class="absolute -right-6 -bottom-6 w-40 h-40 bg-white/5 rounded-full"></div>
            <div class="absolute -right-2 -top-4 w-24 h-24 bg-white/5 rounded-full"></div>
            <div class="relative z-10">
              <div class="w-12 h-12 rounded-2xl bg-white/20 flex items-center justify-center mb-4">
                <i class="fa-solid fa-bullhorn text-xl animate-pulse"></i>
              </div>
              <h3 class="text-lg font-black mb-2">Lihat Satwa Terancam?</h3>
              <p class="text-sm text-white/80 mb-6 leading-relaxed">Jika Anda melihat Anoa atau satwa dilindungi lainnya dalam kondisi berbahaya, segera laporkan ke otoritas berwenang.</p>
              <a href="tel:021-5724241" id="hotline-btn" class="w-full bg-white text-[#B71C1C] font-bold py-3 rounded-xl text-sm hover:bg-gray-100 transition shadow-lg shadow-black/10 flex items-center justify-center gap-2">
                <i class="fa-solid fa-phone"></i> Hotline BKSDA: 021-5724241
              </a>
            </div>
          </div>

          <!-- Contribution Widget -->
          <div class="bg-[#1E4D2B] rounded-3xl p-8 text-white relative overflow-hidden">
            <img class="absolute inset-0 w-full h-full object-cover opacity-10"
              src="https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?auto=format&fit=crop&w=1600&q=80"
              alt="Ilustrasi sketsa satwa liar Indonesia" />
            <div class="relative z-10">
              <h3 class="text-lg font-black mb-2">Bantu Kami Berbenah</h3>
              <p class="text-sm text-white/80 mb-6 leading-relaxed">Punya data lapangan atau riset terbaru tentang Anoa? Kontribusikan informasi Anda untuk melengkapi database kami.</p>
              <button id="btn-saran" class="w-full bg-white text-[#1E4D2B] font-bold py-3 rounded-xl text-sm hover:bg-gray-100 transition shadow-lg shadow-black/10">
                Saran Pembaruan Data
              </button>
            </div>
          </div>

        </div>
      </div>

    </div>
  </main>


  <script src="{{ asset('js/DetailSatwa.js') }}"></script>

@endsection