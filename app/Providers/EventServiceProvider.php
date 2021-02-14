<?php

namespace App\Providers;


use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        \App\Models\Category::observe(\App\Observers\CategoryObserver::class);
        \App\Models\Company::observe(\App\Observers\CompanyObserver::class);
        \App\Models\DispatchExtra::observe(\App\Observers\DispatchExtraObserver::class);
        \App\Models\DispatchOrder::observe(\App\Observers\DispatchOrderObserver::class);
        \App\Models\DispatchProduct::observe(\App\Observers\DispatchProductObserver::class);
        \App\Models\Product::observe(\App\Observers\ProductObserver::class);
        \App\Models\Recipe::observe(\App\Observers\RecipeObserver::class);
        \App\Models\ReservedStock::observe(\App\Observers\ReservedStockObserver::class);
        \App\Models\SalesType::observe(\App\Observers\SalesTypeObserver::class);
        \App\Models\Setting::observe(\App\Observers\SettingObserver::class);
        \App\Models\StockMove::observe(\App\Observers\StockMoveObserver::class);
        \App\Models\Unit::observe(\App\Observers\UnitObserver::class);
        \App\Models\User::observe(\App\Observers\UserObserver::class);
        \App\Models\WorkOrder::observe(\App\Observers\WorkOrderObserver::class);
    }
}
