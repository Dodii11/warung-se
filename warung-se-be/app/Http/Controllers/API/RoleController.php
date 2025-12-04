<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // GET semua role
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    // GET detail role
    public function show($id)
    {
        $role = Role::find($id);
        if(!$role) return response()->json(['message' => 'Role not found'], 404);
        return response()->json($role);
    }

    // CREATE role baru
    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|string|unique:roles,role_name',
        ]);

        $role = Role::create([
            'role_name' => $request->role_name
        ]);

        return response()->json($role, 201);
    }

    // UPDATE role
    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if(!$role) return response()->json(['message' => 'Role not found'], 404);

        $request->validate([
            'role_name' => 'required|string|unique:roles,role_name,' . $role->id_role . ',id_role',
        ]);

        $role->update([
            'role_name' => $request->role_name
        ]);

        return response()->json($role);
    }

    // DELETE role
    public function destroy($id)
    {
        $role = Role::find($id);
        if(!$role) return response()->json(['message' => 'Role not found'], 404);

        // cek apakah ada account yang menggunakan role ini
        if($role->accounts()->count() > 0){
            return response()->json(['message' => 'Cannot delete role assigned to users'], 400);
        }

        $role->delete();
        return response()->json(['message' => 'Role deleted']);
    }
}
