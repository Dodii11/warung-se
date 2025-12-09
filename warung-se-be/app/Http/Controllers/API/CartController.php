<?php

namespace App\Http\Controllers\API;

use App\Models\Cart;
use App\Models\Menu;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    // GET isi keranjang user login
    public function index()
    {
        $user = request()->user();

        $cart = Cart::with('menu')   // relasi menu
            ->where('id_user', $user->id_user)
            ->get();

        return response()->json([
            'message' => 'Cart fetched',
            'data' => $cart
        ], 200);
    }

    // POST tambah menu ke keranjang
    public function store(Request $request)
    {
        $request->validate([
            'id_menu' => 'required|exists:menu,id_menu',
            'jumlah' => 'required|integer|min:1',
        ]);

        $user = request()->user();
        $menu = Menu::find($request->id_menu);

        if (!$menu || $menu->stok < $request->jumlah) {
            return response()->json([
                'message' => 'Stok tidak cukup'
            ], 400);
        }

        $subtotalBaru = $menu->harga * $request->jumlah;

        // Jika sudah ada di cart → update jumlah + subtotal
        $cartItem = Cart::where('id_user', $user->id_user)
            ->where('id_menu', $menu->id_menu)
            ->first();

        if ($cartItem) {
            $cartItem->jumlah += $request->jumlah;
            $cartItem->subtotal += $subtotalBaru;
            $cartItem->save();
        } else {
            Cart::create([
                'id_user'  => $user->id_user,
                'id_menu'  => $menu->id_menu,
                'jumlah'   => $request->jumlah,
                'subtotal' => $subtotalBaru,
            ]);
        }

        return response()->json([
            'message' => 'Added to cart'
        ], 201);
    }

    // DELETE hapus 1 menu dari cart
    public function destroy($id_menu)
    {
        $user = request()->user();
        $deleted = Cart::where('id_user', $user->id_user)
            ->where('id_menu', $id_menu)
            ->delete();

        if (!$deleted) {
            return response()->json([
                'message' => 'Item not found in cart'
            ], 404);
        }

        return response()->json([
            'message' => 'Deleted from cart'
        ], 200);
    }

    // DELETE clear seluruh cart user
    public function clear()
    {
        $user = request()->user();
        Cart::where('id_user', $user->id_user)->delete();

        return response()->json([
            'message' => 'Cart cleared'
        ], 200);
    }
}
