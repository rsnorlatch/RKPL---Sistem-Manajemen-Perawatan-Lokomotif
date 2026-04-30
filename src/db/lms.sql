-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 26 Apr 2026 pada 17.33
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
-- Database: `lms`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `accepted_call`
--

CREATE TABLE `accepted_call` (
  `id` int(255) NOT NULL,
  `call_id` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `accepted_call`
--

INSERT INTO `accepted_call` (`id`, `call_id`) VALUES
(1, 2),
(2, 3),
(3, 4),
(4, 5);

-- --------------------------------------------------------

--
-- Struktur dari tabel `calling`
--

CREATE TABLE `calling` (
  `id` int(255) NOT NULL,
  `driver_id` int(255) DEFAULT NULL,
  `call_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `calling`
--

INSERT INTO `calling` (`id`, `driver_id`, `call_time`) VALUES
(2, 3, '2026-04-24 17:51:37'),
(3, 5, '2026-04-25 13:22:52'),
(4, 5, '2026-04-26 07:45:44'),
(5, 5, '2026-04-26 10:40:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `central_office`
--

CREATE TABLE `central_office` (
  `id` int(255) NOT NULL,
  `username` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `central_office`
--

INSERT INTO `central_office` (`id`, `username`, `email`, `password`) VALUES
(1, 'centralOffice', 'centralOffice@gmail.com', 'password');

-- --------------------------------------------------------

--
-- Struktur dari tabel `central_office_preference`
--

CREATE TABLE `central_office_preference` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `theme` enum('Light','Dark') DEFAULT NULL,
  `language` enum('Indonesia','English') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `central_office_preference`
--

INSERT INTO `central_office_preference` (`id`, `user_id`, `theme`, `language`) VALUES
(1, 1, 'Dark', 'English');

-- --------------------------------------------------------

--
-- Struktur dari tabel `confirmation_finish`
--

CREATE TABLE `confirmation_finish` (
  `id` int(255) NOT NULL,
  `driver_id` int(255) NOT NULL,
  `calling_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `confirmation_finish`
--

INSERT INTO `confirmation_finish` (`id`, `driver_id`, `calling_id`) VALUES
(16, 5, 3),
(17, 5, 3);

-- --------------------------------------------------------

--
-- Struktur dari tabel `confirmation_problem`
--

CREATE TABLE `confirmation_problem` (
  `id` int(255) NOT NULL,
  `driver_id` int(255) NOT NULL,
  `calling_id` int(255) NOT NULL,
  `problem` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `confirmation_problem`
--

INSERT INTO `confirmation_problem` (`id`, `driver_id`, `calling_id`, `problem`) VALUES
(2, 5, 4, 'ada kendala'),
(3, 5, 5, 'terjadi kerusakan pada lokomotif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `driver`
--

CREATE TABLE `driver` (
  `id` int(255) NOT NULL,
  `username` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `driver`
--

INSERT INTO `driver` (`id`, `username`, `email`, `password`) VALUES
(1, 'user', 'email@mail.mail', 'jfiejifejif'),
(2, 'username', 'email@mail.com', 'password'),
(3, 'Masinis2', 'masinis@gmail.com', 'masinis3'),
(4, 'drver', 'driver@email.com', 'password'),
(5, 'driverbaru', 'driverbaru@gmail.com', 'driverbaru');

-- --------------------------------------------------------

--
-- Struktur dari tabel `driver_preference`
--

CREATE TABLE `driver_preference` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `theme` enum('Light','Dark') DEFAULT NULL,
  `language` enum('Indonesia','English') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `driver_preference`
--

INSERT INTO `driver_preference` (`id`, `user_id`, `theme`, `language`) VALUES
(1, 4, 'Light', 'Indonesia'),
(2, 5, 'Dark', 'English'),
(3, 3, 'Light', 'Indonesia'),
(5, 2, 'Light', 'Indonesia'),
(6, 1, 'Light', 'Indonesia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `locomotive`
--

CREATE TABLE `locomotive` (
  `id` int(255) NOT NULL,
  `driver_id` int(255) NOT NULL,
  `model` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `locomotive`
--

INSERT INTO `locomotive` (`id`, `driver_id`, `model`) VALUES
(1, 5, 'model-1');

-- --------------------------------------------------------

--
-- Struktur dari tabel `maintainer`
--

CREATE TABLE `maintainer` (
  `id` int(255) NOT NULL,
  `username` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `password` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `maintainer`
--

INSERT INTO `maintainer` (`id`, `username`, `email`, `password`) VALUES
(1, 'newmaintainer', 'maintainer@email.com', 'newmaintainer');

-- --------------------------------------------------------

--
-- Struktur dari tabel `maintainer_preference`
--

CREATE TABLE `maintainer_preference` (
  `id` int(255) NOT NULL,
  `user_id` int(255) DEFAULT NULL,
  `theme` enum('Light','Dark') DEFAULT NULL,
  `language` enum('Indonesia','English') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `maintainer_preference`
--

INSERT INTO `maintainer_preference` (`id`, `user_id`, `theme`, `language`) VALUES
(1, 1, 'Dark', 'English');

-- --------------------------------------------------------

--
-- Struktur dari tabel `maintenance_schedule`
--

CREATE TABLE `maintenance_schedule` (
  `id` int(255) NOT NULL,
  `start` datetime DEFAULT NULL,
  `end` datetime DEFAULT NULL,
  `locomotive_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `maintenance_schedule`
--

INSERT INTO `maintenance_schedule` (`id`, `start`, `end`, `locomotive_id`) VALUES
(1, '2026-04-15 00:00:00', '2026-04-15 23:59:59', 1),
(2, '2026-04-25 00:00:00', '2026-04-25 23:59:59', 1),
(3, '2026-04-22 00:00:00', '2026-04-22 23:59:59', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `maintenance_unit`
--

CREATE TABLE `maintenance_unit` (
  `id` int(255) NOT NULL,
  `sequence_number` int(255) DEFAULT NULL,
  `unit_name` text NOT NULL,
  `unit_description` text NOT NULL,
  `unit_type` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `maintenance_unit`
--

INSERT INTO `maintenance_unit` (`id`, `sequence_number`, `unit_name`, `unit_description`, `unit_type`) VALUES
(1, 1, 'Evaluasi Keamanan Lokomotif 2', 'Untuk mengetahui titik rentan dan kerusakan pada bagian dalam lokomotif ', 'Pengecekan, penggantian suku cadang mesin baru dan komponen baru '),
(2, 2, 'Evaluasi Keamanan Lokomotif', 'Untuk mengetahui titik rentan dan kerusakan pada bagian dalam lokomotif ', 'Pengecekan, penggantian suku cadang mesin baru dan komponen baru ');

-- --------------------------------------------------------

--
-- Struktur dari tabel `notification_balaiyasa`
--

CREATE TABLE `notification_balaiyasa` (
  `id` int(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `onsite_locomotive`
--

CREATE TABLE `onsite_locomotive` (
  `id` int(255) NOT NULL,
  `locomotive_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `onsite_locomotive`
--

INSERT INTO `onsite_locomotive` (`id`, `locomotive_id`) VALUES
(2, 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `rejected_call`
--

CREATE TABLE `rejected_call` (
  `id` int(255) NOT NULL,
  `call_id` int(255) DEFAULT NULL,
  `reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `send_request`
--

CREATE TABLE `send_request` (
  `id` int(255) NOT NULL,
  `locomotive_id` int(255) DEFAULT NULL,
  `destination_id` int(255) DEFAULT NULL,
  `request_time` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `send_request`
--

INSERT INTO `send_request` (`id`, `locomotive_id`, `destination_id`, `request_time`) VALUES
(1, 1, 1, '2026-04-08 15:38:37'),
(2, 1, 1, '2026-04-08 17:41:43'),
(3, 1, 1, '2026-04-08 17:41:46'),
(4, 1, 1, '2026-04-08 17:42:02'),
(5, 1, 1, '2026-04-08 17:42:07'),
(6, 1, 31, '2026-04-08 17:43:59'),
(7, 1, 3, '2026-04-23 06:19:43'),
(8, 1, 3, '2026-04-23 14:31:28'),
(9, 1, 17, '2026-04-23 15:26:13'),
(10, 1, 3, '2026-04-23 15:26:22'),
(11, 1, 35, '2026-04-23 16:55:54'),
(12, 1, 12, '2026-04-24 14:34:51'),
(13, 1, 17, '2026-04-24 15:01:21'),
(14, 1, 32, '2026-04-25 15:22:52'),
(15, 1, 35, '2026-04-26 09:45:44'),
(16, 1, 35, '2026-04-26 12:40:31');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stop`
--

CREATE TABLE `stop` (
  `id` int(255) NOT NULL,
  `name` text DEFAULT NULL,
  `x` float DEFAULT NULL,
  `y` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stop`
--

INSERT INTO `stop` (`id`, `name`, `x`, `y`) VALUES
(1, 'Jakarta Kota', -6.1376, 106.813),
(2, 'Gambir', -6.1767, 106.83),
(3, 'Pasar Senen', -6.1731, 106.853),
(4, 'Bekasi', -6.2383, 107.001),
(5, 'Cikarang', -6.2615, 107.14),
(6, 'Karawang', -6.3054, 107.3),
(7, 'Cikampek', -6.4064, 107.456),
(8, 'Purwakarta', -6.5567, 107.443),
(9, 'Bandung', -6.9175, 107.604),
(10, 'Kiaracondong', -6.9254, 107.643),
(11, 'Tasikmalaya', -7.3274, 108.221),
(12, 'Banjar', -7.3705, 108.541),
(13, 'Cilacap', -7.7267, 109.017),
(14, 'Kroya', -7.6333, 109.251),
(15, 'Purwokerto', -7.4242, 109.241),
(16, 'Kebumen', -7.6681, 109.654),
(17, 'Kutoarjo', -7.7211, 109.907),
(18, 'Yogyakarta', -7.7893, 110.364),
(19, 'Lempuyangan', -7.7829, 110.376),
(20, 'Solo Balapan', -7.5561, 110.821),
(21, 'Purwosari', -7.5653, 110.792),
(22, 'Sragen', -7.4282, 111.021),
(23, 'Madiun', -7.6185, 111.524),
(24, 'Nganjuk', -7.6051, 111.901),
(25, 'Kertosono', -7.5833, 112.1),
(26, 'Jombang', -7.545, 112.233),
(27, 'Mojokerto', -7.4722, 112.434),
(28, 'Surabaya Gubeng', -7.2654, 112.752),
(29, 'Surabaya Pasar Turi', -7.248, 112.731),
(30, 'Sidoarjo', -7.4465, 112.718),
(31, 'Bangil', -7.5994, 112.822),
(32, 'Pasuruan', -7.6453, 112.906),
(33, 'Probolinggo', -7.7543, 113.216),
(34, 'Klaten', -7.7056, 110.6),
(35, 'Magelang (Tidar area)', -7.4705, 110.213);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `accepted_call`
--
ALTER TABLE `accepted_call`
  ADD PRIMARY KEY (`id`),
  ADD KEY `call_id` (`call_id`);

--
-- Indeks untuk tabel `calling`
--
ALTER TABLE `calling`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indeks untuk tabel `central_office`
--
ALTER TABLE `central_office`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `central_office_preference`
--
ALTER TABLE `central_office_preference`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `confirmation_finish`
--
ALTER TABLE `confirmation_finish`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `calling_id` (`calling_id`);

--
-- Indeks untuk tabel `confirmation_problem`
--
ALTER TABLE `confirmation_problem`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`),
  ADD KEY `calling_id` (`calling_id`);

--
-- Indeks untuk tabel `driver`
--
ALTER TABLE `driver`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `driver_preference`
--
ALTER TABLE `driver_preference`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `locomotive`
--
ALTER TABLE `locomotive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `driver_id` (`driver_id`);

--
-- Indeks untuk tabel `maintainer`
--
ALTER TABLE `maintainer`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `maintainer_preference`
--
ALTER TABLE `maintainer_preference`
  ADD PRIMARY KEY (`id`),
  ADD KEY `maintainer_id` (`user_id`);

--
-- Indeks untuk tabel `maintenance_schedule`
--
ALTER TABLE `maintenance_schedule`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locomotive_id` (`locomotive_id`);

--
-- Indeks untuk tabel `maintenance_unit`
--
ALTER TABLE `maintenance_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `notification_balaiyasa`
--
ALTER TABLE `notification_balaiyasa`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `onsite_locomotive`
--
ALTER TABLE `onsite_locomotive`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locomotive_id` (`locomotive_id`);

--
-- Indeks untuk tabel `rejected_call`
--
ALTER TABLE `rejected_call`
  ADD PRIMARY KEY (`id`),
  ADD KEY `call_id` (`call_id`);

--
-- Indeks untuk tabel `send_request`
--
ALTER TABLE `send_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `locomotive_id` (`locomotive_id`),
  ADD KEY `destination_id` (`destination_id`);

--
-- Indeks untuk tabel `stop`
--
ALTER TABLE `stop`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `accepted_call`
--
ALTER TABLE `accepted_call`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `calling`
--
ALTER TABLE `calling`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `central_office`
--
ALTER TABLE `central_office`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `central_office_preference`
--
ALTER TABLE `central_office_preference`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `confirmation_finish`
--
ALTER TABLE `confirmation_finish`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `confirmation_problem`
--
ALTER TABLE `confirmation_problem`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `driver`
--
ALTER TABLE `driver`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `driver_preference`
--
ALTER TABLE `driver_preference`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `locomotive`
--
ALTER TABLE `locomotive`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `maintainer`
--
ALTER TABLE `maintainer`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `maintainer_preference`
--
ALTER TABLE `maintainer_preference`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `maintenance_schedule`
--
ALTER TABLE `maintenance_schedule`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `maintenance_unit`
--
ALTER TABLE `maintenance_unit`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `notification_balaiyasa`
--
ALTER TABLE `notification_balaiyasa`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `onsite_locomotive`
--
ALTER TABLE `onsite_locomotive`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `rejected_call`
--
ALTER TABLE `rejected_call`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `send_request`
--
ALTER TABLE `send_request`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `stop`
--
ALTER TABLE `stop`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `accepted_call`
--
ALTER TABLE `accepted_call`
  ADD CONSTRAINT `accepted_call_ibfk_1` FOREIGN KEY (`call_id`) REFERENCES `calling` (`id`);

--
-- Ketidakleluasaan untuk tabel `calling`
--
ALTER TABLE `calling`
  ADD CONSTRAINT `calling_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`);

--
-- Ketidakleluasaan untuk tabel `central_office_preference`
--
ALTER TABLE `central_office_preference`
  ADD CONSTRAINT `central_office_preference_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `central_office` (`id`);

--
-- Ketidakleluasaan untuk tabel `confirmation_finish`
--
ALTER TABLE `confirmation_finish`
  ADD CONSTRAINT `confirmation_finish_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`),
  ADD CONSTRAINT `confirmation_finish_ibfk_2` FOREIGN KEY (`calling_id`) REFERENCES `calling` (`id`);

--
-- Ketidakleluasaan untuk tabel `confirmation_problem`
--
ALTER TABLE `confirmation_problem`
  ADD CONSTRAINT `confirmation_problem_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`),
  ADD CONSTRAINT `confirmation_problem_ibfk_2` FOREIGN KEY (`calling_id`) REFERENCES `calling` (`id`);

--
-- Ketidakleluasaan untuk tabel `driver_preference`
--
ALTER TABLE `driver_preference`
  ADD CONSTRAINT `driver_preference_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `driver` (`id`);

--
-- Ketidakleluasaan untuk tabel `locomotive`
--
ALTER TABLE `locomotive`
  ADD CONSTRAINT `locomotive_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`);

--
-- Ketidakleluasaan untuk tabel `maintainer_preference`
--
ALTER TABLE `maintainer_preference`
  ADD CONSTRAINT `maintainer_preference_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `maintainer` (`id`);

--
-- Ketidakleluasaan untuk tabel `maintenance_schedule`
--
ALTER TABLE `maintenance_schedule`
  ADD CONSTRAINT `maintenance_schedule_ibfk_1` FOREIGN KEY (`locomotive_id`) REFERENCES `locomotive` (`id`);

--
-- Ketidakleluasaan untuk tabel `onsite_locomotive`
--
ALTER TABLE `onsite_locomotive`
  ADD CONSTRAINT `onsite_locomotive_ibfk_1` FOREIGN KEY (`locomotive_id`) REFERENCES `locomotive` (`id`);

--
-- Ketidakleluasaan untuk tabel `rejected_call`
--
ALTER TABLE `rejected_call`
  ADD CONSTRAINT `rejected_call_ibfk_1` FOREIGN KEY (`call_id`) REFERENCES `calling` (`id`);

--
-- Ketidakleluasaan untuk tabel `send_request`
--
ALTER TABLE `send_request`
  ADD CONSTRAINT `send_request_ibfk_1` FOREIGN KEY (`locomotive_id`) REFERENCES `locomotive` (`id`),
  ADD CONSTRAINT `send_request_ibfk_2` FOREIGN KEY (`destination_id`) REFERENCES `stop` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
