<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index() {
        if(Auth::check()) return redirect()->route('dashboard');
        return view('auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'login' => 'required', // Ini bisa email atau username
            'password' => 'required'
        ]);
        
        // Coba login pakai email dulu, kalau gagal coba pakai username
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        
        if (Auth::attempt([$loginType => $request->login, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->route('dashboard');
        }
        
        return back()->with('error', 'Email/Username atau password salah.');
    }

    public function register(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:4|confirmed'
        ]);

        // Kita gunakan email sebagai username secara otomatis agar unik
        // atau gunakan nama yang di-sanitize. Lebih aman email.
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->email, // Username disamakan dengan email agar unik
            'password' => Hash::make($request->password),
            'role' => 'siswa' // Selalu jadi murid
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Selamat datang! Akun murid berhasil dibuat.');
    }

    public function showAdminRegister() {
        if(Auth::check()) return redirect()->route('dashboard');
        return view('auth.register-admin');
    }

    public function registerAdmin(Request $request) {
        $request->validate([
            'nip' => 'required|max:30|unique:user,nip',
            'username' => 'required|max:255|unique:user,username',
            'email' => 'required|email|unique:user,email',
            'password' => 'required|min:4|confirmed'
        ]);

        $user = User::create([
            'nip' => $request->nip,
            'name' => $request->username, // Gunakan username sebagai nama sementara
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'guru' // Admin adalah Guru
        ]);

        Auth::login($user);
        return redirect()->route('dashboard')->with('success', 'Selamat datang Pak/Bu Guru! Akun admin berhasil dibuat.');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}

