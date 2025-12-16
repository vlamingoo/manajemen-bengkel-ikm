@extends('adminlte::page')

@section('title', 'Detail User')

@section('content_header')
    <h1>Detail User</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-user mr-2"></i>
                Informasi User
            </h3>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="200">Nama</th>
                    <td><strong>{{ $user->name }}</strong></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $user->email }}</td>
                </tr>
                <tr>
                    <th>Role</th>
                    <td>
                        @if($user->role == 'admin')
                            <span class="badge badge-danger badge-lg">ADMIN</span>
                        @elseif($user->role == 'karyawan')
                            <span class="badge badge-success badge-lg">KARYAWAN</span>
                        @else
                            <span class="badge badge-warning badge-lg">OWNER</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Terdaftar Sejak</th>
                    <td>{{ $user->created_at->format('d F Y, H:i') }}</td>
                </tr>
                <tr>
                    <th>Terakhir Update</th>
                    <td>{{ $user->updated_at->format('d F Y, H:i') }}</td>
                </tr>
            </table>
        </div>
        <div class="card-footer">
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            @if($user->id !== auth()->id())
                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus user ini?')">
                        <i class="fas fa-trash"></i> Hapus
                    </button>
                </form>
            @endif
        </div>
    </div>
@stop