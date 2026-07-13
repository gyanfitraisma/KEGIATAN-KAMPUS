<?php
// Menyertakan file konfigurasi koneksi ke basis data MySQL
include 'koneksi.php';

// Menginisialisasi variabel pesan kesalahan dengan string kosong default
$pesan_error = "";
// Menginisialisasi variabel pesan keberhasilan dengan string kosong default
$pesan_sukses = "";

// Cek apakah tombol submit (Daftar User) sudah diklik
// Memeriksa apakah halaman diakses menggunakan metode pengiriman data POST dari formulir
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dan amankan dari SQL Injection
    // Membersihkan input nama lengkap dari potensi karakter berbahaya/query ilegal
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    // Membersihkan kata kunci identitas akun (username) sebelum masuk ke database
    $username     = mysqli_real_escape_string($koneksi, $_POST['username']);
    //Membersihkan input data surat elektronik (email)
    $email        = mysqli_real_escape_string($koneksi, $_POST['email']);
    // Membersihkan nomor handphone pendaftar untuk validasi keamanan database
    $no_hp        = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    // Menangkap nilai password asli (sengaja tidak di-escape agar karakter asli sandi terjaga saat di-hash)
    $password     = $_POST['password'];
    // Menangkap nilai ulangan konfirmasi kata sandi dari formulir
    $confirm_pwd  = $_POST['confirm_password'];
    // Membersihkan pilihan hak akses kedudukan akun (role)
    $role_akses   = mysqli_real_escape_string($koneksi, $_POST['role_akses']);
    // Membersihkan parameter status keaktifan akun baru
    $status_akun  = mysqli_real_escape_string($koneksi, $_POST['status_akun']);

    // 1. Validasi: Pastikan Password dan Konfirmasi Password cocok
    // Membandingkan kesamaan string antara password utama dan konfirmasi password
    if ($password !== $confirm_pwd) {
        // Mengisi pesan galat jika kedua input kata sandi tersebut tidak sama
        $pesan_error = "Konfirmasi password tidak cocok!";
    } else {
        // 2. Validasi: Cek apakah username sudah pernah terdaftar
        // Menjalankan query ke database untuk memeriksa ketersediaan nama pengguna yang sama
        $cek_username = mysqli_query($koneksi, "SELECT * FROM user_login WHERE username = '$username'");
        
        // Memeriksa jika jumlah baris hasil query lebih besar dari 0 (artinya username sudah ada)
        if (mysqli_num_rows($cek_username) > 0) {
            // Memberikan notifikasi bahwa nama pengguna tersebut tidak bisa digunakan kembali
            $pesan_error = "Username sudah digunakan, pilih username lain!";
        } else {
            // Hash password demi keamanan data sebelum disimpan ke database
            // Mengubah teks kata sandi mentah menjadi string acak terenkripsi yang aman menggunakan bcrypt
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // 3. Eksekusi: Masukkan data ke database
            // Sesuaikan nama kolom berikut dengan struktur tabel user di phpMyAdmin kamu
            // Menyusun perintah SQL INSERT untuk mendaftarkan akun pengguna baru ke tabel user_login
            $query = "INSERT INTO user_login (nama_lengkap, username, email, no_hp, password, role, status) 
                      VALUES ('$nama_lengkap', '$username', '$email', '$no_hp', '$password_hashed', '$role_akses', '$status_akun')";
            
            // Mengeksekusi query ke database dan memvalidasi apakah proses berhasil
            if (mysqli_query($koneksi, $query)) {
                // Menetapkan pesan sukses pendaftaran akun
                $pesan_sukses = "Akun berhasil didaftarkan! Mengalihkan ke halaman login...";
                // Redirect otomatis ke halaman login (index.php) setelah 2 detik
                // Mengirim instruksi header HTTP refresh guna memindahkan halaman secara otomatis
                header("refresh:2;url=index.php");
            } else {
                // Menyimpan informasi pesan error bawaan database jika query gagal berjalan
                $pesan_error = "Gagal mendaftarkan akun: " . mysqli_error($koneksi);
            }
        }
    }
}
?>

<!DOCTYPE html>
<!-- Mendeklarasikan format dokumen web berbasis standar baku HTML5 -->
<html lang="id">
<head>
    <!-- Menentukan pengodean kumpulan karakter dokumen dengan standar UTF-8 -->
    <meta charset="UTF-8">
    <!-- Mengatur viewport agar tampilan antarmuka bersifat fleksibel di ponsel dan komputer -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Memberikan judul halaman resmi pada tab penjelajah internet -->
    <title>Register User</title>
    <!-- Memuat lembar gaya CSS Bootstrap 5 untuk standarisasi layout dan elemen visual -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Memuat kumpulan simbol ikon grafis dari pustaka Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Menyertakan stylesheet eksternal lokal untuk desain kustom tata letak halaman -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
