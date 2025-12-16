<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Sparepart;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        return view('laporan.index');
    }

    // Laporan Pendapatan
    public function pendapatan(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        // Total pendapatan per bulan
        $pendapatan = Transaction::whereMonth('tanggal_servis', $bulan)
            ->whereYear('tanggal_servis', $tahun)
            ->sum('total_biaya');

        // Jumlah transaksi
        $jumlahTransaksi = Transaction::whereMonth('tanggal_servis', $bulan)
            ->whereYear('tanggal_servis', $tahun)
            ->count();

        // Transaksi per status
        $statusCount = Transaction::whereMonth('tanggal_servis', $bulan)
            ->whereYear('tanggal_servis', $tahun)
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        // Detail transaksi
        $transactions = Transaction::with(['customer', 'vehicle'])
            ->whereMonth('tanggal_servis', $bulan)
            ->whereYear('tanggal_servis', $tahun)
            ->orderBy('tanggal_servis', 'desc')
            ->get();

        // Pendapatan per hari dalam bulan tersebut
        $pendapatanHarian = Transaction::whereMonth('tanggal_servis', $bulan)
            ->whereYear('tanggal_servis', $tahun)
            ->select(
                DB::raw('DAY(tanggal_servis) as hari'),
                DB::raw('SUM(total_biaya) as total')
            )
            ->groupBy('hari')
            ->orderBy('hari')
            ->get();

        return view('laporan.pendapatan', compact(
            'pendapatan',
            'jumlahTransaksi',
            'statusCount',
            'transactions',
            'pendapatanHarian',
            'bulan',
            'tahun'
        ));
    }

    // Laporan Sparepart Terlaris
    public function sparepart(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $sparepartTerlaris = TransactionDetail::join('transactions', 'transaction_details.transaction_id', '=', 'transactions.id')
            ->join('spareparts', 'transaction_details.sparepart_id', '=', 'spareparts.id')
            ->whereMonth('transactions.tanggal_servis', $bulan)
            ->whereYear('transactions.tanggal_servis', $tahun)
            ->select(
                'spareparts.kode_sparepart',
                'spareparts.nama_sparepart',
                DB::raw('SUM(transaction_details.qty) as total_qty'),
                DB::raw('SUM(transaction_details.subtotal) as total_pendapatan')
            )
            ->groupBy('spareparts.id', 'spareparts.kode_sparepart', 'spareparts.nama_sparepart')
            ->orderBy('total_qty', 'desc')
            ->get();

        return view('laporan.sparepart', compact('sparepartTerlaris', 'bulan', 'tahun'));
    }

    // Laporan Pelanggan
    public function pelanggan(Request $request)
    {
        $bulan = $request->bulan ?? date('m');
        $tahun = $request->tahun ?? date('Y');

        $pelangganTerbanyak = Customer::join('transactions', 'customers.id', '=', 'transactions.customer_id')
            ->whereMonth('transactions.tanggal_servis', $bulan)
            ->whereYear('transactions.tanggal_servis', $tahun)
            ->select(
                'customers.id',
                'customers.nama',
                'customers.no_telp',
                DB::raw('COUNT(transactions.id) as total_transaksi'),
                DB::raw('SUM(transactions.total_biaya) as total_belanja')
            )
            ->groupBy('customers.id', 'customers.nama', 'customers.no_telp')
            ->orderBy('total_transaksi', 'desc')
            ->get();

        return view('laporan.pelanggan', compact('pelangganTerbanyak', 'bulan', 'tahun'));
    }

    // Laporan Grafik (untuk Chart)
    public function grafik()
    {
        // Pendapatan 6 bulan terakhir
        $data = [];
        for ($i = 5; $i >= 0; $i--) {
            $bulan = date('m', strtotime("-$i months"));
            $tahun = date('Y', strtotime("-$i months"));
            
            $pendapatan = Transaction::whereMonth('tanggal_servis', $bulan)
                ->whereYear('tanggal_servis', $tahun)
                ->sum('total_biaya');
            
            $data[] = [
                'bulan' => date('M Y', strtotime("-$i months")),
                'pendapatan' => $pendapatan
            ];
        }

        return view('laporan.grafik', compact('data'));
    }
}