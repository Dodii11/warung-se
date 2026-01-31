<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    public function index()
    {
        return response()->json(Driver::all());
    }

    public function show($id)
    {
        $driver = Driver::find($id);
        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => 'Driver not found'
            ], 404);
        }

        return response()->json($driver);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_driver'     => 'required|string|max:100',
            'no_telp'         => 'nullable|numeric',
            'status'          => 'in:aktif,tidak aktif',
            'tipe_kendaraan'  => 'required|in:motor,pick up',
            'plat_kendaraan'  => 'nullable|string|max:20',
            'gambar_driver'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $id = 'DRV' . str_pad(Driver::count() + 1, 3, '0', STR_PAD_LEFT);

        $data = $request->all();
        $data['id_driver'] = $id;

        if ($request->hasFile('gambar_driver')) {
            $path = $request->file('gambar_driver')
                ->store('driver', 'public');
            $data['gambar_driver'] = $path;
        }

        $driver = Driver::create($data);

        return response()->json([
            'success' => true,
            'data' => $driver
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::find($id);
        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => 'Driver not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'nama_driver'     => 'sometimes|required|string|max:100',
            'no_telp'         => 'nullable|numeric',
            'status'          => 'in:aktif,tidak aktif',
            'tipe_kendaraan'  => 'in:motor,pick up',
            'plat_kendaraan'  => 'nullable|string|max:20',
            'gambar_driver'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors'  => $validator->errors()
            ], 422);
        }

        $data = $request->all();

        if ($request->hasFile('gambar_driver')) {
            // hapus gambar lama
            if ($driver->gambar_driver) {
                Storage::disk('public')->delete($driver->gambar_driver);
            }

            $path = $request->file('gambar_driver')
                ->store('driver', 'public');
            $data['gambar_driver'] = $path;
        }

        $driver->update($data);

        return response()->json([
            'success' => true,
            'data' => $driver
        ]);
    }

    public function destroy($id)
    {
        $driver = Driver::find($id);
        if (!$driver) {
            return response()->json([
                'success' => false,
                'message' => 'Driver not found'
            ], 404);
        }

        if ($driver->gambar_driver) {
            Storage::disk('public')->delete($driver->gambar_driver);
        }

        $driver->delete();

        return response()->json([
            'success' => true,
            'message' => 'Driver deleted'
        ]);
    }
}
