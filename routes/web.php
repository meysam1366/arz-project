<?php

/** @var \Laravel\Lumen\Routing\Router $router */
use Illuminate\Support\Facades\Hash;

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
$router->get('/', function() {
    return Hash::make('12345678');
});
$router->get('api/v1/login','ApiController@authenticate');

$router->group(['prefix' => 'api/v1', 'middleware' => 'auth'], function() use($router) {
    $router->post('/deposit', 'ApiController@deposit');
    $router->post('/withdraw', 'ApiController@withdraw');
    $router->get('/showStock', 'ApiController@showStock');
    $router->post('/transactions', 'ApiController@transactionList');
});

