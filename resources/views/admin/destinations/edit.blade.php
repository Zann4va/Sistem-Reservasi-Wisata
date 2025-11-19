@extends('layouts.admin')

@section('title', 'Edit Destinasi')
@section('page-title', 'Edit Destinasi')

@section('content')
<div class="form-container">
    <form action="{{ route('admin.destinations.update', $destination) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="name">Nama Destinasi *</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                        id="name" name="name" value="{{ old('name', $destination->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="location">Lokasi *</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" 
                        id="location" name="location" value="{{ old('location', $destination->location) }}" required>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="price">Harga (Rp) *</label>
                    <input type="number" class="form-control @error('price') is-invalid @enderror" 
                        id="price" name="price" value="{{ old('price', $destination->price) }}" step="0.01" required>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="rating">Rating (0-5)</label>
                    <input type="number" class="form-control @error('rating') is-invalid @enderror" 
                        id="rating" name="rating" value="{{ old('rating', $destination->rating) }}" step="0.01" min="0" max="5">
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="image_url">URL Gambar</label>
            <input type="url" class="form-control @error('image_url') is-invalid @enderror" 
                id="image_url" name="image_url" value="{{ old('image_url', $destination->image_url) }}">
            @error('image_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="description">Deskripsi *</label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                id="description" name="description" rows="5" required>{{ old('description', $destination->description) }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

@endsection
