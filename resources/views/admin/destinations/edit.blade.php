@extends('layouts.admin')

@section('title', 'Edit Destinasi')
@section('page-title', 'Edit Destinasi')

@section('content')

<!-- ===== FORM CONTAINER ===== -->
<div class="form-container">
    <form 
        action="{{ route('admin.destinations.update', $destination) }}" 
        method="POST">
        @csrf
        @method('PUT')

        <!-- ===== ROW 1: NAME & LOCATION ===== -->
        <div class="row">
            <!-- Name Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="name">
                        Nama Destinasi <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', $destination->name) }}"
                        minlength="5"
                        maxlength="100"
                        title="Nama destinasi harus terdiri dari 5-100 karakter"
                        required>
                    <small class="form-text text-muted">
                        Min. 5 karakter, max. 100 karakter
                    </small>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Location Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="location">
                        Lokasi <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="text" 
                        class="form-control @error('location') is-invalid @enderror" 
                        id="location" 
                        name="location" 
                        value="{{ old('location', $destination->location) }}"
                        minlength="5"
                        maxlength="100"
                        title="Lokasi harus terdiri dari 5-100 karakter"
                        required>
                    <small class="form-text text-muted">
                        Min. 5 karakter, max. 100 karakter
                    </small>
                    @error('location')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- ===== ROW 2: PRICE & RATING ===== -->
        <div class="row">
            <!-- Price Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="price">
                        Harga (Rp) <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="number" 
                        class="form-control @error('price') is-invalid @enderror" 
                        id="price" 
                        name="price" 
                        value="{{ old('price', $destination->price) }}"
                        min="10000"
                        max="999999999"
                        step="1"
                        title="Harga harus antara Rp 10.000 dan Rp 999.999.999"
                        required>
                    <small class="form-text text-muted">
                        Range: Rp 10.000 - Rp 999.999.999
                    </small>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Rating Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="rating">
                        Rating (0-5)
                    </label>
                    <input 
                        type="number" 
                        class="form-control @error('rating') is-invalid @enderror" 
                        id="rating" 
                        name="rating" 
                        value="{{ old('rating', $destination->rating) }}"
                        min="0"
                        max="5"
                        step="0.1"
                        title="Rating harus antara 0 dan 5 bintang">
                    <small class="form-text text-muted">
                        0.0 - 5.0 bintang
                    </small>
                    @error('rating')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- ===== IMAGE URL FIELD ===== -->
        <div class="form-group mb-3">
            <label for="image_url">
                URL Gambar
            </label>
            <input 
                type="url" 
                class="form-control @error('image_url') is-invalid @enderror" 
                id="image_url" 
                name="image_url" 
                value="{{ old('image_url', $destination->image_url) }}"
                maxlength="500"
                placeholder="https://example.com/image.jpg"
                title="Masukkan URL gambar yang valid (max 500 karakter)">
            <small class="form-text text-muted">
                Format: https://... (max 500 karakter)
            </small>
            @error('image_url')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- ===== DESCRIPTION FIELD ===== -->
        <div class="form-group mb-3">
            <label for="description">
                Deskripsi <span class="text-danger">*</span>
                <small class="text-muted">(min 10, max 2000 karakter)</small>
            </label>
            <textarea 
                class="form-control @error('description') is-invalid @enderror" 
                id="description" 
                name="description" 
                rows="5"
                minlength="10"
                maxlength="2000"
                title="Deskripsi harus terdiri dari 10-2000 karakter"
                required>{{ old('description', $destination->description) }}</textarea>
            <small class="form-text text-muted">
                Minimal 10 karakter, maksimal 2000 karakter
            </small>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- ===== ACTION BUTTONS ===== -->
        <div class="form-group">
            <button 
                type="submit" 
                class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
            <a 
                href="{{ route('admin.destinations.index') }}" 
                class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

@endsection
