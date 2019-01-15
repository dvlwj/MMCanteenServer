<?php

namespace App\Http\Controllers\web;

use App\Absen;
use App\Siswa;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ReportController extends Controller
{
    public function __construct()
    {
    	$this->middleware('isAdminWeb');
    }

    public function index($nis)
    {
    	$siswa = Siswa::select('id')->where('nis', $nis)->first();
    	$report = Absen::where('siswa_id',$siswa->id)->get();

    	return $report;
    }
}
