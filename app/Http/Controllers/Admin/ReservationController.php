<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Destination;
use App\Models\Customer;
use App\Models\StatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * ReservationController
 * Handles CRUD operations and status management for reservations
 * Includes advanced features: bulk status update, audit trail logging
 */
class ReservationController extends Controller
{
    /**
     * Display paginated list of reservations with search & filters
     *
     * Supports:
     * - Search by customer name, email, or phone
     * - Filter by status (pending/confirmed/cancelled)
     * - Filter by destination
     * - Filter by date range (from/to)
     * - Sort by any column in any order
     * - Eager load destinations (prevent N+1 queries)
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // ===== BUILD QUERY WITH EAGER LOADING =====
        // Load destination and customer data to prevent N+1 queries
        $query = Reservation::with('destination', 'customer');

        // ===== SEARCH FILTERS =====
        // Search across customer name, email, or phone via relationship
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // ===== STATUS FILTER =====
        // Filter by single status: pending, confirmed, or cancelled
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // ===== DESTINATION FILTER =====
        // Filter by destination ID
        if ($request->filled('destination_id')) {
            $query->where('destination_id', $request->input('destination_id'));
        }

        // ===== DATE RANGE FILTERS =====
        // Filter by date from (on or after)
        if ($request->filled('date_from')) {
            $query->whereDate('reservation_date', '>=', $request->input('date_from'));
        }

        // Filter by date to (on or before)
        if ($request->filled('date_to')) {
            $query->whereDate('reservation_date', '<=', $request->input('date_to'));
        }

        // ===== SORTING =====
        // Sort by column (default: reservation_date) and order (default: desc)
        $sortBy = $request->input('sort_by', 'reservation_date');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // ===== PAGINATION =====
        // 10 items per page, preserve all query parameters
        $reservations = $query->paginate(10)->appends($request->query());
        
        // ===== FETCH DESTINATIONS & CUSTOMERS FOR FILTER DROPDOWN =====
        $destinations = Destination::all();
        $customers = Customer::all();
        
        return view('admin.reservations.index', compact('reservations', 'destinations', 'customers'));
    }

    /**
     * Show create reservation form
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // ===== LOAD DESTINATIONS & CUSTOMERS FOR DROPDOWN =====
        $destinations = Destination::all();
        $customers = Customer::all();
        return view('admin.reservations.create', compact('destinations', 'customers'));
    }

    /**
     * Store new reservation and create audit trail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // ===== VALIDATION =====
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',                                // Valid customer
            'destination_id' => 'required|exists:destinations,id',                          // Valid destination
            'reservation_date' => 'required|date|after_or_equal:today|before_or_equal:' . date('Y-m-d', strtotime('+1 year')),  // Future date, max 1 year
            'quantity' => 'required|integer|min:1|max:100',                                 // 1-100 people
            'total_price' => 'required|numeric|min:50000|max:999999999',                    // Rp 50K - 999M
            'status' => 'required|in:pending,confirmed,cancelled',                          // Valid status
            'notes' => 'nullable|string|max:1000',                                          // Max 1000 chars
        ], [
            'reservation_date.after_or_equal' => 'Tanggal reservasi tidak boleh di masa lalu',
            'reservation_date.before_or_equal' => 'Tanggal reservasi maksimal 1 tahun ke depan',
            'quantity.min' => 'Minimal 1 orang',
            'quantity.max' => 'Maksimal 100 orang',
            'total_price.min' => 'Total harga minimal Rp 50.000',
            'total_price.max' => 'Total harga maksimal Rp 999.999.999',
        ]);

        // ===== GET CUSTOMER NAME =====
        $customer = Customer::findOrFail($validated['customer_id']);
        $validated['customer_name'] = $customer->name;

        // ===== CREATE RESERVATION =====
        $reservation = Reservation::create($validated);

        // ===== LOG AUDIT TRAIL =====
        // Create initial status history record
        StatusHistory::create([
            'reservation_id' => $reservation->id,
            'old_status' => null,                              // Initial creation
            'new_status' => $validated['status'],
            'changed_by' => Auth::user()->email,               // Admin who created
            'notes' => 'Reservasi dibuat',                     // Initial creation note
        ]);

        // ===== REDIRECT =====
        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservasi berhasil ditambahkan!');
    }

    /**
     * Show reservation details with status history
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\View\View
     */
    public function show(Reservation $reservation)
    {
        // ===== LOAD STATUS HISTORY =====
        $statusHistories = $reservation->statusHistories;
        return view('admin.reservations.show', compact('reservation', 'statusHistories'));
    }

    /**
     * Show edit reservation form
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\View\View
     */
    public function edit(Reservation $reservation)
    {
        // ===== LOAD DESTINATIONS & CUSTOMERS FOR DROPDOWN =====
        $destinations = Destination::all();
        $customers = Customer::all();
        return view('admin.reservations.edit', compact('reservation', 'destinations', 'customers'));
    }

