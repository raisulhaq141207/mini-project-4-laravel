# Inventory Management System (Laravel)

Lanjutan Inventory Management System P4 menggunakan framework **Laravel**.
Aplikasi untuk mengelola **produk**, **kategori**, dan **supplier**, dilengkapi dashboard ringkasan dan peringatan stok menipis.

- **Nama:** _(isi nama)_
- **NIM:** _(isi NIM)_
- **Mata Kuliah / Pertemuan:** _(isi)_

---

## 1. Fitur

| Modul | Fitur |
|-------|-------|
| Dashboard | Total produk, kategori, supplier, nilai stok, daftar stok menipis |
| Produk | CRUD, pencarian (nama/SKU), filter kategori, pagination, badge stok menipis |
| Kategori | CRUD, jumlah produk per kategori |
| Supplier | CRUD, jumlah produk per supplier |
| Validasi | Server-side validation dengan pesan Bahasa Indonesia + `old()` input |

## 2. Teknologi

- PHP >= 8.2
- Laravel 11 / 12
- SQLite (default, tanpa instalasi database tambahan) — MySQL juga bisa
- Blade + Bootstrap 5 (via CDN, tidak perlu `npm install`)

## 3. Instruksi Instalasi

Prasyarat: **PHP >= 8.2** (ekstensi `sqlite3`/`pdo_sqlite`), **Composer**, **Git**.

```bash
# 1. Clone repository
git clone <URL-REPOSITORY-ANDA>
cd <nama-folder-repository>

# 2. Install dependency
composer install

# 3. Siapkan environment
cp .env.example .env          # Windows (CMD): copy .env.example .env
php artisan key:generate

# 4. Siapkan database SQLite
touch database/database.sqlite   # Windows (CMD): type nul > database\database.sqlite

# 5. Jalankan migration + seeder
php artisan migrate --seed

# 6. Jalankan server
php artisan serve
```

Buka **http://127.0.0.1:8000**.

> Pastikan `.env` berisi `DB_CONNECTION=sqlite`.
> Untuk MySQL: ubah `DB_CONNECTION=mysql`, isi `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`, lalu buat database kosongnya sebelum `php artisan migrate --seed`.

Reset data dari awal: `php artisan migrate:fresh --seed`

## 4. Struktur Database (Migration)

```
categories                 suppliers                  products
-----------                ----------                 ----------
id                         id                         id
name (unique)              name                       sku (unique)
description                phone                      name
timestamps                 email                      category_id  -> categories.id (cascade)
                           address                    supplier_id  -> suppliers.id (nullable, set null)
                           timestamps                 price, stock, min_stock
                                                      description, timestamps
```

Relasi: **Category 1 — N Product**, **Supplier 1 — N Product**.

File migration: `database/migrations/2026_10_14_00000{1,2,3}_*.php`

## 5. Seeder

| Seeder | Isi |
|--------|-----|
| `CategorySeeder` | 4 kategori |
| `SupplierSeeder` | 3 supplier |
| `ProductSeeder` | 8 produk contoh (2 di antaranya stok menipis) |
| `DatabaseSeeder` | Memanggil ketiganya secara berurutan (Category & Supplier dulu karena foreign key) |

## 6. Route

Lihat dengan `php artisan route:list`.

| Method | URI | Controller@method | Nama |
|--------|-----|-------------------|------|
| GET | `/` | DashboardController | dashboard |
| GET | `/products` | ProductController@index | products.index |
| GET | `/products/create` | ProductController@create | products.create |
| POST | `/products` | ProductController@store | products.store |
| GET | `/products/{product}` | ProductController@show | products.show |
| GET | `/products/{product}/edit` | ProductController@edit | products.edit |
| PUT/PATCH | `/products/{product}` | ProductController@update | products.update |
| DELETE | `/products/{product}` | ProductController@destroy | products.destroy |
| * | `/categories` (kecuali show) | CategoryController | categories.* |
| * | `/suppliers` (kecuali show) | SupplierController | suppliers.* |

