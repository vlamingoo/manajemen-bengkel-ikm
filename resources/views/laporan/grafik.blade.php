@extends('adminlte::page')

@section('title', 'Grafik Pendapatan')

@section('content_header')
    <h1>Grafik Pendapatan 6 Bulan Terakhir</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-danger">
                    <h3 class="card-title">
                        <i class="fas fa-chart-line"></i> Trend Pendapatan
                    </h3>
                </div>
                <div class="card-body">
                    <canvas id="chartPendapatan" height="80"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-table"></i> Detail Pendapatan per Bulan
                    </h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead class="bg-dark">
                            <tr>
                                <th width="30%">Bulan</th>
                                <th width="40%">Pendapatan</th>
                                <th width="30%">Perubahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $index => $item)
                                <tr>
                                    <td><strong>{{ $item['bulan'] }}</strong></td>
                                    <td>
                                        <strong class="text-success" style="font-size: 16px;">
                                            Rp {{ number_format($item['pendapatan'], 0, ',', '.') }}
                                        </strong>
                                    </td>
                                    <td>
                                        @if($index > 0)
                                            @php
                                                $previous = $data[$index - 1]['pendapatan'];
                                                $current = $item['pendapatan'];
                                                
                                                if($previous > 0) {
                                                    $percentage = (($current - $previous) / $previous) * 100;
                                                } else {
                                                    $percentage = $current > 0 ? 100 : 0;
                                                }
                                            @endphp
                                            
                                            @if($percentage > 0)
                                                <span class="badge badge-success">
                                                    <i class="fas fa-arrow-up"></i> {{ number_format($percentage, 1) }}%
                                                </span>
                                            @elseif($percentage < 0)
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-arrow-down"></i> {{ number_format(abs($percentage), 1) }}%
                                                </span>
                                            @else
                                                <span class="badge badge-secondary">
                                                    <i class="fas fa-minus"></i> 0%
                                                </span>
                                            @endif
                                        @else
                                            <span class="badge badge-info">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="bg-light">
                                <th>TOTAL 6 BULAN:</th>
                                <th colspan="2">
                                    <strong class="text-success" style="font-size: 18px;">
                                        Rp {{ number_format(collect($data)->sum('pendapatan'), 0, ',', '.') }}
                                    </strong>
                                </th>
                            </tr>
                            <tr class="bg-light">
                                <th>RATA-RATA per BULAN:</th>
                                <th colspan="2">
                                    <strong class="text-info" style="font-size: 16px;">
                                        Rp {{ number_format(collect($data)->avg('pendapatan'), 0, ',', '.') }}
                                    </strong>
                                </th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Info Summary --}}
    <div class="row">
        <div class="col-lg-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>Rp {{ number_format(collect($data)->max('pendapatan'), 0, ',', '.') }}</h3>
                    <p>Pendapatan Tertinggi</p>
                </div>
                <div class="icon">
                    <i class="fas fa-arrow-up"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>Rp {{ number_format(collect($data)->min('pendapatan'), 0, ',', '.') }}</h3>
                    <p>Pendapatan Terendah</p>
                </div>
                <div class="icon">
                    <i class="fas fa-arrow-down"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>Rp {{ number_format(collect($data)->avg('pendapatan'), 0, ',', '.') }}</h3>
                    <p>Rata-rata per Bulan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer">
        <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <button onclick="window.print()" class="btn btn-success float-right">
            <i class="fas fa-print"></i> Print Grafik
        </button>
    </div>
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const dataPendapatan = {
        labels: [
            @foreach($data as $item)
                '{{ $item['bulan'] }}',
            @endforeach
        ],
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: [
                @foreach($data as $item)
                    {{ $item['pendapatan'] }},
                @endforeach
            ],
            backgroundColor: 'rgba(220, 53, 69, 0.2)',
            borderColor: 'rgba(220, 53, 69, 1)',
            borderWidth: 3,
            fill: true,
            tension: 0.4,
            pointRadius: 6,
            pointHoverRadius: 8,
            pointBackgroundColor: 'rgba(220, 53, 69, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2
        }]
    };
    
    const configPendapatan = {
        type: 'line',
        data: dataPendapatan,
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Trend Pendapatan 6 Bulan Terakhir',
                    font: {
                        size: 16
                    }
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
    
    new Chart(
        document.getElementById('chartPendapatan'),
        configPendapatan
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