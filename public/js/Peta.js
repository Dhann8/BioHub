document.addEventListener('DOMContentLoaded', function () {
  const drawer = document.getElementById('species-drawer');
  const gridView = document.getElementById('grid-view');
  
  // Use data from backend
  const speciesData = window.dynamicSpeciesData || {};

  window.openDrawer = function(speciesKey) {
    if (!drawer) return;
    const s = speciesData[speciesKey];
    if (s) {
      const nameEl = document.getElementById('drawer-name');
      const latinEl = document.getElementById('drawer-latin');
      const catEl = document.getElementById('drawer-cat');
      const descEl = document.getElementById('drawer-desc');
      const imgEl = document.getElementById('drawer-img');
      const statusEl = document.getElementById('drawer-status');
      const detailBtn = document.getElementById('drawer-detail-btn');

      if (nameEl) nameEl.innerText = s.name;
      if (latinEl) latinEl.innerText = s.latin;
      if (catEl) catEl.innerText = s.cat;
      if (descEl) descEl.innerText = s.desc;
      if (imgEl && s.img) imgEl.src = s.img;
      if (detailBtn) detailBtn.href = '/detail-spesies/' + (s.id || '');

      if (statusEl) {
        statusEl.innerHTML = `<i class="fa-solid fa-triangle-exclamation"></i> ${s.status.toUpperCase()}`;
        statusEl.className = `${s.statusClass} text-white text-[10px] font-black px-3 py-1.5 rounded-lg shadow-sm flex items-center gap-1.5 uppercase`;
      }
    }

    drawer.classList.remove('drawer-closed');
    drawer.classList.add('drawer-open');
  };

  window.closeDrawer = function() {
    if (!drawer) return;
    drawer.classList.add('drawer-closed');
    drawer.classList.remove('drawer-open');
  };

  window.toggleView = function(view) {
    if (!gridView) return;
    if (view === 'grid') {
      gridView.classList.remove('hidden');
    } else {
      gridView.classList.add('hidden');
    }
  };

  // Toggle view button listeners
  document.querySelectorAll('button').forEach(btn => {
    if (btn.innerText.includes('Grid')) {
      btn.addEventListener('click', () => window.toggleView('grid'));
    } else if (btn.innerText.includes('Peta') || btn.innerText.includes('Kembali ke Peta')) {
      btn.addEventListener('click', () => window.toggleView('map'));
    }
  });

  // Filtering Logic
  const applyBtn = document.getElementById('apply-filter');
  const resetBtn = document.getElementById('reset-filter');
  const searchInput = document.getElementById('filter-search');

  function applyFilters() {
    const activeCats = Array.from(document.querySelectorAll('.filter-cat:checked')).map(cb => cb.value);
    const activeStatuses = Array.from(document.querySelectorAll('.filter-status:checked')).map(cb => cb.value);
    const region = document.getElementById('filter-region') ? document.getElementById('filter-region').value : "Semua Wilayah";
    const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : "";

    const pins = document.querySelectorAll('.map-pin-container');
    const cards = document.querySelectorAll('.grid-card-container');

    const filterElement = (el) => {
      const cat = el.getAttribute('data-category');
      const status = el.getAttribute('data-status');
      const name = el.getAttribute('data-name');
      const itemRegion = el.getAttribute('data-region');

      let show = true;
      if (activeCats.length > 0 && !activeCats.includes(cat)) show = false;
      if (activeStatuses.length > 0 && !activeStatuses.includes(status)) show = false;
      if (searchTerm && (!name || !name.includes(searchTerm))) show = false;
      if (region && region !== "Semua Wilayah" && itemRegion !== region) show = false;

      if (show) {
        el.classList.remove('hidden');
      } else {
        el.classList.add('hidden');
      }
    };

    pins.forEach(filterElement);
    cards.forEach(filterElement);
  }

  if (applyBtn) {
    applyBtn.addEventListener('click', applyFilters);
  }

  // Realtime Search input
  if (searchInput) {
    searchInput.addEventListener('input', applyFilters);
  }

  const regionSelect = document.getElementById('filter-region');
  if (regionSelect) {
    regionSelect.addEventListener('change', applyFilters);
  }

  if (resetBtn) {
    resetBtn.addEventListener('click', () => {
      document.querySelectorAll('.filter-cat, .filter-status').forEach(cb => cb.checked = false);
      if (searchInput) searchInput.value = '';
      if (document.getElementById('filter-region')) document.getElementById('filter-region').value = "Semua Wilayah";
      applyFilters();
    });
  }
});
