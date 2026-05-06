-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 03, 2026 at 06:09 AM
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
-- Database: `task_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `module` varchar(255) DEFAULT NULL,
  `title` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `log_name` varchar(255) DEFAULT NULL,
  `properties` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`properties`)),
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branches`
--

CREATE TABLE `branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `is_head_office` tinyint(4) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `settings` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`settings`)),
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `branch_departments`
--

CREATE TABLE `branch_departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `state_id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `state_id`, `country_id`, `name`, `is_active`, `is_deleted`, `deleted_at`, `deleted_by`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, NULL, 'Rajkot', 0, 0, NULL, NULL, 1, 1, '2026-01-05 01:24:16', '2026-01-05 01:26:49'),
(2, 1, NULL, 'Ahemdabad', 1, 0, NULL, NULL, 1, NULL, '2026-01-05 01:25:05', '2026-01-05 01:25:05'),
(3, 2, 3, 'Surat', 0, 0, NULL, NULL, 1, 1, '2026-01-05 01:26:07', '2026-01-06 01:15:07'),
(4, 1, NULL, 'gondal', 1, 1, '2026-01-05 04:54:43', 1, 1, 1, '2026-01-05 04:51:31', '2026-01-05 04:54:43'),
(5, 1, 6, 'Junagadh', 1, 0, NULL, NULL, 1, NULL, '2026-01-06 01:06:20', '2026-01-06 01:06:20'),
(6, 1, 6, 'sdfsdfsdf', 1, 1, '2026-01-06 02:07:02', 1, 1, NULL, '2026-01-06 01:58:02', '2026-01-06 02:07:02'),
(7, 1, 6, 'asddddddddddddd', 0, 0, NULL, NULL, 1, NULL, '2026-01-06 01:59:19', '2026-01-06 01:59:19');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `zip_code` varchar(255) DEFAULT NULL,
  `tax_id` varchar(255) DEFAULT NULL,
  `registration_number` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `registration_date` date DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `company_branches`
--

CREATE TABLE `company_branches` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `short_name` varchar(255) DEFAULT NULL,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `code`, `short_name`, `is_active`, `is_deleted`, `deleted_at`, `deleted_by`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'India1', '92', 'IND', 1, 1, '2026-01-02 06:02:56', 1, 1, 1, '2026-01-02 05:08:21', '2026-01-02 06:02:56'),
(3, 'Saudi Arabia', '1', 'SAU', 1, 0, NULL, NULL, 1, 1, '2026-01-02 05:57:22', '2026-01-02 06:50:00'),
(4, 'india', '911', 'IND', 1, 1, '2026-01-05 04:48:20', 1, 1, 1, '2026-01-02 06:46:49', '2026-01-05 04:48:20'),
(5, 'india2', '91554', 'INDdkjh', 0, 1, '2026-01-05 02:39:58', 1, 1, 1, '2026-01-05 02:24:24', '2026-01-05 02:39:58'),
(6, 'India', '91', 'IND', 1, 1, '2026-01-06 02:04:58', 1, 1, 1, '2026-01-06 01:04:39', '2026-01-06 02:04:58'),
(7, 'United States', '89', 'US', 0, 0, NULL, NULL, 1, NULL, '2026-01-06 02:04:34', '2026-01-06 02:04:34'),
(8, 'test', '8', 'tt', 1, 1, '2026-01-06 02:04:47', 1, 1, NULL, '2026-01-06 02:04:42', '2026-01-06 02:04:47'),
(9, 'awsds', '5', 'asd', 1, 1, '2026-01-06 02:11:43', 1, 1, NULL, '2026-01-06 02:11:36', '2026-01-06 02:11:43');

-- --------------------------------------------------------

--
-- Table structure for table `currencies`
--

CREATE TABLE `currencies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(30) NOT NULL,
  `symbol` varchar(30) NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `currencies`
--

