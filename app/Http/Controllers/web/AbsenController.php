<?php

namespace App\Http\Controllers\web;

use App\Absen;
use App\Kelas;
use App\Siswa;
use App\TahunAjaran;
use Illuminate\Support\Facades\DB;
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
        $absen = Absen::orderBy('time', 'desc')->get();
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

    public function makan()
    {
        $time = date('Y-m-d');
        $makan = DB::select(DB::raw("SELECT c.id, c.name, 'makan' AS keterangan, 
                    '2019-01-14' AS _date, 'pagi' as status, 
                    d.id AS must_be_null FROM siswas AS c LEFT JOIN 
                    (SELECT a.id, a.name, b.keterangan, b.time
                    FROM siswas AS a LEFT JOIN absens AS b
                    ON a.id = b.siswa_id
                    WHERE b.time = '2019-01-14'
                    AND b.status = 'pagi') AS d
                    ON d.id = c.id;"));

        return $makan;
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
