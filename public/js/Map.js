    const drawer = document.getElementById('species-drawer');
    const gridView = document.getElementById('grid-view');
    
    function openDrawer(species) {
      // In a real app, we'd fetch data. Here we just update the UI.
      const data = {
        orangutan: {
          name: "Orangutan Sumatra",
          latin: "Pongo abelii",
          cat: "Fauna · Primata",
          status: "Kritis (CR)",
          statusClass: "bg-status-cr",
          desc: "Hanya ditemukan di pulau Sumatra. Hidup di kanopi hutan hujan dataran rendah.",
          img: "Sumatran orangutan portrait close up"
        },
        harimau: {
          name: "Harimau Sumatra",
          latin: "Panthera tigris sumatrae",
          cat: "Fauna · Felidae",
          status: "Kritis (CR)",
          statusClass: "bg-status-cr",
          desc: "Subspesies harimau terakhir di Indonesia. Terancam oleh fragmentasi habitat.",
          img: "Sumatran tiger face close up"
        },
        bekantan: {
          name: "Bekantan",
          latin: "Nasalis larvatus",
          cat: "Fauna · Primata",
          status: "Terancam (EN)",
          statusClass: "bg-status-en",
          desc: "Primata endemik Kalimantan yang dikenal dengan hidung besarnya yang unik.",
          img: "Proboscis monkey bekantan portrait"
        },
        anoa: {
          name: "Anoa Dataran Rendah",
          latin: "Bubalus depressicornis",
          cat: "Fauna · Bovidae",
          status: "Terancam (EN)",
          statusClass: "bg-status-en",
          desc: "Kerbau kerdil endemik Sulawesi. Sangat pemalu dan hidup di hutan lebat.",
          img: "Anoa dwarf buffalo portrait"
        },
        cendrawasih: {
          name: "Cendrawasih Wilson",
          latin: "Cicinnurus respublica",
          cat: "Fauna · Paradisaeidae",
          status: "Rentan (VU)",
          statusClass: "bg-status-vu",
          desc: "Burung surga dari pulau Waigeo, Papua. Dikenal dengan tarian kawin yang spektakuler.",
          img: "Wilson's Bird of Paradise Papua"
        }
      };

      const s = data[species];
      if (s) {
        document.getElementById('drawer-name').innerText = s.name;
        document.getElementById('drawer-latin').innerText = s.latin;
        document.getElementById('drawer-cat').innerText = s.cat;
        document.getElementById('drawer-desc').innerText = s.desc;
        const statusEl = document.getElementById('drawer-status');
        statusEl.innerText = s.status;
        statusEl.className = `${s.statusClass} text-white text-[10px] font-black px-3 py-1.5 rounded-lg shadow-sm flex items-center gap-1.5 uppercase`;
      }

      drawer.classList.remove('drawer-closed');
      drawer.classList.add('drawer-open');
    }

    function closeDrawer() {
      drawer.classList.add('drawer-closed');
      drawer.classList.remove('drawer-open');
    }

    function toggleView(view) {
      if (view === 'grid') {
        gridView.classList.remove('hidden');
      } else {
        gridView.classList.add('hidden');
      }
    }

    // Toggle button listeners
    document.querySelectorAll('nav button').forEach(btn => {
      btn.addEventListener('click', () => {
        if (btn.innerText.includes('Grid')) {
          toggleView('grid');
          document.querySelectorAll('nav button').forEach(b => {
            b.classList.remove('bg-white', 'text-[#2E7D32]', 'shadow-sm');
            b.classList.add('text-gray-500', 'hover:bg-gray-200');
          });
          btn.classList.add('bg-white', 'text-[#2E7D32]', 'shadow-sm');
          btn.classList.remove('text-gray-500', 'hover:bg-gray-200');
        } else if (btn.innerText.includes('Peta')) {
          toggleView('map');
          document.querySelectorAll('nav button').forEach(b => {
            b.classList.remove('bg-white', 'text-[#2E7D32]', 'shadow-sm');
            b.classList.add('text-gray-500', 'hover:bg-gray-200');
          });
          btn.classList.add('bg-white', 'text-[#2E7D32]', 'shadow-sm');
          btn.classList.remove('text-gray-500', 'hover:bg-gray-200');
        }
      });
    });