<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Absen;
use App\Siswa;
use App\Kelas;
use App\TahunAjaran;
use App\User;
use JWTAuth;
use Illuminate\Support\Facades\DB;

class AbsenController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt.auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listAbsen($kelas, $th_ajaran, $bulan, $tahun)
    {
        //kelas, th_ajaran, bulan, tahun
        $absens = DB::table('absens')
                    ->where('kelas', $kelas)
                    ->where('th_ajaran', $th_ajaran)
                    ->whereMonth('time', $bulan)
                    ->whereYear('time', $tahun)
                    ->get();
        foreach($absens as $absen) {
            $absen->data_siswa = DB::table('siswas')->select('id','nis', 'name')->where('id',$absen->siswa_id)->first();
            $absen->data_petugas = DB::table('users')->select('id', 'name')->where('id',$absen->user_id)->first();
        }

        $response = [
            'status' => 1,
            'msg' => 'List of Absen',
            'absens' => $absens
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
        $user = JWTAuth::toUser($request->header('token'));
        $user_id = $user->id;
        $nis = $request->input('nis');
        $status = $request->input('status');

        $siswa = Siswa::where('nis', $nis)->first();
        $time = date('Y-m-d');
        $ket = 'tidak makan';
        
        //Check Absen
        $absen = Absen::where('siswa_id',$siswa->id)->where('status',$status)->whereDate('time',$time)->first();

        if($absen != null){
            $response = [
                'status' => 0,
                'msg' => 'Siswa is already present',
            ];

            return response()->json($response);            
        }else{
            $absen = new Absen([
                'user_id' => $user_id,
                'siswa_id' => $siswa->id,
                'time' => $time,
                'status' => $status,
                'keterangan' => $ket
            ]);
        }

        if ($absen->save()) {
            $response = [
                'status' => 1,
                'msg' => 'Absen siswa added',
                'absen' => $absen,
                'link' => 'api/v1/absen',
                'method' => 'GET',
                'params' => 'kelas, th_ajaran, bulan, tahun'
            ];

            return response()->json($response, 201);
        }

        $response = [
            'status' => 2,
            'msg' => 'An Error occured'
        ];

        return response()->json($response);
    }
}
