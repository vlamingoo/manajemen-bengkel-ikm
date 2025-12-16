@extends('adminlte::page')

@section('title', 'Edit Transaksi Servis')

@section('content_header')
    <h1>Edit Transaksi Servis</h1>
@stop

@section('content')
    <form action="{{ route('transactions.update', $transaction->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        {{-- Info Transaksi --}}
        <div class="card">
            <div class="card-header bg-info">
                <h3 class="card-title">
                    <i class="fas fa-info-circle"></i> Informasi Transaksi
                </h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="150">Kode Transaksi</th>
                                <td><span class="badge badge-primary">{{ $transaction->kode_transaksi }}</span></td>
                            </tr>
                            <tr>
                                <th>Tanggal Servis</th>
                                <td>{{ $transaction->tanggal_servis->format('d F Y') }}</td>
                            </tr>
                            <tr>
                                <th>Pelanggan</th>
                                <td>
                                    <strong>{{ $transaction->customer->nama }}</strong><br>
                                    <small>{{ $transaction->customer->no_telp }}</small>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-bordered">
                            <tr>
                                <th width="150">Kendaraan</th>
                                <td>
                                    {{ $transaction->vehicle->merk }} {{ $transaction->vehicle->model }}<br>
                                    <span class="badge badge-info">{{ $transaction->vehicle->no_plat }}</span>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Biaya</th>
                                <td>
                                    <strong class="text-success" style="font-size: 18px;">
                                        {{ $transaction->formatted_total_biaya }}
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <th>Keluhan</th>
                                <td>{{ $transaction->keluhan }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Sparepart --}}
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-box"></i> Sparepart yang Digunakan
                </h3>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Sparepart</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaction->details as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $detail->sparepart->nama_sparepart }}</td>
                                <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                                <td>{{ $detail->qty }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada sparepart digunakan</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="4" class="text-right">Biaya Jasa:</th>
                            <th>Rp {{ number_format($transaction->biaya_jasa, 0, ',', '.') }}</th>
                        </tr>
                        <tr>
                            <th colspan="4" class="text-right">TOTAL:</th>
                            <th class="text-success">{{ $transaction->formatted_total_biaya }}</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        {{-- Form Edit Status --}}
        <div class="card">
            <div class="card-header bg-warning">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i> Edit Status & Informasi
                </h3>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label>Status Servis <span class="text-danger">*</span></label>
                    <select name="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="proses" {{ $transaction->status == 'proses' ? 'selected' : '' }}>
                            Proses
                        </option>
                        <option value="selesai" {{ $transaction->status == 'selesai' ? 'selected' : '' }}>
                            Selesai
                        </option>
                        <option value="diambil" {{ $transaction->status == 'diambil' ? 'selected' : '' }}>
                            Diambil
                        </option>
                    </select>
                    @error('status')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Tindakan/Perbaikan yang Dilakukan</label>
                    <textarea name="tindakan" class="form-control" rows="4" 
                              placeholder="Jelaskan tindakan yang dilakukan...">{{ old('tindakan', $transaction->tindakan) }}</textarea>
                </div>

                <div class="form-group">
                    <label>Keterangan Tambahan</label>
                    <textarea name="keterangan" class="form-control" rows="3" 
                              placeholder="Keterangan lain (opsional)">{{ old('keterangan', $transaction->keterangan) }}</textarea>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi --}}
        <div class="card">
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Update Transaksi
                </button>
                <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-info">
                    <i class="fas fa-eye"></i> Lihat Detail
                </a>
                <a href="{{ route('transactions.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
    </form>
@stop