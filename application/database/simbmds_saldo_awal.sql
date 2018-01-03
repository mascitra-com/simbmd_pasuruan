-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 30, 2017 at 10:14 AM
-- Server version: 10.1.28-MariaDB
-- PHP Version: 5.6.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `simbmds`
--

-- --------------------------------------------------------

--
-- Table structure for table `saldo_aset_a`
--

CREATE TABLE `saldo_aset_a` (
  `id` int(11) NOT NULL,
  `reg_barang` int(11) NOT NULL,
  `reg_induk` varchar(255) DEFAULT NULL,
  `luas` int(11) DEFAULT NULL,
  `alamat` text,
  `sertifikat_tgl` datetime DEFAULT NULL,
  `sertifikat_no` varchar(255) DEFAULT NULL,
  `hak` varchar(255) DEFAULT NULL,
  `pengguna` varchar(255) DEFAULT NULL,
  `tgl_perolehan` datetime DEFAULT NULL,
  `tgl_pembukuan` datetime DEFAULT NULL,
  `tahun` year(4) DEFAULT NULL,
  `asal_usul` varchar(255) DEFAULT NULL,
  `kondisi` int(1) DEFAULT '1',
  `nilai` double(30,2) NOT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `kd_pemilik` varchar(255) DEFAULT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  `log_action` varchar(255) DEFAULT NULL,
  `log_user` varchar(255) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `saldo_aset_b`
--

CREATE TABLE `saldo_aset_b` (
  `id` int(11) NOT NULL,
  `reg_barang` int(11) NOT NULL,
  `reg_induk` varchar(255) DEFAULT NULL,
  `tgl_perolehan` datetime DEFAULT NULL,
  `tgl_pembukuan` datetime DEFAULT NULL,
  `merk` varchar(255) DEFAULT NULL,
  `tipe` varchar(255) DEFAULT NULL,
  `ukuran` int(11) DEFAULT NULL,
  `bahan` varchar(255) DEFAULT NULL,
  `no_pabrik` varchar(255) DEFAULT NULL,
  `no_rangka` varchar(255) DEFAULT NULL,
  `no_mesin` varchar(255) DEFAULT NULL,
  `no_polisi` varchar(255) DEFAULT NULL,
  `no_bpkb` varchar(255) DEFAULT NULL,
  `asal_usul` varchar(255) DEFAULT NULL,
  `kondisi` varchar(255) DEFAULT NULL,
  `nilai` double(30,2) NOT NULL,
  `nilai_sisa` double(30,2) NOT NULL,
  `masa_manfaat` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `kd_pemilik` varchar(255) NOT NULL,
  `id_ruangan` int(11) DEFAULT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  `log_action` varchar(255) DEFAULT NULL,
  `log_user` varchar(255) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `saldo_aset_c`
--

CREATE TABLE `saldo_aset_c` (
  `id` int(11) NOT NULL,
  `reg_barang` int(11) NOT NULL,
  `reg_induk` varchar(255) DEFAULT NULL,
  `tgl_perolehan` datetime NOT NULL,
  `tgl_pembukuan` datetime NOT NULL,
  `tingkat` varchar(255) DEFAULT NULL,
  `beton` varchar(255) DEFAULT NULL,
  `luas_lantai` int(11) DEFAULT NULL,
  `lokasi` text,
  `dokumen_tgl` datetime DEFAULT NULL,
  `dokumen_no` varchar(255) DEFAULT NULL,
  `status_tanah` varchar(255) DEFAULT NULL,
  `kode_tanah` varchar(255) DEFAULT NULL,
  `asal_usul` varchar(255) DEFAULT NULL,
  `kondisi` varchar(255) DEFAULT NULL,
  `nilai` double(15,2) NOT NULL,
  `nilai_sisa` double(30,2) NOT NULL,
  `nilai_tambah` double(30,2) NOT NULL,
  `masa_manfaat` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `kd_pemilik` varchar(255) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  `log_action` varchar(255) DEFAULT NULL,
  `log_user` varchar(255) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `saldo_aset_d`
--

CREATE TABLE `saldo_aset_d` (
  `id` int(11) NOT NULL,
  `reg_barang` int(11) NOT NULL,
  `reg_induk` varchar(255) DEFAULT NULL,
  `tgl_perolehan` datetime NOT NULL,
  `tgl_pembukuan` datetime NOT NULL,
  `kontruksi` varchar(255) DEFAULT NULL,
  `panjang` int(11) DEFAULT NULL,
  `lebar` int(11) DEFAULT NULL,
  `luas` int(11) DEFAULT NULL,
  `lokasi` text,
  `dokumen_tgl` datetime DEFAULT NULL,
  `dokumen_no` varchar(255) DEFAULT NULL,
  `status_tanah` varchar(255) DEFAULT NULL,
  `kode_tanah` varchar(255) DEFAULT NULL,
  `asal_usul` varchar(255) DEFAULT NULL,
  `kondisi` varchar(255) DEFAULT NULL,
  `nilai` double(30,2) NOT NULL,
  `nilai_sisa` double(30,2) NOT NULL,
  `nilai_tambah` double(30,2) NOT NULL,
  `masa_manfaat` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `kd_pemilik` varchar(255) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  `log_action` varchar(255) DEFAULT NULL,
  `log_user` varchar(255) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `saldo_aset_e`
--

CREATE TABLE `saldo_aset_e` (
  `id` int(11) NOT NULL,
  `reg_barang` int(11) NOT NULL,
  `reg_induk` varchar(255) DEFAULT NULL,
  `tgl_perolehan` datetime NOT NULL,
  `tgl_pembukuan` datetime NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `pencipta` varchar(255) DEFAULT NULL,
  `bahan` varchar(255) DEFAULT NULL,
  `ukuran` int(11) DEFAULT NULL,
  `asal_usul` varchar(255) DEFAULT NULL,
  `kondisi` varchar(255) DEFAULT NULL,
  `nilai` double(30,2) NOT NULL,
  `nilai_sisa` double(30,2) NOT NULL,
  `masa_manfaat` int(11) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `tahun` year(4) NOT NULL,
  `kd_pemilik` varchar(255) NOT NULL,
  `id_ruangan` int(11) DEFAULT NULL,
  `id_kategori` int(11) NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  `log_action` varchar(255) DEFAULT NULL,
  `log_user` varchar(255) DEFAULT NULL,
  `log_time` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `saldo_aset_a`
--
ALTER TABLE `saldo_aset_a`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saldo_aset_b`
--
ALTER TABLE `saldo_aset_b`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saldo_aset_c`
--
ALTER TABLE `saldo_aset_c`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saldo_aset_d`
--
ALTER TABLE `saldo_aset_d`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saldo_aset_e`
--
ALTER TABLE `saldo_aset_e`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `saldo_aset_a`
--
ALTER TABLE `saldo_aset_a`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `saldo_aset_b`
--
ALTER TABLE `saldo_aset_b`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT for table `saldo_aset_c`
--
ALTER TABLE `saldo_aset_c`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `saldo_aset_d`
--
ALTER TABLE `saldo_aset_d`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `saldo_aset_e`
--
ALTER TABLE `saldo_aset_e`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
