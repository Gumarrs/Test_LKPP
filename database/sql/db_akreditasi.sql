-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 22 Jan 2026 pada 20.20
-- Versi server: 10.4.28-MariaDB
-- Versi PHP: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_akreditasi`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `lppbjs`
--

CREATE TABLE `lppbjs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama_lppbj` varchar(255) NOT NULL,
  `kriteria` enum('Pemerintah','Non-Pemerintah') NOT NULL,
  `kategori` enum('A','B') NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `masa_berlaku` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `lppbjs`
--

INSERT INTO `lppbjs` (`id`, `nama_lppbj`, `kriteria`, `kategori`, `tanggal_mulai`, `masa_berlaku`, `created_at`, `updated_at`) VALUES
(1, 'Pusat Pendidikan dan Pelatihan SDM - Kementerian Lingkungan Hidup dan Kehutanan', 'Pemerintah', 'B', '2023-08-16', '2026-08-16', '2026-01-22 09:54:23', '2026-01-22 09:54:53'),
(2, 'Pusat Pendidikan dan Pelatihan - Kementerian Luar Negeri', 'Pemerintah', 'B', '2023-01-22', '2026-01-22', '2026-01-22 09:56:11', '2026-01-22 09:56:11'),
(3, 'Badan Pemerintahan SDM - Semarang', 'Pemerintah', 'A', '2023-05-23', '2026-05-23', '2026-01-22 09:57:10', '2026-01-22 09:57:10'),
(4, 'Mabes Tentara Nasional Indonesia - TNI AU', 'Non-Pemerintah', 'B', '2023-02-28', '2026-02-28', '2026-01-22 09:57:57', '2026-01-22 09:57:57'),
(5, 'Lembaga Pendidikan dan Pelatihan Gurindam', 'Non-Pemerintah', 'B', '2022-07-12', '2024-07-12', '2026-01-22 10:08:46', '2026-01-22 10:08:46'),
(6, 'Lembaga Kajian dan Pelatihan Manajemen (LKPM) IPWI', 'Non-Pemerintah', 'B', '2023-12-17', '2026-12-17', '2026-01-22 10:09:19', '2026-01-22 10:09:19'),
(7, 'Pusat Pendidikan dan Pelatihan - Kementerian Komunikasi dan Informatika', 'Pemerintah', 'B', '2022-06-06', '2025-06-06', '2026-01-22 10:45:17', '2026-01-22 10:45:17'),
(8, 'Pemerintah Kota Surakarta', 'Pemerintah', 'B', '2023-12-27', '2026-12-27', '2026-01-22 10:45:38', '2026-01-22 10:45:38'),
(9, 'Pemerintah Provinsi DI Yogyakarta', 'Pemerintah', 'B', '2025-03-25', '2028-03-25', '2026-01-22 10:46:02', '2026-01-22 10:46:02'),
(10, 'Diponegoro Smart Solution', 'Non-Pemerintah', 'A', '2023-03-30', '2028-03-30', '2026-01-22 10:46:24', '2026-01-22 10:46:24'),
(11, 'PPM Manajemen', 'Non-Pemerintah', 'A', '2023-04-23', '2028-04-23', '2026-01-22 10:46:52', '2026-01-22 10:46:52'),
(12, 'Lembaga Pengembangan dan Konsultasi Nasional (LPKN)', 'Non-Pemerintah', 'A', '2024-05-09', '2029-05-09', '2026-01-22 10:47:17', '2026-01-22 10:47:17'),
(13, 'Pusat Diklat Nasional (Pusdiknas)', 'Non-Pemerintah', 'A', '2019-05-01', '2024-05-01', '2026-01-22 10:47:43', '2026-01-22 10:47:43'),
(14, 'Badan Pusat Statistik', 'Pemerintah', 'A', '2021-04-20', '2026-04-20', '2026-01-22 10:48:09', '2026-01-22 10:48:09'),
(15, 'Icon Training Center', 'Non-Pemerintah', 'A', '2023-03-30', '2026-03-30', '2026-01-22 10:48:55', '2026-01-22 10:48:55'),
(16, 'Badan Pengembangan Sumber Daya Manusia - Pemerintah Provinsi Papua', 'Pemerintah', 'A', '2020-01-11', '2025-01-11', '2026-01-22 10:49:35', '2026-01-22 10:49:35'),
(17, 'Badan Pengembangan Sumber Daya Manusia - Pemerintah Provinsi Papua', 'Pemerintah', 'B', '2019-08-05', '2026-08-05', '2026-01-22 11:21:52', '2026-01-22 11:21:52');

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2026_01_22_131829_create_lppbjs_table', 1);

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','sekretariat','asesor') NOT NULL DEFAULT 'sekretariat',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Administrator', 'admin@lkpp.go.id', NULL, '$2y$10$0RZBN57995t15Qu1aVRRI.asSfVCV1z3NzG76DsIS46qO4C.Jf9T6', 'admin', NULL, '2026-01-22 09:49:51', '2026-01-22 09:49:51'),
(2, 'Staf Sekretariat', 'sekretariat@lkpp.go.id', NULL, '$2y$10$WmTVfBnlCO/hv9wpPdc/AeufvLckMXpe4XPu56PSTkyz/b9Qff8.e', 'sekretariat', NULL, '2026-01-22 09:49:51', '2026-01-22 11:14:53'),
(3, 'Tim Asesor', 'asesor@lkpp.go.id', NULL, '$2y$10$jFs1SyuPdaz9mxCDFw4e4eV4oVZcOZjuE69DnB0Jz1qa/G64p9bWu', 'asesor', NULL, '2026-01-22 09:49:51', '2026-01-22 09:49:51');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `lppbjs`
--
ALTER TABLE `lppbjs`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `lppbjs`
--
ALTER TABLE `lppbjs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
