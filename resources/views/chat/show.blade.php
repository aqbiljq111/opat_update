@extends('layouts.app')

@section('title', $message->title)

@section('content')
<main class="max-w-4xl mx-auto px-4 py-8">
    <!-- Back Button -->
    <a href="{{ route('chat') }}" class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 font-semibold mb-6 hover:text-teal-600 dark:hover:text-teal-400 transition-colors">
        <i class="fas fa-arrow-left"></i> Kembali ke Forum
    </a>

    <!-- Original Post (Student Question) -->
    <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm rounded-xl shadow-sm border border-blue-50 dark:border-slate-700 p-6 mb-8">
        <div class="flex items-center gap-2 mb-4 text-xs text-gray-500 dark:text-gray-400">
            <div class="w-6 h-6 rounded-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center">
                <i class="fas fa-user text-[10px]"></i>
            </div>
            <span class="font-bold text-gray-900 dark:text-white">{{ $message->sender->name }}</span>
            <span>•</span>
            <span>{{ $message->created_at->diffForHumans() }}</span>
        </div>
        <div id="content-{{ $message->id }}">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">{{ $message->title }}</h1>
            <div class="text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap mb-6">
                {{ $message->message }}
            </div>
        </div>

        @if(Auth::id() == $message->sender_id)
        <div id="edit-form-{{ $message->id }}" class="hidden mb-6">
            <form action="{{ route('chat.update', $message->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="text" name="title" value="{{ $message->title }}" required class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-lg outline-none focus:ring-2 focus:ring-teal-500 mb-2 font-bold dark:text-white">
                <textarea name="message" required rows="5" class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-lg outline-none focus:ring-2 focus:ring-teal-500 mb-2 dark:text-white">{{ $message->message }}</textarea>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('edit-form-{{ $message->id }}').classList.add('hidden'); document.getElementById('content-{{ $message->id }}').classList.remove('hidden')" class="px-3 py-1.5 text-gray-500 text-sm hover:bg-gray-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-1.5 bg-gradient-to-r from-teal-500 to-blue-600 text-white font-semibold rounded-lg text-sm hover:from-teal-600 hover:to-blue-700">Simpan Perubahan</button>
                </div>
            </form>
        </div>
        @endif
        
        <div class="flex items-center gap-4 pt-4 border-t border-gray-100 dark:border-slate-700">
            <button onclick="document.getElementById('reply-form-{{ $message->id }}').classList.toggle('hidden')" class="flex items-center gap-2 text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-slate-700 px-3 py-1.5 rounded-lg text-sm font-semibold transition-colors">
                <i class="far fa-comment-alt"></i>
                Jawab
            </button>

            @if(Auth::id() == $message->sender_id)
            <button onclick="document.getElementById('edit-form-{{ $message->id }}').classList.remove('hidden'); document.getElementById('content-{{ $message->id }}').classList.add('hidden')" class="flex items-center gap-2 text-teal-600 hover:bg-teal-50 px-3 py-1.5 rounded-lg text-sm font-semibold transition-colors">
                <i class="far fa-edit"></i>
                Edit
            </button>
            @endif

            @if(Auth::user()->role == 'admin' || Auth::user()->role == 'guru' || Auth::id() == $message->sender_id)
            <form action="{{ route('chat.destroy', $message->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pertanyaan ini beserta seluruh balasannya?');" class="ml-auto">
                @csrf
                @method('DELETE')
                <button type="submit" class="flex items-center gap-2 text-red-500 hover:bg-red-50 px-3 py-1.5 rounded-lg text-sm font-semibold transition-colors">
                    <i class="far fa-trash-alt"></i>
                    Hapus
                </button>
            </form>
            @endif
        </div>

        <!-- Reply Form for the Main Thread -->
        <div id="reply-form-{{ $message->id }}" class="hidden mt-4 pt-4 border-t border-dashed dark:border-slate-700">
            @if(Auth::user()->role == 'guru' || Auth::user()->role == 'admin')
            <form action="{{ route('chat.reply', $message->id) }}" method="POST">
                @csrf
                <textarea name="message" required rows="3" placeholder="Tulis jawaban Anda..." class="w-full px-4 py-2 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-lg outline-none focus:ring-2 focus:ring-teal-500 mb-2 dark:text-white"></textarea>
                <div class="flex justify-end gap-2">
                    <button type="button" onclick="document.getElementById('reply-form-{{ $message->id }}').classList.add('hidden')" class="px-3 py-1.5 text-gray-500 text-sm hover:bg-gray-100 rounded-lg">Batal</button>
                    <button type="submit" class="px-4 py-1.5 bg-gradient-to-r from-blue-600 to-teal-500 text-white font-semibold rounded-lg text-sm hover:from-blue-700 hover:to-teal-600">Kirim Jawaban</button>
                </div>
            </form>
            @else
            <div class="p-3 bg-yellow-50 text-yellow-700 text-sm rounded-lg border border-yellow-100">
                <i class="fas fa-info-circle mr-1"></i> Hanya guru yang dapat memberikan jawaban pertama pada pertanyaan.
            </div>
            @endif
        </div>
    </div>

    <!-- Replies / Comments Section -->
    <div class="space-y-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">
            <i class="far fa-comments mr-2"></i> {{ $message->nestedReplies->count() }} Jawaban
        </h2>

        @foreach($message->nestedReplies as $reply)
            @include('chat.partials.reply', ['reply' => $reply, 'level' => 1])
        @endforeach
    </div>
</main>
@endsection
