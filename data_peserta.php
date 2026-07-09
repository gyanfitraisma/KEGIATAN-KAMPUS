<?php
include 'koneksi.php';
$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$filter_kegiatan = isset($_GET['filter_kegiatan']) ? $_GET['filter_kegiatan'] : '';

$query = "
    SELECT 
        peserta.*,
        kegiatan.nama_kegiatan
    FROM peserta
    JOIN kegiatan 
        ON peserta.id_kegiatan = kegiatan.id_kegiatan
    WHERE 1=1
";

if ($keyword != '') {
    $query .= "
        AND (
            peserta.nim LIKE '%$keyword%'
            OR peserta.nama_lengkap LIKE '%$keyword%'
        )
    ";
}

if ($filter_kegiatan != '') {
    $query .= "
        AND peserta.id_kegiatan='$filter_kegiatan'
    ";
}

$query .= "
    ORDER BY peserta.id_peserta DESC
";

$data_peserta = mysqli_query($koneksi, $query);

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
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistem Pendaftaran Kegiatan Kampus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<aside class="sidebar">
    <div class="brand">
        <div class="brand-logo">SK</div>
        <div>
            <h1>Sistem Kampus</h1>
            <p>Pendaftaran Kegiatan</p>
        </div>
    </div>

    <nav class="menu">
        <a href="dashboard.php">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="form_daftar.php">
            <i class="bi bi-pencil-square"></i> Form Pendaftaran
        </a>
        <a href="data_peserta.php" class="active">
            <i class="bi bi-people"></i> Data Peserta
        </a>
        <a href="edit_data.php">
            <i class="bi bi-pencil"></i> Edit Peserta
        </a>
        <a href="kegiatan.php">
            <i class="bi bi-calendar-event"></i> Data Kegiatan
        </a>
        <a href="logout.php">
            <i class="bi bi-box-arrow-in-right"></i> Log-out
        </a>
    </nav>
</aside>

<main class="content">
<section class="topbar">
    <div>
        <p class="label">Admin Panel</p>
        <h2>Sistem Pendaftaran Kegiatan Kampus</h2>
        <p class="text-muted">
            Kelola kegiatan, pendaftaran peserta, perubahan data, dan rekap peserta.
        </p>
    </div>
</section>

<section class="card-box mb-4">
<div class="section-title">
    <h3>Daftar Peserta</h3>
    <span>Filter berdasarkan kegiatan</span>
</div>

<form method="get" class="row g-3 mb-3">
    <div class="col-md-5">
        <input 
            type="text"
            name="keyword"
            class="form-control"
            placeholder="Cari nama atau NIM"
            value="<?= htmlspecialchars($keyword); ?>"
        >
    </div>

    <div class="col-md-5">
        <select name="filter_kegiatan" class="form-select">
            <option value="">Semua kegiatan</option>
            <?php while($kegiatan = mysqli_fetch_assoc($data_kegiatan)){ ?>
                <option 
                    value="<?= $kegiatan['id_kegiatan']; ?>"
                    <?= ($filter_kegiatan == $kegiatan['id_kegiatan']) ? 'selected' : ''; ?>
                >
                    <?= htmlspecialchars($kegiatan['nama_kegiatan']); ?>
                </option>
            <?php } ?>
        </select>
    </div>

    <div class="col-md-2">
        <button type="submit" class="btn btn-success w-100">
            <i class="bi bi-funnel"></i> Filter
        </button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-hover align-middle">
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
        <tbody>
        <?php
        $no = 1;
        while($peserta = mysqli_fetch_assoc($data_peserta)){
        ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= htmlspecialchars($peserta['nim']); ?></td>
                <td><?= htmlspecialchars($peserta['nama_lengkap']); ?></td>
                <td><?= htmlspecialchars($peserta['program_studi']); ?></td>
                <td><?= htmlspecialchars($peserta['nama_kegiatan']); ?></td>
                <td>
                    <?php if($peserta['status_pendaftaran'] == 'hadir'){ ?>
                        <span class="badge bg-primary">Hadir</span>
                    <?php } elseif($peserta['status_pendaftaran'] == 'batal'){ ?>
                        <span class="badge bg-danger">Batal</span>
                    <?php } else { ?>
                        <span class="badge bg-success">Terdaftar</span>
                    <?php } ?>
                </td>
                <td>
                    <a href="edit_data.php?id=<?= $peserta['id_peserta']; ?>" class="btn btn-sm btn-warning">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <!-- BAGIAN INI SUDAH DIPERBAIKI MENJADI DINAMIS SESUAI ID DATA -->
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>