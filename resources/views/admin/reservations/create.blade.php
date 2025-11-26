@extends('layouts.admin')

@section('title', 'Tambah Reservasi')
@section('page-title', 'Tambah Reservasi Baru')

@section('content')

<!-- ===== FORM CONTAINER ===== -->
<div class="form-container">
    <form 
        action="{{ route('admin.reservations.store') }}" 
        method="POST">
        @csrf

        <!-- ===== CUSTOMER DATA SECTION ===== -->
        <h5 class="mb-4">
            <i class="bi bi-person-circle"></i> Data Customer
        </h5>

        <!-- Customer Selection -->
        <div class="form-group mb-4">
            <label for="customer_id">
                Pilih Customer <span class="text-danger">*</span>
            </label>
            <select 
                class="form-select @error('customer_id') is-invalid @enderror" 
                id="customer_id" 
                name="customer_id" 
                required>
                <option value="">-- Pilih Customer --</option>
                @foreach($customers as $customer)
                    <option 
                        value="{{ $customer->id }}"
                        @if(old('customer_id') == $customer->id) selected @endif>
                        {{ $customer->name }} ({{ $customer->email }})
                    </option>
                @endforeach
            </select>
            @error('customer_id')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>

        <hr>

        <!-- ===== RESERVATION DATA SECTION ===== -->
        <h5 class="mb-4">
            <i class="bi bi-calendar-check"></i> Data Reservasi
        </h5>

        <!-- Destination & Date -->
        <div class="row">
            <!-- Destination Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="destination_id">
                        Destinasi <span class="text-danger">*</span>
                    </label>
                    <select 
                        class="form-select @error('destination_id') is-invalid @enderror" 
                        id="destination_id" 
                        name="destination_id" 
                        required 
                        onchange="updatePrice()">
                        <option value="">Pilih Destinasi</option>
                        @foreach($destinations as $dest)
                            <option 
                                value="{{ $dest->id }}" 
                                data-price="{{ $dest->price }}" 
                                @if(old('destination_id') == $dest->id) selected @endif>
                                {{ $dest->name }} - Rp {{ number_format($dest->price, 0, ',', '.') }}
                            </option>
                        @endforeach
                    </select>
                    @error('destination_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Date Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="reservation_date">
                        Tanggal Reservasi <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="date" 
                        class="form-control @error('reservation_date') is-invalid @enderror" 
                        id="reservation_date" 
                        name="reservation_date" 
                        value="{{ old('reservation_date') }}" 
                        required>
                    @error('reservation_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Quantity & Price -->
        <div class="row">
            <!-- Quantity Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="quantity">
                        Jumlah Orang <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="number" 
                        class="form-control @error('quantity') is-invalid @enderror" 
                        id="quantity" 
                        name="quantity" 
                        value="{{ old('quantity', 1) }}" 
                        min="1" 
                        required 
                        onchange="updatePrice()">
                    @error('quantity')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Total Price Field -->
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="total_price">
                        Total Harga (Rp) <span class="text-danger">*</span>
                    </label>
                    <input 
                        type="number" 
                        class="form-control @error('total_price') is-invalid @enderror" 
                        id="total_price" 
                        name="total_price" 
                        value="{{ old('total_price', 0) }}" 
                        step="0.01" 
                        required 
                        readonly>
                    @error('total_price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Status Field -->
        <div class="row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <label for="status">
                        Status <span class="text-danger">*</span>
                    </label>
                    <select 
                        class="form-select @error('status') is-invalid @enderror" 
                        id="status" 
                        name="status" 
                        required>
                        <option 
                            value="pending" 
                            @if(old('status') === 'pending') selected @endif>
                            ⏳ Pending
                        </option>
                        <option 
                            value="confirmed" 
                            @if(old('status') === 'confirmed') selected @endif>
                            ✓ Terkonfirmasi
                        </option>
                        <option 
                            value="cancelled" 
                            @if(old('status') === 'cancelled') selected @endif>
                            ✗ Dibatalkan
                        </option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>

        <!-- ===== NOTES SECTION ===== -->
        <div class="form-group mb-3">
            <label for="notes">
                Catatan
            </label>
            <textarea 
                class="form-control @error('notes') is-invalid @enderror" 
                id="notes" 
                name="notes" 
                rows="3"
                placeholder="Tambahkan catatan jika diperlukan...">{{ old('notes') }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- ===== ACTION BUTTONS ===== -->
        <div class="form-group">
            <button 
                type="submit" 
                class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Simpan
            </button>
            <a 
                href="{{ route('admin.reservations.index') }}" 
                class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Batal
            </a>
        </div>
    </form>
</div>

<!-- ===== PRICE CALCULATION SCRIPT ===== -->
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
