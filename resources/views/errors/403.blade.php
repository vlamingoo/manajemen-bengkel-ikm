@extends('adminlte::page')

@section('title', 'Akses Ditolak')

@section('content_header')
    <h1>Akses Ditolak</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="alert alert-danger">
                <h4><i class="fas fa-exclamation-triangle"></i> Akses Ditolak</h4>
                <p>{{ $message ?? 'Anda tidak memiliki izin untuk mengakses halaman ini.' }}</p>
            </div>

            <a href="{{ url()->previous() ?: route('dashboard') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@stop