INSERT INTO `currencies` (`id`, `name`, `code`, `symbol`, `country_id`, `is_active`, `is_deleted`, `deleted_at`, `deleted_by`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'Dollar', 'USDd', '$', 3, 1, 0, NULL, NULL, 1, 1, '2026-01-05 01:37:36', '2026-01-05 06:08:31'),
(2, 'Riyal', 'USD', '$', 3, 1, 0, NULL, NULL, 1, NULL, '2026-01-05 06:35:28', '2026-01-05 06:35:28'),
(3, 'test', 'asdasd', '$', 6, 1, 0, NULL, NULL, 1, NULL, '2026-01-06 01:54:46', '2026-01-06 01:54:46'),
(4, 'asdasdasd', 'asdasdasd', 'SAR', 6, 1, 0, NULL, NULL, 1, NULL, '2026-01-06 01:55:27', '2026-01-06 01:55:27'),
(5, 'sdfsdfsfsd', 'fasfsdf', '₹', 3, 1, 1, '2026-01-06 02:07:10', 1, 1, NULL, '2026-01-06 01:56:45', '2026-01-06 02:07:10'),
(6, 'asdsad', 'USD', '%', 6, 0, 0, NULL, NULL, 1, NULL, '2026-01-06 01:57:10', '2026-01-06 01:57:10');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `company_id` bigint(20) UNSIGNED NOT NULL,
  `branch_id` bigint(20) UNSIGNED DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `color_code` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `parent_department_id` bigint(20) UNSIGNED DEFAULT NULL,
  `head_role_id` bigint(20) UNSIGNED DEFAULT NULL,
  `manager_id` bigint(20) UNSIGNED DEFAULT NULL,
  `scope` enum('company','branch','global') NOT NULL DEFAULT 'company',
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
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
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `short_name` varchar(2) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`, `short_name`, `is_active`, `is_deleted`, `deleted_at`, `deleted_by`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'English', 'EN', 1, 0, NULL, NULL, 1, NULL, '2026-01-06 00:36:18', '2026-01-06 00:36:18'),
(2, 'Arabicw', 'AR', 0, 0, NULL, NULL, 1, 1, '2026-01-06 00:37:19', '2026-01-06 01:25:02'),
(3, 'Franch', 'FR', 1, 1, '2026-01-06 00:38:53', 1, 1, NULL, '2026-01-06 00:38:00', '2026-01-06 00:38:53'),
(4, 'test', 'sd', 0, 1, '2026-01-06 02:07:29', 1, 1, NULL, '2026-01-06 01:49:53', '2026-01-06 02:07:29');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_01_01_075450_create_companies_table', 2),
(5, '2026_01_01_081302_create_companies_table', 3),
(6, '2026_01_01_093442_create_user_companies_table', 3),
(7, '2026_01_01_111417_create_branches_table', 3),
(8, '2026_01_01_112034_create_departments_table', 3),
(9, '2026_01_01_112454_create_company_branches_table', 3),
(10, '2026_01_01_113203_create_branch_departments_table', 3),
(11, '2026_01_01_113406_create_activity_logs_table', 3),
(12, '2026_01_02_100000_create_countries_table', 3),
(14, '2026_01_02_110000_create_states_table', 4),
(15, '2026_01_05_055854_create_cities_table', 4),
(16, '2026_01_05_063949_create_currencies_table', 5),
(17, '2026_01_02_120503_create_countries_table', 6),
(18, '2026_01_02_130000_create_states_table', 6),
(19, '2026_01_05_075000_create_timezones_table', 6),
(20, '2026_01_06_create_languages_table', 7),
(21, '2026_01_06_add_country_id_to_cities_table', 8);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('97CEBZp1nBAFjh1rqQhRHlYTsS9Wlf7tyIA63GRP', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiZTdna2dGOHVCQUpZS2JoMjFKME1CVXVHejRxbEFScWlRZkxyWDJnUyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdXBlci1hZG1pbi9jdXJyZW5jaWVzIjtzOjU6InJvdXRlIjtzOjI4OiJzdXBlci1hZG1pbi1jdXJyZW5jaWVzLWluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTtzOjQ6InVzZXIiO2E6ODp7czoyOiJpZCI7aToxO3M6MTA6ImZpcnN0X25hbWUiO3M6NToiU3VwZXIiO3M6MTE6Im1pZGRsZV9uYW1lIjtzOjA6IiI7czo5OiJsYXN0X25hbWUiO3M6NToiQWRtaW4iO3M6OToiZnVsbF9uYW1lIjtzOjExOiJTdXBlciBBZG1pbiI7czo1OiJlbWFpbCI7czoyMjoic3VwZXJhZG1pbkBleGFtcGxlLmNvbSI7czo0OiJ0eXBlIjtzOjExOiJzdXBlcl9hZG1pbiI7czo2OiJzdGF0dXMiO2k6MTt9czo5OiJhcGlfdG9rZW4iO3M6MzIwOiJleUowZVhBaU9pSktWMVFpTENKaGJHY2lPaUpJVXpJMU5pSjkuZXlKcGMzTWlPaUpvZEhSd09pOHZNVEkzTGpBdU1DNHhPamd3TURBdllYQnBMM1l4TDJ4dloybHVJaXdpYVdGMElqb3hOemN3TURrMU1qZzVMQ0psZUhBaU9qRTNOekF3T1RnNE9Ea3NJbTVpWmlJNk1UYzNNREE1TlRJNE9Td2lhblJwSWpvaVpIQnNjREpoWTIxYWRITTNSM280VFNJc0luTjFZaUk2SWpFaUxDSndjbllpT2lJeU0ySmtOV000T1RRNVpqWXdNR0ZrWWpNNVpUY3dNV00wTURBNE56SmtZamRoTlRrM05tWTNJbjAuaGs2QlpUblZMdEN6Q05oZVpQR3VGdV9mNEY4UHBZb1plMkZyODlrU2ZYRSI7fQ==', 1770095308),
('MnTupdfXc45E7bZchmUnwqHki6x5qA0UMe22FDIg', 1, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiamMzaVNlUHpxeUU3V05lYlJlRG55eEVOWmpVRmhQdHBueHlsNGh1WSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdXBlci1hZG1pbi9hcHAtc2V0dGluZ3MiO3M6NToicm91dGUiO3M6MzA6InN1cGVyLWFkbWluLWFwcC1zZXR0aW5ncy1pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7czo0OiJ1c2VyIjthOjg6e3M6MjoiaWQiO2k6MTtzOjEwOiJmaXJzdF9uYW1lIjtzOjU6IlN1cGVyIjtzOjExOiJtaWRkbGVfbmFtZSI7czowOiIiO3M6OToibGFzdF9uYW1lIjtzOjU6IkFkbWluIjtzOjk6ImZ1bGxfbmFtZSI7czoxMToiU3VwZXIgQWRtaW4iO3M6NToiZW1haWwiO3M6MjI6InN1cGVyYWRtaW5AZXhhbXBsZS5jb20iO3M6NDoidHlwZSI7czoxMToic3VwZXJfYWRtaW4iO3M6Njoic3RhdHVzIjtpOjE7fXM6OToiYXBpX3Rva2VuIjtzOjMyMDoiZXlKMGVYQWlPaUpLVjFRaUxDSmhiR2NpT2lKSVV6STFOaUo5LmV5SnBjM01pT2lKb2RIUndPaTh2TVRJM0xqQXVNQzR4T2pnd01EQXZZWEJwTDNZeEwyeHZaMmx1SWl3aWFXRjBJam94TnpZM05qZzJOekkwTENKbGVIQWlPakUzTmpjMk9UQXpNalVzSW01aVppSTZNVGMyTnpZNE5qY3lOU3dpYW5ScElqb2lOM2hDTm5WUmMwWlVNbUpsVGtSSVpTSXNJbk4xWWlJNklqRWlMQ0p3Y25ZaU9pSXlNMkprTldNNE9UUTVaall3TUdGa1lqTTVaVGN3TVdNME1EQTROekprWWpkaE5UazNObVkzSW4wLnB3WDFvb1ZBLTZDY1Q3NkxMUTB1RGY4RV9GQk5BZmFqdzVhd2ViSE52OXciO30=', 1767686924),
('xArsKuDjQWpv4gi2KFblJJVGnqrmHw7qCRDBhzxp', 2, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoiblBDUHJDN1BqcDRBZEloSjBkbzZnQVZKZ2xpeVRVa1pEa2VIRGxpUCI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6NDA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9saXN0X2NvbXBhbnkiO3M6NToicm91dGUiO3M6MTI6Imxpc3RfY29tcGFueSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7czo0OiJ1c2VyIjthOjg6e3M6MjoiaWQiO2k6MjtzOjEwOiJmaXJzdF9uYW1lIjtzOjY6Ik1vcmVubyI7czoxMToibWlkZGxlX25hbWUiO3M6NzoiQnJhbm5vbiI7czo5OiJsYXN0X25hbWUiO3M6NDoiTGVvbiI7czo5OiJmdWxsX25hbWUiO3M6MTk6Ik1vcmVubyBCcmFubm9uIExlb24iO3M6NToiZW1haWwiO3M6MTg6Im1vcmVub0B5b3BtYWlsLmNvbSI7czo0OiJ0eXBlIjtzOjU6ImFkbWluIjtzOjY6InN0YXR1cyI7aToxO31zOjk6ImFwaV90b2tlbiI7czozMjA6ImV5SjBlWEFpT2lKS1YxUWlMQ0poYkdjaU9pSklVekkxTmlKOS5leUpwYzNNaU9pSm9kSFJ3T2k4dk1USTNMakF1TUM0eE9qZ3dNREF2WVhCcEwzWXhMMnh2WjJsdUlpd2lhV0YwSWpveE56WTNOamczTURRNUxDSmxlSEFpT2pFM05qYzJPVEEyTkRrc0ltNWlaaUk2TVRjMk56WTROekEwT1N3aWFuUnBJam9pTXpWelFYaHRjRXhsUWxoeGVtMVdWU0lzSW5OMVlpSTZJaklpTENKd2NuWWlPaUl5TTJKa05XTTRPVFE1WmpZd01HRmtZak01WlRjd01XTTBNREE0TnpKa1lqZGhOVGszTm1ZM0luMC43TUVuOUUxOGNkZVVxY3pFUnEzZHIzX0FVNmRWWUpyQWFTOU9TbjJ1b2lrIjt9', 1767687078);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `country_id`, `name`, `is_active`, `is_deleted`, `deleted_at`, `deleted_by`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 6, 'Gujarat', 1, 0, NULL, NULL, 1, 1, '2026-01-05 01:17:07', '2026-01-06 01:05:29'),
(2, 3, 'test', 1, 0, NULL, NULL, 1, NULL, '2026-01-05 04:00:08', '2026-01-05 04:00:08'),
(3, 3, 'test1', 1, 0, NULL, NULL, 1, NULL, '2026-01-05 04:01:23', '2026-01-05 04:01:23'),
(4, 3, 'test122', 1, 0, NULL, NULL, 1, NULL, '2026-01-05 04:10:56', '2026-01-05 04:10:56'),
(5, 3, 'test12211', 1, 0, NULL, NULL, 1, NULL, '2026-01-05 04:13:05', '2026-01-05 04:13:05'),
(6, 3, 'test1221', 1, 0, NULL, NULL, 1, 1, '2026-01-05 04:13:54', '2026-01-05 04:58:40'),
(7, 3, 'abc', 0, 1, '2026-01-05 04:47:46', 1, 1, 1, '2026-01-05 04:19:57', '2026-01-05 04:47:46'),
(8, 6, 'test', 1, 1, '2026-01-06 02:06:52', 1, 1, NULL, '2026-01-06 02:01:59', '2026-01-06 02:06:52'),
(9, 6, 'asdasd', 0, 0, NULL, NULL, 1, NULL, '2026-01-06 02:02:25', '2026-01-06 02:02:25'),
(10, 6, 'asdswre4fdef', 1, 1, '2026-01-06 02:02:56', 1, 1, NULL, '2026-01-06 02:02:46', '2026-01-06 02:02:56');

-- --------------------------------------------------------

--
-- Table structure for table `timezones`
--

CREATE TABLE `timezones` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `timezone` varchar(255) NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `utc` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(1) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `timezones`
--

INSERT INTO `timezones` (`id`, `name`, `timezone`, `country_id`, `utc`, `is_active`, `is_deleted`, `deleted_at`, `deleted_by`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 'India Standard Timesd', 'Kolcutta', 3, 'GMT +5:30', 0, 0, NULL, NULL, 1, 1, '2026-01-05 07:06:08', '2026-01-06 00:00:15'),
(2, 'test', 'Kolcuttaa', 3, 'asdd', 1, 0, NULL, NULL, 1, NULL, '2026-01-06 00:00:30', '2026-01-06 00:00:30'),
(3, 'testsdsad', 'asdasdaswd', 6, 'GMT +5:31', 1, 1, '2026-01-06 02:07:19', 1, 1, NULL, '2026-01-06 01:50:21', '2026-01-06 02:07:19'),
(4, 'asd', 'asdasd', 3, 'aasdasd', 1, 0, NULL, NULL, 1, NULL, '2026-01-06 01:51:22', '2026-01-06 01:51:22'),
(5, 'adasdsd', 'sdasdsd', 6, 'GMT +5:20', 1, 0, NULL, NULL, 1, NULL, '2026-01-06 01:53:59', '2026-01-06 01:53:59'),
(6, 'asdasdfsf', 'fsdfsdfsdf', 3, 'GMT +5:10', 1, 0, NULL, NULL, 1, 1, '2026-01-06 01:54:26', '2026-01-06 01:54:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_code` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `mobile` varchar(255) DEFAULT NULL,
  `mobile_verified_at` timestamp NULL DEFAULT NULL,
  `profile` text DEFAULT NULL,
  `user_type` enum('super_admin','admin','staff') NOT NULL DEFAULT 'admin',
  `email_verified` tinyint(4) NOT NULL DEFAULT 0,
  `mobile_verified` tinyint(4) NOT NULL DEFAULT 0,
  `is_active` tinyint(4) NOT NULL DEFAULT 1,
  `is_deleted` tinyint(4) NOT NULL DEFAULT 0,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `deleted_by` bigint(20) UNSIGNED DEFAULT NULL,
  `created_by` bigint(20) UNSIGNED DEFAULT NULL,
  `updated_by` bigint(20) UNSIGNED DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_code`, `first_name`, `middle_name`, `last_name`, `full_name`, `email`, `email_verified_at`, `password`, `mobile`, `mobile_verified_at`, `profile`, `user_type`, `email_verified`, `mobile_verified`, `is_active`, `is_deleted`, `deleted_at`, `deleted_by`, `created_by`, `updated_by`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'SA001', 'Super', '', 'Admin', 'Super Admin', 'superadmin@example.com', NULL, '$2y$12$0lczMal6AD.hLQA.Olq3x.5DQpj/nXnJIxzF8BqaUlEzxgh.JR49.', '1234567890', NULL, NULL, 'super_admin', 1, 1, 1, 0, NULL, NULL, NULL, NULL, 'KSpOZPC1iqM73yIEIUpCUyTwwcXv6b5C7xd9bYotBBcer54ZkU8XeVyHQYuN', '2026-01-01 00:57:37', '2026-01-01 00:57:37'),
(2, 'USR-6956408E5A09F', 'Moreno', 'Brannon', 'Leon', 'Moreno Brannon Leon', 'moreno@yopmail.com', NULL, '$2y$12$awIrTuc7k0oXYBOrcIm4J.RhUDyV4kt9KnEq2p.K04e4yqWB9XeiK', '1234567890', NULL, NULL, 'admin', 1, 1, 1, 0, NULL, NULL, NULL, NULL, '20GGCsB0U1OLoJCrnyaG7DWtDTdIIQPjOuunmRWYCGjs8wrmypFemz9RtP9A', '2026-01-01 04:08:22', '2026-01-01 04:08:22'),
(3, 'USR-6956502078D7F', 'abc', 'abc', 'abc', 'abc abc abc', 'abc@example.com', NULL, '$2y$12$LocgTd/DoHgk3xCOB7qxmuQgzdOvlxstd.KtD2NnxMiLt7qeJxBCW', '8998585825', NULL, NULL, 'admin', 0, 0, 1, 1, '2026-01-01 07:42:14', 1, NULL, NULL, NULL, '2026-01-01 05:14:48', '2026-01-01 07:42:14'),
(4, 'USR-695674B3711FC', 'jhon', 'Brannon', 'Leon', 'jhon Brannon Leon', 'jhon@example.com', NULL, '$2y$12$SJxGZC0CL/q3o3ZiErvoue5pcGHUIICsQUyhFfepWKR7Hu7XU6Fem', '8998585825', NULL, NULL, 'admin', 0, 0, 0, 0, NULL, NULL, NULL, NULL, NULL, '2026-01-01 07:50:51', '2026-01-02 05:47:48'),
(5, 'USR-69567775DDE61', 'sdasdasdsa', 'sdasd', 'asdasdasdad', 'sdasdasdsa sdasd asdasdasdad', 'sdasd@example.com', NULL, '$2y$12$mLcFzZbxufwD1Mt4T6mOX.v.IfzsPO1N0ZomgB0bSTLQ7.9u2r2hi', '1111111111', NULL, NULL, 'admin', 0, 0, 1, 1, '2026-01-01 08:24:51', 1, NULL, NULL, NULL, '2026-01-01 08:02:38', '2026-01-01 08:24:51');

-- --------------------------------------------------------

--
-- Table structure for table `user_companies`
--

CREATE TABLE `user_companies` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `company_id` bigint(20) UNSIGNED DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `activity_logs_user_id_foreign` (`user_id`),
  ADD KEY `activity_logs_company_id_foreign` (`company_id`),
  ADD KEY `activity_logs_branch_id_foreign` (`branch_id`),
  ADD KEY `activity_logs_department_id_foreign` (`department_id`);

--
-- Indexes for table `branches`
--
ALTER TABLE `branches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `branches_company_id_foreign` (`company_id`),
  ADD KEY `branches_manager_id_foreign` (`manager_id`);

