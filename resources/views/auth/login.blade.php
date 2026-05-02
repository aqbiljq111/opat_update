@extends('layouts.app')

@section('title', 'Masuk / Daftar')

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
        .btn-glow {
            position: relative;
            z-index: 1;
        }
        .btn-glow::after {
            content: '';
            position: absolute;
            top: 2px;
            left: 2px;
            right: 2px;
            bottom: -4px;
            background: linear-gradient(45deg, #2563eb, #14b8a6, #3b82f6, #0d9488);
            background-size: 250% 250%;
            z-index: -1;
            filter: blur(12px);
            border-radius: 14px;
            opacity: 0.5;
            animation: glow-animation 4s ease infinite;
            transition: all 0.3s;
        }
        @keyframes glow-animation {
            0% { background-position: 0% 50%; opacity: 0.4; }
            50% { background-position: 100% 50%; opacity: 0.7; }
            100% { background-position: 0% 50%; opacity: 0.4; }
        }
        .btn-glow:hover::after {
            filter: blur(16px);
            opacity: 0.8;
            bottom: -6px;
        }
        /* Dark Mode adjustment for shadow */
        .dark .btn-glow::after {
            opacity: 0.4;
            filter: blur(15px);
        }

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
            <div class="bg-gradient-to-br from-blue-100 to-teal-100 dark:from-blue-900/30 dark:to-teal-900/30 w-16 h-16 rounded-2xl flex items-center justify-center mx-auto mb-4 border border-blue-200 dark:border-blue-800">
                <i class="fas fa-bullhorn text-3xl text-blue-600 dark:text-blue-400"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Opat Update</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Sistem Informasi SMKN 4 Bandung</p>
        </div>

        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-600 rounded-xl text-sm border border-red-200 fade-in">
                <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-600 rounded-xl text-sm border border-green-200 fade-in">
                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-3 bg-red-50 text-red-600 rounded-xl text-sm border border-red-100 fade-in">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Login/Register (Otomatis deteksi di Controller) --}}
        <form action="{{ route('login.post') }}" method="POST" id="authForm">
            @csrf
            
            {{-- Field Nama (Hanya Register) --}}
            <div class="mb-4 hidden" id="nameField">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                <div class="relative">
                    <i class="fas fa-id-card absolute left-4 top-3.5 text-gray-400"></i>
                    <input type="text" name="name" placeholder="Masukkan nama lengkap..." 
                        class="w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-800 border border-blue-100 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition-all dark:text-white">
                </div>
            </div>

            {{-- Field Email/Username (Login) | Field Email (Register) --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2" id="loginLabel">Email</label>
                <div class="relative">
                    <i class="fas fa-user absolute left-4 top-3.5 text-gray-400" id="loginIcon"></i>
                    <input type="text" name="login" required placeholder="Masukkan email" 
                        class="w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-800 border border-blue-100 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition-all dark:text-white">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                <div class="relative">
                    <i class="fas fa-lock absolute left-4 top-3.5 text-gray-400"></i>
                    <input type="password" name="password" required placeholder="Masukkan password" 
                        class="w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-800 border border-blue-100 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition-all dark:text-white">
                </div>
            </div>

            <div class="mb-5 hidden" id="confirmPasswordField">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Konfirmasi Password</label>
                <div class="relative">
                    <i class="fas fa-check-double absolute left-4 top-3.5 text-gray-400"></i>
                    <input type="password" name="password_confirmation" placeholder="Ulangi password..." 
                        class="w-full pl-11 pr-4 py-3 bg-white dark:bg-slate-800 border border-blue-100 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition-all dark:text-white">
                </div>
            </div>

            <button type="submit" id="submitBtn" class="w-full btn-glow bg-gradient-to-r from-blue-600 to-teal-500 hover:from-blue-700 hover:to-teal-600 text-white font-semibold py-3 rounded-xl transition-all shadow-lg">
                Masuk
            </button>

            <div class="text-center mt-6">
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    <span id="toggleText">Belum punya akun?</span> 
                    <button type="button" id="toggleAuth" class="text-blue-600 dark:text-blue-400 font-bold hover:text-teal-600 hover:underline transition-colors">Daftar Sekarang</button>
                </p>
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-slate-800">
                    <a href="{{ route('register.admin') }}" class="text-xs text-gray-400 hover:text-blue-500 dark:hover:text-blue-400 transition-colors">
                        <i class="fas fa-user-tie mr-1"></i> Buat akun sebagai Guru/Admin
                    </a>
                </div>
            </div>
        </form>

        <script>
            const form = document.getElementById('authForm');
            const submitBtn = document.getElementById('submitBtn');
            const toggleAuth = document.getElementById('toggleAuth');
            const toggleText = document.getElementById('toggleText');
            
            const nameField = document.getElementById('nameField');
            const nameInput = nameField.querySelector('input');
            
            const loginLabel = document.getElementById('loginLabel');
            const loginInput = document.getElementsByName('login')[0];
            const loginIcon = document.getElementById('loginIcon');
            
            const confirmPasswordField = document.getElementById('confirmPasswordField');
            const confirmInput = confirmPasswordField.querySelector('input');
            
            let isLogin = true;

            function switchToRegister() {
                isLogin = false;
                form.action = "{{ route('register.post') }}";
                submitBtn.innerText = 'Daftar Akun';
                toggleText.innerText = 'Sudah punya akun?';
                toggleAuth.innerText = 'Login di sini';
                
                nameField.classList.remove('hidden');
                nameInput.setAttribute('required', 'required');
                
                loginLabel.innerText = 'Alamat Email';
                loginInput.placeholder = 'Masukkan alamat email...';
                loginInput.name = 'email';
                loginIcon.className = 'fas fa-envelope absolute left-4 top-3.5 text-gray-400';
                
                confirmPasswordField.classList.remove('hidden');
                confirmInput.setAttribute('required', 'required');
            }

            function switchToLogin() {
                isLogin = true;
                form.action = "{{ route('login.post') }}";
                submitBtn.innerText = 'Masuk';
                toggleText.innerText = 'Belum punya akun?';
                toggleAuth.innerText = 'Daftar Sekarang';
                
                nameField.classList.add('hidden');
                nameInput.removeAttribute('required');
                
                loginLabel.innerText = 'Email atau Nama User';
                loginInput.placeholder = 'Masukkan email atau nama...';
                loginInput.name = 'login';
                loginIcon.className = 'fas fa-user absolute left-4 top-3.5 text-gray-400';
                
                confirmPasswordField.classList.add('hidden');
                confirmInput.removeAttribute('required');
            }

            toggleAuth.addEventListener('click', () => {
                if (isLogin) switchToRegister();
                else switchToLogin();
            });

            // Auto-switch to register if there are registration-specific errors
            @if($errors->has('name') || $errors->has('email') && old('name'))
                switchToRegister();
                // Fill back old values safely
                nameInput.value = @json(old('name'));
                loginInput.value = @json(old('email'));
            @endif
        </script>
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