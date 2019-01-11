<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use JWTAuth;

class PetugasController extends Controller
{
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
            return response()->json(['status' => 0,'msg' => 'Petugas not found'], 200);
        } else {
            $user->username = $username;
            $user->password = $password;
            $user->role = $role;
        }

        if(!$user->update()) {
            return response()->json([
                'status' => 2,
                'msg' => 'Error during update'
            ]);
        }

        $response = [
            'status' => 1,
            'msg' => 'Petugas updated',
            'user' => $user
        ];

        return response()->json($response, 200);
    }
}
