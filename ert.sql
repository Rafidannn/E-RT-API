-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Mar 2026 pada 14.24
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ert`
--
CREATE DATABASE IF NOT EXISTS `ert` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `ert`;

-- --------------------------------------------------------

--
-- Struktur dari tabel `iuran`
--

CREATE TABLE `iuran` (
  `id_iuran` int(11) NOT NULL,
  `id_keluarga` int(11) DEFAULT NULL,
  `id_user` int(11) NOT NULL,
  `jenis_iuran` varchar(50) DEFAULT NULL,
  `bulan` varchar(20) NOT NULL,
  `tahun` year(4) DEFAULT NULL,
  `nominal` int(11) NOT NULL,
  `status` enum('lunas','belum','pending','ditolak') DEFAULT 'belum',
  `metode_pembayaran` varchar(30) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `bukti_transfer` varchar(255) DEFAULT NULL,
  `transaction_id` varchar(50) DEFAULT NULL,
  `tanggal_bayar` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `iuran`
--

INSERT INTO `iuran` (`id_iuran`, `id_keluarga`, `id_user`, `jenis_iuran`, `bulan`, `tahun`, `nominal`, `status`, `metode_pembayaran`, `catatan`, `bukti_transfer`, `transaction_id`, `tanggal_bayar`, `created_at`) VALUES
(1, 1, 1, 'Iuran Keamanan', 'Januari', '2024', 50000, 'lunas', 'Tunai', 'Bayar tepat waktu', NULL, NULL, '2024-01-05', '2026-03-10 17:28:47'),
(2, 2, 1, 'Iuran Kebersihan', 'Januari', '2024', 30000, 'lunas', 'Transfer Bank', 'Pembayaran via Mobile Banking', NULL, NULL, '2024-01-07', '2026-03-10 17:28:47'),
(3, 3, 1, 'Iuran Kematian', 'Februari', '2024', 20000, 'belum', NULL, NULL, NULL, NULL, NULL, '2026-03-10 17:28:47'),
(4, 4, 1, 'Iuran Kas RT', 'Februari', '2024', 100000, 'lunas', 'Tunai', 'Titip ke bendahara', NULL, NULL, '2024-02-10', '2026-03-10 17:28:47'),
(5, 1, 1, 'Iuran Kebersihan', 'Februari', '2024', 30000, 'lunas', 'Tunai', 'Lunas', NULL, NULL, '2024-02-12', '2026-03-10 17:28:47'),
(6, 5, 1, 'Iuran Keamanan', 'Maret', '2024', 50000, 'belum', NULL, 'Akan dibayar minggu depan', NULL, NULL, NULL, '2026-03-10 17:28:47'),
(7, 2, 1, 'Iuran Kas RT', 'Maret', '2024', 100000, 'lunas', 'Transfer Bank', 'Transfer ke rekening RT', NULL, NULL, '2024-03-01', '2026-03-10 17:28:47'),
(8, 3, 1, 'Iuran Keamanan', 'Maret', '2024', 50000, 'lunas', 'Tunai', 'Diterima oleh petugas', NULL, NULL, '2024-03-05', '2026-03-10 17:28:47'),
(9, 4, 1, 'Iuran Kebersihan', 'April', '2024', 30000, 'belum', NULL, NULL, NULL, NULL, NULL, '2026-03-10 17:28:47'),
(10, 5, 1, 'Iuran Kas RT', 'April', '2024', 100000, 'lunas', 'Tunai', 'Bayar langsung', NULL, NULL, '2024-04-02', '2026-03-10 17:28:47'),
(11, 5, 1, 'Iuran Kebersihan', 'Maret', '2026', 10, 'lunas', 'Transfer Bank', 'tes', NULL, NULL, '2026-03-11', '2026-03-11 01:13:58'),
(19, 3, 1, 'Iuran Kas RT', 'Februari', '2026', 10, 'lunas', 'Transfer Bank', 'ffefe', NULL, NULL, '2026-03-11', '2026-03-11 01:31:45'),
(24, 4, 1, 'Iuran Kebersihan', 'Februari', '2026', 10000, 'lunas', 'Transfer Bank', 'tess', NULL, NULL, '2026-03-11', '2026-03-11 01:40:42'),
(25, 3, 1, 'Iuran Kebersihan', 'Maret', '2026', 100000, 'lunas', 'Transfer Bank', 'tess', NULL, NULL, '2026-03-11', '2026-03-11 01:44:59'),
(26, 3, 1, 'Iuran Kebersihan', 'Juni', '2026', 30000, 'lunas', 'Transfer Bank', 'tes', NULL, NULL, '2026-03-11', '2026-03-11 01:45:37'),
(27, 7, 1, 'Iuran Kas RT', 'Desember', '2026', 20000, 'lunas', 'Tunai', 'gasken', NULL, NULL, '2026-03-11', '2026-03-11 02:06:55'),
(28, 2, 1, 'Iuran Kebersihan', 'April', '2026', 10000, 'lunas', 'Transfer Bank', 'aoa aja', NULL, NULL, '2026-03-11', '2026-03-11 02:07:46'),
(29, 3, 1, 'Iuran Keamanan', 'Mei', '2026', 50000, 'pending', 'Transfer Bank BCA', '', '', '#TRX-20260319215639824', '2026-03-19', '2026-03-19 20:56:39'),
(30, 1, 1, 'Iuran Sampah/Kebersihan', 'April', '2026', 50000, 'pending', 'Transfer Bank BCA', '', '', '#TRX-20260319215704408', '2026-03-19', '2026-03-19 20:57:04'),
(31, 4, 1, 'Iuran Kas RT', 'Mei', '2026', 100000, 'pending', 'Transfer Bank BCA', '', '', '#TRX-20260319215728550', '2026-03-19', '2026-03-19 20:57:28'),
(32, 1, 1, 'Iuran Keamanan', 'Mei', '2026', 50000, 'pending', 'Transfer Bank BCA', '', '', '#TRX-20260319215802342', '2026-03-19', '2026-03-19 20:58:02'),
(33, 5, 1, 'Iuran Kas RT', 'Mei', '2026', 50000, 'pending', 'Transfer Bank BCA', '', '', '#TRX-20260319215838776', '2026-03-19', '2026-03-19 20:58:38'),
(34, 7, 1, 'Iuran Keamanan', 'Mei', '2026', 50000, 'pending', 'Transfer Bank BCA', '', '', '#TRX-20260319215901160', '2026-03-19', '2026-03-19 20:59:01'),
(35, 5, 1, 'Iuran Kas RT', 'Mei', '2026', 50000, 'pending', 'Transfer Bank BCA', '', '', '#TRX-20260319220105164', '2026-03-19', '2026-03-19 21:01:05'),
(36, 2, 1, 'Iuran Keamanan', 'Februari', '2026', 20000, 'pending', 'Transfer Bank BCA', '', '', '#TRX-20260319220329375', '2026-03-19', '2026-03-19 21:03:29'),
(37, 1, 1, 'Iuran Keamanan', 'April', '2026', 50000, 'pending', 'Transfer Bank BCA', '', '', '#TRX-20260319220345706', '2026-03-19', '2026-03-19 21:03:45'),
(38, 1, 1, 'Iuran Keamanan', 'April', '2026', 50000, 'pending', 'Transfer Bank BCA', '', '', '#TRX-20260319220731799', '2026-03-19', '2026-03-19 21:07:31'),
(39, 2, 1, 'Iuran Keamanan', 'April', '2026', 50000, 'pending', 'Transfer Bank BCA', '', 'uploads/1773978095_IMG_20241218_060737.jpg', '#TRX-20260320044135186', '2026-03-20', '2026-03-20 03:41:35'),
(40, 1, 1, 'Iuran Keamanan', 'April', '2026', 50000, 'pending', 'Transfer Bank BCA', 'tes', 'uploads/1773978165_IMG_20241218_060737.jpg', '#TRX-20260320044245408', '2026-03-20', '2026-03-20 03:42:45'),
(41, 1, 1, 'Iuran Keamanan', 'Maret', '2026', 50000, 'pending', 'Transfer Bank BCA', 'tes', 'uploads/1773987609_095ea1bf-677c-4563-b89a-94a060358f83-1_all_935.jpg', '#TRX-20260320072009613', '2026-03-20', '2026-03-20 06:20:09'),
(49, 1, 5, 'Iuran Sampah/Kebersihan', 'Maret', '2026', 20000, 'pending', 'Transfer Bank BCA', 'Pembayaran Iuran Sampah/Kebersihan bulan Maret', 'uploads/1774511006_scaled_1000195115.jpg', '#TRX-20260326084326601', '2026-03-26', '2026-03-26 07:43:26'),
(50, 1, 5, 'Iuran Kematian', 'Maret', '2026', 50000, 'pending', 'Transfer Bank Mandiri', 'Pembayaran Iuran Kematian bulan Maret', 'uploads/1774511260_scaled_1000195115.jpg', '#TRX-20260326084740364', '2026-03-26', '2026-03-26 07:47:40'),
(51, 1, 5, 'Iuran Sosial', 'Maret', '2026', 75056, 'pending', 'Tunai', 'Pembayaran Iuran Sosial bulan Maret', 'uploads/1774511545_scaled_1000195115.jpg', '#TRX-20260326085225497', '2026-03-26', '2026-03-26 07:52:25'),
(52, 1, 5, 'Iuran Kas RT', 'Maret', '2026', 50001, 'pending', 'Transfer Bank BCA', 'Pembayaran Iuran Kas RT bulan Maret', 'uploads/1774511606_scaled_1000192034.jpg', '#TRX-20260326085326697', '2026-03-26', '2026-03-26 07:53:26'),
(53, 1, 5, 'Iuran Keamanan', 'Maret', '2026', 50002, 'pending', 'Transfer Bank BCA', 'Pembayaran Iuran Keamanan bulan Maret', 'uploads/1774511870_scaled_1000194698.jpg', '#TRX-20260326085750737', '2026-03-26', '2026-03-26 07:57:50'),
(54, 1, 5, 'Iuran Sampah/Kebersihan', 'Maret', '2026', 51000, 'pending', 'Transfer Bank BCA', 'Pembayaran Iuran Sampah/Kebersihan bulan Maret', 'uploads/1774511931_scaled_1000193042.jpg', '#TRX-20260326085851247', '2026-03-26', '2026-03-26 07:58:51'),
(55, 1, 5, 'Iuran Kas RT', 'Maret', '2026', 59000, 'pending', 'Tunai', 'Pembayaran Iuran Kas RT bulan Maret', 'uploads/1774512133_scaled_1000195115.jpg', '#TRX-20260326090213787', '2026-03-26', '2026-03-26 08:02:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `jumantik`
--

CREATE TABLE `jumantik` (
  `id_jumantik` int(11) NOT NULL,
  `id_keluarga` int(11) DEFAULT NULL,
  `status_jentik` enum('ada','tidak') NOT NULL,
  `tanggal` date NOT NULL,
  `petugas` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `wadah` varchar(100) DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `foto` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `jumantik`
--

INSERT INTO `jumantik` (`id_jumantik`, `id_keluarga`, `status_jentik`, `tanggal`, `petugas`, `created_at`, `wadah`, `catatan`, `foto`) VALUES
(5, 2, 'tidak', '2026-03-10', 3, '2026-03-10 16:24:27', NULL, NULL, NULL),
(6, 3, 'tidak', '2026-03-10', 2, '2026-03-10 16:25:39', NULL, NULL, NULL),
(7, 6, 'ada', '2026-03-10', 1, '2026-03-10 16:25:54', NULL, NULL, NULL),
(8, 1, 'ada', '2026-03-21', 2, '2026-03-11 02:35:35', NULL, NULL, NULL),
(9, 4, 'tidak', '2026-03-20', 1, '2026-03-20 04:28:20', NULL, NULL, NULL),
(10, 7, 'tidak', '2026-03-20', 1, '2026-03-20 06:21:55', NULL, NULL, NULL),
(11, 3, 'ada', '2026-03-20', 3, '2026-03-20 09:53:02', NULL, NULL, NULL),
(12, 6, 'ada', '2026-03-20', 3, '2026-03-20 09:53:49', NULL, NULL, NULL),
(13, 5, 'ada', '2026-03-20', 1, '2026-03-20 10:03:10', NULL, NULL, NULL),
(14, 1, 'tidak', '2026-03-20', 1, '2026-03-20 10:29:34', 'Ember Ajaib', 'Tes Local', ''),
(15, 1, 'tidak', '2026-03-20', 1, '2026-03-20 10:29:34', 'Ember Ajaib', 'Tes Local', ''),
(16, 4, 'tidak', '2026-03-20', 1, '2026-03-20 12:11:01', 'Lainnya', 'tess', 'uploads/jumantik_1774008661_4048.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keluarga`
--

