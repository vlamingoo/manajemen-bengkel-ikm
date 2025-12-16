@extends('adminlte::page')

@section('title', 'Detail Pelanggan')

@section('content_header')
    <h1>Detail Pelanggan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Informasi Pelanggan</h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Nama</th>
                    <td>{{ $customer->nama }}</td>
                </tr>
                <tr>
                    <th>No Telepon</th>
                    <td>{{ $customer->no_telp }}</td>
                </tr>
                <tr>
                    <th>Alamat</th>
                    <td>{{ $customer->alamat }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $customer->email ?? '-' }}</td>
                </tr>
                <tr>
                    <th>Terdaftar Sejak</th>
                    <td>{{ $customer->created_at->format('d F Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Terakhir Diupdate</th>
                    <td>{{ $customer->updated_at->format('d F Y, H:i') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                    <i class="fas fa-trash"></i> Hapus
                </button>
            </form>
        </div>
    </div>
@stop