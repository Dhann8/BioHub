window.addEventListener('load', function() {
    try {
      const xData = ['2018', '2019', '2020', '2021', '2022', '2023', '2024'];
      const yData = [1200, 1450, 1800, 2400, 3100, 3800, 4200];

      const trace1 = {
        x: xData,
        y: yData,
        type: 'scatter',
        mode: 'lines+markers',
        name: 'Publikasi',
        line: { color: '#2E7D32', width: 3 },
        marker: { color: '#2E7D32', size: 6 },
        fill: 'tozeroy',
        fillcolor: 'rgba(46, 125, 50, 0.1)'
      };

      const layout = {
        margin: { t: 10, r: 10, b: 30, l: 40 },
        paper_bgcolor: 'rgba(0,0,0,0)',
        plot_bgcolor: 'rgba(0,0,0,0)',
        showlegend: false,
        xaxis: {
          gridcolor: '#f1f5f9',
          tickfont: { size: 10, color: '#94a3b8' }
        },
        yaxis: {
          gridcolor: '#f1f5f9',
          tickfont: { size: 10, color: '#94a3b8' }
        }
      };

      const config = { responsive: true, displayModeBar: false, displaylogo: false };
      if(document.getElementById('trendChart')) {
        Plotly.newPlot('trendChart', [trace1], layout, config);
      }
    } catch(e) {
      console.error("Plotly Error:", e);
    }

    // Dynamic Fetching logic
    let currentPage = 1;
    let searchQuery = '';
    let filterYear = '';
    let filterType = '';
    let sortValue = 'newest';

    const papersList = document.getElementById('papersList');
    const paginationContainer = document.getElementById('paginationContainer');
    const paperCountText = document.getElementById('paperCountText');
    const mostCitedList = document.getElementById('mostCitedList');

    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const filterYearSelect = document.getElementById('filterYear');
    const filterTypeSelect = document.getElementById('filterType');
    const sortSelect = document.getElementById('sortSelect');
    const clearFiltersBtn = document.getElementById('clearFiltersBtn');

    function loadPapers() {
        if(!papersList) return;
        papersList.innerHTML = '<div class="text-center py-8 text-slate-500">Memuat makalah...</div>';

        let url = `/api/papers?page=${currentPage}&per_page=5&sort=${sortValue}`;
        if (searchQuery) url += `&search=${encodeURIComponent(searchQuery)}`;
        if (filterYear) url += `&year=${filterYear}`;
        if (filterType) url += `&type=${encodeURIComponent(filterType)}`;

        fetch(url)
            .then(res => res.json())
            .then(res => {
                if(res.status === 'success') {
                    renderPapers(res.data);
                    renderPagination(res.data);
                    if(paperCountText) {
                        paperCountText.innerText = `Makalah Riset (${res.data.total} Hasil)`;
                    }
                }
            })
            .catch(err => {
                console.error(err);
                papersList.innerHTML = '<div class="text-center py-8 text-red-500">Gagal memuat makalah.</div>';
            });
    }

    function renderPapers(paginatedData) {
        papersList.innerHTML = '';
        if (paginatedData.data.length === 0) {
            papersList.innerHTML = '<div class="text-center py-8 text-slate-500">Tidak ada makalah yang ditemukan.</div>';
            return;
        }

        paginatedData.data.forEach(paper => {
            const compounds = paper.compounds || [];
            let compoundsHtml = '';
            if (compounds.length > 0) {
                compoundsHtml = `<div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="text-xs font-bold text-slate-400 mr-2">Senyawa Aktif:</span>`;
                compounds.forEach(c => {
                    compoundsHtml += `<span class="px-2.5 py-1 bg-amber-light text-amber-dark text-xs font-bold rounded-full">${c}</span>`;
                });
                compoundsHtml += `</div>`;
            }

            const pubDate = new Date(paper.created_at).toLocaleDateString('id-ID', { year: 'numeric', month: 'short', day: 'numeric' });

            const card = `
            <div class="academic-card bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-all group">
            <div class="flex flex-col md:flex-row md:items-start gap-4">
              <div class="flex-1">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                  <span class="px-2 py-1 bg-green-pale text-green-primary text-[10px] font-bold rounded uppercase">${paper.type || 'Riset'}</span>
                  <span class="px-2 py-1 bg-slate-100 text-slate-500 text-[10px] font-bold rounded uppercase">${paper.category || 'Umum'}</span>
                  <span class="text-xs text-slate-400 font-medium">Diterbitkan: ${pubDate}</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2 leading-tight group-hover:text-green-primary transition">${paper.title}</h3>
                <p class="text-sm text-slate-500 font-medium mb-3">${paper.authors}</p>
                <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed mb-4">${paper.abstract || 'Tidak ada abstrak yang tersedia.'}</p>
                ${compoundsHtml}
              </div>
              <div class="md:w-48 flex flex-col gap-2 shrink-0">
                <a ${paper.pdf_url ? 'href="'+paper.pdf_url+'" target="_blank"' : 'href="/api/papers/'+paper.id+'/download" target="_blank"'} class="w-full bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition text-center">
                  <i class="fa-solid fa-file-pdf"></i> Unduh PDF
                </a>
                <button class="w-full border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition">
                  <i class="fa-solid fa-quote-right"></i> Sitasi (APA/IEEE)
                </button>
              </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-medium text-slate-400">
              <span class="flex items-center gap-2"><i class="fa-solid fa-book text-green-primary"></i> ${paper.journal_name || 'Jurnal'}</span>
              <span class="flex items-center gap-2"><i class="fa-solid fa-eye"></i> ${paper.views || 0} Dilihat</span>
              <span class="flex items-center gap-2"><i class="fa-solid fa-share-nodes"></i> ${paper.citations || 0} Sitasi</span>
            </div>
          </div>
            `;
            papersList.insertAdjacentHTML('beforeend', card);
        });
    }

    function renderPagination(data) {
        if(!paginationContainer) return;
        paginationContainer.innerHTML = '';
        if (data.last_page <= 1) return;

        let prevDisabled = data.current_page === 1 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-slate-50 cursor-pointer';
        let html = `<button onclick="window.changePage(${data.current_page - 1})" ${data.current_page === 1 ? 'disabled' : ''} class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 transition ${prevDisabled}"><i class="fa-solid fa-chevron-left text-sm"></i></button>`;

        for (let i = 1; i <= data.last_page; i++) {
            if (i === data.current_page) {
                html += `<button class="w-10 h-10 rounded-xl bg-[#2E7D32] text-white font-bold text-sm shadow-md shadow-green-900/20">${i}</button>`;
            } else {
                html += `<button onclick="window.changePage(${i})" class="w-10 h-10 rounded-xl border border-slate-200 bg-white text-slate-700 font-bold text-sm hover:bg-slate-50 transition">${i}</button>`;
            }
        }

        let nextDisabled = data.current_page === data.last_page ? 'opacity-50 cursor-not-allowed' : 'hover:bg-slate-50 cursor-pointer';
        html += `<button onclick="window.changePage(${data.current_page + 1})" ${data.current_page === data.last_page ? 'disabled' : ''} class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 transition ${nextDisabled}"><i class="fa-solid fa-chevron-right text-sm"></i></button>`;

        paginationContainer.innerHTML = html;
    }

    window.searchForPaper = function(title) {
        if(searchInput) searchInput.value = title;
        searchQuery = title;

        if(filterYearSelect) filterYearSelect.value = '';
        filterYear = '';

        if(filterTypeSelect) filterTypeSelect.value = '';
        filterType = '';

        if(sortSelect) sortSelect.value = 'newest';
        sortValue = 'newest';

        currentPage = 1;
        loadPapers();

        if(papersList) {
            papersList.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    };

    window.changePage = function(page) {
        currentPage = page;
        loadPapers();
    };

    function loadMostCited() {
        if(!mostCitedList) return;
        fetch('/api/papers/most-cited')
            .then(res => res.json())
            .then(res => {
                if(res.status === 'success') {
                    mostCitedList.innerHTML = '';
                    res.data.forEach((paper, index) => {
                        if(index > 0) mostCitedList.insertAdjacentHTML('beforeend', '<div class="h-px bg-slate-100"></div>');
                        const item = `
                        <div class="group cursor-pointer" onclick="window.searchForPaper('${paper.title.replace(/'/g, "\\'")}')">
                          <p class="text-xs font-bold text-green-primary mb-1">${paper.citations || 0} Sitasi</p>
                          <h4 class="text-sm font-bold text-slate-800 leading-snug group-hover:text-green-primary transition">${paper.title}</h4>
                          <p class="text-[11px] text-slate-400 mt-1 italic">${paper.journal_name || 'Jurnal'} · ${paper.publication_year}</p>
                        </div>
                        `;
                        mostCitedList.insertAdjacentHTML('beforeend', item);
                    });
                }
            })
            .catch(err => {
                console.error(err);
                mostCitedList.innerHTML = '<div class="text-xs text-red-500 text-center">Gagal memuat</div>';
            });
    }

    if(searchBtn) {
        searchBtn.addEventListener('click', () => {
            searchQuery = searchInput.value;
            currentPage = 1;
            loadPapers();
        });
    }

    if(searchInput) {
        searchInput.addEventListener('keypress', (e) => {
            if(e.key === 'Enter') {
                searchQuery = searchInput.value;
                currentPage = 1;
                loadPapers();
            }
        });
    }

    if(filterYearSelect) {
        filterYearSelect.addEventListener('change', () => {
            filterYear = filterYearSelect.value;
            currentPage = 1;
            loadPapers();
        });
    }

    if(filterTypeSelect) {
        filterTypeSelect.addEventListener('change', () => {
            filterType = filterTypeSelect.value;
            currentPage = 1;
            loadPapers();
        });
    }

    if(sortSelect) {
        sortSelect.addEventListener('change', () => {
            sortValue = sortSelect.value;
            currentPage = 1;
            loadPapers();
        });
    }

    if(clearFiltersBtn) {
        clearFiltersBtn.addEventListener('click', () => {
            searchInput.value = '';
            filterYearSelect.value = '';
            filterTypeSelect.value = '';
            sortSelect.value = 'newest';

            searchQuery = '';
            filterYear = '';
            filterType = '';
            sortValue = 'newest';
            currentPage = 1;
            loadPapers();
        });
    }

    loadPapers();
    loadMostCited();
});
