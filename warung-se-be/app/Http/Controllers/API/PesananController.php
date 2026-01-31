<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Menu;
use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Str;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        if ($user->role === 'user') {
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
            'cart' => 'required|array|min:1',
            'cart.*.id_menu' => 'required|integer',
            'cart.*.jumlah' => 'required|integer|min:1',
            'catatan' => 'nullable|string',
            'id_alamat' => 'nullable|integer'
        ]);

        $user = $request->user();

        // ====== ALAMAT ======
        $alamat = $request->id_alamat
            ? Alamat::where('id_alamat', $request->id_alamat)
            ->where('id_user', $user->id_user)
            ->first()
            : Alamat::where('id_user', $user->id_user)
            ->where('is_default', true)
            ->first();

        if (!$alamat) {
            return response()->json(['message' => 'Alamat tidak ditemukan'], 400);
        }

        DB::beginTransaction();

        try {
            $total = 0;

            foreach ($request->cart as $item) {
                $menu = Menu::findOrFail($item['id_menu']);

                if ($menu->stok < $item['jumlah']) {
                    throw new \Exception("Stok {$menu->menu} tidak cukup");
                }

                $total += $menu->harga * $item['jumlah'];
            }

            $id_pesanan = 'PS' . str_pad(Pesanan::count() + 1, 5, '0', STR_PAD_LEFT);

            $pesanan = Pesanan::create([
                'id_pesanan' => $id_pesanan,
                'id_user' => $user->id_user,
                'id_alamat' => $alamat->id_alamat,
                'tanggal_pesanan' => now(),
                'total_harga' => $total,
                'status' => 'Tertunda',
                'catatan' => $request->catatan
            ]);

            foreach ($request->cart as $item) {
                $menu = Menu::find($item['id_menu']);

                DetailPesanan::create([
                    'id_detail' => 'DP' . uniqid(),
                    'id_pesanan' => $id_pesanan,
                    'id_menu' => $menu->id_menu,
                    'jumlah' => $item['jumlah'],
                    'subtotal' => $menu->harga * $item['jumlah']
                ]);

                $menu->decrement('stok', $item['jumlah']);
            }

            DB::commit();

            return response()->json(
                $pesanan->load('detail.menu', 'alamat'),
                201
            );
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Checkout gagal',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        $pesanan->update([
            'status' => $request->status
        ]);

        return response()->json($pesanan);
    }


    public function assignDriver(Request $request, $id)
    {
        $request->validate([
            'id_driver' => 'required|exists:driver,id_driver'
        ]);

        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        $pesanan->update([
            'id_driver' => $request->id_driver
        ]);

        return response()->json([
            'success' => true,
            'data' => $pesanan->load('driver')
        ]);
    }

    // USER
    public function indexUser(Request $request)
    {
        return Pesanan::with([
            'user',
            'driver',
            'alamat',
            'detail.menu'
        ])
            ->where('id_user', $request->user()->id_user)
            ->orderByDesc('tanggal_pesanan')
            ->get();
    }


    // ADMIN
    public function indexAdmin()
    {
        return Pesanan::with(['user', 'detail.menu', 'alamat', 'driver'])
            ->orderByDesc('tanggal_pesanan')
            ->get();
    }
}
