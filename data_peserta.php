<?php
    include 'koneksi.php';
    // mengambil keyword pencarian
    $keyword = isset($_GET['keyword']) 
                ? $_GET['keyword'] 
                : "";
    // mengambil filter kegiatan
    $filter_kegiatan = isset($_GET['filter_kegiatan']) 
                        ? $_GET['filter_kegiatan'] 
                        : "";
    $query = "
        SELECT 
            peserta.*,
            kegiatan.nama_kegiatan
        FROM peserta
        JOIN kegiatan 
            ON peserta.id_kegiatan = kegiatan.id_kegiatan

        WHERE 1=1
    ";

    // pencarian berdasarkan nama atau NIM
    if ($keyword != "") {

        $query .= "
            AND (
                peserta.nim 
                    LIKE '%$keyword%'
                OR
                peserta.nama_lengkap 
                    LIKE '%$keyword%'
            )
        ";

    }

    // filter berdasarkan kegiatan
    if ($filter_kegiatan != "") {
        $query .= "
            AND kegiatan.id_kegiatan 
                = '$filter_kegiatan'
        ";

    }

    $query .= "
        ORDER BY 
            peserta.id_peserta DESC
    ";

    $data_peserta = mysqli_query(
        $koneksi,
        $query
    );
    // mengambil data kegiatan untuk pilihan filter
    $data_kegiatan = mysqli_query(
        $koneksi,

        "
            SELECT * 
            FROM kegiatan

            ORDER BY 
                nama_kegiatan ASC
        "
    );
?>

<!doctype html>
<html lang="id">
<head>

    <meta charset="utf-8">
    <meta name="viewport" 
          content="width=device-width, initial-scale=1">

    <title>
        Data Peserta
    </title>

    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
        rel="stylesheet">
    <link 
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" 
        rel="stylesheet">
    <link 
        href="assets/css/style.css" 
        rel="stylesheet">
</head>
<body>
    <aside class="sidebar">
        <div class="brand">

            <div class="brand-logo">
                SK
            </div>

            <div>
                <h1>
                    Sistem Kampus
                </h1>
                <p>
                    Pendaftaran Kegiatan
                </p>
            </div>
        </div>

        <nav class="menu">
            <a href="dashboard.php">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>

            <a href="form-daftar.php">
                <i class="bi bi-pencil-square"></i>
                Form Pendaftaran
            </a>

            <a href="data-peserta.php" 
               class="active">
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

            <a href="logout.php">
                <i class="bi bi-box-arrow-in-right"></i>
                Log-out
            </a>
        </nav>
    </aside>

    <main class="content">

        <section class="topbar">
            <div>
                <p class="label">
                    Admin Panel
                </p>
                <h2>
                    Sistem Pendaftaran Kegiatan Kampus
                </h2>

                <p class="text-muted">

                    Kelola kegiatan, pendaftaran peserta,
                    perubahan data, dan rekap peserta.

                </p>
            </div>
        </section>
        <section class="card-box mb-4">
            <div class="section-title">
                <h3>
                    Daftar Peserta
                </h3>
                <span>
                    Filter berdasarkan kegiatan
                </span>
            </div>