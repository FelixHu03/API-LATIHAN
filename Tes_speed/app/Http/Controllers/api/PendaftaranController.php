<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PendaftaranResource;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendaftaran = pendaftaran::get();
        if ($pendaftaran) {
            return PendaftaranResource::collection($pendaftaran);
        } else {
            return response()->json(['message'=> 'Tidak Ada Isi'], 200);
        }

    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'nomorTelepon' => 'required|string|max:255|unique:pendaftaras,nomorTelepon',
            'tingkatSekolah' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message'=> 'All fields are mandatory',
                'error' => $validator->messages(),
            ], 422);

        } 
        $pendaftaran = pendaftaran::create([
            'nama'=> $request->nama,
            'email'=> $request->email,
            'nomorTelepon'=> $request->noorTelepon,
            'tingkatSekolah'=> $request->tingkatSekolah,

        ]);
        return response()->json([
            'message'=> 'Pendaftaran Berhasil',
            'data'=> new PendaftaranResource($pendaftaran),
        ],200);
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pendaftaran = pendaftaran::findOrFail($id);
        return new PendaftaranResource($pendaftaran);
    }
    public function update(Request $request, $id)
    {
        $pendaftaran = pendaftaran::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'nomorTelepon' => 'required|string|max:255|unique:pendaftaras,nomorTelepon',
            'tingkatSekolah' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'All fields are mandotory',
                'error'=> $validator->messages(),
            ],422);
        }   
        $pendaftaran->update([
            'nama'=> $request->nama,
            'email'=> $request->email,
            'nomorTelepon'=> $request->nomorTelepon,
            'tingkatSekolah'=> $request->tingkatSekolah,
        ]);
        $pendaftaran->refresh();
        return response()->json([
            'message'=> 'Data Berhasil di Update',
            'data' => new PendaftaranResource($pendaftaran),
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();
        return response()->json([
            'message' => "Peserta Berhasil di hapus",
        ],200);
    }
}
