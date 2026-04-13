# 📰 News Portal - Category Management (Laravel)

## 📌 Deskripsi

## 🚀 Fitur

* Menampilkan kategori
* Menambah kategori
* Mengedit kategori
* Menghapus kategori

---

## 🛠️ Teknologi

* Laravel
* PHP
* MySQL
* Blade

---

## 🌐 Routing

| Method | URL                     | Fungsi           |
| ------ | ----------------------- | ---------------- |
| GET    | `/categories`           | Menampilkan data |
| GET    | `/categories/create`    | Form tambah      |
| POST   | `/categories`           | Simpan data      |
| GET    | `/categories/{id}/edit` | Form edit        |
| PUT    | `/categories/{id}`      | Update data      |
| DELETE | `/categories/{id}`      | Hapus data       |

---

## 📂 Contoh Data (JSON Representation)

Walaupun project ini berbasis **web (Blade)**, berikut adalah bentuk data jika direpresentasikan dalam format JSON:

### 🔹 Data Category

```json
{
    "id": 1,
    "name": "Elektronik",
    "created_at": "2024-01-01 10:00:00",
    "updated_at": "2024-01-01 10:00:00"
}
```

---

### 🔹 List Data Category

```json
{
    "status": true,
    "data": [
        {
            "id": 1,
            "name": "Elektronik"
        },
        {
            "id": 2,
            "name": "Fashion"
        }
    ]
}
```

---

### 🔹 Request Tambah Data

```json
{
    "name": "Makanan"
}
```

---

### 🔹 Response Berhasil (Simulasi)

```json
{
    "status": true,
    "message": "Data berhasil ditambahkan",
    "data": {
        "id": 3,
        "name": "Makanan"
    }
}
```

---

### 🔹 Response Error (Validasi)

```json
{
    "status": false,
    "message": "The name field is required."
}
```

---

## ⚙️ Validasi

```php
'name' => 'required|max:255|unique:categories,name'
```

---

## ▶️ Cara Menjalankan

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Akses:

```
http://http://127.0.0.1:8000//categories
```
