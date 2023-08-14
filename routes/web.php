<?php

/** @var \Laravel\Lumen\Routing\Router $router */

use App\Utils\Roles;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// api/v1/


$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/login', 'AuthController@login');
    $router->delete('/logout', 'AuthController@logout');
    $router->post('/refresh', 'AuthController@refresh');
    $router->get('/me', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'AuthController@getMe']);
});

$router->group(['prefix' => 'users/'], function () use ($router) {
    $router->get('/', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'UserAccountController@index']);
    $router->post('/', 'UserAccountController@store');
    $router->get('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'UserAccountController@show']);
    $router->post('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'UserAccountController@update']);
    $router->delete('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'UserAccountController@destroy']);
});


$router->group(['prefix' => 'admin'], function () use ($router) {
    $router->get('/dashboard', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@dashboard']);
    $router->get('/tabungan', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@data_tabungan']);
    $router->get('/tabungan/{id}', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@detail_tabungan']);
    $router->post('/tabungan/{id}', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@setor_tabungan']);
    $router->put('/tabungan/tarik/{id}', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@editSetor']);
});


$router->group(['prefix' => 'admin/verifikasi'], function () use ($router) {
    $router->get('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@data_verifikasi']);
    $router->get('/gambar/{id}', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@lihat_gambar']);
    $router->put('/{id}', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@ganti_verifikasi']);
});

$router->group(['prefix' => 'admin/departure'], function () use ($router) {
    $router->get('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@data_pemberangkatan']);
    $router->put('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@input_pemberangkatan']);
});

$router->group(['prefix' => 'user/admin'], function () use ($router) {
    $router->get('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@index']);
    $router->post('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@store']);
    $router->get('/{id}', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@show']);
    $router->put('/{id}', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@update']);
    $router->delete('/{id}', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@destroy']);
});

$router->group(['prefix' => 'saving-categories'], function () use ($router) {
    $router->get('/', 'SavingCategoriesController@index');
    $router->post('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'SavingCategoriesController@store']);
    $router->get('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'SavingCategoriesController@show']);
    $router->put('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'SavingCategoriesController@update']);
    $router->delete('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'SavingCategoriesController@destroy']);
});

$router->group(['prefix' => 'pilgrims'], function () use ($router) {
    $router->get('/', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'PilgrimsController@index']);
    $router->post('/', 'PilgrimsController@store');
    $router->get('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'PilgrimsController@show']);
    $router->put('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'PilgrimsController@update']);
    $router->delete('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'PilgrimsController@destroy']);
});


$router->group(['prefix' => 'transactional-savings'], function () use ($router) {
    $router->get('/', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'TransactionalSavingsController@index']);
    $router->post('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'TransactionalSavingsController@store']);
    $router->get('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'TransactionalSavingsController@show']);
    $router->put('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'TransactionalSavingsController@update']);
    $router->delete('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'TransactionalSavingsController@destroy']);
});

$router->group(['prefix' => 'departure-info'], function () use ($router) {
    $router->get('/', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'DepartureInformationsController@index']);
    $router->post('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'DepartureInformationsController@store']);
    $router->get('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'DepartureInformationsController@show']);
    $router->put('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'DepartureInformationsController@update']);
    $router->delete('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'DepartureInformationsController@destroy']);
});

$router->group(['prefix' => 'saldo'], function () use ($router) {
    $router->get('/', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'SaldoController@index']);
    $router->post('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'SaldoController@store']);
    $router->get('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'SaldoController@show']);
    $router->put('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'SaldoController@update']);
    $router->delete('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'SaldoController@destroy']);
});


$router->group(['prefix' => 'files'], function () use ($router) {
    $router->get('/', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'FilesController@index']);
    $router->post('/', 'FilesController@store');
});

$router->group(['prefix' => 'informations'], function () use ($router) {
    $router->get('/', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'InformationsController@index']);
    $router->post('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'InformationsController@store']);
    $router->get('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'InformationsController@show']);
    $router->put('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'InformationsController@update']);
    $router->delete('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'InformationsController@destroy']);
});

$router->group(['prefix' => 'galleries'], function () use ($router) {
    $router->get('/', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'GalleriesController@index']);
    $router->post('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'GalleriesController@store']);
    $router->get('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'GalleriesController@show']);
    $router->put('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'GalleriesController@update']);
    $router->delete('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'GalleriesController@destroy']);
});

$router->group(['prefix' => 'report'], function () use ($router) {
    $router->get('/', 'ReportController@index');
    $router->get('/print', 'ReportController@print');
    $router->get('/export', 'ReportController@export');
});


$router->group(['prefix' => '/jamaah'], function () use ($router) {
    $router->get('/information/departure', ['middleware' => 'auth:' . Roles::$pilgrim, 'uses' => 'PilgrimsController@keberangkatan']);
    $router->get('/information', ['middleware' => 'auth:' . Roles::$pilgrim, 'uses' => 'PilgrimsController@dashboard']);
    $router->post('/information', ['middleware' => 'auth:' . Roles::$pilgrim, 'uses' => 'PilgrimsController@setor']);
    $router->get('/saldo', ['middleware' => 'auth:' . Roles::$pilgrim, 'uses' => 'PilgrimsController@saldo']);
});

$router->post('/setoran-awal/{id}', 'PilgrimsController@setoranAwal');

$router->group(['prefix' => '/notification'], function () use ($router) {
    $router->get('/', ['uses' => 'NotificationController@index']);
    $router->post('/', ['uses' => 'NotificationController@store']);
    $router->get('/{id}', ['uses' => 'NotificationController@show']);
    $router->get('/mynotification/{id}', ['uses' => 'NotificationController@showByUserAccount']);
});

$router->group(['prefix'=> 'chat'], function () use ($router) {
    $router->post('/test_pusher', 'ChatController@test_pusher');
});