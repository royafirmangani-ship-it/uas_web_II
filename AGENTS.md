# AGENTS.md — Sistem Klinik

## Project state

**CodeIgniter 3.1.13** PHP project — complete **Sistem Informasi Klinik** with AdminLTE 3 dashboard.

## Quick start

1. Import `database/db_sistem_klinik.sql` into MySQL
2. Set `base_url` in `application/config/config.php:26` to your URL
3. Run `composer install` (dompdf ^2.0 + phpspreadsheet ^1.29 are in vendor/)
4. Access at your base URL — login with `admin` / `admin123` or `petugas` / `petugas123`

## Architecture

- **Controllers** extend `MY_Controller` (`application/core/MY_Controller.php`) which provides `check_login()`, `check_admin()`, and `view($view, $data)` — the `view()` method wraps content in the AdminLTE template.
- **Models** extend `CI_Model`, use Query Builder.
- **Auth**: `Auth.php` controller, session-based, `password_hash()`/`password_verify()`. Login page is standalone (no template wrapper).
- **URL scheme**: `example.com/controller/method/param/`
- **Subclass prefix**: `MY_` — custom base classes go in `application/core/`

## Modules

| Module | Controller | Model | Views |
|---|---|---|---|
| Auth | `Auth.php` | — | `auth/login.php` |
| Dashboard | `Dashboard.php` | — | `dashboard/index.php` (+ Chart.js) |
| User | `User.php` | `User_model.php` | `user/` (list, form, detail) |
| Pasien | `Pasien.php` | `Pasien_model.php` | `pasien/` (list, form, detail) |
| Dokter | `Dokter.php` | `Dokter_model.php` | `dokter/` (list, form) |
| Poli | `Poli.php` | `Poli_model.php` | `poli/` (list, form) |
| Obat | `Obat.php` | `Obat_model.php` | `obat/` (list, form) |
| Pendaftaran | `Pendaftaran.php` | `Pendaftaran_model.php` | `pendaftaran/` (list, form, detail) |
| Pemeriksaan | `Pemeriksaan.php` | `Pemeriksaan_model.php` | `pemeriksaan/` (list, form, detail) |
| Resep | `Resep.php` | `Resep_model.php` | `resep/` (list, form, detail) |
| Pembayaran | `Pembayaran.php` | `Pembayaran_model.php` | `pembayaran/` (list, form, detail, nota) |
| Laporan | `Laporan.php` | (inline queries) | `laporan/` (pasien, pemeriksaan, pembayaran + PDF views) |

## Key config

- DB: `application/config/database.php:76-96` — MySQLi driver, `db_sistem_klinik`
- Routes: `application/config/routes.php` — default to `auth`
- Autoload: `application/config/autoload.php` — database, session, form_validation, pagination, helpers (url, form, file, auth)
- Sessions: `files` driver, 2hr expiry, `ci_session` cookie
- CSRF: **disabled** (enable for production)
- Composer autoload: **enabled** at `vendor/autoload.php`

## Template

AdminLTE 3 via CDN (Bootstrap 4.6, jQuery 3.6, Font Awesome 5, Chart.js). Template parts in `application/views/template/`. CDNs loaded in footer/header — no local assets needed beyond custom CSS.

## Uploads

Pasien photos → `uploads/pasien/` (gitignored).

## Exports

- PDF: Dompdf (landscape A4)
- Excel: PhpSpreadsheet (.xlsx)
- Print: CSS `@media print` in `application/views/laporan/print_css.php`

## Role-based access

- **Admin**: all modules including User management and Laporan
- **Petugas**: cannot access User module or Laporan (redirected with flash message)

## DB column quirks (important for queries)

- `pendaftaran.status` uses lowercase ENUM: `menunggu`, `diperiksa`, `selesai`
- `pembayaran.status` uses lowercase ENUM: `lunas`, `belum`, `batal`
- Pemeriksaan columns: `berat_badan`, `tinggi_badan` (not `berat`/`tinggi`)
- Pasien columns: `jenis_kelamin`, `tanggal_lahir` (not `jk`/`tgl_lahir`)
- Telepon column: `telepon` (not `telp`)

## Admin credentials (from sample data)

- `admin` / `admin123` (role: admin)
- `petugas` / `petugas123` (role: petugas)
