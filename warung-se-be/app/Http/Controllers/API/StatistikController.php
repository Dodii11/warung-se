<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\Pesanan;
use App\Models\Driver;

class StatistikController extends Controller
{
    public function index()
    {
        // Total User (role user)
        $totalUser = Account::whereHas('role', function ($q) {
            $q->where('role_name', 'user');
        })->count();

        // Total Pesanan
        $totalPesanan = Pesanan::count();

        // Total Pendapatan (pesanan selesai)
        $totalPendapatan = Pesanan::where('status', 'selesai')
            ->sum('total_harga');

        // Total Driver
        $totalDriver = Driver::count();

        return response()->json([
            'total_user' => $totalUser,
            'total_pesanan' => $totalPesanan,
            'total_pendapatan' => $totalPendapatan,
            'total_driver' => $totalDriver,
        ]);
    }
}
