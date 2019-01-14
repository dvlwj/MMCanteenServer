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
    public function update(Request $request)
    {
        $user = JWTAuth::toUser($request->header('token'));
        $id = $user->id;

        $password = $request->input('password');
        
        if(strlen($password) < 6)
        {
            $response = [
                'status' => 1,
                'msg' => 'Password minimal 6 digit!'
            ];

            return response()->json($response, 200);
        } else {
            $user = User::find($id);

            if($user == '') {
                return response()->json(['status' => 0,'msg' => 'Petugas not found'], 200);
            } else {
                $user->password = bcrypt($password);
            }

            if(!$user->update()) {
                return response()->json([
                    'status' => 2,
                    'msg' => 'Error during update'
                ]);
            }

            $response = [
                'status' => 1,
                'msg' => 'Password updated',
                'user' => $user
            ];

            return response()->json($response, 200);
        }
    }
}
