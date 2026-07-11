<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "db_kegiatan_kampus";

// Membuat koneksi database
$conn = mysqli_connect($host, $user, $password, $database);

// Validasi koneksi
if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Menyamakan variabel agar mendukung $koneksi dan $conn sekaligus
$koneksi = $conn;
?>