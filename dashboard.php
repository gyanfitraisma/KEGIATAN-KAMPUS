<?php
// Memulai sesi baru atau melanjutkan sesi yang sudah ada di server
session_start();
// Menyertakan file konfigurasi koneksi database
include "koneksi.php";

// Cek apakah admin sudah login
// Memeriksa variabel sesi login, jika belum diset maka pengguna akan dialihkan
if (!isset($_SESSION['login'])) {
    // Mengarahkan pengguna kembali ke halaman utama (login) jika akses ditolak
    header("Location: index.php");
    // Menghentikan eksekusi skrip selanjutnya demi alasan keamanan
    exit;
}

// Ambil nama lengkap dari session
// Menyimpan nama lengkap pengguna dari data sesi ke dalam variabel lokal
$nama = $_SESSION['nama_lengkap'];

// ==================================================
// LOGIKA STATISTIK DINAMIS DARI DATABASE
// ==================================================
// 1. Hitung Total Peserta Terdaftar
// Menjalankan query SQL untuk menghitung jumlah total baris pada tabel peserta
$q_peserta = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM peserta");
// Mengambil hasil query dalam bentuk array asosiatif
$d_peserta = mysqli_fetch_assoc($q_peserta);
// Menyimpan total nilai jumlah peserta ke dalam variabel
$total_peserta = $d_peserta['total'];

// 2. Hitung Total Kegiatan Kampus
// Menjalankan query SQL untuk menghitung jumlah total baris pada tabel kegiatan
$q_kegiatan = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM kegiatan");
// Mengambil hasil query dalam bentuk array asosiatif
$d_kegiatan = mysqli_fetch_assoc($q_kegiatan);
// Menyimpan total nilai jumlah kegiatan ke dalam variabel
$total_kegiatan = $d_kegiatan['total'];

// 3. Set Total Kuota Maksimal Aplikasi (Misal diset global: 300)
// Menetapkan batas maksimal kuota peserta yang diizinkan oleh sistem
$kuota_maksimal = 300;
// Menghitung sisa kuota yang masih tersedia berdasarkan total peserta terdaftar
$kuota_tersedia = $kuota_maksimal - $total_peserta;
// Memastikan nilai sisa kuota tidak menjadi minus jika peserta melebihi kuota
if($kuota_tersedia < 0) $kuota_tersedia = 0;

// 4. Hitung Persentase Progress Bar
// Menghitung rasio persentase keterisian kuota menggunakan operator ternary dan pembulatan angka
$persentase = ($total_peserta > 0) ? round(($total_peserta / $kuota_maksimal) * 100) : 0;
// Memastikan visualisasi persentase tidak melebihi batas nilai maksimal 100%
if($persentase > 100) $persentase = 100;
?>

