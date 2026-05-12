<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$nama  = $_SESSION['nama'];
$email = $_SESSION['email'];

$words    = explode(' ', trim($nama));
$initials = strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
?>

<!doctype html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <title>Dashboard</title>
    <style>
        :root {
            --bg:           #f0ede8;
            --surface:      #ffffff;
            --surface-2:    #f7f5f2;
            --border:       #e2ddd7;
            --text:         #1a1714;
            --text-muted:   #8a8078;
            --accent:       #2d6a4f;
            --accent-hover: #1b4332;
            --accent-light: #d8f3dc;
            --shadow:       0 8px 40px rgba(0,0,0,0.07);
            --transition:   0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        [data-theme="dark"] {
            --bg:           #0f1210;
            --surface:      #1a1f1c;
            --surface-2:    #222822;
            --border:       #2e352e;
            --text:         #e8ede9;
            --text-muted:   #7a8c7c;
            --accent:       #52b788;
            --accent-hover: #74c69d;
            --accent-light: #1a2e22;
            --shadow:       0 8px 40px rgba(0,0,0,0.4);
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: background var(--transition), color var(--transition);
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: fixed; top: -25%; right: -15%;
            width: 550px; height: 550px; border-radius: 50%;
            background: radial-gradient(circle, var(--accent-light) 0%, transparent 65%);
            opacity: 0.55; pointer-events: none; transition: background var(--transition);
        }
        body::after {
            content: '';
            position: fixed; bottom: -20%; left: -12%;
            width: 480px; height: 480px; border-radius: 50%;
            background: radial-gradient(circle, var(--accent-light) 0%, transparent 65%);
            opacity: 0.35; pointer-events: none; transition: background var(--transition);
        }

        .theme-toggle {
            position: fixed; top: 24px; right: 24px; z-index: 100;
            background: var(--surface); border: 1.5px solid var(--border);
            border-radius: 50px; padding: 6px;
            display: flex; align-items: center; gap: 4px;
            box-shadow: var(--shadow); transition: all var(--transition);
        }
        .theme-toggle button {
            background: none; border: none; cursor: pointer;
            width: 36px; height: 36px; border-radius: 50px;
            display: flex; align-items: center; justify-content: center;
            font-size: 16px; color: var(--text-muted); transition: all var(--transition);
        }
        .theme-toggle button.active { background: var(--accent); color: #fff; }
        .theme-toggle button:hover:not(.active) { background: var(--surface-2); color: var(--text); }

        .btn-logout {
            position: fixed; top: 24px; left: 24px; z-index: 100;
            background: var(--surface); border: 1.5px solid var(--border);
            border-radius: 50px; padding: 8px 18px;
            font-family: 'DM Sans', sans-serif; font-size: 13.5px; font-weight: 500;
            color: var(--text-muted); cursor: pointer;
            display: flex; align-items: center; gap: 7px;
            box-shadow: var(--shadow); text-decoration: none;
            transition: all var(--transition);
        }
        .btn-logout:hover {
            background: #fef2f2; border-color: #fecaca;
            color: #b91c1c;
        }
        [data-theme="dark"] .btn-logout:hover {
            background: #2d1111; border-color: #7f1d1d; color: #fca5a5;
        }

        .dashboard {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            position: relative;
            z-index: 10;
            animation: fadeUp 0.6s cubic-bezier(0.4,0,0.2,1) both;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(28px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .avatar {
            width: 88px; height: 88px;
            background: var(--accent);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif; font-weight: 800;
            font-size: 30px; color: #fff;
            margin-bottom: 32px;
            box-shadow: 0 8px 32px rgba(45,106,79,0.3);
            letter-spacing: 1px;
            transition: background var(--transition), box-shadow var(--transition);
        }
        [data-theme="dark"] .avatar { box-shadow: 0 8px 32px rgba(82,183,136,0.25); }

        .greeting {
            font-family: 'DM Sans', sans-serif;
            font-size: 15px; font-weight: 400;
            color: var(--text-muted);
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 12px;
        }

        .user-name {
            font-family: 'Poppins', sans-serif;
            font-weight: 800;
            font-size: clamp(36px, 7vw, 64px);
            letter-spacing: -2px;
            line-height: 1.05;
            color: var(--text);
            margin-bottom: 16px;
        }
        .user-name span {
            color: var(--accent);
            transition: color var(--transition);
        }

        .email-badge {
            display: inline-flex; align-items: center; gap: 7px;
            background: var(--surface); border: 1.5px solid var(--border);
            border-radius: 50px; padding: 8px 18px;
            font-size: 13.5px; color: var(--text-muted);
            box-shadow: var(--shadow);
            transition: all var(--transition);
            margin-bottom: 40px;
        }
        .email-badge i { color: var(--accent); font-size: 14px; }

        .divider-line {
            width: 48px; height: 3px;
            background: var(--accent);
            border-radius: 2px;
            margin: 0 auto 32px;
            opacity: 0.5;
        }

        .tagline {
            font-size: 15px; color: var(--text-muted);
            max-width: 320px; line-height: 1.6;
        }

        @media (max-width: 480px) {
            .user-name { letter-spacing: -1px; }
            .btn-logout span { display: none; }
        }
    </style>
</head>
<body>

<a href="aksi.php?action=logout" class="btn-logout">
    <i class="bi bi-box-arrow-left"></i>
    <span>Logout</span>
</a>

<div class="theme-toggle">
    <button id="btnLight" onclick="setTheme('light')" title="Light Mode"><i class="bi bi-sun-fill"></i></button>
    <button id="btnDark"  onclick="setTheme('dark')"  title="Dark Mode"><i class="bi bi-moon-fill"></i></button>
</div>

<div class="dashboard">

    <div class="avatar"><?= htmlspecialchars($initials) ?></div>

    <p class="greeting">Selamat datang</p>

    <h1 class="user-name">
        <?php
            $parts = explode(' ', htmlspecialchars($nama), 2);
            echo '<span>' . $parts[0] . '</span>';
            if (isset($parts[1])) echo ' ' . $parts[1];
        ?>
    </h1>

    <div class="email-badge">
        <i class="bi bi-envelope-fill"></i>
        <?= htmlspecialchars($email) ?>
    </div>

    <div class="divider-line"></div>

    <p class="tagline">Kamu sudah berhasil masuk kedalam dashboard</p>

</div>

<script>
    function setTheme(t) {
        document.documentElement.setAttribute('data-theme', t);
        localStorage.setItem('theme', t);
        document.getElementById('btnLight').classList.toggle('active', t === 'light');
        document.getElementById('btnDark').classList.toggle('active', t === 'dark');
    }
    (function(){ setTheme(localStorage.getItem('theme') || 'light'); })();
</script>
</body>
</html>