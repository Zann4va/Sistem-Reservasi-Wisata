# 🏖️ Sistem Reservasi Wisata - Admin CRUD System

> **Platform manajemen profesional untuk mengelola destinasi dan reservasi wisata dengan dashboard analytics yang powerful**

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=flat-square&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=flat-square&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat-square&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=flat-square&logo=bootstrap)
![Chart.js](https://img.shields.io/badge/Chart.js-3.9-FF6384?style=flat-square&logo=chartjs)

---

## � Daftar Isi

- [🎯 Tentang Proyek](#tentang-proyek)
- [�👥 Tim Pengembang](#tim-pengembang)
- [🚀 Fitur Utama](#fitur-utama)
- [🛠️ Tech Stack](#tech-stack)
- [⚙️ Instalasi & Setup](#instalasi--setup)
- [🔑 Akun Test](#akun-test)
- [📊 Database Schema](#database-schema)
- [🗂️ Struktur Project](#struktur-project)
- [📚 API Routes](#api-routes)
- [🎨 Fitur Dashboard](#fitur-dashboard)
- [📝 Dokumentasi Lengkap](#dokumentasi-lengkap)

---

## 🎯 Tentang Proyek

**Sistem Reservasi Wisata** adalah aplikasi web berbasis Laravel yang dirancang khusus untuk **admin CRUD system**. Sistem ini memungkinkan pengelola wisata untuk:

✅ Mengelola destinasi wisata (Create, Read, Update, Delete)  
✅ Mengelola reservasi pelanggan  
✅ Melihat analytics dan dashboard interaktif  
✅ Membuat laporan penjualan  
✅ Kelola pengguna sistem  

Aplikasi ini **100% Composer-based** tanpa npm/Vite, menggunakan **Bootstrap 5 CDN** dan **Chart.js CDN** untuk UI yang responsif dan modern.

---

## 👥 Tim Pengembang

| No | Nama | NIM | Posisi | Kontribusi |
|----|------|-----|--------|-----------|
| 1 | **Dimas Bayu Nugroho** | 19240384 | Tech Lead | Arsitektur sistem, auth, refactor ke admin-only, CRUD controllers |
| 2 | Septian Tirta Wijaya | 19241518 | 👨‍💻 Developer | Implementasi fitur |
| 3 | Ichwan Fauzan | 19240621 | 👨‍💻 Developer | Database design, migrations |
| 4 | Mario Cahya Eka Saputra | 19240656 | 👨‍💻 Developer | UI/UX Frontend |
| 5 | Rangga Sholeh Nugroho | 19240613 | 👨‍💻 Developer | Testing & QA |

---

## 🚀 Fitur Utama

### 🔐 **Authentication & Authorization**
- ✅ Admin-only login system dengan email & password
- ✅ Password hashing dengan bcrypt
- ✅ CSRF protection & session security
- ✅ Role-based access control (Admin middleware)
- ✅ Auto-logout & session management

### 🏖️ **Manajemen Destinasi**
- ✅ CRUD lengkap untuk destinasi wisata
- ✅ Upload & tampilkan gambar destinasi (Unsplash CDN)
- ✅ Kelola: nama, deskripsi, lokasi, harga, rating, pengunjung
- ✅ Pagination & search
- ✅ Validasi input komprehensif

### 📅 **Manajemen Reservasi**
- ✅ CRUD untuk booking/reservasi pelanggan
- ✅ Auto-calculate total harga (destinasi price × quantity)
- ✅ Track status: Pending, Confirmed, Cancelled
- ✅ Simpan data pelanggan: nama, email, phone
- ✅ Catatan/notes untuk setiap reservasi
- ✅ 70+ data dummy (Jan-Nov 2025)

### 📊 **Dashboard Analytics**
- ✅ Real-time statistics cards
  - Total destinasi
  - Total reservasi
  - Total revenue (Rp)
  - Reservasi pending
- ✅ **3 Interactive Charts** powered by Chart.js:
  - 📈 Line chart: 30-hari terakhir reservasi dengan weekday/weekend variability
  - 📊 Bar chart: Revenue 3 bulan terakhir
  - 🍩 Doughnut chart: Status distribusi (pending/confirmed/cancelled)
- ✅ Top 5 destinasi list
- ✅ Auto-refresh data

### 🎨 **Landing Page (Beranda)**
- ✅ Hero section dengan animated icon
- ✅ 6 feature cards dengan gambar Unsplash
- ✅ Statistics section
- ✅ About section
- ✅ Professional footer
- ✅ Responsive design (mobile, tablet, desktop)
- ✅ Navigation bar dengan login/dashboard links

### 📱 **User Interface**
- ✅ Modern design dengan Bootstrap 5.3 CDN
- ✅ Sidebar navigation (fixed, responsive)
- ✅ Sticky topbar dengan user info & logout
- ✅ Color-coded stat cards & badges
- ✅ Table responsive dengan hover effects
- ✅ Modal confirmations untuk delete
- ✅ Form validation feedback
- ✅ Bootstrap Icons CDN (1.11.0)

---

## 🛠️ Tech Stack

| Layer | Technology | Version |
|-------|-----------|---------|
| **Framework** | Laravel | 10.x |
| **PHP** | PHP | 8.1+ |
| **Database** | MySQL | 8.0+ |
| **Frontend Framework** | Bootstrap | 5.3 (CDN) |
| **Icons** | Bootstrap Icons | 1.11.0 (CDN) |
| **Charts** | Chart.js | 3.9.1 (CDN) |
| **Package Manager** | Composer | Latest |
| **Date/Time** | Carbon | ^2.68 |
| **ORM** | Eloquent | Laravel 10 |
| **Templating** | Blade | Laravel 10 |
| **Authentication** | Laravel Auth | Built-in |

**❌ NOT Used:** npm, Vite, Webpack, Node.js (100% Composer + CDN only)

---

## ⚙️ Instalasi & Setup

### 📋 Prerequisites
- PHP 8.1 atau lebih tinggi
- MySQL 8.0+
- Composer
- XAMPP/Laragon/Local environment

### 🚀 Langkah-Langkah Instalasi

**1. Clone Repository**
```bash
git clone <repository-url>
cd Sistem-Reservasi-Wisata
```

**2. Install Dependencies**
```bash
composer install
```

**3. Setup Environment**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Konfigurasi Database**

Edit `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_reservasi
DB_USERNAME=root
DB_PASSWORD=
```

**5. Run Migrations & Seeders**
```bash
php artisan migrate:fresh --seed
```

Atau terpisah:
```bash
php artisan migrate
php artisan db:seed
```

**6. Jalankan Laravel Server**
```bash
php artisan serve
```

**7. Akses Aplikasi**
```
http://localhost:8000
```

---

## 🔑 Akun Test

### 👨‍💼 Admin Account
```
Email    : admin@wisata.com
Password : admin123
```

**Access:** Full CRUD untuk destinasi, reservasi, dan dashboard

---

## 📊 Database Schema

### 📍 Tabel: `destinations`
```sql
CREATE TABLE destinations (
  id BIGINT PRIMARY KEY,
  name VARCHAR(255),
  description TEXT,
  location VARCHAR(255),
  price DECIMAL(10,2),
  image_url VARCHAR(255),
  rating DECIMAL(3,1),
  total_visitors INT,
  timestamps
)
```

**Relasi:** 1 Destination → Many Reservations

### 📅 Tabel: `reservations`
```sql
CREATE TABLE reservations (
  id BIGINT PRIMARY KEY,
  customer_name VARCHAR(255),
  customer_email VARCHAR(255),
  customer_phone VARCHAR(20),
  destination_id BIGINT FOREIGN KEY,
  reservation_date DATE,
  quantity INT,
  total_price DECIMAL(10,2),
  status ENUM('pending', 'confirmed', 'cancelled'),
  notes TEXT,
  timestamps
)
```

**Relasi:** Many Reservations → 1 Destination

### 👤 Tabel: `users`
```sql
CREATE TABLE users (
  id BIGINT PRIMARY KEY,
  name VARCHAR(255),
  email VARCHAR(255) UNIQUE,
  password VARCHAR(255),
  role ENUM('admin', 'user'),
  timestamps
)
```

**Data:** Admin user seeded otomatis

---

## �️ Struktur Project

```
Sistem-Reservasi-Wisata/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php (Login/Logout)
│   │   │   └── Admin/
│   │   │       ├── DashboardController.php (Stats & Charts)
│   │   │       ├── DestinationController.php (CRUD Destinasi)
│   │   │       └── ReservationController.php (CRUD Reservasi)
│   │   └── Middleware/
│   │       ├── CheckRole.php (Admin middleware)
│   │       └── Authenticate.php
│   └── Models/
│       ├── Users.php
│       ├── Destination.php
│       └── Reservation.php
├── database/
│   ├── migrations/
│   │   ├── 2014_10_12_000000_create_users_table.php
│   │   ├── 2025_11_19_000001_create_destinations_table.php
│   │   └── 2025_11_19_000002_create_reservations_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       ├── UserSeeder.php
│       ├── DestinationSeeder.php (10 destinasi + gambar)
│       └── ReservationSeeder.php (70+ reservasi, Jan-Nov 2025)
├── resources/
│   └── views/
│       ├── beranda.blade.php (Landing page publik)
│       ├── auth/
│       │   └── login.blade.php
│       ├── layouts/
│       │   └── admin.blade.php (Master layout)
│       └── admin/
│           ├── dashboard.blade.php (3 charts, stats)
│           ├── destinations/
│           │   ├── index.blade.php (List + gambar)
│           │   ├── create.blade.php
│           │   ├── edit.blade.php
│           │   └── show.blade.php
│           └── reservations/
│               ├── index.blade.php
│               ├── create.blade.php (Auto price calc)
│               ├── edit.blade.php
│               └── show.blade.php
├── routes/
│   └── web.php (Admin-only routes)
└── public/
    └── index.php
```

---

## � API Routes

### 🔓 Public Routes
```
GET  /              → Landing page (beranda)
GET  /login         → Login form
POST /login         → Submit login
POST /logout        → Logout
```

### 🔐 Admin Routes (Protected by `CheckRole` middleware)
```
# Dashboard
GET  /admin/dashboard                    → Dashboard dengan charts

# Destinations CRUD
GET    /admin/destinations               → List destinations
GET    /admin/destinations/create        → Create form
POST   /admin/destinations               → Store destination
GET    /admin/destinations/{id}          → Show destination
GET    /admin/destinations/{id}/edit     → Edit form
PUT    /admin/destinations/{id}          → Update destination
DELETE /admin/destinations/{id}          → Delete destination

# Reservations CRUD
GET    /admin/reservations               → List reservations
GET    /admin/reservations/create        → Create form
POST   /admin/reservations               → Store reservation
GET    /admin/reservations/{id}          → Show reservation
GET    /admin/reservations/{id}/edit     → Edit form
PUT    /admin/reservations/{id}          → Update reservation
DELETE /admin/reservations/{id}          → Delete reservation
```

---

## 🎨 Fitur Dashboard

### 📈 **Chart 1: Reservasi 30 Hari Terakhir**
- **Type:** Line chart
- **Data:** Setiap hari selama 30 hari terakhir
- **Fitur:** 
  - Weekday vs weekend variability
  - Smooth curve dengan point markers
  - Area fill semi-transparent
  - Y-axis auto-scale

### 📊 **Chart 2: Revenue 3 Bulan Terakhir**
- **Type:** Bar chart
- **Data:** Revenue agregat per bulan (3 bulan)
- **Fitur:**
  - Colorful bars (blue, green, purple)
  - Y-axis dengan format Rp (Juta)
  - Legend display

### 🍩 **Chart 3: Status Reservasi**
- **Type:** Doughnut chart
- **Data:** Breakdown pending/confirmed/cancelled
- **Fitur:**
  - Color-coded (orange/green/red)
  - Legend di bawah
  - Hover tooltip

### 📊 **Stat Cards**
- Total Destinasi (blue icon)
- Total Reservasi (purple icon)
- Total Revenue (green icon)
- Reservasi Pending (orange icon)

### ⭐ **Top 5 Destinasi**
- Ranked by reservation count
- Show: nama, jumlah reservasi, badge
- Real-time update

---

## � Dokumentasi Lengkap

### � File Dokumentasi Tambahan
- `REFACTOR_COMPLETE.md` - Detail perubahan dari user dashboard ke admin-only CRUD
- `ADMIN_SYSTEM_SETUP.md` - Panduan setup admin system lengkap
- `SETUP_GUIDE.md` - Quick start guide

### 💡 Tips & Tricks

**Menambah Destinasi Baru:**
1. Login sebagai admin
2. Sidebar → Destinasi → Tambah Destinasi
3. Isi form: nama, lokasi, harga, rating, deskripsi
4. Upload gambar (atau copy URL dari Unsplash)
5. Submit

**Membuat Reservasi:**
1. Sidebar → Reservasi → Tambah Reservasi
2. Isi data pelanggan (nama, email, phone)
3. Pilih destinasi (harga akan auto-fill)
4. Input tanggal & jumlah (total harga auto-calculate)
5. Pilih status & tambah notes
6. Submit

**View Dashboard:**
1. Login → Langsung ke dashboard
2. Lihat 4 stat cards di atas
3. Scroll bawah untuk melihat 3 charts
4. Lihat top 5 destinasi di sisi kanan

---

## 🔄 Data Seeder

### **DestinationSeeder** (10 Destinasi)
1. Candi Borobudur - Rp 500.000
2. Gunung Bromo - Rp 450.000
3. Pantai Parangtritis - Rp 300.000
4. Taman Nasional Komodo - Rp 750.000
5. Danau Toba - Rp 600.000
6. Tanjung Tinggi Beach - Rp 350.000
7. Bukit Kawi - Rp 250.000
8. Pulau Derawan - Rp 800.000
9. Kawah Ijen - Rp 520.000
10. Pantai Kuta - Rp 280.000

Semua punya gambar dari Unsplash (landscape/alam yang indah)

### **ReservationSeeder** (70+ Reservasi)
- **Date Range:** 1 Januari - 30 November 2025
- **Variasi:**
  - 50+ nama pelanggan berbeda
  - Quantity: 1-6 orang per reservasi
  - Status: Pending, Confirmed, Cancelled (realistic mix)
  - Phone format: +62xxx-xxxx-xxxx
  - 10 historical records (past dates, confirmed status)
  - Weekday/weekend patterns untuk realistic data

---

## 🐛 Troubleshooting

**Q: Gambar destinasi tidak muncul?**  
A: Pastikan image_url di database valid dari Unsplash CDN. Check: `images.unsplash.com/photo-[ID]`

**Q: Total price tidak auto-calculate?**  
A: JavaScript di create/edit view harus enabled. Check browser console untuk error.

**Q: Login gagal?**  
A: Pastikan database sudah di-seed dengan UserSeeder. Run: `php artisan db:seed --class=UserSeeder`

**Q: Chart tidak menampilkan data?**  
A: Pastikan Chart.js CDN loaded. Check browser → Network tab. Seharusnya ada 3 canvas elements.

**Q: CSRF Token Error?**  
A: Pastikan form memiliki `@csrf` token di dalam blade template.

---

## 📄 License

Proyek ini dibuat untuk keperluan pendidikan dan dapat digunakan secara bebas sesuai kebutuhan.


---

## ✨ Changelog

### v2.0.0 - Refactor to Admin-Only CRUD (Nov 19, 2025)
- ✅ Convert ke admin-only system
- ✅ Remove register & customer features
- ✅ Add CRUD untuk destinations & reservations
- ✅ Add dashboard dengan 3 charts
- ✅ 100% Composer + CDN (no npm/Vite)
- ✅ 10 destinasi + 70+ reservasi dummy
- ✅ Professional landing page

### v1.0.0 - Initial Release
- User & Admin dashboard
- Basic authentication

---

**Last Updated:** November 19, 2025  
**Status:** ✅ Production Ready