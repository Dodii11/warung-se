<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DriverController extends Controller
{
    public function index()
    {
        return response()->json(Driver::all());
    }

    public function show($id)
    {
        $driver = Driver::find($id);
        if(!$driver) return response()->json(['message'=>'Driver not found'],404);
        return response()->json($driver);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_driver'=>'required|string',
            'no_telp'=>'nullable|numeric',
            'tipe_kendaraan'=>'required|in:motor,pick up',
            'plat_kendaraan'=>'nullable|string',
        ]);

        $id = 'DRV'.str_pad(Driver::count()+1,3,'0',STR_PAD_LEFT);

        $driver = Driver::create(array_merge($request->all(),['id_driver'=>$id]));
        return response()->json($driver,201);
    }

    public function update(Request $request,$id)
    {
        $driver = Driver::find($id);
        if(!$driver) return response()->json(['message'=>'Driver not found'],404);
        $driver->update($request->all());
        return response()->json($driver);
    }

    public function destroy($id)
    {
        $driver = Driver::find($id);
        if(!$driver) return response()->json(['message'=>'Driver not found'],404);
        $driver->delete();
        return response()->json(['message'=>'Deleted']);
    }
}
