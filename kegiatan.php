<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kegiatan - Sistem Pendaftaran Kegiatan Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
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
            <a href="dashboard.html">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>
            <a href="form-daftar.html">
                <i class="bi bi-pencil-square"></i>
                Form Pendaftaran
            </a>
            <a href="data-peserta.html">
                <i class="bi bi-people"></i>
                Data Peserta
            </a>
            <a href="edit-data.html">
                <i class="bi bi-pencil"></i>
                Edit Peserta
            </a>
            <a href="kegiatan.html" class="active">
                <i class="bi bi-calendar-event"></i>
                Data Kegiatan
            </a>
            <a href="index.html">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>
        </nav>
    </aside>
    <!-- Content -->
    <main class="content">
        <!-- Header -->
        <section class="topbar">
            <div>
                <p class="label">
                    Admin Panel
                </p>
                <h2>
                    Data Kegiatan Kampus
                </h2>
                <p class="text-muted">
                    Kelola seluruh kegiatan kampus, jadwal pelaksanaan,
                    kuota peserta, dan status kegiatan.
                </p>
            </div>
            <a href="#" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i>
                Tambah Kegiatan
            </a>
        </section>
        <!-- ================= HERO KEGIATAN ================= -->
        <section class="hero-dashboard mb-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2>
                        📅 Data Kegiatan Kampus
                    </h2>
                    <p>
                        Halaman ini digunakan untuk mengelola seluruh kegiatan
                        kampus yang sedang berlangsung maupun yang akan datang.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <h3 id="jam">00:00:00</h3>
                    <span id="tanggal">
                        Senin, 1 Januari 2026
                    </span>
                </div>
            </div>
        </section>
        <!-- ================= CARD STATISTIK ================= -->
        <section class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-calendar-event display-5 text-primary"></i>
                    <h2>8</h2>
                    <p>Total Kegiatan</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-check-circle-fill display-5 text-success"></i>
                    <h2>5</h2>
                    <p>Kegiatan Aktif</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-hourglass-split display-5 text-warning"></i>
                    <h2>2</h2>
                    <p>Akan Datang</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-flag-fill display-5 text-danger"></i>
                    <h2>1</h2>
                    <p>Selesai</p>
                </div>
            </div>
        </section>
        <!-- ================= DATA KEGIATAN ================= -->
        <section class="card-box">
            <div class="section-title">
                <h3>
                    <i class="bi bi-calendar2-week-fill text-primary"></i>
                    Daftar Kegiatan
                </h3>
                <span>Semester Genap 2026</span>
            </div>
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Cari nama kegiatan...">
                    </div>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Lokasi</th>
                            <th>Kuota</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>KG001</td>
                            <td>Seminar Karier Digital</td>
                            <td>12 Juli 2026</td>
                            <td>Aula Kampus</td>
                            <td>100</td>
                            <td>
                                <span class="badge bg-success">
                                    Dibuka
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>KG002</td>
                            <td>Workshop UI/UX</td>
                            <td>18 Juli 2026</td>
                            <td>Lab Multimedia</td>
                            <td>40</td>
                            <td>
                                <span class="badge bg-warning text-dark">
                                    Terbatas
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>KG003</td>
                            <td>Lomba Web Design</td>
                            <td>25 Juli 2026</td>
                            <td>Gedung ICT</td>
                            <td>60</td>
                            <td>
                                <span class="badge bg-danger">
                                    Hampir Penuh
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>KG004</td>
                            <td>Pelatihan Public Speaking</td>
                            <td>30 Juli 2026</td>
                            <td>Aula Serbaguna</td>
                            <td>80</td>
                            <td>
                                <span class="badge bg-primary">
                                    Akan Datang
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <!-- ================= FOOTER ================= -->
    <footer class="footer-dashboard">
        <p>
            © 2026 Sistem Pendaftaran Kegiatan Kampus |
            Universitas Islam Negeri Ar-Raniry Banda Aceh
        </p>
    </footer>
    <!-- ================= JAVASCRIPT ================= -->
    <script>
        function updateJam() {
            const sekarang = new Date();
            document.getElementById("jam").innerHTML =
                sekarang.toLocaleTimeString("id-ID");
            document.getElementById("tanggal").innerHTML =
                sekarang.toLocaleDateString("id-ID", {
                    weekday: "long",
                    day: "numeric",
                    month: "long",
                    year: "numeric"
                });
        }
        setInterval(updateJam, 1000);
        updateJam();
    </script>
</body>
</html>
