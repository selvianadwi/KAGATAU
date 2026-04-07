<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator; // <--- WAJIB TAMBAHKAN BARIS INI

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Panggil fungsi ini agar pagination rapi menggunakan style Bootstrap 5
        Paginator::useBootstrapFive(); 
        // Paginator::useTailwind();
    }
}