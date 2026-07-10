-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 10, 2026 at 06:46 AM
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
(2, 4, 3, '2026-07-10', '12:00:00', '22:00:00', 'terkonfirmasi', '2026-07-10 04:42:21', 'SS-2026-00002', 'qris', '', 1202500.00);

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
(1, 4, 'Telaga Futsal 1', 'Futsal', 60000.00, 'tersedia', 'Jl. Perumnas No.89, Condongcatur, Depok, Sleman', '1783658084_WhatsApp Image 2026-07-10 at 10.52.15.jpeg', 'Lapangan ini termasuk kedalam lapangan yang paling ramai dengan banyak pilihan lapangan', 'Kui', '0812456783999', '', '08:00 - 23:00', 0, 'Rumput Sintesis', '', 'https://www.google.com/maps?q=Jl.+Ringroad+Utara%2C+Sleman&output=embed', 'https://maps.google.com/?q=Jl.+Ringroad+Utara%2C+Sleman', 'diterima', 1, '2026-07-10 s/d 2026-07-16', 'aktif'),
(2, 4, 'Tifosi Futsal', 'Futsal', 80000.00, 'tersedia', 'Jl. Sukonandi No.11, Semaki, Umbuharjo, Kota Yogyakrta', '1783657582_WhatsApp Image 2026-07-10 at 10.52.15 (1).jpeg', '                ', 'Kui', '0812456783999', '', '07.00-00.00', 12, 'Vinyl', 'Toilet', 'https://www.google.com/maps?q=Jl.+Sukonandi+No.11%2C+Semaki%2C+Umbuharjo%2C+Kota+Yogyakrta&output=embed', 'https://maps.google.com/?q=Jl.+Sukonandi+No.11%2C+Semaki%2C+Umbuharjo%2C+Kota+Yogyakrta', 'diterima', 1, NULL, 'aktif'),
(3, 4, 'Town Hoops 3x3 Basketball Court', 'Basket', 120000.00, 'tersedia', 'Miliaran III No.400, Muja Muju, Umbulharjo, Kota Yogyakarta', '1783658301_WhatsApp Image 2026-07-10 at 10.48.55.jpeg', 'Lapangan basket dengan fasilitas terlengkap yang ada di yogyakarta.', 'Kui', '0812456783999', '', '08:00 - 22:00', 0, 'Vinyl', 'Kantin, Musholah', 'https://www.google.com/maps?q=Miliaran+III+No.400%2C+Muja+Muju%2C+Umbulharjo%2C+Kota+Yogyakarta&output=embed', 'https://maps.google.com/?q=Miliaran+III+No.400%2C+Muja+Muju%2C+Umbulharjo%2C+Kota+Yogyakarta', 'diterima', 1, NULL, 'aktif'),
(4, 4, 'GOR Jambon Badminton Center', 'Badminton', 120000.00, 'tersedia', 'Jambon, Trihanggo, Gamping, Sleman', '1783658463_WhatsApp Image 2026-07-10 at 10.49.35.jpeg', 'Lapangan Badminton yang sangat digemari kaum pecinta badminton', 'Kui', '0812456783999', '', '08:00 - 22:00', 0, 'Karet', 'Shuttlecock, Penyewaan Raket', 'https://www.google.com/maps?q=Jambon%2C+Trihanggo%2C+Gamping%2C+Sleman&output=embed', 'https://maps.google.com/?q=Jambon%2C+Trihanggo%2C+Gamping%2C+Sleman', 'diterima', 1, NULL, 'aktif');

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
(1, 4, 1, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-10 04:29:34'),
(2, 4, 1, 'Booking Dibatalkan', 'Booking telah berhasil dibatalkan.', 'belum', '2026-07-10 04:30:49'),
(3, 4, 2, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-10 04:42:21');

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
(2, 2, '', 1202500.00, 'tertunda', '2026-07-10 04:42:21', '');

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
(1, 4, 3, 2, 'booking_diterima', 'Booking Diterima', 'Booking Anda telah diterima oleh owner.', 'dibaca', '2026-07-10 04:42:32');

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
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fields`
--
ALTER TABLE `fields`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `owners`
--
ALTER TABLE `owners`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `user_notifications`
--
ALTER TABLE `user_notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
