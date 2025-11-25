# 📚 DOKUMENTASI LENGKAP - SISTEM RESERVASI WISATA

> Pemahaman menyeluruh tentang arsitektur, database, flow bisnis, dan implementasi teknis sistem

**Dibuat:** 26 November 2025  
**Stack Teknologi:** Laravel 10, MySQL 8, Bootstrap 5, Chart.js  
**Bahasa:** PHP 8.1+, MySQL, Blade (templating), HTML/CSS/JavaScript

---

## 📋 DAFTAR ISI

1. [Arsitektur Sistem](#1-arsitektur-sistem)
2. [Database Schema](#2-database-schema)
3. [Models & Relationships](#3-models--relationships)
4. [Authentication & Authorization](#4-authentication--authorization)
5. [Controllers & Business Logic](#5-controllers--business-logic)
6. [Routes & Endpoints](#6-routes--endpoints)
7. [Middleware](#7-middleware)
8. [Validasi & Error Handling](#8-validasi--error-handling)
9. [Frontend Integration](#9-frontend-integration)
10. [Fitur-Fitur Utama](#10-fitur-fitur-utama)

---

## 1. ARSITEKTUR SISTEM

### 1.1 Struktur Direktori

```
Sistem-Reservasi-Wisata/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php           ← Autentikasi
│   │   │   ├── Controller.php               ← Base Controller
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php  ← Dashboard & Analytics
│   │   │       ├── DestinationController.php ← CRUD Destinasi
│   │   │       └── ReservationController.php ← CRUD Reservasi + Status Management
│   │   ├── Middleware/
│   │   │   ├── Authenticate.php             ← Cek user sudah login?
│   │   │   ├── CheckRole.php                ← Cek role admin?
│   │   │   ├── RedirectIfAuthenticated.php  ← Jika sudah login, redirect
│   │   │   └── ... (middleware lainnya)
│   │   └── Kernel.php                       ← Middleware stack
│   ├── Models/
│   │   ├── Users.php                        ← User model
│   │   ├── Destination.php                  ← Destinasi wisata
│   │   ├── Reservation.php                  ← Reservasi
│   │   └── StatusHistory.php                ← Audit trail status
│   ├── Providers/
│   │   └── AppServiceProvider.php
│   └── Exceptions/
│       └── Handler.php
├── database/
│   ├── migrations/
│   │   ├── 2014_10_12_000000_create_users_table.php
│   │   ├── 2025_11_19_000001_create_destinations_table.php
│   │   ├── 2025_11_19_000002_create_reservations_table.php
│   │   └── 2025_11_21_091658_create_status_histories_table.php
│   ├── factories/
│   │   ├── DestinationFactory.php           ← Generate test data destinasi
│   │   └── ReservationFactory.php           ← Generate test data reservasi
│   └── seeders/
│       ├── DatabaseSeeder.php               ← Main seeder
│       ├── UserSeeder.php                   ← Create admin user
│       ├── DestinationSeeder.php            ← Create destinasi
│       └── ReservationSeeder.php            ← Create reservasi
├── routes/
│   ├── web.php                              ← Semua routes aplikasi
│   ├── api.php                              ← API routes (optional)
│   └── console.php
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   ├── dashboard.blade.php
│   │   │   ├── destinations/
│   │   │   │   ├── create.blade.php
│   │   │   │   ├── edit.blade.php
│   │   │   │   ├── index.blade.php
│   │   │   │   └── show.blade.php
│   │   │   └── reservations/
│   │   │       ├── create.blade.php
│   │   │       ├── edit.blade.php
│   │   │       ├── index.blade.php
│   │   │       ├── show.blade.php
│   │   │       └── status-history.blade.php
│   │   ├── auth/
│   │   │   ├── login.blade.php
│   │   │   └── register.blade.php
│   │   ├── errors/
│   │   │   ├── 403.blade.php
│   │   │   ├── 404.blade.php
│   │   │   └── forbidden.blade.php
│   │   ├── layouts/
│   │   │   └── admin.blade.php              ← Master layout
│   │   └── beranda.blade.php
│   ├── css/
│   │   └── app.css
│   └── js/
│       ├── app.js
│       └── bootstrap.js
├── storage/
│   ├── app/
│   ├── framework/
│   │   ├── cache/
│   │   ├── sessions/
│   │   ├── views/
│   │   └── testing/
│   └── logs/
├── tests/
│   ├── Feature/
│   └── Unit/
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── database.php
│   └── ... (config lainnya)
├── bootstrap/
│   ├── app.php
│   └── cache/
├── public/
│   ├── index.php                            ← Entry point
│   └── robots.txt
├── vendor/                                  ← Dependencies
├── .env                                     ← Environment variables
├── .env.example
├── composer.json
├── package.json
├── phpunit.xml
├── vite.config.js
└── artisan                                  ← CLI tool
```

### 1.2 Request Flow Architecture

```
┌─────────────────┐
│   HTTP Request  │
│  (URL + Method) │
└────────┬────────┘
         │
         ▼
┌──────────────────────────┐
│   Route Matching         │
│   (web.php)              │
│   ✓ Find route pattern   │
└────────┬─────────────────┘
         │
         ▼
┌──────────────────────────┐
│   Middleware Stack       │
│ 1. EncryptCookies        │
│ 2. TrimStrings           │
│ 3. ConvertEmptyStrings   │
│ 4. TrustProxies          │
│ 5. Authenticate          │◄── Cek login?
│ 6. CheckRole('admin')    │◄── Cek role?
│ 7. Session verification  │
│ 8. CSRF verification     │
└────────┬─────────────────┘
         │
         ▼
┌──────────────────────────┐
│   Controller Method      │
│ - Validate request       │
│ - Process business logic │
│ - Query/update database  │
│ - Return response        │
└────────┬─────────────────┘
         │
         ▼
┌──────────────────────────┐
│   Response Returned      │
│ - View (HTML)            │
│ - Redirect               │
│ - JSON                   │
│ - Download               │
└────────┬─────────────────┘
         │
         ▼
┌──────────────────────────┐
│   Browser Receives       │
│   Response & Renders     │
└──────────────────────────┘
```

---

## 2. DATABASE SCHEMA

### 2.1 ERD (Entity-Relationship Diagram)

```
┌──────────────────┐
│      USERS       │
├──────────────────┤
│ id (PK)          │
│ username         │
│ email (UNIQUE)   │
│ password         │
│ No_Handphone     │
│ role             │
│ created_at       │
│ updated_at       │
└────────┬─────────┘
         │
         │ (Authenticatable)
         │
         ▼
    (Admin Login)


┌──────────────────────────────┐
│     DESTINATIONS             │
├──────────────────────────────┤
│ id (PK)                      │
│ name                         │
│ description                  │
│ location                     │
│ price (decimal:12,2)         │
│ image_url                    │
│ rating (decimal:2)           │
│ total_visitors               │
│ created_at                   │
│ updated_at                   │
└────────┬──────────────────────┘
         │
         │ (1:M)
         │ hasMany Reservations
         │
         ▼
┌──────────────────────────────┐
│    RESERVATIONS              │
├──────────────────────────────┤
│ id (PK)                      │
│ customer_name                │
│ customer_email               │
│ customer_phone               │
│ destination_id (FK)          │◄─── Foreign key ke destinations
│ reservation_date             │
│ quantity                     │
│ total_price (decimal:2)      │
│ status (enum)                │
│ notes                        │
│ created_at                   │
│ updated_at                   │
└────────┬──────────────────────┘
         │
         │ (1:M)
         │ hasMany StatusHistories
         │
         ▼
┌──────────────────────────────┐
│   STATUS_HISTORIES           │
├──────────────────────────────┤
│ id (PK)                      │
│ reservation_id (FK)          │◄─── Foreign key ke reservations
│ old_status                   │
│ new_status                   │
│ reason                       │
│ changed_by                   │
│ notes                        │
│ created_at                   │
│ (indexed)                    │
└──────────────────────────────┘
```

### 2.2 Tabel Destinations

```sql
CREATE TABLE destinations (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    location VARCHAR(100) NOT NULL,
    price DECIMAL(12, 2) NOT NULL,
    image_url VARCHAR(255) NULLABLE,
    rating DECIMAL(2, 1) NULLABLE,
    total_visitors INT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Penjelasan:**
- `id`: Auto-increment primary key
- `name`: Nama destinasi wisata (max 100 karakter)
- `description`: Deskripsi lengkap destinasi
- `location`: Lokasi geografis (max 100 karakter)
- `price`: Harga per orang (12 digit total, 2 desimal = max 9999999999.99)
- `image_url`: URL gambar destinasi (opsional)
- `rating`: Rating 0-5 bintang (opsional)
- `total_visitors`: Total pengunjung sepanjang masa
- `created_at`, `updated_at`: Timestamp Laravel

### 2.3 Tabel Reservations

```sql
CREATE TABLE reservations (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    customer_name VARCHAR(100) NOT NULL,
    customer_email VARCHAR(100) NOT NULL,
    customer_phone VARCHAR(20) NOT NULL,
    destination_id BIGINT UNSIGNED NOT NULL,
    reservation_date DATE NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(12, 2) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    notes TEXT NULLABLE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (destination_id) REFERENCES destinations(id) 
        ON DELETE CASCADE
);
```

**Penjelasan:**
- `customer_*`: Data customer yang membuat reservasi
- `destination_id`: Foreign key ke destinations table
  - Cascade delete: Jika destinasi dihapus, semua reservasi juga terhapus
- `reservation_date`: Tanggal ketika pelanggan ingin berkunjung
- `quantity`: Jumlah orang yang akan berkunjung
- `total_price`: Total harga = price × quantity
- `status`: pending (menunggu), confirmed (dikonfirmasi), cancelled (dibatalkan)

### 2.4 Tabel Status Histories

```sql
CREATE TABLE status_histories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    reservation_id BIGINT UNSIGNED NOT NULL,
    old_status VARCHAR(20) NULLABLE,
    new_status VARCHAR(20) NOT NULL,
    reason TEXT NULLABLE,
    changed_by VARCHAR(255) NOT NULL,
    notes TEXT NULLABLE,
    created_at TIMESTAMP NULL,
    KEY idx_reservation_id (reservation_id),
    KEY idx_created_at (created_at),
    FOREIGN KEY (reservation_id) REFERENCES reservations(id) 
        ON DELETE CASCADE
);
```

**Penjelasan:**
- Tabel audit trail yang merekam setiap perubahan status reservasi
- `old_status`: Status sebelumnya
- `new_status`: Status baru
- `reason`: Alasan perubahan (terutama untuk pembatalan)
- `changed_by`: Admin yang melakukan perubahan (email)
- `notes`: Catatan tambahan
- Indexed pada `reservation_id` dan `created_at` untuk query cepat

### 2.5 Tabel Users

```sql
CREATE TABLE users (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    No_Handphone VARCHAR(15) NOT NULL,
    role VARCHAR(20) DEFAULT 'user',
    remember_token VARCHAR(100) NULLABLE,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

**Penjelasan:**
- `role`: 'admin' atau 'user' (untuk role-based access control)
- Hanya user dengan role 'admin' yang bisa akses panel admin

---

## 3. MODELS & RELATIONSHIPS

### 3.1 Users Model

```php
<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Users extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table = 'users';
    
    protected $fillable = [
        'username', 'email', 'password', 'No_Handphone', 'role'
    ];
    
    protected $hidden = ['password', 'remember_token'];
    
    protected $casts = [
        'password' => 'hashed',  // Otomatis hash saat set password
    ];
}
```

**Fitur:**
- Extends `Authenticatable` → Laravel bisa authenticate user
- `$fillable`: Field yang boleh mass-assign
- `$hidden`: Password dan remember_token tidak muncul di JSON
- `$casts`: Password otomatis di-hash dengan bcrypt

### 3.2 Destination Model

```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Destination extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'location', 'price', 
        'image_url', 'rating', 'total_visitors'
    ];

    protected $casts = [
        'price' => 'decimal:2',    // Cast ke decimal dengan 2 desimal
        'rating' => 'decimal:2',
    ];

    // RELATIONSHIP: Destination has many Reservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
```

**Relationships:**
- `1:M` dengan Reservations (1 destinasi memiliki banyak reservasi)

### 3.3 Reservation Model

```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name', 'customer_email', 'customer_phone',
        'destination_id', 'reservation_date', 'quantity',
        'total_price', 'status', 'notes'
    ];

    protected $casts = [
        'reservation_date' => 'date',   // Cast string ke Carbon date
        'total_price' => 'decimal:2',
    ];

    // RELATIONSHIP: Reservation belongs to Destination
    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    // RELATIONSHIP: Reservation has many StatusHistories
    public function statusHistories()
    {
        return $this->hasMany(StatusHistory::class)
                    ->orderBy('created_at', 'desc');  // Newest first
    }
}
```

**Relationships:**
- `M:1` dengan Destinations (banyak reservasi dari 1 destinasi)
- `1:M` dengan StatusHistories (1 reservasi memiliki banyak status history)

### 3.4 StatusHistory Model

```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id', 'old_status', 'new_status',
        'reason', 'changed_by', 'notes'
    ];

    // RELATIONSHIP: StatusHistory belongs to Reservation
    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
```

**Relationships:**
- `M:1` dengan Reservations (banyak status history dari 1 reservasi)

---

## 4. AUTHENTICATION & AUTHORIZATION

### 4.1 Flow Autentikasi

```
┌──────────────────────────────────────────────────────────┐
│              AUTHENTICATION FLOW                         │
└──────────────────────────────────────────────────────────┘

1. USER BELUM LOGIN
   └─ Akses halaman apapun
   └─ Middleware Authenticate → redirect ke /login

2. USER BUKA /login
   └─ Middleware RedirectIfAuthenticated
   └─ Jika sudah login → redirect ke /admin/dashboard
   └─ Jika belum login → tampilkan form login

3. USER SUBMIT FORM LOGIN
   └─ POST /login
   └─ Validate email & password
   └─ Auth::attempt($credentials)
      ├─ Cari user dengan email tersebut
      ├─ Bandingkan password input dengan hash di database
      ├─ Jika cocok → login berhasil
      └─ Jika tidak → login gagal
   └─ Jika login berhasil:
      ├─ Cek apakah role = 'admin'
      ├─ Jika ya → regenerate session → redirect ke dashboard
      ├─ Jika tidak → logout & return error
   └─ Jika login gagal:
      └─ Return error message

4. USER SUDAH LOGIN
   └─ Session tersimpan (default 120 menit)
   └─ Cookie dengan session ID
   └─ Request berikutnya → session ID valid

5. USER AKSES ROUTE YANG MEMERLUKAN AUTH
   └─ Middleware Authenticate cek session
   └─ Jika valid → lanjut ke controller
   └─ Jika tidak valid → redirect ke /login

6. USER LOGOUT
   └─ POST /logout
   └─ Auth::logout() → hapus autentikasi
   └─ Invalidate session
   └─ Regenerate CSRF token
   └─ Redirect ke home page
```

### 4.2 Credential Default (dari Seeder)

```php
Email:    admin@wisata.com
Password: password
Role:     admin
```

File: `database/seeders/UserSeeder.php`

### 4.3 Authorization - Role Based Access Control

```php
// Di route web.php:
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        // Hanya admin yang bisa akses routes ini
        Route::resource('destinations', DestinationController::class);
        Route::resource('reservations', ReservationController::class);
        Route::get('/dashboard', [DashboardController::class, 'index']);
    });
});
```

**Middleware Flow:**
1. `auth` middleware cek apakah user sudah login
2. Jika tidak → redirect ke /login
3. Jika ya → di `AuthController::login()` ada pengecekan:
   ```php
   if ($user->role !== 'admin') {
       Auth::logout();  // Logout user yang bukan admin
       return back()->withErrors(['email' => 'Hanya admin yang dapat login.']);
   }
   ```

---

## 5. CONTROLLERS & BUSINESS LOGIC

### 5.1 AuthController - Authentication

**Method: `showLogin()`**
- Route: `GET /login`
- Return view: `auth.login`
- Middleware: `guest` (hanya user yang belum login)

**Method: `login(Request $request)`**
- Route: `POST /login`
- Validasi:
  ```
  email: required|email
  password: required|min:6
  ```
- Proses:
  1. Validate credentials
  2. Auth::attempt() → cek email & password
  3. Verify role = 'admin'
  4. Regenerate session
  5. Redirect ke dashboard
- Response:
  - ✓ Redirect ke `/admin/dashboard` dengan message
  - ✗ Back ke form dengan error

**Method: `logout(Request $request)`**
- Route: `POST /logout`
- Proses:
  1. Clear authentication
  2. Invalidate session
  3. Regenerate CSRF token
- Response:
  - Redirect ke home page dengan message

---

### 5.2 DashboardController - Analytics

**Method: `index()`**
- Route: `GET /admin/dashboard`
- Middleware: `auth`
- Data yang digenerate:

| Data | Deskripsi | Query |
|------|-----------|-------|
| totalDestinations | Total destinasi | Destination::count() |
| totalReservations | Total reservasi | Reservation::count() |
| totalRevenue | Total pendapatan | Reservation::sum('total_price') |
| pendingReservations | Reservasi menunggu | Reservation::where('status','pending')->count() |
| chartData | Reservasi 30 hari | Query dengan fill missing dates |
| revenueByMonth | Pendapatan 3 bulan | GROUP BY DATE_FORMAT |
| statusDistribution | Distribusi status | COUNT per status |
| topDestinations | Top 5 destinasi | withCount('reservations') |

**Method: `getReservationChartData()`** (private)
- Return: Array dengan struktur:
  ```php
  [
      ['date' => '2025-01-01', 'count' => 5, 'dayName' => 'Mon'],
      ['date' => '2025-01-02', 'count' => 3, 'dayName' => 'Tue'],
      // ... 30 hari
  ]
  ```

**Method: `getRevenueByMonth()`** (private)
- Return: Collection dengan struktur:
  ```php
  [
      ['month' => '2025-11', 'revenue' => 1500000, 'count' => 10],
      // ... 3 bulan
  ]
  ```

**Method: `getStatusDistribution()`** (private)
- Return: Array:
  ```php
  [
      'pending' => 5,
      'confirmed' => 10,
      'cancelled' => 2,
  ]
  ```

---

### 5.3 DestinationController - CRUD Destinasi

**Method: `index(Request $request)`**
- Route: `GET /admin/destinations`
- Features:
  - Search by name or location
  - Filter by price range (min/max)
  - Filter by rating
  - Sort by column
  - Pagination (10 items/page)
- Query building:
  ```php
  if ($request->filled('search')) {
      $query->where('name', 'LIKE', "%{$search}%")
            ->orWhere('location', 'LIKE', "%{$search}%");
  }
  ```
- Return: View dengan paginated destinations

**Method: `create()`**
- Route: `GET /admin/destinations/create`
- Return: View form tambah destinasi

**Method: `store(Request $request)`**
- Route: `POST /admin/destinations`
- Validasi:
  ```
  name: required|string|max:100
  description: required|string
  location: required|string|max:100
  price: required|numeric|min:0
  image_url: nullable|url
  rating: nullable|numeric|min:0|max:5
  ```
- Proses: Destination::create($validated)
- Response: Redirect ke index dengan success message

**Method: `show(Destination $destination)`**
- Route: `GET /admin/destinations/{id}`
- Return: View detail destinasi

**Method: `edit(Destination $destination)`**
- Route: `GET /admin/destinations/{id}/edit`
- Return: View form edit destinasi

**Method: `update(Request $request, Destination $destination)`**
- Route: `PUT /admin/destinations/{id}`
- Same validation as store
- Proses: $destination->update($validated)
- Response: Redirect ke index dengan success message

**Method: `destroy(Destination $destination)`**
- Route: `DELETE /admin/destinations/{id}`
- Proses: $destination->delete()
  - Cascade delete: semua reservasi juga terhapus
- Response: Redirect ke index dengan success message

---

### 5.4 ReservationController - CRUD & Status Management

**Method: `index(Request $request)`**
- Route: `GET /admin/reservations`
- Features:
  - Search by customer name, email, phone
  - Filter by status (pending/confirmed/cancelled)
  - Filter by destination
  - Filter by date range (from/to)
  - Sort by column
  - Pagination (10 items/page)
  - Eager load destinations (prevent N+1 queries)
- Query:
  ```php
  $query = Reservation::with('destination');
  // ... filters
  $reservations = $query->paginate(10)->appends($request->query());
  ```
- Return: View dengan paginated reservations

**Method: `create()`**
- Route: `GET /admin/reservations/create`
- Load destinations for dropdown
- Return: View form tambah reservasi

**Method: `store(Request $request)`**
- Route: `POST /admin/reservations`
- Validasi:
  ```
  customer_name: required|string|max:100
  customer_email: required|email|max:100
  customer_phone: required|string|max:20
  destination_id: required|exists:destinations,id
  reservation_date: required|date
  quantity: required|integer|min:1
  total_price: required|numeric|min:0
  status: required|in:pending,confirmed,cancelled
  notes: nullable|string
  ```
- Proses:
  1. Create reservation
  2. Create StatusHistory dengan initial status
     ```php
     StatusHistory::create([
         'reservation_id' => $reservation->id,
         'old_status' => null,
         'new_status' => $validated['status'],
         'changed_by' => Auth::user()->email,
         'notes' => 'Reservasi dibuat',
     ]);
     ```
- Response: Redirect ke index dengan success message

**Method: `show(Reservation $reservation)`**
- Route: `GET /admin/reservations/{id}`
- Load status histories
- Return: View detail reservasi dengan status histories

**Method: `edit(Reservation $reservation)`**
- Route: `GET /admin/reservations/{id}/edit`
- Load destinations for dropdown
- Return: View form edit reservasi

**Method: `update(Request $request, Reservation $reservation)`**
- Route: `PUT /admin/reservations/{id}`
- Same validation as store
- Proses:
  1. Capture old status
  2. Update reservation
  3. If status changed → create StatusHistory
     ```php
     if ($oldStatus !== $validated['status']) {
         StatusHistory::create([...]);
     }
     ```
- Response: Redirect ke index dengan success message

**Method: `destroy(Reservation $reservation)`**
- Route: `DELETE /admin/reservations/{id}`
- Proses: $reservation->delete()
  - Cascade delete: semua status histories juga terhapus
- Response: Redirect ke index dengan success message

**Method: `changeStatus(Request $request, Reservation $reservation)`**
- Route: `POST /admin/reservations/{id}/change-status`
- Validasi:
  ```
  status: required|in:pending,confirmed,cancelled
  reason: nullable|string
  ```
- Proses:
  1. Capture old status
  2. Update status
  3. Create StatusHistory dengan reason
- Response: Back dengan success message

**Method: `bulkStatusUpdate(Request $request)`**
- Route: `POST /admin/reservations/bulk-status-update`
- Validasi:
  ```
  reservation_ids: required|array
  reservation_ids.*: integer|exists:reservations,id
  status: required|in:pending,confirmed,cancelled
  reason: nullable|string
  ```
- Proses:
  1. Loop each reservation
  2. Jika status berbeda → update dan create StatusHistory
  3. Count jumlah yang berhasil diubah
- Response: Redirect ke index dengan count message

**Method: `statusHistory(Reservation $reservation)`**
- Route: `GET /admin/reservations/{id}/status-history`
- Load status histories (sorted DESC by created_at)
- Return: View timeline status changes

---

## 6. ROUTES & ENDPOINTS

### 6.1 Route Structure di `routes/web.php`

```php
// ===== PUBLIC ROUTES =====
Route::get('/', function () {
    return view('beranda');
})->name('home');

// ===== AUTH ROUTES (untuk guest/belum login) =====
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', ...)->name('register');
    Route::post('/register', ...)->name('register.store');
});

// ===== LOGOUT ROUTE (untuk auth/sudah login) =====
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ===== ADMIN ROUTES (hanya untuk admin) =====
Route::middleware(['auth'])->group(function () {
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Destinations CRUD
        Route::resource('destinations', DestinationController::class);
        
        // Status Management Routes (HARUS SEBELUM resource())
        Route::post('/reservations/{reservation}/change-status', 
                   [ReservationController::class, 'changeStatus'])
              ->name('reservations.changeStatus');
        Route::post('/reservations/bulk-status-update', 
                   [ReservationController::class, 'bulkStatusUpdate'])
              ->name('reservations.bulkStatusUpdate');
        Route::get('/reservations/{reservation}/status-history', 
                   [ReservationController::class, 'statusHistory'])
              ->name('reservations.statusHistory');
        
        // Reservations CRUD
        Route::resource('reservations', ReservationController::class);
    });
});
```

### 6.2 Daftar Route Lengkap

| Method | Route | Controller | Middleware | Deskripsi |
|--------|-------|------------|------------|-----------|
| GET | / | - | - | Home page |
| GET | /login | AuthController@showLogin | guest | Form login |
| POST | /login | AuthController@login | guest | Submit login |
| POST | /logout | AuthController@logout | auth | Logout |
| GET | /admin/dashboard | DashboardController@index | auth | Dashboard analytics |
| GET | /admin/destinations | DestinationController@index | auth | List destinasi |
| GET | /admin/destinations/create | DestinationController@create | auth | Form tambah |
| POST | /admin/destinations | DestinationController@store | auth | Simpan destinasi baru |
| GET | /admin/destinations/{id} | DestinationController@show | auth | Detail destinasi |
| GET | /admin/destinations/{id}/edit | DestinationController@edit | auth | Form edit |
| PUT | /admin/destinations/{id} | DestinationController@update | auth | Update destinasi |
| DELETE | /admin/destinations/{id} | DestinationController@destroy | auth | Hapus destinasi |
| GET | /admin/reservations | ReservationController@index | auth | List reservasi |
| GET | /admin/reservations/create | ReservationController@create | auth | Form tambah |
| POST | /admin/reservations | ReservationController@store | auth | Simpan reservasi baru |
| GET | /admin/reservations/{id} | ReservationController@show | auth | Detail reservasi |
| GET | /admin/reservations/{id}/edit | ReservationController@edit | auth | Form edit |
| PUT | /admin/reservations/{id} | ReservationController@update | auth | Update reservasi |
| DELETE | /admin/reservations/{id} | ReservationController@destroy | auth | Hapus reservasi |
| POST | /admin/reservations/{id}/change-status | ReservationController@changeStatus | auth | Quick status change |
| POST | /admin/reservations/bulk-status-update | ReservationController@bulkStatusUpdate | auth | Bulk status update |
| GET | /admin/reservations/{id}/status-history | ReservationController@statusHistory | auth | View audit trail |

---

## 7. MIDDLEWARE

### 7.1 Built-in Middleware Stack

**Global Middleware** (Semua request):
```php
protected $middleware = [
    \App\Http\Middleware\TrustProxies::class,
    \Illuminate\Http\Middleware\HandleCors::class,
    \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
    \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
    \App\Http\Middleware\TrimStrings::class,
    \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
];
```

**Middleware Groups**:

```php
// 'web' group
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,
    ],
];

// 'api' group
protected $middlewareGroups = [
    'api' => [
        // ...
    ],
];
```

### 7.2 Custom Middleware

**Authenticate.php**
```php
protected function redirectTo(Request $request): ?string
{
    return $request->expectsJson() ? null : route('login');
}
```
- Redirect user yang belum login ke /login

**CheckRole.php**
```php
public function handle(Request $request, Closure $next, ...$roles): Response
{
    if (!auth()->check()) {
        return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
    }

    if (!in_array(auth()->user()->role, $roles)) {
        return abort(403);  // Forbidden
    }

    return $next($request);
}
```
- Cek apakah user memiliki role yang diizinkan
- Penggunaan: `Route::middleware(['auth', 'checkRole:admin'])`

**RedirectIfAuthenticated.php**
- Jika user sudah login, redirect ke dashboard
- Digunakan di login dan register form

**VerifyCsrfToken.php**
- Verify CSRF token di setiap POST/PUT/DELETE request
- Proteksi dari CSRF attacks

**TrimStrings.php**
- Otomatis trim whitespace dari semua string input

---

## 8. VALIDASI & ERROR HANDLING

### 8.1 Validation Rules

**Destinasi (Create/Update)**
```php
'name' => 'required|string|max:100'
'description' => 'required|string'
'location' => 'required|string|max:100'
'price' => 'required|numeric|min:0'
'image_url' => 'nullable|url'
'rating' => 'nullable|numeric|min:0|max:5'
```

**Reservasi (Create/Update)**
```php
'customer_name' => 'required|string|max:100'
'customer_email' => 'required|email|max:100'
'customer_phone' => 'required|string|max:20'
'destination_id' => 'required|exists:destinations,id'
'reservation_date' => 'required|date'
'quantity' => 'required|integer|min:1'
'total_price' => 'required|numeric|min:0'
'status' => 'required|in:pending,confirmed,cancelled'
'notes' => 'nullable|string'
```

**Login**
```php
'email' => 'required|email'
'password' => 'required|min:6'
```

### 8.2 Error Handling

**Controller Validation**
```php
$validated = $request->validate([...]);
// Jika validasi gagal → otomatis redirect back dengan $errors
// Jika validasi berhasil → $validated berisi data yang valid
```

**Try-Catch** (Opsional, tidak di-implement)
```php
try {
    // Logic
} catch (Exception $e) {
    return back()->with('error', 'Error: ' . $e->getMessage());
}
```

**Exception Handler** (`app/Exceptions/Handler.php`)
- Handle semua exception
- Return error page untuk 404, 403, 500, etc.

---

## 9. FRONTEND INTEGRATION

### 9.1 Master Layout (`resources/views/layouts/admin.blade.php`)

```html
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Sistem Reservasi Wisata Admin</title>
    
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.0/font/bootstrap-icons.min.css" rel="stylesheet">
    
    <style>
        /* Custom CSS di sini */
    </style>
    
    @yield('extra-css')  <!-- CSS tambahan per halaman -->
</head>
<body>
    <!-- Sidebar navigation -->
    <nav class="sidebar">
        <!-- Menu items -->
    </nav>
    
    <!-- Main content -->
    <main class="main-content">
        <header>
            <!-- Header dengan judul page -->
            <h1>@yield('page-title')</h1>
        </header>
        
        <div class="container-fluid">
            @if ($errors->any())
                <!-- Error messages -->
            @endif
            
            @if (session('success'))
                <!-- Success messages -->
            @endif
            
            <!-- Halaman content -->
            @yield('content')
        </div>
    </main>
    
    <!-- JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    @yield('extra-js')  <!-- JS tambahan per halaman -->
</body>
</html>
```

### 9.2 View Templating Patterns

**Form Create/Edit**
```blade
@extends('layouts.admin')

@section('title', 'Tambah Destinasi')
@section('page-title', 'Tambah Destinasi Baru')

@section('content')
    <form action="{{ route('admin.destinations.store') }}" method="POST">
        @csrf
        
        <div class="row">
            <div class="col-md-6">
                <label>Name</label>
                <input type="text" name="name" 
                       value="{{ old('name') }}"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
@endsection
```

**Data Table dengan Pagination**
```blade
<table class="table">
    <thead>
        <tr>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($destinations as $destination)
            <tr>
                <td>{{ $destination->name }}</td>
                <td>
                    <a href="{{ route('admin.destinations.show', $destination) }}" 
                       class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('admin.destinations.edit', $destination) }}" 
                       class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.destinations.destroy', $destination) }}" 
                          method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" 
                                onclick="return confirm('Sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="2" class="text-center">No data</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- Pagination -->
{{ $destinations->links() }}
```

### 9.3 Chart.js Integration (Dashboard)

```blade
@section('extra-css')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
@endsection

@section('content')
    <div class="chart-container">
        <canvas id="reservationChart"></canvas>
    </div>
@endsection

@section('extra-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('reservationChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($chartData->pluck('date')) !!},
                    datasets: [{
                        label: 'Reservations',
                        data: {!! json_encode($chartData->pluck('count')) !!},
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                }
            });
        });
    </script>
@endsection
```

---

## 10. FITUR-FITUR UTAMA

### 10.1 Authentication

✅ Admin-only login  
✅ Session management (120 menit)  
✅ CSRF protection  
✅ Password hashing (bcrypt)  
✅ Session regeneration on login/logout  
✅ Secure logout dengan session invalidation  

**Credentials Default:**
```
Email: admin@wisata.com
Password: password
```

### 10.2 Destination Management

✅ Create destinasi  
✅ Read list dengan search & filters  
✅ Read detail destinasi  
✅ Update destinasi  
✅ Delete destinasi (cascade delete reservasi)  
✅ Pagination (10 items/page)  
✅ Search by name/location  
✅ Filter by price range  
✅ Filter by rating  
✅ Sort by any column  

### 10.3 Reservation Management

✅ Create reservasi  
✅ Read list dengan search & filters  
✅ Read detail reservasi  
✅ Update reservasi  
✅ Delete reservasi (cascade delete status history)  
✅ Pagination (10 items/page)  
✅ Search by customer name/email/phone  
✅ Filter by status  
✅ Filter by destination  
✅ Filter by date range  
✅ Sort by any column  
✅ Eager loading (prevent N+1 queries)  

### 10.4 Status Management & Audit Trail

✅ Quick status change (pending → confirmed/cancelled)  
✅ Bulk status update untuk multiple reservasi  
✅ Audit trail setiap status change  
✅ Log old status → new status  
✅ Log admin yang melakukan change  
✅ Log reason (terutama untuk cancellation)  
✅ Status history timeline view  
✅ Filter only update if status changed  

**Status Values:**
- `pending` - Menunggu konfirmasi
- `confirmed` - Sudah dikonfirmasi
- `cancelled` - Dibatalkan

### 10.5 Analytics & Dashboard

✅ Total destinations card  
✅ Total reservations card  
✅ Total revenue card  
✅ Pending reservations card  
✅ 30-day reservation chart (line)  
✅ 3-month revenue chart  
✅ Status distribution chart (pie)  
✅ Top 5 destinations ranking  
✅ Missing dates filled with 0 (smooth chart)  

### 10.6 Security Features

✅ Role-based access control (admin only)  
✅ Middleware authentication  
✅ CSRF token verification  
✅ Password hashing (bcrypt)  
✅ Session regeneration  
✅ Secure logout  
✅ SQL injection prevention (Eloquent ORM)  
✅ XSS protection (Blade escaping)  
✅ Foreign key constraints (data integrity)  
✅ Cascade delete (maintain referential integrity)  

### 10.7 Data Integrity

✅ Foreign keys dengan cascade delete  
✅ Timestamps (created_at, updated_at)  
✅ Indexed columns untuk query optimization  
✅ Data validation di controller  
✅ Mass assignment protection ($fillable)  
✅ Hidden sensitive fields ($hidden)  
✅ Type casting ($casts)  

---

## 📊 DATABASE SEEDING

### Seeder Flow

```php
// Run: php artisan db:seed

1. DatabaseSeeder::run()
   ├─ UserSeeder::run()
   │  └─ Create admin user (admin@wisata.com)
   ├─ DestinationSeeder::run()
   │  └─ Create 10 destinations via factory
   └─ ReservationSeeder::run()
      └─ Create 50 reservations via factory
```

### Credentials After Seeding

```
Email: admin@wisata.com
Password: password
Role: admin
```

---

## 🚀 QUICK START

### Instalasi

```bash
# 1. Clone/Download project
cd Sistem-Reservasi-Wisata

# 2. Install dependencies
composer install
npm install

# 3. Create .env file
copy .env.example .env

# 4. Generate APP_KEY
php artisan key:generate

# 5. Setup database di .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=db_laravel_playground
DB_USERNAME=root
DB_PASSWORD=

# 6. Migrate & Seed
php artisan migrate --seed

# 7. Run development server
php artisan serve
php artisan tinker

# 8. Run frontend asset compiler
npm run dev
```

### Login

```
URL: http://localhost:8000/login
Email: admin@wisata.com
Password: password
```

---

## 🔧 COMMON TASKS

### Add New Destination

```bash
# 1. Dashboard → Destinations
# 2. Click "Tambah Destinasi"
# 3. Fill form:
#    - Name: Destinasi Name
#    - Description: Panjang deskripsi
#    - Location: Lokasi geografis
#    - Price: Harga per orang (numeric)
#    - Image URL: (opsional)
#    - Rating: 0-5 (opsional)
# 4. Submit form
```

### Create Reservation

```bash
# 1. Dashboard → Reservations
# 2. Click "Tambah Reservasi"
# 3. Fill form:
#    - Customer Name/Email/Phone
#    - Choose Destination
#    - Reservation Date
#    - Quantity (jumlah orang)
#    - Total Price (otomatis = Price × Quantity)
#    - Status (pending/confirmed/cancelled)
#    - Notes (opsional)
# 4. Submit form
# → StatusHistory otomatis dibuat
```

### Change Reservation Status

**Option 1: Quick Change**
```bash
# 1. Dashboard → Reservations
# 2. Click reservation → Detail view
# 3. Click "Ubah Status" button
# 4. Choose new status + optional reason
# 5. Submit
```

**Option 2: Bulk Update**
```bash
# 1. Dashboard → Reservations
# 2. Check multiple reservations
# 3. Select new status
# 4. Click "Bulk Update"
```

**Option 3: Edit Form**
```bash
# 1. Click Edit button di reservation
# 2. Change status di form
# 3. Submit
```

### View Audit Trail

```bash
# 1. Dashboard → Reservations
# 2. Click reservation → Detail view
# 3. Click "Riwayat Status" button
# → Timeline of all status changes with:
#    - Old Status → New Status
#    - Admin who changed
#    - Timestamp
#    - Reason
```

---

## 📝 NOTES

- Default pagination: 10 items/page
- Session lifetime: 120 menit
- Default password hash: bcrypt
- Timezone: UTC (configurable di config/app.php)
- Language: Indonesian (di controller messages)
- Database: MySQL dengan InnoDB engine

---

**Selesai! Anda sekarang sudah memahami seluruh sistem reservasi wisata ini. 🎉**
