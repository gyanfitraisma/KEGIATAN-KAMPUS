<?php
// Memulai sesi baru atau melanjutkan sesi yang sudah ada di server
session_start();
// Menyertakan file konfigurasi koneksi database
include "koneksi.php";

// Memeriksa apakah pengguna memiliki hak akses (sudah login atau belum)
if (!isset($_SESSION['login'])) {
    // Mengarahkan pengguna ke halaman utama jika belum terautentikasi
    header("Location: index.php");
    // Menghentikan eksekusi skrip selanjutnya untuk keamanan sistem
    exit;
}

// Memeriksa apakah tombol dengan atribut nama 'simpan' telah diklik (metode POST)
if (isset($_POST['simpan'])) {
    // Mengamankan input dari SQL Injection
    // Membersihkan input ID Kegiatan untuk mencegah karakter berbahaya masuk ke query database
    $id_kegiatan   = mysqli_real_escape_string($koneksi, $_POST['id_kegiatan']);
    // Membersihkan input Nomor Induk Mahasiswa (NIM) sebelum diproses
    $nim           = mysqli_real_escape_string($koneksi, $_POST['nim']);
    // Membersihkan nama lengkap peserta dari potensi skrip berbahaya
    $nama_lengkap  = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    // Membersihkan input pilihan program studi peserta
    $program_studi = mysqli_real_escape_string($koneksi, $_POST['program_studi']);
    // Membersihkan nilai semester yang dipilih peserta
    $semester      = mysqli_real_escape_string($koneksi, $_POST['semester']);
    // Membersihkan nomor handphone agar formatnya aman saat disimpan
    $no_hp         = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    // Membersihkan alamat email yang diinput untuk keperluan validasi query
    $email         = mysqli_real_escape_string($koneksi, $_POST['email']);
    // Membersihkan isi teks alamat lengkap dari karakter aneh
    $alamat        = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    // Query disesuaikan dengan struktur tabel peserta di database kamu
    // Menjalankan query SQL untuk menyisipkan data peserta baru ke dalam tabel peserta
    $query = mysqli_query($koneksi, "INSERT INTO peserta 
    (id_kegiatan, nim, nama_lengkap, program_studi, semester, no_hp, email, alamat, status_pendaftaran) 
    VALUES 
    ('$id_kegiatan', '$nim', '$nama_lengkap', '$program_studi', '$semester', '$no_hp', '$email', '$alamat', 'terdaftar')");

    // Mengecek apakah proses eksekusi query ke database berhasil dilakukan
    if($query){
        // Menampilkan kotak dialog sukses dan mengarahkan kembali ke halaman daftar peserta
        echo "<script>
        alert('Data peserta berhasil disimpan!');
        window.location='data_peserta.php';
        </script>";
    }else{
        // Menampilkan pesan kesalahan sistem jika query gagal dieksekusi beserta detail errornya
        echo "<script>alert('Data gagal disimpan! Error: " . mysqli_error($koneksi) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<!-- Mendeklarasikan bahwa berkas menggunakan standar HTML5 dengan pengaturan bahasa Indonesia -->
<html lang="id">
<head>
    <!-- Menentukan pengodean karakter unicode yang digunakan, yaitu UTF-8 -->
    <meta charset="UTF-8">
    <!-- Mengonfigurasi area pandang layar agar antarmuka responsif di ponsel maupun desktop -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Memberikan judul halaman pada tab browser pengguna -->
    <title>Form Pendaftaran Peserta</title>
    <!-- Memuat berkas CSS kerangka Bootstrap 5 untuk standarisasi layout dan komponen -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Memuat berkas CSS Bootstrap Icons untuk menampilkan simbol/ikon visual -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Menyertakan file CSS eksternal kustom untuk visualisasi khusus -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

    <!-- Sidebar -->
    <!-- Komponen navigasi menu utama yang diletakkan di sisi samping halaman -->
    <aside class="sidebar">
        <!-- Area pembungkus logo dan identitas instansi -->
        <div class="brand">
            <!-- Menampilkan simbol singkatan instansi sebagai logo -->
            <div class="brand-logo">SK</div>
            <div>
                <!-- Nama aplikasi utama pada panel navigasi -->
                <h1>Sistem Kampus</h1>
                <!-- Sub-keterangan mengenai lingkup fungsi aplikasi -->
                <p>Pendaftaran Kegiatan</p>
            </div>
        </div>
        <!-- Wadah penampung daftar link navigasi antar halaman admin -->
        <nav class="menu">
            <!-- Link menuju halaman ringkasan performa sistem (Dashboard) -->
            <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <!-- Link menu aktif yang mengarah ke halaman formulir pendaftaran saat ini -->
            <a href="form_daftar.php" class="active"><i class="bi bi-pencil-square"></i> Form Pendaftaran</a>
            <!-- Link navigasi untuk meninjau database berkas pendaftar -->
            <a href="data_peserta.php"><i class="bi bi-people"></i> Data Peserta</a>
            <!-- Link navigasi untuk memperbarui atau mengoreksi data pendaftar -->
            <a href="edit_data.php"><i class="bi bi-pencil"></i> Edit Peserta</a>
            <!-- Link navigasi untuk memanajemen kategori kegiatan kampus -->
            <a href="kegiatan.php"><i class="bi bi-calendar-event"></i> Data Kegiatan</a>
            <!-- Link untuk menghapus sesi login aktif pengguna dari sistem server -->
            <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </nav>
    </aside>

    <!-- Content -->
    <!-- Area konten dinamis tempat formulir pendaftaran utama diproses -->
    <main class="content">
        <!-- Bagian tajuk (topbar) untuk memberikan ringkasan status halaman -->
        <section class="topbar">
            <div>
                <!-- Label nama kategori halaman yang sedang diakses -->
                <p class="label">Form Pendaftaran</p>
                <!-- Judul utama dari modul pengisian data -->
                <h2>Pendaftaran Peserta Kegiatan Kampus</h2>
                <!-- Teks petunjuk pengisian bagi pengguna -->
                <p class="text-muted">Isi seluruh data peserta dengan lengkap dan benar.</p>
            </div>
            <div>
                <!-- Tombol pintasan untuk langsung berpindah ke menu rekap data peserta -->
                <a href="data_peserta.php" class="btn btn-primary">
                    <!-- Menampilkan ikon representasi tabel/kumpulan peserta -->
                    <i class="bi bi-people-fill"></i> Lihat Data Peserta
                </a>
            </div>
        </section>

        <!-- Bagian banner sambutan formulir dengan penyelarasan komponen tengah -->
        <section class="hero-dashboard mb-4">
            <div class="row align-items-center">
                <!-- Sisi kiri banner untuk judul besar modul formulir -->
                <div class="col-lg-8">
                    <h2>📝 Formulir Pendaftaran Peserta</h2>
                    <p>Silakan lengkapi data mahasiswa yang akan mengikuti kegiatan kampus.</p>
                </div>
                <!-- Sisi kanan banner untuk widget penunjuk waktu digital -->
                <div class="col-lg-4 text-lg-end">
                    <div class="hero-time">
                        <!-- Komponen teks penampung angka jam (diperbarui real-time oleh JS) -->
                        <h3 id="jam">00:00:00</h3>
                        <!-- Komponen teks penampung hari dan tanggal (diperbarui real-time oleh JS) -->
                        <span id="tanggal">Senin, 1 Januari 2026</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Kotak pembungkus utama komponen form input data -->
        <section class="card-box mb-4">
            <!-- Header judul komponen di dalam kotak kartu -->
            <div class="section-title">
                <h3><i class="bi bi-person-plus-fill text-primary"></i> Form Pendaftaran Peserta</h3>
                <span>Lengkapi seluruh data</span>
            </div>

            <!-- Elemen formulir dengan metode pengiriman data POST dan jarak kisi otomatis -->
            <form method="POST" class="row g-4">
                <!-- Kolom isian teks nama lengkap peserta -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-person-fill text-primary"></i> Nama Lengkap</label>
                    <input type="text" class="form-control" name="nama_lengkap" placeholder="Masukkan nama lengkap" required>
                </div>

                <!-- Kolom isian kode identitas Nomor Induk Mahasiswa -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-credit-card-fill text-primary"></i> NIM</label>
                    <input type="text" class="form-control" name="nim" placeholder="Masukkan NIM" required>
                </div>

                <!-- Kolom isian data program studi aktif mahasiswa -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-mortarboard-fill text-primary"></i> Program Studi</label>
                    <input type="text" class="form-control" name="program_studi" placeholder="Contoh : Pendidikan Teknologi Informasi" required>
                </div>

                <!-- Kolom pilihan (dropdown) untuk menentukan posisi semester saat ini -->
                <div class="col-md-3">
                    <label class="form-label"><i class="bi bi-book-half text-primary"></i> Semester</label>
                    <select class="form-select" name="semester" required>
                        <option value="">Pilih Semester</option>
                        <!-- Melakukan perulangan otomatis menggunakan PHP untuk membuat opsi opsi semester 1 sampai 8 -->
                        <?php for($i=1; $i<=8; $i++){ ?>
                            <option value="<?= $i; ?>"><?= $i; ?></option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Kolom isian nomor kontak seluler aktif peserta -->
                <div class="col-md-3">
                    <label class="form-label"><i class="bi bi-phone-fill text-primary"></i> Nomor HP</label>
                    <input type="tel" class="form-control" name="no_hp" placeholder="08xxxxxxxxxx" required>
                </div>

                <!-- Kolom isian alamat surat elektronik resmi aktif -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-envelope-fill text-primary"></i> Email</label>
                    <input type="email" class="form-control" name="email" placeholder="nama@email.com" required>
                </div>

                <!-- Kolom pilihan kegiatan dinamis yang diambil langsung dari database -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-calendar-event-fill text-primary"></i> Pilih Kegiatan</label>
                    <select class="form-select" name="id_kegiatan" required>
                        <option value="">Pilih Kegiatan</option>
                        <?php
                        // Menarik data semua kegiatan dari database dan diurutkan berdasarkan nama secara alfabetis
                        $kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan ORDER BY nama_kegiatan ASC");
                        // Melakukan perulangan array asosiatif untuk mencetak setiap data kegiatan ke dalam elemen option
                        while($row = mysqli_fetch_assoc($kegiatan)){
                        ?>
                        <!-- Menyimpan ID kegiatan pada value, dan menampilkan nama kegiatan dengan aman menggunakan htmlspecialchars -->
                        <option value="<?= $row['id_kegiatan']; ?>">
                            <?= htmlspecialchars($row['nama_kegiatan']); ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Kolom isian teks berparagraf (textarea) untuk alamat tempat tinggal -->
                <div class="col-12">
                    <label class="form-label"><i class="bi bi-geo-alt-fill text-primary"></i> Alamat</label>
                    <textarea class="form-control" name="alamat" rows="4" placeholder="Masukkan alamat lengkap..." required></textarea>
                </div>

                <!-- Kelompok tombol untuk memproses aksi pengiriman formulir atau pembatalan input -->
                <div class="col-12 mt-3">
                    <!-- Tombol untuk mengeksekusi aksi simpan data form ke server -->
                    <button type="submit" name="simpan" class="btn btn-primary me-2">
                        <i class="bi bi-check-circle-fill"></i> Simpan Data
                    </button>
                    <!-- Tombol untuk membersihkan semua isian kolom kembali ke kondisi awal kosong -->
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Reset Form
                    </button>
                </div>
            </form>
        </section>

        <!-- Catatan kaki halaman administrasi sistem pendaftaran -->
        <footer class="footer mt-4">
            <p>&copy; 2026 Sistem Pendaftaran Kegiatan Kampus <br><small class="text-muted">Dibuat untuk memenuhi tugas Pemrograman Web.</small></p>
        </footer>
    </main>

    <!-- Blok naskah pemrograman JavaScript untuk fungsionalitas antarmuka -->
    <script>
    // Membuat modul fungsi pembaruan waktu secara berkala
    function updateJam() {
        // Menginisialisasi tanggal dan waktu saat ini berdasarkan jam internal gawai pengguna
        const sekarang = new Date();
        // Menginjeksikan konversi waktu format lokal Indonesia ke elemen jam HTML
        document.getElementById("jam").innerHTML = sekarang.toLocaleTimeString("id-ID");
        // Menginjeksikan penulisan struktur penanggalan lengkap Indonesia ke elemen tanggal HTML
        document.getElementById("tanggal").innerHTML = ClinicalTanggal = sekarang.toLocaleDateString("id-ID", {
            weekday: "long", day: "numeric", month: "long", year: "numeric"
        });
    }
    // Mengatur interval penyegaran fungsi updateJam agar dijalankan berulang setiap 1 detik
    setInterval(updateJam, 1000);
    // Memanggil fungsi secara instan sesaat setelah skrip dibaca browser agar tidak ada visual kosong
    updateJam();
    </script>
    <!-- Memuat berkas bundle JavaScript Bootstrap 5 untuk mendukung aspek interaktivitas bawaan -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>