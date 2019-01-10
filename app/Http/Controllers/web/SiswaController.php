<?php

namespace App\Http\Controllers\web;

use App\Siswa;
use App\Kelas;
use App\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiswaController extends Controller
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
        $siswa = Siswa::all();
        foreach ($siswa as $data) {
            $data->kelas_name = Kelas::select('name')->where('id', $data->kelas_id)->first();
            $data->th_ajaran_name = TahunAjaran::select('tahun')->where('id', $data->th_ajaran_id)->first();
        }
        $kelas = Kelas::all();
        $thAjaran = TahunAjaran::all();
        return view('siswa', compact(['siswa', 'kelas', 'thAjaran']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nis' => 'required', 
            'name' => 'required', 
            'kelas_id' => 'required', 
            'th_ajaran_id' => 'required'
        ]);

        $nis = $request->input('nis');
        $name = $request->input('name');
        $kelas_id = $request->input('kelas_id');
        $th_ajaran_id = $request->input('th_ajaran_id');

        $siswa = new Siswa([
            'nis' => $nis,
            'name' => $name,
            'kelas_id' => $kelas_id,
            'th_ajaran_id' => $th_ajaran_id,
            'status' => 'enable'
        ]);

        // Check NIS
        if (Siswa::where('nis', $nis)->first()) {
            $response = [
                'status' => 0,
                'msg' => 'NIS is already exist',
            ];

            return response()->json($response);
        }

        if ($siswa->save()) {
            $response = [
                'status' => 1,
                'msg' => 'Siswa created',
                'siswa' => $siswa,
                'link' => 'api/v1/siswa',
                'method' => 'GET'
            ];

            return response()->json($response, 201);
        }

        $response = [
            'status' => 2,
            'msg' => 'An Error occured'
        ];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function show($siswa)
    {
        $data = Siswa::find($siswa);
        if($data == '') {
            return response()->json(['status' => 0,'msg' => 'Data not found']);
        }else{
            return response()->json($data, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $siswa)
    {
        $this->validate($request, [
            'nis' => 'required', 
            'name' => 'required', 
            'kelas_id' => 'required', 
            'th_ajaran_id' => 'required',
            'status' => 'required'
        ]);

        $nis = $request->input('nis');
        $name = $request->input('name');
        $kelas_id = $request->input('kelas_id');
        $th_ajaran_id = $request->input('th_ajaran_id');
        $status = $request->input('status');

        $data = Siswa::find($siswa);
        if ($data == '') {
            return response()->json(['status' => 0,'msg' => 'Siswa not found']);
        } else {
            $data->nis = $nis;
            $data->name = $name;
            $data->kelas_id = $kelas_id;
            $data->th_ajaran_id = $th_ajaran_id;
            $data->status = $status;
        }

        if(!$data->update()) {
            return response()->json([
                'status' => 2,
                'msg' => 'Error during update'
            ]);
        }

        $response = [
            'status' => 1,
            'msg' => 'Siswa updated',
            'siswa' => $data
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Siswa  $siswa
     * @return \Illuminate\Http\Response
     */
    public function destroy($siswa)
    {
        $data = Siswa::find($siswa);
        if($data == ''){
            return response()->json(['status' => 0,'msg' => 'Delete Failed']);
        }else{
            $data->delete();
            return response()->json(['status' => 1,'msg' => 'Data berhasil dihapus'], 201);
        }
    }

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
    * Display a QR Code of Siswa
    *
    * @param  \App\Siswa  $siswa
    * @return \Illuminate\Http\Response
    */
    public function qr($id)
    {
        $siswa = Siswa::find($id);
        if($siswa == ''){
            return redirect()->route('siswa.index');       
        }
        return view('qrcode', ['nis' => $siswa->nis, 'name' => $siswa->name]);
    }
}
