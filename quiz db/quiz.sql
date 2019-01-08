-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 04, 2019 at 09:32 AM
-- Server version: 5.7.24-0ubuntu0.16.04.1
-- PHP Version: 7.1.25-1+ubuntu16.04.1+deb.sury.org+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `quiz`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_settings`
--

CREATE TABLE `admin_settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin_settings`
--

INSERT INTO `admin_settings` (`id`, `slug`, `value`, `created_at`, `updated_at`) VALUES
(1, 'app_title', 'Quiz App', '2018-12-27 06:08:50', '2019-01-03 03:50:54'),
(2, 'logo', 'logo_logo.png', '2018-12-27 06:08:50', '2019-01-01 08:05:08'),
(3, 'login_logo', 'login_logo2.png', '2018-12-27 06:08:50', '2019-01-01 08:07:13'),
(4, 'favicon', 'favicon_favicon.png', '2018-12-27 06:08:50', '2019-01-03 03:48:50'),
(5, 'copyright_text', 'Copyright@2018', '2018-12-27 06:08:50', '2019-01-03 03:50:54'),
(6, 'lang', 'en', '2018-12-27 06:08:50', '2019-01-03 03:50:54'),
(7, 'company_name', 'New Company', '2018-12-27 06:08:50', '2019-01-03 03:50:54'),
(8, 'primary_email', 'info@email.com', '2018-12-27 06:08:50', '2019-01-03 03:50:54'),
(9, 'user_registration', '2', '2018-12-27 06:08:50', '2019-01-03 03:50:54');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `qs_limit` int(11) DEFAULT NULL,
  `time_limit` int(11) DEFAULT NULL,
  `max_limit` int(11) DEFAULT NULL,
  `serial` int(11) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`, `image`, `qs_limit`, `time_limit`, `max_limit`, `serial`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Science', 'test', '1546428212.svg', 10, 2, 200, 1, 1, '2018-12-27 12:24:31', '2019-01-02 06:28:18'),
