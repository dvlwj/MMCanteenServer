<?php

namespace App\Http\Controllers;

use App\Absen;
use App\Kelas;
use App\Siswa;
use App\TahunAjaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {	
    	$nis = $request->input('nis');
    	$bulan = $request->input('bulan');
    	$tahun = $request->input('tahun');

    	$siswa = Siswa::where('nis', $nis)->first();

    	if($siswa == ''){
    		$response = [
	    			'status' => 0,
	    			'msg' => 'Nis tidak ada!'
	    		];

    		return response()->json($response);
    	}else{
	    	$kelas = Kelas::find($siswa->kelas_id)->first();
	    	$thAjaran = TahunAjaran::find($siswa->th_ajaran_id)->first();
	    	$bl = array('January','February','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
	    	
	    	if($bulan == "" || $tahun == "")
	    	{
	    		$response = [
	    			'status' => 1,
	    			'msg' => 'Kosong',
	    			'report' => [],
			    	'harga' => [],
			    	'periode' => '-------',
			    	'total' => 0
	    		];

	    		return response()->json($response);
	    	}else{
	    		$report = Absen::where('siswa_id',$siswa->id)->where('keterangan', 'makan')->whereMonth('time',$bulan)->whereYear('time',$tahun)->get();
		    	$harga = DB::select(DB::raw("SELECT h.harga AS harga
				    		FROM siswas AS s, kelas AS k, hargas as h
				    		WHERE s.kelas_id = k.id AND h.id = k.harga_id AND s.nis = '".$siswa->nis."'"));
		    	foreach($report as $r)
	    		{
	    			$r->harga = $harga[0]->harga; 
	    		}
		    	$periode = $bl[$bulan-1]." ".$tahun;
		    	$total = count($report) * $harga[0]->harga;

		    	$response = [
	    			'status' => 1,
	    			'msg' => 'Data Report',
	    			'report' => $report,
			    	'periode' => $periode,
			    	'total' => $total
	    		];
	    		
	    		return response()->json($response);
	    	}
	    }

    }
}
