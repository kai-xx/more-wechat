<?php
/**
 * Created by PhpStorm.
 * User: carter
 * Date: 2018/7/22
 * Time: 下午12:31
 */

namespace App\Http\Controllers\Api\Auth;


use App\Http\Controllers\Controller;
use App\Http\Endpoints\Base\BaseEndpoint;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseEndpoint
{

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('login_name', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            return $this->respondWithToken($token);
        }
        return $this->resultForApi(400,[],'登录失败');
//        return response()->json([ 'error' => 'Unauthorized'], 200);
    }

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $info = $this->guard()->user();
        $info['code'] = 200;
        $info['roles'] = [$info->{Manager::DB_FILED_NAME}];
        app('log')->info("返回数据为："  , $info->toArray(), compact('time'));
        return $this->resultForApi(200, $info);
//        return response()->json($info, 200);

    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->guard()->logout();
        return $this->resultForApi(200, ['message' => '登出成功！'], "登出成功");

//        return response()->json([
//            'message' => '登出成功！',
//            'code' => '200',
//        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());;
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        app('log')->info("返回数据为："  , [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ], compact('time'));
        return $this->resultForApi(200,[
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
//        return response()->json([
//            'code' => 200,
//            'token' => $token,
//            'token_type' => 'bearer',
//            'expires_in' => $this->guard()->factory()->getTTL() * 60
//        ],200);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard();
    }
}