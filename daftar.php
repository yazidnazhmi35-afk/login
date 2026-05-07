<?php
session_start();
require_once "database.php";

if ($_POST) {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // Validasi
    if (empty($username) || empty($email) || empty($password)) {
        die("<!DOCTYPE html><html lang='en'><head><link rel='stylesheet' href='style.css'><script src='https://unpkg.com/lucide@latest'></script></head><body><div class='blob blob-1'></div><div class='glass-card text-center'><i data-lucide='alert-circle' style='width:64px; height:64px; color:var(--secondary); margin-bottom:1.5rem;'></i><h2 class='text-gradient'>Error!</h2><p style='color:var(--text-muted); margin-bottom:2rem;'>Semua field harus diisi!</p><a href='signup.html' class='btn-premium btn-primary-premium'>Kembali</a></div><script>lucide.createIcons();</script></body></html>");
    }

    $db = new Database();
    $conn = $db->connect();

    // Cek username sudah ada
    $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        die("<!DOCTYPE html><html lang='en'><head><link rel='stylesheet' href='style.css'><script src='https://unpkg.com/lucide@latest'></script></head><body><div class='blob blob-1'></div><div class='glass-card text-center'><i data-lucide='user-x' style='width:64px; height:64px; color:var(--secondary); margin-bottom:1.5rem;'></i><h2 class='text-gradient'>Username Terpakai</h2><p style='color:var(--text-muted); margin-bottom:2rem;'>Username tersebut sudah digunakan oleh pengguna lain.</p><a href='signup.html' class='btn-premium btn-primary-premium'>Kembali</a></div><script>lucide.createIcons();</script></body></html>");
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert user
    $insert = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $insert->bind_param("sss", $username, $email, $hashedPassword);

    if ($insert->execute()) {
        // Ambil ID user yang baru dibuat
        $user_id = $conn->insert_id;

        // Set session
        $_SESSION['user_id'] = $user_id;
        $_SESSION['username'] = $username;

        // Redirect ke dashboard
        header("Location: dashboard.php");
        exit();
    } else {
        die("<!DOCTYPE html><html lang='en'><head><link rel='stylesheet' href='style.css'><script src='https://unpkg.com/lucide@latest'></script></head><body><div class='blob blob-1'></div><div class='glass-card text-center'><i data-lucide='x-circle' style='width:64px; height:64px; color:var(--secondary); margin-bottom:1.5rem;'></i><h2 class='text-gradient'>Gagal Mendaftar</h2><p style='color:var(--text-muted); margin-bottom:2rem;'>Terjadi kesalahan saat menyimpan data Anda.</p><a href='signup.html' class='btn-premium btn-primary-premium'>Kembali</a></div><script>lucide.createIcons();</script></body></html>");
    }

    $stmt->close();
    $insert->close();
    $conn->close();
}
?>