<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
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
    <h1>
        Register User
    </h1>
    <p class="text-muted">
        Silakan lengkapi data untuk membuat akun Admin ataupun Panitia.
    </p>
    <div class="alert alert-info mt-3">
        <i class="bi bi-info-circle-fill"></i>
        Pastikan seluruh data yang diinput sudah benar sebelum membuat akun.
    </div>
    <form class="row g-4 mt-2">
      <!-- Nama -->
        <div class="col-md-6">
            <label class="form-label">
                <i class="bi bi-person-fill text-primary"></i>
                Nama Lengkap
            </label>
            <input
                type="text"
                class="form-control"
                placeholder="Masukkan nama lengkap">
        </div>
        <!-- Username -->
        <div class="col-md-6">
            <label class="form-label">
                <i class="bi bi-at text-primary"></i>
                Username
            </label>
            <input
                type="text"
                class="form-control"
                placeholder="Masukkan username">
        </div>
        <!-- Email -->
        <div class="col-md-6">
            <label class="form-label">
                <i class="bi bi-envelope-fill text-primary"></i>
                Email
            </label>
            <input
                type="email"
                class="form-control"
                placeholder="contoh@email.com">
        </div>
        <!-- No HP -->
        <div class="col-md-6">
            <label class="form-label">
                <i class="bi bi-telephone-fill text-primary"></i>
                Nomor HP
            </label>
            <input
                type="text"
                class="form-control"
                placeholder="08xxxxxxxxxx">
        </div>
        <!-- Password -->
        <div class="col-md-6">
            <label class="form-label">
                <i class="bi bi-lock-fill text-primary"></i>
                Password
            </label>
            <div class="input-group">
                <input
                    type="password"
                    class="form-control"
                    placeholder="Masukkan password">
                <span class="input-group-text">
                    <i class="bi bi-eye"></i>
                </span>
            </div>
        </div>
        <!-- Konfirmasi -->
        <div class="col-md-6">
            <label class="form-label">
                <i class="bi bi-shield-lock-fill text-primary"></i>
                Konfirmasi Password
            </label>
            <div class="input-group">
                <input
                    type="password"
                    class="form-control"
                    placeholder="Ulangi password">
                <span class="input-group-text">
                    <i class="bi bi-eye"></i>
                </span>
            </div>
        </div>
        <!-- Role -->
        <div class="col-md-6">
            <label class="form-label">
                <i class="bi bi-person-workspace text-primary"></i>
                Role User
            </label>
            <select class="form-select">
                <option>Pilih Role</option>
                <option>Admin</option>
                <option>Panitia</option>
            </select>
        </div>
        <!-- Status -->
        <div class="col-md-6">
            <label class="form-label">
                <i class="bi bi-check-circle-fill text-primary"></i>
                Status Akun
            </label>
            <select class="form-select">
                <option>Aktif</option>
                <option>Nonaktif</option>
            </select>
        </div>
        <!-- Checklist -->
        <div class="col-12">
            <div class="form-check">
                <input
                    class="form-check-input"
                    type="checkbox"
                    id="cek">
                <label
                    class="form-check-label"
                    for="cek">
                    Saya menyatakan bahwa data yang saya masukkan sudah benar.
                </label>
            </div>
        </div>
        <!-- Tombol -->
        <div class="col-12 d-flex gap-3">
            <button
                type="submit"
                class="btn btn-primary flex-fill">
                <i class="bi bi-person-plus-fill"></i>
                Daftar User
            </button>
            <button
                type="reset"
                class="btn btn-outline-secondary flex-fill">
                <i class="bi bi-arrow-clockwise"></i>
                Reset
            </button>
        </div>
    </form>
    <hr class="my-4">
    <p class="auth-bottom">
        Sudah punya akun?
        <a href="index.html">
            Login sekarang
        </a>
    </p>
</main>
<script src="java/js/register.js"></script>
</body>
