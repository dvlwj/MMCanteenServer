<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use JWTAuth;

class PetugasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['jwt.auth', 'isAdmin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $users = User::all();
        foreach($users as $user) {
            $user->detail_user = [
                'link' => 'api/v1/petugas/' . $user->id,
                'method' => 'GET'
            ];
        }

        $response = [
            'msg' => 'List of user',
            'users' => $users
        ];

        return response()->json($response, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|min:5',
            'password' => 'required|min:6',
            'role' => 'required|nullable'
        ]);

        $name = $request->input('name');
        $password = $request->input('password');
        $role = $request->input('role');
        
        $user = new User([
            'name' => $name,
            'password' => bcrypt($password),
            'role' => $role
        ]);

        //JWT Auth Credentials
        $credentials = [
            'name' => $name,
            'password' => $password
        ];

        //Check User
        if (User::where('name', $name)->first()){
            return response()->json([
                'msg' => 'Username is already taken'
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
                'link' => 'api/v1/signin',
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        if($user == '') {
            return response()->json(['msg' => 'User not found'], 200);
        } else {
            $user->update = [
                'link' => 'api/v1/petugas/' . $user->id,
                'method' => 'PATCH'
            ];
        }

        $response = [
            'msg' => 'Detail petugas',
            'user' => $user
        ];

        return response()->json($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|min:5',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        $name = $request->input('name');
        $password = $request->input('password');
        $role = $request->input('role');
        
        $user = User::find($id);

        if($user == '') {
            return response()->json(['msg' => 'User not found'], 200);
        } else {
            $user->name = $name;
            $user->password = $password;
            $user->role = $role;
        }

        if(!$user->update()) {
            return response()->json([
                'msg' => 'Error during update'
            ], 404);
        }

        $response = [
            'msg' => 'User updated',
            'user' => $user
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if($user == '') {
            return response()->json(['msg' => 'Petugas not found'], 200);
        }

        if(!$user->delete()) {
            return response()->json([
                'msg' => 'Delete failed'
            ], 404);
        }

        $response = [
            'msg' => 'User deleted',
            'create' => [
                'link' => 'api/v1/petugas',
                'method' => 'POST',
                'params' => 'name, password, role'
            ]             
        ];

        return response()->json($response, 200);
    }
}
