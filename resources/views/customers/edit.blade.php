@extends('adminlte::page')

@section('title', 'Edit Pelanggan')

@section('content_header')
    <h1>Edit Pelanggan</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group">
                    <label>Nama <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" 
                           value="{{ old('nama', $customer->nama) }}" required>
                    @error('nama')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>No Telepon <span class="text-danger">*</span></label>
                    <input type="text" name="no_telp" class="form-control @error('no_telp') is-invalid @enderror" 
                           value="{{ old('no_telp', $customer->no_telp) }}" required>
                    @error('no_telp')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Alamat <span class="text-danger">*</span></label>
                    <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" 
                              rows="3" required>{{ old('alamat', $customer->alamat) }}</textarea>
                    @error('alamat')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           value="{{ old('email', $customer->email) }}">
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update
                    </button>
                    <a href="{{ route('customers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>
@stop