-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 11, 2025 at 05:34 AM
-- Server version: 8.0.30
-- PHP Version: 8.3.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sortir`
--

-- --------------------------------------------------------

--
-- Table structure for table `hashes`
--

CREATE TABLE `hashes` (
  `id` bigint UNSIGNED NOT NULL,
  `hash_value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hash_upload_log`
--

CREATE TABLE `hash_upload_log` (
  `id` bigint UNSIGNED NOT NULL,
  `hash_id` bigint UNSIGNED NOT NULL,
  `upload_log_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ip_addresses`
--

CREATE TABLE `ip_addresses` (
  `id` bigint UNSIGNED NOT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ip_address_upload_log`
--

CREATE TABLE `ip_address_upload_log` (
  `id` bigint UNSIGNED NOT NULL,
  `ip_address_id` bigint UNSIGNED NOT NULL,
  `upload_log_id` bigint UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '2025_09_09_041204_create_upload_logs_table', 1),
(3, '2025_09_09_041234_create_ip_addresses_table', 1),
(4, '2025_09_09_041244_create_hashes_table', 1),
(5, '2025_09_09_042747_create_ip_address_upload_log_table', 1),
(6, '2025_09_09_042756_create_hash_upload_log_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `upload_logs`
--

CREATE TABLE `upload_logs` (
  `id` bigint UNSIGNED NOT NULL,
  `user_id` bigint UNSIGNED NOT NULL,
  `comment` text COLLATE utf8mb4_unicode_ci,
  `data_type` enum('ip','hash') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$12$Kp5PdoFVqYi/GQcRPW23eOovWFI7FaTwsloyCDl88WF0YIbp5XCXK', '2025-09-11 05:34:18', '2025-09-11 05:34:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `hashes`
--
ALTER TABLE `hashes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `hashes_hash_value_unique` (`hash_value`);

--
-- Indexes for table `hash_upload_log`
--
ALTER TABLE `hash_upload_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hash_upload_log_hash_id_foreign` (`hash_id`),
  ADD KEY `hash_upload_log_upload_log_id_foreign` (`upload_log_id`);

--
-- Indexes for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ip_addresses_ip_address_unique` (`ip_address`);

--
-- Indexes for table `ip_address_upload_log`
--
ALTER TABLE `ip_address_upload_log`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ip_address_upload_log_ip_address_id_foreign` (`ip_address_id`),
  ADD KEY `ip_address_upload_log_upload_log_id_foreign` (`upload_log_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `upload_logs`
--
ALTER TABLE `upload_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `upload_logs_user_id_foreign` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `hashes`
--
ALTER TABLE `hashes`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hash_upload_log`
--
ALTER TABLE `hash_upload_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_addresses`
--
ALTER TABLE `ip_addresses`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ip_address_upload_log`
--
ALTER TABLE `ip_address_upload_log`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `upload_logs`
--
ALTER TABLE `upload_logs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hash_upload_log`
--
ALTER TABLE `hash_upload_log`
  ADD CONSTRAINT `hash_upload_log_hash_id_foreign` FOREIGN KEY (`hash_id`) REFERENCES `hashes` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hash_upload_log_upload_log_id_foreign` FOREIGN KEY (`upload_log_id`) REFERENCES `upload_logs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `ip_address_upload_log`
--
ALTER TABLE `ip_address_upload_log`
  ADD CONSTRAINT `ip_address_upload_log_ip_address_id_foreign` FOREIGN KEY (`ip_address_id`) REFERENCES `ip_addresses` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `ip_address_upload_log_upload_log_id_foreign` FOREIGN KEY (`upload_log_id`) REFERENCES `upload_logs` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `upload_logs`
--
ALTER TABLE `upload_logs`
  ADD CONSTRAINT `upload_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
