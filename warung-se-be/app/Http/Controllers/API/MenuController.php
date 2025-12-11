<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        return response()->json(Menu::all());
    }

    public function show($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }
        return response()->json($menu);
    }

    public function store(Request $request)
    {
        $request->validate([
            'menu' => 'required|string',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|integer',
            'kategori' => 'required|in:makanan,minuman,paket',
            'stok' => 'required|integer',
            'status' => 'required|in:tersedia,tidak tersedia',
            'gambar_menu' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('gambar_menu')) {
            $path = $request->file('gambar_menu')->store('menu', 'public');
        }

        $menu = Menu::create([
            'menu' => $request->menu,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'kategori' => $request->kategori,
            'stok' => $request->stok,
            'status' => $request->status,
            'gambar_menu' => $path,
        ]);

        return response()->json($menu, 201);
    }

    public function update(Request $request, $id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        // 1. Validasi Input. Menggunakan 'sometimes' agar hanya memvalidasi field yang dikirimkan
        $validatedData = $request->validate([
            'menu' => 'sometimes|required|string',
            'deskripsi' => 'nullable|string',
            'harga' => 'sometimes|required|integer',
            'kategori' => 'sometimes|required|in:makanan,minuman,paket',
            'stok' => 'sometimes|required|integer',
            'status' => 'sometimes|required|in:tersedia,tidak tersedia',
            'gambar_menu' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Data awal untuk update adalah data yang sudah divalidasi
        $dataToUpdate = $validatedData;

        // 2. Handle Upload Gambar
        if ($request->hasFile('gambar_menu')) {
            // Hapus gambar lama jika ada
            if ($menu->gambar_menu) {
                Storage::disk('public')->delete($menu->gambar_menu);
            }
            $path = $request->file('gambar_menu')->store('menu', 'public');
            $dataToUpdate['gambar_menu'] = $path;
        } else {
            // Jika field gambar_menu ada di validatedData (artinya FE mengirim gambar_menu: null)
            if (isset($dataToUpdate['gambar_menu']) && is_null($dataToUpdate['gambar_menu'])) {
                // User berniat menghapus gambar
                if ($menu->gambar_menu) {
                    Storage::disk('public')->delete($menu->gambar_menu);
                }
                // dataToUpdate['gambar_menu'] sudah null
            } else {
                // Jika tidak ada file dan bukan perintah hapus (null), hapus dari array update
                unset($dataToUpdate['gambar_menu']);
            }
        }

        // 3. Update Kolom Lainnya
        $menu->update($dataToUpdate);

        return response()->json($menu);
    }

    public function destroy($id)
    {
        $menu = Menu::find($id);
        if (!$menu) {
            return response()->json(['message' => 'Menu not found'], 404);
        }

        $menu->delete();
        return response()->json(['message' => 'Deleted']);
    }

    public function gambar($id)
    {
        $menu = Menu::find($id);
        if (!$menu || !$menu->gambar_menu) {
            return response()->json(['message' => 'Gambar tidak ditemukan'], 404);
        }

        // ambil file path
        $path = storage_path('app/public/' . $menu->gambar_menu);

        if (!file_exists($path)) {
            return response()->json(['message' => 'File tidak ditemukan'], 404);
        }

        return response()->file($path);
    }
}
