<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Sistem Kegiatan Kampus aaaaa</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="auth-page">
  <main class="auth-card">
    <div class="auth-logo">SK</div>

    <h1>Login Admin</h1>
    <p class="text-muted">Masuk untuk mengelola pendaftaran kegiatan kampus.</p>

    <form action="#" method="post" class="mt-4">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-person"></i></span>
          <input type="text" name="username" class="form-control" placeholder="Masukkan username">
        </div>
      </div>

      <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
          <span class="input-group-text"><i class="bi bi-lock"></i></span>
          <input type="password" name="password" class="form-control" placeholder="Masukkan password">
        </div>
      </div>

      <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="remember" id="remember">
          <label class="form-check-label" for="remember">Ingat saya</label>
        </div>
        <a href="#" class="auth-link">Lupa password?</a>
      </div>

      <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-box-arrow-in-right"></i> Login
      </button>
    </form>

    <p class="auth-bottom">
      Belum punya akun?
      <a href="register.php">Daftar user</a>
    </p>
  </main>
</body>
</html>


