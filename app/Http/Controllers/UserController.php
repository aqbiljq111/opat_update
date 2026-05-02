<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:user,email',
            'username' => 'required|unique:user,username',
            'password' => 'required|min:4',
            'role' => 'required|in:admin,guru,siswa'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);

        return back()->with('success', 'User berhasil ditambahkan!');
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:admin,guru,siswa'
        ]);

        // Mencegah admin mengubah dirinya sendiri menjadi role lain jika dia satu-satunya admin, 
        // tapi untuk sekarang kita ikuti logika sederhana
        $user->update(['role' => $request->role]);

        return back()->with('success', 'Role berhasil diperbarui!');
    }
}