## 7. Penjelasan Singkat Arsitektur MVC

Laravel menerapkan pola **Model – View – Controller**:

- **Model** (`app/Models`) — representasi tabel & relasi menggunakan Eloquent ORM.
  `Product` `belongsTo` `Category` dan `Supplier`; `Category`/`Supplier` `hasMany` `Product`.
  Properti `$fillable` melindungi dari mass-assignment.
- **View** (`resources/views`) — tampilan menggunakan template **Blade**. `layouts/app.blade.php`
  adalah layout utama (`@extends`, `@yield`), form dipakai ulang lewat partial `_form.blade.php` untuk create & edit.
- **Controller** (`app/Http/Controllers`) — menerima request, memvalidasi input, memanggil Model, lalu
  mengembalikan View atau redirect. Contoh: `ProductController`.
- **Route** (`routes/web.php`) — memetakan URL ke method Controller (`Route::resource`).

Alur request:

```
Browser -> Route (web.php) -> Controller -> Model (Eloquent) -> Database
                                  |
                                  +--> View (Blade) -> HTML -> Browser
```

## 8. Demo Alur Lengkap: Form → Validasi → Simpan → Redirect → Tampilkan Data

Alur yang didemonstrasikan: **Tambah Produk**.

| # | Langkah | Kode | Yang terlihat |
|---|---------|------|---------------|
| 1 | Membuka form | `GET /products/create` → `ProductController@create` → `products/create.blade.php` | Form kosong |
| 2 | Validasi | `ProductController@store` → `$request->validate(...)` | Submit form kosong / SKU duplikat → kembali ke form dengan pesan error merah & input lama (`old()`) |
| 3 | Simpan | `Product::create($validated)` | Data masuk tabel `products` |
| 4 | Redirect | `redirect()->route('products.show', $product)->with('success', ...)` | Pindah ke halaman detail (pola Post/Redirect/Get, mencegah double-submit) |
| 5 | Tampilkan data | `ProductController@show` → `products/show.blade.php` | Detail produk + flash message hijau "berhasil ditambahkan" |

Langkah mencoba:
1. Buka `/products/create`, klik **Simpan** tanpa isi → muncul pesan validasi.
2. Isi SKU `ELK-001` (sudah ada) → muncul "SKU sudah digunakan".
3. Isi data valid (mis. SKU `ELK-099`) → diarahkan ke halaman detail + pesan sukses.
4. Buka `/products` → produk baru muncul di daftar.

## 9. Screenshot

Simpan screenshot di folder `docs/screenshots/` lalu tampilkan di sini.

| Bagian | Gambar |
|--------|--------|
| Output `php artisan route:list` | `![route](docs/screenshots/01-route-list.png)` |
| Output `php artisan migrate --seed` | `![migrate](docs/screenshots/02-migrate-seed.png)` |
| Dashboard | `![dashboard](docs/screenshots/03-dashboard.png)` |
| Daftar produk (Read) | `![index](docs/screenshots/04-products-index.png)` |
| Form tambah produk (Create) | `![create](docs/screenshots/05-products-create.png)` |
| Error validasi | `![validation](docs/screenshots/06-validation-error.png)` |
| Detail produk + flash message | `![show](docs/screenshots/07-products-show.png)` |
| Form edit (Update) | `![edit](docs/screenshots/08-products-edit.png)` |
| Hapus produk (Delete) | `![delete](docs/screenshots/09-products-delete.png)` |
| Kategori & Supplier | `![kategori](docs/screenshots/10-categories.png)` |
| Kode Blade view | `![blade](docs/screenshots/11-blade-view.png)` |

## 10. Struktur File Penting

```
app/Http/Controllers/   Product / Category / Supplier / DashboardController
app/Models/             Product, Category, Supplier
database/migrations/    3 migration tabel
database/seeders/       Category, Supplier, Product, DatabaseSeeder
resources/views/        layouts, dashboard, products, categories, suppliers
routes/web.php          definisi route
```
