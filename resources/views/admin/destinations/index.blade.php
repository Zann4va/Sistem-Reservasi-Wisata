@extends('layouts.admin')

@section('title', 'Daftar Destinasi')
@section('page-title', 'Daftar Destinasi')

@section('content')
<div class="mb-4">
    <div class="row align-items-end gap-3">
        <div class="col-md-2">
            <a href="{{ route('admin.destinations.create') }}" class="btn btn-primary w-100">
                <i class="bi bi-plus-circle"></i> Tambah Destinasi
            </a>
        </div>
    </div>
</div>

<!-- Search & Filter Section -->
<div class="table-container mb-4">
    <form method="GET" action="{{ route('admin.destinations.index') }}" class="row g-3">
        <div class="col-md-3">
            <label class="form-label"><i class="bi bi-search"></i> Cari Nama/Lokasi</label>
            <input type="text" name="search" class="form-control" placeholder="Candi Borobudur..." value="{{ request('search') }}">
        </div>

        <div class="col-md-2">
            <label class="form-label"><i class="bi bi-tag"></i> Harga Min</label>
            <input type="number" name="price_min" class="form-control" placeholder="0" value="{{ request('price_min') }}">
        </div>

        <div class="col-md-2">
            <label class="form-label"><i class="bi bi-tag"></i> Harga Max</label>
            <input type="number" name="price_max" class="form-control" placeholder="1000000" value="{{ request('price_max') }}">
        </div>

        <div class="col-md-2">
            <label class="form-label"><i class="bi bi-star"></i> Rating Min</label>
            <select name="rating" class="form-select">
                <option value="">-- Semua --</option>
                <option value="4" {{ request('rating') == 4 ? 'selected' : '' }}>⭐ 4 ke atas</option>
                <option value="4.5" {{ request('rating') == 4.5 ? 'selected' : '' }}>⭐ 4.5 ke atas</option>
                <option value="5" {{ request('rating') == 5 ? 'selected' : '' }}>⭐ 5 (Sempurna)</option>
            </select>
        </div>

        <div class="col-md-2">
            <label class="form-label"><i class="bi bi-arrow-down-up"></i> Urutkan</label>
            <select name="sort_by" class="form-select">
                <option value="name" {{ request('sort_by') == 'name' ? 'selected' : '' }}>Nama</option>
                <option value="price" {{ request('sort_by') == 'price' ? 'selected' : '' }}>Harga</option>
                <option value="rating" {{ request('sort_by') == 'rating' ? 'selected' : '' }}>Rating</option>
                <option value="total_visitors" {{ request('sort_by') == 'total_visitors' ? 'selected' : '' }}>Pengunjung</option>
                <option value="created_at" {{ request('sort_by') == 'created_at' ? 'selected' : '' }}>Terbaru</option>
            </select>
        </div>

        <div class="col-md-1">
            <label class="form-label">&nbsp;</label>
            <select name="sort_order" class="form-select">
                <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>↑ Naik</option>
                <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>↓ Turun</option>
            </select>
        </div>

        <div class="col-12">
            <button type="submit" class="btn btn-success me-2">
                <i class="bi bi-search"></i> Filter & Cari
            </button>
            <a href="{{ route('admin.destinations.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-clockwise"></i> Reset
            </a>
            <span class="text-muted ms-3">
                Menampilkan <strong>{{ $destinations->count() }}</strong> dari <strong>{{ $destinations->total() }}</strong> destinasi
            </span>
        </div>
    </form>
</div>

<div class="table-container">
    @if($destinations->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Gambar</th>
                        <th>Nama</th>
                        <th>Lokasi</th>
                        <th>Harga</th>
                        <th>Rating</th>
                        <th>Pengunjung</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($destinations as $index => $dest)
                        <tr>
                            <td>{{ ($destinations->currentPage() - 1) * $destinations->perPage() + $loop->iteration }}</td>
                            <td>
                                <img src="{{ $dest->image_url }}" alt="{{ $dest->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                            </td>
                            <td>{{ $dest->name }}</td>
                            <td>{{ $dest->location }}</td>
                            <td>Rp {{ number_format($dest->price, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-warning">
                                    <i class="bi bi-star-fill"></i> {{ $dest->rating ?? 0 }}
                                </span>
                            </td>
                            <td>{{ $dest->total_visitors }}</td>
                            <td>
                                <a href="{{ route('admin.destinations.show', $dest) }}" class="btn btn-sm btn-info btn-action">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                <a href="{{ route('admin.destinations.edit', $dest) }}" class="btn btn-sm btn-warning btn-action">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.destinations.destroy', $dest) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger btn-action">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem; color: #bdc3c7;"></i>
                                <p class="text-muted mt-2">Tidak ada destinasi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <nav>
            {{ $destinations->links('pagination::bootstrap-5') }}
        </nav>
    @else
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size: 3rem; color: #bdc3c7;"></i>
            <p class="text-muted mt-3">Belum ada destinasi. <a href="{{ route('admin.destinations.create') }}">Tambah sekarang</a></p>
        </div>
    @endif
</div>

@endsection
