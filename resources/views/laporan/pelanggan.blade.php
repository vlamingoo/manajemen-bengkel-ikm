@extends('adminlte::page')

@section('title', 'Laporan Pelanggan')

@section('content_header')
    <h1>Laporan Pelanggan Terbanyak Servis</h1>
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
            <form action="{{ route('laporan.pelanggan') }}" method="GET">
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

    {{-- Tabel Pelanggan Terbanyak --}}
    <div class="card">
        <div class="card-header bg-warning">
            <h3 class="card-title">
                <i class="fas fa-users"></i> Pelanggan Terbanyak Servis Bulan {{ date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="bg-dark">
                    <tr>
                        <th width="50">Rank</th>
                        <th>Nama Pelanggan</th>
                        <th>No Telepon</th>
                        <th width="150">Total Servis</th>
                        <th width="200">Total Belanja</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelangganTerbanyak as $pelanggan)
                        <tr>
                            <td class="text-center">
                                @if($loop->iteration == 1)
                                    <span class="badge badge-warning" style="font-size: 16px;">
                                        <i class="fas fa-crown"></i> #{{ $loop->iteration }}
                                    </span>
                                @elseif($loop->iteration == 2)
                                    <span class="badge badge-secondary" style="font-size: 14px;">
                                        <i class="fas fa-star"></i> #{{ $loop->iteration }}
                                    </span>
                                @elseif($loop->iteration == 3)
                                    <span class="badge badge-danger" style="font-size: 14px;">
                                        <i class="fas fa-star"></i> #{{ $loop->iteration }}
                                    </span>
                                @else
                                    <span class="badge badge-info">#{{ $loop->iteration }}</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $pelanggan->nama }}</strong>
                                @if($loop->iteration <= 3)
                                    <span class="badge badge-success ml-2">Top Customer</span>
                                @endif
                            </td>
                            <td>
                                <i class="fas fa-phone text-success"></i> 
                                {{ $pelanggan->no_telp }}
                            </td>
                            <td class="text-center">
                                <span class="badge badge-primary" style="font-size: 14px;">
                                    {{ $pelanggan->total_transaksi }} kali
                                </span>
                            </td>
                            <td>
                                <strong class="text-success">
                                    Rp {{ number_format($pelanggan->total_belanja, 0, ',', '.') }}
                                </strong>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Tidak ada data pelanggan pada periode ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($pelangganTerbanyak->count() > 0)
                    <tfoot>
                        <tr class="bg-light">
                            <th colspan="3" class="text-right">TOTAL:</th>
                            <th class="text-center">
                                <span class="badge badge-primary" style="font-size: 14px;">
                                    {{ $pelangganTerbanyak->sum('total_transaksi') }} servis
                                </span>
                            </th>
                            <th>
                                <strong class="text-success" style="font-size: 16px;">
                                    Rp {{ number_format($pelangganTerbanyak->sum('total_belanja'), 0, ',', '.') }}
                                </strong>
                            </th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

    {{-- Info Cards untuk Top 3 --}}
    @if($pelangganTerbanyak->count() >= 3)
        <div class="row">
            @foreach($pelangganTerbanyak->take(3) as $pelanggan)
                <div class="col-lg-4">
                    <div class="card 
                        @if($loop->iteration == 1) border-warning
                        @elseif($loop->iteration == 2) border-secondary
                        @else border-danger
                        @endif" style="border-width: 3px;">
                        <div class="card-header 
                            @if($loop->iteration == 1) bg-warning
                            @elseif($loop->iteration == 2) bg-secondary
                            @else bg-danger
                            @endif">
                            <h3 class="card-title">
                                <i class="fas fa-{{ $loop->iteration == 1 ? 'crown' : 'star' }}"></i> 
                                Rank #{{ $loop->iteration }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <h4><strong>{{ $pelanggan->nama }}</strong></h4>
                            <p class="text-muted mb-2">
                                <i class="fas fa-phone"></i> {{ $pelanggan->no_telp }}
                            </p>
                            <hr>
                            <p class="mb-1">
                                <strong>Total Servis:</strong> 
                                <span class="badge badge-primary float-right">{{ $pelanggan->total_transaksi }} kali</span>
                            </p>
                            <p class="mb-0">
                                <strong>Total Belanja:</strong><br>
                                <span class="text-success" style="font-size: 18px;">
                                    <strong>Rp {{ number_format($pelanggan->total_belanja, 0, ',', '.') }}</strong>
                                </span>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="card-footer">
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-success float-right">
            <i class="fas fa-print"></i> Print Laporan
        </button>
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