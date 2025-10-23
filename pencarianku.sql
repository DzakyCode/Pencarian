-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 23, 2025 at 04:53 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pencarianku`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `created_at`) VALUES
(1, 'admin', 'admin123', '2025-10-23 01:42:25');

-- --------------------------------------------------------

--
-- Table structure for table `jenis_pemerintahan`
--

CREATE TABLE `jenis_pemerintahan` (
  `id_pemerintahan` int(11) NOT NULL,
  `id_negara` int(11) NOT NULL,
  `sistem_pemerintahan` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jenis_pemerintahan`
--

INSERT INTO `jenis_pemerintahan` (`id_pemerintahan`, `id_negara`, `sistem_pemerintahan`, `created_at`, `deleted_at`, `deleted_by`) VALUES
(10, 14, 'Republik Federal', '2025-10-23 02:34:59', NULL, NULL),
(11, 15, 'Monarki Konstitusional', '2025-10-23 02:36:59', NULL, NULL),
(12, 13, 'Republik Presidensial', '2025-10-23 02:37:43', NULL, NULL),
(13, 16, 'Monarki Konstitusional', '2025-10-23 02:37:55', NULL, NULL),
(14, 17, 'Republik Semi-Presidensial', '2025-10-23 02:38:05', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `kota`
--

CREATE TABLE `kota` (
  `id_kota` int(11) NOT NULL,
  `id_provinsi` int(11) NOT NULL,
  `nama_kota` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kota`
--

INSERT INTO `kota` (`id_kota`, `id_provinsi`, `nama_kota`, `created_at`, `deleted_at`, `deleted_by`) VALUES
(26, 16, 'Los Angeles', '2025-10-23 02:34:15', NULL, NULL),
(27, 16, 'San Francisco', '2025-10-23 02:34:23', NULL, NULL),
(28, 17, 'Dallas', '2025-10-23 02:34:40', NULL, NULL),
(29, 17, 'Houston', '2025-10-23 02:34:48', NULL, NULL),
(30, 18, 'Newcastle', '2025-10-23 02:35:42', NULL, NULL),
(31, 18, 'Sydney', '2025-10-23 02:35:53', NULL, NULL),
(32, 19, 'Bandung', '2025-10-23 02:36:22', NULL, NULL),
(33, 19, 'Bekasi', '2025-10-23 02:36:30', NULL, NULL),
(34, 19, 'Depok', '2025-10-23 02:36:37', NULL, NULL),
(35, 20, 'Magelang', '2025-10-23 02:39:55', NULL, NULL),
(36, 20, 'Surabaya', '2025-10-23 02:40:02', NULL, NULL),
(37, 20, 'Surakarta', '2025-10-23 02:40:10', NULL, NULL),
(38, 21, 'Jayapura', '2025-10-23 02:41:41', NULL, NULL),
(39, 21, 'Timika', '2025-10-23 02:41:48', NULL, NULL),
(40, 22, 'Sapporo', '2025-10-23 02:42:09', NULL, NULL),
(41, 23, 'Sinjuku', '2025-10-23 02:42:19', NULL, NULL),
(42, 24, 'Paris', '2025-10-23 02:42:51', NULL, NULL),
(43, 24, 'Versailles', '2025-10-23 02:42:57', NULL, NULL),
(44, 25, 'Nice', '2025-10-23 02:43:10', NULL, NULL),
(45, 25, 'Marseille', '2025-10-23 02:43:16', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `negara`
--

CREATE TABLE `negara` (
  `id_negara` int(11) NOT NULL,
  `nama_negara` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `negara`
--

INSERT INTO `negara` (`id_negara`, `nama_negara`, `created_at`, `deleted_at`, `deleted_by`) VALUES
(13, 'Indonesia', '2025-10-23 02:32:18', NULL, NULL),
(14, 'Amerika Serikat', '2025-10-23 02:32:21', NULL, NULL),
(15, 'Australia', '2025-10-23 02:32:38', NULL, NULL),
(16, 'Jepang', '2025-10-23 02:32:47', NULL, NULL),
(17, 'Prancis', '2025-10-23 02:32:51', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `provinsi`
--

CREATE TABLE `provinsi` (
  `id_provinsi` int(11) NOT NULL,
  `id_negara` int(11) NOT NULL,
  `nama_provinsi` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `provinsi`
--

INSERT INTO `provinsi` (`id_provinsi`, `id_negara`, `nama_provinsi`, `created_at`, `deleted_at`, `deleted_by`) VALUES
(16, 14, 'California', '2025-10-23 02:33:36', NULL, NULL),
(17, 14, 'Texas', '2025-10-23 02:33:43', NULL, NULL),
(18, 15, 'New South Wales', '2025-10-23 02:35:31', NULL, NULL),
(19, 13, 'Jawa Barat', '2025-10-23 02:36:13', NULL, NULL),
(20, 13, 'Jawa Tengah', '2025-10-23 02:39:40', NULL, NULL),
(21, 13, 'Papua', '2025-10-23 02:40:29', NULL, NULL),
(22, 16, 'Hokkaido', '2025-10-23 02:40:44', NULL, NULL),
(23, 16, 'Tokyo', '2025-10-23 02:40:53', NULL, NULL),
(24, 17, 'Île-de-France', '2025-10-23 02:41:02', NULL, NULL),
(25, 17, 'Provence-Alpes-Côte d’Azur', '2025-10-23 02:41:15', NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `jenis_pemerintahan`
--
ALTER TABLE `jenis_pemerintahan`
  ADD PRIMARY KEY (`id_pemerintahan`),
  ADD KEY `id_negara` (`id_negara`);

--
-- Indexes for table `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`id_kota`),
  ADD KEY `id_provinsi` (`id_provinsi`);

--
-- Indexes for table `negara`
--
ALTER TABLE `negara`
  ADD PRIMARY KEY (`id_negara`);

--
-- Indexes for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD PRIMARY KEY (`id_provinsi`),
  ADD KEY `id_negara` (`id_negara`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `jenis_pemerintahan`
--
ALTER TABLE `jenis_pemerintahan`
  MODIFY `id_pemerintahan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `kota`
--
ALTER TABLE `kota`
  MODIFY `id_kota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `negara`
--
ALTER TABLE `negara`
  MODIFY `id_negara` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `provinsi`
--
ALTER TABLE `provinsi`
  MODIFY `id_provinsi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `jenis_pemerintahan`
--
ALTER TABLE `jenis_pemerintahan`
  ADD CONSTRAINT `jenis_pemerintahan_ibfk_1` FOREIGN KEY (`id_negara`) REFERENCES `negara` (`id_negara`) ON DELETE CASCADE;

--
-- Constraints for table `kota`
--
ALTER TABLE `kota`
  ADD CONSTRAINT `kota_ibfk_1` FOREIGN KEY (`id_provinsi`) REFERENCES `provinsi` (`id_provinsi`) ON DELETE CASCADE;

--
-- Constraints for table `provinsi`
--
ALTER TABLE `provinsi`
  ADD CONSTRAINT `provinsi_ibfk_1` FOREIGN KEY (`id_negara`) REFERENCES `negara` (`id_negara`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
