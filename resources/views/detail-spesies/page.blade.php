@extends('layout.base')

@section('content')

  <main class="pt-24 pb-20 px-4">
    <div class="max-w-7xl mx-auto">

      <!-- BREADCRUMB -->
      <nav aria-label="breadcrumb" class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('homepage') }}" class="hover:text-[#1E4D2B]">Beranda</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('spesies') }}" class="hover:text-[#1E4D2B]">Fauna Finder</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-gray-600 font-medium">{{ $fauna->local_name }}</span>
      </nav>

      <!-- HEADER SECTION -->
      <section class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 mb-8">
        <div class="grid lg:grid-cols-2">

          <!-- Image Gallery -->
          <div class="p-6 md:p-8">
            <div class="rounded-2xl overflow-hidden mb-4 aspect-[4/3]">
              <img id="main-img" class="w-full h-full object-cover"
                src="{{ $fauna->image_url ?? asset('images/default-fauna.jpg') }}"
                alt="{{ $fauna->local_name }} ({{ $fauna->scientific_name }})" />
            </div>

            <!-- Gallery Thumbnails -->
            <div class="grid grid-cols-4 gap-3">
              <!-- Main Image Thumb -->
              <div class="aspect-square rounded-xl overflow-hidden thumb thumb-active cursor-pointer"
                onclick="switchImage(this, '{{ $fauna->image_url ?? asset('images/default-fauna.jpg') }}', '{{ $fauna->local_name }}')">
                <img class="w-full h-full object-cover" src="{{ $fauna->image_url ?? asset('images/default-fauna.jpg') }}"
                  alt="{{ $fauna->local_name }}" />
              </div>

              <!-- Loop Additional Images / Gallery (If available) -->
              @if(isset($fauna->gallery) && count($fauna->gallery) > 0)
                @foreach($fauna->gallery->take(2) as $galleryItem)
                  <div class="aspect-square rounded-xl overflow-hidden thumb cursor-pointer"
                    onclick="switchImage(this, '{{ $galleryItem->image_url }}', '{{ $galleryItem->caption ?? $fauna->local_name }}')">
                    <img class="w-full h-full object-cover" src="{{ $galleryItem->image_url }}"
                      alt="{{ $galleryItem->caption ?? 'Galeri' }}" />
                  </div>
                @endforeach
              @endif

              <div
                class="aspect-square rounded-xl overflow-hidden bg-gray-100 flex items-center justify-center text-gray-400 cursor-pointer hover:bg-gray-200 transition">
                <i class="fa-solid fa-plus"></i>
              </div>
            </div>
          </div>

          <!-- Quick Info -->
          <div class="p-6 md:p-8 md:pl-0 flex flex-col justify-center">
            <div class="flex flex-wrap gap-2 mb-4">
              <span
                class="bg-[#B71C1C]/10 text-[#B71C1C] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest flex items-center gap-1.5">
                <i class="fa-solid fa-triangle-exclamation"></i> Status IUCN:
                {{ $fauna->iucn_status ?? 'Tidak Diketahui' }}
              </span>
              <span
                class="bg-[#E8F5E9] text-[#1E4D2B] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                {{ $fauna->taxonomy->class_name ?? 'Fauna' }}
              </span>
              <span
                class="bg-gray-100 text-gray-500 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">
                {{ $fauna->locations ? $fauna->locations->pluck('region_name')->implode(', ') : 'Indonesia' }}
              </span>
            </div>

            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-2">
              {{ $fauna->local_name }}
            </h1>
            <p class="text-lg italic text-gray-400 mb-6 font-medium">{{ $fauna->scientific_name }}</p>

            <p class="text-gray-600 leading-relaxed mb-8 max-w-xl">
              {{ $fauna->description ?? 'Belum ada deskripsi singkat untuk spesies ini.' }}
            </p>

            <!-- Community Info / Rating -->
            <div class="flex items-center gap-4 mb-8">
              <div class="flex items-center gap-2">
                <span class="text-xs text-gray-500 font-medium">
                  <i class="fa-solid fa-[#1E4D2B] fa-eye mr-1"></i> Dilihat {{ number_format($fauna->views_count ?? 0) }}x
                </span>
              </div>
              @if(isset($fauna->rating))
                <div class="h-6 w-px bg-gray-200"></div>
                <div class="flex items-center gap-1 text-amber-500">
                  <i class="fa-solid fa-star"></i>
                  <span class="text-sm font-bold text-gray-900">{{ number_format($fauna->rating, 1) }}</span>
                  <span class="text-xs text-gray-400 font-normal">({{ $fauna->reviews_count ?? 0 }} Ulasan)</span>
                </div>
              @endif
            </div>

            <div class="flex flex-wrap gap-3">
              <button id="btn-simpan" data-id="{{ $fauna->id }}"
                class="bg-[#1E4D2B] hover:bg-[#0E2E1A] text-white font-bold px-8 py-3.5 rounded-2xl transition shadow-lg shadow-green-900/10 flex items-center gap-2">
                <i class="fa-solid fa-bookmark"></i> Simpan ke Koleksi
              </button>
              <button id="btn-bagikan"
                class="border-2 border-gray-100 hover:bg-gray-50 text-gray-600 font-bold px-6 py-3.5 rounded-2xl transition flex items-center gap-2">
                <i class="fa-solid fa-share-nodes"></i> Bagikan
              </button>
              <a href="tel:021-5724241"
                class="border-2 border-[#B71C1C]/30 text-[#B71C1C] hover:bg-[#B71C1C]/5 font-bold px-6 py-3.5 rounded-2xl transition flex items-center gap-2">
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
              <button type="button" onclick="openTab(event,'taksonomi')"
                class="tab-btn active px-5 py-5 text-sm font-semibold transition whitespace-nowrap">Profil &
                Taksonomi</button>
              <button type="button" onclick="openTab(event,'perilaku')"
                class="tab-btn px-5 py-5 text-sm font-semibold transition whitespace-nowrap">Perilaku & Ekologi</button>
              <button type="button" onclick="openTab(event,'konservasi')"
                class="tab-btn px-5 py-5 text-sm font-semibold transition whitespace-nowrap">Konservasi</button>
              <button type="button" onclick="openTab(event,'ancaman')"
                class="tab-btn px-5 py-5 text-sm font-semibold transition text-red-600 whitespace-nowrap">Ancaman</button>
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
                          <p class="text-sm text-gray-500">{{ $fauna->taxonomy->kingdom ?? 'Animalia' }} â€“
                            {{ $fauna->taxonomy->phylum ?? 'Chordata' }}</p>
                        </div>
                      </li>
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#1E4D2B] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Ordo &amp; Famili</p>
                          <p class="text-sm text-gray-500">{{ $fauna->taxonomy->order ?? '-' }} â€“
                            {{ $fauna->taxonomy->family ?? '-' }}</p>
                        </div>
                      </li>
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#1E4D2B] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Genus &amp; Spesies</p>
                          <p class="text-sm text-gray-500"><em>{{ $fauna->scientific_name }}</em></p>
                        </div>
                      </li>
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#1E4D2B] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Ukuran &amp; Berat</p>
                          <p class="text-sm text-gray-500">
                            {{ $fauna->physicalCharacteristics->size_and_weight ?? 'Data belum tersedia' }}</p>
                        </div>
                      </li>
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#1E4D2B] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Ciri Khas</p>
                          <p class="text-sm text-gray-500">
                            {{ $fauna->physicalCharacteristics->distinctive_features ?? 'Data belum tersedia' }}</p>
                        </div>
                      </li>
                    </ul>
                  </div>

                  <!-- Map / Distribution -->
                  <div class="rounded-2xl overflow-hidden border border-gray-100 h-56 relative group">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                      src="{{ $fauna->map_image_url ?? asset('images/default-map.jpg') }}"
                      alt="Peta distribusi {{ $fauna->local_name }}" />
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/20 gap-2">
                      <span
                        class="bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-lg text-[10px] font-bold text-gray-700 shadow-sm border border-gray-200">
                        <i class="fa-solid fa-location-dot text-red-500 mr-1"></i> Peta Distribusi:
                        {{ $fauna->locations->pluck('region_name')->first() ?? 'Indonesia' }}
                      </span>
                      <a href="{{ route('map', ['species' => 'fauna_' . $fauna->id]) }}" class="bg-[#1E4D2B] hover:bg-[#0E2E1A] text-white text-xs font-bold px-4 py-2 rounded-xl shadow-lg transition flex items-center gap-1.5 backdrop-blur-sm">
                        <i class="fa-solid fa-map-location-dot"></i> Buka di Peta Interaktif
                      </a>
                    </div>
                  </div>
                </div>

                <div class="text-sm text-gray-600 leading-relaxed space-y-3">
                  {!! nl2br(e($fauna->taxonomy_description ?? $fauna->description)) !!}
                </div>
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
                      {{ $fauna->ecologicalInfo->habitat_description ?? 'Informasi habitat belum tersedia.' }}
                    </p>
                  </div>

                  <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h3 class="font-bold text-[#1E4D2B] mb-2 flex items-center gap-2">
                      <i class="fa-solid fa-moon"></i> Aktivitas &amp; Pola Makan
                    </h3>
                    <p class="text-sm text-gray-600 leading-relaxed">
                      {{ $fauna->ecologicalInfo->diet_and_behavior ?? 'Informasi diet dan aktivitas belum tersedia.' }}
                    </p>
                  </div>

                  @if(!empty($fauna->ecologicalInfo->quote))
                    <div class="p-4 border-l-4 border-blue-500 bg-blue-50 rounded-r-2xl">
                      <p class="text-xs text-blue-700 italic">
                        "{{ $fauna->ecologicalInfo->quote }}"
                      </p>
                    </div>
                  @endif

                  <!-- Stats Grid -->
                  <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-2">
                    <div class="bg-[#E8F5E9] p-4 rounded-2xl text-center">
                      <p class="text-2xl font-black text-[#1E4D2B]">{{ $fauna->lifespan ?? '-' }}</p>
                      <p class="text-xs text-gray-500 mt-1 font-medium">Thn Harapan Hidup</p>
                    </div>
                    <div class="bg-[#E8F5E9] p-4 rounded-2xl text-center">
                      <p class="text-2xl font-black text-[#1E4D2B]">{{ $fauna->offspring_count ?? '-' }}</p>
                      <p class="text-xs text-gray-500 mt-1 font-medium">Anak per Kelahiran</p>
                    </div>
                    <div class="bg-[#E8F5E9] p-4 rounded-2xl text-center">
                      <p class="text-2xl font-black text-[#1E4D2B]">{{ $fauna->gestation_period ?? '-' }}</p>
                      <p class="text-xs text-gray-500 mt-1 font-medium">Hari Masa Hamil</p>
                    </div>
                    <div class="bg-[#E8F5E9] p-4 rounded-2xl text-center">
                      <p class="text-xl font-black text-[#1E4D2B]">{{ $fauna->social_pattern ?? '-' }}</p>
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
                    <div
                      class="w-16 h-16 rounded-2xl bg-[#E65100] flex items-center justify-center text-white shrink-0 shadow-lg">
                      <span class="font-black text-xl">{{ $fauna->iucn_code ?? 'IUCN' }}</span>
                    </div>
                    <div>
                      <p class="text-xs font-black text-[#E65100] uppercase tracking-widest mb-1">Status IUCN Red List</p>
                      <h3 class="text-lg font-black text-gray-900">{{ $fauna->iucn_status }}</h3>
                      <p class="text-sm text-gray-500">
                        {{ $fauna->iucn_description ?? 'Data rinci mengenai populasi liar sedang diperbarui.' }}</p>
                    </div>
                  </div>

                  <div>
                    <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                      <span
                        class="w-6 h-6 rounded-full bg-[#1E4D2B] text-white text-[10px] flex items-center justify-center">1</span>
                      Perlindungan Hukum di Indonesia
                    </h3>
                    <p class="text-sm text-gray-600 mb-3">
                      {{ $fauna->legal_status ?? 'Dilindungi oleh peraturan perundang-undangan Republik Indonesia terkait konservasi sumber daya alam dan ekosistemnya.' }}
                    </p>
                  </div>

                  <div>
                    <h3 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                      <span
                        class="w-6 h-6 rounded-full bg-[#1E4D2B] text-white text-[10px] flex items-center justify-center">2</span>
                      Program Penangkaran &amp; Riset
                    </h3>
                    @if(isset($fauna->conservationPrograms) && $fauna->conservationPrograms->count() > 0)
                      <ul class="list-disc list-inside text-sm text-gray-600 space-y-2">
                        @foreach($fauna->conservationPrograms as $program)
                          <li>{{ $program->title_or_description }}</li>
                        @endforeach
                      </ul>
                    @else
                      <p class="text-sm text-gray-500 italic">Belum ada data program konservasi yang terdaftar.</p>
                    @endif
                  </div>
                </div>
              </div>

              <!-- Tab 4: Ancaman -->
              <div id="ancaman" class="tab-content">
                <h2 class="text-xl font-bold text-red-600 mb-6">Ancaman Utama &amp; Faktor Kepunahan</h2>
                <div class="space-y-6">
                  @if(isset($fauna->threats) && $fauna->threats->count() > 0)
                    @foreach($fauna->threats as $threat)
                      <div
                        class="{{ $loop->first ? 'danger-box bg-[#B71C1C]/5' : 'warning-box bg-[#FEF3C7]' }} p-6 rounded-r-2xl">
                        <h3
                          class="font-bold {{ $loop->first ? 'text-[#B71C1C]' : 'text-[#B45309]' }} mb-2 flex items-center gap-2">
                          <i class="{{ $threat->icon ?? 'fa-solid fa-triangle-exclamation' }}"></i> {{ $threat->title }}
                        </h3>
                        <p
                          class="text-sm {{ $loop->first ? 'text-[#B71C1C]/80' : 'text-[#B45309] opacity-80' }} leading-relaxed">
                          {{ $threat->description }}
                        </p>
                      </div>
                    @endforeach
                  @else
                    <p class="text-sm text-gray-500 italic">Data ancaman belum dimasukkan.</p>
                  @endif

                  @if(!empty($fauna->population_trend))
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                      <h3 class="text-sm font-bold text-gray-800 mb-2">Laju Penurunan Populasi</h3>
                      <p class="text-sm text-gray-500">{{ $fauna->population_trend }}</p>
                    </div>
                  @endif
                </div>
              </div>

            </div>
          </div>
        </div>

        <!-- Right: Sidebar -->
        <div class="space-y-8">

          <!-- Related Animals -->
          <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
            <h3 class="text-lg font-black text-gray-900 mb-6">Spesies Terkait</h3>
            <div class="space-y-4">
              @forelse($relatedFaunas as $related)
                <a href="{{ route('detail-spesies', $related->id) }}" class="flex items-center gap-4 group">
                  <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0">
                    <img class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                      src="{{ $related->image_url ?? asset('images/default-fauna.jpg') }}"
                      alt="{{ $related->local_name }}" />
                  </div>
                  <div>
                    <h4 class="text-sm font-bold text-gray-800 group-hover:text-[#1E4D2B] transition">
                      {{ $related->local_name }}</h4>
                    <p class="text-xs text-gray-400 italic">{{ $related->scientific_name }}</p>
                    <span
                      class="text-[10px] font-bold text-[#E65100] bg-[#E65100]/10 px-2 py-0.5 rounded-full mt-1 inline-block">
                      {{ $related->iucn_status }}
                    </span>
                  </div>
                </a>
              @empty
                <p class="text-xs text-gray-400">Tidak ada spesies terkait.</p>
              @endforelse
            </div>

            <a href="{{ route('spesies') }}"
              class="w-full mt-6 text-[#1E4D2B] font-bold text-sm py-3 rounded-xl bg-[#E8F5E9] hover:bg-[#1E4D2B] hover:text-white transition flex items-center justify-center gap-2">
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
              <h3 class="text-lg font-black mb-2">Lihat Spesies Terancam?</h3>
              <p class="text-sm text-white/80 mb-6 leading-relaxed">Jika Anda melihat {{ $fauna->local_name }} atau spesies
                dilindungi lainnya dalam kondisi berbahaya, segera laporkan ke otoritas berwenang.</p>
              <a href="tel:021-5724241" id="hotline-btn"
                class="w-full bg-white text-[#B71C1C] font-bold py-3 rounded-xl text-sm hover:bg-gray-100 transition shadow-lg shadow-black/10 flex items-center justify-center gap-2">
                <i class="fa-solid fa-phone"></i> Hotline BKSDA: 021-5724241
              </a>
            </div>
          </div>

          <!-- Contribution Widget -->
          <div class="bg-[#1E4D2B] rounded-3xl p-8 text-white relative overflow-hidden">
            <img class="absolute inset-0 w-full h-full object-cover opacity-10"
              src="https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?auto=format&fit=crop&w=1600&q=80"
              alt="Ilustrasi sketsa spesies liar Indonesia" />
            <div class="relative z-10">
              <h3 class="text-lg font-black mb-2">Bantu Kami Berbenah</h3>
              <p class="text-sm text-white/80 mb-6 leading-relaxed">Punya data lapangan atau riset terbaru tentang
                {{ $fauna->local_name }}? Kontribusikan informasi Anda untuk melengkapi database kami.</p>
              <button id="btn-saran" data-id="{{ $fauna->id }}"
                class="w-full bg-white text-[#1E4D2B] font-bold py-3 rounded-xl text-sm hover:bg-gray-100 transition shadow-lg shadow-black/10">
                Saran Pembaruan Data
              </button>
            </div>
          </div>

        </div>
      </div>

    </div>
  </main>

  <script src="{{ asset('js/DetailSpesies.js') }}"></script>

@endsection
