<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        return response()->json(Driver::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_driver' => 'required|string|max:255',
            'no_telp' => 'required|numeric',
        ]);

        $driver = Driver::create($request->all());
        return response()->json($driver, 201);
    }

    public function show($id)
    {
        return response()->json(Driver::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $driver = Driver::findOrFail($id);
        $driver->update($request->all());
        return response()->json($driver);
    }

    public function destroy($id)
    {
        $driver = Driver::findOrFail($id);
        $driver->delete();
        return response()->json(null, 204);
    }
}
