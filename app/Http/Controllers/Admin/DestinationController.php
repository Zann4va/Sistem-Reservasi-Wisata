<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

/**
 * DestinationController
 * Handles CRUD operations for tourist destinations
 */
class DestinationController extends Controller
{
    /**
     * Display paginated list of destinations with search & filters
     *
     * Supports:
     * - Search by name or location
     * - Filter by price range (min/max)
     * - Filter by rating threshold
     * - Sort by any column in any order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // ===== BUILD QUERY =====
        $query = Destination::query();

        // ===== SEARCH FILTERS =====
        // Search by name or location
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%");
        }

        // ===== PRICE FILTERS =====
        // Filter by minimum price
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        // Filter by maximum price
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        // ===== RATING FILTER =====
        // Filter by minimum rating (0-5 stars)
        if ($request->filled('rating')) {
            $rating = $request->input('rating');
            $query->where('rating', '>=', $rating);
        }

        // ===== SORTING =====
        // Sort by column (default: name) and order (default: asc)
        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // ===== PAGINATION =====
        // 10 items per page, preserve query parameters
        $destinations = $query->paginate(10)->appends($request->query());
        
        return view('admin.destinations.index', compact('destinations'));
    }

    /**
     * Show create destination form
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.destinations.create');
    }

    /**
     * Store new destination in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // ===== VALIDATION =====
        $validated = $request->validate([
            'name' => 'required|string|min:5|max:100|unique:destinations,name',    // Name: min 5, unique
            'description' => 'required|string|min:10|max:2000',                    // Description: min 10 chars
            'location' => 'required|string|min:5|max:100',                         // Location: min 5 chars
            'price' => 'required|numeric|min:10000|max:999999999',                 // Price: Rp 10K - 999M
            'image_url' => 'nullable|url|max:500',                                 // Image URL: valid URL
            'rating' => 'nullable|numeric|min:0|max:5',                            // Rating: 0-5 stars
            'total_visitors' => 'nullable|numeric|min:0|max:9999999',              // Visitors: realistic number
        ], [
            'name.min' => 'Nama destinasi minimal 5 karakter',
            'name.unique' => 'Nama destinasi sudah ada',
            'description.min' => 'Deskripsi minimal 10 karakter',
            'location.min' => 'Lokasi minimal 5 karakter',
            'price.min' => 'Harga minimal Rp 10.000',
            'price.max' => 'Harga maksimal Rp 999.999.999',
            'rating.max' => 'Rating maksimal 5 bintang',
            'total_visitors.max' => 'Jumlah pengunjung tidak realistis',
        ]);

        // ===== CREATE RECORD =====
        Destination::create($validated);

        // ===== REDIRECT =====
        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destinasi berhasil ditambahkan!');
    }

    /**
     * Show destination details
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\View\View
     */
    public function show(Destination $destination)
    {
        return view('admin.destinations.show', compact('destination'));
    }

    /**
     * Show edit destination form
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\View\View
     */
    public function edit(Destination $destination)
    {
        return view('admin.destinations.edit', compact('destination'));
    }

    /**
     * Update destination in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Destination $destination)
    {
        // ===== VALIDATION =====
        $validated = $request->validate([
            'name' => 'required|string|min:5|max:100|unique:destinations,name,' . $destination->id,       // Name: unique except current
            'description' => 'required|string|min:10|max:2000',                                            // Description: min 10 chars
            'location' => 'required|string|min:5|max:100',                                                 // Location: min 5 chars
            'price' => 'required|numeric|min:10000|max:999999999',                                         // Price: Rp 10K - 999M
            'image_url' => 'nullable|url|max:500',                                                         // Image URL: valid URL
            'rating' => 'nullable|numeric|min:0|max:5',                                                    // Rating: 0-5 stars
            'total_visitors' => 'nullable|numeric|min:0|max:9999999',                                      // Visitors: realistic
        ], [
            'name.min' => 'Nama destinasi minimal 5 karakter',
            'name.unique' => 'Nama destinasi sudah ada',
            'description.min' => 'Deskripsi minimal 10 karakter',
            'location.min' => 'Lokasi minimal 5 karakter',
            'price.min' => 'Harga minimal Rp 10.000',
            'price.max' => 'Harga maksimal Rp 999.999.999',
            'rating.max' => 'Rating maksimal 5 bintang',
            'total_visitors.max' => 'Jumlah pengunjung tidak realistis',
        ]);

        // ===== UPDATE RECORD =====
        $destination->update($validated);

        // ===== REDIRECT =====
        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destinasi berhasil diperbarui!');
    }

    /**
     * Delete destination from database
     * 
     * Cascade delete: all reservations linked to this destination are also deleted
     *
     * @param  \App\Models\Destination  $destination
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Destination $destination)
    {
        // ===== DELETE RECORD =====
        // Cascade delete via foreign key constraint
        $destination->delete();

        // ===== REDIRECT =====
        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destinasi berhasil dihapus!');
    }
}