(2, 'Mythology', 'test', NULL, 10, 2, 100, 2, 1, '2018-12-27 23:51:01', '2019-01-02 01:37:26'),
(4, 'Sports', '2', NULL, 12, 2, 400, 5, 1, '2018-12-28 07:57:47', '2018-12-29 12:52:43'),
(5, 'Politics', 'politics', '1546100479.png', 10, 2, 200, 3, 1, '2018-12-29 10:21:19', '2018-12-29 10:21:19'),
(8, 'test', 'test', NULL, 12, 10, 12, 4, 1, '2018-12-31 03:59:13', '2018-12-31 03:59:13'),
(9, 'Shopping', 'As a hobby shopping is very popular .', '1546431782.jpg', 5, 2, 20, 10, 1, '2019-01-02 06:23:02', '2019-01-02 06:23:02'),
(11, 'Travel', NULL, NULL, 10, 2, 20, 7, 1, '2019-01-02 06:35:12', '2019-01-02 06:35:12'),
(12, 'Design', 'test', NULL, 10, 2, 200, 6, 1, '2019-01-02 06:43:19', '2019-01-02 06:43:19'),
(13, 'Profession', 'Professional topics', NULL, 10, 2, 50, 11, 1, '2019-01-02 08:09:20', '2019-01-02 08:09:20');

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
(10, '2014_10_12_000000_create_users_table', 1),
(11, '2014_10_12_100000_create_password_resets_table', 1),
(12, '2016_06_01_000001_create_oauth_auth_codes_table', 1),
(13, '2016_06_01_000002_create_oauth_access_tokens_table', 1),
(14, '2016_06_01_000003_create_oauth_refresh_tokens_table', 1),
(15, '2016_06_01_000004_create_oauth_clients_table', 1),
(16, '2016_06_01_000005_create_oauth_personal_access_clients_table', 1),
(17, '2018_12_26_075334_create_user_verification_codes_table', 1),
(18, '2018_12_26_091755_create_admin_settings_table', 1),
(19, '2018_12_26_161850_create_categories_table', 1),
(20, '2018_12_26_162740_create_questions_table', 1),
(21, '2018_12_26_164629_create_user_answers_table', 1),
(22, '2018_12_26_165706_create_quiz_results_table', 1),
(23, '2018_12_27_065913_create_question_options_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_access_tokens`
--

INSERT INTO `oauth_access_tokens` (`id`, `user_id`, `client_id`, `name`, `scopes`, `revoked`, `created_at`, `updated_at`, `expires_at`) VALUES
('0fada7149bb36cc957fb21494f266b0bfe45fa66f516581796b623605320f64447bde046f505c440', 4, 1, 'messi@email.com', '[]', 0, '2019-01-01 00:44:54', '2019-01-01 00:44:54', '2020-01-01 06:44:54'),
('23599565846ac2b9a843a6cbb64e36bc062389106f0e93092f15e36f47bcb77058db0194a8ca23bd', 2, 1, 'user@email.com', '[]', 0, '2018-12-27 06:20:58', '2018-12-27 06:20:58', '2019-12-27 12:20:58'),
('3083205647c4329395039c04f88b10e6c2370e5ded9489329fdcb16d514bbec950a72e70c6b680d9', 1, 1, 'admin@email.com', '[]', 0, '2019-01-01 23:42:00', '2019-01-01 23:42:00', '2020-01-02 05:42:00'),
('3945c816a24dbb3abf869c287ffc81c900a65ebd261b843292968e2dc4001e10ea14e96026957190', 7, 1, 'messi10@email.com', '[]', 0, '2019-01-01 23:27:15', '2019-01-01 23:27:15', '2020-01-02 05:27:15'),
('5c30f7a63bb46e5e4045e21a3dee2e12fa3423102c7f402001f1335728e4be96a561c3708931a066', 4, 1, 'messi@email.com', '[]', 0, '2019-01-01 23:38:31', '2019-01-01 23:38:31', '2020-01-02 05:38:31'),
('73c24acc6564fec3657ce12c7bdb9ded122af32d3d262e78a469d515fe7971c4a38053da3f3b8c79', 4, 1, 'messi@email.com', '[]', 0, '2019-01-01 23:40:36', '2019-01-01 23:40:36', '2020-01-02 05:40:36'),
('875c54acc4653abc08cc457ba120848ad755095fc9227a5c7e3e22283632d9427336c2db1e2f1356', 4, 1, 'messi@email.com', '[]', 0, '2018-12-27 06:41:47', '2018-12-27 06:41:47', '2019-12-27 12:41:47'),
('9510af4bb239f0b6d78e231da05db3e6c423a1a1564724935d991366b56748a763d5b139ff530c69', 4, 1, 'messi@email.com', '[]', 0, '2019-01-01 23:42:12', '2019-01-01 23:42:12', '2020-01-02 05:42:12'),
('9af40509cfb838d25b1521472b61aaeba3f3db2d476b685f7fac96aec32ad73f553691396d3270a5', 5, 1, 'david@email.com', '[]', 0, '2018-12-29 10:51:09', '2018-12-29 10:51:09', '2019-12-29 16:51:09'),
('a04809530b83868dd6c5b25c173aff56c31a424b402a154bcc948c1f319d7927ee154246605363e6', 5, 1, 'david@email.com', '[]', 0, '2019-01-01 23:42:30', '2019-01-01 23:42:30', '2020-01-02 05:42:30'),
('aca1b62761528fa24425fe3fe9747cf8e725559c0664c344d68471b1beadd79b81eb6c32b7c3d433', 1, 1, 'admin@email.com', '[]', 0, '2019-01-01 23:41:24', '2019-01-01 23:41:24', '2020-01-02 05:41:24'),
('c92ddae6fd97ccb9782a498f3ecb0ea1d60f3980551b327326724bd855f37ce2a01a5b73589fe66f', 2, 1, 'user@email.com', '[]', 0, '2019-01-01 23:26:37', '2019-01-01 23:26:37', '2020-01-02 05:26:37'),
('cb9a9d40aecb93b99a4ec5e310b232f028a8866025ba6601e390596304ddcf23b294b67d5761c3f8', 4, 1, 'messi@email.com', '[]', 0, '2019-01-01 23:37:57', '2019-01-01 23:37:57', '2020-01-02 05:37:57');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(11) NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'yQlfuIx2Lph3nXpJbPDIe6091Dyy4fbnLFTIUtnv', 'http://localhost', 1, 0, 0, '2018-12-27 06:20:52', '2018-12-27 06:20:52'),
(2, NULL, 'Laravel Password Grant Client', 'EkIMgFzxclFJkZSjfmkNm0Sqos7j9TKC1aFgF2vC', 'http://localhost', 0, 1, 0, '2018-12-27 06:20:52', '2018-12-27 06:20:52');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2018-12-27 06:20:52', '2018-12-27 06:20:52');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `serial` int(11) DEFAULT NULL,
  `answer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time_limit` int(11) DEFAULT NULL,
  `point` int(11) NOT NULL DEFAULT '0',
  `coin` int(11) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `title`, `category_id`, `image`, `type`, `serial`, `answer`, `time_limit`, `point`, `coin`, `status`, `created_at`, `updated_at`) VALUES
