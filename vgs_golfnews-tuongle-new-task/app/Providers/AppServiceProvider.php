<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
//        if ($this->app->environment() !== 'real') {
//        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_ENV', 'production') == 'production') {
            URL::forceScheme('https');
        };
        
        \Carbon\Carbon::setLocale('vi');
        app('view')->composer('*', function ($view) {
            if (app('request')->route()) {
                $action = app('request')->route()->getAction();
                $controller = class_basename($action['controller']);
                list($controller, $action) = array_pad(explode('@', $controller), 2, null);
                $controller = ucwords(str_replace('Controller', '', $controller));
                $action = ucwords($action);
            } else {
                $controller = 'default';
                $action = 'default';
            }
            $cdnGolf = 'https://cdn.golfnews.vn/';
            $agent = new Agent();
            $view->with(compact('controller', 'action', 'cdnGolf', 'agent'));
        });
        
    }
}
