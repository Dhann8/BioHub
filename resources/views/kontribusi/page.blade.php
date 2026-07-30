@extends('layout.base')

@section('content')

<main class="pt-24 pb-20 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

  {{-- Header --}}
  <div class="mb-10 text-center">
    <h1 class="text-3xl font-black text-slate-900 mb-3">Upload Data Anda</h1>
    <p class="text-slate-500 max-w-xl mx-auto">Bantu memperkaya database keanekaragaman hayati Indonesia. Setiap kontribusi yang Anda kirim akan ditinjau oleh tim ahli kami sebelum dipublikasikan.</p>
  </div>

  @guest
  {{-- Login Notice --}}
  <div class="mb-8 bg-amber-light border border-amber-200 text-amber-dark px-6 py-5 rounded-2xl flex items-start gap-4">
    <div class="w-10 h-10 rounded-xl bg-amber-accent/10 flex items-center justify-center flex-shrink-0">
      <i class="fa-solid fa-lock text-amber-accent"></i>
    </div>
    <div>
      <p class="font-bold text-sm mb-1">Login Diperlukan</p>
      <p class="text-xs leading-relaxed">Anda harus <button onclick="openAuthModal('login')" class="font-bold underline">masuk</button> atau <button onclick="openAuthModal('register')" class="font-bold underline">daftar</button> untuk mengirim kontribusi data ke platform kami.</p>
    </div>
  </div>
  @endguest


  {{-- Alert Messages --}}
  @if(session('success'))
    <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-5 py-4 rounded-2xl flex items-start gap-3">
      <i class="fa-solid fa-circle-check text-emerald-500 text-xl mt-0.5 flex-shrink-0"></i>
      <div>
        <p class="font-bold text-sm">Berhasil Dikirim!</p>
        <p class="text-xs mt-0.5">{{ session('success') }}</p>
      </div>
    </div>
  @endif

  @if(session('error'))
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-2xl flex items-start gap-3">
      <i class="fa-solid fa-circle-xmark text-red-500 text-xl mt-0.5 flex-shrink-0"></i>
      <div>
        <p class="font-bold text-sm">Terjadi Kesalahan</p>
        <p class="text-xs mt-0.5">{{ session('error') }}</p>
      </div>
    </div>
  @endif

  @if($errors->any())
    <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-2xl">
      <p class="font-bold text-sm mb-2 flex items-center gap-2"><i class="fa-solid fa-triangle-exclamation"></i> Harap perbaiki data berikut:</p>
      <ul class="text-xs space-y-1 list-disc list-inside">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Category Selector --}}
  <div class="mb-8">
    <p class="text-sm font-bold text-slate-700 mb-3">Pilih Jenis Kontribusi <span class="text-red-500">*</span></p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4" id="categoryCards">
      <button type="button" onclick="selectCategory('fauna')" id="cat-fauna"
        class="category-card border-2 border-slate-200 rounded-2xl p-5 text-left hover:border-green-primary transition cursor-pointer bg-white group">
        <div class="w-10 h-10 rounded-xl bg-slate-100 group-[.active]:bg-green-pale flex items-center justify-center mb-3">
          <i class="fa-solid fa-paw text-slate-400 group-[.active]:text-green-primary text-lg"></i>
        </div>
        <h3 class="font-bold text-slate-800 mb-1">Fauna</h3>
        <p class="text-xs text-slate-500">Spesies hewan liar, reptil, burung, dll.</p>
      </button>

      <button type="button" onclick="selectCategory('herbal')" id="cat-herbal"
        class="category-card border-2 border-slate-200 rounded-2xl p-5 text-left hover:border-green-primary transition cursor-pointer bg-white group">
        <div class="w-10 h-10 rounded-xl bg-slate-100 group-[.active]:bg-green-pale flex items-center justify-center mb-3">
          <i class="fa-solid fa-seedling text-slate-400 group-[.active]:text-green-primary text-lg"></i>
        </div>
        <h3 class="font-bold text-slate-800 mb-1">Herbal / TOGA</h3>
        <p class="text-xs text-slate-500">Tanaman obat, tumbuhan berkhasiat medis.</p>
      </button>

      <button type="button" onclick="selectCategory('paper')" id="cat-paper"
        class="category-card border-2 border-slate-200 rounded-2xl p-5 text-left hover:border-green-primary transition cursor-pointer bg-white group">
        <div class="w-10 h-10 rounded-xl bg-slate-100 group-[.active]:bg-green-pale flex items-center justify-center mb-3">
          <i class="fa-solid fa-file-lines text-slate-400 group-[.active]:text-green-primary text-lg"></i>
        </div>
        <h3 class="font-bold text-slate-800 mb-1">Makalah Riset</h3>
        <p class="text-xs text-slate-500">Jurnal ilmiah, laporan penelitian.</p>
      </button>
    </div>
  </div>

  {{-- Upload Form --}}
  <div id="uploadForm" class="hidden">
    <form action="{{ route('contribute.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
      @csrf
      <input type="hidden" name="category" id="categoryInput" value="">

      {{-- Main Form Card --}}
      <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="bg-slate-50 px-6 py-4 border-b border-slate-100">
          <h2 class="font-bold text-slate-800 flex items-center gap-2">
            <i class="fa-solid fa-pen-to-square text-green-primary"></i>
            <span id="formSectionTitle">Informasi Data</span>
          </h2>
        </div>

        <div class="p-6 space-y-5">
          {{-- Title --}}
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Judul / Nama <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" required
              placeholder="Masukkan nama spesies, tanaman, atau judul makalah..."
              class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 outline-none focus:ring-2 focus:ring-green-primary/30 focus:border-green-primary transition" />
          </div>

          {{-- Description --}}
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">Deskripsi <span class="text-red-500">*</span></label>
            <textarea name="description" rows="4" required
              placeholder="Jelaskan temuan Anda, lokasi ditemukan, karakteristik khusus, atau abstrak makalah..."
              class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 outline-none focus:ring-2 focus:ring-green-primary/30 focus:border-green-primary transition resize-none">{{ old('description') }}</textarea>
          </div>

          {{-- Coordinate Fields (hanya fauna/herbal) --}}
          <div id="coordinateFields" class="grid grid-cols-2 gap-4">
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Latitude <span class="text-slate-400 font-normal">(opsional)</span></label>
              <input type="number" name="latitude" value="{{ old('latitude') }}" step="any" min="-90" max="90"
                placeholder="-6.200000"
                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 outline-none focus:ring-2 focus:ring-green-primary/30 focus:border-green-primary transition" />
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1.5">Longitude <span class="text-slate-400 font-normal">(opsional)</span></label>
              <input type="number" name="longitude" value="{{ old('longitude') }}" step="any" min="-180" max="180"
                placeholder="106.816666"
                class="w-full border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-800 outline-none focus:ring-2 focus:ring-green-primary/30 focus:border-green-primary transition" />
            </div>
            <div class="col-span-2">
              <button type="button" id="getLocationBtn"
                class="text-xs font-semibold text-green-primary hover:underline flex items-center gap-1">
                <i class="fa-solid fa-location-crosshairs"></i> Gunakan Lokasi Saya Saat Ini
              </button>
            </div>
          </div>

          {{-- Photo / File Upload --}}
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5">
              <span id="photoLabel">Foto / Gambar</span> <span class="text-red-500">*</span>
            </label>
            <div id="dropzone"
              class="border-2 border-dashed border-slate-200 rounded-2xl p-8 text-center hover:border-green-primary hover:bg-green-pale/30 transition cursor-pointer"
              onclick="document.getElementById('photoInput').click()"
              ondragover="event.preventDefault(); this.classList.add('border-green-primary','bg-green-pale/30')"
              ondragleave="this.classList.remove('border-green-primary','bg-green-pale/30')"
              ondrop="handleDrop(event)">
              <i class="fa-solid fa-cloud-arrow-up text-3xl text-slate-300 mb-3"></i>
              <p class="text-sm font-semibold text-slate-500">Klik atau seret file ke sini</p>
              <p class="text-xs text-slate-400 mt-1" id="dropzoneSubtext">JPG, PNG, WEBP — Maks. 2MB</p>
              <div id="filePreview" class="mt-4 hidden">
                <img id="previewImg" src="" alt="preview" class="max-h-48 mx-auto rounded-xl object-contain">
                <p id="previewName" class="text-xs text-slate-500 mt-2"></p>
              </div>
            </div>
            <input type="file" name="photo" id="photoInput" accept="image/*" class="hidden" onchange="handleFileSelect(this)">
          </div>
        </div>
      </div>

      {{-- Info Panel --}}
      <div class="bg-amber-light border border-amber-200 rounded-2xl p-5 flex gap-4">
        <div class="flex-shrink-0">
          <div class="w-10 h-10 rounded-xl bg-amber-accent/10 flex items-center justify-center">
            <i class="fa-solid fa-hourglass-half text-amber-accent"></i>
          </div>
        </div>
        <div>
          <p class="font-bold text-amber-dark text-sm">Proses Verifikasi</p>
          <p class="text-xs text-amber-dark/80 mt-1 leading-relaxed">Data yang Anda kirim akan masuk ke antrian moderasi. Tim ahli kami akan memvalidasi setiap kontribusi sebelum ditampilkan secara publik. Proses ini biasanya memakan waktu 1–3 hari kerja.</p>
        </div>
      </div>

      {{-- Submit --}}
      <div class="flex gap-3">
        <button type="button" onclick="resetForm()"
          class="flex-1 border border-slate-200 text-slate-600 font-bold py-3.5 rounded-xl hover:bg-slate-50 transition text-sm">
          Batal
        </button>
        <button type="submit"
          class="flex-2 bg-green-primary hover:bg-green-dark text-white font-bold py-3.5 px-8 rounded-xl transition text-sm shadow-lg shadow-green-primary/20 flex items-center gap-2 justify-center">
          <i class="fa-solid fa-paper-plane"></i>
          Kirim Kontribusi
        </button>
      </div>
    </form>
  </div>

  {{-- My Contributions History --}}
  @auth
  <div class="mt-16">
    <div class="flex items-center justify-between mb-6">
      <div>
        <h2 class="text-xl font-black text-slate-900">Riwayat Kontribusi Saya</h2>
        <p class="text-sm text-slate-500">Pantau status verifikasi data yang sudah Anda kirim</p>
      </div>
    </div>

    @if($myContributions->isEmpty())
      <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
        <i class="fa-solid fa-inbox text-5xl text-slate-200 mb-4"></i>
        <p class="font-bold text-slate-600 mb-1">Belum Ada Kontribusi</p>
        <p class="text-xs text-slate-400">Mulai berkontribusi dengan memilih kategori di atas.</p>
      </div>
    @else
      <div class="space-y-3">
        @foreach($myContributions as $contrib)
          @php
            $statusClasses = [
              'pending'  => 'bg-amber-100 text-amber-700',
              'approved' => 'bg-emerald-100 text-emerald-700',
              'rejected' => 'bg-red-100 text-red-600',
            ];
            $statusLabels = [
              'pending'  => 'Menunggu',
              'approved' => 'Disetujui',
              'rejected' => 'Ditolak',
            ];
            $catIcons = [
              'fauna'  => 'fa-paw',
              'herbal' => 'fa-seedling',
              'paper'  => 'fa-file-lines',
            ];
          @endphp
          <div class="bg-white rounded-2xl border border-slate-200 p-5 flex items-center gap-4 hover:shadow-sm transition">
            {{-- Category Icon --}}
            <div class="w-12 h-12 rounded-xl bg-green-pale flex items-center justify-center flex-shrink-0">
              <i class="fa-solid {{ $catIcons[$contrib->category] ?? 'fa-question' }} text-green-primary text-lg"></i>
            </div>
            {{-- Info --}}
            <div class="flex-1 min-w-0">
              <div class="flex items-center gap-2 mb-1">
                <span class="text-[10px] font-bold uppercase text-slate-400">{{ ucfirst($contrib->category) }}</span>
                <span class="text-[10px] text-slate-300">•</span>
                <span class="text-[10px] text-slate-400">{{ $contrib->created_at->format('d M Y, H:i') }}</span>
              </div>
              <h3 class="font-bold text-slate-800 text-sm truncate">{{ $contrib->title }}</h3>
              @if($contrib->moderator_notes)
                <p class="text-xs text-slate-500 mt-1 flex items-center gap-1">
                  <i class="fa-solid fa-comment-dots text-slate-300"></i>
                  Catatan: {{ $contrib->moderator_notes }}
                </p>
              @endif
            </div>
            {{-- Status --}}
            <div class="flex-shrink-0 text-right">
              <span class="text-xs font-bold px-3 py-1.5 rounded-lg {{ $statusClasses[$contrib->status] ?? 'bg-slate-100 text-slate-600' }}">
                {{ $statusLabels[$contrib->status] ?? $contrib->status }}
              </span>
              @if($contrib->reviewer)
                <p class="text-[10px] text-slate-400 mt-1">oleh {{ $contrib->reviewer->name }}</p>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
  @endauth

