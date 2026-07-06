-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 06, 2026 at 02:28 PM
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
(1, 2, 1, '2026-06-26', '06:00:00', '08:00:00', 'terkonfirmasi', '2026-06-24 17:51:56', NULL, NULL, NULL, 0.00),
(2, 2, 1, '2026-06-27', '06:00:00', '08:00:00', 'terkonfirmasi', '2026-06-24 17:53:18', NULL, NULL, NULL, 0.00),
(3, 2, 1, '2026-06-27', '06:00:00', '08:00:00', 'terkonfirmasi', '2026-06-24 17:56:14', 'SS-2026-00003', NULL, NULL, 0.00),
(4, 2, 2, '2026-06-27', '07:00:00', '09:00:00', 'terkonfirmasi', '2026-06-25 12:05:52', 'SS-2026-00004', NULL, NULL, 0.00),
(5, 2, 4, '2026-06-26', '13:00:00', '15:00:00', 'terkonfirmasi', '2026-06-25 12:07:50', 'SS-2026-00005', NULL, NULL, 0.00),
(6, 2, 2, '2026-07-10', '07:00:00', '10:00:00', 'terkonfirmasi', '2026-07-01 03:58:49', 'SS-2026-00006', NULL, NULL, 0.00),
(7, 2, 2, '2026-07-03', '07:00:00', '09:00:00', 'terkonfirmasi', '2026-07-01 18:22:37', 'SS-2026-00007', NULL, NULL, 0.00),
(8, 3, 1, '2026-07-03', '07:00:00', '10:00:00', 'terkonfirmasi', '2026-07-01 20:33:47', 'SS-2026-00008', NULL, NULL, 0.00),
(9, 3, 1, '2026-07-02', '17:00:00', '18:00:00', 'terkonfirmasi', '2026-07-01 20:49:57', 'SS-2026-00009', NULL, NULL, 0.00),
(10, 3, 2, '2026-07-03', '08:00:00', '10:00:00', '', '2026-07-01 21:47:45', 'SS-2026-00010', NULL, NULL, 0.00),
(11, 3, 2, '2026-07-03', '08:00:00', '10:00:00', 'selesai', '2026-07-01 21:50:25', 'SS-2026-00011', NULL, NULL, 0.00),
(12, 3, 2, '2026-07-03', '08:00:00', '10:00:00', 'selesai', '2026-07-01 22:04:01', 'SS-2026-00012', NULL, NULL, 0.00),
(13, 3, 2, '2026-07-03', '08:00:00', '10:00:00', 'terkonfirmasi', '2026-07-01 22:12:12', 'SS-2026-00013', NULL, NULL, 0.00),
(14, 3, 1, '2026-07-04', '18:00:00', '20:00:00', 'terkonfirmasi', '2026-07-01 22:31:29', 'SS-2026-00014', NULL, NULL, 0.00),
(15, 3, 1, '2026-07-03', '20:00:00', '21:00:00', 'terkonfirmasi', '2026-07-01 22:41:44', 'SS-2026-00015', NULL, NULL, 0.00),
(16, 3, 1, '2026-07-04', '07:00:00', '09:00:00', 'terkonfirmasi', '2026-07-01 22:52:37', 'SS-2026-00016', NULL, NULL, 0.00),
(17, 3, 1, '2026-07-03', '07:00:00', '08:00:00', 'terkonfirmasi', '2026-07-02 05:29:18', 'SS-2026-00017', NULL, NULL, 0.00),
(18, 3, 2, '2026-07-25', '07:00:00', '09:00:00', 'selesai', '2026-07-02 10:08:27', 'SS-2026-00018', NULL, NULL, 0.00),
(19, 4, 1, '2026-07-04', '08:00:00', '10:00:00', '', '2026-07-03 07:18:28', 'SS-2026-00019', NULL, NULL, 0.00),
(20, 4, 1, '0000-00-00', '08:00:00', '09:00:00', '', '2026-07-03 07:53:33', 'SS-2026-00020', NULL, NULL, 0.00),
(21, 4, 1, '2026-08-01', '19:00:00', '20:00:00', '', '2026-07-03 09:22:28', 'SS-2026-00021', 'dana', '', 82500.00),
(22, 4, 1, '2026-07-18', '19:00:00', '20:00:00', '', '2026-07-03 09:29:31', 'SS-2026-00022', 'shopeepay', '', 82500.00),
(23, 4, 1, '2026-07-16', '09:00:00', '10:00:00', '', '2026-07-03 09:45:14', 'SS-2026-00023', 'qris', '', 82500.00),
(24, 4, 1, '2026-07-16', '09:00:00', '10:00:00', '', '2026-07-03 09:48:30', 'SS-2026-00024', 'shopeepay', '', 82500.00),
(25, 4, 1, '2026-07-04', '10:00:00', '11:00:00', 'terkonfirmasi', '2026-07-03 10:00:41', 'SS-2026-00025', 'transfer', '', 82500.00),
(26, 4, 2, '2026-07-04', '09:00:00', '10:00:00', 'tertunda', '2026-07-03 10:02:02', 'SS-2026-00026', 'transfer', 'mandiri', 47500.00),
(27, 4, 2, '2026-07-10', '09:00:00', '11:00:00', 'tertunda', '2026-07-03 10:13:36', 'SS-2026-00027', 'transfer', 'mandiri', 92500.00),
(28, 4, 1, '2026-07-03', '00:00:19', '20:00:00', 'tertunda', '2026-07-03 11:25:26', 'SS-2026-00028', 'transfer', 'mandiri', 82500.00),
(29, 4, 1, '2026-07-06', '00:00:18', '20:00:00', 'tertunda', '2026-07-06 10:45:42', 'SS-2026-00029', 'dana', '', 162500.00);

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
(6, 4, NULL, 1, 'user', 'mau cek lapangan', '2026-07-03 07:17:51', 'belum');

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
(8, 4, 2, '2026-07-03 07:16:20');

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
(1, NULL, 'Lapangan Futsal A ', 'Futsal', 80000.00, 'tersedia', 'Jl. Kaliurang Km 7, Sleman', 'lapangan-futsal.jpg', 'Lapangan futsal premium dengan lantai vinyl.              ', 'Bapak Suharto', '081234567890', 'Jl. Kaliurang Km 7, Sleman', '06.00 - 22.00', 10, 'Vinyl', 'Parkir,Kantin,Toilet', 'https://www.google.com/maps?q=Jl.+Kaliurang+Km+7+Sleman&output=embed', 'https://maps.google.com/?q=Jl.+Kaliurang+Km+7+Sleman', 'pending', 1, NULL, 'aktif'),
(2, NULL, 'Arena Badminton 88', 'Badminton', 45000.00, 'tersedia', 'Jl. Magelang Km 5, Yogyakarta', 'badminton.jpg', 'Lapangan badminton indoor dengan pencahayaan terang dan area bermain nyaman.', 'Bapak Andi', '081298765432', 'Jl. Magelang Km 5, Yogyakarta', '07.00 - 22.00', 4, 'Karpet Badminton', 'Toilet, Kantin, Parkir', 'https://www.google.com/maps?q=Jl.+Magelang+Km+5+Yogyakarta&output=embed', 'https://maps.google.com/?q=Jl.+Magelang+Km+5+Yogyakarta', 'pending', 1, NULL, 'aktif'),
(3, NULL, 'Basket Court Pro', 'Basket', 120000.00, 'penuh', 'Kota Yogyakarta', 'lapangan-basket.jpg', 'Lapangan basket indoor premium dengan lantai kayu berkualitas, ring standar pertandingan dan tribun penonton.', 'Basket Court Pro', '081290907788', 'Kota Yogyakarta', '08.00 - 23.00', 14, 'Kayu Indoor', 'Tribun, Toilet, Kantin', 'https://www.google.com/maps?q=Kota+Yogyakarta&output=embed', 'https://maps.google.com/?q=Kota+Yogyakarta', 'ditolak', 1, NULL, 'aktif'),
(4, NULL, 'GOR Sport Center', 'Futsal', 70000.00, 'tersedia', 'Jl. Ringroad Utara, Sleman', 'lapangan-futsal2.jpg', 'Lapangan futsal indoor dengan rumput sintetis dan fasilitas lengkap.', 'Bapak Budi', '081377778888', 'Jl. Ringroad Utara, Sleman', '06.00 - 23.00', 10, 'Rumput Sintetis', 'Toilet, Mushola, Parkir', 'https://www.google.com/maps?q=Jl.+Ringroad+Utara+Sleman&output=embed', 'https://maps.google.com/?q=Jl.+Ringroad+Utara+Sleman', 'diterima', 1, NULL, 'nonaktif'),
(6, NULL, 'Lapangan Basket A', 'Basket', 90000.00, 'tersedia', 'Jl. Kaliurang Km 9, Sleman', '1783079207_баскетбол.jpg', '                ', NULL, NULL, NULL, '08:00 - 22:00', 15, 'Vinyl', NULL, NULL, NULL, 'diterima', 1, NULL, 'aktif');

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
(19, 4, 29, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-06 10:45:42');

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
(3, NULL, 11, 'keonho', 'keonho@sportspace.com', '081234567899', NULL);

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
(26, 29, '', 162500.00, 'tertunda', '2026-07-06 10:45:42', '');

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
(12, 'martin', 'martin@sportspace.com', '081234567891', '$2y$10$KzZyPvIDVpqjP5Kk/pmEaOhzWhlL/FlHHsNVMuO6.Guxd3.mgGxz2', 'user', 'aktif', '2026-07-05 20:11:24');

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
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
