<?php

namespace App\Http\Controllers\web;

use App\Absen;
use App\Kelas;
use App\Siswa;
use App\TahunAjaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function __construct()
    {
    	$this->middleware('isAdminWeb');
    }

    public function index($nis, $bl = 0, $th = 0)
    {
    	$siswa = Siswa::where('nis', $nis)->first();
    	$kelas = Kelas::find($siswa->kelas_id)->first();
    	$tahun = DB::select(DB::raw("SELECT DISTINCT YEAR(time) AS tahun FROM absens WHERE siswa_id = '".$siswa->id."' "));
    	$thAjaran = TahunAjaran::find($siswa->th_ajaran_id)->first();
    	$bulan = array('January','February','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
    	
    	if($bl == 0 || $th == 0)
    	{
	    	$report = [];
	    	$harga = [];
            $periode = '-------';
	    	$total = 0;
    	}else{
    		$report = Absen::where('siswa_id',$siswa->id)->where('keterangan', 'makan')->whereMonth('time',$bl)->whereYear('time',$th)->get();
            $porsi_pagi = 'h_pagi_b';
            $porsi_siang = 'h_siang_b';
            if($siswa->porsi_pagi == 1) {
                $porsi_pagi = 'h_pagi_j';
            }

            if($siswa->porsi_siang == 1) {
                $porsi_siang = 'h_siang_j';
            }

	    	$harga = DB::select(DB::raw("SELECT h.".$porsi_pagi." AS h_pagi, h.".$porsi_siang." AS h_siang
			    		FROM siswas AS s, kelas AS k, hargas as h
			    		WHERE s.kelas_id = k.id AND h.id = k.harga_id AND s.nis = '".$siswa->nis."'"));
	    	$periode = $bulan[$bl-1]." ".$th;
	    	$total = count($report);
    	}

    	return view('report', compact(['report','periode','harga','total','bulan','tahun','siswa','kelas','thAjaran']));
    }
}
