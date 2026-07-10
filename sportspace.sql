-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2026 at 05:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportspace`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status` enum('tertunda','terkonfirmasi','ditolak','dibatalkan','selesai') NOT NULL DEFAULT 'tertunda',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `booking_code` varchar(20) DEFAULT NULL,
  `metode_pembayaran` varchar(30) DEFAULT NULL,
  `bank` varchar(30) DEFAULT NULL,
  `total` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`booking_id`, `user_id`, `field_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `status`, `created_at`, `booking_code`, `metode_pembayaran`, `bank`, `total`) VALUES
(1, 2, 1, '2026-06-26', '06:00:00', '08:00:00', 'selesai', '2026-06-24 17:51:56', NULL, NULL, NULL, 0.00),
(2, 2, 1, '2026-06-27', '06:00:00', '08:00:00', 'selesai', '2026-06-24 17:53:18', NULL, NULL, NULL, 0.00),
(3, 2, 1, '2026-06-27', '06:00:00', '08:00:00', 'selesai', '2026-06-24 17:56:14', 'SS-2026-00003', NULL, NULL, 0.00),
(4, 2, 2, '2026-06-27', '07:00:00', '09:00:00', 'selesai', '2026-06-25 12:05:52', 'SS-2026-00004', NULL, NULL, 0.00),
(5, 2, 4, '2026-06-26', '13:00:00', '15:00:00', 'selesai', '2026-06-25 12:07:50', 'SS-2026-00005', NULL, NULL, 0.00),
(6, 2, 2, '2026-07-10', '07:00:00', '10:00:00', 'terkonfirmasi', '2026-07-01 03:58:49', 'SS-2026-00006', NULL, NULL, 0.00),
(7, 2, 2, '2026-07-03', '07:00:00', '09:00:00', 'selesai', '2026-07-01 18:22:37', 'SS-2026-00007', NULL, NULL, 0.00),
(8, 3, 1, '2026-07-03', '07:00:00', '10:00:00', 'selesai', '2026-07-01 20:33:47', 'SS-2026-00008', NULL, NULL, 0.00),
(9, 3, 1, '2026-07-02', '17:00:00', '18:00:00', 'selesai', '2026-07-01 20:49:57', 'SS-2026-00009', NULL, NULL, 0.00),
(10, 3, 2, '2026-07-03', '08:00:00', '10:00:00', '', '2026-07-01 21:47:45', 'SS-2026-00010', NULL, NULL, 0.00),
(11, 3, 2, '2026-07-03', '08:00:00', '10:00:00', 'selesai', '2026-07-01 21:50:25', 'SS-2026-00011', NULL, NULL, 0.00),
(12, 3, 2, '2026-07-03', '08:00:00', '10:00:00', 'selesai', '2026-07-01 22:04:01', 'SS-2026-00012', NULL, NULL, 0.00),
(13, 3, 2, '2026-07-03', '08:00:00', '10:00:00', 'selesai', '2026-07-01 22:12:12', 'SS-2026-00013', NULL, NULL, 0.00),
(14, 3, 1, '2026-07-04', '18:00:00', '20:00:00', 'selesai', '2026-07-01 22:31:29', 'SS-2026-00014', NULL, NULL, 0.00),
(15, 3, 1, '2026-07-03', '20:00:00', '21:00:00', 'selesai', '2026-07-01 22:41:44', 'SS-2026-00015', NULL, NULL, 0.00),
(16, 3, 1, '2026-07-04', '07:00:00', '09:00:00', 'selesai', '2026-07-01 22:52:37', 'SS-2026-00016', NULL, NULL, 0.00),
(17, 3, 1, '2026-07-03', '07:00:00', '08:00:00', 'selesai', '2026-07-02 05:29:18', 'SS-2026-00017', NULL, NULL, 0.00),
(18, 3, 2, '2026-07-25', '07:00:00', '09:00:00', 'selesai', '2026-07-02 10:08:27', 'SS-2026-00018', NULL, NULL, 0.00),
(19, 4, 1, '2026-07-04', '08:00:00', '10:00:00', '', '2026-07-03 07:18:28', 'SS-2026-00019', NULL, NULL, 0.00),
(20, 4, 1, '0000-00-00', '08:00:00', '09:00:00', '', '2026-07-03 07:53:33', 'SS-2026-00020', NULL, NULL, 0.00),
(21, 4, 1, '2026-08-01', '19:00:00', '20:00:00', '', '2026-07-03 09:22:28', 'SS-2026-00021', 'dana', '', 82500.00),
(22, 4, 1, '2026-07-18', '19:00:00', '20:00:00', '', '2026-07-03 09:29:31', 'SS-2026-00022', 'shopeepay', '', 82500.00),
(23, 4, 1, '2026-07-16', '09:00:00', '10:00:00', '', '2026-07-03 09:45:14', 'SS-2026-00023', 'qris', '', 82500.00),
(24, 4, 1, '2026-07-16', '09:00:00', '10:00:00', '', '2026-07-03 09:48:30', 'SS-2026-00024', 'shopeepay', '', 82500.00),
(25, 4, 1, '2026-07-04', '10:00:00', '11:00:00', 'selesai', '2026-07-03 10:00:41', 'SS-2026-00025', 'transfer', '', 82500.00),
(26, 4, 2, '2026-07-04', '09:00:00', '10:00:00', 'tertunda', '2026-07-03 10:02:02', 'SS-2026-00026', 'transfer', 'mandiri', 47500.00),
(27, 4, 2, '2026-07-10', '09:00:00', '11:00:00', 'tertunda', '2026-07-03 10:13:36', 'SS-2026-00027', 'transfer', 'mandiri', 92500.00),
(28, 4, 1, '2026-07-03', '00:00:19', '20:00:00', 'tertunda', '2026-07-03 11:25:26', 'SS-2026-00028', 'transfer', 'mandiri', 82500.00),
(29, 4, 1, '2026-07-06', '00:00:18', '20:00:00', 'tertunda', '2026-07-06 10:45:42', 'SS-2026-00029', 'dana', '', 162500.00),
(30, 13, 1, '2026-07-16', '12:00:00', '13:00:00', 'tertunda', '2026-07-08 12:40:39', 'SS-2026-00030', 'qris', '', 82500.00),
(31, 13, 2, '2026-07-11', '18:00:00', '19:00:00', 'tertunda', '2026-07-08 12:42:36', 'SS-2026-00031', 'gopay', '', 47500.00),
(32, 14, 10, '2026-07-23', '06:00:00', '08:00:00', 'terkonfirmasi', '2026-07-09 05:45:23', 'SS-2026-00032', 'gopay', '', 122500.00),
(33, 5, 10, '2026-07-09', '13:00:00', '22:00:00', 'selesai', '2026-07-09 05:52:31', 'SS-2026-00033', 'transfer', '', 542500.00),
(34, 14, 10, '2026-07-09', '06:00:00', '13:00:00', 'selesai', '2026-07-09 05:54:09', 'SS-2026-00034', 'qris', '', 422500.00),
(35, 14, 10, '2026-08-06', '12:00:00', '14:00:00', 'terkonfirmasi', '2026-07-09 09:07:49', 'SS-2026-00035', 'dana', '', 122500.00),
(36, 14, 10, '2026-07-23', '08:00:00', '09:00:00', 'terkonfirmasi', '2026-07-09 10:03:18', 'SS-2026-00036', 'qris', '', 62500.00),
(37, 14, 10, '2026-07-18', '06:00:00', '08:00:00', 'terkonfirmasi', '2026-07-09 10:08:53', 'SS-2026-00037', 'transfer', '', 122500.00),
(38, 14, 10, '2026-07-18', '06:00:00', '08:00:00', 'terkonfirmasi', '2026-07-09 10:09:01', 'SS-2026-00038', 'transfer', '', 122500.00),
(39, 14, 10, '2026-07-24', '17:00:00', '19:00:00', 'dibatalkan', '2026-07-09 10:54:03', 'SS-2026-00039', 'dana', '', 122500.00),
(40, 14, 10, '2026-07-18', '12:00:00', '14:00:00', 'terkonfirmasi', '2026-07-09 17:36:51', 'SS-2026-00040', 'qris', '', 122500.00),
(41, 14, 10, '2026-07-17', '06:00:00', '07:00:00', 'dibatalkan', '2026-07-09 17:38:08', 'SS-2026-00041', 'qris', '', 62500.00),
(42, 14, 10, '2026-07-25', '19:00:00', '20:00:00', 'terkonfirmasi', '2026-07-09 17:40:31', 'SS-2026-00042', 'qris', '', 62500.00),
(43, 14, 10, '2026-08-01', '12:00:00', '13:00:00', 'dibatalkan', '2026-07-09 23:23:29', 'SS-2026-00043', 'qris', '', 62500.00),
(44, 14, 10, '2026-07-22', '13:00:00', '15:00:00', 'terkonfirmasi', '2026-07-10 02:45:44', 'SS-2026-00044', 'qris', '', 122500.00),
(45, 14, 10, '2026-07-31', '19:00:00', '20:00:00', 'dibatalkan', '2026-07-10 02:51:40', 'SS-2026-00045', 'qris', '', 62500.00),
(46, 14, 10, '2026-07-22', '10:00:00', '11:00:00', 'terkonfirmasi', '2026-07-10 02:54:06', 'SS-2026-00046', 'qris', '', 62500.00),
(47, 14, 10, '2026-07-24', '17:00:00', '18:00:00', 'tertunda', '2026-07-10 03:16:36', 'SS-2026-00047', 'qris', '', 62500.00);

-- --------------------------------------------------------

--
-- Table structure for table `chat`
--

CREATE TABLE `chat` (
  `chat_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `field_id` int(11) DEFAULT NULL,
  `sender` enum('user','admin') DEFAULT NULL,
  `pesan` text DEFAULT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` enum('terbaca','belum') DEFAULT 'belum'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chat`
