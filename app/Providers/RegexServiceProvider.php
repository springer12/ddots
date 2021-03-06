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
            return preg_match('/^[0-9A-z_-]+$/', $value);
        });

        Validator::extend('any_lang_name', function($attribute, $value){
            return preg_match('/^[\pL-\' ]+$/u', $value);
        });

        Validator::extend('alpha_dash_spaces', function($attribute, $value){
            return preg_match('/^[\pL0-9- ]+$/u', $value);
        });

        Validator::extend('url_domain', function($attribute, $value, $parameters){
            $parsedUrl = parse_url($value);
            if($parsedUrl && isset($parsedUrl['host'])) {
                return in_array($parsedUrl['host'], $parameters);
            } else {
                return false;
            }

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
