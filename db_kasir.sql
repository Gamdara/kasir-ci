-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jun 27, 2021 at 05:38 PM
-- Server version: 8.0.23
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_kasir`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int NOT NULL,
  `id_transaksi` int NOT NULL,
  `id_produk` int NOT NULL,
  `jumlah` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `id_transaksi`, `id_produk`, `jumlah`) VALUES
(1, 10, 1, 2),
(2, 10, 2, 3),
(3, 11, 1, 2),
(4, 11, 2, 3),
(5, 12, 1, 2),
(6, 13, 1, 2),
(7, 14, 1, 1),
(8, 15, 1, 1),
(9, 16, 1, 1),
(10, 17, 2, 2),
(11, 18, 1, 2),
(12, 19, 1, 3),
(13, 20, 1, 3),
(14, 21, 1, 3),
(15, 22, 1, 3);

-- --------------------------------------------------------

--
-- Table structure for table `gudang`
--

CREATE TABLE `gudang` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `gudang`
--

INSERT INTO `gudang` (`id`, `nama`) VALUES
(1, 'Gudang A');

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `id` int NOT NULL,
  `karyawan` varchar(100) NOT NULL,
  `telp` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`id`, `karyawan`, `telp`) VALUES
(1, 'Gede', '089283');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `id` int NOT NULL,
  `kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori_produk`
--

INSERT INTO `kategori_produk` (`id`, `kategori`) VALUES
(1, 'Tekhnologi'),
(2, 'Kebutuhan');

-- --------------------------------------------------------

--
-- Stand-in structure for view `laporan_bulanan`
-- (See below for the actual view)
--
CREATE TABLE `laporan_bulanan` (
`bulan` varchar(69)
,`total_beli` decimal(54,0)
,`total_jual` decimal(54,0)
,`jumlah_transaksi` decimal(42,0)
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `laporan_harian`
-- (See below for the actual view)
--
CREATE TABLE `laporan_harian` (
`tanggal` varchar(40)
,`total_beli` decimal(32,0)
,`total_jual` decimal(32,0)
,`jumlah_transaksi` bigint
);

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id` int NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kelamin` set('Pria','Wanita','Lainya') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `level` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id`, `nama`, `jenis_kelamin`, `alamat`, `telepon`, `level`) VALUES
(1, 'Adam', 'Pria', 'Seoul', '081237483291', 'pelanggan'),
(2, 'Rahma', 'Wanita', 'Banjarnegara', '085463728374', 'reseller');

-- --------------------------------------------------------

--
-- Table structure for table `pengeluaran`
--

