<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use JWTAuthException;
use App\User;

class AuthController extends Controller
{
    public function __construct(){
        $this->middleware('cors'); 
    }

    /**
     * signin a user
     */
    public function signin (Request $request) {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        if ($user = User::where('username', $username)->first()) {
            //JWT Auth Credentials
            $credentials = [
                'username' => $username,
                'password' => $password
            ];

            $token = null;
            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        'status' => 0,
                        'msg' => 'Username or Password are incorrect',
                    ]);
                }
            } catch (JWTAuthException $e) {
                return response()->json([
                    'status' => 0,
                    'msg' => 'failed_to_create_token',
                ]);
            }

            $response = [
                'status' => 1,
                'msg' => 'User signin',
                'user' => $user,
                'token' => $token
            ];
            return response()->json($response, 200);
        }

        $response = [
            'status' => 2,
            'msg' => 'An error occured'
        ];

        return response()->json($response);
    }
}
