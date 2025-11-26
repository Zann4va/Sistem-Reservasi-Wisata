@props(['reservation'])

<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Quick Actions</h5>
    </div>
    <div class="card-body">
        <!-- ===== STATUS DISPLAY ===== -->
        <div class="mb-4">
            <label class="text-muted small">Current Status:</label>
            <div class="mt-2">
                <x-status_badge :status="$reservation->status" />
            </div>
        </div>

        <!-- ===== QUICK ACTION BUTTONS ===== -->
        <div class="d-grid gap-2">
            @if($reservation->status !== 'confirmed')
                <button 
                    type="button" 
                    class="btn btn-success btn-sm"
                    data-bs-toggle="modal" 
                    data-bs-target="#confirmModal">
                    <i class="bi bi-check-circle"></i> Confirm Reservation
                </button>
            @endif

            @if($reservation->status !== 'cancelled')
                <button 
                    type="button" 
                    class="btn btn-danger btn-sm"
                    data-bs-toggle="modal" 
                    data-bs-target="#cancelModal">
                    <i class="bi bi-x-circle"></i> Cancel Reservation
                </button>
            @endif

            <a 
                href="{{ route('admin.reservations.edit', $reservation) }}" 
                class="btn btn-warning btn-sm">
                <i class="bi bi-pencil"></i> Edit Details
            </a>

            <a 
                href="{{ route('admin.reservations.statusHistory', $reservation) }}" 
                class="btn btn-info btn-sm">
                <i class="bi bi-clock-history"></i> View History
            </a>
        </div>

        <!-- ===== RESERVATION INFO SUMMARY ===== -->
        <hr>
        <div class="small">
            <p class="mb-2">
                <strong>Destination:</strong><br>
                {{ $reservation->destination->name }}
            </p>
            <p class="mb-2">
                <strong>Customer:</strong><br>
                {{ $reservation->customer_name }}<br>
                <small class="text-muted">{{ $reservation->customer->email }}</small>
            </p>
            <p class="mb-2">
                <strong>Date:</strong><br>
                {{ $reservation->reservation_date->format('d M Y') }}
            </p>
            <p class="mb-0">
                <strong>Total Price:</strong><br>
                <span class="text-success fw-bold">
                    Rp {{ number_format($reservation->total_price, 0, ',', '.') }}
                </span>
            </p>
        </div>
    </div>
</div>
