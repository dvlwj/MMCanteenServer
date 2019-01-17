<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Siswa;
use App\TahunAjaran;
use App\Kelas;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
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
            'status' => 1,
            'msg' => 'List of Siswa',
            'siswa' => $siswa,
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
    public function update(Request $request, $nis)
    {

        $pagi = $request->input('pagi');
        $siang = $request->input('siang');

        $siswa = Siswa::where('nis', $nis)->first();
        if ($siswa == '') {
            return response()->json(['status' => 0,'msg' => 'Siswa not found']);
        } else {
            if($pagi != ''){
                $siswa->pagi = $pagi;
            } elseif($siang != '') {
                $siswa->siang = $siang;
            }
        }

        if(!$siswa->update()) {
            return response()->json([
                'status' => 2,
                'msg' => 'Error during update'
            ]);
        }

        $response = [
            'status' => 1,
            'msg' => 'Siswa updated',
            'siswa' => $siswa
        ];

        return response()->json($response, 200);
    }

    /**
     * List of Kelas.
     * 
     * @return \Illuminate\Http\Response
     */
    public function listKelas()
    {
        $kelas = Kelas::select('id','name')->get();

        $response = [
            'status' => 1,
            'msg' => 'List of Kelas',
            'kelas' => $kelas
        ];

        return response()->json($response, 200);
    }

    /**
     * List of Tahun Ajaran.
     * 
     * @return \Illuminate\Http\Response
     */
    public function listTahunAjaran()
    {
        $TahunAjaran = TahunAjaran::select('id','tahun')->get();

        $response = [
            'status' => 1,
            'msg' => 'List of Tahun Ajaran',
            'th_ajaran' => $TahunAjaran
        ];

        return response()->json($response, 200);
    }
}
