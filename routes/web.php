<?php
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
$router->group(['prefix' => "api/v1"], function () use ($router) {
    $router->post('/auth/login', 'Auth\AuthController@login');
    $router->post('/authtest/login', 'Login\AuthTestController@authenticate');

    $router->group(['middleware' => ['auth']], function () use ($router) {
        $router->group(['prefix' => 'manager'], function () use ($router) {
            $router->get('index',"Manager\ManagerController@index");
            $router->post('store',"Manager\ManagerController@store");
            $router->put('update/{id}',"Manager\ManagerController@update");
            $router->delete('delete/{id}',"Manager\ManagerController@delete");
        });
    });
});



