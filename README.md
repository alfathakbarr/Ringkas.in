<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## 📝 Tentang Aplikasi

**Ringkas.in** adalah aplikasi web untuk membuat URL pendek yang memudahkan pengguna untuk berbagi link dengan cara yang lebih praktis dan efisien. Aplikasi ini dirancang untuk memberikan pengalaman pengguna yang sederhana namun powerful dengan fitur-fitur seperti:

- Pembuatan URL pendek otomatis atau custom
- Pelacakan jumlah klik
- Generasi QR Code
- Manajemen link dengan deletion key
- Sistem keamanan dengan hashing

Aplikasi ini dibangun menggunakan **Laravel 12** dengan fokus pada performa, keamanan, dan kemudahan penggunaan.

---

## ✨ Fitur Utama

### 1. 🔐 Pembuatan URL Pendek
- **Auto-generate Short Code**: Kode pendek acak 8-10 karakter yang unik
- **Custom Alias**: Pengguna dapat membuat alias custom sesuai keinginan (min 3 karakter, hanya alfanumerik, dash, underscore)
- **Validasi URL**: Memastikan URL tujuan valid sebelum disimpan
- **Deletion Key**: Kunci keamanan untuk menghapus atau mengelola link yang dibuat

### 2. 📊 Tracking & Analytics
- **Click Counter**: Pencatatan otomatis setiap kali link diakses
- **Created Date**: Timestamp kapan link dibuat
- **Link Management**: Dashboard untuk melihat semua link yang sudah dibuat

### 3. 🎯 QR Code Generation
- **QR Code Otomatis**: Opsi untuk generate QR code dari short URL
- **Local Storage**: QR code disimpan di server untuk akses cepat
- **Fallback URL**: Jika QR lokal tidak tersedia, menggunakan fallback dari API eksternal

### 4. 🛠️ Manajemen Link
- **Search by Deletion Key**: Cari links berdasarkan deletion key
- **View All Links**: Dashboard lengkap dengan informasi link
- **Delete Links**: Hapus link dengan verifikasi deletion key
- **Copy to Clipboard**: Copy short URL dengan satu klik

### 5. 🔗 Redirect System
- **Public Access**: Short link dapat diakses tanpa login
- **Click Tracking**: Setiap akses secara otomatis tercatat di database
- **Fast Redirect**: Redirect langsung ke URL original dengan cepat

---

## 🛠️ Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| **Framework** | Laravel 12 |
| **Language** | PHP 8.2+ |
| **Database** | MySQL / SQLite (development) |
| **Frontend** | Blade Templates + Tailwind CSS |
| **Version Control** | Git |
| **QR Code Library** | SimpleSoftwareIO/simple-qrcode 4.2 |
| **HTTP Client** | Guzzle HTTP |
| **Testing** | PHPUnit 11+ |
| **Asset Building** | Vite |

### Dependensi Utama

**Production:**
- `laravel/framework: ^12.0`
- `laravel/tinker: ^2.10.1`
- `simplesoftwareio/simple-qrcode: ^4.2`

**Development:**
- `fakerphp/faker: ^1.23` - Database seeding
- `laravel/pail: ^1.2.2` - Log visualization
- `laravel/pint: ^1.24` - Code style
- `laravel/sail: ^1.41` - Docker development
- `phpunit/phpunit: ^11.5.50` - Testing framework

---

## 📁 Struktur Proyek

