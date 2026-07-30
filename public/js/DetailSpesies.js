/**
 * DetailSpesies.js — Tab navigasi & image switcher untuk halaman detail spesies & herbal
 */

// ─────────────────────────────────────────────────────
// Tab Navigation
// ─────────────────────────────────────────────────────
window.openTab = function(evt, tabName) {
    // Sembunyikan semua konten tab
    document.querySelectorAll('.tab-content').forEach(el => {
        el.classList.remove('active');
    });

    // Hapus status aktif dari semua tombol tab
    document.querySelectorAll('.tab-btn').forEach(el => {
        el.classList.remove('active');
    });

    // Tampilkan tab yang dipilih
    const targetTab = document.getElementById(tabName);
    if (targetTab) {
        targetTab.classList.add('active');
    }

    // Tandai tombol yang aktif
    const btn = evt && (evt.currentTarget || evt.target);
    if (btn) {
        btn.classList.add('active');
    }
};

// ─────────────────────────────────────────────────────
// Image Switcher (Gallery Thumbnail)
// ─────────────────────────────────────────────────────
window.switchImage = function(thumbEl, src, alt) {
    const mainImg = document.getElementById('main-img');
    if (mainImg) {
        mainImg.style.opacity = '0';
        setTimeout(() => {
            mainImg.src = src;
            if (alt) mainImg.alt = alt;
            mainImg.style.opacity = '1';
        }, 150);
    }
    document.querySelectorAll('.thumb').forEach(t => t.classList.remove('thumb-active'));
    if (thumbEl) {
        thumbEl.classList.add('thumb-active');
    }
};

// ─────────────────────────────────────────────────────
// Inisialisasi saat DOM siap
// ─────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', function() {
    // Aktifkan tab pertama yang ada secara default
    const firstTab = document.querySelector('.tab-btn');
    const firstContent = document.querySelector('.tab-content');

    if (firstTab && !document.querySelector('.tab-btn.active')) {
        firstTab.classList.add('active');
    }
    if (firstContent && !document.querySelector('.tab-content.active')) {
        firstContent.classList.add('active');
    }

    // Transisi gambar utama (smooth fade)
    const mainImg = document.getElementById('main-img');
    if (mainImg) {
        mainImg.style.transition = 'opacity 0.15s ease';
    }
});
