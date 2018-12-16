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
                'status' => 'fail',
                'msg' => 'Tahun is already created'
            ], 200);
        }

        if($th_ajaran->save()) {
            $response = [
                'status' => 'success',
                'msg' => 'Tahun Ajaran created',
                'th_ajaran' => $th_ajaran
            ];

            return response()->json($response, 201);
        }

        $response = [
            'status' => 'fail',
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
            return response()->json(['status' => 'fail','msg' => 'Data not found']);
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
        $this->validate($request, [
            'tahun' => 'required'
        ]);

        $tahun = $request->input('tahun');
        $thAjaran = TahunAjaran::find($th_ajaran);
        
        if($thAjaran == '') {
            return response()->json(['status' => 'fail','msg' => 'Tahun ajaran not found'], 200);
        } elseif (TahunAjaran::where('tahun', $tahun)->first()){
            return response()->json(['status' => 'fail','msg' => 'Tahun Ajaran is already taken.']);
        } else {
            $thAjaran->tahun = $tahun;
        }

        if(!$thAjaran->update()) {
            return response()->json([
                'status' => 'fail',
                'msg' => 'Error during update'
            ]);
        }

        $response = [
            'status' => 'success',
            'msg' => 'Tahun Ajaran updated',
            'th_ajaran' => $thAjaran
        ];

        return response()->json($response, 200);
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
            return response()->json(['status' => 'fail','msg' => 'Delete Failed']);
        }else{
            $thAjaran->delete();
            return response()->json(['status' => 'fail','msg' => 'Data berhasil dihapus'], 201);
        }
    }
}
