@extends('layouts.admin')

@section('title', 'Kelola Berita')

@section('content')
<div class="card">
    <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
        <h3>Daftar Berita</h3>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Berita
        </a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul</th>
                <th>Kategori</th>
                <th>Penulis</th>
                <th>Status</th>
                <th>Views</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($news as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ Str::limit($item->title, 50) }}</td>
                <td>
                    <span class="badge badge-primary">{{ ucfirst($item->category) }}</span>
                </td>
                <td>{{ $item->author->name }}</td>
                <td>
                    @if($item->status === 'published')
                        <span class="badge badge-success">Published</span>
                    @else
                        <span class="badge badge-warning">Draft</span>
                    @endif
                </td>
                <td>{{ $item->views }}</td>
                <td>{{ $item->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('admin.news.destroy', $item) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus berita ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; color: #999; padding: 40px;">
                    <i class="fas fa-newspaper" style="font-size: 48px; opacity: 0.3; display: block; margin-bottom: 10px;"></i>
                    Belum ada berita. <a href="{{ route('admin.news.create') }}">Tambah berita pertama</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="padding: 20px;">
        {{ $news->links() }}
    </div>
</div>
@endsection




