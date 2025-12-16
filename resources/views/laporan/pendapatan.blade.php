@extends('adminlte::page')

@section('title', 'Laporan Pendapatan')

@section('content_header')
    <h1>Laporan Pendapatan</h1>
@stop

@section('content')
    {{-- Filter Bulan & Tahun --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter"></i> Filter Periode
            </h3>
        </div>
        <div class="card-body">
            <form action="{{ route('laporan.pendapatan') }}" method="GET">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Bulan</label>
                            <select name="bulan" class="form-control">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ $m }}" {{ $bulan == $m ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Tahun</label>
                            <select name="tahun" class="form-control">
                                @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                                    <option value="{{ $y }}" {{ $tahun == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-search"></i> Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Info Boxes --}}
    <div class="row">
        <div class="col-lg-4 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Rp {{ number_format($pendapatan, 0, ',', '.') }}</h3>
                    <p>Total Pendapatan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $jumlahTransaksi }}</h3>
                    <p>Jumlah Transaksi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>Rp {{ $jumlahTransaksi > 0 ? number_format($pendapatan / $jumlahTransaksi, 0, ',', '.') : 0 }}</h3>
                    <p>Rata-rata per Transaksi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calculator"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Status Transaksi --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-tasks"></i> Status Transaksi
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($statusCount as $status)
                            <div class="col-md-4">
                                <div class="info-box 
                                    @if($status->status == 'proses') bg-warning
                                    @elseif($status->status == 'selesai') bg-success
                                    @else bg-secondary
                                    @endif">
                                    <span class="info-box-icon">
                                        <i class="fas fa-{{ $status->status == 'proses' ? 'hourglass-half' : ($status->status == 'selesai' ? 'check-circle' : 'flag-checkered') }}"></i>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text">{{ strtoupper($status->status) }}</span>
                                        <span class="info-box-number">{{ $status->total }} Transaksi</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Grafik Pendapatan Harian --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-chart-bar"></i> Pendapatan per Hari
            </h3>
        </div>
        <div class="card-body">
            <canvas id="chartPendapatanHarian" height="80"></canvas>
        </div>
    </div>

    {{-- Detail Transaksi --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-list"></i> Detail Transaksi Bulan {{ date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a href="{{ route('transactions.show', $transaction->id) }}">
                                    <span class="badge badge-primary">{{ $transaction->kode_transaksi }}</span>
                                </a>
                            </td>
                            <td>{{ $transaction->tanggal_servis->format('d M Y') }}</td>
                            <td>{{ $transaction->customer->nama }}</td>
                            <td>{{ $transaction->vehicle->merk }} {{ $transaction->vehicle->model }}</td>
                            <td>
                                <strong class="text-success">
                                    Rp {{ number_format($transaction->total_biaya, 0, ',', '.') }}
                                </strong>
                            </td>
                            <td>
                                @if($transaction->status == 'proses')
                                    <span class="badge badge-warning">Proses</span>
                                @elseif($transaction->status == 'selesai')
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-secondary">Diambil</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada transaksi pada periode ini</td>
                        </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr class="bg-light">
                        <th colspan="5" class="text-right">TOTAL:</th>
                        <th colspan="2">
                            <strong class="text-success" style="font-size: 16px;">
                                Rp {{ number_format($pendapatan, 0, ',', '.') }}
                            </strong>
                        </th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card-footer">
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-success float-right">
            <i class="fas fa-print"></i> Print Laporan
        </button>
    </div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data untuk chart
    const labels = [
        @foreach($pendapatanHarian as $item)
            '{{ $item->hari }}',
        @endforeach
    ];
    
    const data = {
        labels: labels,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: [
                @foreach($pendapatanHarian as $item)
                    {{ $item->total }},
                @endforeach
            ],
            backgroundColor: 'rgba(40, 167, 69, 0.2)',
            borderColor: 'rgba(40, 167, 69, 1)',
            borderWidth: 2,
            fill: true
        }]
    };
    
    const config = {
        type: 'line',
        data: data,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                title: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    };
    
    const chartPendapatan = new Chart(
        document.getElementById('chartPendapatanHarian'),
        config
    );
</script>
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