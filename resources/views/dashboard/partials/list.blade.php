@foreach($announcements as $item)
<article class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-3xl shadow-premium border border-blue-50 dark:border-slate-700 p-6 fade-in relative overflow-hidden group transition-all duration-300">
    {{-- Decorative Side Bar --}}
    <div class="absolute top-0 left-0 w-1.5 h-full bg-gradient-to-b from-blue-500 to-teal-400"></div>
    
    <header class="flex justify-between items-start mb-4">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $item->title }}</h3>
        
        {{-- Administrative Actions --}}
        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'guru')
        <nav class="flex gap-2 opacity-0 group-hover:opacity-100 transition-opacity" aria-label="Opsi Pengumuman">
            <button onclick="document.getElementById('edit-form-{{ $item->id }}').classList.toggle('hidden')" 
                    class="w-8 h-8 rounded-lg bg-teal-50 text-teal-600 dark:bg-teal-900/20 dark:text-teal-400 hover:bg-teal-100 flex items-center justify-center transition-colors"
                    title="Edit Pengumuman">
                <i class="fas fa-edit text-sm"></i>
            </button>
            <form action="{{ route('announcement.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pengumuman ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="w-8 h-8 rounded-lg bg-red-50 text-red-600 dark:bg-red-900/20 dark:text-red-400 hover:bg-red-100 flex items-center justify-center transition-colors"
                        title="Hapus Pengumuman">
                    <i class="fas fa-trash text-sm"></i>
                </button>
            </form>
        </nav>
        @endif
    </header>

    {{-- Meta Information --}}
    <section class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-500 dark:text-gray-400 mb-5">
        <div class="flex items-center">
            <i class="fas fa-calendar mr-2 text-blue-500"></i>
            <time datetime="{{ $item->date }}">{{ $item->date }}</time> 
            @if($item->time) 
                <span class="mx-1">-</span> 
                <time>{{ \Carbon\Carbon::parse($item->time)->format('H:i') }}</time> 
            @endif
        </div>
        <div class="flex items-center">
            <i class="fas fa-map-marker-alt mr-2 text-teal-500"></i>
            <span>{{ $item->location }}</span>
        </div>
    </section>

    {{-- Content --}}
    @if($item->content)
    <section class="bg-gradient-to-r from-blue-50 to-teal-50 dark:from-slate-700 dark:to-slate-700 p-4 rounded-xl text-sm border border-blue-100/50 dark:border-slate-600 text-gray-700 dark:text-gray-200">
        {{ $item->content }}
    </section>
    @endif

    {{-- Hidden Edit Form --}}
    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'guru')
    <section id="edit-form-{{ $item->id }}" class="hidden mt-6 pt-6 border-t border-blue-50 dark:border-slate-700">
        <form action="{{ route('announcement.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <input type="text" name="title" value="{{ $item->title }}" required placeholder="Judul" class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                
                <select name="category" class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                    <option value="mingguan" {{ strtolower($item->category) == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                    <option value="bulanan" {{ strtolower($item->category) == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                    <option value="tahunan" {{ strtolower($item->category) == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
                </select>
                
                <input type="text" name="date" value="{{ $item->date }}" required placeholder="Pilih Tanggal" class="datepicker w-full px-4 py-2 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                <input type="text" name="location" value="{{ $item->location }}" required placeholder="Lokasi" class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                <input type="text" name="time" value="{{ \Carbon\Carbon::parse($item->time)->format('H:i') }}" required placeholder="Pilih Jam" class="timepicker w-full px-4 py-2 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
            </div>

            <textarea name="content" rows="3" placeholder="Isi Pengumuman (Opsional)" class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-xl outline-none mb-4 focus:ring-2 focus:ring-teal-500 dark:text-white">{{ $item->content }}</textarea>
            
            <footer class="flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('edit-form-{{ $item->id }}').classList.add('hidden')" class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg text-sm font-medium">Batal</button>
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-teal-500 hover:from-blue-700 hover:to-teal-600 text-white font-medium px-6 py-2 rounded-lg shadow-sm text-sm transition-all">Simpan Perubahan</button>
            </footer>
        </form>
    </section>
    @endif
</article>
@endforeach

@if($announcements->isEmpty())
<section class="bg-white dark:bg-slate-800 rounded-3xl shadow-premium border border-blue-100 dark:border-slate-700 p-12 text-center fade-in">
    <div class="w-16 h-16 bg-gray-100 dark:bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
        <i class="fas fa-bullhorn text-2xl"></i>
    </div>
    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Tidak ada pengumuman</h3>
    <p class="text-gray-500 dark:text-gray-400">Gunakan kata kunci atau filter lain untuk mencari.</p>
</section>
@endif
