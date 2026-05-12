# 🔐 Auth-page

Sistem autentikasi sederhana berbasis PHP Native & MySQL — mencakup registrasi, login, proteksi halaman, dan logout.

---

## ✨ Fitur

- Register & Login dengan validasi lengkap
- Password aman menggunakan `password_hash()` (bcrypt)
- Session-based authentication
- Proteksi halaman dashboard
- Dark / Light mode toggle
- Desain modern dengan Bootstrap 5

---

## 🗂️ Struktur File

```
Auth/
   auth-page
      ├── login.php        # Halaman login & register
      ├── aksi.php         # Handler login, register, logout
      ├── dashboard.php    # Halaman dashboard (protected)
      └── style.css        # Styling halaman login dan register
└── koneksi.php      # Konfigurasi koneksi database
```

---

## 🛠️ Instalasi

1. **Clone repo ini**
   ```bash
   git clone https://github.com/Malfrmnsyhh/Auth-page
   ```

2. **Pindahkan ke folder XAMPP**
   ```bash
   Auth-page/ /xampp/htdocs/
   ```

3. **Buat database & tabel**

   Buka phpMyAdmin lalu jalankan query berikut:
   ```sql
   CREATE DATABASE users_auth;

   USE users_auth;

   CREATE TABLE users (
       id             INT AUTO_INCREMENT PRIMARY KEY,
       nama           VARCHAR(100) ,
       email          VARCHAR(150) ,
       password       VARCHAR(255) ,
       tanggal_daftar DATETIME DEFAULT CURRENT_TIMESTAMP
   );
   ```

4. **Sesuaikan `koneksi.php`**
   ```php
   $koneksi = mysqli_connect("localhost", "root", "", "users_auth");
   ```

5. **Jalankan di browser**
   ```
   http://localhost/Auth-page/login.php
   ```

---

## 🔄 Alur Aplikasi

```
login.php  →  aksi.php (POST)  →  dasbor.php   (login berhasil)
                               →  login.php      (login gagal)
dasbor.php →  aksi.php?action=logout  →  login.php
```

---

## 🧰 Tech Stack

| Teknologi  | Keterangan              |
|------------|-------------------------|
| PHP Native | Backend & session       |
| MySQL      | Database                |
| Bootstrap 5| Styling & komponen UI   |
| Vanilla JS | Dark mode toggle        |

---

