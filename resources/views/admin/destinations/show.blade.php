@extends('layouts.admin')

@section('title', 'Detail Destinasi')
@section('page-title', 'Detail Destinasi: ' . $destination->name)

@section('content')
<div class="table-container">
    <div class="row">
        <div class="col-md-6">
            @if($destination->image_url)
                <img src="{{ $destination->image_url }}" alt="{{ $destination->name }}" class="img-fluid rounded mb-3" style="max-height: 400px; object-fit: cover;">
            @else
                <div class="bg-light rounded mb-3 d-flex align-items-center justify-content-center" style="height: 300px;">
                    <i class="bi bi-image" style="font-size: 3rem; color: #bdc3c7;"></i>
                </div>
            @endif
        </div>

        <div class="col-md-6">
            <h3>{{ $destination->name }}</h3>
            <hr>

            <div class="mb-3">
                <label class="text-muted">Lokasi</label>
                <p>{{ $destination->location }}</p>
            </div>

            <div class="mb-3">
                <label class="text-muted">Harga</label>
                <p class="h5 text-success">Rp {{ number_format($destination->price, 0, ',', '.') }}</p>
            </div>

            <div class="mb-3">
                <label class="text-muted">Rating</label>
                <p>
                    <span class="badge bg-warning">
                        <i class="bi bi-star-fill"></i> {{ $destination->rating ?? 0 }}/5
                    </span>
                </p>
            </div>

            <div class="mb-3">
                <label class="text-muted">Total Pengunjung</label>
                <p>{{ $destination->total_visitors }} orang</p>
            </div>

            <div class="mb-3">
                <label class="text-muted">Tanggal Dibuat</label>
                <p>{{ $destination->created_at->format('d M Y H:i') }}</p>
            </div>

            <hr>

            <a href="{{ route('admin.destinations.edit', $destination) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <h5>Deskripsi</h5>
            <p>{{ $destination->description }}</p>
        </div>
    </div>
</div>

@endsection
