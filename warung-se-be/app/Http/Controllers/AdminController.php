<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
    {
        return response()->json(Admin::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'email_admin' => 'required|email|unique:admin',
            'nama_admin' => 'required|string|max:255',
            'no_telp' => 'required|numeric',
            'password' => 'required|string|min:6',
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $admin = Admin::create($data);
        return response()->json($admin, 201);
    }

    public function show($id)
    {
        return response()->json(Admin::findOrFail($id));
    }

    public function update(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        if ($request->has('password')) {
            $request['password'] = Hash::make($request->password);
        }

        $admin->update($request->all());
        return response()->json($admin);
    }

    public function destroy($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();
        return response()->json(null, 204);
    }
}
