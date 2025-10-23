<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use App\Models\Menu;
use App\Models\DetailPesanan;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PesananController extends Controller
{
    // 📌 Admin view semua pesanan
    public function index()
    {
        $pesanan = Pesanan::with('detail.menu')->get();
        return view('pesanan.index', compact('pesanan'));
    }

    // 📌 User form pemesanan
    public function user()
    {
        $menu = Menu::all();
        return view('pesanan.user', compact('menu'));
    }

    // 📌 Simpan pesanan
    public function store(Request $request)
    {
        $total = 0;

        foreach ($request->id_menu as $i => $id_menu) {
            $harga = Menu::find($id_menu)->harga;
            $total += $harga * $request->jumlah[$i];
        }

        $pesanan = Pesanan::create([
            'id_user' => '001',
            'tanggal_pesanan' => Carbon::now(),
            'total_harga' => $total,
            'status' => 'proses',
            'metode_bayar' => $request->metode_bayar,
            'alamat' => $request->alamat,
            'catatan' => $request->catatan,
        ]);

        foreach ($request->id_menu as $i => $id_menu) {
            $harga = Menu::find($id_menu)->harga;
            DetailPesanan::create([
                'id_pesanan' => $pesanan->id_pesanan,
                'id_menu' => $id_menu,
                'jumlah' => $request->jumlah[$i],
                'subtotal' => $harga * $request->jumlah[$i],
            ]);
        }

        return redirect()->back()->with('success', 'Pesanan berhasil dibuat!');
    }

    // 📌 Detail pop-up (AJAX)
    public function show($id)
    {
        $pesanan = Pesanan::with('detail.menu')->findOrFail($id);
        return view('pesanan.show', compact('pesanan'));
    }

    // 📌 Update status oleh admin
    public function updateStatus(Request $request, $id)
    {
        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => $request->status]);
        return redirect()->back()->with('success', 'Status pesanan diperbarui.');
    }
}
