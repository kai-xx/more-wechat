<?php
header('Access-Control-Allow-Origin: *');
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

    $router->post('upload','Api\Upload\UploadController@upload');
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
            $router->get('show/{id}',"Api\News\NewsController@show");
            $router->delete('delete/{id}',"Api\News\NewsController@delete");
        });
        $router->group(['prefix' => 'wechat'], function () use ($router) {
            $router->get('index',"Api\Wechat\WechatController@index");
            $router->post('store',"Api\Wechat\WechatController@store");
            $router->put('update/{id}',"Api\Wechat\WechatController@update");
            $router->get('show/{id}',"Api\Wechat\WechatController@show");
            $router->delete('delete/{id}',"Api\Wechat\WechatController@delete");
        });
        $router->group(['prefix' => 'message'], function () use ($router) {
            $router->get('index',"Api\Message\MessageController@index");
            $router->post('store',"Api\Message\MessageController@store");
            $router->put('update/{id}',"Api\Message\MessageController@update");
            $router->get('show/{id}',"Api\Message\MessageController@show");
            $router->delete('delete/{id}',"Api\Message\MessageController@delete");
        });

        $router->group(['prefix' => 'fans'], function () use ($router) {
            $router->get('index',"Api\Fans\FansController@index");
        });
        $router->group(['prefix' => 'wechatApi'], function () use ($router) {
            $router->post('updateFans',"Api\WechatApi\WechatApiController@updateFans");
            $router->post('updateTags',"Api\WechatApi\WechatApiController@updateTags");
            $router->post('sendMessage',"Api\WechatApi\WechatApiController@sendMessage");
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



