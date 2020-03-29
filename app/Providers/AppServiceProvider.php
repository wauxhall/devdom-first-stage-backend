<?php

namespace App\Providers;

use App\Services\StudyMaterialService;
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
        $this->app->singleton('App\Services\Contracts\StudyMaterialLogicInterface', function ($app) {
            return new StudyMaterialService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
