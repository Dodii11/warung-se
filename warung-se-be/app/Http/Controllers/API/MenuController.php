<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index()
    {
        return response()->json(Menu::all());
    }

    public function show($id)
    {
        $menu = Menu::find($id);
        if(!$menu) return response()->json(['message'=>'Menu not found'],404);
        return response()->json($menu);
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu'=>'required|string',
            'harga'=>'required|integer',
            'kategori'=>'required|in:makanan,minum,paket',
            'stok'=>'required|integer',
        ]);

        $menu = Menu::create($request->all());
        return response()->json($menu,201);
    }

    public function update(Request $request,$id)
    {
        $menu = Menu::find($id);
        if(!$menu) return response()->json(['message'=>'Menu not found'],404);

        $menu->update($request->all());
        return response()->json($menu);
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);
        if(!$menu) return response()->json(['message'=>'Menu not found'],404);
        $menu->delete();
        return response()->json(['message'=>'Deleted']);
    }
}
