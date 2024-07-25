<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use Illuminate\Http\Request;
use Validator;

class GenreController extends Controller
{
    public function index(){
        $genre = genre::latest()->get();
        $response = [
            'succes' => true,
            'message' =>'Data Genre',
            'data' => $genre,
        ];
        return response()->json($response, 200);
    }

    public function store(Request $request)
    {

        //validasi data
        $validator = Validator::make($request->all(), [
            'nama_genre' => 'required|unique:genres'
        ], [
            'nama_genre.required' => 'Masukan genre',
            'nama_genre.unique' => 'genre Sudah Di Gunakan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'silahkan isi dengan benar',
                'data' => $validator->errors(),
            ], 400);
        } else {
            $genre = new genre;
            $genre->nama_genre = $request->nama_genre;
            $genre->save();
    }
        if ($genre) {
            return response()->json([
                'success' => true,
                'message' => 'Data Berhasil Di Simpan',
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => 'Data Gagal Di Simpan',
            ], 400);
        }
    }

    public function show($id)
{

    $genre = genre::find($id);

    if ($genre) {
        return response()->json([
            'success' => true,
            'message' => 'Detail genre',
            'data' => $genre,
        ], 200);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'genre Tidak Ditemukan',
            'data' => '',
        ], 404);
    }
}

public function update(Request $request, $id)
{

    //validasi data
    $validator = Validator::make($request->all(), [
        'nama_genre' => 'required'
    ], [
        'nama_genre.required' => 'Masukan genre',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'success' => false,
            'message' => 'silahkan isi dengan benar',
            'data' => $validator->errors(),
        ], 400);
    } else {
        $genre = genre::find($id);
        $genre->nama_genre = $request->nama_genre;
        $genre->save();
}
    if ($genre) {
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Di Simpan',
        ], 200);
    } else {
        return response()->json([
            'success' => true,
            'message' => 'Data Gagal Di Simpan',
        ], 400);
    }
}

    public function destroy($id)
    {
        $genre = genre::find($id);
        if ($genre)
        {
            $genre->delete();
        return response()->json([
            'success' => true,
            'message' => 'data' . $genre->nama_genre . ' berhasil di hapus',
        ], 200);
        } else {
            $genre->delete();
        return response()->json([
            'success' => false,
            'message' => 'data tidak di temukan',
        ], 404);
        }
    }
}
