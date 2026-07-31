/**
 * FilterSpesies.js — Versi Lengkap dengan API
 * Fitur: Filter, Load More (10 per 10), Data dari JSON/API
 */

const filterState = {
    taxonomy: null,
    size: null,
    features: [],
    region: null
};

// State paginasi
let speciesPage = 1;
let speciesPerPage = 10;
let speciesTotalItems = 0;
let speciesLoadedCount = 0;
let isLoadingSpecies = false;

window.toggleActive = function(btn) {
    if (!btn) return;

    // A. Grup Taxonomy (Single-Select)
    const taxonomySection = btn.closest('section');
    if (taxonomySection && taxonomySection.querySelector('h3')?.innerText?.includes('Taksonomi')) {
        taxonomySection.querySelectorAll('.selector-card').forEach(card => {
            card.classList.remove('active', 'border-forest-primary', 'bg-forest-pale');
        });
        btn.classList.add('active', 'border-forest-primary', 'bg-forest-pale');
        filterState.taxonomy = btn.getAttribute('data-value') || btn.innerText.trim();
        return;
    }

    // B. Grup Region / Wilayah (Single-Select)
    const regionSection = btn.closest('section');
    if (regionSection && regionSection.querySelector('h3')?.innerText?.includes('Wilayah')) {
        regionSection.querySelectorAll('.selector-card').forEach(card => {
            card.classList.remove('active', 'bg-forest-primary', 'text-white', 'border-forest-primary');
        });
        btn.classList.add('active', 'bg-forest-primary', 'text-grey-400', 'border-forest-primary');
        filterState.region = btn.getAttribute('data-value') || btn.innerText.trim();
        return;
    }

    // C. Multi-Select (Fitur Unik)
    btn.classList.toggle('active');
    btn.classList.toggle('border-forest-primary');
    btn.classList.toggle('bg-forest-pale');

    const value = btn.getAttribute('data-value') || btn.innerText.trim();
    if (filterState.features.includes(value)) {
        filterState.features = filterState.features.filter(item => item !== value);
    } else {
        filterState.features.push(value);
    }
};

window.goToStep = function(step) {
    document.querySelectorAll('.wizard-step').forEach(el => {
        el.classList.remove('active');
        el.classList.add('hidden');
    });

    const targetStep = document.getElementById('step-' + step);
    if (targetStep) {
        targetStep.classList.remove('hidden');
        targetStep.classList.add('active');
    }

    const dot2 = document.getElementById('dot-2');
    const line1 = document.getElementById('line-1');

    if (step === 2) {
        // Reset pagination & load fresh
        speciesPage = 1;
        speciesLoadedCount = 0;
        document.getElementById('speciesGrid').innerHTML = '';
        document.getElementById('loadMoreContainer').classList.add('hidden');
        fetchSpecies(false);

        if (line1) line1.style.width = '100%';
        if (dot2) {
            dot2.classList.remove('bg-gray-200', 'text-gray-400');
            dot2.classList.add('bg-[#1E4D2B]', 'text-white', 'shadow-lg', 'shadow-green-900/20');
        }
    } else {
        if (line1) line1.style.width = '0%';
        if (dot2) {
            dot2.classList.remove('bg-[#1E4D2B]', 'text-white', 'shadow-lg', 'shadow-green-900/20');
            dot2.classList.add('bg-gray-200', 'text-gray-400');
        }
    }

    window.scrollTo({ top: 200, behavior: 'smooth' });
};