(2, 'test test test', 2, '1546013694.png', 1, NULL, NULL, 2, 5, 0, 1, '2018-12-28 05:41:25', '2018-12-28 10:14:54'),
(3, 'question number one', 4, NULL, 1, NULL, NULL, NULL, 5, 0, 1, '2018-12-29 09:56:45', '2018-12-29 09:56:45'),
(4, 'Question number two', 4, NULL, 1, NULL, NULL, NULL, 5, 0, 1, '2018-12-29 10:01:47', '2018-12-29 11:53:10'),
(5, 'Question number three', 4, NULL, 1, NULL, NULL, NULL, 5, 0, 1, '2018-12-29 10:16:04', '2018-12-31 01:42:28'),
(6, 'Question number five', 5, '1546100783.png', 1, NULL, NULL, NULL, 5, 0, 1, '2018-12-29 10:26:23', '2018-12-29 11:27:52'),
(7, 'Question number six', 5, NULL, 1, NULL, NULL, NULL, 5, 0, 1, '2018-12-29 10:35:21', '2018-12-29 10:35:21'),
(8, 'the study of myths.', 2, NULL, 1, NULL, NULL, 10, 5, 0, 0, '2018-12-31 03:26:15', '2018-12-31 03:27:23'),
(9, 'q1', 5, NULL, 1, NULL, NULL, 2, 5, 0, 1, '2018-12-31 04:32:18', '2018-12-31 04:32:18'),
(10, 'q2', 5, NULL, 1, NULL, NULL, 2, 5, 0, 1, '2018-12-31 04:32:46', '2018-12-31 04:32:46'),
(11, 'Q3', 5, NULL, 1, NULL, NULL, 2, 5, 0, 1, '2018-12-31 04:33:54', '2018-12-31 04:33:54'),
(12, 'Question no seven', 4, NULL, 1, NULL, NULL, 10, 5, 0, 1, '2018-12-31 04:48:16', '2018-12-31 04:48:16'),
(13, 'Question No eight', 5, NULL, 1, NULL, NULL, 1, 5, 0, 1, '2018-12-31 04:48:58', '2018-12-31 07:06:54'),
(14, 'Question No ten', 5, NULL, 1, NULL, NULL, 1, 5, 0, 1, '2018-12-31 04:49:44', '2018-12-31 07:06:20'),
(15, 'Question no eleven', 4, NULL, 1, NULL, NULL, 10, 5, 0, 1, '2018-12-31 04:50:47', '2018-12-31 04:50:47'),
(16, 'Question No 12', 4, NULL, 1, NULL, NULL, 10, 5, 0, 1, '2018-12-31 04:51:30', '2019-01-02 08:07:53'),
(17, 'Question no 13', 4, NULL, 1, NULL, NULL, 10, 5, 0, 1, '2018-12-31 04:52:17', '2018-12-31 07:05:48'),
(18, 'Which place is best for travel in winter season ?', 11, NULL, 1, NULL, NULL, 2, 5, 0, 1, '2018-12-31 04:53:09', '2019-01-02 06:54:58'),
(19, 'In which country COX Bazar sea beach is situated ?', 11, NULL, 1, NULL, NULL, 2, 10, 0, 1, '2019-01-02 06:57:03', '2019-01-02 06:58:22'),
(20, 'Where is the biggest shopping mall situated ?', 9, NULL, 1, NULL, NULL, 2, 10, 0, 1, '2019-01-02 06:59:52', '2019-01-02 06:59:52'),
(21, 'what is your name', 8, NULL, 1, NULL, NULL, 2, 10, 0, 1, '2019-01-02 07:03:56', '2019-01-02 07:03:56'),
(24, 'How are you ?', 2, NULL, 1, NULL, NULL, 2, 10, 0, 1, '2019-01-02 07:22:45', '2019-01-02 07:22:45'),
(25, 'Are you alien ?', 2, NULL, 1, NULL, NULL, 2, 10, 0, 1, '2019-01-02 07:23:46', '2019-01-02 07:23:46'),
(26, 'Where do you wanna go ?', 8, NULL, 1, NULL, NULL, 2, 10, 0, 1, '2019-01-02 07:36:21', '2019-01-02 07:36:21'),
(27, 'Do you like pets ?', 8, NULL, 1, NULL, NULL, 2, 10, 0, 0, '2019-01-02 08:06:10', '2019-01-04 01:07:42');

