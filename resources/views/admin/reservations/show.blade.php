@extends('layouts.admin')

@section('title', 'Detail Reservasi')
@section('page-title', 'Detail Reservasi')

@section('content')

<!-- ===== MAIN CONTAINER ===== -->
<div class="table-container">
    <div class="row mb-4">
        <!-- ===== LEFT COLUMN: RESERVATION INFO ===== -->
        <div class="col-md-8">
            <!-- ===== CUSTOMER DATA SECTION ===== -->
            <div class="row">
                <!-- Customer Info -->
                <div class="col-md-6">
                    <h5 class="mb-3">
                        <i class="bi bi-person"></i> Data Customer
                    </h5>
                    <div class="mb-3">
                        <label class="text-muted">Nama</label>
                        <p class="fw-bold">
                            <a href="{{ route('admin.customers.show', $reservation->customer) }}" class="text-decoration-none">
                                {{ $reservation->customer_name }}
                            </a>
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Email</label>
                        <p>{{ $reservation->customer->email }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Nomor Telepon</label>
                        <p>{{ $reservation->customer->phone }}</p>
                    </div>
                </div>

                <!-- Reservation Info -->
                <div class="col-md-6">
                    <h5 class="mb-3">
                        <i class="bi bi-calendar-check"></i> Data Reservasi
                    </h5>
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

            <!-- ===== PRICING & STATUS SECTION ===== -->
            <div class="row">
                <!-- Price Info -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-muted">Harga Per Orang</label>
                        <p>
                            Rp {{ number_format($reservation->destination->price, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Total Harga</label>
                        <p class="h5 text-success fw-bold">
                            Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                        </p>
                    </div>
                </div>

                <!-- Status Info -->
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="text-muted">Status</label>
                        <p>
                            <x-status_badge :status="$reservation->status" />
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="text-muted">Tanggal Dibuat</label>
                        <p>{{ $reservation->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
            </div>

            <!-- ===== NOTES SECTION (if exists) ===== -->
            @if($reservation->notes)
                <hr>
                <div class="mb-3">
                    <label class="text-muted">
                        <i class="bi bi-chat-left-text"></i> Catatan
                    </label>
                    <p>{{ $reservation->notes }}</p>
                </div>
            @endif
        </div>

        <!-- ===== RIGHT COLUMN: QUICK ACTIONS ===== -->
        <div class="col-md-4">
            <x-reservation_quick_actions :reservation="$reservation" />
        </div>
    </div>

    <hr>

    <!-- ===== ACTION BUTTONS ===== -->
    <a 
        href="{{ route('admin.reservations.edit', $reservation) }}" 
        class="btn btn-warning">
        <i class="bi bi-pencil"></i> Edit
    </a>
    <a 
        href="{{ route('admin.reservations.index') }}" 
        class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<!-- ===== CONFIRM RESERVATION MODAL ===== -->
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Konfirmasi Reservasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('admin.reservations.changeStatus', $reservation) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="status" value="confirmed">
                    <p>Apakah Anda yakin ingin mengkonfirmasi reservasi ini?</p>
                    <div class="mb-3">
                        <label class="form-label">
                            <strong>Catatan (Opsional)</strong>
                        </label>
                        <textarea 
                            name="reason" 
                            class="form-control" 
                            rows="3" 
                            placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button 
                        type="button" 
                        class="btn btn-secondary" 
                        data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="btn btn-success">
                        Konfirmasi Reservasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ===== CANCEL RESERVATION MODAL ===== -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <h5 class="modal-title">Batalkan Reservasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('admin.reservations.changeStatus', $reservation) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="status" value="cancelled">
                    <div class="mb-3">
                        <label class="form-label">
                            <strong>Alasan Pembatalan</strong>
                        </label>
                        <textarea 
                            name="reason" 
                            class="form-control" 
                            rows="3" 
                            placeholder="Jelaskan alasan pembatalan..." 
                            required></textarea>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button 
                        type="button" 
                        class="btn btn-secondary" 
                        data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button 
                        type="submit" 
                        class="btn btn-danger">
                        Batalkan Reservasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
