-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 15 Nov 2026 pada 13.04
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
-- Database: `db_siacad_smk_2`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `guru`
--

CREATE TABLE `guru` (
  `id` int(11) NOT NULL,
  `nip` varchar(20) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `guru`
--

INSERT INTO `guru` (`id`, `nip`, `nama`, `jenis_kelamin`, `user_id`) VALUES
(25, '13456812', 'Sukanda Wiguna, S.T.Gr.', 'L', 51),
(26, '124568990', 'Mutiara Zahra,S.Pd.,Gr.,S.h.', '', 92),
(27, '34907907', 'Suci Sulastri. S.Kom,Gr.', '', 93),
(28, ' 19850312', 'Ahmad Fauzan, S.Pd.', '', 94),
(29, '19870615', 'Siti Nurhaliza, S.Pd.', '', 95),
(30, '19840921', 'Dedi Kurniawan, S.Pd', '', 96),
(31, '19880210', 'Rina Marlina, S.Pd.', '', 97),
(32, '19860518', 'Budi Santoso, S.Pd', '', 98),
(33, '19891123', 'Dewi Anggraini, S.Pd', '', 99),
(34, '19871219', 'Rizky Ramadhan, S.Pd.', '', 100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mapel`
--

CREATE TABLE `mapel` (
  `id` int(11) NOT NULL,
  `kode_mapel` varchar(10) NOT NULL,
  `nama_mapel` varchar(100) NOT NULL,
  `guru_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mapel`
--

INSERT INTO `mapel` (`id`, `kode_mapel`, `nama_mapel`, `guru_id`) VALUES
(12, 'MP001', 'Pemrograman Web dan Perangkat Bergerak', 25),
(13, 'MP002', 'Desain Grafis', 26),
(14, 'MP003', 'Data Base', 27),
(15, 'MP004', 'Bahasa Indonesia', 28),
(16, 'MP005', 'Matematika', 29),
(17, 'MP006', 'Bahasa Inggris', 32),
(18, 'MP007', 'Sejarah', 30),
(19, 'MP008', 'Kimia', 33),
(20, 'MP009', 'MS Office', 34),
(21, 'MP010', 'Kreativitas, Inovasi, dan Kewirausahawan', 31);

-- --------------------------------------------------------

--
-- Struktur dari tabel `mengajar`
--

CREATE TABLE `mengajar` (
  `id` int(11) NOT NULL,
  `mapel_id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `mengajar`
--

INSERT INTO `mengajar` (`id`, `mapel_id`, `siswa_id`) VALUES
(36, 12, 22),
(37, 12, 23),
(38, 12, 24),
(39, 12, 25),
(40, 12, 26),
(41, 12, 27),
(42, 12, 28),
(43, 12, 29),
(44, 12, 30),
(45, 12, 31),
(46, 12, 52),
(47, 13, 22),
(48, 13, 23),
(49, 13, 24),
(50, 13, 25),
(51, 13, 26),
(52, 13, 27),
(53, 13, 28),
(54, 13, 29),
(55, 13, 30),
(56, 13, 31),
(57, 13, 42),
(58, 13, 43),
(59, 13, 44),
(60, 13, 45),
(61, 13, 46),
(62, 13, 47),
(63, 13, 48),
(64, 13, 49),
(65, 13, 50),
(66, 13, 51),
(67, 13, 32),
(68, 13, 33),
(69, 13, 34),
(70, 13, 35),
(71, 13, 36),
(72, 13, 37),
(73, 13, 38),
(74, 13, 39),
(75, 13, 40),
(76, 13, 41),
(77, 13, 52),
(78, 13, 53),
(79, 13, 54),
(80, 13, 55),
(81, 13, 56),
(82, 13, 57),
(83, 13, 58),
(84, 13, 59),
(85, 13, 60),
(86, 13, 61),
(87, 14, 22),
(88, 14, 23),
(89, 14, 24),
(90, 14, 25),
(91, 14, 26),
(92, 14, 27),
(93, 14, 28),
(94, 14, 29),
(95, 14, 30),
(96, 14, 31),
(97, 14, 52),
(98, 14, 53),
(99, 14, 54),
(100, 14, 55),
(101, 14, 56),
(102, 14, 57),
(103, 14, 58),
(104, 14, 59),
(105, 14, 60),
(106, 14, 61),
(107, 15, 22),
(108, 15, 23),
(109, 15, 24),
(110, 15, 25),
(111, 15, 26),
(112, 15, 27),
(113, 15, 28),
(114, 15, 29),
(115, 15, 30),
(116, 15, 31),
(117, 15, 32),
(118, 15, 33),
(119, 15, 34),
(120, 15, 35),
(121, 15, 36),
(122, 15, 37),
(123, 15, 38),
(124, 15, 39),
(125, 15, 40),
(126, 15, 41),
(127, 15, 52),
(128, 15, 53),
(129, 15, 54),
(130, 15, 55),
(131, 15, 56),
(132, 15, 57),
(133, 15, 58),
(134, 15, 59),
(135, 15, 60),
(136, 15, 61),
(137, 16, 22),
(138, 16, 23),
(139, 16, 24),
(140, 16, 25),
(141, 16, 26),
(142, 16, 27),
(143, 16, 28),
(144, 16, 29),
(145, 16, 30),
(146, 16, 31),
(147, 16, 32),
(148, 16, 33),
(149, 16, 34),
(150, 16, 35),
(151, 16, 36),
(152, 16, 37),
(153, 16, 38),
(154, 16, 39),
(155, 16, 40),
(156, 16, 41),
(157, 16, 42),
(158, 16, 43),
(159, 16, 44),
(160, 16, 45),
(161, 16, 46),
(162, 16, 47),
(163, 16, 48),
(164, 16, 49),
(165, 16, 50),
(166, 16, 51),
(167, 16, 52),
(168, 16, 53),
(169, 16, 54),
(170, 16, 55),
(171, 16, 56),
(172, 16, 57),
(173, 16, 58),
(174, 16, 59),
(175, 16, 60),
(176, 16, 61),
(177, 17, 22),
(178, 17, 23),
(179, 17, 24),
(180, 17, 25),
(181, 17, 26),
(182, 17, 27),
(183, 17, 28),
(184, 17, 29),
(185, 17, 30),
(186, 17, 31),
(187, 17, 42),
(188, 17, 43),
(189, 17, 44),
(190, 17, 45),
(191, 17, 46),
(192, 17, 47),
(193, 17, 48),
(194, 17, 49),
(195, 17, 50),
(196, 17, 51),
(197, 18, 22),
(198, 18, 23),
(199, 18, 24),
(200, 18, 25),
(201, 18, 26),
(202, 18, 27),
(203, 18, 28),
(204, 18, 29),
(205, 18, 30),
(206, 18, 31),
(207, 18, 32),
(208, 18, 33),
(209, 18, 34),
(210, 18, 35),
(211, 18, 36),
(212, 18, 37),
(213, 18, 38),
(214, 18, 39),
(215, 18, 40),
(216, 18, 41),
(217, 19, 32),
(218, 19, 33),
(219, 19, 34),
(220, 19, 35),
(221, 19, 36),
(222, 19, 37),
(223, 19, 38),
(224, 19, 39),
(225, 19, 40),
(226, 19, 41),
(227, 19, 42),
(228, 19, 43),
(229, 19, 44),
(230, 19, 45),
(231, 19, 46),
(232, 19, 47),
(233, 19, 48),
(234, 19, 49),
(235, 19, 50),
(236, 19, 51),
(237, 20, 22),
(238, 20, 23),
(239, 20, 24),
(240, 20, 25),
(241, 20, 26),
(242, 20, 27),
(243, 20, 28),
(244, 20, 29),
(245, 20, 30),
(246, 20, 31),
(247, 21, 32),
(248, 21, 33),
(249, 21, 34),
(250, 21, 35),
(251, 21, 36),
(252, 21, 37),
(253, 21, 38),
(254, 21, 39),
(255, 21, 40),
(256, 21, 41),
(257, 21, 52),
(258, 21, 53),
(259, 21, 54),
(260, 21, 55),
(261, 21, 56),
(262, 21, 57),
(263, 21, 58),
(264, 21, 59),
(265, 21, 60),
(266, 21, 61);

-- --------------------------------------------------------

--
-- Struktur dari tabel `nilai_rapor`
--

CREATE TABLE `nilai_rapor` (
  `id` int(11) NOT NULL,
  `siswa_id` int(11) NOT NULL,
  `mapel_id` int(11) NOT NULL,
  `nilai_kkm` int(11) DEFAULT 75,
  `nilai_pengetahuan` int(11) DEFAULT NULL,
  `nilai_keterampilan` int(11) DEFAULT NULL,
  `Keterangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `nilai_rapor`
--

INSERT INTO `nilai_rapor` (`id`, `siswa_id`, `mapel_id`, `nilai_kkm`, `nilai_pengetahuan`, `nilai_keterampilan`, `Keterangan`) VALUES
(9, 22, 12, 75, 91, 85, 'good, pertahankan dan tingkatkan.'),
(10, 23, 12, 75, 89, 88, 'good, tingkatkan.'),
(11, 24, 12, 75, 83, 86, 'tingkatkan'),
(12, 25, 12, 75, 79, 82, 'tingkatkan '),
(13, 26, 12, 75, 80, 83, 'tingkatkan'),
(14, 27, 12, 75, 86, 85, 'good'),
(15, 28, 12, 75, 81, 84, 'good'),
(16, 29, 12, 75, 82, 80, 'tingkatkan'),
(17, 30, 12, 75, 77, 79, 'tingkatkan '),
(18, 31, 12, 75, 85, 84, 'good\r\n'),
(19, 52, 12, 75, 87, 86, 'good'),
(20, 53, 12, 75, 79, 75, 'tingkatkan'),
(21, 54, 12, 75, 80, 82, 'nicee'),
(22, 55, 12, 75, 80, 80, 'tingkatkan'),
(23, 56, 12, 75, 83, 85, 'good'),
(24, 57, 12, 75, 81, 81, 'good'),
(25, 58, 12, 75, 82, 83, 'good'),
(26, 59, 12, 75, 82, 81, 'good'),
(27, 60, 12, 75, 80, 82, ''),
(28, 61, 12, 75, 85, 84, ''),
(29, 22, 13, 75, 84, 85, ''),
(30, 23, 13, 75, 83, 82, ''),
(31, 24, 13, 75, 78, 80, ''),
(32, 25, 13, 75, 80, 81, ''),
(33, 26, 13, 75, 80, 80, ''),
(34, 27, 13, 75, 83, 85, ''),
(35, 28, 13, 75, 80, 82, ''),
(36, 29, 13, 75, 83, 80, ''),
(37, 30, 13, 75, 76, 77, ''),
(38, 31, 13, 75, 81, 81, ''),
(39, 32, 13, 75, 79, 80, ''),
(40, 33, 13, 75, 82, 80, ''),
(41, 34, 13, 75, 80, 80, ''),
(42, 35, 13, 75, 82, 81, ''),
(43, 36, 13, 75, 84, 85, ''),
(44, 37, 13, 75, 80, 81, ''),
(45, 38, 13, 75, 80, 82, ''),
(46, 39, 13, 75, 81, 79, ''),
(47, 41, 13, 75, 85, 86, ''),
(48, 40, 13, 75, 73, 74, ''),
(49, 42, 13, 75, 79, 80, ''),
(50, 43, 13, 75, 80, 81, ''),
(51, 44, 13, 75, 89, 81, ''),
(52, 45, 13, 75, 80, 84, ''),
(53, 46, 13, 75, 75, 76, ''),
(54, 47, 13, 75, 83, 81, ''),
(55, 48, 13, 75, 79, 81, ''),
(56, 49, 13, 75, 84, 83, ''),
(57, 50, 13, 79, 78, 78, ''),
(58, 51, 13, 75, 80, 83, ''),
(59, 52, 13, 75, 90, 85, ''),
(60, 53, 13, 75, 78, 80, ''),
(61, 54, 13, 75, 79, 78, ''),
(62, 55, 13, 75, 86, 85, ''),
(63, 56, 13, 75, 83, 83, ''),
(64, 57, 13, 75, 80, 80, ''),
(65, 58, 13, 75, 82, 80, ''),
(66, 59, 13, 75, 82, 81, ''),
(67, 60, 13, 75, 89, 84, ''),
(68, 61, 13, 75, 84, 84, ''),
(69, 22, 14, 75, 83, 83, ''),
(70, 23, 14, 75, 80, 81, ''),
(71, 24, 14, 75, 83, 80, ''),
(72, 25, 14, 75, 79, 79, ''),
(73, 26, 14, 75, 81, 80, ''),
(74, 27, 14, 75, 80, 80, ''),
(75, 28, 14, 75, 79, 81, ''),
(76, 29, 14, 75, 83, 81, ''),
(77, 30, 14, 75, 80, 83, ''),
(78, 31, 14, 75, 80, 85, ''),
(79, 52, 14, 75, 80, 83, ''),
(80, 53, 14, 75, 85, 80, ''),
(81, 54, 14, 75, 80, 79, ''),
(82, 55, 14, 75, 86, 80, ''),
(83, 56, 14, 75, 87, 86, ''),
(84, 57, 14, 75, 80, 85, ''),
(85, 58, 14, 75, 78, 77, ''),
(86, 59, 14, 75, 84, 84, ''),
(87, 60, 14, 75, 79, 86, ''),
(88, 61, 14, 75, 82, 81, ''),
(89, 22, 15, 75, 82, 82, ''),
(90, 23, 15, 75, 79, 83, ''),
(91, 24, 15, 75, 79, 80, ''),
(92, 25, 15, 75, 80, 84, ''),
(93, 26, 15, 75, 83, 83, ''),
(94, 27, 15, 75, 82, 82, ''),
(95, 28, 15, 75, 79, 79, ''),
(96, 29, 15, 75, 81, 81, ''),
(97, 30, 15, 75, 76, 80, ''),
(98, 31, 15, 75, 82, 81, ''),
(99, 32, 15, 75, 80, 81, ''),
(100, 33, 15, 75, 81, 81, ''),
(101, 34, 15, 75, 79, 80, ''),
(102, 35, 15, 75, 83, 84, ''),
(103, 36, 15, 75, 80, 80, ''),
(105, 37, 15, 75, 81, 82, ''),
(106, 38, 15, 75, 79, 84, ''),
(107, 39, 15, 75, 80, 80, ''),
(108, 40, 15, 75, 76, 77, ''),
(109, 41, 15, 75, 80, 83, ''),
(110, 52, 15, 75, 83, 83, ''),
(111, 53, 15, 75, 80, 81, ''),
(112, 54, 15, 75, 80, 80, ''),
(113, 55, 15, 75, 83, 82, ''),
(114, 56, 15, 75, 80, 83, ''),
(115, 57, 15, 75, 82, 82, ''),
(116, 58, 15, 75, 80, 79, ''),
(117, 59, 15, 75, 78, 80, ''),
(118, 60, 15, 75, 79, 82, ''),
(119, 61, 15, 75, 77, 80, ''),
(120, 22, 20, 75, 82, 82, ''),
(121, 23, 20, 75, 80, 83, ''),
(122, 24, 20, 75, 79, 81, ''),
(123, 25, 20, 75, 80, 80, ''),
(124, 26, 20, 75, 77, 80, ''),
(125, 27, 20, 75, 82, 82, ''),
(126, 28, 20, 75, 79, 80, ''),
(127, 29, 20, 75, 80, 82, ''),
(128, 30, 20, 75, 80, 81, ''),
(129, 31, 20, 75, 100, 85, ''),
(130, 32, 21, 75, 80, 80, ''),
(131, 33, 21, 75, 80, 80, ''),
(132, 34, 21, 75, 79, 82, ''),
(133, 35, 21, 75, 81, 81, ''),
(134, 36, 21, 75, 82, 81, ''),
(135, 37, 21, 75, 80, 82, ''),
(136, 38, 21, 75, 80, 80, ''),
(137, 39, 21, 75, 79, 80, ''),
(138, 40, 21, 75, 80, 81, ''),
(139, 41, 21, 75, 80, 80, ''),
(140, 52, 21, 75, 80, 82, ''),
(141, 53, 21, 75, 80, 80, ''),
(142, 54, 21, 75, 84, 81, ''),
(143, 55, 21, 75, 80, 80, ''),
(144, 56, 21, 75, 80, 80, ''),
(145, 57, 21, 75, 80, 80, ''),
(146, 58, 21, 75, 80, 80, ''),
(147, 59, 21, 75, 79, 80, ''),
(148, 60, 21, 75, 79, 79, ''),
(149, 61, 21, 75, 80, 80, ''),
(150, 22, 16, 75, 85, 83, ''),
(151, 23, 16, 75, 80, 80, ''),
(152, 24, 16, 75, 80, 80, ''),
(153, 25, 16, 75, 80, 80, ''),
(154, 26, 16, 75, 80, 80, ''),
(155, 27, 16, 75, 80, 80, ''),
(156, 28, 16, 75, 80, 80, ''),
(157, 29, 16, 75, 80, 80, ''),
(158, 30, 16, 75, 80, 80, ''),
(159, 31, 16, 75, 80, 80, ''),
(160, 32, 16, 75, 80, 80, ''),
(161, 33, 16, 75, 80, 80, ''),
(162, 34, 16, 75, 80, 80, ''),
(163, 35, 16, 75, 80, 80, ''),
(164, 36, 16, 75, 80, 80, ''),
(165, 37, 16, 75, 80, 80, ''),
(166, 38, 16, 75, 80, 80, ''),
(167, 39, 16, 75, 80, 80, ''),
(168, 40, 16, 75, 80, 80, ''),
(169, 41, 16, 75, 80, 80, ''),
(170, 42, 16, 75, 80, 80, ''),
(171, 43, 16, 75, 80, 80, ''),
(172, 44, 16, 75, 80, 80, ''),
(173, 45, 16, 75, 80, 80, ''),
(174, 46, 16, 75, 80, 80, ''),
(175, 47, 16, 75, 80, 80, ''),
(176, 48, 16, 75, 80, 80, ''),
(177, 49, 16, 75, 80, 80, ''),
(178, 50, 16, 75, 80, 80, ''),
(179, 51, 16, 75, 80, 80, ''),
(180, 61, 16, 75, 80, 80, ''),
(181, 60, 16, 75, 80, 80, ''),
(182, 59, 16, 75, 80, 80, ''),
(183, 52, 16, 75, 80, 80, ''),
(184, 53, 16, 75, 80, 80, ''),
(185, 54, 16, 75, 80, 80, ''),
(186, 55, 16, 75, 80, 80, ''),
(187, 56, 16, 75, 80, 80, ''),
(188, 57, 16, 75, 80, 80, ''),
(189, 58, 16, 75, 80, 80, ''),
(190, 22, 18, 75, 80, 80, ''),
(191, 23, 18, 75, 80, 80, ''),
(192, 24, 18, 75, 80, 80, ''),
(193, 25, 18, 75, 80, 80, ''),
(194, 26, 18, 75, 80, 80, ''),
(195, 27, 18, 75, 80, 80, ''),
(196, 31, 18, 75, 80, 80, ''),
(197, 30, 18, 75, 80, 80, ''),
(198, 28, 18, 75, 80, 80, ''),
(199, 29, 18, 75, 80, 80, ''),
(200, 32, 18, 75, 80, 80, ''),
(201, 33, 18, 75, 80, 80, ''),
(202, 41, 18, 75, 80, 80, ''),
(203, 40, 18, 75, 80, 80, ''),
(204, 39, 18, 75, 80, 80, ''),
(205, 34, 18, 75, 80, 80, ''),
(206, 35, 18, 75, 80, 80, ''),
(207, 38, 18, 75, 80, 80, ''),
(208, 37, 18, 75, 80, 80, ''),
(209, 36, 18, 75, 80, 80, ''),
(210, 22, 17, 75, 80, 80, ''),
(211, 23, 17, 75, 80, 80, ''),
(212, 24, 17, 75, 80, 80, ''),
(213, 25, 17, 75, 80, 80, ''),
(214, 26, 17, 75, 80, 80, ''),
(215, 31, 17, 75, 80, 80, ''),
(216, 30, 17, 75, 80, 80, ''),
(217, 29, 17, 75, 80, 80, ''),
(218, 28, 17, 75, 80, 80, ''),
(219, 27, 17, 75, 80, 80, ''),
(220, 42, 17, 75, 80, 80, ''),
(221, 43, 17, 75, 80, 80, ''),
(222, 44, 17, 75, 80, 80, ''),
(223, 51, 17, 75, 80, 80, ''),
(224, 50, 17, 75, 80, 80, ''),
(225, 49, 17, 75, 80, 80, ''),
(226, 48, 17, 75, 80, 80, ''),
(227, 47, 17, 75, 80, 80, ''),
(228, 46, 17, 75, 80, 80, ''),
(229, 45, 17, 75, 80, 80, ''),
(230, 41, 19, 75, 80, 80, ''),
(231, 40, 19, 75, 80, 80, ''),
(232, 39, 19, 75, 80, 80, ''),
(233, 32, 19, 75, 80, 80, ''),
(234, 33, 19, 75, 80, 80, ''),
(235, 38, 19, 75, 80, 80, ''),
(236, 37, 19, 75, 80, 80, ''),
(237, 34, 19, 75, 80, 80, ''),
(238, 36, 19, 75, 80, 80, ''),
(239, 35, 19, 75, 80, 80, ''),
(240, 42, 19, 75, 80, 80, ''),
(241, 51, 19, 75, 80, 80, ''),
(242, 50, 19, 75, 80, 80, ''),
(243, 49, 19, 75, 80, 80, ''),
(244, 48, 19, 75, 80, 80, ''),
(245, 47, 19, 75, 80, 80, ''),
(246, 46, 19, 75, 80, 80, ''),
(247, 45, 19, 75, 80, 80, ''),
(248, 44, 19, 75, 80, 80, ''),
(249, 43, 19, 75, 80, 80, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `siswa`
--

CREATE TABLE `siswa` (
  `id` int(11) NOT NULL,
  `nis` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `kelas` varchar(10) NOT NULL,
  `jenis_kelamin` enum('L','P') NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama`, `kelas`, `jenis_kelamin`, `user_id`) VALUES
(22, '22231001', 'Ahmad Fauzi', 'XI RPL 1', '', 52),
(23, '22231002', 'Aisyah Putri', 'XI RPL 1', '', 53),
(24, '22231003', 'Budi Santoso', 'XI RPL 1', '', 54),
(25, '22231004', 'Citra Dewi', 'XI RPL 1', '', 55),
(26, '22231005', 'Daffa Pratama', 'XI RPL 1', '', 56),
(27, '22231006', 'Dina Rahmawati', 'XI RPL 1', '', 57),
(28, '22231007', 'Eko Nugroho', 'XI RPL 1', '', 58),
(29, '22231008', 'Fina Lestari', 'XI RPL 1', '', 59),
(30, '22231009', 'Gilang Ramadhan', 'XI RPL 1', '', 60),
(31, '22231010', 'Hania Salsabila', 'XI RPL 1', '', 61),
(32, '22231011', 'Indra Wijaya', 'XI RPL 2', '', 62),
(33, '22231012', 'Intan Nuraini', 'XI RPL 2', '', 63),
(34, '22231013', 'Joko Susilo', 'XI RPL 2', '', 64),
(35, '22231014', 'Kartika Sari', 'XI RPL 2', '', 65),
(36, '22231015', 'Kevin Sanjaya', 'XI RPL 2', '', 66),
(37, '22231016', 'Laila Majnun', 'XI RPL 2', '', 67),
(38, '22231017', 'Muhammad Rizky', 'XI RPL 2', '', 68),
(39, '22231018', 'Nabila Syakieb', 'XI RPL 2', '', 69),
(40, '22231019', 'Naufal Hidayat', 'XI RPL 2', '', 70),
(41, '22231020', 'Olivia Zalianty', 'XI RPL 2', '', 71),
(42, '22231021', 'Panji Ahmad', 'XI RPL 3', '', 72),
(43, '22231022', 'Putri Ayu', 'XI RPL 3', '', 73),
(44, '22231023', 'Qaisar Al-Fatih', 'XI RPL 3', '', 74),
(45, '22231024', 'Rania Zahra', 'XI RPL 3', '', 75),
(46, '22231025', 'Rezza Pratama', 'XI RPL 3', '', 76),
(47, '22231026', 'Rina Melati', 'XI RPL 3', '', 77),
(48, '22231027', 'Satria Perkasa', 'XI RPL 3', '', 78),
(49, '22231028', 'Siti Aminah', 'XI RPL 3', '', 79),
(50, '22231029', 'Taufik Hidayat', 'XI RPL 3', '', 80),
(51, '22231030', 'Tiara Andini', 'XI RPL 3', '', 81),
(52, '22231031', 'Umar Farooq', 'XI RPL 4', '', 82),
(53, '22231032', 'Vira Panduwinata', 'XI RPL 4', '', 83),
(54, '22231033', 'Wahyu Setiawan ', 'XI RPL 4', '', 84),
(55, '22231034', 'Winda Utami', 'XI RPL 4', '', 85),
(56, '22231035', 'Xavier Hermansyah', 'XI RPL 4', '', 86),
(57, '22231036', 'Yasmin Maharani', 'XI RPL 4', '', 87),
(58, '22231037', 'Yoga Pratama', 'XI RPL 4', '', 88),
(59, '22231038', 'Yulia Rachman', 'XI RPL 4', '', 89),
(60, '22231039', 'Zainal Abidin', 'XI RPL 4', '', 90),
(61, '22231040', 'Zhafira Az-Zahra', 'XI RPL 4', '', 91);

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','guru','siswa') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`) VALUES
(1, 'admin.nasir', '123', 'admin', '2026-08-23 03:07:35'),
(51, 'sukanda13', '$2y$10$Sx9J2h.6Y5jZ9k8OfX.XwOkoUMcd8fT9wyPOYJNT0sb6Zs3cLcfHi', 'guru', '2026-10-28 04:39:13'),
(52, 'ahmad1', '$2y$10$dN0MJN6RsP9PqDR5ZdFDFe6SxZuE/Wi3oQqHCE5hiUqbBk6WBOc5u', 'siswa', '2026-10-28 04:40:42'),
(53, 'putri2', '$2y$10$4dqGBa6iVtSP2Sh7Qmx5RumZrifTHimKiuWDb2rhItM6CJPDXc31W', 'siswa', '2026-10-29 09:16:11'),
(54, 'budi3', '$2y$10$KYDTKXjDk.b7p8DpZmyOz./HLkN7o82hIzi6.DsS1zJCyPjwpmDDW', 'siswa', '2026-10-29 09:18:27'),
(55, 'citra4', '$2y$10$.BIPPT4YNb08ylixwF3HUOdhLIzR8nQuHImxPNSb3Ho159Tf5E.qa', 'siswa', '2026-10-29 09:19:15'),
(56, 'daffa5', '$2y$10$oE5QqgsAVHOupKxzU8VjEeF1.hoKIp.hTbeki26muwXUY7JI1.1Sy', 'siswa', '2026-10-29 09:21:44'),
(57, 'dina6', '$2y$10$t26RhZ.FHmpJBcWAjHtD9.77RIOS3l0nXN/lSVYjPLAqeKAApv.fK', 'siswa', '2026-10-29 09:28:48'),
(58, 'eko7', '$2y$10$mOUislNU3EoTIBk/HFbB8OAryHotCIGBSOVskm6AaTNdvECuM5942', 'siswa', '2026-10-29 09:29:51'),
(59, 'finaa8', '$2y$10$ikP1m/1VwribYlDx6mExjuOxbZ3w7.4S9FeG2wnRDLcHwszhjot8.', 'siswa', '2026-10-29 09:30:54'),
(60, 'gilang9', '$2y$10$rWC2ssWTGWe3qfopLhB/E.3l19sDjKzJNbWcI9NRCHtDLOpXg1eVO', 'siswa', '2026-10-29 09:32:38'),
(61, 'hania10', '$2y$10$hPI8QyUnGomuOZ9Fe/2sH.Gj5v9b1LFlxFVzDCM7s/8qH1BnNRyLe', 'siswa', '2026-10-29 09:34:23'),
(62, 'indra11', '$2y$10$hgxVjzEWJ3CWs8UsovGgy.RhoySm.RhFxLoh.uqhAhr7nVbfUZLyC', 'siswa', '2026-10-29 09:35:50'),
(63, 'intan12', '$2y$10$1kk7fqvCWVy3MKknK/12veSM4S0FSJKI5pdh9RiCxoYhqPzLbq7a6', 'siswa', '2026-10-29 09:37:58'),
(64, 'jokoo13', '$2y$10$NGxtYGW/5kcWyyyLBQitIObX0gbPE9xspUwS55Lth89SNTgFCVfEO', 'siswa', '2026-10-29 09:38:48'),
(65, 'kartikaa14', '$2y$10$omu3dIFpvs0ypBeJvJIcIeNckFw.MSgJ6L.Xbn/YSDhzPALDdeitG', 'siswa', '2026-10-29 09:39:58'),
(66, 'kevin15', '$2y$10$LbRwQ3/dDt.KOUI4aaxQ6OMDDad07gmp/G6apAcEky09s4aP2fym.', 'siswa', '2026-10-29 09:40:56'),
(67, 'laila16', '$2y$10$zF6HMDSnYMKfqfdAoqq.NeQLn0MV785p0X/irk3GwTxd42xdrLYia', 'siswa', '2026-10-29 09:46:09'),
(68, 'rizky17', '$2y$10$LUJTM0MZfGiXd6Dl.iMsnuIvBHT9sosNjWtwAbIAq8zuVSYIS9tFG', 'siswa', '2026-10-29 09:47:15'),
(69, 'nabila18', '$2y$10$vK1oReJLM9VSEnL0sc35o.W7lDLJiBncnEpt9aanl6wynga3Pdfja', 'siswa', '2026-10-29 09:50:28'),
(70, 'naufal19', '$2y$10$zAXI5/Ik4Gjanw9ilgTRfOrJGmmFMR88CwBD4N7B5FlUgo/Fv8qlO', 'siswa', '2026-10-29 09:52:03'),
(71, 'oliviaa20', '$2y$10$z3Qy8tNUxUzGzo48lbDjseB.6YNVQgcT9hmAtYa6y2mgvjd2GS9gO', 'siswa', '2026-10-29 09:53:12'),
(72, 'panji21', '$2y$10$rP1tuy3Pl2vlo1soBn06peGnx7KqaWj9K4/BaS598eQXQYrTh6BQ6', 'siswa', '2026-10-29 11:13:09'),
(73, 'putriayu22', '$2y$10$uLGnWWsIVHTquQ5ZX1DE/e3xRYBHn/w5F/ZZW1cqmVvBAD/CKlKm.', 'siswa', '2026-10-29 11:14:11'),
(74, 'qaisar23', '$2y$10$0RH26.RyaIQFpUc7JKADy.s6XC2ghRROQVAewxScTnzUEQmy5h42C', 'siswa', '2026-10-29 11:14:58'),
(75, 'rania24', '$2y$10$OPEQzt1DNMaQjL.8cQzyIudjRzo19TJQUK9dURclnCf0faOZfbfBO', 'siswa', '2026-10-29 11:16:55'),
(76, 'rezza25', '$2y$10$jVXMUfE3mM6pPfuMiKe3geOI./wxH08pOOBPJwywR26s4NOClcyfq', 'siswa', '2026-10-29 11:44:20'),
(77, 'riname26', '$2y$10$77EPq4q/VdYXL3ELz9te7uX3PrMLgxY8YKO7GdT4r9UAJdT6ZPaIy', 'siswa', '2026-10-29 11:45:39'),
(78, 'satria27', '$2y$10$lJecdyQQHTyIJ26pDwbdEONf6xYCHJ4xEmx63OuqCA5UIJg7j4mq6', 'siswa', '2026-10-29 11:47:23'),
(79, 'siti28', '$2y$10$v5g7R708u23s015p6zFBDeHQ6I1ni6J8ljSbREe9LobbWXowZOLay', 'siswa', '2026-10-29 11:48:09'),
(80, 'taufik299', '$2y$10$0BF8jOCr4atyLpfdck2tKuD0aeVG4PQuKcOkQaCi0kTjycFbY7p16', 'siswa', '2026-10-29 11:49:09'),
(81, 'tiara300', '$2y$10$zKqRnWJzSW35RnHo6zN31eacTKyeJiKhinc1vcJbpQnr11PFbVP6S', 'siswa', '2026-10-29 11:50:06'),
(82, 'umarfa31', '$2y$10$FH0NjxKExJjCUIN0cp7FKu/6iJvzoteBcnxRkieA.BLjJVI1KTdu2', 'siswa', '2026-10-29 12:09:30'),
(83, 'vira32', '$2y$10$cZZMHlTXXinygDVvIZR2EutjdlYM5vGDuoy.EZquQYdTb9ckYcfF.', 'siswa', '2026-10-29 12:27:03'),
(84, 'wahyuu33', '$2y$10$X.0VjvpFTYSf6cFymdyEHuD/MuDQle4215TcoCDV2VvKCb/KpjZie', 'siswa', '2026-10-29 12:28:17'),
(85, 'windauta34', '$2y$10$M1A5eDgXXsOuxIyv1KZq9uBaGhD8e9kyUW6sRyNo9PU09dyIvIY0.', 'siswa', '2026-10-29 12:30:00'),
(86, 'xavier35', '$2y$10$xB.5Qpy3hgjqDmz.WDCrXez9pNijD0wirNg31wRGwGYcfNA2r5dgy', 'siswa', '2026-10-29 12:34:27'),
(87, 'yasmin36', '$2y$10$PUoIRt8RnlXDpZ4TUkTjO.Bcff4.iYNI8EY0WshUuFd2gLC.sdITe', 'siswa', '2026-10-29 12:39:02'),
(88, 'yoga37', '$2y$10$PUPKm90pQ9TxWKevlc7PCe2aV9lhJf.2DyBaobftR0HiUsycP3uSO', 'siswa', '2026-10-29 12:40:22'),
(89, 'yuliara38', '$2y$10$iAeGtOUZWeadg8PU3bJJOO/1ur1KyTPj.BPAJU0eqIY/C4ad2/8Se', 'siswa', '2026-10-29 12:41:13'),
(90, 'zainalab39', '$2y$10$.DNnYIOf17qzquqg8Bbrb.mPJZqnfDpWj2if4dPJuaCp2whpV1Jqe', 'siswa', '2026-10-29 12:42:20'),
(91, 'zhafiraaz40', '$2y$10$q.LDXYX22ZdwcXgEpxu9TusMU3ZGZa32Sg2REoWpl2dTfQMj.4VEe', 'siswa', '2026-10-29 12:44:46'),
(92, 'mutia19', '$2y$10$UvmVp6kxpR7ygA.hssdoau1NllPRPnjLiXgewL4dhCkl9BiTdaKqW', 'guru', '2026-11-07 13:23:07'),
(93, 'suci12', '$2y$10$JHwHso39j7lp3Opbm1c.ju.kAovghY.G7WZ/twfz3UAQQjdqogdKu', 'guru', '2026-11-07 13:29:55'),
(94, 'fauzan77', '$2y$10$9VlZa0P.fItt33FaBr7ZGugk0/6UjaYkW7sdjU.Xn8Sp.XXilQ/5.', 'guru', '2026-11-14 04:36:57'),
(95, 'nurha12', '$2y$10$NyOzbeyxXvwqc8dB2A2usuOIiH3oO9m3yCJ1ZvcDXuF5OCHxedQdW', 'guru', '2026-11-14 04:38:15'),
(96, 'dedi13', '$2y$10$Q15z99dCkMliuRzruAcu1eirDlR7tC05Cv055kNOQ5itDrQqomMoS', 'guru', '2026-11-14 04:41:15'),
(97, 'rina10', '$2y$10$VkY0v03m4anjV03kSDCAQO.CHGEU2zaMnBQX6.1DAS5fu.QvngA1i', 'guru', '2026-11-14 04:44:32'),
(98, 'santoso18', '$2y$10$nBicNSdmoVusx0HJ/DmNOOLhQ.5riQjH6PtTormqUYMzvQ/JjOZrS', 'guru', '2026-11-14 04:45:53'),
(99, 'anggraini23', '$2y$10$xMVqpwcBHnzzlDKS16VwAuZK8K5e6Zn6pk2YkHSsre92wRxIyjUue', 'guru', '2026-11-14 04:49:11'),
(100, 'kyrama19', '$2y$10$FerGcJ.j10Fumt799DKtPe6Ps58lLXzWapD3cdUxuT4QuocbD5ovu', 'guru', '2026-11-14 04:50:49');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nip` (`nip`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `kode_mapel` (`kode_mapel`),
  ADD KEY `guru_id` (`guru_id`);

--
-- Indeks untuk tabel `mengajar`
--
ALTER TABLE `mengajar`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `mapel_id` (`mapel_id`);

--
-- Indeks untuk tabel `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `siswa_id` (`siswa_id`),
  ADD KEY `mapel_id` (`mapel_id`);

--
-- Indeks untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nis` (`nis`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `guru`
--
ALTER TABLE `guru`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT untuk tabel `mapel`
--
ALTER TABLE `mapel`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT untuk tabel `mengajar`
--
ALTER TABLE `mengajar`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=267;

--
-- AUTO_INCREMENT untuk tabel `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=250;

--
-- AUTO_INCREMENT untuk tabel `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `guru`
--
ALTER TABLE `guru`
  ADD CONSTRAINT `guru_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `guru_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `mapel`
--
ALTER TABLE `mapel`
  ADD CONSTRAINT `mapel_ibfk_1` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `mapel_ibfk_2` FOREIGN KEY (`guru_id`) REFERENCES `guru` (`id`);

--
-- Ketidakleluasaan untuk tabel `mengajar`
--
ALTER TABLE `mengajar`
  ADD CONSTRAINT `mengajar_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`),
  ADD CONSTRAINT `mengajar_ibfk_2` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`);

--
-- Ketidakleluasaan untuk tabel `nilai_rapor`
--
ALTER TABLE `nilai_rapor`
  ADD CONSTRAINT `nilai_rapor_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_rapor_ibfk_2` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `nilai_rapor_ibfk_3` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`),
  ADD CONSTRAINT `nilai_rapor_ibfk_4` FOREIGN KEY (`mapel_id`) REFERENCES `mapel` (`id`);

--
-- Ketidakleluasaan untuk tabel `siswa`
--
ALTER TABLE `siswa`
  ADD CONSTRAINT `siswa_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `siswa_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
