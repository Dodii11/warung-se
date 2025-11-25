<?php

namespace App\Http\Controllers;

use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function index()
    {
        return response()->json(SuperAdmin::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'email_super' => 'required|email|unique:super_admin',
            'nama_super' => 'required|string|max:255',
            'no_telp' => 'required|numeric',
            'password' => 'required|string|min:6',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $superadmin = SuperAdmin::create($data);
        return response()->json($superadmin, 201);
    }

    public function show($id)
    {
        return response()->json(SuperAdmin::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $superadmin = SuperAdmin::findOrFail($id);

        if ($request->has('password')) {
            $request['password'] = Hash::make($request->password);
        }

        $superadmin->update($request->all());
        return response()->json($superadmin);
    }

    public function destroy($id)
    {
        $superadmin = SuperAdmin::findOrFail($id);
        $superadmin->delete();
        return response()->json(null, 204);
    }
}
