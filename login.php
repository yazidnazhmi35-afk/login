<?php
session_start();
require_once "database.php";

if ($_POST) {
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Validasi
    if (empty($username) || empty($password)) {
        die("<!DOCTYPE html><html lang='en'><head><link rel='stylesheet' href='style.css'><script src='https://unpkg.com/lucide@latest'></script></head><body><div class='blob blob-1'></div><div class='glass-card text-center'><i data-lucide='alert-circle' style='width:64px; height:64px; color:var(--secondary); margin-bottom:1.5rem;'></i><h2 class='text-gradient'>Error!</h2><p style='color:var(--text-muted); margin-bottom:2rem;'>Username dan password harus diisi!</p><a href='login.html' class='btn-premium btn-primary-premium'>Kembali</a></div><script>lucide.createIcons();</script></body></html>");
    }

    $db = new Database();
    $conn = $db->connect();

    // Cari user
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verifikasi password
        if (password_verify($password, $row['password'])) {
            // Set session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            // Redirect ke dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            die("<!DOCTYPE html><html lang='en'><head><link rel='stylesheet' href='style.css'><script src='https://unpkg.com/lucide@latest'></script></head><body><div class='blob blob-1'></div><div class='glass-card text-center'><i data-lucide='shield-x' style='width:64px; height:64px; color:var(--secondary); margin-bottom:1.5rem;'></i><h2 class='text-gradient'>Akses Ditolak</h2><p style='color:var(--text-muted); margin-bottom:2rem;'>Password yang Anda masukkan salah.</p><a href='login.html' class='btn-premium btn-primary-premium'>Kembali</a></div><script>lucide.createIcons();</script></body></html>");
        }
    } else {
        die("<!DOCTYPE html><html lang='en'><head><link rel='stylesheet' href='style.css'><script src='https://unpkg.com/lucide@latest'></script></head><body><div class='blob blob-1'></div><div class='glass-card text-center'><i data-lucide='user-x' style='width:64px; height:64px; color:var(--secondary); margin-bottom:1.5rem;'></i><h2 class='text-gradient'>User Tidak Ditemukan</h2><p style='color:var(--text-muted); margin-bottom:2rem;'>Username tidak terdaftar di sistem kami.</p><a href='login.html' class='btn-premium btn-primary-premium'>Kembali</a></div><script>lucide.createIcons();</script></body></html>");
    }

    $stmt->close();
    $conn->close();
}
?>
