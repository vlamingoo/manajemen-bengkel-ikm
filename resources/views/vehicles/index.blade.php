@extends('adminlte::page')

@section('title', 'Data Kendaraan')

@section('content_header')
    <h1>Data Kendaraan</h1>
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
            <a href="{{ route('vehicles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kendaraan
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Pemilik</th>
                        <th>Merk/Model</th>
                        <th>No Plat</th>
                        <th>Tahun</th>
                        <th>Warna</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $vehicle)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $vehicle->customer->nama }}</td>
                            <td>{{ $vehicle->merk }} {{ $vehicle->model }}</td>
                            <td><span class="badge badge-info">{{ $vehicle->no_plat }}</span></td>
                            <td>{{ $vehicle->tahun }}</td>
                            <td>{{ $vehicle->warna ?? '-' }}</td>
                            <td>
                                <a href="{{ route('vehicles.show', $vehicle->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('vehicles.edit', $vehicle->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" style="display:inline">
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
                            <td colspan="7" class="text-center">Belum ada data kendaraan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $vehicles->links() }}
        </div>
    </div>
@stop