<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\SendSixDigitCodeNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\Controller;

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

    // 1. Generate Kode 6 Digit & Kirim via Notification
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email'    => 'Format email tidak valid.',
            'email.exists'   => 'Email tidak ditemukan.',
        ]);

        // Generate 6 digit angka acak
        $code = random_int(100000, 999999);

        // Hapus token lama jika ada, lalu simpan kode yang telah di-hash
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();
        DB::table('password_reset_tokens')->insert([
            'email'      => $request->email,
            'token'      => Hash::make($code),
            'created_at' => now(),
        ]);

        // Kirim email notifikasi berisi kode 6 digit
        $user = User::where('email', $request->email)->first();
        $user->notify(new SendSixDigitCodeNotification((string) $code));

        return redirect()->route('homepage')
            ->with('reset_email', $request->email)
            ->with('open_reset_modal', true)
            ->with('info', 'Kode 6 digit telah dikirim ke email ' . $request->email . '. Masukkan kode tersebut di bawah ini.');
    }

    public function showResetPasswordForm(string $token = 'manual', ?Request $request = null)
    {
        // Aman dari error null property access
        $email = $request ? $request->email : session('reset_email');

        return redirect()->route('homepage')
            ->with('reset_email', $email)
            ->with('open_reset_modal', true)
            ->with('info', 'Masukkan kode 6 digit dari email Anda dan buat kata sandi baru.');
    }

    // 2. Verifikasi Kode 6 Digit & Perbarui Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email', 'exists:users,email'],
            'code'     => ['required', 'numeric', 'digits:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'email.required'     => 'Email wajib diisi.',
            'email.email'        => 'Format email tidak valid.',
            'email.exists'       => 'Email tidak terdaftar.',
            'code.required'      => 'Kode 6 digit wajib diisi.',
            'code.numeric'       => 'Kode harus berupa angka.',
            'code.digits'        => 'Kode harus berjumlah 6 digit.',
            'password.required'  => 'Password baru wajib diisi.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        $record = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        // Cek 1: Record token ada atau tidak
        if (!$record) {
            return back()
                ->with('open_reset_modal', true)
                ->with('reset_email', $request->email)
                ->withErrors(['code' => 'Permintaan reset tidak ditemukan. Silakan minta kode baru.'])
                ->withInput();
        }

        // Cek 2: Expiration (berlaku 15 menit)
        if (now()->subMinutes(15)->gt($record->created_at)) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()
                ->with('open_reset_modal', true)
                ->with('reset_email', $request->email)
                ->withErrors(['code' => 'Kode 6 digit sudah kadaluwarsa. Silakan minta kode baru.'])
                ->withInput();
        }

        // Cek 3: Verifikasi kecocokan hash kode
        if (!Hash::check($request->code, $record->token)) {
            return back()
                ->with('open_reset_modal', true)
                ->with('reset_email', $request->email)
                ->withErrors(['code' => 'Kode 6 digit yang Anda masukkan salah.'])
                ->withInput();
        }

        // Cek 4: Update Password User
        $user = User::where('email', $request->email)->first();
        $user->forceFill([
            'password'       => Hash::make($request->password),
            'remember_token' => Str::random(60),
        ])->save();

        event(new PasswordReset($user));

        // Hapus token yang sudah dipakai
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('success', 'Password Anda berhasil diperbarui! Silakan login kembali.');
    }
}   