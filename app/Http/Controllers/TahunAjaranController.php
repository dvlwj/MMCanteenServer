<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\TahunAjaran;

class TahunAjaranController extends Controller
{
    public function __construct()
    {
        $this->middleware(['jwt.auth', 'isAdmin']);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $th_ajarans = TahunAjaran::all();
        foreach($th_ajarans as $th_ajaran) {
            $th_ajaran->detail = [
                'link' => 'api/v1/th-ajaran/' . $th_ajaran->id,
                'method' => 'GET'
            ];
        }

        $response = [
            'status' => 1,
            'msg' => 'List of Tahun Ajaran',
            'data' => $th_ajarans
        ];

        return response()->json($response, 200);
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
                'status' => 0,
                'msg' => 'Tahun is already created'
            ], 200);
        }

        if($th_ajaran->save()) {
            $response = [
                'status' => 1,
                'msg' => 'Tahun Ajaran created',
                'th_ajaran' => $th_ajaran,
                'link' => 'api/v1/th-ajaran',
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $th_ajaran = TahunAjaran::find($id);
        if($th_ajaran == '') {
            return response()->json(['status' => 0,'msg' => 'Tahun ajaran not found'], 200);
        } else {
            $th_ajaran->update = [
                'link' => 'api/v1/th-ajaran/' . $th_ajaran->id,
                'method' => 'PATCH'
            ];
        }

        $response = [
            'status' => 1,
            'msg' => 'Detail Tahun Ajaran',
            'data' => $th_ajaran
        ];

        return response()->json($response, 200);
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
            'tahun' => 'required'
        ]);

        $tahun = $request->input('tahun');
        $th_ajaran = TahunAjaran::find($id);
        
        if($th_ajaran == '') {
            return response()->json(['status' => 0,'msg' => 'Tahun ajaran not found'], 200);
        } else {
            $th_ajaran->tahun = $tahun;
        }

        if(!$th_ajaran->update()) {
            return response()->json([
                'status' => 2,
                'msg' => 'Error during update'
            ]);
        }

        $response = [
            'status' => 1,
            'msg' => 'Tahun Ajaran updated',
            'th_ajaran' => $th_ajaran
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
        $th_ajaran = TahunAjaran::find($id);
        
        if($th_ajaran == '') {
            return response()->json(['status' => 0,'msg' => 'Tahun ajaran not found'], 200);
        }

        if(!$th_ajaran->delete()) {
            return response()->json([
                'status' => 0,
                'msg' => 'Delete failed'
            ]);
        }

        $response = [
            'status' => 1,
            'msg' => 'Tahun Ajaran deleted',
            'create' => [
                'link' => 'api/v1/th-ajaran',
                'method' => 'POST',
                'params' => 'tahun'
            ]             
        ];

        return response()->json($response, 200);
    }
}
