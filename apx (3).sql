-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 02, 2026 at 10:35 AM
-- Server version: 8.4.7
-- PHP Version: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apx`
--

-- --------------------------------------------------------

--
-- Table structure for table `daily_activities`
--

DROP TABLE IF EXISTS `daily_activities`;
CREATE TABLE IF NOT EXISTS `daily_activities` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `body` text COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `activity_date` date DEFAULT NULL,
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `daily_activities`
--

INSERT INTO `daily_activities` (`id`, `title`, `body`, `image_url`, `activity_date`, `sort_order`, `is_visible`, `created_at`, `updated_at`) VALUES
(1, 'Add Daily Activity', 'Add Daily ActivityAdd Daily ActivityAdd Daily ActivityAdd Daily Activit\r\nAdd Daily ActivityAdd Daily ActivityAdd Daily Activity\r\nAdd Daily ActivityAdd Daily Activityy', '/public/uploads/activities/activity_20260102_082706_8941803f.jpeg', '2026-01-02', 0, 1, '2026-01-02 02:57:06', '2026-01-02 02:57:06'),
(2, 'Add Daily Activity', 'Add Daily Activity\r\nAdd Daily Activity\r\nAdd Daily Activity\r\nAdd Daily Activity\r\nAdd Daily Activity', '/public/uploads/activities/activity_20260102_084435_e0fbe06a.jpeg', '2026-01-02', 0, 1, '2026-01-02 03:14:35', '2026-01-02 03:14:35'),
(3, 'Add Daily Activity', 'Add Daily ActiviAdd Daily Activity\r\nAdd Daily ActivityAdd Daily Activity\r\nAdd Daily ActivityAdd Daily Activity\r\ntyAdd Daily ActivityAdd Daily Activity', '/public/uploads/activities/activity_20260102_084454_d8375b8f.jpeg', '2026-01-02', 0, 1, '2026-01-02 03:14:54', '2026-01-02 03:14:54'),
(4, 'Add Daily Activity', 'Add Daily Activity\r\n\r\nAdd Daily Activity\r\nAdd Daily Activity\r\nAdd Daily Activity', '/public/uploads/activities/activity_20260102_084509_c23abcbc.jpeg', NULL, 0, 1, '2026-01-02 03:15:03', '2026-01-02 03:15:09'),
(5, 'Add Daily Activity', 'Add Daily Activity\r\nAdd Daily Activity\r\nAdd Daily Activity\r\nAdd Daily Activity\r\nAdd Daily Activity', '/public/uploads/activities/activity_20260102_084535_526b4a90.jpeg', '2026-01-02', 0, 1, '2026-01-02 03:15:28', '2026-01-02 03:15:35'),
(6, 'Add Daily Activity', 'Add Daily Activity\r\nAdd Daily Activity\r\nAdd Daily Activity\r\nAdd Daily Activity\r\nAdd Daily Activity', '/public/uploads/activities/activity_20260102_084553_18731409.jpeg', '2026-01-02', 0, 1, '2026-01-02 03:15:53', '2026-01-02 03:15:53'),
(7, 'Add Daily Activity', 'Add Daily Activity\r\nAdd Daily Activity\r\nAdd Daily Activity\r\nAdd Daily Activity\r\nAdd Daily Activity', '/public/uploads/activities/activity_20260102_084609_20fd0b88.jpeg', '2026-01-02', 0, 1, '2026-01-02 03:16:09', '2026-01-02 03:16:09');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `features`
--

DROP TABLE IF EXISTS `features`;
CREATE TABLE IF NOT EXISTS `features` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `icon` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon_image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `features`
--

INSERT INTO `features` (`id`, `icon`, `icon_image_url`, `title`, `description`, `sort_order`, `is_visible`, `created_at`, `updated_at`) VALUES
(1, '✈️', '/uploads/features/feature_icon_20260102_065606_5d6f9f18.jpeg', 'Air Freight', 'Air Freight', 0, 1, '2025-12-31 02:45:47', '2026-01-02 01:26:06'),
(2, '🚆', '/uploads/features/feature_icon_20251231_081610_2bab54eb.jpeg', 'Air Freight', 'Air Freight', 0, 1, '2025-12-31 02:46:10', '2025-12-31 02:46:10');

-- --------------------------------------------------------

--
-- Table structure for table `footer_links`
--

DROP TABLE IF EXISTS `footer_links`;
CREATE TABLE IF NOT EXISTS `footer_links` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int UNSIGNED NOT NULL DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery_items`
--

