<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use JWTAuthException;
use App\User;

class AuthController extends Controller
{
    /**
     * signin a user
     */
    public function signin (Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'password' => 'required'
        ]);

        $name = $request->input('name');
        $password = $request->input('password');

        if ($user = User::where('name', $name)->first()) {
            //JWT Auth Credentials
            $credentials = [
                'name' => $name,
                'password' => $password
            ];

            $token = null;
            try {
                if (!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        'msg' => 'Username or Password are incorrect',
                    ], 404);
                }
            } catch (JWTAuthException $e) {
                return response()->json([
                    'msg' => 'failed_to_create_token',
                ], 404);
            }

            $response = [
                'msg' => 'User signin',
                'user' => $user,
                'token' => $token
            ];
            return response()->json($response, 201);
        }

        $response = [
            'msg' => 'An error occured'
        ];

        return response()->json($response, 404);
    }
}