```
ringkas.in/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── Controller.php              # Base controller
│   │       └── UrlController.php           # Main URL management logic
│   ├── Models/
│   │   ├── Url.php                         # URL data model
│   │   └── User.php                        # User model
│   └── Providers/
│       └── AppServiceProvider.php          # Service provider
├── bootstrap/
│   ├── app.php                             # Application bootstrap
│   ├── providers.php                       # Service providers
│   └── cache/
│       ├── packages.php
│       └── services.php
├── config/                                 # Configuration files
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
├── database/
│   ├── factories/
│   │   └── UserFactory.php                 # Model factory for testing
│   ├── migrations/                         # Database migrations
│   │   ├── 2026_03_25_145730_create_urls_table.php
│   │   ├── 2026_03_27_064533_create_sessions_table.php
│   │   ├── 2026_03_27_115926_add_qr_path_to_urls_table.php
│   │   ├── 2026_03_27_181636_remove_unique_from_deletion_key_urls_table.php
│   │   └── 2026_03_27_223100_change_deletion_key_to_non_unique_on_urls_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── docs/
│   ├── ERD/
│   │   └── ERD_DOCUMENTATION.md            # Database documentation
│   ├── UML/
│   │   ├── Activity_Diagrams/              # Activity diagrams
│   │   └── Use_Case_Diagrams/              # Use case diagrams
│   ├── UI/                                 # UI Screenshots & mockups
│   └── Testing/                            # Testing documentation
│       ├── Images/
│       └── Videos/
├── public/
│   ├── index.php                           # Application entry point
│   └── robots.txt
├── resources/
│   ├── css/
│   │   └── app.css                         # Application styles
│   ├── js/
│   │   ├── app.js                          # Main JavaScript
│   │   └── bootstrap.js                    # Bootstrap setup
│   └── views/
│       ├── welcome.blade.php               # Welcome page
│       ├── layouts/
│       │   └── app.blade.php               # Main layout template
│       └── urls/                           # URL-related views
│           ├── create.blade.php            # Create form
│           ├── home.blade.php              # Home page
│           ├── index.blade.php             # Manage links
│           └── qr.blade.php                # QR generator
├── routes/
│   ├── console.php                         # Artisan command routes
│   └── web.php                             # Web routes
├── storage/
│   ├── app/                                # Application storage
│   │   ├── private/
│   │   └── public/
│   ├── framework/
│   │   ├── cache/
│   │   ├── sessions/
│   │   ├── testing/
│   │   └── views/
│   └── logs/                               # Application logs
├── tests/
│   ├── TestCase.php                        # Base test case
│   ├── Feature/                            # Feature tests
│   │   └── ExampleTest.php
│   └── Unit/                               # Unit tests
│       └── ExampleTest.php
├── artisan                                 # Laravel CLI
├── composer.json                           # PHP dependencies
├── package.json                            # Node dependencies
├── phpunit.xml                             # PHPUnit configuration
├── vite.config.js                          # Vite configuration
└── README.md                               # This file
```

---

## 🚀 Instalasi & Setup

### Prasyarat

Sebelum memulai, pastikan sudah memiliki:
- **PHP 8.2+** (lebih baik 8.3 atau terbaru)
- **Composer** untuk dependency management PHP
- **Node.js 18+** dan npm untuk asset building
- **MySQL/MariaDB** atau SQLite untuk database
- **Git** untuk version control

### Langkah Instalasi

#### 1. Clone Repository
```bash
git clone <repository-url>
cd Ringkas.in
```

#### 2. Install PHP Dependencies
```bash
composer install
```

#### 3. Setup Environment
```bash
# Copy file .env.example ke .env
cp .env.example .env

# Generate application key
php artisan key:generate
```

#### 4. Database Setup
```bash
# Run migrations
php artisan migrate

# (Optional) Seed database dengan data dummy
php artisan db:seed
```

#### 5. Install Frontend Dependencies
```bash
npm install
```

#### 6. Build Assets
```bash
# Development build
npm run dev

# Production build
npm run build
```

#### 7. Storage Link (untuk QR codes)
```bash
php artisan storage:link
```

### Quick Setup (One Command)
```bash
composer run setup
```

Perintah di atas akan menjalankan:
- `composer install`
- Copy `.env.example` ke `.env`
- Generate application key
- Run database migrations
- Install Node dependencies
- Build frontend assets

---

## 💻 Penggunaan

### Menjalankan Development Server

#### Mode Sederhana
```bash
# Terminal 1: Start PHP server
php artisan serve

# Terminal 2: Start Vite dev server
npm run dev
```

#### Mode Complete (dengan queue & log monitoring)
```bash
composer run dev
```
Perintah ini akan menjalankan:
- Laravel development server (port 8000)
- Queue listener
- Log monitoring (Pail)
- Vite dev server

### Mengakses Aplikasi
- **Homepage**: http://localhost:8000
- **Create Short URL**: http://localhost:8000/create
- **Manage Links**: http://localhost:8000/urls
- **Generate QR**: http://localhost:8000/qr

---

## 📚 Dokumentasi

### Entity Relationship Diagram

![ERD Structure](docs/ERD/ERD_DOCUMENTATION.md)

#### Database Schema

Aplikasi Ringkas.in menggunakan single table design yang sederhana namun powerful:

**Table: `urls`**

