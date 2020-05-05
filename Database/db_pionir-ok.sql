-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: 26 Mar 2020 pada 11.38
-- Versi Server: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_pionir`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akses`
--

CREATE TABLE `akses` (
  `id` int(11) NOT NULL,
  `userId` varchar(12) DEFAULT NULL,
  `password` text,
  `idLevel` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `akses`
--

INSERT INTO `akses` (`id`, `userId`, `password`, `idLevel`) VALUES
(117, 'admin', 'admin', 1),
(118, '1', '1', 2),
(119, '2', '2', 2);

-- --------------------------------------------------------

--
-- Struktur dari tabel `consistence`
--

CREATE TABLE `consistence` (
  `id` int(11) NOT NULL,
  `id_contest` int(11) DEFAULT NULL,
  `lambda` double DEFAULT NULL,
  `consIndex` double DEFAULT NULL,
  `consRatio` double DEFAULT NULL,
  `isConsistence` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `consistence`
--

INSERT INTO `consistence` (`id`, `id_contest`, `lambda`, `consIndex`, `consRatio`, `isConsistence`) VALUES
(6, 62, 4.1213204373423, 0.040440145780768, 0.044933495311964, '1'),
(7, 61, 4.1213204373423, 0.040440145780768, 0.044933495311964, '1'),
(8, 60, 4.1215306122449, 0.040510204081633, 0.045011337868481, '1'),
(9, 59, 4.247544307952, 0.082514769317329, 0.091683077019255, '1'),
(10, 58, 4.1215306122449, 0.040510204081633, 0.045011337868481, '1'),
(11, 57, 4.0605392156863, 0.020179738562092, 0.022421931735657, '1'),
(12, 56, 4, 0, 0, '1'),
(13, 55, 4.247544307952, 0.082514769317329, 0.091683077019255, '1'),
(14, 54, 4.247544307952, 0.082514769317329, 0.091683077019255, '1'),
(15, 53, 4.247544307952, 0.082514769317329, 0.091683077019255, '1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `contest`
--

CREATE TABLE `contest` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `kuota` char(10) DEFAULT NULL,
  `dibuka` date DEFAULT NULL COMMENT 'pendaftaran',
  `ditutup` date DEFAULT NULL COMMENT 'pendaftaran',
  `seleksiTutup` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `contest`
--

INSERT INTO `contest` (`id`, `nama`, `kuota`, `dibuka`, `ditutup`, `seleksiTutup`) VALUES
(53, 'Futsal', '12', '2019-06-24', '2019-06-30', '2019-07-06'),
(54, 'Basketball', '12', '2019-06-24', '2019-06-30', '2019-07-06'),
(55, 'Volly ball', '12', '2019-06-24', '2019-06-30', '2019-07-06'),
(56, 'Badminton', '15', '2019-06-24', '2019-06-30', '2019-07-06'),
(57, 'Sepak Takraw', '6', '2019-06-24', '2019-06-30', '2019-07-06'),
(58, 'Chess', '5', '2019-06-24', '2019-06-30', '2019-07-06'),
(59, 'Pencaksilat', '10', '2019-06-24', '2019-06-30', '2019-07-06'),
(60, 'Karate', '10', '2019-07-29', '2019-06-30', '2019-07-06'),
(61, 'Table Tennis', '8', '2019-06-24', '2019-06-30', '2019-07-06'),
(62, 'Wall Climbing', '5', '2019-06-24', '2019-06-30', '2019-07-06');

-- --------------------------------------------------------

--
-- Struktur dari tabel `eigen_kriteria`
--

CREATE TABLE `eigen_kriteria` (
  `id` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `id_contest` int(11) NOT NULL,
  `value_eigen` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `eigen_kriteria`
--

INSERT INTO `eigen_kriteria` (`id`, `id_kriteria`, `id_contest`, `value_eigen`) VALUES
(17, 41, 62, 0.29285714285714),
(18, 37, 62, 0.29285714285714),
(19, 29, 62, 0.20714285714286),
(20, 28, 62, 0.20714285714286),
(21, 37, 61, 0.29285714285714),
(22, 29, 61, 0.29285714285714),
(23, 36, 61, 0.20714285714286),
(24, 40, 61, 0.20714285714286),
(25, 28, 60, 0.34602076124567),
(26, 37, 60, 0.24221453287197),
(27, 40, 60, 0.24221453287197),
(28, 38, 60, 0.16955017301038),
(29, 28, 59, 0.28859060402685),
(30, 37, 59, 0.28859060402685),
(31, 40, 59, 0.21476510067114),
(32, 38, 59, 0.20805369127517),
(33, 38, 58, 0.34602076124567),
(34, 40, 58, 0.24221453287197),
(35, 29, 58, 0.24221453287197),
(36, 37, 58, 0.16955017301038),
(37, 28, 57, 0.28985507246377),
(38, 29, 57, 0.28985507246377),
(39, 31, 57, 0.17391304347826),
(40, 37, 57, 0.2463768115942),
(41, 37, 56, 0.28571428571429),
(42, 38, 56, 0.28571428571429),
(43, 28, 56, 0.28571428571429),
(44, 39, 56, 0.14285714285714),
(45, 28, 55, 0.28859060402685),
(46, 31, 55, 0.28859060402685),
(47, 32, 55, 0.21476510067114),
(48, 36, 55, 0.20805369127517),
(49, 28, 54, 0.28859060402685),
(50, 33, 54, 0.28859060402685),
(51, 32, 54, 0.21476510067114),
(52, 35, 54, 0.20805369127517),
(53, 28, 53, 0.28859060402685),
(54, 29, 53, 0.28859060402685),
(55, 31, 53, 0.21476510067114),
(56, 32, 53, 0.20805369127517);

-- --------------------------------------------------------

--
-- Struktur dari tabel `fakultas`
--

CREATE TABLE `fakultas` (
  `id` int(11) NOT NULL,
  `namaFk` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `fakultas`
--

INSERT INTO `fakultas` (`id`, `namaFk`) VALUES
(1, 'Tarbiyah dan Ilmu Keguruan'),
(2, 'Syari’ah'),
(3, 'Humaniora'),
(4, 'Psikologi'),
(5, 'Ekonomi'),
(6, 'Sains dan Teknologi'),
(7, 'Kedokteran dan Ilmu-Ilmu Kesehatan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `identitas_mhs`
--

CREATE TABLE `identitas_mhs` (
  `nimMhs` int(11) NOT NULL,
  `namaLengkap` varchar(100) DEFAULT NULL,
  `tempatLahir` text,
  `tglLahir` date DEFAULT NULL,
  `asalKota` varchar(20) DEFAULT NULL,
  `namaOrtu` varchar(20) DEFAULT NULL,
  `alamatOrtu` text,
  `kotaOrtu` varchar(30) DEFAULT NULL,
  `propinsiOrtu` varchar(30) DEFAULT NULL,
  `angkatan` char(5) DEFAULT NULL,
  `jenisKel` tinyint(1) DEFAULT NULL,
  `alamatLengkap` text,
  `emailAktif` varchar(100) DEFAULT NULL,
  `noTelp` char(12) DEFAULT NULL,
  `fotoMhs` varchar(100) DEFAULT NULL,
  `idJrs` int(11) DEFAULT NULL,
  `idAkses` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Struktur dari tabel `jurusan`
--

CREATE TABLE `jurusan` (
  `id` int(11) NOT NULL,
  `namaJur` varchar(100) DEFAULT NULL,
  `idFk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `jurusan`
--

INSERT INTO `jurusan` (`id`, `namaJur`, `idFk`) VALUES
(1, 'Pendidikan Agama Islam', 1),
(2, 'Pendidikan IPS', 1),
(3, 'Pendidikan Guru Madrasah Ibtidaiyah (PGMI)', 1),
(4, 'Pendidikan Bahasa Arab', 1),
(5, 'Pendidikan Islam Anak Usia Dini (PIAUD)', 1),
(6, 'Manajemen Pendidikan Islam', 1),
(7, 'Tadris Bahasa Inggris', 1),
(8, 'Tadris Matematika', 1),
(9, 'Al-Ahwal Al-Syakhsiyyah', 2),
(10, 'Hukum Bisnis Syari\'ah', 2),
(11, 'Hukum Tata Negara', 2),
(12, 'Ilmu Al-Qur\'an dan Tafsir', 2),
(13, 'Bahasa dan Sastra Arab', 3),
(14, 'Sastra Inggris', 3),
(15, 'Psikologi', 4),
(16, 'Manajemen', 5),
(17, 'Akuntansi', 5),
(18, 'D3. Perbankan Syari\'ah', 5),
(19, 'S1. Perbankan Syari\'ah', 5),
(20, 'Matematika', 6),
(21, 'Biologi', 6),
(22, 'Kimia', 6),
(23, 'Fisika', 6),
(24, 'Teknik Informatika', 6),
(25, 'Teknik Arsitektur', 6),
(26, 'Farmasi', 7),
(27, 'Pendidikan Dokter', 7);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kriteria_skor`
--

CREATE TABLE `kriteria_skor` (
  `id` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `kriteria_skor`
--

INSERT INTO `kriteria_skor` (`id`, `nama`) VALUES
(28, 'Physical'),
(29, 'Skill'),
(30, 'Speed'),
(31, 'Teamwork'),
(32, 'Passing'),
(33, 'Dribble'),
(34, 'Shooting'),
(35, 'Power(Jump)'),
(36, 'Flexibility'),
(37, 'Technical'),
(38, 'Mental'),
(39, 'Durability'),
(40, 'Agility'),
(41, 'Strength');

-- --------------------------------------------------------

--
-- Struktur dari tabel `levellog`
--

CREATE TABLE `levellog` (
  `id` int(11) NOT NULL,
  `level` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `levellog`
--

INSERT INTO `levellog` (`id`, `level`) VALUES
(1, 'Admin'),
(2, 'Mahasiswa');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pair_kriteria`
--

CREATE TABLE `pair_kriteria` (
  `id_pair` int(11) NOT NULL,
  `id_kriteria` int(11) NOT NULL,
  `id_kriteria_pair` int(11) NOT NULL,
  `id_contest` int(11) NOT NULL,
  `value` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pair_kriteria`
--

INSERT INTO `pair_kriteria` (`id_pair`, `id_kriteria`, `id_kriteria_pair`, `id_contest`, `value`) VALUES
(55, 41, 41, 62, 1),
(56, 41, 37, 62, 1),
(57, 41, 29, 62, 2),
(58, 41, 28, 62, 1),
(59, 37, 41, 62, 1),
(60, 37, 37, 62, 1),
(61, 37, 29, 62, 1),
(62, 37, 28, 62, 2),
(63, 29, 41, 62, 0.5),
(64, 29, 37, 62, 1),
(65, 29, 29, 62, 1),
(66, 29, 28, 62, 1),
(67, 28, 41, 62, 1),
(68, 28, 37, 62, 0.5),
(69, 28, 29, 62, 1),
(70, 28, 28, 62, 1),
(71, 37, 37, 61, 1),
(72, 37, 29, 61, 1),
(73, 37, 36, 61, 2),
(74, 37, 40, 61, 1),
(75, 29, 37, 61, 1),
(76, 29, 29, 61, 1),
(77, 29, 36, 61, 1),
(78, 29, 40, 61, 2),
(79, 36, 37, 61, 0.5),
(80, 36, 29, 61, 1),
(81, 36, 36, 61, 1),
(82, 36, 40, 61, 1),
(83, 40, 37, 61, 1),
(84, 40, 29, 61, 0.5),
(85, 40, 36, 61, 1),
(86, 40, 40, 61, 1),
(87, 28, 28, 60, 1),
(88, 28, 37, 60, 2),
(89, 28, 40, 60, 1),
(90, 28, 38, 60, 2),
(91, 37, 28, 60, 0.5),
(92, 37, 37, 60, 1),
(93, 37, 40, 60, 1),
(94, 37, 38, 60, 2),
(95, 40, 28, 60, 1),
(96, 40, 37, 60, 1),
(97, 40, 40, 60, 1),
(98, 40, 38, 60, 1),
(99, 38, 28, 60, 0.5),
(100, 38, 37, 60, 0.5),
(101, 38, 40, 60, 1),
(102, 38, 38, 60, 1),
(103, 28, 28, 59, 1),
(104, 28, 37, 59, 1),
(105, 28, 40, 59, 2),
(106, 28, 38, 59, 1),
(107, 37, 28, 59, 1),
(108, 37, 37, 59, 1),
(109, 37, 40, 59, 2),
(110, 37, 38, 59, 1),
(111, 40, 28, 59, 0.5),
(112, 40, 37, 59, 0.5),
(113, 40, 40, 59, 1),
(114, 40, 38, 59, 2),
(115, 38, 28, 59, 1),
(116, 38, 37, 59, 1),
(117, 38, 40, 59, 0.5),
(118, 38, 38, 59, 1),
(119, 38, 38, 58, 1),
(120, 38, 40, 58, 2),
(121, 38, 29, 58, 1),
(122, 38, 37, 58, 2),
(123, 40, 38, 58, 0.5),
(124, 40, 40, 58, 1),
(125, 40, 29, 58, 1),
(126, 40, 37, 58, 2),
(127, 29, 38, 58, 1),
(128, 29, 40, 58, 1),
(129, 29, 29, 58, 1),
(130, 29, 37, 58, 1),
(131, 37, 38, 58, 0.5),
(132, 37, 40, 58, 0.5),
(133, 37, 29, 58, 1),
(134, 37, 37, 58, 1),
(135, 28, 28, 57, 1),
(136, 28, 29, 57, 1),
(137, 28, 31, 57, 2),
(138, 28, 37, 57, 1),
(139, 29, 28, 57, 1),
(140, 29, 29, 57, 1),
(141, 29, 31, 57, 2),
(142, 29, 37, 57, 1),
(143, 31, 28, 57, 0.5),
(144, 31, 29, 57, 0.5),
(145, 31, 31, 57, 1),
(146, 31, 37, 57, 1),
(147, 37, 28, 57, 1),
(148, 37, 29, 57, 1),
(149, 37, 31, 57, 1),
(150, 37, 37, 57, 1),
(151, 37, 37, 56, 1),
(152, 37, 38, 56, 1),
(153, 37, 28, 56, 1),
(154, 37, 39, 56, 2),
(155, 38, 37, 56, 1),
(156, 38, 38, 56, 1),
(157, 38, 28, 56, 1),
(158, 38, 39, 56, 2),
(159, 28, 37, 56, 1),
(160, 28, 38, 56, 1),
(161, 28, 28, 56, 1),
(162, 28, 39, 56, 2),
(163, 39, 37, 56, 0.5),
(164, 39, 38, 56, 0.5),
(165, 39, 28, 56, 0.5),
(166, 39, 39, 56, 1),
(167, 28, 28, 55, 1),
(168, 28, 31, 55, 1),
(169, 28, 32, 55, 2),
(170, 28, 36, 55, 1),
(171, 31, 28, 55, 1),
(172, 31, 31, 55, 1),
(173, 31, 32, 55, 2),
(174, 31, 36, 55, 1),
(175, 32, 28, 55, 0.5),
(176, 32, 31, 55, 0.5),
(177, 32, 32, 55, 1),
(178, 32, 36, 55, 2),
(179, 36, 28, 55, 1),
(180, 36, 31, 55, 1),
(181, 36, 32, 55, 0.5),
(182, 36, 36, 55, 1),
(183, 28, 28, 54, 1),
(184, 28, 33, 54, 1),
(185, 28, 32, 54, 2),
(186, 28, 35, 54, 1),
(187, 33, 28, 54, 1),
(188, 33, 33, 54, 1),
(189, 33, 32, 54, 2),
(190, 33, 35, 54, 1),
(191, 32, 28, 54, 0.5),
(192, 32, 33, 54, 0.5),
(193, 32, 32, 54, 1),
(194, 32, 35, 54, 2),
(195, 35, 28, 54, 1),
(196, 35, 33, 54, 1),
(197, 35, 32, 54, 0.5),
(198, 35, 35, 54, 1),
(199, 28, 28, 53, 1),
(200, 28, 29, 53, 1),
(201, 28, 31, 53, 2),
(202, 28, 32, 53, 1),
(203, 29, 28, 53, 1),
(204, 29, 29, 53, 1),
(205, 29, 31, 53, 2),
(206, 29, 32, 53, 1),
(207, 31, 28, 53, 0.5),
(208, 31, 29, 53, 0.5),
(209, 31, 31, 53, 1),
(210, 31, 32, 53, 2),
(211, 32, 28, 53, 1),
(212, 32, 29, 53, 1),
(213, 32, 31, 53, 0.5),
(214, 32, 32, 53, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftar`
--

CREATE TABLE `pendaftar` (
  `id` int(11) NOT NULL,
  `id_contest` int(11) NOT NULL,
  `nim` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `tempatLahir` text,
  `tglLahir` date NOT NULL,
  `jenisKel` tinyint(1) DEFAULT NULL COMMENT '1 = Laki-Laki; 2= Perempuan',
  `noTelp` char(12) DEFAULT NULL,
  `idJrs` int(11) DEFAULT NULL,
  `status` int(1) NOT NULL DEFAULT '0' COMMENT '1=diterima, 0=tidak_diterima',
  `waktuDiubah` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pendaftar`
--

INSERT INTO `pendaftar` (`id`, `id_contest`, `nim`, `nama`, `tempatLahir`, `tglLahir`, `jenisKel`, `noTelp`, `idJrs`, `status`, `waktuDiubah`) VALUES
(1728, 62, 15510058, 'Fahrur Rozi Abdul Aziz Seferan', 'Malang', '1997-05-29', 1, '085101908576', 16, 1, '2019-06-23 20:49:13'),
(1729, 62, 15510024, 'Toha Barizi', 'Situbondo', '1996-05-16', 1, '81235486445', 16, 1, '2019-06-23 20:49:14'),
(1730, 62, 16220004, 'M. Yakub Rajuli', 'Pengadangan', '1998-06-26', 1, '082339766788', 10, 1, '2019-06-23 20:49:13'),
(1731, 62, 15540022, 'Alfajar Assidiq', 'Jember', '1996-05-21', 1, '085785071400', 19, 0, '2019-06-23 20:45:28'),
(1732, 53, 15230025, 'Angga Deka Saputra', 'Malang', '1997-09-26', 1, '81539375802', 9, 0, '2019-06-24 04:01:57'),
(1733, 53, 16510242, 'Sikrulloh', 'Malang', '2019-06-24', 1, '81216224103', 15, 0, '2019-06-24 04:02:48'),
(1734, 53, 15650043, 'Komarudin Mahbullah', 'Tuban', '1998-02-26', 1, '87837155053', 24, 0, '2019-06-24 04:03:53'),
(1735, 53, 15650051, 'Fahrul Fanani Ghizbunaza', 'Malang', '1998-02-26', 1, '87837155053', 22, 0, '2019-06-24 04:04:41'),
(1736, 53, 16510043, 'Muhammad Ari Firmansyah', 'Malang', '1998-02-14', 1, '85791562342', 1, 0, '2019-06-24 04:05:33'),
(1737, 53, 16310055, 'Abdulloh Asrori', 'Gresik', '1999-01-08', 1, '82244030203', 13, 0, '2019-06-24 04:06:55'),
(1738, 53, 17610007, 'Mohamad Abdul Ba\'Is', 'Kediri', '1999-03-22', 1, '85655657420', 20, 0, '2019-06-24 04:07:39'),
(1739, 53, 16610024, 'Lutfi Alwi Muzakka', 'Semarang', '1998-06-19', 1, '85856446444', 10, 0, '2019-06-24 04:08:23'),
(1740, 53, 17610046, 'Ahmad Chuzaimi Assubchi', 'Blitar', '1999-05-14', 1, '85735895883', 15, 0, '2019-06-24 04:09:12'),
(1741, 53, 15510030, 'Ibnu Abbas', 'Bangkalan', '1996-02-16', 1, '87750934190', 18, 0, '2019-06-24 04:09:50'),
(1742, 53, 15540001, 'Abdul Mushawwir', 'Bima', '1998-02-03', 1, '82359474930', 10, 0, '2019-06-24 04:10:28'),
(1743, 53, 17110064, 'Syamsul Arifin', 'Sumenep', '1999-11-07', 1, '81933053035', 2, 0, '2019-06-24 04:11:12'),
(1744, 53, 17310169, 'Akhmad Munawar', 'Pasuruan', '1996-07-12', 1, '81615719372', 13, 0, '2019-06-24 04:11:50'),
(1745, 53, 16210053, 'Yusril Hidayat Maulidi', 'Pamekasan', '1997-07-20', 1, '85843384046', 9, 0, '2019-06-24 04:12:28'),
(1746, 53, 17540033, 'Moch. Fatih Firmansyah Din Salim', 'Kediri', '1998-06-13', 1, '85749481771', 18, 0, '2019-06-24 04:13:11'),
(1747, 53, 15540007, 'Mawafi', 'Bangkalan', '1997-07-20', 1, '87849980309', 15, 0, '2019-06-24 04:13:49'),
(1748, 53, 16650032, 'Achmad Arief H', 'Mojokerto', '1997-03-31', 1, '85607733810', 24, 0, '2019-06-24 04:14:47'),
(1749, 53, 15540016, 'Angga Dwi Febrianto', 'Kediri', '1997-02-13', 1, '85790699229', 10, 0, '2019-06-24 04:15:36'),
(1750, 53, 15650005, 'Moch Afifudin Yuhri', 'Lamongan', '1996-07-27', 1, '81515718314', 23, 0, '2019-06-24 04:16:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pendaftar_skor`
--

CREATE TABLE `pendaftar_skor` (
  `id` int(40) NOT NULL,
  `idPendaftar` int(11) NOT NULL,
  `id_contest` int(11) NOT NULL,
  `idKriteria` int(11) NOT NULL,
  `idSubKriteria` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `pendaftar_skor`
--

INSERT INTO `pendaftar_skor` (`id`, `idPendaftar`, `id_contest`, `idKriteria`, `idSubKriteria`) VALUES
(13144, 1728, 62, 41, 184),
(13145, 1728, 62, 37, 165),
(13146, 1728, 62, 29, 125),
(13147, 1728, 62, 28, 118),
(13148, 1729, 62, 41, 183),
(13149, 1729, 62, 37, 164),
(13150, 1729, 62, 29, 125),
(13151, 1729, 62, 28, 119),
(13152, 1730, 62, 41, 185),
(13153, 1730, 62, 37, 164),
(13154, 1730, 62, 29, 125),
(13155, 1730, 62, 28, 119),
(13156, 1731, 62, 41, 184),
(13157, 1731, 62, 37, 163),
(13158, 1731, 62, 29, 124),
(13159, 1731, 62, 28, 118),
(13160, 1732, 53, 28, 119),
(13161, 1732, 53, 29, 123),
(13162, 1732, 53, 31, 134),
(13163, 1732, 53, 32, 139),
(13164, 1733, 53, 28, 117),
(13165, 1733, 53, 29, 123),
(13166, 1733, 53, 31, 134),
(13167, 1733, 53, 32, 139),
(13168, 1734, 53, 28, 119),
(13169, 1734, 53, 29, 124),
(13170, 1734, 53, 31, 133),
(13171, 1734, 53, 32, 138),
(13172, 1735, 53, 28, 118),
(13173, 1735, 53, 29, 124),
(13174, 1735, 53, 31, 134),
(13175, 1735, 53, 32, 138),
(13176, 1736, 53, 28, 119),
(13177, 1736, 53, 29, 123),
(13178, 1736, 53, 31, 133),
(13179, 1736, 53, 32, 138),
(13180, 1737, 53, 28, 117),
(13181, 1737, 53, 29, 124),
(13182, 1737, 53, 31, 134),
(13183, 1737, 53, 32, 138),
(13184, 1738, 53, 28, 117),
(13185, 1738, 53, 29, 123),
(13186, 1738, 53, 31, 133),
(13187, 1738, 53, 32, 139),
(13188, 1739, 53, 28, 118),
(13189, 1739, 53, 29, 122),
(13190, 1739, 53, 31, 133),
(13191, 1739, 53, 32, 138),
(13192, 1740, 53, 28, 118),
(13193, 1740, 53, 29, 123),
(13194, 1740, 53, 31, 134),
(13195, 1740, 53, 32, 138),
(13196, 1741, 53, 28, 118),
(13197, 1741, 53, 29, 123),
(13198, 1741, 53, 31, 134),
(13199, 1741, 53, 32, 139),
(13200, 1742, 53, 28, 118),
(13201, 1742, 53, 29, 123),
(13202, 1742, 53, 31, 133),
(13203, 1742, 53, 32, 139),
(13204, 1743, 53, 28, 118),
(13205, 1743, 53, 29, 123),
(13206, 1743, 53, 31, 133),
(13207, 1743, 53, 32, 138),
(13208, 1744, 53, 28, 118),
(13209, 1744, 53, 29, 123),
(13210, 1744, 53, 31, 134),
(13211, 1744, 53, 32, 138),
(13212, 1745, 53, 28, 118),
(13213, 1745, 53, 29, 123),
(13214, 1745, 53, 31, 133),
(13215, 1745, 53, 32, 139),
(13216, 1746, 53, 28, 118),
(13217, 1746, 53, 29, 123),
(13218, 1746, 53, 31, 133),
(13219, 1746, 53, 32, 139),
(13220, 1747, 53, 28, 120),
(13221, 1747, 53, 29, 122),
(13222, 1747, 53, 31, 134),
(13223, 1747, 53, 32, 139),
(13224, 1748, 53, 28, 119),
(13225, 1748, 53, 29, 123),
(13226, 1748, 53, 31, 134),
(13227, 1748, 53, 32, 139),
(13228, 1749, 53, 28, 118),
(13229, 1749, 53, 29, 123),
(13230, 1749, 53, 31, 134),
(13231, 1749, 53, 32, 138),
(13232, 1750, 53, 28, 119),
(13233, 1750, 53, 29, 123),
(13234, 1750, 53, 31, 133),
(13235, 1750, 53, 32, 139);

-- --------------------------------------------------------

--
-- Struktur dari tabel `set_contest_kriteria_skor`
--

CREATE TABLE `set_contest_kriteria_skor` (
  `id` int(11) NOT NULL,
  `idContest` int(11) NOT NULL,
  `idKriteriaSkor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `set_contest_kriteria_skor`
--

INSERT INTO `set_contest_kriteria_skor` (`id`, `idContest`, `idKriteriaSkor`) VALUES
(14, 53, 28),
(15, 53, 29),
(16, 53, 31),
(17, 53, 32),
(18, 54, 28),
(19, 54, 33),
(20, 54, 32),
(21, 54, 35),
(22, 55, 28),
(23, 55, 31),
(24, 55, 32),
(25, 55, 36),
(26, 56, 37),
(27, 56, 38),
(28, 56, 28),
(29, 56, 39),
(30, 57, 28),
(31, 57, 29),
(32, 57, 31),
(33, 57, 37),
(34, 58, 38),
(35, 58, 40),
(36, 58, 29),
(37, 58, 37),
(38, 59, 28),
(39, 59, 37),
(40, 59, 40),
(41, 59, 38),
(42, 60, 28),
(43, 60, 37),
(44, 60, 40),
(45, 60, 38),
(46, 61, 37),
(47, 61, 29),
(48, 61, 36),
(49, 61, 40),
(50, 62, 41),
(51, 62, 37),
(52, 62, 29),
(53, 62, 28);

-- --------------------------------------------------------

--
-- Struktur dari tabel `set_sub_kriteria_skor`
--

CREATE TABLE `set_sub_kriteria_skor` (
  `id` int(11) NOT NULL,
  `idKriteriaSkor` int(11) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `skor` int(7) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data untuk tabel `set_sub_kriteria_skor`
--

INSERT INTO `set_sub_kriteria_skor` (`id`, `idKriteriaSkor`, `nama`, `skor`) VALUES
(117, 28, '<40', 1),
(118, 28, '40-55', 2),
(119, 28, '56-70', 3),
(120, 28, '71-84', 4),
(121, 28, '85-100', 5),
(122, 29, ' <40', 1),
(123, 29, '40-55', 2),
(124, 29, ' 56-70', 3),
(125, 29, '71-84', 4),
(126, 29, ' 85-100', 5),
(127, 30, '<40', 1),
(128, 30, '40-55', 2),
(129, 30, '56-70', 3),
(130, 30, '71-84', 4),
(131, 30, '85-100', 5),
(132, 31, '<40', 1),
(133, 31, '40-55', 2),
(134, 31, '56-70', 3),
(135, 31, '71-84', 4),
(136, 31, '85-100', 5),
(137, 32, '<40', 1),
(138, 32, '40-55', 2),
(139, 32, '56-70', 3),
(140, 32, '71-84', 4),
(141, 32, '85-100', 5),
(142, 33, '<40', 1),
(143, 33, '40-55', 2),
(144, 33, '56-70', 3),
(145, 33, '71-84', 4),
(146, 33, '85-100', 5),
(147, 34, '<40', 1),
(148, 34, '40-55', 2),
(149, 34, '56-70', 3),
(150, 34, '71-84', 4),
(151, 34, '85-100', 5),
(152, 35, '<40', 1),
(153, 35, '40-55', 2),
(154, 35, '56-70', 3),
(155, 35, '71-84', 4),
(156, 35, '85-100', 5),
(157, 36, '<40', 1),
(158, 36, '40-55', 2),
(159, 36, '56-70', 3),
(160, 36, '71-84', 4),
(161, 36, '85-100', 5),
(162, 37, '<40', 1),
(163, 37, '40-55', 2),
(164, 37, '56-70', 3),
(165, 37, '71-84', 4),
(166, 37, '85-100', 5),
(167, 38, '<40', 1),
(168, 38, '40-55', 2),
(169, 38, '56-70', 3),
(170, 38, '71-84', 4),
(171, 38, '85-100', 5),
(172, 39, '<40', 1),
(173, 39, '40-55', 2),
(174, 39, '56-70', 3),
(175, 39, '71-84', 4),
(176, 39, '85-100', 5),
(177, 40, '<40', 1),
(178, 40, '40-55', 2),
(179, 40, '56-70', 3),
(180, 40, '71-84', 4),
(181, 40, '85-100', 5),
(182, 41, '<40', 1),
(183, 41, '40-55', 2),
(184, 41, '56-70', 3),
(185, 41, '71-84', 4),
(186, 41, '85-100', 5);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses`
--
ALTER TABLE `akses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idLevel` (`idLevel`);

--
-- Indexes for table `consistence`
--
ALTER TABLE `consistence`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bea` (`id_contest`);

--
-- Indexes for table `contest`
--
ALTER TABLE `contest`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `eigen_kriteria`
--
ALTER TABLE `eigen_kriteria`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kriteria` (`id_kriteria`),
  ADD KEY `id_bea` (`id_contest`);

--
-- Indexes for table `fakultas`
--
ALTER TABLE `fakultas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `identitas_mhs`
--
ALTER TABLE `identitas_mhs`
  ADD PRIMARY KEY (`nimMhs`),
  ADD UNIQUE KEY `nimMhs` (`nimMhs`),
  ADD KEY `jurusan-mhs` (`idJrs`),
  ADD KEY `id_akses` (`idAkses`);

--
-- Indexes for table `jurusan`
--
ALTER TABLE `jurusan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jurusan_fk` (`idFk`);

--
-- Indexes for table `kriteria_skor`
--
ALTER TABLE `kriteria_skor`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `levellog`
--
ALTER TABLE `levellog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pair_kriteria`
--
ALTER TABLE `pair_kriteria`
  ADD PRIMARY KEY (`id_pair`),
  ADD KEY `id_kriteria` (`id_kriteria`),
  ADD KEY `id_kriteria_pair` (`id_kriteria_pair`),
  ADD KEY `id_bea` (`id_contest`);

--
-- Indexes for table `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `nim` (`nim`),
  ADD KEY `idBea` (`id_contest`),
  ADD KEY `idJrs` (`idJrs`);

--
-- Indexes for table `pendaftar_skor`
--
ALTER TABLE `pendaftar_skor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idPendaftar` (`idPendaftar`),
  ADD KEY `idBea` (`id_contest`),
  ADD KEY `idKategori` (`idKriteria`),
  ADD KEY `idSubKategori` (`idSubKriteria`);

--
-- Indexes for table `set_contest_kriteria_skor`
--
ALTER TABLE `set_contest_kriteria_skor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_bea` (`idContest`),
  ADD KEY `id_kategori_skor` (`idKriteriaSkor`);

--
-- Indexes for table `set_sub_kriteria_skor`
--
ALTER TABLE `set_sub_kriteria_skor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori_skor` (`idKriteriaSkor`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `akses`
--
ALTER TABLE `akses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;
--
-- AUTO_INCREMENT for table `consistence`
--
ALTER TABLE `consistence`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `contest`
--
ALTER TABLE `contest`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;
--
-- AUTO_INCREMENT for table `eigen_kriteria`
--
ALTER TABLE `eigen_kriteria`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;
--
-- AUTO_INCREMENT for table `fakultas`
--
ALTER TABLE `fakultas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `jurusan`
--
ALTER TABLE `jurusan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `kriteria_skor`
--
ALTER TABLE `kriteria_skor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;
--
-- AUTO_INCREMENT for table `levellog`
--
ALTER TABLE `levellog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `pair_kriteria`
--
ALTER TABLE `pair_kriteria`
  MODIFY `id_pair` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=215;
--
-- AUTO_INCREMENT for table `pendaftar`
--
ALTER TABLE `pendaftar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1751;
--
-- AUTO_INCREMENT for table `pendaftar_skor`
--
ALTER TABLE `pendaftar_skor`
  MODIFY `id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13236;
--
-- AUTO_INCREMENT for table `set_contest_kriteria_skor`
--
ALTER TABLE `set_contest_kriteria_skor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;
--
-- AUTO_INCREMENT for table `set_sub_kriteria_skor`
--
ALTER TABLE `set_sub_kriteria_skor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=187;
--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `akses`
--
ALTER TABLE `akses`
  ADD CONSTRAINT `akses_ibfk_1` FOREIGN KEY (`idLevel`) REFERENCES `levellog` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `consistence`
--
ALTER TABLE `consistence`
  ADD CONSTRAINT `consistence_ibfk_1` FOREIGN KEY (`id_contest`) REFERENCES `contest` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `eigen_kriteria`
--
ALTER TABLE `eigen_kriteria`
  ADD CONSTRAINT `eigen_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria_skor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `eigen_kriteria_ibfk_2` FOREIGN KEY (`id_contest`) REFERENCES `contest` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `jurusan`
--
ALTER TABLE `jurusan`
  ADD CONSTRAINT `jurusan_ibfk_1` FOREIGN KEY (`idFk`) REFERENCES `fakultas` (`id`);

--
-- Ketidakleluasaan untuk tabel `pair_kriteria`
--
ALTER TABLE `pair_kriteria`
  ADD CONSTRAINT `pair_kriteria_ibfk_1` FOREIGN KEY (`id_kriteria`) REFERENCES `kriteria_skor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pair_kriteria_ibfk_2` FOREIGN KEY (`id_kriteria_pair`) REFERENCES `kriteria_skor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pair_kriteria_ibfk_3` FOREIGN KEY (`id_contest`) REFERENCES `contest` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pendaftar`
--
ALTER TABLE `pendaftar`
  ADD CONSTRAINT `pendaftar_ibfk_1` FOREIGN KEY (`idJrs`) REFERENCES `jurusan` (`id`);

--
-- Ketidakleluasaan untuk tabel `pendaftar_skor`
--
ALTER TABLE `pendaftar_skor`
  ADD CONSTRAINT `pendaftar_skor_ibfk_1` FOREIGN KEY (`idPendaftar`) REFERENCES `pendaftar` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pendaftar_skor_ibfk_2` FOREIGN KEY (`id_contest`) REFERENCES `contest` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pendaftar_skor_ibfk_3` FOREIGN KEY (`idKriteria`) REFERENCES `kriteria_skor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `pendaftar_skor_ibfk_4` FOREIGN KEY (`idSubKriteria`) REFERENCES `set_sub_kriteria_skor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `set_contest_kriteria_skor`
--
ALTER TABLE `set_contest_kriteria_skor`
  ADD CONSTRAINT `set_contest_kriteria_skor_ibfk_1` FOREIGN KEY (`idContest`) REFERENCES `contest` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `set_contest_kriteria_skor_ibfk_2` FOREIGN KEY (`idKriteriaSkor`) REFERENCES `kriteria_skor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `set_sub_kriteria_skor`
--
ALTER TABLE `set_sub_kriteria_skor`
  ADD CONSTRAINT `set_sub_kriteria_skor_ibfk_1` FOREIGN KEY (`idKriteriaSkor`) REFERENCES `kriteria_skor` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
