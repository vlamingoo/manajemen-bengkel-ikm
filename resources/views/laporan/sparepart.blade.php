@extends('adminlte::page')

@section('title', 'Laporan Sparepart Terlaris')

@section('content_header')
    <h1>Laporan Sparepart Terlaris</h1>
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
            <form action="{{ route('laporan.sparepart') }}" method="GET">
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

    {{-- Tabel Sparepart Terlaris --}}
    <div class="card">
        <div class="card-header bg-success">
            <h3 class="card-title">
                <i class="fas fa-box"></i> Sparepart Terlaris Bulan {{ date('F Y', mktime(0, 0, 0, $bulan, 1, $tahun)) }}
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead class="bg-dark">
                    <tr>
                        <th width="50">Rank</th>
                        <th>Kode</th>
                        <th>Nama Sparepart</th>
                        <th width="150">Total Terjual</th>
                        <th width="200">Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sparepartTerlaris as $sparepart)
                        <tr>
                            <td class="text-center">
                                @if($loop->iteration == 1)
                                    <span class="badge badge-warning" style="font-size: 16px;">
                                        <i class="fas fa-trophy"></i> #{{ $loop->iteration }}
                                    </span>
                                @elseif($loop->iteration == 2)
                                    <span class="badge badge-secondary" style="font-size: 14px;">
                                        <i class="fas fa-medal"></i> #{{ $loop->iteration }}
                                    </span>
                                @elseif($loop->iteration == 3)
                                    <span class="badge badge-danger" style="font-size: 14px;">
                                        <i class="fas fa-medal"></i> #{{ $loop->iteration }}
                                    </span>
                                @else
                                    <span class="badge badge-info">#{{ $loop->iteration }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-secondary">{{ $sparepart->kode_sparepart }}</span>
                            </td>
                            <td><strong>{{ $sparepart->nama_sparepart }}</strong></td>
                            <td class="text-center">
                                <span class="badge badge-primary" style="font-size: 14px;">
                                    {{ $sparepart->total_qty }} unit
                                </span>
                            </td>
                            <td>
                                <strong class="text-success">
                                    Rp {{ number_format($sparepart->total_pendapatan, 0, ',', '.') }}
                                </strong>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">
                                Tidak ada data sparepart pada periode ini
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if($sparepartTerlaris->count() > 0)
                    <tfoot>
                        <tr class="bg-light">
                            <th colspan="3" class="text-right">TOTAL:</th>
                            <th class="text-center">
                                <span class="badge badge-primary" style="font-size: 14px;">
                                    {{ $sparepartTerlaris->sum('total_qty') }} unit
                                </span>
                            </th>
                            <th>
                                <strong class="text-success" style="font-size: 16px;">
                                    Rp {{ number_format($sparepartTerlaris->sum('total_pendapatan'), 0, ',', '.') }}
                                </strong>
                            </th>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>
    </div>

    {{-- Chart Sparepart --}}
    @if($sparepartTerlaris->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-chart-pie"></i> Grafik Sparepart Terlaris
                </h3>
            </div>
            <div class="card-body">
                <canvas id="chartSparepart" height="80"></canvas>
            </div>
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

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    @if($sparepartTerlaris->count() > 0)
    const dataSparepart = {
        labels: [
            @foreach($sparepartTerlaris->take(10) as $item)
                '{{ $item->nama_sparepart }}',
            @endforeach
        ],
        datasets: [{
            label: 'Jumlah Terjual',
            data: [
                @foreach($sparepartTerlaris->take(10) as $item)
                    {{ $item->total_qty }},
                @endforeach
            ],
            backgroundColor: [
                'rgba(255, 99, 132, 0.7)',
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)',
                'rgba(75, 192, 192, 0.7)',
                'rgba(153, 102, 255, 0.7)',
                'rgba(255, 159, 64, 0.7)',
                'rgba(199, 199, 199, 0.7)',
                'rgba(83, 102, 255, 0.7)',
                'rgba(255, 102, 255, 0.7)',
                'rgba(102, 255, 102, 0.7)',
            ],
            borderWidth: 2
        }]
    };
    
    const configSparepart = {
        type: 'bar',
        data: dataSparepart,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: true,
                    text: 'Top 10 Sparepart Terlaris'
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    };
    
    new Chart(
        document.getElementById('chartSparepart'),
        configSparepart
    );
    @endif
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