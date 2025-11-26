@extends('layouts.admin')

@section('title', 'Tambah Destinasi')
@section('page-title', 'Tambah Destinasi Baru')

@section('content')

<!-- ===== FORM CONTAINER ===== -->
<div class="form-container">
    <form 
        action="{{ route('admin.destinations.store') }}" 
        method="POST">
        @csrf

        <!-- ===== ROW 1: NAME & LOCATION ===== -->
        <div class="row">
            <!-- Name Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="name">
                        Nama Destinasi <span class="text-danger">*</span>
                        <small class="text-muted">(min 5 karakter)</small>
                    </label>
                    <input 
                        type="text" 
                        class="form-control @error('name') is-invalid @enderror" 
                        id="name" 
                        name="name" 
                        value="{{ old('name') }}"
                        minlength="5"
                        maxlength="100"
                        title="Nama destinasi minimal 5 karakter"
                        required>
                    @error('name')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Location Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="location">
                        Lokasi <span class="text-danger">*</span>
                        <small class="text-muted">(min 5 karakter)</small>
                    </label>
                    <input 
                        type="text" 
                        class="form-control @error('location') is-invalid @enderror" 
                        id="location" 
                        name="location" 
                        value="{{ old('location') }}"
                        minlength="5"
                        maxlength="100"
                        title="Lokasi minimal 5 karakter"
                        required>
                    @error('location')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
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
                        <small class="text-muted">(10K - 999M)</small>
                    </label>
                    <input 
                        type="number" 
                        class="form-control @error('price') is-invalid @enderror" 
                        id="price" 
                        name="price" 
                        value="{{ old('price') }}" 
                        step="1"
                        min="10000"
                        max="999999999"
                        title="Harga harus antara Rp 10.000 - Rp 999.999.999"
                        required>
                    <small class="form-text text-muted">💡 Harga diantara Rp 10.000 hingga Rp 999.999.999</small>
                    @error('price')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Rating Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="rating">
                        Rating (0-5)
                        <small class="text-muted">(bintang)</small>
                    </label>
                    <input 
                        type="number" 
                        class="form-control @error('rating') is-invalid @enderror" 
                        id="rating" 
                        name="rating" 
                        value="{{ old('rating', 0) }}" 
                        step="0.1" 
                        min="0" 
                        max="5"
                        title="Rating harus antara 0-5 bintang">
                    @error('rating')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- ===== IMAGE URL FIELD ===== -->
        <div class="form-group mb-3">
            <label for="image_url">
                URL Gambar
                <small class="text-muted">(harus URL yang valid)</small>
            </label>
            <input 
                type="url" 
                class="form-control @error('image_url') is-invalid @enderror" 
                id="image_url" 
                name="image_url" 
                value="{{ old('image_url') }}"
                placeholder="https://example.com/image.jpg"
                maxlength="500"
                title="Masukkan URL gambar yang valid">
            @error('image_url')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- ===== DESCRIPTION FIELD ===== -->
        <div class="form-group mb-3">
            <label for="description">
                Deskripsi <span class="text-danger">*</span>
                <small class="text-muted">(min 10 karakter)</small>
            </label>
            <textarea 
                class="form-control @error('description') is-invalid @enderror" 
                id="description" 
                name="description" 
                rows="5"
                minlength="10"
                maxlength="2000"
                title="Deskripsi minimal 10 karakter"
                required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <!-- ===== ACTION BUTTONS ===== -->
        <div class="form-group">
            <button 
                type="submit" 
                class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Simpan
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