--
-- Indexes for table `branch_departments`
--
ALTER TABLE `branch_departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `cities_state_id_name_unique` (`state_id`,`name`),
  ADD KEY `cities_state_id_index` (`state_id`),
  ADD KEY `cities_is_active_index` (`is_active`),
  ADD KEY `cities_is_deleted_index` (`is_deleted`),
  ADD KEY `cities_country_id_index` (`country_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `companies_code_unique` (`code`);

--
-- Indexes for table `company_branches`
--
ALTER TABLE `company_branches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_code_unique` (`code`);

--
-- Indexes for table `currencies`
--
ALTER TABLE `currencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `currencies_country_id_name_unique` (`country_id`,`name`),
  ADD KEY `currencies_country_id_index` (`country_id`),
  ADD KEY `currencies_is_active_index` (`is_active`),
  ADD KEY `currencies_is_deleted_index` (`is_deleted`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `departments_company_id_foreign` (`company_id`),
  ADD KEY `departments_manager_id_foreign` (`manager_id`),
  ADD KEY `departments_branch_id_foreign` (`branch_id`),
  ADD KEY `departments_parent_department_id_foreign` (`parent_department_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `languages_name_unique` (`name`),
  ADD UNIQUE KEY `languages_short_name_unique` (`short_name`),
  ADD KEY `languages_is_active_index` (`is_active`),
  ADD KEY `languages_is_deleted_index` (`is_deleted`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `states_country_id_name_unique` (`country_id`,`name`),
  ADD KEY `states_country_id_index` (`country_id`),
  ADD KEY `states_is_active_index` (`is_active`),
  ADD KEY `states_is_deleted_index` (`is_deleted`);

--
-- Indexes for table `timezones`
--
ALTER TABLE `timezones`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `timezones_name_unique` (`name`),
  ADD UNIQUE KEY `timezones_timezone_unique` (`timezone`),
  ADD KEY `timezones_country_id_index` (`country_id`),
  ADD KEY `timezones_is_active_index` (`is_active`),
  ADD KEY `timezones_is_deleted_index` (`is_deleted`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_user_code_unique` (`user_code`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `user_companies`
--
ALTER TABLE `user_companies`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branches`
--
ALTER TABLE `branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `branch_departments`
--
ALTER TABLE `branch_departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `company_branches`
--
ALTER TABLE `company_branches`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `currencies`
--
ALTER TABLE `currencies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `timezones`
--
ALTER TABLE `timezones`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `user_companies`
--
ALTER TABLE `user_companies`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `activity_logs_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_logs_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_logs_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `activity_logs_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `branches`
--
ALTER TABLE `branches`
  ADD CONSTRAINT `branches_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `branches_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `departments`
--
ALTER TABLE `departments`
  ADD CONSTRAINT `departments_branch_id_foreign` FOREIGN KEY (`branch_id`) REFERENCES `branches` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `departments_company_id_foreign` FOREIGN KEY (`company_id`) REFERENCES `companies` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `departments_manager_id_foreign` FOREIGN KEY (`manager_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `departments_parent_department_id_foreign` FOREIGN KEY (`parent_department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
