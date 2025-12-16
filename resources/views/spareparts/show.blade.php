@extends('adminlte::page')

@section('title', 'Detail Sparepart')

@section('content_header')
    <h1>Detail Sparepart</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-box mr-2"></i>
                Informasi Sparepart
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Kode Sparepart</th>
                    <td>
                        <span class="badge badge-secondary badge-lg" style="font-size: 14px;">
                            {{ $sparepart->kode_sparepart }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Nama Sparepart</th>
                    <td><strong>{{ $sparepart->nama_sparepart }}</strong></td>
                </tr>
                <tr>
                    <th>Stok</th>
                    <td>
                        @if($sparepart->stok < 10)
                            <span class="badge badge-danger" style="font-size: 16px;">{{ $sparepart->stok }}</span>
                            <span class="text-danger ml-2">
                                <i class="fas fa-exclamation-triangle"></i> Stok Menipis!
                            </span>
                        @elseif($sparepart->stok < 20)
                            <span class="badge badge-warning" style="font-size: 16px;">{{ $sparepart->stok }}</span>
                            <span class="text-warning ml-2">
                                <i class="fas fa-exclamation-circle"></i> Stok Terbatas
                            </span>
                        @else
                            <span class="badge badge-success" style="font-size: 16px;">{{ $sparepart->stok }}</span>
                            <span class="text-success ml-2">
                                <i class="fas fa-check-circle"></i> Stok Aman
                            </span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Harga</th>
                    <td>
                        <strong class="text-success" style="font-size: 18px;">
                            {{ $sparepart->formatted_harga }}
                        </strong>
                    </td>
                </tr>
                <tr>
                    <th>Satuan</th>
                    <td>{{ ucfirst($sparepart->satuan) }}</td>
                </tr>
                <tr>
                    <th>Keterangan</th>
                    <td>{{ $sparepart->keterangan ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Terdaftar Sejak</th>
                    <td>{{ $sparepart->created_at->format('d F Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Terakhir Diupdate</th>
                    <td>{{ $sparepart->updated_at->format('d F Y, H:i') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('spareparts.edit', $sparepart->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('spareparts.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <form action="{{ route('spareparts.destroy', $sparepart->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus sparepart ini?')">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Info Stok Card --}}
    <div class="row">
        <div class="col-md-4">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $sparepart->stok }}</h3>
                    <p>Stok Tersedia</p>
                </div>
                <div class="icon">
                    <i class="fas fa-boxes"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $sparepart->formatted_harga }}</h3>
                    <p>Harga per {{ ucfirst($sparepart->satuan) }}</p>
                </div>
                <div class="icon">
                    <i class="fas fa-dollar-sign"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ number_format($sparepart->stok * $sparepart->harga, 0, ',', '.') }}</h3>
                    <p>Total Nilai Stok</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calculator"></i>
                </div>
            </div>
        </div>
    </div>
@stop