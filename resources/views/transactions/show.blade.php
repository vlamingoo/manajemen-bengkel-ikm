@extends('adminlte::page')

@section('title', 'Detail Transaksi Servis')

@section('content_header')
    <h1>Detail Transaksi Servis</h1>
@stop

@section('content')
    {{-- Header Info --}}
    <div class="row">
        <div class="col-md-4">
            <div class="info-box bg-info">
                <span class="info-box-icon"><i class="fas fa-receipt"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Kode Transaksi</span>
                    <span class="info-box-number">{{ $transaction->kode_transaksi }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fas fa-money-bill-wave"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Biaya</span>
                    <span class="info-box-number">{{ $transaction->formatted_total_biaya }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box 
                @if($transaction->status == 'proses') bg-warning
                @elseif($transaction->status == 'selesai') bg-primary
                @else bg-secondary
                @endif">
                <span class="info-box-icon"><i class="fas fa-tasks"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Status</span>
                    <span class="info-box-number">{{ strtoupper($transaction->status) }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Data Pelanggan & Kendaraan --}}
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="card-title">
                        <i class="fas fa-user"></i> Data Pelanggan
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="150">Nama</th>
                            <td><strong>{{ $transaction->customer->nama }}</strong></td>
                        </tr>
                        <tr>
                            <th>No Telepon</th>
                            <td>
                                <i class="fas fa-phone text-success"></i> 
                                {{ $transaction->customer->no_telp }}
                            </td>
                        </tr>
                        <tr>
                            <th>Alamat</th>
                            <td>{{ $transaction->customer->alamat }}</td>
                        </tr>
                        <tr>
                            <th>Email</th>
                            <td>{{ $transaction->customer->email ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-info">
                    <h3 class="card-title">
                        <i class="fas fa-car"></i> Data Kendaraan
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th width="150">Merk</th>
                            <td>{{ $transaction->vehicle->merk }}</td>
                        </tr>
                        <tr>
                            <th>Model</th>
                            <td>{{ $transaction->vehicle->model }}</td>
                        </tr>
                        <tr>
                            <th>No Plat</th>
                            <td>
                                <span class="badge badge-info badge-lg" style="font-size: 16px;">
                                    {{ $transaction->vehicle->no_plat }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Tahun</th>
                            <td>{{ $transaction->vehicle->tahun }}</td>
                        </tr>
                        <tr>
                            <th>Warna</th>
                            <td>{{ $transaction->vehicle->warna ?? '-' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Keluhan & Tindakan --}}
    <div class="card">
        <div class="card-header bg-warning">
            <h3 class="card-title">
                <i class="fas fa-clipboard-list"></i> Keluhan & Tindakan
            </h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-exclamation-circle text-danger"></i> Keluhan:</h5>
                    <p class="border p-3 bg-light">{{ $transaction->keluhan }}</p>
                </div>
                <div class="col-md-6">
                    <h5><i class="fas fa-wrench text-success"></i> Tindakan/Perbaikan:</h5>
                    <p class="border p-3 bg-light">{{ $transaction->tindakan ?? 'Belum ada tindakan dicatat' }}</p>
                </div>
            </div>
            
            @if($transaction->keterangan)
                <div class="mt-3">
                    <h5><i class="fas fa-sticky-note text-info"></i> Keterangan Tambahan:</h5>
                    <p class="border p-3 bg-light">{{ $transaction->keterangan }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Detail Sparepart --}}
    <div class="card">
        <div class="card-header bg-success">
            <h3 class="card-title">
                <i class="fas fa-box"></i> Sparepart yang Digunakan
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="bg-dark">
                    <tr>
                        <th width="50">No</th>
                        <th>Kode</th>
                        <th>Nama Sparepart</th>
                        <th width="150">Harga Satuan</th>
                        <th width="100">Qty</th>
                        <th width="150">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaction->details as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge badge-secondary">
                                    {{ $detail->sparepart->kode_sparepart }}
                                </span>
                            </td>
                            <td>{{ $detail->sparepart->nama_sparepart }}</td>
                            <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="badge badge-primary">{{ $detail->qty }}</span>
                            </td>
                            <td>
                                <strong>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</strong>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                <i class="fas fa-info-circle"></i> Tidak ada sparepart digunakan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Rincian Biaya --}}
    <div class="card">
        <div class="card-header bg-secondary">
            <h3 class="card-title">
                <i class="fas fa-calculator"></i> Rincian Biaya
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="70%">Biaya Sparepart:</th>
                    <td class="text-right">
                        <strong>Rp {{ number_format($transaction->details->sum('subtotal'), 0, ',', '.') }}</strong>
                    </td>
                </tr>
                <tr>
                    <th>Biaya Jasa:</th>
                    <td class="text-right">
                        <strong>Rp {{ number_format($transaction->biaya_jasa, 0, ',', '.') }}</strong>
                    </td>
                </tr>
                <tr class="bg-light">
                    <th style="font-size: 18px;">TOTAL BIAYA:</th>
                    <td class="text-right text-success" style="font-size: 20px;">
                        <strong>{{ $transaction->formatted_total_biaya }}</strong>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    {{-- Timestamp Info --}}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <p>
                        <i class="fas fa-calendar-plus text-info"></i> 
                        <strong>Dibuat:</strong> {{ $transaction->created_at->format('d F Y, H:i') }}
                    </p>
                </div>
                <div class="col-md-6">
                    <p>
                        <i class="fas fa-calendar-check text-success"></i> 
                        <strong>Terakhir Update:</strong> {{ $transaction->updated_at->format('d F Y, H:i') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="card">
        <div class="card-footer">
            <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit Status
            </a>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus transaksi ini? Stok sparepart akan dikembalikan.')">
                    <i class="fas fa-trash"></i> Hapus Transaksi
                </button>
            </form>
            
            <button class="btn btn-success float-right" onclick="window.print()">
                <i class="fas fa-print"></i> Print Invoice
            </button>
        </div>
    </div>
@stop

@section('css')
<style>
    @media print {
        .main-sidebar, .main-header, .content-header, .card-footer, .btn {
            display: none !important;
        }
    }
</style>
@stop