<?php
session_start();

// Kalau sudah login, langsung ke dashboard
if (isset($_SESSION['user_id'])) {
  header("Location: dasbor.php");
  exit;
}

// Ambil pesan dari query string (dikirim aksi.php)
$error = $_GET['error'] ?? '';
$success = (($_GET['msg'] ?? '') === 'logout') ? 'Kamu berhasil logout.' : '';
$tab = $_GET['tab'] ?? 'login';
?>

<!doctype html>
<html lang="en" data-theme="light">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap"
    rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style.css">
  <title>Login System</title>
</head>

<body>

  <div class="theme-toggle">
    <button id="btnLight" onclick="setTheme('light')" title="Light Mode"><i class="bi bi-sun-fill"></i></button>
    <button id="btnDark" onclick="setTheme('dark')" title="Dark Mode"><i class="bi bi-moon-fill"></i></button>
  </div>

  <div class="auth-card">
    <div class="brand">
      <span class="brand-name">AuthSystem</span>
    </div>

    <?php if (!empty($error)): ?>
      <div class="alert-custom alert-danger">
        <i class="bi bi-exclamation-circle-fill"></i> <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>
    <?php if (!empty($success)): ?>
      <div class="alert-custom alert-success">
        <i class="bi bi-check-circle-fill"></i> <?= htmlspecialchars($success) ?>
      </div>
    <?php endif; ?>

    <div class="auth-tabs">
      <button class="auth-tab" id="tabLogin" onclick="switchTab('login')">Login</button>
      <button class="auth-tab" id="tabRegister" onclick="switchTab('register')">Register</button>
    </div>

    <div class="form-panel" id="panelLogin">
      <div class="auth-heading">
        <h2>Welcome</h2>
      </div>
      <form method="POST" action="aksi.php">
        <input type="hidden" name="action" value="login">
        <div class="form-group">
          <label class="form-label-custom">Email Address</label>
          <div class="input-wrapper">
            <input type="email" name="email" class="form-control-custom" placeholder="nama@email.com" required
              autocomplete="email">
            <i class="bi bi-envelope input-icon"></i>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label-custom">Password</label>
          <div class="input-wrapper">
            <input type="password" name="password" id="loginPw" class="form-control-custom"
              placeholder="Masukkan password" required autocomplete="current-password">
            <i class="bi bi-lock input-icon"></i>
            <button type="button" class="toggle-pw" onclick="togglePw('loginPw',this)"><i
                class="bi bi-eye"></i></button>
          </div>
        </div>
        <button type="submit" class="btn-submit"><i class="bi bi-box-arrow-in-right me-2"></i> Masuk</button>
      </form>
    </div>

    <div class="form-panel" id="panelRegister">
      <div class="auth-heading">
        <h2>Buat akun baru</h2>
      </div>
      <form method="POST" action="aksi.php">
        <input type="hidden" name="action" value="register">
        <div class="form-group">
          <label class="form-label-custom">Nama Lengkap</label>
          <div class="input-wrapper">
            <input type="text" name="name" class="form-control-custom" placeholder="Nama kamu" required
              autocomplete="name">
            <i class="bi bi-person input-icon"></i>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label-custom">Email Address</label>
          <div class="input-wrapper">
            <input type="email" name="email" class="form-control-custom" placeholder="nama@email.com" required
              autocomplete="email">
            <i class="bi bi-envelope input-icon"></i>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label-custom">Password</label>
          <div class="input-wrapper">
            <input type="password" name="password" id="regPw" class="form-control-custom" placeholder="Min. 8 karakter"
              required autocomplete="new-password">
            <i class="bi bi-lock input-icon"></i>
            <button type="button" class="toggle-pw" onclick="togglePw('regPw',this)"><i class="bi bi-eye"></i></button>
          </div>
        </div>
        <div class="form-group" style="margin-bottom:24px">
          <label class="form-label-custom">Konfirmasi Password</label>
          <div class="input-wrapper">
            <input type="password" name="confirm_password" id="regPw2" class="form-control-custom"
              placeholder="Ulangi password" required autocomplete="new-password">
            <i class="bi bi-lock-fill input-icon"></i>
            <button type="button" class="toggle-pw" onclick="togglePw('regPw2',this)"><i class="bi bi-eye"></i></button>
          </div>
        </div>
        <button type="submit" class="btn-submit"><i class="bi bi-person-plus me-2"></i> Daftar Sekarang</button>
      </form>
      <div class="auth-footer" style="margin-top:16px">
        Sudah punya akun? <a href="#" onclick="switchTab('login');return false;">Login di sini</a>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    const html = document.documentElement;
    function setTheme(t) {
      html.setAttribute('data-theme', t);
      localStorage.setItem('theme', t);
      document.getElementById('btnLight').classList.toggle('active', t === 'light');
      document.getElementById('btnDark').classList.toggle('active', t === 'dark');
    }
    (function () { setTheme(localStorage.getItem('theme') || 'light'); })();

    function switchTab(tab) {
      const isLogin = tab === 'login';
      document.getElementById('tabLogin').classList.toggle('active', isLogin);
      document.getElementById('tabRegister').classList.toggle('active', !isLogin);
      document.getElementById('panelLogin').classList.toggle('active', isLogin);
      document.getElementById('panelRegister').classList.toggle('active', !isLogin);
    }
    switchTab("<?= $tab ?>");

    function togglePw(id, btn) {
      const el = document.getElementById(id);
      const hidden = el.type === 'password';
      el.type = hidden ? 'text' : 'password';
      btn.querySelector('i').className = hidden ? 'bi bi-eye-slash' : 'bi bi-eye';
    }
  </script>
</body>

</html>