-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 06, 2023 at 01:45 AM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sikendis`
--

-- --------------------------------------------------------

--
-- Table structure for table `asal_usul`
--

CREATE TABLE `asal_usul` (
  `id` tinyint(2) UNSIGNED NOT NULL,
  `keterangan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Master asal usul kendaraan';

--
-- Dumping data for table `asal_usul`
--

INSERT INTO `asal_usul` (`id`, `keterangan`) VALUES
(1, 'Pembelian'),
(2, 'Hibah');

-- --------------------------------------------------------

--
-- Table structure for table `bahan_bakar`
--

CREATE TABLE `bahan_bakar` (
  `id` tinyint(2) UNSIGNED NOT NULL,
  `keterangan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Master jenis bahan bakar kendaraan';

--
-- Dumping data for table `bahan_bakar`
--

INSERT INTO `bahan_bakar` (`id`, `keterangan`) VALUES
(1, 'Bensin'),
(2, 'Solar');

-- --------------------------------------------------------

--
-- Table structure for table `kelompok`
--

CREATE TABLE `kelompok` (
  `id` tinyint(2) UNSIGNED NOT NULL,
  `keterangan` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Master kelompok kendaraan';

--
-- Dumping data for table `kelompok`
--

INSERT INTO `kelompok` (`id`, `keterangan`) VALUES
(1, 'Kendaraan Rutin'),
(2, 'Kendaraan Operasional');

-- --------------------------------------------------------

--
-- Table structure for table `kendaraan`
--

CREATE TABLE `kendaraan` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `kd_aset` varchar(30) NOT NULL,
  `nama_aset` varchar(100) NOT NULL,
  `noreg` smallint(4) UNSIGNED DEFAULT NULL,
  `merk` varchar(50) NOT NULL,
  `ukuran_cc` smallint(6) UNSIGNED DEFAULT NULL,
  `bahan` varchar(30) DEFAULT NULL,
  `th_beli` smallint(4) UNSIGNED NOT NULL,
  `no_rangka` varchar(30) NOT NULL,
  `no_mesin` varchar(30) NOT NULL,
  `no_polisi` varchar(30) DEFAULT NULL,
  `no_bpkb` varchar(30) DEFAULT NULL,
  `roda_id` tinyint(2) UNSIGNED NOT NULL,
  `asal_usul_id` tinyint(2) UNSIGNED DEFAULT NULL,
  `bahan_bakar_id` tinyint(2) UNSIGNED DEFAULT NULL,
  `warna` varchar(20) DEFAULT NULL,
  `harga` decimal(15,2) UNSIGNED NOT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `photo_stnk` varchar(100) DEFAULT NULL,
  `photo_bpkb` varchar(100) DEFAULT NULL,
  `keterangan` varchar(255) DEFAULT NULL,
  `kelompok_id` tinyint(2) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Master kendaraan';

--
-- Dumping data for table `kendaraan`
--

INSERT INTO `kendaraan` (`id`, `kd_aset`, `nama_aset`, `noreg`, `merk`, `ukuran_cc`, `bahan`, `th_beli`, `no_rangka`, `no_mesin`, `no_polisi`, `no_bpkb`, `roda_id`, `asal_usul_id`, `bahan_bakar_id`, `warna`, `harga`, `photo`, `photo_stnk`, `photo_bpkb`, `keterangan`, `kelompok_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '02.03.01.01.03', 'Station Wagon', 0, 'Toyota / New Camry 3,5 Q A/T', 3456, 'BESI/METAL', 2010, 'MR053KK4DA9002312', '2GR-0757779', 'DN 1', 'I 05011518 S1', 3, 1, 1, '', '670500000.00', NULL, NULL, NULL, '', 1, '2023-03-25 14:16:03', '2023-03-25 14:16:03', NULL),
(3, '02.03.01.01.03', 'Station Wagon', 0, 'Toyota / Fortuner 2.5 G M/T', 2700, 'BESI/METAL', 2006, 'MR0YX59GX60010024', '2TR6233147', 'DN 97 ', '8890002-S1', 3, 1, 1, '', '440000000.00', NULL, NULL, NULL, '', 2, '2023-03-25 14:25:43', '2023-03-25 14:25:43', NULL),
(4, '02.03.01.01.03', 'Station Wagon', 0, 'Toyota Camry 2.400 AT', 2362, 'BESI/METAL', 2006, 'MR053BK3065502576', '2AZ -3238568', 'DN 203 ', 'M 05143923 S1', 3, 1, 1, '', '372000000.00', 'public/repository/kendaraan/photo-kendaraan-1684227087_a8fb1e722e078d397e97.png', NULL, NULL, '', 2, '2023-03-25 14:39:51', '2023-05-16 16:51:27', NULL),
(5, '02.03.01.01.03', 'Station Wagon', 0, 'TOYOTA VOXI', 0, 'BESI/METAL', 2019, 'T7XRB80K7017426', '3ZR-C557410', 'DN 1390 ST', '', 3, 1, 1, '', '489000000.00', 'public/repository/kendaraan/photo-kendaraan-1684225927_216f058e23fa14e04513.png', NULL, NULL, '', 2, '2023-03-25 14:42:55', '2023-05-16 16:32:07', NULL),
(6, '02.03.01.01.03', 'Station Wagon', 0, 'SUZUKI JB 420-GRAND VITARA JLX MT', 0, '', 2007, 'MHYJTE54V7J103934', '120AID207057', 'DN 1261 ST', '-', 3, 1, 1, '', '0.00', NULL, NULL, NULL, '', 1, '2023-04-04 14:39:36', '2023-04-04 14:39:36', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `opd`
--

CREATE TABLE `opd` (
  `id` tinyint(2) UNSIGNED NOT NULL,
  `kd_opd` varchar(11) NOT NULL,
  `nm_opd` varchar(100) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Master OPD';

--
-- Dumping data for table `opd`
--

INSERT INTO `opd` (`id`, `kd_opd`, `nm_opd`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '04.01.01.01', 'Sekretariat Daerah Sulawesi Tengah', '2023-03-15 23:42:46', '2023-03-15 23:42:46', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman_operasional`
--

CREATE TABLE `peminjaman_operasional` (
  `id` int(11) UNSIGNED NOT NULL,
  `kendaraan_id` smallint(6) UNSIGNED NOT NULL,
  `instansi` varchar(100) NOT NULL,
  `penanggung_jawab` varchar(50) NOT NULL,
  `no_telp` varchar(15) NOT NULL,
  `no_disposisi` varchar(50) DEFAULT NULL,
  `tgl_disposisi` date DEFAULT NULL,
  `file_disposisi` varchar(100) DEFAULT NULL,
  `no_permohonan` varchar(50) DEFAULT NULL,
  `tgl_permohonan` date DEFAULT NULL,
  `file_permohonan` varchar(100) DEFAULT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='History peminjaman operasional kendaraan';

--
-- Dumping data for table `peminjaman_operasional`
--

INSERT INTO `peminjaman_operasional` (`id`, `kendaraan_id`, `instansi`, `penanggung_jawab`, `no_telp`, `no_disposisi`, `tgl_disposisi`, `file_disposisi`, `no_permohonan`, `tgl_permohonan`, `file_permohonan`, `tgl_mulai`, `tgl_selesai`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 3, 'instansi', 'hendi', '081234567890', '', '0000-00-00', NULL, '', '0000-00-00', NULL, '2023-05-02', '2023-05-04', '2023-05-02 17:23:42', '2023-05-02 17:23:42', NULL),
(4, 3, 'instansi a', 'as', '0812', '', '0000-00-00', NULL, '', '0000-00-00', NULL, '2023-05-09', '2023-05-16', '2023-05-02 17:24:14', '2023-05-02 17:24:14', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna`
--

CREATE TABLE `pengguna` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `nip` varchar(21) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `jabatan` varchar(50) NOT NULL,
  `unit_id` smallint(5) UNSIGNED NOT NULL,
  `sub_bagian` varchar(100) DEFAULT NULL,
  `no_telp` varchar(15) NOT NULL,
  `alamat` varchar(200) DEFAULT NULL,
  `photo` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Master pengguna kendaraan';

--
-- Dumping data for table `pengguna`
--

INSERT INTO `pengguna` (`id`, `nip`, `nama_lengkap`, `jabatan`, `unit_id`, `sub_bagian`, `no_telp`, `alamat`, `photo`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '196603122006041014', 'A R I S T E N', 'STAF', 1, '-', '082271121633', NULL, NULL, '2023-03-27 10:04:27', '2023-03-27 10:04:48', NULL),
(2, '196604101988031023', 'A S G A R, S.SOS', 'KASUBAG', 1, '-', '082271121633', NULL, 'public/repository/pengguna/196604101988031023.png', '2023-03-27 10:05:54', '2023-04-02 17:24:08', NULL),
(4, '196608102007012033', 'AGUSTIEN SUMAMPOW', 'STAF', 1, '-', '0', NULL, NULL, '2023-03-31 16:36:08', '2023-03-31 16:36:08', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `pengguna_rutin`
--

CREATE TABLE `pengguna_rutin` (
  `id` int(11) UNSIGNED NOT NULL,
  `kendaraan_id` smallint(6) UNSIGNED NOT NULL,
  `pengguna_id` smallint(6) UNSIGNED NOT NULL,
  `no_bap` varchar(50) NOT NULL,
  `tgl_bap` date NOT NULL,
  `file_bap` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='History penggunaan rutin kendaraan';

--
-- Dumping data for table `pengguna_rutin`
--

INSERT INTO `pengguna_rutin` (`id`, `kendaraan_id`, `pengguna_id`, `no_bap`, `tgl_bap`, `file_bap`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 1, 4, '1/GJDHGFJSD', '2023-04-05', 'public/repository/pengguna-rutin/file-bap-1681256773_a3c968f09932e3c267ec.pdf', '2023-04-12 07:46:13', '2023-04-12 07:46:13', NULL),
(4, 1, 2, '2/TES', '2023-05-01', 'public/repository/pengguna-rutin/file-bap-1682929542_90a8ef5f01d54220572a.pdf', '2023-05-01 16:25:42', '2023-05-01 16:25:42', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `roda`
--

CREATE TABLE `roda` (
  `id` tinyint(2) UNSIGNED NOT NULL,
  `keterangan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Master jenis roda kendaraan';

--
-- Dumping data for table `roda`
--

INSERT INTO `roda` (`id`, `keterangan`) VALUES
(1, 'Roda 2'),
(2, 'Roda 3'),
(3, 'Roda 4');

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `kd_unit` varchar(15) NOT NULL,
  `nm_unit` varchar(100) NOT NULL,
  `opd_id` tinyint(2) UNSIGNED NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Master unit/biro';

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `kd_unit`, `nm_unit`, `opd_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '04.01.01.01.013', 'BIRO UMUM SETDA PROV.SULTENG', 1, '2023-03-15 23:45:32', '2023-03-15 23:45:32', NULL),
(2, '04.01.01.01.014', 'BIRO TES', 1, '2023-05-10 17:40:39', '2023-05-10 17:40:39', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` smallint(6) UNSIGNED NOT NULL,
  `user_name` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `nama_lengkap` varchar(50) NOT NULL,
  `keterangan` varchar(50) DEFAULT NULL,
  `level_id` tinyint(2) UNSIGNED NOT NULL,
  `unit_id` smallint(5) DEFAULT NULL COMMENT 'Unit / Biro',
  `is_active` char(1) NOT NULL DEFAULT 'T' COMMENT 'T/F',
  `is_login` char(1) NOT NULL DEFAULT 'F' COMMENT 'T/F',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Master user';

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `user_name`, `password`, `nama_lengkap`, `keterangan`, `level_id`, `unit_id`, `is_active`, `is_login`, `last_login`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'admin', '$2y$10$EIlgugnz2Qn1FiKs6G1hiegzmHwZ4Vkm4P8Rucjs4s4Br4IvuZBzy', 'Admin', 'Administrator', 0, NULL, 'T', 'F', '2023-06-27 23:01:03', '2023-03-03 06:52:06', '2023-06-27 23:02:10', NULL),
(2, 'hendi', '$2y$10$EIlgugnz2Qn1FiKs6G1hiegzmHwZ4Vkm4P8Rucjs4s4Br4IvuZBzy', 'Ruhaendi', 'Pejabat', 1, 1, 'T', 'F', '2023-05-15 15:09:29', '2023-03-10 10:21:26', '2023-05-15 15:09:36', NULL),
(4, 'sa', '$2y$10$EIlgugnz2Qn1FiKs6G1hiegzmHwZ4Vkm4P8Rucjs4s4Br4IvuZBzy', 'Super Admin', '', 0, 0, 'F', 'F', NULL, '2023-03-19 15:08:26', '2023-03-19 15:11:39', NULL),
(5, 'ihsan', '$2y$10$EIlgugnz2Qn1FiKs6G1hiegzmHwZ4Vkm4P8Rucjs4s4Br4IvuZBzy', 'M Ihsan', '', 2, 1, 'T', 'F', '2023-05-11 17:36:17', '2023-05-09 15:19:49', '2023-05-11 17:37:19', NULL),
(6, 'yati', '$2y$10$EIlgugnz2Qn1FiKs6G1hiegzmHwZ4Vkm4P8Rucjs4s4Br4IvuZBzy', 'Nurhayati', '', 2, 2, 'T', 'F', '2023-05-15 15:04:49', '2023-05-11 00:07:22', '2023-05-15 15:09:18', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_level`
--

CREATE TABLE `user_level` (
  `id` tinyint(2) UNSIGNED NOT NULL,
  `keterangan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Master level user';

--
-- Dumping data for table `user_level`
--

INSERT INTO `user_level` (`id`, `keterangan`) VALUES
(0, 'Administrator'),
(1, 'Pejabat'),
(2, 'Operator');

-- --------------------------------------------------------

--
-- Table structure for table `user_log`
--

CREATE TABLE `user_log` (
  `id` int(11) NOT NULL,
  `user_id` smallint(6) NOT NULL,
  `reflog_id` tinyint(2) DEFAULT NULL,
  `keterangan` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Log aktifitas user';

--
-- Dumping data for table `user_log`
--

INSERT INTO `user_log` (`id`, `user_id`, `reflog_id`, `keterangan`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-05 09:43:44', '2023-03-05 09:43:44', NULL),
(2, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-05 09:44:17', '2023-03-05 09:44:17', NULL),
(3, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-05 09:54:38', '2023-03-05 09:54:38', NULL),
(4, 1, 2, 'Logout sebagai admin', '2023-03-05 10:04:35', '2023-03-05 10:04:35', NULL),
(5, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-05 10:06:30', '2023-03-05 10:06:30', NULL),
(6, 1, 2, 'Logout sebagai admin', '2023-03-05 10:21:13', '2023-03-05 10:21:13', NULL),
(7, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-05 10:21:19', '2023-03-05 10:21:19', NULL),
(8, 1, 2, 'Logout sebagai admin', '2023-03-05 10:44:25', '2023-03-05 10:44:25', NULL),
(9, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-07 10:21:36', '2023-03-07 10:21:36', NULL),
(10, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-08 07:33:09', '2023-03-08 07:33:09', NULL),
(11, 1, 2, 'Logout sebagai admin', '2023-03-08 07:35:18', '2023-03-08 07:35:18', NULL),
(12, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-08 07:35:27', '2023-03-08 07:35:27', NULL),
(13, 1, 2, 'Logout sebagai admin', '2023-03-08 07:36:20', '2023-03-08 07:36:20', NULL),
(14, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-08 07:39:50', '2023-03-08 07:39:50', NULL),
(15, 1, 2, 'Logout sebagai admin', '2023-03-08 08:20:07', '2023-03-08 08:20:07', NULL),
(16, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-08 08:22:16', '2023-03-08 08:22:16', NULL),
(17, 1, 4, 'Ubah password.', '2023-03-08 08:30:15', '2023-03-08 08:30:15', NULL),
(18, 1, 2, 'Logout sebagai admin', '2023-03-08 08:30:21', '2023-03-08 08:30:21', NULL),
(19, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-08 08:30:32', '2023-03-08 08:30:32', NULL),
(20, 1, 2, 'Logout sebagai admin', '2023-03-08 08:30:36', '2023-03-08 08:30:36', NULL),
(21, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-08 08:54:37', '2023-03-08 08:54:37', NULL),
(22, 1, 4, 'Ubah password.', '2023-03-08 08:54:54', '2023-03-08 08:54:54', NULL),
(23, 1, 2, 'Logout sebagai admin', '2023-03-08 08:54:56', '2023-03-08 08:54:56', NULL),
(24, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-08 08:59:55', '2023-03-08 08:59:55', NULL),
(25, 1, 2, 'Logout sebagai admin', '2023-03-08 09:38:13', '2023-03-08 09:38:13', NULL),
(26, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-08 09:38:29', '2023-03-08 09:38:29', NULL),
(27, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-10 08:51:56', '2023-03-10 08:51:56', NULL),
(28, 2, 1, 'Login sebagai hendi dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-10 10:22:00', '2023-03-10 10:22:00', NULL),
(29, 2, 2, 'Logout sebagai hendi', '2023-03-10 10:41:57', '2023-03-10 10:41:57', NULL),
(30, 2, 1, 'Login sebagai hendi dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-10 10:44:22', '2023-03-10 10:44:22', NULL),
(31, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-10 10:44:47', '2023-03-10 10:44:47', NULL),
(32, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-10 10:46:26', '2023-03-10 10:46:26', NULL),
(33, 1, 2, 'Logout sebagai admin', '2023-03-10 10:48:04', '2023-03-10 10:48:04', NULL),
(34, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-10 10:48:15', '2023-03-10 10:48:15', NULL),
(35, 1, 2, 'Logout sebagai admin', '2023-03-10 10:48:27', '2023-03-10 10:48:27', NULL),
(36, 2, 1, 'Login sebagai hendi dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-10 10:48:34', '2023-03-10 10:48:34', NULL),
(37, 2, 1, 'Login sebagai hendi dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-10 10:51:39', '2023-03-10 10:51:39', NULL),
(38, 2, 2, 'Logout sebagai hendi', '2023-03-10 10:51:44', '2023-03-10 10:51:44', NULL),
(39, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-10 10:52:01', '2023-03-10 10:52:01', NULL),
(40, 1, 2, 'Logout sebagai admin', '2023-03-10 10:58:57', '2023-03-10 10:58:57', NULL),
(41, 2, 1, 'Login sebagai hendi dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-10 10:59:03', '2023-03-10 10:59:03', NULL),
(42, 2, 2, 'Logout sebagai hendi', '2023-03-10 11:41:30', '2023-03-10 11:41:30', NULL),
(43, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-10 14:06:43', '2023-03-10 14:06:43', NULL),
(44, 1, 2, 'Logout sebagai admin', '2023-03-10 14:23:49', '2023-03-10 14:23:49', NULL),
(45, 2, 1, 'Login sebagai hendi dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-10 14:23:52', '2023-03-10 14:23:52', NULL),
(46, 2, 2, 'Logout sebagai hendi', '2023-03-10 15:17:15', '2023-03-10 15:17:15', NULL),
(47, 1, 1, 'Login sebagai admin dengan Chrome 110.0.0.0 (Linux) IP. ::1', '2023-03-10 15:17:19', '2023-03-10 15:17:19', NULL),
(48, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-13 14:24:09', '2023-03-13 14:24:09', NULL),
(49, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-14 06:34:53', '2023-03-14 06:34:53', NULL),
(50, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-14 10:02:23', '2023-03-14 10:02:23', NULL),
(51, 1, 3, 'Add OPD, ID 3', '2023-03-14 17:45:37', '2023-03-14 17:45:37', NULL),
(52, 1, 4, 'Edit OPD, ID 3', '2023-03-14 17:49:44', '2023-03-14 17:49:44', NULL),
(53, 1, 5, 'Delete OPD, ID 3', '2023-03-14 18:09:30', '2023-03-14 18:09:30', NULL),
(54, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-15 08:32:43', '2023-03-15 08:32:43', NULL),
(55, 1, 3, 'Add OPD, ID 1', '2023-03-15 08:41:07', '2023-03-15 08:41:07', NULL),
(56, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-15 14:45:12', '2023-03-15 14:45:12', NULL),
(57, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-15 22:19:35', '2023-03-15 22:19:35', NULL),
(58, 1, 3, 'Add Unit, ID 5', '2023-03-15 23:09:08', '2023-03-15 23:09:08', NULL),
(59, 1, 4, 'Edit Unit, ID 5', '2023-03-15 23:18:24', '2023-03-15 23:18:24', NULL),
(60, 1, 4, 'Edit Unit, ID 5', '2023-03-15 23:27:15', '2023-03-15 23:27:15', NULL),
(61, 1, 5, 'Delete Unit, ID 2', '2023-03-15 23:33:32', '2023-03-15 23:33:32', NULL),
(62, 1, 5, 'Delete Unit, ID 1', '2023-03-15 23:33:44', '2023-03-15 23:33:44', NULL),
(63, 1, 5, 'Delete OPD, ID 1', '2023-03-15 23:41:52', '2023-03-15 23:41:52', NULL),
(64, 1, 3, 'Add OPD, ID 1', '2023-03-15 23:42:46', '2023-03-15 23:42:46', NULL),
(65, 1, 3, 'Add Unit, ID 1', '2023-03-15 23:45:32', '2023-03-15 23:45:32', NULL),
(66, 1, 2, 'Logout sebagai admin', '2023-03-15 23:48:55', '2023-03-15 23:48:55', NULL),
(67, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-18 07:11:23', '2023-03-18 07:11:23', NULL),
(68, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-18 10:08:25', '2023-03-18 10:08:25', NULL),
(69, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-18 14:21:36', '2023-03-18 14:21:36', NULL),
(70, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-19 14:01:27', '2023-03-19 14:01:27', NULL),
(71, 1, 3, 'Add User, ID 3', '2023-03-19 14:51:33', '2023-03-19 14:51:33', NULL),
(72, 1, 4, 'Edit User, ID 3', '2023-03-19 14:52:02', '2023-03-19 14:52:02', NULL),
(73, 1, 4, 'Edit User, ID 3', '2023-03-19 14:53:29', '2023-03-19 14:53:29', NULL),
(74, 1, 4, 'Edit User, ID 3', '2023-03-19 14:54:02', '2023-03-19 14:54:02', NULL),
(75, 1, 3, 'Add User, ID 4', '2023-03-19 15:08:26', '2023-03-19 15:08:26', NULL),
(76, 1, 4, 'Reset password User, ID 4', '2023-03-19 15:11:33', '2023-03-19 15:11:33', NULL),
(77, 1, 4, 'User dinonaktifkan, ID 4', '2023-03-19 15:11:39', '2023-03-19 15:11:39', NULL),
(78, 1, 4, 'Logout paksa User, ID 1', '2023-03-19 15:11:50', '2023-03-19 15:11:50', NULL),
(79, 1, 2, 'Logout sebagai admin', '2023-03-19 15:11:59', '2023-03-19 15:11:59', NULL),
(80, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-19 15:12:22', '2023-03-19 15:12:22', NULL),
(81, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-20 06:09:53', '2023-03-20 06:09:53', NULL),
(82, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-20 14:31:34', '2023-03-20 14:31:34', NULL),
(83, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-21 11:18:19', '2023-03-21 11:18:19', NULL),
(84, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-21 15:00:25', '2023-03-21 15:00:25', NULL),
(85, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-22 14:13:46', '2023-03-22 14:13:46', NULL),
(86, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-23 15:56:07', '2023-03-23 15:56:07', NULL),
(87, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-24 06:28:14', '2023-03-24 06:28:14', NULL),
(88, 1, 3, 'Add Kendaraan, ID 1', '2023-03-24 07:38:09', '2023-03-24 07:38:09', NULL),
(89, 1, 4, 'Edit Kendaraan, ID 1', '2023-03-24 07:44:29', '2023-03-24 07:44:29', NULL),
(90, 1, 4, 'Edit Kendaraan, ID 1', '2023-03-24 07:45:23', '2023-03-24 07:45:23', NULL),
(91, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-24 13:31:12', '2023-03-24 13:31:12', NULL),
(92, 1, 3, 'Add Kendaraan, ID 2', '2023-03-24 14:22:51', '2023-03-24 14:22:51', NULL),
(93, 1, 4, 'Edit Kendaraan, ID 2', '2023-03-24 15:07:06', '2023-03-24 15:07:06', NULL),
(94, 1, 4, 'Edit Kendaraan, ID 2', '2023-03-24 15:08:52', '2023-03-24 15:08:52', NULL),
(95, 1, 4, 'Edit Kendaraan, ID 2', '2023-03-24 15:15:50', '2023-03-24 15:15:50', NULL),
(96, 1, 4, 'Edit Kendaraan, ID 2', '2023-03-24 15:17:18', '2023-03-24 15:17:18', NULL),
(97, 1, 4, 'Edit Kendaraan, ID 2', '2023-03-24 15:20:45', '2023-03-24 15:20:45', NULL),
(98, 1, 5, 'Delete Kendaraan, ID 2', '2023-03-24 16:00:49', '2023-03-24 16:00:49', NULL),
(99, 1, 4, 'Edit Kendaraan, ID 1', '2023-03-24 16:01:19', '2023-03-24 16:01:19', NULL),
(100, 1, 4, 'Edit Kendaraan, ID 1', '2023-03-24 16:02:03', '2023-03-24 16:02:03', NULL),
(101, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-25 14:08:48', '2023-03-25 14:08:48', NULL),
(102, 1, 5, 'Delete Kendaraan, ID 1', '2023-03-25 14:09:40', '2023-03-25 14:09:40', NULL),
(103, 1, 3, 'Add Kendaraan, ID 1', '2023-03-25 14:16:03', '2023-03-25 14:16:03', NULL),
(104, 1, 3, 'Add Kendaraan, ID 2', '2023-03-25 14:18:58', '2023-03-25 14:18:58', NULL),
(105, 1, 3, 'Add Kendaraan, ID 3', '2023-03-25 14:25:43', '2023-03-25 14:25:43', NULL),
(106, 1, 3, 'Add Kendaraan, ID 4', '2023-03-25 14:39:51', '2023-03-25 14:39:51', NULL),
(107, 1, 3, 'Add Kendaraan, ID 5', '2023-03-25 14:42:55', '2023-03-25 14:42:55', NULL),
(108, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-26 14:43:58', '2023-03-26 14:43:58', NULL),
(109, 1, 3, 'Add Pengguna, ID 1', '2023-03-26 17:34:42', '2023-03-26 17:34:42', NULL),
(110, 1, 4, 'Edit Pengguna, ID 1', '2023-03-26 17:44:05', '2023-03-26 17:44:05', NULL),
(111, 1, 3, 'Add Pengguna, ID 2', '2023-03-26 17:44:57', '2023-03-26 17:44:57', NULL),
(112, 1, 4, 'Edit Pengguna, ID 1', '2023-03-26 17:57:02', '2023-03-26 17:57:02', NULL),
(113, 1, 4, 'Edit Pengguna, ID 2', '2023-03-26 17:57:20', '2023-03-26 17:57:20', NULL),
(114, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-27 08:30:15', '2023-03-27 08:30:15', NULL),
(115, 1, 3, 'Add Pengguna, ID 3', '2023-03-27 09:46:51', '2023-03-27 09:46:51', NULL),
(116, 1, 5, 'Delete Pengguna, ID 2', '2023-03-27 09:52:04', '2023-03-27 09:52:04', NULL),
(117, 1, 5, 'Delete Pengguna, ID 3', '2023-03-27 09:52:47', '2023-03-27 09:52:47', NULL),
(118, 1, 5, 'Delete Pengguna, ID 1', '2023-03-27 09:53:19', '2023-03-27 09:53:19', NULL),
(119, 1, 3, 'Add Pengguna, ID 1', '2023-03-27 10:04:27', '2023-03-27 10:04:27', NULL),
(120, 1, 4, 'Edit Pengguna, ID 1', '2023-03-27 10:04:48', '2023-03-27 10:04:48', NULL),
(121, 1, 3, 'Add Pengguna, ID 2', '2023-03-27 10:05:54', '2023-03-27 10:05:54', NULL),
(122, 1, 3, 'Add Pengguna, ID 3', '2023-03-27 10:07:03', '2023-03-27 10:07:03', NULL),
(123, 1, 5, 'Delete Pengguna, ID 3', '2023-03-27 10:17:36', '2023-03-27 10:17:36', NULL),
(124, 1, 2, 'Logout sebagai admin', '2023-03-27 11:11:04', '2023-03-27 11:11:04', NULL),
(125, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-27 11:11:42', '2023-03-27 11:11:42', NULL),
(126, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-28 08:59:00', '2023-03-28 08:59:00', NULL),
(127, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-29 08:54:48', '2023-03-29 08:54:48', NULL),
(128, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-29 16:36:32', '2023-03-29 16:36:32', NULL),
(129, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-30 08:01:42', '2023-03-30 08:01:42', NULL),
(130, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-03-31 16:28:43', '2023-03-31 16:28:43', NULL),
(131, 1, 3, 'Add Pengguna, ID 4', '2023-03-31 16:36:08', '2023-03-31 16:36:08', NULL),
(132, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-04-01 17:26:01', '2023-04-01 17:26:01', NULL),
(133, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-04-02 14:03:28', '2023-04-02 14:03:28', NULL),
(134, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-04-02 16:51:53', '2023-04-02 16:51:53', NULL),
(135, 1, 4, 'Edit Pengguna, ID 2', '2023-04-02 17:24:08', '2023-04-02 17:24:08', NULL),
(136, 1, 3, 'Add Pengguna Rutin, ID 1', '2023-04-02 17:31:12', '2023-04-02 17:31:12', NULL),
(137, 1, 3, 'Add Pengguna Rutin, ID 2', '2023-04-02 17:33:32', '2023-04-02 17:33:32', NULL),
(138, 1, 4, 'Edit Pengguna Rutin, ID 1', '2023-04-02 17:49:03', '2023-04-02 17:49:03', NULL),
(139, 1, 4, 'Edit Pengguna Rutin, ID 2', '2023-04-02 17:54:02', '2023-04-02 17:54:02', NULL),
(140, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-04-04 14:31:07', '2023-04-04 14:31:07', NULL),
(141, 1, 5, 'Delete Kendaraan, ID 2', '2023-04-04 14:33:04', '2023-04-04 14:33:04', NULL),
(142, 1, 3, 'Add Kendaraan, ID 6', '2023-04-04 14:39:36', '2023-04-04 14:39:36', NULL),
(143, 1, 5, 'Delete Pengguna Rutin, ID 2', '2023-04-04 15:17:27', '2023-04-04 15:17:27', NULL),
(144, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-04-06 06:32:36', '2023-04-06 06:32:36', NULL),
(145, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-04-10 08:15:41', '2023-04-10 08:15:41', NULL),
(146, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-04-11 08:08:40', '2023-04-11 08:08:40', NULL),
(147, 1, 3, 'Add Peminjaman Operasional, ID 1', '2023-04-11 10:07:05', '2023-04-11 10:07:05', NULL),
(148, 1, 4, 'Edit Peminjaman Operasional, ID 1', '2023-04-11 11:45:10', '2023-04-11 11:45:10', NULL),
(149, 1, 1, 'Login sebagai admin dengan Chrome 111.0.0.0 (Linux) IP. ::1', '2023-04-11 17:56:09', '2023-04-11 17:56:09', NULL),
(150, 1, 4, 'Edit Peminjaman Operasional, ID 1', '2023-04-11 17:56:54', '2023-04-11 17:56:54', NULL),
(151, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-04-12 06:08:45', '2023-04-12 06:08:45', NULL),
(152, 1, 3, 'Add Peminjaman Operasional, ID 2', '2023-04-12 06:35:31', '2023-04-12 06:35:31', NULL),
(153, 1, 4, 'Edit Peminjaman Operasional, ID 2', '2023-04-12 06:51:46', '2023-04-12 06:51:46', NULL),
(154, 1, 4, 'Edit Peminjaman Operasional, ID 1', '2023-04-12 06:55:31', '2023-04-12 06:55:31', NULL),
(155, 1, 5, 'Delete Peminjaman Operasional, ID 1', '2023-04-12 07:23:18', '2023-04-12 07:23:18', NULL),
(156, 1, 5, 'Delete Peminjaman Operasional, ID 2', '2023-04-12 07:23:29', '2023-04-12 07:23:29', NULL),
(157, 1, 5, 'Delete Pengguna Rutin, ID 1', '2023-04-12 07:42:49', '2023-04-12 07:42:49', NULL),
(158, 1, 3, 'Add Pengguna Rutin, ID 3', '2023-04-12 07:46:13', '2023-04-12 07:46:13', NULL),
(159, 1, 3, 'Add Kendaraan, ID 7', '2023-04-12 07:52:42', '2023-04-12 07:52:42', NULL),
(160, 1, 5, 'Delete Kendaraan, ID 7', '2023-04-12 07:53:16', '2023-04-12 07:53:16', NULL),
(161, 1, 3, 'Add Kendaraan, ID 8', '2023-04-12 08:12:15', '2023-04-12 08:12:15', NULL),
(162, 1, 3, 'Add Kendaraan, ID 9', '2023-04-12 08:38:41', '2023-04-12 08:38:41', NULL),
(163, 1, 5, 'Delete Kendaraan, ID 8', '2023-04-12 08:38:59', '2023-04-12 08:38:59', NULL),
(164, 1, 5, 'Delete Kendaraan, ID 9', '2023-04-12 08:39:12', '2023-04-12 08:39:12', NULL),
(165, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-04-14 15:16:59', '2023-04-14 15:16:59', NULL),
(166, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-04-14 17:40:01', '2023-04-14 17:40:01', NULL),
(167, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-04-15 16:08:20', '2023-04-15 16:08:20', NULL),
(168, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-04-16 17:11:09', '2023-04-16 17:11:09', NULL),
(169, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-04-17 14:41:50', '2023-04-17 14:41:50', NULL),
(170, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-04-28 16:03:00', '2023-04-28 16:03:00', NULL),
(171, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-04-30 16:22:34', '2023-04-30 16:22:34', NULL),
(172, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-01 16:16:31', '2023-05-01 16:16:31', NULL),
(173, 1, 3, 'Add Pengguna Rutin, ID 4', '2023-05-01 16:25:42', '2023-05-01 16:25:42', NULL),
(174, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-02 13:03:17', '2023-05-02 13:03:17', NULL),
(175, 1, 3, 'Add Peminjaman Operasional, ID 3', '2023-05-02 17:23:42', '2023-05-02 17:23:42', NULL),
(176, 1, 3, 'Add Peminjaman Operasional, ID 4', '2023-05-02 17:24:14', '2023-05-02 17:24:14', NULL),
(177, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-03 09:02:35', '2023-05-03 09:02:35', NULL),
(178, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-03 15:14:49', '2023-05-03 15:14:49', NULL),
(179, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-04 14:02:52', '2023-05-04 14:02:52', NULL),
(180, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-04 16:32:32', '2023-05-04 16:32:32', NULL),
(181, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-04 21:24:13', '2023-05-04 21:24:13', NULL),
(182, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-05 08:52:56', '2023-05-05 08:52:56', NULL),
(183, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-05 16:58:13', '2023-05-05 16:58:13', NULL),
(184, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-05 22:22:13', '2023-05-05 22:22:13', NULL),
(185, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-06 16:57:01', '2023-05-06 16:57:01', NULL),
(186, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-09 08:28:18', '2023-05-09 08:28:18', NULL),
(187, 1, 2, 'Logout sebagai admin', '2023-05-09 10:39:57', '2023-05-09 10:39:57', NULL),
(188, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-09 13:55:43', '2023-05-09 13:55:43', NULL),
(189, 1, 2, 'Logout sebagai admin', '2023-05-09 14:23:29', '2023-05-09 14:23:29', NULL),
(190, 2, 1, 'Login sebagai hendi dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-09 14:23:40', '2023-05-09 14:23:40', NULL),
(191, 2, 2, 'Logout sebagai hendi', '2023-05-09 14:57:10', '2023-05-09 14:57:10', NULL),
(192, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-09 15:04:27', '2023-05-09 15:04:27', NULL),
(193, 1, 2, 'Logout sebagai admin', '2023-05-09 15:04:56', '2023-05-09 15:04:56', NULL),
(194, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-09 15:18:32', '2023-05-09 15:18:32', NULL),
(195, 1, 3, 'Add User, ID 5', '2023-05-09 15:19:49', '2023-05-09 15:19:49', NULL),
(196, 1, 2, 'Logout sebagai admin', '2023-05-09 15:19:56', '2023-05-09 15:19:56', NULL),
(197, 5, 1, 'Login sebagai ihsan dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-09 15:20:02', '2023-05-09 15:20:02', NULL),
(198, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-09 22:02:41', '2023-05-09 22:02:41', NULL),
(199, 1, 1, 'Login sebagai admin dengan Firefox 112.0 (Linux) IP. 127.0.0.1', '2023-05-10 00:03:44', '2023-05-10 00:03:44', NULL),
(200, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-10 13:47:37', '2023-05-10 13:47:37', NULL),
(201, 1, 1, 'Login sebagai admin dengan Firefox 112.0 (Linux) IP. 127.0.0.1', '2023-05-10 14:06:08', '2023-05-10 14:06:08', NULL),
(202, 1, 1, 'Login sebagai admin dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-10 14:07:18', '2023-05-10 14:07:18', NULL),
(203, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-10 17:39:52', '2023-05-10 17:39:52', NULL),
(204, 1, 3, 'Add Unit, ID 2', '2023-05-10 17:40:39', '2023-05-10 17:40:39', NULL),
(205, 2, 1, 'Login sebagai hendi dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-10 22:43:19', '2023-05-10 22:43:19', NULL),
(206, 2, 2, 'Logout sebagai hendi', '2023-05-10 22:43:23', '2023-05-10 22:43:23', NULL),
(207, 5, 1, 'Login sebagai ihsan dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-10 22:43:36', '2023-05-10 22:43:36', NULL),
(208, 5, 2, 'Logout sebagai ihsan', '2023-05-11 00:06:37', '2023-05-11 00:06:37', NULL),
(209, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 00:06:49', '2023-05-11 00:06:49', NULL),
(210, 1, 3, 'Add User, ID 6', '2023-05-11 00:07:22', '2023-05-11 00:07:22', NULL),
(211, 1, 2, 'Logout sebagai admin', '2023-05-11 00:07:30', '2023-05-11 00:07:30', NULL),
(212, 6, 1, 'Login sebagai yati dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 00:07:37', '2023-05-11 00:07:37', NULL),
(213, 6, 2, 'Logout sebagai yati', '2023-05-11 00:09:36', '2023-05-11 00:09:36', NULL),
(214, 5, 1, 'Login sebagai ihsan dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 00:21:41', '2023-05-11 00:21:41', NULL),
(215, 5, 2, 'Logout sebagai ihsan', '2023-05-11 00:21:57', '2023-05-11 00:21:57', NULL),
(216, 6, 1, 'Login sebagai yati dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 00:22:03', '2023-05-11 00:22:03', NULL),
(217, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 07:53:13', '2023-05-11 07:53:13', NULL),
(218, 1, 2, 'Logout sebagai admin', '2023-05-11 08:00:27', '2023-05-11 08:00:27', NULL),
(219, 5, 1, 'Login sebagai ihsan dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 08:00:35', '2023-05-11 08:00:35', NULL),
(220, 5, 2, 'Logout sebagai ihsan', '2023-05-11 08:10:58', '2023-05-11 08:10:58', NULL),
(221, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 08:11:02', '2023-05-11 08:11:02', NULL),
(222, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 15:00:56', '2023-05-11 15:00:56', NULL),
(223, 1, 2, 'Logout sebagai admin', '2023-05-11 15:05:28', '2023-05-11 15:05:28', NULL),
(224, 5, 1, 'Login sebagai ihsan dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 15:05:36', '2023-05-11 15:05:36', NULL),
(225, 5, 2, 'Logout sebagai ihsan', '2023-05-11 15:06:01', '2023-05-11 15:06:01', NULL),
(226, 6, 1, 'Login sebagai yati dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 15:06:07', '2023-05-11 15:06:07', NULL),
(227, 6, 2, 'Logout sebagai yati', '2023-05-11 16:36:47', '2023-05-11 16:36:47', NULL),
(228, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 16:36:51', '2023-05-11 16:36:51', NULL),
(229, 1, 2, 'Logout sebagai admin', '2023-05-11 17:05:11', '2023-05-11 17:05:11', NULL),
(230, 6, 1, 'Login sebagai yati dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 17:05:17', '2023-05-11 17:05:17', NULL),
(231, 6, 2, 'Logout sebagai yati', '2023-05-11 17:19:33', '2023-05-11 17:19:33', NULL),
(232, 5, 1, 'Login sebagai ihsan dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 17:19:38', '2023-05-11 17:19:38', NULL),
(233, 5, 2, 'Logout sebagai ihsan', '2023-05-11 17:19:47', '2023-05-11 17:19:47', NULL),
(234, 1, 1, 'Login sebagai admin dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 17:19:52', '2023-05-11 17:19:52', NULL),
(235, 1, 2, 'Logout sebagai admin', '2023-05-11 17:19:59', '2023-05-11 17:19:59', NULL),
(236, 6, 1, 'Login sebagai yati dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 17:20:15', '2023-05-11 17:20:15', NULL),
(237, 6, 2, 'Logout sebagai yati', '2023-05-11 17:36:11', '2023-05-11 17:36:11', NULL),
(238, 5, 1, 'Login sebagai ihsan dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 17:36:17', '2023-05-11 17:36:17', NULL),
(239, 5, 2, 'Logout sebagai ihsan', '2023-05-11 17:37:19', '2023-05-11 17:37:19', NULL),
(240, 6, 1, 'Login sebagai yati dengan Chrome 112.0.0.0 (Linux) IP. ::1', '2023-05-11 17:37:26', '2023-05-11 17:37:26', NULL),
(241, 1, 1, 'Login sebagai admin dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-15 09:03:05', '2023-05-15 09:03:05', NULL),
(242, 1, 2, 'Logout sebagai admin', '2023-05-15 11:17:30', '2023-05-15 11:17:30', NULL),
(243, 6, 1, 'Login sebagai yati dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-15 11:17:36', '2023-05-15 11:17:36', NULL),
(244, 6, 2, 'Logout sebagai yati', '2023-05-15 11:36:07', '2023-05-15 11:36:07', NULL),
(245, 1, 1, 'Login sebagai admin dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-15 11:36:12', '2023-05-15 11:36:12', NULL),
(246, 1, 2, 'Logout sebagai admin', '2023-05-15 11:36:16', '2023-05-15 11:36:16', NULL),
(247, 2, 1, 'Login sebagai hendi dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-15 11:36:21', '2023-05-15 11:36:21', NULL),
(248, 2, 2, 'Logout sebagai hendi', '2023-05-15 11:36:25', '2023-05-15 11:36:25', NULL),
(249, 6, 1, 'Login sebagai yati dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-15 11:36:37', '2023-05-15 11:36:37', NULL),
(250, 6, 2, 'Logout sebagai yati', '2023-05-15 11:36:58', '2023-05-15 11:36:58', NULL),
(251, 1, 1, 'Login sebagai admin dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-15 11:37:04', '2023-05-15 11:37:04', NULL),
(252, 1, 2, 'Logout sebagai admin', '2023-05-15 11:37:17', '2023-05-15 11:37:17', NULL),
(253, 2, 1, 'Login sebagai hendi dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-15 11:37:20', '2023-05-15 11:37:20', NULL),
(254, 2, 2, 'Logout sebagai hendi', '2023-05-15 11:37:30', '2023-05-15 11:37:30', NULL),
(255, 6, 1, 'Login sebagai yati dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-15 11:37:38', '2023-05-15 11:37:38', NULL),
(256, 1, 1, 'Login sebagai admin dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-15 15:04:36', '2023-05-15 15:04:36', NULL),
(257, 1, 2, 'Logout sebagai admin', '2023-05-15 15:04:44', '2023-05-15 15:04:44', NULL),
(258, 6, 1, 'Login sebagai yati dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-15 15:04:49', '2023-05-15 15:04:49', NULL),
(259, 6, 2, 'Logout sebagai yati', '2023-05-15 15:09:18', '2023-05-15 15:09:18', NULL),
(260, 2, 1, 'Login sebagai hendi dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-15 15:09:30', '2023-05-15 15:09:30', NULL),
(261, 2, 2, 'Logout sebagai hendi', '2023-05-15 15:09:36', '2023-05-15 15:09:36', NULL),
(262, 1, 1, 'Login sebagai admin dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-15 15:09:43', '2023-05-15 15:09:43', NULL),
(263, 1, 1, 'Login sebagai admin dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-16 11:20:54', '2023-05-16 11:20:54', NULL),
(264, 1, 1, 'Login sebagai admin dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-16 14:40:58', '2023-05-16 14:40:58', NULL),
(265, 1, 2, 'Logout sebagai admin', '2023-05-16 15:24:22', '2023-05-16 15:24:22', NULL),
(266, 1, 1, 'Login sebagai admin dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-16 15:59:20', '2023-05-16 15:59:20', NULL),
(267, 1, 4, 'Edit Kendaraan, ID 5', '2023-05-16 16:32:07', '2023-05-16 16:32:07', NULL),
(268, 1, 4, 'Edit Kendaraan, ID 4', '2023-05-16 16:51:27', '2023-05-16 16:51:27', NULL),
(269, 1, 1, 'Login sebagai admin dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-17 08:17:22', '2023-05-17 08:17:22', NULL),
(270, 1, 2, 'Logout sebagai admin', '2023-05-17 12:00:23', '2023-05-17 12:00:23', NULL),
(271, 1, 1, 'Login sebagai admin dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-17 14:44:27', '2023-05-17 14:44:27', NULL),
(272, 1, 1, 'Login sebagai admin dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-19 16:26:20', '2023-05-19 16:26:20', NULL),
(273, 1, 1, 'Login sebagai admin dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-29 14:43:31', '2023-05-29 14:43:31', NULL),
(274, 1, 1, 'Login sebagai admin dengan Chrome 113.0.0.0 (Linux) IP. ::1', '2023-05-30 09:05:28', '2023-05-30 09:05:28', NULL),
(275, 1, 1, 'Login sebagai admin dengan Chrome 114.0.0.0 (Linux) IP. ::1', '2023-06-27 22:31:08', '2023-06-27 22:31:08', NULL),
(276, 1, 2, 'Logout sebagai admin', '2023-06-27 23:01:00', '2023-06-27 23:01:00', NULL),
(277, 1, 1, 'Login sebagai admin dengan Chrome 114.0.0.0 (Linux) IP. ::1', '2023-06-27 23:01:03', '2023-06-27 23:01:03', NULL),
(278, 1, 2, 'Logout sebagai admin', '2023-06-27 23:02:10', '2023-06-27 23:02:10', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_reflog`
--

CREATE TABLE `user_reflog` (
  `id` tinyint(2) UNSIGNED NOT NULL,
  `keterangan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Master referensi log';

--
-- Dumping data for table `user_reflog`
--

INSERT INTO `user_reflog` (`id`, `keterangan`) VALUES
(1, 'Login'),
(2, 'Logout'),
(3, 'Insert'),
(4, 'Update'),
(5, 'Delete'),
(6, 'Query / Report');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `asal_usul`
--
ALTER TABLE `asal_usul`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bahan_bakar`
--
ALTER TABLE `bahan_bakar`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kelompok`
--
ALTER TABLE `kelompok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kendaraan`
--
ALTER TABLE `kendaraan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `kd_aset_IDX` (`kd_aset`),
  ADD KEY `nm_aset_IDX` (`nama_aset`),
  ADD KEY `no_rangka_IDX` (`no_rangka`),
  ADD KEY `no_mesin_IDX` (`no_mesin`),
  ADD KEY `no_polisi_IDX` (`no_polisi`),
  ADD KEY `no_bpkb_IDX` (`no_bpkb`),
  ADD KEY `roda_id_IDX` (`roda_id`),
  ADD KEY `asal_usul_id_IDX` (`asal_usul_id`),
  ADD KEY `bahan_bakar_id_IDX` (`bahan_bakar_id`),
  ADD KEY `kelompok_id_IDX` (`kelompok_id`),
  ADD KEY `th_beli_IDX` (`th_beli`);

--
-- Indexes for table `opd`
--
ALTER TABLE `opd`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kd_opd_IDX` (`kd_opd`),
  ADD KEY `nm_opd_IDX` (`nm_opd`);

--
-- Indexes for table `peminjaman_operasional`
--
ALTER TABLE `peminjaman_operasional`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pengguna`
--
ALTER TABLE `pengguna`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip_IDX` (`nip`),
  ADD KEY `nama_lengkap_IDX` (`nama_lengkap`),
  ADD KEY `unit_id_IDX` (`unit_id`);

--
-- Indexes for table `pengguna_rutin`
--
ALTER TABLE `pengguna_rutin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roda`
--
ALTER TABLE `roda`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kd_unit_IDX` (`kd_unit`),
  ADD KEY `nm_unit_IDX` (`nm_unit`),
  ADD KEY `opd_id_IDX` (`opd_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_name_IDX` (`user_name`),
  ADD KEY `password_IDX` (`password`),
  ADD KEY `level_id_IDX` (`level_id`),
  ADD KEY `unit_id_IDX` (`unit_id`);

--
-- Indexes for table `user_level`
--
ALTER TABLE `user_level`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_log`
--
ALTER TABLE `user_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_reflog`
--
ALTER TABLE `user_reflog`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `asal_usul`
--
ALTER TABLE `asal_usul`
  MODIFY `id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `bahan_bakar`
--
ALTER TABLE `bahan_bakar`
  MODIFY `id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kelompok`
--
ALTER TABLE `kelompok`
  MODIFY `id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `kendaraan`
--
ALTER TABLE `kendaraan`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `opd`
--
ALTER TABLE `opd`
  MODIFY `id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `peminjaman_operasional`
--
ALTER TABLE `peminjaman_operasional`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengguna`
--
ALTER TABLE `pengguna`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `pengguna_rutin`
--
ALTER TABLE `pengguna_rutin`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `roda`
--
ALTER TABLE `roda`
  MODIFY `id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` smallint(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_log`
--
ALTER TABLE `user_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=279;

--
-- AUTO_INCREMENT for table `user_reflog`
--
ALTER TABLE `user_reflog`
  MODIFY `id` tinyint(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
