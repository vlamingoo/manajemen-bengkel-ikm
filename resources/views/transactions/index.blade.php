@extends('adminlte::page')

@section('title', 'Transaksi Servis')

@section('content_header')
    <h1>Transaksi Servis</h1>
@stop

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <a href="{{ route('transactions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Transaksi
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Kendaraan</th>
                        <th>Total Biaya</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <span class="badge badge-primary">{{ $transaction->kode_transaksi }}</span>
                            </td>
                            <td>{{ $transaction->tanggal_servis->format('d M Y') }}</td>
                            <td>
                                <strong>{{ $transaction->customer->nama }}</strong><br>
                                <small class="text-muted">{{ $transaction->customer->no_telp }}</small>
                            </td>
                            <td>
                                {{ $transaction->vehicle->merk }} {{ $transaction->vehicle->model }}<br>
                                <span class="badge badge-info">{{ $transaction->vehicle->no_plat }}</span>
                            </td>
                            <td><strong class="text-success">{{ $transaction->formatted_total_biaya }}</strong></td>
                            <td>
                                @if($transaction->status == 'proses')
                                    <span class="badge badge-warning">Proses</span>
                                @elseif($transaction->status == 'selesai')
                                    <span class="badge badge-success">Selesai</span>
                                @else
                                    <span class="badge badge-secondary">Diambil</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" style="display:inline">
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
                            <td colspan="8" class="text-center">Belum ada data transaksi</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $transactions->links() }}
        </div>
    </div>
@stop