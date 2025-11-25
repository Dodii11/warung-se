<?php

namespace App\Http\Controllers;

use App\Models\DetailPesanan;
use Illuminate\Http\Request;

class DetailPesananController extends Controller
{
    public function index()
    {
        return response()->json(DetailPesanan::with(['pesanan', 'menu'])->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pesanan' => 'required|exists:pesanan,id_pesanan',
            'id_menu' => 'required|exists:menu,id_menu',
            'jumlah' => 'required|integer|min:1',
            'subtotal' => 'required|numeric',
        ]);

        $detail = DetailPesanan::create($request->all());
        return response()->json($detail, 201);
    }

    public function show($id)
    {
        return response()->json(DetailPesanan::with(['pesanan', 'menu'])->findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $detail = DetailPesanan::findOrFail($id);
        $detail->update($request->all());
        return response()->json($detail);
    }

    public function destroy($id)
    {
        $detail = DetailPesanan::findOrFail($id);
        $detail->delete();
        return response()->json(null, 204);
    }
}
