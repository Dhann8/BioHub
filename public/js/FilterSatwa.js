const filterState = {
    taxonomy: null,
    size: null,
    features: [],
    region: null
};

window.toggleActive = function(btn) {
    if (!btn) return;

    // A. Grup Taxonomy (Single-Select)
    const taxonomyGroup = btn.closest('.grid')?.querySelectorAll('.selector-card');
    if (taxonomyGroup && btn.closest('section')?.querySelector('h3')?.innerText.includes('Taksonomi')) {
        taxonomyGroup.forEach(card => card.classList.remove('active', 'border-forest-primary', 'bg-forest-pale/30'));
        btn.classList.add('active', 'border-forest-primary', 'bg-forest-pale/30');
        filterState.taxonomy = btn.getAttribute('data-value') || btn.innerText.trim();
        return;
    }

    // B. Grup Region / Wilayah (Single-Select)
    const regionGroup = btn.closest('.flex-wrap')?.querySelectorAll('.selector-card');
    if (regionGroup && btn.closest('section')?.querySelector('h3')?.innerText.includes('Wilayah')) {
        regionGroup.forEach(card => card.classList.remove('active', 'bg-forest-primary', 'text-white'));
        btn.classList.add('active', 'bg-forest-primary', 'text-white');
        filterState.region = btn.getAttribute('data-value') || btn.innerText.trim();
        return;
    }

    // C. Default / Multi-Select (Fitur Unik, dll)
    btn.classList.toggle('active');
    btn.classList.toggle('border-forest-primary');
    btn.classList.toggle('bg-forest-pale/30');

    const value = btn.getAttribute('data-value') || btn.innerText.trim();
    if (filterState.features.includes(value)) {
        filterState.features = filterState.features.filter(item => item !== value);
    } else {
        filterState.features.push(value);
    }
};

/**
 * Pindah Step pada Wizard & Sinkronisasi Progress Bar
 */
window.goToStep = function(step) {
    // 1. Sembunyikan semua step & tampilkan step target
    document.querySelectorAll('.wizard-step').forEach(el => {
        el.classList.remove('active');
        el.classList.add('hidden');
    });

    const targetStep = document.getElementById('step-' + step);
    if (targetStep) {
        targetStep.classList.remove('hidden');
        targetStep.classList.add('active');
    }

    // 2. Update Indikator Progress Line & Dot
    const dot2 = document.getElementById('dot-2');
    const line1 = document.getElementById('line-1');

    if (step === 2) {
        // Jalankan filter data sebelum menampilkan hasil di Step 2
        applyFaunaFilter();

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

    // 3. Scroll Halus ke Atas
    window.scrollTo({ top: 200, behavior: 'smooth' });
};

/**
 * Menyaring Tampilan Kartu Satwa di Step 2
 */
function applyFaunaFilter() {
    const cards = document.querySelectorAll('#step-2 .grid > div');
    let totalMatched = 0;

    cards.forEach(card => {
        const taxonomyText = card.querySelector('.text-amber-accent')?.innerText?.toLowerCase() || '';
        const regionText = card.querySelector('.fa-location-dot')?.parentElement?.innerText?.toLowerCase() || '';

        let matches = true;

        // Pencocokan Taksonomi
        if (filterState.taxonomy && !taxonomyText.includes(filterState.taxonomy.toLowerCase())) {
            matches = false;
        }

        // Pencocokan Wilayah
        if (filterState.region && !regionText.includes(filterState.region.toLowerCase())) {
            matches = false;
        }

        // Tampilkan / Sembunyikan Kartu
        if (matches) {
            card.classList.remove('hidden');
            totalMatched++;
        } else {
            card.classList.add('hidden');
        }
    });

    // Update Counter Jumlah Hasil Ditemukan
    const countBadge = document.querySelector('#step-2 .text-forest-primary');
    if (countBadge) {
        countBadge.innerText = `${totalMatched} Spesies`;
    }
}

/**
 * Event Listener untuk Radio Input (Ukuran Tubuh)
 */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[name="size"]').forEach(radio => {
        radio.addEventListener('change', (e) => {
            filterState.size = e.target.value;
        });
    });
});