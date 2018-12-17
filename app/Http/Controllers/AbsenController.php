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
            'status' => 'success',
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

        $siswa = Siswa::where('nis', $nis)->first();
        $kelas = Kelas::where('id', $siswa->kelas_id)->first();
        $th_ajaran = TahunAjaran::where('id', $siswa->th_ajaran_id)->first();
        $time = date('Y-m-d H:i:s');
        
        $absen = new Absen([
            'user_id' => $user_id,
            'siswa_id' => $siswa->id,
            'kelas' => $kelas->name,
            'th_ajaran' => $th_ajaran->tahun,
            'time' => $time
        ]);

        if ($absen->save()) {
            $response = [
                'status' => 'success',
                'msg' => 'Absen siswa added',
                'absen' => $absen,
                'link' => 'api/v1/absen',
                'method' => 'GET',
                'params' => 'kelas, th_ajaran, bulan, tahun'
            ];

            return response()->json($response, 201);
        }

        $response = [
            'status' => 'fail',
            'msg' => 'An Error occured'
        ];

        return response()->json($response);
    }
}
