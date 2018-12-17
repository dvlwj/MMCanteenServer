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
            'status' => 'success',
            'msg' => 'List of Petugas',
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
            'username' => 'required|min:5',
            'password' => 'required|min:6',
            'role' => 'required|nullable'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');
        $role = $request->input('role');
        
        $user = new User([
            'username' => $username,
            'password' => bcrypt($password),
            'role' => $role
        ]);

        //JWT Auth Credentials
        $credentials = [
            'username' => $username,
            'password' => $password
        ];

        //Check User
        if (User::where('username', $username)->first()){
            return response()->json([
                'status' => 'fail',
                'msg' => 'Username is already taken'
            ], 200);
        } 

        if ($user->save()) {
            // JWT Auth
            $token = null;
            try {
                if(!$token = JWTAuth::attempt($credentials)) {
                    return response()->json([
                        'status' => 'fail',
                        'msg' => 'Username or Password are incorrect',
                    ]);
                }
            } catch (JWTAuthException $e) {
                return response()->json([
                    'status' => 'fail',
                    'msg' => 'failed_to_create_token',
                ]);
            }

            $user->signin = [
                'link' => 'api/v1/signin',
                'method' => 'POST',
                'params' => 'username, password'
            ];

            $response = [
                'status' => 'success',
                'msg' => 'Petugas created',
                'user' => $user,
                'token' => $token
            ];

            return response()->json($response, 201);
        }
        
        $response = [
            'status' => 'fail',
            'msg' => 'An Error occured'
        ];

        return response()->json($response);
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
            return response()->json(['status' => 'fail','msg' => 'Petugas not found'], 200);
        } else {
            $user->update = [
                'link' => 'api/v1/petugas/' . $user->id,
                'method' => 'PATCH'
            ];
        }

        $response = [
            'status' => 'success',
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
            'username' => 'required|min:5',
            'password' => 'required|min:6',
            'role' => 'required'
        ]);

        $username = $request->input('username');
        $password = $request->input('password');
        $role = $request->input('role');
        
        $user = User::find($id);

        if($user == '') {
            return response()->json(['status' => 'fail','msg' => 'Petugas not found'], 200);
        } else {
            $user->username = $username;
            $user->password = $password;
            $user->role = $role;
        }

        if(!$user->update()) {
            return response()->json([
                'status' => 'fail',
                'msg' => 'Error during update'
            ]);
        }

        $response = [
            'status' => 'success',
            'msg' => 'Petugas updated',
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
            return response()->json(['status' => 'fail','msg' => 'Petugas not found'], 200);
        }

        if(!$user->delete()) {
            return response()->json([
                'status' => 'fail',
                'msg' => 'Delete failed'
            ]);
        }

        $response = [
            'status' => 'success',
            'msg' => 'Petugas deleted',
            'create' => [
                'link' => 'api/v1/petugas',
                'method' => 'POST',
                'params' => 'name, password, role'
            ]             
        ];

        return response()->json($response, 200);
    }
}
