@extends('layout.base')
@section('content')

{{-- Ambil gambar utama: prioritas gallery pertama, fallback ke image_url, lalu placeholder --}}
@php
  $mainImage    = $herbal->image_url ?? 'https://images.unsplash.com/photo-1615485500704-8e990f9900f7?auto=format&fit=crop&w=800&q=80';
  $galleryItems = $herbal->gallery;
  $badgeColor   = $herbal->evidence_level === 'Clinical_Trial' ? 'green' : 'amber';
  $badgeLabel   = $herbal->evidence_level === 'Clinical_Trial' ? 'Uji Klinis' : 'Empiris';
@endphp

<main class="pt-24 pb-20 px-4">
    <div class="max-w-7xl mx-auto">
      
      <!-- BREADCRUMB -->
      <nav class="flex items-center gap-2 text-xs text-gray-400 mb-6">
        <a href="{{ route('homepage') }}" class="hover:text-[#2E7D32]">Beranda</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('herbal') }}" class="hover:text-[#2E7D32]">Database Herbal</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-gray-600 font-medium">{{ $herbal->local_name }}</span>
      </nav>

      <!-- HEADER SECTION -->
      <section class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 mb-8">
        <div class="grid lg:grid-cols-2">
          <!-- Image Gallery -->
          <div class="p-6 md:p-8">
            <!-- Gambar Utama -->
            <div class="rounded-2xl overflow-hidden mb-4 aspect-[4/3]">
              <img id="main-img"
                   class="w-full h-full object-cover"
                   src="{{ $mainImage }}"
                   alt="{{ $herbal->local_name }} ({{ $herbal->scientific_name }})" />
            </div>

            <!-- Gallery Thumbnails -->
            <div class="grid grid-cols-4 gap-3">
              <!-- Thumbnail Gambar Utama -->
              <div class="aspect-square rounded-xl overflow-hidden thumb thumb-active cursor-pointer"
                   onclick="switchImage(this, '{{ $mainImage }}', '{{ $herbal->local_name }}')">
                <img class="w-full h-full object-cover"
                     src="{{ $mainImage }}"
                     alt="{{ $herbal->local_name }}" />
              </div>

              <!-- Loop Galeri Tambahan (maks. 2) -->
              @if($galleryItems->count() > 0)
                @foreach($galleryItems->take(2) as $galleryItem)
                  <div class="aspect-square rounded-xl overflow-hidden thumb cursor-pointer"
                       onclick="switchImage(this, '{{ $galleryItem->image_url }}', '{{ $galleryItem->caption ?? $herbal->local_name }}')">
                    <img class="w-full h-full object-cover"
                         src="{{ $galleryItem->image_url }}"
                         alt="{{ $galleryItem->caption ?? 'Galeri' }}" />
                  </div>
                @endforeach
              @endif

              <!-- Slot ke-4: tombol + -->
              <div class="aspect-square rounded-xl overflow-hidden bg-gray-100 flex items-center justify-center text-gray-400 cursor-pointer hover:bg-gray-200 transition">
                <i class="fa-solid fa-plus"></i>
              </div>
            </div>
          </div>

          <!-- Quick Info -->
          <div class="p-6 md:p-8 md:pl-0 flex flex-col justify-center">
            <div class="flex flex-wrap gap-2 mb-4">
              <span class="bg-[#E8F5E9] text-[#2E7D32] text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">Tanaman Obat</span>
              <span class="bg-{{ $badgeColor }}-100 text-{{ $badgeColor }}-700 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">{{ $badgeLabel }}</span>
              @if($herbal->origin_region)
                <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-widest">{{ $herbal->origin_region }}</span>
              @endif
            </div>
            <h1 class="text-4xl md:text-5xl font-black text-gray-900 mb-2">{{ $herbal->local_name }}</h1>
            <p class="text-lg italic text-gray-400 mb-6 font-medium">{{ $herbal->scientific_name }}</p>
            
            <p class="text-gray-600 leading-relaxed mb-8 max-w-xl">
              {{ $herbal->description ?? 'Deskripsi belum tersedia.' }}
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
                          <p class="text-sm font-bold text-gray-800">Famili</p>
                          <p class="text-sm text-gray-500">{{ $herbal->plant_family ?? '-' }}</p>
                        </div>
                      </li>
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#2E7D32] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Ciri Fisik</p>
                          <p class="text-sm text-gray-500">{{ $herbal->morphology_description ?? 'Data morfologi belum tersedia.' }}</p>
                        </div>
                      </li>
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#2E7D32] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Lingkungan Tumbuh</p>
                          <p class="text-sm text-gray-500">{{ $herbal->cultivation_zone ?? '-' }}</p>
                        </div>
                      </li>
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#2E7D32] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Bagian Yang Digunakan</p>
                          <p class="text-sm text-gray-500">
                              {{ is_array($herbal->plant_parts) ? implode(', ', $herbal->plant_parts) : ($herbal->plant_parts ?? '-') }}
                          </p>
                        </div>
                      </li>
                      @if($herbal->symptoms->count() > 0)
                      <li class="flex items-start gap-3">
                        <i class="fa-solid fa-check-circle text-[#2E7D32] mt-1 text-sm"></i>
                        <div>
                          <p class="text-sm font-bold text-gray-800">Kegunaan / Gejala yang Ditangani</p>
                          <p class="text-sm text-gray-500">{{ $herbal->symptoms->pluck('symptom_name')->join(', ') }}</p>
                        </div>
                      </li>
                      @endif
                    </ul>
                  </div>
                  <div class="rounded-2xl overflow-hidden border border-gray-100 h-48 relative">
                    <img class="w-full h-full object-cover" 
                         src="{{ $herbal->map_image_url ?: asset('image/map.webp') }}" 
                         alt="Peta Distribusi {{ $herbal->local_name }}" />
                    <div class="absolute inset-0 flex items-center justify-center bg-black/10">
                      <span class="bg-white/90 backdrop-blur-sm px-3 py-1.5 rounded-lg text-[10px] font-bold text-gray-700 shadow-sm border border-gray-200">
                        <i class="fa-solid fa-location-dot text-red-500 mr-1"></i> Peta Distribusi
                      </span>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Tab 2: Benefits -->
              <div id="benefits" class="tab-content">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Kandungan Aktif & Bukti Ilmiah</h3>
                <div class="space-y-6">
                  @forelse($herbal->activeCompounds as $compound)
                  <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h4 class="font-bold text-[#2E7D32] mb-2 flex items-center gap-2">
                      <i class="fa-solid fa-flask"></i> {{ $compound->compound_name }}
                    </h4>
                    <p class="text-sm text-gray-600 leading-relaxed">
                      {{ $compound->pharmacological_effect }}
                    </p>
                  </div>
                  @empty
                  <div class="p-6 text-center text-gray-400">
                      Belum ada data kandungan aktif.
                  </div>
                  @endforelse
                </div>
              </div>

              <!-- Tab 3: Preparation -->
              <div id="preparation" class="tab-content">
                <h3 class="text-xl font-bold text-gray-900 mb-6">Cara Pengolahan & Dosis</h3>
                <div class="space-y-8">
                  <div>
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                      <span class="w-6 h-6 rounded-full bg-[#2E7D32] text-white text-[10px] flex items-center justify-center">1</span>
                      Metode Pengolahan
                    </h4>
                    <p class="text-sm text-gray-600 mb-3">{{ $herbal->preparation_method ?? 'Metode belum tersedia.' }}</p>
                  </div>
                  <div>
                    <h4 class="text-sm font-bold text-gray-800 mb-4 flex items-center gap-2">
                      <span class="w-6 h-6 rounded-full bg-[#2E7D32] text-white text-[10px] flex items-center justify-center">2</span>
                      Dosis & Panduan Konsumsi
                    </h4>
                    <p class="text-sm text-gray-600 space-y-2">
                      {{ $herbal->dosage_guide ?? 'Dosis belum tersedia.' }}
                    </p>
                  </div>
                </div>
              </div>

              <!-- Tab 4: Safety -->
              <div id="safety" class="tab-content">
                <h3 class="text-xl font-bold text-red-600 mb-6">Kontraindikasi & Efek Samping</h3>
                <div class="space-y-6">
                  
                  @if($herbal->safety_warning)
                  <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h4 class="text-sm font-bold text-gray-800 mb-2">Peringatan Umum</h4>
                    <p class="text-sm text-gray-500">{{ $herbal->safety_warning }}</p>
                  </div>
                  @endif

                  @forelse($herbal->interactions as $interaction)
                  <div class="warning-box bg-[#FEF3C7] p-6 rounded-r-2xl">
                    <h4 class="font-bold text-[#B45309] mb-2 flex items-center gap-2">
                      <i class="fa-solid fa-triangle-exclamation"></i> {{ $interaction->title }}
                    </h4>
                    <p class="text-sm text-[#B45309] opacity-80 leading-relaxed mb-1">
                      <span class="font-bold">Risiko:</span> {{ $interaction->severity }}
                    </p>
                    <p class="text-sm text-[#B45309] opacity-80 leading-relaxed">
                      {{ $interaction->description }}
                    </p>
                  </div>
                  @empty
                  <div class="p-6 text-center text-gray-400">
                      Belum ada data interaksi spesifik.
                  </div>
                  @endforelse

                </div>
              </div>

            </div>
          </div>
        </div>

        <!-- Right: Sidebar Widget -->
        <div class="space-y-8">
          <!-- Related Plants -->
          <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-100">
            <h3 class="text-lg font-black text-gray-900 mb-6">Herbal Lainnya</h3>
            <div class="space-y-4">
              @forelse($relatedHerbals as $related)
              <a href="{{ route('detail-herbal', $related->id) }}" class="flex items-center gap-4 group">
                <div class="w-16 h-16 rounded-xl overflow-hidden shrink-0">
                  <img class="w-full h-full object-cover group-hover:scale-110 transition duration-300"
                       src="{{ $related->image_url ?: 'https://images.unsplash.com/photo-1509358271058-acd05cc93898?auto=format&fit=crop&w=800&q=80' }}"
                       alt="{{ $related->local_name }}" />
                </div>
                <div>
                  <h4 class="text-sm font-bold text-gray-800 group-hover:text-[#2E7D32] transition">{{ $related->local_name }}</h4>
                  <p class="text-xs text-gray-400 italic">{{ $related->scientific_name }}</p>
                </div>
              </a>
              @empty
              <p class="text-sm text-gray-400 text-center">Tidak ada herbal lain.</p>
              @endforelse
            </div>
            <a href="{{ route('herbal') }}" class="w-full mt-6 text-[#2E7D32] font-bold text-sm py-3 rounded-xl bg-[#E8F5E9] hover:bg-[#2E7D32] hover:text-white transition text-center flex items-center justify-center">
              Kembali ke Database
            </a>
          </div>

          <!-- Contribution Widget -->
          <div class="bg-[#2E7D32] rounded-3xl p-8 text-white relative overflow-hidden">
            <img class="absolute inset-0 w-full h-full object-cover opacity-10" src="https://images.unsplash.com/photo-1518531933037-91b2f5f229cc?auto=format&fit=crop&w=1600&q=80" alt="botanical drawing" />
            <div class="relative z-10">
              <h3 class="text-lg font-black mb-2">Bantu Kami Berbenah</h3>
              <p class="text-sm text-white/80 mb-6 leading-relaxed">
                Punya riset terbaru atau info tambahan tentang <strong>{{ $herbal->local_name }}</strong>? Laporkan perubahan data di sini.
              </p>
              <button class="w-full bg-white text-[#2E7D32] font-bold py-3 rounded-xl text-sm hover:bg-gray-100 transition shadow-lg shadow-black/10">
                Saran Pembaruan
              </button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>

  <script src="{{ asset('js/DetailSpesies.js') }}"></script>

@endsection