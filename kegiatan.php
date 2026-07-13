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

// 2.Hitung Statistik Secara Dinamis dari Database
// Menjalankan query SQL untuk menghitung jumlah total baris/record pada tabel kegiatan
$q_total = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kegiatan");
// Mengambil hasil perhitungan query ke dalam bentuk array asosiatif
$d_total = mysqli_fetch_assoc($q_total);
// Menyimpan angka total kegiatan ke dalam variabel penampung
$total_kegiatan = $d_total['total'];

// Untuk contoh, kita samakan kegiatan aktif dengan total kegiatan, sisanya 0 sesuai template aslimu
// Menetapkan jumlah kegiatan aktif sama dengan total kegiatan yang ada saat ini
$kegiatan_aktif = $total_kegiatan; 
// Menetapkan nilai default 0 untuk kategori kegiatan yang akan datang
$akan_datang = 0;
// Menetapkan nilai default 0 untuk kategori kegiatan yang sudah selesai
$selesai = 0;
?>

<!DOCTYPE html>
<!-- Mendeklarasikan tipe dokumen sebagai HTML5 dengan konfigurasi bahasa Indonesia -->
<html lang="id">
<head>
    <!-- Menetapkan sistem pengodean karakter universal dokumen menggunakan UTF-8 -->
    <meta charset="UTF-8">
    <!-- Mengonfigurasi tampilan agar tata letak berskala responsif di semua resolusi layar -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Menentukan judul halaman resmi pada tab browser pengguna -->
    <title>Data Kegiatan - Sistem Pendaftaran</title>
    <!-- Memuat file CSS framework Bootstrap 5 untuk standarisasi layout komponen antarmuka -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Memuat file CSS ikon bawaan dari Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Menyertakan file CSS kustom eksternal untuk gaya tampilan lokal khas dashboard -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Sidebar asli kamu -->
    <!-- Elemen pembungkus menu navigasi utama di bagian samping halaman -->
    <aside class="sidebar">
        <!-- Area identitas dan penjenamaan aplikasi -->
        <div class="brand">
            <!-- Menampilkan simbol inisial aplikasi sebagai logo utama -->
            <div class="brand-logo">SK</div>
            <div>
                <!-- Judul utama pada menu sidebar instansi -->
                <h1>Sistem Kampus</h1>
                <!-- Sub-deskripsi fungsi sistem pada sidebar -->
                <p>Pendaftaran Kegiatan</p>
            </div>
        </div>
        <!-- Kumpulan tautan navigasi antarmuka bagi pengguna admin -->
        <nav class="menu">
            <!-- Tautan untuk berpindah ke halaman utama statistik (Dashboard) -->
            <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <!-- Tautan menuju ke formulir input data peserta baru -->
            <a href="form_daftar.php"><i class="bi bi-pencil-square"></i> Form Pendaftaran</a>
            <!-- Tautan navigasi untuk membuka daftar tabel database peserta -->
            <a href="data_peserta.php"><i class="bi bi-people"></i> Data Peserta</a>
            <!-- Tautan navigasi aktif saat ini yang mengarah ke manajemen data kegiatan -->
            <a href="kegiatan.php" class="active"><i class="bi bi-calendar-event"></i> Data Kegiatan</a>
            <!-- Tautan pengakhiran sesi masuk untuk keluar dari sistem aplikasi secara aman -->
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </nav>
    </aside>

    <!-- Main Content Sesuai Desain Foto Kedua Kamu -->
    <!-- Area utama pembungkus seluruh informasi dan tabel dinamis pada halaman ini -->
    <main class="content">
        
        <!-- Banner Atas -->
        <!-- Bagian kartu hero penyambutan dengan gradasi warna menarik dan sudut melengkung -->
        <section class="hero-dashboard mb-4" style="background: linear-gradient(135deg, #1d72b8 0%, #34a853 100%); color: white; padding: 30px; border-radius: 15px;">
            <div class="row align-items-center">
                <!-- Membagi tata letak kolom banner menjadi ukuran lebar 8 grid pada desktop -->
                <div class="col-md-8">
                    <!-- Judul utama halaman lengkap dengan ikon rentang kalender -->
                    <h2><i class="bi bi-calendar2-range"></i> Data Kegiatan Kampus</h2>
                    <!-- Deskripsi ringkas mengenai hak guna dan fungsi dari modul halaman saat ini -->
                    <p class="mb-0">Halaman ini digunakan untuk mengelola seluruh kegiatan kampus yang sedang berlangsung maupun yang akan datang.</p>
                </div>
            </div>
        </section>

        <!-- Kartu Statistik (Sudah Dinamis) -->
        <!-- Bagian baris yang menampung kartu-kartu metrik informasi statistik data -->
        <section class="row g-3 mb-4">
            <!-- Kartu indikator informasi jumlah total seluruh kegiatan -->
            <div class="col-md-3">
                <div class="card-box text-center p-3">
                    <!-- Menampilkan ikon kalender dengan dekorasi warna primer -->
                    <i class="bi bi-calendar-event text-primary fs-3"></i>
                    <!-- Mencetak angka total kegiatan dinamis dari kalkulasi database -->
                    <h2 class="mt-2 fw-bold"><?= $total_kegiatan; ?></h2>
                    <p class="text-muted mb-0">Total Kegiatan</p>
                </div>
            </div>
            <!-- Kartu indikator informasi jumlah kegiatan berstatus aktif saat ini -->
            <div class="col-md-3">
                <div class="card-box text-center p-3">
                    <!-- Menampilkan ikon lingkaran tercentang berwarna hijau -->
                    <i class="bi bi-check-circle text-success fs-3"></i>
                    <!-- Mencetak variabel jumlah kegiatan berstatus aktif -->
                    <h2 class="mt-2 fw-bold"><?= $kegiatan_aktif; ?></h2>
                    <p class="text-muted mb-0">Kegiatan Aktif</p>
                </div>
            </div>
            <!-- Kartu indikator informasi jumlah kegiatan terjadwal di masa mendatang -->
            <div class="col-md-3">
                <div class="card-box text-center p-3">
                    <!-- Menampilkan ikon jam pasir pertanda waktu tunggu berwarna kuning -->
                    <i class="bi bi-hourglass-split text-warning fs-3"></i>
                    <!-- Mencetak nilai statistik kegiatan yang akan datang -->
                    <h2 class="mt-2 fw-bold"><?= $akan_datang; ?></h2>
                    <p class="text-muted mb-0">Akan Datang</p>
                </div>
            </div>
            <!-- Kartu indikator informasi jumlah seluruh kegiatan yang telah sukses terlaksana -->
            <div class="col-md-3">
                <div class="card-box text-center p-3">
                    <!-- Menampilkan ikon bendera penanda akhir berwarna merah -->
                    <i class="bi bi-flag text-danger fs-3"></i>
                    <!-- Mencetak nilai statistik jumlah kegiatan yang telah selesai -->
                    <h2 class="mt-2 fw-bold"><?= $selesai; ?></h2>
                    <p class="text-muted mb-0">Selesai</p>
                </div>
            </div>
        </section>

        <!-- Tabel Utama -->
        <!-- Kotak kartu pembungkus utama form pencarian dan tabel daftar data -->
        <section class="card-box p-4">
            <!-- Header judul komponen di dalam kotak kartu dengan tata letak horizontal menyebar -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="fw-bold mb-0"><i class="bi bi-calendar-check text-primary"></i> Daftar Kegiatan</h4>
                <!-- Menampilkan teks keterangan tahun akademik berjalan -->
                <span class="text-muted">Semester Genap 2026</span>
            </div>

            <!-- Form Pencarian -->
            <!-- Form pencarian data menggunakan metode GET yang mengarah ke halaman itu sendiri -->
            <form method="GET" action="" class="row g-2 mb-4">
                <!-- Komponen input pencarian dengan lebar porsi 10 grid kisi -->
                <div class="col-md-10">
                    <div class="input-group">
                        <!-- Grup input pendukung berupa ikon kaca pembesar pencarian -->
                        <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                        <!-- Kolom teks pencarian yang menahan nilai pencarian sebelumnya menggunakan htmlspecialchars -->
                        <input type="text" name="keyword" class="form-control" placeholder="Cari nama kegiatan..." value="<?= htmlspecialchars($search); ?>">
                    </div>
                </div>
                <!-- Tombol eksekusi submit formulir pencarian dengan porsi 2 grid kisi -->
                <div class="col-md-2">
                    <button type="submit" name="cari" class="btn btn-primary w-100">Cari</button>
                </div>
            </form>

            <!-- Wadah penampung responsif agar tabel tetap rapi jika diakses dari layar kecil -->
            <div class="table-responsive">
                <!-- Elemen tabel Bootstrap dengan efek sorot baris dan perataan vertikal tengah -->
                <table class="table table-hover align-middle">
                    <!-- Bagian kepala judul kolom tabel dengan latar belakang terang -->
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
                        // Menginisialisasi variabel nomor urut baris data
                        $no = 1;
                        // Melakukan perulangan data baris hasil query dari tabel kegiatan database
                        while($row = mysqli_fetch_assoc($query_kegiatan)) { 
                            // Membuat format kode kustom otomatis (misal: KG001) dengan menambahkan angka 0 di sisi kiri string
                            $kode = "KG" . str_pad($row['id_kegiatan'], 3, "0", STR_PAD_LEFT);
                        ?>
                        <!-- Menampilkan baris data dari database ke dalam baris tabel HTML -->
                        <tr>
                            <!-- Menampilkan string kode kustom yang telah dibuat secara tebal -->
                            <td><strong><?= $kode; ?></strong></td>
                            <!-- Menampilkan nama kegiatan secara aman dengan penyaringan htmlspecialchars -->
                            <td><?= htmlspecialchars($row['nama_kegiatan']); ?></td>
                            <!-- Mengonversi string format tanggal database menjadi tampilan tanggal resmi (Tgl Bln Thn) -->
                            <td><?= date('d M Y', strtotime($row['tanggal'])); ?></td>
                            <!-- Menampilkan nama lokasi atau tempat dilaksanakannya kegiatan secara aman -->
                            <td><?= htmlspecialchars($row['lokasi']); ?></td>
                            <!-- Memeriksa ketersediaan kolom kuota, jika kosong maka akan menampilkan nilai default 100 -->
                            <td><?= isset($row['kuota']) ? $row['kuota'] : '100'; ?></td>
                            <!-- Menampilkan label status pendaftaran kegiatan -->
                            <td>
                                <!-- Label badge Bootstrap berbentuk oval dengan warna latar belakang hijau -->
                                <span class="badge bg-success" style="border-radius: 50px; padding: 5px 15px;">dibuka</span>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </section>

    </main>

    <!-- Memuat bundle JavaScript resmi milik Bootstrap 5 untuk mendukung interaktivitas komponen -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>