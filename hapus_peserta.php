<?php
// Menyertakan file konfigurasi koneksi ke basis data MySQL
include 'koneksi.php';

// Memeriksa apakah parameter 'id' dikirimkan melalui URL dengan metode GET
if (isset($_GET['id'])) {
    // Mengamankan data ID peserta dari celah SQL Injection sebelum dieksekusi di query
    $id_peserta = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Proses hapus data
    // Menyusun perintah SQL DELETE untuk menghapus data peserta berdasarkan ID spesifik
    $query = "DELETE FROM peserta WHERE id_peserta = '$id_peserta'";
    // Mengeksekusi query penghapusan data ke database MySQL
    mysqli_query($koneksi, $query);

    // Cek apakah data berhasil dihapus
    // Memeriksa jumlah baris yang terpengaruh/berubah di database setelah eksekusi query
    if (mysqli_affected_rows($koneksi) > 0) {
        // Menampilkan pesan alert sukses dan mengembalikan pengguna ke halaman daftar peserta
        echo "<script>
                alert('Data peserta berhasil dihapus dari database!');
                window.location.href = 'data_peserta.php';
              </script>";
    } else {
        // Menampilkan pesan alert gagal jika data tidak ada atau tidak ditemukan di database
        echo "<script>
                alert('Gagal menghapus! ID tidak ditemukan di database.');
                window.location.href = 'data_peserta.php';
              </script>";
    }
} else {
    // Jika file ini diakses langsung tanpa membawa parameter ID melalui URL
    // Mengarahkan paksa browser pengguna kembali ke halaman utama tabel peserta
    header("Location: data_peserta.php");
    // Menghentikan seluruh proses eksekusi kode PHP selanjutnya demi keamanan sistem
    exit;
}
?>