<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{

    public function me(Request $request)
    {
        // $request->user() akan mengembalikan user yang token-nya valid
        $user = $request->user();

        if (!$user) {
            // Ini seharusnya tidak terjadi jika sanctum bekerja dengan benar sebelum masuk sini
            return response()->json(['message' => 'User not authenticated'], 401);
        }

        // Load relasi 'role' agar role_name bisa diakses
        $user->load('role');

        // Kembalikan data user beserta role-nya
        // Pastikan struktur ini sesuai dengan yang dibutuhkan oleh FE di authStore
        return response()->json([
            'id_user' => $user->id_user,
            'nama_user' => $user->nama_user,
            'email_user' => $user->email_user,
            'id_role' => $user->id_role,
            'role' => $user->role->role_name, // <-- Ini penting untuk guard di FE
            'no_telp' => $user->no_telp,
            'status' => $user->status,
            // Tambahkan field lain jika diperlukan
        ]);
    }

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
        if (!$user) return response()->json(['message' => 'User not found'], 404);
        return response()->json($user);
    }

    // Update profile (nama, no_telp, dan opsional id_role)
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->only('nama_user', 'no_telp');

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
        if (!$user) return response()->json(['message' => 'User not found'], 404);
        $user->delete();
        return response()->json(['message' => 'Deleted']);
    }

    // filter user untuk manajemen user
    public function indexUser()
    {
        return Account::with('role')
            ->whereHas('role', function ($q) {
                $q->where('role_name', 'user');
            })
            ->get();
    }

    // HANYA ADMIN (tanpa super admin)
    public function indexAdmin()
    {
        return Account::with('role')
            ->whereHas('role', function ($q) {
                $q->where('role_name', 'admin');
            })
            ->get();
    }

    public function storeAdmin(Request $request)
    {
        $data = $request->validate([
            'nama_user' => 'required|string',
            'email_user' => 'required|email|unique:account,email_user',
            'password' => 'required|min:8',
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['id_role'] = \App\Models\Role::where('role_name', 'admin')->value('id_role');
        $data['status'] = 'aktif';

        return Account::create($data);
    }

    public function updateByAdmin(Request $request, $id)
    {
        $user = Account::findOrFail($id);

        $request->validate([
            'nama_user' => 'required|string',
            'email_user' => 'required|email|unique:account,email_user,' . $id . ',id_user',
            'status' => 'required|in:aktif,tidak aktif',
            'password' => 'nullable|min:8',
        ]);

        $data = $request->only([
            'nama_user',
            'email_user',
            'status',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return response()->json($user->load('role'));
    }
}