| Field | Type | Constraint | Deskripsi |
|-------|------|-----------|----------|
| `id` | BIGINT | PRIMARY KEY, AUTO_INCREMENT | Unique identifier |
| `original_url` | TEXT | NOT NULL | URL tujuan yang akan di-shortening |
| `short_code` | VARCHAR(10) | UNIQUE, NOT NULL | Kode pendek acak (8-10 karakter) |
| `custom_alias` | VARCHAR(255) | NULLABLE, UNIQUE | Custom alias (opsional) |
| `deletion_key` | VARCHAR(255) | NOT NULL (hashed) | Kunci untuk menghapus/mengelola link |
| `click_count` | INT | DEFAULT 0 | Counter jumlah klik |
| `qr_path` | VARCHAR(255) | NULLABLE | Path ke QR code yang di-generate |
| `created_at` | TIMESTAMP | DEFAULT CURRENT | Waktu pembuatan link |
| `updated_at` | TIMESTAMP | DEFAULT CURRENT | Waktu update terakhir |

#### Design Decisions

1. **No Soft Delete**: Menggunakan hard delete untuk kesederhanaan dan efisiensi storage
2. **No `updated_at` for URLs**: Data URL tidak perlu di-update, hanya dibuat dan dihapus
3. **Short Code Length**: 8-10 karakter random (configurable)
4. **Custom Alias**: Optional, dengan unique validation untuk mencegah duplikasi
5. **Click Tracking**: Pencatatan hanya count, bukan individual user data (privacy-first)
6. **Hashed Deletion Key**: Deletion key disimpan dengan hashing untuk keamanan

### UML Diagrams

#### 1. Use Case Diagram
Menggambarkan interaksi antara pengguna dan sistem:

**Main Actors:**
- **User/Pengguna Umum**: Pengguna yang menggunakan aplikasi

**Use Cases:**
- ✅ Create Short URL - Membuat URL pendek (auto atau custom)
- ✅ Search Links - Mencari links berdasarkan deletion key
- ✅ View Links - Melihat daftar links yang telah dibuat
- ✅ Copy Short URL - Copy link ke clipboard
- ✅ Delete Link - Menghapus link dengan deletion key
- ✅ Generate QR Code - Generate QR code dari short URL
- ✅ Access Short Link - Mengakses short link (redirect + tracking)

**Documentation**: [Use_Case_Ringkasin.png](docs/UML/Use_Case_Diagrams/Use_Case_Ringkasin.png)

#### 2. Activity Diagrams

##### a. Shorten URL Flow
```
Start → Input URL → Validate URL → Generate/Validate Alias 
→ Create Deletion Key → Save to DB → Success → End
     ↓
   Error
```
Alur lengkap: [Shorten_URL.png](docs/UML/Activity_Diagrams/Shorten_URL.png)

##### b. Mengakses Short URL Flow
```
Start → Access Short Link → Lookup in DB → Increment Click Count 
→ Redirect to Original → End
     ↓
   Not Found
```
Alur lengkap: [Mengakses_Short_URL.png](docs/UML/Activity_Diagrams/Mengakses_Short_URL.png)

##### c. Mengelola Link Flow
```
Start → Input Deletion Key → Validate Key → Show User's Links 
→ Delete/Update → Confirm → Database Update → End
```
Alur lengkap: [Mengelola_Link.png](docs/UML/Activity_Diagrams/Mengelola_Link.png)

##### d. Generate QR Code Flow
```
Start → Input Short URL → Validate input → Generate QR Code 
→ Save/Display → Success → End
     ↓
   Error
```
Alur lengkap: [Generate_QR_Code.png](docs/UML/Activity_Diagrams/Generate_QR_Code.png)

**Dokumentasi Lengkap**: [/docs/UML](/docs/UML/)

### UI Screenshots

Aplikasi memiliki interface yang user-friendly dan responsive:

#### 1. **Home Page**
![Home Page](docs/UI/Home%20Page.png)

Homepage menampilkan:
- Header dengan branding Ringkas.in
- Call-to-action untuk membuat URL pendek
- Informasi singkat tentang aplikasi
- Quick start guide

#### 2. **Create Short URL Page**
![Create Page](docs/UI/Short%20URL%20Page.png)

Fitur pada halaman create:
- Input URL tujuan
- Opsi custom alias
- Opsi generate QR code
- Deletion key setup (min 8 karakter dengan 1 huruf kapital, 1 angka, 1 karakter khusus)
- Form validation realtime
- Mobile-responsive design

