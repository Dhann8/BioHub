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

          <!-- Symptom Picker dengan data-symptom -->
          <p class="text-sm font-semibold text-gray-700 mb-3">Pilih Keluhan:</p>
          <div class="flex flex-wrap gap-3 mb-8" id="symptom-picker">
            <button type="button" data-symptom="Demam" class="symptom-btn border-2 border-[#D97706] bg-[#FEF3C7] text-[#D97706] text-sm font-medium px-4 py-2 rounded-xl transition cursor-pointer">
              <i class="fa-solid fa-temperature-high mr-1.5"></i>Demam
            </button>
            <button type="button" data-symptom="Batuk" class="symptom-btn border-2 border-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl transition cursor-pointer">
              <i class="fa-solid fa-head-side-cough mr-1.5"></i>Batuk
            </button>
            <button type="button" data-symptom="Gangguan Pencernaan" class="symptom-btn border-2 border-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl transition cursor-pointer">
              <i class="fa-solid fa-stomach mr-1.5"></i>Gangguan Pencernaan
            </button>
            <button type="button" data-symptom="Sakit Kepala" class="symptom-btn border-2 border-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl transition cursor-pointer">
              <i class="fa-solid fa-brain mr-1.5"></i>Sakit Kepala
            </button>
            <button type="button" data-symptom="Nyeri Sendi" class="symptom-btn border-2 border-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl transition cursor-pointer">
              <i class="fa-solid fa-joint mr-1.5"></i>Nyeri Sendi
            </button>
            <button type="button" data-symptom="Imunitas" class="symptom-btn border-2 border-gray-200 text-gray-600 text-sm font-medium px-4 py-2 rounded-xl transition cursor-pointer">
              <i class="fa-solid fa-shield-heart mr-1.5"></i>Imunitas
            </button>
          </div>

          <!-- Tombol Trigger Cari -->
          <button type="button" id="btn-search-herbal" class="bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-semibold px-8 py-3.5 rounded-xl inline-flex items-center gap-2 transition cursor-pointer">
            <i class="fa-solid fa-magnifying-glass"></i>Cari Herbal Sekarang
          </button>
        </div>

        <!-- Right: Herb Cards Container (Hasil Pencarian Ditempatkan Di Sini) -->
        <div class="flex-1 w-full">
            <div id="herb-results-container" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
              @foreach($herbals as $herbal)
              <!-- Card Default -->
              <a href="{{ route('detail-herbal', $herbal->id) }}" class="herb-card bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 cursor-pointer block hover:shadow-md transition">
                <div class="h-40 overflow-hidden">
                  <img class="w-full h-full object-cover" src="{{ $herbal->image_url ?: 'https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_6ba8a92af3_ac9c9f8415f6ac80.png' }}" alt="{{ $herbal->local_name }}" />
                </div>
                <div class="p-4">
                  <div class="flex items-center justify-between mb-2">
                    <span class="text-xs font-semibold {{ $herbal->evidence_level === 'Clinical_Trial' ? 'bg-[#E8F5E9] text-[#2E7D32]' : 'bg-[#FEF3C7] text-[#D97706]' }} px-2 py-1 rounded-full">
                      {{ $herbal->evidence_level === 'Clinical_Trial' ? 'Uji Klinis' : 'Empiris' }}
                    </span>
                  </div>
                  <h3 class="font-bold text-gray-800 text-sm mb-1">{{ $herbal->local_name }}</h3>
                  <p class="text-xs text-gray-500">{{ Str::limit($herbal->description, 60) }}</p>
                </div>
              </a>
              @endforeach
            </div>
        </div>
      </div>
    </div>
</section>

{{-- SCRIPT FILTER JS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const symptomBtns = document.querySelectorAll('.symptom-btn');
    const searchBtn = document.getElementById('btn-search-herbal');
    const resultsContainer = document.getElementById('herb-results-container');
    
    let selectedSymptom = 'Demam'; // Default terpilih pertama

    // 1. Toggle Aktif Tombol Gejala
    symptomBtns.forEach(btn => {
        btn.addEventListener('click', function () {
            // Reset style semua tombol
            symptomBtns.forEach(b => {
                b.classList.remove('border-[#D97706]', 'bg-[#FEF3C7]', 'text-[#D97706]');
                b.classList.add('border-gray-200', 'text-gray-600');
            });

            // Aktifkan tombol yang diklik
            this.classList.remove('border-gray-200', 'text-gray-600');
            this.classList.add('border-[#D97706]', 'bg-[#FEF3C7]', 'text-[#D97706]');

            selectedSymptom = this.getAttribute('data-symptom');
        });
    });

    // 2. Kirim Request Pencarian saat Tombol "Cari Herbal Sekarang" Diklik
    searchBtn.addEventListener('click', function () {
        if (!selectedSymptom) return;

        // Tampilkan Loading State
        resultsContainer.innerHTML = `
            <div class="col-span-2 text-center py-10 text-gray-500">
                <i class="fa-solid fa-spinner fa-spin text-2xl text-[#2E7D32] mb-2"></i>
                <p class="text-sm">Mencari herbal untuk keluhan ${selectedSymptom}...</p>
            </div>
        `;

        // Panggil Global Search API yang sudah dibuat sebelumnya
        fetch(`{{ route('api.global-search') }}?search=${encodeURIComponent(selectedSymptom)}&kategori=herbal`)
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success' && data.redirect_url) {
                    // Jika ingin langsung ke detail herbal yang paling cocok
                    window.location.href = data.redirect_url;
                } else {
                    // Jika tidak ditemukan
                    resultsContainer.innerHTML = `
                        <div class="col-span-2 bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center">
                            <p class="text-sm text-yellow-800 font-medium">Data herbal untuk keluhan "${selectedSymptom}" belum tersedia.</p>
                        </div>
                    `;
                }
            })
            .catch(err => {
                console.error(err);
                resultsContainer.innerHTML = `
                    <div class="col-span-2 bg-red-50 border border-red-200 rounded-xl p-6 text-center">
                        <p class="text-sm text-red-600 font-medium">Terjadi kesalahan saat memuat data.</p>
                    </div>
                `;
            });
    });
});
</script>