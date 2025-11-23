# 🎨 Frontend Architecture & Controller Integration

> Dokumentasi lengkap tentang **Master Layout Admin**, **Frontend Mechanics**, dan **Controller-View Integration** dalam Sistem Reservasi Wisata

---

## 📖 Daftar Isi

- [🎨 Master Layout Admin](#master-layout-admin)
- [🔗 Frontend-Backend Flow](#frontend-backend-flow)
- [📊 Dashboard Mechanics](#dashboard-mechanics)
- [🗂️ CRUD Operations Flow](#crud-operations-flow)
- [🔄 Status Management Flow](#status-management-flow)
- [⚙️ Request Handling & Validation](#request-handling--validation)
- [🎯 View Templating Patterns](#view-templating-patterns)
- [📱 Responsive Design](#responsive-design)

---

## 🎨 Master Layout Admin

### 📍 File Location
```
resources/views/layouts/admin.blade.php
```

### 🏗️ Layout Structure

Master layout dibagi menjadi 3 bagian utama:

```html
┌─────────────────────────────────────────┐
│            HEADER (HTML/Meta)           │
│  - Bootstrap 5.3 CDN                    │
│  - Bootstrap Icons 1.11.0 CDN           │
│  - Custom CSS (Design System)           │
└─────────────────────────────────────────┘
│
├─────────────────────┬───────────────────────┐
│                     │                       │
│   SIDEBAR (250px)   │   MAIN CONTENT        │
│   ┌───────────────┐ │  ┌─────────────────┐ │
│   │ Brand Header  │ │  │   TOPBAR        │ │
│   ├───────────────┤ │  ├─────────────────┤ │
│   │ Nav Menu      │ │  │  CONTENT AREA   │ │
│   │ - Dashboard   │ │  │  (@yield)       │ │
│   │ - Destinasi   │ │  │  - Alerts       │ │
│   │ - Reservasi   │ │  │  - Tables       │ │
│   │              │ │  │  - Forms        │ │
│   └───────────────┘ │  │  - Charts       │ │
│                     │  └─────────────────┘ │
│                     │                       │
└─────────────────────┴───────────────────────┘
│
└─────────────────────────────────────────┐
│        FOOTER (Bootstrap JS CDN)        │
│  - Bootstrap Bundle (Modal, Dropdown)   │
│  - Custom JavaScript (@yield extra-js) │
└─────────────────────────────────────────┘
```

### 🎯 Key Components

#### **1. SIDEBAR** (Fixed, Left Side)
```blade
<div class="sidebar">
    <!-- Header dengan branding -->
    <div class="sidebar-header">
        <h3><i class="bi bi-building"></i> Reservasi Wisata</h3>
        <p>Admin Panel</p>
    </div>

    <!-- Navigation Menu -->
    <ul class="nav-menu">
        <li>
            <a href="{{ route('admin.dashboard') }}" 
               class="@if(Route::currentRouteName() == 'admin.dashboard') active @endif">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>
        <li>
            <a href="{{ route('admin.destinations.index') }}" 
               class="@if(...) active @endif">
                <i class="bi bi-map"></i> Destinasi
            </a>
        </li>
        <li>
            <a href="{{ route('admin.reservations.index') }}" 
               class="@if(...) active @endif">
                <i class="bi bi-calendar-check"></i> Reservasi
            </a>
        </li>
    </ul>
</div>
```

**Fitur:**
- ✅ Fixed position (sticky saat scroll)
- ✅ Active state detection (kelas `active` di route saat ini)
- ✅ Icon dari Bootstrap Icons CDN
- ✅ Gradient background (primary → sidebar color)
- ✅ Responsive: 250px desktop, 200px tablet, full width mobile

#### **2. TOPBAR** (Sticky, Right Side)
```blade
<div class="topbar">
    <div class="topbar-left">
        <h2>@yield('page-title', 'Dashboard')</h2>
    </div>
    <div class="topbar-right">
        <div class="user-info">
            <span>{{ Auth::user()->username ?? 'Admin' }}</span>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </form>
    </div>
</div>
```

**Fitur:**
- ✅ Page title dinamis dari child view
- ✅ User info (username dari Auth::user())
- ✅ Logout button dengan CSRF protection
- ✅ Responsive: flexbox, wrap pada mobile

#### **3. CONTENT AREA**
```blade
<div class="content">
    <!-- Error Messages -->
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif

    <!-- Success Messages -->
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Child View Content -->
    @yield('content')
</div>
```

**Fitur:**
- ✅ Auto-display validation errors
- ✅ Auto-display success/flash messages
- ✅ Dismissible alert (bs-dismiss)
- ✅ Child template content via @yield('content')

### 🎨 Design System (CSS Variables)

```css
:root {
    --primary-color: #2c3e50;      /* Dark blue-gray */
    --sidebar-color: #34495e;      /* Darker shade */
    --accent-color: #3498db;       /* Bright blue */
    --success-color: #27ae60;      /* Green */
    --danger-color: #e74c3c;       /* Red */
}
```

**Usage in Components:**
- Primary text: `var(--primary-color)`
- Hover effects: `var(--accent-color)`
- Success buttons: `var(--success-color)`
- Danger buttons: `var(--danger-color)`

---

## 🔗 Frontend-Backend Flow

### 📊 Request-Response Cycle

```
┌─────────────┐
│   Browser   │ GET /admin/reservations?status=pending&sort_by=created_at
└──────┬──────┘
       │
       ▼
┌─────────────────────────────────────────┐
│   routes/web.php                        │
│   Route::get('/reservations',           │
│       ReservationController@index)      │
└──────┬──────────────────────────────────┘
       │
       ▼
┌─────────────────────────────────────────┐
│   ReservationController::index()         │
│   1. Build query dari Request            │
│   2. Apply filters/search                │
│   3. Paginate results                    │
│   4. Load related data (destination)     │
│   5. Return view + data                  │
└──────┬──────────────────────────────────┘
       │
       ▼
┌─────────────────────────────────────────┐
│   resources/views/...index.blade.php     │
│   1. Loop through $reservations          │
│   2. Render table rows                   │
│   3. Display filters & search form       │
│   4. Add pagination links                │
└──────┬──────────────────────────────────┘
       │
       ▼
┌─────────────┐
│   Browser   │ Render HTML response
└─────────────┘
```

---

## 📊 Dashboard Mechanics

### 🎯 DashboardController Flow

**File:** `app/Http/Controllers/Admin/DashboardController.php`

```php
public function index()
{
    // 1️⃣ CALCULATE STATISTICS (Card Data)
    $totalDestinations = Destination::count();
    $totalReservations = Reservation::count();
    $totalRevenue = Reservation::sum('total_price');
    $pendingReservations = Reservation::where('status', 'pending')->count();

    // 2️⃣ BUILD CHART DATA (30 days)
    // - Query database untuk last 30 hari
    // - Fill missing dates dengan 0
    // - Tambah variasi untuk realism (weekday vs weekend)
    $chartData = [];
    foreach (range(0, 29) as $i) {
        $dateStr = $currentDate->format('Y-m-d');
        $count = /* query */ ;
        // Adjust berdasarkan day of week
        if ($dayOfWeek >= 6) { // Weekend
            $count = max(0, $count - rand(0, 2));
        } else { // Weekday
            $count = max(0, $count + rand(0, 3));
        }
        $chartData[] = ['date' => $dateStr, 'count' => $count];
    }

    // 3️⃣ AGGREGATE DATA (Other Charts)
    $revenueByMonth = DB::table('reservations')
        ->selectRaw('DATE_FORMAT(reservation_date, "%Y-%m") as month, 
                     SUM(total_price) as revenue, COUNT(*) as count')
        ->where('reservation_date', '>=', now()->subMonths(3))
        ->groupBy(...)
        ->get();

    $statusDistribution = DB::table('reservations')
        ->selectRaw('status, COUNT(*) as count')
        ->groupBy('status')
        ->get()
        ->pluck('count', 'status')
        ->toArray();

    // 4️⃣ FETCH RELATED DATA (Top Destinations)
    $topDestinations = Destination::withCount('reservations')
        ->orderBy('reservations_count', 'desc')
        ->limit(5)
        ->get();

    // 5️⃣ PASS TO VIEW
    return view('admin.dashboard', [
        'totalDestinations' => $totalDestinations,
        'totalReservations' => $totalReservations,
        'totalRevenue' => $totalRevenue,
        'pendingReservations' => $pendingReservations,
        'chartData' => $chartData,
        'revenueByMonth' => $revenueByMonth,
        'statusDistribution' => $statusDistribution,
        'topDestinations' => $topDestinations,
    ]);
}
```

### 📈 Dashboard View Integration

**File:** `resources/views/admin/dashboard.blade.php`

```blade
@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard Analytics')

@section('extra-css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
@endsection

@section('content')
<div class="row">
    <!-- STAT CARDS -->
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-card-icon" style="background: #e3f2fd;">
                <i class="bi bi-map-fill" style="color: #2196F3;"></i>
            </div>
            <div class="stat-card-content">
                <h5>Total Destinasi</h5>
                <h3>{{ $totalDestinations }}</h3>
            </div>
        </div>
    </div>

    <!-- CHARTS -->
    <div class="col-md-8 mt-4">
        <div class="table-container">
            <h5>📈 Reservasi 30 Hari Terakhir</h5>
            <canvas id="lineChart"></canvas>
        </div>
    </div>
</div>

<!-- INITIALIZE CHARTS WITH DATA -->
@endsection

@section('extra-js')
<script>
// Data dari controller
const chartData = {!! json_encode($chartData) !!};
const revenueByMonth = {!! json_encode($revenueByMonth) !!};
const statusDistribution = {!! json_encode($statusDistribution) !!};

// Line Chart - 30 hari
const ctx1 = document.getElementById('lineChart').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: chartData.map(d => d.date),
        datasets: [{
            label: 'Reservasi',
            data: chartData.map(d => d.count),
            borderColor: '#3498db',
            backgroundColor: 'rgba(52, 152, 219, 0.1)',
            tension: 0.4,
            fill: true,
        }]
    }
});
</script>
@endsection
```

### 🔄 Data Flow untuk Dashboard

```
Controller                View                  Browser
    │                      │                       │
    ├─ Query DB ──────────>│                       │
    │  (50 queries)        │                       │
    │                      │                       │
    ├─ Calculate stats ──->│ Stat Cards            │
    │  - Count             │ <h3>50</h3>           │
    │  - Sum               │                       │
    │  - GroupBy           │                       │
    │                      │                       │
    ├─ Aggregate data ──-->│ Chart.js Data         │
    │  - Dates             │ <canvas>              │
    │  - Amounts           │ const data = {...}    │
    │  - Status            │                       │
    │                      │                       │
    └─ Return view + data->├──────────────────────>│ Render
                           │  HTML + JS             │
                           │  @section('extra-js')  │
                           │                        │ Chart.js:
                           │                        │ new Chart(ctx, {
                           │                        │   data: data,
                           │                        │   ...
                           │                        │ })
```

---

## 🗂️ CRUD Operations Flow

### 📋 Reservation Index + Filter

**Controller:** `ReservationController::index(Request $request)`

```php
public function index(Request $request)
{
    $query = Reservation::with('destination');

    // 🔍 SEARCH FILTER
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where('customer_name', 'LIKE', "%{$search}%")
              ->orWhere('customer_email', 'LIKE', "%{$search}%")
              ->orWhere('customer_phone', 'LIKE', "%{$search}%");
    }

    // 📌 STATUS FILTER
    if ($request->filled('status')) {
        $query->where('status', $request->input('status'));
    }

    // 🏖️ DESTINATION FILTER
    if ($request->filled('destination_id')) {
        $query->where('destination_id', $request->input('destination_id'));
    }

    // 📅 DATE RANGE FILTER
    if ($request->filled('date_from')) {
        $query->whereDate('reservation_date', '>=', $request->input('date_from'));
    }
    if ($request->filled('date_to')) {
        $query->whereDate('reservation_date', '<=', $request->input('date_to'));
    }

    // 📊 SORTING
    $sortBy = $request->input('sort_by', 'reservation_date');
    $sortOrder = $request->input('sort_order', 'desc');
    $query->orderBy($sortBy, $sortOrder);

    // 📄 PAGINATION (preserve filters)
    $reservations = $query->paginate(10)->appends($request->query());
    $destinations = Destination::all();
    
    return view('admin.reservations.index', 
                compact('reservations', 'destinations'));
}
```

**View:** `resources/views/admin/reservations/index.blade.php`

```blade
<!-- FILTER FORM -->
<form method="GET" action="{{ route('admin.reservations.index') }}" class="row g-3">
    <!-- Search -->
    <div class="col-md-3">
        <input type="text" name="search" class="form-control" 
               placeholder="Cari nama/email/phone"
               value="{{ request('search') }}">
    </div>

    <!-- Status Filter -->
    <div class="col-md-2">
        <select name="status" class="form-select">
            <option value="">Semua Status</option>
            <option value="pending" @if(request('status')=='pending') selected @endif>
                ⏳ Pending
            </option>
            <option value="confirmed" @if(request('status')=='confirmed') selected @endif>
                ✓ Terkonfirmasi
            </option>
            <option value="cancelled" @if(request('status')=='cancelled') selected @endif>
                ✗ Dibatalkan
            </option>
        </select>
    </div>

    <!-- Destination Filter -->
    <div class="col-md-3">
        <select name="destination_id" class="form-select">
            <option value="">Semua Destinasi</option>
            @foreach($destinations as $dest)
                <option value="{{ $dest->id }}" 
                    @if(request('destination_id')==$dest->id) selected @endif>
                    {{ $dest->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Sort -->
    <div class="col-md-2">
        <select name="sort_by" class="form-select">
            <option value="reservation_date">Tanggal</option>
            <option value="customer_name">Nama</option>
            <option value="total_price">Harga</option>
        </select>
    </div>

    <!-- Submit -->
    <div class="col-md-2">
        <button type="submit" class="btn btn-success w-100">
            <i class="bi bi-search"></i> Filter
        </button>
    </div>
</form>

<!-- TABLE -->
<div class="table-container mt-4">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Pelanggan</th>
                <th>Destinasi</th>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $res)
                <tr>
                    <td>{{ $res->customer_name }}</td>
                    <td>{{ $res->destination->name }}</td>
                    <td>{{ $res->reservation_date->format('d M Y') }}</td>
                    <td>{{ $res->quantity }} orang</td>
                    <td>Rp {{ number_format($res->total_price, 0, ',', '.') }}</td>
                    <td>
                        @if($res->status === 'pending')
                            <span class="badge bg-warning">⏳ Pending</span>
                        @elseif($res->status === 'confirmed')
                            <span class="badge bg-success">✓ Terkonfirmasi</span>
                        @else
                            <span class="badge bg-danger">✗ Dibatalkan</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.reservations.show', $res) }}" 
                           class="btn btn-sm btn-info">Lihat</a>
                        <a href="{{ route('admin.reservations.edit', $res) }}" 
                           class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.reservations.destroy', $res) }}" 
                              method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" 
                                    onclick="return confirm('Yakin?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center text-muted">
                        Tidak ada reservasi
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-center mt-4">
        {{ $reservations->links() }}
    </div>
</div>
```

### 🔄 Key Mechanics

| Aspek | Deskripsi |
|-------|-----------|
| **Query Building** | Dynamic WHERE clauses berdasarkan request input |
| **Filter Preservation** | `->appends($request->query())` di pagination |
| **Search** | LIKE query di 3 kolom: name, email, phone |
| **Sorting** | Dynamic `orderBy($sortBy, $sortOrder)` |
| **Pagination** | 10 items per halaman, preserve filters |
| **Relationship** | `.with('destination')` load eager |
| **Selected State** | `request('fieldname') == value` di form |

---

## 🔄 Status Management Flow

### ✨ Quick Action Buttons (Show Page)

**Controller:** `ReservationController::changeStatus(Request $request, Reservation $res)`

```php
public function changeStatus(Request $request, Reservation $reservation)
{
    // 1️⃣ VALIDATE INPUT
    $validated = $request->validate([
        'status' => 'required|in:pending,confirmed,cancelled',
        'reason' => 'nullable|string',
    ]);

    // 2️⃣ SAVE OLD STATUS (for audit trail)
    $oldStatus = $reservation->status;
    
    // 3️⃣ UPDATE RESERVATION
    $reservation->status = $validated['status'];
    $reservation->save();

    // 4️⃣ LOG TO AUDIT TRAIL
    StatusHistory::create([
        'reservation_id' => $reservation->id,
        'old_status' => $oldStatus,
        'new_status' => $validated['status'],
        'reason' => $validated['reason'] ?? null,
        'changed_by' => Auth::user()->email,
    ]);

    // 5️⃣ RETURN WITH SUCCESS MESSAGE
    return back()->with('success', 
        'Status berhasil diubah menjadi ' . strtoupper($validated['status']));
}
```

**View:** `resources/views/admin/reservations/show.blade.php`

```blade
<!-- QUICK ACTIONS SIDEBAR -->
<div class="col-md-4">
    <div style="background: #f8f9fa; padding: 20px; border-radius: 10px;">
        <h6><i class="bi bi-lightning"></i> Quick Actions</h6>

        <!-- KONFIRMASI Button (jika status !== confirmed) -->
        @if($reservation->status !== 'confirmed')
            <form action="{{ route('admin.reservations.changeStatus', $reservation) }}" 
                  method="POST" class="mb-2">
                @csrf
                <input type="hidden" name="status" value="confirmed">
                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-check"></i> Konfirmasi
                </button>
            </form>
        @endif

        <!-- BATALKAN Button (Modal trigger) -->
        @if($reservation->status !== 'cancelled')
            <button type="button" class="btn btn-danger w-100" 
                    data-bs-toggle="modal" data-bs-target="#cancelModal">
                <i class="bi bi-x-circle"></i> Batalkan
            </button>
        @endif

        <hr>

        <!-- LIHAT RIWAYAT Link -->
        <a href="{{ route('admin.reservations.statusHistory', $reservation) }}" 
           class="btn btn-secondary w-100">
            <i class="bi bi-clock-history"></i> Lihat Riwayat
        </a>
    </div>
</div>

<!-- CANCEL MODAL -->
<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Batalkan Reservasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.reservations.changeStatus', $reservation) }}" 
                  method="POST">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="status" value="cancelled">
                    <div class="mb-3">
                        <label class="form-label"><strong>Alasan Pembatalan</strong></label>
                        <textarea name="reason" class="form-control" rows="3" 
                                  placeholder="Jelaskan alasan pembatalan..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" 
                            data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        Batalkan Reservasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
```

### 📜 Status History Timeline

**Controller:** `ReservationController::statusHistory(Reservation $res)`

```php
public function statusHistory(Reservation $reservation)
{
    // Load status histories ordered by latest first
    $histories = $reservation->statusHistories;
    return view('admin.reservations.status-history', 
                compact('reservation', 'histories'));
}
```

**View:** `resources/views/admin/reservations/status-history.blade.php`

```blade
<div class="timeline">
    @foreach($histories as $history)
        <div class="timeline-item">
            <!-- Timeline dot & line -->
            <div class="timeline-marker"></div>

            <!-- Content -->
            <div class="timeline-content">
                <div class="timeline-header">
                    <span class="badge bg-primary">
                        {{ strtoupper($history->old_status) }}
                    </span>
                    <i class="bi bi-arrow-right mx-2"></i>
                    <span class="badge bg-success">
                        {{ strtoupper($history->new_status) }}
                    </span>
                </div>

                <div class="timeline-meta">
                    <small class="text-muted">
                        <i class="bi bi-person"></i> {{ $history->changed_by }}
                    </small>
                    <br>
                    <small class="text-muted">
                        <i class="bi bi-clock"></i> 
                        {{ $history->created_at->format('d M Y H:i') }}
                    </small>
                </div>

                @if($history->reason)
                    <div class="mt-2">
                        <strong>Alasan:</strong> {{ $history->reason }}
                    </div>
                @endif

                @if($history->notes)
                    <div class="mt-2">
                        <strong>Catatan:</strong> {{ $history->notes }}
                    </div>
                @endif
            </div>
        </div>
    @endforeach
</div>
```

---

## ⚙️ Request Handling & Validation

### 🔐 Input Validation Pattern

**Reservation Store/Update Example:**

```php
public function store(Request $request)
{
    // VALIDATION RULES
    $validated = $request->validate([
        'customer_name' => 'required|string|max:100',
        'customer_email' => 'required|email|max:100',
        'customer_phone' => 'required|string|max:20',
        'destination_id' => 'required|exists:destinations,id',
        'reservation_date' => 'required|date',
        'quantity' => 'required|integer|min:1',
        'total_price' => 'required|numeric|min:0',
        'status' => 'required|in:pending,confirmed,cancelled',
        'notes' => 'nullable|string',
    ]);

    // CREATE OR UPDATE
    $reservation = Reservation::create($validated);

    // LOG AUDIT TRAIL
    StatusHistory::create([
        'reservation_id' => $reservation->id,
        'old_status' => null,
        'new_status' => $validated['status'],
        'changed_by' => Auth::user()->email,
        'notes' => 'Reservasi dibuat',
    ]);

    // REDIRECT WITH MESSAGE
    return redirect()->route('admin.reservations.index')
        ->with('success', 'Reservasi berhasil ditambahkan!');
}
```

### 🎯 Validation Error Display

**In Layout:**

```blade
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Ada kesalahan!</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
```

**In Form Fields:**

```blade
<div class="form-group">
    <label>Email</label>
    <input type="email" name="customer_email" 
           class="form-control @error('customer_email') is-invalid @enderror"
           value="{{ old('customer_email') }}">
    @error('customer_email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
```

---

## 🎯 View Templating Patterns

### 🔄 Blade Directives Digunakan

| Directive | Fungsi | Contoh |
|-----------|--------|--------|
| `@extends()` | Inherit layout | `@extends('layouts.admin')` |
| `@section()` | Define block | `@section('title', 'Dashboard')` |
| `@yield()` | Output block | `@yield('content')` |
| `@if/@else/@endif` | Conditional | `@if($item->status === 'pending')` |
| `@foreach/@endforeach` | Loop | `@foreach($items as $item)` |
| `@forelse/@empty` | Loop with fallback | `@forelse($items) ... @empty` |
| `@csrf` | CSRF token | `<form>@csrf</form>` |
| `@method()` | HTTP method | `@method('PUT')` |
| `@error()/@enderror` | Error display | `@error('field') ... @enderror` |
| `{{ }}` | Echo (escaped) | `{{ $variable }}` |
| `{!! !!}` | Echo (unescaped) | `{!! $html !!}` |

### 📝 Form Pattern

```blade
<form action="{{ route('admin.reservations.store') }}" method="POST" class="form-container">
    @csrf
    
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label">Nama Pelanggan</label>
                <input type="text" name="customer_name" class="form-control" 
                       value="{{ old('customer_name') }}"
                       @error('customer_name') is-invalid @enderror>
                @error('customer_name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Simpan
    </button>
    <a href="{{ route('admin.reservations.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</form>
```

### 📊 Table Pattern

```blade
<div class="table-container">
    <table class="table table-hover">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        @if($item->status === 'pending')
                            <span class="badge bg-warning">Pending</span>
                        @else
                            <span class="badge bg-success">Active</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route(..., $item) }}" class="btn btn-sm btn-info">
                            Edit
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
```

---

## 📱 Responsive Design

### 🎬 Breakpoints

```css
/* Desktop: >= 1200px */
.sidebar { width: 250px; }
.main-content { margin-left: 250px; }

/* Tablet: 768px - 1199px */
@media (max-width: 768px) {
    .sidebar { width: 200px; }
    .main-content { margin-left: 200px; }
    .topbar { flex-direction: column; }
}

/* Mobile: < 576px */
@media (max-width: 576px) {
    .sidebar { 
        width: 100%;
        position: relative;
        min-height: auto;
    }
    .main-content { margin-left: 0; }
    .table-container { overflow-x: auto; }
    .stat-card { flex-direction: column; }
}
```

### 📐 Grid System (Bootstrap)

```blade
<!-- 3-column pada desktop, 2-column tablet, 1-column mobile -->
<div class="row">
    <div class="col-md-4 col-sm-6 col-12">
        <div class="stat-card">...</div>
    </div>
</div>
```

---

## 🔗 Integration Summary

### Flow Chart (Request → Response)

```
User Action (Browser)
        ↓
    Route (web.php)
        ↓
    Controller (execute logic)
        ├── Query Database
        ├── Validate Input
        ├── Process Business Logic
        ├── Create Audit Trail
        └── Prepare Data
        ↓
    Blade View (render HTML)
        ├── Master Layout (layouts/admin.blade.php)
        │   ├── Sidebar Navigation
        │   ├── Topbar
        │   └── Content Area (@yield)
        │
        ├── Child View (admin/[module]/[action].blade.php)
        │   ├── Display Data
        │   ├── Forms
        │   ├── Tables
        │   └── Status Badges
        │
        └── JavaScript (extra-js section)
            ├── Chart.js
            ├── Bootstrap Modals
            └── Custom Interactions
        ↓
    HTML + CSS + JavaScript Response
        ↓
    Browser Render & Display
        ↓
    User sees result
```

---

## 📚 File Reference

| File | Purpose |
|------|---------|
| `resources/views/layouts/admin.blade.php` | Master layout template |
| `app/Http/Controllers/Admin/DashboardController.php` | Statistics & charts logic |
| `app/Http/Controllers/Admin/ReservationController.php` | Reservation CRUD & filters |
| `resources/views/admin/dashboard.blade.php` | Dashboard page |
| `resources/views/admin/reservations/index.blade.php` | Reservations list + filters |
| `resources/views/admin/reservations/show.blade.php` | Reservation detail + quick actions |
| `resources/views/admin/reservations/status-history.blade.php` | Status audit trail |

---

**Last Updated:** November 23, 2025  
**Version:** 2.1.0  
**Status:** ✅ Documentation Complete
