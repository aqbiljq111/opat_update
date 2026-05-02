@extends('layouts.app')

@section('title', 'Mading Digital')

@push('scripts')
<style>
    .animate-gradient {
        background-size: 200% 200%;
        animation: gradient-move 5s ease infinite;
    }
    @keyframes gradient-move {
        0% { background-position: 100% 0%; }
        50% { background-position: 0% 100%; }
        100% { background-position: 100% 0%; }
    }
    .shadow-premium {
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.05);
    }
    /* Dark Mode Icon Fix for native pickers (fallback) */
    .dark input::-webkit-calendar-picker-indicator {
        filter: invert(1);
    }
    /* Flatpickr Dark Mode Styling */
    .dark .flatpickr-calendar,
    .dark .flatpickr-days,
    .dark .flatpickr-innerContainer,
    .dark .flatpickr-months,
    .dark .flatpickr-month,
    .dark .flatpickr-weekdayContainer,
    .dark .flatpickr-time {
        background: #1e293b !important;
        background-color: #1e293b !important;
        color: white !important;
        border-color: #334155 !important;
    }
    .dark .flatpickr-calendar {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5) !important;
    }
    .dark .flatpickr-day, 
    .dark .flatpickr-weekday, 
    .dark .cur-month, 
    .dark .flatpickr-month, 
    .dark .flatpickr-time input,
    .dark .flatpickr-time .flatpickr-time-separator {
        color: white !important;
    }
    .dark .flatpickr-day:hover,
    .dark .flatpickr-day.prevMonthDay:hover,
    .dark .flatpickr-day.nextMonthDay:hover {
        background: #334155 !important;
        border-color: #334155 !important;
    }
    .dark .flatpickr-day.selected {
        background: #14b8a6 !important;
        border-color: #14b8a6 !important;
    }
    .dark .flatpickr-day.prevMonthDay, 
    .dark .flatpickr-day.nextMonthDay {
        color: #64748b !important;
    }
    .dark .flatpickr-monthDropdown-months,
    .dark .flatpickr-monthDropdown-month {
        background: #1e293b !important;
        color: white !important;
    }
    .dark .numInputWrapper span:hover {
        background: #334155 !important;
    }
    .dark .flatpickr-current-month .numInputWrapper span.arrowUp:after { border-bottom-color: white; }
    .dark .flatpickr-current-month .numInputWrapper span.arrowDown:after { border-top-color: white; }

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
@endpush

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
    
    {{-- Form Admin & Guru (Create Announcement) --}}
    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'guru')
    <section class="mb-8 fade-in" aria-labelledby="create-announcement-title">
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-premium border border-blue-100 dark:border-slate-700 overflow-hidden transition-all duration-300">
            {{-- Header Form --}}
            <header class="bg-gradient-to-r from-blue-600 to-teal-500 animate-gradient px-6 py-5 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="bg-white/20 p-2 rounded-xl backdrop-blur-md">
                        <i class="fas fa-plus-circle text-white text-xl"></i>
                    </div>
                    <h2 id="create-announcement-title" class="text-white font-bold text-xl tracking-tight">Tambah Pengumuman Baru</h2>
                </div>
                
                @if(Auth::user()->role === 'admin')
                <nav>
                    <a href="{{ route('users.index') }}" class="bg-white text-blue-600 hover:bg-blue-50 px-4 py-2 rounded-lg text-sm font-bold flex items-center gap-2 transition-colors">
                        <i class="fas fa-users"></i> Manajemen User
                    </a>
                </nav>
                @endif
            </header>

            {{-- Input Form --}}
            <form action="/announcement" method="POST" class="p-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-5">
                    <input type="text" name="title" placeholder="Judul Pengumuman" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                    <select name="category" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                        <option value="mingguan">Kategori: Mingguan</option>
                        <option value="bulanan">Kategori: Bulanan</option>
                        <option value="tahunan">Kategori: Tahunan</option>
                    </select>
                    <input type="text" name="date" placeholder="Pilih Tanggal" class="datepicker w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                    <input type="text" name="location" placeholder="Lokasi Pelaksanaan" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                    <input type="text" name="time" required placeholder="Pilih Jam" class="timepicker w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                </div>
                <textarea name="content" rows="3" placeholder="Isi Pengumuman (Opsional)" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border dark:border-slate-700 rounded-xl outline-none mb-4 focus:ring-2 focus:ring-teal-500 dark:text-white"></textarea>
                
                <footer class="flex justify-end">
                    <button type="submit" class="bg-gradient-to-r from-blue-600 to-teal-500 hover:from-blue-700 hover:to-teal-600 text-white font-medium px-6 py-2.5 rounded-xl shadow-md transition-all">
                        Publish Info
                    </button>
                </footer>
            </form>
        </div>
    </section>
    @endif

    {{-- Live Search Header --}}
    <section class="mb-8 fade-in" aria-label="Pencarian">
        <form action="{{ route('dashboard') }}" method="GET" id="dashboard-search-form" autocomplete="off">
            <div class="relative group">
                <i class="fas fa-search absolute left-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-teal-500 transition-colors"></i>
                <input type="text" id="dashboard-search-input" name="search" value="{{ request('search') }}" placeholder="Cari pengumuman berdasarkan judul atau isi..." 
                    class="w-full pl-14 pr-4 py-4 bg-white dark:bg-slate-800 border border-blue-100 dark:border-slate-700 rounded-2xl shadow-premium outline-none focus:ring-2 focus:ring-teal-500 transition-all dark:text-white"
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
                <a href="{{ route('dashboard') }}" class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 transition-colors">
                    <i class="fas fa-times"></i>
                </a>
                @endif
            </div>
        </form>
    </section>

    <div class="flex flex-col-reverse lg:flex-row gap-8">
        {{-- List Content --}}
        <section class="w-full lg:w-3/4 space-y-5" id="announcement-list" aria-label="Daftar Pengumuman">
            @include('dashboard.partials.list')
        </section>

        {{-- Sidebar Filters --}}
        <aside class="w-full lg:w-1/4">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-premium border border-blue-100 dark:border-slate-700 p-6 lg:sticky lg:top-24 transition-all duration-300">
                <header class="flex items-center gap-3 mb-6">
                    <div class="bg-blue-100 dark:bg-blue-900/30 p-2 rounded-xl">
                        <i class="fas fa-filter text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h4 class="font-bold text-xl dark:text-white tracking-tight">Filter</h4>
                </header>

                <form action="{{ route('dashboard') }}" method="GET" class="space-y-5" id="filter-form">
                    {{-- Filter: Location --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Lokasi</label>
                        <div class="relative">
                            <i class="fas fa-map-marker-alt absolute left-3.5 top-3 text-gray-400"></i>
                            <input type="text" name="location" value="{{ request('location') }}" placeholder="Cari Lokasi..." 
                                class="w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-transparent dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white text-sm">
                        </div>
                    </div>

                    {{-- Filter: Date --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Tanggal Spesifik</label>
                        <div class="relative">
                            <i class="fas fa-calendar absolute left-3.5 top-3 text-gray-400"></i>
                            <input type="text" name="date" value="{{ request('date') }}" placeholder="Pilih Tanggal..."
                                class="datepicker w-full pl-10 pr-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-transparent dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white text-sm">
                        </div>
                    </div>

                    {{-- Filter: Month --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-2">Bulan</label>
                        <div class="relative">
                            <select name="month" onchange="this.form.submit()" class="w-full px-4 py-2.5 bg-gray-50 dark:bg-slate-900 border border-transparent dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white text-sm appearance-none cursor-pointer">
                                <option value="all">Semua Bulan</option>
                                @php
                                    $months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                                @endphp
                                @foreach($months as $index => $monthName)
                                    <option value="{{ $index + 1 }}" {{ request('month') == ($index + 1) ? 'selected' : '' }}>{{ $monthName }}</option>
                                @endforeach
                            </select>
                            <i class="fas fa-chevron-down absolute right-4 top-3.5 text-gray-400 pointer-events-none text-xs"></i>
                        </div>
                    </div>

                    <div class="pt-2 flex gap-2">
                        <button type="submit" class="flex-grow bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-blue-500/20 transition-all text-sm">Terapkan</button>
                        <a href="{{ route('dashboard') }}" class="w-12 flex items-center justify-center bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-gray-400 rounded-xl hover:bg-gray-200 transition-all" title="Reset Filter">
                            <i class="fas fa-sync-alt"></i>
                        </a>
                    </div>
                </form>
            </div>
        </aside>
    </div>
</main>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Flatpickr Date
        flatpickr(".datepicker", {
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
            allowInput: true,
            onReady: function(selectedDates, dateStr, instance) {
                const todayBtn = document.createElement("div");
                todayBtn.innerHTML = "Hari Ini";
                todayBtn.classList.add("flatpickr-today-btn");
                todayBtn.style.textAlign = "center";
                todayBtn.style.padding = "10px";
                todayBtn.style.cursor = "pointer";
                todayBtn.style.borderTop = "1px solid #e2e8f0";
                todayBtn.style.fontSize = "12px";
                todayBtn.style.fontWeight = "bold";
                todayBtn.style.color = "#14b8a6";
                
                todayBtn.addEventListener("click", () => {
                    instance.setDate(new Date());
                    instance.close();
                });
                
                instance.calendarContainer.appendChild(todayBtn);
                
                // Adjust for dark mode border
                if (document.documentElement.classList.contains('dark')) {
                    todayBtn.style.borderTopColor = "#334155";
                }
            }
        });

        // Flatpickr Time
        flatpickr(".timepicker", {
            enableTime: true,
            noCalendar: true,
            dateFormat: "H:i",
            time_24hr: true,
            allowInput: true
        });

        // Live Search Dashboard
        const searchInput = document.getElementById('dashboard-search-input');
        const announcementList = document.getElementById('announcement-list');
        let debounceTimer;

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const query = this.value;
                const filterForm = document.getElementById('filter-form');
                const location = filterForm.querySelector('input[name="location"]').value;
                const date = filterForm.querySelector('input[name="date"]').value;
                const month = filterForm.querySelector('select[name="month"]').value;

                debounceTimer = setTimeout(() => {
                    fetchAnnouncements(query, location, date, month);
                }, 300);
            });
        }

        // Also add listeners to filters for live updates
        document.querySelectorAll('#filter-form input, #filter-form select').forEach(el => {
            el.addEventListener('change', () => {
                const query = searchInput.value;
                const filterForm = document.getElementById('filter-form');
                const location = filterForm.querySelector('input[name="location"]').value;
                const date = filterForm.querySelector('input[name="date"]').value;
                const month = filterForm.querySelector('select[name="month"]').value;
                fetchAnnouncements(query, location, date, month);
            });
        });

        async function fetchAnnouncements(query, location, date, month) {
            announcementList.style.opacity = '0.5';
            const url = new URL('{{ route('dashboard') }}', window.location.origin);
            if(query) url.searchParams.set('search', query);
            if(location) url.searchParams.set('location', location);
            if(date) url.searchParams.set('date', date);
            if(month && month !== 'all') url.searchParams.set('month', month);

            try {
                const response = await fetch(url, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const html = await response.text();
                announcementList.innerHTML = html;
            } catch (error) {
                console.error('Error:', error);
            } finally {
                announcementList.style.opacity = '1';
            }
        }

        // Recent Search Logic
        const recentDropdown = document.getElementById('recent-searches');
        const recentList = document.getElementById('recent-list');

        function getRecentSearches() {
            return JSON.parse(localStorage.getItem('dashboard_recent_searches') || '[]');
        }

        function saveSearch(query) {
            if (!query || !query.trim()) return;
            let searches = getRecentSearches();
            searches = searches.filter(s => s !== query);
            searches.unshift(query);
            searches = searches.slice(0, 5);
            localStorage.setItem('dashboard_recent_searches', JSON.stringify(searches));
        }

        function renderRecentSearches() {
            const searches = getRecentSearches();
            if (searches.length === 0) {
                recentDropdown.classList.add('hidden');
                return;
            }

            recentList.innerHTML = searches.map(s => `
                <button type="button" onclick="setSearch('${s}')" class="w-full px-4 py-2.5 text-left text-sm text-gray-600 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-slate-700 flex items-center gap-3 transition-colors">
                    <i class="fas fa-history text-gray-400 text-xs"></i>
                    <span class="truncate">${s}</span>
                </button>
            `).join('');
        }

        window.setSearch = function(query) {
            searchInput.value = query;
            fetchAnnouncements(query, '', '', 'all');
            recentDropdown.classList.add('hidden');
        }

        window.clearRecentSearches = function() {
            localStorage.removeItem('dashboard_recent_searches');
            recentDropdown.classList.add('hidden');
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

            searchInput.addEventListener('keypress', (e) => {
                if (e.key === 'Enter') {
                    saveSearch(searchInput.value);
                }
            });
        }
    });
</script>
@endpush