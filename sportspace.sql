-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Waktu pembuatan: 02 Jul 2026 pada 18.32
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
(1, 2, 1, '2026-06-26', '06:00:00', '08:00:00', 'terkonfirmasi', '2026-06-24 17:51:56', NULL),
(2, 2, 1, '2026-06-27', '06:00:00', '08:00:00', 'terkonfirmasi', '2026-06-24 17:53:18', NULL),
(3, 2, 1, '2026-06-27', '06:00:00', '08:00:00', 'terkonfirmasi', '2026-06-24 17:56:14', 'SS-2026-00003'),
(4, 2, 2, '2026-06-27', '07:00:00', '09:00:00', 'terkonfirmasi', '2026-06-25 12:05:52', 'SS-2026-00004'),
(5, 2, 4, '2026-06-26', '13:00:00', '15:00:00', 'terkonfirmasi', '2026-06-25 12:07:50', 'SS-2026-00005'),
(6, 2, 2, '2026-07-10', '07:00:00', '10:00:00', 'terkonfirmasi', '2026-07-01 03:58:49', 'SS-2026-00006'),
(7, 2, 2, '2026-07-03', '07:00:00', '09:00:00', 'terkonfirmasi', '2026-07-01 18:22:37', 'SS-2026-00007'),
(8, 3, 1, '2026-07-03', '07:00:00', '10:00:00', 'terkonfirmasi', '2026-07-01 20:33:47', 'SS-2026-00008'),
(9, 3, 1, '2026-07-02', '17:00:00', '18:00:00', 'terkonfirmasi', '2026-07-01 20:49:57', 'SS-2026-00009'),
(10, 3, 2, '2026-07-03', '08:00:00', '10:00:00', 'tertunda', '2026-07-01 21:47:45', 'SS-2026-00010'),
(11, 3, 2, '2026-07-03', '08:00:00', '10:00:00', 'selesai', '2026-07-01 21:50:25', 'SS-2026-00011'),
(12, 3, 2, '2026-07-03', '08:00:00', '10:00:00', 'selesai', '2026-07-01 22:04:01', 'SS-2026-00012'),
(13, 3, 2, '2026-07-03', '08:00:00', '10:00:00', 'terkonfirmasi', '2026-07-01 22:12:12', 'SS-2026-00013'),
(14, 3, 1, '2026-07-04', '18:00:00', '20:00:00', 'terkonfirmasi', '2026-07-01 22:31:29', 'SS-2026-00014'),
(15, 3, 1, '2026-07-03', '20:00:00', '21:00:00', 'tertunda', '2026-07-01 22:41:44', 'SS-2026-00015'),
(16, 3, 1, '2026-07-04', '07:00:00', '09:00:00', 'tertunda', '2026-07-01 22:52:37', 'SS-2026-00016'),
(17, 3, 1, '2026-07-03', '07:00:00', '08:00:00', 'tertunda', '2026-07-02 05:29:18', 'SS-2026-00017'),
(18, 3, 2, '2026-07-25', '07:00:00', '09:00:00', 'selesai', '2026-07-02 10:08:27', 'SS-2026-00018');

-- --------------------------------------------------------

--
-- Struktur dari tabel `chat`
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
-- Dumping data untuk tabel `chat`
--

INSERT INTO `chat` (`chat_id`, `user_id`, `booking_id`, `field_id`, `sender`, `pesan`, `waktu`, `status`) VALUES
(1, 3, NULL, 1, 'user', 'haii', '2026-07-01 20:11:13', 'belum'),
(2, 3, NULL, 1, 'user', 'halo adminn', '2026-07-01 20:15:00', 'belum'),
(3, 3, NULL, 1, 'user', 'tesss', '2026-07-01 20:15:52', 'belum'),
(4, 3, NULL, 1, 'user', 'haii', '2026-07-01 20:16:00', 'belum');

-- --------------------------------------------------------

