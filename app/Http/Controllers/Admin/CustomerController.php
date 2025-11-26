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
            'name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',                   // Name: only letters & spaces, min 3
            'email' => 'required|email|unique:customers,email|lowercase',                      // Email: unique, must be lowercase
            'phone' => 'required|regex:/^[0-9]{10,15}$/|unique:customers,phone',                // Phone: 10-15 digits only, unique
            'address' => 'nullable|string|max:500',                                            // Address: max 500 chars
            'city' => 'nullable|string|max:100|regex:/^[a-zA-Z\s]+$/',                       // City: letters & spaces only
            'province' => 'nullable|string|max:100|regex:/^[a-zA-Z\s]+$/',                   // Province: letters & spaces only
            'postal_code' => 'nullable|regex:/^[0-9]{4,6}$/',                                  // Postal code: 4-6 digits
            'notes' => 'nullable|string|max:1000',                                             // Notes: max 1000 chars
        ], [
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi',
            'name.min' => 'Nama minimal 3 karakter',
            'email.lowercase' => 'Email harus menggunakan huruf kecil',
            'phone.regex' => 'Nomor telepon harus terdiri dari 10-15 angka',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'city.regex' => 'Kota hanya boleh mengandung huruf dan spasi',
            'province.regex' => 'Provinsi hanya boleh mengandung huruf dan spasi',
            'postal_code.regex' => 'Kode pos harus terdiri dari 4-6 angka',
        ]);
        
        // ===== LOWERCASE EMAIL =====
        $validated['email'] = strtolower($validated['email']);

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
            'name' => 'required|string|min:3|max:100|regex:/^[a-zA-Z\s]+$/',                              // Name: letters & spaces, min 3
            'email' => 'required|email|unique:customers,email,' . $customer->id . '|lowercase',          // Email: unique, lowercase
            'phone' => 'required|regex:/^[0-9]{10,15}$/|unique:customers,phone,' . $customer->id,        // Phone: unique, 10-15 digits
            'address' => 'nullable|string|max:500',                                                        // Address: max 500 chars
            'city' => 'nullable|string|max:100|regex:/^[a-zA-Z\s]+$/',                                   // City: letters & spaces
            'province' => 'nullable|string|max:100|regex:/^[a-zA-Z\s]+$/',                               // Province: letters & spaces
            'postal_code' => 'nullable|regex:/^[0-9]{4,6}$/',                                              // Postal code: 4-6 digits
            'notes' => 'nullable|string|max:1000',                                                         // Notes: max 1000 chars
        ], [
            'name.regex' => 'Nama hanya boleh mengandung huruf dan spasi',
            'name.min' => 'Nama minimal 3 karakter',
            'email.lowercase' => 'Email harus menggunakan huruf kecil',
            'phone.regex' => 'Nomor telepon harus terdiri dari 10-15 angka',
            'phone.unique' => 'Nomor telepon sudah terdaftar',
            'city.regex' => 'Kota hanya boleh mengandung huruf dan spasi',
            'province.regex' => 'Provinsi hanya boleh mengandung huruf dan spasi',
            'postal_code.regex' => 'Kode pos harus terdiri dari 4-6 angka',
        ]);
        
        // ===== LOWERCASE EMAIL =====
        $validated['email'] = strtolower($validated['email']);

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
