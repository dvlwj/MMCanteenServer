<?php

namespace App\Http\Controllers\web;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PetugasController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'isAdminWeb'])->except('update'); 
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $petugas = User::all();
        return view('petugas', compact('petugas'));
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
            'role' => 'required'
        ]);

        $username = $request->input('username');
        $role = $request->input('role');
        
        $user = new User([
            'username' => $username,
            'password' => bcrypt("password"),
            'role' => $role
        ]);

        //Check User
        if (User::where('username', $username)->first()){
            return response()->json([
                'status' => 0,
                'msg' => 'Username is already taken'
            ]);
        } 

        if ($user->save()) {
            $response = [
                'status' => 1,
                'msg' => 'Petugas created',
                'user' => $user,
            ];

            return response()->json($response, 201);
        }
        
        $response = [
            'status' => 2,
            'msg' => 'An Error occured'
        ];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($petuga)
    {
        $data = User::find($petuga);
        if($data == '') {
            return response()->json(['status' => 0,'msg' => 'Data not found']);
        }else{
            return response()->json($data, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $petuga)
    {   
        $reset = $request->input('reset');

        if($reset == true){
            $user = User::find($petuga);
            $user->password = bcrypt("password");

            if($user->update()){
                return response()->json($user, 201);
            }else{
                return response()->json(['status' => 0,'msg' => 'Update Failed']);
            }
        }

        $role = $request->input('role');

        if($role != ''){
            $user = User::find($petuga);

            if($role == 'admin'){
                $user->role = 'petugas';
            }else{
                $user->role = 'admin';
            }

            if($user->update()){
                return response()->json($user, 201);
            }else{
                return response()->json(['status' => 0,'msg' => 'Update Failed']);
            }
        }

        $username = $request->input('username');

        if($username != ''){
            $user = User::find($petuga);

            if($username == $user->username){
                $user->username = $user->username;
            }else{
                $user->username = $username;
            }

            if($user->update()){
                return response()->json($user, 201);
            }else{
                return response()->json(['status' => 0,'msg' => 'Update Failed']);
            }
        }

        $password = $request->input('password');

        if($password != ''){
            $user = User::find($petuga);

            if($password == $user->password){
                $user->password = $user->password;
            }else{
                $user->password = bcrypt($password);
            }

            if($user->update()){
                return response()->json($user, 201);
            }else{
                return response()->json(['status' => 0,'msg' => 'Update Failed']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($petuga)
    {
        $user = User::find($petuga);
        if($user == ''){
            return response()->json(['status' => 0,'msg' => 'Delete Failed']);
        }else{
            $user->delete();
            return response()->json(['status' => 1,'msg' => 'Data berhasil dihapus'], 201);
        }
    }
}
