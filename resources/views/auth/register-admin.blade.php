@extends('layouts.app')

@section('title', 'Buat Akun Admin/Guru')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4 relative">
    {{-- Guest Dark Mode Toggle --}}
    <div class="absolute top-6 right-6">
        <button onclick="toggleDarkMode()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white/80 dark:bg-slate-800/80 backdrop-blur-md shadow-sm border border-gray-100 dark:border-slate-700 text-gray-500 dark:text-yellow-400 hover:scale-110 transition-all">
            <i class="fas fa-moon dark:hidden"></i>
            <i class="fas fa-sun hidden dark:block"></i>
        </button>
    </div>

    <style>
        /* Fix Autofill background in dark mode */
        .dark input:-webkit-autofill,
        .dark input:-webkit-autofill:hover, 
        .dark input:-webkit-autofill:focus, 
        .dark input:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 30px #1e293b inset !important;
            -webkit-text-fill-color: white !important;
            transition: background-color 5000s ease-in-out 0s;
        }
    </style>

    <div class="bg-white dark:bg-slate-800 p-8 rounded-3xl shadow-xl w-full max-w-md fade-in border border-gray-100 dark:border-slate-700 transition-colors duration-300">
        <div class="text-center mb-8">
            <div class="bg-gradient-to-br from-teal-100 to-blue-100 dark:from-teal-900/30 dark:to-blue-900/30 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-teal-200 dark:border-teal-800">
                <i class="fas fa-user-shield text-3xl text-teal-600 dark:text-teal-400"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Registrasi Guru</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Sistem Informasi SMKN 4 Bandung</p>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 text-red-600 rounded-xl text-sm border border-red-100 dark:border-red-900/30 dark:bg-red-900/20 fade-in">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register.admin.post') }}" method="POST">
            @csrf
            
            {{-- Field NIP --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">NIP</label>
                <div class="relative">
                    <i class="fas fa-id-badge absolute left-4 top-3.5 text-gray-400"></i>
                    <input type="text" name="nip" required value="{{ old('nip') }}" placeholder="Masukkan NIP..." 
                        class="w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-800 border border-blue-100 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition-all dark:text-white">
                </div>
            </div>

            {{-- Field Username --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-4 top-3.5 text-gray-400"></i>
                    <input type="text" name="username" required value="{{ old('username') }}" placeholder="Masukkan username..." 
                        class="w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-800 border border-blue-100 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition-all dark:text-white">
                </div>
            </div>

            {{-- Field Email --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Alamat Email</label>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-3.5 text-gray-400"></i>
                    <input type="email" name="email" required value="{{ old('email') }}" placeholder="Masukkan email..." 
                        class="w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-800 border border-blue-100 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition-all dark:text-white">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-3.5 text-gray-400"></i>
                    <input type="password" name="password" required placeholder="Masukkan password..." 
                        class="w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-800 border border-blue-100 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition-all dark:text-white">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password</label>
                <div class="relative">
                    <i class="fas fa-check-double absolute left-4 top-3.5 text-gray-400"></i>
                    <input type="password" name="password_confirmation" required placeholder="Ulangi password..." 
                        class="w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-800 border border-blue-100 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition-all dark:text-white">
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-teal-600 to-blue-500 hover:from-teal-700 hover:to-blue-600 text-white font-semibold py-3 rounded-xl transition-all shadow-lg shadow-teal-200 dark:shadow-teal-900/20">
                Daftar Akun Admin/Guru
            </button>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="text-sm text-blue-600 dark:text-blue-400 font-bold hover:text-teal-600 hover:underline transition-colors">
                    Kembali ke halaman Login
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleDarkMode() {
        const html = document.documentElement;
        if (html.classList.contains('dark')) {
            html.classList.remove('dark');
            localStorage.setItem('dark-mode', 'false');
        } else {
            html.classList.add('dark');
            localStorage.setItem('dark-mode', 'true');
        }
    }
</script>
@endsection