--

INSERT INTO `chat` (`chat_id`, `user_id`, `booking_id`, `field_id`, `sender`, `pesan`, `waktu`, `status`) VALUES
(1, 3, NULL, 1, 'user', 'haii', '2026-07-01 20:11:13', 'belum'),
(2, 3, NULL, 1, 'user', 'halo adminn', '2026-07-01 20:15:00', 'belum'),
(3, 3, NULL, 1, 'user', 'tesss', '2026-07-01 20:15:52', 'belum'),
(4, 3, NULL, 1, 'user', 'haii', '2026-07-01 20:16:00', 'belum'),
(5, 4, NULL, 1, 'user', 'halo', '2026-07-03 07:17:40', 'belum'),
(6, 4, NULL, 1, 'user', 'mau cek lapangan', '2026-07-03 07:17:51', 'belum'),
(7, 14, NULL, 10, 'user', 'halo', '2026-07-09 09:35:29', 'terbaca'),
(8, 14, NULL, 10, 'admin', 'oittt', '2026-07-09 10:55:13', 'terbaca'),
(9, 14, NULL, 10, 'user', 'anjay', '2026-07-09 11:02:58', 'terbaca'),
(10, 14, NULL, 10, 'admin', 'yayaya', '2026-07-09 11:03:16', 'terbaca'),
(11, 14, NULL, 10, 'user', 'kiw', '2026-07-09 11:07:34', 'terbaca'),
(12, 14, NULL, 10, 'user', 'kak', '2026-07-09 11:18:39', 'terbaca'),
(13, 14, NULL, 10, 'user', 'kak', '2026-07-09 13:08:42', 'terbaca'),
(14, 14, NULL, 10, 'admin', 'yaa', '2026-07-09 13:40:31', 'terbaca'),
(15, 14, NULL, 10, 'user', 'kakakkk', '2026-07-09 13:42:17', 'terbaca'),
(16, 14, NULL, 10, 'user', 'tes', '2026-07-09 13:58:49', 'terbaca'),
(17, 14, NULL, 10, 'user', 'tes', '2026-07-09 15:57:39', 'terbaca'),
(18, 14, NULL, 10, 'user', 'tes', '2026-07-09 15:57:46', 'terbaca'),
(19, 14, NULL, 10, 'user', 'p', '2026-07-09 15:57:53', 'terbaca'),
(20, 14, NULL, 10, 'user', 'y', '2026-07-09 16:03:34', 'terbaca'),
(21, 14, NULL, 10, 'admin', 'l', '2026-07-09 16:23:20', 'terbaca'),
(22, 14, NULL, 10, 'admin', 'knp', '2026-07-09 16:29:58', 'terbaca'),
(23, 14, NULL, 10, 'admin', 'woi', '2026-07-09 16:30:00', 'terbaca'),
(24, 14, NULL, 10, 'user', 'is', '2026-07-09 16:31:01', 'terbaca'),
(25, 14, NULL, 10, 'user', 'apaa', '2026-07-09 16:31:11', 'terbaca'),
(26, 14, NULL, 10, 'admin', 'gapapa', '2026-07-09 16:31:16', 'terbaca'),
(27, 14, NULL, 10, 'admin', 'l', '2026-07-09 16:32:06', 'terbaca'),
(28, 14, NULL, 10, 'admin', 'lo', '2026-07-09 16:32:14', 'terbaca'),
(29, 14, NULL, 10, 'admin', 'yoi', '2026-07-09 16:34:02', 'terbaca'),
(30, 14, NULL, 10, 'admin', 'apasii', '2026-07-09 16:34:56', 'terbaca'),
(31, 14, NULL, 10, 'user', 'gaapapp', '2026-07-09 16:35:10', 'terbaca'),
(32, 14, NULL, 2, 'user', 'pp apa', '2026-07-09 17:40:57', 'belum'),
(33, 14, NULL, 10, 'user', 'hai im comback', '2026-07-09 17:41:26', 'terbaca'),
(34, 14, NULL, 10, 'user', 'gajadi', '2026-07-09 17:43:32', 'terbaca'),
(35, 14, NULL, 10, 'admin', 'yaaa', '2026-07-09 22:40:19', 'terbaca'),
(36, 14, NULL, 10, 'admin', 'hmmm', '2026-07-09 22:49:44', 'terbaca'),
(37, 14, NULL, 10, 'admin', 'woi', '2026-07-10 02:41:33', 'terbaca'),
(38, 14, NULL, 10, 'admin', 'p', '2026-07-10 02:41:46', 'terbaca'),
(39, 14, NULL, 10, 'admin', 'i', '2026-07-10 02:43:45', 'terbaca'),
(40, 14, NULL, 10, 'admin', 'ttutu', '2026-07-10 02:49:33', 'terbaca'),
(41, 14, NULL, 10, 'user', 'oi', '2026-07-10 03:16:47', 'belum');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `favorites`
--

