<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;

class DetailPesananController extends Controller
{
    public function index($id_pesanan)
    {
        return DetailPesanan::with('menu')
            ->where('id_pesanan', $id_pesanan)
            ->get();
    }

    public function show($id)
    {
        return DetailPesanan::with('menu')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        $detail = DetailPesanan::findOrFail($id);
        $detail->update([
            'jumlah'   => $request->jumlah,
            'subtotal' => $detail->menu->harga * $request->jumlah
        ]);

        return response()->json($detail);
    }

    public function destroy($id)
    {
        DetailPesanan::findOrFail($id)->delete();
        return response()->json(['message' => 'Detail pesanan dihapus']);
    }
}
