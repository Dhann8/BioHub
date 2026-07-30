// State untuk menyimpan gejala yang dipilih
let selectedSymptoms = [];

document.addEventListener('DOMContentLoaded', () => {
    // FUNGSI FILTER/SEARCH GEJALA
    const searchInput = document.querySelector('input[placeholder*="Cari gejala"]');
    const symptomCards = document.querySelectorAll('.symptom-card');

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase().trim();

            symptomCards.forEach((card) => {
                // Ambil teks dari nama gejala
                const symptomName = card.querySelector('span').textContent.toLowerCase();

                // Cek apakah nama gejala cocok dengan keyword pencarian
                if (symptomName.includes(searchTerm)) {
                    card.style.display = 'block'; // Tampilkan kartu
                } else {
                    card.style.display = 'none';  // Sembunyikan kartu
                }
            });
        });
    }
});

// FUNGSI TOGGLE GEJALA (Pilih / Batal Pilih)
function toggleSymptom(button) {
    const symptomName = button.querySelector('span').textContent.trim();

    // Visual Toggle Class
    button.classList.toggle('ring-2');
    button.classList.toggle('ring-[#2E7D32]');
    button.classList.toggle('bg-green-50');
    
    // Toggle icon and styling within the card
    const iconContainer = button.querySelector('div');
    if (button.classList.contains('ring-2')) {
        iconContainer.classList.remove('bg-[#E8F5E9]', 'text-[#2E7D32]', 'bg-[#FEF3C7]', 'text-[#D97706]');
        iconContainer.classList.add('bg-[#2E7D32]', 'text-white');
    } else {
        // Reset to original based on context, we'll just remove the active ones and let group-hover take over
        iconContainer.classList.remove('bg-[#2E7D32]', 'text-white');
        if(symptomName === 'Demam' || symptomName === 'Pencernaan' || symptomName === 'Nyeri Sendi' || symptomName === 'Gatal/Kulit') {
             iconContainer.classList.add('bg-[#E8F5E9]', 'text-[#2E7D32]');
        } else {
             iconContainer.classList.add('bg-[#FEF3C7]', 'text-[#D97706]');
        }
    }

    // Simpan data ke array
    if (selectedSymptoms.includes(symptomName)) {
        // Jika sudah ada, hapus
        selectedSymptoms = selectedSymptoms.filter(item => item !== symptomName);
    } else {
        // Jika belum ada, tambahkan
        selectedSymptoms.push(symptomName);
    }

    console.log('Gejala terpilih:', selectedSymptoms);
}

// FUNGSI NAVIGASI STEP WIZARD
function goToStep(step) {
    if (step === 2 && selectedSymptoms.length === 0) {
        alert('Pilih minimal satu gejala terlebih dahulu!');
        return;
    }

    if (step === 2) {
        // Filter Herbal Cards in Step 2
        const herbalCards = document.querySelectorAll('.herbal-card');
        let visibleCount = 0;
        
        herbalCards.forEach(card => {
            const cardSymptoms = card.getAttribute('data-symptoms').split(',').map(s => s.trim());
            
            // Check if there is any intersection between selectedSymptoms and cardSymptoms
            const hasMatch = selectedSymptoms.some(s => cardSymptoms.includes(s));
            
            if (hasMatch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        // Update summary text
        const summaryElement = document.querySelector('#step-2 p.text-sm.text-gray-500 span.font-bold');
        if (summaryElement) {
            summaryElement.textContent = selectedSymptoms.join(', ');
        }
    }

    document.querySelectorAll('.wizard-step').forEach(el => el.classList.remove('active'));
    document.getElementById('step-' + step).classList.add('active');

    // Update indicators
    if (step === 2) {
        document.getElementById('dot-2').classList.remove('bg-gray-200', 'text-gray-400');
        document.getElementById('dot-2').classList.add('bg-[#2E7D32]', 'text-white', 'shadow-lg', 'shadow-green-900/20');
        document.getElementById('line-1').classList.remove('w-0');
        document.getElementById('line-1').classList.add('w-full');
    } else {
        document.getElementById('dot-2').classList.add('bg-gray-200', 'text-gray-400');
        document.getElementById('dot-2').classList.remove('bg-[#2E7D32]', 'text-white', 'shadow-lg', 'shadow-green-900/20');
        document.getElementById('line-1').classList.add('w-0');
        document.getElementById('line-1').classList.remove('w-full');
    }
    
    // Scroll to top of wizard
    window.scrollTo({ top: 0, behavior: 'smooth' });
}