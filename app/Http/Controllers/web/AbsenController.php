<?php

namespace App\Http\Controllers\web;

use App\Absen;
use App\Kelas;
use App\Siswa;
use App\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AbsenController extends Controller
{
    public function __construct(){
        $this->middleware('isAdminWeb')->except('index'); 
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bulan = array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
        $absen = Absen::orderBy('siswa_id', 'asc')->get();
        $kelas = Kelas::all();
        $thAjaran = TahunAjaran::all();
        $tahun = Absen::distinct()->get(['time']);

        foreach($absen as $a){
            $a->siswa = Siswa::where('id',$a->siswa_id)->first();
            $a->kelas = Kelas::where('id',$a->siswa->kelas_id)->first();
            $a->thAjaran = TahunAjaran::find($a->siswa->th_ajaran_id)->first();
        }

        return view('absen', compact(['absen', 'kelas', 'thAjaran', 'bulan', 'tahun']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Absen  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Absen::find($id);
        if($data == ''){
            return response()->json(['status' => 0,'msg' => 'Delete Failed']);
        }else{
            $data->delete();
            return response()->json(['status' => 1,'msg' => 'Data berhasil dihapus'], 201);
        }
    }
}
