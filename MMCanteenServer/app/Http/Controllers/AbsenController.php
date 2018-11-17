<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Absen;

class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'user_id' => 'required', 
            'siswa_id' => 'required', 
            'kelas' => 'required', 
            'th_ajaran' => 'required',
            'time' => 'required'
        ]);

        $user_id = $request->input('user_id');
        $siswa_id = $request->input('siswa_id');
        $kelas = $request->input('kelas');
        $th_ajaran = $request->input('th_ajaran');
        $time = $request->input('time');
        
        $absen = new Absen([
            'user_id' => $user_id,
            'siswa_id' => $siswa_id,
            'kelas' => $kelas,
            'th_ajaran' => $th_ajaran,
            'time' => $time
        ]);

        if ($absen->save()) {
            $response = [
                'msg' => 'Absen siswa added',
                'absen' => $absen,
                'link' => 'api/v1/absen',
                'method' => 'GET',
                'params' => 'kelas, th_ajaran, bulan, tahun'
            ];

            return response()->json($response, 201);
        }

        $response = [
            'msg' => 'An Error occured'
        ];

        return response()->json($response, 404);
    }
}
