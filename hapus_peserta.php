<?php
include 'koneksi.php';

if (isset($_GET['id'])) {
    $id_peserta = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Proses hapus data
    $query = "DELETE FROM peserta WHERE id_peserta = '$id_peserta'";
    mysqli_query($koneksi, $query);

    // Cek apakah data berhasil dihapus
    if (mysqli_affected_rows($koneksi) > 0) {
        echo "<script>
                alert('Data peserta berhasil dihapus dari database!');
                window.location.href = 'data_peserta.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus! ID tidak ditemukan di database.');
                window.location.href = 'data_peserta.php';
              </script>";
    }
} else {
    header("Location: data_peserta.php");
    exit;
}
?>  