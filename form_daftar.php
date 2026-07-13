<?php
// Memulai session PHP untuk melacak status login pengguna
session_start();

// Menghubungkan file ini dengan database MySQL melalui file koneksi.php
include "koneksi.php";

// Gerbang Keamanan: Jika session 'login' belum ada, tendang pengguna kembali ke halaman login (index.php)
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit; // Menghentikan eksekusi skrip agar kode di bawahnya tidak berjalan
}

// Mengecek apakah tombol 'simpan' (submit form) telah diklik oleh pengguna
if (isset($_POST['simpan'])) {
    // Mengamankan input dari SQL Injection menggunakan fungsi mysqli_real_escape_string
    $id_kegiatan   = mysqli_real_escape_string($koneksi, $_POST['id_kegiatan']);
    $nim           = mysqli_real_escape_string($koneksi, $_POST['nim']);
    $nama_lengkap  = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    $program_studi = mysqli_real_escape_string($koneksi, $_POST['program_studi']);
    $semester      = mysqli_real_escape_string($koneksi, $_POST['semester']);
    $no_hp         = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $email         = mysqli_real_escape_string($koneksi, $_POST['email']);
    $alamat        = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    // Query SQL untuk memasukkan data pendaftaran baru ke dalam tabel 'peserta'
    $query = mysqli_query($koneksi, "INSERT INTO peserta 
    (id_kegiatan, nim, nama_lengkap, program_studi, semester, no_hp, email, alamat, status_pendaftaran) 
    VALUES 
    ('$id_kegiatan', '$nim', '$nama_lengkap', '$program_studi', '$semester', '$no_hp', '$email', '$alamat', 'terdaftar')");

    // Validasi apakah proses query ke database berhasil atau gagal
    if($query){
        // Jika berhasil, munculkan notifikasi sukses lalu alihkan (redirect) ke halaman data_peserta.php
        echo "<script>
        alert('Data peserta berhasil disimpan!');
        window.location='data_peserta.php';
        </script>";
    }else{
        // Jika gagal, munculkan notifikasi gagal beserta pesan error spesifik dari MySQL
        echo "<script>alert('Data gagal disimpan! Error: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran Peserta</title>
    <!-- Memanggil framework Bootstrap 5 untuk styling layout dan komponen UI -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Memanggil Bootstrap Icons untuk kebutuhan ikon pada form dan sidebar -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- File CSS eksternal kustom untuk mengatur tampilan antarmuka (dashboard) -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Bagian Navigation Sidebar (Menu Samping) -->
    <aside class="sidebar">
        <!-- Logo dan Nama Aplikasi/Sistem -->
        <div class="brand">
            <div class="brand-logo">SK</div>
            <div>
                <h1>Sistem Kampus</h1>
                <p>Pendaftaran Kegiatan</p>
            </div>
        </div>
        <!-- Daftar Menu Navigasi -->
        <nav class="menu">
            <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <!-- Menu Form diberi class 'active' sebagai penanda posisi halaman saat ini -->
            <a href="form_daftar.php" class="active"><i class="bi bi-pencil-square"></i> Form Pendaftaran</a>
            <a href="data_peserta.php"><i class="bi bi-people"></i> Data Peserta</a>
            <a href="kegiatan.php"><i class="bi bi-calendar-event"></i> Data Kegiatan</a>
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </nav>
    </aside>

    <!-- Bagian Konten Utama Halaman -->
    <main class="content">
        <!-- Topbar: Bagian atas konten yang berisi judul halaman dan tombol pintas -->
        <section class="topbar">
            <div>
                <p class="label">Form Pendaftaran</p>
                <h2>Pendaftaran Peserta Kegiatan Kampus</h2>
                <p class="text-muted">Isi seluruh data peserta dengan lengkap dan benar.</p>
            </div>
            <div>
                <!-- Tombol navigasi cepat untuk melihat list peserta yang sudah mendaftar -->
                <a href="data_peserta.php" class="btn btn-primary">
                    <i class="bi bi-people-fill"></i> Lihat Data Peserta
                </a>
            </div>
        </section>

        <!-- Hero Dashboard: Menampilkan banner selamat datang dan widget waktu real-time -->
        <section class="hero-dashboard mb-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2>📝 Formulir Pendaftaran Peserta</h2>
                    <p>Silakan lengkapi data mahasiswa yang akan mengikuti kegiatan kampus.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <!-- Penampung Jam dan Tanggal Digital (Akan di-update otomatis oleh JavaScript) -->
                    <div class="hero-time">
                        <h3 id="jam">00:00:00</h3>
                        <span id="tanggal">Senin, 1 Januari 2026</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Area Kartu Formulir Pendaftaran -->
        <section class="card-box mb-4">
            <div class="section-title">
                <h3><i class="bi bi-person-plus-fill text-primary"></i> Form Pendaftaran Peserta</h3>
                <span>Lengkapi seluruh data</span>
            </div>

            <!-- Form HTML dengan metode POST untuk mengirimkan data ke database -->
            <form method="POST" class="row g-4">
                <!-- Input field untuk Nama Lengkap -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-person-fill text-primary"></i> Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                </div>

                <!-- Input field untuk Nomor Induk Mahasiswa (NIM) -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-credit-card-fill text-primary"></i> NIM</label>
                    <input type="text" class="form-control" name="nim" placeholder="Masukkan NIM" required>
                </div>

                <!-- Input field untuk Nama Program Studi -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-mortarboard-fill text-primary"></i> Program Studi</label>
                    <input type="text" class="form-control" name="program_studi" placeholder="Contoh : Pendidikan Teknologi Informasi" required>
                </div>

                <!-- Pilihan Dropdown Semester (Looping otomatis dari semester 1 sampai 8) -->
                <div class="col-md-3">
                    <label class="form-label"><i class="bi bi-book-half text-primary"></i> Semester</label>
                    <select class="form-select" name="semester" required>
                        <option value="">Pilih Semester</option>
                        <?php for($i=1; $i<=8; $i++){ ?>
                            <option value="<?= $i; ?>"><?= $i; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Input field untuk Nomor Handphone (Tipe 'tel') -->
                <div class="col-md-3">
                    <label class="form-label"><i class="bi bi-phone-fill text-primary"></i> Nomor HP</label>
                    <input type="tel" class="form-control" name="no_hp" placeholder="08xxxxxxxxxx" required>
                </div>

                <!-- Input field untuk Alamat Email (Tipe 'email' otomatis memvalidasi format @) -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-envelope-fill text-primary"></i> Email</label>
                    <input type="email" class="form-control" name="email" placeholder="nama@email.com" required>
                </div>

                <!-- Dropdown Dinamis: Mengambil data daftar kegiatan langsung dari tabel 'kegiatan' di database -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-calendar-event-fill text-primary"></i> Pilih Kegiatan</label>
                    <select class="form-select" name="id_kegiatan" required>
                        <option value="">Pilih Kegiatan</option>
                        <?php
                        // Mengambil seluruh data kegiatan dan diurutkan berdasarkan alfabet (A-Z)
                        $kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan ORDER BY nama_kegiatan ASC");
                        while($row = mysqli_fetch_assoc($kegiatan)){
                        ?>
                        <!-- Menyimpan 'id_kegiatan' sebagai value database, namun menampilkan 'nama_kegiatan' ke user -->
                        <option value="<?= $row['id_kegiatan']; ?>">
                            <?= htmlspecialchars($row['nama_kegiatan']); ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Input Textarea untuk penulisan Alamat Lengkap -->
                <div class="col-12">
                    <label class="form-label"><i class="bi bi-geo-alt-fill text-primary"></i> Alamat</label>
                    <textarea class="form-control" name="alamat" rows="4" placeholder="Masukkan alamat lengkap..." required></textarea>
                </div>

                <!-- Tombol aksi: Simpan (Submit Form) dan Reset (Mengosongkan kembali isi form) -->
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

        <!-- Bagian kaki halaman (Footer) informasi hak cipta -->
        <footer class="footer mt-4">
            <p>&copy; 2026 Sistem Pendaftaran Kegiatan Kampus <br><small class="text-muted">Dibuat untuk memenuhi tugas Pemrograman Web.</small></p>
        </footer>
    </main>

    <!-- JavaScript untuk fungsionalitas Jam & Tanggal Digital Real-Time -->
    <script>
    function updateJam() {
        const sekarang = new Date(); // Mengambil data waktu lokal dari perangkat user
        // Mengubah format tampilan jam menjadi format Indonesia (HH.MM.SS)
        document.getElementById("jam").innerHTML = sekarang.toLocaleTimeString("id-ID");
        // Mengubah format tampilan hari dan tanggal menjadi bahasa Indonesia yang lengkap
        document.getElementById("tanggal").innerHTML = ClinicalTanggal = sekarang.toLocaleDateString("id-ID", {
            weekday: "long", day: "numeric", month: "long", year: "numeric"
        });
    }
    // Menjalankan fungsi updateJam setiap 1000 milidetik (1 detik) sekali secara terus-menerus
    setInterval(updateJam, 1000);
    updateJam(); // Memanggil fungsi pertama kali saat halaman selesai dimuat
    </script>
    <!-- Memanggil file bundle JavaScript Bootstrap 5 untuk fungsionalitas interaktif UI -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>