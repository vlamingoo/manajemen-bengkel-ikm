@extends('adminlte::page')

@section('title', 'Tambah Sparepart')

@section('content_header')
    <h1>Tambah Sparepart</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('spareparts.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label>Kode Sparepart <span class="text-danger">*</span></label>
                    <input type="text" name="kode_sparepart" class="form-control @error('kode_sparepart') is-invalid @enderror" 
                           value="{{ old('kode_sparepart') }}" placeholder="Contoh: SP001" required>
                    @error('kode_sparepart')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Nama Sparepart <span class="text-danger">*</span></label>
                    <input type="text" name="nama_sparepart" class="form-control @error('nama_sparepart') is-invalid @enderror" 
                           value="{{ old('nama_sparepart') }}" placeholder="Contoh: Oli Mesin 1 Liter" required>
                    @error('nama_sparepart')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Stok <span class="text-danger">*</span></label>
                            <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" 
                                   value="{{ old('stok', 0) }}" min="0" required>
                            @error('stok')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Harga <span class="text-danger">*</span></label>
                            <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" 
                                   value="{{ old('harga', 0) }}" min="0" step="0.01" placeholder="50000" required>
                            @error('harga')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Satuan <span class="text-danger">*</span></label>
                            <select name="satuan" class="form-control @error('satuan') is-invalid @enderror" required>
                                <option value="pcs" {{ old('satuan') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="set" {{ old('satuan') == 'set' ? 'selected' : '' }}>Set</option>
                                <option value="unit" {{ old('satuan') == 'unit' ? 'selected' : '' }}>Unit</option>
                                <option value="liter" {{ old('satuan') == 'liter' ? 'selected' : '' }}>Liter</option>
                                <option value="box" {{ old('satuan') == 'box' ? 'selected' : '' }}>Box</option>
                            </select>
                            @error('satuan')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" 
                              rows="3" placeholder="Keterangan tambahan (opsional)">{{ old('keterangan') }}</textarea>
                    @error('keterangan')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('spareparts.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop