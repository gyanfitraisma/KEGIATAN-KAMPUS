<?php
session_start();
include "koneksi.php";

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; // Jangan di-escape dulu untuk kebutuhan verifikasi password_verify

    // Ambil data user berdasarkan username dan status aktif
    $query = mysqli_query($koneksi, "SELECT * FROM user_login WHERE username='$username' AND status='aktif'");

    if (mysqli_num_rows($query) > 0) {
        $data = mysqli_fetch_assoc($query);

        // LOGIKA MULTI-PASSWORD:
        // Cek apakah password cocok dengan teks biasa (untuk data default db)
        // ATAU cocok dengan password terenkripsi (untuk user baru hasil register)
        if ($password === $data['password'] || password_verify($password, $data['password'])) {
            
            $_SESSION['login'] = true;
            $_SESSION['id_user'] = $data['id_user'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
            $_SESSION['role'] = $data['role'];

            header("Location: dashboard.php");
            exit();
        } else {
            // Password salah
            header("Location: index.php?error=1");
            exit();
        }
    } else {
        // Username tidak ditemukan
        header("Location: index.php?error=1");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>