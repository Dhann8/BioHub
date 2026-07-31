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
    public function showAdminLoginForm()
    {
        if (Auth::check()) {
            return Auth::user()->role === 'admin' 
                ? redirect()->route('admin.dashboard') 
                : redirect()->route('homepage');
        }
        return redirect()->route('homepage')->with('open_auth_modal', true)->with('auth_tab', 'login');
    }

    public function adminLogin(Request $request)
    {
        return $this->login($request);
    }

    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('homepage');
        }
        return redirect()->route('homepage')->with('open_auth_modal', true)->with('auth_tab', 'login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email atau Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
        ]);

        $loginInput = trim($credentials['email']);
        $fieldType  = filter_var($loginInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'name';

        $attemptCredentials = [
            $fieldType => $loginInput,
            'password' => $credentials['password'],
        ];

        $remember = $request->boolean('remember');

        if (Auth::attempt($attemptCredentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Selamat datang di Panel Admin BioHub!');
            }

            return redirect()->intended(route('homepage'))->with('success', 'Selamat datang kembali di Nusantara BioHub!');
        }

        return back()->withErrors([
            'email' => 'Email/Username atau password yang Anda masukkan tidak cocok.',
        ])->onlyInput('email');
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('homepage');
        }
        return redirect()->route('homepage')->with('open_auth_modal', true)->with('auth_tab', 'register');
    }

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

        // Role otomatis 'user' saat mendaftar lewat form
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('homepage')->with('success', 'Akun berhasil dibuat! Selamat datang di Nusantara BioHub.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Anda telah berhasil keluar.');
    }

    public function showForgotPasswordForm()
    {
        if (Auth::check()) {
            return redirect()->route('homepage');
        }
        return view('auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return redirect()->route('homepage')
                ->with('reset_email', $request->email)
                ->with('open_reset_modal', true)
                ->with('info', 'Kode reset telah dikirim ke email ' . $request->email . '. Masukkan kode di bawah ini.');
        }

        return back()->withErrors(['email' => 'Email tidak ditemukan dalam sistem kami.'])->onlyInput('email');
    }

    public function showResetPasswordForm(string $token, Request $request)
    {
        $email = $request->email ?? session('reset_email');

        if ($token === 'manual') {
            return redirect()->route('homepage')
                ->with('reset_email', $email)
                ->with('open_reset_modal', true)
                ->with('info', 'Masukkan kode dari email Anda dan buat kata sandi baru.');
        }

        return view('auth.reset-password', [
            'token'        => $token,
            'email'        => $email,
            'fromRedirect' => false,
            'infoMessage'  => null,
        ]);
    }

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