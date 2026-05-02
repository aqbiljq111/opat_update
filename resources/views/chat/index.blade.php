@extends('layouts.app')

@section('title', 'Forum Tanya Jawab')

@section('content')
@push('scripts')
<style>
    /* Fix Autofill background in dark mode */
    .dark input:-webkit-autofill,
    .dark input:-webkit-autofill:hover, 
    .dark input:-webkit-autofill:focus, 
    .dark input:-webkit-autofill:active {
        -webkit-box-shadow: 0 0 0 30px #0f172a inset !important;
        -webkit-text-fill-color: white !important;
        transition: background-color 5000s ease-in-out 0s;
    }
</style>
@endpush
<main class="max-w-4xl mx-auto px-4 py-8 w-full">
    {{-- Page Header --}}
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2 tracking-tight">Forum Tanya Jawab</h1>
        <p class="text-gray-600 dark:text-gray-400">Berdiskusi, bertanya, dan temukan jawaban dari para guru.</p>
    </header>

    {{-- Ask Question Section --}}
    <section class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border dark:border-slate-700 p-4 mb-8" aria-labelledby="ask-form-title">
        <header class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400">
                <i class="fas fa-user"></i>
            </div>
            <button onclick="document.getElementById('ask-form').classList.toggle('hidden')" 
                    class="flex-grow bg-gray-50 dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg px-4 py-2 text-left text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                Apa yang ingin Anda tanyakan?
            </button>
        </header>

        <div id="ask-form" class="hidden space-y-4 pt-2 border-t dark:border-slate-700">
            <form action="{{ route('chat.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Judul Pertanyaan</label>
                    <input type="text" name="title" required placeholder="Gunakan judul yang deskriptif..." 
                        class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">Detail Pertanyaan</label>
                    <textarea name="message" required rows="4" placeholder="Jelaskan pertanyaan Anda lebih detail..." 
                        class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-lg outline-none focus:ring-2 focus:ring-teal-500 dark:text-white"></textarea>
                </div>
                <footer class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('ask-form').classList.add('hidden')" class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg">Batal</button>
                    <button type="submit" class="px-6 py-2 bg-gradient-to-r from-blue-600 to-teal-500 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-teal-600 transition-colors">Posting Pertanyaan</button>
                </footer>
            </form>
        </div>
    </section>

    {{-- Search & Filter Section --}}
    <section class="mb-8" aria-label="Cari Pertanyaan">
        <form action="{{ route('chat') }}" method="GET" autocomplete="off">
            <div class="relative group">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-teal-500 transition-colors"></i>
                <input type="text" id="search-input" name="search" value="{{ request('search') }}" placeholder="Cari pertanyaan berdasarkan judul atau isi..." 
                    class="w-full pl-11 pr-12 py-3 bg-white dark:bg-slate-900 border border-gray-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-teal-500 outline-none transition-all dark:text-white shadow-sm"
                    autocomplete="off">
                
                {{-- Recent Search Dropdown --}}
                <div id="recent-searches" class="hidden absolute top-full left-0 right-0 mt-2 bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-xl shadow-xl z-50 overflow-hidden fade-in">
                    <header class="p-3 border-b border-gray-50 dark:border-slate-700 flex justify-between items-center bg-gray-50/50 dark:bg-slate-900/50">
                        <span class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Pencarian Terakhir</span>
                        <button type="button" onclick="clearRecentSearches()" class="text-[10px] font-bold text-red-400 hover:text-red-500 uppercase tracking-widest">Hapus Semua</button>
                    </header>
                    <div id="recent-list" class="max-h-48 overflow-y-auto">
                        {{-- Items injected via JS --}}
                    </div>
                </div>

                @if(request('search'))
                <a href="{{ route('chat') }}" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors" title="Hapus pencarian">
                    <i class="fas fa-times"></i>
                </a>
                @else
                <button type="submit" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-teal-500 transition-colors" title="Cari">
                    <i class="fas fa-arrow-right"></i>
                </button>
                @endif
            </div>
        </form>
    </section>

    {{-- Forum Feed --}}
    <section class="space-y-4" id="forum-list" aria-label="Feed Diskusi">
        @include('chat.partials.list')
    </section>
</main>
@endsection

@push('scripts')
<script>
    const searchInput = document.getElementById('search-input');
    const recentDropdown = document.getElementById('recent-searches');
    const recentList = document.getElementById('recent-list');

    // Load recent searches
    function getRecentSearches() {
        return JSON.parse(localStorage.getItem('forum_recent_searches') || '[]');
    }

    function saveSearch(query) {
        if (!query || !query.trim()) return;
        let searches = getRecentSearches();
        searches = searches.filter(s => s !== query); // Remove duplicates
        searches.unshift(query);
        searches = searches.slice(0, 5); // Keep last 5
        localStorage.setItem('forum_recent_searches', JSON.stringify(searches));
    }

    function renderRecentSearches() {
        const searches = getRecentSearches();
        if (searches.length === 0) {
            recentDropdown.classList.add('hidden');
            return;
        }

        recentList.innerHTML = searches.map(s => `
            <button type="button" onclick="setSearch('${s}')" class="w-full px-4 py-2.5 text-left text-sm text-gray-600 dark:text-gray-300 hover:bg-teal-50 dark:hover:bg-slate-700 flex items-center gap-3 transition-colors">
                <i class="fas fa-history text-gray-400 text-xs"></i>
                <span class="truncate">${s}</span>
            </button>
        `).join('');
    }

    function setSearch(query) {
        searchInput.value = query;
        searchInput.closest('form').submit();
    }

    window.clearRecentSearches = function() {
        localStorage.removeItem('forum_recent_searches');
        recentDropdown.classList.add('hidden');
    }

    // Live Search Logic
    let debounceTimer;
    searchInput.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        const query = searchInput.value;
        
        // Hide dropdown when typing
        recentDropdown.classList.add('hidden');

        debounceTimer = setTimeout(() => {
            fetchForum(query);
        }, 300);
    });

    async function fetchForum(query) {
        const forumList = document.getElementById('forum-list');
        // Optional: show loading state
        forumList.style.opacity = '0.5';

        try {
            const response = await fetch(`{{ route('chat') }}?search=${encodeURIComponent(query)}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const html = await response.text();
            forumList.innerHTML = html;
        } catch (error) {
            console.error('Error fetching forum:', error);
        } finally {
            forumList.style.opacity = '1';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('focus', () => {
            renderRecentSearches();
            const searches = getRecentSearches();
            if (searches.length > 0) recentDropdown.classList.remove('hidden');
        });

        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !recentDropdown.contains(e.target)) {
                recentDropdown.classList.add('hidden');
            }
        });

        searchInput.closest('form').addEventListener('submit', (e) => {
            saveSearch(searchInput.value);
        });
    }
</script>
@endpush