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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Builder::macro('orWhereLike', function ($attributes, string $searchTerms){
            $this->where(function (Builder $query) use ($attributes, $searchTerms) {
                foreach(Arr::wrap($attributes) as $attribute) {
                    $query->orWhere(function ($query) use ($attribute, $searchTerms) {
                        foreach(explode(' ', $searchTerms) as $searchTerm) {
                            $query->where($attribute, 'LIKE', "%{$searchTerm}%");
                        }
                    });
                }
            });
            return $this;
        });
        
    }

}
