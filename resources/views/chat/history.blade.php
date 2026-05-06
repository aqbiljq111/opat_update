@extends('layouts.app')

@section('title', 'Riwayat Forum')

@section('content')
<main class="max-w-6xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Audit Log Forum</h1>
            <p class="text-gray-600 dark:text-gray-400">Pantau seluruh aktivitas pembuatan, perubahan, dan penghapusan pesan di forum.</p>
        </div>
        <a href="{{ route('chat') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg font-semibold hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors">
            <i class="fas fa-arrow-left"></i> Kembali ke Forum
        </a>
    </div>

    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50 dark:bg-slate-900/50 border-b dark:border-slate-700">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Waktu</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Aksi</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Pesan / Judul</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">ID Referensi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($logs as $log)
                    <tr class="hover:bg-gray-50/50 dark:hover:bg-slate-700/30 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                            {{ $log->created_at->format('d M Y, H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 text-xs">
                                    <i class="fas fa-user"></i>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $log->user->name }}</div>
                                    <div class="text-[10px] text-gray-500">{{ $log->user->email }}</div>
                                    <div class="text-[10px] text-teal-600 dark:text-teal-400 font-bold uppercase">{{ $log->user->role }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider
                                @if($log->action == 'created') bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400
                                @elseif($log->action == 'updated') bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400
                                @elseif($log->action == 'deleted') bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400
                                @else bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400 @endif">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($log->title)
                                <div class="text-sm font-bold text-gray-900 dark:text-white mb-1">Judul: {{ $log->title }}</div>
                            @endif
                            <div class="text-sm text-gray-600 dark:text-gray-400 whitespace-pre-wrap max-w-md">
                                {{ $log->message }}
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-xs text-gray-400">
                            <div>Msg ID: #{{ $log->message_id }}</div>
                            @if($log->parent_id)
                                <div class="mt-1">Ques ID: #{{ $log->parent_id }}</div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                            <i class="fas fa-history text-4xl mb-4 opacity-20"></i>
                            <p>Belum ada riwayat aktivitas.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
        <div class="px-6 py-4 border-t dark:border-slate-700">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</main>
@endsection
