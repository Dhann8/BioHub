@extends('layout.admin')
@section('content')

<div class="flex min-h-screen bg-[#F8FAFC]" x-data="{ currentTab: 'botanical' }">
    @include('components.admin.sidebar')
    
    <div class="flex-1 flex flex-col h-screen overflow-y-auto overflow-x-hidden" id="main-scroll-area">
        
        <!-- TOP HEADER -->
        <header id="header" class="bg-white border-b border-gray-100 px-6 py-4 flex items-center justify-between gap-4 sticky top-0 z-10">
            <div>
                <h1 class="text-xl font-bold text-gray-800">Herbal Details</h1>
            </div>
        </header>

        <!-- CONTENT BODY -->
        <div class="flex flex-col lg:flex-row flex-1 p-6 gap-6 items-start">
            
            <!-- LEFT PANEL: HERBAL SELECTOR -->
            <aside class="w-full lg:w-72 bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sticky top-6 self-start flex-shrink-0">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Pilih Tanaman Herbal</h2>
                <div class="space-y-1.5 max-h-[calc(100vh-180px)] overflow-y-auto pr-1 custom-scrollbar">
                    @forelse($herbals as $herbalItem)
                        <a href="?herbal_id={{ $herbalItem->id }}" 
                           class="flex items-center gap-3 p-2.5 rounded-xl border transition-all text-left {{ $selectedHerbal && $selectedHerbal->id === $herbalItem->id ? 'bg-[#1E4D2B]/5 border-[#1E4D2B] text-[#1E4D2B] font-semibold' : 'border-gray-100 hover:bg-gray-50 text-gray-700' }}">
                            <div class="w-8 h-8 rounded-lg overflow-hidden bg-gray-50 flex-shrink-0">
                                @if($herbalItem->image_url)
                                    <img class="w-full h-full object-cover" src="{{ $herbalItem->image_url }}" alt="{{ $herbalItem->local_name }}" />
                                @else
                                    <div class="w-full h-full bg-emerald-50 text-emerald-400 flex items-center justify-center">
                                        <i class="fa-solid fa-seedling text-sm"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs truncate leading-tight">{{ $herbalItem->local_name }}</p>
                                <p class="text-[10px] text-gray-400 italic truncate">{{ $herbalItem->scientific_name }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-xs text-gray-400 italic text-center py-4">Belum ada herbal terdaftar.</p>
                    @endforelse
                </div>
            </aside>

            <!-- RIGHT PANEL: EDIT DETAILS FORM -->
            <main class="flex-1 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                @if(!$selectedHerbal)
                    <div class="flex flex-col items-center justify-center p-12 text-center text-gray-400">
                        <i class="fa-solid fa-seedling text-5xl text-gray-200 mb-3"></i>
                        <h3 class="font-bold text-gray-700 mb-1">Silakan Pilih Tanaman Herbal</h3>
                        <p class="text-xs max-w-sm">Pilih salah satu tanaman herbal di panel kiri untuk mulai mengelola detail, kandungan aktif, dan informasi botaninya.</p>
                    </div>
                @else
                    <!-- Selected Herbal Banner -->
                    <div class="bg-[#1E4D2B]/5 border-b border-gray-100 px-6 py-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-white border border-gray-200 shadow-sm flex-shrink-0 flex items-center justify-center">
                                @if($selectedHerbal->image_url)
                                    <img class="w-full h-full object-cover" src="{{ $selectedHerbal->image_url }}" />
                                @else
                                    <i class="fa-solid fa-seedling text-xl text-emerald-400"></i>
                                @endif
                            </div>
                            <div>
                                <h2 class="text-sm font-black text-gray-900 leading-tight">{{ $selectedHerbal->local_name }}</h2>
                                <p class="text-xs text-gray-500 italic">{{ $selectedHerbal->scientific_name }}</p>
                            </div>
                        </div>
                        <span class="bg-emerald-100 text-emerald-800 text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase tracking-wider">
                            {{ $selectedHerbal->evidence_level === 'Clinical_Trial' ? 'Uji Klinis' : 'Empiris' }}
                        </span>
                    </div>

                    <!-- Tabs Selector -->
                    <div class="flex border-b border-gray-100 bg-gray-50/50 px-6 overflow-x-auto">
                        <button type="button" @click="currentTab = 'botanical'" :class="currentTab === 'botanical' ? 'border-[#1E4D2B] text-[#1E4D2B] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900'" class="px-4 py-3 text-xs border-b-2 font-medium transition whitespace-nowrap">
                            Botani & Morfologi
                        </button>
                        <button type="button" @click="currentTab = 'compounds'" :class="currentTab === 'compounds' ? 'border-[#1E4D2B] text-[#1E4D2B] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900'" class="px-4 py-3 text-xs border-b-2 font-medium transition whitespace-nowrap">
                            Kandungan & Manfaat
                        </button>
                        <button type="button" @click="currentTab = 'symptoms'" :class="currentTab === 'symptoms' ? 'border-[#1E4D2B] text-[#1E4D2B] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900'" class="px-4 py-3 text-xs border-b-2 font-medium transition whitespace-nowrap">
                            Gejala & Terapi
                        </button>
                        <button type="button" @click="currentTab = 'safety'" :class="currentTab === 'safety' ? 'border-[#1E4D2B] text-[#1E4D2B] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900'" class="px-4 py-3 text-xs border-b-2 font-medium transition whitespace-nowrap">
                            Keamanan & Interaksi
                        </button>
                        <button type="button" @click="currentTab = 'gallery'" :class="currentTab === 'gallery' ? 'border-[#1E4D2B] text-[#1E4D2B] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900'" class="px-4 py-3 text-xs border-b-2 font-medium transition whitespace-nowrap">
                            Peta & Galeri
                        </button>
                    </div>

                    <!-- Main Form -->
                    <form action="{{ route('admin.herbal-details.update', $selectedHerbal->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                        @csrf

                        @if(session('success'))
                            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold px-4 py-3 rounded-xl flex items-center gap-2">
                                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        <!-- TAB 1: BOTANI & MORFOLOGI -->
                        <div x-show="currentTab === 'botanical'" class="space-y-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Informasi Botani</h3>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Famili Tumbuhan</label>
                                    <input type="text" name="plant_family" value="{{ $selectedHerbal->plant_family }}" placeholder="Contoh: Zingiberaceae"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Asal Wilayah</label>
                                    <input type="text" name="origin_region" value="{{ $selectedHerbal->origin_region }}" placeholder="Contoh: Asia Tenggara, Jawa"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Zona Budidaya</label>
                                    <input type="text" name="cultivation_zone" value="{{ $selectedHerbal->cultivation_zone }}" placeholder="Contoh: Dataran rendah 0-500 mdpl"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Bagian Tanaman yang Digunakan (pisahkan dengan koma)</label>
                                <input type="text" name="plant_parts" value="{{ is_array($selectedHerbal->plant_parts) ? implode(', ', $selectedHerbal->plant_parts) : $selectedHerbal->plant_parts }}" 
                                    placeholder="Contoh: Rimpang, Daun, Akar"
                                    class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi Morfologi Tanaman</label>
                                <textarea name="morphology_description" rows="4" placeholder="Deskripsikan ciri fisik tanaman: batang, daun, bunga, buah, dll."
                                    class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 resize-none text-gray-800">{{ $selectedHerbal->morphology_description }}</textarea>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi Umum</label>
                                <textarea name="description" rows="3" placeholder="Deskripsi umum tanaman herbal..."
                                    class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 resize-none text-gray-800">{{ $selectedHerbal->description }}</textarea>
                            </div>
                        </div>

                        <!-- TAB 2: KANDUNGAN & MANFAAT -->
                        <div x-show="currentTab === 'compounds'" class="space-y-4">
                            <div class="flex items-center justify-between">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Kandungan Aktif Herbal</h3>
                                <button type="button" onclick="addCompoundRow()" class="text-xs bg-[#1E4D2B] text-white px-3 py-1.5 rounded-lg flex items-center gap-1.5 hover:bg-[#163a20] transition-colors">
                                    <i class="fa-solid fa-plus text-[10px]"></i> Tambah Kandungan
                                </button>
                            </div>

                            <div id="compounds-container" class="space-y-3">
                                @forelse($selectedHerbal->activeCompounds as $compound)
                                    <div class="compound-row grid grid-cols-1 sm:grid-cols-5 gap-3 p-3 bg-gray-50/50 border border-gray-100 rounded-xl">
                                        <div class="sm:col-span-2">
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Nama Kandungan</label>
                                            <input type="text" name="compounds[][name]" value="{{ $compound->compound_name }}"
                                                placeholder="Contoh: Gingerol, Quercetin"
                                                class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30" />
                                        </div>
                                        <div class="sm:col-span-2">
                                            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Efek Farmakologi</label>
                                            <input type="text" name="compounds[][effect]" value="{{ $compound->pharmacological_effect }}"
                                                placeholder="Contoh: Anti-inflamasi, Antioksidan"
                                                class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30" />
                                        </div>
                                        <div class="flex items-end">
                                            <button type="button" onclick="this.closest('.compound-row').remove()"
                                                class="w-full h-9 bg-red-50 text-red-500 hover:bg-red-600 hover:text-white rounded-lg transition-all text-xs font-semibold">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-xs text-gray-400 italic text-center py-4 border border-dashed border-gray-200 rounded-xl">
                                        Belum ada kandungan aktif. Klik "Tambah Kandungan" untuk menambahkan.
                                    </p>
                                @endforelse
                            </div>

                            <div class="border-t border-gray-100 pt-4">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Metode Pengolahan & Dosis</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Metode Pengolahan</label>
                                        <textarea name="preparation_method" rows="4" placeholder="Cara pengolahan tanaman untuk terapi..."
                                            class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 resize-none text-gray-800">{{ $selectedHerbal->preparation_method }}</textarea>
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Panduan Dosis & Frekuensi</label>
                                        <textarea name="dosage_guide" rows="4" placeholder="Takaran pemakaian dan frekuensi yang dianjurkan..."
                                            class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 resize-none text-gray-800">{{ $selectedHerbal->dosage_guide }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Tingkat Bukti Ilmiah</label>
                                <select name="evidence_level" class="w-full sm:w-64 text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800">
                                    <option value="Empirical" {{ $selectedHerbal->evidence_level === 'Empirical' ? 'selected' : '' }}>Empiris (Tradisional)</option>
                                    <option value="Clinical_Trial" {{ $selectedHerbal->evidence_level === 'Clinical_Trial' ? 'selected' : '' }}>Uji Klinis (Teruji Ilmiah)</option>
                                </select>
                            </div>
                        </div>

                        <!-- TAB 3: GEJALA & TERAPI -->
                        <div x-show="currentTab === 'symptoms'" class="space-y-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Relasi Gejala yang Ditangani</h3>
                            <p class="text-xs text-gray-500">Pilih gejala penyakit yang dapat ditangani oleh tanaman herbal ini.</p>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($symptoms as $symptom)
                                    @php
                                        $isAttached = $selectedHerbal->symptoms->contains($symptom->id);
                                        $pivot = $selectedHerbal->symptoms->find($symptom->id)?->pivot;
                                    @endphp
                                    <div class="symptom-item border border-gray-100 rounded-xl p-3 transition-all {{ $isAttached ? 'bg-emerald-50/50 border-emerald-200' : 'bg-gray-50/30 hover:bg-gray-50' }}">
                                        <div class="flex items-center gap-3">
                                            <input type="checkbox" 
                                                name="symptom_ids[]" 
                                                value="{{ $symptom->id }}"
                                                id="sym_{{ $symptom->id }}"
                                                {{ $isAttached ? 'checked' : '' }}
                                                onchange="togglePlantPart({{ $symptom->id }}, this.checked)"
                                                class="w-4 h-4 rounded accent-[#1E4D2B]" />
                                            <label for="sym_{{ $symptom->id }}" class="text-xs font-semibold text-gray-700 cursor-pointer flex-1">
                                                {{ $symptom->symptom_name }}
                                            </label>
                                        </div>
                                        <div id="plantpart_{{ $symptom->id }}" class="{{ $isAttached ? '' : 'hidden' }} mt-2 pl-7">
                                            <label class="block text-[10px] text-gray-400 uppercase font-bold mb-1">Bagian yang Digunakan</label>
                                            <input type="text" 
                                                name="plant_part_used[]"
                                                placeholder="Contoh: Daun, Rimpang"
                                                value="{{ $pivot?->plant_part_used ?? '' }}"
                                                class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30" />
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if($symptoms->isEmpty())
                                <div class="text-center py-8 border border-dashed border-gray-200 rounded-xl text-gray-400">
                                    <i class="fa-solid fa-triangle-exclamation text-2xl mb-2 block"></i>
                                    <p class="text-xs">Belum ada data gejala. Tambahkan data gejala terlebih dahulu.</p>
                                </div>
                            @endif
                        </div>

                        <!-- TAB 4: KEAMANAN & INTERAKSI -->
                        <div x-show="currentTab === 'safety'" class="space-y-4">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Peringatan Keamanan Umum</label>
                                <textarea name="safety_warning" rows="3" placeholder="Contoh: Jangan dikonsumsi berlebih, hindari jika alergi rimpang..."
                                    class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 resize-none text-gray-800">{{ $selectedHerbal->safety_warning }}</textarea>
                            </div>

                            <div class="border-t border-gray-100 pt-4">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider">Interaksi & Kontraindikasi</h3>
                                    <button type="button" onclick="addInteractionRow()" class="text-xs bg-red-600 text-white px-3 py-1.5 rounded-lg flex items-center gap-1.5 hover:bg-red-700 transition-colors">
                                        <i class="fa-solid fa-plus text-[10px]"></i> Tambah Interaksi
                                    </button>
                                </div>

                                <div id="interactions-container" class="space-y-3">
                                    @forelse($selectedHerbal->interactions as $inter)
                                        <div class="interaction-row grid grid-cols-1 sm:grid-cols-5 gap-3 p-3 bg-red-50/30 border border-red-100 rounded-xl">
                                            <div class="sm:col-span-2">
                                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Judul Interaksi</label>
                                                <input type="text" name="interactions[][title]" value="{{ $inter->title }}"
                                                    placeholder="Contoh: Interaksi dengan Warfarin"
                                                    class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-200" />
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Tingkat Risiko</label>
                                                <select name="interactions[][severity]" class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-200">
                                                    <option value="Perhatian" {{ $inter->severity === 'Perhatian' ? 'selected' : '' }}>Perhatian</option>
                                                    <option value="Sedang" {{ $inter->severity === 'Sedang' ? 'selected' : '' }}>Sedang</option>
                                                    <option value="Tinggi" {{ $inter->severity === 'Tinggi' ? 'selected' : '' }}>Tinggi</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Deskripsi</label>
                                                <input type="text" name="interactions[][description]" value="{{ $inter->description }}"
                                                    placeholder="Jelaskan efek interaksi..."
                                                    class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-200" />
                                            </div>
                                            <div class="flex items-end">
                                                <button type="button" onclick="this.closest('.interaction-row').remove()"
                                                    class="w-full h-9 bg-red-50 text-red-500 hover:bg-red-600 hover:text-white rounded-lg transition-all text-xs font-semibold">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-xs text-gray-400 italic text-center py-4 border border-dashed border-gray-200 rounded-xl">
                                            Belum ada data interaksi. Klik "Tambah Interaksi" untuk menambahkan.
                                        </p>
                                    @endforelse
                                </div>
                            </div>
                        </div>

                        <!-- TAB 5: PETA & GALERI -->
                        <div x-show="currentTab === 'gallery'" class="space-y-4">
                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-2">Peta Sebaran Wilayah</label>
                                @if($selectedHerbal->map_image_url)
                                    <div class="mb-3">
                                        <img src="{{ $selectedHerbal->map_image_url }}" class="w-full max-h-56 object-cover rounded-xl border border-gray-200" alt="Peta sebaran herbal" />
                                    </div>
                                @endif
                                <input type="file" name="map_image" accept="image/*"
                                    class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-gray-200 rounded-xl bg-[#F8FAFC]" />
                                <p class="text-[10px] text-gray-400 mt-1">Upload peta sebaran wilayah tumbuh tanaman herbal ini.</p>
                            </div>

                            <!-- Gallery -->
                            <div class="border-t border-gray-100 pt-4">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Galeri Foto</h3>
                                
                                @if($selectedHerbal->gallery->isNotEmpty())
                                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-4">
                                        @foreach($selectedHerbal->gallery as $galItem)
                                            <div class="relative group rounded-xl overflow-hidden border border-gray-100 bg-gray-50">
                                                <img src="{{ $galItem->image_url }}" class="w-full h-28 object-cover" alt="{{ $galItem->caption ?? 'Herbal' }}" />
                                                <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-all flex items-center justify-center">
                                                    <label class="flex items-center gap-1.5 bg-red-600 text-white text-[10px] font-bold px-2 py-1 rounded-lg cursor-pointer">
                                                        <input type="checkbox" name="delete_gallery_ids[]" value="{{ $galItem->id }}" class="hidden" onchange="this.parentElement.textContent = this.checked ? '✓ Hapus' : 'Hapus'">
                                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                                    </label>
                                                </div>
                                                @if($galItem->caption)
                                                    <p class="text-[10px] text-gray-500 p-2 truncate">{{ $galItem->caption }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <div class="space-y-2">
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Upload Foto Baru</label>
                                    <input type="file" name="gallery_files[]" accept="image/*" multiple
                                        class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100 cursor-pointer border border-gray-200 rounded-xl bg-[#F8FAFC]" />
                                    <input type="text" name="gallery_captions[]" placeholder="Caption/Keterangan foto (opsional)"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                            </div>
                        </div>

                        <!-- SAVE BUTTON -->
                        <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.herbal.index') }}" class="px-5 py-2.5 border border-gray-200 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                                Kembali ke Daftar
                            </a>
                            <button type="submit" class="flex-1 py-2.5 bg-[#1E4D2B] hover:bg-[#163a20] text-white text-xs font-semibold rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                                <i class="fa-solid fa-floppy-disk text-xs"></i> Simpan Semua Perubahan
                            </button>
                        </div>
                    </form>
                @endif
            </main>

        </div>
    </div>
</div>

<script>
function addCompoundRow() {
    const container = document.getElementById('compounds-container');
    // Remove empty state p tag if exists
    const emptyP = container.querySelector('p');
    if (emptyP) emptyP.remove();

    const row = document.createElement('div');
    row.className = 'compound-row grid grid-cols-1 sm:grid-cols-5 gap-3 p-3 bg-gray-50/50 border border-gray-100 rounded-xl';
    row.innerHTML = `
        <div class="sm:col-span-2">
            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Nama Kandungan</label>
            <input type="text" name="compounds[][name]" placeholder="Contoh: Gingerol, Quercetin"
                class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30" />
        </div>
        <div class="sm:col-span-2">
            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Efek Farmakologi</label>
            <input type="text" name="compounds[][effect]" placeholder="Contoh: Anti-inflamasi, Antioksidan"
                class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30" />
        </div>
        <div class="flex items-end">
            <button type="button" onclick="this.closest('.compound-row').remove()"
                class="w-full h-9 bg-red-50 text-red-500 hover:bg-red-600 hover:text-white rounded-lg transition-all text-xs font-semibold">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        </div>
    `;
    container.appendChild(row);
}

function addInteractionRow() {
    const container = document.getElementById('interactions-container');
    const emptyP = container.querySelector('p');
    if (emptyP) emptyP.remove();

    const row = document.createElement('div');
    row.className = 'interaction-row grid grid-cols-1 sm:grid-cols-5 gap-3 p-3 bg-red-50/30 border border-red-100 rounded-xl';
    row.innerHTML = `
        <div class="sm:col-span-2">
            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Judul Interaksi</label>
            <input type="text" name="interactions[][title]" placeholder="Contoh: Interaksi dengan Warfarin"
                class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-200" />
        </div>
        <div>
            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Tingkat Risiko</label>
            <select name="interactions[][severity]" class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-200">
                <option value="Perhatian">Perhatian</option>
                <option value="Sedang">Sedang</option>
                <option value="Tinggi">Tinggi</option>
            </select>
        </div>
        <div>
            <label class="block text-[10px] font-bold text-gray-500 uppercase mb-1">Deskripsi</label>
            <input type="text" name="interactions[][description]" placeholder="Jelaskan efek interaksi..."
                class="w-full text-xs bg-white border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-red-200" />
        </div>
        <div class="flex items-end">
            <button type="button" onclick="this.closest('.interaction-row').remove()"
                class="w-full h-9 bg-red-50 text-red-500 hover:bg-red-600 hover:text-white rounded-lg transition-all text-xs font-semibold">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        </div>
    `;
    container.appendChild(row);
}

function togglePlantPart(symId, checked) {
    const div = document.getElementById(`plantpart_${symId}`);
    if (div) div.classList.toggle('hidden', !checked);
}
</script>

@endsection