-- --------------------------------------------------------

--
-- Table structure for table `question_options`
--

CREATE TABLE `question_options` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `option_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `option_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `serial` int(11) DEFAULT NULL,
  `is_answer` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `question_options`
--

INSERT INTO `question_options` (`id`, `question_id`, `option_title`, `option_image`, `serial`, `is_answer`, `created_at`, `updated_at`) VALUES
(31, 2, 'qqq', NULL, NULL, 0, NULL, NULL),
(32, 2, 'www', NULL, NULL, 1, NULL, NULL),
(33, 2, 'rrrr', NULL, NULL, 0, NULL, NULL),
(34, 3, 'option 1', NULL, NULL, 0, NULL, NULL),
(35, 3, 'option 2', NULL, NULL, 0, NULL, NULL),
(36, 3, 'option 3', NULL, NULL, 0, NULL, NULL),
(37, 3, 'option 4', NULL, NULL, 1, NULL, NULL),
(50, 7, 'answer 1', NULL, NULL, 0, NULL, NULL),
(51, 7, 'answer 2', NULL, NULL, 1, NULL, NULL),
(52, 6, 'option 4', NULL, NULL, 0, NULL, NULL),
(53, 6, 'option 5', NULL, NULL, 1, NULL, NULL),
(54, 4, 'option 4', NULL, NULL, 0, NULL, NULL),
(55, 4, 'option 3', NULL, NULL, 0, NULL, NULL),
(56, 4, 'option 2', NULL, NULL, 1, NULL, NULL),
(57, 4, 'op', NULL, NULL, 0, NULL, NULL),
(58, 5, 'option 6', NULL, NULL, 0, NULL, NULL),
(59, 5, 'option 4', NULL, NULL, 0, NULL, NULL),
(60, 5, 'option 3', NULL, NULL, 0, NULL, NULL),
(61, 5, 'option 2', NULL, NULL, 0, NULL, NULL),
(62, 5, 'option 1', NULL, NULL, 0, NULL, NULL),
(63, 5, 'option 5', NULL, NULL, 1, NULL, NULL),
(67, 8, 'test2', NULL, NULL, 0, NULL, NULL),
(68, 8, 'test1', NULL, NULL, 1, NULL, NULL),
(69, 9, 'ans2', NULL, NULL, 1, NULL, NULL),
(70, 9, 'ans1', NULL, NULL, 0, NULL, NULL),
(71, 10, 'ans1', NULL, NULL, 1, NULL, NULL),
(72, 10, 'ans2', NULL, NULL, 0, NULL, NULL),
(73, 11, 'answer1', NULL, NULL, 1, NULL, NULL),
(74, 11, 'answer 2', NULL, NULL, 0, NULL, NULL),
(75, 12, 'test1', NULL, NULL, 1, NULL, NULL),
(76, 12, 'test', NULL, NULL, 0, NULL, NULL),
(81, 15, 'eleven1', NULL, NULL, 1, NULL, NULL),
(82, 15, 'eleven', NULL, NULL, 1, NULL, NULL),
(83, 16, '13', NULL, NULL, 0, NULL, NULL),
(84, 16, '12', NULL, NULL, 1, NULL, NULL),
(89, 17, 'ans1', NULL, NULL, 0, NULL, NULL),
(90, 17, 'ans2', NULL, NULL, 1, NULL, NULL),
(93, 14, 'ten', NULL, NULL, 0, NULL, NULL),
(94, 14, 'wow', NULL, NULL, 1, NULL, NULL),
(95, 13, 'game', NULL, NULL, 1, NULL, NULL),
(96, 13, 'hello', NULL, NULL, 0, NULL, NULL),
(99, 18, 'Sea Beach', NULL, NULL, 1, '2019-01-02 06:54:58', '2019-01-02 06:54:58'),
(100, 18, 'Tea Garden', NULL, NULL, 0, '2019-01-02 06:54:58', '2019-01-02 06:54:58'),
(101, 18, 'Park', NULL, NULL, 0, '2019-01-02 06:54:58', '2019-01-02 06:54:58'),
(102, 24, 'bad', NULL, NULL, 1, '2019-01-02 07:22:45', '2019-01-02 07:22:45'),
(103, 24, 'fine', NULL, NULL, 0, '2019-01-02 07:22:45', '2019-01-02 07:22:45'),
(104, 25, 'yes', NULL, NULL, 0, '2019-01-02 07:23:46', '2019-01-02 07:23:46'),
(105, 25, 'mideum', NULL, NULL, 0, '2019-01-02 07:23:46', '2019-01-02 07:23:46'),
(106, 25, 'no', NULL, NULL, 1, '2019-01-02 07:23:46', '2019-01-02 07:23:46'),
(107, 26, 'Bangladesh', NULL, NULL, 0, '2019-01-02 07:36:21', '2019-01-02 07:36:21'),
(108, 26, 'Portugal', NULL, NULL, 1, '2019-01-02 07:36:21', '2019-01-02 07:36:21'),
(113, 27, 'yes', NULL, NULL, 1, '2019-01-03 00:16:34', '2019-01-03 00:16:34'),
(114, 27, 'No', NULL, NULL, 0, '2019-01-03 00:16:34', '2019-01-03 00:16:34');

