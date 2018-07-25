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
    $router->post('/auth/login', 'Api\Auth\AuthController@login');
    $router->post('/authtest/login', 'Api\Login\AuthTestController@authenticate');

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->group(['prefix' => 'manager'], function () use ($router) {
            $router->get('index',"Api\Manager\ManagerController@index");
            $router->post('store',"Api\Manager\ManagerController@store");
            $router->put('update/{id}',"Api\Manager\ManagerController@update");
            $router->delete('delete/{id}',"Api\Manager\ManagerController@delete");
        });
    });
});

$router->group(['prefix' => "web/v1"], function () use ($router) {
    $router->get('home', 'Web\HomeController@home');
    $router->get('login', 'Web\Login\LoginController@login');
    $router->group(['prefix' => 'manager'], function () use ($router) {
        $router->get('index', 'Web\Manager\ManagerController@index');
        $router->get('store', 'Web\Manager\ManagerController@store');
        $router->get('update', 'Web\Manager\ManagerController@update');
    });
});



