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
      <a href="dashboard.php" ><i class="bi bi-speedometer2"></i> Dashboard</a>
      <a href="form-daftar.php" ><i class="bi bi-pencil-square"></i> Form Pendaftaran</a>
      <a href="data-peserta.php"><i class="bi bi-people"></i> Data Peserta</a>
      <a href="edit-data.php" class="active"><i class="bi bi-pencil"></i> Edit Peserta</a>
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
    </section>

    <section id="edit" class="card-box mb-4">
      <div class="section-title">
        <h3>Edit Data Peserta</h3>
        <span>Template perubahan data</span>
      </div>

      <form action="#" method="post" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="nama_lengkap" class="form-control" value="Aulia Rahma">
        </div>
        <div class="col-md-6">
          <label class="form-label">NIM</label>
          <input type="text" name="nim" class="form-control" value="231001001">
        </div>
        <div class="col-md-6">
          <label class="form-label">Kegiatan</label>
          <select name="id_kegiatan" class="form-select">
            <option selected>Workshop UI/UX</option>
            <option>Seminar Karier Digital</option>
            <option>Lomba Web Design</option>
          </select>
        </div>
        <div class="col-md-6">
          <label class="form-label">Status</label>
          <select name="status_pendaftaran" class="form-select">
            <option selected>Terdaftar</option>
            <option>Hadir</option>
            <option>Batal</option>
          </select>
        </div>
        <div class="col-12">
          <button type="submit" class="btn btn-primary">Update Data</button>
        </div>
      </form>
    </section>



    
  </main>
</body>
</html>