<!DOCTYPE html>
<!-- Menentukan deklarasi tipe dokumen sebagai HTML5 dengan pengaturan bahasa Indonesia -->
<html lang="id">
<head>
    <!-- Menetapkan pengodean karakter dokumen menggunakan UTF-8 -->
    <meta charset="UTF-8">
    <!-- Mengatur tampilan agar responsif di berbagai ukuran layar perangkat -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Menentukan judul halaman web yang tampil pada tab peramban -->
    <title>Dashboard - Sistem Pendaftaran Kegiatan Kampus</title>

    <!-- Memuat pustaka gaya Bootstrap 5 untuk desain antarmuka yang modern -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Memuat pustaka ikon resmi dari Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Memuat berkas CSS kustom milik lokal untuk dekorasi tambahan -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- Bagian panel samping (sidebar) untuk navigasi menu utama -->
    <aside class="sidebar">

        <!-- Kontainer untuk logo dan nama sistem aplikasi -->
        <div class="brand">
            <!-- Menampilkan inisial singkat sebagai logo sistem -->
            <div class="brand-logo">SK</div>

            <div>
                <!-- Menampilkan judul utama aplikasi pada sidebar -->
                <h1>Sistem Kampus</h1>
                <!-- Menampilkan sub-judul penjelasan aplikasi -->
                <p>Pendaftaran Kegiatan</p>
            </div>
        </div>

        <!-- Kontainer untuk menampung seluruh daftar menu navigasi -->
        <nav class="menu">

            <!-- Tautan menuju halaman dashboard utama yang saat ini sedang aktif -->
            <a href="dashboard.php" class="active">
                <!-- Menampilkan ikon speedometer sebagai representasi visual dashboard -->
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <!-- Tautan navigasi menuju halaman formulir pendaftaran -->
            <a href="form_daftar.php">
                <!-- Menampilkan ikon pensil dalam kotak -->
                <i class="bi bi-pencil-square"></i>
                Form Pendaftaran
            </a>

            <!-- Tautan navigasi menuju halaman daftar peserta -->
            <a href="data_peserta.php">
                <!-- Menampilkan ikon sekelompok orang -->
                <i class="bi bi-people"></i>
                Data Peserta
            </a>

            <!-- Tautan navigasi menuju halaman pengubahan data -->
            <a href="edit_data.php">
                <!-- Menampilkan ikon pensil penanda edit -->
                <i class="bi bi-pencil"></i>
                Edit Peserta
            </a>

            <!-- Tautan navigasi menuju halaman informasi kegiatan -->
            <a href="kegiatan.php">
                <!-- Menampilkan ikon kalender acara -->
                <i class="bi bi-calendar-event"></i>
                Data Kegiatan
            </a>

            <!-- Tautan untuk mengakhiri sesi pengguna (keluar sistem) -->
            <a href="logout.php">
                <!-- Menampilkan ikon pintu keluar atau logout -->
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </a>

        </nav>

    </aside>

    <!-- Area konten utama tempat seluruh informasi dashboard ditampilkan -->
    <main class="content">

        <!-- Bagian atas halaman (topbar) untuk informasi ringkas sistem dan aksi cepat -->
        <section class="topbar">

            <div>
                <!-- Label penanda bahwa halaman ini adalah panel khusus admin -->
                <p class="label">Admin Panel</p>
                <!-- Judul utama konten pada area halaman -->
                <h2>Sistem Pendaftaran Kegiatan Kampus</h2>
                <!-- Deskripsi singkat mengenai fungsi dan kegunaan sistem -->
                <p class="text-muted">
                    Kelola seluruh kegiatan kampus, data peserta,
                    dan proses pendaftaran dengan mudah.
                </p>
            </div>

            <!-- Kontainer tombol aksi dengan susunan flexbox bertata letak rapi -->
            <div class="d-flex gap-2">
                <!-- Tombol utama untuk mengarahkan pengguna ke form pendaftaran baru -->
                <a href="form_daftar.php" class="btn btn-primary">
                    <!-- Menampilkan ikon tambah data -->
                    <i class="bi bi-plus-circle"></i>
                    Daftar Peserta
                </a>

                <!-- Tombol sekunder untuk melihat data seluruh kegiatan kampus -->
                <a href="kegiatan.php" class="btn btn-outline-primary">
                    <!-- Menampilkan ikon kalender acara -->
                    <i class="bi bi-calendar-event"></i>
                    Data Kegiatan
                </a>
            </div>

        </section>

        <!-- Bagian penyambutan (hero section) yang atraktif bagi pengguna -->
        <section class="hero-dashboard mb-4">

            <!-- Menggunakan sistem baris kisi Bootstrap untuk pembagian tata letak -->
            <div class="row align-items-center">

                <!-- Kolom kiri untuk teks salam selamat datang kepada admin -->
                <div class="col-lg-8">
                    <!-- Menampilkan nama admin secara aman menggunakan fungsi htmlspecialchars -->
                    <h2 id="sapaan">
                     Selamat Datang, <?php echo htmlspecialchars($nama); ?> 👋
                    </h2>
                    <!-- Teks pengantar informatif bagi pengguna dashboard -->
                    <p>
                        Kelola seluruh kegiatan kampus dengan lebih mudah.
                        Pantau jumlah peserta, kegiatan aktif,
                        serta aktivitas terbaru secara real-time.
                    </p>
                </div>

                <!-- Kolom kanan untuk menampilkan waktu dan tanggal secara dinamis -->
                <div class="col-lg-4 text-lg-end">
                    <!-- Kontainer khusus penampil penunjuk waktu -->
                    <div class="hero-time">
                        <!-- Komponen penampung waktu jam digital (diperbarui oleh JavaScript) -->
                        <h3 id="jam">00:00:00</h3>
                        <!-- Komponen penampung format tanggal hari ini (diperbarui oleh JavaScript) -->
                        <span id="tanggal">Senin, 1 Januari 2026</span>
                    </div>
                </div>

            </div>

        </section>

        <!-- PROGRESS BAR DINAMIS -->
        <!-- Bagian visualisasi perkembangan jumlah pendaftar yang masuk -->
        <section class="card-box mb-4">

            <!-- Bagian judul progress bar dengan tata letak menyebar horizontal -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">
                    <!-- Menampilkan ikon grafik panah naik -->
                    <i class="bi bi-graph-up-arrow text-success"></i>
                    Progress Pendaftaran
                </h4>
                <!-- Menampilkan angka persentase total pendaftaran saat ini menggunakan badge -->
                <span class="badge bg-success fs-6">
                    <?= $persentase; ?>%
                </span>
            </div>

            <!-- Keterangan tertulis mengenai detail angka rasio kuota saat ini -->
            <p class="mb-2">
                Kuota peserta telah terisi sebanyak
                <strong><?= $total_peserta; ?> / <?= $kuota_maksimal; ?> peserta</strong>
            </p>

            <!-- Komponen bilah kemajuan (progress bar) interaktif milik Bootstrap -->
            <div class="progress progress-modern">
                <!-- Komponen internal bilah kemajuan dengan animasi bergerak sesuai variabel persentase -->
                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: <?= $persentase; ?>%">
                    <?= $persentase; ?>%
                </div>
            </div>
        </section>

        <!-- QUICK CARD MENU -->
        <!-- Bagian jalan pintas (shortcut) berupa kartu-kartu menu interaktif -->
        <section class="row g-3 mb-4">
            <!-- Kartu menu cepat untuk pendaftaran peserta baru -->
            <div class="col-md-3">
                <a href="form_daftar.php" class="quick-card text-decoration-none">
                    <!-- Menampilkan ikon tambah personil -->
                    <i class="bi bi-person-plus-fill"></i>
                    <h5>Tambah Peserta</h5>
                    <p>Daftarkan peserta baru</p>
                </a>
            </div>

            <!-- Kartu menu cepat untuk meninjau data peserta terdaftar -->
            <div class="col-md-3">
                <a href="data_peserta.php" class="quick-card text-decoration-none">
                    <!-- Menampilkan ikon grup/komunitas -->
                    <i class="bi bi-people-fill"></i>
                    <h5>Data Peserta</h5>
                    <p>Lihat seluruh peserta</p>
                </a>
            </div>

            <!-- Kartu menu cepat untuk pengelolaan agenda kegiatan -->
            <div class="col-md-3">
                <a href="kegiatan.php" class="quick-card text-decoration-none">
                    <!-- Menampilkan ikon kalender penuh -->
                    <i class="bi bi-calendar-event-fill"></i>
                    <h5>Kegiatan</h5>
                    <p>Kelola kegiatan kampus</p>
                </a>
            </div>

            <!-- Kartu menu cepat untuk pembaruan berkas/informasi -->
            <div class="col-md-3">
                <a href="edit_data.php" class="quick-card text-decoration-none">
                    <!-- Menampilkan ikon dokumen dan pena -->
                    <i class="bi bi-pencil-square"></i>
                    <h5>Edit Data</h5>
                    <p>Ubah data peserta</p>
                </a>
            </div>
        </section>

        <!-- COUNTER STATISTIK DINAMIS -->
        <!-- Bagian kartu ringkasan numerik data statistik riil database -->
        <section class="row g-4 mb-4">

            <!-- Kartu statistik jumlah seluruh kegiatan kampus -->
            <div class="col-lg-4 col-md-6">
                <div class="stat-card text-center">
                    <!-- Menampilkan ikon kalender tercentang -->
                    <i class="bi bi-calendar-check display-5"></i>
                    <!-- Mencetak total nilai kegiatan hasil query SQL -->
                    <h2 class="counter"><?= $total_kegiatan; ?></h2>
                    <p>Total Kegiatan Kampus</p>
                </div>
            </div>

            <!-- Kartu statistik jumlah peserta yang sukses melakukan registrasi -->
            <div class="col-lg-4 col-md-6">
                <div class="stat-card text-center">
                    <!-- Menampilkan ikon kerumunan orang -->
                    <i class="bi bi-people-fill display-5"></i>
                    <!-- Mencetak total jumlah pendaftar hasil query SQL -->
                    <h2 class="counter"><?= $total_peserta; ?></h2>
                    <p>Total Peserta Terdaftar</p>
                </div>
            </div>

            <!-- Kartu statistik jumlah sisa alokasi kuota aplikasi yang tersedia -->
            <div class="col-lg-4 col-md-6">
                <div class="stat-card text-center">
                    <!-- Menampilkan ikon verifikasi pengguna -->
                    <i class="bi bi-person-check-fill display-5"></i>
                    <!-- Mencetak sisa kuota yang telah dikalkulasi di logika PHP -->
                    <h2 class="counter"><?= $kuota_tersedia; ?></h2>
                    <p>Sisa Kuota Tersedia</p>
                </div>
            </div>

        </section>

        <!-- Tata letak dua kolom untuk info tambahan (Pengumuman & Aktivitas) -->
        <section class="row g-4">

            <!-- Kolom sebelah kiri untuk memuat papan pengumuman -->
            <div class="col-lg-7">

                <!-- Kotak kartu dengan pengaturan tinggi penuh (100%) -->
                <div class="card-box h-100">

                    <!-- Komponen judul utama papan pengumuman -->
                    <div class="section-title">
                        <h3>
                            <!-- Menampilkan ikon megafon atau pengeras suara -->
                            <i class="bi bi-megaphone-fill text-primary"></i>
                            Pengumuman
                        </h3>
                        <!-- Sub-teks penjelas status informasi -->
                        <span>Informasi Terbaru</span>
                    </div>

                    <!-- Kotak notifikasi Bootstrap berwarna biru (informasi seminar) -->
                    <div class="alert alert-primary">
                        Seminar Karier Digital akan dilaksanakan pada
                        <strong>12 Juli 2026</strong>.
                    </div>

                    <!-- Kotak notifikasi Bootstrap berwarna hijau (informasi workshop) -->
                    <div class="alert alert-success">
                        Workshop UI/UX masih membuka pendaftaran peserta.
                    </div>

                    <!-- Kotak notifikasi Bootstrap berwarna kuning dengan margin bawah dihilangkan (info lomba) -->
                    <div class="alert alert-warning mb-0">
                        Lomba Web Design akan ditutup apabila kuota telah terpenuhi.
                    </div>

                </div>

            </div>

            <!-- Kolom sebelah kanan untuk memuat log riwayat aktivitas -->
            <div class="col-lg-5">

                <!-- Kotak kartu dengan penyesuaian tinggi penuh (100%) -->
                <div class="card-box h-100">

                    <!-- Komponen judul utama untuk tabel aktivitas -->
                    <div class="section-title">
                        <h3>
                            <!-- Menampilkan ikon jam riwayat (history) -->
                            <i class="bi bi-clock-history text-primary"></i>
                            Aktivitas Terbaru
                        </h3>
                    </div>

                    <!-- Elemen tabel interaktif dengan efek sorot baris (hover) -->
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <!-- Kolom judul tabel waktu -->
                                <th>Jam</th>
                                <!-- Kolom judul tabel bentuk kegiatan -->
                                <th>Aktivitas</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Baris catatan aktivitas pertama -->
                            <tr>
                                <td>08.00</td>
                                <td>Admin membuka pendaftaran seminar.</td>
                            </tr>
                            <!-- Baris catatan aktivitas kedua -->
                            <tr>
                                <td>09.30</td>
                                <td>15 peserta berhasil mendaftar.</td>
                            </tr>
                            <!-- Baris catatan aktivitas ketiga -->
                            <tr>
                                <td>10.45</td>
                                <td>Data peserta berhasil diperbarui.</td>
                            </tr>
                            <!-- Baris catatan aktivitas keempat -->
                            <tr>
                                <td>11.20</td>
                                <td>Workshop UI/UX ditambahkan.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

        <!-- Komponen catatan kaki (footer) halaman dashboard admin -->
        <footer class="footer-dashboard">
            <p>
                © 2026 Sistem Pendaftaran Kegiatan Kampus
                <br>
                Universitas • Admin Dashboard Version 1.0
            </p>
        </footer>
    </main>

    <!-- Skrip pemrograman JavaScript untuk fitur jam dan tanggal dinamis -->
    <script>
    // Fungsi khusus untuk memperbarui tampilan waktu dan penanggalan secara berkala
    function updateJam(){
        // Membuat objek tanggal baru berdasarkan waktu lokal sistem saat ini
        const sekarang = new Date();

        // Mengubah teks HTML elemen jam menjadi format waktu lokal Indonesia (HH.MM.SS)
        document.getElementById("jam").innerHTML =
            sekarang.toLocaleTimeString("id-ID");

        // Mengubah teks HTML elemen tanggal menjadi format penulisan resmi Indonesia secara lengkap
        document.getElementById("tanggal").innerHTML =
            sekarang.toLocaleDateString("id-ID",{
                weekday:"long",
                day:"numeric",
                month:"long",
                year:"numeric"
            });
    }
    // Menjalankan fungsi updateJam secara otomatis setiap 1000 milidetik (1 detik)
    setInterval(updateJam,1000);
    // Memanggil fungsi pertama kali saat halaman berhasil dimuat agar tidak ada jeda tampilan kosong
    updateJam();
    </script>
</body>
</html>