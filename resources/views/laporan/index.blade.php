@extends('adminlte::page')

@section('title', 'Laporan')

@section('content_header')
    <h1>Laporan & Statistik</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Pendapatan</h3>
                    <p>Laporan Pendapatan per Periode</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <a href="{{ route('laporan.pendapatan') }}" class="small-box-footer">
                    Lihat Laporan <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Sparepart</h3>
                    <p>Sparepart Terlaris</p>
                </div>
                <div class="icon">
                    <i class="fas fa-box"></i>
                </div>
                <a href="{{ route('laporan.sparepart') }}" class="small-box-footer">
                    Lihat Laporan <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Pelanggan</h3>
                    <p>Pelanggan Terbanyak</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="{{ route('laporan.pelanggan') }}" class="small-box-footer">
                    Lihat Laporan <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>Grafik</h3>
                    <p>Grafik Pendapatan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <a href="{{ route('laporan.grafik') }}" class="small-box-footer">
                    Lihat Grafik <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle mr-2"></i>
                        Informasi Laporan
                    </h3>
                </div>
                <div class="card-body">
                    <p><strong>Laporan yang Tersedia:</strong></p>
                    <ul>
                        <li><strong>Laporan Pendapatan:</strong> Melihat total pendapatan per bulan, jumlah transaksi, dan detail per hari</li>
                        <li><strong>Laporan Sparepart:</strong> Melihat sparepart yang paling banyak digunakan dan pendapatan dari masing-masing sparepart</li>
                        <li><strong>Laporan Pelanggan:</strong> Melihat pelanggan yang paling sering servis dan total belanja mereka</li>
                        <li><strong>Grafik Pendapatan:</strong> Visualisasi pendapatan 6 bulan terakhir dalam bentuk grafik</li>
                    </ul>
                    <p class="mt-3">
                        <i class="fas fa-user-shield text-info"></i> 
                        <strong>Akses:</strong> Laporan hanya dapat diakses oleh <span class="badge badge-danger">ADMIN</span> dan <span class="badge badge-warning">OWNER</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
@stop