@extends('layout.base')
@section('content')

  <main class="pt-24 pb-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

      <div class="lg:col-span-9">

        <div class="mb-8">
          <h1 class="text-3xl font-black text-slate-900 mb-2">Academic Research & Literature</h1>
          <p class="text-slate-500 max-w-2xl">Access thousands of peer-reviewed studies on Indonesian biodiversity, traditional medicine (TOGA), and pharmacological validations.</p>

          <div class="mt-8 bg-white p-2 rounded-2xl shadow-sm border border-slate-200 flex flex-col md:flex-row gap-2">
            <div class="flex-1 flex items-center gap-3 px-4 py-2">
              <i class="fa-solid fa-magnifying-glass text-slate-400"></i>
              <input type="text" placeholder="Search by paper title, active compound (e.g. Curcumin), or author..." class="w-full bg-transparent outline-none text-slate-700 text-sm" />
            </div>
            <button class="bg-green-primary hover:bg-green-dark text-white px-8 py-3 rounded-xl font-bold text-sm transition">
              Search Repository
            </button>
          </div>

          <!-- FILTERS -->
          <div class="flex flex-wrap gap-3 mt-4">
            <div class="relative group">
              <button class="flex items-center gap-2 bg-white border border-slate-200 px-4 py-2 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-50">
                Publication Year <i class="fa-solid fa-chevron-down text-[10px]"></i>
              </button>
            </div>
            <div class="relative group">
              <button class="flex items-center gap-2 bg-white border border-slate-200 px-4 py-2 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-50">
                Research Topic <i class="fa-solid fa-chevron-down text-[10px]"></i>
              </button>
            </div>
            <div class="relative group">
              <button class="flex items-center gap-2 bg-white border border-slate-200 px-4 py-2 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-50">
                Journal Type <i class="fa-solid fa-chevron-down text-[10px]"></i>
              </button>
            </div>
            <div class="relative group">
              <button class="flex items-center gap-2 bg-white border border-slate-200 px-4 py-2 rounded-lg text-xs font-semibold text-slate-600 hover:bg-slate-50">
                Evidence Level <i class="fa-solid fa-chevron-down text-[10px]"></i>
              </button>
            </div>
            <button class="text-xs font-bold text-green-primary hover:underline ml-auto">Clear All Filters</button>
          </div>
        </div>

        <!-- RECENT RESEARCH STATS (Plotly Chart) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
          <div class="md:col-span-2 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm">
            <div class="flex items-center justify-between mb-4">
              <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider">Publication Trends (2018-2024)</h3>
              <span class="text-xs text-green-primary font-bold"><i class="fa-solid fa-arrow-trend-up mr-1"></i>+12% Growth</span>
            </div>
            <div id="trendChart" class="h-[200px] w-full"></div>
          </div>
          <div class="bg-green-primary p-6 rounded-2xl text-white flex flex-col justify-between">
            <div>
              <p class="text-green-pale/70 text-xs font-bold uppercase tracking-widest mb-1">Total Indexed</p>
              <h2 class="text-4xl font-black">42.1k</h2>
              <p class="text-green-pale/80 text-xs mt-2 leading-relaxed">Peer-reviewed papers across 248 international journals.</p>
            </div>
            <button class="bg-white/15 hover:bg-white/25 border border-white/30 text-white text-xs font-bold py-2 rounded-lg transition mt-4">
              View Citation Index
            </button>
          </div>
        </div>

        <!-- PAPERS LIST -->
        <div class="space-y-4">
          <div class="flex items-center justify-between mb-2">
            <h2 class="font-black text-slate-900">Research Papers (128 Results)</h2>
            <div class="flex items-center gap-2 text-xs text-slate-500">
              Sort by:
              <select class="bg-transparent font-bold text-slate-800 outline-none cursor-pointer">
                <option>Newest First</option>
                <option>Most Cited</option>
                <option>Relevance</option>
              </select>
            </div>
          </div>

          <!-- Paper Card 1 -->
          <div class="academic-card bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-all group">
            <div class="flex flex-col md:flex-row md:items-start gap-4">
              <div class="flex-1">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                  <span class="px-2 py-1 bg-green-pale text-green-primary text-[10px] font-bold rounded uppercase">Clinical Trial</span>
                  <span class="px-2 py-1 bg-slate-100 text-slate-500 text-[10px] font-bold rounded uppercase">Botany</span>
                  <span class="text-xs text-slate-400 font-medium">Published: Oct 12, 2024</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2 leading-tight group-hover:text-green-primary transition">Efficacy of Curcuma longa L. in Modulating Pro-inflammatory Cytokines: A Randomized Controlled Trial</h3>
                <p class="text-sm text-slate-500 font-medium mb-3">Dr. S. Hartono, Prof. L. Wijaya, et al.</p>
                <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed mb-4">A randomized controlled trial demonstrating significant downregulation of TNF-α and IL-6 following standardized rhizome extract administration over eight weeks in patients with chronic inflammatory markers...</p>

                <div class="flex flex-wrap items-center gap-2 mb-4">
                  <span class="text-xs font-bold text-slate-400 mr-2">Compounds:</span>
                  <span class="px-2.5 py-1 bg-amber-light text-amber-dark text-xs font-bold rounded-full">Curcumin</span>
                  <span class="px-2.5 py-1 bg-amber-light text-amber-dark text-xs font-bold rounded-full">Flavonoid</span>
                  <span class="px-2.5 py-1 bg-amber-light text-amber-dark text-xs font-bold rounded-full">Turmerone</span>
                </div>
              </div>
              <div class="md:w-48 flex flex-col gap-2 shrink-0">
                <button class="w-full bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition">
                  <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
                <button class="w-full border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition">
                  <i class="fa-solid fa-quote-right"></i> Cite (APA/IEEE)
                </button>
                <button class="w-full border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition">
                  <i class="fa-solid fa-seedling"></i> View Plant Profile
                </button>
              </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-medium text-slate-400">
              <span class="flex items-center gap-2"><i class="fa-solid fa-book text-green-primary"></i> Journal of Ethnopharmacology</span>
              <span class="flex items-center gap-2"><i class="fa-solid fa-eye"></i> 2.4k Views</span>
              <span class="flex items-center gap-2"><i class="fa-solid fa-share-nodes"></i> 142 Citations</span>
            </div>
          </div>

          <!-- Paper Card 2 -->
          <div class="academic-card bg-white p-6 rounded-2xl border border-slate-200 shadow-sm transition-all group">
            <div class="flex flex-col md:flex-row md:items-start gap-4">
              <div class="flex-1">
                <div class="flex flex-wrap items-center gap-2 mb-3">
                  <span class="px-2 py-1 bg-blue-100 text-blue-600 text-[10px] font-bold rounded uppercase">In Vitro</span>
                  <span class="px-2 py-1 bg-slate-100 text-slate-500 text-[10px] font-bold rounded uppercase">Pharmacology</span>
                  <span class="text-xs text-slate-400 font-medium">Published: Aug 24, 2024</span>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-2 leading-tight group-hover:text-green-primary transition">Neuroprotective Effects of Centella asiatica on Cognitive Models and Triterpenoid Fractionation</h3>
                <p class="text-sm text-slate-500 font-medium mb-3">Prof. R. Santoso, Dr. M. Pratama</p>
                <p class="text-sm text-slate-600 line-clamp-2 leading-relaxed mb-4">In vivo assessment of triterpenoid-enriched fractions showing improved spatial memory retention and reduced oxidative stress markers in murine models of neurodegeneration...</p>

                <div class="flex flex-wrap items-center gap-2 mb-4">
                  <span class="text-xs font-bold text-slate-400 mr-2">Compounds:</span>
                  <span class="px-2.5 py-1 bg-amber-light text-amber-dark text-xs font-bold rounded-full">Asiaticoside</span>
                  <span class="px-2.5 py-1 bg-amber-light text-amber-dark text-xs font-bold rounded-full">Madecassoside</span>
                </div>
              </div>
              <div class="md:w-48 flex flex-col gap-2 shrink-0">
                <button class="w-full bg-slate-900 hover:bg-slate-800 text-white text-xs font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition">
                  <i class="fa-solid fa-file-pdf"></i> Download PDF
                </button>
                <button class="w-full border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition">
                  <i class="fa-solid fa-quote-right"></i> Cite (APA/IEEE)
                </button>
                <button class="w-full border border-slate-200 hover:bg-slate-50 text-slate-700 text-xs font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition">
                  <i class="fa-solid fa-seedling"></i> View Plant Profile
                </button>
              </div>
            </div>
            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-medium text-slate-400">
              <span class="flex items-center gap-2"><i class="fa-solid fa-book text-green-primary"></i> Phytomedicine Journal</span>
              <span class="flex items-center gap-2"><i class="fa-solid fa-eye"></i> 1.8k Views</span>
              <span class="flex items-center gap-2"><i class="fa-solid fa-share-nodes"></i> 89 Citations</span>
            </div>
          </div>

          <!-- Pagination -->
          <div class="flex items-center justify-center gap-2 mt-8">
            <button class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition"><i class="fa-solid fa-chevron-left text-sm"></i></button>
            <button class="w-10 h-10 rounded-xl bg-green-primary text-white font-bold text-sm shadow-lg shadow-green-primary/20">1</button>
            <button class="w-10 h-10 rounded-xl border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition">2</button>
            <button class="w-10 h-10 rounded-xl border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition">3</button>
            <span class="px-2 text-slate-400">...</span>
            <button class="w-10 h-10 rounded-xl border border-slate-200 text-slate-600 font-bold text-sm hover:bg-slate-50 transition">12</button>
            <button class="w-10 h-10 rounded-xl border border-slate-200 flex items-center justify-center text-slate-400 hover:bg-slate-50 transition"><i class="fa-solid fa-chevron-right text-sm"></i></button>
          </div>
        </div>
      </div>

      <!-- SIDEBAR -->
      <div class="lg:col-span-3 space-y-6">

        <!-- MOST CITED -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
          <div class="bg-slate-50 px-5 py-4 border-b border-slate-200">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider flex items-center gap-2">
              <i class="fa-solid fa-ranking-star text-amber-accent"></i> Most Cited This Month
            </h3>
          </div>
          <div class="p-5 space-y-4">
            <div class="group cursor-pointer">
              <p class="text-xs font-bold text-green-primary mb-1">142 Citations</p>
              <h4 class="text-sm font-bold text-slate-800 leading-snug group-hover:text-green-primary transition">Anti-inflammatory Activity of Curcumin in Rheumatoid Arthritis</h4>
              <p class="text-[11px] text-slate-400 mt-1 italic">J. Ethnopharmacol. · 2023</p>
            </div>
            <div class="h-px bg-slate-100"></div>
            <div class="group cursor-pointer">
              <p class="text-xs font-bold text-green-primary mb-1">98 Citations</p>
              <h4 class="text-sm font-bold text-slate-800 leading-snug group-hover:text-green-primary transition">Standardization of Herbal Extracts for Clinical Trials</h4>
              <p class="text-[11px] text-slate-400 mt-1 italic">Phytomedicine · 2024</p>
            </div>
            <div class="h-px bg-slate-100"></div>
            <div class="group cursor-pointer">
              <p class="text-xs font-bold text-green-primary mb-1">76 Citations</p>
              <h4 class="text-sm font-bold text-slate-800 leading-snug group-hover:text-green-primary transition">Biodiversity Hotspots and Medicinal Plant Conservation</h4>
              <p class="text-[11px] text-slate-400 mt-1 italic">Conserv. Biol. · 2024</p>
            </div>
          </div>
          <button class="w-full py-3 text-xs font-bold text-slate-500 hover:text-green-primary hover:bg-slate-50 transition border-t border-slate-100">View Ranking Leaderboard</button>
        </div>

        <!-- LATEST SCIENTIFIC DISCOVERIES -->
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
          <div class="bg-slate-50 px-5 py-4 border-b border-slate-200">
            <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wider flex items-center gap-2">
              <i class="fa-solid fa-microscope text-green-primary"></i> Discoveries in ID
            </h3>
          </div>
          <div class="p-4 space-y-4">
            <div class="relative rounded-xl overflow-hidden h-32 group">
              <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_fa75d00656_d270862a86c9baba.png" alt="rare red ginger subspecies documented in Sumatra rainforest, botanical discovery, professional photo" />
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent p-3 flex flex-col justify-end">
                <p class="text-[10px] font-bold text-amber-accent uppercase tracking-widest mb-0.5">Sumatra</p>
                <p class="text-xs font-bold text-white leading-snug">New Red Ginger Subspecies Documented</p>
              </div>
            </div>
            <div class="relative rounded-xl overflow-hidden h-32 group">
              <img class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" src="https://storage.googleapis.com/uxpilot-auth.appspot.com/gen_7b1d953c52_614434b97adde7e2.png" alt="indigenous medical plant knowledge mapping Kalimantan, ethnobotany field research, professional phot" />
              <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent p-3 flex flex-col justify-end">
                <p class="text-[10px] font-bold text-amber-accent uppercase tracking-widest mb-0.5">Kalimantan</p>
                <p class="text-xs font-bold text-white leading-snug">Ethnobotanical Map of Dayak Communities</p>
              </div>
            </div>
          </div>
          <button class="w-full py-3 text-xs font-bold text-slate-500 hover:text-green-primary hover:bg-slate-50 transition border-t border-slate-100">View Research Blog</button>
        </div>

        <!-- CONTRIBUTOR CTA -->
        <div class="bg-green-primary rounded-2xl p-6 text-white text-center">
          <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fa-solid fa-cloud-arrow-up text-xl"></i>
          </div>
          <h4 class="font-bold mb-2">Publish Your Work</h4>
          <p class="text-xs text-green-pale/80 leading-relaxed mb-6">Contribute to Indonesia's largest biodiversity database and reach thousands of researchers.</p>
          <button class="w-full bg-white text-green-primary font-bold py-3 rounded-xl text-xs hover:bg-green-pale transition">Submit Manuscript</button>
        </div>

      </div>
    </div>
  </main>

  <script src="/js/Riset.js"></script>

@endsection