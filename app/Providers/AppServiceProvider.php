<?php

namespace App\Providers;

use App\View\Components\Layout;
use App\View\Components\Home;
use App\View\Components\Order;
use App\View\Components\OrderTable;
use App\View\Components\ProductTable;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('home', Home::class);
        Blade::component('layout', Layout::class);
        Blade::component('order', Order::class);
        Blade::component('data-table', OrderTable::class);
        Blade::component('data-table', ProductTable::class);
    }
}