    /**
     * Update reservation and log status changes to audit trail
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Reservation $reservation)
    {
        // ===== VALIDATION =====
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',                                // Valid customer
            'destination_id' => 'required|exists:destinations,id',                          // Valid destination
            'reservation_date' => 'required|date|after_or_equal:today|before_or_equal:' . date('Y-m-d', strtotime('+1 year')),  // Future date, max 1 year
            'quantity' => 'required|integer|min:1|max:100',                                 // 1-100 people
            'total_price' => 'required|numeric|min:50000|max:999999999',                    // Rp 50K - 999M
            'status' => 'required|in:pending,confirmed,cancelled',                          // Valid status
            'notes' => 'nullable|string|max:1000',                                          // Max 1000 chars
        ], [
            'reservation_date.after_or_equal' => 'Tanggal reservasi tidak boleh di masa lalu',
            'reservation_date.before_or_equal' => 'Tanggal reservasi maksimal 1 tahun ke depan',
            'quantity.min' => 'Minimal 1 orang',
            'quantity.max' => 'Maksimal 100 orang',
            'total_price.min' => 'Total harga minimal Rp 50.000',
            'total_price.max' => 'Total harga maksimal Rp 999.999.999',
        ]);

        // ===== GET CUSTOMER NAME =====
        $customer = Customer::findOrFail($validated['customer_id']);
        $validated['customer_name'] = $customer->name;

        // ===== CAPTURE OLD STATUS FOR COMPARISON =====
        $oldStatus = $reservation->status;

        // ===== UPDATE RESERVATION =====
        $reservation->update($validated);

        // ===== LOG STATUS CHANGE IF CHANGED =====
        // Only log if status actually changed (prevent duplicate logs)
        if ($oldStatus !== $validated['status']) {
            StatusHistory::create([
                'reservation_id' => $reservation->id,
                'old_status' => $oldStatus,
                'new_status' => $validated['status'],
                'changed_by' => Auth::user()->email,                   // Admin who updated
                'notes' => $validated['notes'] ?? null,
            ]);
        }

        // ===== REDIRECT =====
        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservasi berhasil diperbarui!');
    }

    /**
     * Delete reservation from database
     * 
     * Cascade delete via foreign key: status_histories are also deleted
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reservation $reservation)
    {
        // ===== DELETE RESERVATION =====
        // Cascade delete: status_histories automatically deleted via FK
        $reservation->delete();

        // ===== REDIRECT =====
        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservasi berhasil dihapus!');
    }

    /**
     * Quick status change with optional reason
     * 
     * Used by quick action buttons on reservation detail page
     * Logs status change with reason to audit trail
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\Http\RedirectResponse
     */
    public function changeStatus(Request $request, Reservation $reservation)
    {
        // ===== VALIDATION =====
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',     // Valid status only
            'reason' => 'nullable|string',                             // Optional reason (for cancel)
        ]);

        // ===== CAPTURE OLD STATUS =====
        $oldStatus = $reservation->status;

        // ===== UPDATE STATUS =====
        $reservation->status = $validated['status'];
        $reservation->save();

        // ===== LOG STATUS CHANGE =====
        // Create audit trail entry with reason
        StatusHistory::create([
            'reservation_id' => $reservation->id,
            'old_status' => $oldStatus,
            'new_status' => $validated['status'],
            'reason' => $validated['reason'] ?? null,                  // Reason (usually for cancellations)
            'changed_by' => Auth::user()->email,                       // Admin who changed
        ]);

        // ===== REDIRECT =====
        return back()->with('success', 'Status berhasil diubah menjadi ' . strtoupper($validated['status']));
    }

    /**
     * Bulk status update for multiple reservations
     * 
     * Allows updating status of multiple reservations at once
     * Only updates if status is different (prevents duplicate logs)
     * Logs each change to audit trail
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function bulkStatusUpdate(Request $request)
    {
        // ===== VALIDATION =====
        $validated = $request->validate([
            'reservation_ids' => 'required|array',                     // Must be array
            'reservation_ids.*' => 'integer|exists:reservations,id',   // Each ID must exist
            'status' => 'required|in:pending,confirmed,cancelled',     // Valid status only
            'reason' => 'nullable|string',                             // Optional reason
        ]);

        // ===== BULK UPDATE LOOP =====
        $changedBy = Auth::user()->email;
        $count = 0;

        foreach ($validated['reservation_ids'] as $id) {
            // ===== FETCH RESERVATION =====
            $reservation = Reservation::find($id);
            $oldStatus = $reservation->status;

            // ===== UPDATE IF STATUS DIFFERENT =====
            // Only update and log if status actually changed
            if ($oldStatus !== $validated['status']) {
                // Update reservation status
                $reservation->status = $validated['status'];
                $reservation->save();

                // Log status change to audit trail
                StatusHistory::create([
                    'reservation_id' => $id,
                    'old_status' => $oldStatus,
                    'new_status' => $validated['status'],
                    'reason' => $validated['reason'] ?? null,
                    'changed_by' => $changedBy,
                ]);

                $count++;  // Increment counter
            }
        }

        // ===== REDIRECT =====
        return redirect()->route('admin.reservations.index')
            ->with('success', "Status $count reservasi berhasil diubah!");
    }

    /**
     * Display status change history/audit trail for a reservation
     * 
     * Shows timeline of all status changes with:
     * - Old status → New status
     * - Admin who made the change
     * - Timestamp of change
     * - Reason (if provided, especially for cancellations)
     *
     * @param  \App\Models\Reservation  $reservation
     * @return \Illuminate\View\View
     */
    public function statusHistory(Reservation $reservation)
    {
        // ===== LOAD STATUS HISTORY =====
        // Already sorted DESC by created_at in model relationship
        $histories = $reservation->statusHistories;
        return view('admin.reservations.status-history', compact('reservation', 'histories'));
    }
}
