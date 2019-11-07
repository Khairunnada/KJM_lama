-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 07, 2019 at 04:41 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `KJM`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_master_barang`
--

CREATE TABLE `tb_master_barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(10) NOT NULL,
  `barang` varchar(300) NOT NULL,
  `id_satuan` int(5) NOT NULL,
  `id_satuan_lain` int(5) NOT NULL,
  `id_grup` int(5) NOT NULL,
  `id_level_1` int(5) NOT NULL,
  `id_level_2` int(5) NOT NULL,
  `id_golongan` int(5) NOT NULL,
  `faktor` int(2) NOT NULL,
  `minimum_stok` int(2) NOT NULL,
  `lead_time` int(2) NOT NULL,
  `reorder_qty` int(2) NOT NULL,
  `pembagi` double(20,2) NOT NULL,
  `harga_rata_rata` double(20,2) NOT NULL,
  `id_akun_pembukuan` int(5) NOT NULL,
  `id_aktiva` int(10) NOT NULL,
  `id_tipe_aktiva` int(2) NOT NULL,
  `id_kelompok_aktiva` int(2) NOT NULL,
  `id_akun_akumulasi_penyusutan_aktiva` int(5) NOT NULL,
  `id_akun_beban_penyusutan_aktiva` int(5) NOT NULL,
  `catatan` varchar(100) NOT NULL,
  `aktif` int(2) NOT NULL,
  `hapus` int(1) NOT NULL,
  `id_user` int(5) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tb_master_barang`
--

INSERT INTO `tb_master_barang` (`id`, `kode`, `barang`, `id_satuan`, `id_satuan_lain`, `id_grup`, `id_level_1`, `id_level_2`, `id_golongan`, `faktor`, `minimum_stok`, `lead_time`, `reorder_qty`, `pembagi`, `harga_rata_rata`, `id_akun_pembukuan`, `id_aktiva`, `id_tipe_aktiva`, `id_kelompok_aktiva`, `id_akun_akumulasi_penyusutan_aktiva`, `id_akun_beban_penyusutan_aktiva`, `catatan`, `aktif`, `hapus`, `id_user`, `created_at`, `updated_at`) VALUES
(1, 'AL0001', 'test', 1, 1, 1, 4, 6, 2, 1, 4, 2, 4, 1.00, 0.00, 2, 0, 1, 2, 61, 161, '-', 1, 0, 1, '2019-11-06 14:49:09', '2019-11-06 14:49:09'),
(2, 'AL0002', 'test2', 2, 2, 1, 3, 1, 2, 1, 4, 2, 4, 1.00, 0.00, 4, 0, 1, 5, 61, 161, 'testssss', 1, 1, 1, '2019-11-06 14:51:27', '2019-11-06 15:16:16'),
(6, 'AL0002', 'test2', 2, 2, 1, 3, 1, 2, 1, 4, 2, 4, 1.00, 0.00, 4, 0, 1, 5, 61, 161, 'testssss', 1, 1, 1, '2019-11-06 15:16:16', '2019-11-06 15:18:25'),
(7, 'AL0002', 'test2', 2, 2, 1, 3, 1, 2, 1, 4, 2, 4, 1.00, 0.00, 4, 0, 1, 5, 61, 161, 'testssss', 1, 1, 1, '2019-11-06 15:18:25', '2019-11-06 15:18:56'),
(8, 'AL0002', 'test3', 2, 2, 1, 3, 1, 2, 1, 4, 2, 4, 1.00, 0.00, 4, 0, 1, 5, 61, 161, 'testssss', 1, 1, 1, '2019-11-06 15:18:56', '2019-11-06 15:19:14'),
(9, 'BB0001', 'test3', 2, 2, 2, 3, 1, 2, 1, 4, 2, 4, 1.00, 0.00, 4, 0, 1, 5, 61, 161, 'testssss', 1, 1, 1, '2019-11-06 15:19:14', '2019-11-06 15:19:32'),
(10, 'BB0001', 'test3', 3, 3, 2, 3, 1, 2, 1, 4, 2, 4, 1.00, 0.00, 4, 0, 1, 5, 61, 161, 'testssss', 1, 1, 1, '2019-11-06 15:19:32', '2019-11-06 15:19:48'),
(11, 'BB0001', 'test3', 52, 52, 2, 3, 1, 2, 1, 4, 2, 4, 1.00, 0.00, 4, 0, 1, 5, 61, 161, 'testssss', 1, 1, 1, '2019-11-06 15:19:48', '2019-11-06 15:26:21'),
(12, 'BB0001', 'test3', 52, 52, 2, 3, 1, 2, 1, 4, 2, 4, 1.00, 0.00, 4, 0, 2, 5, 61, 161, 'testssss', 1, 1, 1, '2019-11-06 15:26:21', '2019-11-06 15:30:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_master_barang`
--
ALTER TABLE `tb_master_barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_master_barang`
--
ALTER TABLE `tb_master_barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
