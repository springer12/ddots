<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        config([
            'services.facebook.redirect' => url(config('services.facebook.redirect')),
            'services.google.redirect' => url(config('services.google.redirect')),
            'services.vkontakte.redirect' => url(config('services.vkontakte.redirect')),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
