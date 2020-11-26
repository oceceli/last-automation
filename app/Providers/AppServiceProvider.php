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
        $this->app->bind('Moves', \App\Common\StockMoves\Moves::class);
        $this->app->bind('Conversions', \App\Common\Units\Conversions::class);
        $this->app->bind('StockCalculations', \App\Common\StockMoves\StockCalculations::class);
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
