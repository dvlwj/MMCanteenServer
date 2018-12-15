<?php

namespace App\Http\Controllers\web;

use App\TahunAjaran;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TahunAjaranController extends Controller
{
    public function __construct(){
        $this->middleware(['auth', 'isAdminWeb']); 
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $thAjaran = TahunAjaran::all();
        return view('thAjaran', compact('thAjaran'));
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
            'tahun' => 'required|max:4'
        ]);

        $tahun = $request->input('tahun');

        $th_ajaran = new TahunAjaran([
            'tahun' => $tahun
        ]);

        //Check Tahun Ajaran
        if (TahunAjaran::where('tahun', $tahun)->first()){
            return response()->json([
                'msg' => 'Tahun is already created'
            ], 200);
        }

        if($th_ajaran->save()) {
            $response = [
                'msg' => 'Tahun Ajaran created',
                'th_ajaran' => $th_ajaran
            ];

            return response()->json($response, 201);
        }

        $response = [
            'msg' => 'An Error occured'
        ];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function show($th_ajaran)
    {
        $data = TahunAjaran::find($th_ajaran);
        if($data == '') {
            return response()->json(['msg' => 'Data not found']);
        }else{
            return response()->json($data, 200);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $th_ajaran)
    {
        $thAjaran = TahunAjaran::find($th_ajaran);
        if($request->tahun == '') {
            $thAjaran->tahun = $thAjaran->password;
        }elseif (TahunAjaran::where('tahun', $request->tahun)->first()) {
            return response()->json(['msg' => 'Tahun is already created'], 200);
        }else{
            $thAjaran->tahun = $request->tahun;
        }

        if($thAjaran->update()){
            return response()->json($thAjaran, 201);
        }else{
            return response()->json(['msg' => 'Update Failed']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TahunAjaran  $tahunAjaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($th_ajaran)
    {
        $thAjaran = TahunAjaran::find($th_ajaran);
        if($thAjaran == ''){
            return response()->json(['msg' => 'Delete Failed']);
        }else{
            $thAjaran->delete();
            return response()->json(['msg' => 'Data berhasil dihapus'], 201);
        }
    }
}
