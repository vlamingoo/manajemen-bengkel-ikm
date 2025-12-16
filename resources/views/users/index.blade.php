@extends('adminlte::page')

@section('title', 'Kelola User')

@section('content_header')
    <h1>Kelola User</h1>
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
            <a href="{{ route('users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah User
            </a>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Terdaftar</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <strong>{{ $user->name }}</strong>
                                @if($user->id === auth()->id())
                                    <span class="badge badge-info">Anda</span>
                                @endif
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->role == 'admin')
                                    <span class="badge badge-danger">ADMIN</span>
                                @elseif($user->role == 'karyawan')
                                    <span class="badge badge-success">KARYAWAN</span>
                                @else
                                    <span class="badge badge-warning">OWNER</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                @if($user->id !== auth()->id())
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data user</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
@stop