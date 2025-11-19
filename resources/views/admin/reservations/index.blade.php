@extends('layouts.admin')

@section('title', 'Daftar Reservasi')
@section('page-title', 'Daftar Reservasi')

@section('content')
<div class="mb-3">
    <a href="{{ route('admin.reservations.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Reservasi
    </a>
</div>

<div class="table-container">
    @if($reservations->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Customer</th>
                        <th>Email</th>
                        <th>Destinasi</th>
                        <th>Tanggal</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reservations as $index => $res)
                        <tr>
                            <td>{{ ($reservations->currentPage() - 1) * $reservations->perPage() + $loop->iteration }}</td>
                            <td>{{ $res->customer_name }}</td>
                            <td>{{ $res->customer_email }}</td>
                            <td>{{ $res->destination->name }}</td>
                            <td>{{ $res->reservation_date->format('d M Y') }}</td>
                            <td>{{ $res->quantity }}</td>
                            <td>Rp {{ number_format($res->total_price, 0, ',', '.') }}</td>
                            <td>
                                @if($res->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($res->status === 'confirmed')
                                    <span class="badge bg-success">Terkonfirmasi</span>
                                @else
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.reservations.show', $res) }}" class="btn btn-sm btn-info btn-action">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                <a href="{{ route('admin.reservations.edit', $res) }}" class="btn btn-sm btn-warning btn-action">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('admin.reservations.destroy', $res) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus?');">
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
                            <td colspan="9" class="text-center py-4">
                                <i class="bi bi-inbox" style="font-size: 2rem; color: #bdc3c7;"></i>
                                <p class="text-muted mt-2">Tidak ada reservasi</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <nav>
            {{ $reservations->links('pagination::bootstrap-5') }}
        </nav>
    @else
        <div class="text-center py-5">
            <i class="bi bi-inbox" style="font-size: 3rem; color: #bdc3c7;"></i>
            <p class="text-muted mt-3">Belum ada reservasi. <a href="{{ route('admin.reservations.create') }}">Tambah sekarang</a></p>
        </div>
    @endif
</div>

@endsection
