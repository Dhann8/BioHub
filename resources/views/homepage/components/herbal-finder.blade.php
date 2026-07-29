<section id="herbal-finder" class="py-20 bg-[#F9FAFB]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row gap-12 items-start">
        <!-- Left: Text + Symptom Picker -->
        <div class="flex-1">
          <div class="inline-flex items-center gap-2 bg-[#FEF3C7] text-[#D97706] text-xs font-semibold px-3 py-1.5 rounded-full mb-4">
            <i class="fa-solid fa-mortar-pestle"></i> PENCARI HERBAL
          </div>
          <h2 class="text-3xl md:text-4xl font-black text-gray-900 mb-3">Temukan Ramuan <span class="text-[#D97706]">Herbal</span> untuk Keluhan Anda</h2>
          <p class="text-gray-500 text-sm leading-relaxed mb-8">Pilih gejala yang Anda alami dan temukan rekomendasi tanaman herbal tradisional Indonesia yang relevan.</p>

          <!-- Symptom Picker -->
          <p class="text-sm font-semibold text-gray-700 mb-3">Pilih Keluhan:</p>
          <div class="flex flex-wrap gap-3 mb-8" id="symptom-picker">
            <button class="symptom-btn border-2 border-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl transition active" onclick="selectSymptom(this)">
              <i class="fa-solid fa-temperature-high mr-1.5"></i>Demam
            </button>
            <button class="symptom-btn border-2 border-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl transition" onclick="selectSymptom(this)">
              <i class="fa-solid fa-head-side-cough mr-1.5"></i>Batuk
            </button>
            <button class="symptom-btn border-2 border-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl transition" onclick="selectSymptom(this)">
              <i class="fa-solid fa-stomach mr-1.5"></i>Gangguan Pencernaan
            </button>
            <button class="symptom-btn border-2 border-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl transition" onclick="selectSymptom(this)">
              <i class="fa-solid fa-brain mr-1.5"></i>Sakit Kepala
            </button>
            <button class="symptom-btn border-2 border-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl transition" onclick="selectSymptom(this)">
              <i class="fa-solid fa-joint mr-1.5"></i>Nyeri Sendi
            </button>
            <button class="symptom-btn border-2 border-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl transition" onclick="selectSymptom(this)">
              <i class="fa-solid fa-shield-heart mr-1.5"></i>Imunitas
            </button>
          </div>

          <a href="herbal.html" class="bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-semibold px-8 py-3.5 rounded-xl inline-flex items-center gap-2 transition">
            <i class="fa-solid fa-magnifying-glass"></i>Cari Herbal Sekarang
          </a>
        </div>

        <!-- Right: Herb Cards -->
        <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-5">
          <!-- Card 1 -->
          <a href="detail-herbal.html" class="herb-card bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 cursor-pointer block">
            <div class="h-40 overflow-hidden">
              <img class="w-full h-full object-cover" src="https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_6ba8a92af3_ac9c9f8415f6ac80.png" alt="fresh ginger root and turmeric slices on natural wooden surface, Indonesian herbal medicine, warm to" />
            </div>
            <div class="p-4">
              <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold bg-[#E8F5E9] text-[#2E7D32] px-2 py-1 rounded-full">Anti-inflamasi</span>
                <span class="text-xs text-gray-400"><i class="fa-solid fa-star text-[#D97706]"></i> 4.8</span>
              </div>
              <h3 class="font-bold text-gray-800 text-sm mb-1">Jahe & Kunyit</h3>
              <p class="text-xs text-gray-500">Efektif untuk demam, nyeri, dan meningkatkan imunitas tubuh.</p>
            </div>
          </a>
          <!-- Card 2 -->
          <a href="detail-herbal.html" class="herb-card bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 cursor-pointer block">
            <div class="h-40 overflow-hidden">
              <img class="w-full h-full object-cover" src="https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_d6c5be637a_b834564485960f62.png" alt="fresh noni morinda citrifolia fruit and leaves on tropical background, Indonesian herbal plant, vivi" />
            </div>
            <div class="p-4">
              <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold bg-[#FEF3C7] text-[#D97706] px-2 py-1 rounded-full">Antibakteri</span>
                <span class="text-xs text-gray-400"><i class="fa-solid fa-star text-[#D97706]"></i> 4.5</span>
              </div>
              <h3 class="font-bold text-gray-800 text-sm mb-1">Mengkudu</h3>
              <p class="text-xs text-gray-500">Digunakan untuk tekanan darah dan infeksi bakteri.</p>
            </div>
          </a>
          <!-- Card 3 -->
          <a href="detail-herbal.html" class="herb-card bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 cursor-pointer block">
            <div class="h-40 overflow-hidden">
              <img class="w-full h-full object-cover" src="https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_7a2162a989_2a02991e79982d29.png" alt="lemongrass and pandan leaves bundle, Indonesian herbal cooking ingredients, fresh green, natural lig" />
            </div>
            <div class="p-4">
              <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold bg-[#E8F5E9] text-[#2E7D32] px-2 py-1 rounded-full">Digestif</span>
                <span class="text-xs text-gray-400"><i class="fa-solid fa-star text-[#D97706]"></i> 4.7</span>
              </div>
              <h3 class="font-bold text-gray-800 text-sm mb-1">Sereh & Pandan</h3>
              <p class="text-xs text-gray-500">Membantu melancarkan pencernaan dan meredakan kembung.</p>
            </div>
          </a>
          <!-- Card 4 -->
          <a href="detail-herbal.html" class="herb-card bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 cursor-pointer block">
            <div class="h-40 overflow-hidden">
              <img class="w-full h-full object-cover" src="https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_63cb4c3b07_0e3641918bb56514.png" alt="temulawak curcuma zanthorrhiza rhizome roots, Indonesian jamu herbal medicine, warm orange tones, st" />
            </div>
            <div class="p-4">
              <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-semibold bg-[#FEF3C7] text-[#D97706] px-2 py-1 rounded-full">Hepatoprotektor</span>
                <span class="text-xs text-gray-400"><i class="fa-solid fa-star text-[#D97706]"></i> 4.9</span>
              </div>
              <h3 class="font-bold text-gray-800 text-sm mb-1">Temulawak</h3>
              <p class="text-xs text-gray-500">Melindungi hati dan meningkatkan nafsu makan anak.</p>
            </div>
          </a>
        </div>
      </div>
    </div>
  </section>