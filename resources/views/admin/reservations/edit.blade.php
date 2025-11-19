@extends('layouts.admin')

@section('title', 'Edit Reservasi')
@section('page-title', 'Edit Reservasi')

@section('content')
<div class="form-container">
    <form action="{{ route('admin.reservations.update', $reservation) }}" method="POST">
        @csrf
        @method('PUT')

        <h5 class="mb-4">Data Customer</h5>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="customer_name">Nama Customer *</label>
                    <input type="text" class="form-control @error('customer_name') is-invalid @enderror" 
                        id="customer_name" name="customer_name" value="{{ old('customer_name', $reservation->customer_name) }}" required>
                    @error('customer_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="customer_email">Email *</label>
                    <input type="email" class="form-control @error('customer_email') is-invalid @enderror" 
                        id="customer_email" name="customer_email" value="{{ old('customer_email', $reservation->customer_email) }}" required>
                    @error('customer_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group mb-4">
            <label for="customer_phone">Nomor Telepon *</label>
            <input type="tel" class="form-control @error('customer_phone') is-invalid @enderror" 
                id="customer_phone" name="customer_phone" value="{{ old('customer_phone', $reservation->customer_phone) }}" required>
            @error('customer_phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <hr>
        <h5 class="mb-4">Data Reservasi</h5>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="destination_id">Destinasi *</label>
                    <select class="form-select @error('destination_id') is-invalid @enderror" 
                        id="destination_id" name="destination_id" required onchange="updatePrice()">
                        <option value="">Pilih Destinasi</option>
                        @foreach($destinations as $dest)
                            <option value="{{ $dest->id }}" data-price="{{ $dest->price }}" 
                                @if(old('destination_id', $reservation->destination_id) == $dest->id) selected @endif>
                                {{ $dest->name }} - Rp {{ number_format($dest->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('destination_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="reservation_date">Tanggal Reservasi *</label>
                    <input type="date" class="form-control @error('reservation_date') is-invalid @enderror" 
                        id="reservation_date" name="reservation_date" value="{{ old('reservation_date', $reservation->reservation_date->format('Y-m-d')) }}" required>
                    @error('reservation_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="quantity">Jumlah Orang *</label>
                    <input type="number" class="form-control @error('quantity') is-invalid @enderror" 
                        id="quantity" name="quantity" value="{{ old('quantity', $reservation->quantity) }}" min="1" required onchange="updatePrice()">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="total_price">Total Harga (Rp) *</label>
                    <input type="number" class="form-control @error('total_price') is-invalid @enderror" 
                        id="total_price" name="total_price" value="{{ old('total_price', $reservation->total_price) }}" step="0.01" required readonly>
                    @error('total_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="status">Status *</label>
                    <select class="form-select @error('status') is-invalid @enderror" 
                        id="status" name="status" required>
                        <option value="pending" @if(old('status', $reservation->status) === 'pending') selected @endif>Pending</option>
                        <option value="confirmed" @if(old('status', $reservation->status) === 'confirmed') selected @endif>Terkonfirmasi</option>
                        <option value="cancelled" @if(old('status', $reservation->status) === 'cancelled') selected @endif>Dibatalkan</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <label for="notes">Catatan</label>
            <textarea class="form-control @error('notes') is-invalid @enderror" 
                id="notes" name="notes" rows="3">{{ old('notes', $reservation->notes) }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
            </button>
            <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

<script>
    function updatePrice() {
        const destinationSelect = document.getElementById('destination_id');
        const selectedOption = destinationSelect.options[destinationSelect.selectedIndex];
        const price = parseFloat(selectedOption.dataset.price) || 0;
        const quantity = parseInt(document.getElementById('quantity').value) || 1;
        const totalPrice = price * quantity;
        document.getElementById('total_price').value = totalPrice.toFixed(2);
    }
</script>

@endsection
