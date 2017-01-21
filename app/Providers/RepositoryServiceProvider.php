<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Repositories\Interface\RoomsRepositoryInterface', 'App\Repositories\RoomsRepository');
        $this->app->bind('App\Repositories\Interfaces\RoomPricesRepositoryInterface', 'App\Repositories\RoomPricesRepository');
        $this->app->bind('App\Repositories\Interfaces\RoomInventoriesRepositoryInterface', 'App\Repositories\RoomInventoriesRepository');
    }
}
