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

            <a href="form-daftar.php" class="active">
                <i class="bi bi-pencil-square"></i>
                Form Pendaftaran
            </a>

            <a href="data-peserta.php">
                <i class="bi bi-people"></i>
                Data Peserta
            </a>

            <a href="edit-data.php">
                <i class="bi bi-pencil"></i>
                Edit Peserta
            </a>

            <a href="kegiatan.php">
                <i class="bi bi-calendar-event"></i>
                Data Kegiatan
            </a>

            <a href="index.php">
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
                <a href="data-peserta.html" class="btn btn-primary">
                    <i class="bi bi-people-fill"></i>
                    Lihat Data Peserta
                </a>
            </div>
        </section>
        <!-- HERO -->

        <section class="hero-dashboard mb-4">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2>
                        📝 Formulir Pendaftaran Peserta
                    </h2>
                    <p>
                        Silakan lengkapi data mahasiswa yang akan mengikuti
                        kegiatan kampus. Pastikan seluruh informasi sudah benar
                        sebelum menekan tombol simpan.
                    </p>
                </div>

                <div class="col-lg-4 text-lg-end">
                    <div class="hero-time">
                        <h3 id="jam">
                            00:00:00
                        </h3>
                        <span id="tanggal">
                            Senin, 1 Januari 2026
                        </span>
                    </div>
                </div>
            </div>
        </section>

        <!-- CARD FORM -->
        <section class="card-box mb-4">
            <div class="section-title">
                <h3>
                    <i class="bi bi-person-plus-fill text-primary"></i>
                    Form Pendaftaran Peserta
                </h3>
                <span>
                    Lengkapi seluruh data
                </span>
            </div>

            <form class="row g-4">
              <!-- Nama Lengkap -->
                <div class="col-md-6">

                    <label class="form-label">
                        <i class="bi bi-person-fill text-primary"></i>
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="nama_lengkap"
                        placeholder="Masukkan nama lengkap"
                        required>

                </div>

                <!-- NIM -->
                <div class="col-md-6">

                    <label class="form-label">
                        <i class="bi bi-credit-card-fill text-primary"></i>
                        NIM
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="nim"
                        placeholder="Masukkan NIM"
                        required>

                </div>

                <!-- Program Studi -->
                <div class="col-md-6">

                    <label class="form-label">
                        <i class="bi bi-mortarboard-fill text-primary"></i>
                        Program Studi
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="program_studi"
                        placeholder="Contoh : Pendidikan Teknologi Informasi"
                        required>

                </div>

                <!-- Semester -->
                <div class="col-md-3">

                    <label class="form-label">
                        <i class="bi bi-book-half text-primary"></i>
                        Semester
                    </label>

                    <select
                        class="form-select"
                        name="semester"
                        required>

                        <option value="">Pilih Semester</option>

                        <option>1</option>
                        <option>2</option>
                        <option>3</option>
                        <option>4</option>
                        <option>5</option>
                        <option>6</option>
                        <option>7</option>
                        <option>8</option>

                    </select>

                </div>

                <!-- Nomor HP -->
                <div class="col-md-3">

                    <label class="form-label">
                        <i class="bi bi-phone-fill text-primary"></i>
                        Nomor HP
                    </label>

                    <input
                        type="tel"
                        class="form-control"
                        name="no_hp"
                        placeholder="08xxxxxxxxxx"
                        required>

                </div>

                <!-- Email -->
                <div class="col-md-6">

                    <label class="form-label">
                        <i class="bi bi-envelope-fill text-primary"></i>
                        Email
                    </label>

                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        placeholder="nama@email.com"
                        required>

                </div>

                <!-- Pilihan Kegiatan -->
                <div class="col-md-6">

                    <label class="form-label">
                        <i class="bi bi-calendar-event-fill text-primary"></i>
                        Pilih Kegiatan
                    </label>

                    <select
                        class="form-select"
                        name="kegiatan"
                        required>

                        <option value="">Pilih Kegiatan</option>

                        <option>Seminar Karier Digital</option>

                        <option>Workshop UI / UX</option>

                        <option>Lomba Web Design</option>

                        <option>Pelatihan Public Speaking</option>

                        <option>Seminar Artificial Intelligence</option>

                    </select>

                </div>

                <!-- Alamat -->
                <div class="col-12">

                    <label class="form-label">
                        <i class="bi bi-geo-alt-fill text-primary"></i>
                        Alamat
                    </label>

                    <textarea
                        class="form-control"
                        rows="4"
                        placeholder="Masukkan alamat lengkap..."
                        required></textarea>
                </div>
                <!-- Upload Foto -->

                <div class="col-md-6">

                    <label class="form-label">
                        <i class="bi bi-image-fill text-primary"></i>
                        Upload Foto
                    </label>

                    <input
                        type="file"
                        class="form-control"
                        accept="image/*">
                </div>

                <!-- Jenis Kelamin -->
                <div class="col-md-6">
                    <label class="form-label">
                        <i class="bi bi-gender-ambiguous text-primary"></i>
                        Jenis Kelamin
                    </label>
                    <select class="form-select" required>
                        <option value="">Pilih Jenis Kelamin</option>
                        <option>Laki-laki</option>
                        <option>Perempuan</option>
                    </select>
                </div>

                <!-- Tombol -->

                <div class="col-12 mt-3">

                    <button
                        type="submit"
                        class="btn btn-primary me-2">
                        <i class="bi bi-check-circle-fill"></i>
                        Simpan Data
                    </button>

                    <button
                        type="reset"
                        class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-clockwise"></i>
                        Reset Form
                    </button>
                </div>
            </form>
        </section>
        <!-- Footer -->
        <footer class="footer mt-4">
            <p>
                © 2026 Sistem Pendaftaran Kegiatan Kampus
                <br>
                Dibuat untuk memenuhi tugas Pemrograman Web.
            </p>
        </footer>
    </main>

    <!-- Jam Otomatis -->
    <script>
    function updateJam(){
        const sekarang = new Date();

        document.getElementById("jam").innerHTML =
            sekarang.toLocaleTimeString("id-ID");

        document.getElementById("tanggal").innerHTML =
            sekarang.toLocaleDateString("id-ID",{
                weekday:"long",
                day:"numeric",
                month:"long",
                year:"numeric"
            });
    }
    setInterval(updateJam,1000);
    updateJam();
    </script>