CREATE TABLE `keluarga` (
  `id_keluarga` int(11) NOT NULL,
  `no_kk` varchar(20) DEFAULT NULL,
  `alamat_lengkap` text DEFAULT NULL,
  `rt_rw` varchar(10) DEFAULT NULL,
  `penghasilan_bulanan` int(11) DEFAULT 0,
  `status_ekonomi` enum('prasejahtera','madya','mandiri') DEFAULT 'madya',
  `sumber_air` enum('pdam','sumur','lainnya') DEFAULT NULL,
  `memiliki_jamban` tinyint(1) DEFAULT 1,
  `pengelolaan_sampah` enum('diangkut','dibakar','kompos') DEFAULT NULL,
  `memiliki_toga` tinyint(1) DEFAULT 0,
  `id_kepala_keluarga` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keluarga`
--

INSERT INTO `keluarga` (`id_keluarga`, `no_kk`, `alamat_lengkap`, `rt_rw`, `penghasilan_bulanan`, `status_ekonomi`, `sumber_air`, `memiliki_jamban`, `pengelolaan_sampah`, `memiliki_toga`, `id_kepala_keluarga`, `created_at`) VALUES
(1, '3201010101010001', 'Jl. Merdeka No. 10', '01/05', 5000000, 'madya', 'pdam', 1, 'diangkut', 1, 1, '2026-03-09 01:34:06'),
(2, '3201010101010002', 'Jl. Keadilan No. 22', '01/05', 2000000, 'madya', 'sumur', 1, 'kompos', 0, 3, '2026-03-09 01:34:06'),
(3, '3201010101010003', 'Jl. Elang No. 05', '01/05', 8500000, 'mandiri', 'pdam', 1, 'diangkut', 1, 6, '2026-03-10 15:17:20'),
(4, '3201010101010004', 'Jl. Merak No. 12', '01/05', 12000000, 'mandiri', 'pdam', 1, 'diangkut', 0, 7, '2026-03-10 15:17:20'),
(5, '3201010101010005', 'Jl. Kancil No. 02', '01/05', 4500000, 'madya', 'sumur', 1, 'kompos', 1, 8, '2026-03-10 15:17:20'),
(6, '3201010101010006', 'Jl. Kelinci No. 08', '01/05', 3500000, 'madya', 'sumur', 1, 'diangkut', 0, 9, '2026-03-10 15:17:20'),
(7, '3201010101010007', 'JALAN KELAPA DUREN No 5', '01/05', 1500000, '', 'pdam', 0, 'diangkut', 1, 10, '2026-03-10 15:17:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int(11) NOT NULL,
  `nik` varchar(50) NOT NULL,
  `subjek` varchar(150) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `foto_bukti` varchar(255) DEFAULT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `status` enum('TERKIRIM','DIPROSES','SELESAI','DITOLAK') DEFAULT 'TERKIRIM',
  `tanggal_laporan` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `laporan`
--

INSERT INTO `laporan` (`id_laporan`, `nik`, `subjek`, `kategori`, `detail`, `foto_bukti`, `lokasi`, `status`, `tanggal_laporan`) VALUES
(1, '12345678', 'Meninggal', 'Sosial', 'Ghatan merokok pas puasa', 'uploads/1774514419_scaled_2816cbd9-302a-4ed0-aaca-af96c1a303b38205904548081968523.jpg', 'Jl. Anggrek No. 12, RT 05/RW 02, Jakarta Selatan', 'TERKIRIM', '2026-03-26 15:40:19'),
(2, '12345678', 'jalan rusak', 'Infrastruktur', 'didekat jalan marsudi', 'uploads/1774514772_scaled_b83c5d80-b6c4-406e-a706-05c31c13cd796840511248687770752.jpg', 'Jl. Anggrek No. 12, RT 05/RW 02, Jakarta Selatan', 'TERKIRIM', '2026-03-26 15:46:12');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengumuman`
--

CREATE TABLE `pengumuman` (
  `id_pengumuman` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `isi` text NOT NULL,
  `tanggal` date NOT NULL,
  `dibuat_oleh` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(255) DEFAULT NULL,
  `waktu` varchar(50) DEFAULT NULL,
  `kategori` varchar(50) DEFAULT NULL,
  `lokasi` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengumuman`
--

INSERT INTO `pengumuman` (`id_pengumuman`, `judul`, `isi`, `tanggal`, `dibuat_oleh`, `created_at`, `foto`, `waktu`, `kategori`, `lokasi`) VALUES
(2, 'Rapat RT', 'Rapat RT hari Jumat malam', '2026-02-09', NULL, '2026-02-09 01:17:09', NULL, NULL, NULL, NULL),
(3, 'Kerja Bakti', 'Kerja bakti RT Minggu pagi', '2026-02-09', NULL, '2026-02-09 01:18:36', NULL, NULL, NULL, NULL),
(4, 'MBG GRATIS', 'makan bergizi gratiss', '2026-03-19', 1, '2026-03-11 02:36:29', NULL, NULL, NULL, NULL),
(5, 'Kerja bakti', 'tess', '2026-03-24', 1, '2026-03-24 06:52:14', NULL, NULL, NULL, NULL),
(6, 'Kerja baktiii', 'bkabakbakabakla', '2026-03-24', 1, '2026-03-24 07:07:59', NULL, NULL, NULL, NULL),
(7, 'Kerja Bakti ', 'balbalaba', '2026-03-24', 1, '2026-03-24 07:45:53', 'pengumuman_1774338353.jpg', '14:40 WIB', 'LINGKUNGAN', 'Balai Warga '),
(8, 'Nangis bareng', 'Silahkan meninggal ', '2026-03-26', 1, '2026-03-26 06:05:48', NULL, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `posyandu`
--

CREATE TABLE `posyandu` (
  `id_posyandu` int(11) NOT NULL,
  `id_warga` int(11) DEFAULT NULL,
  `kategori` enum('balita','lansia') NOT NULL,
  `berat_badan` decimal(5,2) DEFAULT NULL,
  `tinggi_badan` decimal(5,2) DEFAULT NULL,
  `hasil` text DEFAULT NULL,
  `tanggal` date NOT NULL,
  `petugas` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `posyandu`
--

INSERT INTO `posyandu` (`id_posyandu`, `id_warga`, `kategori`, `berat_badan`, `tinggi_badan`, `hasil`, `tanggal`, `petugas`, `created_at`) VALUES
(1, 2, 'lansia', 62.50, 158.00, 'Kesehatan janin stabil, rutin konsumsi vitamin.', '2026-03-10', 1, '2026-03-10 14:14:12'),
(2, 4, 'balita', 12.40, 85.50, 'Berat badan ideal, imunisasi lengkap.', '2026-03-10', 1, '2026-03-10 14:14:12'),
(3, 3, 'lansia', 68.20, 165.00, 'Tekanan darah normal, jaga pola makan.', '2026-03-09', 1, '2026-03-10 14:14:12'),
(4, 1, 'balita', 100.00, 180.00, 'gahahhaga', '2026-03-10', 1, '2026-03-10 14:53:35'),
(5, 5, 'balita', 20.00, 100.00, 'fefefefefefe', '2026-03-10', 1, '2026-03-10 18:35:29'),
(6, 8, 'balita', 30.00, 200.00, 'babbfa', '2026-03-17', 1, '2026-03-17 04:44:48'),
(7, 1, 'lansia', 10.00, 160.00, 'sehat', '2026-03-20', 1, '2026-03-20 03:59:47'),
(8, 9, 'lansia', 10.00, 100.00, 'sehat', '2026-03-20', 1, '2026-03-20 04:00:11'),
(9, 8, 'balita', 10.00, 100.00, 'sehat', '2026-03-20', 1, '2026-03-20 04:03:19'),
(10, 7, 'balita', 10.00, 100.00, 'sehat', '2026-03-20', 1, '2026-03-20 04:08:41');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id_user` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nik` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','warga','posyandu','jumantik','kader_dawis') DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_verified` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id_user`, `nama`, `nik`, `password`, `role`, `created_at`, `is_verified`) VALUES
(1, 'Joko Wi Dodo', '317505', '123', 'admin', '2026-02-24 15:25:57', 1),
(2, 'Maulana', '31089', '$2y$10$twMUKGyB.xw58mtsM4tn2.oPJi6bKJBTXsKtyZJvIgnfsfIAXpw/O', 'admin', '2026-03-08 23:29:57', 1),
(3, 'Carrysa', '1', '123', 'admin', '2026-03-08 23:31:55', 1),
(5, 'ghatann', '12345678', '123', 'warga', '2026-03-20 09:25:48', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `warga`
--

CREATE TABLE `warga` (
  `id_warga` int(11) NOT NULL,
  `id_keluarga` int(11) DEFAULT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `nik` varchar(20) DEFAULT NULL,
  `tempat_lahir` varchar(50) DEFAULT NULL,
  `tanggal_lahir` date DEFAULT NULL,
  `jenis_kelamin` enum('L','P') DEFAULT NULL,
  `pendidikan` varchar(50) DEFAULT NULL,
  `pekerjaan` varchar(50) DEFAULT NULL,
  `status_perkawinan` enum('kawin','belum_kawin','cerai_hidup','cerai_mati') DEFAULT NULL,
  `status_kesehatan_khusus` enum('umum','bumil','lansia','disabilitas') DEFAULT 'umum',
  `bpjs_aktif` tinyint(1) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `warga`
--

INSERT INTO `warga` (`id_warga`, `id_keluarga`, `nama`, `nik`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `pendidikan`, `pekerjaan`, `status_perkawinan`, `status_kesehatan_khusus`, `bpjs_aktif`) VALUES
(1, 1, 'Rafidan', '3201000000000001', 'Jakarta', '1995-05-10', 'L', 'S1', 'Programmer', 'belum_kawin', 'umum', 1),
(2, 1, 'Siti Aminah', '3201000000000002', 'Bandung', '1998-08-20', 'P', 'SMA', 'IRT', 'kawin', 'bumil', 1),
(3, 2, 'Budi Santoso', '3201000000000003', 'Surabaya', '1970-01-15', 'L', 'SMP', 'Buruh', 'cerai_hidup', 'lansia', 0),
(4, 2, 'Agus Setiawan', '3201000000000004', 'Jakarta', '2010-12-12', 'L', 'SD', 'Pelajar', 'belum_kawin', 'disabilitas', 1),
(5, 2, 'Mbah Elis', '3175052107080001', 'Kebumen', '1955-03-29', 'P', 'SD', 'Penanam Sawit', 'cerai_hidup', 'lansia', 1),
(6, 3, 'Ahmad Subarjo', '3201000000000006', 'Surabaya', '1975-01-15', 'L', 'SMP', 'Buruh', 'kawin', 'lansia', 1),
(7, 4, 'Siti Aminah Baru', '3201000000000007', 'Yogyakarta', '1990-11-02', 'P', 'S1', 'Guru', 'kawin', 'bumil', 1),
(8, 5, 'Eko Prasetyo', '3201000000000008', 'Semarang', '1982-03-25', 'L', 'D3', 'Karyawan', 'kawin', 'umum', 0),
(9, 6, 'Bambang Wijaya', '3201000000000009', 'Malang', '1979-07-10', 'L', 'SMA', 'Supir', 'cerai_hidup', 'umum', 1),
(10, 7, 'Ratna TOmi', '3201000000000010', 'Medan', '1985-09-30', 'P', 'S1', 'Bidan', 'kawin', 'umum', 1),
(15, 1, 'Ghatan', '12345678', NULL, NULL, 'L', 'SMA', 'Mahasiswa', 'belum_kawin', 'umum', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `iuran`
--
ALTER TABLE `iuran`
  ADD PRIMARY KEY (`id_iuran`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `fk_iuran_keluarga` (`id_keluarga`);

--
-- Indeks untuk tabel `jumantik`
--
ALTER TABLE `jumantik`
  ADD PRIMARY KEY (`id_jumantik`),
  ADD KEY `fk_jumantik_keluarga` (`id_keluarga`),
  ADD KEY `fk_jumantik_petugas` (`petugas`);

--
-- Indeks untuk tabel `keluarga`
--
ALTER TABLE `keluarga`
  ADD PRIMARY KEY (`id_keluarga`),
  ADD UNIQUE KEY `no_kk` (`no_kk`);

--
-- Indeks untuk tabel `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`);

--
-- Indeks untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD PRIMARY KEY (`id_pengumuman`),
  ADD KEY `dibuat_oleh` (`dibuat_oleh`);

--
-- Indeks untuk tabel `posyandu`
--
ALTER TABLE `posyandu`
  ADD PRIMARY KEY (`id_posyandu`),
  ADD KEY `petugas` (`petugas`),
  ADD KEY `fk_posyandu_warga` (`id_warga`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `nik` (`nik`);

--
-- Indeks untuk tabel `warga`
--
ALTER TABLE `warga`
  ADD PRIMARY KEY (`id_warga`),
  ADD UNIQUE KEY `nik` (`nik`),
  ADD KEY `id_keluarga` (`id_keluarga`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `iuran`
--
ALTER TABLE `iuran`
  MODIFY `id_iuran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT untuk tabel `jumantik`
--
ALTER TABLE `jumantik`
  MODIFY `id_jumantik` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `keluarga`
--
ALTER TABLE `keluarga`
  MODIFY `id_keluarga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  MODIFY `id_pengumuman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `posyandu`
--
ALTER TABLE `posyandu`
  MODIFY `id_posyandu` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `warga`
--
ALTER TABLE `warga`
  MODIFY `id_warga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `iuran`
--
ALTER TABLE `iuran`
  ADD CONSTRAINT `fk_iuran_keluarga` FOREIGN KEY (`id_keluarga`) REFERENCES `keluarga` (`id_keluarga`),
  ADD CONSTRAINT `iuran_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jumantik`
--
ALTER TABLE `jumantik`
  ADD CONSTRAINT `fk_jumantik_keluarga` FOREIGN KEY (`id_keluarga`) REFERENCES `keluarga` (`id_keluarga`),
  ADD CONSTRAINT `fk_jumantik_petugas` FOREIGN KEY (`petugas`) REFERENCES `users` (`id_user`),
  ADD CONSTRAINT `jumantik_ibfk_1` FOREIGN KEY (`petugas`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `pengumuman`
--
ALTER TABLE `pengumuman`
  ADD CONSTRAINT `pengumuman_ibfk_1` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `posyandu`
--
ALTER TABLE `posyandu`
  ADD CONSTRAINT `fk_posyandu_warga` FOREIGN KEY (`id_warga`) REFERENCES `warga` (`id_warga`),
  ADD CONSTRAINT `posyandu_ibfk_1` FOREIGN KEY (`petugas`) REFERENCES `users` (`id_user`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `warga`
--
ALTER TABLE `warga`
  ADD CONSTRAINT `warga_ibfk_1` FOREIGN KEY (`id_keluarga`) REFERENCES `keluarga` (`id_keluarga`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
