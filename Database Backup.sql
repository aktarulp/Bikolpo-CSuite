-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 07, 2025 at 05:57 PM
-- Server version: 8.4.3
-- PHP Version: 8.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bikolpolive`
--

-- --------------------------------------------------------

--
-- Table structure for table `ac_roles`
--

CREATE TABLE `ac_roles` (
  `id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `display_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `level` int NOT NULL DEFAULT '1',
  `is_system` tinyint(1) NOT NULL DEFAULT '0',
  `is_default` tinyint(1) DEFAULT '0',
  `parent_role_id` bigint UNSIGNED DEFAULT NULL,
  `inherit_permissions` tinyint(1) DEFAULT '1',
  `permissions_inheritance_mode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'recursive',
  `created_by` bigint UNSIGNED DEFAULT NULL,
  `updated_by` bigint UNSIGNED DEFAULT NULL,
  `status` enum('active','inactive') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `permissions` json DEFAULT NULL,
  `flag` enum('active','inactive','deleted') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ac_roles`
--

INSERT INTO `ac_roles` (`id`, `name`, `display_name`, `description`, `level`, `is_system`, `is_default`, `parent_role_id`, `inherit_permissions`, `permissions_inheritance_mode`, `created_by`, `updated_by`, `status`, `permissions`, `flag`, `created_at`, `updated_at`) VALUES
(1, 'system_administrator', 'System Administrator', 'Super user with full system access', 1, 1, 1, NULL, 1, 'recursive', NULL, NULL, 'active', '{\"roles\": [\"full\"], \"users\": [\"full\"], \"system\": [\"full\"], \"reports\": [\"full\"], \"partners\": [\"full\"], \"settings\": [\"full\"], \"students\": [\"full\"], \"teachers\": [\"full\"], \"operators\": [\"full\"], \"permissions\": [\"full\"]}', 'active', '2025-10-07 05:52:14', '2025-10-07 05:52:14'),
(2, 'partner_admin', 'Partner Admin', 'Main administrator of each partner', 2, 1, 1, 1, 1, 'recursive', NULL, NULL, 'active', '{\"users\": [\"full\"], \"reports\": [\"full\"], \"settings\": [\"limited\"], \"students\": [\"full\"], \"teachers\": [\"full\"], \"operators\": [\"full\"]}', 'active', '2025-10-07 05:52:14', '2025-10-07 05:52:14'),
(3, 'student', 'Student', 'Student role with limited access', 3, 1, 1, 2, 1, 'recursive', NULL, NULL, 'active', '{\"grades\": [\"read\"], \"courses\": [\"read\"], \"profile\": [\"full\"], \"reports\": [\"read\"], \"assignments\": [\"read\"]}', 'active', '2025-10-07 05:52:14', '2025-10-07 05:52:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ac_roles`
--
ALTER TABLE `ac_roles`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `ac_roles_name_unique` (`name`),
  ADD KEY `ac_roles_parent_role_id_foreign` (`parent_role_id`),
  ADD KEY `ac_roles_created_by_foreign` (`created_by`),
  ADD KEY `ac_roles_updated_by_foreign` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ac_roles`
--
ALTER TABLE `ac_roles`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ac_roles`
--
ALTER TABLE `ac_roles`
  ADD CONSTRAINT `ac_roles_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `ac_users` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ac_roles_parent_role_id_foreign` FOREIGN KEY (`parent_role_id`) REFERENCES `ac_roles` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `ac_roles_updated_by_foreign` FOREIGN KEY (`updated_by`) REFERENCES `ac_users` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
