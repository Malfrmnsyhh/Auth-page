<?php
session_start();
require_once '../koneksi.php';

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
  case 'login':
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
      redirect_login('Email dan password tidak boleh kosong');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      redirect_login('Email tidak valid');
    }

    $stmt = $koneksi->prepare("SELECT id, nama, email, password FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
      redirect_login("Email atau password salah.");
    }

    $user = $result->fetch_assoc();
    $stmt->close();

    if (!password_verify($password, $user['password'])) {
      redirect_login("Email atau password salah");
    }

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nama'] = $user['nama'];
    $_SESSION['email'] = $user['email'];

    header("location: dashboard.php");
    exit();

  case 'register':
    $nama = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // --- Validasi input kosong ---
    if (empty($nama) || empty($email) || empty($password) || empty($confirm_password)) {
      redirect_login('Semua field harus diisi.', 'register');
    }

    // --- Validasi format email ---
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      redirect_login('Format email tidak valid.', 'register');
    }

    // --- Validasi panjang password ---
    if (strlen($password) < 8) {
      redirect_login('Password minimal 8 karakter.', 'register');
    }

    // --- Validasi konfirmasi password ---
    if ($password !== $confirm_password) {
      redirect_login('Password dan konfirmasi password tidak cocok.', 'register');
    }

    // --- Cek email sudah terdaftar ---
    $stmt = $koneksi->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
      $stmt->close();
      redirect_login('Email sudah terdaftar, silakan login.', 'register');
    }
    $stmt->close();

    // --- Hash password ---
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // --- Simpan ke database ---
    $tanggal_daftar = date('Y-m-d H:i:s');
    $stmt = $koneksi->prepare("INSERT INTO users (nama, email, password, tanggal_daftar) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nama, $email, $hashed_password, $tanggal_daftar);

    if ($stmt->execute()) {
      $stmt->close();
      // Set session langsung setelah register
      $new_id = $koneksi->insert_id;
      $_SESSION['user_id'] = $new_id;
      $_SESSION['nama'] = $nama;
      $_SESSION['email'] = $email;
      header("Location: dashboard.php");
      exit;
    } else {
      $stmt->close();
      redirect_login('Terjadi kesalahan, coba lagi.', 'register');
    }

  case 'logout':
    session_start();
    session_unset();
    session_destroy();
    header("location: login.php");
    exit();

  default:
    header("location: login.php");
    exit;
}

function redirect_login(string $pesan, string $tab = 'login')
{
  $msg = urlencode($pesan);
  header("location: login.php?error={$msg}&tab={$tab}");
  exit;
}