CREATE TABLE `pengeluaran` (
  `id` int NOT NULL,
  `tanggal` date NOT NULL,
  `nominal` int NOT NULL,
  `jenis_bayar` varchar(100) NOT NULL,
  `keterangan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pengeluaran`
--

INSERT INTO `pengeluaran` (`id`, `tanggal`, `nominal`, `jenis_bayar`, `keterangan`) VALUES
(5, '2021-06-24', 10000, 'BCA', '-');

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` int NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` char(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `username`, `password`, `nama`, `role`) VALUES
(1, 'admin', '$2y$10$/I7laWi1mlNFxYSv54EUPOH8MuZhmRWxhE.LaddTK9TSmVe.IHP2C', 'Admin', '1'),
(2, 'ibrahimalanshor', '$2y$10$5thNuizSyAdrGXC9A/WYd.StNiSRUy0eBZJ401hGBfUpwGINu9kyG', 'Ibrahim Al Anshor', '2'),
(3, 'admin', 'admin', 'admin', '1');

-- --------------------------------------------------------

--
-- Table structure for table `platform`
--

CREATE TABLE `platform` (
  `id` int NOT NULL,
  `nama` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `platform`
--

INSERT INTO `platform` (`id`, `nama`) VALUES
(3, 'Tokopedia');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `barcode` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_produk` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` int NOT NULL,
  `satuan` int NOT NULL,
  `harga_beli` int NOT NULL,
  `harga_jual` int NOT NULL,
  `harga_reseller` int NOT NULL,
  `stok` int NOT NULL,
  `terjual` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `barcode`, `nama_produk`, `kategori`, `satuan`, `harga_beli`, `harga_jual`, `harga_reseller`, `stok`, `terjual`) VALUES
(1, 'PULS ALPRB', 'Voucher Pulsa 50000', 1, 2, 45000, 55000, 50000, 81, 19),
(2, 'DJRM SPER', 'Djarum Super 12', 2, 1, 14000, 18000, 18000, 62, 2);

-- --------------------------------------------------------

--
-- Table structure for table `refund`
--

CREATE TABLE `refund` (
  `id` int NOT NULL,
  `id_transaksi` int NOT NULL,
  `tanggal` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `refund`
--

INSERT INTO `refund` (`id`, `id_transaksi`, `tanggal`) VALUES
(1, 3, '2021-06-27'),
(2, 13, '2021-06-27'),
(5, 16, '2021-06-27');

-- --------------------------------------------------------

--
-- Table structure for table `reseller`
--

CREATE TABLE `reseller` (
  `id` int NOT NULL,
  `nama` varchar(200) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `alamat` varchar(300) NOT NULL,
  `telepon` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `reseller`
--

INSERT INTO `reseller` (`id`, `nama`, `jenis_kelamin`, `alamat`, `telepon`) VALUES
(1, 'Heyo', 'Wanita', 'Jalan', '08979');

-- --------------------------------------------------------

--
-- Table structure for table `satuan_produk`
--

CREATE TABLE `satuan_produk` (
  `id` int NOT NULL,
  `satuan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `satuan_produk`
--

INSERT INTO `satuan_produk` (`id`, `satuan`) VALUES
(1, 'Bungkus'),
(2, 'Voucher');

-- --------------------------------------------------------

--
-- Table structure for table `stok_keluar`
--

CREATE TABLE `stok_keluar` (
  `id` int NOT NULL,
  `tanggal` datetime NOT NULL,
  `barcode` int NOT NULL,
  `jumlah` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Keterangan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok_keluar`
--

INSERT INTO `stok_keluar` (`id`, `tanggal`, `barcode`, `jumlah`, `Keterangan`) VALUES
(1, '2020-02-21 13:42:01', 1, '10', 'rusak'),
(2, '2021-06-22 14:15:34', 1, '65', 'rusak'),
(3, '2021-06-24 21:58:14', 1, '2', 'rusak'),
(4, '2021-06-24 22:41:22', 1, '2', 'rusak'),
(5, '2021-06-25 01:02:48', 2, '2', 'rusak'),
(6, '2021-06-25 12:06:24', 2, '2', '-'),
(7, '2021-06-25 12:06:24', 2, '2', '-'),
(8, '2021-06-25 12:06:24', 2, '2', '-'),
(9, '2021-06-25 12:07:02', 2, '2', '-'),
(10, '2021-06-25 12:38:40', 2, '2', '-'),
(11, '2021-06-25 12:39:43', 2, '1', '-'),
(12, '2021-06-25 12:40:21', 1, '3', '-'),
(13, '2021-06-25 12:40:21', 2, '3', '-');

-- --------------------------------------------------------

--
-- Table structure for table `stok_masuk`
--

CREATE TABLE `stok_masuk` (
  `id` int NOT NULL,
  `tanggal` datetime NOT NULL,
  `barcode` int NOT NULL,
  `jumlah` varchar(11) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `supplier` int DEFAULT NULL,
  `bayar` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok_masuk`
--

INSERT INTO `stok_masuk` (`id`, `tanggal`, `barcode`, `jumlah`, `keterangan`, `supplier`, `bayar`) VALUES
(1, '2020-02-21 13:41:25', 1, '10', 'penambahan', NULL, 0),
(2, '2020-02-21 13:41:40', 2, '20', 'penambahan', 1, 0),
(3, '2020-02-21 13:42:23', 1, '10', 'penambahan', 2, 0),
(4, '0000-00-00 00:00:00', 1, '2', 'penambahan', 1, 0),
(5, '0000-00-00 00:00:00', 1, '4', 'penambahan', 1, 0),
(6, '0000-00-00 00:00:00', 2, '4', 'penambahan', 1, 0),
(7, '0000-00-00 00:00:00', 1, '100', 'penambahan', 1, 0),
(8, '0000-00-00 00:00:00', 1, '100', 'penambahan', 1, 0),
(9, '0000-00-00 00:00:00', 1, '2', 'penambahan', 1, 110000),
(10, '2021-06-23 12:48:44', 1, '2', 'penambahan', 1, 110000),
(11, '2021-06-23 12:49:17', 1, '22', 'penambahan', 1, 1210000),
(12, '2021-06-24 14:17:12', 1, '80', 'penambahan', 1, 3600000),
(13, '2021-06-24 14:17:44', 2, '80', 'penambahan', 1, 1120000),
(14, '2021-06-24 23:57:32', 1, '80', 'penambahan', 1, 3600000),
(15, '2021-06-25 12:40:05', 1, '100', 'penambahan', 1, 4500000);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id` int NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `telepon` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `alamat`, `telepon`, `keterangan`) VALUES
(1, 'Tulus', 'Banjarnegara', '083321128832', 'Aktif'),
(2, 'aNur', 'Cilacap', '082235542637', 'Baru');

-- --------------------------------------------------------

--
-- Table structure for table `toko`
--

CREATE TABLE `toko` (
  `id` int NOT NULL,
  `nama` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `toko`
--

INSERT INTO `toko` (`id`, `nama`, `alamat`) VALUES
(1, 'Toko Tuma', 'Jln Raya Klesem Selatan No 1E Wanadadi, Banjarnegara, Indonesia');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int NOT NULL,
  `tanggal` datetime NOT NULL,
  `total_bayar` int NOT NULL,
  `jumlah_uang` int NOT NULL,
  `diskon` int NOT NULL,
  `pelanggan` int DEFAULT NULL,
  `nota` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `kasir` int NOT NULL,
  `marketplace` int NOT NULL,
  `jenis_piutang` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `piutang_kurang` int NOT NULL,
  `jenis_bayar` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_kirim` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ongkir` int NOT NULL,
  `bank` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `tanggal`, `total_bayar`, `jumlah_uang`, `diskon`, `pelanggan`, `nota`, `kasir`, `marketplace`, `jenis_piutang`, `piutang_kurang`, `jenis_bayar`, `jenis_kirim`, `ongkir`, `bank`) VALUES
(13, '2021-06-25 00:58:17', 110000, 1111111, 0, 1, '9MJNXQM0A2UX9SL', 1, 0, 'refund', 0, '', '', 0, ''),
(14, '2021-06-25 09:39:49', 55000, 100000, 0, 1, 'ZC5HK3R975XI6AC', 1, 0, '', 0, '', '', 0, ''),
(15, '2021-06-25 09:39:49', 55000, 100000, 0, 1, 'ZC5HK3R975XI6AC', 1, 0, '', 0, '', '', 0, ''),
(16, '2021-06-25 09:39:49', 55000, 100000, 0, 1, 'ZC5HK3R975XI6AC', 1, 0, 'refund', 0, '', '', 0, ''),
(17, '2021-06-25 09:41:53', 36000, 100000, 0, 1, 'V0BWR0T3OX5L3EJ', 1, 0, '', 0, '', '', 0, ''),
(18, '2021-06-25 19:59:04', 110000, 1000000, 0, 2, 'M3HJUCZYAYPC2HA', 1, 0, '', 0, '', '', 0, ''),
(19, '2021-06-25 22:45:29', 165000, 1000000, 0, 1, '0FE2WMTYF3URGQK', 1, 3, 'lunas', 0, 'cash', 'JNE', 20000, 'BCA'),
(20, '2021-06-27 12:55:41', 165000, 100000, 0, 1, '6DIDQ15QBYJM9UN', 1, 1, 'lunas', 0, 'cash', '', 0, 'BCA'),
(21, '2021-06-27 16:41:33', 150000, 1000000, 0, 2, 'LC3JM81S730LTH9', 1, 0, 'dp', 0, 'bank', '', 0, 'BCA'),
(22, '2021-06-27 16:43:56', 150000, 1000000, 0, 2, 'DTH61EEUWK9MSQ2', 1, 0, 'dp', 0, 'bank', '', 0, 'BCA');

-- --------------------------------------------------------

--
-- Structure for view `laporan_bulanan`
--
DROP TABLE IF EXISTS `laporan_bulanan`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `laporan_bulanan`  AS  select date_format(cast(str_to_date(`laporan_harian`.`tanggal`,'%d %b %Y') as date),'%M %Y') AS `bulan`,sum(`laporan_harian`.`total_beli`) AS `total_beli`,sum(`laporan_harian`.`total_jual`) AS `total_jual`,sum(`laporan_harian`.`jumlah_transaksi`) AS `jumlah_transaksi` from `laporan_harian` group by date_format(cast(str_to_date(`laporan_harian`.`tanggal`,'%d %b %Y') as date),'%M %Y') ;

-- --------------------------------------------------------

--
-- Structure for view `laporan_harian`
--
DROP TABLE IF EXISTS `laporan_harian`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `laporan_harian`  AS  select date_format(`transaksi`.`tanggal`,'%d %b %Y') AS `tanggal`,sum(`produk`.`harga_beli`) AS `total_beli`,sum(`produk`.`harga_jual`) AS `total_jual`,count(`transaksi`.`id`) AS `jumlah_transaksi` from ((`detail_transaksi` join `transaksi` on((`transaksi`.`id` = `detail_transaksi`.`id_transaksi`))) join `produk` on((`detail_transaksi`.`id_produk` = `produk`.`id`))) group by date_format(`transaksi`.`tanggal`,'%d %b %Y') ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `gudang`
--
ALTER TABLE `gudang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `platform`
--
ALTER TABLE `platform`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `refund`
--
ALTER TABLE `refund`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reseller`
--
ALTER TABLE `reseller`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `satuan_produk`
--
ALTER TABLE `satuan_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `toko`
--
ALTER TABLE `toko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `gudang`
--
ALTER TABLE `gudang`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `karyawan`
--
ALTER TABLE `karyawan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `pengeluaran`
--
ALTER TABLE `pengeluaran`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `platform`
--
ALTER TABLE `platform`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `refund`
--
ALTER TABLE `refund`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `reseller`
--
ALTER TABLE `reseller`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `satuan_produk`
--
ALTER TABLE `satuan_produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `stok_keluar`
--
ALTER TABLE `stok_keluar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `stok_masuk`
--
ALTER TABLE `stok_masuk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `toko`
--
ALTER TABLE `toko`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
