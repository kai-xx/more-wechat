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
$router->options("{path:.+}", function () {
    return response('', 200)
        ->header('Access-Control-Allow-Origin', '*')
        ->header('Access-Control-Allow-Methods','OPTIONS, GET, POST, PUT, DELETE')
        ->header('Access-Control-Allow-Headers', 'Content-Type, Origin');
});

$router->group(['prefix' => "api/v1"], function () use ($router) {
    $router->post('/auth/login', 'Api\Auth\AuthController@login');
    $router->post('/authtest/login', 'Api\Login\AuthTestController@authenticate');

    $router->group(['middleware' => 'auth'], function () use ($router) {
        $router->get('/auth/info', 'Api\Auth\AuthController@me');
        $router->post('/auth/logout', 'Api\Auth\AuthController@logout');

        $router->group(['prefix' => 'manager'], function () use ($router) {
            $router->get('index',"Api\Manager\ManagerController@index");
            $router->post('store',"Api\Manager\ManagerController@store");
            $router->put('update/{id}',"Api\Manager\ManagerController@update");
            $router->get('show/{id}',"Api\Manager\ManagerController@show");
            $router->delete('delete/{id}',"Api\Manager\ManagerController@delete");
        });
        $router->group(['prefix' => 'news'], function () use ($router) {
            $router->get('index',"Api\News\NewsController@index");
            $router->post('store',"Api\News\NewsController@store");
            $router->put('update/{id}',"Api\News\NewsController@update");
            $router->put('show/{id}',"Api\News\NewsController@show");
            $router->delete('delete/{id}',"Api\News\NewsController@delete");
        });
    });
});

$router->group(['prefix' => "web/v1"], function () use ($router) {
    $router->get('home', 'Web\HomeController@home');
    $router->get('login', 'Web\Login\LoginController@login');
    $router->get('register', 'Web\Login\LoginController@register');
    $router->group(['prefix' => 'manager'], function () use ($router) {
        $router->get('index', 'Web\Manager\ManagerController@index');
        $router->get('store', 'Web\Manager\ManagerController@store');
        $router->get('update', 'Web\Manager\ManagerController@update');
    });
});



