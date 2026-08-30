<!-- MODAL ADD NEW SPECIES (POPUP MODAL) -->
<div id="add-species-modal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden border border-gray-100 transform scale-95 transition-all duration-300" id="modal-container">
        
        <!-- Modal Header -->
        <div class="bg-[#1E4D2B] px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-[#D97706] rounded-xl flex items-center justify-center text-white">
                    <i class="fa-solid fa-paw text-base"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white leading-tight">Tambah Spesies Fauna Baru</h3>
                    <p class="text-xs text-white/70">Masukkan data taksonomi & status konservasi spesies</p>
                </div>
            </div>
            <button onclick="closeAddSpeciesModal()" type="button" class="text-white/60 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Modal Body (Form) -->
        <form action="{{ route('admin.fauna.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto custom-scrollbar">
            @csrf

            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs px-4 py-3 rounded-xl">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 text-xs px-4 py-3 rounded-xl space-y-1">
                    @foreach($errors->all() as $error)
                        <p>â€¢ {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- 2-Column Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nama Lokal -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Lokal <span class="text-red-500">*</span></label>
                    <input type="text" name="local_name" required placeholder="Contoh: Harimau Sumatera" 
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-gray-800" />
                </div>

                <!-- Nama Ilmiah -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Ilmiah <span class="text-red-500">*</span></label>
                    <input type="text" name="scientific_name" required placeholder="Contoh: Panthera tigris sumatrae" 
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all italic text-gray-800" />
                </div>
            </div>

            <!-- 2-Column Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Taksonomi Class -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Kelas Taksonomi <span class="text-red-500">*</span></label>
                    <select name="taxonomy_id" required 
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-gray-800">
                        <option value="">Pilih Kelas Taksonomi</option>
                        @foreach($taxonomies as $tax)
                            <option value="{{ $tax->id }}">{{ $tax->class_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status IUCN -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Status IUCN <span class="text-red-500">*</span></label>
                    <select name="iucn_status" required 
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-gray-800">
                        <option value="">Pilih Status IUCN</option>
                        <option value="CR">CR - Critically Endangered</option>
                        <option value="EN">EN - Endangered</option>
                        <option value="VU">VU - Vulnerable</option>
                        <option value="NT">NT - Near Threatened</option>
                        <option value="LC">LC - Least Concern</option>
                    </select>
                </div>
            </div>

            <!-- 2-Column Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Ukuran Tubuh -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Ukuran Tubuh</label>
                    <select name="size" 
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-gray-800">
                        <option value="">Pilih Ukuran</option>
                        <option value="Kecil">Kecil</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Besar">Besar</option>
                    </select>
                </div>

                <!-- Habitat Utama -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Habitat Utama</label>
                    <input type="text" name="primary_habitat" placeholder="Contoh: Hutan Hujan Tropis" 
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-gray-800" />
                </div>
            </div>

            <!-- Fitur Fisik & Perilaku -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Fitur Fisik / Tag (Pisahkan dengan koma)</label>
                <input type="text" name="physical_features_input" placeholder="Contoh: Soliter, Karnivora, Apex Predator" 
                    class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-gray-800" />
            </div>

            <!-- Deskripsi Spesies -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi Spesies <span class="text-red-500">*</span></label>
                <textarea name="description" rows="3" required placeholder="Tuliskan deskripsi lengkap ciri khas spesies..." 
                    class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all resize-none text-gray-800"></textarea>
            </div>

            <!-- Input Lokasi GIS (FaunaLocation) -->
            <div class="border-t border-gray-100 pt-3">
                <div class="flex items-center gap-2 mb-2">
                    <i class="fa-solid fa-location-dot text-[#D97706] text-xs"></i>
                    <span class="text-xs font-bold text-gray-800 uppercase tracking-wider">Lokasi Habitat / GIS (Opsional)</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Nama Wilayah / Region</label>
                        <input type="text" name="region_name" placeholder="Contoh: TN Ujung Kulon" 
                            class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Latitude</label>
                        <input type="number" step="any" name="latitude" placeholder="-6.7500" 
                            class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                    </div>
                    <div>
                        <label class="block text-[11px] font-semibold text-gray-600 mb-1">Longitude</label>
                        <input type="number" step="any" name="longitude" placeholder="105.3333" 
                            class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                    </div>
                </div>
            </div>

            <!-- Upload Foto Spesies -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Foto Bukti / Gambar Spesies</label>
                <input type="file" name="image" accept="image/*" 
                    class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#1E4D2B]/10 file:text-[#1E4D2B] hover:file:bg-[#1E4D2B]/20 cursor-pointer border border-gray-200 rounded-xl bg-[#F8FAFC]" />
            </div>

            <!-- Form Actions -->
            <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeAddSpeciesModal()" 
                    class="flex-1 py-2.5 border border-gray-200 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" 
                    class="flex-1 py-2.5 bg-[#1E4D2B] hover:bg-[#163a20] text-white text-xs font-semibold rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Simpan Spesies
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openAddSpeciesModal() {
        const modal = document.getElementById('add-species-modal');
        const container = document.getElementById('modal-container');
        modal.classList.remove('opacity-0', 'pointer-events-none');
        container.classList.remove('scale-95');
        container.classList.add('scale-100');
    }

    function closeAddSpeciesModal() {
        const modal = document.getElementById('add-species-modal');
        const container = document.getElementById('modal-container');
        modal.classList.add('opacity-0', 'pointer-events-none');
        container.classList.remove('scale-100');
        container.classList.add('scale-95');
    }
</script>

