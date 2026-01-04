-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 04 Jan 2026 pada 04.06
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
-- Database: `cookieraa`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `email`, `password`) VALUES
(1, 'rara', 'rara@yahoo', '$2y$10$YctsSQkLOglQFA6n72ovOej8BZdPGAK9yoB9CdjeDrZc8344XAK2O'),
(2, 'azirara55', 'azirara55@gmail.com', '$2y$10$jF4AMkeSndD4x7etgz/NAO6gCCLoCgvc.WlqXE5axY8Y1cNJjQa6q'),
(3, 'azirara55', '', '$2y$10$fHznSxlutQ1xcqZeKuPTfOueLjUYw6ZuHwiamE4fMOD/dnhz82P8S'),
(4, 'azirara55', 'azirara55@gmail.com', '$2y$10$WcZDCEtMdnWU4TLBGEhvMuCeYcukxGvMeRW.V/Ws48.kmjspXGHhO'),
(5, 'azirara', 'azira@gmail.com', '$2y$10$SuTaZM6oGWoYGhdWMPH6Iu5k2oTYGYO4JlIeTjX.4pVqD0vwm5fEG');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id_pesanan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `tanggal` datetime DEFAULT current_timestamp(),
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `total` int(11) NOT NULL,
  `pembayaran` varchar(50) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pesanan`
--

INSERT INTO `pesanan` (`id_pesanan`, `id_user`, `tanggal`, `no_hp`, `alamat`, `total`, `pembayaran`, `status`) VALUES
(15, 2, '2026-01-03 23:03:30', NULL, NULL, 30000, NULL, 'pending'),
(16, 2, '2026-01-03 23:09:59', '12309876768', 'Cikopak', 15000, NULL, 'proses'),
(17, 2, '2026-01-03 23:17:29', '12309876768', 'Cikopak', 17000, 'cod', 'pending'),
(18, 4, '2026-01-03 23:35:03', '12309876768', 'Cikopak', 47000, 'cod', 'pending'),
(19, 4, '2026-01-04 00:53:08', '12309876768', 'Cikopak', 30000, 'transfer', 'pending');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan_detail`
--

