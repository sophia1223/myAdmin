<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $classname = '\App\Tools\Validator';
        $reflect = new \ReflectionClass($classname);
        $methods = $reflect->getMethods();
        foreach ($methods as $method)
        {
            Validator::extend($method->getName(), $classname.'@'.$method->getName());
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
