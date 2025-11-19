@extends('layouts.admin')

@section('title', 'Detail Reservasi')
@section('page-title', 'Detail Reservasi')

@section('content')
<div class="table-container">
    <div class="row">
        <div class="col-md-6">
            <h5 class="mb-3">Data Customer</h5>
            <div class="mb-3">
                <label class="text-muted">Nama</label>
                <p class="fw-bold">{{ $reservation->customer_name }}</p>
            </div>
            <div class="mb-3">
                <label class="text-muted">Email</label>
                <p>{{ $reservation->customer_email }}</p>
            </div>
            <div class="mb-3">
                <label class="text-muted">Nomor Telepon</label>
                <p>{{ $reservation->customer_phone }}</p>
            </div>
        </div>

        <div class="col-md-6">
            <h5 class="mb-3">Data Reservasi</h5>
            <div class="mb-3">
                <label class="text-muted">Destinasi</label>
                <p class="fw-bold">{{ $reservation->destination->name }}</p>
            </div>
            <div class="mb-3">
                <label class="text-muted">Tanggal Reservasi</label>
                <p>{{ $reservation->reservation_date->format('d M Y') }}</p>
            </div>
            <div class="mb-3">
                <label class="text-muted">Jumlah Orang</label>
                <p>{{ $reservation->quantity }} orang</p>
            </div>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-3">
                <label class="text-muted">Harga Per Orang</label>
                <p>Rp {{ number_format($reservation->destination->price, 0, ',', '.') }}</p>
            </div>
            <div class="mb-3">
                <label class="text-muted">Total Harga</label>
                <p class="h5 text-success fw-bold">Rp {{ number_format($reservation->total_price, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="col-md-6">
            <div class="mb-3">
                <label class="text-muted">Status</label>
                <p>
                    @if($reservation->status === 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($reservation->status === 'confirmed')
                        <span class="badge bg-success">Terkonfirmasi</span>
                    @else
                        <span class="badge bg-danger">Dibatalkan</span>
                    @endif
                </p>
            </div>
            <div class="mb-3">
                <label class="text-muted">Tanggal Dibuat</label>
                <p>{{ $reservation->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>
    </div>

    @if($reservation->notes)
        <hr>
        <div class="mb-3">
            <label class="text-muted">Catatan</label>
            <p>{{ $reservation->notes }}</p>
        </div>
    @endif

    <hr>

    <a href="{{ route('admin.reservations.edit', $reservation) }}" class="btn btn-warning">
        <i class="bi bi-pencil"></i> Edit
    </a>
    <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

@endsection
