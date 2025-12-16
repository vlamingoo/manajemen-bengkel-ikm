@extends('adminlte::page')

@section('title', 'Data Pelanggan')

@section('content_header')
    <h1>Data Pelanggan</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('customers.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pelanggan
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th>No Telepon</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $customer->nama }}</td>
                            <td>{{ $customer->no_telp }}</td>
                            <td>{{ $customer->alamat }}</td>
                            <td>{{ $customer->email ?? '-' }}</td>
                            <td>
                                <a href="{{ route('customers.show', $customer->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('customers.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('customers.destroy', $customer->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data pelanggan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $customers->links() }}
        </div>
    </div>
@stop