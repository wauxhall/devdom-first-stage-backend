<?php

namespace App\Providers;

use App\Services\StudyMaterialCategoryService;
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
        $studyMaterialService = new StudyMaterialService($studyMaterialLinkService);
        $studyMaterialCategoryService = new StudyMaterialCategoryService($studyMaterialService);

        $this->app->singleton('App\Services\Contracts\StudyMaterialLinkLogicInterface', function ($app) use($studyMaterialLinkService) {
            return $studyMaterialLinkService;
        });

        $this->app->singleton('App\Services\Contracts\StudyMaterialLogicInterface', function ($app) use($studyMaterialService) {
            return $studyMaterialService;
        });

        $this->app->singleton('App\Services\Contracts\StudyMaterialCategoryLogicInterface', function ($app) use($studyMaterialCategoryService) {
            return $studyMaterialCategoryService;
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