</main>

<style>
  .category-card.active {
    border-color: #2E7D32;
    background-color: #F0F7F1;
    box-shadow: 0 0 0 3px rgba(46,125,50,0.15);
  }
  .category-card.active .w-10 {
    background-color: #E8F5E9;
  }
  .category-card.active .fa-paw,
  .category-card.active .fa-seedling,
  .category-card.active .fa-file-lines {
    color: #2E7D32;
  }
</style>

<script>
  let selectedCategory = null;

  function selectCategory(cat) {
    selectedCategory = cat;
    document.getElementById('categoryInput').value = cat;

    // Update card styles
    document.querySelectorAll('.category-card').forEach(c => c.classList.remove('active'));
    document.getElementById('cat-' + cat).classList.add('active');

    // Show form
    document.getElementById('uploadForm').classList.remove('hidden');

    // Update UI based on category
    const coordinateFields = document.getElementById('coordinateFields');
    const photoLabel = document.getElementById('photoLabel');
    const formSectionTitle = document.getElementById('formSectionTitle');
    const dropzoneSubtext = document.getElementById('dropzoneSubtext');

    if (cat === 'paper') {
      coordinateFields.style.display = 'none';
      photoLabel.textContent = 'Foto / Cover Makalah';
      formSectionTitle.textContent = 'Informasi Makalah Riset';
      dropzoneSubtext.textContent = 'JPG, PNG, WEBP — Maks. 2MB (foto cover/gambar ilustrasi)';
    } else {
      coordinateFields.style.display = 'grid';
      photoLabel.textContent = 'Foto / Gambar';
      formSectionTitle.textContent = 'Informasi Data ' + (cat === 'fauna' ? 'Fauna' : 'Herbal');
      dropzoneSubtext.textContent = 'JPG, PNG, WEBP — Maks. 2MB';
    }

    // Smooth scroll to form
    setTimeout(() => {
      document.getElementById('uploadForm').scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 100);
  }

  function resetForm() {
    selectedCategory = null;
    document.querySelectorAll('.category-card').forEach(c => c.classList.remove('active'));
    document.getElementById('uploadForm').classList.add('hidden');
    document.getElementById('categoryInput').value = '';
    document.getElementById('filePreview').classList.add('hidden');
    window.scrollTo({ top: 0, behavior: 'smooth' });
  }

  function handleFileSelect(input) {
    if (input.files && input.files[0]) {
      const file = input.files[0];
      const reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('previewImg').src = e.target.result;
        document.getElementById('previewName').textContent = file.name + ' (' + (file.size / 1024).toFixed(1) + ' KB)';
        document.getElementById('filePreview').classList.remove('hidden');
      };
      reader.readAsDataURL(file);
    }
  }

  function handleDrop(event) {
    event.preventDefault();
    event.currentTarget.classList.remove('border-green-primary', 'bg-green-pale/30');
    const file = event.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
      const input = document.getElementById('photoInput');
      const dt = new DataTransfer();
      dt.items.add(file);
      input.files = dt.files;
      handleFileSelect(input);
    }
  }

  const getLocationBtn = document.getElementById('getLocationBtn');
  if (getLocationBtn) {
    getLocationBtn.addEventListener('click', function() {
      if (!navigator.geolocation) {
        alert('Browser Anda tidak mendukung geolokasi.');
        return;
      }
      this.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Mendapatkan lokasi...';
      navigator.geolocation.getCurrentPosition(
        (pos) => {
          document.querySelector('input[name="latitude"]').value = pos.coords.latitude.toFixed(6);
          document.querySelector('input[name="longitude"]').value = pos.coords.longitude.toFixed(6);
          this.innerHTML = '<i class="fa-solid fa-circle-check text-green-primary"></i> Lokasi berhasil didapatkan!';
        },
        (err) => {
          this.innerHTML = '<i class="fa-solid fa-location-crosshairs"></i> Gunakan Lokasi Saya Saat Ini';
          alert('Tidak bisa mendapatkan lokasi: ' + err.message);
        }
      );
    });
  }
</script>

@endsection
