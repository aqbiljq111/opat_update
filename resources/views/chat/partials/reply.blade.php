<article class="flex gap-2 sm:gap-{{ max(2, 4 - $level) }} mt-4">
    {{-- Thread Line Indicator --}}
    <aside class="flex flex-col items-center">
        <div class="w-{{ max(6, 9 - $level) }} h-{{ max(6, 9 - $level) }} rounded-full {{ $reply->sender->role == 'guru' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400' : 'bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-400' }} flex items-center justify-center shrink-0">
            <i class="fas fa-{{ $reply->sender->role == 'guru' ? 'user-tie' : 'user' }} text-[{{ max(10, 14 - $level) }}px]"></i>
        </div>
        @if($reply->nestedReplies->count() > 0)
            <div class="w-0.5 grow bg-gray-100 dark:bg-slate-700 mt-2"></div>
        @endif
    </aside>

    <div class="grow pb-{{ max(2, 6 - $level) }}">
        {{-- Reply Card --}}
        <section class="bg-white dark:bg-slate-800 rounded-xl p-3 sm:p-{{ max(3, 5 - $level) }} border {{ $reply->sender->role == 'guru' ? 'border-blue-50 dark:border-blue-900/20' : 'border-gray-100 dark:border-slate-700' }} shadow-sm">
            <header class="flex items-center gap-2 mb-2 text-xs">
                <span class="font-bold text-gray-900 dark:text-white">{{ $reply->sender->name }}</span>
                @if($reply->sender->role == 'guru')
                    <span class="px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full font-medium text-[10px]">Guru</span>
                @endif
                <span class="text-gray-500 dark:text-gray-400">•</span>
                <time class="text-gray-500 dark:text-gray-400">{{ $reply->created_at->diffForHumans(short: true) }}</time>
            </header>

            <div class="text-gray-700 dark:text-gray-300 text-sm whitespace-pre-wrap mb-3">
                {{ $reply->message }}
            </div>

            {{-- Action Toolbar --}}
            <footer class="flex items-center gap-4">
                <button onclick="document.getElementById('reply-form-{{ $reply->id }}').classList.toggle('hidden')" 
                        class="text-xs font-bold text-gray-500 hover:text-blue-600 transition-colors">
                    <i class="fas fa-reply mr-1"></i> Balas
                </button>

                @if(Auth::user()->role == 'admin' || Auth::user()->role == 'guru' || Auth::id() == $reply->sender_id)
                <form action="{{ route('chat.destroy', $reply->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus balasan ini beserta balasannya (jika ada)?');" class="ml-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 transition-colors">
                        <i class="fas fa-trash-alt mr-1"></i> Hapus
                    </button>
                </form>
                @endif
            </footer>

            {{-- Nested Reply Form --}}
            <section id="reply-form-{{ $reply->id }}" class="hidden mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                <form action="{{ route('chat.reply', $reply->id) }}" method="POST">
                    @csrf
                    <textarea name="message" required rows="2" placeholder="Tulis balasan Anda..." class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-lg outline-none focus:ring-2 focus:ring-teal-500 mb-2 text-sm dark:text-white"></textarea>
                    <div class="flex justify-end gap-2">
                        <button type="button" onclick="document.getElementById('reply-form-{{ $reply->id }}').classList.add('hidden')" class="px-3 py-1.5 text-gray-500 dark:text-gray-400 text-xs hover:bg-gray-100 dark:hover:bg-slate-700 rounded-lg">Batal</button>
                        <button type="submit" class="px-4 py-1.5 bg-gradient-to-r from-blue-600 to-teal-500 text-white font-semibold rounded-lg text-xs hover:from-blue-700 hover:to-teal-600">Kirim Balasan</button>
                    </div>
                </form>
            </section>
        </section>

        {{-- Recursive Nested Replies Container --}}
        @if($reply->nestedReplies->count() > 0)
        <section class="mt-3">
            <button onclick="document.getElementById('nested-replies-{{ $reply->id }}').classList.toggle('hidden'); this.querySelector('.toggle-text').innerText = document.getElementById('nested-replies-{{ $reply->id }}').classList.contains('hidden') ? 'Lihat {{ $reply->nestedReplies->count() }} Balasan' : 'Sembunyikan Balasan'; this.querySelector('.toggle-icon').classList.toggle('fa-chevron-down'); this.querySelector('.toggle-icon').classList.toggle('fa-chevron-up');" 
                    class="flex items-center gap-2 text-[10px] sm:text-xs font-bold text-blue-600 dark:text-blue-400 hover:text-blue-700 transition-colors">
                <i class="fas fa-chevron-down toggle-icon text-[8px] sm:text-[10px]"></i>
                <span class="toggle-text">Lihat {{ $reply->nestedReplies->count() }} Balasan</span>
            </button>
            <div id="nested-replies-{{ $reply->id }}" class="hidden space-y-2 mt-2">
                @foreach($reply->nestedReplies as $nestedReply)
                    @include('chat.partials.reply', ['reply' => $nestedReply, 'level' => min(4, $level + 1)])
                @endforeach
            </div>
        </section>
        @endif
    </div>
</article>
