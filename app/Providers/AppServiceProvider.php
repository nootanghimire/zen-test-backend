<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Interfaces\RoomsRepositoryInterface', 'App\Repositories\RoomsRepository');
        $this->app->bind('App\Repositories\Interfaces\RoomPricesRepositoryInterface', 'App\Repositories\RoomPricesRepository');
        $this->app->bind('App\Repositories\Interfaces\RoomInventoriesRepositoryInterface', 'App\Repositories\RoomInventoriesRepository');
    }
}
