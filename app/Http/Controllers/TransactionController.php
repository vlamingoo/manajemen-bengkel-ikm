<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Customer;
use App\Models\Vehicle;
use App\Models\Sparepart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['customer', 'vehicle'])->latest()->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $customers = Customer::all();
        $spareparts = Sparepart::where('stok', '>', 0)->get();
        $kodeTransaksi = Transaction::generateKode();
        $jenisServis = config('bengkel.jenis_servis');
        
        return view('transactions.create', compact('customers', 'spareparts', 'kodeTransaksi', 'jenisServis'));
    }

    public function getVehicles($customerId)
    {
        $vehicles = Vehicle::where('customer_id', $customerId)->get();
        return response()->json($vehicles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'vehicle_id' => 'required|exists:vehicles,id',
            'tanggal_servis' => 'required|date',
            'keluhan' => 'required',
            'biaya_jasa' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();
        try {
            // Hitung total biaya sparepart
            $totalSparepart = 0;
            if ($request->sparepart_id) {
                foreach ($request->sparepart_id as $key => $sparepartId) {
                    if ($sparepartId && $request->qty[$key] > 0) {
                        $sparepart = Sparepart::find($sparepartId);
                        $subtotal = $sparepart->harga * $request->qty[$key];
                        $totalSparepart += $subtotal;
                    }
                }
            }

            // Total biaya = biaya jasa + total sparepart
            $totalBiaya = $request->biaya_jasa + $totalSparepart;

            // Simpan transaksi
            $transaction = Transaction::create([
                'kode_transaksi' => Transaction::generateKode(),
                'customer_id' => $request->customer_id,
                'vehicle_id' => $request->vehicle_id,
                'tanggal_servis' => $request->tanggal_servis,
                'keluhan' => $request->keluhan,
                'tindakan' => $request->tindakan,
                'biaya_jasa' => $request->biaya_jasa,
                'total_biaya' => $totalBiaya,
                'status' => 'proses',
                'keterangan' => $request->keterangan,
            ]);

            // Simpan detail sparepart
            if ($request->sparepart_id) {
                foreach ($request->sparepart_id as $key => $sparepartId) {
                    if ($sparepartId && $request->qty[$key] > 0) {
                        $sparepart = Sparepart::find($sparepartId);
                        
                        // Kurangi stok
                        $sparepart->decrement('stok', $request->qty[$key]);
                        
                        // Simpan detail
                        TransactionDetail::create([
                            'transaction_id' => $transaction->id,
                            'sparepart_id' => $sparepartId,
                            'qty' => $request->qty[$key],
                            'harga' => $sparepart->harga,
                            'subtotal' => $sparepart->harga * $request->qty[$key],
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('transactions.index')
                ->with('success', 'Transaksi servis berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load(['customer', 'vehicle', 'details.sparepart']);
        return view('transactions.show', compact('transaction'));
    }

    public function edit(Transaction $transaction)
    {
        $customers = Customer::all();
        $spareparts = Sparepart::all();
        $transaction->load(['details']);
        
        return view('transactions.edit', compact('transaction', 'customers', 'spareparts'));
    }

    public function update(Request $request, Transaction $transaction)
    {
        $request->validate([
            'status' => 'required|in:proses,selesai,diambil',
            'tindakan' => 'nullable',
            'keterangan' => 'nullable',
        ]);

        $transaction->update([
            'status' => $request->status,
            'tindakan' => $request->tindakan,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil diupdate!');
    }

    public function destroy(Transaction $transaction)
    {
        // Kembalikan stok sparepart
        foreach ($transaction->details as $detail) {
            $detail->sparepart->increment('stok', $detail->qty);
        }

        $transaction->delete();

        return redirect()->route('transactions.index')
            ->with('success', 'Transaksi berhasil dihapus!');
    }
}