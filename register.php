<?php
include 'koneksi.php';

$pesan_error = "";
$pesan_sukses = "";

// Cek apakah tombol submit (Daftar User) sudah diklik
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form dan amankan dari SQL Injection
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $username     = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email        = mysqli_real_escape_string($koneksi, $_POST['email']);
    $no_hp        = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $password     = $_POST['password'];
    $confirm_pwd  = $_POST['confirm_password'];
    $role_akses   = mysqli_real_escape_string($koneksi, $_POST['role_akses']);
    $status_akun  = mysqli_real_escape_string($koneksi, $_POST['status_akun']);

    // 1. Validasi: Pastikan Password dan Konfirmasi Password cocok
    if ($password !== $confirm_pwd) {
        $pesan_error = "Konfirmasi password tidak cocok!";
    } else {
        // 2. Validasi: Cek apakah username sudah pernah terdaftar
        $cek_username = mysqli_query($koneksi, "SELECT * FROM user_login WHERE username = '$username'");
        
        if (mysqli_num_rows($cek_username) > 0) {
            $pesan_error = "Username sudah digunakan, pilih username lain!";
        } else {
            // Hash password demi keamanan data sebelum disimpan ke database
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);

            // 3. Eksekusi: Masukkan data ke database
            // Sesuaikan nama kolom berikut dengan struktur tabel user di phpMyAdmin kamu
            $query = "INSERT INTO user_login (nama_lengkap, username, email, no_hp, password, role, status) 
                      VALUES ('$nama_lengkap', '$username', '$email', '$no_hp', '$password_hashed', '$role_akses', '$status_akun')";
            
            if (mysqli_query($koneksi, $query)) {
                $pesan_sukses = "Akun berhasil didaftarkan! Mengalihkan ke halaman login...";
                // Redirect otomatis ke halaman login (index.php) setelah 2 detik
                header("refresh:2;url=index.php");
            } else {
                $pesan_error = "Gagal mendaftarkan akun: " . mysqli_error($koneksi);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-page">
<main class="auth-card auth-card-wide">
    <div class="auth-logo">
        <i class="bi bi-person-plus-fill"></i>
    </div>
    <h1>Register User</h1>
    <p class="text-muted">Silakan lengkapi data untuk membuat akun Admin ataupun Panitia.</p>
    
    <!-- Tempat menampilkan notifikasi sukses atau error -->
    <?php if ($pesan_error != ""): ?>
        <div class="alert alert-danger mt-3">
            <i class="bi bi-exclamation-triangle-fill"></i> <?= $pesan_error; ?>
        </div>
    <?php endif; ?>

    <?php if ($pesan_sukses != ""): ?>
        <div class="alert alert-success mt-3">
            <i class="bi bi-check-circle-fill"></i> <?= $pesan_sukses; ?>
        </div>
    <?php endif; ?>

    <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle-fill"></i> Pastikan seluruh data yang diinput sudah benar sebelum membuat akun.
    </div>

    <!-- Menambahkan action kosong (memproses di file ini sendiri) dan method POST -->
    <form action="" method="POST" class="row g-4 mt-2">
        <div class="col-md-6">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap" required value="<?= isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : ''; ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" placeholder="Masukkan username" required value="<?= isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" placeholder="nama@kampus.ac.id" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
        </div>
        <div class="col-md-6">
            <label class="form-label">No. HP</label>
            <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx" required value="<?= isset($_POST['no_hp']) ? htmlspecialchars($_POST['no_hp']) : ''; ?>">
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Password</label>
            <div class="input-group">
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
                <button class="input-group-text" type="button" id="togglePassword" style="cursor: pointer; z-index: 10; pointer-events: auto;">
                     <i class="bi bi-eye" id="toggleIcon"></i>
                </button>
            </div>
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Konfirmasi Password</label>
            <div class="input-group">
                <input type="password" name="confirm_password" id="confirmPassword" class="form-control" placeholder="Ulangi password" required>
                <button class="input-group-text" type="button" id="toggleConfirmPassword" style="cursor: pointer; z-index: 10; pointer-events: auto;">
                     <i class="bi bi-eye" id="toggleConfirmIcon"></i>
                </button>
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Role Akses</label>
            <select name="role_akses" class="form-select">
                <option value="Admin" <?= (isset($_POST['role_akses']) && $_POST['role_akses'] == 'Admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="Panitia" <?= (isset($_POST['role_akses']) && $_POST['role_akses'] == 'Panitia') ? 'selected' : ''; ?>>Panitia</option>
            </select>
        </div>
        <div class="col-md-6">
            <label class="form-label">Status Akun</label>
            <select name="status_akun" class="form-select">
                <option value="Aktif" <?= (isset($_POST['status_akun']) && $_POST['status_akun'] == 'Aktif') ? 'selected' : ''; ?>>Aktif</option>
                <option value="Nonaktif" <?= (isset($_POST['status_akun']) && $_POST['status_akun'] == 'Nonaktif') ? 'selected' : ''; ?>>Nonaktif</option>
            </select>
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="cek" required>
                <label class="form-check-label" for="cek">Saya menyatakan bahwa data yang saya masukkan sudah benar.</label>
            </div>
        </div>
        <div class="col-12 d-flex gap-3">
            <button type="submit" class="btn btn-primary flex-fill"><i class="bi bi-person-plus-fill"></i> Daftar User</button>
            <button type="reset" class="btn btn-outline-secondary flex-fill"><i class="bi bi-arrow-clockwise"></i> Reset</button>
        </div>
    </form>
    <hr class="my-4">
    <p class="auth-bottom text-center">
        Sudah punya akun? <a href="index.php">Login sekarang</a>
    </p>
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // 1. Logika Mata untuk Password Utama
    const passwordInput = document.getElementById("password");
    const togglePassword = document.getElementById("togglePassword");
    const toggleIcon = document.getElementById("toggleIcon");

    if (togglePassword && passwordInput && toggleIcon) {
        togglePassword.addEventListener("click", function (e) {
            e.preventDefault();
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleIcon.classList.remove("bi-eye");
                toggleIcon.classList.add("bi-eye-slash");
            } else {
                passwordInput.type = "password";
                toggleIcon.classList.remove("bi-eye-slash");
                toggleIcon.classList.add("bi-eye");
            }
        });
    }

    // 2. Logika Mata untuk Konfirmasi Password
    const confirmInput = document.getElementById("confirmPassword");
    const toggleConfirm = document.getElementById("toggleConfirmPassword");
    const toggleConfirmIcon = document.getElementById("toggleConfirmIcon");

    if (toggleConfirm && confirmInput && toggleConfirmIcon) {
        toggleConfirm.addEventListener("click", function (e) {
            e.preventDefault();
            if (confirmInput.type === "password") {
                confirmInput.type = "text";
                toggleConfirmIcon.classList.remove("bi-eye");
                toggleConfirmIcon.classList.add("bi-eye-slash");
            } else {
                confirmInput.type = "password";
                toggleConfirmIcon.classList.remove("bi-eye-slash");
                toggleConfirmIcon.classList.add("bi-eye");
            }
        });
    }
});
</script>
</body>
</html>