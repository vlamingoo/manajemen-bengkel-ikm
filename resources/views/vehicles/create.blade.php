@extends('adminlte::page')

@section('title', 'Tambah Kendaraan')

@section('content_header')
    <h1>Tambah Kendaraan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('vehicles.store') }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label>Pemilik Kendaraan <span class="text-danger">*</span></label>
                    <select name="customer_id" class="form-control @error('customer_id') is-invalid @enderror" required>
                        <option value="">-- Pilih Pelanggan --</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                {{ $customer->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('customer_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Merk <span class="text-danger">*</span></label>
                    <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror" 
                           value="{{ old('merk') }}" placeholder="Contoh: Toyota, Honda, Yamaha" required>
                    @error('merk')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Model <span class="text-danger">*</span></label>
                    <input type="text" name="model" class="form-control @error('model') is-invalid @enderror" 
                           value="{{ old('model') }}" placeholder="Contoh: Avanza, Beat, Supra" required>
                    @error('model')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>No Plat <span class="text-danger">*</span></label>
                    <input type="text" name="no_plat" class="form-control @error('no_plat') is-invalid @enderror" 
                           value="{{ old('no_plat') }}" placeholder="Contoh: B 1234 XYZ" required>
                    @error('no_plat')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Tahun <span class="text-danger">*</span></label>
                    <input type="number" name="tahun" class="form-control @error('tahun') is-invalid @enderror" 
                           value="{{ old('tahun') }}" placeholder="Contoh: 2020" required>
                    @error('tahun')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Warna</label>
                    <input type="text" name="warna" class="form-control @error('warna') is-invalid @enderror" 
                           value="{{ old('warna') }}" placeholder="Contoh: Hitam, Putih, Merah">
                    @error('warna')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                    <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop