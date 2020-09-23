<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        #automatic #addAfter
		$this->app->bind('App\Contracts\StockMoveContract', 'App\Repositories\StockMoveRepository');
		$this->app->bind('App\Contracts\ProductContract', 'App\Repositories\ProductRepository');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
