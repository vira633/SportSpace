-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 02 Jul 2026 pada 07.37
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

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
-- Struktur dari tabel `booking`
--

CREATE TABLE `booking` (
  `booking_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `status` enum('tertunda','terkonfirmasi','dibatalkan','selesai') NOT NULL DEFAULT 'tertunda',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `booking_code` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `booking`
--

INSERT INTO `booking` (`booking_id`, `user_id`, `field_id`, `tanggal`, `jam_mulai`, `jam_selesai`, `status`, `created_at`, `booking_code`) VALUES
(1, 2, 1, '2026-06-26', '06:00:00', '08:00:00', 'dibatalkan', '2026-06-24 17:51:56', 'SS-2026-00001'),
(2, 2, 1, '2026-06-27', '06:00:00', '08:00:00', 'terkonfirmasi', '2026-06-24 17:53:18', 'SS-2026-00002'),
(3, 2, 1, '2026-06-27', '06:00:00', '08:00:00', 'terkonfirmasi', '2026-06-24 17:56:14', 'SS-2026-00003'),
(4, 2, 1, '2026-06-26', '19:00:00', '20:00:00', 'terkonfirmasi', '2026-06-25 17:10:00', 'SS-2026-00004'),
(5, 2, 1, '2026-06-29', '19:00:00', '21:00:00', 'terkonfirmasi', '2026-06-25 17:10:53', 'SS-2026-00005'),
(6, 2, 1, '2026-06-30', '10:00:00', '11:00:00', 'terkonfirmasi', '2026-06-28 10:24:48', 'SS-2026-00006'),
(7, 2, 1, '2026-06-28', '12:00:00', '13:00:00', 'dibatalkan', '2026-06-28 10:55:24', 'SS-2026-00007'),
(8, 2, 1, '2026-06-28', '14:00:00', '15:00:00', 'tertunda', '2026-06-28 10:57:25', 'SS-2026-00008'),
(9, 2, 1, '2026-06-28', '14:00:00', '15:00:00', 'terkonfirmasi', '2026-06-28 10:57:37', 'SS-2026-00009'),
(11, 2, 4, '2026-07-08', '19:00:00', '21:00:00', 'selesai', '2026-07-01 03:59:26', 'SS-2026-00011'),
(12, 2, 4, '2026-07-08', '19:00:00', '21:00:00', 'dibatalkan', '2026-07-01 03:59:32', 'SS-2026-00012'),
(13, 2, 4, '2026-07-02', '19:00:00', '21:00:00', 'terkonfirmasi', '2026-07-01 10:43:19', 'SS-2026-00013'),
(14, 2, 1, '2026-07-09', '16:00:00', '18:00:00', 'tertunda', '2026-07-01 10:43:45', 'SS-2026-00014'),
(15, 2, 1, '2026-07-23', '20:00:00', '22:00:00', 'terkonfirmasi', '2026-07-01 10:45:45', 'SS-2026-00015'),
(16, 2, 1, '2026-07-23', '20:00:00', '22:00:00', 'tertunda', '2026-07-01 10:45:55', 'SS-2026-00016'),
(17, 2, 1, '2026-07-23', '20:00:00', '22:00:00', 'terkonfirmasi', '2026-07-01 10:46:01', 'SS-2026-00017'),
(18, 2, 4, '2026-07-01', '12:00:00', '14:00:00', 'terkonfirmasi', '2026-07-01 11:01:29', 'SS-2026-00018');

-- --------------------------------------------------------

--
-- Struktur dari tabel `fields`
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
  `verifikasi` enum('pending','diterima','ditolak') DEFAULT 'pending',
  `durasi_slot` int(11) DEFAULT 1,
  `hari_libur` text DEFAULT NULL,
  `aktif` enum('aktif','nonaktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `fields`
--

INSERT INTO `fields` (`field_id`, `owner_id`, `nama_lapangan`, `jenis`, `harga`, `status`, `lokasi`, `gambar`, `deskripsi`, `owner_name`, `owner_phone`, `owner_address`, `jam_operasional`, `kapasitas`, `jenis_lantai`, `fasilitas`, `maps_link`, `google_maps_url`, `verifikasi`, `durasi_slot`, `hari_libur`, `aktif`) VALUES
(1, NULL, 'GOR Maju Jaya', 'Futsal', 50000.00, 'tersedia', 'Jl. Kaliurang Km 7, Sleman', '1782877908_images.png', 'Lapangan futsal premium dengan lantai vinyl.                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           ', 'Bapak Suharto ', '081234567890', '', '08:00 - 22:00', 10, 'Vinyl', 'Parkir,Kantin,Toilet', 'https://www.google.com/maps?q=Jl.+Kaliurang+Km+7+Sleman&output=embed', 'https://maps.google.com/?q=Jl.+Kaliurang+Km+7+Sleman', 'diterima', 1, '2026-07-03 s/d 2026-07-03', 'aktif'),
(2, NULL, 'Arena Badminton 88', 'Badminton', 45000.00, 'tersedia', 'Jl. Magelang Km 5, Yogyakarta', 'badminton.jpg', 'Lapangan badminton indoor dengan pencahayaan terang dan area bermain nyaman.', 'Bapak Andi', '081298765432', 'Jl. Magelang Km 5, Yogyakarta', '07.00 - 22.00', 4, 'Karpet Badminton', 'Toilet, Kantin, Parkir', 'https://www.google.com/maps?q=Jl.+Magelang+Km+5+Yogyakarta&output=embed', 'https://maps.google.com/?q=Jl.+Magelang+Km+5+Yogyakarta', 'ditolak', 1, NULL, 'nonaktif'),
(3, NULL, 'Basket Court Pro', 'Basket', 120000.00, 'penuh', 'Kota Yogyakarta', 'lapangan-basket.jpg', 'Lapangan basket indoor premium dengan lantai kayu berkualitas, ring standar pertandingan dan tribun penonton.', 'Basket Court Pro', '081290907788', 'Kota Yogyakarta', '08:00 - 23:00', 14, 'Kayu Indoor', 'Tribun, Toilet, Kantin', 'https://www.google.com/maps?q=Kota+Yogyakarta&output=embed', 'https://maps.google.com/?q=Kota+Yogyakarta', 'pending', 1, '2026-07-02 s/d 2026-07-02', 'nonaktif'),
(4, NULL, 'GOR Sport Center ', 'Futsal', 70000.00, 'tersedia', 'Jl. Ringroad Utara, Sleman', '1782750417_38217690_8599310.png', 'Lapangan futsal indoor dengan rumput sintetis dan fasilitas lengkap.', 'Bapak Budi', '081377778888', 'Jl. Ringroad Utara, Sleman', '06.00 - 23.00', 10, 'Rumput Sintetis', 'Toilet, Mushola, Parkir', 'https://www.google.com/maps?q=Jl.+Ringroad+Utara+Sleman&output=embed', 'https://maps.google.com/?q=Jl.+Ringroad+Utara+Sleman', 'pending', 1, NULL, 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `owners`
--

CREATE TABLE `owners` (
  `owner_id` int(11) NOT NULL,
  `field_id` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `owners`
--

INSERT INTO `owners` (`owner_id`, `field_id`, `nama`, `telepon`, `alamat`, `email`, `password`, `created_at`) VALUES
(1, 1, 'Bapak Suharto ', '081234567890', '', 'suharto@gmail.com', '12345678', '2026-06-30 18:10:06'),
(2, 3, 'Basket Court Pro', '0812-9090-7788', 'Kota Yogyakarta', 'owner@example.com', '24681012', '2026-06-30 15:23:43'),
(3, 2, 'Bapak Andi', '081298765432', 'Jl. Magelang Km 5, Yogyakarta', 'andi@gmail.com', '135791113', '2026-06-30 15:23:33'),
(4, 4, 'Bapak Budi', '081377778888', 'Jl. Ringroad Utara, Sleman', 'budi@gmail.com', '123456810', '2026-06-30 15:24:10');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `booking_id` int(11) NOT NULL,
  `metode` enum('transfer','ewallet','cash') NOT NULL,
  `total` decimal(10,2) NOT NULL,
  `status` enum('tertunda','diverifikasi','ditolak') NOT NULL DEFAULT 'tertunda',
  `tanggal_bayar` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `payment`
--

INSERT INTO `payment` (`payment_id`, `booking_id`, `metode`, `total`, `status`, `tanggal_bayar`) VALUES
(1, 1, '', 162500.00, 'diverifikasi', '2026-06-24 17:51:56'),
(2, 2, '', 162500.00, 'tertunda', '2026-06-24 17:53:18'),
(3, 3, '', 162500.00, 'diverifikasi', '2026-06-24 17:56:14'),
(4, 13, 'transfer', 142500.00, 'tertunda', '2026-07-01 10:43:19'),
(5, 15, 'transfer', 102500.00, 'tertunda', '2026-07-01 10:45:45'),
(6, 17, 'transfer', 102500.00, 'tertunda', '2026-07-01 10:46:01'),
(7, 18, 'transfer', 142500.00, 'tertunda', '2026-07-01 11:01:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`user_id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(2, 'Admin SportSpace', 'admin@sportspace.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-06-13 09:28:16'),
(3, 'Siti Maysaroh', 'maysaarou@students.amikom.ac.id', '$2y$10$I7KpPrTCkbuka5r/7gWk8ub2SoGQBKZl8Tad6Bh9MSN914ffOUlJ.', 'user', '2026-06-23 18:49:08'),
(4, 'Budi Santoso', 'budi@gmail.com', '123456', 'user', '2026-06-25 13:32:52'),
(5, 'Riska Aprilia', 'riska19@gmail.com', '$2y$10$Ddd2pK7P9JkUd28zCCtXr.A6PXEiO/x1KRF0j27Zmy5lfAEs6Uggy', 'user', '2026-06-25 17:06:46'),
(6, 'Riska Aprilia', 'riska@gmail.com', '$2y$10$hokyE7SRFd3BzPWAN2qmEO5JhjdQALl3AEx9jxLW27Abxv.PAlJLa', 'user', '2026-07-01 10:49:06');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD PRIMARY KEY (`booking_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `field_id` (`field_id`);

--
-- Indeks untuk tabel `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`field_id`);

--
-- Indeks untuk tabel `owners`
--
ALTER TABLE `owners`
  ADD PRIMARY KEY (`owner_id`),
  ADD KEY `field_id` (`field_id`);

--
-- Indeks untuk tabel `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `booking_id` (`booking_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `booking`
--
ALTER TABLE `booking`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `fields`
--
ALTER TABLE `fields`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT untuk tabel `owners`
--
ALTER TABLE `owners`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`);

--
-- Ketidakleluasaan untuk tabel `owners`
--
ALTER TABLE `owners`
  ADD CONSTRAINT `owners_ibfk_1` FOREIGN KEY (`field_id`) REFERENCES `fields` (`field_id`);

--
-- Ketidakleluasaan untuk tabel `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`booking_id`) REFERENCES `booking` (`booking_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
