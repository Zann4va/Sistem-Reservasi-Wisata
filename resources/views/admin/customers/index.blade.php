@extends('layouts.admin')

@section('title', 'Daftar Customer')
@section('page-title', 'Daftar Customer')

@section('content')

<!-- ===== HEADER SECTION ===== -->
<div class="mb-4">
    <div class="row align-items-end gap-3">
        <div class="col-md-2">
            <a href="{{ route('admin.customers.create') }}" class="btn btn-primary w-100">
                <i class="bi bi-plus-circle"></i> Tambah Customer
            </a>
        </div>
    </div>
</div>

<!-- ===== FILTER & SEARCH SECTION ===== -->
<div class="table-container mb-4">
    <form method="GET" action="{{ route('admin.customers.index') }}" class="row g-3">
        
        <!-- Search Field -->
        <div class="col-md-3">
            <label class="form-label">
                <i class="bi bi-search"></i> Cari Nama/Email/HP
            </label>
            <input 
                type="text" 
                name="search" 
                class="form-control" 
                placeholder="Nama atau email..." 
                value="{{ request('search') }}">
        </div>

        <!-- City Filter -->
        <div class="col-md-3">
            <label class="form-label">
                <i class="bi bi-geo-alt"></i> Kota
            </label>
            <input 
                type="text" 
                name="city" 
                class="form-control" 
                placeholder="Kota..." 
                value="{{ request('city') }}">
        </div>

        <!-- Sort Fields -->
        <div class="col-md-2">
            <label class="form-label">
                <i class="bi bi-arrow-down-up"></i> Urutkan
            </label>
            <select name="sort_by" class="form-select">
                <option value="name" @if(request('sort_by') == 'name') selected @endif>
                    Nama
                </option>
                <option value="email" @if(request('sort_by') == 'email') selected @endif>
                    Email
                </option>
                <option value="city" @if(request('sort_by') == 'city') selected @endif>
                    Kota
                </option>
                <option value="created_at" @if(request('sort_by') == 'created_at') selected @endif>
                    Dibuat
                </option>
            </select>
        </div>

        <div class="col-md-1">
            <label class="form-label">&nbsp;</label>
            <select name="sort_order" class="form-select">
                <option value="desc" @if(request('sort_order') == 'desc') selected @endif>
                    ↓ Terbaru
                </option>
                <option value="asc" @if(request('sort_order') == 'asc') selected @endif>
                    ↑ Terlama
                </option>
            </select>
        </div>

        <!-- Action Buttons -->
        <div class="col-12">
            <button type="submit" class="btn btn-success me-2">
                <i class="bi bi-search"></i> Filter & Cari
            </button>
            <a href="{{ route('admin.customers.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
            <span class="text-muted ms-3">
                Menampilkan <strong>{{ $customers->count() }}</strong> dari 
                <strong>{{ $customers->total() }}</strong> customer
            </span>
        </div>
    </form>
</div>

<!-- ===== DATA TABLE SECTION ===== -->
<div class="table-container">
    @if($customers->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                
                <!-- Table Header -->
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">Nama</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 15%;">Telepon</th>
                        <th style="width: 15%;">Kota</th>
                        <th style="width: 10%;">Provinsi</th>
                        <th style="width: 15%;">Aksi</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody>
                    @forelse($customers as $index => $customer)
                        <tr>
                            <!-- No Column -->
                            <td>
                                {{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}
                            </td>

                            <!-- Customer Info -->
                            <td>{{ $customer->name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->city ?? '-' }}</td>
                            <td>{{ $customer->province ?? '-' }}</td>

                            <!-- Action Buttons -->
                            <td>
                                <a 
                                    href="{{ route('admin.customers.show', $customer) }}" 
                                    class="btn btn-sm btn-info btn-action"
                                    title="Lihat Detail">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                
                                <a 
                                    href="{{ route('admin.customers.edit', $customer) }}" 
                                    class="btn btn-sm btn-warning btn-action"
                                    title="Edit Customer">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                
                                <form 
                                    action="{{ route('admin.customers.destroy', $customer) }}" 
                                    method="POST" 
                                    class="d-inline" 
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus customer ini? Semua reservasi customer akan dihapus.');">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="btn btn-sm btn-danger btn-action"
                                        title="Hapus Customer">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 2rem; color: #bdc3c7;"></i>
                                <p class="text-muted mt-2">Tidak ada customer</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <nav class="mt-4">
            {{ $customers->links('pagination::bootstrap-5') }}
        </nav>

    @else
        <!-- Empty State Section -->
        <div class="text-center py-5">
            <i 
                class="bi bi-inbox" 
                style="font-size: 3rem; color: #bdc3c7;">
            </i>
            <p class="text-muted mt-3">
                Belum ada customer. 
                <a href="{{ route('admin.customers.create') }}">
                    Tambah sekarang
                </a>
            </p>
        </div>
    @endif
</div>

@endsection
