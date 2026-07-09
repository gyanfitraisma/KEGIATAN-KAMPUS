<?php
// 1. KONEKSI KE DATABASE
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_kegiatan_kampus";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal. Tolong pastikan XAMPP (Apache & MySQL) sudah START ya Rida.");
}

// 2. AMBIL ID PESERTA (Dinamis dari URL, jika tidak ada, cari data pertama)
if (isset($_GET['id'])) {
    $id_peserta = $_GET['id'];
} else {
    $query_cek = mysqli_query($koneksi, "SELECT id_peserta FROM peserta LIMIT 1");
    $data_cek = mysqli_fetch_assoc($query_cek);
    $id_peserta = isset($data_cek['id_peserta']) ? $data_cek['id_peserta'] : 1;
}

$query = "SELECT * FROM peserta WHERE id_peserta = '$id_peserta'";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

// Ambil daftar kegiatan dari database untuk pilihan dropdown menu kegiatan
$data_kegiatan = mysqli_query($koneksi, "SELECT * FROM kegiatan ORDER BY nama_kegiatan ASC");

// 3. PROSES UPDATE DATA
$pesan = "";
if (isset($_POST['update'])) {
    $nim                = $_POST['nim'];
    $nama_lengkap       = $_POST['nama_lengkap'];
    $program_studi      = $_POST['program_studi'];
    $semester           = $_POST['semester'];
    $jenis_kelamin      = $_POST['jenis_kelamin'];
    $no_hp              = $_POST['no_hp'];
    $email              = $_POST['email'];
    $alamat             = $_POST['alamat'];
    $id_kegiatan        = $_POST['id_kegiatan']; // Mengambil nilai kegiatan baru
    $status_pendaftaran = $_POST['status_pendaftaran'];

    // Update data berdasarkan id_peserta yang aktif
    $query_update = "UPDATE peserta SET 
                    nim = '$nim', 
                    nama_lengkap = '$nama_lengkap', 
                    program_studi = '$program_studi', 
                    semester = '$semester', 
                    jenis_kelamin = '$jenis_kelamin', 
                    no_hp = '$no_hp', 
                    email = '$email', 
                    alamat = '$alamat', 
                    id_kegiatan = '$id_kegiatan',
                    status_pendaftaran = '$status_pendaftaran' 
                    WHERE id_peserta = '$id_peserta'";

    if (mysqli_query($koneksi, $query_update)) {
        // Redirect kembali dengan menyertakan id dan status sukses
        header("Location: edit_data.php?id=$id_peserta&status=sukses");
        exit();
    } else {
        $pesan = "<div class='alert alert-danger'>Aduh eror Rida, ini pesan erornya: " . mysqli_error($koneksi) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Peserta</title>
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
            <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
            <a href="form_daftar.php"><i class="bi bi-pencil-square"></i> Form Pendaftaran</a>
            <a href="data_peserta.php"><i class="bi bi-people"></i> Data Peserta</a>
            <a href="edit_data.php" class="active"><i class="bi bi-pencil-square"></i> Edit Peserta</a>
            <a href="kegiatan.php"><i class="bi bi-calendar-event"></i> Data Kegiatan</a>
            <a href="index.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
        </nav>
    </aside>

    <!-- Content -->
    <main class="content">
        <section class="topbar">
            <div>
                <p class="label">Edit Peserta</p>
                <h2>Perbarui Data Peserta</h2>
                <p class="text-muted">Halaman ini digunakan untuk mengubah data peserta yang telah melakukan pendaftaran.</p>
            </div>
        </section>

        <!-- HERO -->
        <section class="hero-dashboard mb-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2>✏️ Edit Data Peserta</h2>
                    <p>Lakukan perubahan data peserta apabila terdapat kesalahan informasi ataupun perubahan status pendaftaran.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="hero-time">
                        <h3 id="jam">00:00:00</h3>
                        <span id="tanggal">Kamis, 9 Juli 2026</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- FORM BOX -->
        <section class="card-box mb-4">
            <div class="section-title">
                <h3><i class="bi bi-pencil-square text-primary"></i> Edit Informasi Peserta</h3>
                <span>Perbarui data</span>
            </div>

            <!-- Notifikasi Transaksi -->
            <?php 
            echo $pesan; 
            if (isset($_GET['status']) && $_GET['status'] == 'sukses') {
                echo "<div class='alert alert-success'>🎉 Data Berhasil Diperbarui!</div>";
            }
            ?>

            <form id="formEdit" class="row g-4" method="POST" action="" enctype="multipart/form-data">
                
                <!-- Nama Lengkap -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-person-fill text-primary"></i> Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control" value="<?php echo htmlspecialchars($data['nama_lengkap'] ?? ''); ?>" placeholder="Masukkan nama lengkap" required>
                </div>

                <!-- NIM -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-credit-card-fill text-primary"></i> NIM</label>
                    <input type="text" name="nim" class="form-control" value="<?php echo htmlspecialchars($data['nim'] ?? ''); ?>" placeholder="Masukkan NIM" required>
                </div>

                <!-- Program Studi -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-mortarboard-fill text-primary"></i> Program Studi</label>
                    <input type="text" name="program_studi" class="form-control" value="<?php echo htmlspecialchars($data['program_studi'] ?? ''); ?>" placeholder="Masukkan program studi">
                </div>

                <!-- Semester -->
                <div class="col-md-3">
                    <label class="form-label"><i class="bi bi-book-fill text-primary"></i> Semester</label>
                    <select name="semester" class="form-select">
                        <?php 
                        for ($i = 1; $i <= 8; $i++) {
                            $selected = (($data['semester'] ?? 3) == $i) ? 'selected' : '';
                            echo "<option value='$i' $selected>$i</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Nomor HP -->
                <div class="col-md-3">
                    <label class="form-label"><i class="bi bi-phone-fill text-primary"></i> Nomor HP</label>
                    <input type="text" name="no_hp" class="form-control" value="<?php echo htmlspecialchars($data['no_hp'] ?? ''); ?>">
                </div>

                <!-- Email -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-envelope-fill text-primary"></i> Email</label>
                    <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($data['email'] ?? ''); ?>">
                </div>

                <!-- Kegiatan (SUDAH AKTIF DAN AMBIL DARI DATABASE) -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-calendar-event-fill text-primary"></i> Kegiatan</label>
                    <select name="id_kegiatan" class="form-select">
                        <?php while($kegiatan = mysqli_fetch_assoc($data_kegiatan)){ ?>
                            <option value="<?= $kegiatan['id_kegiatan']; ?>" <?= (($data['id_kegiatan'] ?? '') == $kegiatan['id_kegiatan']) ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($kegiatan['nama_kegiatan']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Status Pendaftaran -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-check-circle-fill text-primary"></i> Status Peserta</label>
                    <select name="status_pendaftaran" class="form-select">
                        <option value="terdaftar" <?php echo (($data['status_pendaftaran'] ?? '') == 'terdaftar') ? 'selected' : ''; ?>>Terdaftar</option>
                        <option value="hadir" <?php echo (($data['status_pendaftaran'] ?? '') == 'hadir') ? 'selected' : ''; ?>>Hadir</option>
                        <option value="batal" <?php echo (($data['status_pendaftaran'] ?? '') == 'batal') ? 'selected' : ''; ?>>Batal</option>
                    </select>
                </div>

                <!-- Alamat -->
                <div class="col-12">
                    <label class="form-label"><i class="bi bi-geo-alt-fill text-primary"></i> Alamat</label>
                    <textarea name="alamat" class="form-control" rows="4"><?php echo htmlspecialchars($data['alamat'] ?? ''); ?></textarea>
                </div>

                <!-- Upload Foto -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-image-fill text-primary"></i> Foto Peserta</label>
                    <input type="file" name="foto" class="form-control" accept="image/*">
                </div>

                <!-- Jenis Kelamin -->
                <div class="col-md-6">
                    <label class="form-label"><i class="bi bi-gender-ambiguous text-primary"></i> Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select">
                        <option value="Laki-laki" <?php echo (($data['jenis_kelamin'] ?? '') == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="Perempuan" <?php echo (($data['jenis_kelamin'] ?? '') == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>

                <!-- Tombol -->
                <div class="col-12 mt-3">
                    <button type="submit" name="update" class="btn btn-primary me-2">
                        <i class="bi bi-save-fill"></i> Update Data
                    </button>
                    <!-- Menggunakan tipe button + fungsi JS kosongkanForm -->
                    <button type="button" onclick="kosongkanForm()" class="btn btn-outline-secondary me-2">
                        <i class="bi bi-arrow-clockwise"></i> Reset
                    </button>
                    <a href="data_peserta.php" class="btn btn-success">
                        <i class="bi bi-arrow-left-circle"></i> Kembali
                    </a>
                </div>
            </form>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <p>© 2026 Sistem Pendaftaran Kegiatan Kampus <br> Dibuat untuk memenuhi tugas Pemrograman Web.</p>
        </footer>
    </main>

    <!-- Script Jam & Fungsi Mengosongkan Form -->
    <script>
    function updateJam(){
        const sekarang = new Date();
        document.getElementById("jam").innerHTML = sekarang.toLocaleTimeString("id-ID");
        document.getElementById("tanggal").innerHTML = sekarang.toLocaleDateString("id-ID",{
            weekday:"long", day:"numeric", month:"long", year:"numeric"
        });
    }
    setInterval(updateJam,1000);
    updateJam();

    // JAVASCRIPT UNTUK MENGOSONGKAN FORM TOTAL
    function kosongkanForm() {
        // Ambil elemen form berdasarkan ID
        const form = document.getElementById("formEdit");
        
        // Bersihkan seluruh tipe input teks, email, file, dan textarea
        const inputs = form.querySelectorAll('input[type="text"], input[type="email"], input[type="file"], textarea');
        inputs.forEach(input => input.value = '');

        // Kembalikan semua elemen dropdown select ke baris pilihan pertama (paling atas)
        const selects = form.querySelectorAll('select');
        selects.forEach(select => select.selectedIndex = 0);
    }
    </script>
</body>
</html>