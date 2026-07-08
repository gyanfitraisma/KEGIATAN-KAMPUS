<?php
// Hubungkan ke database
include 'koneksi.php';

// Cek apakah parameter id ada di URL
if (isset($_GET['id'])) {
    // Ambil id dari URL dan amankan dari SQL Injection
    $id_peserta = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Query untuk menghapus data peserta berdasarkan id_peserta
    // Sesuai dengan nama kolom primary key di phpMyAdmin kamu: id_peserta
    $query = "DELETE FROM peserta WHERE id_peserta = '$id_peserta'";
    $delete = mysqli_query($koneksi, $query);

    if ($delete) {
        // Jika berhasil, tampilkan alert dan kembali ke halaman data peserta
        echo "<script>
                alert('Data peserta berhasil dihapus!');
                window.location.href = 'data-peserta.php';
              </script>";
    } else {
        // Jika gagal
        echo "<script>
                alert('Gagal menghapus data: " . mysqli_error($koneksi) . "');
                window.location.href = 'data-peserta.php';
              </script>";
    }
} else {
    // Jika mencoba akses langsung tanpa ID, kembalikan ke data peserta
    header("Location: data-peserta.php");
    exit;
}
?>