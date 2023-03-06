<?php

namespace App\Providers;

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
        if ($this->app->environment() !== 'real') {
            $this->app->register(\Way\Generators\GeneratorsServiceProvider::class);
            $this->app->register(\Xethron\MigrationsGenerator\MigrationsGeneratorServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        app('view')->composer('*', function ($view) {
            if (app('request')->route()) {
                $action = app('request')->route()->getAction();
                $controller = class_basename($action['controller']);
                list($controller, $action) = explode('@', $controller);
                $controller = ucwords(str_replace('Controller', '', $controller));
                $action = ucwords($action);
            } else {
                $controller = 'default';
                $action = 'default';
            }
            $view->with(compact('controller', 'action'));
        });
    }
}
