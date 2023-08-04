-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 01, 2023 at 09:22 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `miton`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggarans`
--

CREATE TABLE `anggarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `sub_kegiatan_id` bigint(20) UNSIGNED NOT NULL,
  `pak_id` bigint(20) UNSIGNED NOT NULL,
  `nominal_anggaran` bigint(20) NOT NULL,
  `pelaksanaan` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `anggarans`
--

INSERT INTO `anggarans` (`id`, `sub_kegiatan_id`, `pak_id`, `nominal_anggaran`, `pelaksanaan`, `created_at`, `updated_at`) VALUES
(5, 5, 2, 123123123, 0, '2023-07-04 06:38:17', '2023-07-04 06:40:12'),
(6, 6, 2, 400000, 0, '2023-07-31 06:41:51', '2023-07-31 06:41:51'),
(7, 7, 2, 400000, 0, '2023-07-31 19:22:28', '2023-07-31 19:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `bulans`
--

CREATE TABLE `bulans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_bulan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bulans`
--

INSERT INTO `bulans` (`id`, `nama_bulan`, `created_at`, `updated_at`) VALUES
(1, 'Januari', '2023-02-01 11:38:29', '2023-02-07 12:53:41'),
(2, 'Pebruari', '2023-02-01 11:41:05', '2023-02-06 10:22:54'),
(3, 'Maret', '2023-02-01 11:46:27', '2023-02-06 10:24:11'),
(4, 'April', '2023-02-01 11:46:57', '2023-05-14 12:39:35'),
(5, 'Mei', '2023-02-01 11:48:59', '2023-02-01 11:48:59'),
(6, 'Juni', '2023-02-01 11:49:10', '2023-05-01 23:13:04'),
(7, 'Juli', '2023-02-01 11:49:51', '2023-02-01 11:49:51'),
(8, 'Agustus', '2023-02-01 11:50:28', '2023-04-26 12:59:10'),
(9, 'September', '2023-02-01 11:51:39', '2023-05-14 12:44:47'),
(10, 'Oktober', '2023-02-01 11:52:13', '2023-05-14 12:10:23'),
(11, 'November', '2023-02-01 11:57:12', '2023-05-14 12:53:34'),
(12, 'Desember', '2023-02-01 11:57:17', '2023-05-14 16:16:04');

-- --------------------------------------------------------

--
-- Table structure for table `detail_sub_kegiatan`
--

CREATE TABLE `detail_sub_kegiatan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pengadaan_id` int(11) NOT NULL,
  `pelaksanaan_id` int(11) NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `sub_kegiatan_id` bigint(20) UNSIGNED NOT NULL,
  `anggaran` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `detail_sub_kegiatan`
--

INSERT INTO `detail_sub_kegiatan` (`id`, `pengadaan_id`, `pelaksanaan_id`, `keterangan`, `sub_kegiatan_id`, `anggaran`, `created_at`, `updated_at`) VALUES
(2, 2, 1, 'apalah apalah', 5, '2000', '2023-07-04 18:13:02', '2023-07-04 18:13:02'),
(3, 1, 1, '123123', 6, '400000', '2023-07-31 06:47:42', '2023-07-31 06:47:42'),
(4, 1, 1, 'ini testing', 5, '2000', '2023-07-31 16:30:30', '2023-07-31 16:30:30'),
(5, 1, 4, 'ini adalah detail sub_testing', 7, '400000', '2023-07-31 19:24:24', '2023-07-31 19:24:24');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jadwals`
--

CREATE TABLE `jadwals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `detail_sub_kegiatan_id` bigint(20) UNSIGNED NOT NULL,
  `bulan_id` bigint(20) UNSIGNED NOT NULL,
  `pelaksanaan` tinyint(1) NOT NULL,
  `target_kegiatan` bigint(20) DEFAULT 0,
  `kegiatan_bulan_sebelumnya` bigint(20) DEFAULT 0,
  `kegiatan_bulan_sekarang` bigint(20) DEFAULT 0,
  `target_keuangan` bigint(20) DEFAULT 0,
  `keuangan_bulan_sebelumnya` bigint(20) DEFAULT 0,
  `keuangan_bulan_sekarang` bigint(20) DEFAULT 0,
  `kendala` text DEFAULT NULL,
  `status` tinyint(1) DEFAULT 0,
  `status_pelaksanaan` enum('persiapan-tender','proses-tender','selesai-tender','belum-kontrak','sedang-berjalan-kontrak','jatuh-tempo-kontrak','addendum-kontrak','selesai-kontrak') DEFAULT 'persiapan-tender',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `jadwals`
--

INSERT INTO `jadwals` (`id`, `detail_sub_kegiatan_id`, `bulan_id`, `pelaksanaan`, `target_kegiatan`, `kegiatan_bulan_sebelumnya`, `kegiatan_bulan_sekarang`, `target_keuangan`, `keuangan_bulan_sebelumnya`, `keuangan_bulan_sekarang`, `kendala`, `status`, `status_pelaksanaan`, `created_at`, `updated_at`) VALUES
(17, 2, 1, 0, 100, 0, 12, 2000, 0, 0, NULL, 1, 'persiapan-tender', '2023-07-31 00:59:22', '2023-07-31 06:20:44'),
(18, 2, 2, 0, 0, 0, 12, 0, 0, 0, NULL, 1, 'persiapan-tender', '2023-07-31 00:59:22', '2023-07-31 06:21:47'),
(19, 2, 3, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 00:59:22', '2023-07-31 00:59:22'),
(20, 2, 4, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 00:59:22', '2023-07-31 00:59:22'),
(21, 2, 5, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 00:59:22', '2023-07-31 00:59:22'),
(22, 2, 6, 0, 0, 0, 0, 0, 0, 0, NULL, 1, 'persiapan-tender', '2023-07-31 00:59:22', '2023-07-31 04:57:10'),
(23, 2, 7, 0, 0, 0, 10, 0, 0, 123123123, 'tidak ada', 1, 'persiapan-tender', '2023-07-31 00:59:22', '2023-07-31 06:20:36'),
(24, 2, 8, 0, 0, 0, 12, 0, 0, 0, NULL, 1, 'persiapan-tender', '2023-07-31 00:59:22', '2023-07-31 21:30:42'),
(25, 2, 9, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 00:59:22', '2023-07-31 00:59:22'),
(26, 2, 10, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 00:59:22', '2023-07-31 00:59:22'),
(27, 2, 11, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 00:59:22', '2023-07-31 00:59:22'),
(28, 2, 12, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 00:59:22', '2023-07-31 00:59:22'),
(29, 3, 1, 0, 10, 0, 0, 40000, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 06:50:07', '2023-07-31 06:50:07'),
(30, 3, 2, 0, 10, 0, 0, 40000, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 06:50:07', '2023-07-31 06:50:07'),
(31, 3, 3, 0, 10, 0, 0, 40000, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 06:50:07', '2023-07-31 06:50:07'),
(32, 3, 4, 0, 10, 0, 0, 40000, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 06:50:07', '2023-07-31 06:50:07'),
(33, 3, 5, 0, 10, 0, 0, 40000, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 06:50:07', '2023-07-31 06:50:07'),
(34, 3, 6, 0, 10, 0, 0, 40000, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 06:50:07', '2023-07-31 06:50:07'),
(35, 3, 7, 0, 10, 0, 100, 40000, 0, 0, NULL, 1, 'persiapan-tender', '2023-07-31 06:50:07', '2023-07-31 06:50:37'),
(36, 3, 8, 0, 10, 0, 0, 40000, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 06:50:07', '2023-07-31 06:50:07'),
(37, 3, 9, 0, 10, 0, 0, 40000, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 06:50:07', '2023-07-31 06:50:07'),
(38, 3, 10, 0, 10, 0, 0, 40000, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 06:50:07', '2023-07-31 06:50:07'),
(39, 3, 11, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 06:50:07', '2023-07-31 06:50:07'),
(40, 3, 12, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 06:50:07', '2023-07-31 06:50:07'),
(41, 4, 1, 0, 10, 0, 0, 200, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 16:41:41', '2023-07-31 16:41:41'),
(42, 4, 2, 0, 10, 0, 0, 200, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 16:41:41', '2023-07-31 16:41:41'),
(43, 4, 3, 0, 10, 0, 0, 200, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 16:41:41', '2023-07-31 16:41:41'),
(44, 4, 4, 0, 10, 0, 0, 200, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 16:41:41', '2023-07-31 16:41:41'),
(45, 4, 5, 0, 10, 0, 0, 200, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 16:41:41', '2023-07-31 16:41:41'),
(46, 4, 6, 0, 10, 0, 0, 200, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 16:41:41', '2023-07-31 16:41:41'),
(47, 4, 7, 0, 10, 0, 0, 200, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 16:41:41', '2023-07-31 16:41:41'),
(48, 4, 8, 0, 10, 0, 0, 200, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 16:41:41', '2023-07-31 16:41:41'),
(49, 4, 9, 0, 10, 0, 0, 200, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 16:41:41', '2023-07-31 16:41:41'),
(50, 4, 10, 0, 10, 0, 0, 200, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 16:41:41', '2023-07-31 16:41:41'),
(51, 4, 11, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 16:41:41', '2023-07-31 16:41:41'),
(52, 4, 12, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 16:41:41', '2023-07-31 16:41:41'),
(53, 5, 1, 0, 100, 0, 0, 400000, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 21:20:28', '2023-07-31 21:20:28'),
(54, 5, 2, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 21:20:28', '2023-07-31 21:20:28'),
(55, 5, 3, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 21:20:28', '2023-07-31 21:20:28'),
(56, 5, 4, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 21:20:28', '2023-07-31 21:20:28'),
(57, 5, 5, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 21:20:28', '2023-07-31 21:20:28'),
(58, 5, 6, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 21:20:28', '2023-07-31 21:20:28'),
(59, 5, 7, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 21:20:28', '2023-07-31 21:20:28'),
(60, 5, 8, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 21:20:28', '2023-07-31 21:20:28'),
(61, 5, 9, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 21:20:28', '2023-07-31 21:20:28'),
(62, 5, 10, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 21:20:28', '2023-07-31 21:20:28'),
(63, 5, 11, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 21:20:28', '2023-07-31 21:20:28'),
(64, 5, 12, 0, 0, 0, 0, 0, 0, 0, NULL, 0, 'persiapan-tender', '2023-07-31 21:20:28', '2023-07-31 21:20:28');

-- --------------------------------------------------------

--
-- Table structure for table `kunci_inputans`
--

CREATE TABLE `kunci_inputans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_inputan` varchar(255) NOT NULL,
  `aktif` datetime NOT NULL,
  `tidak_aktif` datetime NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kunci_inputans`
--

INSERT INTO `kunci_inputans` (`id`, `nama_inputan`, `aktif`, `tidak_aktif`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Entry Kegiatan', '2022-09-23 00:00:00', '2022-09-23 00:00:00', 1, '2022-09-22 23:35:55', '2023-01-30 17:09:26'),
(2, 'Target Fisik & Target Keuangan', '2022-09-23 00:00:00', '2022-09-23 00:00:00', 1, '2022-09-22 23:35:55', '2023-01-30 17:09:27'),
(3, 'Laporan RFK', '2022-09-23 00:00:00', '2022-09-23 00:00:00', 1, '2022-09-22 23:35:55', '2023-01-30 17:09:30');

-- --------------------------------------------------------

--
-- Table structure for table `kunci_paks`
--

CREATE TABLE `kunci_paks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `pak_id` bigint(20) UNSIGNED NOT NULL,
  `pelaksanaan` tinyint(1) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kunci_paks`
--

INSERT INTO `kunci_paks` (`id`, `pak_id`, `pelaksanaan`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 0, 0, '2023-01-31 04:05:47', '2023-03-31 15:39:24'),
(2, 1, 1, 0, '2023-01-31 04:06:44', '2023-03-03 02:21:37'),
(3, 2, 0, 1, '2023-01-31 04:22:41', '2023-01-31 04:22:41'),
(4, 2, 1, 0, '2023-01-31 04:22:41', '2023-03-03 02:12:08');

-- --------------------------------------------------------

--
-- Table structure for table `lokasis`
--

CREATE TABLE `lokasis` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `detail_sub_kegiatan_id` bigint(20) UNSIGNED NOT NULL,
  `alamat` text NOT NULL,
  `kecamatan` text NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lokasis`
--

INSERT INTO `lokasis` (`id`, `detail_sub_kegiatan_id`, `alamat`, `kecamatan`, `latitude`, `longitude`, `created_at`, `updated_at`) VALUES
(8, 2, 'Pademawu, Pamekasan Regency, East Java, Indonesia', 'Pademawu', '-7.162450199999999', '113.4962707', '2023-07-04 18:53:48', '2023-07-04 18:53:48'),
(9, 2, 'Asempitu, West Pademawu, Pamekasan Regency, East Java, Indonesia', 'Kecamatan Pademawu', '-7.189211', '113.5177912', '2023-07-04 20:21:57', '2023-07-04 20:21:57'),
(10, 2, 'Kangenan, Pamekasan Regency, East Java, Indonesia', 'Pamekasan', '-7.1806524', '113.4910039', '2023-07-04 20:24:34', '2023-07-04 20:24:34'),
(11, 2, 'Kangenan, Pamekasan Regency, East Java, Indonesia', 'Pamekasan', '-7.1806524', '113.4910039', '2023-07-04 20:24:39', '2023-07-04 20:24:39'),
(13, 2, 'Pademawu Timur, Pamekasan Regency, East Java, Indonesia', 'Pademawu', '-7.2380812', '113.516303', '2023-07-04 21:00:30', '2023-07-04 21:00:30'),
(14, 3, 'Kecamatan Balubur Limbangan, Garut Regency, West Java, Indonesia', 'Balubur Limbangan', '-7.0346718', '107.9844113', '2023-07-31 07:01:37', '2023-07-31 07:01:37'),
(15, 4, 'Pademawu, Pamekasan Regency, East Java, Indonesia', 'Pademawu', '-7.162450199999999', '113.4962707', '2023-07-31 16:30:51', '2023-07-31 16:30:51');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paks`
--

CREATE TABLE `paks` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tahun_anggaran` year(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `paks`
--

INSERT INTO `paks` (`id`, `tahun_anggaran`, `created_at`, `updated_at`) VALUES
(1, '2022', '2022-09-22 23:35:55', '2022-09-22 23:35:55'),
(2, '2023', '2023-01-08 12:24:02', '2023-01-08 12:24:02');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelaksanaans`
--

CREATE TABLE `pelaksanaans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pelaksanaan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelaksanaans`
--

INSERT INTO `pelaksanaans` (`id`, `nama_pelaksanaan`, `created_at`, `updated_at`) VALUES
(1, 'Tender', '2022-09-22 23:35:55', '2022-09-22 23:35:55'),
(2, 'Penunjukan Langsung', '2022-09-22 23:35:55', '2022-09-22 23:35:55'),
(3, 'Pengadaan Langsung', '2022-09-22 23:35:55', '2022-09-22 23:35:55'),
(4, 'ePucrhasing', '2022-09-22 23:35:55', '2022-09-22 23:35:55'),
(5, 'Swakelola', '2022-09-22 23:35:55', '2022-09-22 23:35:55'),
(6, 'Seleksi', '2022-09-22 23:35:55', '2022-09-22 23:35:55');

-- --------------------------------------------------------

--
-- Table structure for table `penanggung_jawabs`
--

CREATE TABLE `penanggung_jawabs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `detail_sub_kegiatan_id` bigint(20) UNSIGNED NOT NULL,
  `user_penanggun_jawab_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penanggung_jawabs`
--

INSERT INTO `penanggung_jawabs` (`id`, `detail_sub_kegiatan_id`, `user_penanggun_jawab_id`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '2023-07-04 21:05:14', '2023-07-04 21:05:14'),
(2, 3, 2, '2023-07-31 07:00:30', '2023-07-31 07:00:30'),
(3, 4, 1, '2023-07-31 16:45:34', '2023-07-31 16:45:34');

-- --------------------------------------------------------

--
-- Table structure for table `pengadaans`
--

CREATE TABLE `pengadaans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_pengadaan` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengadaans`
--

INSERT INTO `pengadaans` (`id`, `nama_pengadaan`, `created_at`, `updated_at`) VALUES
(1, 'Konstruksi', '2022-09-22 23:35:55', '2022-09-22 23:35:55'),
(2, 'Barang', '2022-09-22 23:35:55', '2022-09-22 23:35:55'),
(3, 'Konsultansi', '2022-09-22 23:35:55', '2022-09-22 23:35:55'),
(4, 'Jasa Lainya', '2022-09-22 23:35:55', '2022-09-22 23:35:55');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna_anggarans`
--

CREATE TABLE `pengguna_anggarans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(255) NOT NULL,
  `nama_pengguna_anggaran` text NOT NULL,
  `jabatan` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rekap`
--

CREATE TABLE `rekap` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `sumber_dana_id` int(11) DEFAULT NULL,
  `pak_id` int(11) DEFAULT NULL,
  `bulan_id` int(11) NOT NULL,
  `pelaksanaan` int(3) DEFAULT NULL,
  `jumlah_paket` varchar(255) DEFAULT '0',
  `anggaran` varchar(255) DEFAULT '0',
  `target_kegiatan` varchar(255) DEFAULT '0',
  `persentase_kegiatan` varchar(255) DEFAULT '0',
  `realisasi_kegiatan` varchar(255) DEFAULT '0',
  `target_keuangan` varchar(255) DEFAULT '0',
  `realisasi_keuangan` varchar(255) DEFAULT '0',
  `prosentase_realisasi_keuangan` varchar(255) DEFAULT '0',
  `status` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `rekap`
--

INSERT INTO `rekap` (`id`, `user_id`, `sumber_dana_id`, `pak_id`, `bulan_id`, `pelaksanaan`, `jumlah_paket`, `anggaran`, `target_kegiatan`, `persentase_kegiatan`, `realisasi_kegiatan`, `target_keuangan`, `realisasi_keuangan`, `prosentase_realisasi_keuangan`, `status`, `created_at`, `updated_at`) VALUES
(253, 12, 1, 2, 1, 0, '3', '369369369', '40', '0', '3.9996', '42200', '0', '0', 1, '2023-08-01 05:35:51', '2023-08-01 05:35:51'),
(254, 12, 1, 2, 2, 0, '3', '369369369', '46.666666666667', '0', '7.9992', '82400', '0', '0', 1, '2023-08-01 05:35:51', '2023-08-01 05:35:51'),
(255, 12, 1, 2, 3, 0, '3', '369369369', '53.333333333333', '0', '7.9992', '122600', '0', '0', 0, '2023-08-01 05:35:51', '2023-08-01 05:35:51'),
(256, 12, 1, 2, 4, 0, '3', '369369369', '60', '0', '7.9992', '162800', '0', '0', 0, '2023-08-01 05:35:51', '2023-08-01 05:35:51'),
(257, 12, 1, 2, 5, 0, '3', '369369369', '66.666666666667', '0', '7.9992', '203000', '0', '0', 0, '2023-08-01 05:35:51', '2023-08-01 05:35:51'),
(258, 12, 1, 2, 6, 0, '3', '369369369', '73.333333333333', '0', '7.9992', '243200', '0', '0', 0, '2023-08-01 05:35:51', '2023-08-01 05:35:51'),
(259, 12, 1, 2, 7, 0, '3', '369369369', '80', '0', '8.1202', '283400', '123123123', '33.333333333333', 1, '2023-08-01 05:35:51', '2023-08-01 05:35:51'),
(260, 12, 1, 2, 8, 0, '3', '369369369', '86.666666666667', '0', '8.1334', '323600', '123123123', '33.333333333333', 1, '2023-08-01 05:35:51', '2023-08-01 05:35:51'),
(261, 12, 1, 2, 9, 0, '3', '369369369', '93.333333333333', '0', '8.1334', '363800', '123123123', '33.333333333333', 0, '2023-08-01 05:35:51', '2023-08-01 05:35:51'),
(262, 12, 1, 2, 10, 0, '3', '369369369', '100', '0', '8.1334', '404000', '123123123', '33.333333333333', 0, '2023-08-01 05:35:51', '2023-08-01 05:35:51'),
(263, 12, 1, 2, 11, 0, '3', '369369369', '100', '0', '8.1334', '404000', '123123123', '33.333333333333', 0, '2023-08-01 05:35:51', '2023-08-01 05:35:51'),
(264, 12, 1, 2, 12, 0, '3', '369369369', '100', '0', '8.1334', '404000', '123123123', '33.333333333333', 0, '2023-08-01 05:35:51', '2023-08-01 05:35:51');

-- --------------------------------------------------------

--
-- Table structure for table `sub_kegiatans`
--

CREATE TABLE `sub_kegiatans` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `pak_id` bigint(20) UNSIGNED NOT NULL,
  `sumber_dana_id` bigint(20) UNSIGNED NOT NULL,
  `rekening` varchar(100) NOT NULL,
  `nama_sub_kegiatan` varchar(255) NOT NULL,
  `dau` tinyint(1) DEFAULT NULL,
  `dak` tinyint(1) DEFAULT NULL,
  `tugas_pembantuan` tinyint(1) DEFAULT NULL,
  `dekonsentrasi` tinyint(1) DEFAULT NULL,
  `pembiayaan` tinyint(1) DEFAULT NULL,
  `program_bupati` enum('Ya','Tidak') NOT NULL,
  `jenis_sub_kegiatan` enum('fisik','nonfisik') NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sub_kegiatans`
--

INSERT INTO `sub_kegiatans` (`id`, `user_id`, `pak_id`, `sumber_dana_id`, `rekening`, `nama_sub_kegiatan`, `dau`, `dak`, `tugas_pembantuan`, `dekonsentrasi`, `pembiayaan`, `program_bupati`, `jenis_sub_kegiatan`, `created_at`, `updated_at`) VALUES
(5, 12, 2, 1, '123123', '123123', 1, 1, 1, NULL, NULL, 'Tidak', 'nonfisik', '2023-07-04 06:38:17', '2023-07-04 06:40:12'),
(6, 12, 2, 1, '123123', '234234', 1, NULL, NULL, NULL, NULL, 'Tidak', 'nonfisik', '2023-07-31 06:41:51', '2023-07-31 06:41:51'),
(7, 12, 2, 1, '123123123123', 'Ini adalah sub kegiatan testing', 1, 1, NULL, NULL, NULL, 'Tidak', 'nonfisik', '2023-07-31 19:22:28', '2023-07-31 19:22:49');

-- --------------------------------------------------------

--
-- Table structure for table `sumber_danas`
--

CREATE TABLE `sumber_danas` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_sumber_dana` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sumber_danas`
--

INSERT INTO `sumber_danas` (`id`, `nama_sumber_dana`, `created_at`, `updated_at`) VALUES
(1, 'APBD KABUPATEN TIMOR TENGAH UTARA', '2022-09-22 23:35:55', '2022-09-22 23:35:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `kode_skpd` enum('1','2','3','4','5') NOT NULL,
  `nama_skpd` text NOT NULL,
  `nomor_tlp_kantor` varchar(255) NOT NULL,
  `alamat_kantor` text NOT NULL,
  `nama_operator` varchar(255) NOT NULL,
  `nomor_tlp_operator` varchar(255) NOT NULL,
  `alamat_operator` text NOT NULL,
  `nama_kpa` varchar(255) NOT NULL,
  `images` varchar(255) NOT NULL,
  `isAdmin` tinyint(1) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `kode_skpd`, `nama_skpd`, `nomor_tlp_kantor`, `alamat_kantor`, `nama_operator`, `nomor_tlp_operator`, `alamat_operator`, `nama_kpa`, `images`, `isAdmin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$Hob0OK5jckrNTaAzjh677upfTc7qEJ76VXGGZ7ZZ/2d42DIJ1h/GO', '1', 'Admin', '12828328', 'Pamekasan', 'Admin', '12828328', 'Sumenep', 'Admin', 'default.jpg', 1, NULL, '2022-09-23 06:35:55', '2022-09-23 06:35:55'),
(12, 'operator', '$2y$10$SdI0MsLVXI2iUGMo8KeJT.krbq1MidKKKLPWhRpmTDPAXX51xD7mW', '1', 'Operator Testing', '082336738210', 'JL. KABUPATEN 107 PAMEKASAN', 'DIENA RACHMANTI, S.Pd', '082336738210', 'Pamekasan', 'Dra. Ec. LAILI', 'default.jpg', 0, NULL, '2023-01-29 23:12:46', '2023-06-25 18:13:53'),
(97, 'Bag.AP', '$2y$10$pDt4Cc8ThyctBiQhGJdTW.HAIqqwVTb.oUFFG5nSN2ZdPwF/xl/3u', '1', 'Bagian Administrasi Pembangunan', '-', 'Jl. Basuki Rachmat - Benpasi - Kefamenanu', 'Noviyanti Tefa, SSTP', '081320080489', 'Jl. Basuki Rachmat - Benpasi - Kefamenanu', 'Delfiana T. Naisali, SSTP', 'default.jpg', 0, NULL, '2023-06-25 18:09:12', '2023-06-25 18:17:02');

-- --------------------------------------------------------

--
-- Table structure for table `user_penanggun_jawabs`
--

CREATE TABLE `user_penanggun_jawabs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `nama_penanggung_jawab` varchar(255) NOT NULL,
  `nip` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_penanggun_jawabs`
--

INSERT INTO `user_penanggun_jawabs` (`id`, `user_id`, `nama_penanggung_jawab`, `nip`, `created_at`, `updated_at`) VALUES
(1, 12, 'Khana', '234234234', '2023-07-04 21:01:40', '2023-07-04 21:51:05'),
(2, 12, 'wqreqwer', '3123123', '2023-07-04 21:06:01', '2023-07-04 21:06:01');

-- --------------------------------------------------------

--
-- Table structure for table `volumes`
--

CREATE TABLE `volumes` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `detail_sub_kegiatan_id` bigint(20) UNSIGNED NOT NULL,
  `volume` varchar(255) NOT NULL,
  `satuan_volume` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `volumes`
--

INSERT INTO `volumes` (`id`, `detail_sub_kegiatan_id`, `volume`, `satuan_volume`, `created_at`, `updated_at`) VALUES
(1, 2, '15', 'Orang', '2023-07-04 20:55:47', '2023-07-31 16:31:18'),
(2, 3, '1', 'Paket', '2023-07-31 06:47:59', '2023-07-31 06:47:59'),
(3, 4, '10', 'Orang', '2023-07-31 16:45:24', '2023-07-31 16:45:24'),
(4, 5, '100', 'Paket', '2023-07-31 19:25:12', '2023-07-31 19:25:12');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggarans`
--
ALTER TABLE `anggarans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bulans`
--
ALTER TABLE `bulans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `detail_sub_kegiatan`
--
ALTER TABLE `detail_sub_kegiatan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jadwals`
--
ALTER TABLE `jadwals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kunci_inputans`
--
ALTER TABLE `kunci_inputans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kunci_paks`
--
ALTER TABLE `kunci_paks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasis`
--
ALTER TABLE `lokasis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `paks`
--
ALTER TABLE `paks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `pelaksanaans`
--
ALTER TABLE `pelaksanaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penanggung_jawabs`
--
ALTER TABLE `penanggung_jawabs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengadaans`
--
ALTER TABLE `pengadaans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna_anggarans`
--
ALTER TABLE `pengguna_anggarans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `rekap`
--
ALTER TABLE `rekap`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_kegiatans`
--
ALTER TABLE `sub_kegiatans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sumber_danas`
--
ALTER TABLE `sumber_danas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_penanggun_jawabs`
--
ALTER TABLE `user_penanggun_jawabs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `volumes`
--
ALTER TABLE `volumes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggarans`
--
ALTER TABLE `anggarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `bulans`
--
ALTER TABLE `bulans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `detail_sub_kegiatan`
--
ALTER TABLE `detail_sub_kegiatan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jadwals`
--
ALTER TABLE `jadwals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `kunci_inputans`
--
ALTER TABLE `kunci_inputans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kunci_paks`
--
ALTER TABLE `kunci_paks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `lokasis`
--
ALTER TABLE `lokasis`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paks`
--
ALTER TABLE `paks`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pelaksanaans`
--
ALTER TABLE `pelaksanaans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `penanggung_jawabs`
--
ALTER TABLE `penanggung_jawabs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengadaans`
--
ALTER TABLE `pengadaans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengguna_anggarans`
--
ALTER TABLE `pengguna_anggarans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rekap`
--
ALTER TABLE `rekap`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=265;

--
-- AUTO_INCREMENT for table `sub_kegiatans`
--
ALTER TABLE `sub_kegiatans`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `sumber_danas`
--
ALTER TABLE `sumber_danas`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `user_penanggun_jawabs`
--
ALTER TABLE `user_penanggun_jawabs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `volumes`
--
ALTER TABLE `volumes`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