-- --------------------------------------------------------

--
-- Table structure for table `quiz_results`
--

CREATE TABLE `quiz_results` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `score` bigint(20) NOT NULL DEFAULT '0',
  `coin` bigint(20) NOT NULL DEFAULT '0',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `photo` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active_status` tinyint(4) NOT NULL DEFAULT '1',
  `role` tinyint(4) NOT NULL DEFAULT '2',
  `email_verified` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `reset_code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `zip` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `country`, `phone`, `photo`, `active_status`, `role`, `email_verified`, `reset_code`, `city`, `state`, `address`, `zip`, `language`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'admin@email.com', '$2y$10$.Dna03Aw.O2vgk.8EN2hW.78.noXK7rxSHpjrbyCKALT1MVLju/VK', 'Bangladesh', '013698512', '1546438402.jpg', 1, 1, '1', 'c453c08aa1f0f4829aaeb538918a9897', 'Khulna', 'Khulna', 'Khulna', '9250', 'en', 'oisWUqvhfbYP7wTkFXOmPiSqUFzx1CBeTMNGDZO4s3E4J59bGOvfvu7IUIvq', '2018-12-27 06:08:50', '2019-01-02 08:13:22'),
(2, 'Mr. user', 'user@email.com', '$2y$10$58dlZK4UsZI4NFDh5qHSFuzqcpdIFzvbzVtegvuHFTdxiCLCW0zpi', 'bd', '+8801313682980', '1546190175.png', 0, 2, '1', '8134da3f7a913615a4606dabd38e1cfd', NULL, NULL, NULL, NULL, 'en', NULL, '2018-12-27 06:08:50', '2019-01-03 04:43:50'),
(4, 'Mr. user', 'messi@email.com', '$2y$10$9YAN6Pf.agFEJunGrPY1HOHSQgvRMoWCWjZNbbLQS053Unu3j/s0G', 'bd', '+8801313682980', NULL, 1, 2, '1', '8134da3f7a913615a4606dabd38e1cfl', NULL, NULL, NULL, NULL, 'en', 'ZPA4ALQa4wMsW57gnv37UBv8uqk1o4j80hVf0Wn6ZLKVr8STA5wZ0WgIS7nz', '2018-12-27 06:41:41', '2019-01-01 00:57:49'),
(5, 'David Beckhum', 'david@email.com', '$2y$10$/T3rUAhGlapb9HVe5S2dU.LE8ci/NUj0FuaoZmFjle/4ywWLXdka2', NULL, NULL, NULL, 1, 2, '1', '27bcefb6664b81a2a14d7ef737410a01', NULL, NULL, NULL, NULL, 'en', NULL, '2018-12-27 10:56:39', '2019-01-01 05:09:54'),
(6, 'QA', 'qa@squaredworks.com', '$2y$10$EOYKJ9EuwP1fkGsbLVPnxOnvfQj8XbJzpQb6v.6Zp4xjzmh58vz3a', NULL, '02', NULL, 1, 1, '1', 'bdd7e8753b8ae6cf1b9ceff87f4e48b1', NULL, NULL, NULL, NULL, 'en', 'd6arn8ECQvWaMWvSOkiTNLukNVklkj4KZdrySvan4IgDui5HglJ5ktsC2Chl', '2018-12-31 04:13:56', '2019-01-03 04:40:14'),
(7, 'Leo Messi', 'messi10@email.com', '$2y$10$HartX/arrFVtZ5KgQbJBv.er8imxXoAZaB1kI9g5kOGST2A4r7./W', NULL, '01955784397', NULL, 1, 2, '0', '695e76badb4a335d1ec42e0b23965d0f', NULL, NULL, NULL, NULL, 'en', NULL, '2019-01-01 23:27:07', '2019-01-03 04:40:15');

