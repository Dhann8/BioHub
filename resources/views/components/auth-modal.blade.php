    <!-- Auth Modal Overlay -->
<div id="authModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 sm:p-6 overflow-y-auto bg-gray-900/60 backdrop-blur-sm transition-opacity duration-300" onclick="if(event.target === this) closeAuthModal()">
    
    <!-- Modal Box -->
    <div class="relative w-full max-w-md bg-white/95 backdrop-blur-md rounded-2xl shadow-2xl border border-green-100 overflow-hidden transform transition-all duration-300 scale-95 opacity-0 my-auto" id="authModalContainer" onclick="event.stopPropagation()">
        
        <!-- Close Button -->
        <button type="button" onclick="closeAuthModal()" class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full text-gray-400 hover:text-gray-700 hover:bg-gray-100 transition duration-200 z-20">
            <i class="fa-solid fa-xmark text-lg"></i>
        </button>

        <!-- Decorative Top Line -->
        <div class="h-1.5 bg-gradient-to-r from-[#2E7D32] via-[#4CAF50] to-[#D97706]"></div>

        <div class="p-6 sm:p-8">
            <!-- Header Logo -->
            <div class="text-center mb-6">
                <div class="w-12 h-12 rounded-2xl bg-[#2E7D32] flex items-center justify-center shadow-md mx-auto mb-3">
                    <i class="fa-solid fa-leaf text-white text-xl"></i>
                </div>
                <h3 id="authModalTitle" class="text-2xl font-extrabold text-gray-900 tracking-tight">Masuk ke Nusantara BioHub</h3>
                <p id="authModalSubtitle" class="text-xs text-gray-500 mt-1">Akses portal informasi biodiversitas dan herbal Nusantara</p>
            </div>

            <!-- Flash Success Message -->
            @if (session('success'))
                <div class="mb-4 bg-emerald-50 border border-emerald-200 text-emerald-800 px-3.5 py-2.5 rounded-xl flex items-start gap-2.5 text-xs shadow-sm" role="alert">
                    <i class="fa-solid fa-circle-check text-emerald-600 text-base mt-0.5"></i>
                    <div>
                        <span class="font-semibold">Berhasil!</span>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            <!-- Info message (e.g. after sending reset email) -->
            @if (session('info'))
                <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-800 px-3.5 py-2.5 rounded-xl flex items-start gap-2.5 text-xs shadow-sm" role="alert">
                    <i class="fa-solid fa-paper-plane text-blue-500 text-base mt-0.5 flex-shrink-0"></i>
                    <div>
                        <span class="font-semibold">Email Terkirim!</span>
                        <p>{{ session('info') }}</p>
                    </div>
                </div>
            @endif

            <!-- ---------------------------------------------------- -->
            <!-- TAB 1: LOGIN FORM -->
            <!-- ---------------------------------------------------- -->
            <div id="loginTabPanel" class="auth-panel space-y-4">
                <form action="{{ route('login.post') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="auth_tab" value="login">

                    <!-- Email Input -->
                    <div>
                        <label for="modal_login_email" class="block text-xs font-semibold text-gray-700 mb-1">
                            Alamat Email
                        </label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-envelope text-xs"></i>
                            </div>
                            <input type="email" name="email" id="modal_login_email" value="{{ old('auth_tab') === 'login' ? old('email') : '' }}" required
                                placeholder="nama@email.com"
                                class="block w-full pl-9 pr-3 py-2.5 text-xs text-gray-900 bg-gray-50/60 border @if($errors->has('email') && (old('auth_tab') === 'login' || !old('auth_tab'))) border-red-400 bg-red-50/30 @else border-gray-200 focus:border-[#2E7D32] focus:bg-white @endif rounded-xl transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20">
                        </div>
                        @if ($errors->has('email') && (old('auth_tab') === 'login' || !old('auth_tab')))
                            <p class="mt-1 text-[11px] text-red-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first('email') }}
                            </p>
                        @endif
                    </div>

                    <!-- Password Input -->
                    <div>
                        <div class="flex items-center justify-between mb-1">
                            <label for="modal_login_password" class="block text-xs font-semibold text-gray-700">
                                Kata Sandi
                            </label>
                            <button type="button" onclick="switchAuthTab('forgot')" class="text-xs font-semibold text-[#2E7D32] hover:text-[#1B5E20] hover:underline focus:outline-none">
                                Lupa kata sandi?
                            </button>
                        </div>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                            <input type="password" name="password" id="modal_login_password" required
                                placeholder="••••••••"
                                class="block w-full pl-9 pr-9 py-2.5 text-xs text-gray-900 bg-gray-50/60 border @if($errors->has('password') && (old('auth_tab') === 'login' || !old('auth_tab'))) border-red-400 bg-red-50/30 @else border-gray-200 focus:border-[#2E7D32] focus:bg-white @endif rounded-xl transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20">
                            <button type="button" onclick="toggleModalPasswordVisibility('modal_login_password', 'toggleModalLoginIcon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i id="toggleModalLoginIcon" class="fa-solid fa-eye text-xs"></i>
                            </button>
                        </div>
                        @if ($errors->has('password') && (old('auth_tab') === 'login' || !old('auth_tab')))
                            <p class="mt-1 text-[11px] text-red-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first('password') }}
                            </p>
                        @endif
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 text-xs text-gray-600 cursor-pointer select-none">
                            <input type="checkbox" name="remember" class="h-3.5 w-3.5 text-[#2E7D32] focus:ring-[#2E7D32] border-gray-300 rounded">
                            <span>Ingat saya di perangkat ini</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-2.5 px-4 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 active:scale-[0.99]">
                        <span>Masuk Sekarang</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </button>
                </form>

                <div class="pt-4 border-t border-gray-100 text-center text-xs text-gray-500">
                    Belum memiliki akun? 
                    <button type="button" onclick="switchAuthTab('register')" class="font-bold text-[#2E7D32] hover:underline focus:outline-none">Daftar Gratis</button>
                </div>
            </div>

            <!-- ---------------------------------------------------- -->
            <!-- TAB 2: REGISTER FORM -->
            <!-- ---------------------------------------------------- -->
            <div id="registerTabPanel" class="auth-panel hidden space-y-4">
                <form action="{{ route('register.post') }}" method="POST" class="space-y-3.5">
                    @csrf
                    <input type="hidden" name="auth_tab" value="register">

                    <!-- Name -->
                    <div>
                        <label for="modal_reg_name" class="block text-xs font-semibold text-gray-700 mb-1">Nama Lengkap</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-user text-xs"></i>
                            </div>
                            <input type="text" name="name" id="modal_reg_name" value="{{ old('auth_tab') === 'register' ? old('name') : '' }}" required placeholder="Nama Lengkap Anda" class="block w-full pl-9 pr-3 py-2.5 text-xs text-gray-900 bg-gray-50/60 border @if($errors->has('name') && old('auth_tab') === 'register') border-red-400 bg-red-50/30 @else border-gray-200 focus:border-[#2E7D32] focus:bg-white @endif rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20">
                        </div>
                        @if ($errors->has('name') && old('auth_tab') === 'register')
                            <p class="mt-1 text-[11px] text-red-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first('name') }}
                            </p>
                        @endif
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="modal_reg_email" class="block text-xs font-semibold text-gray-700 mb-1">Alamat Email</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-envelope text-xs"></i>
                            </div>
                            <input type="email" name="email" id="modal_reg_email" value="{{ old('auth_tab') === 'register' ? old('email') : '' }}" required placeholder="nama@email.com" class="block w-full pl-9 pr-3 py-2.5 text-xs text-gray-900 bg-gray-50/60 border @if($errors->has('email') && old('auth_tab') === 'register') border-red-400 bg-red-50/30 @else border-gray-200 focus:border-[#2E7D32] focus:bg-white @endif rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20">
                        </div>
                        @if ($errors->has('email') && old('auth_tab') === 'register')
                            <p class="mt-1 text-[11px] text-red-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first('email') }}
                            </p>
                        @endif
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="modal_reg_password" class="block text-xs font-semibold text-gray-700 mb-1">Kata Sandi</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                            <input type="password" name="password" id="modal_reg_password" required placeholder="Minimal 8 karakter" class="block w-full pl-9 pr-3 py-2.5 text-xs text-gray-900 bg-gray-50/60 border @if($errors->has('password') && old('auth_tab') === 'register') border-red-400 bg-red-50/30 @else border-gray-200 focus:border-[#2E7D32] focus:bg-white @endif rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20">
                        </div>
                        @if ($errors->has('password') && old('auth_tab') === 'register')
                            <p class="mt-1 text-[11px] text-red-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first('password') }}
                            </p>
                        @endif
                    </div>

                    <!-- Password Confirmation -->
                    <div>
                        <label for="modal_reg_password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1">Konfirmasi Kata Sandi</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-shield-halved text-xs"></i>
                            </div>
                            <input type="password" name="password_confirmation" id="modal_reg_password_confirmation" required placeholder="Ulangi kata sandi" class="block w-full pl-9 pr-3 py-2.5 text-xs text-gray-900 bg-gray-50/60 border border-gray-200 focus:border-[#2E7D32] focus:bg-white rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full py-2.5 px-4 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 active:scale-[0.99]">
                        <span>Daftar Sekarang</span>
                        <i class="fa-solid fa-user-check text-[10px]"></i>
                    </button>
                </form>

                <div class="pt-4 border-t border-gray-100 text-center text-xs text-gray-500">
                    Sudah memiliki akun? 
                    <button type="button" onclick="switchAuthTab('login')" class="font-bold text-[#2E7D32] hover:underline focus:outline-none">Masuk ke Akun</button>
                </div>
            </div>

            <!-- ---------------------------------------------------- -->
            <!-- TAB 3: FORGOT PASSWORD FORM -->
            <!-- ---------------------------------------------------- -->
            <div id="forgotTabPanel" class="auth-panel hidden space-y-4">
                <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="auth_tab" value="forgot">

                    <div class="p-3.5 bg-amber-50 border border-amber-200 rounded-xl text-xs text-amber-800 flex items-start gap-2">
                        <i class="fa-solid fa-circle-info text-amber-500 mt-0.5 flex-shrink-0"></i>
                        <span>Masukkan email akun Anda. Kode reset akan dikirimkan, lalu Anda akan diarahkan ke form pengisian kode.</span>
                    </div>

                    <div>
                        <label for="modal_forgot_email" class="block text-xs font-semibold text-gray-700 mb-1">Alamat Email Terdaftar</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-envelope text-xs"></i>
                            </div>
                            <input type="email" name="email" id="modal_forgot_email" required value="{{ old('auth_tab') === 'forgot' ? old('email') : '' }}" placeholder="nama@email.com" class="block w-full pl-9 pr-3 py-2.5 text-xs text-gray-900 bg-gray-50/60 border @if($errors->has('email') && old('auth_tab') === 'forgot') border-red-400 bg-red-50/30 @else border-gray-200 focus:border-[#2E7D32] focus:bg-white @endif rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20">
                        </div>
                        @if ($errors->has('email') && old('auth_tab') === 'forgot')
                            <p class="mt-1 text-[11px] text-red-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first('email') }}
                            </p>
                        @endif
                    </div>

                    <button type="submit" class="w-full py-2.5 px-4 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 active:scale-[0.99]">
                        <span>Kirim Kode Reset</span>
                        <i class="fa-solid fa-paper-plane text-[10px]"></i>
                    </button>
                </form>

                <div class="pt-4 border-t border-gray-100 text-center text-xs text-gray-500">
                    Ingat kata sandi Anda? 
                    <button type="button" onclick="switchAuthTab('login')" class="font-bold text-[#2E7D32] hover:underline focus:outline-none">Kembali ke Login</button>
                </div>
            </div>

            <!-- ---------------------------------------------------- -->
            <!-- TAB 4: RESET PASSWORD FORM -->
            <!-- ---------------------------------------------------- -->
            <div id="resetTabPanel" class="auth-panel hidden space-y-4">
                <form action="{{ route('password.update') }}" method="POST" class="space-y-3.5">
                    @csrf
                    <input type="hidden" name="auth_tab" value="reset">

                    <!-- Email (pre-filled dari session atau old input) -->
                    <div>
                        <label for="modal_reset_email" class="block text-xs font-semibold text-gray-700 mb-1">Alamat Email</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-envelope text-xs"></i>
                            </div>
                            <input type="email" name="email" id="modal_reset_email"
                                value="{{ session('reset_email') ?? (old('auth_tab') === 'reset' ? old('email') : '') }}"
                                required placeholder="nama@email.com"
                                class="block w-full pl-9 pr-3 py-2.5 text-xs text-gray-900 bg-gray-50/60 border @if($errors->has('email') && old('auth_tab') === 'reset') border-red-400 bg-red-50/30 @else border-gray-200 focus:border-[#2E7D32] focus:bg-white @endif rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20">
                        </div>
                        @if ($errors->has('email') && old('auth_tab') === 'reset')
                            <p class="mt-1 text-[11px] text-red-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first('email') }}
                            </p>
                        @endif
                    </div>

                    <!-- Token / Kode Reset -->
                    <div>
                        <label for="modal_reset_code" class="block text-xs font-semibold text-gray-700 mb-1">
                            Kode Reset
                            <span class="text-[10px] font-normal text-gray-400 ml-1">(dari email yang dikirimkan)</span>
                        </label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-fingerprint text-xs"></i>
                            </div>
                            <input type="text" name="code" id="modal_reset_code"
                                value="{{ session('reset_code') ?? (old('auth_tab') === 'reset' ? old('code') : '') }}"
                                required placeholder="Masukkan 6 digit kode dari email..."
                                autocomplete="off"
                                class="block w-full pl-9 pr-3 py-2.5 font-mono text-[11px] text-gray-800 bg-gray-50/60 border @if($errors->has('code') && old('auth_tab') === 'reset') border-red-400 bg-red-50/30 @else border-gray-200 focus:border-[#2E7D32] focus:bg-white @endif rounded-xl transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20 placeholder:font-sans placeholder:text-gray-400 placeholder:text-xs">
                        </div>
                        @if ($errors->has('code') && old('auth_tab') === 'reset')
                            <p class="mt-1 text-[11px] text-red-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first('code') }}
                            </p>
                        @endif
                        <p class="mt-1.5 text-[10px] text-gray-400 leading-snug flex items-start gap-1">
                            <i class="fa-solid fa-circle-info text-[#2E7D32] mt-0.5 flex-shrink-0"></i>
                            <span>Buka email → salin 6 digit kode dari badan email.</span>
                        </p>
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label for="modal_reset_password" class="block text-xs font-semibold text-gray-700 mb-1">Kata Sandi Baru</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-lock text-xs"></i>
                            </div>
                            <input type="password" name="password" id="modal_reset_password" required placeholder="Minimal 8 karakter"
                                class="block w-full pl-9 pr-9 py-2.5 text-xs text-gray-900 bg-gray-50/60 border @if($errors->has('password') && old('auth_tab') === 'reset') border-red-400 bg-red-50/30 @else border-gray-200 focus:border-[#2E7D32] focus:bg-white @endif rounded-xl transition duration-200 focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20">
                            <button type="button" onclick="toggleModalPasswordVisibility('modal_reset_password', 'toggleResetPwIcon')" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i id="toggleResetPwIcon" class="fa-solid fa-eye text-xs"></i>
                            </button>
                        </div>
                        @if ($errors->has('password') && old('auth_tab') === 'reset')
                            <p class="mt-1 text-[11px] text-red-600 flex items-center gap-1">
                                <i class="fa-solid fa-circle-xmark"></i> {{ $errors->first('password') }}
                            </p>
                        @endif
                    </div>

                    <!-- Konfirmasi Password Baru -->
                    <div>
                        <label for="modal_reset_password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                        <div class="relative rounded-xl shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-shield-halved text-xs"></i>
                            </div>
                            <input type="password" name="password_confirmation" id="modal_reset_password_confirmation" required placeholder="Ulangi kata sandi baru"
                                class="block w-full pl-9 pr-3 py-2.5 text-xs text-gray-900 bg-gray-50/60 border border-gray-200 focus:border-[#2E7D32] focus:bg-white rounded-xl focus:outline-none focus:ring-2 focus:ring-[#2E7D32]/20">
                        </div>
                    </div>

                    <!-- Submit -->
                    <button type="submit" class="w-full py-2.5 px-4 bg-[#2E7D32] hover:bg-[#1B5E20] text-white text-xs font-bold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 flex items-center justify-center gap-2 active:scale-[0.99]">
                        <span>Simpan Kata Sandi Baru</span>
                        <i class="fa-solid fa-key text-[10px]"></i>
                    </button>
                </form>

                <div class="pt-4 border-t border-gray-100 text-center text-xs text-gray-500">
                    Ingat kata sandi Anda? 
                    <button type="button" onclick="switchAuthTab('login')" class="font-bold text-[#2E7D32] hover:underline focus:outline-none">Kembali ke Login</button>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Modal Javascript Logic -->
