<?php

namespace App\Http\Controllers\web;

use App\User;
use App\Absen;
use App\Kelas;
use App\Siswa;
use App\TahunAjaran;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
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

    public function makan($status)
    {
        $time = date('Y-m-d');
        $makan = DB::select(DB::raw("SELECT c.id AS siswa_id, c.name AS siswa_name, 'makan' AS keterangan, 
                    '".$time."' AS _date, '".$status."' as status, 
                    d.id AS is_null 
                    FROM siswas AS c 
                    LEFT JOIN (SELECT a.id, a.name, b.keterangan, b.time
                    FROM siswas AS a 
                    LEFT JOIN absens AS b
                    ON a.id = b.siswa_id
                    WHERE b.time = '".$time."'
                    AND b.status = '".$status."') AS d
                    ON d.id = c.id WHERE d.id is null AND c.".$status." = 'aktif';"));

        $user = User::select('id')->where('username','system')->first();
        $check = $makan != null ? $makan : 'kosong';

        if($check != 'kosong')
        {
            foreach($makan as $m)
            {
                $absen = new Absen([
                    'user_id' => $user->id,
                    'siswa_id' => $m->siswa_id,
                    'time' => $m->_date,
                    'status' => $m->status,
                    'keterangan' => 'makan'
                ]);

                $absen->save();
            }
        }

        return $check;
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
