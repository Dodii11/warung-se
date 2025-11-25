<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::all()->map(function ($menu) {
            if ($menu->gambar_menu) {
                $menu->gambar_menu_url = asset('storage/menu/' . $menu->gambar_menu);
            }
            return $menu;
        });
        return response()->json($menus);
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu' => 'required|string|max:255',
            'harga' => 'required|integer',
            'kategori' => 'required|in:makanan,minum,paket',
            'gambar_menu' => 'required|image|max:2048',
        ]);

        $fileName = time() . '_' . $request->file('gambar_menu')->getClientOriginalName();
        $request->file('gambar_menu')->storeAs('public/menu', $fileName);

        $menu = Menu::create([
            'menu' => $request->menu,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'gambar_menu' => $fileName
        ]);

        return response()->json($menu, 201);
    }

    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        if ($menu->gambar_menu) {
            $menu->gambar_menu_url = asset('storage/menu/' . $menu->gambar_menu);
        }
        return response()->json($menu);
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::findOrFail($id);

        if ($request->hasFile('gambar_menu')) {
            // Hapus file lama
            if ($menu->gambar_menu) {
                Storage::delete('public/menu/' . $menu->gambar_menu);
            }
            $fileName = time() . '_' . $request->file('gambar_menu')->getClientOriginalName();
            $request->file('gambar_menu')->storeAs('public/menu', $fileName);
            $menu->gambar_menu = $fileName;
        }

        $menu->update($request->except('gambar_menu'));
        return response()->json($menu);
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        if ($menu->gambar_menu) {
            Storage::delete('public/menu/' . $menu->gambar_menu);
        }
        $menu->delete();
        return response()->json(null, 204);
    }
}
