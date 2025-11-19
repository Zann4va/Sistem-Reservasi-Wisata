<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    public function index(Request $request)
    {
        $query = Destination::query();

        // Search by name or location
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('location', 'LIKE', "%{$search}%");
        }

        // Filter by price range
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->input('price_max'));
        }

        // Filter by rating
        if ($request->filled('rating')) {
            $rating = $request->input('rating');
            $query->where('rating', '>=', $rating);
        }

        // Sort by
        $sortBy = $request->input('sort_by', 'name');
        $sortOrder = $request->input('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $destinations = $query->paginate(10)->appends($request->query());
        
        return view('admin.destinations.index', compact('destinations'));
    }

    public function create()
    {
        return view('admin.destinations.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'location' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        Destination::create($validated);

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destinasi berhasil ditambahkan!');
    }

    public function show(Destination $destination)
    {
        return view('admin.destinations.show', compact('destination'));
    }

    public function edit(Destination $destination)
    {
        return view('admin.destinations.edit', compact('destination'));
    }

    public function update(Request $request, Destination $destination)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'required|string',
            'location' => 'required|string|max:100',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url',
            'rating' => 'nullable|numeric|min:0|max:5',
        ]);

        $destination->update($validated);

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destinasi berhasil diperbarui!');
    }

    public function destroy(Destination $destination)
    {
        $destination->delete();

        return redirect()->route('admin.destinations.index')
            ->with('success', 'Destinasi berhasil dihapus!');
    }
}
