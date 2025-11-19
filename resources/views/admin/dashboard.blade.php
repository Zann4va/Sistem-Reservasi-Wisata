@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('extra-css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
@endsection

@section('extra-js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // ===== 1. CHART RESERVASI 30 HARI =====
    const reservationCtx = document.getElementById('reservationChart');
    if (reservationCtx) {
        const reservationData = @json($chartData ?? []);
        
        const dates = reservationData.map(item => item.dayName + ' ' + item.date.split('-')[2]);
        const counts = reservationData.map(item => item.count);
        
        new Chart(reservationCtx, {
            type: 'line',
            data: {
                labels: dates,
                datasets: [{
                    label: 'Jumlah Reservasi',
                    data: counts,
                    borderColor: '#3498db',
                    backgroundColor: 'rgba(52, 152, 219, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointBackgroundColor: '#3498db',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: { usePointStyle: true, padding: 15 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1 }
                    }
                }
            }
        });
    }

    // ===== 2. CHART STATUS RESERVASI =====
    const statusCtx = document.getElementById('statusChart');
    if (statusCtx) {
        const statusData = @json($statusDistribution ?? ['pending' => 0, 'confirmed' => 0, 'cancelled' => 0]);
        
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Confirmed', 'Cancelled'],
                datasets: [{
                    data: [
                        statusData.pending || 0,
                        statusData.confirmed || 0,
                        statusData.cancelled || 0
                    ],
                    backgroundColor: [
                        '#ff9800',
                        '#4caf50',
                        '#f44336'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: { usePointStyle: true, padding: 15 }
                    }
                }
            }
        });
    }

    // ===== 3. CHART REVENUE 3 BULAN =====
    const revenueCtx = document.getElementById('revenueChart');
    if (revenueCtx) {
        const revenueData = @json($revenueByMonth ?? []);
        
        const monthNames = revenueData.map(item => item.month);
        const revenues = revenueData.map(item => item.revenue);
        
        new Chart(revenueCtx, {
            type: 'bar',
            data: {
                labels: monthNames,
                datasets: [{
                    label: 'Revenue (Rp)',
                    data: revenues,
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.8)',
                        'rgba(46, 204, 113, 0.8)',
                        'rgba(155, 89, 182, 0.8)'
                    ],
                    borderColor: [
                        '#3498db',
                        '#2ecc71',
                        '#9b59b6'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: { usePointStyle: true, padding: 15 }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + (value / 1000000).toFixed(1) + 'M';
                            }
                        }
                    }
                }
            }
        });
    }
});
</script>
@endsection

@section('content')
<div class="row">
    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: #e3f2fd;">
                <i class="bi bi-map" style="color: var(--accent-color);"></i>
            </div>
            <div class="stat-card-content">
                <h5>Total Destinasi</h5>
                <h3>{{ $totalDestinations ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: #f3e5f5;">
                <i class="bi bi-calendar-check" style="color: #9c27b0;"></i>
            </div>
            <div class="stat-card-content">
                <h5>Total Reservasi</h5>
                <h3>{{ $totalReservations ?? 0 }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: #e8f5e9;">
                <i class="bi bi-cash-coin" style="color: var(--success-color);"></i>
            </div>
            <div class="stat-card-content">
                <h5>Total Revenue</h5>
                <h3>Rp {{ number_format($totalRevenue ?? 0, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: #fff3e0;">
                <i class="bi bi-exclamation-circle" style="color: #ff9800;"></i>
            </div>
            <div class="stat-card-content">
                <h5>Reservasi Pending</h5>
                <h3>{{ $pendingReservations ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row 1 -->
<div class="row mt-4">
    <div class="col-lg-8">
        <div class="table-container">
            <h5 class="mb-3"><i class="bi bi-graph-up"></i> Grafik Reservasi (30 Hari Terakhir)</h5>
            <canvas id="reservationChart" style="max-height: 300px;"></canvas>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="table-container">
            <h5 class="mb-3"><i class="bi bi-pie-chart"></i> Status Reservasi</h5>
            <canvas id="statusChart" style="max-height: 300px;"></canvas>
        </div>
    </div>
</div>

<!-- Charts Row 2 -->
<div class="row mt-4">
    <div class="col-lg-6">
        <div class="table-container">
            <h5 class="mb-3"><i class="bi bi-cash-coin"></i> Revenue (3 Bulan Terakhir)</h5>
            <canvas id="revenueChart" style="max-height: 300px;"></canvas>
        </div>
    </div>

    <div class="col-lg-6">
        <div class="table-container">
            <h5 class="mb-3"><i class="bi bi-star"></i> Top 5 Destinasi</h5>
            @forelse($topDestinations ?? [] as $dest)
                <div class="mb-3 pb-3" style="border-bottom: 1px solid #eee;">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mb-1">{{ $dest->name }}</h6>
                            <small class="text-muted">{{ $dest->reservations_count }} reservasi</small>
                        </div>
                        <span class="badge bg-primary">{{ $dest->reservations_count }}</span>
                    </div>
                </div>
            @empty
                <p class="text-muted text-center">Tidak ada data</p>
            @endforelse
        </div>
    </div>
</div>

@endsection

@section('extra-js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const ctx = document.getElementById('reservationChart');
        if (ctx) {
            const labels = {!! json_encode(($reservationsByDate ?? collect([]))->pluck('date')) !!};
            const data = {!! json_encode(($reservationsByDate ?? collect([]))->pluck('count')) !!};

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Jumlah Reservasi',
                        data: data,
                        borderColor: '#3498db',
                        backgroundColor: 'rgba(52, 152, 219, 0.1)',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#3498db',
                        pointBorderColor: '#fff',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });
        }
    });
</script>
@endsection
