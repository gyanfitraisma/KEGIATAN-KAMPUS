<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistem Pendaftaran Kegiatan Kampus</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
    
<body>

    <aside class="sidebar">

        <div class="brand">
            <div class="brand-logo">SK</div>

            <div>
                <h1>Sistem Kampus</h1>
                <p>Pendaftaran Kegiatan</p>
            </div>
        </div>

        <nav class="menu">

            <a href="dashboard.php" class="active">
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

            <a href="edit-data.php">
                <i class="bi bi-pencil"></i>
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

    <main class="content">

        <section class="topbar">

            <div>

                <p class="label">Admin Panel</p>

                <h2>Sistem Pendaftaran Kegiatan Kampus</h2>

                <p class="text-muted">
                    Kelola seluruh kegiatan kampus, data peserta,
                    dan proses pendaftaran dengan mudah.
                </p>

            </div>

            <div class="d-flex gap-2">

                <a href="form-daftar.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i>
                    Daftar Peserta
                </a>

                <a href="kegiatan.php" class="btn btn-outline-primary">
                    <i class="bi bi-calendar-event"></i>
                    Data Kegiatan
                </a>

            </div>

        </section>

        <section class="hero-dashboard mb-4">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <h2 id="sapaan">
                        Selamat Datang, Admin 👋
                    </h2>

                    <p>
                        Kelola seluruh kegiatan kampus dengan lebih mudah.
                        Pantau jumlah peserta, kegiatan aktif,
                        serta aktivitas terbaru secara real-time.
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

        <section class="card-box mb-4">

            <div class="d-flex justify-content-between align-items-center mb-3">

                <h4 class="mb-0">
                    <i class="bi bi-graph-up-arrow text-success"></i>
                    Progress Pendaftaran
                </h4>

                <span class="badge bg-success fs-6">
                    79%
                </span>

            </div>

            <p class="mb-2">
                Kuota peserta telah terisi sebanyak
                <strong>248/312 peserta</strong>
            </p>

            <div class="progress progress-modern">
                <div
                    class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                    style="width:79%">
                    79%
                </div>
            </div>
        </section>

        <section class="row g-3 mb-4">
            <div class="col-md-3">
                <a href="form-daftar.php" class="quick-card text-decoration-none">
                    <i class="bi bi-person-plus-fill"></i>
                    <h5>Tambah Peserta</h5>
                    <p>Daftarkan peserta baru</p>
                </a>
            </div>

            <div class="col-md-3">
                <a href="data-peserta.php" class="quick-card text-decoration-none">
                    <i class="bi bi-people-fill"></i>
                    <h5>Data Peserta</h5>
                    <p>Lihat seluruh peserta</p>
                </a>
            </div>

            <div class="col-md-3">
                <a href="kegiatan.php" class="quick-card text-decoration-none">
                    <i class="bi bi-calendar-event-fill"></i>
                    <h5>Kegiatan</h5>
                    <p>Kelola kegiatan kampus</p>
                </a>
            </div>

            <div class="col-md-3">
                <a href="edit-data.php" class="quick-card text-decoration-none">
                    <i class="bi bi-pencil-square"></i>
                    <h5>Edit Data</h5>
                    <p>Ubah data peserta</p>
                </a>
            </div>
        </section>
        <section class="row g-4 mb-4">

            <div class="col-lg-3 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-calendar-check display-5"></i>
                    <h2 class="counter">8</h2>
                    <p>Kegiatan Aktif</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-people-fill display-5"></i>
                    <h2 class="counter">248</h2>
                    <p>Total Peserta</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-person-check-fill display-5"></i>
                    <h2 class="counter">64</h2>
                    <p>Kuota Tersedia</p>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-award-fill display-5"></i>
                    <h2 class="counter">15</h2>
                    <p>Kegiatan Selesai</p>
                </div>
            </div>
        </section>

        <section class="row g-4">

            <div class="col-lg-7">

                <div class="card-box h-100">

                    <div class="section-title">
                        <h3>
                            <i class="bi bi-megaphone-fill text-primary"></i>
                            Pengumuman
                        </h3>
                        <span>Informasi Terbaru</span>
                    </div>

                    <div class="alert alert-primary">
                        Seminar Karier Digital akan dilaksanakan pada
                        <strong>12 Juli 2026</strong>.
                    </div>

                    <div class="alert alert-success">
                        Workshop UI/UX masih membuka pendaftaran peserta.
                    </div>

                    <div class="alert alert-warning mb-0">
                        Lomba Web Design akan ditutup apabila kuota telah terpenuhi.
                    </div>

                </div>

            </div>

            <div class="col-lg-5">

                <div class="card-box h-100">

                    <div class="section-title">
                        <h3>
                            <i class="bi bi-clock-history text-primary"></i>
                            Aktivitas Terbaru
                        </h3>
                    </div>

                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Jam</th>
                                <th>Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>08.00</td>
                                <td>Admin membuka pendaftaran seminar.</td>
                            </tr>
                            <tr>
                                <td>09.30</td>
                                <td>15 peserta berhasil mendaftar.</td>
                            </tr>
                            <tr>
                                <td>10.45</td>
                                <td>Data peserta berhasil diperbarui.</td>
                            </tr>
                            <tr>
                                <td>11.20</td>
                                <td>Workshop UI/UX ditambahkan.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <footer class="footer-dashboard">
            <p>
                © 2026 Sistem Pendaftaran Kegiatan Kampus
                <br>
                Universitas • Admin Dashboard Version 1.0
            </p>
        </footer>
    </main>

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
</body>
</html>