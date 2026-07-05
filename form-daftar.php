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
      <a href="form-daftar.php" class="active"><i class="bi bi-pencil-square"></i> Form Pendaftaran</a>
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
    </section>

    

    <section id="pendaftaran" class="card-box mb-4">
      <div class="section-title">
        <h3>Form Pendaftaran Peserta</h3>
        <span>Input data mahasiswa</span>
      </div>

      <form action="#" method="post" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Nama Lengkap</label>
          <input type="text" name="nama_lengkap" class="form-control" placeholder="Masukkan nama lengkap">
        </div>

        <div class="col-md-6">
          <label class="form-label">NIM</label>
          <input type="text" name="nim" class="form-control" placeholder="Masukkan NIM">
        </div>

        <div class="col-md-6">
          <label class="form-label">Program Studi</label>
          <input type="text" name="program_studi" class="form-control" placeholder="Contoh: Sistem Informasi">
        </div>

        <div class="col-md-3">
          <label class="form-label">Semester</label>
          <select name="semester" class="form-select">
            <option value="">Pilih</option>
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

        <div class="col-md-3">
          <label class="form-label">No. HP</label>
          <input type="text" name="no_hp" class="form-control" placeholder="08xxxxxxxxxx">
        </div>

        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input type="email" name="email" class="form-control" placeholder="nama@email.com">
        </div>

        <div class="col-md-6">
          <label class="form-label">Kegiatan</label>
          <select name="id_kegiatan" class="form-select">
            <option value="">Pilih kegiatan</option>
            <option>Seminar Karier Digital</option>
            <option>Workshop UI/UX</option>
            <option>Lomba Web Design</option>
          </select>
        </div>

        <div class="col-12">
          <label class="form-label">Alamat</label>
          <textarea name="alamat" class="form-control" rows="3" placeholder="Masukkan alamat peserta"></textarea>
        </div>

        <div class="col-12">
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Simpan Pendaftaran
          </button>
          <button type="reset" class="btn btn-light">Reset</button>
        </div>
      </form>
    </section>

    
  </main>
</body>
</html>