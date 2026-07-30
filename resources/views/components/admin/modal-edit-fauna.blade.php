<!-- MODAL EDIT SPECIES (POPUP MODAL) -->
<div id="edit-species-modal" class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden border border-gray-100 transform scale-95 transition-all duration-300" id="edit-modal-container">
        
        <!-- Modal Header -->
        <div class="bg-amber-600 px-6 py-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 bg-white text-amber-600 rounded-xl flex items-center justify-center font-bold text-lg">
                    <i class="fa-solid fa-pen text-base"></i>
                </div>
                <div>
                    <h3 class="text-base font-bold text-white leading-tight">Edit Spesies Fauna</h3>
                    <p class="text-xs text-white/70">Perbarui data taksonomi, deskripsi & status konservasi spesies</p>
                </div>
            </div>
            <button onclick="closeEditSpeciesModal()" type="button" class="text-white/60 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <!-- Modal Body (Form) -->
        <form id="edit-species-form" action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-4 max-h-[80vh] overflow-y-auto custom-scrollbar">
            @csrf
            @method('PUT')

            <!-- 2-Column Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Nama Lokal -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Lokal <span class="text-red-500">*</span></label>
                    <input type="text" name="local_name" id="edit_local_name" required placeholder="Contoh: Harimau Sumatera" 
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-gray-800" />
                </div>

                <!-- Nama Ilmiah -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Ilmiah <span class="text-red-500">*</span></label>
                    <input type="text" name="scientific_name" id="edit_scientific_name" required placeholder="Contoh: Panthera tigris sumatrae" 
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all italic text-gray-800" />
                </div>
            </div>

            <!-- 2-Column Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <!-- Taksonomi Class -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Kelas Taksonomi <span class="text-red-500">*</span></label>
                    <select name="taxonomy_id" id="edit_taxonomy_id" required 
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
                    <select name="iucn_status" id="edit_iucn_status" required 
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-gray-800">
                        <option value="">-- Pilih Status IUCN --</option>
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
                    <select name="size" id="edit_size" 
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-gray-800">
                        <option value="">-- Pilih Ukuran --</option>
                        <option value="Kecil">Kecil</option>
                        <option value="Sedang">Sedang</option>
                        <option value="Besar">Besar</option>
                    </select>
                </div>

                <!-- Habitat Utama -->
                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Habitat Utama</label>
                    <input type="text" name="primary_habitat" id="edit_primary_habitat" placeholder="Contoh: Hutan Hujan Tropis" 
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-gray-800" />
                </div>
            </div>

            <!-- Fitur Fisik & Perilaku -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Fitur Fisik / Tag (Pisahkan dengan koma)</label>
                <input type="text" name="physical_features_input" id="edit_physical_features_input" placeholder="Contoh: Soliter, Karnivora, Apex Predator" 
                    class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all text-gray-800" />
            </div>

            <!-- Deskripsi Spesies -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi Spesies <span class="text-red-500">*</span></label>
                <textarea name="description" id="edit_description" rows="3" required placeholder="Tuliskan deskripsi lengkap ciri khas spesies..." 
                    class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all resize-none text-gray-800"></textarea>
            </div>

            <!-- Upload Foto Spesies -->
            <div>
                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Foto Bukti / Gambar Spesies (Biarkan kosong jika tidak diubah)</label>
                <input type="file" name="image" accept="image/*" 
                    class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-700 hover:file:bg-amber-100 cursor-pointer border border-gray-200 rounded-xl bg-[#F8FAFC]" />
            </div>

            <!-- Form Actions -->
            <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
                <button type="button" onclick="closeEditSpeciesModal()" 
                    class="flex-1 py-2.5 border border-gray-200 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                    Batal
                </button>
                <button type="submit" 
                    class="flex-1 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                    <i class="fa-solid fa-check text-xs"></i> Perbarui Spesies
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openEditSpeciesModal(fauna) {
        const modal = document.getElementById('edit-species-modal');
        const container = document.getElementById('edit-modal-container');
        const form = document.getElementById('edit-species-form');
        
        form.action = `{{ url('admin/fauna') }}/${fauna.id}`;
        
        document.getElementById('edit_local_name').value = fauna.local_name;
        document.getElementById('edit_scientific_name').value = fauna.scientific_name;
        document.getElementById('edit_taxonomy_id').value = fauna.taxonomy_id;
        document.getElementById('edit_iucn_status').value = fauna.iucn_status;
        document.getElementById('edit_size').value = fauna.size || 'Sedang';
        document.getElementById('edit_primary_habitat').value = fauna.primary_habitat || '';
        document.getElementById('edit_description').value = fauna.description;
        
        let features = '';
        if (fauna.physical_features) {
            if (Array.isArray(fauna.physical_features)) {
                features = fauna.physical_features.join(', ');
            } else if (typeof fauna.physical_features === 'string') {
                try {
                    let parsed = JSON.parse(fauna.physical_features);
                    if (Array.isArray(parsed)) {
                        features = parsed.join(', ');
                    }
                } catch(e) {
                    features = fauna.physical_features;
                }
            }
        }
        document.getElementById('edit_physical_features_input').value = features;
        
        modal.classList.remove('opacity-0', 'pointer-events-none');
        container.classList.remove('scale-95');
        container.classList.add('scale-100');
    }

    function closeEditSpeciesModal() {
        const modal = document.getElementById('edit-species-modal');
        const container = document.getElementById('edit-modal-container');
        modal.classList.add('opacity-0', 'pointer-events-none');
        container.classList.remove('scale-100');
        container.classList.add('scale-95');
    }
</script>

