<nav id="header" class="fixed top-0 w-full z-50 bg-white/95 backdrop-blur-md border-b border-green-100 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between h-16">
      <a href="{{ route('homepage') }}" class="flex items-center gap-2">
        <div class="w-9 h-9 rounded-xl bg-[#2E7D32] flex items-center justify-center shadow-sm">
          <i class="fa-solid fa-leaf text-white text-base"></i>
        </div>
        <span class="font-bold text-xl text-[#2E7D32] tracking-tight">Nusantara <span class="text-[#D97706]">BioHub</span></span>
      </a>
      <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
        <a href="{{ route('homepage') }}" class="hover:text-[#2E7D32] transition">Beranda</a>
        <a href="{{ route('spesies') }}" class="hover:text-[#2E7D32] transition">Spesies</a>
        <a href="{{ route('herbal') }}" class="hover:text-[#2E7D32] transition">Herbal</a>
        <a href="{{ route('map') }}" class="hover:text-[#2E7D32] transition">Peta Interaktif</a>
        <a href="{{ route('riset') }}" class="hover:text-[#2E7D32] transition">Riset</a>
        <a href="{{ route('kontribusi') }}" class="hover:text-[#2E7D32] transition">Kontribusi</a>
      </div>
      <div class="flex items-center gap-3">
        @auth
          <div class="flex items-center gap-3">
            <span class="text-sm font-semibold text-gray-700 flex items-center gap-1.5 bg-green-50 px-3 py-1.5 rounded-lg border border-green-200">
              <i class="fa-solid fa-user-circle text-[#2E7D32] text-base"></i>
              {{ Auth::user()->name }}
            </span>
            <form action="{{ route('logout') }}" method="POST" class="inline">
              @csrf
              <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 text-sm font-medium px-3 py-1.5 rounded-lg border border-red-200 transition flex items-center gap-1">
                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                <span>Keluar</span>
              </button>
            </form>
          </div>
        @else
          <button type="button" onclick="openAuthModal('login')" class="hidden md:inline text-sm font-medium text-gray-600 hover:text-[#2E7D32] transition focus:outline-none">
            Masuk
          </button>
          <button type="button" onclick="openAuthModal('register')" class="bg-[#2E7D32] text-white text-sm font-semibold px-4 py-2 rounded-lg hover:bg-[#1B5E20] transition shadow-sm focus:outline-none">
            Daftar Gratis
          </button>
        @endauth
        <button class="md:hidden text-gray-600"><i class="fa-solid fa-bars text-xl"></i></button>
      </div>
    </div>
</nav>
