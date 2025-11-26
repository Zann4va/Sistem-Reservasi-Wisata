<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

/**
 * CustomerController
 * Handles CRUD operations for customers
 */
class CustomerController extends Controller
{
    /**
     * Display paginated list of customers with search & filters
     *
     * Supports:
     * - Search by name, email, or phone
     * - Filter by city
     * - Sort by any column in any order
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // ===== BUILD QUERY =====
        $query = Customer::query();

        // ===== SEARCH FILTERS =====
        // Search by name, email, or phone
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
        }

        // ===== CITY FILTER =====
        // Filter by city
        if ($request->filled('city')) {
            $query->where('city', $request->input('city'));
        }

        // ===== SORTING =====
        // Sort by column (default: name) and order (default: asc)
        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // ===== PAGINATION =====
        // 10 items per page, preserve query parameters
        $customers = $query->paginate(10)->appends($request->query());
        
        return view('admin.customers.index', compact('customers'));
    }

    /**
     * Show create customer form
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('admin.customers.create');
    }

    /**
     * Store new customer in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // ===== VALIDATION =====
        $validated = $request->validate([
            'name' => 'required|string|max:100',                   // Customer name
            'email' => 'required|email|unique:customers,email',    // Email (unique)
            'phone' => 'required|string|max:20',                   // Phone number
            'address' => 'nullable|string',                        // Address (optional)
            'city' => 'nullable|string|max:100',                   // City (optional)
            'province' => 'nullable|string|max:100',               // Province (optional)
            'postal_code' => 'nullable|string|max:10',             // Postal code (optional)
            'notes' => 'nullable|string',                          // Notes (optional)
        ]);

        // ===== CREATE RECORD =====
        Customer::create($validated);

        // ===== REDIRECT =====
        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil ditambahkan!');
    }

    /**
     * Show customer details
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\View\View
     */
    public function show(Customer $customer)
    {
        // ===== LOAD RESERVATIONS =====
        $reservations = $customer->reservations()->with('destination')->get();
        
        return view('admin.customers.show', compact('customer', 'reservations'));
    }

    /**
     * Show edit customer form
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\View\View
     */
    public function edit(Customer $customer)
    {
        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update customer in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Customer $customer)
    {
        // ===== VALIDATION =====
        $validated = $request->validate([
            'name' => 'required|string|max:100',                                   // Customer name
            'email' => 'required|email|unique:customers,email,' . $customer->id,   // Email (unique except current)
            'phone' => 'required|string|max:20',                                   // Phone number
            'address' => 'nullable|string',                                        // Address (optional)
            'city' => 'nullable|string|max:100',                                   // City (optional)
            'province' => 'nullable|string|max:100',                               // Province (optional)
            'postal_code' => 'nullable|string|max:10',                             // Postal code (optional)
            'notes' => 'nullable|string',                                          // Notes (optional)
        ]);

        // ===== UPDATE RECORD =====
        $customer->update($validated);

        // ===== REDIRECT =====
        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil diperbarui!');
    }

    /**
     * Delete customer from database
     * 
     * Cascade delete: all reservations linked to this customer are also deleted
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Customer $customer)
    {
        // ===== DELETE RECORD =====
        // Cascade delete via foreign key constraint
        $customer->delete();

        // ===== REDIRECT =====
        return redirect()->route('admin.customers.index')
            ->with('success', 'Customer berhasil dihapus!');
    }
}
