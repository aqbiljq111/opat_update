@forelse($messages as $msg)
<article class="block bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-xl shadow-sm border border-blue-50 dark:border-slate-700 hover:border-teal-300 dark:hover:border-teal-500 transition-all group overflow-hidden">
    <a href="{{ route('chat.show', $msg->id) }}" class="p-5 flex gap-4">
        {{-- Vote Stats (Visual Only) --}}
        <aside class="hidden sm:flex flex-col items-center gap-1 text-gray-400 dark:text-gray-500" aria-label="Statistik">
            <i class="fas fa-chevron-up hover:text-blue-500"></i>
            <span class="text-xs font-bold">{{ rand(1, 99) }}</span>
            <i class="fas fa-chevron-down hover:text-teal-500"></i>
        </aside>

        <section class="flex-grow">
            {{-- Post Meta --}}
            <header class="flex items-center gap-2 mb-2 text-xs text-gray-500 dark:text-gray-400">
                <span class="font-semibold text-gray-900 dark:text-white">{{ $msg->sender->name }}</span>
                <span>•</span>
                <time datetime="{{ $msg->created_at }}">{{ $msg->created_at->diffForHumans(short: true) }}</time>
                
                @if($msg->sender->role == 'guru')
                <span class="px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full font-medium">Guru</span>
                @endif
            </header>

            {{-- Post Title --}}
            <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors mb-2">
                {{ $msg->title }}
            </h3>

            {{-- Post Preview --}}
            <p class="text-gray-600 dark:text-gray-400 text-sm line-clamp-2 mb-4">
                {{ $msg->message }}
            </p>

            {{-- Post Actions/Footer --}}
            <footer class="flex items-center gap-4 text-gray-500 dark:text-gray-400 text-xs font-semibold">
                <div class="flex items-center gap-1.5 hover:bg-gray-100 dark:hover:bg-slate-700 px-2 py-1 rounded transition-colors">
                    <i class="far fa-comment-alt"></i>
                    <span>{{ $msg->replies->count() }} Jawaban</span>
                </div>
                <div class="flex items-center gap-1.5 hover:bg-gray-100 dark:hover:bg-slate-700 px-2 py-1 rounded transition-colors">
                    <i class="fas fa-share"></i>
                    <span>Bagikan</span>
                </div>
            </footer>
        </section>
    </a>
</article>
@empty
<section class="bg-white dark:bg-slate-800 rounded-xl border dark:border-slate-700 p-12 text-center shadow-sm">
    <div class="w-16 h-16 bg-gray-100 dark:bg-slate-900 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
        <i class="fas fa-comments text-2xl"></i>
    </div>
    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Belum ada diskusi</h3>
    <p class="text-gray-500 dark:text-gray-400">Jadilah yang pertama untuk bertanya!</p>
</section>
@endforelse
