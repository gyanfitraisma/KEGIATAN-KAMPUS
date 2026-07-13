<?php
// Menentukan nama host server database, umumnya menggunakan "localhost" untuk server lokal
$host = "localhost";
//Menentukan username default untuk hak akses masuk ke MySQL, standarnya adalah "root"
$user = "root";
// Menentukan kata sandi (password) MySQL, dikosongkan secara default untuk server lokal XAMPP
$password = "";
// Menentukan nama basis data (database) target yang akan digunakan di dalam sistem aplikasi
$database = "db_kegiatan_kampus";

// Membuat koneksi database
// Menjalankan fungsi bawaan PHP untuk membuka hubungan koneksi baru ke server MySQL
$conn = mysqli_connect($host, $user, $password, $database);

// Validasi koneksi
// Memeriksa status keberhasilan koneksi, jika bernilai salah (gagal) maka blok ini dieksekusi
if (!$conn) {
    // Menghentikan skrip secara paksa dan menampilkan pesan galat (error) detail dari sistem MySQL
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Menyamakan variabel agar mendukung $koneksi dan $conn sekaligus
// Menduplikasi referensi objek koneksi ke variabel baru demi menjaga kompatibilitas variabel di file lain
$koneksi = $conn;
?>