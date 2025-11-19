@extends('layouts.admin')

@section('title', 'Daftar Destinasi')
@section('page-title', 'Daftar Destinasi')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.destinations.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Destinasi
    </a>
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
