<?php
/**
 * Created by PhpStorm.
 * User: kare
 * Date: 2018/7/20
 * Time: 10:59
 */

namespace App\Http\Controllers\Login;


use App\Http\Controllers\Controller;
use App\Http\Endpoints\Manager\GetManagerByLogin;
use App\Manager;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $getManagerByLogin = new GetManagerByLogin($request);
        $manager = $getManagerByLogin->GetManagerByLogin();
        dd($manager);
        if ($manager instanceof Manager) {

        }
    }

    public function loginOut() {

    }
}