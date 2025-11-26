@extends('layouts.admin')

@section('title', 'Edit Customer')
@section('page-title', 'Edit Customer')

@section('content')

<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0">
                    <i class="bi bi-pencil-square"></i> Form Edit Customer
                </h5>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="needs-validation">
                    @csrf
                    @method('PUT')

                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="name" class="form-label">
                            <i class="bi bi-person"></i> Nama
                            <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('name') is-invalid @enderror" 
                            id="name" 
                            name="name" 
                            placeholder="Masukkan nama lengkap"
                            value="{{ old('name', $customer->name) }}"
                            pattern="^[a-zA-Z\s]{3,100}$"
                            minlength="3"
                            maxlength="100"
                            title="Nama hanya boleh mengandung huruf dan spasi (3-100 karakter)"
                            required>
                        @error('name')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Field -->
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="bi bi-envelope"></i> Email
                            <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="email" 
                            class="form-control @error('email') is-invalid @enderror" 
                            id="email" 
                            name="email" 
                            placeholder="contoh@email.com"
                            value="{{ old('email', $customer->email) }}"
                            title="Email harus format yang benar dan menggunakan huruf kecil"
                            required>
                        <small class="form-text text-muted">
                            💡 Email akan otomatis diubah menjadi huruf kecil
                        </small>
                        @error('email')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone Field -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">
                            <i class="bi bi-telephone"></i> Telepon
                            <span class="text-danger">*</span>
                        </label>
                        <input 
                            type="tel" 
                            class="form-control @error('phone') is-invalid @enderror" 
                            id="phone" 
                            name="phone" 
                            placeholder="Contoh: 081234567890"
                            value="{{ old('phone', $customer->phone) }}"
                            pattern="^[0-9]{10,15}$"
                            title="Nomor telepon harus terdiri dari 10-15 angka tanpa simbol"
                            required>
                        <small class="form-text text-muted">
                            Format: 10-15 digit angka (contoh: 081234567890)
                        </small>
                        @error('phone')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <!-- Address Field -->
                    <div class="mb-3">
                        <label for="address" class="form-label">
                            <i class="bi bi-house"></i> Alamat
                        </label>
                        <textarea 
                            class="form-control @error('address') is-invalid @enderror" 
                            id="address" 
                            name="address" 
                            placeholder="Masukkan alamat lengkap"
                            rows="3">{{ old('address', $customer->address) }}</textarea>
                        @error('address')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- City Field -->
                    <div class="mb-3">
                        <label for="city" class="form-label">
                            <i class="bi bi-geo-alt"></i> Kota
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('city') is-invalid @enderror" 
                            id="city" 
                            name="city" 
                            placeholder="Masukkan kota"
                            value="{{ old('city', $customer->city) }}"
                            pattern="^[a-zA-Z\s]*$"
                            maxlength="100"
                            title="Kota hanya boleh mengandung huruf dan spasi">
                        @error('city')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Province Field -->
                    <div class="mb-3">
                        <label for="province" class="form-label">
                            <i class="bi bi-map"></i> Provinsi
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('province') is-invalid @enderror" 
                            id="province" 
                            name="province" 
                            placeholder="Masukkan provinsi"
                            value="{{ old('province', $customer->province) }}"
                            pattern="^[a-zA-Z\s]*$"
                            maxlength="100"
                            title="Provinsi hanya boleh mengandung huruf dan spasi">
                        @error('province')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Postal Code Field -->
                    <div class="mb-3">
                        <label for="postal_code" class="form-label">
                            <i class="bi bi-mailbox"></i> Kode Pos
                        </label>
                        <input 
                            type="text" 
                            class="form-control @error('postal_code') is-invalid @enderror" 
                            id="postal_code" 
                            name="postal_code" 
                            placeholder="Contoh: 12345"
                            value="{{ old('postal_code', $customer->postal_code) }}"
                            pattern="^[0-9]{4,6}$"
                            title="Kode pos harus terdiri dari 4-6 angka">
                        <small class="form-text text-muted">
                            Format: 4-6 digit angka
                        </small>
                        @error('postal_code')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Notes Field -->
                    <div class="mb-3">
                        <label for="notes" class="form-label">
                            <i class="bi bi-chat-dots"></i> Catatan
                            <small class="text-muted">(max 1000 karakter)</small>
                        </label>
                        <textarea 
                            class="form-control @error('notes') is-invalid @enderror" 
                            id="notes" 
                            name="notes" 
                            placeholder="Masukkan catatan tambahan (opsional)"
                            rows="2"
                            maxlength="1000">{{ old('notes', $customer->notes) }}</textarea>
                        @error('notes')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr>

                    <!-- Action Buttons -->
                    <div class="mt-4 d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-check-circle"></i> Update Customer
                        </button>
                        <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
