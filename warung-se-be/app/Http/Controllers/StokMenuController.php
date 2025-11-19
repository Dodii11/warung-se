<?php

namespace App\Http\Controllers;

use App\Models\StokMenu;
use Illuminate\Http\Request;

class StokMenuController extends Controller
{
    // Tampilkan semua stok
    public function index()
    {
        $stok = StokMenu::with('menu')->get();
        return response()->json($stok);
    }

    // Tambah stok untuk menu
    public function store(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|exists:menu,id_menu',
            'jumlah_stok' => 'required|integer|min:0'
        ]);

        $stok = StokMenu::create([
            'id_menu' => $request->id_menu,
            'jumlah_stok' => $request->jumlah_stok
        ]);

        return response()->json($stok, 201);
    }

    // Update stok
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah_stok' => 'required|integer|min:0'
        ]);

        $stok = StokMenu::findOrFail($id);
        $stok->jumlah_stok = $request->jumlah_stok;
        $stok->save();

        return response()->json($stok);
    }

    // Hapus stok
    public function destroy($id)
    {
        $stok = StokMenu::findOrFail($id);
        $stok->delete();
        return response()->json(null, 204);
    }
}
