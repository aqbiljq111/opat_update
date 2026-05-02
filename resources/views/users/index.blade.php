@extends('layouts.app')

@section('title', 'Manajemen User')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
    
    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-xl text-sm border border-green-200">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col lg:flex-row gap-8">
        {{-- Form Tambah User --}}
        <div class="w-full lg:w-1/3">
            <div class="bg-white/80 dark:bg-slate-800 backdrop-blur-sm rounded-2xl shadow-sm border border-blue-50 dark:border-slate-700 overflow-hidden mb-8 transition-colors duration-300">
                <div class="bg-gradient-to-r from-blue-600 to-teal-500 px-6 py-4 flex items-center gap-3">
                    <i class="fas fa-user-plus text-white"></i>
                    <h2 class="text-white font-bold text-lg">Tambah User Baru</h2>
                </div>
                <form action="{{ route('users.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                        <input type="email" name="email" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Username</label>
                        <input type="text" name="username" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Password</label>
                        <input type="password" name="password" required class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                    </div>
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
                        <select name="role" class="w-full px-4 py-2.5 bg-white dark:bg-slate-900 border border-blue-100 dark:border-slate-700 rounded-xl outline-none focus:ring-2 focus:ring-teal-500 dark:text-white">
                            <option value="siswa">Siswa</option>
                            <option value="guru">Guru</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-teal-500 hover:from-blue-700 hover:to-teal-600 text-white font-medium px-6 py-2.5 rounded-xl shadow-md transition-all">Simpan User</button>
                </form>
            </div>
        </div>

        {{-- Daftar User --}}
        <div class="w-full lg:w-2/3">
            <div class="bg-white/80 dark:bg-slate-800 backdrop-blur-sm rounded-2xl shadow-sm border border-blue-50 dark:border-slate-700 overflow-hidden transition-colors duration-300">
                <div class="px-6 py-4 border-b border-blue-50 dark:border-slate-700 bg-gradient-to-r from-blue-50 to-teal-50 dark:from-slate-700 dark:to-slate-700 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 dark:text-white">Daftar Semua User</h3>
                </div>
                <div class="p-6 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-slate-700">
                                <th class="pb-3 px-4 font-semibold text-gray-600 dark:text-gray-300">ID</th>
                                <th class="pb-3 px-4 font-semibold text-gray-600 dark:text-gray-300">Username</th>
                                <th class="pb-3 px-4 font-semibold text-gray-600 dark:text-gray-300">Role Saat Ini</th>
                                <th class="pb-3 px-4 font-semibold text-gray-600 dark:text-gray-300">Ubah Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr class="border-b border-gray-100 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                                <td class="py-3 px-4 text-gray-700 dark:text-gray-300">{{ $user->id }}</td>
                                <td class="py-3 px-4 text-gray-900 dark:text-white">{{ $user->username }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full inline-block
                                        @if($user->role == 'admin') bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400
                                        @elseif($user->role == 'guru') bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400
                                        @else bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($user->username != 'admin_utama') {{-- Mencegah ubah admin utama --}}
                                    <form action="{{ route('users.updateRole', $user->id) }}" method="POST" class="flex gap-2 items-center">
                                        @csrf
                                        @method('PUT')
                                        <select name="role" class="px-2 py-1.5 bg-white dark:bg-slate-900 border border-gray-300 dark:border-slate-600 rounded-lg text-sm text-gray-800 dark:text-white outline-none focus:ring-2 focus:ring-teal-500">
                                            <option value="siswa" {{ $user->role == 'siswa' ? 'selected' : '' }}>Siswa</option>
                                            <option value="guru" {{ $user->role == 'guru' ? 'selected' : '' }}>Guru</option>
                                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        </select>
                                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-teal-500 hover:from-blue-700 hover:to-teal-600 text-white px-3 py-1.5 rounded-lg text-sm transition-all shadow-sm">Update</button>
                                    </form>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Tidak dapat diubah</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
