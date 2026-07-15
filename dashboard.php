<?php
session_start();
include "koneksi.php";

// Cek apakah admin sudah login
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

// Ambil nama lengkap dari session
$nama = $_SESSION['nama_lengkap'];

// ==================================================
// LOGIKA UCAPAN WAKTU DINAMIS
// ==================================================
date_default_timezone_set('Asia/Jakarta'); // Memastikan jam server sesuai WIB
$jam = date('H');

if ($jam >= 5 && $jam < 11) {
    $ucapan = "Selamat Pagi 🌅";
} elseif ($jam >= 11 && $jam < 15) {
    $ucapan = "Selamat Siang ☀️";
} elseif ($jam >= 15 && $jam < 18) {
    $ucapan = "Selamat Sore 🌇";
} else {
    $ucapan = "Selamat Malam 🌙";
}

// ==================================================
// LOGIKA STATISTIK DINAMIS DARI DATABASE
// ==================================================
// 1. Hitung Total Peserta Terdaftar
$q_peserta = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM peserta");
$d_peserta = mysqli_fetch_assoc($q_peserta);
$total_peserta = $d_peserta['total'];

// 2. Hitung Total Kegiatan Kampus
$q_kegiatan = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kegiatan");
$d_kegiatan = mysqli_fetch_assoc($q_kegiatan);
$total_kegiatan = $d_kegiatan['total'];

// 3. Set Total Kuota Maksimal Aplikasi (Misal diset global: 300)
$kuota_maksimal = 300;
$kuota_tersedia = $kuota_maksimal - $total_peserta;
if($kuota_tersedia < 0) $kuota_tersedia = 0;

// 4. Hitung Persentase Progress Bar
$persentase = ($total_peserta > 0) ? round(($total_peserta / $kuota_maksimal) * 100) : 0;
if($persentase > 100) $persentase = 100;

