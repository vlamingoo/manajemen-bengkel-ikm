<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Custom Blade Directive untuk cek role
        Blade::if('role', function (...$roles) {
            return in_array(auth()->user()->role ?? '', $roles);
        });

        // Define Gates untuk AdminLTE menu
        Gate::define('admin', function ($user) {
            return $user->role === 'admin';
        });

        Gate::define('karyawan', function ($user) {
            return $user->role === 'karyawan';
        });

        Gate::define('owner', function ($user) {
            return $user->role === 'owner';
        });

        Gate::define('admin|karyawan', function ($user) {
            return in_array($user->role, ['admin', 'karyawan']);
        });

        Gate::define('owner|admin', function ($user) {
            return in_array($user->role, ['owner', 'admin']);
        });
    }
}