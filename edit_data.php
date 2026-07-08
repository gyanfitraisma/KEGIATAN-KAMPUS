<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">
    <title>Edit Data Peserta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet"
          href="assets/css/style.css">
</head>
    
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-logo">
                SK
            </div>
            <div>
                <h1>Sistem Kampus</h1>
                <p>Pendaftaran Kegiatan</p>
            </div>
        </div>
        <nav class="menu">
            <a href="dashboard.php">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>
            <a href="form-daftar.php">
                <i class="bi bi-pencil-square"></i>
                Form Pendaftaran
            </a>
            <a href="data-peserta.php">
                <i class="bi bi-people"></i>
                Data Peserta
            </a>
            <a href="edit-data.php"
               class="active">
                <i class="bi bi-pencil-square"></i>
                Edit Peserta
            </a>
            <a href="kegiatan.php">
                <i class="bi bi-calendar-event"></i>
                Data Kegiatan
            </a>
            <a href="index.php">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        </nav>
    </aside>
    <!-- Content -->
    <main class="content">
        <section class="topbar">
            <div>
                <p class="label">
                    Edit Peserta
                </p>
                <h2>
                    Perbarui Data Peserta
                </h2>
                <p class="text-muted">
                    Halaman ini digunakan untuk mengubah data peserta
                    yang telah melakukan pendaftaran.
                </p>
            </div>
        </section>
        <!-- HERO -->
        <section class="hero-dashboard mb-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2>
                        ✏️ Edit Data Peserta
                    </h2>
                    <p>
                        Lakukan perubahan data peserta apabila terdapat
                        kesalahan informasi ataupun perubahan status
                        pendaftaran.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="hero-time">
                        <h3 id="jam">
                            00:00:00
                        </h3>
                        <span id="tanggal">
                            Senin, 1 Januari 2026
                        </span>
                    </div>
                </div>
            </div>
        </section>
        <!-- FORM -->
        <section class="card-box mb-4">
            <div class="section-title">
                <h3>
                    <i class="bi bi-pencil-square text-primary"></i>
                    Edit Informasi Peserta
                </h3>
                <span>
                    Perbarui data
                </span>
            </div>
            <form class="row g-4">
              <!-- Nama Lengkap -->
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-person-fill text-primary"></i>
                        Nama Lengkap
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        value="Aulia Rahma"
                        placeholder="Masukkan nama lengkap">
                </div>
                <!-- NIM -->
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-credit-card-fill text-primary"></i>
                        NIM
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        value="231001001"
                        placeholder="Masukkan NIM">
                </div>
                <!-- Program Studi -->
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-mortarboard-fill text-primary"></i>
                        Program Studi
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        value="Pendidikan Teknologi Informasi">
                </div>
                <!-- Semester -->
                <div class="col-md-3">
                    <label class="form-label">
                        <i class="bi bi-book-fill text-primary"></i>
                        Semester
                    </label>
                    <select class="form-select">
                        <option>1</option>
                        <option>2</option>
                        <option selected>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>
                    </select>
                </div>
                <!-- Nomor HP -->
                <div class="col-md-3">
                    <label class="form-label">
                        <i class="bi bi-phone-fill text-primary"></i>
                        Nomor HP
                    </label>
                    <input
                        type="text"
                        class="form-control"
                        value="082312345678">
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
                        value="aulia@gmail.com">
                </div>
                <!-- Kegiatan -->
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-calendar-event-fill text-primary"></i>
                        Kegiatan
                    </label>
                    <select class="form-select">
                        <option>Seminar Karier Digital</option>
                        <option selected>
                            Workshop UI / UX
                        </option>
                        <option>
                            Lomba Web Design
                        </option>
                        <option>
                            Seminar Artificial Intelligence
                        </option>
                    </select>
                </div>
                <!-- Status -->
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-check-circle-fill text-primary"></i>
                        Status Peserta
                    </label>
                    <select class="form-select">
                        <option selected>Terdaftar</option>
                        <option>Hadir</option>
                        <option>Batal</option>
                    </select>
                </div>
                <!-- Alamat -->
                <div class="col-12">
                    <label class="form-label">
                        <i class="bi bi-geo-alt-fill text-primary"></i>
                        Alamat
                    </label>
                    <textarea
                        class="form-control"
                        rows="4">Jl. Teuku Umar No. 12, Banda Aceh</textarea>
                </div>
                <!-- Upload Foto -->
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-image-fill text-primary"></i>
                        Foto Peserta
                    </label>
                    <input
                        type="file"
                        class="form-control"
                        accept="image/*">
                </div>
                <!-- Jenis Kelamin -->
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-gender-ambiguous text-primary"></i>
                        Jenis Kelamin
                    </label>
                    <select class="form-select">
                        <option>Laki-laki</option>
                        <option selected>Perempuan</option>
                    </select>
                </div>
                <!-- Status Saat Ini -->
                <div class="col-12">
                    <div class="alert alert-info d-flex align-items-center">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Status saat ini :
                        <span class="badge bg-success ms-2">
                            Terdaftar
                        </span>
                    </div>
                </div>
                <!-- Tombol -->
                <div class="col-12 mt-3">
                    <button
                        type="submit"
                        class="btn btn-primary me-2">
                        <i class="bi bi-save-fill"></i>
                        Update Data
                    </button>
                    <button
                        type="reset"
                        class="btn btn-outline-secondary me-2">
                        <i class="bi bi-arrow-clockwise"></i>
                        Reset
                    </button>
                    <a
                        href="data-peserta.html"
                        class="btn btn-success">
                        <i class="bi bi-arrow-left-circle"></i>
                        Kembali
                    </a>
                </div>
            </form>
        </section>
        <!-- Footer -->
        <footer class="footer">
            <p>
                © 2026 Sistem Pendaftaran Kegiatan Kampus
                <br>
                Dibuat untuk memenuhi tugas Pemrograman Web.
            </p>
        </footer>
    </main>
    <!-- Script Jam -->
  <script>
    function updateJam(){
        const sekarang = new Date();

        document.getElementById("jam").innerHTML =
            sekarang.toLocaleTimeString("id-ID");

        document.getElementById("tanggal").innerHTML =
            sekarang.toLocaleDateString("id-ID",{
                weekday:"long",
                day:"numeric",
                month:"long",
                year:"numeric"
            });
    }
    setInterval(updateJam,1000);
    updateJam();
    </script>