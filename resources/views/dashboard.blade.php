@extends('adminlte::page')

@section('title', 'Dashboard Manajemen Bengkel')

@section('content_header')
    <h1 class="m-0 text-dark">Dashboard Manajemen Bengkel</h1>
@stop

@section('content')
    {{-- Info Boxes --}}
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Pelanggan</span>
                    <span class="info-box-number">{{ $totalCustomers }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-car"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Kendaraan</span>
                    <span class="info-box-number">{{ $totalVehicles }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-wrench"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Servis Bulan Ini</span>
                    <span class="info-box-number">{{ $transaksisBulanIni }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-chart-line"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Pendapatan Bulan Ini</span>
                    <span class="info-box-number">
                        Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Transaksi --}}
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $transaksiProses }}</h3>
                    <p>Transaksi Proses</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <a href="{{ route('transactions.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $transaksiSelesai }}</h3>
                    <p>Transaksi Selesai</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <a href="{{ route('transactions.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $transaksiDiambil }}</h3>
                    <p>Kendaraan Diambil</p>
                </div>
                <div class="icon">
                    <i class="fas fa-flag-checkered"></i>
                </div>
                <a href="{{ route('transactions.index') }}" class="small-box-footer">
                    Lihat Detail <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Transaksi Terbaru --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-history mr-1"></i>
                        Transaksi Terbaru
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-eye"></i> Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Pelanggan</th>
                                <th>Kendaraan</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transaksisTerbaru as $transaksi)
                                <tr>
                                    <td>
                                        <a href="{{ route('transactions.show', $transaksi->id) }}">
                                            <span class="badge badge-primary">{{ $transaksi->kode_transaksi }}</span>
                                        </a>
                                    </td>
                                    <td>{{ $transaksi->customer->nama }}</td>
                                    <td>
                                        {{ $transaksi->vehicle->merk }} {{ $transaksi->vehicle->model }}
                                        <br>
                                        <small class="text-muted">{{ $transaksi->vehicle->no_plat }}</small>
                                    </td>
                                    <td>
                                        <strong class="text-success">
                                            Rp {{ number_format($transaksi->total_biaya, 0, ',', '.') }}
                                        </strong>
                                    </td>
                                    <td>
                                        @if($transaksi->status == 'proses')
                                            <span class="badge badge-warning">Proses</span>
                                        @elseif($transaksi->status == 'selesai')
                                            <span class="badge badge-success">Selesai</span>
                                        @else
                                            <span class="badge badge-secondary">Diambil</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">
                                        Belum ada transaksi
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Stok Sparepart Menipis --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header border-0">
                    <h3 class="card-title">
                        <i class="fas fa-exclamation-triangle text-danger mr-1"></i>
                        Stok Menipis
                    </h3>
                    <div class="card-tools">
                        <a href="{{ route('spareparts.index') }}" class="btn btn-sm btn-warning">
                            <i class="fas fa-box"></i> Kelola Stok
                        </a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($sparepartsMenurun as $sparepart)
                            <li class="list-group-item">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong>{{ $sparepart->nama_sparepart }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $sparepart->kode_sparepart }}</small>
                                    </div>
                                    <span class="badge badge-danger badge-pill" style="font-size: 14px;">
                                        {{ $sparepart->stok }}
                                    </span>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center text-muted">
                                <i class="fas fa-check-circle text-success"></i> 
                                Semua stok aman!
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions --}}
<div class="row mt-3 mb-3">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-0">
                <h3 class="card-title">
                    <i class="fas fa-bolt mr-1"></i>
                    Aksi Cepat
                </h3>
            </div>
            <div class="card-body" style="padding: 30px;">
                <div class="row">
                    {{-- Tombol Transaksi - Admin & Karyawan ONLY --}}
                    @role('admin', 'karyawan')
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                            <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-block" style="padding: 30px 20px; font-size: 16px; border-radius: 10px;">
                                <i class="fas fa-plus-circle" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                                <strong>Transaksi Baru</strong>
                            </a>
                        </div>
                    @endrole
                    
                    {{-- Tombol Pelanggan - Admin & Karyawan ONLY --}}
                    @role('admin', 'karyawan')
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                            <a href="{{ route('customers.create') }}" class="btn btn-info btn-block" style="padding: 30px 20px; font-size: 16px; border-radius: 10px;">
                                <i class="fas fa-user-plus" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                                <strong>Tambah Pelanggan</strong>
                            </a>
                        </div>
                    @endrole
                    
                    {{-- Tombol Kendaraan - Admin & Karyawan ONLY --}}
                    @role('admin', 'karyawan')
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                            <a href="{{ route('vehicles.create') }}" class="btn btn-warning btn-block" style="padding: 30px 20px; font-size: 16px; border-radius: 10px;">
                                <i class="fas fa-car" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                                <strong>Tambah Kendaraan</strong>
                            </a>
                        </div>
                    @endrole
                    
                    {{-- Tombol Sparepart - Admin & Karyawan ONLY --}}
                    @role('admin', 'karyawan')
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                            <a href="{{ route('spareparts.create') }}" class="btn btn-success btn-block" style="padding: 30px 20px; font-size: 16px; border-radius: 10px;">
                                <i class="fas fa-box" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                                <strong>Tambah Sparepart</strong>
                            </a>
                        </div>
                    @endrole
                    
                    {{-- Tombol Laporan - Owner & Admin ONLY --}}
                    @role('owner', 'admin')
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                            <a href="{{ route('laporan.index') }}" class="btn btn-danger btn-block" style="padding: 30px 20px; font-size: 16px; border-radius: 10px;">
                                <i class="fas fa-chart-line" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                                <strong>Lihat Laporan</strong>
                            </a>
                        </div>
                    @endrole
                    
                    {{-- Tombol Kelola User - Admin ONLY --}}
                    @role('admin')
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                            <a href="{{ route('users.index') }}" class="btn btn-secondary btn-block" style="padding: 30px 20px; font-size: 16px; border-radius: 10px;">
                                <i class="fas fa-users-cog" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                                <strong>Kelola User</strong>
                            </a>
                        </div>
                    @endrole
                    
                    {{-- Jika Owner, tampilkan tombol khusus owner --}}
                    @role('owner')
                        <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-3">
                            <a href="{{ route('transactions.index') }}" class="btn btn-info btn-block" style="padding: 30px 20px; font-size: 16px; border-radius: 10px;">
                                <i class="fas fa-list" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                                <strong>Lihat Transaksi</strong>
                            </a>
                        </div>
                    @endrole
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .info-box-number {
            font-weight: bold;
        }
        .small-box .icon {
            font-size: 70px;
        }
    </style>
@stop