#### 3. **Manage Links Page**
![Manage Page](docs/UI/Kelola%20Link%20Page.png)

Fitur pada halaman manage:
- Daftar semua links yang dibuat
- Filter berdasarkan deletion key
- Informasi original URL, short code, custom alias
- Click count tracking
- Tanggal pembuatan
- Tombol copy, delete, dan view
- Pagination support

#### 4. **Generate QR Page**
![QR Page](docs/UI/Generate%20QR%20Page.png)

Fitur pada halaman QR:
- Input short URL
- Preview QR code
- Download QR code
- Customize QR size (optional)
- Print support

**Semua screenshots**: [/docs/UI/](/docs/UI/)

---

## 🛣️ API Routes

### Web Routes

| Method | Route | Controller | Nama | Deskripsi |
|--------|-------|-----------|------|-----------|
| `GET` | `/` | UrlController@home | urls.home | Homepage - Tampilkan daftar links |
| `GET` | `/create` | UrlController@create | urls.create | Form untuk membuat short URL |
| `POST` | `/urls` | UrlController@store | urls.store | Simpan short URL baru |
| `GET` | `/urls` | UrlController@index | urls.index | Halaman manage links |
| `POST` | `/urls/search` | UrlController@search | urls.search | Cari links berdasarkan deletion key |
| `GET` | `/s/{code}` | UrlController@show | urls.show | Redirect ke original URL + track click |
| `DELETE` | `/urls/{id}` | UrlController@destroy | urls.destroy | Hapus link |
| `GET` | `/qr` | UrlController@qr | urls.qr | Halaman QR code generator |

### Request/Response Examples

#### 1. Create Short URL
**Request:**
```bash
POST /urls
Content-Type: application/json

{
    "original_url": "https://example.com/very-long-url",
    "use_custom_alias": true,
    "custom_alias": "mylink",
    "generate_qr": true,
    "deletion_key": "MyKey123!@#"
}
```

**Response (Success):**
```json
{
    "success": true,
    "short_url": "http://localhost:8000/s/mylink",
    "original_url": "https://example.com/very-long-url",
    "qr_url": "http://localhost:8000/storage/qr/1.png",
    "deletion_key": "MyKey123!@#",
    "created_at": "2026-03-30"
}
```

#### 2. Delete Link
**Request:**
```bash
DELETE /urls/1
Content-Type: application/json

{
    "deletion_key": "MyKey123!@#"
}
```

**Response (Success):**
```json
{
    "success": true,
    "message": "Link berhasil dihapus"
}
```

---

## 🧪 Testing

### Testing Structure

Aplikasi menyediakan framework testing yang comprehensive:

```
tests/
├── TestCase.php              # Base test case
├── Feature/
│   └── ExampleTest.php       # Feature/integration tests
└── Unit/
    └── ExampleTest.php       # Unit tests
```

### Running Tests

#### Jalankan semua test
```bash
composer test
```

#### Jalankan test dengan coverage
```bash
php artisan test --coverage
```

#### Jalankan test spesifik
```bash
php artisan test tests/Feature/UrlTest.php
```

### Test Coverage

**Planned Test Areas:**
- ✅ URL creation and validation
- ✅ Short code generation uniqueness
- ✅ Custom alias validation
- ✅ Deletion key verification
- ✅ Click tracking accuracy
- ✅ QR code generation
- ✅ Redirect functionality
- ✅ Database relationships

**Testing Documentation**: [/docs/Testing/](/docs/Testing/)

---

## 📚 Available Commands

### Artisan Commands

```bash
# Database
php artisan migrate              # Run database migrations
php artisan migrate:fresh        # Fresh migration (reset + migrate)
php artisan migrate:rollback     # Rollback migrations
php artisan db:seed              # Seed database

# Cache & Config
php artisan config:cache         # Cache configuration
php artisan cache:clear          # Clear cache
php artisan storage:link         # Link storage directory

# Development
php artisan serve                # Start dev server (port 8000)
php artisan tinker               # Interactive PHP shell
php artisan queue:listen         # Listen to queue jobs

# Maintenance
php artisan down                 # Put application in maintenance mode
php artisan up                   # Bring application up

# Code Quality
./vendor/bin/pint                # Fix PHP code style
php artisan test                 # Run tests
```

---

## 📊 Database Migrations

Aplikasi menggunakan migrations untuk version control database:

