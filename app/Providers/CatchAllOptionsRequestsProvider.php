<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/29
 * Time: 下午4:18
 */

namespace App\Providers;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class CatchAllOptionsRequestsProvider extends ServiceProvider {
    public function register()
    {
        $request = app('request');
        Log::info($request->getMethod());
        if ($request->isMethod('OPTIONS'))
        {
            app()->options($request->path(), function() {
                return response('', 200)
                    ->header('Access-Control-Allow-Origin', '*')
                    ->header('Access-Control-Allow-Methods','OPTIONS, GET, POST, PUT, DELETE')
                    ->header('Access-Control-Allow-Headers', 'Content-Type, Origin');
            });
        }


    }
}