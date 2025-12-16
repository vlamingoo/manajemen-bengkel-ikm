@extends('adminlte::page')

@section('title', 'Data Sparepart')

@section('content_header')
    <h1>Data Sparepart</h1>
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
            <a href="{{ route('spareparts.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Sparepart
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Kode</th>
                        <th>Nama Sparepart</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Satuan</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($spareparts as $sparepart)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><span class="badge badge-secondary">{{ $sparepart->kode_sparepart }}</span></td>
                            <td>{{ $sparepart->nama_sparepart }}</td>
                            <td>
                                @if($sparepart->stok < 10)
                                    <span class="badge badge-danger">{{ $sparepart->stok }}</span>
                                    <small class="text-danger">Stok Menipis!</small>
                                @else
                                    <span class="badge badge-success">{{ $sparepart->stok }}</span>
                                @endif
                            </td>
                            <td>{{ $sparepart->formatted_harga }}</td>
                            <td>{{ $sparepart->satuan }}</td>
                            <td>
                                <a href="{{ route('spareparts.show', $sparepart->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('spareparts.edit', $sparepart->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('spareparts.destroy', $sparepart->id) }}" method="POST" style="display:inline">
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
                            <td colspan="7" class="text-center">Belum ada data sparepart</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $spareparts->links() }}
        </div>
    </div>
@stop