<!-- Kontainer utama tempat menampung kartu formulir pendaftaran akun (lebar luas) -->
<main class="auth-card auth-card-wide">
    <!-- Area visual untuk menampilkan simbol ikon pendaftaran user -->
    <div class="auth-logo">
        <i class="bi bi-person-plus-fill"></i>
    </div>
    <!-- Judul utama tajuk formulir pendaftaran -->
    <h1>Register User</h1>
    <!-- Deskripsi petunjuk pengisian bagi calon admin maupun panitia baru -->
    <p class="text-muted">Silakan lengkapi data untuk membuat akun Admin ataupun Panitia.</p>
    
    <!-- Tempat menampilkan notifikasi sukses atau error -->
    <!-- Memeriksa apakah terdapat pesan galat yang perlu ditampilkan ke layar -->
    <?php if ($pesan_error != ""): ?>
        <!-- Kotak pemberitahuan berwarna merah yang dinamis untuk menampilkan pesan error -->
        <div class="alert alert-danger mt-3">
            <i class="bi bi-exclamation-triangle-fill"></i> <?= $pesan_error; ?>
        </div>
    <?php endif; ?>

    <!-- Memeriksa apakah terdapat pesan keberhasilan transaksi data yang perlu dicetak -->
    <?php if ($pesan_sukses != ""): ?>
        <!-- Kotak pemberitahuan berwarna hijau dinamis untuk menampilkan pesan sukses pendaftaran -->
        <div class="alert alert-success mt-3">
            <i class="bi bi-check-circle-fill"></i> <?= $pesan_sukses; ?>
        </div>
    <?php endif; ?>

    <!-- Kotak instruksi informasi standar berwarna biru untuk mengingatkan pengguna -->
    <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle-fill"></i> Pastikan seluruh data yang diinput sudah benar sebelum membuat akun.
    </div>

    <!-- Menambahkan action kosong (memproses di file ini sendiri) dan method POST -->
    <!-- Form isian pendaftaran yang mengirimkan datanya kembali ke file ini menggunakan metode POST -->
    <form action="" method="POST" class="row g-4 mt-2">
        <!-- Kolom isian teks Nama Lengkap pengguna -->
        <div class="col-md-6">
            <label class="form-label">Nama Lengkap</label>
            <!-- Kolom input yang mengingat data input sebelumnya jika validasi form sempat gagal -->
            <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required value="<?= isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : ''; ?>">
        </div>
        <!-- Kolom isian teks kata sandi akun unik (Username) -->
        <div class="col-md-6">
            <label class="form-label">Username</label>
            <!-- Mengunci data lama yang telah di-post agar pengguna tidak repot mengetik ulang -->
            <input type="text" name="username" class="form-control" placeholder="Masukkan username" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
        </div>
        <!-- Kolom isian alamat korespondensi elektronik (Email) -->
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <!-- Menggunakan tipe data email untuk validasi otomatis struktur surel oleh browser -->
            <input type="email" name="email" class="form-control" placeholder="nama@kampus.ac.id" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        </div>
        <!-- Kolom isian data nomor kontak telepon seluler -->
        <div class="col-md-6">
            <label class="form-label">No. HP</label>
            <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required value="<?= isset($_POST['no_hp']) ? htmlspecialchars($_POST['no_hp']) : ''; ?>">
        </div>
        
        <!-- Kolom input pengisian Kata Sandi utama -->
        <div class="col-md-6">
            <label class="form-label">Password</label>
            <!-- Komponen grup masukan terpadu untuk menyatukan kolom input dengan tombol mata -->
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                <!-- Tombol aksi kustom untuk memicu fungsi melihat/menyembunyikan teks sandi lewat JavaScript -->
                <button class="input-group-text" type="button" id="togglePassword" style="cursor: pointer; z-index: 10; pointer-events: auto;">
                     <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
            </div>
        </div>
        
        <!-- Kolom input pengisian pengulangan Konfirmasi Kata Sandi -->
        <div class="col-md-6">
            <label class="form-label">Konfirmasi Password</label>
            <!-- Komponen grup masukan terpadu untuk area konfirmasi sandi -->
            <div class="input-group">
                <input type="password" name="confirm_password" id="confirmPassword" class="form-control" placeholder="Ulangi password" required>
                <!-- Tombol aksi pemutus visibilitas teks konfirmasi kata sandi -->
                <button class="input-group-text" type="button" id="toggleConfirmPassword" style="cursor: pointer; z-index: 10; pointer-events: auto;">
                     <i class="bi bi-eye" id="toggleConfirmIcon"></i>
                </button>
            </div>
        </div>

        <!-- Kolom Dropdown pemilihan tingkatan hak akses (Role Akses) -->
        <div class="col-md-6">
            <label class="form-label">Role Akses</label>
            <select name="role_akses" class="form-select">
                <!-- Mempertahankan pilihan opsi 'Admin' jika sebelumnya sudah terpilih -->
                <option value="Admin" <?= (isset($_POST['role_akses']) && $_POST['role_akses'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                <!-- Mempertahankan pilihan opsi 'Panitia' jika sebelumnya sudah terpilih -->
                <option value="Panitia" <?= (isset($_POST['role_akses']) && $_POST['role_akses'] == 'Panitia') ? 'selected' : ''; ?>>Panitia</option>
            </select>
        </div>
        <!-- Kolom Dropdown pemilihan status validitas keaktifan akun -->
        <div class="col-md-6">
            <label class="form-label">Status Akun</label>
            <select name="status_akun" class="form-select">
                <!-- Mempertahankan kondisi opsi 'Aktif' setelah form dikirim -->
                <option value="Aktif" <?= (isset($_POST['status_akun']) && $_POST['status_akun'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                <!-- Mempertahankan kondisi opsi 'Nonaktif' setelah form dikirim -->
                <option value="Nonaktif" <?= (isset($_POST['status_akun']) && $_POST['status_akun'] == 'Nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
            </select>
        </div>
        <!-- Komponen kotak centang deklarasi keabsahan data pengguna -->
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="cek" required>
                <label class="form-check-label" for="cek">Saya menyatakan bahwa data yang saya masukkan sudah benar.</label>
            </div>
        </div>
        <!-- Kolom baris tombol eksekusi akhir data registrasi dan tombol reset -->
        <div class="col-12 d-flex gap-3">
            <!-- Tombol submit utama untuk memproses pendaftaran user -->
            <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-person-plus-fill"></i> Daftar User</button>
            <!-- Tombol pembatalan/reset isian untuk mengembalikan form ke kondisi kosong -->
            <button type="reset" class="btn btn-outline-secondary flex-fill"><i class="bi bi-arrow-clockwise"></i> Reset</button>
        </div>
    </form>
    <!-- Garis pemisah horizontal dekoratif -->
    <hr class="my-4">
    <!-- Area navigasi kaki untuk mengarahkan pengguna lama kembali ke form login -->
    <p class="auth-bottom text-center">
        Sudah punya akun? <a href="index.php">Login sekarang</a>
    </p>
</main>

<!-- Blok kode instruksi pemrograman client-side JavaScript -->
<script>
// Memastikan seluruh elemen DOM HTML telah dimuat dengan sempurna sebelum skrip berjalan
document.addEventListener("DOMContentLoaded", function () {
    // 1. Logika Mata untuk Password Utama
    // Membaca referensi element kolom input kata sandi utama
    const passwordInput = document.getElementById("password");
    // Membaca referensi wadah button pengubah tipe input sandi utama
    const togglePassword = document.getElementById("togglePassword");
    // Membaca elemen ikon di dalam tombol sandi utama
    const toggleIcon = document.getElementById("toggleIcon");

    // Melakukan validasi kesiapan objek elemen agar tidak menimbulkan galat javascript
    if (togglePassword && passwordInput && toggleIcon) {
        // Memasang penangkap aktivitas klik pada tombol mata password utama
        togglePassword.addEventListener("click", function (e) {
            // Mencegah perilaku default bawaan browser dari elemen button
            e.preventDefault();
            // Memeriksa jika tipe input saat ini merupakan teks rahasia (password)
            if (passwordInput.type === "password") {
                // Mengubah format input menjadi plain text agar kata sandi terlihat jelas
                passwordInput.type = "text";
                // Mengganti ikon mata terbuka menjadi ikon mata tercoret
                toggleIcon.classList.remove("bi-eye");
                toggleIcon.classList.add("bi-eye-slash");
            } else {
                // Mengembalikan format input menjadi teks bintang tersembunyi (password)
                passwordInput.type = "password";
                // Mengembalikan visualisasi ikon menjadi bentuk mata terbuka normal
                toggleIcon.classList.remove("bi-eye-slash");
                toggleIcon.classList.add("bi-eye");
            }
        });
    }

    // 2. Logika Mata untuk Konfirmasi Password
    // Membaca referensi objek element kolom input konfirmasi kata sandi
    const confirmInput = document.getElementById("confirmPassword");
    // Membaca referensi tombol penukar visibilitas konfirmasi kata sandi
    const toggleConfirm = document.getElementById("toggleConfirmPassword");
    // Membaca elemen ikon penunjuk status mata konfirmasi sandi
    const toggleConfirmIcon = document.getElementById("toggleConfirmIcon");

    // Melakukan validasi kesiapan objek elemen konfirmasi sebelum diproses
    if (toggleConfirm && confirmInput && toggleConfirmIcon) {
        // Memasang pemantau aktivitas klik pada tombol mata konfirmasi password
        toggleConfirm.addEventListener("click", function (e) {
            // Mencegah interaksi default bawaan browser
            e.preventDefault();
            // Mengevaluasi tipe input text kolom konfirmasi kata sandi berjalan
            if (confirmInput.type === "password") {
                // Menyingkap tabir sandi konfirmasi menjadi tulisan biasa
                confirmInput.type = "text";
                // Memperbarui indikator class CSS menjadi ikon mata terbelah
                toggleConfirmIcon.classList.remove("bi-eye");
                toggleConfirmIcon.classList.add("bi-eye-slash");
            } else {
                // Menyembunyikan kembali teks tulisan konfirmasi sandi ke format password
                confirmInput.type = "password";
                // Memulihkan class CSS ikon menjadi bentuk mata normal kembali
                toggleConfirmIcon.classList.remove("bi-eye-slash");
                toggleConfirmIcon.classList.add("bi-eye");
            }
        });
    }
});
</script>
</body>
</html>