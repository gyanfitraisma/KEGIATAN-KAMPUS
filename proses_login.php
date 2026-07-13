<?php
// Memulai sesi baru atau melanjutkan sesi yang sudah ada di server untuk mencatat data login
session_start();
// Menyertakan file konfigurasi koneksi database
include "koneksi.php";

// Memeriksa apakah data inputan 'username' dan 'password' telah dikirim oleh formulir login
if (isset($_POST['username']) && isset($_POST['password'])) {

    // Mengamankan input username dari celah SQL Injection sebelum masuk ke query
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    // Menyimpan input password ke variabel (tidak di-escape agar karakter aslinya tidak berubah saat divalidasi)
    $password = $_POST['password']; // Jangan di-escape dulu untuk kebutuhan verifikasi password_verify

    // Ambil data user berdasarkan username dan status aktif
    // Menjalankan query SQL untuk mencari data pengguna yang memiliki username cocok dan berstatus 'aktif'
    $query = mysqli_query($koneksi, "SELECT * FROM user_login WHERE username='$username' AND status='aktif'");

    // Memeriksa apakah data pengguna yang dicari ditemukan di dalam database (jumlah baris lebih dari 0)
    if (mysqli_num_rows($query) > 0) {
        // Mengambil baris data hasil query dan mengonversinya ke dalam bentuk array asosiatif
        $data = mysqli_fetch_assoc($query);

        //LOGIKA MULTI-PASSWORD:
        // Cek apakah password cocok dengan teks biasa (untuk data default db)
        // ATAU cocok dengan password terenkripsi (untuk user baru hasil register)
        // Melakukan validasi ganda: mencocokkan teks langsung ATAU mencocokkan via hash enkripsi password
        if ($password === $data['password'] || password_verify($password, $data['password'])) {
            
            // Menyimpan status login sukses ke dalam variabel sesi global
            $_SESSION['login'] = true;
            // Menyimpan ID pengguna ke dalam sesi untuk pelacakan relasi data
            $_SESSION['id_user'] = $data['id_user'];
            // Menyimpan nama akun pengguna ke dalam sesi
            $_SESSION['username'] = $data['username'];
            // Menyimpan nama lengkap asli pengguna ke dalam sesi untuk dipajang di dashboard
            $_SESSION['nama_lengkap'] = $data['nama_lengkap'];
            // Menyimpan level hak akses (role) pengguna ke dalam sesi sistem
            $_SESSION['role'] = $data['role'];

            // Mengarahkan pengguna ke halaman utama admin (dashboard.php) karena autentikasi berhasil
            header("Location: dashboard.php");
            // Menghentikan fungsi kerja skrip selanjutnya demi keamanan alur sistem
            exit();
        } else {
            // Password salah
            // Mengarahkan kembali ke halaman login sambil melempar parameter error bernilai 1
            header("Location: index.php?error=1");
            // Menghentikan kelanjutan eksekusi proses jika validasi password tidak terpenuhi
            exit();
        }
    } else {
        // Username tidak ditemukan
        // Mengarahkan kembali ke halaman utama login dengan membawa tanda parameter galat (error=1)
        header("Location: index.php?error=1");
        // Menghentikan skrip agar tidak memproses baris kode berikutnya di bawah ini
        exit();
    }
} else {
    // Jika akses ke file ini dilakukan langsung tanpa melalui form POST username & password
    // Mengembalikan paksa koneksi pengguna menuju ke halaman form login utama (index.php)
    header("Location: index.php");
    // Menghentikan eksekusi kode program secara menyeluruh
    exit();
}
?>