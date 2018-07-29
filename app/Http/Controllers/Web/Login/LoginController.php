<?php

namespace App\Http\Controllers\Web\Login;


use App\Http\Controllers\Web\Base\BaseController;

class LoginController extends BaseController
{
    //

    public function login()
    {
        return view('login');
    }

    public function register(){
        return view('register');
    }
    public function loginOut()
    {
        
    }
}
