<?php
$prefixAdmin    = config('zvn.url.prefix_admin');

Route::group(['prefix' => $prefixAdmin, 'namespace' => 'Admin', 'middleware' => ['permission.admin']], function () {

// ============================== DASHBOARD ==============================
$prefix         = 'dashboard';
$controllerName = 'dashboard';
Route::group(['prefix' =>  $prefix], function () use ($controllerName) {
    $controller = ucfirst($controllerName)  . 'Controller@';
    Route::get('/',                             [ 'as' => $controllerName,                  'uses' => $controller . 'index' ]);
});

// ============================== SLIDER ==============================
$prefix         = 'slider';
$controllerName = 'slider';
Route::group(['prefix' =>  $prefix], function () use ($controllerName) {
    $controller = ucfirst($controllerName)  . 'Controller@';
    Route::get('/',                             [ 'as' => $controllerName,                  'uses' => $controller . 'index' ]);
    Route::get('form/{id?}',                    [ 'as' => $controllerName . '/form',        'uses' => $controller . 'form'])->where('id', '[0-9]+');
    Route::post('save',                         [ 'as' => $controllerName . '/save',        'uses' => $controller . 'save']);
    Route::get('delete/{id}',                   [ 'as' => $controllerName . '/delete',      'uses' => $controller . 'delete'])->where('id', '[0-9]+');
    Route::get('change-status-{status}/{id}',   [ 'as' => $controllerName . '/status',      'uses' => $controller . 'status'])->where('id', '[0-9]+');
    Route::get('ordering/{id_current?}/{id_change?}',   [ 'as' => $controllerName . '/ordering',    'uses' => $controller . 'ordering'])->where(['id_current' => '[0-9]+', 'id_change' => '[0-9]+']);
});

// ============================== ARTICLE ==============================
$prefix         = 'post';
$controllerName = 'post';
Route::group(['prefix' =>  $prefix], function () use($controllerName) {
    $controller = ucfirst($controllerName)  . 'Controller@';
    Route::get('/',                                 [ 'as' => $controllerName,                  'uses' => $controller . 'index' ]);
    Route::get('form/{id?}',                        [ 'as' => $controllerName . '/form',        'uses' => $controller . 'form'])->where('id', '[0-9]+');
    Route::post('save',                             [ 'as' => $controllerName . '/save',        'uses' => $controller . 'save']);
    Route::get('delete/{id}',                       [ 'as' => $controllerName . '/delete',      'uses' => $controller . 'delete'])->where('id', '[0-9]+');
    Route::get('change-status-{status}/{id}',       [ 'as' => $controllerName . '/status',      'uses' => $controller . 'status']);
    Route::get('attribute/{id}',                    [ 'as' => $controllerName . '/attribute',   'uses' => $controller . 'attribute']);
});

// ============================== USER ==============================
$prefix         = 'user';
$controllerName = 'user';
Route::group(['prefix' =>  $prefix], function () use($controllerName) {
    $controller = ucfirst($controllerName)  . 'Controller@';
    Route::get('/',                                 [ 'as' => $controllerName,                  'uses' => $controller . 'index' ]);
    Route::get('form/{id?}',                        [ 'as' => $controllerName . '/form',        'uses' => $controller . 'form'])->where('id', '[0-9]+');
    Route::post('save',                             [ 'as' => $controllerName . '/save',        'uses' => $controller . 'save']);
    Route::get('change-password',                   [ 'as' => $controllerName . '/change-password',          'uses' => $controller . 'changePassword']);
    Route::post('post-change-password',             [ 'as' => $controllerName . '/post-change-password',    'uses' => $controller . 'postChangePassword']);
    Route::post('change-level',                     [ 'as' => $controllerName . '/change-level',            'uses' => $controller . 'changeLevel']);
    Route::get('delete/{id}',                       [ 'as' => $controllerName . '/delete',      'uses' => $controller . 'delete'])->where('id', '[0-9]+');
    Route::get('change-status-{status}/{id}',       [ 'as' => $controllerName . '/status',      'uses' => $controller . 'status']);
    Route::get('change-level-{level}/{id}',         [ 'as' => $controllerName . '/level',       'uses' => $controller . 'level']);
    Route::get('attribute/{id}',                    [ 'as' => $controllerName . '/attribute',   'uses' => $controller . 'attribute']);
});

// ============================== EMAIL BCC ==============================
$prefix         = 'emailBcc';
$controllerName = 'emailBcc';
Route::group(['prefix' =>  $prefix], function () use ($controllerName) {
    $controller = ucfirst($controllerName)  . 'Controller@';
    Route::get('/',                                 [ 'as' => $controllerName,                  'uses' => $controller . 'index' ]);
    Route::get('form/{id?}',                        [ 'as' => $controllerName . '/form',        'uses' => $controller . 'form'])->where('id', '[0-9]+');
    Route::post('save',                             [ 'as' => $controllerName . '/save',        'uses' => $controller . 'save']);
    Route::get('delete/{id}',                       [ 'as' => $controllerName . '/delete',      'uses' => $controller . 'delete'])->where('id', '[0-9]+');
    Route::get('change-status-{status}/{id}',       [ 'as' => $controllerName . '/status',      'uses' => $controller . 'status'])->where('id', '[0-9]+');
    Route::get('bcc-contact-{status}/{id}',         [ 'as' => $controllerName . '/bccContact',  'uses' => $controller . 'bccContact'])->where('id', '[0-9]+');
    Route::get('bcc-order-{status}/{id}',           [ 'as' => $controllerName . '/bccOrder',    'uses' => $controller . 'bccOrder'])->where('id', '[0-9]+');
    Route::get('attribute/{id}',                    [ 'as' => $controllerName . '/attribute',   'uses' => $controller . 'attribute']);
});

// ============================== EMAIL TEMPLATE ==============================
$prefix         = 'emailTemplate';
$controllerName = 'emailTemplate';
Route::group(['prefix' =>  $prefix], function () use($controllerName) {
    $controller = ucfirst($controllerName)  . 'Controller@';
    Route::get('/',                                 [ 'as' => $controllerName,                  'uses' => $controller . 'index' ]);
    Route::get('form/{id?}',                        [ 'as' => $controllerName . '/form',        'uses' => $controller . 'form'])->where('id', '[0-9]+');
    Route::post('save',                             [ 'as' => $controllerName . '/save',        'uses' => $controller . 'save']);
    Route::get('delete/{id}',                       [ 'as' => $controllerName . '/delete',      'uses' => $controller . 'delete'])->where('id', '[0-9]+');
    Route::get('change-status-{status}/{id}',       [ 'as' => $controllerName . '/status',      'uses' => $controller . 'status']);
    Route::get('attribute/{id}',                    [ 'as' => $controllerName . '/attribute',   'uses' => $controller . 'attribute']);
});

// ============================== EMAIL SUBSCRIBE ==============================
$prefix         = 'emailSubscribe';
$controllerName = 'emailSubscribe';
Route::group(['prefix' =>  $prefix], function () use ($controllerName) {
    $controller = ucfirst($controllerName)  . 'Controller@';
    Route::get('/',                                 [ 'as' => $controllerName,                  'uses' => $controller . 'index' ]);
    Route::get('form/{id?}',                        [ 'as' => $controllerName . '/form',        'uses' => $controller . 'form'])->where('id', '[0-9]+');
    Route::post('save',                             [ 'as' => $controllerName . '/save',        'uses' => $controller . 'save']);
    Route::get('delete/{id}',                       [ 'as' => $controllerName . '/delete',      'uses' => $controller . 'delete'])->where('id', '[0-9]+');
    Route::get('change-status-{status}/{id}',       [ 'as' => $controllerName . '/status',      'uses' => $controller . 'status'])->where('id', '[0-9]+');
});

// ============================== USB ==============================
$prefix         = 'usb';
$controllerName = 'usb';
Route::group(['prefix' =>  $prefix], function () use ($controllerName) {
    $controller = ucfirst($controllerName)  . 'Controller@';
    Route::get('/',                                 [ 'as' => $controllerName,                  'uses' => $controller . 'index' ]);
    Route::get('form/{id?}',                        [ 'as' => $controllerName . '/form',        'uses' => $controller . 'form'])->where('id', '[0-9]+');
    Route::post('save',                             [ 'as' => $controllerName . '/save',        'uses' => $controller . 'save']);
    Route::post('update',                           [ 'as' => $controllerName . '/update',      'uses' => $controller . 'update']);
    Route::get('delete/{id}',                       [ 'as' => $controllerName . '/delete',      'uses' => $controller . 'delete'])->where('id', '[0-9]+');
    Route::get('change-status-{status}/{id}',       [ 'as' => $controllerName . '/status',      'uses' => $controller . 'status'])->where('id', '[0-9]+');
    Route::get('attribute/{id}',                    [ 'as' => $controllerName . '/attribute',   'uses' => $controller . 'attribute']);
});

// ============================== STATUS ==============================
$prefix         = 'status';
$controllerName = 'status';
Route::group(['prefix' =>  $prefix], function () use ($controllerName) {
    $controller = ucfirst($controllerName)  . 'Controller@';
    Route::get('/',                                 [ 'as' => $controllerName,                  'uses' => $controller . 'index' ]);
    Route::get('form/{id?}',                        [ 'as' => $controllerName . '/form',        'uses' => $controller . 'form'])->where('id', '[0-9]+');
    Route::post('save',                             [ 'as' => $controllerName . '/save',        'uses' => $controller . 'save']);
    Route::post('update',                           [ 'as' => $controllerName . '/update',      'uses' => $controller . 'update']);
    Route::get('delete/{id}',                       [ 'as' => $controllerName . '/delete',      'uses' => $controller . 'delete'])->where('id', '[0-9]+');
    Route::get('change-status-{status}/{id}',       [ 'as' => $controllerName . '/status',      'uses' => $controller . 'status'])->where('id', '[0-9]+');
    Route::get('attribute/{id}',                    [ 'as' => $controllerName . '/attribute',   'uses' => $controller . 'attribute']);
});

// ============================== COMPANY ==============================
$prefix         = 'company';
$controllerName = 'company';
Route::group(['prefix' =>  $prefix], function () use ($controllerName) {
    $controller = ucfirst($controllerName)  . 'Controller@';
    Route::get('/',                                 [ 'as' => $controllerName,                  'uses' => $controller . 'index' ]);
    Route::get('/export',                           [ 'as' => $controllerName . '/export',      'uses' => $controller . 'export' ]);
    Route::get('form/{id?}',                        [ 'as' => $controllerName . '/form',        'uses' => $controller . 'form'])->where('id', '[0-9]+');
    Route::post('save',                             [ 'as' => $controllerName . '/save',        'uses' => $controller . 'save']);
    Route::post('update',                           [ 'as' => $controllerName . '/update',      'uses' => $controller . 'update']);
    Route::get('delete/{id}',                       [ 'as' => $controllerName . '/delete',      'uses' => $controller . 'delete'])->where('id', '[0-9]+');
    Route::get('change-status-{status}/{id}',       [ 'as' => $controllerName . '/status',      'uses' => $controller . 'status'])->where('id', '[0-9]+');
    Route::get('attribute/{id}',                    [ 'as' => $controllerName . '/attribute',   'uses' => $controller . 'attribute']);
});

// ============================== SUGGESTIONS ==============================
$prefix         = 'suggestions';
$controllerName = 'suggestions';
Route::group(['prefix' =>  $prefix], function () use ($controllerName) {
    $controller = ucfirst($controllerName)  . 'Controller@';
    Route::get('/',                                 [ 'as' => $controllerName,                  'uses' => $controller . 'index' ]);
    Route::get('form/{id?}',                        [ 'as' => $controllerName . '/form',        'uses' => $controller . 'form'])->where('id', '[0-9]+');
    Route::post('save',                             [ 'as' => $controllerName . '/save',        'uses' => $controller . 'save']);
    Route::post('update',                           [ 'as' => $controllerName . '/update',      'uses' => $controller . 'update']);
    Route::get('delete/{id}',                       [ 'as' => $controllerName . '/delete',      'uses' => $controller . 'delete'])->where('id', '[0-9]+');
    Route::get('change-status-{status}/{id}',       [ 'as' => $controllerName . '/status',      'uses' => $controller . 'status'])->where('id', '[0-9]+');
    Route::get('attribute/{id}',                    [ 'as' => $controllerName . '/attribute',   'uses' => $controller . 'attribute']);
});

// ============================== FILES ==============================
$prefix         = 'files';
$controllerName = 'files';
Route::group(['prefix' =>  $prefix], function () use ($controllerName) {
    $controller = ucfirst($controllerName)  . 'Controller@';
    Route::get('/',                                 [ 'as' => $controllerName,                  'uses' => $controller . 'index' ]);
    Route::get('form/{id?}',                        [ 'as' => $controllerName . '/form',        'uses' => $controller . 'form'])->where('id', '[0-9]+');
    Route::get('view/{id?}',                        [ 'as' => $controllerName . '/view',        'uses' => $controller . 'view'])->where('id', '[0-9]+');
    Route::get('view/multi',                        [ 'as' => $controllerName . '/multi',       'uses' => $controller . 'multi']);
    Route::get('view/add',                          [ 'as' => $controllerName . '/add',         'uses' => $controller . 'add']);
    Route::post('view/postAdd',                     [ 'as' => $controllerName . '/postAdd',     'uses' => $controller . 'postAdd']);
    Route::get('update',                            [ 'as' => $controllerName . '/update',      'uses' => $controller . 'update']);
    Route::get('export',                            [ 'as' => $controllerName . '/export',      'uses' => $controller . 'export']);
    Route::get('search',                            [ 'as' => $controllerName . '/search',      'uses' => $controller . 'search']);
    Route::get('mail',                              [ 'as' => $controllerName . '/mail',        'uses' => $controller . 'mail']);
    Route::get('company-mail',                      [ 'as' => $controllerName . '/companyEmail', 'uses' => $controller . 'companyEmail']);
    Route::post('save',                             [ 'as' => $controllerName . '/save',        'uses' => $controller . 'save']);
    Route::get('delete/{id}',                       [ 'as' => $controllerName . '/delete',      'uses' => $controller . 'delete'])->where('id', '[0-9]+');
    Route::get('change-status-{status}/{id}',       [ 'as' => $controllerName . '/status',      'uses' => $controller . 'status'])->where('id', '[0-9]+');
    Route::get('attribute/{id}',                    [ 'as' => $controllerName . '/attribute',   'uses' => $controller . 'attribute']);
});

// ============================== CATE NEWS ==============================
$prefix         = 'cateNews';
$controllerName = 'cateNews';
Route::group(['prefix' => $prefix], function () use ($controllerName) {
    $controller = ucfirst($controllerName)  . 'Controller@';
    Route::get('/',                                 [ 'as' => $controllerName,                  'uses' => $controller . 'index' ]);
    Route::get('form/{id?}',                        [ 'as' => $controllerName . '/form',        'uses' => $controller . 'form'])->where('id', '[0-9]+');
    Route::post('save',                             [ 'as' => $controllerName . '/save',        'uses' => $controller . 'save']);
    Route::get('delete/{id}',                       [ 'as' => $controllerName . '/delete',      'uses' => $controller . 'delete'])->where('id', '[0-9]+');
    Route::get('change-status-{status}/{id}',       [ 'as' => $controllerName . '/status',      'uses' => $controller . 'status'])->where('id', '[0-9]+');
    Route::get('ordering-{type?}/{id?}',            [ 'as' => $controllerName . '/ordering',    'uses' => $controller . 'ordering'])->where('id', '[0-9]+');
});

// ============================== SETTING ==============================
$prefix = 'settings';
$control = ucfirst($prefix) . 'Controller@';
Route::group(['prefix' => $prefix], function () use ($prefix, $control) {
    Route::get('/', ['as' => $prefix . '/form', 'uses' => $control . 'form']);
    Route::post('/save', ['as' => $prefix . '/save', 'uses' => $control . 'save']);
});

// ============================== FILES ==============================
$prefix         = 'files';
$controllerName = 'files';
Route::group(['prefix' =>  $prefix], function () use ($controllerName) {
    $controller = ucfirst($controllerName)  . 'Controller@';
    Route::get('/',                                 [ 'as' => $controllerName,                  'uses' => $controller . 'index' ]);
});
});