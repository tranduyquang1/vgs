<?php
$prefixFrontend = config('zvn.url.prefix_frontend');
Route::group(['prefix' => $prefixFrontend, 'namespace' => 'Frontend'], function () {

    // ====================== AUTH ========================
    $prefix         = '';
    $controllerName = 'auth';

    Route::group(['prefix' =>  $prefix], function () use ($controllerName) {
        $prefixLogin = config('zvn.url.prefix_login');
        $controller = ucfirst($controllerName)  . 'Controller@';
        Route::get('/'.$prefixLogin,     ['as' => $controllerName.'/login',     'uses' => $controller . 'login'])->middleware('check.login');;
        Route::post('/postLogin',   ['as' => $controllerName.'/postLogin',      'uses' => $controller . 'postLogin']);
        Route::get('/logout',       ['as' => $controllerName.'/logout',         'uses' => $controller . 'logout']);
    });

    // ============================== HOMEPAGE ==============================
    $prefix         = '';
    $controllerName = 'index';
    Route::group(['prefix' =>  $prefix], function () use ($controllerName) {
        $controller = ucfirst($controllerName)  . 'Controller@';
        Route::get('/',                                 [ 'as' => $controllerName,                                          'uses' => $controller . 'index' ]);
        Route::get('/page-not-found',                   [ 'as' => $controllerName.'/notfound',                              'uses' => $controller . 'notfound' ]);
        Route::get('/dang-ki-email-subscribe',          [ 'as' => $controllerName.'/emailSubscribe',                        'uses' => $controller . 'emailSubscribe']);
    });
});