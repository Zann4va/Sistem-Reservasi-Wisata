@extends('layouts.admin')

@section('title', 'Riwayat Status - ' . $reservation->customer_name)
@section('page-title', 'Riwayat Perubahan Status')

@section('content')

<!-- ===== BACK BUTTON SECTION ===== -->
<div class="mb-4">
    <a 
        href="{{ route('admin.reservations.show', $reservation) }}" 
        class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<!-- ===== MAIN CONTAINER ===== -->
<div class="table-container">
    
    <!-- ===== RESERVATION INFO SECTION ===== -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
                <h6 class="mb-2">
                    <strong>Reservasi:</strong> {{ $reservation->customer_name }}
                </h6>
                <p class="mb-1">
                    <strong>Email:</strong> {{ $reservation->customer_email }}
                </p>
                <p class="mb-1">
                    <strong>Destinasi:</strong> {{ $reservation->destination->name }}
                </p>
                <p class="mb-1">
                    <strong>Tanggal:</strong> 
                    {{ $reservation->reservation_date->format('d M Y') }}
                </p>
                <p class="mb-0">
                    <strong>Status Saat Ini:</strong>
                    <x-status_badge :status="$reservation->status" />
                </p>
            </div>
        </div>
    </div>

    <!-- ===== STATUS HISTORY TIMELINE COMPONENT ===== -->
    <x-status_history_timeline :histories="$histories" />

</div>

<!-- ===== TIMELINE STYLES ===== -->
<style>
    .timeline {
        position: relative;
    }

    .timeline-item:hover {
        background: #f8f9fa;
        border-radius: 8px;
        padding-left: 40px;
        margin-left: -20px;
        padding: 10px 20px;
        transition: all 0.3s ease;
    }
</style>

@endsection
