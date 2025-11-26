@extends('layouts.admin')

@section('title', 'Daftar Reservasi')
@section('page-title', 'Daftar Reservasi')

@section('content')

<!-- ===== HEADER SECTION ===== -->
<div class="mb-4">
    <div class="row align-items-end gap-3">
        <div class="col-md-2">
            <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary w-100">
                <i class="bi bi-plus-circle"></i> Tambah Reservasi
            </a>
        </div>
    </div>
</div>

<!-- ===== FILTER & SEARCH SECTION ===== -->
<div class="table-container mb-4">
    <form method="GET" action="{{ route('admin.reservations.index') }}" class="row g-3">
        
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

        <!-- Date Range Filters -->
        <div class="col-md-2">
            <label class="form-label">
                <i class="bi bi-calendar"></i> Dari Tanggal
            </label>
            <input 
                type="date" 
                name="date_from" 
                class="form-control" 
                value="{{ request('date_from') }}">
        </div>

        <div class="col-md-2">
            <label class="form-label">
                <i class="bi bi-calendar"></i> Sampai Tanggal
            </label>
            <input 
                type="date" 
                name="date_to" 
                class="form-control" 
                value="{{ request('date_to') }}">
        </div>

        <!-- Status Filter -->
        <div class="col-md-2">
            <label class="form-label">
                <i class="bi bi-tag"></i> Status
            </label>
            <select name="status" class="form-select">
                <option value="">-- Semua Status --</option>
                <option value="pending" @if(request('status') == 'pending') selected @endif>
                    ⏳ Pending
                </option>
                <option value="confirmed" @if(request('status') == 'confirmed') selected @endif>
                    ✓ Terkonfirmasi
                </option>
                <option value="cancelled" @if(request('status') == 'cancelled') selected @endif>
                    ✗ Dibatalkan
                </option>
            </select>
        </div>

        <!-- Destination Filter -->
        <div class="col-md-3">
            <label class="form-label">
                <i class="bi bi-map"></i> Destinasi
            </label>
            <select name="destination_id" class="form-select">
                <option value="">-- Semua Destinasi --</option>
                @foreach($destinations as $dest)
                    <option 
                        value="{{ $dest->id }}" 
                        @if(request('destination_id') == $dest->id) selected @endif>
                        {{ $dest->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Sort Fields -->
        <div class="col-md-2">
            <label class="form-label">
                <i class="bi bi-arrow-down-up"></i> Urutkan
            </label>
            <select name="sort_by" class="form-select">
                <option value="reservation_date" @if(request('sort_by') == 'reservation_date') selected @endif>
                    Tanggal Reservasi
                </option>
                <option value="customer_name" @if(request('sort_by') == 'customer_name') selected @endif>
                    Nama Customer
                </option>
                <option value="total_price" @if(request('sort_by') == 'total_price') selected @endif>
                    Total Harga
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
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
            <span class="text-muted ms-3">
                Menampilkan <strong>{{ $reservations->count() }}</strong> dari 
                <strong>{{ $reservations->total() }}</strong> reservasi
            </span>
        </div>
    </form>
</div>

<!-- ===== DATA TABLE SECTION ===== -->
<div class="table-container">
    @if($reservations->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                
                <!-- Table Header -->
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 15%;">Nama Customer</th>
                        <th style="width: 15%;">Email</th>
                        <th style="width: 15%;">Destinasi</th>
                        <th style="width: 12%;">Tanggal</th>
                        <th style="width: 8%;">Jumlah</th>
                        <th style="width: 12%;">Total Harga</th>
                        <th style="width: 10%;">Status</th>
                        <th style="width: 18%;">Aksi</th>
                    </tr>
                </thead>

                <!-- Table Body -->
                <tbody>
                    @forelse($reservations as $index => $res)
                        <tr>
                            <!-- No Column -->
                            <td>
                                {{ ($reservations->currentPage() - 1) * $reservations->perPage() + $loop->iteration }}
                            </td>

                            <!-- Customer Info -->
                            <td>{{ $res->customer_name }}</td>
                            <td>{{ $res->customer->email }}</td>
                            <td>{{ $res->destination->name }}</td>

                            <!-- Reservation Details -->
                            <td>{{ $res->reservation_date->format('d M Y') }}</td>
                            <td>{{ $res->quantity }} orang</td>
                            <td>Rp {{ number_format($res->total_price, 0, ',', '.') }}</td>

                            <!-- Status Badge -->
                            <td>
                                @if($res->status === 'pending')
                                    <span class="badge bg-warning">⏳ Pending</span>
                                @elseif($res->status === 'confirmed')
                                    <span class="badge bg-success">✓ Terkonfirmasi</span>
                                @else
                                    <span class="badge bg-danger">✗ Dibatalkan</span>
                                @endif
                            </td>

                            <!-- Action Buttons -->
                            <td>
                                <a 
                                    href="{{ route('admin.reservations.show', $res) }}" 
                                    class="btn btn-sm btn-info btn-action"
                                    title="Lihat Detail">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                
                                <a 
                                    href="{{ route('admin.reservations.edit', $res) }}" 
                                    class="btn btn-sm btn-warning btn-action"
                                    title="Edit Reservasi">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                
                                <form 
                                    action="{{ route('admin.reservations.destroy', $res) }}" 
                                    method="POST" 
                                    class="d-inline" 
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="btn btn-sm btn-danger btn-action"
                                        title="Hapus Reservasi">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5">
                                <i class="bi bi-inbox" style="font-size: 2rem; color: #bdc3c7;"></i>
                                <p class="text-muted mt-2">Tidak ada reservasi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination Section -->
        <nav class="mt-4">
            {{ $reservations->links('pagination::bootstrap-5') }}
        </nav>

    @else
        <!-- Empty State Section -->
        <div class="text-center py-5">
            <i 
                class="bi bi-inbox" 
                style="font-size: 3rem; color: #bdc3c7;">
            </i>
            <p class="text-muted mt-3">
                Belum ada reservasi. 
                <a href="{{ route('admin.reservations.create') }}">
                    Tambah sekarang
                </a>
            </p>
        </div>
    @endif
</div>

@endsection
