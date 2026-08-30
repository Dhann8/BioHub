<aside id="sidebar" class="w-64 h-screen sticky top-0 bg-[#0f2817] flex flex-col flex-shrink-0 z-20">

  <!-- Brand -->
  <div class="flex items-center gap-3 px-5 py-6 border-b border-white/10">
    <div class="w-9 h-9 rounded-xl bg-[#2E7D32] flex items-center justify-center shadow-sm">
      <i class="fa-solid fa-leaf text-white text-base"></i>
    </div>
    <span class="text-white font-bold text-lg tracking-wide">BioHub</span>
  </div>

  <!-- Nav -->
  <nav class="flex-1 px-3 pt-5 space-y-1 overflow-y-auto scrollbar-thin">

    <p class="text-white/30 text-[10px] font-semibold uppercase tracking-widest px-3 mb-2">Main Menu</p>

    <a href="{{ route('admin.dashboard') }}"
      class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg cursor-pointer {{ request()->routeIs('admin.dashboard') ? 'sidebar-active' : 'text-white/70' }}">
      <i class="fa-solid fa-gauge-high w-4 text-center"></i>
      <span class="text-sm font-medium">Dashboard</span>
    </a>

    <!-- Fauna Management (Dropdown) -->
    <div class="space-y-1">
      <button type="button" onclick="toggleFaunaSubmenu()"
        class="w-full sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg cursor-pointer transition-colors {{ request()->routeIs('admin.fauna.*') || request()->routeIs('admin.fauna-locations.*') || request()->routeIs('admin.fauna-details.*') ? 'bg-white/10 text-white font-semibold' : 'text-white/70' }}">
        <i class="fa-solid fa-paw w-4 text-center"></i>
        <span class="text-sm font-medium">Fauna Management</span>
        <span class="ml-auto text-white/40 text-xs transition-transform duration-200" id="fauna-menu-arrow">
          <i
            class="fa-solid fa-chevron-down text-[10px] {{ request()->routeIs('admin.fauna.*') || request()->routeIs('admin.fauna-locations.*') || request()->routeIs('admin.fauna-details.*') ? 'rotate-180' : '' }}"></i>
        </span>
      </button>

      <div id="fauna-submenu"
        class="pl-7 space-y-1 {{ request()->routeIs('admin.fauna.*') || request()->routeIs('admin.fauna-locations.*') || request()->routeIs('admin.fauna-details.*') ? '' : 'hidden' }}">
        <a href="{{ route('admin.fauna.index') }}"
          class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.fauna.index') ? 'sidebar-active font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
          <i class="fa-solid fa-list w-3 text-center text-amber-500"></i>
          <span>Daftar Fauna</span>
        </a>
        <a href="{{ route('admin.fauna-details.index') }}"
          class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.fauna-details.*') ? 'sidebar-active font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
          <i class="fa-solid fa-circle-info w-3 text-center text-amber-300"></i>
          <span>Detail & Karakteristik</span>
        </a>
        <a href="{{ route('admin.fauna-locations.index') }}"
          class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.fauna-locations.*') ? 'sidebar-active font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
          <i class="fa-solid fa-location-dot w-3 text-center text-amber-400"></i>
          <span>Lokasi & GIS Fauna</span>
        </a>
      </div>
    </div>

    <!-- TOGA Herbal Management (Dropdown) -->
    <div class="space-y-1">
      <button type="button" onclick="toggleHerbalSubmenu()"
        class="w-full sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg cursor-pointer transition-colors {{ request()->routeIs('admin.herbal.*') || request()->routeIs('admin.herbal-details.*') ? 'bg-white/10 text-white font-semibold' : 'text-white/70' }}">
        <i class="fa-solid fa-seedling w-4 text-center"></i>
        <span class="text-sm font-medium">TOGA Herbal Mgmt</span>
        <span class="ml-auto text-white/40 text-xs transition-transform duration-200" id="herbal-menu-arrow">
          <i
            class="fa-solid fa-chevron-down text-[10px] {{ request()->routeIs('admin.herbal.*') || request()->routeIs('admin.herbal-details.*') ? 'rotate-180' : '' }}"></i>
        </span>
      </button>

      <div id="herbal-submenu"
        class="pl-7 space-y-1 {{ request()->routeIs('admin.herbal.*') || request()->routeIs('admin.herbal-details.*') ? '' : 'hidden' }}">
        <a href="{{ route('admin.herbal.index') }}"
          class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.herbal.index') ? 'sidebar-active font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
          <i class="fa-solid fa-list w-3 text-center text-emerald-400"></i>
          <span>Daftar Herbal</span>
        </a>
        <a href="{{ route('admin.herbal-details.index') }}"
          class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs transition-colors {{ request()->routeIs('admin.herbal-details.*') ? 'sidebar-active font-semibold' : 'text-white/70 hover:bg-white/5 hover:text-white' }}">
          <i class="fa-solid fa-flask w-3 text-center text-emerald-300"></i>
          <span>Detail & Kandungan</span>
        </a>
      </div>
    </div>

    <a href="{{ route('admin.crowdsourcing.index') }}"
      class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg cursor-pointer {{ request()->routeIs('admin.crowdsourcing.*') ? 'sidebar-active' : 'text-white/70' }}">
      <i class="fa-solid fa-inbox w-4 text-center"></i>
      <span class="text-sm font-medium">Crowdsourcing Queue</span>
      @php $pendingCrowdsource = \App\Models\Contribution::where('status', 'pending')->count(); @endphp
      @if($pendingCrowdsource > 0)
        <span
          class="ml-auto bg-[#D97706] text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full">{{ $pendingCrowdsource }}</span>
      @endif
    </a>

    <a href="{{ route('map') }}"
      class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg cursor-pointer {{ request()->routeIs('map') ? 'sidebar-active' : 'text-white/70' }}">
      <i class="fa-solid fa-map-location-dot w-4 text-center"></i>
      <span class="text-sm font-medium">Web GIS Spatial Data</span>
    </a>

    <a href="{{ route('admin.users.index') }}"
      class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg cursor-pointer {{ request()->routeIs('admin.users.*') ? 'sidebar-active' : 'text-white/70' }}">
      <i class="fa-solid fa-users-gear w-4 text-center"></i>
      <span class="text-sm font-medium">User & Role Access</span>
    </a>

    <p class="text-white/30 text-[10px] font-semibold uppercase tracking-widest px-3 mb-2 mt-5">System</p>

    <a href="{{ route('admin.settings') }}"
      class="sidebar-item flex items-center gap-3 px-3 py-2.5 rounded-lg cursor-pointer {{ request()->routeIs('admin.settings') ? 'sidebar-active' : 'text-white/70' }}">
      <i class="fa-solid fa-gear w-4 text-center"></i>
      <span class="text-sm font-medium">Settings</span>
    </a>
  </nav>

  <!-- Profile Widget -->
  <div class="px-4 py-4 border-t border-white/10">
    <div class="flex items-center gap-3 mb-3">
      <img
        src="{{ Auth::user()->foto_profile ? asset('storage/profile/' . Auth::user()->foto_profile) : asset('image/iconProfil.jpg') }}"
        class="w-9 h-9 rounded-full object-cover ring-2 ring-[#D97706]/60" />
      <div class="flex-1 min-w-0">
        <p class="text-white text-xs font-semibold leading-tight truncate">
          {{ Auth::check() ? Auth::user()->name : 'Dr. Pakar Biodiversity' }}</p>
        <span
          class="inline-block mt-0.5 bg-[#D97706]/20 text-[#D97706] text-[10px] font-semibold px-1.5 py-0.5 rounded">Admin
          Validator</span>
      </div>
    </div>
    <form action="{{ route('logout') }}" method="POST">
      @csrf
      <button type="submit"
        class="w-full flex items-center justify-center gap-2 bg-white/10 hover:bg-white/15 text-white/80 text-xs font-medium py-2 rounded-lg transition-colors">
        <i class="fa-solid fa-right-from-bracket"></i> Logout
      </button>
    </form>
  </div>
</aside>

<script>
  function toggleFaunaSubmenu() {
    const submenu = document.getElementById('fauna-submenu');
    const arrow = document.getElementById('fauna-menu-arrow');
    if (submenu) submenu.classList.toggle('hidden');
    if (arrow) arrow.firstElementChild.classList.toggle('rotate-180');
  }

  function toggleHerbalSubmenu() {
    const submenu = document.getElementById('herbal-submenu');
    const arrow = document.getElementById('herbal-menu-arrow');
    if (submenu) submenu.classList.toggle('hidden');
    if (arrow) arrow.firstElementChild.classList.toggle('rotate-180');
  }
</script>