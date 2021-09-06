-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Sep 2021 pada 08.49
-- Versi server: 10.4.19-MariaDB
-- Versi PHP: 7.4.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `symvaro_stations_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `core_projects`
--

CREATE TABLE `core_projects` (
  `id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(50) DEFAULT NULL,
  `organization` varchar(50) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  `is_valid` enum('Y','N') DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `core_projects`
--

INSERT INTO `core_projects` (`id`, `created`, `modified`, `name`, `organization`, `is_active`, `is_valid`) VALUES
(1, '2021-09-06 05:14:54', '2021-09-06 05:14:54', 'Tesla Charger', 'Tesla', 'Y', 'N'),
(2, '2021-09-06 05:14:54', '2021-09-06 05:14:54', 'Carinthia Charger', 'Carinthia Gov', 'Y', 'N');

-- --------------------------------------------------------

--
-- Struktur dari tabel `core_stations`
--

CREATE TABLE `core_stations` (
  `id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(11) NOT NULL DEFAULT 0,
  `port_id` int(11) DEFAULT 0,
  `project_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `street` varchar(255) NOT NULL,
  `number` varchar(50) NOT NULL,
  `zip` varchar(10) NOT NULL,
  `town` varchar(50) NOT NULL,
  `country` varchar(50) NOT NULL,
  `lat` text DEFAULT NULL,
  `long` text DEFAULT NULL,
  `is_active` enum('Y','N') NOT NULL DEFAULT 'Y',
  `is_valid` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `core_stations`
--

INSERT INTO `core_stations` (`id`, `created`, `modified`, `user_id`, `port_id`, `project_id`, `name`, `street`, `number`, `zip`, `town`, `country`, `lat`, `long`, `is_active`, `is_valid`) VALUES
(12, '2021-09-06 03:23:21', '2021-09-06 05:23:56', 62, 2, 2, 'Ebike Villach', 'Ringmauergasse', '10', '9400', 'Villach', 'Austria', NULL, NULL, 'Y', 'Y'),
(13, '2021-09-06 04:36:12', '2021-09-06 05:23:54', 62, 1, 2, 'Car Charging Station Klagenfurt', 'Funderstrasse', '01', '9020', 'Klagenfurt', 'Austria', '46.62209066910115', '14.318575859069826', 'Y', 'Y'),
(14, '2021-09-06 05:35:24', '2021-09-06 05:35:24', 62, 1, 0, 'Test', 'Ringmauergasse', '10', '70712', 'Villach', 'Austria', '46.6314566', '14.2974941', 'Y', 'Y');

-- --------------------------------------------------------

--
-- Struktur dari tabel `core_users`
--

CREATE TABLE `core_users` (
  `id` int(11) NOT NULL,
  `created` timestamp NULL DEFAULT current_timestamp(),
  `modified` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(64) DEFAULT NULL,
  `is_active` enum('Y','N') DEFAULT 'Y',
  `is_valid` enum('Y','N') DEFAULT 'N',
  `last_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `core_users`
--

INSERT INTO `core_users` (`id`, `created`, `modified`, `first_name`, `last_name`, `email`, `password`, `is_active`, `is_valid`, `last_login`) VALUES
(62, '2021-09-05 14:05:41', '2021-09-05 14:05:41', 'Rahmat', 'Ramadhani', 'ramadhani015@gmail.com', 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', 'Y', 'N', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `ref_charging_port`
--

CREATE TABLE `ref_charging_port` (
  `id` int(11) NOT NULL,
  `created` timestamp NOT NULL DEFAULT current_timestamp(),
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `name` varchar(100) NOT NULL,
  `usage` varchar(100) NOT NULL,
  `is_active` enum('Y','N') NOT NULL DEFAULT 'Y'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data untuk tabel `ref_charging_port`
--

INSERT INTO `ref_charging_port` (`id`, `created`, `modified`, `name`, `usage`, `is_active`) VALUES
(1, '2021-09-05 16:24:25', '2021-09-05 17:28:35', 'Car', 'car', 'Y'),
(2, '2021-09-05 16:24:25', '2021-09-05 17:28:37', 'Ebike', 'ebike', 'Y'),
(3, '2021-09-05 16:25:01', '2021-09-05 17:28:40', 'Boat', 'boat', 'Y');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `core_projects`
--
ALTER TABLE `core_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `core_stations`
--
ALTER TABLE `core_stations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `core_users`
--
ALTER TABLE `core_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indeks untuk tabel `ref_charging_port`
--
ALTER TABLE `ref_charging_port`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `core_projects`
--
ALTER TABLE `core_projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `core_stations`
--
ALTER TABLE `core_stations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT untuk tabel `core_users`
--
ALTER TABLE `core_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT untuk tabel `ref_charging_port`
--
ALTER TABLE `ref_charging_port`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
