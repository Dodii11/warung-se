<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Alamat;
use Illuminate\Http\Request;

class AlamatController extends Controller
{

    public function index(Request $request)
    {
        return $request->user()
            ->alamat()
            ->orderByDesc('is_default')
            ->get();
    }

    /**
     * Tambah alamat baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'alamat' => 'required|string',
            'kecamatan' => 'required|string',
            'kota' => 'required|string',
            'data_lokasi' => 'nullable|string',
        ]);

        $user = $request->user();

        $alamat = $user->alamat()->create([
            'alamat' => $request->alamat,
            'kecamatan' => $request->kecamatan,
            'kota' => $request->kota,
            'data_lokasi' => $request->data_lokasi,
            'is_default' => false,
        ]);

        // jika belum ada default
        if (!$user->alamat()->where('is_default', true)->exists()) {
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
        $alamat = $request->user()
            ->alamat()
            ->findOrFail($id_alamat);

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
    public function destroy(Request $request, $id_alamat)
    {
        $alamat = $request->user()
            ->alamat()
            ->findOrFail($id_alamat);

        $alamat->delete();

        return response()->json([
            'message' => 'Alamat berhasil dihapus',
        ]);
    }
}
