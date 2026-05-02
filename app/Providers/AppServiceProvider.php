<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate; // Import ini
use App\Models\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void { /* ... */ }

    public function boot(): void
    {
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('guru', function (User $user) {
            return $user->role === 'guru';
        });

        // Gate gabungan untuk yang bisa atur jadwal/pengumuman
        Gate::define('atur-pengumuman', function (User $user) {
            return in_array($user->role, ['admin', 'guru']);
        });
    }
}