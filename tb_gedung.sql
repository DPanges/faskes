-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2024 at 10:01 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_gedung`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_gedung`
--

CREATE TABLE `tb_gedung` (
  `id` int(11) NOT NULL,
  `gedung` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `lantai` varchar(255) NOT NULL,
  `opd` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_gedung`
--

INSERT INTO `tb_gedung` (`id`, `gedung`, `unit`, `lantai`, `opd`, `latitude`, `longitude`) VALUES
(7, 'Gedung A', 'Unit 1', 'Lantai 1', 'Biro Administrasi Pembangunan\r\n', '-0.061974', '109.353389'),
(8, 'Gedung A', 'Unit 1', 'Lantai 2', 'Asisten II,\r\nStaf Ahli,\r\nBiro Administrasi Pimpinan', '-0.061789', '109.353240'),
(9, 'Gedung A', 'UNIT 1', 'Lantai 3', 'Biro Pengadaan Barang dan Jasa', '-0.061598', '109.353152 '),
(10, 'Gedung A', 'Unit 2', 'Lantai 1', 'Asisten III,\r\nBiro Administrasi Pimpinan,\r\nBiro Umum,', '-0.061297', '109.352848');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_gedung`
--
ALTER TABLE `tb_gedung`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_gedung`
--
ALTER TABLE `tb_gedung`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
