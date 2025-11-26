@props(['histories'])

<div class="timeline">
    <h5 class="mb-4">
        <i class="bi bi-clock-history"></i> Riwayat Perubahan Status
    </h5>

    @if($histories->isEmpty())
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Belum ada riwayat perubahan status
        </div>
    @else
        @foreach($histories as $history)
            <div class="timeline-item mb-4">
                <!-- Timeline Marker -->
                <div class="d-flex gap-3">
                    <div class="position-relative">
                        <div class="rounded-circle p-2" style="background: #007bff; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center;">
                            <i class="bi bi-arrow-left-right text-white"></i>
                        </div>
                        @if(!$loop->last)
                            <div style="position: absolute; left: 21px; top: 44px; width: 2px; height: 80px; background: #dee2e6;"></div>
                        @endif
                    </div>

                    <!-- Timeline Content -->
                    <div class="flex-grow-1 pb-3">
                        <div class="card border-light">
                            <div class="card-body">
                                <!-- Status Change Info -->
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div>
                                        <h6 class="mb-1">
                                            Perubahan Status
                                        </h6>
                                        <div class="mb-2">
                                            @if($history->old_status)
                                                <span class="badge bg-secondary">
                                                    {{ ucfirst($history->old_status) }}
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    Baru
                                                </span>
                                            @endif

                                            <i class="bi bi-arrow-right mx-2"></i>

                                            <x-status_badge :status="$history->new_status" />
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar"></i>
                                        {{ $history->created_at->format('d M Y H:i') }}
                                    </small>
                                </div>

                                <!-- Changed By -->
                                <p class="mb-2 small">
                                    <strong>Diubah oleh:</strong>
                                    <span class="badge bg-light text-dark">
                                        {{ $history->changed_by }}
                                    </span>
                                </p>

                                <!-- Reason/Notes -->
                                @if($history->reason || $history->notes)
                                    <p class="mb-0 small">
                                        <strong>Catatan:</strong><br>
                                        <em class="text-muted">
                                            {{ $history->reason ?? $history->notes ?? 'Tidak ada catatan' }}
                                        </em>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<style>
    .timeline {
        padding: 20px 0;
    }

    .timeline-item {
        transition: all 0.3s ease;
    }

    .timeline-item:hover {
        transform: translateX(10px);
    }

    .timeline-item .card {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .timeline-item:hover .card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
</style>
