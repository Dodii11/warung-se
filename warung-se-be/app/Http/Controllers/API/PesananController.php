<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PesananController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        if($user->role == 'user'){
            return response()->json(Pesanan::where('id_user',$user->id_user)->get());
        }
        return response()->json(Pesanan::all());
    }

    public function show($id)
    {
        $pesanan = Pesanan::with('detail.menu')->find($id);
        if(!$pesanan) return response()->json(['message'=>'Pesanan not found'],404);
        return response()->json($pesanan);
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'cart'=>'required|array',
            'alamat'=>'required|string',
            'catatan'=>'nullable|string'
        ]);

        $user = $request->user();
        $total = 0;
        foreach($request->cart as $item){
            $menu = Menu::find($item['id_menu']);
            if(!$menu) return response()->json(['message'=>"Menu {$item['id_menu']} not found"],404);
            if($menu->stok < $item['jumlah']) return response()->json(['message'=>"Menu {$menu->menu} stok tidak cukup"],400);
            $total += $menu->harga * $item['jumlah'];
        }

        $id_pesanan = 'PS'.str_pad(Pesanan::count()+1,4,'0',STR_PAD_LEFT);
        $pesanan = Pesanan::create([
            'id_pesanan'=>$id_pesanan,
            'id_user'=>$user->id_user,
            'tanggal_pesanan'=>Carbon::now(),
            'total_harga'=>$total,
            'status'=>'proses',
            'alamat'=>$request->alamat,
            'catatan'=>$request->catatan
        ]);

        foreach($request->cart as $item){
            $menu = Menu::find($item['id_menu']);
            $id_detail = 'DP'.str_pad(DetailPesanan::count()+1,4,'0',STR_PAD_LEFT);
            DetailPesanan::create([
                'id_detail'=>$id_detail,
                'id_pesanan'=>$id_pesanan,
                'id_menu'=>$menu->id_menu,
                'jumlah'=>$item['jumlah'],
                'subtotal'=>$menu->harga * $item['jumlah']
            ]);
            // Kurangi stok menu
            $menu->decrement('stok',$item['jumlah']);
        }

        return response()->json($pesanan->load('detail.menu'));
    }
}