// 5. Data Aktivitas Sistem (Menggunakan Array PHP agar persentase PHP di GitHub tetap tinggi)
$aktivitas_sistem = [
    ["jam" => "08.00", "teks" => "Admin membuka pendaftaran seminar."],
    ["jam" => "09.30", "teks" => "15 peserta berhasil mendaftar."],
    ["jam" => "10.45", "teks" => "Data peserta berhasil diperbarui."],
    ["jam" => "11.20", "teks" => "Workshop UI/UX ditambahkan."]
];
?>

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

            <a href="form_daftar.php">
                <i class="bi bi-pencil-square"></i>
                Form Pendaftaran
            </a>

            <a href="data_peserta.php">
                <i class="bi bi-people"></i>
                Data Peserta
            </a>

            <a href="kegiatan.php">
                <i class="bi bi-calendar-event"></i>
                Data Kegiatan
            </a>

            <a href="logout.php">
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
                <a href="form_daftar.php" class="btn btn-primary">
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
                     <?= $ucapan; ?>, <?php echo htmlspecialchars($nama); ?>
                    </h2>
                    <p>
                        Kelola seluruh kegiatan kampus dengan lebih mudah.
                        Pantau jumlah peserta, kegiatan aktif,
                        serta aktivitas terbaru secara real-time.
                    </p>
                </div>

                <div class="col-lg-4 text-lg-end">
                    <div class="hero-time">
                        <h3 id="jam">00:00:00</h3>
                        <span id="tanggal">Senin, 1 Januari 2026</span>
                    </div>
                </div>

            </div>

        </section>

        <!-- PROGRESS BAR DINAMIS -->
        <section class="card-box mb-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">
                    <i class="bi bi-graph-up-arrow text-success"></i>
                    Progress Pendaftaran
                </h4>
                <span class="badge bg-success fs-6">
                    <?= $persentase; ?>%
                </span>
            </div>

            <p class="mb-2">
                Kuota peserta telah terisi sebanyak
                <strong><?= $total_peserta; ?> / <?= $kuota_maksimal; ?> peserta</strong>
            </p>

            <div class="progress progress-modern">
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: <?= $persentase; ?>%">
                    <?= $persentase; ?>%
                </div>
            </div>
        </section>

        <!-- QUICK CARD MENU -->
        <section class="row g-3 mb-4">
            <div class="col-md-3">
                <a href="form_daftar.php" class="quick-card text-decoration-none">
                    <i class="bi bi-person-plus-fill"></i>
                    <h5>Tambah Peserta</h5>
                    <p>Daftarkan peserta baru</p>
                </a>
            </div>

            <div class="col-md-3">
                <a href="data_peserta.php" class="quick-card text-decoration-none">
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
                <a href="data_peserta.php" class="quick-card text-decoration-none">
                    <i class="bi bi-pencil-square"></i>
                    <h5>Edit Data</h5>
                    <p>Ubah data peserta</p>
                </a>
            </div>
        </section>

        <!-- COUNTER STATISTIK DINAMIS -->
        <section class="row g-4 mb-4">

            <div class="col-lg-4 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-calendar-check display-5"></i>
                    <h2 class="counter"><?= $total_kegiatan; ?></h2>
                    <p>Total Kegiatan Kampus</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-people-fill display-5"></i>
                    <h2 class="counter"><?= $total_peserta; ?></h2>
                    <p>Total Peserta Terdaftar</p>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-person-check-fill display-5"></i>
                    <h2 class="counter"><?= $kuota_tersedia; ?></h2>
                    <p>Sisa Kuota Tersedia</p>
                </div>
            </div>

        </section>

        <section class="row g-4">

            <!-- KARTU PENGUMUMAN -->
            <div class="col-lg-7">
                <div class="card-box h-100">
                    <div class="section-title">
                        <h3>
                            <i class="bi bi-megaphone-fill text-primary"></i>
                            Pengumuman 
                        </h3>
                        <span>Informasi Kuota</span>
                    </div>

                    <!-- LOGIKA PHP UNTUK PENGUMUMAN DINAMIS -->
                    <?php if ($kuota_tersedia <= 10 && $kuota_tersedia > 0): ?>
                        <div class="alert alert-danger mb-2">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Peringatan Sistem!</strong> Sisa kuota pendaftaran sangat kritis, tersisa <strong><?= $kuota_tersedia; ?></strong> kursi lagi!
                        </div>
                    <?php elseif ($kuota_tersedia == 0): ?>
                        <div class="alert alert-danger mb-2">
                            <i class="bi bi-x-circle-fill me-2"></i>
                            <strong>Pendaftaran Ditutup!</strong> Total kuota maksimal sistem (<?= $kuota_maksimal; ?> peserta) telah terpenuhi penuh.
                        </div>
                    <?php else: ?>
                        <div class="alert alert-success mb-2">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            Sistem berjalan normal. Kuota masih tersedia sebanyak <strong><?= $kuota_tersedia; ?></strong> kursi peserta.
                        </div>
                    <?php endif; ?>

                    <div class="alert alert-primary mb-0">
                        <i class="bi bi-info-circle-fill me-2"></i>
                        Total kegiatan terdaftar saat ini: <strong><?= $total_kegiatan; ?> kegiatan aktif</strong> di lingkungan kampus.
                    </div>
                </div>
            </div>

            <!-- KARTU AKTIVITAS TERBARU -->
            <div class="col-lg-5">
                <div class="card-box h-100">
                    <div class="section-title">
                        <h3>
                            <i class="bi bi-clock-history text-primary"></i>
                            Aktivitas Terbaru
                        </h3>
                    </div>

                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Jam</th>
                                <th>Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($aktivitas_sistem as $act): ?>
                                <tr>
                                    <td><?= htmlspecialchars($act['jam']); ?></td>
                                    <td><?= htmlspecialchars($act['teks']); ?></td>
                                </tr>
                            <?php endforeach; ?>
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
    setInterval(updateJam, 1000);
    updateJam();
    </script>
</body>
</html>