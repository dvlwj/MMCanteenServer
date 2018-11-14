<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Kelas;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $kelas = Kelas::all();
        foreach($kelas as $data) {
            $data->detail_kelas = [
                'link' => 'api/v1/kelas/' . $data->id,
                'method' => 'GET'
            ];
        }

        $response = [
            'msg' => 'List of Kelas',
            'kelas' => $kelas
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
            'name' => 'required'
        ]);

        $name = $request->input('name');
        
        $kelas = new Kelas([
            'name' => $name
        ]);

        // Kelas check
        if(Kelas::where('name', $name)->first()) {
            $response = [
                'msg' => 'Kelas is already exist',
            ];

            return response()->json($response, 404);
        }

        if($kelas->save()) {
            $response = [
                'msg' => 'Kelas created',
                'kelas' => $kelas,
                'link' => 'api/v1/kelas',
                'method' => 'GET'
            ];

            return response()->json($response, 201);
        }

        $response = [
            'msg' => 'An Error occured'
        ];

        return response()->json($response, 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $kelas = Kelas::findOrFail($id);
        $kelas->update = [
            'link' => 'api/v1/kelas/' . $kelas->id,
            'method' => 'PATCH'
        ];

        $response = [
            'msg' => 'Detail kelas',
            'kelas' => $kelas
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
            'name' => 'required'
        ]);
        
        $name = $request->input('name');
        $kelas = Kelas::findOrFail($id);
        $kelas->name = $name;

        if(!$kelas->update()) {
            return response()->json([
                'msg' => 'Error during update'
            ], 404);
        }

        $response = [
            'msg' => 'Kelas updated',
            'kelas' => $kelas
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
        $kelas = Kelas::findOrFail($id);
        
        if(!$kelas->delete()) {
            return response()->json([
                'msg' => 'Delete failed'
            ], 404);
        }

        $response = [
            'msg' => 'Kelas deleted',
            'create' => [
                'link' => 'api/v1/kelas',
                'method' => 'POST',
                'params' => 'name'
            ]             
        ];

        return response()->json($response, 200);
    }
}
