<?php

namespace App\Http\Controllers\web;

use App\Kelas;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class KelasController extends Controller
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
        $kelas = Kelas::all();
        return view('kelas', compact('kelas'));
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
            'name' => 'required'
        ]);

        $name = $request->input('name');
        
        $kelas = new Kelas([
            'name' => $name
        ]);

        // Kelas check
        if(Kelas::where('name', $name)->first()) {
            $response = [
                'status' => 0,
                'msg' => 'Kelas is already exist',
            ];

            return response()->json($response);
        }

        if($kelas->save()) {
            $response = [
                'status' => 1,
                'msg' => 'Kelas created',
                'kelas' => $kelas
            ];

            return response()->json($response, 201);
        }

        $response = [
            'status' => 0,
            'msg' => 'An Error occured'
        ];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function show($kela)
    {
        $data = Kelas::find($kela);
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
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $kela)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        
        $name = $request->input('name');
        $kelas = Kelas::find($kela);

        if($kelas == '') {
            return response()->json(['status' => 0,'msg' => 'Kelas not found'], 200);
        } elseif (Kelas::where('name', $name)->first()){
            return response()->json(['status' => 0,'msg' => 'Kelas is already taken.']);
        } else {
            $kelas->name = $name;
        }

        if(!$kelas->update()) {
            return response()->json([
                'status' => 0,
                'msg' => 'Error during update'
            ]);
        }

        $response = [
            'status' => 1,
            'msg' => 'Kelas updated',
            'kelas' => $kelas
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kelas  $kelas
     * @return \Illuminate\Http\Response
     */
    public function destroy($kela)
    {
        $kelas = Kelas::find($kela);
        if($kelas == ''){
            return response()->json(['status' => 0,'msg' => 'Delete Failed']);
        }else{
            $kelas->delete();
            return response()->json(['status' => 1,'msg' => 'Data berhasil dihapus'], 201);
        }
    }
}