DROP TABLE IF EXISTS `gallery_items`;
CREATE TABLE IF NOT EXISTS `gallery_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_label` varchar(24) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `gallery_items`
--

INSERT INTO `gallery_items` (`id`, `image_url`, `label`, `date_label`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, '/uploads/services/service_20251231_085638_fa9db668.jpeg', 'Gallery Item', NULL, 0, '2025-12-31 03:26:46', '2025-12-31 03:26:46');

-- --------------------------------------------------------

--
-- Table structure for table `help_items`
--

DROP TABLE IF EXISTS `help_items`;
CREATE TABLE IF NOT EXISTS `help_items` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `icon` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `home_banners`
--

DROP TABLE IF EXISTS `home_banners`;
CREATE TABLE IF NOT EXISTS `home_banners` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `eyebrow` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_line1` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title_line2` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subtitle` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bg_image_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `banner_height_px` int UNSIGNED DEFAULT NULL,
  `bg_position` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `banner_content_max_width_px` int UNSIGNED DEFAULT NULL,
  `bg_size` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primary_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `primary_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_text` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `secondary_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `home_banners`
--

INSERT INTO `home_banners` (`id`, `eyebrow`, `title_line1`, `title_line2`, `subtitle`, `bg_image_url`, `banner_height_px`, `bg_position`, `banner_content_max_width_px`, `bg_size`, `primary_text`, `primary_url`, `secondary_text`, `secondary_url`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, NULL, NULL, '/public/uploads/banners/banner_20260102_100054_421d32f1.jpeg', 620, 'center', 1600, 'cover', NULL, NULL, NULL, NULL, '2026-01-02 04:30:54', '2026-01-02 04:59:11');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 2),
(3, '2019_08_19_000000_create_failed_jobs_table', 3),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 4),
(5, '2025_12_19_000000_add_is_admin_to_users_table', 4),
(6, '2025_12_19_000000_create_users_table', 4),
(7, '2025_12_19_000001_add_is_admin_to_users_table', 4),
(8, '2025_12_19_000100_create_features_table', 5),
(9, '2025_12_19_000200_create_home_banners_table', 6),
(10, '2025_12_19_000150_create_features_table', 7),
(11, '2025_12_19_000180_create_services_table', 7),
(12, '2025_12_19_000190_create_settings_table', 8),
(13, '2025_12_19_000210_create_nav_links_table', 8),
(14, '2025_12_19_000220_create_gallery_items_table', 8),
(15, '2025_12_19_000230_create_help_items_table', 9),
(16, '2025_12_31_000220_create_social_links_table', 10),
(17, '2025_12_31_000230_add_icon_to_nav_links_table', 11),
(18, '2025_12_31_075000_add_visibility_and_icon_image_to_features_table', 11),
(19, '2025_12_31_075100_add_visibility_to_services_table', 12),
(20, '2025_12_31_100000_create_quotes_table', 12),
(21, '2025_12_31_110000_create_footer_links_table', 12),
(22, '2025_12_31_120000_create_newsletter_subscriptions_table', 13),
(23, '2026_01_02_000000_create_daily_activities_table', 14),
(24, '2026_01_02_000300_add_display_settings_to_home_banners_table', 15),
(25, '2026_01_02_000400_add_more_display_settings_to_home_banners_table', 16);

-- --------------------------------------------------------

