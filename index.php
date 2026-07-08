<?php
session_start();

// Jika sudah login, langsung ke dashboard
if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}

// Menampilkan pesan error
$error = "";
if (isset($_GET['error'])) {
    $error = "Username atau Password salah!";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Sistem Kegiatan Kampus</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body class="auth-page">

<main class="auth-card">
    <div class="text-center mb-4">
        <div class="auth-logo">
            <i class="bi bi-mortarboard-fill"></i>
        </div>

        <h1 class="fw-bold mt-3">Login Admin</h1>

        <p class="text-muted">
            Selamat datang di <strong>Sistem Pendaftaran Kegiatan Kampus</strong>.<br>
            Silakan login untuk mengelola data kegiatan dan peserta.
        </p>
    </div>

    <!-- Pesan Error -->
    <?php if($error != "") : ?>
        <div class="alert alert-danger">
            <?= $error; ?>
        </div>
    <?php endif; ?>

    <!-- Form Login -->
    <form action="proses_login.php" method="post" class="mt-4">

        <div class="mb-3">
            <label class="form-label">
                <i class="bi bi-person-circle"></i>
                Username
            </label>

            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-person"></i>
                </span>

                <input
                    type="text"
                    name="username"
                    class="form-control"
                    placeholder="Masukkan username"
                    required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">
                <i class="bi bi-lock-fill"></i>
                Password
            </label>

            <div class="input-group">
                <span class="input-group-text">
                    <i class="bi bi-key-fill"></i>
                </span>

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Masukkan password"
                    required>

                <span class="input-group-text" id="togglePassword" style="cursor:pointer;">
                    <i class="bi bi-eye" id="toggleIcon"></i>
                </span>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    id="remember"
                    name="remember">

                <label class="form-check-label" for="remember">
                    Ingat Saya
                </label>
            </div>

            <a href="#" class="auth-link">
                Lupa Password?
            </a>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2">
            <i class="bi bi-box-arrow-in-right"></i>
            Login Sekarang
        </button>

    </form>

    <hr>

    <p class="auth-bottom text-center">
        Belum mempunyai akun?
        <a href="register.html">
            Daftar Sekarang
        </a>
    </p>

    <small class="text-muted d-block text-center mt-3">
        © <?php echo date("Y"); ?> Sistem Pendaftaran Kegiatan Kampus
    </small>

</main>

<script src="java/js/login.js"></script>
</body>
</html>