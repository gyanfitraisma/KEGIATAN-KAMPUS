<?php
// Menyertakan file konfigurasi untuk menghubungkan script dengan database MySQL
include 'koneksi.php';

// Mengambil kata kunci pencarian dari URL (metode GET) jika ada, jika tidak ada diset string kosong
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
// Mengambil ID kegiatan dari dropdown filter jika dipilih, jika tidak ada diset string kosong
$filter_kegiatan = isset($_GET['filter_kegiatan']) ? $_GET['filter_kegiatan'] : '';

// Menyusun query SQL dasar untuk mengambil data peserta dan menggabungkannya (JOIN) dengan tabel kegiatan
$query = "
    SELECT 
        peserta.*,
        kegiatan.nama_kegiatan
    FROM peserta
    JOIN kegiatan 
        ON peserta.id_kegiatan = kegiatan.id_kegiatan
    WHERE 1=1
";

// Kondisi tambahan jika pengguna mengetikkan kata kunci pencarian (NIM atau Nama Lengkap)
if ($keyword != '') {
    $query .= "
        AND (
            peserta.nim LIKE '%$keyword%'
            OR peserta.nama_lengkap LIKE '%$keyword%'
        )
    ";
}

// Kondisi tambahan jika pengguna memilih filter berdasarkan kegiatan tertentu
if ($filter_kegiatan != '') {
    $query .= "
        AND peserta.id_kegiatan='$filter_kegiatan'
    ";
}

// Mengurutkan data peserta dari yang paling baru mendaftar (berdasarkan ID terbesar)
$query .= "
    ORDER BY peserta.id_peserta DESC
";

// Mengeksekusi query data peserta yang sudah disusun ke database
$data_peserta = mysqli_query($koneksi, $query);

// Mengambil seluruh data kegiatan untuk ditampilkan ke dalam pilihan (dropdown) filter
$data_kegiatan = mysqli_query(
    $koneksi,
    "
    SELECT *
    FROM kegiatan
    ORDER BY nama_kegiatan ASC
    "
);
?>

