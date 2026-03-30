# Ringkas.in - Entity Relationship Diagram & Documentation

## Database Schema

### Table: `urls`

| Field | Type | Constraint | Description |
|-------|------|-----------|-------------|
| `id` | INT | PRIMARY KEY | Unique identifier |
| `original_url` | TEXT | - | Full original URL |
| `short_code` | VARCHAR(10) | UNIQUE | Random generated 8-10 character code |
| `custom_alias` | VARCHAR | NULLABLE, UNIQUE | Optional custom short link alias |
| `click_count` | INT | DEFAULT 0 | Count of clicks on this short URL |
| `created_at` | TIMESTAMP | CURRENT_TIMESTAMP | Timestamp when URL was created |

## Design Decisions

1. **No `updated_at` field**: Data tidak perlu di-update, hanya di-buat dan di-delete
2. **No soft delete**: Menggunakan hard delete untuk kesederhanaan
3. **Short Code Length**: 8-10 karakter random (configurable via `generateShortCode()` method)
4. **Custom Alias**: Optional, bisa disesuaikan username atau custom path
5. **Click Tracking**: Count clicks tanpa menyimpan individual user data
6. **No user authentication**: Aplikasi single-use, public access

## Features Implemented

### 1. Create Short URL
- Validasi URL format
- Auto-generate 8-10 karakter random short code
- Optional custom alias (unique validation)
- Redirect ke index dengan success message

### 2. Display All URLs
- Tabel dengan original URL, short code, click count, created date
- Responsive design dengan Tailwind CSS
- Pagination (optional - bisa ditambah nanti)

### 3. Copy to Clipboard ✅
- Button "Copy" untuk setiap short URL
- JavaScript clipboard API
- Visual feedback (berubah ke "✓ Copied!" hijau selama 2 detik)
- Browser compatibility: Modern browsers dengan clipboard API

### 4. Delete URL ✅
- POST DELETE request dengan CSRF protection
- Confirmation dialog: "Yakin ingin hapus URL ini?"
- Hard delete dari database
- Redirect ke index dengan success message

### 5. Track Clicks
- Short URL redirect endpoint (`/s/{short_code}`)
- Increment `click_count` setiap kali diakses
- Public access (no authentication)

### 6. QR Code (Planned)
- Belum implemented
- Gunakan library: `simple-qrcode`
- Generate QR code untuk short URL pada create/display

## Tech Stack

- **Framework**: Laravel 12
- **Language**: PHP 8.5
- **Database**: MySQL / SQLite (development)
- **Frontend**: Tailwind CSS
- **Library**: Simple-QRCode (untuk QR feature)

## Project Structure

```
ringkas.in/
├── app/
│   ├── Http/Controllers/UrlController.php    # Main logic
│   └── Models/Url.php                         # Data model
├── database/
│   └── migrations/
│       └── 2026_03_25_145730_create_urls_table.php
├── resources/views/
│   ├── layouts/app.blade.php                 # Main layout
│   └── urls/
│       ├── create.blade.php                  # Form untuk create
│       └── index.blade.php                   # List & manage URLs
└── routes/web.php                             # Route definitions
```

## Routes

| Method | Route | Controller | Description |
|--------|-------|-----------|-------------|
| GET | `/` | UrlController@index | Homepage - list semua URLs |
| GET | `/urls/create` | UrlController@create | Form untuk create URL baru |
| POST | `/urls` | UrlController@store | Store URL baru ke database |
| GET | `/s/{id}` | UrlController@show | Redirect ke original URL + increment clicks |
| DELETE | `/urls/{id}` | UrlController@destroy | Delete URL |

## Next Steps (For Future Development)

1. **QR Code Generation**: Integrate `simple-qrcode`
2. **Pagination**: Laravel pagination untuk handle banyak URLs
3. **Advanced Analytics**: Graph clicks over time
4. **Expiration Feature**: Auto-delete links after X days
5. **Rate Limiting**: Prevent abuse dari single IP
6. **Mobile App**: React Native atau Flutter
7. **API Endpoint**: RESTful API untuk third-party integrations

---

**Created**: March 25, 2026  
**Status**: Initial Setup Complete  
**Contributors**: Alfath Akbar (Lead)
