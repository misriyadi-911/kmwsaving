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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/login', 'AuthController@login');
    $router->delete('/logout', 'AuthController@logout');
    $router->post('/refresh', 'AuthController@refresh');
    $router->get('/me', ['middleware' => 'auth:' .implode(' ', Roles::$ALL), 'uses' => 'AuthController@getMe']);
});


//Table User Account
function resourceUsers($router,$uri,$controller){
    $router->get($uri,$controller.'@index');
    $router->post($uri,$controller.'@store');
    $router->get($uri.'/{id}',$controller.'@show');
    $router->put($uri.'/{id}',$controller.'@update');

    $router->patch($uri.'/{id}',$controller.'@update');
    $router->delete($uri.'/{id}',$controller.'@destroy');
}
resourceUsers($router,'users','UserAccountController');

//Table Admin
function resourceAdmin($router,$uri,$controller){
    $router->get($uri,$controller.'@index');
    $router->post($uri,$controller.'@store');
    $router->get($uri.'/{id}',$controller.'@show');
    $router->put($uri.'/{id}',$controller.'@update');

    $router->patch($uri.'/{id}',$controller.'@update');
    $router->delete($uri.'/{id}',$controller.'@destroy');
}
resourceAdmin($router,'user/admin','AdminController');

function resourceSaving($router,$uri,$controller){
    $router->get($uri,$controller.'@index');
    $router->post($uri,$controller.'@store');
    $router->get($uri.'/{id}',$controller.'@show');
    $router->put($uri.'/{id}',$controller.'@update');

    $router->patch($uri.'/{id}',$controller.'@update');
    $router->delete($uri.'/{id}',$controller.'@destroy');
}
resourceSaving($router,'saving','SavingCategoriesController');

function resourcePilgrims($router,$uri,$controller){
    $router->get($uri,$controller.'@index');
    $router->post($uri,$controller.'@store');
    $router->get($uri.'/{id}',$controller.'@show');
    $router->put($uri.'/{id}',$controller.'@update');

    $router->patch($uri.'/{id}',$controller.'@update');
    $router->delete($uri.'/{id}',$controller.'@destroy');
}
resourcePilgrims($router,'pilgrims','PilgrimsController');

function resourceTransactional($router,$uri,$controller){
    $router->get($uri,$controller.'@index');
    $router->post($uri,$controller.'@store');
    $router->get($uri.'/{id}',$controller.'@show');
    $router->put($uri.'/{id}',$controller.'@update');

    $router->patch($uri.'/{id}',$controller.'@update');
    $router->delete($uri.'/{id}',$controller.'@destroy');
}
resourceTransactional($router,'transaction','TransactionalSavingsController');

function resourceDeparture($router,$uri,$controller){
    $router->get($uri,$controller.'@index');
    $router->post($uri,$controller.'@store');
    $router->get($uri.'/{id}',$controller.'@show');
    $router->put($uri.'/{id}',$controller.'@update');

    $router->patch($uri.'/{id}',$controller.'@update');
    $router->delete($uri.'/{id}',$controller.'@destroy');
}
resourceDeparture($router,'departureinfo','DepartureInformationsController');

function resourceSaldo($router,$uri,$controller){
    $router->get($uri,$controller.'@index');
    $router->post($uri,$controller.'@store');
    $router->get($uri.'/{id}',$controller.'@show');
    $router->put($uri.'/{id}',$controller.'@update');

    $router->patch($uri.'/{id}',$controller.'@update');
    $router->delete($uri.'/{id}',$controller.'@destroy');
}
resourceSaldo($router,'saldo','SaldoController');

function resourceFiles($router,$uri,$controller){
    $router->get($uri,$controller.'@index');
    $router->post($uri,$controller.'@store');
    $router->get($uri.'/{id}',$controller.'@show');
    $router->put($uri.'/{id}',$controller.'@update');

    $router->patch($uri.'/{id}',$controller.'@update');
    $router->delete($uri.'/{id}',$controller.'@destroy');
}
resourceFiles($router,'files','FilesController');

function resourceInfo($router,$uri,$controller){
    $router->get($uri,$controller.'@index');
    $router->post($uri,$controller.'@store');
    $router->get($uri.'/{id}',$controller.'@show');
    $router->put($uri.'/{id}',$controller.'@update');

    $router->patch($uri.'/{id}',$controller.'@update');
    $router->delete($uri.'/{id}',$controller.'@destroy');
}
resourceInfo($router,'informations','InformationsController');

function resourceGalleries($router,$uri,$controller){
    $router->get($uri,$controller.'@index');
    $router->post($uri,$controller.'@store');
    $router->get($uri.'/{id}',$controller.'@show');
    $router->put($uri.'/{id}',$controller.'@update');

    $router->patch($uri.'/{id}',$controller.'@update');
    $router->delete($uri.'/{id}',$controller.'@destroy');
}
resourceGalleries($router,'galleries','GalleriesController');
