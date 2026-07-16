<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST['simpan'])) {

    // Mengamankan input dari SQL Injection
    $id_kegiatan   = mysqli_real_escape_string($conn, $_POST['id_kegiatan']);
    $nim           = mysqli_real_escape_string($conn, $_POST['nim']);
    $nama_lengkap  = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $program_studi = mysqli_real_escape_string($conn, $_POST['program_studi']);
    $semester      = mysqli_real_escape_string($conn, $_POST['semester']);
    $no_hp         = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $email         = mysqli_real_escape_string($conn, $_POST['email']);
    $alamat        = mysqli_real_escape_string($conn, $_POST['alamat']);

    $query = mysqli_query($conn, "INSERT INTO peserta 
    (id_kegiatan, nim, nama_lengkap, program_studi, semester, no_hp, email, alamat, status_pendaftaran) 
    VALUES 
    ('$id_kegiatan', '$nim', '$nama_lengkap', '$program_studi', '$semester', '$no_hp', '$email', '$alamat', 'terdaftar')");

    if($query){
        // DIUBAH: Mengalihkan kembali ke form agar notifikasi muncul di halaman yang sama
        header("Location: form_daftar.php?status=sukses");
        exit;
    }else{
        header("Location: form_daftar.php?status=gagal");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Form Pendaftaran Peserta</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <!-- ================= SIDEBAR ================= -->
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
            <a href="form_daftar.php" class="active"><i class="bi bi-pencil-square"></i> Form Pendaftaran</a>
            <a href="data_peserta.php"><i class="bi bi-people"></i> Data Peserta</a>
            <a href="kegiatan.php"><i class="bi bi-calendar-event"></i> Data Kegiatan</a>
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </nav>
    </aside>

    <!-- ================= CONTENT ================= -->
    <main class="content">

        <!-- Header -->
        <section class="topbar">
            <div>
                <p class="label">Form Pendaftaran</p>
                <h2>Pendaftaran Peserta Kegiatan Kampus</h2>
                <p class="text-muted">
                    Isi seluruh data peserta dengan lengkap dan benar agar proses pendaftaran dapat diproses oleh admin.
                </p>
            </div>
            <div>
                <a href="data_peserta.php" class="btn btn-primary">
                    <i class="bi bi-people-fill"></i> Lihat Data Peserta
                </a>
            </div>
        </section>

        <!-- HERO -->
        <section class="hero-dashboard mb-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2>📝 Formulir Pendaftaran Peserta</h2>
                    <p>Silakan lengkapi data mahasiswa yang akan mengikuti kegiatan kampus. Pastikan seluruh informasi sudah benar sebelum menekan tombol simpan.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="hero-time">
                        <h3 id="jam">00:00:00</h3>
                        <span id="tanggal">Senin, 1 Januari 2026</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- FITUR BARU: ALERT NOTIFIKASI BOOTSTRAP -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'sukses'): ?>
            <div class="alert alert-success alert-dismissible fade show mb-4 d-flex align-items-center" role="alert" style="border-radius: 10px;">
                <i class="bi bi-check-circle-fill me-3 fs-4"></i>
                <div>
                    <strong>Pendaftaran Berhasil!</strong> Data peserta baru telah sukses disimpan ke dalam sistem database.
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'gagal'): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4 d-flex align-items-center" role="alert" style="border-radius: 10px;">
                <i class="bi bi-exclamation-triangle-fill me-3 fs-4"></i>
                <div>
                    <strong>Pendaftaran Gagal!</strong> Terjadi kendala teknis saat menyimpan data ke database. Silakan coba lagi.
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- CARD FORM -->
        <section class="card-box mb-4">
            <div class="section-title">
                <h3>
                    <i class="bi bi-person-plus-fill text-primary"></i> Form Pendaftaran Peserta
                </h3>
                <span>Lengkapi seluruh data</span>
            </div>

            <form method="POST" class="row g-4">
                <!-- Nama Lengkap -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-person-fill text-primary"></i> Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                </div>

                <!-- NIM -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-credit-card-fill text-primary"></i> NIM</label>
                    <input type="text" class="form-control" name="nim" placeholder="Masukkan NIM" required>
                </div>

                <!-- Program Studi -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-mortarboard-fill text-primary"></i> Program Studi</label>
                    <input type="text" class="form-control" name="program_studi" placeholder="Contoh : Pendidikan Teknologi Informasi" required>
                </div>

                <!-- Semester -->
                <div class="col-md-3">
                    <label class="form-label"><i class="bi bi-book-half text-primary"></i> Semester</label>
                    <select class="form-select" name="semester" required>
                        <option value="">Pilih Semester</option>
                        <?php for($i=1; $i<=8; $i++){ ?>
                            <option value="<?= $i; ?>"><?= $i; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Nomor HP -->
                <div class="col-md-3">
                    <label class="form-label"><i class="bi bi-phone-fill text-primary"></i> Nomor HP</label>
                    <input type="tel" class="form-control" name="no_hp" placeholder="08xxxxxxxxxx" required>
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-envelope-fill text-primary"></i> Email</label>
                    <input type="email" class="form-control" name="email" placeholder="nama@email.com" required>
                </div>

                <!-- Pilihan Kegiatan -->
<div class="col-md-6">
    <label class="form-label"><i class="bi bi-calendar-event-fill text-primary"></i> Pilih Kegiatan</label>
    <select class="form-select" name="id_kegiatan" required>
        <option value="" selected disabled>Pilih Kegiatan</option>
        <?php
        // Mengambil semua data kegiatan dari database diurutkan secara alfabetis
        $kegiatan = mysqli_query($conn, "SELECT * FROM kegiatan ORDER BY nama_kegiatan ASC");
        while($row = mysqli_fetch_assoc($kegiatan)){
            // Ambil tanggal kegiatan dari database dan tanggal hari ini
            $tgl_kegiatan = date('Y-m-d', strtotime($row['tanggal']));
            $tgl_sekarang = date('Y-m-d');

            // JIKA TANGGAL KEGIATAN SUDAH LEWAT (SUDAH SELESAI)
            if ($tgl_kegiatan < $tgl_sekarang) {
                // Ditampilkan di dropdown tapi tidak bisa dipilih (disabled) dan diberi warna abu-abu
                ?>
                <option value="<?= $row['id_kegiatan']; ?>" disabled style="color: #a0a0a0; background-color: #f2f2f2;">
                    <?= htmlspecialchars($row['nama_kegiatan']); ?> (Pendaftaran Ditutup - Kegiatan Selesai)
                </option>
                <?php
            } 
            // JIKA KEGIATAN MASIH AKAN DATANG ATAU HARI INI
            else {
                // Ditampilkan secara normal agar pendaftar bisa memilihnya
                ?>
                <option value="<?= $row['id_kegiatan']; ?>">
                    <?= htmlspecialchars($row['nama_kegiatan']); ?>
                </option>
                <?php 
            }
        } 
        ?>
    </select>
</div>

                <!-- Alamat -->
                <div class="col-12">
                    <label class="form-label"><i class="bi bi-geo-alt-fill text-primary"></i> Alamat</label>
                    <textarea class="form-control" name="alamat" rows="4" placeholder="Masukkan alamat lengkap..." required></textarea>
                </div>

                <!-- Tombol -->
                <div class="col-12 mt-3">
                    <button type="submit" name="simpan" class="btn btn-primary me-2">
                        <i class="bi bi-check-circle-fill"></i> Simpan Data
                    </button>
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset Form
                    </button>
                </div>
            </form>
        </section>

        <!-- Footer -->
        <footer class="footer mt-4">
            <p>
                &copy; <?= date("Y"); ?> Sistem Pendaftaran Kegiatan Kampus <br>
                <small class="text-muted">Dibuat untuk memenuhi tugas Pemrograman Web.</small>
            </p>
        </footer>

    </main>

    <!-- Jam Otomatis -->
    <script>
    function updateJam() {
        const sekarang = new Date();
        document.getElementById("jam").innerHTML = sekarang.toLocaleTimeString("id-ID");
        document.getElementById("tanggal").innerHTML = sekarang.toLocaleDateString("id-ID", {
            weekday: "long",
            day: "numeric",
            month: "long",
            year: "numeric"
        });
    }
    setInterval(updateJam, 1000);
    updateJam();
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>