--
-- Struktur dari tabel `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `favorites`
--

INSERT INTO `favorites` (`favorite_id`, `user_id`, `field_id`, `created_at`) VALUES
(4, 3, 1, '2026-07-01 19:20:55'),
(6, 3, 2, '2026-07-01 19:31:09');

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
  `verifikasi` enum('pending','diterima','ditolak') NOT NULL DEFAULT 'pending',
  `durasi_slot` int(11) NOT NULL DEFAULT 1,
  `hari_libur` text DEFAULT NULL,
  `aktif` enum('aktif','nonaktif') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `fields`
--

INSERT INTO `fields` (`field_id`, `owner_id`, `nama_lapangan`, `jenis`, `harga`, `status`, `lokasi`, `gambar`, `deskripsi`, `owner_name`, `owner_phone`, `owner_address`, `jam_operasional`, `kapasitas`, `jenis_lantai`, `fasilitas`, `maps_link`, `google_maps_url`, `verifikasi`, `durasi_slot`, `hari_libur`, `aktif`) VALUES
(1, NULL, 'Lapangan Futsal A ', 'Futsal', 80000.00, 'tersedia', 'Jl. Kaliurang Km 7, Sleman', '1783003824_images.png', 'Lapangan futsal premium dengan lantai vinyl.', 'Bapak Suharto', '081234567890', 'Jl. Kaliurang Km 7, Sleman', '06.00 - 22.00', 10, 'Vinyl', 'Parkir, Toilet, Kantin', 'https://www.google.com/maps?q=Jl.+Kaliurang+Km+7+Sleman&output=embed', 'https://maps.google.com/?q=Jl.+Kaliurang+Km+7+Sleman', 'diterima', 1, NULL, 'aktif'),
(2, NULL, 'Arena Badminton 88', 'Badminton', 45000.00, 'tersedia', 'Jl. Magelang Km 5, Yogyakarta', 'badminton.jpg', 'Lapangan badminton indoor dengan pencahayaan terang dan area bermain nyaman.', 'Bapak Andi', '081298765432', 'Jl. Magelang Km 5, Yogyakarta', '07.00 - 22.00', 4, 'Karpet Badminton', 'Toilet, Kantin, Parkir', 'https://www.google.com/maps?q=Jl.+Magelang+Km+5+Yogyakarta&output=embed', 'https://maps.google.com/?q=Jl.+Magelang+Km+5+Yogyakarta', 'pending', 1, NULL, 'aktif'),
(3, NULL, 'Basket Court Pro', 'Basket', 120000.00, 'penuh', 'Kota Yogyakarta', 'lapangan-basket.jpg', 'Lapangan basket indoor premium dengan lantai kayu berkualitas, ring standar pertandingan dan tribun penonton.', 'Basket Court Pro', '081290907788', 'Kota Yogyakarta', '08.00 - 23.00', 14, 'Kayu Indoor', 'Tribun, Toilet, Kantin', 'https://www.google.com/maps?q=Kota+Yogyakarta&output=embed', 'https://maps.google.com/?q=Kota+Yogyakarta', 'ditolak', 1, NULL, 'aktif'),
(4, NULL, 'GOR Sport Center', 'Futsal', 70000.00, 'tersedia', 'Jl. Ringroad Utara, Sleman', 'lapangan-futsal2.jpg', 'Lapangan futsal indoor dengan rumput sintetis dan fasilitas lengkap.', 'Bapak Budi', '081377778888', 'Jl. Ringroad Utara, Sleman', '06.00 - 23.00', 10, 'Rumput Sintetis', 'Toilet, Mushola, Parkir', 'https://www.google.com/maps?q=Jl.+Ringroad+Utara+Sleman&output=embed', 'https://maps.google.com/?q=Jl.+Ringroad+Utara+Sleman', 'diterima', 1, NULL, 'aktif'),
(6, NULL, 'Lapangan Basket A', 'Basket', 90000.00, 'tersedia', 'Jl. Kaliurang Km 9, Sleman', '1783004273_38217690_8599310.png', '                ', NULL, NULL, NULL, '08:00 - 22:00', 15, 'Vinyl', NULL, NULL, NULL, 'ditolak', 1, NULL, 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notifications`
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
-- Dumping data untuk tabel `notifications`
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
(11, 3, 18, 'Konfirmasi Pembayaran Diterima', 'Konfirmasi pembayaran Anda telah diterima dan sedang menunggu verifikasi admin.', 'belum', '2026-07-02 10:08:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `owners`
--

CREATE TABLE `owners` (
  `owner_id` int(11) NOT NULL,
  `field_id` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `owners`
--

INSERT INTO `owners` (`owner_id`, `field_id`, `nama`, `email`, `telepon`, `alamat`) VALUES
(1, 1, 'Bapak Suharto', '', '081234567890', 'Jl. Kaliurang Km 7, Sleman'),
(2, 3, 'Basket Court Pro', '', '0812-9090-7788', 'Kota Yogyakarta'),
(3, 2, 'Bapak Andi', '', '081298765432', 'Jl. Magelang Km 5, Yogyakarta'),
(4, 4, 'Bapak Budi', '', '081377778888', 'Jl. Ringroad Utara, Sleman');

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
(1, 1, '', 162500.00, 'tertunda', '2026-06-24 17:51:56'),
(2, 2, '', 162500.00, 'tertunda', '2026-06-24 17:53:18'),
(3, 3, '', 162500.00, 'tertunda', '2026-06-24 17:56:14'),
(4, 4, '', 92500.00, 'tertunda', '2026-06-25 12:05:52'),
(5, 5, '', 142500.00, 'tertunda', '2026-06-25 12:07:50'),
(6, 6, '', 137500.00, 'tertunda', '2026-07-01 03:58:49'),
(7, 7, '', 92500.00, 'tertunda', '2026-07-01 18:22:37'),
(8, 8, '', 242500.00, 'tertunda', '2026-07-01 20:33:47'),
(9, 9, 'cash', 82500.00, 'tertunda', '2026-07-01 20:49:57'),
(10, 10, '', 92500.00, 'tertunda', '2026-07-01 21:47:46'),
(11, 11, '', 92500.00, 'tertunda', '2026-07-01 21:50:25'),
(12, 12, '', 92500.00, 'tertunda', '2026-07-01 22:04:01'),
(13, 13, '', 92500.00, 'tertunda', '2026-07-01 22:12:12'),
(14, 14, 'cash', 162500.00, 'tertunda', '2026-07-01 22:31:29'),
(15, 15, '', 82500.00, 'tertunda', '2026-07-01 22:41:44'),
(16, 16, '', 162500.00, 'tertunda', '2026-07-01 22:52:37'),
(17, 17, '', 82500.00, 'tertunda', '2026-07-02 05:29:18'),
(18, 18, '', 92500.00, 'tertunda', '2026-07-02 10:08:27');

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
(4, 'Maysa', 'maysaa@students.amikom.ac.id', '$2y$10$Iunqp.u35GEGZccDd7WCBuvODLFpfWX0rFtPjv7xBM7Pu6hcB3FL6', 'user', '2026-07-02 10:26:25');

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
-- Indeks untuk tabel `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`chat_id`);

--
-- Indeks untuk tabel `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`);

--
-- Indeks untuk tabel `fields`
--
ALTER TABLE `fields`
  ADD PRIMARY KEY (`field_id`);

--
-- Indeks untuk tabel `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notification_id`);

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
-- AUTO_INCREMENT untuk tabel `chat`
--
ALTER TABLE `chat`
  MODIFY `chat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `fields`
--
ALTER TABLE `fields`
  MODIFY `field_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notification_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `owners`
--
ALTER TABLE `owners`
  MODIFY `owner_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

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
