<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Aktor;

class AktorController extends Controller
{
    public function index(){
        $aktor = aktor::latest()->get();
        $response = [
            'success'=> true,
            'message'=> 'Data Aktor',
            'data'=> $aktor,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'nama_aktor' => 'required|unique:aktors',
            'bio' => 'required',
        ],[
            'nama_aktor.required'=>'Masukan Aktor',
            'bio.required'=>'Masukan Biodata',
            'nama_aktor.unique' => 'Aktor Sudah Di gunakan'
        ]);
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=> 'Silahkan Di isi Dengan Benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $aktor = new aktor;
            $aktor -> nama_aktor = $request->nama_aktor;
            $aktor -> bio = $request->bio;
            $aktor ->save();
        }
        if ($aktor) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan',
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal Disimpan',
            ], 400);
        }
    }

    public function show($id)
    {
        $aktor = aktor::find($id);
        if ($aktor) {
            return response()->json([
                'success' => true,
                'message' => 'Data Ditemukan',
                'data' => $aktor
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }
    }

    public function update(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'nama_aktor' => 'required|unique:aktors',
            'nama_aktor' => 'required',
        ],[
            'nama_aktor.required'=>'Masukan Aktor',
            'nama_aktor.unique' => 'Aktor Sudah Di gunakan',
            'bio.required'=>'Masukan Biodata'
        ]);
        if($validator->fails()){
            return response()->json([
                'success'=>false,
                'message'=> 'Silahkan Di isi Dengan Benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $aktor = aktor::find($id);
            $aktor -> nama_aktor = $request->nama_aktor;
            $aktor -> bio = $request->bio;
            $aktor ->save();
        }
        if ($aktor) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Disimpan',
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Gagal Disimpan',
            ], 400);
        }
    }

    public function destroy($id)
    {
        $aktor = aktor::find($id);
        if ($aktor) {
            $aktor->delete();
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Dihapus',
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data Tidak Ditemukan',
            ], 404);
        }
    }

}
