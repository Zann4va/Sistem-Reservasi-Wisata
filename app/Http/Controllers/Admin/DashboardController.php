<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use App\Models\Reservation;
use Illuminate\Support\Facades\DB;

/**
 * DashboardController
 * Handles admin dashboard statistics, analytics, and chart data generation
 */
class DashboardController extends Controller
{
    /**
     * Display dashboard with statistics and charts
     * 
     * Generates:
     * - 4 statistics cards (total destinations, reservations, revenue, pending)
     * - 4 charts (30-day reservations, 3-month revenue, status distribution, top destinations)
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // ===== LOAD STATISTICS =====
        $totalDestinations = Destination::count();
        $totalReservations = Reservation::count();
        // Total Revenue hanya dari CONFIRMED reservations saja
        $totalRevenue = Reservation::where('status', 'confirmed')->sum('total_price');
        $pendingReservations = Reservation::where('status', 'pending')->count();

        // ===== LOAD CHART DATA =====
        // Chart 1: Reservations (last 30 days)
        $chartData = $this->getReservationChartData();

        // Chart 2: Revenue (last 3 months)
        $revenueByMonth = $this->getRevenueByMonth();

        // Chart 3: Status distribution (all reservations)
        $statusDistribution = $this->getStatusDistribution();

        // Chart 4: Top 5 destinations (by reservation count)
        $topDestinations = Destination::withCount('reservations')
            ->orderBy('reservations_count', 'desc')
            ->limit(5)
            ->get();

        // ===== PREPARE VIEW DATA =====
        return view('admin.dashboard', [
            'totalDestinations' => $totalDestinations,
            'totalReservations' => $totalReservations,
            'totalRevenue' => $totalRevenue,
            'pendingReservations' => $pendingReservations,
            'chartData' => $chartData,
            'revenueByMonth' => $revenueByMonth,
            'statusDistribution' => $statusDistribution,
            'topDestinations' => $topDestinations,
        ]);
    }

    /**
     * Get reservation data for last 30 days
     * 
     * Query reservations from database (not random generated)
     * Fill missing dates with 0 for smooth chart display
     *
     * @return array Array of chart data points with date, count, and day name
     */
    private function getReservationChartData()
    {
        // ===== DATE RANGE SETUP =====
        $today = now();
        $thirtyDaysAgo = $today->copy()->subDays(29);

        // ===== QUERY DATABASE =====
        // Get reservation counts grouped by date for last 30 days
        $reservationsByDate = DB::table('reservations')
            ->selectRaw('DATE(reservation_date) as date, COUNT(*) as count')
            ->where('reservation_date', '>=', $thirtyDaysAgo)
            ->where('reservation_date', '<=', $today)
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');  // Key by date for O(1) lookup performance

        // ===== BUILD CHART DATA =====
        // Fill all 30 days (missing dates get 0)
        $chartData = [];
        $currentDate = $thirtyDaysAgo->copy();

        foreach (range(0, 29) as $i) {
            $dateStr = $currentDate->format('Y-m-d');
            $count = $reservationsByDate->get($dateStr)?->count ?? 0;

            $chartData[] = [
                'date' => $dateStr,
                'count' => (int) $count,
                'dayName' => $currentDate->format('D'),  // Short day name (Mon, Tue, etc)
            ];

            $currentDate->addDay();
        }

        return $chartData;
    }

    /**
     * Get revenue data aggregated by month (last 3 months)
     * 
     * Sums total_price grouped by month with reservation count
     *
     * @return \Illuminate\Support\Collection Collection of monthly revenue data
     */
    private function getRevenueByMonth()
    {
        return DB::table('reservations')
            ->selectRaw('DATE_FORMAT(reservation_date, "%Y-%m") as month, SUM(total_price) as revenue, COUNT(*) as count')
            ->where('status', 'confirmed')
            ->where('reservation_date', '>=', now()->subMonths(3))
            ->groupBy(DB::raw('DATE_FORMAT(reservation_date, "%Y-%m")'))
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => $item->month,
                    'revenue' => (int) $item->revenue,
                    'count' => (int) $item->count,
                ];
            });
    }

    /**
     * Get status distribution across all reservations
     * 
     * Ensures all status keys exist with default 0 to prevent chart errors
     * Statuses: pending, confirmed, cancelled
     *
     * @return array Array with status as key and count as value
     */
    private function getStatusDistribution()
    {
        // ===== QUERY STATUS COUNTS =====
        $statusData = DB::table('reservations')
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get()
            ->pluck('count', 'status')
            ->toArray();

        // ===== ENSURE ALL STATUSES EXIST =====
        // Prevents chart errors from missing status keys
        return [
            'pending' => $statusData['pending'] ?? 0,
            'confirmed' => $statusData['confirmed'] ?? 0,
            'cancelled' => $statusData['cancelled'] ?? 0,
        ];
    }
}

