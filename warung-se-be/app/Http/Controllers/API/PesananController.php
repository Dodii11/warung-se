<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role == 'user') {
            return response()->json(
                Pesanan::where('id_user', $user->id_user)->get()
            );
        }

        return response()->json(Pesanan::all());
    }

    public function show($id)
    {
        $pesanan = Pesanan::with('detail.menu', 'alamat')->find($id);

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan not found'], 404);
        }

        return response()->json($pesanan);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'cart'        => 'required|array',
            'id_alamat'   => 'nullable|integer',
            'catatan'     => 'nullable|string',
        ]);

        $user = $request->user();

        if (!$request->id_alamat) {
            // Jika user tidak kirim id_alamat → pakai default
            $alamat = Alamat::where('id_user', $user->id_user)
                ->where('is_default', true)
                ->first();

            if (!$alamat) {
                return response()->json([
                    'message' => 'User tidak memiliki alamat default. Harap pilih alamat.'
                ], 400);
            }
        } else {
            // Jika user kirim id_alamat → validasi kepemilikan
            $alamat = Alamat::where('id_alamat', $request->id_alamat)
                ->where('id_user', $user->id_user)
                ->first();

            if (!$alamat) {
                return response()->json([
                    'message' => 'Alamat tidak valid atau bukan milik user.'
                ], 400);
            }
        }

        $total = 0;

        foreach ($request->cart as $item) {
            $menu = Menu::find($item['id_menu']);

            if (!$menu) {
                return response()->json(['message' => "Menu {$item['id_menu']} not found"], 404);
            }

            if ($menu->stok < $item['jumlah']) {
                return response()->json([
                    'message' => "Menu {$menu->menu} stok tidak cukup"
                ], 400);
            }

            $total += $menu->harga * $item['jumlah'];
        }

        $id_pesanan = 'PS' . str_pad(Pesanan::count() + 1, 4, '0', STR_PAD_LEFT);

        $pesanan = Pesanan::create([
            'id_pesanan'      => $id_pesanan,
            'id_user'         => $user->id_user,
            'id_alamat'       => $alamat->id_alamat,   // FOREIGN KEY BARU
            'tanggal_pesanan' => Carbon::now(),
            'total_harga'     => $total,
            'status'          => 'Diproses',
            'catatan'         => $request->catatan
        ]);

        foreach ($request->cart as $item) {
            $menu = Menu::find($item['id_menu']);

            $id_detail = 'DP' . str_pad(DetailPesanan::count() + 1, 4, '0', STR_PAD_LEFT);

            DetailPesanan::create([
                'id_detail'   => $id_detail,
                'id_pesanan'  => $id_pesanan,
                'id_menu'     => $menu->id_menu,
                'jumlah'      => $item['jumlah'],
                'subtotal'    => $menu->harga * $item['jumlah']
            ]);

            // Kurangi stok menu
            $menu->decrement('stok', $item['jumlah']);
        }

        return response()->json(
            $pesanan->load('detail.menu', 'alamat')
        );
    }

    public function latest()
    {
        $pesanan = Pesanan::with([
            'user:id_user,nama_user',
            'driver:id_driver,nama_driver',
            'alamat:id_alamat,alamat'
        ])
            ->orderBy('tanggal_pesanan', 'desc')
            ->limit(10)
            ->get()
            ->map(function ($p) {
                return [
                    'id'        => $p->id_pesanan,
                    'tanggal'  => $p->tanggal_pesanan->format('d M Y H:i'),
                    'customer' => $p->user->nama_user ?? '-',
                    'alamat'   => $p->alamat->alamat ?? '-',
                    'total'    => $p->total_harga,
                    'status'   => $p->status,
                    'driver'   => $p->driver->nama_driver ?? 'Belum ditetapkan'
                ];
            });

        return response()->json($pesanan);
    }
}
