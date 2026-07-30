document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tableRows = document.querySelectorAll('#queue-table-body tr[data-cat]');
    const countDisplay = document.getElementById('displayed-count-text');

    // Fungsi Filter Tab
    tabButtons.forEach(button => {
        button.addEventListener('click', function () {
            const selectedTab = this.getAttribute('data-tab');
            let visibleCount = 0;

            // Update Style Active Tab
            tabButtons.forEach(btn => {
                btn.classList.remove('active', 'bg-[#1E4D2B]', 'text-white');
                btn.classList.add('text-gray-500', 'hover:text-gray-700');
            });

            this.classList.add('active', 'bg-[#1E4D2B]', 'text-white');
            this.classList.remove('text-gray-500', 'hover:text-gray-700');

            // Filter Baris Tabel & Hitung Jumlah Baris Tampil
            tableRows.forEach(row => {
                const category = row.getAttribute('data-cat');
                
                if (selectedTab === 'all' || category === selectedTab) {
                    row.style.display = '';
                    visibleCount++;
                } else {
                    row.style.display = 'none';
                }
            });

            // Update teks jumlah data di footer
            if (countDisplay) {
                countDisplay.textContent = `Menampilkan ${visibleCount} pengajuan`;
            }
        });
    });
});

// Helper Ambil CSRF Token
function getCsrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
}

// Handler Aksi Approve (AJAX)
function approveRow(button) {
    const id = button.getAttribute('data-id');
    const row = button.closest('tr');

    if (confirm('Apakah Anda yakin ingin menyetujui data ini?')) {
        fetch(`/admin/contributions/${id}/approve`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Gagal memproses data');
            return response.json();
        })
        .then(data => {
            // Update Status Badge menjadi Approved
            const statusCell = row.querySelector('td:nth-child(6)');
            statusCell.innerHTML = `<span class="bg-emerald-100 text-emerald-700 font-semibold text-[10px] px-2 py-0.5 rounded-full capitalize">Approved</span>`;
            
            // Ubah Tombol Aksi
            const actionCell = row.querySelector('td:nth-child(7)');
            actionCell.innerHTML = `<span class="text-xs text-emerald-600 font-medium italic"><i class="fa-solid fa-circle-check mr-1"></i>Disetujui</span>`;
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menyetujui data.');
        });
    }
}

// Handler Aksi Reject (AJAX)
function openReject(button) {
    const id = button.getAttribute('data-id');
    const row = button.closest('tr');

    const reason = prompt('Masukkan alasan penolakan data ini:');
    
    if (reason !== null && reason.trim() !== "") {
        fetch(`/admin/contributions/${id}/reject`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': getCsrfToken(),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({ note: reason })
        })
        .then(response => {
            if (!response.ok) throw new Error('Gagal memproses data');
            return response.json();
        })
        .then(data => {
            // Update Status Badge menjadi Rejected
            const statusCell = row.querySelector('td:nth-child(6)');
            statusCell.innerHTML = `<span class="bg-red-100 text-red-700 font-semibold text-[10px] px-2 py-0.5 rounded-full capitalize">Rejected</span>`;
            
            // Ubah Tombol Aksi
            const actionCell = row.querySelector('td:nth-child(7)');
            actionCell.innerHTML = `<span class="text-xs text-rose-500 font-medium italic"><i class="fa-solid fa-circle-xmark mr-1"></i>Ditolak</span>`;
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Gagal menolak data.');
        });
    }
}