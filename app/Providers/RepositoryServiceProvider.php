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
		$this->app->bind('App\Contracts\UnitContract', 'App\Repositories\UnitRepository');
		$this->app->bind('App\Contracts\CategoryContract', 'App\Repositories\CategoryRepository');
		$this->app->bind('App\Contracts\WorkOrderContract', 'App\Repositories\WorkOrderRepository');
		$this->app->bind('App\Contracts\RecipeContract', 'App\Repositories\RecipeRepository');
		$this->app->bind('App\Contracts\RoleContract', 'App\Repositories\RoleRepository');
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
