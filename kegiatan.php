<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

// 1. Logika Pencarian
$search = "";
if (isset($_GET['cari'])) {
    $search = mysqli_real_escape_string($koneksi, $_GET['keyword']);
    $query_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE nama_kegiatan LIKE '%$search%' OR lokasi LIKE '%$search%' ORDER BY id_kegiatan DESC");
} else {
    $query_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan ORDER BY id_kegiatan DESC");
}

// 2. Hitung Statistik Secara Dinamis dari Database
$q_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kegiatan");
$d_total = mysqli_fetch_assoc($q_total);
$total_kegiatan = $d_total['total'];

// Untuk contoh, kita samakan kegiatan aktif dengan total kegiatan, sisanya 0 sesuai template aslimu
$kegiatan_aktif = $total_kegiatan; 
$akan_datang = 0;
$selesai = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kegiatan - Sistem Pendaftaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Sidebar asli kamu -->
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-logo">SK</div>
            <div>
                <h1>Sistem Kampus</h1>
                <p>Pendaftaran Kegiatan</p>
            </div>
        </div>
        <nav class="menu">
            <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="form_daftar.php"><i class="bi bi-pencil-square"></i> Form Pendaftaran</a>
            <a href="data_peserta.php"><i class="bi bi-people"></i> Data Peserta</a>
            <a href="edit_data.php"><i class="bi bi-pencil"></i> Edit Peserta</a>
            <a href="kegiatan.php" class="active"><i class="bi bi-calendar-event"></i> Data Kegiatan</a>
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </nav>
    </aside>

    <!-- Main Content Sesuai Desain Foto Kedua Kamu -->
    <main class="content">
        
        <!-- Banner Atas -->
        <section class="hero-dashboard mb-4" style="background: linear-gradient(135deg, #1d72b8 0%, #34a853 100%); color: white; padding: 30px; border-radius: 15px;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2><i class="bi bi-calendar2-range"></i> Data Kegiatan Kampus</h2>
                    <p class="mb-0">Halaman ini digunakan untuk mengelola seluruh kegiatan kampus yang sedang berlangsung maupun yang akan datang.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <h3><?= date('H.i'); ?></h3>
                    <span><?= date('l, d F Y'); ?></span>
                </div>
            </div>
        </section>

        <!-- Kartu Statistik (Sudah Dinamis) -->
        <section class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card-box text-center p-3">
                    <i class="bi bi-calendar-event text-primary fs-3"></i>
                    <h2 class="mt-2 fw-bold"><?= $total_kegiatan; ?></h2>
                    <p class="text-muted mb-0">Total Kegiatan</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-box text-center p-3">
                    <i class="bi bi-check-circle text-success fs-3"></i>
                    <h2 class="mt-2 fw-bold"><?= $kegiatan_aktif; ?></h2>
                    <p class="text-muted mb-0">Kegiatan Aktif</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-box text-center p-3">
                    <i class="bi bi-hourglass-split text-warning fs-3"></i>
                    <h2 class="mt-2 fw-bold"><?= $akan_datang; ?></h2>
                    <p class="text-muted mb-0">Akan Datang</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-box text-center p-3">
                    <i class="bi bi-flag text-danger fs-3"></i>
                    <h2 class="mt-2 fw-bold"><?= $selesai; ?></h2>
                    <p class="text-muted mb-0">Selesai</p>
                </div>
            </div>
        </section>

        <!-- Tabel Utama -->
        <section class="card-box p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0"><i class="bi bi-calendar-check text-primary"></i> Daftar Kegiatan</h4>
                <span class="text-muted">Semester Genap 2026</span>
            </div>

            <!-- Form Pencarian -->
            <form method="GET" action="" class="row g-2 mb-4">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="keyword" class="form-control" placeholder="Cari nama kegiatan..." value="<?= htmlspecialchars($search); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="cari" class="btn btn-primary w-100">Cari</button>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>KODE</th>
                            <th>NAMA KEGIATAN</th>
                            <th>TANGGAL</th>
                            <th>LOKASI</th>
                            <th>KUOTA</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        while($row = mysqli_fetch_assoc($query_kegiatan)) { 
                            // Membuat kode otomatis misal KG001, KG002 berdasarkan ID
                            $kode = "KG" . str_pad($row['id_kegiatan'], 3, "0", STR_PAD_LEFT);
                        ?>
                        <tr>
                            <td><strong><?= $kode; ?></strong></td>
                            <td><?= htmlspecialchars($row['nama_kegiatan']); ?></td>
                            <td><?= date('d M Y', strtotime($row['tanggal'])); ?></td>
                            <td><?= htmlspecialchars($row['lokasi']); ?></td>
                            <td><?= isset($row['kuota']) ? $row['kuota'] : '100'; ?></td>
                            <td>
                                <span class="badge bg-success" style="border-radius: 50px; padding: 5px 15px;">dibuka</span>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>