@extends('layout.admin')
@section('content')

<div class="flex min-h-screen bg-[#F8FAFC]" x-data="{ currentTab: 'taxonomy' }">
    @include('components.admin.sidebar')
    
    <div class="flex-1 flex flex-col h-screen overflow-y-auto overflow-x-hidden" id="main-scroll-area">
        
        <!-- TOP HEADER -->
        <header id="header" class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between gap-4 sticky top-0 z-10 shadow-sm">
            <div>
                <div class="flex items-center gap-2 text-xs text-gray-400 mb-0.5">
                    <a href="{{ route('admin.fauna.index') }}" class="hover:text-[#1E4D2B]">Fauna Management</a>
                    <i class="fa-solid fa-chevron-right text-[10px]"></i>
                    <span class="text-gray-600 font-medium">Detail & Karakteristik</span>
                </div>
                <h1 class="text-lg font-bold text-[#1E4D2B] leading-tight">Pengelolaan Spesifikasi Detail Fauna</h1>
            </div>
        </header>

        <!-- CONTENT BODY -->
        <div class="flex flex-col lg:flex-row flex-1 p-6 gap-6 items-start">
            
            <!-- LEFT PANEL: FAUNA SELECTOR -->
            <aside class="w-full lg:w-72 bg-white rounded-2xl border border-gray-100 shadow-sm p-4 sticky top-6 self-start flex-shrink-0">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Pilih Spesies Fauna</h2>
                <div class="space-y-1.5 max-h-[calc(100vh-180px)] overflow-y-auto pr-1 custom-scrollbar">
                    @forelse($faunas as $faunaItem)
                        <a href="?fauna_id={{ $faunaItem->id }}" 
                           class="flex items-center gap-3 p-2.5 rounded-xl border transition-all text-left {{ $selectedFauna && $selectedFauna->id === $faunaItem->id ? 'bg-[#1E4D2B]/5 border-[#1E4D2B] text-[#1E4D2B] font-semibold' : 'border-gray-100 hover:bg-gray-50 text-gray-700' }}">
                            <div class="w-8 h-8 rounded-lg overflow-hidden bg-gray-50 flex-shrink-0">
                                @if($faunaItem->image_url)
                                    <img class="w-full h-full object-cover" src="{{ $faunaItem->image_url }}" alt="{{ $faunaItem->local_name }}" />
                                @else
                                    <div class="w-full h-full bg-gray-100 text-gray-400 flex items-center justify-center text-[10px] font-bold">
                                        {{ strtoupper(substr($faunaItem->local_name, 0, 2)) }}
                                    </div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs truncate leading-tight">{{ $faunaItem->local_name }}</p>
                                <p class="text-[10px] text-gray-400 italic truncate">{{ $faunaItem->scientific_name }}</p>
                            </div>
                        </a>
                    @empty
                        <p class="text-xs text-gray-400 italic text-center py-4">Belum ada fauna terdaftar.</p>
                    @endforelse
                </div>
            </aside>

            <!-- RIGHT PANEL: EDIT DETAILS FORM -->
            <main class="flex-1 bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                @if(!$selectedFauna)
                    <div class="flex flex-col items-center justify-center p-12 text-center text-gray-400">
                        <i class="fa-solid fa-circle-info text-5xl text-gray-200 mb-3"></i>
                        <h3 class="font-bold text-gray-700 mb-1">Silakan Pilih Fauna</h3>
                        <p class="text-xs max-w-sm">Pilih salah satu spesies fauna di panel kiri untuk mulai mengelola karakteristik dan spesifikasi detailnya.</p>
                    </div>
                @else
                    <!-- Selected Fauna Banner -->
                    <div class="bg-[#1E4D2B]/5 border-b border-gray-100 px-6 py-4 flex items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl overflow-hidden bg-white border border-gray-200 shadow-sm flex-shrink-0">
                                @if($selectedFauna->image_url)
                                    <img class="w-full h-full object-cover" src="{{ $selectedFauna->image_url }}" />
                                @endif
                            </div>
                            <div>
                                <h2 class="text-sm font-black text-gray-900 leading-tight">{{ $selectedFauna->local_name }}</h2>
                                <p class="text-xs text-gray-500 italic">{{ $selectedFauna->scientific_name }}</p>
                            </div>
                        </div>
                        <span class="bg-[#1E4D2B] text-white text-[10px] font-bold px-2.5 py-1 rounded-lg uppercase tracking-wider">
                            {{ $selectedFauna->taxonomy->class_name ?? 'Fauna' }}
                        </span>
                    </div>

                    <!-- Tabs Selector -->
                    <div class="flex border-b border-gray-100 bg-gray-50/50 px-6 overflow-x-auto">
                        <button type="button" @click="currentTab = 'taxonomy'" :class="currentTab === 'taxonomy' ? 'border-[#1E4D2B] text-[#1E4D2B] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900'" class="px-4 py-3 text-xs border-b-2 font-medium transition whitespace-nowrap">
                            Taksonomi & Profil
                        </button>
                        <button type="button" @click="currentTab = 'physical'" :class="currentTab === 'physical' ? 'border-[#1E4D2B] text-[#1E4D2B] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900'" class="px-4 py-3 text-xs border-b-2 font-medium transition whitespace-nowrap">
                            Fisik & Ekologis
                        </button>
                        <button type="button" @click="currentTab = 'conservation'" :class="currentTab === 'conservation' ? 'border-[#1E4D2B] text-[#1E4D2B] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900'" class="px-4 py-3 text-xs border-b-2 font-medium transition whitespace-nowrap">
                            Konservasi & Ancaman
                        </button>
                        <button type="button" @click="currentTab = 'gallery'" :class="currentTab === 'gallery' ? 'border-[#1E4D2B] text-[#1E4D2B] font-bold' : 'border-transparent text-gray-500 hover:text-gray-900'" class="px-4 py-3 text-xs border-b-2 font-medium transition whitespace-nowrap">
                            Peta & Galeri Foto
                        </button>
                    </div>

                    <!-- Main Form -->
                    <form action="{{ route('admin.fauna-details.update', $selectedFauna->id) }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
                        @csrf
                        
                        @if(session('success'))
                            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold px-4 py-3 rounded-xl flex items-center gap-2">
                                <i class="fa-solid fa-circle-check text-emerald-600 text-base"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        <!-- TAB 1: TAKSONOMI & PROFIL -->
                        <div x-show="currentTab === 'taxonomy'" class="space-y-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Hierarki Taksonomi</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Kingdom</label>
                                    <input type="text" name="kingdom" value="{{ $selectedFauna->taxonomy->kingdom ?? 'Animalia' }}" placeholder="Contoh: Animalia"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Filum</label>
                                    <input type="text" name="phylum" value="{{ $selectedFauna->taxonomy->phylum ?? 'Chordata' }}" placeholder="Contoh: Chordata"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Ordo (Order)</label>
                                    <input type="text" name="order" value="{{ $selectedFauna->taxonomy->order }}" placeholder="Contoh: Artiodactyla"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Famili (Family)</label>
                                    <input type="text" name="family" value="{{ $selectedFauna->taxonomy->family }}" placeholder="Contoh: Bovidae"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                            </div>

                            <hr class="border-gray-100 my-4" />

                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi Profil Taksonomi</label>
                                <textarea name="taxonomy_description" rows="5" placeholder="Tuliskan latar belakang klasifikasi taksonomi secara detail..."
                                    class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800 resize-none">{{ $selectedFauna->taxonomy_description }}</textarea>
                            </div>
                        </div>

                        <!-- TAB 2: FISIK & EKOLOGIS -->
                        <div x-show="currentTab === 'physical'" class="space-y-4">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Karakteristik Fisik</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Ukuran &amp; Berat Tubuh</label>
                                    <textarea name="size_and_weight" rows="2" placeholder="Contoh: Panjang 160–170 cm; tinggi bahu 60–100 cm; berat 150–300 kg"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800 resize-none">{{ $selectedFauna->physicalCharacteristics->size_and_weight ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Ciri Khas &amp; Ciri Fisik Unik</label>
                                    <textarea name="distinctive_features" rows="2" placeholder="Contoh: Tanduk lurus, pendek, dan meruncing ke belakang. Kulit tebal coklat gelap."
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800 resize-none">{{ $selectedFauna->physicalCharacteristics->distinctive_features ?? '' }}</textarea>
                                </div>
                            </div>

                            <hr class="border-gray-100 my-4" />

                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Informasi Ekologis &amp; Reproduksi</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi Habitat Alami</label>
                                    <textarea name="habitat_description" rows="3" placeholder="Deskripsikan habitat spesifik dan tempat tinggal spesies ini..."
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800 resize-none">{{ $selectedFauna->ecologicalInfo->habitat_description ?? '' }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Makanan, Perilaku &amp; Pola Hidup</label>
                                    <textarea name="diet_and_behavior" rows="3" placeholder="Informasi tentang apa yang dikonsumsi, perilaku sosial, dan kebiasaan harian..."
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800 resize-none">{{ $selectedFauna->ecologicalInfo->diet_and_behavior ?? '' }}</textarea>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Harapan Hidup</label>
                                    <input type="text" name="lifespan" value="{{ $selectedFauna->lifespan }}" placeholder="Contoh: ~20 Tahun"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Anak per Kelahiran</label>
                                    <input type="text" name="offspring_count" value="{{ $selectedFauna->offspring_count }}" placeholder="Contoh: 1 Ekor"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Masa Kehamilan</label>
                                    <input type="text" name="gestation_period" value="{{ $selectedFauna->gestation_period }}" placeholder="Contoh: 300 Hari"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Pola Sosial</label>
                                    <input type="text" name="social_pattern" value="{{ $selectedFauna->social_pattern }}" placeholder="Contoh: Soliter / Kelompok"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Kutipan / Quote Pakar</label>
                                <input type="text" name="quote" value="{{ $selectedFauna->ecologicalInfo->quote ?? '' }}" placeholder="Kutipan jurnal atau kalimat menarik dari peneliti spesies..."
                                    class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                            </div>
                        </div>

                        <!-- TAB 3: KONSERVASI & ANCAMAN -->
                        <div x-show="currentTab === 'conservation'" class="space-y-4" x-data="{ 
                            programs: @js($selectedFauna->conservationPrograms->pluck('title_or_description')),
                            threats: @js($selectedFauna->threats)
                        }">
                            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Upaya Perlindungan &amp; Konservasi</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Kode Status IUCN</label>
                                    <input type="text" name="iucn_code" value="{{ $selectedFauna->iucn_code ?: $selectedFauna->iucn_status }}" placeholder="Contoh: EN"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Status IUCN (Teks Panjang)</label>
                                    <input type="text" name="iucn_status" value="{{ $selectedFauna->iucn_status }}" placeholder="Contoh: Endangered (Genting)"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Laju / Tren Populasi</label>
                                    <input type="text" name="population_trend" value="{{ $selectedFauna->population_trend }}" placeholder="Contoh: Menurun drastis setiap dekade"
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Deskripsi IUCN Red List</label>
                                    <textarea name="iucn_description" rows="3" placeholder="Jelaskan mengenai detail ancaman populasi menurut lembaga IUCN..."
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800 resize-none">{{ $selectedFauna->iucn_description }}</textarea>
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Status &amp; Aturan Hukum di Indonesia</label>
                                    <textarea name="legal_status" rows="3" placeholder="Contoh: Dilindungi UU No. 5 Tahun 1990 tentang Konservasi Sumber Daya Alam..."
                                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800 resize-none">{{ $selectedFauna->legal_status }}</textarea>
                                </div>
                            </div>

                            <!-- DYNAMIC PROGRAMS LIST -->
                            <div class="border-t border-gray-100 pt-4">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Program Penangkaran &amp; Riset</label>
                                    <button type="button" @click="programs.push('')" class="text-xs text-[#1E4D2B] font-bold hover:underline">
                                        + Tambah Baris
                                    </button>
                                </div>
                                <div class="space-y-2">
                                    <template x-for="(program, index) in programs" :key="index">
                                        <div class="flex items-center gap-2">
                                            <input type="text" name="programs[]" x-model="programs[index]" placeholder="Contoh: Program monitoring populasi liar di TN Bogani Nani Wartabone..." 
                                                class="flex-1 text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                            <button type="button" @click="programs.splice(index, 1)" class="text-red-500 hover:text-red-700 p-2">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </div>

                            <!-- DYNAMIC THREATS LIST -->
                            <div class="border-t border-gray-100 pt-4">
                                <div class="flex items-center justify-between mb-2">
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider">Ancaman Utama &amp; Faktor Kepunahan</label>
                                    <button type="button" @click="threats.push({icon: 'fa-solid fa-crosshairs', title: '', description: ''})" class="text-xs text-[#1E4D2B] font-bold hover:underline">
                                        + Tambah Ancaman
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    <template x-for="(threat, index) in threats" :key="index">
                                        <div class="p-4 bg-gray-50 border border-gray-100 rounded-xl space-y-3 relative">
                                            <button type="button" @click="threats.splice(index, 1)" class="absolute top-2 right-2 text-red-500 hover:text-red-700 p-2">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Judul Ancaman</label>
                                                    <input type="text" :name="'threats['+index+'][title]'" x-model="threats[index].title" placeholder="Contoh: Perburuan Liar"
                                                        class="w-full text-xs bg-white border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Icon FontAwesome</label>
                                                    <select :name="'threats['+index+'][icon]'" x-model="threats[index].icon"
                                                        class="w-full text-xs bg-white border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800">
                                                        <option value="fa-solid fa-crosshairs">🎯 Perburuan / Bidik</option>
                                                        <option value="fa-solid fa-tree-city">🌳 Degradasi Hutan / Kota</option>
                                                        <option value="fa-solid fa-virus">🦠 Virus / Penyakit</option>
                                                        <option value="fa-solid fa-fire">🔥 Kebakaran Hutan</option>
                                                        <option value="fa-solid fa-triangle-exclamation">⚠️ Peringatan Umum</option>
                                                    </select>
                                                </div>
                                                <div class="sm:col-span-3">
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Deskripsi Ancaman</label>
                                                    <textarea :name="'threats['+index+'][description]'" x-model="threats[index].description" rows="2" placeholder="Uraikan bagaimana faktor ini mengancam spesies tersebut..."
                                                        class="w-full text-xs bg-white border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800 resize-none"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>

                        <!-- TAB 4: PETA & GALERI FOTO -->
                        <div x-show="currentTab === 'gallery'" class="space-y-6">
                            
                            <!-- PETA DISTRIBUSI -->
                            <div class="bg-gray-50/50 p-4 border border-gray-100 rounded-2xl">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Peta Distribusi (Image)</h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 items-center">
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-700 uppercase tracking-wider mb-1">Upload Peta Baru</label>
                                        <input type="file" name="map_image" accept="image/*"
                                            class="w-full text-xs text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-[#1E4D2B]/10 file:text-[#1E4D2B] hover:file:bg-[#1E4D2B]/20 cursor-pointer border border-gray-200 rounded-xl bg-white" />
                                    </div>
                                    <div class="h-32 border border-gray-200 rounded-xl bg-gray-100 overflow-hidden relative flex items-center justify-center">
                                        @if($selectedFauna->map_image_url)
                                            <img src="{{ $selectedFauna->map_image_url }}" class="w-full h-full object-cover" />
                                        @else
                                            <span class="text-xs text-gray-400 font-medium">Belum ada peta diupload</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- GALERI FOTO TAMBAHAN -->
                            <div class="border-t border-gray-100 pt-4">
                                <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Galeri Foto Pendukung (Tambahan)</h3>
                                
                                <!-- Existing Gallery list -->
                                @if($selectedFauna->gallery->count() > 0)
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-4">
                                        @foreach($selectedFauna->gallery as $item)
                                            <div class="bg-white border border-gray-200 rounded-xl overflow-hidden relative shadow-sm group">
                                                <div class="aspect-square bg-gray-100 overflow-hidden">
                                                    <img src="{{ $item->image_url }}" class="w-full h-full object-cover" />
                                                </div>
                                                <div class="p-2 border-t border-gray-100">
                                                    <p class="text-[10px] text-gray-600 truncate font-semibold" title="{{ $item->caption }}">{{ $item->caption ?: '(Tanpa Caption)' }}</p>
                                                    <label class="inline-flex items-center gap-1 mt-1 text-[10px] text-red-500 cursor-pointer font-bold">
                                                        <input type="checkbox" name="delete_gallery_ids[]" value="{{ $item->id }}" class="rounded text-red-500 focus:ring-red-500" />
                                                        <span>Hapus</span>
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                <!-- Add New Gallery Photos -->
                                <div class="bg-[#1E4D2B]/5 border border-[#1E4D2B]/10 p-4 rounded-xl space-y-3" x-data="{ items: [] }">
                                    <div class="flex items-center justify-between">
                                        <p class="text-xs font-bold text-[#1E4D2B]">Tambah Foto Galeri Baru</p>
                                        <button type="button" @click="items.push({caption: ''})" class="text-xs text-[#1E4D2B] font-bold hover:underline">
                                            + Tambah Upload Foto
                                        </button>
                                    </div>
                                    <div class="space-y-3">
                                        <template x-for="(item, idx) in items" :key="idx">
                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 p-3 bg-white border border-gray-100 rounded-xl relative">
                                                <button type="button" @click="items.splice(idx, 1)" class="absolute top-2 right-2 text-red-500 hover:text-red-700 p-2">
                                                    <i class="fa-solid fa-xmark"></i>
                                                </button>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Pilih Gambar</label>
                                                    <input type="file" name="gallery_files[]" accept="image/*" required
                                                        class="w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-[11px] file:font-semibold file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200 border border-gray-200 rounded-xl" />
                                                </div>
                                                <div>
                                                    <label class="block text-[10px] font-bold text-gray-500 uppercase tracking-wider mb-1">Caption Foto</label>
                                                    <input type="text" name="gallery_captions[]" x-model="items[idx].caption" placeholder="Contoh: Anoa di tepi hutan lindung"
                                                        class="w-full text-xs bg-white border border-gray-200 rounded-xl px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-800" />
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Form Submission -->
                        <div class="flex items-center gap-3 pt-6 border-t border-gray-100">
                            <button type="submit" class="flex-1 py-3 bg-[#1E4D2B] hover:bg-[#163a20] text-white text-xs font-semibold rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2 cursor-pointer">
                                <i class="fa-solid fa-cloud-arrow-up text-xs"></i> Simpan Semua Detail &amp; Karakteristik
                            </button>
                        </div>
                    </form>
                @endif
            </main>
            
        </div>
    </div>
</div>

@endsection

