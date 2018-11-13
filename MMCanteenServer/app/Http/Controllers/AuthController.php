<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use JWTAuthException;
use App\User;

class AuthController extends Controller
{
    public function store(Request $request) {
        $this->validate($request, [
            'name' => 'required|min:5',
            'password' => 'required|min:6'
        ]);

        $name = $request->input('name');
        $password = $request->input('password');
        
        $user = new User([
            'name' => $name,
            'password' => bcrypt($password)
        ]);

        //JWT Auth Credentials
        $credentials = [
            'name' => $name,
            'password' => $password
        ];

        //Check User
        if (User::where('name', $name)->first()){
            return response()->json([
                'msg' => 'Username is arleady taken'
            ], 200);
        } 

        if ($user->save()) {
            // JWT Auth
            $token = null;
            try {
                if(!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        'msg' => 'Username or Password are incorrect',
                    ], 404);
                }
            } catch (JWTAuthException $e) {
                return response()->json([
                    'msg' => 'failed_to_create_token',
                ], 404);
            }

            $user->signin = [
                'href' => 'api/v1/user/signin',
                'method' => 'POST',
                'params' => 'name, password'
            ];

            $response = [
                'msg' => 'User created',
                'user' => $user,
                'token' => $token
            ];

            return response()->json($response, 201);
        }
        
        $response = [
            'msg' => 'An Error occured'
        ];

        return response()->json($response, 404);
    }

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

        return $response->json($response, 404);
    }
}
