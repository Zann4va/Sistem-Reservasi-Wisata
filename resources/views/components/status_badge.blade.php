@props(['status'])

@php
    $badgeClass = match($status) {
        'pending' => 'bg-warning text-dark',
        'confirmed' => 'bg-success text-white',
        'cancelled' => 'bg-danger text-white',
        default => 'bg-secondary text-white',
    };
    
    $statusLabel = match($status) {
        'pending' => 'Pending',
        'confirmed' => 'Confirmed',
        'cancelled' => 'Cancelled',
        default => ucfirst($status),
    };
@endphp

<span class="badge {{ $badgeClass }}">
    {{ $statusLabel }}
</span>