-- --------------------------------------------------------

--
-- Table structure for table `user_answers`
--

CREATE TABLE `user_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `is_correct` tinyint(1) NOT NULL DEFAULT '0',
  `given_answer` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `point` int(11) NOT NULL DEFAULT '0',
  `coin` int(11) NOT NULL DEFAULT '0',
  `type` int(11) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_answers`
--

INSERT INTO `user_answers` (`id`, `user_id`, `category_id`, `question_id`, `is_correct`, `given_answer`, `point`, `coin`, `type`, `status`, `created_at`, `updated_at`) VALUES
(1, 2, 4, 5, 0, NULL, 0, 0, 1, 0, '2018-12-30 06:31:27', '2018-12-30 06:31:27'),
(2, 2, 5, 6, 1, NULL, 5, 0, 1, 1, '2018-12-30 10:17:17', '2018-12-30 10:18:17'),
(3, 4, 5, 6, 1, NULL, 5, 0, 1, 1, '2018-12-30 10:17:17', '2018-12-30 10:18:17'),
(4, 5, 5, 6, 1, NULL, 5, 0, 1, 1, '2018-12-30 10:17:17', '2018-12-30 10:18:17'),
(5, 4, 4, 5, 0, NULL, 5, 0, 1, 1, '2018-12-30 06:31:27', '2018-12-30 06:31:27'),
(6, 5, 4, 5, 0, NULL, 5, 0, 1, 1, '2018-12-30 06:31:27', '2018-12-30 06:31:27'),
(8, 2, 5, 10, 1, NULL, 5, 0, 1, 1, '2018-12-30 10:17:17', '2018-12-30 10:18:17'),
(9, 2, 4, 3, 0, NULL, 0, 0, 1, 1, '2018-12-31 23:42:18', '2018-12-31 23:42:18'),
(10, 7, 5, 6, 0, NULL, 0, 0, 1, 1, '2019-01-01 23:33:22', '2019-01-01 23:33:22');

