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
        $this->middleware('auth'); 
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

        foreach($absen as $a){
            $a->siswa = Siswa::where('id',$a->siswa_id)->first();
            $a->kelas = Kelas::where('id',$a->siswa->kelas_id)->first();
            $a->thAjaran = TahunAjaran::find($a->siswa->th_ajaran_id)->first();
        }

        return view('absen', compact(['absen', 'kelas', 'thAjaran', 'bulan']));
    }
}
