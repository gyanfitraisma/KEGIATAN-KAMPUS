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
      <a href="dashboard.php" class="active"><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a href="form-daftar.php"><i class="bi bi-pencil-square"></i> Form Pendaftaran</a>
      <a href="data-peserta.php"><i class="bi bi-people"></i> Data Peserta</a>
      <a href="edit-data.php"><i class="bi bi-pencil"></i> Edit Peserta</a>
      <a href="kegiatan.php"><i class="bi bi-calendar-event"></i> Data Kegiatan</a>
      <a href="#"><i class="bi bi-box-arrow-in-right"></i> Log-out</a>
    </nav>
  </aside>

  <main class="content">
    <section id="dashboard" class="topbar">
      <div>
        <p class="label">Admin Panel</p>
        <h2>Sistem Pendaftaran Kegiatan Kampus</h2>
        <p class="text-muted">Kelola kegiatan, pendaftaran peserta, perubahan data, dan rekap peserta.</p>
      </div>
      <a href="#pendaftaran" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Daftar Peserta
      </a>
    </section>

    <section class="row g-3 mb-4">
      <div class="col-md-4">
        <div class="stat-card">
          <i class="bi bi-calendar-check"></i>
          <h3>8</h3>
          <p>Kegiatan Aktif</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card">
          <i class="bi bi-people"></i>
          <h3>248</h3>
          <p>Total Peserta</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="stat-card">
          <i class="bi bi-person-check"></i>
          <h3>64</h3>
          <p>Kuota Tersedia</p>
        </div>
      </div>
    </section>



    



    
  </main>
</body>
</html>