-- --------------------------------------------------------

--
-- Table structure for table `user_verification_codes`
--

CREATE TABLE `user_verification_codes` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `type` tinyint(1) NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `expired_at` date DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_verification_codes`
--

INSERT INTO `user_verification_codes` (`id`, `user_id`, `type`, `code`, `expired_at`, `status`, `created_at`, `updated_at`) VALUES
(2, 4, 1, '624552', '2019-01-06', 0, '2018-12-27 06:41:41', '2018-12-27 06:41:41'),
(3, 4, 1, '127428', '2019-01-06', 1, '2018-12-27 07:29:56', '2018-12-27 07:30:18'),
(4, 5, 1, 'jJr6HIQOeirDBFzDMazQTcM4zWx2wYiHmGS5303EmTYyxxZYI83okwmKIdce', '2019-01-06', 0, '2018-12-27 10:56:39', '2018-12-27 10:56:39'),
(5, 5, 1, '971525', '2019-01-13', 0, '2018-12-29 10:51:10', '2018-12-29 10:51:10'),
(6, 6, 1, 'QiAmns0UlbHiEQM9ydrZgmhO4n7K60hFt2dECqaxo3jpvIz08olLOzsl2j1K', '2019-01-10', 1, '2018-12-31 04:13:56', '2018-12-31 04:16:12'),
(7, 7, 1, '846218', '2019-01-12', 0, '2019-01-01 23:27:07', '2019-01-01 23:27:07'),
(8, 5, 1, '813297', '2019-01-17', 0, '2019-01-01 23:42:30', '2019-01-01 23:42:30');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_settings`
--
ALTER TABLE `admin_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_access_tokens`
--
ALTER TABLE `oauth_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_access_tokens_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_auth_codes`
--
ALTER TABLE `oauth_auth_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_clients_user_id_index` (`user_id`);

--
-- Indexes for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_personal_access_clients_client_id_index` (`client_id`);

--
-- Indexes for table `oauth_refresh_tokens`
--
ALTER TABLE `oauth_refresh_tokens`
  ADD PRIMARY KEY (`id`),
  ADD KEY `oauth_refresh_tokens_access_token_id_index` (`access_token_id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_category_id_foreign` (`category_id`);

--
-- Indexes for table `question_options`
--
ALTER TABLE `question_options`
  ADD PRIMARY KEY (`id`),
  ADD KEY `question_options_question_id_foreign` (`question_id`);

--
-- Indexes for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD PRIMARY KEY (`id`),
  ADD KEY `quiz_results_user_id_foreign` (`user_id`),
  ADD KEY `quiz_results_category_id_foreign` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_reset_code_unique` (`reset_code`);

--
-- Indexes for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_answers_user_id_foreign` (`user_id`),
  ADD KEY `user_answers_category_id_foreign` (`category_id`),
  ADD KEY `user_answers_question_id_foreign` (`question_id`);

--
-- Indexes for table `user_verification_codes`
--
ALTER TABLE `user_verification_codes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_verification_codes_user_id_foreign` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_settings`
--
ALTER TABLE `admin_settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- AUTO_INCREMENT for table `oauth_clients`
--
ALTER TABLE `oauth_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `oauth_personal_access_clients`
--
ALTER TABLE `oauth_personal_access_clients`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `question_options`
--
ALTER TABLE `question_options`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=115;
--
-- AUTO_INCREMENT for table `quiz_results`
--
ALTER TABLE `quiz_results`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `user_answers`
--
ALTER TABLE `user_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `user_verification_codes`
--
ALTER TABLE `user_verification_codes`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `question_options`
--
ALTER TABLE `question_options`
  ADD CONSTRAINT `question_options_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `quiz_results`
--
ALTER TABLE `quiz_results`
  ADD CONSTRAINT `quiz_results_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `quiz_results_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_answers`
--
ALTER TABLE `user_answers`
  ADD CONSTRAINT `user_answers_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_answers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_verification_codes`
--
ALTER TABLE `user_verification_codes`
  ADD CONSTRAINT `user_verification_codes_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
