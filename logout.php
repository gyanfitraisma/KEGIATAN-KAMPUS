<?php
// Memulai atau mengaktifkan kembali sesi yang sedang berjalan di server agar bisa dimanipulasi
session_start();
// Menghancurkan dan menghapus seluruh data sesi yang terdaftar untuk pengguna saat ini dari memori server
session_destroy();

// Mengarahkan (redireksi) browser pengguna secara otomatis kembali ke halaman login utama (index.php)
header("Location: index.php");
// Menghentikan seluruh proses eksekusi skrip PHP selanjutnya secara instan demi keamanan sistem
exit;
?>