<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Siswa;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    public function __construct()
    {
        $this->middleware(['jwt.auth', 'isAdmin'])->except('listSiswa');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listSiswa($kelas_id, $th_ajaran_id)
    {
        //kelas, th_ajaran
        $siswa = DB::table('siswas')->where('kelas_id', $kelas_id)->where('th_ajaran_id', $th_ajaran_id)->get();
        foreach($siswa as $data) {
            $data->detail_siswa = [
                'link' => 'api/v1/siswa/' . $data->id,
                'method' => 'GET'
            ];   
        }

        $response = [
            'msg' => 'List of Siswa',
            'siswa' => $siswa,
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
            'nis' => 'required', 
            'name' => 'required', 
            'kelas_id' => 'required', 
            'th_ajaran_id' => 'required'
        ]);

        $nis = $request->input('nis');
        $name = $request->input('name');
        $kelas_id = $request->input('kelas_id');
        $th_ajaran_id = $request->input('th_ajaran_id');

        $siswa = new Siswa([
            'nis' => $nis,
            'name' => $name,
            'kelas_id' => $kelas_id,
            'th_ajaran_id' => $th_ajaran_id
        ]);

        // Check NIS
        if (Siswa::where('nis', $nis)->first()) {
            $response = [
                'msg' => 'NIS is already exist',
            ];

            return response()->json($response, 404);
        }

        if ($siswa->save()) {
            $response = [
                'msg' => 'Siswa created',
                'siswa' => $siswa,
                'link' => 'api/v1/siswa',
                'method' => 'GET'
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
        $siswa = Siswa::find($id);
        if ($siswa == '') {
            return response()->json(['msg' => 'Siswa not found'], 404);
        } else {
            $siswa->update = [
                'link' => 'api/v1/siswa/' . $siswa->id,
                'method' => 'PATCH'
            ];
        }

        $response = [
            'msg' => 'Detail siswa',
            'siswa' => $siswa
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
            'nis' => 'required', 
            'name' => 'required', 
            'kelas_id' => 'required', 
            'th_ajaran_id' => 'required'
        ]);

        $nis = $request->input('nis');
        $name = $request->input('name');
        $kelas_id = $request->input('kelas_id');
        $th_ajaran_id = $request->input('th_ajaran_id');

        $siswa = Siswa::find($id);
        if ($siswa == '') {
            return response()->json(['msg' => 'Siswa not found'], 404);
        } else {
            $siswa->nis = $nis;
            $siswa->name = $name;
            $siswa->kelas_id = $kelas_id;
            $siswa->th_ajaran_id = $th_ajaran_id;
        }

        if(!$siswa->update()) {
            return response()->json([
                'msg' => 'Error during update'
            ], 404);
        }

        $response = [
            'msg' => 'Siswa updated',
            'siswa' => $siswa
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
        $siswa = Siswa::find($id);

        if ($siswa == '') {
            return response()->json(['msg' => 'Siswa not found'], 404);
        }

        if(!$siswa->delete()) {
            return response()->json([
                'msg' => 'Delete failed'
            ], 404);
        }

        $response = [
            'msg' => 'Siswa deleted',
            'create' => [
                'link' => 'api/v1/siswa',
                'method' => 'POST',
                'params' => 'nis, name, kelas_id, th_ajaran_id'
            ]             
        ];

        return response()->json($response, 200);
    }
}
