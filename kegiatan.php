<?php
// Memulai sesi baru atau melanjutkan sesi yang sudah ada di server
session_start();
// Menyertakan file konfigurasi koneksi database
include "koneksi.php";

// Memeriksa apakah pengguna memiliki hak akses (sudah login atau belum)
if (!isset($_SESSION['login'])) {
    // Mengarahkan pengguna ke halaman login utama jika sesi belum terbentuk
    header("Location: index.php");
    // Menghentikan eksekusi skrip selanjutnya demi alasan keamanan data
    exit;
}

// 1. Logika Pencarian
// Menginisialisasi variabel pencarian dengan nilai string kosong default
$search = "";
// Memeriksa apakah tombol atau parameter 'cari' dikirim melalui metode GET
if (isset($_GET['cari'])) {
    // Mengamankan input kata kunci pencarian dari potensi ancaman SQL Injection
    $search = mysqli_real_escape_string($koneksi, $_GET['keyword']);
    // Menjalankan query SQL untuk mencari kegiatan berdasarkan nama atau lokasi yang cocok dengan kata kunci
    $query_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan WHERE nama_kegiatan LIKE '%$search%' OR lokasi LIKE '%$search%' ORDER BY id_kegiatan DESC");
} else {
    // Jika tidak ada pencarian, ambil seluruh data kegiatan dan urutkan dari yang terbaru berdasarkan ID
    $query_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan ORDER BY id_kegiatan DESC");
}

// 2. Hitung Statistik Secara Dinamis dari Database (PERBAIKAN OTOMATIS)
// Menjalankan query SQL untuk menghitung jumlah total baris/record pada tabel kegiatan
$q_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kegiatan");
$d_total = mysqli_fetch_assoc($q_total);
$total_kegiatan = $d_total['total'];

// Hitung Kegiatan Selesai secara dinamis (Tanggal kurang dari hari ini)
$q_selesai = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kegiatan WHERE tanggal < CURDATE()");
$d_selesai = mysqli_fetch_assoc($q_selesai);
$selesai = $d_selesai['total'];

// Hitung Kegiatan Akan Datang secara dinamis (Tanggal lebih dari hari ini)
$q_datang = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kegiatan WHERE tanggal > CURDATE()");
$d_datang = mysqli_fetch_assoc($q_datang);
$akan_datang = $d_datang['total'];

// Kegiatan Aktif (Total kegiatan dikurangi yang sudah selesai)
$kegiatan_aktif = $total_kegiatan - $selesai;
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

    <!-- Elemen pembungkus menu navigasi utama di bagian samping halaman -->
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
            <a href="kegiatan.php" class="active"><i class="bi bi-calendar-event"></i> Data Kegiatan</a>
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </nav>
    </aside>

    <!-- Area utama pembungkus seluruh informasi dan tabel dinamis pada halaman ini -->
    <main class="content">
        
        <!-- Topbar Identitas Halaman -->
        <section class="topbar mb-3">
            <div>
                <p class="label">Data Kegiatan</p>
                <h2>Daftar & Jadwal Kegiatan Kampus</h2>
                <p class="text-muted">
                    Atur jadwal agenda, kelola kuota pendaftaran, lokasi, serta status operasional kegiatan mahasiswa.
                </p>
            </div>
        </section>
        
        <!-- Banner Atas -->
        <section class="hero-dashboard mb-4" style="background: linear-gradient(135deg, #1d72b8 0%, #34a853 100%); color: white; padding: 30px; border-radius: 15px;">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2><i class="bi bi-calendar2-range"></i> Data Kegiatan Kampus</h2>
                    <p class="mb-0">Halaman ini digunakan untuk mengelola seluruh kegiatan kampus yang sedang berlangsung maupun yang akan datang.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="hero-time">
                        <h3 id="jam">00:00:00</h3>
                        <span id="tanggal">Senin, 1 Januari 2026</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kartu Statistik (Sudah Otomatis & Dinamis) -->
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

            <!-- Form Pencarian (PERBAIKAN ATRIBUT ACTION & TOMBOL RESET) -->
            <form method="GET" action="kegiatan.php" class="row g-2 mb-4">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="keyword" class="form-control" placeholder="Cari nama kegiatan..." value="<?= htmlspecialchars($search); ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" name="cari" class="btn btn-primary w-100">Cari</button>
                </div>
                <div class="col-md-2">
                    <?php if (isset($_GET['cari']) && $_GET['keyword'] != ""): ?>
                        <a href="kegiatan.php" class="btn btn-secondary w-100">Reset</a>
                    <?php else: ?>
                        <button type="button" class="btn btn-secondary w-100" disabled>Reset</button>
                    <?php endif; ?>
                </div>
            </form>

            <!-- Wadah penampung responsif agar tabel tetap rapi -->
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
                        if (mysqli_num_rows($query_kegiatan) > 0) {
                            while($row = mysqli_fetch_assoc($query_kegiatan)) { 
                                $kode = "KG" . str_pad($row['id_kegiatan'], 3, "0", STR_PAD_LEFT);
                            ?>
                            <tr>
                                <td><strong><?= $kode; ?></strong></td>
                                <td><?= htmlspecialchars($row['nama_kegiatan']); ?></td>
                                <td><?= date('d M Y', strtotime($row['tanggal'])); ?></td>
                                <td><?= htmlspecialchars($row['lokasi']); ?></td>
                                <td><?= isset($row['kuota']) ? $row['kuota'] : '100'; ?></td>
                                <td>
                                    <!-- LOGIKA PHP STATUS DINAMIS BERDASARKAN TANGGAL HARI INI -->
                                    <?php 
                                    $tgl_kegiatan = date('Y-m-d', strtotime($row['tanggal']));
                                    $tgl_sekarang = date('Y-m-d');

                                    if ($tgl_kegiatan < $tgl_sekarang) {
                                        echo '<span class="badge bg-danger" style="border-radius: 50px; padding: 5px 15px;">Selesai</span>';
                                    } elseif ($tgl_kegiatan == $tgl_sekarang) {
                                        echo '<span class="badge bg-primary" style="border-radius: 50px; padding: 5px 15px;">Berlangsung</span>';
                                    } else {
                                        echo '<span class="badge bg-success" style="border-radius: 50px; padding: 5px 15px;">Dibuka</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                            <?php 
                            } 
                        } else {
                            echo '<tr><td colspan="6" class="text-center text-muted py-4">Data kegiatan yang kamu cari tidak ditemukan.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    function updateJam() {
        const sekarang = new Date();
        document.getElementById("jam").innerHTML = sekarang.toLocaleTimeString("id-ID");
        document.getElementById("tanggal").innerHTML = broadband = sekarang.toLocaleDateString("id-ID", {
            weekday: "long", day: "numeric", month: "long", year: "numeric"
        });
    }
    setInterval(updateJam, 1000);
    updateJam();
    </script>
</body>
</html>