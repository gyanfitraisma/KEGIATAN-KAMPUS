<?php
session_start();
include "koneksi.php";

// Cek login
if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

// Proses simpan data
if (isset($_POST['simpan'])) {

    $id_kegiatan = mysqli_real_escape_string($conn, $_POST['id_kegiatan']);
    $nama_lengkap = mysqli_real_escape_string($conn, $_POST['nama_lengkap']);
    $nim = mysqli_real_escape_string($conn, $_POST['nim']);
    $program_studi = mysqli_real_escape_string($conn, $_POST['program_studi']);
    $semester = mysqli_real_escape_string($conn, $_POST['semester']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['jenis_kelamin']);
    $no_hp = mysqli_real_escape_string($conn, $_POST['no_hp']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);

    // Upload Foto
    $foto = "";

    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {

        $foto = time() . "_" . basename($_FILES['foto']['name']);

        move_uploaded_file(
            $_FILES['foto']['tmp_name'],
            "upload/" . $foto
        );
    }

    $query = mysqli_query($conn, "
        INSERT INTO peserta
        (
            id_kegiatan,
            nim,
            nama_lengkap,
            program_studi,
            semester,
            jenis_kelamin,
            no_hp,
            email,
            alamat,
            foto,
            status_pendaftaran
        )
        VALUES
        (
            '$id_kegiatan',
            '$nim',
            '$nama_lengkap',
            '$program_studi',
            '$semester',
            '$jenis_kelamin',
            '$no_hp',
            '$email',
            '$alamat',
            '$foto',
            'terdaftar'
        )
    ");

    if ($query) {
        echo "<script>
                alert('Data peserta berhasil disimpan!');
                window.location='data_peserta.php';
              </script>";
        exit;
    } else {
        echo "<script>
                alert('Gagal menyimpan data!');
              </script>";
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

<body>

    <!-- ================= SIDEBAR ================= -->

    <aside class="sidebar">

        <div class="brand">

            <div class="brand-logo">
                SK
            </div>

            <div>
                <h1>Sistem Kampus</h1>
                <p>Pendaftaran Kegiatan</p>
            </div>

        </div>

        <nav class="menu">

            <a href="dashboard.php">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <a href="form_daftar.php" class="active">
                <i class="bi bi-pencil-square"></i>
                Form Pendaftaran
            </a>

            <a href="data_peserta.php">
                <i class="bi bi-people"></i>
                Data Peserta
            </a>

            <a href="edit_data.php">
                <i class="bi bi-pencil"></i>
                Edit Peserta
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

    <!-- ================= CONTENT ================= -->
    <main class="content">
        
    <!-- Header -->
    <section class="topbar">
        <div>
            <p class="label">
                Form Pendaftaran
            </p>

            <h2>
                Pendaftaran Peserta Kegiatan Kampus
            </h2>

            <p class="text-muted">
                Isi seluruh data peserta dengan lengkap dan benar agar proses
                pendaftaran dapat diproses oleh admin.
            </p>
        </div>

        <div>
            <a href="data_peserta.php" class="btn btn-primary">
                <i class="bi bi-people-fill"></i>
                Lihat Data Peserta
            </a>
        </div>
    </section>

    <!-- HERO -->
    <section class="hero-dashboard mb-4">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h2>📝 Formulir Pendaftaran Peserta</h2>
                <p>
                    Silakan lengkapi data mahasiswa yang akan mengikuti
                    kegiatan kampus.
                </p>
            </div>

            <div class="col-lg-4 text-lg-end">
                <div class="hero-time">
                    <h3 id="jam">00:00:00</h3>
                    <span id="

                <!-- Footer -->
        <footer class="footer mt-4">
            <p>
                © <?php echo date("Y"); ?> Sistem Pendaftaran Kegiatan Kampus
                <br>
                Dibuat untuk memenuhi tugas Pemrograman Web.
            </p>
        </footer>
    </main>

    <!-- Jam Otomatis -->
    <script>
    function updateJam() {
        const sekarang = new Date();

        document.getElementById("jam").innerHTML =
            sekarang.toLocaleTimeString("id-ID");

        document.getElementById("tanggal").innerHTML =
            sekarang.toLocaleDateString("id-ID", {
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