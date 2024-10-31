<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PendaftaranResource;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    // php artisan make:controller Api\pendaftaranController
    public function index()
    {
        $pendaftaran = Pendaftaran::get();

        if ($pendaftaran) {
            return  PendaftaranResource::collection($pendaftaran);
        } else {
            return response()->json(['message' => 'Tidak ada isi'], 200);
        }
    }

    public function store(Request $request)
    {
        // Content-Type: application/json
        // tambahke itu mennak keterimo di postman
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|unique:pendaftaran,email', // Specify table and column for unique validation
            'nomor_telepon' => 'required|string|max:255|unique:pendaftaran,nomor_telepon',
            'tingkat_sekolah' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'All fields are mandatory',
                'error' => $validator->messages(),
            ], 422);
        }
        $pendaftaran = Pendaftaran::create([
            'nama' => $request->nama,
            'email' => $request->email,
            'nomor_telepon' => $request->nomor_telepon,
            'tingkat_sekolah' => $request->tingkat_sekolah,
        ]);

        return response()->json([
            'message' => 'Pendaftaran Berhasil',
            'data' => new PendaftaranResource($pendaftaran),
        ], 200);
    }
    public function show($id)
    {
        $pendaftaran = Pendaftaran::findOrFail($id);
        return new PendaftaranResource($pendaftaran);
    }
    public function update(Request $request, $id) 
{
    // Cari data pendaftaran terlebih dahulu
    $pendaftaran = Pendaftaran::findOrFail($id);

    $validator = Validator::make($request->all(), [
        'nama' => 'required|string|max:255',
        'email' => 'required|string|email',
        'nomor_telepon' => 'required|string|max:255',
        'tingkat_sekolah' => 'required|string|max:255',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'message' => 'All fields are mandatory',
            'error' => $validator->messages(),
        ], 422);
    }

    $pendaftaran->update([
        'nama' => $request->nama,
        'email' => $request->email,
        'nomor_telepon' => $request->nomor_telepon,
        'tingkat_sekolah' => $request->tingkat_sekolah,
    ]);

    // Refresh model untuk mendapatkan data terbaru
    $pendaftaran->refresh();

    return response()->json([
        'message' => 'Pendaftaran Update Berhasil',
        'data' => new PendaftaranResource($pendaftaran),
    ], 200);
}
    public function destroy($id) {
        $pendaftaran = Pendaftaran::findOrFail($id);
        $pendaftaran->delete();
        return response()->json([
            'message' => "Peserta berhasil di hapus"
        ],200);
    }
}