INSERT INTO `favorites` (`favorite_id`, `user_id`, `field_id`, `created_at`) VALUES
(4, 3, 1, '2026-07-01 19:20:55'),
(6, 3, 2, '2026-07-01 19:31:09'),
(7, 4, 1, '2026-07-03 07:15:57'),
(8, 4, 2, '2026-07-03 07:16:20'),
(9, 4, 6, '2026-07-09 12:40:25');

-- --------------------------------------------------------

--
-- Table structure for table `fields`
--

CREATE TABLE `fields` (
  `field_id` int(11) NOT NULL,
  `owner_id` int(11) DEFAULT NULL,
  `nama_lapangan` varchar(100) NOT NULL,
  `jenis` varchar(50) NOT NULL,
  `harga` decimal(10,2) NOT NULL,
  `status` enum('tersedia','penuh') NOT NULL DEFAULT 'tersedia',
  `lokasi` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `owner_name` varchar(100) DEFAULT NULL,
  `owner_phone` varchar(20) DEFAULT NULL,
  `owner_address` varchar(255) DEFAULT NULL,
  `jam_operasional` varchar(50) DEFAULT NULL,
  `kapasitas` int(11) DEFAULT NULL,
  `jenis_lantai` varchar(50) DEFAULT NULL,
  `fasilitas` text DEFAULT NULL,
  `maps_link` text DEFAULT NULL,
  `google_maps_url` text DEFAULT NULL,
  `verifikasi` enum('pending','diterima','ditolak') NOT NULL DEFAULT 'pending',
  `durasi_slot` int(11) NOT NULL DEFAULT 1,
  `hari_libur` text DEFAULT NULL,
  `aktif` enum('aktif','nonaktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fields`
--

INSERT INTO `fields` (`field_id`, `owner_id`, `nama_lapangan`, `jenis`, `harga`, `status`, `lokasi`, `gambar`, `deskripsi`, `owner_name`, `owner_phone`, `owner_address`, `jam_operasional`, `kapasitas`, `jenis_lantai`, `fasilitas`, `maps_link`, `google_maps_url`, `verifikasi`, `durasi_slot`, `hari_libur`, `aktif`) VALUES
(1, NULL, 'Lapangan Futsal A ', 'Futsal', 80000.00, 'tersedia', 'Jl. Kaliurang Km 7, Sleman', 'lapangan-futsal.jpg', 'Lapangan futsal premium dengan lantai vinyl.              ', 'Bapak Suharto', '081234567890', 'Jl. Kaliurang Km 7, Sleman', '06.00 - 22.00', 10, 'Vinyl', 'Parkir,Kantin,Toilet', 'https://www.google.com/maps?q=Jl.+Kaliurang+Km+7+Sleman&output=embed', 'https://maps.google.com/?q=Jl.+Kaliurang+Km+7+Sleman', 'diterima', 1, NULL, 'aktif'),
(2, NULL, 'Arena Badminton 88', 'Badminton', 45000.00, 'tersedia', 'Jl. Magelang Km 5, Yogyakarta', 'badminton.jpg', 'Lapangan badminton indoor dengan pencahayaan terang dan area bermain nyaman.', 'Bapak Andi', '081298765432', 'Jl. Magelang Km 5, Yogyakarta', '07.00 - 22.00', 4, 'Karpet Badminton', 'Toilet, Kantin, Parkir', 'https://www.google.com/maps?q=Jl.+Magelang+Km+5+Yogyakarta&output=embed', 'https://maps.google.com/?q=Jl.+Magelang+Km+5+Yogyakarta', 'diterima', 1, NULL, 'aktif'),
(3, NULL, 'Basket Court Pro', 'Basket', 120000.00, 'penuh', 'Kota Yogyakarta', 'lapangan-basket.jpg', 'Lapangan basket indoor premium dengan lantai kayu berkualitas, ring standar pertandingan dan tribun penonton.', 'Basket Court Pro', '081290907788', 'Kota Yogyakarta', '08.00 - 23.00', 14, 'Kayu Indoor', 'Tribun, Toilet, Kantin', 'https://www.google.com/maps?q=Kota+Yogyakarta&output=embed', 'https://maps.google.com/?q=Kota+Yogyakarta', 'ditolak', 1, NULL, 'aktif'),
(4, NULL, 'GOR Sport Center', 'Futsal', 70000.00, 'tersedia', 'Jl. Ringroad Utara, Sleman', 'lapangan-futsal2.jpg', 'Lapangan futsal indoor dengan rumput sintetis dan fasilitas lengkap.', 'Bapak Budi', '081377778888', 'Jl. Ringroad Utara, Sleman', '06.00 - 23.00', 10, 'Rumput Sintetis', 'Toilet, Mushola, Parkir', 'https://www.google.com/maps?q=Jl.+Ringroad+Utara+Sleman&output=embed', 'https://maps.google.com/?q=Jl.+Ringroad+Utara+Sleman', 'diterima', 1, NULL, 'nonaktif'),
(6, NULL, 'Lapangan Basket A', 'Basket', 90000.00, 'tersedia', 'Jl. Kaliurang Km 9, Sleman', '1783079207_баскетбол.jpg', '                ', NULL, NULL, NULL, '08:00 - 22:00', 15, 'Vinyl', NULL, NULL, NULL, 'diterima', 1, NULL, 'aktif'),
(10, 4, 'asfua', 'Futsal', 60000.00, 'tersedia', 'Jl. Ringroad Utara, Sleman', '1783574856_Badminton vibessss.jpg', '                qeqeq', 'Kui', '0812456783999', '', '08:00 - 23:00', 0, 'Vinyl', '', 'https://www.google.com/maps?q=Jl.+Ringroad+Utara%2C+Sleman&output=embed', 'https://maps.google.com/?q=Jl.+Ringroad+Utara%2C+Sleman', 'diterima', 1, '2026-07-10 s/d 2026-07-16', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `judul` varchar(100) DEFAULT NULL,
  `isi` text DEFAULT NULL,
  `status` enum('dibaca','belum') DEFAULT 'belum',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notification_id`, `user_id`, `booking_id`, `judul`, `isi`, `status`, `created_at`) VALUES
(1, 3, 8, 'Booking Berhasil', 'Booking lapangan berhasil dibuat. Pembayaran Anda sedang menunggu verifikasi admin.', 'belum', '2026-07-01 20:33:47'),
(2, 3, 9, 'Booking Berhasil', 'Booking lapangan berhasil dibuat. Pembayaran Anda sedang menunggu verifikasi admin.', 'belum', '2026-07-01 20:49:57'),
(3, 3, 10, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-01 21:47:46'),
(4, 3, 11, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-01 21:50:25'),
(5, 3, 12, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-01 22:04:01'),
(6, 3, 13, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-01 22:12:12'),
(7, 3, 14, 'Booking Berhasil Dibuat', 'Booking berhasil dibuat. Silakan lakukan pembayaran saat tiba di lokasi sesuai jadwal.', 'belum', '2026-07-01 22:31:29'),
(8, 3, 15, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-01 22:41:44'),
(9, 3, 16, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-01 22:52:37'),
(10, 3, 17, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-02 05:29:18'),
(11, 3, 18, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-02 10:08:27'),
(12, 4, 19, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-03 07:18:28'),
(13, 4, 20, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-03 07:53:33'),
(14, 4, 24, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-03 09:48:30'),
(15, 4, 25, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-03 10:00:41'),
(16, 4, 26, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-03 10:02:02'),
(17, 4, 27, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-03 10:13:36'),
(18, 4, 28, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-03 11:25:26'),
(19, 4, 29, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-06 10:45:42'),
(20, 13, 30, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-08 12:40:39'),
(21, 13, 31, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-08 12:42:36'),
(22, 14, 32, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-09 05:45:24'),
(23, 5, 33, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-09 05:52:31'),
(24, 14, 34, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-09 05:54:09'),
(25, 14, 35, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-09 09:07:49'),
(26, 14, 36, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-09 10:03:18'),
(27, 14, 37, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-09 10:09:00'),
(28, 14, 38, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-09 10:09:01'),
(29, 14, 39, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-09 10:54:03'),
(30, 14, 40, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-09 17:36:52'),
(31, 14, 41, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-09 17:38:08'),
(32, 14, 42, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-09 17:40:31'),
(33, 14, 43, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-09 23:23:29'),
(34, 14, 44, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-10 02:45:44'),
(35, 14, 45, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-10 02:51:40'),
(36, 14, 46, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-10 02:54:06'),
(37, 14, 47, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-10 03:16:36');

-- --------------------------------------------------------

--
-- Table structure for table `owners`
--

CREATE TABLE `owners` (
  `owner_id` int(11) NOT NULL,
  `field_id` int(11) DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(15) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `owners`
--

INSERT INTO `owners` (`owner_id`, `field_id`, `user_id`, `nama`, `email`, `telepon`, `alamat`) VALUES
(2, NULL, 10, 'andi', 'andi@gmail.com', '089786543678', NULL),
(3, NULL, 11, 'keonho', 'keonho@sportspace.com', '081234567899', NULL),
(4, NULL, 14, 'Kui', 'kui@gmail.com', '0812456783999', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `metode` enum('transfer','ewallet','cash') NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('tertunda','diverifikasi','ditolak') NOT NULL DEFAULT 'tertunda',
  `tanggal_bayar` timestamp NOT NULL DEFAULT current_timestamp(),
  `bank` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payment`
--

INSERT INTO `payment` (`payment_id`, `booking_id`, `metode`, `total`, `status`, `tanggal_bayar`, `bank`) VALUES
(1, 1, '', 162500.00, 'tertunda', '2026-06-24 17:51:56', NULL),
(2, 2, '', 162500.00, 'tertunda', '2026-06-24 17:53:18', NULL),
(3, 3, '', 162500.00, 'tertunda', '2026-06-24 17:56:14', NULL),
(4, 4, '', 92500.00, 'tertunda', '2026-06-25 12:05:52', NULL),
(5, 5, '', 142500.00, 'tertunda', '2026-06-25 12:07:50', NULL),
(6, 6, '', 137500.00, 'tertunda', '2026-07-01 03:58:49', NULL),
(7, 7, '', 92500.00, 'tertunda', '2026-07-01 18:22:37', NULL),
(8, 8, '', 242500.00, 'tertunda', '2026-07-01 20:33:47', NULL),
(9, 9, 'cash', 82500.00, 'tertunda', '2026-07-01 20:49:57', NULL),
(10, 10, '', 92500.00, 'tertunda', '2026-07-01 21:47:46', NULL),
(11, 11, '', 92500.00, 'tertunda', '2026-07-01 21:50:25', NULL),
(12, 12, '', 92500.00, 'tertunda', '2026-07-01 22:04:01', NULL),
(13, 13, '', 92500.00, 'tertunda', '2026-07-01 22:12:12', NULL),
(14, 14, 'cash', 162500.00, 'tertunda', '2026-07-01 22:31:29', NULL),
(15, 15, '', 82500.00, 'tertunda', '2026-07-01 22:41:44', NULL),
(16, 16, '', 162500.00, 'tertunda', '2026-07-01 22:52:37', NULL),
(17, 17, '', 82500.00, 'tertunda', '2026-07-02 05:29:18', NULL),
(18, 18, '', 92500.00, 'tertunda', '2026-07-02 10:08:27', NULL),
(19, 19, '', 162500.00, 'tertunda', '2026-07-03 07:18:28', NULL),
(20, 20, '', 82500.00, 'tertunda', '2026-07-03 07:53:33', NULL),
(21, 24, '', 82500.00, 'tertunda', '2026-07-03 09:48:30', ''),
(22, 25, 'transfer', 82500.00, 'tertunda', '2026-07-03 10:00:41', ''),
(23, 26, 'transfer', 47500.00, 'tertunda', '2026-07-03 10:02:02', 'mandiri'),
(24, 27, 'transfer', 92500.00, 'tertunda', '2026-07-03 10:13:36', 'mandiri'),
(25, 28, 'transfer', 82500.00, 'tertunda', '2026-07-03 11:25:26', 'mandiri'),
(26, 29, '', 162500.00, 'tertunda', '2026-07-06 10:45:42', ''),
(27, 30, '', 82500.00, 'tertunda', '2026-07-08 12:40:39', ''),
(28, 31, '', 47500.00, 'tertunda', '2026-07-08 12:42:36', ''),
(29, 32, '', 122500.00, 'tertunda', '2026-07-09 05:45:24', ''),
(30, 33, 'transfer', 542500.00, 'tertunda', '2026-07-09 05:52:31', ''),
(31, 34, '', 422500.00, 'tertunda', '2026-07-09 05:54:09', ''),
(32, 35, '', 122500.00, 'tertunda', '2026-07-09 09:07:49', ''),
(33, 36, '', 62500.00, 'tertunda', '2026-07-09 10:03:18', ''),
(34, 37, 'transfer', 122500.00, 'tertunda', '2026-07-09 10:08:59', ''),
(35, 38, 'transfer', 122500.00, 'tertunda', '2026-07-09 10:09:01', ''),
(36, 39, '', 182500.00, 'tertunda', '2026-07-09 10:54:03', ''),
(37, 40, '', 122500.00, 'tertunda', '2026-07-09 17:36:52', ''),
(38, 41, '', 62500.00, 'tertunda', '2026-07-09 17:38:08', ''),
(39, 42, '', 62500.00, 'tertunda', '2026-07-09 17:40:31', ''),
(40, 43, '', 62500.00, 'tertunda', '2026-07-09 23:23:29', ''),
(41, 44, '', 122500.00, 'tertunda', '2026-07-10 02:45:44', ''),
(42, 45, '', 62500.00, 'tertunda', '2026-07-10 02:51:40', ''),
(43, 46, '', 62500.00, 'tertunda', '2026-07-10 02:54:06', ''),
(44, 47, '', 62500.00, 'tertunda', '2026-07-10 03:16:36', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(15) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin','owner') NOT NULL DEFAULT 'user',
  `aktif` enum('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `nama`, `email`, `telepon`, `password`, `role`, `aktif`, `created_at`) VALUES
(2, 'Admin SportSpace', 'admin@sportspace.com', '', '$2y$10$brYWNAsymma8VKUj/wFmNOBF1NGyJQD21NZMPSABlbKjFEyM/tl0a', 'admin', 'aktif', '2026-06-13 09:28:16'),
(3, 'Siti Maysaroh', 'maysaarou@students.amikom.ac.id', '', '$2y$10$I7KpPrTCkbuka5r/7gWk8ub2SoGQBKZl8Tad6Bh9MSN914ffOUlJ.', 'user', 'aktif', '2026-06-23 18:49:08'),
(4, 'Maysa', 'maysaa@students.amikom.ac.id', '', '$2y$10$Iunqp.u35GEGZccDd7WCBuvODLFpfWX0rFtPjv7xBM7Pu6hcB3FL6', 'user', 'aktif', '2026-07-02 10:26:25'),
(5, 'mpruy', 'mpruy34@gmail.com', '', '$2y$10$SeTCGVHmecPXS0HSYYifoub8X55ymd0gqOXBga.5G2kxYklzda2OW', 'user', 'aktif', '2026-07-03 11:44:25'),
(10, 'andi', 'andi@gmail.com', '089786543678', '$2y$10$wPvbeOUnT/Ucsa8OciBrC.igIchv1UKxBbDz6O1RlEiSV4Gu8ArSa', 'owner', 'aktif', '2026-07-03 13:26:33'),
(11, 'keonho', 'keonho@sportspace.com', '081234567899', '$2y$10$ne/T5RVxwwKjQ3iSmtfV5O.nxtwAKo4qF5Dow9pbDogMxYGC.LYPC', 'owner', 'nonaktif', '2026-07-03 16:59:45'),
(12, 'martin', 'martin@sportspace.com', '081234567891', '$2y$10$KzZyPvIDVpqjP5Kk/pmEaOhzWhlL/FlHHsNVMuO6.Guxd3.mgGxz2', 'user', 'aktif', '2026-07-05 20:11:24'),
(13, 'Lucy', 'lucy@gmail.com', '089786543678', '$2y$10$KuGVd0ai9IX3ca1EQaxks.xXToThcJ7Jb4uZub1uneJkeBeh0RqnK', 'user', 'aktif', '2026-07-07 12:03:04'),
(14, 'Kui', 'kui@gmail.com', '0812456783999', '$2y$10$LdIsC6DOCT5HYQYgaFQ0tOM.1p1N4VJAamXozfxE.1T.6P0eh17P6', 'owner', 'aktif', '2026-07-08 09:53:49');

-- --------------------------------------------------------

--
-- Table structure for table `user_notifications`
--

CREATE TABLE `user_notifications` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `field_id` int(11) DEFAULT NULL,
  `booking_id` int(11) DEFAULT NULL,
  `jenis` enum('chat','booking_dibuat','booking_diterima','booking_dibatalkan','pembayaran_diterima','pembayaran_ditolak') NOT NULL,
  `judul` varchar(100) NOT NULL,
  `isi` text NOT NULL,
  `status` enum('belum','dibaca') DEFAULT 'belum',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_notifications`
--

INSERT INTO `user_notifications` (`notification_id`, `user_id`, `field_id`, `booking_id`, `jenis`, `judul`, `isi`, `status`, `created_at`) VALUES
(1, 14, 10, 40, 'booking_dibuat', 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'dibaca', '2026-07-09 17:36:52'),
(2, 14, 10, 41, 'booking_dibuat', 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'dibaca', '2026-07-09 17:38:08'),
(3, 14, 10, 40, 'booking_diterima', 'Booking Diterima', 'Booking Anda telah diterima oleh owner.', 'dibaca', '2026-07-09 17:38:24'),
(4, 14, 10, 42, 'booking_dibuat', 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'dibaca', '2026-07-09 17:40:31'),
(5, 14, 10, 42, 'booking_diterima', 'Booking Diterima', 'Booking Anda telah diterima oleh owner.', 'dibaca', '2026-07-09 22:39:48'),
(6, 14, 10, NULL, 'chat', 'Pesan Baru', 'Owner mengirim pesan baru kepada Anda.', 'dibaca', '2026-07-09 22:40:19'),
(7, 14, 10, 41, '', 'Booking Ditolak', 'Maaf, booking Anda ditolak oleh owner.', 'dibaca', '2026-07-09 22:45:36'),
(8, 14, 10, NULL, 'chat', 'Pesan Baru', 'Owner mengirim pesan baru kepada Anda.', 'dibaca', '2026-07-09 22:49:44'),
(9, 14, 10, 43, 'booking_dibuat', 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'dibaca', '2026-07-09 23:23:29'),
(10, 14, 10, 43, 'booking_dibatalkan', 'Booking Dibatalkan', 'Maaf, booking Anda dibatalkan oleh owner.', 'dibaca', '2026-07-09 23:23:50'),
(11, 14, 10, NULL, 'chat', 'Pesan Baru', 'Owner mengirim pesan baru kepada Anda.', 'dibaca', '2026-07-10 02:49:33'),
(12, 14, 10, 45, 'booking_dibatalkan', 'Booking Dibatalkan', 'Maaf, booking Anda dibatalkan oleh owner.', 'dibaca', '2026-07-10 02:52:45'),
(13, 14, 10, 46, 'booking_diterima', 'Booking Diterima', 'Booking Anda telah diterima oleh owner.', 'dibaca', '2026-07-10 02:54:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `field_id` (`field_id`);

--
-- Indexes for table `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`);

--
-- Indexes for table `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`field_id`),
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

--
-- Indexes for table `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`owner_id`),
  ADD KEY `field_id` (`field_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD PRIMARY KEY (`notification_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `booking_id` (`booking_id`),
  ADD KEY `field_id` (`field_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`);

--
-- Constraints for table `fields`
--
ALTER TABLE `fields`
  ADD CONSTRAINT `fields_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `owners` (`owner_id`);

--
-- Constraints for table `owners`
--
ALTER TABLE `owners`
  ADD CONSTRAINT `owners_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`),
  ADD CONSTRAINT `owners_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`);

--
-- Constraints for table `user_notifications`
--
ALTER TABLE `user_notifications`
  ADD CONSTRAINT `user_notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_notifications_ibfk_2` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `user_notifications_ibfk_3` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
