# 🔐 simple-php-auth

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
simple-php-auth/
├── koneksi.php      # Konfigurasi koneksi database
├── login.php        # Halaman login & register
├── aksi.php         # Handler login, register, logout
└── dasbor.php       # Halaman dashboard (protected)
```

---

## 🛠️ Instalasi

1. **Clone repo ini**
   ```bash
   git clone https://github.com/username/simple-php-auth.git
   ```

2. **Pindahkan ke folder XAMPP**
   ```bash
   mv simple-php-auth/ /xampp/htdocs/
   ```

3. **Buat database & tabel**

   Buka phpMyAdmin lalu jalankan query berikut:
   ```sql
   CREATE DATABASE users_auth;

   USE users_auth;

   CREATE TABLE users (
       id             INT AUTO_INCREMENT PRIMARY KEY,
       nama           VARCHAR(100)  NOT NULL,
       email          VARCHAR(150)  NOT NULL UNIQUE,
       password       VARCHAR(255)  NOT NULL,
       tanggal_daftar DATETIME      DEFAULT CURRENT_TIMESTAMP
   );
   ```

4. **Sesuaikan `koneksi.php`**
   ```php
   $conn = mysqli_connect("localhost", "root", "", "users_auth");
   ```

5. **Jalankan di browser**
   ```
   http://localhost/simple-php-auth/login.php
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

## 📄 Lisensi

Proyek ini dibuat untuk keperluan tugas akademik. Bebas digunakan dan dimodifikasi.
