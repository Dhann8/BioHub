  <footer id="footer" class="bg-gray-900 text-gray-400 pt-16 pb-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-2 md:grid-cols-5 gap-8 mb-12">
        <!-- Brand -->
        <div class="col-span-2">
          <a href="{{ route('homepage') }}" class="flex items-center gap-2 mb-4">
            <div class="w-9 h-9 rounded-xl bg-[#2E7D32] flex items-center justify-center">
              <i class="fa-solid fa-leaf text-white text-base"></i>
            </div>
            <span class="font-bold text-xl text-white">Nusantara <span class="text-[#D97706]">BioHub</span></span>
          </a>
          <p class="text-sm leading-relaxed mb-5 max-w-xs">Platform keanekaragaman hayati dan kearifan herbal Indonesia terlengkap dan terpercaya.</p>
          <div class="flex gap-3">
            <a href="#" class="w-9 h-9 rounded-lg bg-gray-800 hover:bg-[#2E7D32] flex items-center justify-center transition"><i class="fa-brands fa-instagram text-sm"></i></a>
            <a href="#" class="w-9 h-9 rounded-lg bg-gray-800 hover:bg-[#2E7D32] flex items-center justify-center transition"><i class="fa-brands fa-twitter text-sm"></i></a>
            <a href="#" class="w-9 h-9 rounded-lg bg-gray-800 hover:bg-[#2E7D32] flex items-center justify-center transition"><i class="fa-brands fa-youtube text-sm"></i></a>
            <a href="#" class="w-9 h-9 rounded-lg bg-gray-800 hover:bg-[#2E7D32] flex items-center justify-center transition"><i class="fa-brands fa-github text-sm"></i></a>
          </div>
        </div>

        <!-- Platform Links -->
        <div>
          <p class="font-semibold text-white text-sm mb-4">Platform</p>
          <ul class="space-y-2 text-sm">
            <li><a href="{{ route('homepage') }}" class="hover:text-white transition">Beranda</a></li>
            <li><a href="{{ route('spesies') }}" class="hover:text-white transition">Katalog Spesies</a></li>
            <li><a href="{{ route('herbal') }}" class="hover:text-white transition">Herbal Finder</a></li>
            <li><a href="{{ route('map') }}" class="hover:text-white transition">Peta Interaktif</a></li>
            <li><a href="{{ route('riset') }}" class="hover:text-white transition">Jurnal Riset</a></li>
          </ul>
        </div>

        <!-- Komunitas Links -->
        <div>
          <p class="font-semibold text-white text-sm mb-4">Komunitas</p>
          <ul class="space-y-2 text-sm">
            <li><a href="{{ route('kontribusi') }}" class="hover:text-white transition">Upload Data</a></li>
            <li><a href="{{ route('kontribusi') }}" class="hover:text-white transition">Citizen Science</a></li>
            <li><a href="{{ route('kontribusi') }}" class="hover:text-white transition">Lapor Sighting</a></li>
          </ul>
        </div>

        <!-- Info Links -->
        <div>
          <p class="font-semibold text-white text-sm mb-4">Info</p>
          <ul class="space-y-2 text-sm">
            <li><a href="{{ route('homepage') }}" class="hover:text-white transition">Tentang Kami</a></li>
            <li><a href="#" class="hover:text-white transition">Kebijakan Privasi</a></li>
            <li><a href="#" class="hover:text-white transition">Kontak</a></li>
          </ul>
        </div>
      </div>

      <div class="border-t border-gray-800 pt-6 flex flex-col md:flex-row justify-between items-center gap-3 text-xs">
        <p>&copy; {{ date('Y') }} Nusantara BioHub. Hak Cipta Dilindungi.</p>
        <p class="flex items-center gap-1.5">Dibuat dengan <i class="fa-solid fa-heart text-[#D97706]"></i> untuk Biodiversitas Indonesia</p>
      </div>
    </div>
  </footer>