CREATE TABLE `pesanan_detail` (
  `id_detail` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `no_hp` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `subtotal` int(11) NOT NULL,
  `pembayaran` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `pesanan_detail`
--

INSERT INTO `pesanan_detail` (`id_detail`, `id_pesanan`, `no_hp`, `alamat`, `id_produk`, `nama_produk`, `harga`, `qty`, `subtotal`, `pembayaran`) VALUES
(11, 9, NULL, NULL, 9, 'Red Velvet Cookies With Cream Cheese', 17000, 1, 17000, NULL),
(12, 9, NULL, NULL, 7, 'Red Velvet Cookies Original', 13000, 1, 13000, NULL),
(13, 10, NULL, NULL, 7, 'Red Velvet Cookies Original', 13000, 1, 13000, NULL),
(14, 11, NULL, NULL, 7, 'Red Velvet Cookies Original', 13000, 1, 13000, NULL),
(15, 12, NULL, NULL, 7, 'Red Velvet Cookies Original', 13000, 1, 13000, NULL),
(16, 13, NULL, NULL, 12, 'Oreo Cookies Original', 15000, 1, 15000, NULL),
(17, 14, NULL, NULL, 8, 'Red Velvet Oreo Cookies', 15000, 1, 15000, NULL),
(18, 15, NULL, NULL, 10, 'Choco Chip Cookies', 15000, 2, 30000, NULL),
(19, 16, NULL, NULL, 12, 'Oreo Cookies Original', 15000, 1, 15000, NULL),
(20, 17, NULL, NULL, 11, 'Lotus Biscoff Cookies', 17000, 1, 17000, NULL),
(21, 18, NULL, NULL, 14, 'Chewy Marshmallow Chocolate Chip Cookies', 16000, 2, 32000, NULL),
(22, 18, NULL, NULL, 12, 'Oreo Cookies Original', 15000, 1, 15000, NULL),
(23, 19, NULL, NULL, 12, 'Oreo Cookies Original', 15000, 2, 30000, NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `nama_produk` varchar(200) NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL DEFAULT 0,
  `ketersediaan_stok` enum('habis','tersedia') DEFAULT 'tersedia',
  `gambar` varchar(225) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id_produk`, `nama_produk`, `harga`, `stok`, `ketersediaan_stok`, `gambar`, `deskripsi`) VALUES
(7, 'Red Velvet Cookies Original', 13000, 15, 'tersedia', 'produk_694b935d275c33.52914566.jpg', 'Red velvet clasic dengan tekstur yang chewy.'),
(8, 'Red Velvet Oreo Cookies', 15000, 19, 'tersedia', 'produk_694b9320dd3701.76622620.jpg', 'Red velvet lembut dengan potongan oreo'),
(9, 'Red Velvet Cookies With Cream Cheese', 17000, 9, 'tersedia', 'produk_694b93f0bef387.99608384.jpg', 'Red velvet lembut dengan lelehan cream cheese yang creamy.'),
(10, 'Choco Chip Cookies', 15000, 15, 'tersedia', 'produk_694b942b09cdc9.21371062.jpg', 'Cookies clasic renyah &amp; lembut di dalam.'),
(11, 'Lotus Biscoff Cookies', 17000, 12, 'tersedia', 'produk_694b94627ed2b9.96129581.jpg', 'Cookies clasic dengan aroma karamel dan potongan Biscoff.'),
(12, 'Oreo Cookies Original', 15000, 10, 'tersedia', 'produk_694b948a692279.37848591.jpg', ' Cookies clasic lembut dengan potongan oreo.'),
(14, 'Chewy Marshmallow Chocolate Chip Cookies', 16000, 20, 'tersedia', 'produk_695865908967e3.97810157.jpeg', 'Cookies lembut dan chewy dengan marshmallow lumer serta chocolate chip yang manis dan kaya rasa.'),
(17, 'Matcha Chocolate Chip Cookies', 16000, 17, 'tersedia', 'produk_6959c95b04a9d9.93187207.jpeg', 'Lembut dengan aroma matcha yang harum, dipadu lelehan cokelat yang manis dan creamy di setiap gigitan.'),
(18, 'Dark Chocolate Fudge Cookies', 16000, 13, 'tersedia', 'produk_6959cabdf05076.61662578.jpeg', 'Cookies cokelat lembut dengan rasa cokelat pekat dan tekstur fudgy yang lumer di mulut.'),
(19, 'Strawberry White Chocolate Cookies', 15000, 15, 'tersedia', 'produk_6959caf3c86429.00243591.jpeg', 'Cookies lembut beraroma stroberi manis dengan potongan white chocolate yang creamy.'),
(20, 'Strawberry Frosted Sugar Cookies', 17000, 14, 'tersedia', 'produk_6959cb636dbb87.85879092.jpeg', 'Cookies sugar klasik dengan frosting stroberi lembut dan sentuhan manis yang seimbang.'),
(21, 'Blue Velvet Oreo Cookies', 17000, 10, 'tersedia', 'produk_6959cb93006e45.56561527.jpeg', 'Cookies lembut berwarna blue velvet dengan isian Oreo crunchy dan cokelat lumer.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(225) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `password`) VALUES
(1, 'dea', 'deaaja@yahoo', '$2y$10$Yxzv2w6Wxfj2Gb6UJJftUOo91gf3t8X6N9mKSOC04W0vfGg1QKAzi'),
(2, 'rara', 'rara@com', '$2y$10$nIbUGPj6xHBCxDQ5.FlgpeeonA4yOSnmVXVw3gVNAUng4faUkctMO'),
(3, 'rizky', 'rizky@com', '$2y$10$2UnQ9ODPFTiBkU6q7DHodeULRUfusM1epadT/is0EcPPJaxXTV2yi'),
(4, 'farel', 'farel@com', '$2y$10$ykao9fr.EBUgaFp0dLGPEeMO6uX0QYOG69aYBQXOipXIlDPM9TWyG');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id_pesanan`);

--
-- Indeks untuk tabel `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  ADD PRIMARY KEY (`id_detail`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id_pesanan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `pesanan_detail`
--
ALTER TABLE `pesanan_detail`
  MODIFY `id_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
