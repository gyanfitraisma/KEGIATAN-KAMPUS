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
      <a href="data-peserta.php" class="active"><i class="bi bi-people"></i> Data Peserta</a>
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
    </section>

    <section id="peserta" class="card-box mb-4">
      <div class="section-title">
        <h3>Daftar Peserta</h3>
        <span>Filter berdasarkan kegiatan</span>
      </div>

      <form action="#" method="get" class="row g-3 mb-3">
        <div class="col-md-5">
          <input type="text" name="keyword" class="form-control" placeholder="Cari nama atau NIM">
        </div>
        <div class="col-md-5">
          <select name="filter_kegiatan" class="form-select">
            <option value="">Semua kegiatan</option>
            <option>Seminar Karier Digital</option>
            <option>Workshop UI/UX</option>
            <option>Lomba Web Design</option>
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
            <tr>
              <td>1</td>
              <td>231001001</td>
              <td>Aulia Rahma</td>
              <td>Sistem Informasi</td>
              <td>Workshop UI/UX</td>
              <td><span class="badge bg-success">Terdaftar</span></td>
              <td>
                <a href="#edit" class="btn btn-sm btn-warning">Edit</a>
                <button class="btn btn-sm btn-danger">Hapus</button>
              </td>
            </tr>
            <tr>
              <td>2</td>
              <td>231001002</td>
              <td>Rizky Pratama</td>
              <td>Teknik Informatika</td>
              <td>Seminar Karier Digital</td>
              <td><span class="badge bg-primary">Hadir</span></td>
              <td>
                <a href="#edit" class="btn btn-sm btn-warning">Edit</a>
                <button class="btn btn-sm btn-danger">Hapus</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>



    
  </main>
</body>
</html>