<!doctype html>
<!-- Mendeklarasikan tipe dokumen sebagai HTML5 dengan konfigurasi bahasa Indonesia -->
<html lang="id">
<head>
    <!-- Menetapkan sistem pengodean karakter universal dokumen menggunakan UTF-8 -->
    <meta charset="utf-8">
    <!-- Mengonfigurasi tampilan agar tata letak berskala responsif di semua resolusi layar -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Menentukan judul halaman resmi pada tab browser pengguna -->
    <title>Sistem Pendaftaran Kegiatan Kampus</title>
    <!-- Memuat file CSS framework Bootstrap 5 untuk standarisasi layout komponen antarmuka -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Memuat file CSS ikon bawaan dari Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Menyertakan file CSS kustom eksternal untuk gaya tampilan lokal khas dashboard -->
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

    <!-- Area Menu Samping (Sidebar) Navigasi Utama Admin -->
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
            <a href="dashboard.php">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <!-- Tautan menuju ke formulir input data peserta baru -->
            <a href="form_daftar.php">
                <i class="bi bi-pencil-square"></i> Form Pendaftaran
            </a>
            <!-- Tautan navigasi aktif saat ini yang mengarah ke manajemen data peserta -->
            <a href="data_peserta.php" class="active">
                <i class="bi bi-people"></i> Data Peserta
            </a>
            <!-- Tautan navigasi untuk membuka daftar tabel database kegiatan -->
            <a href="kegiatan.php">
                <i class="bi bi-calendar-event"></i> Data Kegiatan
            </a>
            <!-- Tautan pengakhiran sesi masuk untuk keluar dari sistem aplikasi secara aman -->
            <a href="logout.php">
                <i class="bi bi-box-arrow-in-right"></i> Log-out
            </a>
        </nav>
    </aside>

    <!-- Area Utama Pembungkus Seluruh Informasi Halaman -->
    <main class="content">
        <section class="topbar">
            <div>
                <p class="label">Data Peserta</p>
                <h2>Sistem Pendaftaran Kegiatan Kampus</h2>
                <p class="text-muted">
                    Kelola kegiatan, pendaftaran peserta, perubahan data, dan rekap peserta.
                </p>
            </div>
        </section>

        <!-- Banner Hero Gradient -->
        <section class="hero-dashboard mb-4" style="background: linear-gradient(135deg, #1d72b8 0%, #34a853 100%); color: white; padding: 30px; border-radius: 15px;">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h2><i class="bi bi-people"></i> Data Peserta Kegiatan</h2>
                    <p class="mb-0">Pusat informasi dan manajemen data pendaftaran mahasiswa untuk seluruh agenda kegiatan kampus yang sedang berjalan.</p>
                </div>
                <div class="col-lg-4 text-lg-end">
                    <div class="hero-time">
                        <h3 id="jam">00:00:00</h3>
                        <span id="tanggal">Senin, 1 Januari 2026</span>
                    </div>
                </div>
            </div>
        </section>

        <!-- TAMPILAN NOTIFIKASI ALERT BOOTSTRAP (DARI URL) -->
        <?php if (isset($_GET['status']) && $_GET['status'] == 'hapus_sukses'): ?>
            <div class="alert alert-danger alert-dismissible fade show mb-4 d-flex align-items-center shadow-sm" role="alert" style="border-radius: 10px; border-left: 5px solid #dc3545;">
                <i class="bi bi-trash-fill text-danger me-3 fs-4"></i>
                <div>
                    <strong>Data Berhasil Dihapus!</strong> Akun peserta tersebut telah dikeluarkan dari sistem pendaftaran.
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'hapus_gagal'): ?>
            <div class="alert alert-warning alert-dismissible fade show mb-4 d-flex align-items-center shadow-sm" role="alert" style="border-radius: 10px; border-left: 5px solid #ffc107;">
                <i class="bi bi-exclamation-triangle-fill text-warning me-3 fs-4"></i>
                <div>
                    <strong>Proses Gagal!</strong> Data peserta tidak ditemukan atau telah dihapus sebelumnya.
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Kotak kartu pembungkus utama form pencarian/filter dan tabel daftar data -->
        <section class="card-box mb-4">
            <!-- Bagian header judul komponen di dalam kotak kartu -->
            <div class="section-title">
                <h3>Daftar Peserta</h3>
                <!-- Teks penunjuk fungsi filter yang sudah disesuaikan dan konsisten -->
                <span class="text-muted">Filter berdasarkan kegiatan</span>
            </div>

            <!-- Form Pencarian dan Filter Menggunakan Metode GET -->
            <form method="get" class="row g-3 mb-3">
                <!-- Kolom input untuk pencarian kata kunci Nama atau NIM -->
                <div class="col-md-5">
                    <input 
                        type="text"
                        id="inputCari"
                        name="keyword"
                        class="form-control"
                        placeholder="Cari nama atau NIM..."
                        value="<?= htmlspecialchars($keyword); ?>"
                    >
                </div>

                <!-- Kolom pilihan (Dropdown) untuk memfilter data berdasarkan nama kegiatan -->
                <div class="col-md-5">
                    <select name="filter_kegiatan" class="form-select">
                        <option value="">Semua kegiatan</option>
                        <?php 
                        // Melakukan perulangan untuk menampilkan semua daftar kegiatan dari database ke opsi pilihan
                        while($kegiatan = mysqli_fetch_assoc($data_kegiatan)){ 
                        ?>
                            <option 
                                value="<?= $kegiatan['id_kegiatan']; ?>"
                                <!-- Menandai 'selected' otomatis jika kegiatan ini sedang dipilih sebagai filter -->
                                <?= ($filter_kegiatan == $kegiatan['id_kegiatan']) ? 'selected' : ''; ?>
                            >
                                <?= htmlspecialchars($kegiatan['nama_kegiatan']); ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>

                <!-- Tombol Submit untuk memproses penyaringan data -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success w-100">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                </div>
            </form>

            <!-- Wadah penampung responsif agar tabel tetap rapi jika diakses dari layar kecil -->
            <div class="table-responsive">
                <!-- Elemen tabel Bootstrap dengan efek sorot baris dan perataan vertikal tengah -->
                <table class="table table-hover align-middle">
                    <!-- Bagian kepala judul kolom tabel -->
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Prodi</th>
                            <th>Kegiatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <!-- Mengunci ID body tabel agar bisa dibaca oleh sistem Live Search JavaScript -->
                    <tbody id="tabelPeserta">
                    <?php
                    // Menginisialisasi variabel nomor urut baris data tabel
                    $no = 1;
                    // Melakukan perulangan data baris hasil query dari tabel database peserta
                    while($peserta = mysqli_fetch_assoc($data_peserta)){
                    ?>
                        <!-- Menampilkan baris data dari database ke dalam baris tabel HTML -->
                        <tr>
                            <!-- Menampilkan nomor urut yang bertambah otomatis setiap barisnya -->
                            <td><?= $no++; ?></td>
                            <!-- Menampilkan NIM peserta secara aman dengan penyaringan htmlspecialchars -->
                            <td><?= htmlspecialchars($peserta['nim']); ?></td>
                            <!-- Menampilkan Nama Lengkap peserta secara aman -->
                            <td><?= htmlspecialchars($peserta['nama_lengkap']); ?></td>
                            <!-- Menampilkan Program Studi peserta -->
                            <td><?= htmlspecialchars($peserta['program_studi']); ?></td>
                            <!-- Menampilkan Nama Kegiatan hasil relasi JOIN antar tabel -->
                            <td><?= htmlspecialchars($peserta['nama_kegiatan']); ?></td>
                            <!-- Logika pencetakan label warna (Badge) berdasarkan status kehadiran peserta -->
                            <td>
                                <?php if($peserta['status_pendaftaran'] == 'hadir'){ ?>
                                    <span class="badge bg-primary">Hadir</span>
                                <?php } elseif($peserta['status_pendaftaran'] == 'batal'){ ?>
                                    <span class="badge bg-danger">Batal</span>
                                <?php } else { ?>
                                    <span class="badge bg-success">Terdaftar</span>
                                <?php } ?>
                            </td>
                            <!-- Kolom aksi tombol edit dan hapus data -->
                            <td>
                                <!-- Tombol arah tautan menuju ke form pengeditan data berdasarkan ID peserta -->
                                <a href="edit_data.php?id=<?= $peserta['id_peserta']; ?>" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <!-- Tombol hapus data secara dinamis berdasarkan ID peserta yang bersangkutan -->
                                <a href="hapus_peserta.php?id=<?= $peserta['id_peserta']; ?>" 
                                   onclick="return confirm('Yakin ingin menghapus data milik <?= htmlspecialchars($peserta['nama_lengkap']); ?>?')" 
                                   class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Hapus
                                </a>
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

    <!-- SCRIPT LIVE SEARCH JAVASCRIPT & JAM DIGITAL -->
    <script>
    // Fungsi untuk memproses jalannya Jam Digital secara real-time waktu lokal
    function updateJam(){
        const sekarang = new Date();
        // Mengubah tampilan teks jam dengan format lokal regional Indonesia
        document.getElementById("jam").innerHTML = sekarang.toLocaleTimeString("id-ID");
        // Mengubah tampilan susunan teks penanggalan hari, tanggal, bulan, dan tahun Indonesia
        document.getElementById("tanggal").innerHTML = sekarang.toLocaleDateString("id-ID",{
            weekday:"long",
            day:"numeric",
            month:"long",
            year:"numeric"
        });
    }
    // Mengatur agar fungsi updateJam dieksekusi berulang otomatis setiap 1 detik (1000 milidetik)
    setInterval(updateJam, 1000);
    // Memanggil fungsi pertama kali saat halaman selesai dimuat agar tidak ada jeda kosong
    updateJam();

    // Fungsi pencarian langsung (Live Search) tanpa reload halaman saat mengetik kata kunci
    document.getElementById('inputCari').addEventListener('keyup', function() {
        // Mengubah teks inputan pengguna menjadi huruf kecil semua agar pencarian tidak sensitif huruf kapital
        let kataKunci = this.value.toLowerCase();
        // Mengambil seluruh elemen baris (tr) data yang ada di dalam body tabel peserta
        let barisTabel = document.querySelectorAll('#tabelPeserta tr');

        // Melakukan perulangan untuk memeriksa konten di setiap baris tabel satu per satu
        barisTabel.forEach(function(baris) {
            // Mengambil elemen kolom NIM (indeks kolom ke-1) dan kolom Nama (indeks kolom ke-2)
            let kolomNim = baris.getElementsByTagName('td')[1];
            let kolomNama = baris.getElementsByTagName('td')[2];
            
            // Memastikan elemen kolom tersebut eksis/ada pada baris yang sedang diperiksa
            if (kolomNim && kolomNama) {
                // Mengambil teks murni di dalam kolom NIM dan kolom Nama
                let teksNim = kolomNim.textContent || kolomNim.innerText;
                let teksNama = kolomNama.textContent || kolomNama.innerText;
                
                // Mengecek apakah kata kunci yang diketik cocok/ada di dalam teks Nama ATAU teks NIM
                if (teksNama.toLowerCase().indexOf(kataKunci) > -1 || teksNim.toLowerCase().indexOf(kataKunci) > -1) {
                    // Jika cocok, biarkan baris tetap tampil di layar
                    baris.style.display = "";
                } else {
                    // Jika tidak cocok, sembunyikan baris tersebut dari tampilan layar
                    baris.style.display = "none";
                }
            }
        });
    });
    </script>
</body>
</html>