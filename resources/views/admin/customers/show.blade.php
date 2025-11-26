@extends('layouts.admin')

@section('title', 'Detail Customer')
@section('page-title', 'Detail Customer')

@section('content')

<div class="row">
    <div class="col-md-8 mx-auto">
        <!-- Customer Info Card -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bi bi-person-circle"></i> Informasi Customer
                </h5>
                <div>
                    <a href="{{ route('admin.customers.edit', $customer) }}" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('admin.customers.destroy', $customer) }}" method="POST" class="d-inline" 
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus customer ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">
                            <i class="bi bi-person"></i> Nama
                        </h6>
                        <p class="h5">{{ $customer->name }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">
                            <i class="bi bi-envelope"></i> Email
                        </h6>
                        <p class="h5">{{ $customer->email }}</p>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <h6 class="text-muted">
                            <i class="bi bi-telephone"></i> Telepon
                        </h6>
                        <p class="h5">{{ $customer->phone }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-muted">
                            <i class="bi bi-calendar"></i> Terdaftar Sejak
                        </h6>
                        <p class="h5">{{ $customer->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>

                @if($customer->address)
                    <div class="mb-3">
                        <h6 class="text-muted">
                            <i class="bi bi-house"></i> Alamat
                        </h6>
                        <p>{{ $customer->address }}</p>
                    </div>
                @endif

                <div class="row mb-3">
                    @if($customer->city)
                        <div class="col-md-6">
                            <h6 class="text-muted">
                                <i class="bi bi-geo-alt"></i> Kota
                            </h6>
                            <p>{{ $customer->city }}</p>
                        </div>
                    @endif
                    @if($customer->province)
                        <div class="col-md-6">
                            <h6 class="text-muted">
                                <i class="bi bi-map"></i> Provinsi
                            </h6>
                            <p>{{ $customer->province }}</p>
                        </div>
                    @endif
                </div>

                <div class="row mb-3">
                    @if($customer->postal_code)
                        <div class="col-md-6">
                            <h6 class="text-muted">
                                <i class="bi bi-mailbox"></i> Kode Pos
                            </h6>
                            <p>{{ $customer->postal_code }}</p>
                        </div>
                    @endif
                </div>

                @if($customer->notes)
                    <div class="mb-3">
                        <h6 class="text-muted">
                            <i class="bi bi-chat-dots"></i> Catatan
                        </h6>
                        <p>{{ $customer->notes }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Reservations Card -->
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="bi bi-calendar-check"></i> Reservasi Customer ({{ $reservations->count() }})
                </h5>
            </div>

            <div class="card-body">
                @if($reservations->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Destinasi</th>
                                    <th>Tanggal Reservasi</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservations as $res)
                                    <tr>
                                        <td>{{ $res->destination->name }}</td>
                                        <td>{{ $res->reservation_date->format('d M Y') }}</td>
                                        <td>{{ $res->quantity }} orang</td>
                                        <td>Rp {{ number_format($res->total_price, 0, ',', '.') }}</td>
                                        <td>
                                            @if($res->status === 'pending')
                                                <span class="badge bg-warning">⏳ Pending</span>
                                            @elseif($res->status === 'confirmed')
                                                <span class="badge bg-success">✓ Terkonfirmasi</span>
                                            @else
                                                <span class="badge bg-danger">✗ Dibatalkan</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.reservations.show', $res) }}" 
                                               class="btn btn-sm btn-info">
                                                <i class="bi bi-eye"></i> Lihat
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-inbox" style="font-size: 2rem; color: #bdc3c7;"></i>
                        <p class="text-muted mt-2">Customer ini belum memiliki reservasi</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-4">
            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Customer
            </a>
        </div>
    </div>
</div>

@endsection
