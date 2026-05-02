<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat admin pertama
        User::updateOrCreate(
            ['username' => 'admin_utama'], // Cari berdasarkan username ini
            [
                'password' => Hash::make('rahasia123'), // Password default
                'role' => 'admin'
            ]
        );
    }
}
