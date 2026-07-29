<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('homepage');
        }
        return view('auth.login');
    }

    /**
     * Proses autentikasi login.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('homepage'))->with('success', 'Selamat datang kembali di Nusantara BioHub!');
        }

        return back()->withErrors([
            'email' => 'Email atau password yang Anda masukkan tidak cocok.',
        ])->onlyInput('email');
    }

    /**
     * Tampilkan form registrasi.
     */
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('homepage');
        }
        return view('auth.register');
    }

    /**
     * Proses pendaftaran user baru.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required' => 'Nama lengkap wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('homepage')->with('success', 'Akun berhasil dibuat! Selamat datang di Nusantara BioHub.');
    }

    /**
     * Proses logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }

    // ==========================================
    // MENU & ALUR LUPA / RESET KATA SANDI
    // ==========================================

    /**
     * Tampilkan form input email untuk lupa password.
     */
    public function showForgotPasswordForm()
    {
        if (Auth::check()) {
            return redirect()->route('homepage');
        }
        return view('auth.forgot-password');
    }

    /**
     * Kirim link reset password ke email user, lalu buka modal tab reset di homepage.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        // Mengirimkan link reset via facade Password (token disimpan di DB)
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            // Redirect ke homepage → modal reset tab akan terbuka otomatis via session
            return redirect()->route('homepage')
                ->with('reset_email', $request->email)
                ->with('open_reset_modal', true)
                ->with('info', 'Kode reset telah dikirim ke email ' . $request->email . '. Masukkan kode di bawah ini.');
        }

        return back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem kami.'])->onlyInput('email');
    }

    /**
     * Tampilkan form input password baru.
     * Jika diakses dari link email langsung (token di URL) → tampilkan halaman standalone.
     * Jika diakses dengan token=manual → redirect ke homepage & buka modal tab reset.
     */
    public function showResetPasswordForm(string $token, Request $request)
    {
        $email = $request->email ?? session('reset_email');

        if ($token === 'manual') {
            // Redirect ke homepage dengan session, modal tab reset akan terbuka otomatis
            return redirect()->route('homepage')
                ->with('reset_email', $email)
                ->with('open_reset_modal', true)
                ->with('info', 'Masukkan kode dari email Anda dan buat kata sandi baru.');
        }

        // Akses langsung dari link email: tampilkan halaman reset standalone
        return view('auth.reset-password', [
            'token'        => $token,
            'email'        => $email,
            'fromRedirect' => false,
            'infoMessage'  => null,
        ]);
    }

    /**
     * Proses pembaharuan password baru.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Eksekusi reset password
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Password Anda berhasil diperbarui! Silakan login kembali.');
        }

        return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah kadaluwarsa.'])->withInput($request->only('email', 'token', 'auth_tab'));
    }
}