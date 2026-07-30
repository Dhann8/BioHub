// Fungsi toggle skeleton saat data siap
window.hideSkeleton = function(containerId) {
    const container = document.getElementById(containerId);
    if (!container) return;

    // Sembunyikan elemen skeleton
    const skeletons = container.querySelectorAll('.skeleton');
    skeletons.forEach(el => el.classList.add('hidden'));

    // Tampilkan konten asli
    const content = container.querySelector('.content-data');
    if (content) content.classList.remove('hidden');
};