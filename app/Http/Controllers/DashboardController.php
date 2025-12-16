<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Transaction;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung data statistik
        $totalCustomers = Customer::count();
        $totalVehicles = Vehicle::count();
        $totalSpareparts = Sparepart::sum('stok');
        
        // Transaksi bulan ini
        $transaksisBulanIni = Transaction::whereMonth('tanggal_servis', date('m'))
            ->whereYear('tanggal_servis', date('Y'))
            ->count();
        
        // Pendapatan bulan ini
        $pendapatanBulanIni = Transaction::whereMonth('tanggal_servis', date('m'))
            ->whereYear('tanggal_servis', date('Y'))
            ->sum('total_biaya');
        
        // Transaksi terbaru (5 terakhir)
        $transaksisTerbaru = Transaction::with(['customer', 'vehicle'])
            ->latest()
            ->take(5)
            ->get();
        
        // Sparepart stok menipis (kurang dari 10)
        $sparepartsMenurun = Sparepart::where('stok', '<', 10)
            ->orderBy('stok', 'asc')
            ->take(5)
            ->get();
        
        // Data untuk chart - Transaksi per bulan (6 bulan terakhir)
        $chartData = Transaction::select(
                DB::raw('MONTH(tanggal_servis) as bulan'),
                DB::raw('COUNT(*) as total')
            )
            ->where('tanggal_servis', '>=', now()->subMonths(6))
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get();
        
        // Transaksi berdasarkan status
        $transaksiProses = Transaction::where('status', 'proses')->count();
        $transaksiSelesai = Transaction::where('status', 'selesai')->count();
        $transaksiDiambil = Transaction::where('status', 'diambil')->count();

        return view('dashboard', compact(
            'totalCustomers',
            'totalVehicles',
            'totalSpareparts',
            'transaksisBulanIni',
            'pendapatanBulanIni',
            'transaksisTerbaru',
            'sparepartsMenurun',
            'chartData',
            'transaksiProses',
            'transaksiSelesai',
            'transaksiDiambil'
        ));
    }
}