@extends('layouts.admin')

@section('title', 'Kelola User')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Daftar User</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah User
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Role</th>
                <th>Bergabung</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    @if($user->role === 'admin')
                        <span class="badge badge-danger">Admin</span>
                    @else
                        <span class="badge badge-primary">User</span>
                    @endif
                </td>
                <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @else
                        <span class="badge badge-warning" style="font-size: 10px;">Akun Anda</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: #999; padding: 40px;">
                    <i class="fas fa-users" style="font-size: 48px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                    Belum ada user. <a href="{{ route('admin.users.create') }}">Tambah user pertama</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="padding: 20px;">
        {{ $users->links() }}
    </div>
</div>
@endsection