function fetchSpecies(append = false) {
    if (isLoadingSpecies) return;
    isLoadingSpecies = true;

    const loading = document.getElementById('speciesLoading');
    const grid    = document.getElementById('speciesGrid');
    const empty   = document.getElementById('speciesEmpty');
    const loadMoreContainer = document.getElementById('loadMoreContainer');
    const loadMoreBtn = document.getElementById('loadMoreBtn');

    if (!append) {
        if (loading) loading.classList.remove('hidden');
        if (empty)   empty.classList.add('hidden');
        if (loadMoreContainer) loadMoreContainer.classList.add('hidden');
    } else {
        if (loadMoreBtn) loadMoreBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memuat...';
    }

    // Build query params
    const params = new URLSearchParams();
    params.set('page', speciesPage);
    params.set('per_page', speciesPerPage);

    if (filterState.taxonomy)         params.set('taxonomy', filterState.taxonomy);
    if (filterState.size)             params.set('size', filterState.size);
    if (filterState.region)           params.set('region', filterState.region);
    if (filterState.features.length)  params.set('features', filterState.features.join(','));

    fetch('/api/fauna?' + params.toString())
        .then(res => res.json())
        .then(data => {
            const items = data.data || [];
            speciesTotalItems = data.total || 0;
            speciesLoadedCount += items.length;

            if (loading) loading.classList.add('hidden');

            // Update counter
            const counter = document.getElementById('speciesCount');
            if (counter) counter.innerText = `${speciesTotalItems} Spesies`;

            if (items.length === 0 && !append) {
                if (empty) empty.classList.remove('hidden');
                if (loadMoreContainer) loadMoreContainer.classList.add('hidden');
            } else {
                if (empty) empty.classList.add('hidden');
                items.forEach(fauna => grid.insertAdjacentHTML('beforeend', renderSpeciesCard(fauna)));

                // Tampilkan tombol Load More hanya jika masih ada data
                if (speciesLoadedCount < speciesTotalItems) {
                    if (loadMoreContainer) loadMoreContainer.classList.remove('hidden');
                    if (loadMoreBtn) loadMoreBtn.innerHTML = 'Lihat Selengkapnya <i class="fa-solid fa-chevron-down text-xs"></i>';
                } else {
                    if (loadMoreContainer) loadMoreContainer.classList.add('hidden');
                }
            }

            speciesPage++;
            isLoadingSpecies = false;
        })
        .catch(err => {
            console.error('Gagal memuat spesies:', err);
            if (loading) loading.classList.add('hidden');
            if (grid) grid.insertAdjacentHTML('beforeend', '<div class="col-span-2 text-center py-8 text-red-500">Gagal memuat data. Coba lagi.</div>');
            isLoadingSpecies = false;
            if (loadMoreBtn) loadMoreBtn.innerHTML = 'Lihat Selengkapnya <i class="fa-solid fa-chevron-down text-xs"></i>';
        });
}

window.loadMoreSpecies = function() {
    fetchSpecies(true);
};

function renderSpeciesCard(fauna) {
    const iucn       = fauna.iucn_status || 'LC';
    const iucnClass  = { CR: 'bg-red-700', EN: 'bg-orange-600', VU: 'bg-amber-500', NT: 'bg-yellow-400', LC: 'bg-green-600' };
    const badgeColor = iucnClass[iucn] || 'bg-gray-500';
    const taxonomy   = fauna.taxonomy?.class_name || 'Fauna';
    const image      = fauna.image_url || 'https://images.unsplash.com/photo-1551085254-e96b210db58a?auto=format&fit=crop&w=800&q=80';
    const locations  = fauna.locations?.map(l => l.region_name).join(', ') || 'Indonesia';

    return `
    <div class="bg-white rounded-3xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-2xl transition-all duration-500 group">
      <div class="h-64 relative overflow-hidden">
        <img class="w-full h-full object-cover group-hover:scale-110 transition duration-700"
             src="${image}" alt="${fauna.local_name}"
             onerror="this.src='https://images.unsplash.com/photo-1551085254-e96b210db58a?auto=format&fit=crop&w=800&q=80'" />
        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
        <div class="absolute top-4 left-4 flex gap-2">
          <span class="${badgeColor} text-white text-[10px] font-black px-3 py-1.5 rounded-lg shadow-lg flex items-center gap-1.5 uppercase">
            <i class="fa-solid fa-triangle-exclamation"></i> Status ${iucn}
          </span>
        </div>
        <div class="absolute bottom-5 left-6 right-6">
          <p class="text-[10px] font-bold text-amber-400 uppercase tracking-widest mb-1">${taxonomy}</p>
          <h3 class="text-2xl font-black text-white">${fauna.local_name}</h3>
          <p class="text-sm italic text-gray-300">${fauna.scientific_name}</p>
        </div>
      </div>
      <div class="p-8">
        <div class="grid grid-cols-2 gap-4 mb-6">
          <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
            <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Wilayah Asal</p>
            <p class="text-xs font-bold text-gray-800"><i class="fa-solid fa-location-dot text-orange-500 mr-1"></i> ${locations}</p>
          </div>
          <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
            <p class="text-[10px] font-bold text-gray-400 uppercase mb-1">Status IUCN</p>
            <p class="text-xs font-bold text-gray-800"><i class="fa-solid fa-paw text-[#1E4D2B] mr-1"></i> Kategori ${iucn}</p>
          </div>
        </div>
        <p class="text-sm text-gray-600 leading-relaxed mb-8 line-clamp-2">${fauna.description || ''}</p>
        <a href="/detail-spesies/${fauna.id}"
           class="w-full bg-[#1E4D2B] hover:bg-[#0E2E1A] text-white font-bold py-4 rounded-2xl transition shadow-lg flex items-center justify-center gap-2 group/btn">
          Lihat Profil Lengkap <i class="fa-solid fa-arrow-right group-hover/btn:translate-x-1 transition"></i>
        </a>
      </div>
    </div>`;
}

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[name="size"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            filterState.size = e.target.value;
        });
    });
});