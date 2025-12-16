@extends('adminlte::page')

@section('title', 'Detail Kendaraan')

@section('content_header')
    <h1>Detail Kendaraan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-car mr-2"></i>
                Informasi Kendaraan
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Pemilik</th>
                    <td>
                        <strong>{{ $vehicle->customer->nama }}</strong>
                        <br>
                        <small class="text-muted">
                            <i class="fas fa-phone"></i> {{ $vehicle->customer->no_telp }}
                        </small>
                    </td>
                </tr>
                <tr>
                    <th>Merk</th>
                    <td>{{ $vehicle->merk }}</td>
                </tr>
                <tr>
                    <th>Model</th>
                    <td>{{ $vehicle->model }}</td>
                </tr>
                <tr>
                    <th>No Plat</th>
                    <td>
                        <span class="badge badge-info badge-lg" style="font-size: 16px;">
                            {{ $vehicle->no_plat }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Tahun</th>
                    <td>{{ $vehicle->tahun }}</td>
                </tr>
                <tr>
                    <th>Warna</th>
                    <td>{{ $vehicle->warna ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Terdaftar Sejak</th>
                    <td>{{ $vehicle->created_at->format('d F Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Terakhir Diupdate</th>
                    <td>{{ $vehicle->updated_at->format('d F Y, H:i') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus kendaraan ini?')">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Riwayat Servis (Opsional - bisa ditambahkan nanti) --}}
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-history mr-2"></i>
                Riwayat Servis
            </h3>
        </div>
        <div class="card-body">
            <p class="text-muted">Belum ada riwayat servis untuk kendaraan ini.</p>
            {{-- Nanti bisa ditambahkan ketika sudah bikin CRUD Transaksi Servis --}}
        </div>
    </div>
@stop