-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2025 at 02:40 AM
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
-- Database: `monitoringmesin`
--

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `defects`
--

CREATE TABLE `defects` (
  `id` int(11) NOT NULL,
  `defect_category` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `defects`
--

INSERT INTO `defects` (`id`, `defect_category`, `created_at`, `updated_at`) VALUES
(3, 'Flow Lines', '2025-01-10 07:24:48', '2025-01-10 07:24:48'),
(4, 'Sink mark', '2025-01-10 07:25:28', '2025-01-10 07:25:28'),
(5, 'Burn mark', '2025-01-10 07:25:37', '2025-01-10 07:25:37'),
(6, 'Discoloration', '2025-01-10 07:25:46', '2025-01-10 07:25:46'),
(7, 'Flash', '2025-01-10 07:26:11', '2025-01-10 07:26:11'),
(8, 'Short shot / Short mold', '2025-01-10 07:26:21', '2025-01-10 07:26:21'),
(9, 'Pin Bent', '2025-01-10 07:26:28', '2025-01-10 07:26:28'),
(10, 'Gas mark', '2025-01-10 07:26:37', '2025-01-10 07:26:37'),
(11, 'Delamination', '2025-01-10 07:26:43', '2025-01-10 07:26:43'),
(12, 'Under cut', '2025-01-10 07:26:50', '2025-01-10 07:26:50'),
(13, 'Crack', '2025-01-10 07:26:59', '2025-01-10 07:26:59'),
(14, 'Scratches', '2025-01-10 07:27:38', '2025-01-10 07:27:38'),
(15, 'Weld Lines', '2025-01-10 07:27:47', '2025-01-10 07:27:47'),
(16, 'Warpage', '2025-01-10 07:27:52', '2025-01-10 07:27:52'),
(17, 'Contamination', '2025-01-10 07:27:57', '2025-01-10 07:27:57');

-- --------------------------------------------------------

--
-- Table structure for table `downtimes`
--

CREATE TABLE `downtimes` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `badge` varchar(255) DEFAULT NULL,
  `line` varchar(255) DEFAULT NULL,
  `molding_machine` varchar(255) DEFAULT NULL,
  `leader` varchar(255) DEFAULT NULL,
  `raised_ipqc` varchar(255) DEFAULT NULL,
  `raised_operator` varchar(255) DEFAULT NULL,
  `defect_category` varchar(255) DEFAULT NULL,
  `problem_defect` text DEFAULT NULL,
  `root_cause` varchar(255) DEFAULT NULL,
  `action_taken` varchar(255) DEFAULT NULL,
  `maintenance_repair` varchar(255) DEFAULT NULL,
  `production_verify` varchar(255) DEFAULT NULL,
  `qc_approve` varchar(255) DEFAULT NULL,
  `tanggal_submit` date DEFAULT NULL,
  `jam_submit` time DEFAULT NULL,
  `tanggal_start` date DEFAULT NULL,
  `jam_start` time DEFAULT NULL,
  `tanggal_finish` date DEFAULT NULL,
  `jam_finish` time DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `downtimes`
--

INSERT INTO `downtimes` (`id`, `user_id`, `badge`, `line`, `molding_machine`, `leader`, `raised_ipqc`, `raised_operator`, `defect_category`, `problem_defect`, `root_cause`, `action_taken`, `maintenance_repair`, `production_verify`, `qc_approve`, `tanggal_submit`, `jam_submit`, `tanggal_start`, `jam_start`, `tanggal_finish`, `jam_finish`, `status`, `created_at`, `updated_at`) VALUES
(74, 13, '55661', '12', '5', 'Barundang Air', 'Yola', 'qwqwq', 'wwesds', 'sdssds', 'Pakpahan', 'Pakpahan', 'Pakpahan', NULL, NULL, '2025-01-13', '15:21:00', '2025-01-13', '15:27:07', NULL, NULL, 'Menunggu QC Approve', '2025-01-13 08:21:30', '2025-01-13 09:03:47'),
(75, 13, '56772', '22', '4', 'Barundang Air', 'ueffw', '433', '13', 'qssqssq', 'Pakpahan', 'Pakpahan', 'Pakpahan', 'fatah/66573', 'sela/1234', '2025-01-13', '15:24:00', '2025-01-13', '15:27:05', '2025-01-13', '16:05:00', 'Completed', '2025-01-13 08:24:30', '2025-01-13 09:05:53'),
(76, 13, '56781', '90', '3', 'Barundang Air', 'wqwq', 'Yesi', 'gfhhfhfg', 'Aa', NULL, NULL, NULL, NULL, NULL, '2025-01-13', '15:38:00', '2025-01-13', '15:38:37', NULL, NULL, 'Sedang Diproses', '2025-01-13 08:32:00', '2025-01-13 08:38:38'),
(77, 13, 'dfgd', 'ddfgdg', '8', 'Barundang Air', 'dfgfd', 'dfgd', 'dgfdgd', 'dgfdgfdg', NULL, NULL, NULL, NULL, NULL, '2025-01-13', '15:39:00', '2025-01-13', '15:39:23', NULL, NULL, 'Sedang Diproses', '2025-01-13 08:39:01', '2025-01-13 08:39:23');

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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mesin`
--

CREATE TABLE `mesin` (
  `id` int(11) NOT NULL,
  `molding_mc` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mesin`
--

INSERT INTO `mesin` (`id`, `molding_mc`) VALUES
(1, 'IM 1'),
(2, 'IM 2'),
(3, 'IM 3'),
(4, 'IM 4'),
(5, 'IM 5'),
(6, 'IM 6'),
(7, 'IM 7'),
(8, 'IM 8');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2024_11_18_082645_create_setup_table', 1),
(5, '2024_12_12_152310_create_defects_table', 1),
(6, '2024_12_19_114434_create_notifications_table', 1),
(7, '2025_01_10_092810_create_mesin_table', 1),
(8, '2025_01_10_095914_create_downtimes_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `title`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(7, 11, 'Downtime Menunggu Approval', 'Ada downtime yang memerlukan approval QC untuk mesin 7', 0, '2025-01-11 04:07:53', '2025-01-11 04:07:53'),
(9, 11, 'Downtime Menunggu Approval', 'Ada downtime yang memerlukan approval QC untuk mesin 3', 0, '2025-01-11 04:42:14', '2025-01-11 04:42:14'),
(11, 11, 'Downtime Menunggu Approval', 'Ada downtime yang memerlukan approval QC untuk mesin 1', 0, '2025-01-11 05:01:14', '2025-01-11 05:01:14'),
(13, 11, 'Downtime Menunggu Approval', 'Ada downtime yang memerlukan approval QC untuk mesin 1', 0, '2025-01-11 05:06:24', '2025-01-11 05:06:24'),
(42, 11, 'Downtime Menunggu Approval', 'Ada downtime yang memerlukan approval QC untuk mesin 2', 0, '2025-01-12 04:18:11', '2025-01-12 04:18:11'),
(43, 11, 'Downtime Menunggu Approval', 'Ada downtime yang memerlukan approval QC untuk mesin 1', 0, '2025-01-12 04:23:40', '2025-01-12 04:23:40'),
(45, 11, 'Downtime Menunggu Approval', 'Ada downtime yang memerlukan approval QC untuk mesin 1', 0, '2025-01-12 04:31:29', '2025-01-12 04:31:29'),
(51, 11, 'Downtime Menunggu Approval', 'Ada downtime yang memerlukan approval QC untuk mesin 1', 0, '2025-01-12 05:49:38', '2025-01-12 05:49:38'),
(52, 11, 'Downtime Menunggu Approval', 'Ada downtime yang memerlukan approval QC untuk mesin 2', 0, '2025-01-12 05:54:14', '2025-01-12 05:54:14'),
(61, 5, 'Setup Baru', 'Ada laporan setup baru untuk mesin 4 di line 23. Job Request: sdadasd', 0, '2025-01-12 14:18:10', '2025-01-12 14:18:10'),
(62, 5, 'Setup Baru', 'Ada laporan setup baru untuk mesin 5 di line 23. Job Request: hgifi', 0, '2025-01-12 14:35:24', '2025-01-12 14:35:24'),
(63, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 5 di line 22. Kategori: Heeiii', 0, '2025-01-13 02:57:41', '2025-01-13 02:57:41'),
(64, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 7 di line 90. Kategori: 3', 0, '2025-01-13 03:08:05', '2025-01-13 03:08:05'),
(65, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 3 di line 22. Kategori: 8', 0, '2025-01-13 03:21:52', '2025-01-13 03:21:52'),
(66, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 5 di line 81. Kategori: Heeiii', 0, '2025-01-13 03:24:23', '2025-01-13 03:24:23'),
(67, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 1 di line 90. Kategori: 13', 0, '2025-01-13 03:26:48', '2025-01-13 03:26:48'),
(68, 5, 'Setup Baru', 'Ada laporan setup baru untuk mesin 7 di line 81. Job Request: WEDWFRW', 0, '2025-01-13 03:28:18', '2025-01-13 03:28:18'),
(69, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 1 di line 22. Kategori: 9', 0, '2025-01-13 03:32:43', '2025-01-13 03:32:43'),
(70, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 2 di line 81. Kategori: 15', 0, '2025-01-13 03:38:06', '2025-01-13 03:38:06'),
(71, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 4 di line 11. Kategori: 13', 0, '2025-01-13 03:51:58', '2025-01-13 03:51:58'),
(72, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 1 di line 90. Kategori: 11', 0, '2025-01-13 03:59:57', '2025-01-13 03:59:57'),
(73, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 6 di line 12. Kategori: 13', 0, '2025-01-13 04:04:20', '2025-01-13 04:04:20'),
(74, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 5 di line 22. Kategori: 14', 0, '2025-01-13 04:07:45', '2025-01-13 04:07:45'),
(75, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 2 di line 90. Kategori: 15', 0, '2025-01-13 04:13:22', '2025-01-13 04:13:22'),
(76, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 1 di line 90. Kategori: Heeiii', 0, '2025-01-13 04:24:30', '2025-01-13 04:24:30'),
(77, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 7 di line 12. Kategori: Heeiii', 0, '2025-01-13 04:38:45', '2025-01-13 04:38:45'),
(78, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 1 di line 11. Kategori: 6', 0, '2025-01-13 06:24:50', '2025-01-13 06:24:50'),
(79, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 2 di line 5. Kategori: 3', 0, '2025-01-13 06:27:27', '2025-01-13 06:27:27'),
(80, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 7 di line 90. Kategori: Heeiii', 0, '2025-01-13 06:50:10', '2025-01-13 06:50:10'),
(81, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 5 di line 22. Kategori: 13', 0, '2025-01-13 06:51:35', '2025-01-13 06:51:35'),
(82, 5, 'Setup Baru', 'Ada laporan setup baru untuk mesin 8 di line 81. Job Request: weeqew', 0, '2025-01-13 07:20:28', '2025-01-13 07:20:28'),
(83, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 8 di line 12. Kategori: 3', 0, '2025-01-13 07:30:44', '2025-01-13 07:30:44'),
(84, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 2 di line 81. Kategori: 16', 0, '2025-01-13 07:36:12', '2025-01-13 07:36:12'),
(85, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 7 di line 90. Kategori: saaads', 0, '2025-01-13 07:36:43', '2025-01-13 07:36:43'),
(86, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 4 di line 5. Kategori: 14', 0, '2025-01-13 07:37:57', '2025-01-13 07:37:57'),
(87, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 6 di line 5. Kategori: qsqs', 0, '2025-01-13 07:40:16', '2025-01-13 07:40:16'),
(88, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 1 di line 5. Kategori: qsssqssq', 0, '2025-01-13 07:41:09', '2025-01-13 07:41:09'),
(89, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 7 di line 22. Kategori: dsss', 0, '2025-01-13 07:54:23', '2025-01-13 07:54:23'),
(90, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 5 di line 11. Kategori: 13', 0, '2025-01-13 07:54:49', '2025-01-13 07:54:49'),
(91, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 7 di line fdd. Kategori: 16', 0, '2025-01-13 07:55:22', '2025-01-13 07:55:22'),
(92, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 5 di line 12. Kategori: asasa', 0, '2025-01-13 08:04:18', '2025-01-13 08:04:18'),
(93, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 2 di line 5. Kategori: 3', 0, '2025-01-13 08:05:51', '2025-01-13 08:05:51'),
(94, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 6 di line 81. Kategori: 3', 0, '2025-01-13 08:19:12', '2025-01-13 08:19:12'),
(95, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 5 di line 12. Kategori: wwesds', 0, '2025-01-13 08:21:30', '2025-01-13 08:21:30'),
(96, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 4 di line 22. Kategori: 13', 0, '2025-01-13 08:24:30', '2025-01-13 08:24:30'),
(97, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 3 di line 90. Kategori: AAaA', 0, '2025-01-13 08:32:00', '2025-01-13 08:32:00'),
(98, 5, 'Downtime Baru', 'Ada laporan downtime baru untuk mesin 8 di line ddfgdg. Kategori: 11', 0, '2025-01-13 08:39:01', '2025-01-13 08:39:01'),
(99, 11, 'Downtime Menunggu Approval', 'Ada downtime yang memerlukan approval QC untuk mesin 5', 0, '2025-01-13 09:03:47', '2025-01-13 09:03:47'),
(100, 11, 'Downtime Menunggu Approval', 'Ada downtime yang memerlukan approval QC untuk mesin 4', 0, '2025-01-13 09:03:59', '2025-01-13 09:03:59');

-- --------------------------------------------------------

--
-- Table structure for table `setup`
--

CREATE TABLE `setup` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `leader` varchar(100) DEFAULT NULL,
  `line` varchar(255) DEFAULT NULL,
  `schedule_datetime` datetime DEFAULT NULL,
  `part_number` varchar(255) DEFAULT NULL,
  `qty_product` int(11) DEFAULT NULL,
  `customer` varchar(255) DEFAULT NULL,
  `mould_type` varchar(255) DEFAULT NULL,
  `mould_category` varchar(255) DEFAULT NULL,
  `marking_type` varchar(255) DEFAULT NULL,
  `mould_cavity` varchar(100) DEFAULT NULL,
  `cable_grip_size` varchar(255) DEFAULT NULL,
  `molding_machine` varchar(255) DEFAULT NULL,
  `job_request` text DEFAULT NULL,
  `issued_date` date DEFAULT NULL,
  `asset_no_bt` varchar(255) DEFAULT NULL,
  `maintenance_name` varchar(255) DEFAULT NULL,
  `setup_problem` text DEFAULT NULL,
  `mould_type_mtc` varchar(255) DEFAULT NULL,
  `marking_type_mtc` varchar(255) DEFAULT NULL,
  `cable_grip_size_mtc` varchar(255) DEFAULT NULL,
  `ampere_rating` varchar(255) DEFAULT NULL,
  `marking` varchar(100) DEFAULT NULL,
  `relief` varchar(100) DEFAULT NULL,
  `mismatch` varchar(100) DEFAULT NULL,
  `pin_bar_connector` varchar(100) DEFAULT NULL,
  `qc_approve` varchar(100) DEFAULT NULL,
  `tanggal_submit` date DEFAULT NULL,
  `jam_submit` time DEFAULT NULL,
  `tanggal_start` date DEFAULT NULL,
  `jam_start` time DEFAULT NULL,
  `tanggal_finish` date DEFAULT NULL,
  `jam_finish` time DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `setup`
--

INSERT INTO `setup` (`id`, `user_id`, `leader`, `line`, `schedule_datetime`, `part_number`, `qty_product`, `customer`, `mould_type`, `mould_category`, `marking_type`, `mould_cavity`, `cable_grip_size`, `molding_machine`, `job_request`, `issued_date`, `asset_no_bt`, `maintenance_name`, `setup_problem`, `mould_type_mtc`, `marking_type_mtc`, `cable_grip_size_mtc`, `ampere_rating`, `marking`, `relief`, `mismatch`, `pin_bar_connector`, `qc_approve`, `tanggal_submit`, `jam_submit`, `tanggal_start`, `jam_start`, `tanggal_finish`, `jam_finish`, `status`, `created_at`, `updated_at`) VALUES
(15, 13, 'Barundang Air', '23', '2025-01-16 18:13:00', '45346fd546', 670, 'SS', 'QQ', 'Mold Connector', 'qqq', '7', 'wqrwq', '6', 'qwrew', '2025-01-12', 'dsfds', 'Raisa Salshabillah', 'sdfsf', 'sfdsf', 'dsfsd', 'sfds', 'dsfs', '1', '1', '1', '1', 'Elfrida/10562', '2025-01-12', '18:14:12', '2025-01-12', '18:15:20', '2025-01-12', '18:15:00', 'Completed', '2025-01-12 11:14:12', '2025-01-13 02:11:25'),
(16, 13, 'Barundang Air', '23', '2025-01-15 21:35:00', '45346fd546', 670, 'SS', 'QQ', 'Mold Inner', 'qqq', 'rwre', 'wqrwq', '5', 'hgifi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-12', '21:18:10', '2025-01-13', '10:50:04', NULL, NULL, 'Sedang Diproses', '2025-01-12 14:18:10', '2025-01-13 03:50:04'),
(17, 13, 'Barundang Air', '23', '2025-01-15 21:35:00', '45346fd546', 670, 'SS', 'QQ', 'Mold Connector', 'qqq', 'rwre', 'wqrwq', '5', 'hgifi', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-12', '21:35:24', '2025-01-13', '10:50:03', NULL, NULL, 'Sedang Diproses', '2025-01-12 14:35:24', '2025-01-13 03:50:03'),
(18, 13, 'Barundang Air', '81', '2025-01-16 10:27:00', '17AJK56AWG', 23, 'Amazon', '233ff', 'Mold Plug', 'de255', 'Hhaha', '56cm', '7', 'WEDWFRW', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-13', '10:28:18', '2025-01-13', '10:50:01', NULL, NULL, 'Sedang Diproses', '2025-01-13 03:28:18', '2025-01-13 03:50:02'),
(19, 13, 'Barundang Air', '81', '2025-01-15 14:20:00', '17AJK56AWG', 657, 'Philips', 'Hero', 'Mold Plug', 'de255', 'Hhaha', '56cm', '8', 'weeqew', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-01-13', '14:20:28', '2025-01-13', '15:40:17', NULL, NULL, 'Sedang Diproses', '2025-01-13 07:20:28', '2025-01-13 08:40:17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `badge` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `level_user` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_tlpn` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','leader','teknisi','ipqc') NOT NULL DEFAULT 'teknisi',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `badge`, `nama`, `level_user`, `email`, `no_tlpn`, `username`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '89532', 'totokii', 'staff tooling', 'totok@gmail.com', '085689789042', 'totok34562', '$2y$12$lVQ00PxTOnVlaxbw0rtn1OySJVAB0oQFerD1LTnNBUM7g/frcZVAa', 'admin', NULL, '2025-01-10 06:00:02', '2025-01-10 13:14:19'),
(4, '10564', 'Elfridaaa Tenti Nurlelay', 'staff teknisi', 'el@gmail.com', '0823-7689-9430', 'el123', '$2y$12$QZEoZiIRvEP9jejFCuJ99e4vN7bOmTeRjbDOQKQ32vOjwBiA0fV3C', 'admin', NULL, '2025-01-10 04:01:56', '2025-01-10 06:01:19'),
(5, '10563', 'Marsela Damayatiiy', 'teknisi_molding', 'marselaaritonang4@gmail.com', '0823-7689-9430', 'marsela25', '$2y$12$xV3kOdSj1hyjqFm28wAW.u49Tpc3jjv8I4nA3nq6J.2t/ZI388oHa', 'teknisi', NULL, '2025-01-10 04:17:10', '2025-01-10 14:16:44'),
(10, '77431', 'yulia', 'leader', 'yulia@gmail.com', '0823-5667-8990', 'yuli4560', '$2y$12$Z8cqFovvlpoqh18raOHbYu4eJyKkyeEa3M7ubrWT0S0r51BehSeta', 'leader', NULL, '2025-01-10 05:10:18', '2025-01-11 14:15:05'),
(11, '56680', 'Yudiii', 'ipqc', 'Yudiyy@gmail.com', '0895-7268-2267', 'yudi123', '$2y$12$YwgNP9Nq9k/vxqHI.l0pauav7fmM3cVHU5fAYMY9WbpoBU5BewmLO', 'ipqc', NULL, '2025-01-10 05:13:27', '2025-01-12 04:21:08'),
(12, '1234', 'Tenti', 'leader', 'tenti@gmail.com', '0823-7689-9433', 'tenti123', '$2y$12$J2Oq/R4EfQXPcp17fIVFA.9M5.sWMi8Gx2wPhk3VF2DiDDJL2uhWq', 'leader', NULL, '2025-01-10 05:50:44', '2025-01-10 05:50:44'),
(13, '56689', 'Barundang Air', 'Engginer Teknisi', 'kuli@gmail.com', '0823-7689-9431', 'barundang.air', '$2y$12$XYn2brdpKP0PK3Lm2ABMcONPd84NXNvReTIHGB2zP8lQ2zpifTGpi', 'leader', NULL, '2025-01-10 06:59:41', '2025-01-10 14:54:44');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `defects`
--
ALTER TABLE `defects`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `defects_defect_category_unique` (`defect_category`);

--
-- Indexes for table `downtimes`
--
ALTER TABLE `downtimes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `molding_machine` (`molding_machine`,`defect_category`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `mesin`
--
ALTER TABLE `mesin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mesin_molding_mc_unique` (`molding_mc`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `notifications_user_id_foreign` (`user_id`);

--
-- Indexes for table `setup`
--
ALTER TABLE `setup`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_badge_unique` (`badge`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `defects`
--
ALTER TABLE `defects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `downtimes`
--
ALTER TABLE `downtimes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=78;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `mesin`
--
ALTER TABLE `mesin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `setup`
--
ALTER TABLE `setup`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
