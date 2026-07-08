<?php
// Hubungkan ke file koneksi database
include 'koneksi.php';

// 1. Query untuk mengambil total statistik kegiatan
$query_total = mysqli_query($db, "SELECT COUNT(*) as total FROM kegiatan");
$total_kegiatan = mysqli_fetch_assoc($query_total)['total'];

$query_aktif = mysqli_query($db, "SELECT COUNT(*) as total FROM kegiatan WHERE status = 'Dibuka' OR status = 'Terbatas'");
$kegiatan_aktif = mysqli_fetch_assoc($query_aktif)['total'];

$query_mendatang = mysqli_query($db, "SELECT COUNT(*) as total FROM kegiatan WHERE status = 'Akan Datang'");
$kegiatan_mendatang = mysqli_fetch_assoc($query_mendatang)['total'];

$query_selesai = mysqli_query($db, "SELECT COUNT(*) as total FROM kegiatan WHERE status = 'Selesai'");
$kegiatan_selesai = mysqli_fetch_assoc($query_selesai)['total'];

// 2. Logika Pencarian & Pengambilan Data Tabel
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($db, $_GET['search']);
    $query_tabel = mysqli_query($db, "SELECT * FROM kegiatan WHERE nama_kegiatan LIKE '%$search%' ORDER BY tanggal ASC");
} else {
    $query_tabel = mysqli_query($db, "SELECT * FROM kegiatan ORDER BY tanggal ASC");
}

// Fungsi bantu untuk format tanggal Indonesia
function formatTanggalIndo($date) {
    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];
    $split = explode('-', $date);
    return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
}
?>
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
            <div class="brand-logo">SK</div>
            <div>
                <h1>Sistem Kampus</h1>
                <p>Pendaftaran Kegiatan</p>
            </div>
        </div>
        <nav class="menu">
            <a href="dashboard.php">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="form-daftar.php">
                <i class="bi bi-pencil-square"></i> Form Pendaftaran
            </a>
            <a href="data-peserta.php">
                <i class="bi bi-people"></i> Data Peserta
            </a>
            <a href="edit-data.php">
                <i class="bi bi-pencil"></i> Edit Peserta
            </a>
            <a href="kegiatan.php" class="active">
                <i class="bi bi-calendar-event"></i> Data Kegiatan
            </a>
            <a href="index.php">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </nav>
    </aside>

    <!-- Content -->
    <main class="content">
        <!-- Header -->
        <section class="topbar">
            <div>
                <p class="label">Admin Panel</p>
                <h2>Data Kegiatan Kampus</h2>
                <p class="text-muted">
                    Kelola seluruh kegiatan kampus, jadwal pelaksanaan, kuota peserta, dan status kegiatan.
                </p>
            </div>
            <a href="tambah-kegiatan.php" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Kegiatan
            </a>
        </section>

        <!-- ================= HERO KEGIATAN ================= -->
        <section class="hero-dashboard mb-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2>📅 Data Kegiatan Kampus</h2>
                    <p>
                        Halaman ini digunakan untuk mengelola seluruh kegiatan kampus yang sedang berlangsung maupun yang akan datang.
                    </p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <h3 id="jam">00:00:00</h3>
                    <span id="tanggal">Senin, 1 Januari 2026</span>
                </div>
            </div>
        </section>

        <!-- ================= CARD STATISTIK ================= -->
        <section class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-calendar-event display-5 text-primary"></i>
                    <h2><?= $total_kegiatan; ?></h2>
                    <p>Total Kegiatan</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-check-circle-fill display-5 text-success"></i>
                    <h2><?= $kegiatan_aktif; ?></h2>
                    <p>Kegiatan Aktif</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-hourglass-split display-5 text-warning"></i>
                    <h2><?= $kegiatan_mendatang; ?></h2>
                    <p>Akan Datang</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-card text-center">
                    <i class="bi bi-flag-fill display-5 text-danger"></i>
                    <h2><?= $kegiatan_selesai; ?></h2>
                    <p>Selesai</p>
                </div>
            </div>
        </section>

        <!-- ================= DATA KEGIATAN ================= -->
        <section class="card-box">
            <div class="section-title">
                <h3>
                    <i class="bi bi-calendar2-week-fill text-primary"></i> Daftar Kegiatan
                </h3>
                <span>Semester Genap 2026</span>
            </div>
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="kegiatan.php" method="GET">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" name="search" class="form-control" placeholder="Cari nama kegiatan..." value="<?= htmlspecialchars($search); ?>">
                            <button type="submit" class="btn btn-outline-primary">Cari</button>
                            <?php if(!empty($search)): ?>
                                <a href="kegiatan.php" class="btn btn-outline-secondary">Reset</a>
                            <?php endif; ?>
                        </div>
                    </form>
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
                        <?php 
                        if (mysqli_num_rows($query_tabel) > 0) {
                            while ($row = mysqli_fetch_assoc($query_tabel)) {
                                // Menentukan warna badge berdasarkan status dari DB
                                $badge_class = "bg-secondary";
                                if ($row['status'] == 'Dibuka') {
                                    $badge_class = "bg-success";
                                } elseif ($row['status'] == 'Terbatas') {
                                    $badge_class = "bg-warning text-dark";
                                } elseif ($row['status'] == 'Hampir Penuh') {
                                    $badge_class = "bg-danger";
                                } elseif ($row['status'] == 'Akan Datang') {
                                    $badge_class = "bg-primary";
                                }
                        ?>
                                <tr>
                                    <td><?= $row['kode_kegiatan']; ?></td>
                                    <td><?= htmlspecialchars($row['nama_kegiatan']); ?></td>
                                    <td><?= formatTanggalIndo($row['tanggal']); ?></td>
                                    <td><?= htmlspecialchars($row['lokasi']); ?></td>
                                    <td><?= $row['kuota']; ?></td>
                                    <td>
                                        <span class="badge <?= $badge_class; ?>">
                                            <?= $row['status']; ?>
                                        </span>
                                    </td>
                                </tr>
                        <?php 
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center text-muted'>Tidak ada data kegiatan ditemukan.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

        <!-- ================= FOOTER ================= -->
        <footer class="footer-dashboard">
            <p>© 2026 Sistem Pendaftaran Kegiatan Kampus | Universitas Islam Negeri Ar-Raniry Banda Aceh</p>
        </footer>
    </main>

    <!-- ================= JAVASCRIPT ================= -->
    <script>
    function updateJam(){
        const sekarang = new Date();
        document.getElementById("jam").innerHTML = sekarang.toLocaleTimeString("id-ID");
        document.getElementById("tanggal").innerHTML = sekarang.toLocaleDateString("id-ID",{
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