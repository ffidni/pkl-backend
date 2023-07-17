<?php

namespace App\Providers;

use App\Services\EmailConfirmationService;
use App\Services\ForgotPasswordService;
use App\Services\JurnalService;
use App\Services\PklStepsService;
use App\Services\TempatPklService;
use App\Services\TempatPklSuggestionsService;
use App\Services\TugasService;
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
        $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
        $this->app->bind(TugasService::class, TugasService::class);
        $this->app->bind(JurnalService::class, JurnalService::class);
        $this->app->bind(TempatPklService::class, TempatPklService::class);
        $this->app->bind(PklStepsService::class, PklStepsService::class);
        $this->app->bind(TempatPklSuggestionsService::class, TempatPklSuggestionsService::class);
        $this->app->bind(ForgotPasswordServices::class, ForgotPasswordService::class);
        $this->app->bind(EmailConfirmationService::class, EmailConfirmationService::class);

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