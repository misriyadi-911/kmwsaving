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

$router->group(['prefix' => 'users/'], function() use($router) {
    $router->get('/', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'UserAccountController@index']);
    $router->post('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'UserAccountController@store']);
    $router->get('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'UserAccountController@show']);
    $router->post('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'UserAccountController@update']);
    $router->delete('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'UserAccountController@destroy']);
});

// $router->group(['prefix' => 'users/admin'], function () use($router) {
//     $router->get('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@index']);
// });
//Table Admin
function resourceAdmin($router,$uri,$controller){
    $router->get($uri,$controller.'@index');
    $router->post($uri,$controller.'@store');
    $router->get($uri.'/{id}',$controller.'@show');
    $router->put($uri.'/{id}',$controller.'@update');
    $router->patch($uri.'/{id}',$controller.'@update');
    $router->delete($uri.'/{id}',$controller.'@destroy');
    // $router->get($uri.'/dashboard', $controller.'@dashboard');
}
resourceAdmin($router,'user/admin','AdminController');

$router->group(['prefix' => 'admin'], function () use ($router) {
    $router->get('/dashboard', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@dashboard']);
    $router->get('/tabungan', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@data_tabungan']);
    $router->get('/tabungan/{id}', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@detail_tabungan']);
    $router->post('/tabungan/{id}', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'AdminController@setor_tabungan']);
});

function veirifikasi($router,$uri,$controller){
    $router->get($uri, $controller.'@data_verifikasi');
    $router->get($uri. '/gambar/{id}', $controller.'@lihat_gambar');
    $router->put($uri.'/{id}', $controller.'@ganti_verifikasi');
}
veirifikasi($router,'admin/verifikasi','AdminController');

function pemberangkatan($router,$uri,$controller){
    $router->get($uri, $controller.'@data_pemberangkatan');
    $router->post($uri. '/input/{id}', $controller.'@input_pemberangkatan');
}
pemberangkatan($router,'admin/pemberangkatan','AdminController');

function resourceSaving($router,$uri,$controller){
    $router->get($uri,$controller.'@index');
    $router->post($uri,$controller.'@store');
    $router->get($uri.'/{id}',$controller.'@show');
    $router->put($uri.'/{id}',$controller.'@update');

    $router->patch($uri.'/{id}',$controller.'@update');
    $router->delete($uri.'/{id}',$controller.'@destroy');
}
resourceAdmin($router, 'user/admin', 'AdminController');

$router->group(['prefix' => 'saving-categories'], function () use ($router) {
    $router->get('/', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'SavingCategoriesController@index']);
    $router->post('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'SavingCategoriesController@store']);
    $router->get('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'SavingCategoriesController@show']);
    $router->put('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'SavingCategoriesController@update']);
    $router->delete('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'SavingCategoriesController@destroy']);
});

$router->group(['prefix' => 'pilgrims'], function () use ($router) {
    $router->get('/', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'PilgrimsController@index']);
    $router->post('/', ['middleware' => 'auth:' . Roles::$ADMIN, 'uses' => 'PilgrimsController@store']);
    $router->get('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'PilgrimsController@show']);
    $router->put('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'PilgrimsController@update']);
    $router->delete('/{id}', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'PilgrimsController@destroy']);
});


function resourceTransactional($router, $uri, $controller)
{
    $router->get($uri, $controller . '@index');
    $router->post($uri, $controller . '@store');
    $router->get($uri . '/{id}', $controller . '@show');
    $router->put($uri . '/{id}', $controller . '@update');

    $router->patch($uri . '/{id}', $controller . '@update');
    $router->delete($uri . '/{id}', $controller . '@destroy');
}
resourceTransactional($router, 'transaction', 'TransactionalSavingsController');

function resourceDeparture($router, $uri, $controller)
{
    $router->get($uri, $controller . '@index');
    $router->post($uri, $controller . '@store');
    $router->get($uri . '/{id}', $controller . '@show');
    $router->put($uri . '/{id}', $controller . '@update');

    $router->patch($uri . '/{id}', $controller . '@update');
    $router->delete($uri . '/{id}', $controller . '@destroy');
}
resourceDeparture($router, 'departureinfo', 'DepartureInformationsController');

function resourceSaldo($router, $uri, $controller)
{
    $router->get($uri, $controller . '@index');
    $router->post($uri, $controller . '@store');
    $router->get($uri . '/{id}', $controller . '@show');
    $router->put($uri . '/{id}', $controller . '@update');

    $router->patch($uri . '/{id}', $controller . '@update');
    $router->delete($uri . '/{id}', $controller . '@destroy');
}
resourceSaldo($router, 'saldo', 'SaldoController');


$router->group(['prefix' => 'files'], function () use ($router) {
    $router->get('/', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'FilesController@index']);
    $router->post('/', ['middleware' => 'auth:' . implode(' ', Roles::$ALL), 'uses' => 'FilesController@store']);
});

function resourceInfo($router, $uri, $controller)
{
    $router->get($uri, $controller . '@index');
    $router->post($uri, $controller . '@store');
    $router->get($uri . '/{id}', $controller . '@show');
    $router->put($uri . '/{id}', $controller . '@update');

    $router->patch($uri . '/{id}', $controller . '@update');
    $router->delete($uri . '/{id}', $controller . '@destroy');
}
resourceInfo($router, 'informations', 'InformationsController');

function resourceGalleries($router, $uri, $controller)
{
    $router->get($uri, $controller . '@index');
    $router->post($uri, $controller . '@store');
    $router->get($uri . '/{id}', $controller . '@show');
    $router->put($uri . '/{id}', $controller . '@update');

    $router->patch($uri . '/{id}', $controller . '@update');
    $router->delete($uri . '/{id}', $controller . '@destroy');
}
resourceGalleries($router, 'galleries', 'GalleriesController');
