<?php

namespace App\Http\Controllers\web;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PetugasController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'isAdminWeb']); 
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

        //Check User
        if (User::where('username', $username)->first()){
            return response()->json([
                'msg' => 'Username is already taken'
            ]);
        } 

        if ($user->save()) {
            $response = [
                'msg' => 'Petugas created',
                'user' => $user,
            ];

            return response()->json($response, 201);
        }
        
        $response = [
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
            return response()->json(['msg' => 'Data not found']);
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
        $user = User::find($petuga);
        if($request->password == '') {
            $user->password = $user->password;
        }else{
            $user->password = bcrypt($request->password);
        }

        if(User::where('username', $request->username)->first()) {
            return response()->json([
                'msg' => 'Username is already taken'
            ]);
        }

        $user->username = $request->username;
        $user->role = $request->role;

        if($user->update()){
            return response()->json($user, 201);
        }else{
            return response()->json(['msg' => 'Update Failed']);
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
            return response()->json(['msg' => 'Delete Failed']);
        }else{
            $user->delete();
            return response()->json(['msg' => 'Data berhasil dihapus'], 201);
        }
    }
}
