@extends('layout.admin')
@section('content')

    <div class="flex min-h-screen bg-[#F8FAFC]">
        @include('components.admin.sidebar')
        <div class="flex-1 flex flex-col min-h-screen">

            {{-- HEADER HALAMAN PENGGUNA --}}
            <header
                class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between gap-4 sticky top-0 z-10 shadow-sm">
                <div>
                    <h1 class="text-lg font-bold text-[#1E4D2B] leading-tight">User & Role Access</h1>
                    <p class="text-xs text-gray-400 mt-0.5">Kelola akun pengguna dan hak akses sistem</p>
                </div>
                <div class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 bg-[#F8FAFC] border border-gray-200 rounded-xl flex items-center justify-center hover:bg-gray-100 transition-colors cursor-pointer">
                        <i class="fa-solid fa-bell text-gray-500 text-sm"></i>
                    </div>
                    <button onclick="openAddUserModal()"
                        class="flex items-center gap-2 bg-[#1E4D2B] hover:bg-[#163a20] text-white text-sm font-semibold px-4 py-2 rounded-xl transition-colors shadow-sm cursor-pointer">
                        <i class="fa-solid fa-user-plus text-xs"></i> Add User
                    </button>
                </div>
            </header>

            {{-- BAGIAN KONTEN UTAMA --}}
            <main class="flex-1 px-6 py-6 space-y-6" id="users-page-content">

                @if(session('success'))
                    <div
                        class="bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs px-4 py-3 rounded-xl flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-emerald-600"></i>
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div
                        class="bg-red-50 border border-red-200 text-red-700 text-xs px-4 py-3 rounded-xl flex items-center gap-2">
                        <i class="fa-solid fa-circle-exclamation text-red-600"></i>
                        {{ session('error') }}
                    </div>
                @endif

                {{-- BAGIAN SKELETON (Animasi Loading) --}}
                <div id="skeleton-wrapper">

                    {{-- Animasi Loading untuk Kartu Statistik --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                        @for($i = 0; $i < 3; $i++)
                            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                                <div class="skeleton w-12 h-12 rounded-xl flex-shrink-0"></div>
                                <div class="flex-1 space-y-2">
                                    <div class="skeleton h-3 w-20 rounded"></div>
                                    <div class="skeleton h-6 w-12 rounded"></div>
                                </div>
                            </div>
                        @endfor
                    </div>

                    {{-- Animasi Loading untuk Bar Pencarian & Filter --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex gap-4 mb-6">
                        <div class="skeleton flex-1 h-9 rounded-xl"></div>
                        <div class="skeleton w-40 h-9 rounded-xl"></div>
                        <div class="skeleton w-20 h-9 rounded-xl"></div>
                    </div>

                    {{-- Animasi Loading Tabel Pengguna --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        {{-- Header Tabel Skeleton --}}
                        <div class="bg-[#F8FAFC] border-b border-gray-100 px-6 py-4 flex gap-6">
                            <div class="skeleton h-3 w-48 rounded"></div>
                            <div class="skeleton h-3 w-32 rounded"></div>
                            <div class="skeleton h-3 w-20 rounded ml-auto"></div>
                            <div class="skeleton h-3 w-20 rounded"></div>
                            <div class="skeleton h-3 w-16 rounded"></div>
                        </div>
                        {{-- Baris Data Skeleton --}}
                        @for($i = 0; $i < 8; $i++)
                            <div class="px-6 py-4 border-b border-gray-50 flex items-center gap-4">
                                {{-- Avatar Pengguna --}}
                                <div class="skeleton w-10 h-10 rounded-full flex-shrink-0"></div>
                                {{-- Nama dan Email --}}
                                <div class="flex-1 space-y-2">
                                    <div class="skeleton h-3 rounded" style="width: {{ [120, 160, 140, 180, 130][$i % 5] }}px">
                                    </div>
                                    <div class="skeleton h-2.5 rounded"
                                        style="width: {{ [180, 210, 160, 230, 170][$i % 5] }}px">
                                    </div>
                                </div>
                                {{-- Hak Akses (Role) --}}
                                <div class="skeleton h-5 w-16 rounded-full ml-auto"></div>
                                {{-- Status Verifikasi Email --}}
                                <div class="skeleton h-5 w-20 rounded-full"></div>
                                {{-- Tanggal Bergabung --}}
                                <div class="skeleton h-3 w-24 rounded"></div>
                                {{-- Tombol Aksi --}}
                                <div class="flex gap-2">
                                    <div class="skeleton w-8 h-8 rounded-lg"></div>
                                    <div class="skeleton w-8 h-8 rounded-lg"></div>
                                </div>
                            </div>
                        @endfor
                        {{-- Bagian Pagination Skeleton --}}
                        <div class="px-6 py-4 bg-[#F8FAFC] border-t border-gray-100 flex justify-between">
                            <div class="skeleton h-3 w-32 rounded"></div>
                            <div class="skeleton h-3 w-24 rounded"></div>
                        </div>
                    </div>

                </div><!-- /skeleton-wrapper -->


                {{-- KONTEN ASLI (Disembunyikan saat Loading) --}}
                <div id="real-content" class="hidden space-y-6">

                    {{-- KARTU STATISTIK RINGKASAN PENGGUNA --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-[#1E4D2B]/10 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-users text-[#1E4D2B] text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Total Pengguna</p>
                                <p class="text-2xl font-black text-gray-900 mt-0.5">{{ $totalUsers }}</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-user-shield text-amber-600 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Administrator</p>
                                <p class="text-2xl font-black text-gray-900 mt-0.5">{{ $totalAdmins }}</p>
                            </div>
                        </div>
                        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 flex items-center gap-4">
                            <div class="w-12 h-12 bg-blue-50 rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class="fa-solid fa-user text-blue-500 text-lg"></i>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 font-medium uppercase tracking-wider">Member Biasa</p>
                                <p class="text-2xl font-black text-gray-900 mt-0.5">{{ $totalMember }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- FITUR PENCARIAN & FILTER --}}
                    <section class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                        <form method="GET" action="{{ route('admin.users.index') }}"
                            class="flex flex-wrap items-center gap-4">
                            <div class="relative flex-1 min-w-[220px]">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs leading-[0]"></i>
                                </div>

                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari nama atau email pengguna..."
                                    class="w-full pl-9 pr-4 py-2 text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 focus:border-[#1E4D2B] transition-all" />
                            </div>
                            <div class="min-w-[160px]">
                                <select name="role"
                                    class="w-full text-xs border border-gray-200 rounded-xl px-3 py-2 bg-[#F8FAFC] focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 text-gray-600 font-medium">
                                    <option value="">Role (All)</option>
                                    <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Administrator
                                    </option>
                                    <option value="user" {{ request('role') === 'user' ? 'selected' : '' }}>Member</option>
                                </select>
                            </div>
                            <button type="submit"
                                class="text-xs font-semibold bg-[#1E4D2B] text-white px-4 py-2 rounded-xl hover:bg-[#163a20] transition-colors">Cari</button>
                            <a href="{{ route('admin.users.index') }}"
                                class="text-xs font-semibold text-gray-500 hover:text-[#1E4D2B] px-2 transition-colors">Reset</a>
                        </form>
                    </section>

                    {{-- TABEL DATA PENGGUNA --}}
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead>
                                    <tr
                                        class="bg-[#F8FAFC] border-b border-gray-100 text-[11px] font-bold text-gray-500 uppercase tracking-wider">
                                        <th class="px-6 py-4">Pengguna</th>
                                        <th class="px-4 py-4">Email</th>
                                        <th class="px-4 py-4 text-center">Role</th>
                                        <th class="px-4 py-4 text-center">Status Email</th>
                                        <th class="px-4 py-4">Bergabung</th>
                                        <th class="px-6 py-4 text-right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50 text-sm">
                                    @forelse($users as $user)
                                        <tr class="hover:bg-gray-50/50 transition-colors group">
                                            <td class="px-6 py-4">
                                                <div class="flex items-center gap-3">
                                                    <!-- Avatar generated from initials -->
                                                    <div
                                                        class="w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-sm
                                                                    {{ $user->role === 'admin' ? 'bg-amber-100 text-amber-700' : 'bg-blue-100 text-blue-700' }}">
                                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <p class="text-xs font-bold text-gray-900">{{ $user->name }}</p>
                                                        @if($user->id === auth()->id())
                                                            <span class="text-[10px] text-emerald-600 font-semibold">(Anda)</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="px-4 py-4 text-xs text-gray-600">
                                                {{ $user->email }}
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                @if($user->role === 'admin')
                                                    <span
                                                        class="inline-flex items-center gap-1 bg-amber-100 text-amber-700 font-bold text-[10px] px-2.5 py-1 rounded-full">
                                                        <i class="fa-solid fa-shield-halved text-[9px]"></i> Admin
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center gap-1 bg-blue-100 text-blue-700 font-bold text-[10px] px-2.5 py-1 rounded-full">
                                                        <i class="fa-solid fa-user text-[9px]"></i> Member
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 text-center">
                                                @if($user->email_verified_at)
                                                    <span
                                                        class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 font-bold text-[10px] px-2.5 py-1 rounded-full">
                                                        <i class="fa-solid fa-circle-check text-[9px]"></i> Terverifikasi
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center gap-1 bg-gray-100 text-gray-500 font-bold text-[10px] px-2.5 py-1 rounded-full">
                                                        <i class="fa-solid fa-clock text-[9px]"></i> Belum
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-4 text-xs text-gray-400">
                                                {{ $user->created_at->format('d M Y') }}
                                            </td>
                                            <td class="px-6 py-4 text-right">
                                                <div class="flex items-center justify-end gap-2">
                                                    <button
                                                        onclick="openEditUserModal({{ json_encode(['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role' => $user->role]) }})"
                                                        title="Edit"
                                                        class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-amber-600 hover:text-white transition-all flex items-center justify-center">
                                                        <i class="fa-solid fa-pen text-xs"></i>
                                                    </button>
                                                    @if($user->id !== auth()->id())
                                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                                                            onsubmit="return confirm('Yakin ingin menghapus pengguna {{ $user->name }}?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" title="Delete"
                                                                class="w-8 h-8 rounded-lg bg-red-50 text-red-500 hover:bg-red-600 hover:text-white transition-all flex items-center justify-center">
                                                                <i class="fa-solid fa-trash-can text-xs"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <div class="w-8 h-8 rounded-lg bg-gray-50 text-gray-300 flex items-center justify-center cursor-not-allowed"
                                                            title="Tidak dapat menghapus akun sendiri">
                                                            <i class="fa-solid fa-lock text-xs"></i>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                                                <i class="fa-solid fa-users-slash text-4xl text-gray-200 mb-3 block"></i>
                                                <p class="text-sm font-medium">Tidak ada pengguna ditemukan</p>
                                                <p class="text-xs mt-1">Coba ubah filter atau tambah pengguna baru</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Footer -->
                        <div class="px-6 py-4 bg-[#F8FAFC] border-t border-gray-100 flex items-center justify-between">
                            <p class="text-xs text-gray-500 font-medium">
                                Menampilkan {{ $users->firstItem() ?? 0 }}–{{ $users->lastItem() ?? 0 }} dari
                                {{ $users->total() }} pengguna
                            </p>
                            <div class="text-xs">
                                {{ $users->links() }}
                            </div>
                        </div>
                    </div>

                </div><!-- /real-content -->

            </main>
        </div>
    </div>


    <!-- ==================== MODAL ADD USER ==================== -->
    <div id="add-user-modal"
        class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 transform scale-95 transition-all duration-300"
            id="add-user-container">

            <div class="bg-[#1E4D2B] px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-[#D97706] rounded-xl flex items-center justify-center text-white">
                        <i class="fa-solid fa-user-plus text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white leading-tight">Tambah Pengguna Baru</h3>
                        <p class="text-xs text-white/70">Buat akun dan atur hak akses pengguna</p>
                    </div>
                </div>
                <button onclick="closeAddUserModal()" type="button"
                    class="text-white/60 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form action="{{ route('admin.users.store') }}" method="POST" class="p-6 space-y-4">
                @csrf

                @if($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 text-xs px-4 py-3 rounded-xl space-y-1">
                        @foreach($errors->all() as $error)
                            <p>• {{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Lengkap <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name') }}" required placeholder="Contoh: Budi Santoso"
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 transition-all text-gray-800" />
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Alamat Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh@email.com"
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 transition-all text-gray-800" />
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Role / Hak Akses
                        <span class="text-red-500">*</span></label>
                    <select name="role" required
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 transition-all text-gray-800">
                        <option value="user">Member (Pengguna Biasa)</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Password <span
                            class="text-red-500">*</span></label>
                    <div class="relative">
                        <input type="password" name="password" id="add_password" required placeholder="Min. 8 karakter"
                            class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-[#1E4D2B]/30 transition-all text-gray-800 pr-10" />
                        <button type="button" onclick="togglePasswordVisibility('add_password', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition-colors">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
                    <button type="button" onclick="closeAddUserModal()"
                        class="flex-1 py-2.5 border border-gray-200 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-2.5 bg-[#1E4D2B] hover:bg-[#163a20] text-white text-xs font-semibold rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-user-plus text-xs"></i> Tambah Pengguna
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ==================== MODAL EDIT USER ==================== -->
    <div id="edit-user-modal"
        class="fixed inset-0 bg-black/60 z-50 flex items-center justify-center p-4 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden border border-gray-100 transform scale-95 transition-all duration-300"
            id="edit-user-container">

            <div class="bg-amber-600 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-white text-amber-600 rounded-xl flex items-center justify-center">
                        <i class="fa-solid fa-pen text-base"></i>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white leading-tight">Edit Pengguna</h3>
                        <p class="text-xs text-white/70">Perbarui data & hak akses pengguna</p>
                    </div>
                </div>
                <button onclick="closeEditUserModal()" type="button"
                    class="text-white/60 hover:text-white transition-colors p-1.5 rounded-lg hover:bg-white/10">
                    <i class="fa-solid fa-xmark text-lg"></i>
                </button>
            </div>

            <form id="edit-user-form" action="" method="POST" class="p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Nama Lengkap <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="name" id="edit_u_name" required
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-all text-gray-800" />
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Alamat Email <span
                            class="text-red-500">*</span></label>
                    <input type="email" name="email" id="edit_u_email" required
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-all text-gray-800" />
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Role / Hak Akses
                        <span class="text-red-500">*</span></label>
                    <select name="role" id="edit_u_role" required
                        class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-all text-gray-800">
                        <option value="user">Member (Pengguna Biasa)</option>
                        <option value="admin">Administrator</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">Password Baru <span
                            class="text-gray-400 font-normal">(Kosongkan jika tidak diubah)</span></label>
                    <div class="relative">
                        <input type="password" name="password" id="edit_password" placeholder="Min. 8 karakter"
                            class="w-full text-xs bg-[#F8FAFC] border border-gray-200 rounded-xl px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-amber-500/30 transition-all text-gray-800 pr-10" />
                        <button type="button" onclick="togglePasswordVisibility('edit_password', this)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-700 transition-colors">
                            <i class="fa-solid fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center gap-3 pt-3 border-t border-gray-100">
                    <button type="button" onclick="closeEditUserModal()"
                        class="flex-1 py-2.5 border border-gray-200 text-gray-600 text-xs font-semibold rounded-xl hover:bg-gray-50 transition-colors">
                        Batal
                    </button>
                    <button type="submit"
                        class="flex-1 py-2.5 bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold rounded-xl transition-colors shadow-sm flex items-center justify-center gap-2">
                        <i class="fa-solid fa-check text-xs"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>


    <script>
        // ---- Skeleton → Real Content transition ----
        document.addEventListener('DOMContentLoaded', function () {
            const skeleton = document.getElementById('skeleton-wrapper');
            const realContent = document.getElementById('real-content');

            // Simulate async load: skeleton shows for 800ms then fades out
            setTimeout(function () {
                // Fade out skeleton
                skeleton.style.transition = 'opacity 0.4s ease';
                skeleton.style.opacity = '0';

                setTimeout(function () {
                    skeleton.classList.add('hidden');

                    // Fade in real content
                    realContent.classList.remove('hidden');
                    realContent.style.opacity = '0';
                    realContent.style.transition = 'opacity 0.4s ease';
                    requestAnimationFrame(function () {
                        realContent.style.opacity = '1';
                    });
                }, 400);
            }, 800);
        });

        // ---- Modal: Add User ----
        function openAddUserModal() {
            document.getElementById('add-user-modal').classList.remove('opacity-0', 'pointer-events-none');
            document.getElementById('add-user-container').classList.replace('scale-95', 'scale-100');
        }
        function closeAddUserModal() {
            document.getElementById('add-user-modal').classList.add('opacity-0', 'pointer-events-none');
            document.getElementById('add-user-container').classList.replace('scale-100', 'scale-95');
        }

        // ---- Modal: Edit User ----
        function openEditUserModal(user) {
            document.getElementById('edit-user-form').action = `{{ url('admin/users') }}/${user.id}`;
            document.getElementById('edit_u_name').value = user.name;
            document.getElementById('edit_u_email').value = user.email;
            document.getElementById('edit_u_role').value = user.role;
            document.getElementById('edit_password').value = '';

            document.getElementById('edit-user-modal').classList.remove('opacity-0', 'pointer-events-none');
            document.getElementById('edit-user-container').classList.replace('scale-95', 'scale-100');
        }
        function closeEditUserModal() {
            document.getElementById('edit-user-modal').classList.add('opacity-0', 'pointer-events-none');
            document.getElementById('edit-user-container').classList.replace('scale-100', 'scale-95');
        }

        // ---- Toggle Password Visibility ----
        function togglePasswordVisibility(inputId, btn) {
            const input = document.getElementById(inputId);
            const icon = btn.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }

        // Close modals on backdrop click
        ['add-user-modal', 'edit-user-modal'].forEach(id => {
            document.getElementById(id).addEventListener('click', function (e) {
                if (e.target === this) {
                    id === 'add-user-modal' ? closeAddUserModal() : closeEditUserModal();
                }
            });
        });
    </script>

@endsection