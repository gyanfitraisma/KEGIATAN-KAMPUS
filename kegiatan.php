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
      <a href="form-daftar.php"><i class="bi bi-pencil-square"></i> Form Pendaftaran</a>
      <a href="data-peserta.php"><i class="bi bi-people"></i> Data Peserta</a>
      <a href="edit-data.php"><i class="bi bi-pencil"></i> Edit Peserta</a>
      <a href="kegiatan.php" class="active"><i class="bi bi-calendar-event"></i> Data Kegiatan</a>
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

<section id="kegiatan" class="card-box">
      <div class="section-title">
        <h3>Data Kegiatan</h3>
        <span>Daftar kegiatan kampus</span>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead>
            <tr>
              <th>Kode</th>
              <th>Nama Kegiatan</th>
              <th>Tanggal</th>
              <th>Lokasi</th>
              <th>Kuota</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>KG001</td>
              <td>Seminar Karier Digital</td>
              <td>2026-07-12</td>
              <td>Aula Kampus</td>
              <td>100</td>
              <td><span class="badge bg-success">Dibuka</span></td>
            </tr>
            <tr>
              <td>KG002</td>
              <td>Workshop UI/UX</td>
              <td>2026-07-18</td>
              <td>Lab Multimedia</td>
              <td>40</td>
              <td><span class="badge bg-warning text-dark">Terbatas</span></td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>



    
  </main>
</body>
</html>