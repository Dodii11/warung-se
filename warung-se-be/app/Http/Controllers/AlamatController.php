<?php

namespace App\Http\Controllers;

use App\Models\Alamat;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    public function index()
    {
        return response()->json(Alamat::all());
    }

    public function show($id)
    {
        $alamat = Alamat::find($id);
        if (!$alamat) return response()->json(['message' => 'Alamat not found'], 404);

        return response()->json($alamat);
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'alamat' => 'required|string',
        ]);

        $alamat = Alamat::create($request->all());
        return response()->json($alamat, 201);
    }

    public function update(Request $request, $id)
    {
        $alamat = Alamat::find($id);
        if (!$alamat) return response()->json(['message' => 'Alamat not found'], 404);

        $alamat->update($request->all());
        return response()->json($alamat);
    }

    public function destroy($id)
    {
        $alamat = Alamat::find($id);
        if (!$alamat) return response()->json(['message' => 'Alamat not found'], 404);

        $alamat->delete();
        return response()->json(['message' => 'Deleted']);
    }
}
