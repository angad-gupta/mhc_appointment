<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use function foo\func;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Blade::if('superAdmin', function () {
            return auth()->user()->id == 1;
        });

        Blade::if('admin', function () {
            return auth()->check() && auth()->user()->role == 1;
        });

        Blade::if('doctor', function () {
            return auth()->check() && auth()->user()->role == 2;
        });

        Blade::if('assistant', function () {
            return auth()->check() && auth()->user()->role == 4;
        });

        Blade::if('patient', function () {
            return auth('extra_user')->check();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (config('app.env') == 'production') {
            $this->app->bind('path.public', function () {
                return base_path();
            });
        }

    }
}