<script>
    function openAuthModal(tab = 'login') {
        const modal = document.getElementById('authModal');
        const container = document.getElementById('authModalContainer');
        if (!modal || !container) return;

        switchAuthTab(tab);

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeAuthModal() {
        const modal = document.getElementById('authModal');
        const container = document.getElementById('authModalContainer');
        if (!modal || !container) return;

        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.remove('flex');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 200);
    }

    function switchAuthTab(tab) {
        const title    = document.getElementById('authModalTitle');
        const subtitle = document.getElementById('authModalSubtitle');
        const panels   = ['loginTabPanel', 'registerTabPanel', 'forgotTabPanel', 'resetTabPanel'];

        panels.forEach(id => {
            const el = document.getElementById(id);
            if (el) el.classList.add('hidden');
        });

        const config = {
            login:    { title: 'Masuk ke Nusantara BioHub',            subtitle: 'Silakan masuk untuk mengakses akun Anda',              panel: 'loginTabPanel' },
            register: { title: 'Daftar Akun Baru',                     subtitle: 'Bergabunglah dengan platform biodiversitas Nusantara', panel: 'registerTabPanel' },
            forgot:   { title: 'Lupa Kata Sandi',                      subtitle: 'Masukkan email untuk menerima kode reset kata sandi',  panel: 'forgotTabPanel' },
            reset:    { title: 'Masukkan Kode & Password Baru',         subtitle: 'Salin kode dari email lalu buat kata sandi baru',      panel: 'resetTabPanel' },
        };

        if (config[tab]) {
            title.innerText    = config[tab].title;
            subtitle.innerText = config[tab].subtitle;
            const panel = document.getElementById(config[tab].panel);
            if (panel) panel.classList.remove('hidden');
        }
    }

    function toggleModalPasswordVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon  = document.getElementById(iconId);
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

    // Close on Escape key press
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') closeAuthModal();
    });

    // Auto open modal based on server-side state or URL hash
    document.addEventListener('DOMContentLoaded', function() {
        const hash = window.location.hash;

        @if (old('auth_tab') === 'reset' || session('open_reset_modal') || $errors->has('code'))
            openAuthModal('reset');
        @elseif (old('auth_tab') === 'register' || $errors->has('name'))
            openAuthModal('register');
        @elseif (old('auth_tab') === 'forgot')
            openAuthModal('forgot');
        @elseif (old('auth_tab') === 'login' || ($errors->any() && (old('auth_tab') === 'login' || !old('auth_tab'))))
            openAuthModal('login');
        @elseif (session('success'))
            openAuthModal('login');
        @elseif (session('info'))
            openAuthModal('reset');
        @else
            if (hash === '#login') openAuthModal('login');
            if (hash === '#register') openAuthModal('register');
            if (hash === '#forgot-password') openAuthModal('forgot');
            if (hash === '#reset-password') openAuthModal('reset');
        @endif
    });
</script>
