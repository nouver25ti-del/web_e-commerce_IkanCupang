<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /* ---------- Pelanggan ---------- */

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        return $this->masuk($request, User::ROLE_CUSTOMER);
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name'     => ['required', 'max:100'],
            'email'    => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ], [
            'name.required'      => 'Isi nama lengkap.',
            'email.required'     => 'Isi email.',
            'email.email'        => 'Format email tidak valid.',
            'email.unique'       => 'Email ini sudah terdaftar.',
            'password.required'  => 'Isi kata sandi.',
            'password.min'       => 'Kata sandi minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // Peran tidak diambil dari input: akun baru selalu "customer" (default kolom).
        $user = User::create($data);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('cupang.index')->with('status', 'Akun berhasil dibuat. Selamat berbelanja!');
    }

    /* ---------- Admin ---------- */

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        return $this->masuk($request, User::ROLE_ADMIN);
    }

    /* ---------- Keluar ---------- */

    public function logout(Request $request)
    {
        $keLoginAdmin = $request->user()?->isAdmin();

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($keLoginAdmin ? route('admin.login') : route('cupang.index'));
    }

    /* ---------- Proses login bersama ---------- */

    private function masuk(Request $request, string $peran)
    {
        $cred = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required'    => 'Isi email.',
            'email.email'       => 'Format email tidak valid.',
            'password.required' => 'Isi kata sandi.',
        ]);

        $kunci = Str::lower($cred['email']).'|'.$request->ip();

        if (RateLimiter::tooManyAttempts($kunci, 5)) {
            $detik = RateLimiter::availableIn($kunci);

            return back()
                ->withErrors(['email' => "Terlalu banyak percobaan. Coba lagi dalam {$detik} detik."])
                ->onlyInput('email');
        }

        if (! Auth::attempt($cred, $request->boolean('remember'))) {
            RateLimiter::hit($kunci);

            return back()
                ->withErrors(['email' => 'Email atau kata sandi salah.'])
                ->onlyInput('email');
        }

        // Kredensial benar, tapi harus sesuai halaman login yang dipakai.
        if (Auth::user()->role !== $peran) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $pesan = $peran === User::ROLE_ADMIN
                ? 'Akun ini bukan akun admin.'
                : 'Akun admin masuk lewat halaman login admin.';

            return back()->withErrors(['email' => $pesan])->onlyInput('email');
        }

        RateLimiter::clear($kunci);
        $request->session()->regenerate();

        return redirect()->intended(Auth::user()->homeUrl());
    }
}
