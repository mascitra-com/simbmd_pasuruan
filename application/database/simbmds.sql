-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2017 at 05:01 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
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
-- Table structure for table `persetujuan`
--

CREATE TABLE `persetujuan` (
  `id` int(11) NOT NULL,
  `pesan` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `id_transfer` int(11) NOT NULL,
  `id_hapus` int(11) NOT NULL,
  `log_action` varchar(255) NOT NULL,
  `log_user` int(11) NOT NULL,
  `log_time` datetime NOT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `transfer`
--

CREATE TABLE `transfer` (
  `id` int(11) NOT NULL,
  `surat_jenis` varchar(255) DEFAULT NULL,
  `surat_no` varchar(255) DEFAULT NULL,
  `surat_tgl` datetime DEFAULT NULL,
  `jurnal_no` varchar(255) DEFAULT NULL,
  `jurnal_tgl` datetime DEFAULT NULL,
  `serah_terima_no` varchar(255) DEFAULT NULL,
  `serah_terima_tgl` datetime DEFAULT NULL,
  `penerima_nama` varchar(255) DEFAULT NULL,
  `penerima_jabatan` varchar(255) DEFAULT NULL,
  `penerima_nip` varchar(255) DEFAULT NULL,
  `penerima_golongan` varchar(255) DEFAULT NULL,
  `penyerah_nama` varchar(255) DEFAULT NULL,
  `penyerah_jabatan` varchar(255) DEFAULT NULL,
  `penyerah_nip` varchar(255) DEFAULT NULL,
  `penyerah_golongan` varchar(255) DEFAULT NULL,
  `atasan_nama` varchar(255) DEFAULT NULL,
  `atasan_jabatan` varchar(255) DEFAULT NULL,
  `atasan_nip` varchar(255) DEFAULT NULL,
  `atasan_golongan` varchar(255) DEFAULT NULL,
  `id_tujuan` varchar(255) DEFAULT NULL,
  `status_pengajuan` tinyint(1) NOT NULL DEFAULT '0',
  `tanggal_verifikasi` datetime NOT NULL,
  `id_organisasi` int(11) NOT NULL,
  `log_action` varchar(255) DEFAULT NULL,
  `log_time` varchar(255) DEFAULT NULL,
  `log_user` datetime DEFAULT NULL,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `persetujuan`
--
ALTER TABLE `persetujuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transfer`
--
ALTER TABLE `transfer`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `persetujuan`
--
ALTER TABLE `persetujuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `transfer`
--
ALTER TABLE `transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
