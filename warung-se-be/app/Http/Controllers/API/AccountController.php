<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    // GET semua user beserta role
    public function index()
    {
        $users = Account::with('role')->get();
        return response()->json($users);
    }

    // GET detail user beserta role
    public function show($id)
    {
        $user = Account::with('role')->find($id);
        if(!$user) return response()->json(['message'=>'User not found'],404);
        return response()->json($user);
    }

    // Update profile (nama, no_telp, dan opsional id_role)
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->only('nama_user','no_telp');

        // opsional: update role jika ada dan authorized
        if ($request->has('id_role')) {
            $data['id_role'] = $request->id_role;
        }

        $user->update($data);

        return response()->json($user->load('role'));
    }

    // Hapus user
    public function destroy($id)
    {
        $user = Account::find($id);
        if(!$user) return response()->json(['message'=>'User not found'],404);
        $user->delete();
        return response()->json(['message'=>'Deleted']);
    }
}

