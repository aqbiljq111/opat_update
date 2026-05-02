<nav class="bg-white/80 dark:bg-slate-900/80 backdrop-blur-md shadow-sm border-b border-gray-100 dark:border-slate-800 sticky top-0 z-50 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex items-center gap-3">
                <div class="bg-gradient-to-br from-blue-600 to-teal-500 text-white p-2 rounded-lg shadow-lg shadow-blue-500/20"><i class="fas fa-bullhorn"></i></div>
                <span class="font-bold text-xl tracking-tight dark:text-white"><span class="text-blue-600">Opat</span><span class="text-teal-500">Update</span></span>
            </div>
            
            <div class="flex items-center space-x-4">
                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center space-x-6">
                    <a href="/dashboard" class="text-gray-600 dark:text-gray-400 hover:text-teal-600 dark:hover:text-teal-400 font-medium transition-colors">Beranda</a>
                    <a href="/chat" class="text-gray-600 dark:text-gray-400 hover:text-teal-600 dark:hover:text-teal-400 font-medium transition-colors">Tanya</a>
                    <div class="h-6 w-px bg-gray-200 dark:bg-slate-700"></div>
                </div>

                {{-- Dark Mode Toggle --}}
                <button onclick="toggleDarkMode()" class="w-10 h-10 flex items-center justify-center rounded-xl bg-gray-100 dark:bg-slate-800 text-gray-500 dark:text-yellow-400 hover:ring-2 hover:ring-teal-500 transition-all">
                    <i class="fas fa-moon dark:hidden"></i>
                    <i class="fas fa-sun hidden dark:block"></i>
                </button>

                {{-- User Info (Desktop) --}}
                <div class="hidden md:block text-right">
                    <p class="text-sm font-bold text-gray-900 dark:text-white leading-tight">{{ Auth::user()->username }}</p>
                    <p class="text-[10px] text-teal-700 dark:text-teal-300 font-bold bg-teal-50 dark:bg-teal-900/30 px-2 py-0.5 rounded-md capitalize inline-block">{{ Auth::user()->role }}</p>
                </div>

                <form action="/logout" method="POST" class="hidden md:flex items-center">
                    @csrf
                    <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors p-2"><i class="fas fa-sign-out-alt text-lg"></i></button>
                </form>

                {{-- Mobile Menu Button --}}
                <button onclick="toggleMobileMenu()" class="md:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-gray-50 dark:bg-slate-800 text-gray-600 dark:text-gray-400">
                    <i class="fas fa-bars" id="menu-icon"></i>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div id="mobile-menu" class="hidden md:hidden border-t border-gray-100 dark:border-slate-800 bg-white dark:bg-slate-900 fade-in">
        <div class="px-4 pt-2 pb-6 space-y-2">
            <div class="flex items-center gap-3 p-3 mb-4 bg-gray-50 dark:bg-slate-800 rounded-xl">
                <div class="w-10 h-10 rounded-full bg-teal-500 flex items-center justify-center text-white font-bold">
                    {{ substr(Auth::user()->username, 0, 1) }}
                </div>
                <div>
                    <p class="font-bold text-gray-900 dark:text-white">{{ Auth::user()->username }}</p>
                    <p class="text-xs text-teal-600 dark:text-teal-400 capitalize font-medium">{{ Auth::user()->role }}</p>
                </div>
            </div>
            <a href="/dashboard" class="block px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-slate-800 hover:text-teal-600 font-medium transition-all">
                <i class="fas fa-home mr-3"></i> Beranda
            </a>
            <a href="/chat" class="block px-4 py-3 rounded-xl text-gray-700 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-slate-800 hover:text-teal-600 font-medium transition-all">
                <i class="fas fa-comments mr-3"></i> Tanya Jawab
            </a>
            <div class="pt-4 mt-4 border-t border-gray-100 dark:border-slate-800">
                <form action="/logout" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center px-4 py-3 rounded-xl text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10 font-medium transition-all">
                        <i class="fas fa-sign-out-alt mr-3"></i> Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

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

    function toggleMobileMenu() {
        const menu = document.getElementById('mobile-menu');
        const icon = document.getElementById('menu-icon');
        menu.classList.toggle('hidden');
        if (menu.classList.contains('hidden')) {
            icon.classList.remove('fa-times');
            icon.classList.add('fa-bars');
        } else {
            icon.classList.remove('fa-bars');
            icon.classList.add('fa-times');
        }
    }
</script>