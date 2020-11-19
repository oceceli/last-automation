<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
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
        // Localization Carbon çalışmıyor ???
        // \Carbon\Carbon::setLocale($this->app->getLocale());
        $this->app->bind('Stock', \App\Common\StockMoves\Stock::class);
        $this->app->bind('Conversions', \App\Common\Units\Conversions::class);
        $this->app->bind('Production', \App\Common\Production\Production::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

}
