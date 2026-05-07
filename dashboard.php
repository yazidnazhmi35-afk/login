<?php
session_start();

// Cek sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | Portal Premium</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body {
            display: block; /* Override flex center from style.css */
            overflow-y: auto;
        }
        .navbar-premium {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--card-border);
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .main-container {
            padding: 3rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }
        .dashboard-card {
            background: var(--card-bg);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            padding: 2rem;
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
            background: rgba(255, 255, 255, 0.08);
        }
        .icon-box {
            width: 48px;
            height: 48px;
            background: rgba(99, 102, 241, 0.1);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
            color: var(--primary);
        }
    </style>
</head>
<body>
    <div class="blob blob-1"></div>
    <div class="blob blob-2"></div>

    <nav class="navbar-premium">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <i data-lucide="layout-dashboard" style="color: var(--primary);"></i>
            <span style="font-weight: 700; font-size: 1.25rem;">Portal Premium</span>
        </div>
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <div style="text-align: right;">
                <div style="font-size: 0.75rem; color: var(--text-muted);">Selamat datang,</div>
                <div style="font-weight: 600;"><?php echo $username; ?></div>
            </div>
            <a href="logout.php" class="btn-premium btn-outline-premium" style="margin: 0; padding: 0.5rem 1rem; font-size: 0.875rem;">
                <i data-lucide="log-out" style="width: 16px;"></i>
                Logout
            </a>
        </div>
    </nav>

    <main class="main-container">
        <header style="margin-bottom: 3rem;">
            <h1 class="text-gradient" style="font-size: 2.5rem;">Halo, <?php echo $username; ?>! 👋</h1>
            <p style="color: var(--text-muted); font-size: 1.125rem;">Anda telah berhasil masuk ke sistem portal premium kami.</p>
        </header>

        <div class="stats-grid">
            <div class="dashboard-card">
                <div class="icon-box">
                    <i data-lucide="user"></i>
                </div>
                <h3>Profil Saya</h3>
                <p style="color: var(--text-muted); margin: 0.5rem 0 1.5rem;">Lihat dan edit informasi personal Anda di sini.</p>
                <a href="#" class="text-gradient" style="text-decoration: none; font-weight: 600;">Buka Profil →</a>
            </div>

            <div class="dashboard-card">
                <div class="icon-box" style="color: #10b981; background: rgba(16, 185, 129, 0.1);">
                    <i data-lucide="settings"></i>
                </div>
                <h3>Pengaturan</h3>
                <p style="color: var(--text-muted); margin: 0.5rem 0 1.5rem;">Sesuaikan preferensi aplikasi sesuai keinginan Anda.</p>
                <a href="#" class="text-gradient" style="text-decoration: none; font-weight: 600;">Buka Pengaturan →</a>
            </div>

            <div class="dashboard-card">
                <div class="icon-box" style="color: #f59e0b; background: rgba(245, 158, 11, 0.1);">
                    <i data-lucide="activity"></i>
                </div>
                <h3>Aktivitas</h3>
                <p style="color: var(--text-muted); margin: 0.5rem 0 1.5rem;">Pantau riwayat penggunaan dan aktivitas akun Anda.</p>
                <a href="#" class="text-gradient" style="text-decoration: none; font-weight: 600;">Lihat Semua →</a>
            </div>
        </div>
    </main>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>
