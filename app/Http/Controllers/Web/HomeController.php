<?php

namespace App\Http\Controllers\Web;


use App\Http\Controllers\Api\Base\BaseController;

class HomeController extends BaseController
{
    //

    public function home()
    {
        return view('index');
    }
}