--
-- Table structure for table `nav_links`
--

DROP TABLE IF EXISTS `nav_links`;
CREATE TABLE IF NOT EXISTS `nav_links` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `target` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `sort_order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `newsletter_subscriptions`
--

DROP TABLE IF EXISTS `newsletter_subscriptions`;
CREATE TABLE IF NOT EXISTS `newsletter_subscriptions` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `quotes`
--

DROP TABLE IF EXISTS `quotes`;
CREATE TABLE IF NOT EXISTS `quotes` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `service_id` bigint UNSIGNED DEFAULT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new',
  `notes` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `quotes_service_id_foreign` (`service_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `icon` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `title` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
  `image_url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `checklist` json DEFAULT NULL,
  `sort_order` int DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `services`
--

INSERT INTO `services` (`id`, `icon`, `title`, `description`, `image_url`, `checklist`, `sort_order`, `is_visible`, `created_at`, `updated_at`) VALUES
(1, NULL, 'still doesn’t show the admin', 'still doesn’t show the admin', NULL, '[]', 0, 1, '2025-12-31 03:06:40', '2025-12-31 03:06:40'),
(2, NULL, 'still doesn’t show the admin', 'still doesn’t show the admin', NULL, '[]', 0, 1, '2025-12-31 03:07:16', '2025-12-31 03:07:16'),
(3, '🚚', 'Air Freight', 'Air Freight', NULL, '[]', 0, 1, '2025-12-31 03:11:38', '2025-12-31 03:11:38'),
(4, NULL, 'Create Service', 'Create Service', '/uploads/services/service_20251231_084640_1b253042.jpeg', '[\"Create Service\"]', 0, 1, '2025-12-31 03:16:51', '2025-12-31 03:16:51');

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
CREATE TABLE IF NOT EXISTS `settings` (
  `key` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`key`, `value`) VALUES
('site_name', 'APX'),
('contact_email', 'emmentagrossist@gmail.com'),
('contact_phone', '0798645352'),
('address', 'Schwandgasse 16'),
('default_theme', 'emerald'),
('logo_url', '/uploads/logos/logo_20251231_073050_d291fe7a.jpeg'),
('tagline', 'Safe Transportation & Logistics'),
('logo_file', 'C:\\wamp64\\tmp\\php954C.tmp'),
('footer_logo_url', '/public/uploads/logos/footer_logo_20260102_065659_4dd42134.jpeg'),
('footer_text', 'All rights reserved.'),
('footer_newsletter', 'Subscribe to get updates about new services and offers.'),
('footer_hours', NULL),
('footer_about_title', 'About'),
('footer_about_text', 'Subscribe to get updates about new services and offers.\r\nSubscribe to get updates about new services and offers.'),
('footer_about_link_label', NULL),
('footer_about_link_url', NULL),
('footer_show_social', '1'),
('footer_bg_color', '#324a5e'),
('footer_text_color', '#ffffff'),
('footer_link_color', '#ffffff'),
('footer_logo_file', 'C:\\wamp64\\tmp\\phpB41.tmp'),
('header_bg_color', '#08251f'),
('header_border_color', '#08251f'),
('header_link_color', '#ffffff'),
('header_text_color', '#ffffff'),
('header_tagline_color', '#ffffff'),
('header_brand_font_size', '20'),
('header_brand_font_weight', '800'),
('header_brand_font_style', 'italic'),
('site_default_theme', 'dark');

-- --------------------------------------------------------

--
-- Table structure for table `social_links`
--

DROP TABLE IF EXISTS `social_links`;
CREATE TABLE IF NOT EXISTS `social_links` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `label` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `is_visible` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `is_admin`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@example.com', NULL, '$2y$10$8P/SYqieXykA3HFFbCVHvu9x47lBJ2DoxLQ2t1RnKLLfsofjkp2tK', 1, NULL, '2025-12-19 01:25:03', '2025-12-19 01:25:03');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
