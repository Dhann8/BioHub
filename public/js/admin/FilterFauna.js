document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('filter-search');
    const iucnSelect = document.getElementById('filter-iucn');
    const classSelect = document.getElementById('filter-class');
    const resetButton = document.getElementById('filter-reset');
    const faunaRows = document.querySelectorAll('.fauna-row');

    function applyFilters() {
        const searchValue = searchInput ? searchInput.value.toLowerCase().trim() : '';
        const iucnValue = iucnSelect ? iucnSelect.value.toUpperCase() : '';
        const classValue = classSelect ? classSelect.value.toLowerCase() : '';

        faunaRows.forEach(row => {
            const nameData = (row.getAttribute('data-name') || '').toLowerCase();
            const iucnData = (row.getAttribute('data-iucn') || '').toUpperCase();
            const classData = (row.getAttribute('data-class') || '').toLowerCase();

            const matchesSearch = !searchValue || nameData.includes(searchValue);
            const matchesIucn = !iucnValue || iucnData === iucnValue;
            const matchesClass = !classValue || classData === classValue;

            if (matchesSearch && matchesIucn && matchesClass) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    }

    // Event Listener untuk live filter saat mengetik atau memilih dropdown
    if (searchInput) searchInput.addEventListener('input', applyFilters);
    if (iucnSelect) iucnSelect.addEventListener('change', applyFilters);
    if (classSelect) classSelect.addEventListener('change', applyFilters);

    // Event Listener untuk Reset Filter
    if (resetButton) {
        resetButton.addEventListener('click', function () {
            if (searchInput) searchInput.value = '';
            if (iucnSelect) iucnSelect.value = '';
            if (classSelect) classSelect.value = '';
            applyFilters();
        });
    }
});