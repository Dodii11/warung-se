<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailPesanan;
use App\Models\Pesanan;
use App\Models\Menu;
use Illuminate\Http\Request;

class DetailPesananController extends Controller
{
    // GET semua detail berdasarkan pesanan
    public function index($id_pesanan)
    {
        $pesanan = Pesanan::find($id_pesanan);
        if(!$pesanan) return response()->json(['message' => 'Pesanan not found'], 404);

        $detail = DetailPesanan::with('menu')->where('id_pesanan', $id_pesanan)->get();
        return response()->json($detail);
    }

    // GET 1 detail item
    public function show($id)
    {
        $detail = DetailPesanan::with('menu')->find($id);
        if(!$detail) return response()->json(['message' => 'Detail Pesanan not found'], 404);
        return response()->json($detail);
    }

    // UPDATE jumlah item detail pesanan
    public function update(Request $request, $id)
    {
        $detail = DetailPesanan::find($id);
        if(!$detail) return response()->json(['message' => 'Detail Pesanan not found'], 404);

        $request->validate([
            'jumlah' => 'required|integer|min:1'
        ]);

        $menu = Menu::find($detail->id_menu);
        if($menu->stok + $detail->jumlah < $request->jumlah) {
            return response()->json(['message' => 'Stok tidak cukup untuk diupdate'], 400);
        }

        // Balikin stok lama dulu, lalu kurangi dengan jumlah baru
        $menu->increment('stok', $detail->jumlah);
        $menu->decrement('stok', $request->jumlah);

        // Update subtotal
        $detail->update([
            'jumlah' => $request->jumlah,
            'subtotal' => $menu->harga * $request->jumlah
        ]);

        return response()->json($detail->load('menu'));
    }

    // DELETE item detail (misal admin hapus 1 item dari pesanan)
    public function destroy($id)
    {
        $detail = DetailPesanan::find($id);
        if(!$detail) return response()->json(['message' => 'Detail Pesanan not found'], 404);

        $menu = Menu::find($detail->id_menu);

        // Balikin stok saat item dihapus
        if($menu) {
            $menu->increment('stok', $detail->jumlah);
        }

        $detail->delete();

        return response()->json(['message' => 'Deleted']);
    }
}
