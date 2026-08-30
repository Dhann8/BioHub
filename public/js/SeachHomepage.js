document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('heroGlobalSearchForm');
    const searchInput = document.getElementById('globalSearchInput');
    const categorySelect = document.getElementById('globalCategorySelect');
    const searchBtn = document.getElementById('searchBtn');

    if (!searchForm) return;

    searchForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const query = searchInput.value.trim();
        const category = categorySelect ? categorySelect.value : '';

        if (!query) return;

        // Ambil URL API dari atribut data-action form atau fallback ke endpoint lokal
        const apiUrl = searchForm.dataset.apiUrl || '/api/global-search';

        // State loading
        searchBtn.disabled = true;
        const originalBtnHtml = searchBtn.innerHTML;
        searchBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> <span>Mencari...</span>`;

        try {
            const response = await fetch(`${apiUrl}?search=${encodeURIComponent(query)}&kategori=${category}`, {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            // Cek apakah server mengembalikan HTML Error alih-alih JSON
            const data = await response.json();

            if (data.status === 'success' && data.redirect_url) {
                // Pindah ke halaman detail jika data ditemukan
                window.location.href = data.redirect_url;
            } else {
                alert(data.message || `Data tidak ditemukan (HTTP ${response.status})`);
            }
        } catch (error) {
            console.error('Search error:', error);
            alert('Terjadi kesalahan sistem atau data tidak ditemukan.');
        } finally {
            searchBtn.disabled = false;
            searchBtn.innerHTML = originalBtnHtml;
        }
    });
});
