<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Destination;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with('destination');

        // Search by customer name or email
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('customer_name', 'LIKE', "%{$search}%")
                  ->orWhere('customer_email', 'LIKE', "%{$search}%")
                  ->orWhere('customer_phone', 'LIKE', "%{$search}%");
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by destination
        if ($request->filled('destination_id')) {
            $query->where('destination_id', $request->input('destination_id'));
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('reservation_date', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('reservation_date', '<=', $request->input('date_to'));
        }

        // Sort by
        $sortBy = $request->input('sort_by', 'reservation_date');
        $sortOrder = $request->input('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $reservations = $query->paginate(10)->appends($request->query());
        $destinations = Destination::all();
        
        return view('admin.reservations.index', compact('reservations', 'destinations'));
    }

    public function create()
    {
        $destinations = Destination::all();
        return view('admin.reservations.create', compact('destinations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:100',
            'customer_phone' => 'required|string|max:20',
            'destination_id' => 'required|exists:destinations,id',
            'reservation_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        Reservation::create($validated);

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservasi berhasil ditambahkan!');
    }

    public function show(Reservation $reservation)
    {
        return view('admin.reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        $destinations = Destination::all();
        return view('admin.reservations.edit', compact('reservation', 'destinations'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_email' => 'required|email|max:100',
            'customer_phone' => 'required|string|max:20',
            'destination_id' => 'required|exists:destinations,id',
            'reservation_date' => 'required|date',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'status' => 'required|in:pending,confirmed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $reservation->update($validated);

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservasi berhasil diperbarui!');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('admin.reservations.index')
            ->with('success', 'Reservasi berhasil dihapus!');
    }
}
