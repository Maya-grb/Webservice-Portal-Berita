# News Portal Laravel



Project ini merupakan aplikasi News Portal berbasis Laravel yang digunakan untuk menampilkan berita serta mengelola kategori berita. Sistem ini menerapkan konsep CRUD (Create, Read, Update, Delete) untuk kategori dan menampilkan data berita pada halaman utama.

---

## URL Aplikasi

Aplikasi dapat diakses melalui:

```
http://localhost:8000/
```

---

## Fitur Utama

### 1. Manajemen Kategori

* Menampilkan data kategori
* Menambahkan kategori baru
* Mengedit kategori
* Menghapus kategori
* Validasi input otomatis

### 2. Tampilan Berita

* Menampilkan daftar berita
* Menampilkan gambar berita
* Menampilkan judul dan isi berita
* Menampilkan tanggal publikasi

### 3. Notifikasi

* Menggunakan SweetAlert2 untuk menampilkan pesan keberhasilan dan error

---

## Struktur Database

Database yang digunakan: `news_portal_db`

### Tabel Categories

```json
{
    "id": 1,
    "name": "Teknologi",
    "created_at": "2024-01-01 10:00:00",
    "updated_at": "2024-01-01 10:00:00"
}
```

### Tabel News

```json
{
    "id": 1,
    "title": "Judul Berita",
    "content": "Isi berita lengkap",
    "image": "gambar.jpg",
    "created_at": "2024-01-01 10:00:00",
    "updated_at": "2024-01-01 10:00:00"
}
```

---

## Routing

### Kategori

| Method | URL                   | Deskripsi                 |
| ------ | --------------------- | ------------------------- |
| GET    | /categories           | Menampilkan data kategori |
| GET    | /categories/create    | Menampilkan form tambah   |
| POST   | /categories           | Menyimpan data kategori   |
| GET    | /categories/{id}/edit | Menampilkan form edit     |
| PUT    | /categories/{id}      | Mengupdate data           |
| DELETE | /categories/{id}      | Menghapus data            |

### Berita

| Method | URL | Deskripsi                  |
| ------ | --- | -------------------------- |
| GET    | /   | Menampilkan seluruh berita |

---

## Tampilan Sistem

### Halaman Berita

Data berita ditampilkan menggunakan perulangan:

```php
@foreach($news as $new)
```

Data yang ditampilkan:

* Gambar: `$new->image`
* Judul: `$new->title`
* Konten: `$new->content`
* Tanggal: `$new->created_at`

---

### Form Kategori

Input yang digunakan:

```html
<input type="text" name="name">
```

Validasi:

```php
'name' => 'required|max:255|unique:categories,name'
```

---

## Alur Data (JSON)

### Data Berita

```json
{
    "status": true,
    "data": [
        {
            "id": 1,
            "title": "Berita 1",
            "content": "Isi berita",
            "image": "berita1.jpg",
            "created_at": "2024-01-01"
        }
    ]
}
```

### Request Tambah Kategori

```json
{
    "name": "Olahraga"
}
```

### Response Berhasil

```json
{
    "status": true,
    "message": "Data berhasil ditambahkan"
}
```

### Response Error

```json
{
    "status": false,
    "message": "The name field is required."
}
```

---

## Cara Menjalankan

1. Install dependency

```
composer install
```

2. Copy file environment

```
cp .env.example .env
```

3. Konfigurasi database pada file `.env`

4. Generate application key

```
php artisan key:generate
```

5. Jalankan migration

```
php artisan migrate
```

6. Jalankan server

```
php artisan serve
```

7. Akses aplikasi melalui browser

```
http://localhost:8000/
```

---

## Catatan

* Pastikan folder `public/assets/image/` tersedia untuk menyimpan gambar
* Pastikan database sudah dibuat dengan nama `news_portal_db`
* Periksa konfigurasi database jika terjadi error koneksi

---

