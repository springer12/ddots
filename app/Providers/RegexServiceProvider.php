<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class RegexServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('english_alpha_dash', function($attribute, $value){
            return preg_match('/^[A-z_-]$/', $value);
        });

        Validator::extend('any_lang_name', function($attribute, $value){
            return preg_match('/^[\pL- ]+$/u', $value);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
