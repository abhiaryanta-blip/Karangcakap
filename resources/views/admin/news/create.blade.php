@extends('layouts.admin')

@section('title', 'Tambah Berita')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Tambah Berita Baru</h3>
    </div>

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label for="title">Judul Berita *</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title') }}" required>
            @error('title')
                <span style="color: #dc3545; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="excerpt">Ringkasan</label>
            <textarea id="excerpt" name="excerpt" class="form-control" style="min-height: 80px;">{{ old('excerpt') }}</textarea>
            @error('excerpt')
                <span style="color: #dc3545; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="content">Konten Berita *</label>
            <textarea id="content" name="content" class="form-control" style="min-height: 300px;" required>{{ old('content') }}</textarea>
            @error('content')
                <span style="color: #dc3545; font-size: 13px;">{{ $message }}</span>
            @enderror
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
            <div class="form-group">
                <label for="category">Kategori *</label>
                <select id="category" name="category" class="form-control" required>
                    @foreach($categories as $key => $label)
                        <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('category')
                    <span style="color: #dc3545; font-size: 13px;">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status *</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                </select>
                @error('status')
                    <span style="color: #dc3545; font-size: 13px;">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="form-group">
            <label for="image">Gambar Berita</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
            @error('image')
                <span style="color: #dc3545; font-size: 13px;">{{ $message }}</span>
            @enderror
            <small style="color: #666;">Format: JPG, PNG, GIF. Maksimal 2MB</small>
        </div>

        <div style="display: flex; gap: 10px; margin-top: 30px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Berita
            </button>
            <a href="{{ route('admin.news.index') }}" class="btn btn-danger">
                <i class="fas fa-times"></i> Batal
            </a>
        </div>
    </form>
</div>
@endsection






