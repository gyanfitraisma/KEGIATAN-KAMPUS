<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_peserta = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Proses hapus data
    $query = "DELETE FROM peserta WHERE id_peserta = '$id_peserta'";
    mysqli_query($koneksi, $query);

    // Cek apakah ada data di database yang BENAR-BENAR terhapus
    if (mysqli_affected_rows($koneksi) > 0) {
        echo "<script>
                alert('Data peserta berhasil dihapus dari database!');
                window.location.href = 'data-peserta.php';
              </script>";
    } else {
        // Jika masuk ke sini, berarti ID yang dikirim PHP salah/tidak ditemukan di MySQL
        echo "<script>
                alert('PHP gagal menghapus! MySQL melaporkan ID tidak ditemukan. Periksa tombol hapus kamu.');
                window.location.href = 'data-peserta.php';
              </script>";
    }
} else {
    header("Location: data-peserta.php");
    exit;
}
?>