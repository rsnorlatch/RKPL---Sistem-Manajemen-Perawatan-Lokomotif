-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 21 Apr 2026 pada 03.24
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
(1, 1, '2026-03-11 07:02:28');

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
(1, 'centralOffice', 'centralOffice@gmail.com', 'password'),
(2, 'titanium', 'titandeanova17042006@gmail.com', '$2y$10$bpH4UfPmdBIJBdOblrGcWOB26uHT2hyDMyx6TO8IpyNGx.zPDKtTq');

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
(1, 1, 1),
(2, 1, 1),
(3, 1, 1);

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
(2, 'username', 'email@mail.com', 'password');

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
(1, 1, 'model-1');

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
(7, 'user', 'email@email.email', 'password'),
(8, 'username', 'email@email.email', 'password'),
(9, 'maintainer', 'maintainer@gmail.com', 'maintainer');

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
(1, '2026-03-10 00:00:00', '2026-03-10 23:59:59', 1),
(2, '2026-05-01 00:00:00', '2026-05-01 23:59:59', 1);

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
(1, 1, 'Evaluasi Keamanan Lokomotif', 'Untuk mengetahui titik rentan dan kerusakan pada lokomotif', 'Pengecekan, penggantian mesin baru dan komponen baru');

-- --------------------------------------------------------

--
-- Struktur dari tabel `onsite_locomotive`
--

CREATE TABLE `onsite_locomotive` (
  `id` int(255) NOT NULL,
  `locomotive_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `rejected_call`
--

CREATE TABLE `rejected_call` (
  `id` int(255) NOT NULL,
  `call_id` int(255) DEFAULT NULL,
  `reason` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rejected_call`
--

INSERT INTO `rejected_call` (`id`, `call_id`, `reason`) VALUES
(1, 1, 'ffdfdfd'),
(2, 1, 'fdfdfd'),
(3, 1, 'fdfdfd');

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
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `accepted_call`
--
ALTER TABLE `accepted_call`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `calling`
--
ALTER TABLE `calling`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `central_office`
--
ALTER TABLE `central_office`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `confirmation_finish`
--
ALTER TABLE `confirmation_finish`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `confirmation_problem`
--
ALTER TABLE `confirmation_problem`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `driver`
--
ALTER TABLE `driver`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- AUTO_INCREMENT untuk tabel `maintenance_schedule`
--
ALTER TABLE `maintenance_schedule`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `maintenance_unit`
--
ALTER TABLE `maintenance_unit`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `onsite_locomotive`
--
ALTER TABLE `onsite_locomotive`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `rejected_call`
--
ALTER TABLE `rejected_call`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

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
-- Ketidakleluasaan untuk tabel `locomotive`
--
ALTER TABLE `locomotive`
  ADD CONSTRAINT `locomotive_ibfk_1` FOREIGN KEY (`driver_id`) REFERENCES `driver` (`id`);

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
