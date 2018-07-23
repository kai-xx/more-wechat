<?php

namespace App\Http\Controllers\Api\Auth;


use App\Models\Manager;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthTestController extends BaseController
{
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * Create a new token.
     *
     * @param  \App\Models\Manager   $manager
     * @return string
     */
    protected function jwt(Manager $manager) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $manager->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60 // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }

    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     *
     * @param  \App\Models\Manager   $manager
     * @return mixed
     */
    public function authenticate(Manager $manager) {
        $this->validate($this->request, [
            'login_name'     => 'required',
            'password'  => 'required'
        ]);
//        dd(Hash::make($this->request->input(Manager::DB_FILED_PASSWORD)));
        // Find the user by email
        $manager = Manager::where('login_name', $this->request->input('login_name'))->first();
        if (!$manager) {
            // You wil probably have some sort of helpers or whatever
            // to make sure that you have the same response format for
            // differents kind of responses. But let's return the
            // below respose for now.
            return response()->json([
                'error' => 'Email does not exist.'
            ], 400);
        }

        // Verify the password and generate the token
        if (Hash::check($this->request->input('password'), $manager->password)) {
            return response()->json([
                'token' => $this->jwt($manager)
            ], 200);
        }

        // Bad Request response
        return response()->json([
            'error' => 'Email or password is wrong.'
        ], 400);
    }
}