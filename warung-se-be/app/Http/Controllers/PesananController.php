<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PesananController extends Controller
{
    public function index()
    {
        $pesanans = Pesanan::with(['user', 'driver', 'detailPesanan'])->get()->map(function ($p) {
            if ($p->foto_pembayaran) {
                $p->foto_pembayaran_url = asset('storage/pembayaran/' . $p->foto_pembayaran);
            }
            return $p;
        });
        return response()->json($pesanans);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:user,id_user',
            'tanggal_pesanan' => 'required|date',
            'total_harga' => 'required|numeric',
            'status' => 'required|in:proses,diantar,selesai,batal',
            'metode_bayar' => 'required|string',
            'alamat' => 'required|string',
            'foto_pembayaran' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('foto_pembayaran')) {
            $fileName = time() . '_' . $request->file('foto_pembayaran')->getClientOriginalName();
            $request->file('foto_pembayaran')->storeAs('public/pembayaran', $fileName);
            $data['foto_pembayaran'] = $fileName;
        }

        $pesanan = Pesanan::create($data);
        return response()->json($pesanan, 201);
    }

    public function show($id)
    {
        $p = Pesanan::with(['user', 'driver', 'detailPesanan'])->findOrFail($id);
        if ($p->foto_pembayaran) {
            $p->foto_pembayaran_url = asset('storage/pembayaran/' . $p->foto_pembayaran);
        }
        return response()->json($p);
    }

    public function update(Request $request, $id)
    {
        $pesanan = Pesanan::with('detailPesanan.menu.stok')->findOrFail($id);

        $oldStatus = $pesanan->status; // status sebelum update

        if ($request->hasFile('foto_pembayaran')) {
            if ($pesanan->foto_pembayaran) {
                Storage::delete('public/pembayaran/' . $pesanan->foto_pembayaran);
            }
            $fileName = time() . '_' . $request->file('foto_pembayaran')->getClientOriginalName();
            $request->file('foto_pembayaran')->storeAs('public/pembayaran', $fileName);
            $pesanan->foto_pembayaran = $fileName;
        }

        // Update data pesanan
        $pesanan->update($request->except('foto_pembayaran'));

        /**
         * ============================================================
         *      LOGIKA PENGURANGAN STOK KETIKA STATUS = SELESAI
         * ============================================================
         */
        if (
            $pesanan->status === "selesai" &&
            $oldStatus !== "selesai" &&
            !$pesanan->stok_dikurangi
        ) {

            foreach ($pesanan->detailPesanan as $detail) {

                $stok = $detail->menu->stok; // akses stok_menu

                if ($stok) {
                    $stok->jumlah_stok -= $detail->jumlah;
                    if ($stok->jumlah_stok < 0) $stok->jumlah_stok = 0;
                    $stok->save();
                }
            }

            // Tandai bahwa stok untuk pesanan ini sudah dipotong
            $pesanan->stok_dikurangi = true;
            $pesanan->save();
        }

        return response()->json($pesanan);
    }


    public function destroy($id)
    {
        $pesanan = Pesanan::findOrFail($id);
        if ($pesanan->foto_pembayaran) {
            Storage::delete('public/pembayaran/' . $pesanan->foto_pembayaran);
        }
        $pesanan->delete();
        return response()->json(null, 204);
    }
}
