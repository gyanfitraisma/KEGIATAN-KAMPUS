-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2026 at 05:25 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kegiatan_kampus`
--

-- --------------------------------------------------------

--
-- Table structure for table `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `kode_kegiatan` varchar(20) NOT NULL,
  `nama_kegiatan` varchar(150) NOT NULL,
  `kategori` enum('Seminar','Workshop','Lomba','Pelatihan','Lainnya') NOT NULL,
  `tanggal` date NOT NULL,
  `waktu_mulai` time NOT NULL,
  `waktu_selesai` time DEFAULT NULL,
  `lokasi` varchar(150) NOT NULL,
  `kuota` int(11) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `status` enum('dibuka','ditutup','selesai') NOT NULL DEFAULT 'dibuka',
  `created_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kegiatan`
--

INSERT INTO `kegiatan` (`id_kegiatan`, `kode_kegiatan`, `nama_kegiatan`, `kategori`, `tanggal`, `waktu_mulai`, `waktu_selesai`, `lokasi`, `kuota`, `deskripsi`, `status`, `created_by`, `created_at`, `updated_at`) VALUES
(1, 'KG001', 'Seminar Karier Digital', 'Seminar', '2026-07-12', '09:00:00', '12:00:00', 'Aula Kampus', 100, 'Seminar persiapan karier digital mahasiswa.', 'selesai', 1, '2026-06-29 08:40:17', '2026-06-29 08:40:17'),
(2, 'KG002', 'Workshop UI/UX', 'Workshop', '2026-07-18', '13:00:00', '16:00:00', 'Lab Multimedia', 40, 'Pelatihan dasar desain antarmuka aplikasi.', 'dibuka', 1, '2026-06-29 08:40:17', '2026-06-29 08:40:17'),
(3, 'KG003', 'Lomba Web Design', 'Lomba', '2026-07-25', '08:00:00', '15:00:00', 'Gedung Rektorat', 60, 'Kompetisi desain website antar mahasiswa.', 'dibuka', 2, '2026-06-29 08:40:17', '2026-06-29 08:40:17'),
(4, 'KG004', 'Hackathon / Coding Competition 2026', 'Lomba', '2026-08-05', '08:00:00', '17:00:00', 'Aula Gedung IT', 50, 'Kompetisi coding intensif untuk mahasiswa.', 'dibuka', 1, '2026-07-15 00:00:00', '2026-07-15 00:00:00'),
(5, 'KG005', 'Bootcamp Dasar Pemrograman Python & PHP', 'Pelatihan', '2026-08-12', '09:00:00', '15:00:00', 'Lab Komputer 3', 30, 'Pelatihan dasar logika pemrograman.', 'dibuka', 1, '2026-07-15 00:00:00', '2026-07-15 00:00:00'),
(6, 'KG006', 'Workshop Motion Graphic & Video Mobile', 'Workshop', '2026-07-28', '13:00:00', '16:00:00', 'Lab Multimedia', 40, 'Cara membuat animasi bergerak menggunakan smartphone.', 'dibuka', 1, '2026-07-15 00:00:00', '2026-07-15 00:00:00'),
(7, 'KG007', 'Seminar Menguasai Teknologi Wireless Modern', 'Seminar', '2026-07-20', '09:00:00', '12:00:00', 'Ruang Seminar Utama', 80, 'Pembahasan teknologi frekuensi wireless terbaru.', 'dibuka', 2, '2026-07-15 00:00:00', '2026-07-15 00:00:00'),
(8, 'KG008', 'TOEFL Prediction Test & Strategy Workshop', 'Workshop', '2026-07-10', '08:00:00', '12:00:00', 'Pusat Bahasa Kampus', 150, 'Tips lulus ujian TOEFL dengan skor tinggi.', 'selesai', 2, '2026-07-15 00:00:00', '2026-07-15 00:00:00'),
(9, 'KG009', 'Kampus Mengajar: Edukasi Digital Sekolah Dasar', 'Lainnya', '2026-08-20', '08:00:00', '14:00:00', 'Desa Binaan', 25, 'Pengabdian masyarakat mengajarkan IT dasar.', 'dibuka', 1, '2026-07-15 00:00:00', '2026-07-15 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `peserta`
--

CREATE TABLE `peserta` (
  `id_peserta` int(11) NOT NULL,
  `id_kegiatan` int(11) NOT NULL,
  `nim` varchar(20) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `program_studi` varchar(100) NOT NULL,
  `semester` tinyint(4) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `status_pendaftaran` enum('terdaftar','hadir','batal') NOT NULL DEFAULT 'terdaftar',
  `tanggal_daftar` timestamp NOT NULL DEFAULT current_timestamp(),
  `catatan` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peserta`
--

INSERT INTO `peserta` (`id_peserta`, `id_kegiatan`, `nim`, `nama_lengkap`, `program_studi`, `semester`, `no_hp`, `email`, `alamat`, `status_pendaftaran`, `tanggal_daftar`, `catatan`) VALUES
(1, 2, '231001001', 'Aulia Rahma', 'Sistem Informasi', 4, '081234567890', 'aulia@email.com', 'Jl. Merdeka No. 10', 'terdaftar', '2026-06-29 08:40:17', NULL),
(2, 1, '231001002', 'Rizky Pratama', 'Teknik Informatika', 6, '082345678901', 'rizky@email.com', 'Jl. Mawar No. 5', 'hadir', '2026-06-29 08:40:17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_akses`
--

CREATE TABLE `user_akses` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','panitia') NOT NULL DEFAULT 'panitia',
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_akses`
--

INSERT INTO `user_akses` (`id_user`, `nama_lengkap`, `username`, `email`, `no_hp`, `password`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Administrator Kampus', 'admin', 'admin@kampus.ac.id', '081234567890', 'admin123', 'admin', 'aktif', '2026-06-29 08:45:37', '2026-06-29 08:45:37'),
(2, 'Panitia Kegiatan', 'panitia', 'panitia@kampus.ac.id', '082345678901', 'panitia123', 'panitia', 'aktif', '2026-06-29 08:45:37', '2026-06-29 08:45:37');

-- --------------------------------------------------------

--
-- Table structure for table `user_login`
--

CREATE TABLE `user_login` (
  `id_user` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','panitia') NOT NULL DEFAULT 'panitia',
  `status` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_login`
--

INSERT INTO `user_login` (`id_user`, `nama_lengkap`, `username`, `password`, `role`, `status`, `created_at`) VALUES
(1, 'Administrator Kampus', 'admin', 'admin123', 'admin', 'aktif', '2026-06-29 08:40:17'),
(2, 'Panitia Kegiatan', 'panitia', 'panitia123', 'panitia', 'aktif', '2026-06-29 08:40:17');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`),
  ADD UNIQUE KEY `kode_kegiatan` (`kode_kegiatan`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `peserta`
--
ALTER TABLE `peserta`
  ADD PRIMARY KEY (`id_peserta`),
  ADD UNIQUE KEY `unique_peserta_kegiatan` (`id_kegiatan`,`nim`);

--
-- Indexes for table `user_akses`
--
ALTER TABLE `user_akses`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_login`
--
ALTER TABLE `user_login`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `peserta`
--
ALTER TABLE `peserta`
  MODIFY `id_peserta` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_akses`
--
ALTER TABLE `user_akses`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user_login`
--
ALTER TABLE `user_login`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD CONSTRAINT `kegiatan_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `user_login` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `peserta`
--
ALTER TABLE `peserta`
  ADD CONSTRAINT `peserta_ibfk_1` FOREIGN KEY (`id_kegiatan`) REFERENCES `kegiatan` (`id_kegiatan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;