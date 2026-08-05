/**
 * BioHub Interactive GIS & Biodiversity Map Engine
 * Powered by Leaflet.js and OpenStreetMap / Esri World Imagery
 */

(function () {
  'use strict';

  // Global map & layer state
  let map = null;
  let streetsLayer = null;
  let satelliteLayer = null;
  let currentLayerType = 'streets';
  let markersGroup = null;
  let wallaceLayerGroup = null;
  let hotspotsLayerGroup = null;
  let userLocationMarker = null;
  let currentSpeciesKey = null;
  let activeTaxonomyFilter = 'all';

  // Species dataset & taxonomies passed from Blade
  const speciesData = window.dynamicSpeciesData || {};
  const taxonomiesList = window.dynamicTaxonomies || [];

  // Region centers & default zoom levels for Indonesia
  const regionCoordinates = {
    'Semua Wilayah': { center: [-2.5, 118.0], zoom: 5 },
    'Sumatra': { center: [0.5897, 101.3431], zoom: 6 },
    'Jawa': { center: [-7.6145, 110.7122], zoom: 7 },
    'Kalimantan': { center: [-0.2787, 113.9213], zoom: 6 },
    'Sulawesi': { center: [-1.4300, 121.4456], zoom: 6 },
    'Papua': { center: [-4.2699, 138.0804], zoom: 6 },
    'Nusa Tenggara & Bali': { center: [-8.6529, 117.3616], zoom: 7 },
    'Maluku': { center: [-3.2385, 130.1453], zoom: 6 }
  };

  // Marker registry: key -> { marker, data }
  const markersRegistry = {};

  /**
   * Biogeographical Data: Wallace & Weber Lines
   */
  const wallaceCoords = [
    [7.5, 119.5],
    [4.5, 119.2],
    [1.5, 119.0],
    [-0.5, 118.8],
    [-2.5, 117.8],
    [-5.5, 116.5],
    [-8.3, 115.8],
    [-11.5, 115.5]
  ];

  const weberCoords = [
    [6.0, 130.0],
    [2.0, 129.5],
    [-1.0, 129.0],
    [-4.0, 129.5],
    [-7.0, 131.0],
    [-10.0, 131.5],
    [-12.0, 131.0]
  ];

  /**
   * Conservation Hotspots / National Parks
   */
  const conservationHotspots = [
    {
      name: "TN Gunung Leuser",
      region: "Sumatra",
      lat: 3.5852,
      lng: 97.4338,
      area: "7.927 km²",
      desc: "Habitat utama Orangutan Sumatra, Harimau Sumatra, Badak Sumatra, dan Gajah Sumatra."
    },
    {
      name: "TN Kerinci Seblat",
      region: "Sumatra",
      lat: -2.4206,
      lng: 101.4883,
      area: "13.750 km²",
      desc: "Kawasan konservasi terbesar di Sumatra, benteng terakhir Harimau Sumatra liar."
    },
    {
      name: "TN Ujung Kulon",
      region: "Jawa",
      lat: -6.7500,
      lng: 105.3333,
      area: "1.206 km²",
      desc: "Satu-satunya habitat alami yang tersisa bagi Badak Jawa (Rhinoceros sondaicus)."
    },
    {
      name: "TN Tanjung Puting",
      region: "Kalimantan",
      lat: -2.9000,
      lng: 111.9000,
      area: "4.150 km²",
      desc: "Pusat konservasi dan rehabilitasi Orangutan Kalimantan terbesar di dunia."
    },
    {
      name: "TN Komodo",
      region: "Nusa Tenggara & Bali",
      lat: -8.5833,
      lng: 119.4833,
      area: "1.733 km²",
      desc: "Situs Warisan Dunia UNESCO habitat kadal purba raksasa Komodo (Varanus komodoensis)."
    },
    {
      name: "TN Lorentz",
      region: "Papua",
      lat: -4.7500,
      lng: 137.8333,
      area: "25.056 km²",
      desc: "Taman nasional terbesar di Asia Tenggara, membentang dari puncak salju abadi hingga laut tropis."
    },
    {
      name: "TN Bogani Nani Wartabone",
      region: "Sulawesi",
      lat: 0.5500,
      lng: 123.6000,
      area: "2.871 km²",
      desc: "Kawasan endemik Maleo Senkawor, Anoa, dan Babirusa Sulawesi."
    },
    {
      name: "TN Aketajawe-Lolobata",
      region: "Maluku",
      lat: 0.8500,
      lng: 127.8500,
      area: "1.673 km²",
      desc: "Habitat penting Burung Bidadari Halmahera (Semioptera wallacii) dan rempah purba."
    }
  ];

  /**
   * Initialize Leaflet GIS Map
   */
  function initMap() {
    const mapContainer = document.getElementById('map');
    if (!mapContainer || typeof L === 'undefined') {
      console.warn('Map container or Leaflet library not found.');
      return;
    }

    // Default center on Indonesia
    const initialView = regionCoordinates['Semua Wilayah'];
    map = L.map('map', {
      center: initialView.center,
      zoom: initialView.zoom,
      minZoom: 4,
      maxZoom: 18,
      zoomControl: false, // Custom controls used
      attributionControl: false
    });

    // 1. Street / Topographic Base Layer (OpenStreetMap)
    streetsLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      subdomains: ['a', 'b', 'c']
    });

    // 2. High-resolution Satellite Base Layer (Esri World Imagery)
    satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
      maxZoom: 19
    });

    // Set initial base layer
    streetsLayer.addTo(map);

    // Marker Layer Group
    markersGroup = L.layerGroup().addTo(map);

    // Biogeography & Hotspots Layer Groups
    wallaceLayerGroup = L.layerGroup();
    hotspotsLayerGroup = L.layerGroup();

    // Build Biogeography Lines & Hotspots
    buildBiogeographyLayers();
    buildHotspotsLayer();

    // Render all markers
    renderMarkers();

    // Setup Coordinate HUD Mouse Listener
    setupCoordinateHUD();

    // Initial filter application
    applyFilters();

    // Process initial URL Query parameters (e.g. ?species=fauna_1&region=Sumatra)
    handleUrlQueryParams();

    // Update bookmark badge in header
    updateHeaderBookmarkBadge();
  }

  /**
   * Setup Coordinate HUD on Map Mousemove
   */
  function setupCoordinateHUD() {
    if (!map) return;
    const hudLatLng = document.getElementById('hud-latlng');
    const hudZoom = document.getElementById('hud-zoom');

    map.on('mousemove', function (e) {
      if (hudLatLng) {
        hudLatLng.innerText = `Lat: ${e.latlng.lat.toFixed(4)} | Lng: ${e.latlng.lng.toFixed(4)}`;
      }
    });

    map.on('zoomend', function () {
      if (hudZoom) {
        hudZoom.innerText = `Zoom: ${map.getZoom()}x`;
      }
    });
  }

  /**
   * Build Wallace & Weber Biogeographical Line Layer
   */
  function buildBiogeographyLayers() {
    // 1. Wallace Line (Barat / Sundaland vs Wallacea)
    const wallaceLine = L.polyline(wallaceCoords, {
      color: '#4F46E5',
      weight: 3,
      dashArray: '8, 8',
      opacity: 0.85
    });

    wallaceLine.bindTooltip(`
      <div class="p-1 font-sans">
        <p class="font-black text-indigo-700 text-xs flex items-center gap-1">
          <i class="fa-solid fa-wave-square"></i> Garis Wallace (1859)
        </p>
        <p class="text-[10px] text-gray-600">Pemisah Fauna Zona Oriental / Asia (Borneo, Bali) dengan Wallacea (Sulawesi, Lombok).</p>
      </div>
    `, { sticky: true, className: 'biogeo-tooltip' });

    // 2. Weber Line (Wallacea vs Timur / Sahul)
    const weberLine = L.polyline(weberCoords, {
      color: '#D97706',
      weight: 3,
      dashArray: '6, 6',
      opacity: 0.85
    });

    weberLine.bindTooltip(`
      <div class="p-1 font-sans">
        <p class="font-black text-amber-700 text-xs flex items-center gap-1">
          <i class="fa-solid fa-wave-square"></i> Garis Weber (1904)
        </p>
        <p class="text-[10px] text-gray-600">Pemisah Keseimbangan Fauna Australasia (Papua, Maluku) dengan Zona Peralihan Wallacea.</p>
      </div>
    `, { sticky: true, className: 'biogeo-tooltip' });

    wallaceLayerGroup.addLayer(wallaceLine);
    wallaceLayerGroup.addLayer(weberLine);
  }

  /**
   * Build Conservation Hotspots / National Parks Overlay
   */
  function buildHotspotsLayer() {
    conservationHotspots.forEach(park => {
      const parkIcon = L.divIcon({
        html: `
          <div class="hotspot-pin flex items-center justify-center w-8 h-8 bg-emerald-600 text-white rounded-2xl shadow-lg border-2 border-white cursor-pointer transform hover:scale-125 transition-transform">
            <i class="fa-solid fa-shield-halved text-xs"></i>
          </div>
        `,
        className: 'custom-hotspot-pin',
        iconSize: [32, 32],
        iconAnchor: [16, 16]
      });

      const hotspotMarker = L.marker([park.lat, park.lng], { icon: parkIcon });
      
      const popupHtml = `
        <div class="p-3 font-sans max-w-[240px]">
          <span class="bg-emerald-100 text-emerald-800 text-[9px] font-bold px-2 py-0.5 rounded-full mb-1 inline-block">
            Taman Nasional & Hotspot
          </span>
          <h4 class="font-black text-sm text-gray-900 leading-tight mb-1">${park.name}</h4>
          <p class="text-[10px] text-gray-500 mb-2">Wilayah: <strong>${park.region}</strong> · Luas: ${park.area}</p>
          <p class="text-xs text-gray-600 leading-relaxed mb-3">${park.desc}</p>
          <button onclick="filterRegionFromHotspot('${park.region}')" class="w-full bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-bold py-1.5 rounded-lg text-xs transition text-center shadow-sm">
            Lihat Spesies Wilayah Ini
          </button>
        </div>
      `;

      hotspotMarker.bindPopup(popupHtml);
      hotspotsLayerGroup.addLayer(hotspotMarker);
    });
  }

  /**
   * Toggle Wallace Line on Map
   */
  window.toggleWallaceLine = function () {
    if (!map) return;
    const btn = document.getElementById('btn-toggle-wallace');

    if (map.hasLayer(wallaceLayerGroup)) {
      map.removeLayer(wallaceLayerGroup);
      if (btn) {
        btn.className = 'bg-white/95 backdrop-blur-md hover:bg-white text-gray-700 font-semibold px-3 py-2.5 rounded-xl shadow-lg border border-gray-200 flex items-center gap-1.5 text-xs transition cursor-pointer';
      }
      window.showToast('Garis Wallace & Weber disembunyikan', 'fa-eye-slash');
    } else {
      wallaceLayerGroup.addTo(map);
      if (btn) {
        btn.className = 'bg-indigo-600 text-white font-bold px-3 py-2.5 rounded-xl shadow-lg border border-indigo-700 flex items-center gap-1.5 text-xs transition cursor-pointer shadow-indigo-900/20';
      }
      window.showToast('Garis Wallace & Weber diaktifkan', 'fa-wave-square');
    }
  };

  /**
   * Toggle Hotspots Layer on Map
   */
  window.toggleHotspotsLayer = function () {
    if (!map) return;
    const btn = document.getElementById('btn-toggle-hotspots');

    if (map.hasLayer(hotspotsLayerGroup)) {
      map.removeLayer(hotspotsLayerGroup);
      if (btn) {
        btn.className = 'bg-white/95 backdrop-blur-md hover:bg-white text-gray-700 font-semibold px-3 py-2.5 rounded-xl shadow-lg border border-gray-200 flex items-center gap-1.5 text-xs transition cursor-pointer';
      }
      window.showToast('Hotspot Taman Nasional disembunyikan', 'fa-eye-slash');
    } else {
      hotspotsLayerGroup.addTo(map);
      if (btn) {
        btn.className = 'bg-emerald-700 text-white font-bold px-3 py-2.5 rounded-xl shadow-lg border border-emerald-800 flex items-center gap-1.5 text-xs transition cursor-pointer shadow-emerald-900/20';
      }
      window.showToast('Kawasan Taman Nasional & Hotspot diaktifkan', 'fa-shield-halved');
    }
  };

  /**
   * Filter region directly when clicked from hotspot popup
   */
  window.filterRegionFromHotspot = function (regionName) {
    const regionSelect = document.getElementById('filter-region');
    if (regionSelect) {
      regionSelect.value = regionName;
      applyFilters();
      const target = regionCoordinates[regionName] || regionCoordinates['Semua Wilayah'];
      if (map) {
        map.flyTo(target.center, target.zoom, { duration: 1.2 });
      }
      window.showToast(`Peta beralih ke: ${regionName}`, 'fa-map-pin');
    }
  };

  /**
   * Fullscreen Toggle API
   */
  window.toggleMapFullscreen = function () {
    const mapWrapper = document.getElementById('map-main-wrapper');
    const icon = document.getElementById('fullscreen-icon');
    if (!mapWrapper) return;

    if (!document.fullscreenElement) {
      if (mapWrapper.requestFullscreen) {
        mapWrapper.requestFullscreen();
      } else if (mapWrapper.webkitRequestFullscreen) {
        mapWrapper.webkitRequestFullscreen();
      }
      if (icon) icon.className = 'fa-solid fa-compress text-xs';
      window.showToast('Mode Layar Penuh diaktifkan', 'fa-expand');
    } else {
      if (document.exitFullscreen) {
        document.exitFullscreen();
      }
      if (icon) icon.className = 'fa-solid fa-expand text-xs';
      window.showToast('Keluar dari Layar Penuh', 'fa-compress');
    }
  };

  /**
   * Create custom HTML Marker Icon
   */
  function createCustomIcon(species) {
    const isFlora = species.type === 'flora';
    const status = (species.status || 'lc').toLowerCase();

    // Border color based on category and status
    let borderColorClass = 'border-status-' + status;
    let badgeBgClass = 'bg-status-' + status;
    let pulseColor = '#1B5E20';

    if (isFlora) {
      borderColorClass = 'border-[#2E7D32]';
      badgeBgClass = 'bg-[#2E7D32]';
      pulseColor = '#2E7D32';
    } else {
      if (status === 'cr') pulseColor = '#B71C1C';
      else if (status === 'en') pulseColor = '#E65100';
      else if (status === 'vu') pulseColor = '#F57F17';
    }

    const badgeIcon = isFlora
      ? '<i class="fa-solid fa-seedling text-[8px] text-white flex items-center justify-center h-full"></i>'
      : '<i class="fa-solid fa-paw text-[7px] text-white flex items-center justify-center h-full"></i>';

    const html = `
      <div class="custom-map-pin" data-key="${species.key}">
        <div class="pin-pulse" style="background-color: ${pulseColor};"></div>
        <div class="pin-avatar ${borderColorClass}">
          <img src="${species.img}" alt="${species.name}" onerror="this.src='https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_3a21343fd1_225b4e4a886799f4.png'" />
        </div>
        <div class="pin-badge ${badgeBgClass}">
          ${badgeIcon}
        </div>
      </div>
    `;

    return L.divIcon({
      html: html,
      className: 'custom-leaflet-pin',
      iconSize: [44, 44],
      iconAnchor: [22, 22],
      popupAnchor: [0, -24]
    });
  }

  /**
   * Render all species markers on map
   */
  function renderMarkers() {
    markersGroup.clearLayers();

    Object.keys(speciesData).forEach(key => {
      const s = speciesData[key];
      if (!s.lat || !s.lng) return;

      const icon = createCustomIcon(s);
      const marker = L.marker([s.lat, s.lng], { icon: icon });

      // Rich popup content
      const popupHtml = `
        <div class="w-60 overflow-hidden font-sans">
          <div class="h-28 relative bg-gray-900">
            <img src="${s.img}" class="w-full h-full object-cover" alt="${s.name}" onerror="this.src='https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_3a21343fd1_225b4e4a886799f4.png'"/>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
            <span class="absolute top-2.5 left-2.5 ${s.statusClass} text-white text-[9px] font-black px-2 py-0.5 rounded shadow">
              ${s.status}
            </span>
          </div>
          <div class="p-3.5 bg-white">
            <p class="text-[9px] font-bold text-[#D97706] uppercase tracking-wider mb-0.5">${s.cat}</p>
            <h4 class="font-extrabold text-sm text-gray-900 leading-tight">${s.name}</h4>
            <p class="text-[11px] italic text-gray-400 mb-3">${s.latin}</p>
            <div class="flex items-center gap-2">
              <button onclick="window.openDrawer('${s.key}')" class="flex-1 bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-bold py-1.5 px-3 rounded-lg text-xs transition text-center shadow-sm cursor-pointer">
                Buka Info Cepat
              </button>
              <a href="${s.detailUrl}" class="p-1.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg transition text-xs flex items-center justify-center" title="Halaman Detail">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
              </a>
            </div>
          </div>
        </div>
      `;

      marker.bindPopup(popupHtml, { maxWidth: 260 });

      // Click handler
      marker.on('click', function () {
        window.openDrawer(s.key);
      });

      markersRegistry[s.key] = {
        marker: marker,
        data: s
      };
    });
  }

  /**
   * Base Layer Switcher (Streets vs Satellite)
   */
  window.switchBaseLayer = function (type) {
    if (!map) return;
    currentLayerType = type;

    const btnStreets = document.getElementById('btn-layer-streets');
    const btnSatellite = document.getElementById('btn-layer-satellite');

    if (type === 'streets') {
      if (map.hasLayer(satelliteLayer)) map.removeLayer(satelliteLayer);
      if (!map.hasLayer(streetsLayer)) streetsLayer.addTo(map);

      if (btnStreets) {
        btnStreets.className = 'p-2.5 rounded-xl bg-[#2E7D32] text-white transition-all cursor-pointer shadow-sm';
      }
      if (btnSatellite) {
        btnSatellite.className = 'p-2.5 rounded-xl text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition-all cursor-pointer';
      }
      window.showToast('Mode Peta Topografi / Standar diaktifkan', 'fa-layer-group');
    } else {
      if (map.hasLayer(streetsLayer)) map.removeLayer(streetsLayer);
      if (!map.hasLayer(satelliteLayer)) satelliteLayer.addTo(map);

      if (btnSatellite) {
        btnSatellite.className = 'p-2.5 rounded-xl bg-[#2E7D32] text-white transition-all cursor-pointer shadow-sm';
      }
      if (btnStreets) {
        btnStreets.className = 'p-2.5 rounded-xl text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition-all cursor-pointer';
      }
      window.showToast('Mode Citra Satelit Esri diaktifkan', 'fa-satellite');
    }
  };

  /**
   * Zoom Controls
   */
  window.zoomInMap = function () {
    if (map) map.zoomIn();
  };

  window.zoomOutMap = function () {
    if (map) map.zoomOut();
  };

  /**
   * Recenter or Geolocation
   */
  window.recenterMap = function () {
    if (!map) return;

    if (navigator.geolocation) {
      window.showToast('Mencari koordinat lokasi Anda...', 'fa-location-dot');
      navigator.geolocation.getCurrentPosition(
        function (pos) {
          const userLat = pos.coords.latitude;
          const userLng = pos.coords.longitude;

          if (userLocationMarker) {
            map.removeLayer(userLocationMarker);
          }

          const userIcon = L.divIcon({
            html: `
              <div class="relative flex items-center justify-center w-8 h-8">
                <div class="absolute w-8 h-8 bg-blue-500 rounded-full animate-ping opacity-60"></div>
                <div class="relative w-4 h-4 bg-blue-600 rounded-full border-2 border-white shadow-lg"></div>
              </div>
            `,
            className: 'user-loc-pin',
            iconSize: [32, 32],
            iconAnchor: [16, 16]
          });

          userLocationMarker = L.marker([userLat, userLng], { icon: userIcon }).addTo(map);
          userLocationMarker.bindPopup('<p class="text-xs font-bold text-gray-800 p-2">Lokasi Anda Saat Ini</p>').openPopup();

          map.flyTo([userLat, userLng], 11, { duration: 1.5 });
          window.showToast('Peta dipusatkan ke lokasi Anda', 'fa-circle-check');
        },
        function () {
          // Fallback to Indonesia view
          const initial = regionCoordinates['Semua Wilayah'];
          map.flyTo(initial.center, initial.zoom, { duration: 1.2 });
          window.showToast('Peta dipusatkan ke seluruh kepulauan Indonesia', 'fa-map');
        },
        { timeout: 6000 }
      );
    } else {
      const initial = regionCoordinates['Semua Wilayah'];
      map.flyTo(initial.center, initial.zoom, { duration: 1.2 });
      window.showToast('Peta dipusatkan ke seluruh kepulauan Indonesia', 'fa-map');
    }
  };

  /**
   * Taxonomy Filter Chip Setter
   */
  window.setTaxonomyFilter = function (taxName) {
    activeTaxonomyFilter = taxName;

    // Update chip styles
    document.querySelectorAll('.tax-chip').forEach(btn => {
      if (btn.getAttribute('data-tax') === taxName) {
        btn.className = 'tax-chip px-2.5 py-1 rounded-lg text-xs font-bold transition-all bg-[#2E7D32] text-white shadow-sm';
      } else {
        btn.className = 'tax-chip px-2.5 py-1 rounded-lg text-xs font-semibold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200';
      }
    });

    applyFilters();
    window.showToast(taxName === 'all' ? 'Menampilkan semua kelas taksonomi' : `Filter taksonomi: ${taxName}`, 'fa-filter');
  };

  /**
   * Toggle all IUCN status checkboxes
   */
  window.toggleAllStatusFilters = function () {
    const statusCbs = document.querySelectorAll('.filter-status');
    const allChecked = Array.from(statusCbs).every(cb => cb.checked);
    statusCbs.forEach(cb => cb.checked = !allChecked);
    applyFilters();
  };

  /**
   * Realtime Filtering Logic
   */
  function applyFilters() {
    const activeCats = Array.from(document.querySelectorAll('.filter-cat:checked')).map(cb => cb.value.toLowerCase());
    const activeStatuses = Array.from(document.querySelectorAll('.filter-status:checked')).map(cb => cb.value.toLowerCase());
    const regionSelect = document.getElementById('filter-region');
    const region = regionSelect ? regionSelect.value : 'Semua Wilayah';
    const searchInput = document.getElementById('filter-search');
    const searchTerm = searchInput ? searchInput.value.toLowerCase().trim() : '';

    // Update category label active styles
    const catFauna = document.getElementById('filter-cat-fauna');
    const catFlora = document.getElementById('filter-cat-flora');
    const labelFauna = document.getElementById('label-cat-fauna');
    const labelFlora = document.getElementById('label-cat-flora');

    if (labelFauna && catFauna) {
      if (catFauna.checked) {
        labelFauna.className = 'flex items-center justify-between p-3 rounded-xl border border-[#2E7D32] bg-[#E8F5E9]/60 cursor-pointer group transition-all';
      } else {
        labelFauna.className = 'flex items-center justify-between p-3 rounded-xl border border-gray-100 bg-gray-50 hover:border-gray-300 cursor-pointer group transition-all opacity-60';
      }
    }

    if (labelFlora && catFlora) {
      if (catFlora.checked) {
        labelFlora.className = 'flex items-center justify-between p-3 rounded-xl border border-[#2E7D32] bg-[#E8F5E9]/60 cursor-pointer group transition-all';
      } else {
        labelFlora.className = 'flex items-center justify-between p-3 rounded-xl border border-gray-100 bg-gray-50 hover:border-gray-300 cursor-pointer group transition-all opacity-60';
      }
    }

    let visibleCount = 0;
    const totalCount = Object.keys(speciesData).length;

    // Filter Map Markers
    markersGroup.clearLayers();

    Object.keys(speciesData).forEach(key => {
      const s = speciesData[key];
      const entry = markersRegistry[key];
      if (!entry) return;

      const type = (s.type || '').toLowerCase();
      const status = (s.status || '').toLowerCase();
      const taxonomy = (s.taxonomy || '');
      const itemRegion = s.region || 'Semua Wilayah';
      const searchText = (s.name + ' ' + s.latin + ' ' + (s.desc || '') + ' ' + (s.cat || '') + ' ' + (s.locationName || '')).toLowerCase();

      let isMatch = true;

      // Category check
      if (activeCats.length > 0 && !activeCats.includes(type)) {
        isMatch = false;
      }

      // Taxonomy class check
      if (activeTaxonomyFilter !== 'all') {
        if (!taxonomy.toLowerCase().includes(activeTaxonomyFilter.toLowerCase())) {
          isMatch = false;
        }
      }

      // Status check (only applies for faunas or if status is filtered)
      if (activeStatuses.length > 0 && !activeStatuses.includes(status)) {
        isMatch = false;
      }

      // Region check
      if (region !== 'Semua Wilayah') {
        if (itemRegion !== region && itemRegion !== 'Semua Wilayah') {
          isMatch = false;
        }
      }

      // Search term check
      if (searchTerm && !searchText.includes(searchTerm)) {
        isMatch = false;
      }

      if (isMatch) {
        markersGroup.addLayer(entry.marker);
        visibleCount++;
      }
    });

    // Filter Grid Cards
    const gridCards = document.querySelectorAll('.grid-card-container');
    gridCards.forEach(card => {
      const cardCategory = (card.getAttribute('data-category') || '').toLowerCase();
      const cardStatus = (card.getAttribute('data-status') || '').toLowerCase();
      const cardTaxonomy = card.getAttribute('data-taxonomy') || '';
      const cardRegion = card.getAttribute('data-region') || 'Semua Wilayah';
      const cardName = (card.getAttribute('data-name') || '').toLowerCase();

      let isMatch = true;

      if (activeCats.length > 0 && !activeCats.includes(cardCategory)) isMatch = false;
      if (activeTaxonomyFilter !== 'all' && !cardTaxonomy.toLowerCase().includes(activeTaxonomyFilter.toLowerCase())) isMatch = false;
      if (activeStatuses.length > 0 && !activeStatuses.includes(cardStatus)) isMatch = false;
      if (region !== 'Semua Wilayah' && cardRegion !== region && cardRegion !== 'Semua Wilayah') isMatch = false;
      if (searchTerm && !cardName.includes(searchTerm)) isMatch = false;

      if (isMatch) {
        card.classList.remove('hidden');
      } else {
        card.classList.add('hidden');
      }
    });

    // Update Counter Badges
    const badge = document.getElementById('active-count-badge');
    if (badge) {
      badge.innerText = visibleCount === totalCount ? `${visibleCount} Titik Spasial` : `${visibleCount} dari ${totalCount}`;
    }

    const gridVisibleCount = document.getElementById('grid-visible-count');
    const gridTotalCount = document.getElementById('grid-total-count');
    const gridCountBadge = document.getElementById('grid-count-badge');
    const gridEmptyState = document.getElementById('grid-empty-state');

    if (gridVisibleCount) gridVisibleCount.innerText = visibleCount;
    if (gridTotalCount) gridTotalCount.innerText = totalCount;
    if (gridCountBadge) gridCountBadge.innerText = visibleCount;

    if (gridEmptyState) {
      if (visibleCount === 0) {
        gridEmptyState.classList.remove('hidden');
      } else {
        gridEmptyState.classList.add('hidden');
      }
    }

    // Render active filter chips
    renderActiveFilterChips(activeCats, activeStatuses, region, activeTaxonomyFilter, searchTerm);
  }

  /**
   * Render Active Filter Chips Bar
   */
  function renderActiveFilterChips(cats, statuses, region, tax, search) {
    const chipsWrapper = document.getElementById('active-filter-chips');
    const container = document.getElementById('chips-container');
    if (!chipsWrapper || !container) return;

    const chips = [];

    if (region !== 'Semua Wilayah') {
      chips.push({ label: `Wilayah: ${region}`, remove: () => { document.getElementById('filter-region').value = 'Semua Wilayah'; applyFilters(); } });
    }

    if (tax !== 'all') {
      chips.push({ label: `Kelas: ${tax}`, remove: () => window.setTaxonomyFilter('all') });
    }

    if (search) {
      chips.push({ label: `"${search}"`, remove: () => { document.getElementById('filter-search').value = ''; applyFilters(); } });
    }

    if (statuses.length < 4 && statuses.length > 0) {
      chips.push({ label: `IUCN: ${statuses.map(s => s.toUpperCase()).join(', ')}`, remove: () => {
        document.querySelectorAll('.filter-status').forEach(cb => cb.checked = true);
        applyFilters();
      }});
    }

    if (cats.length === 1) {
      chips.push({ label: cats[0] === 'fauna' ? 'Hanya Fauna' : 'Hanya Flora', remove: () => {
        document.querySelectorAll('.filter-cat').forEach(cb => cb.checked = true);
        applyFilters();
      }});
    }

    if (chips.length === 0) {
      chipsWrapper.classList.add('hidden');
    } else {
      chipsWrapper.classList.remove('hidden');
      container.innerHTML = '';
      chips.forEach(chip => {
        const chipEl = document.createElement('span');
        chipEl.className = 'inline-flex items-center gap-1 bg-[#E8F5E9] text-[#1E4D2B] font-bold px-2 py-0.5 rounded-md text-[10px]';
        chipEl.innerHTML = `${chip.label} <button class="hover:text-red-600 ml-0.5 cursor-pointer">✕</button>`;
        chipEl.querySelector('button').addEventListener('click', chip.remove);
        container.appendChild(chipEl);
      });
    }
  }

  /**
   * Quick filter by status from legend
   */
  window.quickFilterStatus = function (status) {
    const statusCbs = document.querySelectorAll('.filter-status');
    statusCbs.forEach(cb => {
      cb.checked = (cb.value.toLowerCase() === status.toLowerCase());
    });
    applyFilters();
    window.showToast(`Memfilter status IUCN: ${status.toUpperCase()}`, 'fa-filter');
  };

  /**
   * Reset All Filters
   */
  window.resetAllFilters = function () {
    document.querySelectorAll('.filter-cat, .filter-status').forEach(cb => cb.checked = true);
    const searchInput = document.getElementById('filter-search');
    if (searchInput) searchInput.value = '';

    const regionSelect = document.getElementById('filter-region');
    if (regionSelect) regionSelect.value = 'Semua Wilayah';

    activeTaxonomyFilter = 'all';
    document.querySelectorAll('.tax-chip').forEach(btn => {
      if (btn.getAttribute('data-tax') === 'all') {
        btn.className = 'tax-chip px-2.5 py-1 rounded-lg text-xs font-bold transition-all bg-[#2E7D32] text-white shadow-sm';
      } else {
        btn.className = 'tax-chip px-2.5 py-1 rounded-lg text-xs font-semibold transition-all bg-gray-100 text-gray-600 hover:bg-gray-200';
      }
    });

    applyFilters();

    if (map) {
      const initial = regionCoordinates['Semua Wilayah'];
      map.flyTo(initial.center, initial.zoom, { duration: 1.2 });
    }

    window.showToast('Semua filter berhasil direset', 'fa-rotate-left');
  };

  /**
   * Quick View Drawer Open
   */
  window.openDrawer = function (speciesKey) {
    const drawer = document.getElementById('species-drawer');
    if (!drawer) return;

    let s = speciesData[speciesKey];
    if (!s) {
      // Find by parentKey if direct key not matched
      const matchedKey = Object.keys(speciesData).find(k => k === speciesKey || speciesData[k].parentKey === speciesKey);
      if (matchedKey) s = speciesData[matchedKey];
    }
    if (!s) return;

    currentSpeciesKey = s.key;

    const nameEl = document.getElementById('drawer-name');
    const latinEl = document.getElementById('drawer-latin');
    const catEl = document.getElementById('drawer-cat');
    const descEl = document.getElementById('drawer-desc');
    const imgEl = document.getElementById('drawer-img');
    const statusEl = document.getElementById('drawer-status');
    const detailBtn = document.getElementById('drawer-detail-btn');
    const sectionTitle = document.getElementById('drawer-section-title');
    const stat1Label = document.getElementById('drawer-stat1-label');
    const stat1Val = document.getElementById('drawer-stat1-val');
    const stat2Label = document.getElementById('drawer-stat2-label');
    const stat2Val = document.getElementById('drawer-stat2-val');
    const tagType = document.getElementById('drawer-tag-type');

    if (nameEl) nameEl.innerText = s.name;
    if (latinEl) latinEl.innerText = s.latin;
    if (catEl) catEl.innerText = s.cat;
    if (descEl) descEl.innerText = s.desc;
    if (imgEl && s.img) imgEl.src = s.img;
    if (detailBtn) detailBtn.href = s.detailUrl;

    if (sectionTitle) {
      sectionTitle.innerText = s.type === 'flora' ? 'Morfologi & Khasiat Herbal' : 'Habitat & Sebaran';
    }

    if (tagType) {
      tagType.innerHTML = s.type === 'flora' ? '<i class="fa-solid fa-seedling"></i> Tanaman Obat' : '<i class="fa-solid fa-shield-halved"></i> Dilindungi';
    }

    if (stat1Label) stat1Label.innerText = s.stat1_label || 'Habitat';
    if (stat1Val) stat1Val.innerText = s.stat1_val || '-';
    if (stat2Label) stat2Label.innerText = s.stat2_label || 'Status';
    if (stat2Val) {
      stat2Val.innerText = s.stat2_val || '-';
      if (s.stat2_val && s.stat2_val.toLowerCase().includes('menurun')) {
        stat2Val.className = 'text-xs font-black text-red-600 flex items-center gap-1';
        stat2Val.innerHTML = '<i class="fa-solid fa-arrow-trend-down"></i> Menurun';
      } else {
        stat2Val.className = 'text-xs font-black text-emerald-700 flex items-center gap-1';
        stat2Val.innerHTML = '<i class="fa-solid fa-check"></i> ' + (s.stat2_val || 'Stabil');
      }
    }

    if (statusEl) {
      const isFlora = s.type === 'flora';
      const statusIcon = isFlora ? 'fa-seedling' : 'fa-triangle-exclamation';
      statusEl.innerHTML = `<i class="fa-solid ${statusIcon}"></i> ${s.status.toUpperCase()}`;
      statusEl.className = `${s.statusClass} text-white text-[10px] font-black px-3 py-1.5 rounded-xl shadow-sm flex items-center gap-1.5 uppercase`;
    }

    // Update bookmark button state
    updateBookmarkButtonState(s.key);

    // Open drawer
    drawer.classList.remove('drawer-closed');
    drawer.classList.add('drawer-open');

    // Pan map smoothly to marker if within bounds
    if (map && s.lat && s.lng) {
      const targetZoom = Math.max(map.getZoom(), 7);
      map.flyTo([s.lat, s.lng], targetZoom, { duration: 0.8 });
    }
  };

  /**
   * Quick View Drawer Close
   */
  window.closeDrawer = function () {
    const drawer = document.getElementById('species-drawer');
    if (!drawer) return;
    drawer.classList.add('drawer-closed');
    drawer.classList.remove('drawer-open');
    currentSpeciesKey = null;
  };

  /**
   * Bookmark Storage & Toggle
   */
  function getBookmarks() {
    try {
      return JSON.parse(localStorage.getItem('biohub_bookmarks')) || [];
    } catch (e) {
      return [];
    }
  }

  function updateHeaderBookmarkBadge() {
    const badge = document.getElementById('header-bookmark-badge');
    if (!badge) return;
    const bookmarks = getBookmarks();
    badge.innerText = bookmarks.length;
  }

  function updateBookmarkButtonState(speciesKey) {
    const btn = document.getElementById('drawer-bookmark-btn');
    const icon = document.getElementById('drawer-bookmark-icon');
    const text = document.getElementById('drawer-bookmark-text');
    if (!btn || !icon || !text) return;

    const bookmarks = getBookmarks();
    const isBookmarked = bookmarks.includes(speciesKey);

    if (isBookmarked) {
      icon.className = 'fa-solid fa-bookmark text-[#D97706]';
      text.innerText = 'Tersimpan';
      btn.className = 'flex-1 border border-amber-300 bg-amber-50 text-amber-800 font-bold py-3 rounded-2xl transition flex items-center justify-center gap-2 text-xs cursor-pointer';
    } else {
      icon.className = 'fa-regular fa-bookmark';
      text.innerText = 'Simpan';
      btn.className = 'flex-1 border border-gray-200 hover:bg-gray-50 text-gray-700 font-bold py-3 rounded-2xl transition flex items-center justify-center gap-2 text-xs cursor-pointer';
    }

    updateHeaderBookmarkBadge();
  }

  window.toggleBookmarkCurrent = function () {
    if (!currentSpeciesKey) return;

    const bookmarks = getBookmarks();
    const idx = bookmarks.indexOf(currentSpeciesKey);
    const s = speciesData[currentSpeciesKey];
    const speciesName = s ? s.name : 'Spesies';

    if (idx > -1) {
      bookmarks.splice(idx, 1);
      localStorage.setItem('biohub_bookmarks', JSON.stringify(bookmarks));
      updateBookmarkButtonState(currentSpeciesKey);
      window.showToast(`${speciesName} dihapus dari koleksi`, 'fa-bookmark');
    } else {
      bookmarks.push(currentSpeciesKey);
      localStorage.setItem('biohub_bookmarks', JSON.stringify(bookmarks));
      updateBookmarkButtonState(currentSpeciesKey);
      window.showToast(`${speciesName} berhasil disimpan ke koleksi!`, 'fa-circle-check');
    }
  };

  /**
   * Share Current Location Deep Link
   */
  window.shareCurrentLocation = function () {
    if (!currentSpeciesKey) return;
    const url = new URL(window.location.href);
    url.searchParams.set('species', currentSpeciesKey);
    
    if (navigator.clipboard) {
      navigator.clipboard.writeText(url.toString()).then(function () {
        window.showToast('Tautan lokasi spesies berhasil disalin!', 'fa-share-nodes');
      });
    } else {
      window.showToast('Tautan: ' + url.toString(), 'fa-share-nodes');
    }
  };

  /**
   * Collection Modal Functions
   */
  window.openCollectionModal = function () {
    const modal = document.getElementById('collection-modal');
    const container = document.getElementById('collection-items-container');
    if (!modal || !container) return;

    const bookmarks = getBookmarks();
    container.innerHTML = '';

    if (bookmarks.length === 0) {
      container.innerHTML = `
        <div class="py-12 text-center text-gray-400">
          <i class="fa-regular fa-bookmark text-4xl mb-3 block text-gray-300"></i>
          <p class="font-bold text-sm text-gray-700">Belum ada spesies yang disimpan</p>
          <p class="text-xs text-gray-400 mt-1">Klik ikon "Simpan" pada panel spesies di peta untuk menyimpan ke koleksi Anda.</p>
        </div>
      `;
    } else {
      bookmarks.forEach(key => {
        const s = speciesData[key];
        if (!s) return;

        const item = document.createElement('div');
        item.className = 'flex items-center justify-between p-3.5 bg-gray-50 hover:bg-gray-100/80 rounded-2xl border border-gray-200/60 transition gap-4';
        item.innerHTML = `
          <div class="flex items-center gap-3.5 flex-1 min-w-0">
            <div class="w-12 h-12 rounded-xl overflow-hidden bg-gray-200 flex-shrink-0 border border-gray-200">
              <img src="${s.img}" alt="${s.name}" class="w-full h-full object-cover" onerror="this.src='https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_3a21343fd1_225b4e4a886799f4.png'"/>
            </div>
            <div class="min-w-0 flex-1">
              <span class="text-[9px] font-bold text-[#D97706] uppercase block">${s.cat}</span>
              <h4 class="font-bold text-xs text-gray-900 truncate">${s.name}</h4>
              <p class="text-[11px] italic text-gray-400 truncate">${s.latin}</p>
            </div>
          </div>
          <div class="flex items-center gap-2 flex-shrink-0">
            <button onclick="focusSpeciesFromCollection('${s.key}')" class="bg-[#2E7D32] hover:bg-[#1B5E20] text-white font-bold text-xs px-3 py-1.5 rounded-xl transition flex items-center gap-1 cursor-pointer">
              <i class="fa-solid fa-location-dot text-[10px]"></i>
              <span>Peta</span>
            </button>
            <a href="${s.detailUrl}" class="p-1.5 text-gray-400 hover:text-gray-700 rounded-lg">
              <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
            </a>
            <button onclick="removeBookmarkFromList('${s.key}')" title="Hapus dari Koleksi" class="p-1.5 text-gray-400 hover:text-red-600 rounded-lg cursor-pointer">
              <i class="fa-solid fa-trash-can text-xs"></i>
            </button>
          </div>
        `;
        container.appendChild(item);
      });
    }

    modal.classList.remove('hidden');
    modal.classList.add('flex');
  };

  window.closeCollectionModal = function () {
    const modal = document.getElementById('collection-modal');
    if (!modal) return;
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  };

  window.removeBookmarkFromList = function (speciesKey) {
    const bookmarks = getBookmarks();
    const idx = bookmarks.indexOf(speciesKey);
    if (idx > -1) {
      bookmarks.splice(idx, 1);
      localStorage.setItem('biohub_bookmarks', JSON.stringify(bookmarks));
      updateBookmarkButtonState(speciesKey);
      openCollectionModal();
      window.showToast('Item berhasil dihapus dari koleksi', 'fa-trash');
    }
  };

  window.clearAllBookmarks = function () {
    if (confirm('Apakah Anda yakin ingin mengosongkan seluruh koleksi tersimpan?')) {
      localStorage.removeItem('biohub_bookmarks');
      updateBookmarkButtonState(currentSpeciesKey || '');
      openCollectionModal();
      window.showToast('Koleksi berhasil dikosongkan', 'fa-circle-check');
    }
  };

  window.focusSpeciesFromCollection = function (speciesKey) {
    closeCollectionModal();
    window.toggleView('map');
    window.openDrawer(speciesKey);
  };

  /**
   * View Switcher (Map vs Grid)
   */
  window.toggleView = function (view) {
    const gridView = document.getElementById('grid-view');
    const btnMap = document.getElementById('btn-view-map');
    const btnGrid = document.getElementById('btn-view-grid');

    if (!gridView) return;

    if (view === 'grid') {
      closeDrawer();
      gridView.classList.remove('hidden');

      if (btnGrid) {
        btnGrid.className = 'view-toggle-btn flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all bg-[#2E7D32] text-white shadow-sm cursor-pointer';
      }
      if (btnMap) {
        btnMap.className = 'view-toggle-btn flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all text-gray-600 hover:bg-gray-100 cursor-pointer';
      }
    } else {
      gridView.classList.add('hidden');

      if (btnMap) {
        btnMap.className = 'view-toggle-btn flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all bg-[#2E7D32] text-white shadow-sm cursor-pointer';
      }
      if (btnGrid) {
        btnGrid.className = 'view-toggle-btn flex items-center gap-2 px-4 py-2 rounded-xl text-xs font-bold transition-all text-gray-600 hover:bg-gray-100 cursor-pointer';
      }

      // Re-trigger Leaflet size calculation
      if (map) {
        setTimeout(function () {
          map.invalidateSize();
        }, 60);
      }
    }
  };

  /**
   * Select species from grid card and switch to map view
   */
  window.selectSpeciesFromGrid = function (speciesKey) {
    window.toggleView('map');
    window.openDrawer(speciesKey);
  };

  /**
   * Mobile Sidebar Drawer Toggle
   */
  window.toggleMobileSidebar = function (isOpen) {
    const sidebar = document.getElementById('map-sidebar');
    const backdrop = document.getElementById('mobile-filter-backdrop');
    if (!sidebar) return;

    if (isOpen) {
      sidebar.classList.remove('-translate-x-full');
      sidebar.classList.add('translate-x-0');
      if (backdrop) backdrop.classList.remove('hidden');
    } else {
      sidebar.classList.add('-translate-x-full');
      sidebar.classList.remove('translate-x-0');
      if (backdrop) backdrop.classList.add('hidden');
    }
  };

  /**
   * Toast Notification Helper
   */
  let toastTimer = null;
  window.showToast = function (message, iconClass = 'fa-circle-check') {
    const toast = document.getElementById('toast-notification');
    const toastMsg = document.getElementById('toast-message');
    const toastIcon = document.getElementById('toast-icon');

    if (!toast || !toastMsg) return;

    if (toastTimer) clearTimeout(toastTimer);

    toastMsg.innerText = message;
    if (toastIcon) {
      toastIcon.className = `fa-solid ${iconClass} text-emerald-400 text-sm`;
    }

    toast.classList.remove('opacity-0', 'pointer-events-none', 'translate-y-4');
    toast.classList.add('opacity-100', 'translate-y-0');

    toastTimer = setTimeout(function () {
      toast.classList.remove('opacity-100', 'translate-y-0');
      toast.classList.add('opacity-0', 'pointer-events-none', 'translate-y-4');
    }, 2800);
  };

  /**
   * URL Query Parameters Handler (Deep Link)
   */
  function handleUrlQueryParams() {
    const params = new URLSearchParams(window.location.search);
    const targetSpecies = params.get('species');
    const targetRegion = params.get('region');
    const targetCat = params.get('category') || params.get('cat');

    if (targetRegion && regionCoordinates[targetRegion]) {
      const regionSelect = document.getElementById('filter-region');
      if (regionSelect) {
        regionSelect.value = targetRegion;
        applyFilters();
        const target = regionCoordinates[targetRegion];
        if (map) map.flyTo(target.center, target.zoom, { duration: 1 });
      }
    }

    if (targetCat) {
      if (targetCat.toLowerCase() === 'fauna') {
        const catFlora = document.getElementById('filter-cat-flora');
        if (catFlora) catFlora.checked = false;
      } else if (targetCat.toLowerCase() === 'flora') {
        const catFauna = document.getElementById('filter-cat-fauna');
        if (catFauna) catFauna.checked = false;
      }
      applyFilters();
    }

    if (targetSpecies) {
      setTimeout(function () {
        window.openDrawer(targetSpecies);
      }, 350);
    }
  }

  /**
   * Event Listeners & Bootstrapping
   */
  document.addEventListener('DOMContentLoaded', function () {
    // 1. Initialize Map
    initMap();

    // 2. Bind filter controls
    const applyBtn = document.getElementById('apply-filter');
    const resetBtn = document.getElementById('reset-filter');
    const searchInput = document.getElementById('filter-search');
    const regionSelect = document.getElementById('filter-region');
    const filterCheckboxes = document.querySelectorAll('.filter-cat, .filter-status');

    if (applyBtn) {
      applyBtn.addEventListener('click', function () {
        applyFilters();
        window.showToast('Filter berhasil diterapkan', 'fa-circle-check');
        if (window.innerWidth < 1024) {
          toggleMobileSidebar(false);
        }
      });
    }

    if (resetBtn) {
      resetBtn.addEventListener('click', window.resetAllFilters);
    }

    if (searchInput) {
      searchInput.addEventListener('input', applyFilters);
    }

    filterCheckboxes.forEach(cb => {
      cb.addEventListener('change', applyFilters);
    });

    if (regionSelect) {
      regionSelect.addEventListener('change', function () {
        applyFilters();
        const selected = regionSelect.value;
        const target = regionCoordinates[selected] || regionCoordinates['Semua Wilayah'];
        if (map) {
          map.flyTo(target.center, target.zoom, { duration: 1.2 });
        }
        window.showToast(`Peta beralih ke: ${selected}`, 'fa-map-pin');
      });
    }

    // Keyboard navigation (Escape closes drawers & modal)
    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape') {
        closeDrawer();
        closeCollectionModal();
        toggleMobileSidebar(false);
      }
    });
  });

})();
