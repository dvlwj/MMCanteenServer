<?php

namespace App\Http\Controllers\web;

use App\Harga;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HargaController extends Controller
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
        $harga = Harga::all();
        return view('harga', compact('harga'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'kel_kelas' => 'required',
            'harga' => 'required'
        ]);

        $kel_kelas = $request->input('kel_kelas');
        $harga = $request->input('harga');

        $addHarga = New Harga([
            'kel_kelas' => $kel_kelas,
            'harga' => $harga
        ]);

        // kel_kelas check
        if(Harga::where('kel_kelas', $kel_kelas)->first()) {
            $response = [
                'status' => 0,
                'msg' => 'Kelompok Kelas is already exist',
            ];

            return response()->json($response);
        }

        if($addHarga->save()) {
            $response = [
                'status' => 1,
                'msg' => 'Harga created',
                'harga' => $addHarga
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Harga::find($id);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'kel_kelas' => 'required',
            'harga' => 'required'
        ]);
        
        $kel_kelas = $request->input('kel_kelas');
        $harga = $request->input('harga');
        $editHarga = Harga::find($id);

        if($editHarga == '') {
            return response()->json(['status' => 0,'msg' => 'Kelompok Kelas not found'], 200);
        } else {
            $editHarga->kel_kelas = $kel_kelas;
            $editHarga->harga = $harga;
        }

        if(!$editHarga->update()) {
            return response()->json([
                'status' => 2,
                'msg' => 'Error during update'
            ]);
        }

        $response = [
            'status' => 1,
            'msg' => 'Kelompok Kelas updated',
            'harga' => $editHarga
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $harga = Harga::find($id);
        if($harga == ''){
            return response()->json(['status' => 0,'msg' => 'Delete Failed']);
        }else{
            $harga->delete();
            return response()->json(['status' => 1,'msg' => 'Data berhasil dihapus'], 201);
        }
    }
}
