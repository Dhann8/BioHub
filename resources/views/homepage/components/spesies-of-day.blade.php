  <section id="species-of-day" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="text-center mb-12">
        <div class="inline-flex items-center gap-2 bg-[#E8F5E9] text-[#2E7D32] text-xs font-semibold px-3 py-1.5 rounded-full mb-3">
          <i class="fa-regular fa-calendar-star"></i> SPESIES PILIHAN HARI INI
        </div>
        <h2 class="text-3xl md:text-4xl font-black text-gray-900">Spesies <span class="text-[#2E7D32]">Hari Ini</span></h2>
      </div>

        @php $mainFauna = $faunas->first(); @endphp
        @if($mainFauna)
        <!-- Main Featured Card -->
        <div class="grid md:grid-cols-2 gap-0 bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 max-w-5xl mx-auto">
          <!-- Image Side -->
          <div class="relative h-[380px] md:h-auto">
            <img class="w-full h-full object-cover" src="{{ $mainFauna->image_url ?: 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_f191a65feb_5ec75308631152c0.png' }}" alt="{{ $mainFauna->local_name }}" />
            <!-- IUCN Badge -->
            <div class="absolute top-5 left-5 flex flex-col gap-2">
              <span class="species-badge-{{ strtolower($mainFauna->iucn_status) }} text-white text-xs font-black px-3 py-1.5 rounded-lg shadow-lg flex items-center gap-1.5">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ $mainFauna->iucn_status }}
              </span>
              <span class="bg-black/60 backdrop-blur-sm text-white text-xs font-medium px-3 py-1.5 rounded-lg flex items-center gap-1.5">
                <i class="fa-solid fa-eye"></i> IUCN Red List
              </span>
            </div>
          </div>

          <!-- Content Side -->
          <div class="p-8 md:p-10 flex flex-col justify-center">
            <p class="text-xs font-semibold text-[#D97706] uppercase tracking-widest mb-2">{{ $mainFauna->taxonomy->class_name ?? 'Taxonomy' }}</p>
            <h3 class="text-3xl font-black text-gray-900 mb-1">{{ $mainFauna->local_name }}</h3>
            <p class="text-sm italic text-gray-400 mb-5">{{ $mainFauna->scientific_name }}</p>

            <p class="text-sm text-gray-600 leading-relaxed mb-6">
              {{ Str::limit($mainFauna->description, 150) }}
            </p>

            <!-- Info Grid -->
            <div class="grid grid-cols-2 gap-4 mb-7">
              <div class="bg-[#F9FAFB] rounded-xl p-3">
                <p class="text-xs text-gray-400 mb-0.5">Habitat</p>
                <p class="text-sm font-semibold text-gray-800">{{ $mainFauna->primary_habitat ?? '-' }}</p>
              </div>
              <div class="bg-[#F9FAFB] rounded-xl p-3">
                <p class="text-xs text-gray-400 mb-0.5">Ukuran Tubuh</p>
                <p class="text-sm font-semibold text-gray-800">{{ $mainFauna->size ?? '-' }}</p>
              </div>
            </div>

            <div class="flex gap-3">
              <a href="{{ route('detail-spesies', $mainFauna->id) }}" class="flex-1 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-sm font-semibold py-3 rounded-xl text-center transition">
                Lihat Profil Lengkap
              </a>
              <a href="#" class="border-2 border-[#2E7D32] text-[#2E7D32] hover:bg-[#E8F5E9] text-sm font-semibold py-3 px-4 rounded-xl text-center transition">
                <i class="fa-solid fa-share-nodes"></i>
              </a>
            </div>
          </div>
        </div>
        @endif

      <!-- Other Featured Species (mini cards) -->
      <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-8 max-w-5xl mx-auto">
        @foreach($faunas->skip(1) as $fauna)
        <a href="{{ route('detail-spesies', $fauna->id) }}" class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 cursor-pointer group block">
          <div class="h-28 overflow-hidden relative">
            <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" src="{{ $fauna->image_url ?: 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_31dacdbe99_414190625abc34a1.png' }}" alt="{{ $fauna->local_name }}" />
            <span class="absolute top-2 left-2 species-badge-{{ strtolower($fauna->iucn_status) }} text-white text-[10px] font-bold px-2 py-0.5 rounded">{{ $fauna->iucn_status }}</span>
          </div>
          <div class="p-3">
            <p class="text-xs font-bold text-gray-800">{{ $fauna->local_name }}</p>
            <p class="text-[10px] text-gray-400 italic">{{ $fauna->scientific_name }}</p>
          </div>
        </a>
        @endforeach
      </div>
    </div>
  </section>
