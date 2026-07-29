@extends('layout.base')

@section('content')
@include('components.header')

<div class="min-h-screen bg-gradient-to-br from-green-50 via-emerald-50/40 to-amber-50/50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 relative overflow-hidden pt-24">
    
    <!-- Decorative background elements -->
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#2E7D32]/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#D97706]/10 rounded-full blur-3xl pointer-events-none"></div>

    <div class="sm:mx-auto sm:w-full sm:max-w-md z-10">
        <!-- Logo & Header -->
        <div class="text-center">
            <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 group mb-4">
                <div class="w-12 h-12 rounded-2xl bg-[#2E7D32] flex items-center justify-center shadow-lg group-hover:scale-105 transition-transform duration-300">
                    <i class="fa-solid fa-leaf text-white text-xl"></i>
                </div>
                <span class="font-extrabold text-2xl text-[#2E7D32] tracking-tight">
                    Nusantara <span class="text-[#D97706]">BioHub</span>
                </span>
            </a>
            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Atur Kata Sandi Baru</h2>
            <p class="mt-2 text-sm text-gray-600">
                Masukkan kode yang dikirimkan ke email Anda beserta kata sandi baru
            </p>
        </div>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md z-10 px-4 sm:px-0">
        <div class="bg-white/90 backdrop-blur-md py-8 px-6 shadow-xl shadow-green-900/5 sm:rounded-2xl border border-green-100/80 sm:px-10 relative overflow-hidden">
            <div class="h-1.5 bg-gradient-to-r from-[#2E7D32] via-[#4CAF50] to-[#D97706] absolute top-0 left-0 right-0"></div>

            <!-- Info Banner (muncul setelah redirect dari forgot-password) -->
            @if ($infoMessage ?? false)
                <div class="mb-5 p-4 rounded-xl bg-blue-50 border border-blue-200 text-blue-800 text-sm flex items-start gap-3 shadow-sm">
                    <i class="fa-solid fa-paper-plane text-blue-500 text-base mt-0.5 flex-shrink-0"></i>
                    <div>
                        <p class="font-semibold mb-0.5">Email Terkirim!</p>
                        <p class="leading-snug text-xs text-blue-700">{{ $infoMessage }}</p>
                    </div>
                </div>
            @endif

            <!-- Error message -->
            @if ($errors->has('email'))
                <div class="mb-5 p-4 rounded-xl bg-red-50 border border-red-200 text-red-800 text-sm flex items-start gap-3 shadow-sm">
                    <i class="fa-solid fa-circle-exclamation text-red-500 text-base mt-0.5 flex-shrink-0"></i>
                    <div>
                        <p class="font-semibold">Gagal Reset Password</p>
                        <p class="text-xs mt-0.5">{{ $errors->first('email') }}</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Email (pre-filled, editable jika perlu) -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">
                        Alamat Email
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-envelope text-sm"></i>
                        </div>
                        <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}" required
                            placeholder="nama@email.com"
                            class="block w-full pl-10 pr-4 py-2.5 text-gray-900 bg-gray-100/80 border border-gray-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20 focus:border-[#2E7D32]">
                    </div>
                </div>

                <!-- Token / Kode Reset -->
                <div>
                    <label for="token" class="block text-sm font-semibold text-gray-700 mb-1">
                        Kode Reset Password
                        <span class="text-[10px] font-normal text-gray-500 ml-1">(dari email yang dikirimkan)</span>
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-fingerprint text-sm"></i>
                        </div>
                        <input type="text" name="token" id="token" value="{{ $token ?? '' }}"
                            required
                            placeholder="Tempel kode token dari email..."
                            autocomplete="off"
                            class="block w-full pl-10 pr-4 py-2.5 font-mono text-xs text-gray-800 bg-gray-50/60 border @error('token') border-red-400 bg-red-50/30 @else border-gray-200 focus:border-[#2E7D32] focus:bg-white @enderror rounded-xl transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20 placeholder:font-sans placeholder:text-gray-400">
                    </div>
                    @error('token')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <i class="fa-solid fa-circle-xmark"></i> {{ $message }}
                        </p>
                    @enderror
                    <!-- Petunjuk cara mendapatkan kode token -->
                    <p class="mt-2 text-[11px] text-gray-500 leading-snug flex items-start gap-1.5">
                        <i class="fa-solid fa-circle-info text-[#2E7D32] mt-0.5 flex-shrink-0"></i>
                        <span>Buka email Anda → cari pesan dari <strong>Nusantara BioHub</strong> → klik tautan reset password, lalu salin token/kode dari URL yang tertera.</span>
                    </p>
                </div>

                <!-- Password Input -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-1">
                        Kata Sandi Baru
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-lock text-sm"></i>
                        </div>
                        <input type="password" name="password" id="password" required autofocus
                            placeholder="Minimal 8 karakter"
                            class="block w-full pl-10 pr-10 py-2.5 text-gray-900 bg-gray-50/50 border @error('password') border-red-400 bg-red-50/30 @else border-gray-200 focus:border-[#2E7D32] focus:bg-white @enderror rounded-xl text-sm transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20">
                        <button type="button" onclick="togglePwVisibility('password','iconPw1')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i id="iconPw1" class="fa-solid fa-eye text-sm"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1.5 text-xs text-red-600 flex items-center gap-1">
                            <i class="fa-solid fa-circle-xmark"></i> {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Confirmation Input -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-1">
                        Konfirmasi Kata Sandi Baru
                    </label>
                    <div class="relative rounded-xl shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                            <i class="fa-solid fa-shield-halved text-sm"></i>
                        </div>
                        <input type="password" name="password_confirmation" id="password_confirmation" required
                            placeholder="Ulangi kata sandi baru"
                            class="block w-full pl-10 pr-10 py-2.5 text-gray-900 bg-gray-50/50 border border-gray-200 focus:border-[#2E7D32] focus:bg-white rounded-xl text-sm transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20">
                        <button type="button" onclick="togglePwVisibility('password_confirmation','iconPw2')" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                            <i id="iconPw2" class="fa-solid fa-eye text-sm"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-[#2E7D32] hover:bg-[#1B5E20] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#2E7D32] transition-all duration-200 active:scale-[0.99]">
                        <span>Simpan Kata Sandi Baru</span>
                        <i class="fa-solid fa-key text-xs"></i>
                    </button>
                </div>
            </form>

            <div class="mt-5 pt-4 border-t border-gray-100 text-center text-xs text-gray-500">
                Ingat kata sandi Anda?
                <a href="{{ route('login') }}" class="font-bold text-[#2E7D32] hover:underline ml-1">Kembali ke Login</a>
            </div>
        </div>

        <!-- Back to Homepage -->
        <div class="text-center mt-6">
            <a href="{{ route('homepage') }}" class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-[#2E7D32] transition-colors">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Kembali ke Beranda</span>
            </a>
        </div>
    </div>
</div>

<script>
    function togglePwVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (input && icon) {
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    }
</script>
@endsection