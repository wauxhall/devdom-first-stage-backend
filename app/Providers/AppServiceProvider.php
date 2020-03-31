<?php

namespace App\Providers;

use App\Services\StudyMaterialLinkService;
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
        $studyMaterialLinkService = new StudyMaterialLinkService();

        $this->app->singleton('App\Services\Contracts\StudyMaterialLinkLogicInterface', function ($app) use($studyMaterialLinkService) {
            return $studyMaterialLinkService;
        });

        $this->app->singleton('App\Services\Contracts\StudyMaterialLogicInterface', function ($app) use($studyMaterialLinkService) {
            return new StudyMaterialService($studyMaterialLinkService);
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
