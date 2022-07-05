-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2021 at 12:20 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `transport4transport`
--

-- --------------------------------------------------------

--
-- Table structure for table `ambulances`
--

CREATE TABLE `ambulances` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `village_id` int(11) NOT NULL,
  `workplace_id` int(11) NOT NULL,
  `sponsor_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `next_repair` date DEFAULT NULL,
  `lastest_repair` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ambulances`
--

INSERT INTO `ambulances` (`id`, `name`, `village_id`, `workplace_id`, `sponsor_id`, `field_id`, `latitude`, `longitude`, `next_repair`, `lastest_repair`, `created_at`, `updated_at`, `deleted_at`) VALUES
(34, 'Wanda Talley', 3, 4, 7, 5, '20.9320', '77.7523', '1971-04-21', '1970-02-12', '2021-06-18 22:38:52', '2021-06-18 22:38:52', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ambulance_usages`
--

CREATE TABLE `ambulance_usages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `date` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `age_of_patient` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_unicode_ci NOT NULL,
  `village_id` bigint(20) UNSIGNED NOT NULL,
  `health_facility` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_of_departure` time NOT NULL,
  `type_of_case` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ambulance_id` bigint(20) UNSIGNED NOT NULL,
  `deceased` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ambulance_usages`
--

INSERT INTO `ambulance_usages` (`id`, `date`, `name`, `age_of_patient`, `gender`, `village_id`, `health_facility`, `time_of_departure`, `type_of_case`, `ambulance_id`, `deceased`, `created_at`, `updated_at`, `deleted_at`) VALUES
(8, '1993-12-10', 'updated Rosales', '12', 'male', 3, 'Courtney Sargent', '12:32:00', 'Sunt beatae dolore', 20, 'No', '2021-06-16 09:43:27', '2021-06-17 20:42:35', NULL),
(9, '2021-06-16', 'Adeel Amir', '22', 'male', 4, 'Fever', '22:33:00', 'Critical', 11, 'Yes', '2021-06-17 17:31:10', '2021-06-17 22:52:58', NULL),
(10, '2021-06-29', 'Usama Tariq', '21', 'male', 3, 'Fever', '17:53:00', 'Critical', 21, 'No', '2021-06-17 22:48:25', '2021-06-17 22:53:22', '2021-06-17 22:53:22'),
(11, '2021-06-20', 'Ambulance usage', '15', 'male', 3, 'Hector Davis', '00:37:00', 'Sunt beatae dolore', 34, 'Yes', '2021-06-19 22:37:53', '2021-06-19 22:37:53', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `country_code`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'India', '0293230', '2021-06-02 10:47:17', '2021-06-08 08:18:15', '2021-06-08 08:18:15'),
(2, 'COuntre', '0293230', '2021-06-04 08:59:08', '2021-06-04 09:00:20', '2021-06-04 09:00:20'),
(3, 'Pk update', '+92', '2021-06-04 09:16:03', '2021-06-06 03:13:53', NULL),
(4, 'India', '+91', '2021-06-04 09:17:12', '2021-06-04 09:17:30', '2021-06-04 09:17:30'),
(5, 'India Update', '+923', '2021-06-06 03:13:39', '2021-06-06 03:55:01', '2021-06-06 03:55:01'),
(6, 'Itely', '+13', '2021-06-10 09:59:21', '2021-06-21 02:26:23', NULL),
(7, 'Spain', '+99', '2021-06-21 02:26:39', '2021-06-21 02:26:44', '2021-06-21 02:26:44');

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `country_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'DIS 1', 1, '2021-06-03 07:48:01', '2021-06-04 08:43:00', '2021-06-04 08:43:00'),
(2, 'DIS 2', 1, '2021-06-03 08:01:43', '2021-06-06 03:12:37', '2021-06-06 03:12:37'),
(3, 'Districts Updatedd', 3, '2021-06-04 09:19:17', '2021-06-06 03:57:28', NULL),
(4, 'New', 3, '2021-06-06 03:56:46', '2021-06-06 03:57:08', '2021-06-06 03:57:08'),
(5, 'Districts First', 6, '2021-06-10 09:59:49', '2021-06-10 09:59:49', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fieldofficers`
--

CREATE TABLE `fieldofficers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `fieldofficers`
--

INSERT INTO `fieldofficers` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Colette Guy', '2021-06-03 10:49:20', '2021-06-03 10:57:32', '2021-06-03 10:57:32'),
(3, 'Sara Dodson', '2021-06-03 10:58:01', '2021-06-04 08:54:30', '2021-06-04 08:54:30'),
(4, 'field officers', '2021-06-04 08:56:56', '2021-06-04 08:57:08', '2021-06-04 08:57:08'),
(5, 'HIHS', '2021-06-04 09:10:28', '2021-06-21 02:24:32', NULL),
(6, 'Hammad', '2021-06-04 09:11:15', '2021-06-04 09:11:27', '2021-06-04 09:11:27'),
(7, 'Adeel Amir', '2021-06-21 02:24:48', '2021-06-21 02:24:55', '2021-06-21 02:24:55');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(19, '2020_12_24_112543_create_roles_table', 5),
(21, '2021_02_11_025555_create_profiles_table', 6),
(22, '2021_02_11_095150_create_buissness_accounts_table', 7),
(23, '2021_02_10_204241_create_teams_table', 8),
(24, '2021_02_13_020317_create_products_table', 8),
(25, '2021_02_13_030634_create_leads_table', 9),
(26, '2021_02_17_173818_create_training_coverage_links_table', 10),
(27, '2021_02_20_233552_create_sales_table', 11),
(28, '2021_02_21_033833_create_payout_settings_table', 12),
(29, '2021_02_21_041110_create_earnings_ms_table', 13),
(30, '2021_02_21_041557_create_earning_ds_table', 14),
(31, '2021_02_27_215648_create_history_notes_table', 15),
(32, '2021_03_09_135957_create_pay_periods_table', 15),
(33, '2021_03_10_172632_create_settings_table', 15),
(34, '2021_03_27_114223_create_expenses_table', 15),
(36, '2021_04_03_032952_create_lead_assignments_table', 16),
(37, '2021_04_14_230854_create_virtual_lead_assignments_table', 17),
(38, '2021_05_28_060115_create_training_videos_table', 18),
(39, '2021_05_28_024355_create_faqs_table', 19),
(40, '2021_05_28_231712_create_training_articles_table', 19),
(41, '2021_05_29_023351_create_training_quizzes_table', 20),
(42, '2021_06_01_131648_create_fieldofficers_table', 21),
(43, '2021_06_01_144815_create_sponsors_table', 22),
(44, '2021_06_01_153101_create_countries_table', 23),
(45, '2021_06_02_122504_create_districts_table', 24),
(46, '2021_06_02_132232_create_villages_table', 25),
(47, '2021_06_02_132303_create_work_places_table', 25),
(51, '2021_06_05_113826_create_ambulances_table', 26),
(52, '2021_06_06_123352_create_wheelchairs_table', 26),
(53, '2021_06_06_131317_create_projects_table', 26),
(54, '2021_06_08_144817_create_prospects_table', 27),
(56, '2021_06_14_161545_create_ambulance_usages_table', 28);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`email`, `token`, `created_at`) VALUES
('info@dynamicempire.net', '$2y$10$M5kqQN6.INI2.iukUu3Rguais5sNCpDidxYF2EmaTN.5Rz1IFGJ92', '2021-03-23 15:10:47');

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `middlename` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `dob` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `street` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zipcode` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity1` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `identity2` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `profile_picture` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `document_numbers` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `profiles`
--

