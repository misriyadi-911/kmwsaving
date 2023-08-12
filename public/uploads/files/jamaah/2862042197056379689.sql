-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 11, 2023 at 03:31 PM
-- Server version: 10.2.44-MariaDB-cll-lve
-- PHP Version: 8.1.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pemn4527_siakad`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `id_admin` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `nama_admin` varchar(70) NOT NULL,
  `thumbnail` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`id_admin`, `id_pengguna`, `nama_admin`, `thumbnail`) VALUES
(1, 1, 'Administrator', 'default.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_guru`
--

CREATE TABLE `tb_guru` (
  `id_guru` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `nuptk` varchar(20) NOT NULL,
  `nama_lengkap` varchar(70) NOT NULL,
  `tempat_lahir` varchar(70) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `jenis_kelamin` tinyint(1) NOT NULL,
  `nomor_telpon` varchar(13) NOT NULL,
  `jabatan` varchar(70) NOT NULL,
  `thumbnail` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_guru`
--

INSERT INTO `tb_guru` (`id_guru`, `id_pengguna`, `nuptk`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `jenis_kelamin`, `nomor_telpon`, `jabatan`, `thumbnail`, `created_at`, `update_at`) VALUES
(1, 2, '4440752652300002', 'Revika Hildayanti, S.Pd', '1974-01-08', '1974-01-08', 'Pamekasan', 2, '0879654321', 'Guru Mapel', '21871691720584.jpg', '2023-08-11 09:23:04', '2023-08-11 09:23:04'),
(2, 3, '2542764667210023', 'Rusman Hadi, S.Pd', 'Pamekasan', '1986-12-10', 'Pamekasan', 1, '08798654321', 'Guru Mapel', '80051691721208.jpg', '2023-08-11 09:33:27', '2023-08-11 09:33:27'),
(3, 4, '6560751652200022', 'Andy Gunawan, S.Si', '1973-02-28', '1973-02-28', 'Pamekasan', 1, '0987654321', 'Guru Mapel', '31331691721417.jpg', '2023-08-11 09:36:56', '2023-08-11 09:36:56'),
(4, 9, '9342769670230393', 'Imroatush Sholihah', 'bojonegoro', '1991-10-10', 'pamekasan', 2, '0987654321', 'Guru Mapel', '13651691723819.jpg', '2023-08-11 10:16:59', '2023-08-11 10:16:59');

-- --------------------------------------------------------

--
-- Table structure for table `tb_jawaban`
--

CREATE TABLE `tb_jawaban` (
  `id_jawaban` int(11) NOT NULL,
  `id_soal` int(11) NOT NULL,
  `isi` text NOT NULL,
  `jawaban_benar` tinyint(4) NOT NULL DEFAULT 0,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp(),
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_jawaban_siswa`
--

CREATE TABLE `tb_jawaban_siswa` (
  `id_jawaban_siswa` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_soal` int(11) NOT NULL,
  `id_jawaban` int(1) DEFAULT NULL,
  `jawaban` longtext DEFAULT NULL,
  `nilai` double DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_kbm`
--

CREATE TABLE `tb_kbm` (
  `id_kbm` int(11) NOT NULL,
  `id_guru` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `id_materi` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kbm`
--

INSERT INTO `tb_kbm` (`id_kbm`, `id_guru`, `id_kelas`, `id_materi`) VALUES
(1, 1, 1, 1),
(2, 2, 1, 3),
(3, 3, 1, 4),
(4, 3, 6, 5),
(5, 4, 17, 8);

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelas`
--

CREATE TABLE `tb_kelas` (
  `id_kelas` int(11) NOT NULL,
  `nama_kelas` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_kelas`
--

INSERT INTO `tb_kelas` (`id_kelas`, `nama_kelas`) VALUES
(1, 'Kelas X X1\r'),
(2, 'Kelas X X2\r'),
(3, 'Kelas X X3\r'),
(4, 'Kelas X X4\r'),
(5, 'Kelas X X5\r'),
(6, 'Kelas XI A1\r'),
(7, 'Kelas XI A2\r'),
(8, 'Kelas XI A3\r'),
(9, 'Kelas XI A4\r'),
(10, 'Kelas XI S1\r'),
(11, 'Kelas XI S2\r'),
(12, 'Kelas XII A1\r'),
(13, 'Kelas XII A2\r'),
(14, 'Kelas XII A3\r'),
(15, 'Kelas XII A4\r'),
(16, 'Kelas XII S1\r'),
(17, 'Kelas XII S2');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kelompok`
--

CREATE TABLE `tb_kelompok` (
  `id_kelompok` bigint(15) NOT NULL,
  `id_tugas_kelompok` bigint(15) NOT NULL,
  `id_siswa` bigint(15) NOT NULL,
  `id_pengumpulan` bigint(20) DEFAULT NULL,
  `kelompok` varchar(11) NOT NULL,
  `kordinator` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_komentar`
--

CREATE TABLE `tb_komentar` (
  `id` int(15) NOT NULL,
  `id_pengguna` int(15) NOT NULL,
  `id_materi_ajar` int(15) NOT NULL,
  `isi` longtext NOT NULL,
  `createdAt` datetime NOT NULL DEFAULT current_timestamp(),
  `updatedAt` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_konferensi`
--

CREATE TABLE `tb_konferensi` (
  `id_konferensi` int(11) NOT NULL,
  `id_materi` int(11) NOT NULL,
  `id_materi_ajar` int(11) NOT NULL,
  `link` text NOT NULL,
  `expired` datetime NOT NULL,
  `waktu_mulai_presensi` datetime DEFAULT NULL,
  `durasi` double DEFAULT NULL,
  `waktu_tutup` datetime DEFAULT NULL,
  `kata_sandi` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_like`
--

CREATE TABLE `tb_like` (
  `id_like` int(15) NOT NULL,
  `id_pengguna` int(15) NOT NULL,
  `id_materi_ajar` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_materi`
--

CREATE TABLE `tb_materi` (
  `id_materi` int(11) NOT NULL,
  `nama_materi` varchar(70) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_materi`
--

INSERT INTO `tb_materi` (`id_materi`, `nama_materi`, `created_at`, `updated_at`) VALUES
(1, 'BAHASA INGGRIS X X1', '2023-08-11 08:48:57', '2023-08-11 08:48:57'),
(2, 'PAI X X1', '2023-08-11 08:50:29', '2023-08-11 08:50:29'),
(3, 'PJOK X X1', '2023-08-11 08:52:36', '2023-08-11 08:52:36'),
(4, 'KIMIA X X1', '2023-08-11 08:54:36', '2023-08-11 08:54:36'),
(5, 'KIMIA XI A1', '2023-08-11 08:57:54', '2023-08-11 08:57:54'),
(6, 'KIMIA LM XI A1', '2023-08-11 08:59:55', '2023-08-11 08:59:55'),
(7, 'BIOLOGI XI A1', '2023-08-11 09:01:50', '2023-08-11 09:01:50'),
(8, 'SEJARAH XII S2', '2023-08-11 09:13:36', '2023-08-11 09:13:36'),
(9, 'EKONOMI LM XII S2', '2023-08-11 09:14:27', '2023-08-11 09:14:27'),
(10, 'PJOK XII S2', '2023-08-11 09:16:28', '2023-08-11 09:16:28');

-- --------------------------------------------------------

--
-- Table structure for table `tb_materi_ajar`
--

CREATE TABLE `tb_materi_ajar` (
  `id_materi_ajar` int(11) NOT NULL,
  `id_kbm` int(11) NOT NULL,
  `id_tahun_pelajaran` int(11) NOT NULL,
  `judul_materi` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `file` varchar(100) DEFAULT NULL,
  `link` text DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_nilai`
--

CREATE TABLE `tb_nilai` (
  `id_nilai` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `id_materi` int(11) NOT NULL,
  `id_tahun_pelajaran` int(11) NOT NULL,
  `tugas` double NOT NULL,
  `uts` double NOT NULL,
  `uas` double NOT NULL,
  `total` double NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengguna`
--

CREATE TABLE `tb_pengguna` (
  `id_pengguna` int(11) NOT NULL,
  `username` varchar(40) NOT NULL,
  `password` varchar(70) NOT NULL,
  `type` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_pengguna`
--

INSERT INTO `tb_pengguna` (`id_pengguna`, `username`, `password`, `type`) VALUES
(1, 'Administrator', '$2y$10$nCZfmch67ebiryQ6jUF6HO84E8zGPcLV7Nee/I4MI1ituTBANo8kq', 'admin'),
(2, '4440752652300002', '$2y$10$OWrSXsyZslxw7ehyQTewEuClcyA/XUsqN1Aslu6htSBd8xWlAAYh2', 'guru'),
(3, '2542764667210023', '$2y$10$p5uJJ/2WWbqZddhQNAj3eui/YuP7D6OevQxAYDagmpdNorlrzpZj6', 'guru'),
(4, '6560751652200022', '$2y$10$KW8jvxRbARj2RPGE6TRASeZkMZumzFx0yMgd9hPZVKWQ8XqTe9yba', 'guru'),
(5, '0096408047', '$2y$10$eTsUc49uhzduYHqGhSpxo.8/wtmV4GFvBTR96eMOASiG7H.h5WL.u', 'siswa'),
(6, '0073246096', '$2y$10$bysE94joGjNWlyUqofVDH.Q0TSNUs9CU6v.T66ADkZFsTRY1yNy2y', 'siswa'),
(7, '0063642312', '$2y$10$45H0JYtG/b3ItQYg26qngeaCx9J6rpZyCwzZulCxuRsrdkDeYny/6', 'siswa'),
(8, '0052347831', '$2y$10$1HRXfaCN1ooUSz.alhy1Bu6vXpqh./KMjmw2/Fdhe4/6QLoXnnkny', 'siswa'),
(9, '9342769670230393', '$2y$10$VNigAESY0Bau/qvUflUQA.Yk4t63R/l7ZsUeJVhvT0z.nPAOnX1xy', 'guru');

-- --------------------------------------------------------

--
-- Table structure for table `tb_pengumpulan`
--

CREATE TABLE `tb_pengumpulan` (
  `id_pengumpulan` int(11) NOT NULL,
  `id_tugas` int(11) NOT NULL,
  `id_siswa` int(11) NOT NULL,
  `file` varchar(100) NOT NULL,
  `komentar` varchar(100) DEFAULT NULL,
  `nilai` tinyint(1) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_presensi`
--

CREATE TABLE `tb_presensi` (
  `id_presensi` int(11) NOT NULL,
  `id_materi_ajar` bigint(15) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `keterangan` int(5) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_siswa`
--

CREATE TABLE `tb_siswa` (
  `id_siswa` int(11) NOT NULL,
  `id_pengguna` int(11) NOT NULL,
  `id_kelas` int(11) NOT NULL,
  `nisn` varchar(13) NOT NULL,
  `nama_lengkap` varchar(70) NOT NULL,
  `tempat_lahir` varchar(70) NOT NULL,
  `tanggal_lahir` date NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `jenis_kelamin` tinyint(1) NOT NULL,
  `thumbnail` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_siswa`
--

INSERT INTO `tb_siswa` (`id_siswa`, `id_pengguna`, `id_kelas`, `nisn`, `nama_lengkap`, `tempat_lahir`, `tanggal_lahir`, `alamat`, `jenis_kelamin`, `thumbnail`, `created_at`, `update_at`) VALUES
(1, 5, 1, '0096408047', 'ACH DANI', 'Pamekasan', '2007-07-09', 'Pademawu', 1, '43721691722352.jpg', '2023-08-11 09:52:31', '2023-08-11 09:52:31'),
(2, 6, 1, '0073246096', 'ADITYA PRATAMA', 'pamekasan', '2007-07-23', 'pademawu', 1, '83501691723288.JPG', '2023-08-11 09:58:28', '2023-08-11 09:58:28'),
(3, 7, 6, '0063642312', 'Abd. Qodir Jailani', 'Paamekasan', '2006-09-08', 'pademawu', 1, '62271691723096.jpg', '2023-08-11 10:04:56', '2023-08-11 10:04:56'),
(4, 8, 17, '0052347831', 'ACHMAD MUAFI', 'Pamekasan', '2005-05-31', 'pademawu', 1, '78741691723234.jpg', '2023-08-11 10:07:14', '2023-08-11 10:07:14');

-- --------------------------------------------------------

--
-- Table structure for table `tb_soal`
--

CREATE TABLE `tb_soal` (
  `id_soal` int(11) NOT NULL,
  `id_ujian` int(11) NOT NULL,
  `urutan` int(11) DEFAULT NULL,
  `soal` longtext NOT NULL,
  `skor` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tahun_pelajaran`
--

CREATE TABLE `tb_tahun_pelajaran` (
  `id_tahun_pelajaran` int(11) NOT NULL,
  `tahun_pelajaran` varchar(10) NOT NULL,
  `semester` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `tb_tahun_pelajaran`
--

INSERT INTO `tb_tahun_pelajaran` (`id_tahun_pelajaran`, `tahun_pelajaran`, `semester`, `status`) VALUES
(1, '2023/2024', 0, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tb_tugas`
--

CREATE TABLE `tb_tugas` (
  `id_tugas` int(11) NOT NULL,
  `id_kbm` int(11) NOT NULL,
  `id_tahun_pelajaran` int(11) NOT NULL,
  `judul_tugas` varchar(40) NOT NULL,
  `deskripsi` text NOT NULL,
  `file` varchar(100) DEFAULT NULL,
  `tanggal_mulai` datetime NOT NULL,
  `tanggal_selesai` datetime NOT NULL,
  `created_at` datetime NOT NULL,
  `update_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_tugas_kelompok`
--

CREATE TABLE `tb_tugas_kelompok` (
  `id_tugas_kelompok` bigint(15) NOT NULL,
  `id_tugas` int(11) NOT NULL,
  `banyak_kelompok` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `tb_ujian`
--

CREATE TABLE `tb_ujian` (
  `id_ujian` int(15) NOT NULL,
  `id_materi` int(11) NOT NULL,
  `id_tahun_pelajaran` int(11) NOT NULL,
  `judul` text DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `duration` double DEFAULT NULL,
  `waktu_mulai` datetime DEFAULT NULL,
  `waktu_selesai` datetime NOT NULL,
  `type` tinyint(1) NOT NULL,
  `tipe_nilai` tinyint(4) NOT NULL DEFAULT 1,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD PRIMARY KEY (`id_guru`),
  ADD KEY `id_pengguna` (`id_pengguna`);

--
-- Indexes for table `tb_jawaban`
--
ALTER TABLE `tb_jawaban`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `id_soal` (`id_soal`);

--
-- Indexes for table `tb_jawaban_siswa`
--
ALTER TABLE `tb_jawaban_siswa`
  ADD PRIMARY KEY (`id_jawaban_siswa`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_soal` (`id_soal`),
  ADD KEY `id_jawaban` (`id_jawaban`);

--
-- Indexes for table `tb_kbm`
--
ALTER TABLE `tb_kbm`
  ADD PRIMARY KEY (`id_kbm`),
  ADD KEY `id_materi` (`id_materi`),
  ADD KEY `id_guru` (`id_guru`),
  ADD KEY `id_siswa` (`id_kelas`);

--
-- Indexes for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  ADD PRIMARY KEY (`id_kelas`);

--
-- Indexes for table `tb_kelompok`
--
ALTER TABLE `tb_kelompok`
  ADD PRIMARY KEY (`id_kelompok`),
  ADD KEY `id_tugas_kelompok` (`id_tugas_kelompok`);

--
-- Indexes for table `tb_komentar`
--
ALTER TABLE `tb_komentar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tb_konferensi`
--
ALTER TABLE `tb_konferensi`
  ADD PRIMARY KEY (`id_konferensi`),
  ADD KEY `tb_konferensi_ibfk_1` (`id_materi`),
  ADD KEY `tb_konferensi_ibfk_2` (`id_materi_ajar`);

--
-- Indexes for table `tb_like`
--
ALTER TABLE `tb_like`
  ADD PRIMARY KEY (`id_like`);

--
-- Indexes for table `tb_materi`
--
ALTER TABLE `tb_materi`
  ADD PRIMARY KEY (`id_materi`);

--
-- Indexes for table `tb_materi_ajar`
--
ALTER TABLE `tb_materi_ajar`
  ADD PRIMARY KEY (`id_materi_ajar`),
  ADD KEY `id_kbm` (`id_kbm`),
  ADD KEY `id_tahun_pelajaran` (`id_tahun_pelajaran`);

--
-- Indexes for table `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD PRIMARY KEY (`id_nilai`),
  ADD KEY `id_siswa` (`id_siswa`),
  ADD KEY `id_materi` (`id_materi`),
  ADD KEY `id_tahun_pelajaran` (`id_tahun_pelajaran`);

--
-- Indexes for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  ADD PRIMARY KEY (`id_pengguna`);

--
-- Indexes for table `tb_pengumpulan`
--
ALTER TABLE `tb_pengumpulan`
  ADD PRIMARY KEY (`id_pengumpulan`),
  ADD KEY `id_tugas` (`id_tugas`),
  ADD KEY `id_siswa` (`id_siswa`);

--
-- Indexes for table `tb_presensi`
--
ALTER TABLE `tb_presensi`
  ADD PRIMARY KEY (`id_presensi`);

--
-- Indexes for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD PRIMARY KEY (`id_siswa`),
  ADD KEY `id_pengguna` (`id_pengguna`),
  ADD KEY `id_kelas` (`id_kelas`);

--
-- Indexes for table `tb_soal`
--
ALTER TABLE `tb_soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `id_ujian` (`id_ujian`);

--
-- Indexes for table `tb_tahun_pelajaran`
--
ALTER TABLE `tb_tahun_pelajaran`
  ADD PRIMARY KEY (`id_tahun_pelajaran`);

--
-- Indexes for table `tb_tugas`
--
ALTER TABLE `tb_tugas`
  ADD PRIMARY KEY (`id_tugas`),
  ADD KEY `id_kbm` (`id_kbm`),
  ADD KEY `id_tahun_pelajaran` (`id_tahun_pelajaran`);

--
-- Indexes for table `tb_tugas_kelompok`
--
ALTER TABLE `tb_tugas_kelompok`
  ADD PRIMARY KEY (`id_tugas_kelompok`),
  ADD KEY `id_tugas` (`id_tugas`);

--
-- Indexes for table `tb_ujian`
--
ALTER TABLE `tb_ujian`
  ADD PRIMARY KEY (`id_ujian`),
  ADD KEY `id_tahun_pelajaran` (`id_tahun_pelajaran`),
  ADD KEY `id_materi` (`id_materi`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_guru`
--
ALTER TABLE `tb_guru`
  MODIFY `id_guru` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_jawaban`
--
ALTER TABLE `tb_jawaban`
  MODIFY `id_jawaban` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_jawaban_siswa`
--
ALTER TABLE `tb_jawaban_siswa`
  MODIFY `id_jawaban_siswa` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_kbm`
--
ALTER TABLE `tb_kbm`
  MODIFY `id_kbm` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tb_kelas`
--
ALTER TABLE `tb_kelas`
  MODIFY `id_kelas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `tb_kelompok`
--
ALTER TABLE `tb_kelompok`
  MODIFY `id_kelompok` bigint(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_komentar`
--
ALTER TABLE `tb_komentar`
  MODIFY `id` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_konferensi`
--
ALTER TABLE `tb_konferensi`
  MODIFY `id_konferensi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_like`
--
ALTER TABLE `tb_like`
  MODIFY `id_like` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_materi`
--
ALTER TABLE `tb_materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_materi_ajar`
--
ALTER TABLE `tb_materi_ajar`
  MODIFY `id_materi_ajar` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_nilai`
--
ALTER TABLE `tb_nilai`
  MODIFY `id_nilai` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_pengguna`
--
ALTER TABLE `tb_pengguna`
  MODIFY `id_pengguna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tb_pengumpulan`
--
ALTER TABLE `tb_pengumpulan`
  MODIFY `id_pengumpulan` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_presensi`
--
ALTER TABLE `tb_presensi`
  MODIFY `id_presensi` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  MODIFY `id_siswa` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_soal`
--
ALTER TABLE `tb_soal`
  MODIFY `id_soal` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_tahun_pelajaran`
--
ALTER TABLE `tb_tahun_pelajaran`
  MODIFY `id_tahun_pelajaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_tugas`
--
ALTER TABLE `tb_tugas`
  MODIFY `id_tugas` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_tugas_kelompok`
--
ALTER TABLE `tb_tugas_kelompok`
  MODIFY `id_tugas_kelompok` bigint(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_ujian`
--
ALTER TABLE `tb_ujian`
  MODIFY `id_ujian` int(15) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD CONSTRAINT `tb_admin_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_guru`
--
ALTER TABLE `tb_guru`
  ADD CONSTRAINT `tb_guru_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_jawaban`
--
ALTER TABLE `tb_jawaban`
  ADD CONSTRAINT `tb_jawaban_ibfk_1` FOREIGN KEY (`id_soal`) REFERENCES `tb_soal` (`id_soal`);

--
-- Constraints for table `tb_jawaban_siswa`
--
ALTER TABLE `tb_jawaban_siswa`
  ADD CONSTRAINT `tb_jawaban_siswa_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_jawaban_siswa_ibfk_2` FOREIGN KEY (`id_soal`) REFERENCES `tb_soal` (`id_soal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_jawaban_siswa_ibfk_3` FOREIGN KEY (`id_jawaban`) REFERENCES `tb_jawaban` (`id_jawaban`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_kbm`
--
ALTER TABLE `tb_kbm`
  ADD CONSTRAINT `tb_kbm_ibfk_1` FOREIGN KEY (`id_materi`) REFERENCES `tb_materi` (`id_materi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_kbm_ibfk_2` FOREIGN KEY (`id_guru`) REFERENCES `tb_guru` (`id_guru`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_kbm_ibfk_3` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_kelompok`
--
ALTER TABLE `tb_kelompok`
  ADD CONSTRAINT `tb_kelompok_ibfk_1` FOREIGN KEY (`id_tugas_kelompok`) REFERENCES `tb_tugas_kelompok` (`id_tugas_kelompok`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_konferensi`
--
ALTER TABLE `tb_konferensi`
  ADD CONSTRAINT `tb_konferensi_ibfk_1` FOREIGN KEY (`id_materi`) REFERENCES `tb_materi` (`id_materi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_konferensi_ibfk_2` FOREIGN KEY (`id_materi_ajar`) REFERENCES `tb_materi_ajar` (`id_materi_ajar`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_materi_ajar`
--
ALTER TABLE `tb_materi_ajar`
  ADD CONSTRAINT `tb_materi_ajar_ibfk_1` FOREIGN KEY (`id_kbm`) REFERENCES `tb_kbm` (`id_kbm`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_materi_ajar_ibfk_2` FOREIGN KEY (`id_tahun_pelajaran`) REFERENCES `tb_tahun_pelajaran` (`id_tahun_pelajaran`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_nilai`
--
ALTER TABLE `tb_nilai`
  ADD CONSTRAINT `tb_nilai_ibfk_1` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_nilai_ibfk_2` FOREIGN KEY (`id_materi`) REFERENCES `tb_materi` (`id_materi`),
  ADD CONSTRAINT `tb_nilai_ibfk_3` FOREIGN KEY (`id_tahun_pelajaran`) REFERENCES `tb_tahun_pelajaran` (`id_tahun_pelajaran`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_pengumpulan`
--
ALTER TABLE `tb_pengumpulan`
  ADD CONSTRAINT `tb_pengumpulan_ibfk_1` FOREIGN KEY (`id_tugas`) REFERENCES `tb_tugas` (`id_tugas`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_pengumpulan_ibfk_2` FOREIGN KEY (`id_siswa`) REFERENCES `tb_siswa` (`id_siswa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_siswa`
--
ALTER TABLE `tb_siswa`
  ADD CONSTRAINT `tb_siswa_ibfk_1` FOREIGN KEY (`id_pengguna`) REFERENCES `tb_pengguna` (`id_pengguna`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_siswa_ibfk_2` FOREIGN KEY (`id_kelas`) REFERENCES `tb_kelas` (`id_kelas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_soal`
--
ALTER TABLE `tb_soal`
  ADD CONSTRAINT `tb_soal_ibfk_1` FOREIGN KEY (`id_ujian`) REFERENCES `tb_ujian` (`id_ujian`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_tugas`
--
ALTER TABLE `tb_tugas`
  ADD CONSTRAINT `tb_tugas_ibfk_1` FOREIGN KEY (`id_kbm`) REFERENCES `tb_kbm` (`id_kbm`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_tugas_ibfk_2` FOREIGN KEY (`id_tahun_pelajaran`) REFERENCES `tb_tahun_pelajaran` (`id_tahun_pelajaran`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_tugas_kelompok`
--
ALTER TABLE `tb_tugas_kelompok`
  ADD CONSTRAINT `tb_tugas_kelompok_ibfk_1` FOREIGN KEY (`id_tugas`) REFERENCES `tb_tugas` (`id_tugas`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tb_ujian`
--
ALTER TABLE `tb_ujian`
  ADD CONSTRAINT `tb_ujian_ibfk_1` FOREIGN KEY (`id_tahun_pelajaran`) REFERENCES `tb_tahun_pelajaran` (`id_tahun_pelajaran`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_ujian_ibfk_2` FOREIGN KEY (`id_materi`) REFERENCES `tb_materi` (`id_materi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