1. **2026_03_25_145730** - Create `urls` table
2. **2026_03_27_064533** - Create `sessions` table
3. **2026_03_27_115926** - Add `qr_path` column to `urls` table
4. **2026_03_27_181636** - Remove unique constraint from `deletion_key` column
5. **2026_03_27_223100** - Change `deletion_key` to non-unique on `urls` table

---

## 🔐 Security Features

### 1. **URL Validation**
- Validasi bahwa URL menggunakan HTTP/HTTPS
- Cek format URL yang valid sebelum disimpan

### 2. **Deletion Key Security**
- Minimum 8 karakter, maksimal 64 karakter
- Harus mengandung: 1 huruf kapital, 1 angka, 1 karakter khusus
- Disimpan dengan hashing MD5 di database
- Diperlukan untuk mengakses dan menghapus link

### 3. **CSRF Protection**
- Semua form dilindungi dengan CSRF token
- DELETE requests memerlukan CSRF token

### 4. **Input Validation**
- Custom alias hanya alfanumerik, dash, dan underscore
- Custom alias minimal 3 karakter, maksimal 10 karakter
- Unique validation untuk mencegah duplikasi

### 5. **Database Security**
- Menggunakan parameterized queries (Eloquent ORM)
- Protection dari SQL injection
- Hashed passwords dan sensitive data

---

## 🚦 Performance Optimization

### 1. **Database**
- Indexed columns untuk fast query (short_code, custom_alias)
- Denormalized design untuk minimal joins

### 2. **Caching**
- Browser caching untuk static assets
- Redis/Memcached support untuk session caching

### 3. **Assets**
- Vite untuk fast HMR development
- CSS dan JS minification untuk production
- Image optimization dengan Tailwind CSS

### 4. **Redirect**
- Direct database lookup untuk shortest response time
- Minimal processing untuk tracking

---

## 🐛 Troubleshooting

### Common Issues

**Issue: `composer install` gagal**
```bash
# Solution: Update composer
composer self-update
composer install --no-dev
```

**Issue: npm run dev error**
```bash
# Solution: Update dependencies
rm -rf node_modules package-lock.json
npm install
npm run dev
```

**Issue: Storage link tidak berfungsi**
```bash
# Solution: Re-create storage link
php artisan storage:link
chmod -R 755 storage/
```

**Issue: Database migration error**
```bash
# Solution: Fresh migration
php artisan migrate:fresh --seed
```

---

## 📞 Support & Contributors

### Contributors

| Nama | Role | Kontribusi |
|------|------|-----------|
| **Alfath Akbar** | Lead Developer | Core development, architecture |

### Kontak & Support

Untuk pertanyaan, request fitur, atau bug report:
- 📧 Email: [contact@ringkas.in]
- 🐛 GitHub Issues: [Report bugs here]
- 💬 Discussion: [GitHub Discussions]

---

## 📄 License

Proyek ini dilisensikan di bawah **MIT License**. Lihat file [LICENSE](LICENSE) untuk detail lengkap.

---

## 🎯 Roadmap Pengembangan

### Phase 1 ✅ (Current)
- [x] URL shortening dengan custom alias
- [x] Click tracking system
- [x] QR code generation
- [x] Link management with deletion key
- [x] Basic UI/UX

### Phase 2 (Planned)
- [ ] User authentication & personal dashboards
- [ ] Advanced analytics & charts
- [ ] Link expiration/TTL feature
- [ ] Rate limiting & abuse prevention
- [ ] API endpoint untuk third-party integration
- [ ] Mobile app (React Native/Flutter)

### Phase 3 (Future)
- [ ] GeoIP tracking untuk analytics
- [ ] A/B testing support
- [ ] Custom domain support
- [ ] Team collaboration features
- [ ] Webhook notifications
- [ ] AI-powered link recommendations
- [ ] Integration dengan social media

---

## 📖 Referensi & Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Tailwind CSS](https://tailwindcss.com)
- [SimpleSoftwareIO QR Code](https://github.com/SimpleSoftwareIO/simple-qrcode)
- [Vite JS](https://vitejs.dev)
- [PHP Documentation](https://www.php.net/docs.php)

---

## 🙏 Terima Kasih

Terima kasih telah menggunakan Ringkas.in! Kami terus mengembangkan aplikasi ini untuk memberikan pengalaman terbaik bagi pengguna.

---

**Last Updated**: 30 Maret 2026  
**Version**: 1.0.0  
**Status**: Production Ready
