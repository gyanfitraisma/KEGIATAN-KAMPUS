<?php
include 'koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = $_POST['nama_lengkap'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_hp'];
    $password = $_POST['password'];
    $konfirmasi = $_POST['konfirmasi_password'];
    $role = $_POST['role'];
    $status = $_POST['status'];

    // Cek password
    if ($password != $konfirmasi) {
        echo "<script>alert('Konfirmasi password tidak sesuai!');</script>";
    } else {

        $query = "INSERT INTO user_akses
        (nama_lengkap, username, email, no_hp, password, role, status)
        VALUES
        ('$nama','$username','$email','$no_hp','$password','$role','$status')";

        if (mysqli_query($conn, $query)) {
            echo "<script>
                    alert('Registrasi berhasil!');
                    window.location='index.php';
                  </script>";
        } else {
            echo "<script>alert('Registrasi gagal!');</script>";
        }

    }
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Register - Sistem Kegiatan Kampus</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body class="auth-page">
  <main class="auth-card auth-card-wide">
    <div class="auth-logo">SK</div>

    <h1>Register User</h1>
    <p class="text-muted">Buat akun admin atau panitia kegiatan kampus.</p>

    <form action="#" method="post" class="row g-3 mt-2">
      <div class="col-md-6">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap">
      </div>

      <div class="col-md-6">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" placeholder="Masukkan username">
      </div>

      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" placeholder="nama@email.com">
      </div>

      <div class="col-md-6">
        <label class="form-label">No. HP</label>
        <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx">
      </div>

      <div class="col-md-6">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Masukkan password">
      </div>

      <div class="col-md-6">
        <label class="form-label">Konfirmasi Password</label>
        <input type="password" name="konfirmasi_password" class="form-control" placeholder="Ulangi password">
      </div>

      <div class="col-md-6">
        <label class="form-label">Role User</label>
        <select name="role" class="form-select">
          <option value="">Pilih role</option>
          <option value="admin">Admin</option>
          <option value="panitia">Panitia</option>
        </select>
      </div>

      <div class="col-md-6">
        <label class="form-label">Status Akun</label>
        <select name="status" class="form-select">
          <option value="aktif">Aktif</option>
          <option value="nonaktif">Nonaktif</option>
        </select>
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-person-plus"></i> Daftar User
        </button>
      </div>
    </form>

    <p class="auth-bottom">
      Sudah punya akun?
      <a href="index.php">Login sekarang</a>
    </p>
  </main>
</body>
</html>