INSERT INTO `profiles` (`id`, `user_id`, `firstname`, `middlename`, `lastname`, `dob`, `phone`, `phone2`, `country`, `city`, `street`, `state`, `zipcode`, `identity1`, `identity2`, `profile_picture`, `document_name`, `document_numbers`, `created_at`, `updated_at`, `deleted_at`) VALUES
(23, 1, 'Transport4Transport', '', '', '1990-01-23', '184-960-7647', '030-098-1909', 'Dominican Republic', 'Santiago', '232 fsd, florida', 'Florida', '89088', NULL, NULL, 'EG-9229654.jpg', NULL, NULL, '2021-03-10 03:56:12', '2021-05-21 13:19:24', NULL),
(24, 2, 'Macey', 'Yardley Cooper', 'Hodge', '1989-10-09', '+1 (441) 207-2288', '+1 (834) 595-7479', 'c', 'Labore ea sed qui id', 'Debitis architecto s', 'Maxime totam dolorem', '18223', NULL, NULL, NULL, NULL, NULL, '2021-06-13 03:59:57', '2021-06-15 09:08:05', NULL),
(25, 3, 'Leslie', 'Quinn Howard', 'Ross', '2010-05-04', '+1 (724) 952-7446', '+1 (923) 923-3058', 'County', 'Lahore', 'Street', 'Punjab', '48035', NULL, NULL, 'C:\\Windows\\Temp\\phpF4B4.tmp', NULL, NULL, '2021-06-13 04:06:45', '2021-06-13 04:06:45', NULL),
(26, 4, 'Adil', NULL, 'Aziz', '2021-06-21', '+1 (951) 374-2276', '+1 (277) 474-3644', 'Pakistan', 'Faisalabad', '132 Fsd', 'Punjab', '55578', NULL, NULL, NULL, NULL, NULL, '2021-06-13 04:18:54', '2021-06-21 04:10:42', NULL),
(27, 5, 'Hillary', 'Jeanette Head', 'Browning', '1975-02-19', '+1 (137) 609-5086', '+1 (696) 989-5973', 'c', 'Laboriosam aperiam', 'Ea facere a qui non', 'Dolore proident nem', '60676', NULL, NULL, NULL, NULL, NULL, '2021-06-13 04:36:43', '2021-06-13 04:36:43', NULL),
(28, 6, 'Matthew', 'Irma Anthony', 'Cox', '1997-01-21', '+1 (458) 718-8264', '+1 (223) 303-7058', 'c', 'Dolorem cum est ass', 'Quam dolorem vero na', 'Rerum enim quo expli', '78597', NULL, NULL, NULL, NULL, NULL, '2021-06-15 07:59:40', '2021-06-15 07:59:40', NULL),
(29, 7, 'Bree', 'Stewart Jensen', 'Hodges', '2002-02-13', '+1 (593) 306-9586', '+1 (861) 703-3569', 'c', 'Non voluptate eu nob', 'Placeat in ut facil', 'Odit do qui quam con', '33064', NULL, NULL, NULL, NULL, NULL, '2021-06-15 10:35:53', '2021-06-15 10:35:53', NULL),
(30, 8, 'FSL', 'Emerald Stafford', 'KK', '2021-06-21', '+1 (838) 174-8462', '+1 (426) 616-2776', 'fsd', 'fsd', '32', 'fsd', '89080', NULL, NULL, NULL, NULL, NULL, '2021-06-16 10:59:50', '2021-06-21 03:04:33', NULL),
(31, 12, 'Desiree', 'Berk Walls', 'Lowe', '1977-11-15', '+1 (963) 677-3891', '+1 (366) 915-1208', '15379', 'Fuga Nisi quibusdam', 'Minim harum aliquid', 'Labore magna exceptu', '53458', NULL, NULL, NULL, NULL, NULL, '2021-06-18 19:07:52', '2021-06-18 19:07:52', NULL),
(32, 19, 'Muhammad', 'Adeel', 'Amir', '2021-06-21', '030-011-8765', NULL, 'Pakistan', 'fsd', 'fsd', 'punjab', '38000', NULL, NULL, NULL, NULL, NULL, '2021-06-22 07:55:53', '2021-06-22 07:55:53', NULL),
(33, 23, 'Ali', NULL, 'But', '2021-06-07', NULL, NULL, 'Pakistan', 'Faisalabad', NULL, 'Punjab', NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-22 08:04:43', '2021-06-23 02:26:26', NULL),
(34, 24, 'Azka', NULL, 'Khan', '2021-06-22', '030-011-1232', NULL, 'Pakistan', 'Faisalabad', '323 fsd, punjab', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-22 08:06:42', '2021-06-22 09:23:40', NULL),
(35, 25, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '16243434811.jpg', NULL, NULL, '2021-06-22 09:31:21', '2021-06-22 09:31:21', NULL),
(36, 26, NULL, NULL, NULL, '2021-06-22', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-22 09:56:12', '2021-06-22 10:54:16', NULL),
(37, 27, 'Kamal', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-22 10:46:44', '2021-06-22 10:46:44', NULL),
(38, 28, 'Sara', NULL, 'Khan', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2021-06-22 10:47:37', '2021-06-22 10:47:37', NULL),
(39, 29, 'Hammad', NULL, 'Azhar', '2021-06-22', NULL, NULL, 'Pakistan', NULL, NULL, NULL, NULL, NULL, NULL, 'HA-3524578.jpg', NULL, NULL, '2021-06-22 10:52:35', '2021-06-23 02:44:20', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sponsor_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `village_id` int(11) NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `title`, `sponsor_id`, `field_id`, `village_id`, `latitude`, `longitude`, `start_time`, `end_time`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(3, 'Colleen Hewitt', 6, 5, 3, '26.4499', '80.3319', '2020-01-23', '2002-01-10', 'Hi', '2021-06-08 11:40:36', '2021-06-08 11:50:18', '2021-06-08 11:50:18'),
(4, 'Laudantium suscipit', 6, 5, 4, '26.4499', '80.3319', '2005-06-29', '2006-10-31', 'In temporibus volupt', '2021-06-09 09:24:36', '2021-06-11 09:41:26', NULL),
(5, 'Website Developer', 6, 5, 4, '13.567', '12.0987', '2021-06-17', '2021-06-17', 'PHP Developer', '2021-06-17 23:43:21', '2021-06-17 23:49:31', '2021-06-17 23:49:31');

-- --------------------------------------------------------

--
-- Table structure for table `prospects`
--

CREATE TABLE `prospects` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sponsor_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_time` date NOT NULL,
  `end_time` date NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `prospects`
--

INSERT INTO `prospects` (`id`, `title`, `sponsor_id`, `field_id`, `latitude`, `longitude`, `start_time`, `end_time`, `description`, `created_at`, `updated_at`, `deleted_at`) VALUES
(2, 'Updated', 7, 5, '51.4825556', '41 24.2028', '2021-06-17', '2021-06-17', 'dsssss', '2021-06-09 10:08:57', '2021-06-18 00:50:33', NULL),
(3, 'Rana Case', 7, 5, '51.482555', '51.482555', '1973-03-14', '1974-08-28', 'Quibusdam in unde cu', '2021-06-16 10:54:45', '2021-06-18 00:50:11', '2021-06-18 00:50:11'),
(4, 'shops in lahore', 6, 5, '51.482555', '41 24.2028', '2021-06-17', '2021-06-17', 'hhhh', '2021-06-16 10:58:25', '2021-06-18 00:50:25', NULL),
(5, 'Catalog Prospects', 6, 5, '12.987', '51.482555', '2021-06-18', '2021-07-07', 'prospects catalog', '2021-06-18 00:42:59', '2021-06-18 01:04:17', '2021-06-18 01:04:17');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `title`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Admin', '2021-06-01 09:36:12', NULL, NULL),
(2, 'Reader', '2021-06-01 09:36:12', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `sponsors`
--

CREATE TABLE `sponsors` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sponsors`
--

INSERT INTO `sponsors` (`id`, `name`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Faisal', '2021-06-02 10:18:48', '2021-06-04 08:21:15', '2021-06-04 08:21:15'),
(2, 'spon 2', '2021-06-02 10:22:01', '2021-06-04 08:20:39', '2021-06-04 08:20:39'),
(3, 'spon', '2021-06-04 08:57:43', '2021-06-04 08:57:56', '2021-06-04 08:57:56'),
(4, 'nsmn', '2021-06-04 09:13:25', '2021-06-06 03:53:59', '2021-06-06 03:53:59'),
(5, 'sponsor 2', '2021-06-04 09:13:55', '2021-06-04 09:14:11', '2021-06-04 09:14:11'),
(6, 'Update', '2021-06-04 11:39:19', '2021-06-06 03:53:36', NULL),
(7, 'KFC', '2021-06-10 09:58:52', '2021-06-21 02:25:15', NULL),
(8, 'Mc Donalds', '2021-06-21 02:26:03', '2021-06-21 02:26:08', '2021-06-21 02:26:08');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `userId` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role_id` int(11) NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 1,
  `last_logged_in` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `userId`, `email`, `email_verified_at`, `password`, `role_id`, `remember_token`, `status`, `last_logged_in`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, '', 'info@transport4transport.net', NULL, '$2y$10$S7JpUAMVkin93xFMPiZkjOF67sSxNgXimNoPqH/75NGylg4yUDnea', 1, 'Fe63oB9vz3E5a2CwhMpDhjZORTMSMOQIkEWk0HS9iN27E23hJSFUdPAKQz5m', 1, '2021-06-23 01:32:27', '2020-12-11 12:53:36', '2021-06-23 08:32:27', '2021-06-15 08:16:20'),
(2, '', 'qileka@mailinator.com', NULL, '$2y$10$ap4Tu8V6LKeSfz//znCwbO8VBhjL.eH5Lt/MasGZUS5qhVi0QpGZO', 0, NULL, 0, '2021-06-14 14:08:05', '2021-06-13 03:59:57', '2021-06-15 09:08:05', NULL),
(3, '', 'vydoj@mailinator.com', NULL, '$2y$10$9WI3zn.1vNeYUMIUiWO67OBuIG/bR8gJlA56zpfJywTKjeject9fu', 2, NULL, 0, NULL, '2021-06-13 04:06:45', '2021-06-15 10:35:39', '2021-06-15 10:35:39'),
(4, '', 'adilaziz@gmail.com', NULL, '$2y$10$bnC5S3XPnnNJPvEAcJdgyuGZQhs/rJScxpr6m1PxX.TUbR0n6GEf2', 1, NULL, 1, '2021-06-20 21:10:42', '2021-06-13 04:18:54', '2021-06-21 04:10:42', NULL),
(5, '', 'rivefed@mailinator.com', NULL, '$2y$10$9WI3zn.1vNeYUMIUiWO67OBuIG/bR8gJlA56zpfJywTKjeject9fu', 2, NULL, 0, '2021-06-12 09:36:43', '2021-06-13 04:36:43', '2021-06-15 08:16:29', '2021-06-15 08:16:29'),
(6, '', 'hasim@mailinator.com', NULL, '$2y$10$wnMh3P470MQVeieRQ1OzYujxogf47QkXN8LO/AWc/JpIXLjby1KUy', 2, NULL, 0, '2021-06-14 12:59:40', '2021-06-15 07:59:40', '2021-06-15 08:16:25', '2021-06-15 08:16:25'),
(7, '', 'lobi@mailinator.com', NULL, '$2y$10$8nYuJgjKmeYmC08TRdoOJec2wTDIXLuWOu4zgjOJFuFSTVHNRvN0C', 2, NULL, 1, '2021-06-14 15:35:53', '2021-06-15 10:35:53', '2021-06-18 18:00:18', '2021-06-18 18:00:18'),
(8, '', 'f@app.com', NULL, '$2y$10$z6sCO5KNbxRbYy.Z9axNXO1W4mQBtsfgijICAJ.nNe4CTAcy3uUFq', 2, 'bqmMzvVxowlFi9eJ3lkhPB5rZK9zy80f45Jtzgs2eGNFRawqtxRwmUVgPZBc', 1, '2021-06-20 20:04:33', '2021-06-16 10:59:50', '2021-06-21 03:04:33', NULL),
(9, '', 'admin@app.com', NULL, '$2y$10$430p92DXjM9O28Tq6fwnaexhfA9.J27clBTYwE4iXwt.JwsWE0agW', 0, NULL, 0, '2021-06-18 12:05:22', '2021-06-18 19:05:22', '2021-06-18 19:05:22', NULL),
(12, '', 'vigebagazy@mailinator.com', NULL, '$2y$10$6bUipIy3ouUGd4eX8WtI5uUjhGsc3CsbjhBrbXfHw89yjk3O5y9cC', 0, NULL, 0, '2021-06-18 12:07:52', '2021-06-18 19:07:52', '2021-06-18 19:07:52', NULL),
(18, '', 'hhh@app.com', NULL, '$2y$10$b1x1Ftow0DHZSunpj3P65.elY19eMXtA2GVp5TLV2AlGwImNCcpnG', 0, NULL, 0, '2021-06-18 12:11:49', '2021-06-18 19:11:49', '2021-06-18 19:11:49', NULL),
(19, '', 'adeel98amir@gmail.com', NULL, '$2y$10$qtntRSPNEPefYbo4eSZ6BOsQYW0UoLC2h.BdeUBMYlPIdfWd4P9SG', 2, NULL, 1, '2021-06-22 00:55:53', '2021-06-22 07:55:53', '2021-06-22 07:55:53', NULL),
(20, '', 'rizwan@gmail.com', NULL, '$2y$10$DblNY0.yOwWKHCU/9tcw0.icuxolpsyNQdPPuS3QWSDNiETGmGWZe', 2, NULL, 1, '2021-06-22 00:56:53', '2021-06-22 07:56:53', '2021-06-22 07:56:53', NULL),
(23, '', 'alibut@gmail.com', NULL, '$2y$10$K2.S3LpW3aoJbKJ7Bz74JuZ6SFqT6dwgMRWul0dNhYbmnnMHN1Wd2', 2, NULL, 1, '2021-06-22 19:26:26', '2021-06-22 08:04:43', '2021-06-23 02:26:26', NULL),
(24, '', 'azkakhan@gmail.com', NULL, '$2y$10$Gp8P6rT0uU./raVszsTSGO0pDLBvB6m53VdZGxfmNBdlxKw91lujO', 2, NULL, 1, '2021-06-22 02:23:40', '2021-06-22 08:06:42', '2021-06-22 09:23:40', NULL),
(25, '', 'faiz@gmail.com', NULL, '$2y$10$kt7sFX5cvZimEfz/A1PXGOrzS9phSMAZQF8GwRrnykIHlGziIvVsC', 2, NULL, 1, '2021-06-22 02:31:21', '2021-06-22 09:31:21', '2021-06-22 09:31:21', NULL),
(26, '', 'bilaltariq@gmail.com', NULL, '$2y$10$I7S9ogHJSUt1HSsTfKG8d.XVATye8QOScr86z/ZyAIUiOgdqw4CVu', 2, NULL, 1, '2021-06-22 03:54:16', '2021-06-22 09:56:12', '2021-06-22 10:54:16', NULL),
(27, '', 'kamalpasha@gmail.com', NULL, '$2y$10$rhARb.9KMA1cRp4yDTVy1OYz1i68GKg6Wsu7PdlEsZhhMJhIjniL.', 2, NULL, 1, '2021-06-22 03:46:44', '2021-06-22 10:46:44', '2021-06-22 10:46:44', NULL),
(28, '', 'sarakhan@gmail.com', NULL, '$2y$10$zGH0x4yfjozPMfqnnSxItO83yV/CTYwN/zNYGkv5ctt.pfGmFDcji', 2, NULL, 1, '2021-06-22 03:47:37', '2021-06-22 10:47:37', '2021-06-22 10:47:37', NULL),
(29, '', 'hammadazhar@gmail.com', NULL, '$2y$10$SxskhM0BVHLXaUBtlPAYa.VNluo6.81esva9MW7Y0qoYp.2ID3Api', 2, NULL, 1, '2021-06-22 19:50:40', '2021-06-22 10:52:35', '2021-06-23 02:50:40', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `villages`
--

CREATE TABLE `villages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `district_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `villages`
--

INSERT INTO `villages` (`id`, `name`, `district_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Village', 1, '2021-06-03 09:01:51', '2021-06-04 08:48:26', '2021-06-04 08:48:26'),
(2, 'Lhr', 3, '2021-06-06 03:12:54', '2021-06-06 03:17:04', '2021-06-06 03:17:04'),
(3, 'Village Updated', 3, '2021-06-06 03:17:18', '2021-06-06 03:59:31', NULL),
(4, 'Village One', 5, '2021-06-10 10:00:09', '2021-06-10 10:00:09', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `wheelchairs`
--

CREATE TABLE `wheelchairs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sponsor_id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `latitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `longitude` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `next_repair` date DEFAULT NULL,
  `latest_repair` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `wheelchairs`
--

INSERT INTO `wheelchairs` (`id`, `name`, `sponsor_id`, `field_id`, `latitude`, `longitude`, `next_repair`, `latest_repair`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Lara Blankenship', 6, 5, '12345678', '12345678', '2009-02-03', '1985-02-25', '2021-06-07 08:53:53', '2021-06-08 09:56:15', '2021-06-08 09:56:15'),
(2, 'Emi Whitaker', 6, 5, '41 24.2028', '41 24.2028', '2007-10-02', '1971-08-16', '2021-06-07 09:08:18', '2021-06-08 09:55:13', '2021-06-08 09:55:13'),
(3, 'Colleen Coffey', 6, 5, 'Vernon Hays', 'Blanditiis esse dol', '1992-06-15', '2005-05-18', '2021-06-08 09:56:49', '2021-06-08 09:58:17', '2021-06-08 09:58:17'),
(4, 'Kathleen Beard', 6, 5, 'Rana Aguirre', 'Enim fuga Animi am', '2015-10-15', '1971-08-03', '2021-06-08 10:00:43', '2021-06-08 10:04:42', '2021-06-08 10:04:42'),
(5, 'Jaime Mooney', 7, 5, 'Nemo non accusantium', 'Quis numquam tempore', '1980-01-22', '1970-04-18', '2021-06-08 11:35:11', '2021-06-10 11:01:23', '2021-06-10 11:01:23'),
(6, 'MyCollection', 6, 5, '51.48255529999999', '41 24.2028', '2021-06-08', '2021-06-08', '2021-06-09 09:19:27', '2021-06-12 11:39:59', '2021-06-12 11:39:59'),
(7, 'Update Wheelchair', 6, 5, '22.7196', '75.8577', '2021-06-17', '2021-06-17', '2021-06-09 09:21:15', '2021-06-17 23:15:16', NULL),
(8, 'Doctor WheelChair', 7, 5, '12.00098', '5.5555', '2021-06-17', '2021-06-17', '2021-06-17 23:03:12', '2021-06-17 23:15:40', '2021-06-17 23:15:40');

-- --------------------------------------------------------

--
-- Table structure for table `work_places`
--

CREATE TABLE `work_places` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `village_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `work_places`
--

INSERT INTO `work_places` (`id`, `name`, `village_id`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'workplace 1', 1, '2021-06-03 09:18:01', '2021-06-04 09:04:06', '2021-06-04 09:04:06'),
(2, 'Wokplace update', 3, '2021-06-06 03:46:10', '2021-06-06 03:47:15', '2021-06-06 03:47:15'),
(3, 'New Workplaces', 3, '2021-06-06 04:00:15', '2021-06-08 07:55:32', NULL),
(4, 'My WorkPlace', 4, '2021-06-10 10:00:29', '2021-06-10 10:00:29', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ambulances`
--
ALTER TABLE `ambulances`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ambulance_usages`
--
ALTER TABLE `ambulance_usages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fieldofficers`
--
ALTER TABLE `fieldofficers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `prospects`
--
ALTER TABLE `prospects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sponsors`
--
ALTER TABLE `sponsors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- Indexes for table `villages`
--
ALTER TABLE `villages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wheelchairs`
--
ALTER TABLE `wheelchairs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `work_places`
--
ALTER TABLE `work_places`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ambulances`
--
ALTER TABLE `ambulances`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `ambulance_usages`
--
ALTER TABLE `ambulance_usages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fieldofficers`
--
ALTER TABLE `fieldofficers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=57;

--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `prospects`
--
ALTER TABLE `prospects`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `sponsors`
--
ALTER TABLE `sponsors`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `villages`
--
ALTER TABLE `villages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `wheelchairs`
--
ALTER TABLE `wheelchairs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `work_places`
--
ALTER TABLE `work_places`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
