<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use Illuminate\Http\Request;

class AlamatController extends Controller
{

    public function index(Request $request)
    {
        return Alamat::where('id_user', $request->id_user)->get();
    }

    /**
     * Tambah alamat baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:account,id_user',
            'alamat' => 'required|string',
        ]);

        $alamat = Alamat::create([
            'id_user' => $request->id_user,
            'data_lokasi' => $request->data_lokasi,
            'alamat' => $request->alamat,
            'kecamatan' => $request->kecamatan,
            'kota' => $request->kota,
            'is_default' => false,
        ]);

        // Jika user belum punya alamat default → jadikan default
        if (!Alamat::where('id_user', $request->id_user)->where('is_default', true)->exists()) {
            $alamat->setAsDefault();
        }

        return response()->json([
            'message' => 'Alamat berhasil ditambahkan',
            'data' => $alamat,
        ]);
    }

    /**
     * Ubah alamat
     */
    public function update(Request $request, $id_alamat)
    {
        $alamat = Alamat::findOrFail($id_alamat);

        $alamat->update($request->only([
            'data_lokasi',
            'alamat',
            'kecamatan',
            'kota'
        ]));

        return response()->json([
            'message' => 'Alamat berhasil diperbarui',
            'data' => $alamat,
        ]);
    }

    /**
     * Set alamat default manual
     */
    public function setDefault($id_alamat)
    {
        $alamat = Alamat::findOrFail($id_alamat);

        $alamat->setAsDefault();

        return response()->json([
            'message' => 'Alamat ini menjadi default',
            'data' => $alamat,
        ]);
    }

    /**
     * Hapus alamat
     */
    public function destroy($id_alamat)
    {
        $alamat = Alamat::findOrFail($id_alamat);

        $alamat->delete();

        return response()->json([
            'message' => 'Alamat berhasil dihapus',
        ]);
    }
}
