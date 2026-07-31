document.addEventListener('DOMContentLoaded', function () {
    const searchForm = document.getElementById('heroGlobalSearchForm');
    const searchInput = document.getElementById('globalSearchInput');
    const categorySelect = document.getElementById('globalCategorySelect');
    const searchBtn = document.getElementById('searchBtn');

    searchForm.addEventListener('submit', async function (e) {
        e.preventDefault();

        const query = searchInput.value.trim();
        const category = categorySelect.value;

        if (!query) return;

        // State loading
        searchBtn.disabled = true;
        const originalBtnHtml = searchBtn.innerHTML;
        searchBtn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> <span>Mencari...</span>`;

        try {
            const response = await fetch(`{{ route('api.global-search') }}?search=${encodeURIComponent(query)}&kategori=${category}`);
            const data = await response.json();

            if (data.status === 'success' && data.redirect_url) {
                // Jika ketemu, langsung pindah ke halaman detail
                window.location.href = data.redirect_url;
            } else {
                // Jika data tidak tersedia
                alert(data.message || 'Data tidak tersedia');
            }
        } catch (error) {
            console.error('Search error:', error);
            alert('Terjadi kesalahan koneksi atau data tidak ditemukan.');
        } finally {
            searchBtn.disabled = false;
            searchBtn.innerHTML = originalBtnHtml;
        }
    });
});