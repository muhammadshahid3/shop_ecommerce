-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 13, 2025 at 11:37 AM
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
-- Database: `shop_schema`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(15) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `username`, `email`, `password`, `phone_number`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$y3c7/OYZQoXE7CF89rdpc.HGrUmWWJxvm.OmY3FC1qXs5qOqagolG', '12345678910', '2024-08-02 13:50:59', '2024-12-09 10:37:45');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `banner_start_text` text DEFAULT NULL,
  `banner_title` text DEFAULT NULL,
  `banner_subtitle` text DEFAULT NULL,
  `banner_image` text DEFAULT NULL,
  `banner_btnlink` text DEFAULT NULL,
  `banner_status` enum('A','I') NOT NULL DEFAULT 'A',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `blogs`
--

CREATE TABLE `blogs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `thumbnail` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `blog_status` enum('A','I') NOT NULL DEFAULT 'A',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `blogs`
--

INSERT INTO `blogs` (`id`, `title`, `thumbnail`, `description`, `blog_status`, `created_at`, `updated_at`) VALUES
(2, 'The Modern Art Clay Ceramics.', '7251817140687556.jpg', 'The world is an amazing place providing an incredible assortment of interesting locations across.', 'A', '2024-09-01 07:24:29', '2024-09-02 05:43:06'),
(3, 'How clothes are linked to climate', '7251755380309237.jpg', 'The world is an amazing place providing an incredible assortment of interesting locations across.', 'A', '2024-09-01 07:25:38', '2024-09-01 07:25:38'),
(6, 'The Sound Of Fashion: Malcolm', '7251825650794278.jpg', 'The world is an amazing place providing an incredible assortment of interesting locations across.', 'A', '2024-09-01 09:22:45', '2024-09-01 09:22:45'),
(8, 'The Modern Art Clay Ceramics.', '7251866300667081.jpg', 'The world is an amazing place providing an incredible assortment of interesting locations across.', 'A', '2024-09-01 10:30:30', '2024-09-01 10:31:29');

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
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_slug` varchar(100) DEFAULT NULL,
  `category_name` varchar(255) NOT NULL,
  `category_image` varchar(255) NOT NULL,
  `category_icon` text DEFAULT NULL,
  `category_order` text DEFAULT NULL,
  `category_status` enum('A','I') NOT NULL DEFAULT 'A',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category_slug`, `category_name`, `category_image`, `category_icon`, `category_order`, `category_status`, `created_at`, `updated_at`) VALUES
(15, '7240507230900801', 'Headphone', '7240507230900801.jpg', 'fa fa-headphones', '1', 'A', '2024-08-19 01:58:43', '2024-08-19 01:58:43'),
(19, '7240716430987652', 'Mobile Phone', '7240716430987652.jpg', 'fa fa-mobile-alt', '3', 'A', '2024-08-19 07:47:24', '2024-08-31 08:57:02'),
(20, '7251325240984169', 'Smart Watch', '7251325240984169.jpg', 'fa fa-robot', '4', 'A', '2024-08-19 12:01:08', '2024-08-31 19:28:44'),
(26, '7253440440315058', 'Clothe', '7253440440315058.jpg', 'fa fa-shirt', '5', 'A', '2024-09-03 06:14:04', '2024-09-03 06:14:04'),
(27, '7253441360936367', 'Bag', '7253441360936367.jpg', 'fa fa-bag-shopping', '6', 'A', '2024-09-03 06:15:36', '2024-09-03 06:15:57'),
(28, '7253442180278239', 'T-Shirt', '7253442180278239.jpg', 'fa fa-shirt', '7', 'A', '2024-09-03 06:16:58', '2024-09-03 06:16:58'),
(29, '7253443450225327', 'Shoes', '7253443450225327.jpg', 'fa fa-shoe-prints', '8', 'A', '2024-09-03 06:19:05', '2024-09-03 06:20:32');

-- --------------------------------------------------------

--
-- Table structure for table `cms_texts`
--

CREATE TABLE `cms_texts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tag` text DEFAULT NULL,
  `value` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cms_texts`
--

INSERT INTO `cms_texts` (`id`, `tag`, `value`, `created_at`, `updated_at`) VALUES
(1, 'header_contact', '03123456789', '2024-12-21 06:58:18', '2024-12-21 06:58:18'),
(2, 'header_logo', '7351438830480113.png', '2024-12-21 06:59:58', '2024-12-21 06:59:58');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `subject` text DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `contact_us`
--

INSERT INTO `contact_us` (`id`, `customer_id`, `subject`, `message`, `created_at`, `updated_at`) VALUES
(5, 1, 'Texting', 'Customer side texting message', '2024-08-24 06:08:28', '2024-08-24 06:08:28'),
(7, 2, 'product purchase', 'customer msg', '2024-12-03 16:10:11', '2024-12-03 16:10:11'),
(8, 2, 'product purchase', 'customer msg', '2024-12-03 16:27:27', '2024-12-03 16:27:27');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `coupon_code` text DEFAULT NULL,
  `coupon_amount` double(8,2) DEFAULT NULL,
  `number_of_uses` int(11) DEFAULT NULL,
  `coupon_stock` int(11) DEFAULT NULL,
  `limit_per_uses` int(11) DEFAULT NULL,
  `coupon_start_date` date DEFAULT NULL,
  `coupon_end_date` date DEFAULT NULL,
  `coupon_status` enum('A','I') NOT NULL DEFAULT 'I',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`id`, `coupon_code`, `coupon_amount`, `number_of_uses`, `coupon_stock`, `limit_per_uses`, `coupon_start_date`, `coupon_end_date`, `coupon_status`, `created_at`, `updated_at`) VALUES
(1, 'AUG@1406', 10.00, 3, 3, 3, '2024-10-20', '2024-10-25', 'A', '2024-10-10 10:12:29', '2024-10-23 18:55:17'),
(3, 'NEW@0101', 10.00, 3, 3, 1, '2024-10-10', '2024-10-10', 'A', '2024-10-10 16:14:49', '2024-10-10 16:14:49');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `username` varchar(15) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `status` enum('A','I') NOT NULL DEFAULT 'A',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `email`, `password`, `phone_number`, `status`, `created_at`, `updated_at`) VALUES
(1, 'John Doe', 'john@gmail.com', '$2y$10$y3c7/OYZQoXE7CF89rdpc.HGrUmWWJxvm.OmY3FC1qXs5qOqagolG', '12345678910', 'A', '2024-08-20 13:40:36', '2024-09-03 10:16:00'),
(2, 'Tim Bro', 'tim@gmail.com', '$2y$10$7p0xf69PAafLNJG2oZ4.o.1tR5vGOCLhABysF1.umcqYDiouzj8gy', '12345678911', 'A', '2024-08-20 10:18:45', '2024-12-26 06:59:10'),
(3, 'test user', 'test@gmail.com', '$2y$10$nsiSGlCnadocqzEcvUSRPu6NRjJLBrUgg3m1d2NMnlOcbc/P62DDq', '01234567891', 'A', '2024-09-30 06:44:00', '2024-09-30 06:44:00');

-- --------------------------------------------------------

--
-- Table structure for table `customer_details`
--

CREATE TABLE `customer_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `username` varchar(15) DEFAULT NULL,
  `email` varchar(20) DEFAULT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `house_no` text DEFAULT NULL,
  `street` varchar(100) DEFAULT NULL,
  `city` varchar(150) DEFAULT NULL,
  `postcode` varchar(15) DEFAULT NULL,
  `message` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customer_details`
--

INSERT INTO `customer_details` (`id`, `customer_id`, `order_id`, `username`, `email`, `phone_number`, `house_no`, `street`, `city`, `postcode`, `message`, `created_at`, `updated_at`) VALUES
(1, 2, 21, 'Tim Bro', 'tim@gmail.com', '12345678911', 'house', 'street', 'town', '111111', 'customer msg', '2024-12-03 16:07:47', '2024-12-03 16:07:47'),
(2, 2, 22, 'Tim Bro', 'tim@gmail.com', '12345678911', 'house', 'street', 'town', '111111', 'customer msg', '2024-12-03 16:25:24', '2024-12-03 16:25:24'),
(3, 2, 32, 'Tim Bro', 'tim@gmail.com', '12345678911', 'df', 'dfd', 'dfdfsdf', '610133', 'dfsdf', '2024-12-13 11:43:08', '2024-12-13 11:43:08'),
(4, 2, 42, 'Tim Bro', 'tim@gmail.com', '12345678911', 'house', 'street', 'clity', '11111', 'order msg', '2025-01-21 10:17:48', '2025-01-21 10:17:48');

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
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question` text DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`id`, `question`, `answer`, `created_at`, `updated_at`) VALUES
(3, 'What types of products do you use?', 'We use various verity of products.', '2024-09-02 10:25:27', '2024-09-02 10:25:27');

-- --------------------------------------------------------

--
-- Table structure for table `general_settings`
--

CREATE TABLE `general_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `shop_logo` varchar(100) DEFAULT NULL,
  `shop_name` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `notification` enum('A','I') NOT NULL DEFAULT 'I',
  `status` enum('A','I') NOT NULL DEFAULT 'A',
  `facebook` text DEFAULT NULL,
  `instagram` text DEFAULT NULL,
  `twitter` text DEFAULT NULL,
  `test_number` text DEFAULT NULL,
  `order_collection_type` enum('C','N') NOT NULL DEFAULT 'C',
  `order_delivery_type` enum('D','N') NOT NULL DEFAULT 'D',
  `shipping_charges` float DEFAULT NULL,
  `discount_value` float DEFAULT NULL,
  `discount_type` enum('V','P','N') DEFAULT 'V',
  `shipping_status` enum('F','N') NOT NULL DEFAULT 'N',
  `pay_by_cash` enum('A','I') NOT NULL DEFAULT 'I',
  `pay_by_card` enum('A','I') NOT NULL DEFAULT 'I',
  `beep_status` enum('A','I') NOT NULL DEFAULT 'A',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `general_settings`
--

INSERT INTO `general_settings` (`id`, `shop_logo`, `shop_name`, `email`, `contact`, `address`, `description`, `notification`, `status`, `facebook`, `instagram`, `twitter`, `test_number`, `order_collection_type`, `order_delivery_type`, `shipping_charges`, `discount_value`, `discount_type`, `shipping_status`, `pay_by_cash`, `pay_by_card`, `beep_status`, `created_at`, `updated_at`) VALUES
(1, '172413579566c43973b4077.png', 'Shops', 'shop@gmail.com', '03123456789', '123 Street New Town Main City Top Country', 'We are a team of designers and developers that create high quality Projects', 'I', 'A', 'https://www.facebook.com/', 'https://www.instagram.com/', 'https://twitter.com/', '01234567891', 'C', 'D', 20, 20, 'V', 'F', 'A', 'A', 'A', '2024-08-20 00:19:54', '2024-12-21 17:35:50');

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
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2024_07_19_165226_create_admins_table', 1),
(6, '2024_07_20_084420_create_customers_table', 1),
(7, '2024_07_20_131804_create_cache_table', 1),
(8, '2024_07_24_070850_create_categories_table', 1),
(11, '2024_07_26_162946_create_products_table', 1),
(12, '2024_07_26_165900_create_products_gallery_img_table', 1),
(13, '2024_07_29_182949_add_sizes_table', 1),
(14, '2024_08_03_060455_create_banners_table', 2),
(16, '2024_08_16_062402_create_products_gallery_img_table', 4),
(17, '2024_08_19_054929_create_general_settings_table', 5),
(18, '2024_08_20_062735_create_product_newarrivals_table', 6),
(19, '2024_08_20_062753_create_product_features_table', 6),
(20, '2024_08_20_062809_create_product_topsellers_table', 6),
(21, '2024_08_20_063118_create_contact_us_table', 6),
(23, '2024_08_22_072640_create_store_texts_table', 7),
(24, '2024_08_27_003329_create_product_additional_details_table', 8),
(25, '2024_08_27_003434_create_faqs_table', 8),
(27, '2024_08_29_113522_create_product_ratings_table', 9),
(28, '2024_09_01_111205_create_blogs_table', 10),
(31, '2024_09_04_152544_create_stock_transactions_table', 12),
(32, '2024_09_21_123640_create_orders_table', 13),
(33, '2024_09_23_142251_create_customer_details_table', 14),
(35, '2024_09_28_221536_create_order_numbers_table', 15),
(38, '2024_10_10_005547_create_coupons_table', 16),
(39, '2024_12_19_153709_create_cms_texts_table', 17);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `order_slug` varchar(100) DEFAULT NULL,
  `order_products` longtext DEFAULT NULL,
  `order_number` text DEFAULT NULL,
  `order_total_qty` int(11) DEFAULT NULL,
  `order_subtotal_price` float(8,2) DEFAULT NULL,
  `coupon_id` int(11) DEFAULT NULL,
  `discount_value` float(8,2) DEFAULT NULL,
  `discount_type` enum('V','P','N') DEFAULT NULL,
  `shipping_charges` float(8,2) DEFAULT NULL,
  `shipping_status` enum('F','N') DEFAULT NULL,
  `order_net_total` float(8,2) DEFAULT NULL,
  `order_highlight` enum('A','I') NOT NULL DEFAULT 'I',
  `order_beep_status` enum('A','I') NOT NULL DEFAULT 'A',
  `order_alert` enum('A','I') NOT NULL DEFAULT 'I',
  `payment_method` enum('PBC','COD','N') NOT NULL DEFAULT 'N',
  `order_delivery_time` enum('C','D') NOT NULL DEFAULT 'C',
  `order_status` enum('P','U') NOT NULL DEFAULT 'U',
  `order_cancel` enum('A','I') NOT NULL DEFAULT 'I',
  `order_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `customer_id`, `order_slug`, `order_products`, `order_number`, `order_total_qty`, `order_subtotal_price`, `coupon_id`, `discount_value`, `discount_type`, `shipping_charges`, `shipping_status`, `order_net_total`, `order_highlight`, `order_beep_status`, `order_alert`, `payment_method`, `order_delivery_time`, `order_status`, `order_cancel`, `order_date`, `created_at`, `updated_at`) VALUES
(1, 2, '7297097160916936', '[{\"product_c_slug\":\"7253442180278239\",\"product_slug\":7253458420628345,\"product_name\":\"T-Shirt\",\"product_price\":\"800.00\",\"product_qty\":1,\"product_stock\":\"3\",\"product_thumbnail\":\"7253458420646583.jpg\"}]', '1', 1, 800.00, 1, 20.00, 'V', NULL, NULL, 770.00, 'I', 'I', 'I', 'COD', 'C', 'P', 'I', '2024-10-23', '2024-10-23 18:55:16', '2024-11-13 10:11:11'),
(7, 2, '7300944650369092', '[{\"product_c_slug\":\"7253440440315058\",\"product_slug\":7253457220922117,\"product_name\":\"Women-Colth\",\"product_price\":\"3500.00\",\"product_qty\":1,\"product_stock\":\"22\",\"product_thumbnail\":\"7253458530412405.jpg\"}]', '2', 1, 3500.00, NULL, 20.00, 'V', NULL, NULL, 3480.00, 'I', 'I', 'I', 'COD', 'C', 'P', 'I', '2024-10-28', '2024-10-28 05:47:45', '2024-11-13 10:11:11'),
(8, 2, '7300945860338178', '[{\"product_c_slug\":\"7240507230900801\",\"product_slug\":7253446440725834,\"product_name\":\"Headphone\",\"product_price\":\"2000.00\",\"product_qty\":1,\"product_stock\":\"1\",\"product_thumbnail\":\"7253446440741796.jpg\"},{\"product_c_slug\":\"7240716430987652\",\"product_slug\":7253448780811113,\"product_name\":\"Mobile\",\"product_price\":\"40000.00\",\"product_qty\":1,\"product_stock\":\"12\",\"product_thumbnail\":\"7253448780831048.jpg\"}]', '3', 2, 42000.00, NULL, 20.00, 'V', NULL, NULL, 41980.00, 'I', 'I', 'I', 'COD', 'C', 'P', 'I', '2024-10-28', '2024-10-28 05:49:46', '2024-11-13 10:11:11'),
(9, 2, '7300946350880719', '[{\"product_c_slug\":\"7240716430987652\",\"product_slug\":7253451890599242,\"product_name\":\"Mobile S3\",\"product_price\":\"42000.00\",\"product_qty\":1,\"product_stock\":\"13\",\"product_thumbnail\":\"7253451890626622.jpg\"}]', '4', 1, 42000.00, NULL, 20.00, 'V', NULL, NULL, 41980.00, 'I', 'I', 'I', 'COD', 'C', 'P', 'I', '2024-10-28', '2024-10-28 05:50:35', '2024-11-13 10:11:11'),
(10, 2, '7303089200333064', '[{\"product_c_slug\":\"7240716430987652\",\"product_slug\":7253448780811113,\"product_name\":\"Mobile\",\"product_price\":\"40000.00\",\"product_qty\":1,\"product_stock\":\"12\",\"product_thumbnail\":\"7253448780831048.jpg\"},{\"product_c_slug\":\"7240507230900801\",\"product_slug\":7253446440725834,\"product_name\":\"Headphone\",\"product_price\":\"2000.00\",\"product_qty\":1,\"product_stock\":\"1\",\"product_thumbnail\":\"7253446440741796.jpg\"}]', '5', 2, 42000.00, NULL, 20.00, 'V', NULL, NULL, 41980.00, 'I', 'I', 'I', 'COD', 'C', 'P', 'I', '2024-10-30', '2024-10-30 17:22:00', '2024-11-13 10:11:11'),
(11, 2, '7303539890140360', '[{\"product_c_slug\":\"7253441360936367\",\"product_slug\":7253461040054870,\"product_name\":\"Bag\",\"product_price\":\"3000.00\",\"product_qty\":1,\"product_stock\":\"3\",\"product_thumbnail\":\"7253461040074905.jpg\"}]', '6', 1, 3000.00, NULL, 20.00, 'V', NULL, NULL, 2980.00, 'I', 'I', 'I', 'COD', 'C', 'P', 'I', '2024-10-31', '2024-10-31 05:53:09', '2024-11-13 10:11:11'),
(27, 2, '7334664630884695', '[{\"product_c_slug\":\"7240507230900801\",\"product_slug\":7313940160861838,\"product_name\":\"Headphone\",\"product_price\":\"2000.00\",\"product_qty\":3,\"product_stock\":\"4\",\"product_thumbnail\":\"7313940160882689.jpg\"}]', '7', 3, 6000.00, NULL, 20.00, 'V', NULL, NULL, 5980.00, 'I', 'I', 'I', 'PBC', 'C', 'P', 'I', '2024-12-06', '2024-12-06 06:27:43', '2024-12-06 06:27:43'),
(28, 2, '7334730640015827', '[{\"product_c_slug\":\"7253442180278239\",\"product_slug\":7313937460729590,\"product_name\":\"T-Shirt\",\"product_price\":\"1800.00\",\"product_qty\":1,\"product_stock\":\"20\",\"product_thumbnail\":\"7313937460749268.jpg\"}]', '8', 1, 1800.00, NULL, 20.00, 'V', NULL, NULL, 1780.00, 'I', 'I', 'I', 'PBC', 'C', 'P', 'I', '2024-12-06', '2024-12-06 08:17:44', '2024-12-06 08:18:17'),
(29, 2, '7334783120350549', '[{\"product_c_slug\":\"7253442180278239\",\"product_slug\":7313937460729590,\"product_name\":\"T-Shirt\",\"product_price\":\"1800.00\",\"product_qty\":1,\"product_stock\":\"20\",\"product_thumbnail\":\"7313937460749268.jpg\"}]', '9', 1, 1800.00, NULL, 20.00, 'V', NULL, NULL, 1780.00, 'I', 'I', 'I', 'PBC', 'C', 'P', 'I', '2024-12-06', '2024-12-06 09:45:12', '2024-12-06 09:45:35'),
(30, 2, '7334784120657088', '[{\"product_c_slug\":\"7253442180278239\",\"product_slug\":7313937460729590,\"product_name\":\"T-Shirt\",\"product_price\":\"1800.00\",\"product_qty\":1,\"product_stock\":\"20\",\"product_thumbnail\":\"7313937460749268.jpg\"}]', '10', 1, 1800.00, NULL, 20.00, 'V', NULL, NULL, 1780.00, 'I', 'I', 'I', 'PBC', 'C', 'P', 'I', '2024-12-06', '2024-12-06 09:46:52', '2024-12-06 09:47:17'),
(31, 2, '7334817010224923', '[{\"product_c_slug\":\"7253442180278239\",\"product_slug\":7313937460729590,\"product_name\":\"T-Shirt\",\"product_price\":\"1800.00\",\"product_qty\":1,\"product_stock\":\"20\",\"product_thumbnail\":\"7313937460749268.jpg\"}]', '11', 1, 1800.00, NULL, 20.00, 'V', NULL, NULL, 1780.00, 'I', 'I', 'I', 'COD', 'C', 'P', 'I', '2024-12-06', '2024-12-06 10:41:41', '2025-01-03 13:57:27'),
(32, 2, '7340901880261635', '[{\"product_c_slug\":\"7253443450225327\",\"product_slug\":7313938660794166,\"product_name\":\"shoes\",\"product_price\":\"3200.00\",\"product_qty\":2,\"product_stock\":\"5\",\"product_thumbnail\":\"7313938660815461.jpg\"},{\"product_c_slug\":\"7240507230900801\",\"product_slug\":7313940160861838,\"product_name\":\"Headphone\",\"product_price\":\"2000.00\",\"product_qty\":1,\"product_stock\":\"4\",\"product_thumbnail\":\"7313940160882689.jpg\"}]', '12', 3, 8400.00, NULL, 20.00, 'V', 20.00, 'F', 8400.00, 'I', 'I', 'I', 'PBC', 'D', 'U', 'I', '2024-12-13', '2024-12-13 11:43:08', '2025-01-04 16:27:54'),
(33, 2, '7358873080667182', '[{\"product_c_slug\":\"7253440440315058\",\"product_slug\":7313941820052101,\"product_name\":\"Cloth\",\"product_price\":\"4000.00\",\"product_qty\":1,\"product_stock\":\"32\",\"product_stock_status\":\"A\",\"product_thumbnail\":\"7313941820070975.jpg\"}]', '13', 1, 4000.00, NULL, 20.00, 'V', NULL, NULL, 3980.00, 'A', 'I', 'A', 'PBC', 'C', 'U', 'I', '2025-01-03', '2025-01-03 06:55:08', '2025-01-05 08:29:46'),
(40, 2, '7360790690951872', '[{\"product_c_slug\":\"7251325240984169\",\"product_slug\":7313934640224601,\"product_name\":\"Smart Watch\",\"product_price\":\"13000.00\",\"product_qty\":1,\"product_stock\":\"10\",\"product_stock_status\":\"A\",\"product_thumbnail\":\"7313934640243425.jpg\"}]', '14', 1, 13000.00, NULL, 20.00, 'V', NULL, NULL, 12980.00, 'A', 'A', 'A', 'PBC', 'C', 'U', 'I', '2025-01-05', '2025-01-05 12:11:09', '2025-01-05 12:11:09'),
(41, 2, '7360857990840484', '[{\"product_c_slug\":\"7253443450225327\",\"product_slug\":7313938660794166,\"product_name\":\"shoes\",\"product_price\":\"3200.00\",\"product_qty\":1,\"product_stock\":\"5\",\"product_stock_status\":\"A\",\"product_thumbnail\":\"7313938660815461.jpg\"}]', '15', 1, 3200.00, NULL, 20.00, 'V', NULL, NULL, 3180.00, 'A', 'A', 'A', 'PBC', 'C', 'P', 'I', '2025-01-05', '2025-01-05 14:03:19', '2025-01-05 14:04:08'),
(42, 2, '7374546680476853', '[{\"product_c_slug\":\"7253443450225327\",\"product_slug\":7313938660794166,\"product_name\":\"shoes\",\"product_price\":\"3200.00\",\"product_qty\":1,\"product_stock\":\"5\",\"product_stock_status\":\"A\",\"product_thumbnail\":\"7313938660815461.jpg\"},{\"product_c_slug\":\"7253442180278239\",\"product_slug\":7313937460729590,\"product_name\":\"T-Shirt\",\"product_price\":\"1800.00\",\"product_qty\":1,\"product_stock\":\"20\",\"product_stock_status\":\"A\",\"product_thumbnail\":\"7313937460749268.jpg\"}]', '16', 2, 5000.00, NULL, 20.00, 'V', 20.00, 'F', 5000.00, 'A', 'A', 'A', 'PBC', 'D', 'P', 'I', '2025-01-21', '2025-01-21 10:17:48', '2025-01-21 10:18:18');

-- --------------------------------------------------------

--
-- Table structure for table `order_numbers`
--

CREATE TABLE `order_numbers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `order_number` int(11) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `order_numbers`
--

INSERT INTO `order_numbers` (`id`, `order_number`, `created_at`, `updated_at`) VALUES
(1, 17, '2024-09-29 04:58:35', '2024-09-29 04:58:35');

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
-- Table structure for table `personal_access_tokens`
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
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_slug` varchar(100) DEFAULT NULL,
  `product_code` varchar(20) DEFAULT NULL,
  `product_barcode` text DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_name` varchar(50) DEFAULT NULL,
  `product_old_price` float(8,2) DEFAULT NULL,
  `product_price` float(8,2) DEFAULT NULL,
  `product_thumbnail` text DEFAULT NULL,
  `product_description` text DEFAULT NULL,
  `product_manufacturer` text DEFAULT NULL,
  `product_supplier` text DEFAULT NULL,
  `product_weight` text DEFAULT NULL,
  `product_order` text DEFAULT NULL,
  `stock_quantity` int(11) DEFAULT NULL,
  `product_stock_status` enum('A','I') NOT NULL DEFAULT 'A',
  `product_status` enum('A','I') NOT NULL DEFAULT 'A',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `product_slug`, `product_code`, `product_barcode`, `category_id`, `product_name`, `product_old_price`, `product_price`, `product_thumbnail`, `product_description`, `product_manufacturer`, `product_supplier`, `product_weight`, `product_order`, `stock_quantity`, `product_stock_status`, `product_status`, `created_at`, `updated_at`) VALUES
(56, '7253446440725834', 'Hea151300.00', 'Hea151300.00.png', 15, 'Headphone', 1500.00, 300.00, '7253446440741796.jpg', 'Latest product<br>', 'Andoride', 'Apple Company', '100gram', '1', 0, 'I', 'I', '2024-09-03 06:24:04', '2024-12-16 11:26:29'),
(58, '7253451890599242', 'Mob19342000.00', 'Mob19342000.00.png', 19, 'Mobile S3', 35000.00, 42000.00, '7253451890626622.jpg', 'Latest product<br>', 'Andoride', 'Apple Company', '300gram', '3', 13, 'A', 'A', '2024-09-03 06:33:09', '2024-11-12 06:34:23'),
(59, '7253454710361063', 'sma20412000', 'sma20412000.png', 20, 'smart watch', 10000.00, 12000.00, '7253454710381664.jpg', 'Latest product<br>', 'Andoride', 'Apple Company', '100gram', '4', 18, 'A', 'A', '2024-09-03 06:37:51', '2024-09-03 06:37:51'),
(60, '7253457220922117', 'Wom2653500', 'Wom2653500.png', 26, 'Women-Colth', 3000.00, 3500.00, '7253458530412405.jpg', 'Latest product<br>', 'AlaaskaFit Textile', 'khawaja Cloth', '30gram', '5', 22, 'A', 'A', '2024-09-03 06:42:02', '2024-09-03 06:44:13'),
(61, '7253458420628345', 'T-S286800.00', 'T-S286800.00.png', 28, 'T-Shirt', 1500.00, 800.00, '7254484260635388.jpg', 'This is the new brand product<br>', 'AlaaskaFit Textile', 'khawaja Cloth', '20gram', '6', 3, 'A', 'A', '2024-09-03 06:44:02', '2025-01-04 13:37:13'),
(62, '7253461040054870', 'Bag2773000', 'Bag2773000.png', 27, 'Bag', 2500.00, 6000.00, '7253461040074905.jpg', 'This is the latest brand<br>', 'Ganj Bakhsh', 'khawaja', '70gram', '7', 3, 'A', 'A', '2024-09-03 06:48:24', '2024-09-03 06:48:24'),
(65, '7254484260617585', 'T-S2893000', 'T-S2893000.png', 28, 'T-Shirt', 2000.00, 3000.00, '7254484260635388.jpg', 'desc', 'andoride', 'apple company', 'kilo', '9', 25, 'A', 'A', '2024-09-04 11:13:46', '2024-09-05 10:20:09'),
(68, '7272519120343236', 'sho2998000.00', 'sho2998000.00.png', 29, 'shoes', 6000.00, 8000.00, '7272519120363885.jpg', 'best product', 'andoride', 'apple company', 'kilo', '9', 2, 'A', 'A', '2024-09-25 08:11:52', '2024-09-25 08:11:52'),
(69, '7313926500907144', 'Hea158250.00', 'Hea158250.00.png', 15, 'Headphone', 200.00, 250.00, '7313926510586840.jpg', 'This is new brand', 'andoride', 'apple company', 'kilo', '8', 15, 'A', 'A', '2024-11-12 06:24:11', '2024-12-20 13:14:55'),
(70, '7313933770263042', 'Mob19935000.00', 'Mob19935000.00.png', 19, 'Mobile phone', 25000.00, 35000.00, '7313933770282199.jpg', 'this is new brand', 'andoride', 'apple company', 'kilo', '9', 20, 'A', 'A', '2024-11-12 06:36:17', '2024-11-12 06:36:17'),
(71, '7313934640224601', 'Sma201013000.00', 'Sma201013000.00.png', 20, 'Smart Watch', 12000.00, 13000.00, '7313934640243425.jpg', 'this is new brand', 'andoride', 'apple company', 'gram', '10', 10, 'A', 'A', '2024-11-12 06:37:44', '2024-11-12 06:37:44'),
(72, '7313935870571123', 'Clo26112200.00', 'Clo26112200.00.png', 26, 'Cloth', 3000.00, 2200.00, '7313935870591165.jpg', 'This is new product brand', 'cloth house lahore', 'khawaja cloth', 'half gram', '11', 50, 'A', 'A', '2024-11-12 06:39:47', '2024-11-12 06:39:47'),
(73, '7313936650418756', 'Bag2712700.00', 'Bag2712700.00.png', 27, 'Bag', 900.00, 700.00, '7313936650437900.jpg', 'This is new brand', 'Ganj Bakhsh', 'khawaja cloth', 'kilo', '12', 30, 'A', 'A', '2024-11-12 06:41:05', '2024-11-12 06:41:05'),
(74, '7313937460729590', 'T-S28131800.00', 'T-S28131800.00.png', 28, 'T-Shirt', 1500.00, 1800.00, '7313937460749268.jpg', 'new brand', 'Ganj Bakhsh', 'khawaja cloth', 'kilo', '13', 20, 'A', 'A', '2024-11-12 06:42:26', '2024-11-12 06:42:26'),
(75, '7313938660794166', 'sho29143200.00', 'sho29143200.00.png', 29, 'shoes', 2000.00, 3200.00, '7313938660815461.jpg', 'New brand', 'Ganj Bakhsh', 'khawaja cloth', 'kilo', '14', 5, 'A', 'A', '2024-11-12 06:44:26', '2024-11-12 06:44:26'),
(76, '7313940160861838', 'Hea15152000.00', 'Hea15152000.00.png', 15, 'Headphone', 800.00, 2000.00, '7313940160882689.jpg', 'This is new brand', 'andoride', 'apple company', 'kilo', '15', 0, 'I', 'A', '2024-11-12 06:46:56', '2024-11-12 06:46:56'),
(77, '7313940670601352', 'Mob191650000.00', 'Mob191650000.00.png', 19, 'Mobile phone', 40000.00, 50000.00, '7313940670623511.jpg', 'New brand', 'andoride', 'apple company', 'kilo', '16', 4, 'A', 'A', '2024-11-12 06:47:47', '2024-11-12 06:47:47'),
(78, '7313941230931624', 'Sma201713000.00', 'Sma201713000.00.png', 20, 'Smart Watch', 12000.00, 13000.00, '7313941230951445.jpg', 'New Product Brand', 'andoride', 'apple company', 'kilo', '17', 7, 'A', 'A', '2024-11-12 06:48:43', '2024-11-12 06:48:43'),
(79, '7313941820052101', 'Clo26184000.00', 'Clo26184000.00.png', 26, 'Cloth', 6000.00, 4000.00, '7313941820070975.jpg', 'New Brand', 'Ganj Bakhsh', 'khawaja cloth', 'kilo', '18', 32, 'A', 'A', '2024-11-12 06:49:42', '2024-11-12 06:49:42'),
(80, '7313942260930111', 'Bag27191000.00', 'Bag27191000.00.png', 27, 'Bag', 2000.00, 1000.00, '7313942260951623.jpg', 'New Brand', 'Ganj Bakhsh', 'khawaja cloth', 'kilo', '19', 12, 'A', 'A', '2024-11-12 06:50:26', '2024-11-12 06:50:26'),
(81, '7313942770012974', 'T-S282013000.00', 'T-S282013000.00.png', 28, 'T-Shirt', 12000.00, 13000.00, '7313942770030674.jpg', 'New Brand', 'Ganj Bakhsh', 'khawaja cloth', 'kilo', '20', 10, 'A', 'A', '2024-11-12 06:51:17', '2024-11-12 06:51:17'),
(82, '7313943190614087', 'sho29213000.00', 'sho29213000.00.png', 29, 'shoes', 2000.00, 3000.00, '7313943190636263.jpg', 'New Brand', 'Ganj Bakhsh', 'khawaja cloth', 'gram', '21', 20, 'A', 'A', '2024-11-12 06:51:59', '2024-11-12 06:51:59'),
(83, '7313943200430273', 'sho29213000.00', 'sho29213000.00.png', 29, 'shoes', 2000.00, 3000.00, '7313943200450331.jpg', 'New Brand', 'Ganj Bakhsh', 'khawaja cloth', 'gram', '21', 20, 'A', 'A', '2024-11-12 06:52:00', '2024-11-12 06:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `products_gallery_img`
--

CREATE TABLE `products_gallery_img` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `product_images` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `products_gallery_img`
--

INSERT INTO `products_gallery_img` (`id`, `product_id`, `product_images`, `created_at`, `updated_at`) VALUES
(203, 57, '7259514650897746.jpg', '2024-09-10 06:57:45', '2024-09-10 06:57:45'),
(204, 57, '7259514650912157.jpg', '2024-09-10 06:57:45', '2024-09-10 06:57:45');

-- --------------------------------------------------------

--
-- Table structure for table `product_additional_details`
--

CREATE TABLE `product_additional_details` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `attribute` varchar(255) DEFAULT NULL,
  `detail` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_additional_details`
--

INSERT INTO `product_additional_details` (`id`, `product_id`, `category_id`, `attribute`, `detail`, `created_at`, `updated_at`) VALUES
(125, 59, 20, 'Color', 'Dark gray', '2024-09-03 06:37:51', '2024-09-03 06:37:51'),
(126, 59, 20, 'Processor', '2.3 GHz (128 GB)', '2024-09-03 06:37:51', '2024-09-03 06:37:51'),
(127, 59, 20, 'Graphics Coprocessor', 'Exynos 9611, Octa Core (4x2.3GHz + 4x1.7GHz)', '2024-09-03 06:37:51', '2024-09-03 06:37:51'),
(128, 59, 20, 'Batteries', '1 Lithium Polymer batteries required. (included)', '2024-09-03 06:37:51', '2024-09-03 06:37:51'),
(131, 60, 26, 'Color', 'Gray, Dark gray, Mystic black', '2024-09-03 06:44:13', '2024-09-03 06:44:13'),
(132, 62, 27, 'Color', 'Red', '2024-09-03 06:48:24', '2024-09-03 06:48:24'),
(152, 57, 19, 'Standing screen display size', 'Screen display Size 10.4', '2024-09-10 06:57:45', '2024-09-10 06:57:45'),
(153, 57, 19, 'Color', 'Gray, Dark gray, Mystic black', '2024-09-10 06:57:45', '2024-09-10 06:57:45'),
(154, 57, 19, 'Screen Resolution', '1920 x 1200 Pixels', '2024-09-10 06:57:45', '2024-09-10 06:57:45'),
(155, 57, 19, 'Processor', '2.3 GHz (128 GB)', '2024-09-10 06:57:45', '2024-09-10 06:57:45'),
(156, 57, 19, 'Operating System', 'Android 12', '2024-09-10 06:57:45', '2024-09-10 06:57:45'),
(157, 57, 19, 'Item model number', 'SM-P6102ZAEXOR', '2024-09-10 06:57:45', '2024-09-10 06:57:45'),
(158, 69, 15, 'Color', 'Red', '2024-11-12 06:24:11', '2024-11-12 06:24:11'),
(159, 56, 15, 'Color', 'Gray, Dark gray, Mystic black', '2024-11-12 06:25:27', '2024-11-12 06:25:27'),
(160, 56, 15, 'Item model number', 'SM-P6102ZAEXOR', '2024-11-12 06:25:27', '2024-11-12 06:25:27'),
(161, 56, 15, 'Batteries', '1 Lithium Polymer batteries required. (included)', '2024-11-12 06:25:27', '2024-11-12 06:25:27'),
(162, 58, 19, 'Standing screen display size', 'Screen display Size 10.4', '2024-11-12 06:34:23', '2024-11-12 06:34:23'),
(163, 58, 19, 'Color', 'Mystic black', '2024-11-12 06:34:23', '2024-11-12 06:34:23'),
(164, 58, 19, 'Processor', '2.3 GHz (128 GB)', '2024-11-12 06:34:23', '2024-11-12 06:34:23'),
(165, 58, 19, 'Graphics Coprocessor', 'Exynos 9611, Octa Core (4x2.3GHz + 4x1.7GHz)', '2024-11-12 06:34:23', '2024-11-12 06:34:23'),
(166, 70, 19, 'Color', 'Blacck', '2024-11-12 06:36:17', '2024-11-12 06:36:17'),
(167, 70, 19, 'Ram', '8GB', '2024-11-12 06:36:17', '2024-11-12 06:36:17'),
(168, 71, 20, 'Color', 'Pink', '2024-11-12 06:37:44', '2024-11-12 06:37:44'),
(169, 72, 26, 'Color', 'Black', '2024-11-12 06:39:47', '2024-11-12 06:39:47'),
(170, 73, 27, 'Color', 'Red', '2024-11-12 06:41:05', '2024-11-12 06:41:05'),
(171, 74, 28, 'Color', 'Orange', '2024-11-12 06:42:26', '2024-11-12 06:42:26'),
(172, 75, 29, 'Color', 'White', '2024-11-12 06:44:26', '2024-11-12 06:44:26'),
(173, 76, 15, 'Color', 'Blue', '2024-11-12 06:46:56', '2024-11-12 06:46:56'),
(174, 77, 19, 'Color', 'Sky Blue', '2024-11-12 06:47:47', '2024-11-12 06:47:47'),
(175, 78, 20, 'Color', 'Brown', '2024-11-12 06:48:43', '2024-11-12 06:48:43'),
(176, 79, 26, 'Color', 'Blue', '2024-11-12 06:49:42', '2024-11-12 06:49:42'),
(177, 80, 27, 'Color', 'Red', '2024-11-12 06:50:26', '2024-11-12 06:50:26'),
(178, 81, 28, 'Color', 'Red', '2024-11-12 06:51:17', '2024-11-12 06:51:17'),
(179, 82, 29, 'Color', 'White', '2024-11-12 06:51:59', '2024-11-12 06:51:59'),
(180, 83, 29, 'Color', 'White', '2024-11-12 06:52:00', '2024-11-12 06:52:00'),
(181, 61, 28, 'Color', 'Gray, Dark gray, Mystic black', '2025-01-04 13:37:13', '2025-01-04 13:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `product_features`
--

CREATE TABLE `product_features` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_features`
--

INSERT INTO `product_features` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
(57, 60, 26, '2024-09-03 06:44:13', '2024-09-03 06:44:13'),
(58, 62, 27, '2024-09-03 06:48:24', '2024-09-03 06:48:24'),
(62, 57, 19, '2024-09-10 06:57:45', '2024-09-10 06:57:45'),
(63, 56, 15, '2024-11-12 06:25:27', '2024-11-12 06:25:27'),
(64, 58, 19, '2024-11-12 06:34:23', '2024-11-12 06:34:23'),
(65, 70, 19, '2024-11-12 06:36:17', '2024-11-12 06:36:17'),
(66, 71, 20, '2024-11-12 06:37:44', '2024-11-12 06:37:44'),
(67, 72, 26, '2024-11-12 06:39:47', '2024-11-12 06:39:47'),
(68, 73, 27, '2024-11-12 06:41:05', '2024-11-12 06:41:05'),
(69, 76, 15, '2024-11-12 06:46:56', '2024-11-12 06:46:56'),
(70, 79, 26, '2024-11-12 06:49:42', '2024-11-12 06:49:42'),
(71, 61, 28, '2025-01-04 13:37:13', '2025-01-04 13:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `product_newarrivals`
--

CREATE TABLE `product_newarrivals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_newarrivals`
--

INSERT INTO `product_newarrivals` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
(60, 59, 20, '2024-09-03 06:37:51', '2024-09-03 06:37:51'),
(63, 60, 26, '2024-09-03 06:44:13', '2024-09-03 06:44:13'),
(64, 62, 27, '2024-09-03 06:48:24', '2024-09-03 06:48:24'),
(69, 57, 19, '2024-09-10 06:57:45', '2024-09-10 06:57:45'),
(71, 68, 29, '2024-09-25 08:11:52', '2024-09-25 08:11:52'),
(72, 56, 15, '2024-11-12 06:25:27', '2024-11-12 06:25:27'),
(73, 58, 19, '2024-11-12 06:34:23', '2024-11-12 06:34:23'),
(74, 71, 20, '2024-11-12 06:37:44', '2024-11-12 06:37:44'),
(75, 72, 26, '2024-11-12 06:39:47', '2024-11-12 06:39:47'),
(76, 73, 27, '2024-11-12 06:41:05', '2024-11-12 06:41:05'),
(77, 74, 28, '2024-11-12 06:42:26', '2024-11-12 06:42:26'),
(78, 75, 29, '2024-11-12 06:44:26', '2024-11-12 06:44:26'),
(79, 76, 15, '2024-11-12 06:46:56', '2024-11-12 06:46:56'),
(80, 79, 26, '2024-11-12 06:49:42', '2024-11-12 06:49:42'),
(81, 61, 28, '2025-01-04 13:37:13', '2025-01-04 13:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `product_ratings`
--

CREATE TABLE `product_ratings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `customer_id` int(11) DEFAULT NULL,
  `stars` int(11) DEFAULT NULL,
  `review_message` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_ratings`
--

INSERT INTO `product_ratings` (`id`, `category_id`, `product_id`, `customer_id`, `stars`, `review_message`, `created_at`, `updated_at`) VALUES
(1, 27, 73, 2, 2, 'dfd', '2024-12-04 13:59:20', '2024-12-04 13:59:20'),
(2, 28, 74, 2, 4, 'fdf', '2024-12-04 14:00:21', '2024-12-04 14:00:21'),
(3, 28, 61, 2, 2, 'df', '2024-12-04 14:04:13', '2024-12-04 14:04:13'),
(5, 20, 59, 2, 2, 'customer shoe rreview', '2024-12-04 16:04:09', '2024-12-04 16:04:09'),
(6, 29, 68, 2, 5, 'customer review', '2024-12-05 13:48:09', '2024-12-05 13:48:09'),
(7, 29, 68, 1, 1, 'reviews', '2024-12-05 14:11:06', '2024-12-05 14:11:06'),
(8, 28, 74, 1, 3, 'review', '2024-12-05 14:13:13', '2024-12-05 14:13:13');

-- --------------------------------------------------------

--
-- Table structure for table `product_topsellers`
--

CREATE TABLE `product_topsellers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `category_id` int(11) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `product_topsellers`
--

INSERT INTO `product_topsellers` (`id`, `product_id`, `category_id`, `created_at`, `updated_at`) VALUES
(58, 59, 20, '2024-09-03 06:37:51', '2024-09-03 06:37:51'),
(64, 57, 19, '2024-09-10 06:57:45', '2024-09-10 06:57:45'),
(65, 69, 15, '2024-11-12 06:24:11', '2024-11-12 06:24:11'),
(66, 56, 15, '2024-11-12 06:25:27', '2024-11-12 06:25:27'),
(67, 58, 19, '2024-11-12 06:34:23', '2024-11-12 06:34:23'),
(68, 72, 26, '2024-11-12 06:39:47', '2024-11-12 06:39:47'),
(69, 73, 27, '2024-11-12 06:41:05', '2024-11-12 06:41:05'),
(70, 76, 15, '2024-11-12 06:46:56', '2024-11-12 06:46:56'),
(71, 77, 19, '2024-11-12 06:47:47', '2024-11-12 06:47:47'),
(72, 78, 20, '2024-11-12 06:48:43', '2024-11-12 06:48:43'),
(73, 79, 26, '2024-11-12 06:49:42', '2024-11-12 06:49:42'),
(74, 61, 28, '2025-01-04 13:37:13', '2025-01-04 13:37:13');

-- --------------------------------------------------------

--
-- Table structure for table `stock_transactions`
--

CREATE TABLE `stock_transactions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `product_id` int(11) DEFAULT NULL,
  `prev_qnty` int(11) DEFAULT NULL,
  `new_qnty` int(11) DEFAULT NULL,
  `transaction_type` enum('none','purchase','sale','return','remove') NOT NULL DEFAULT 'none',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stock_transactions`
--

INSERT INTO `stock_transactions` (`id`, `product_id`, `prev_qnty`, `new_qnty`, `transaction_type`, `created_at`, `updated_at`) VALUES
(2, 65, 15, 20, 'purchase', '2024-09-04 11:13:46', '2024-09-05 07:07:48'),
(3, 65, 20, 30, 'purchase', '2024-09-05 07:11:32', '2024-09-05 07:11:32'),
(4, 65, 30, 25, 'remove', '2024-09-05 09:52:58', '2024-09-05 09:52:58'),
(7, 65, 25, 26, 'purchase', '2024-09-05 10:16:01', '2024-09-05 10:16:01'),
(8, 65, 26, 25, 'remove', '2024-09-05 10:20:09', '2024-09-05 10:20:09'),
(9, 63, 4, 10, 'purchase', '2024-09-05 10:31:05', '2024-09-05 10:31:05'),
(10, 56, 10, 0, 'remove', '2024-09-08 17:48:11', '2024-09-08 17:48:11'),
(11, 66, 0, 2, 'purchase', '2024-09-25 08:05:05', '2024-09-25 08:05:05'),
(12, 67, 0, 2, 'purchase', '2024-09-25 08:07:16', '2024-09-25 08:07:16'),
(13, 68, 0, 2, 'purchase', '2024-09-25 08:11:52', '2024-09-25 08:11:52'),
(14, 69, 0, 15, 'purchase', '2024-11-12 06:24:11', '2024-11-12 06:24:11'),
(15, 70, 0, 20, 'purchase', '2024-11-12 06:36:17', '2024-11-12 06:36:17'),
(16, 71, 0, 10, 'purchase', '2024-11-12 06:37:44', '2024-11-12 06:37:44'),
(17, 72, 0, 50, 'purchase', '2024-11-12 06:39:47', '2024-11-12 06:39:47'),
(18, 73, 0, 30, 'purchase', '2024-11-12 06:41:05', '2024-11-12 06:41:05'),
(19, 74, 0, 20, 'purchase', '2024-11-12 06:42:26', '2024-11-12 06:42:26'),
(20, 75, 0, 5, 'purchase', '2024-11-12 06:44:26', '2024-11-12 06:44:26'),
(21, 76, 0, 4, 'purchase', '2024-11-12 06:46:56', '2024-11-12 06:46:56'),
(22, 77, 0, 4, 'purchase', '2024-11-12 06:47:47', '2024-11-12 06:47:47'),
(23, 78, 0, 7, 'purchase', '2024-11-12 06:48:43', '2024-11-12 06:48:43'),
(24, 79, 0, 32, 'purchase', '2024-11-12 06:49:42', '2024-11-12 06:49:42'),
(25, 80, 0, 12, 'purchase', '2024-11-12 06:50:26', '2024-11-12 06:50:26'),
(26, 81, 0, 10, 'purchase', '2024-11-12 06:51:17', '2024-11-12 06:51:17'),
(27, 82, 0, 20, 'purchase', '2024-11-12 06:51:59', '2024-11-12 06:51:59'),
(28, 83, 0, 20, 'purchase', '2024-11-12 06:52:00', '2024-11-12 06:52:00');

-- --------------------------------------------------------

--
-- Table structure for table `store_texts`
--

CREATE TABLE `store_texts` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `item` varchar(255) DEFAULT NULL,
  `value` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `store_texts`
--

INSERT INTO `store_texts` (`id`, `item`, `value`, `created_at`, `updated_at`) VALUES
(1, 'PrivacyPolicy', '<div>\r\n<p><span style=\"font-size: 18pt; color: #0989FF;\"><strong>Privacy Policy</strong></span></p>\r\n<p><strong>Data Protection &amp; Privacy</strong></p>\r\n<p>We never store payment card details. We store Contact Name, Number, Email (if provided) and Delivery Address details for orders accuracy and fraud prevention purposes. We never give these details to any third party.</p>\r\n<p><strong><span style=\"font-size: 14pt;\">Collecting and Using Your Personal Data</span></strong></p>\r\n<p>While using Our Service, We may ask You to provide Us with certain personally identifiable information that can be used to contact or identify You. Personally identifiable information may include, but is not limited to:</p>\r\n<ul>\r\n<li>Usage Data</li>\r\n</ul>\r\n<h3>Usage Data</h3>\r\n<p>Usage Data is collected automatically when using the Service.</p>\r\n<p>Usage Data may include information such as Your Device\\\'s Internet Protocol address (e.g. IP address), browser type, browser version, the pages of our Service that You visit, the time and date of Your visit, the time spent on those pages, unique device identifiers and other diagnostic data.</p>\r\n<p>When You access the Service by or through a mobile device, We may collect certain information automatically, including, but not limited to, the type of mobile device You use, Your mobile device unique ID, the IP address of Your mobile device, Your mobile operating system, the type of mobile Internet browser You use, unique device identifiers and other diagnostic data.</p>\r\n<p>We may also collect information that Your browser sends whenever You visit our Service or when You access the Service by or through a mobile device.</p>\r\n<h2><span style=\"font-size: 14pt;\">Use of Your Personal Data</span></h2>\r\n<p>The Company may use Personal Data for the following purposes:</p>\r\n<ul>\r\n<li>\r\n<p><strong>To provide and maintain our Service</strong>, including to monitor the usage of our Service.</p>\r\n</li>\r\n<li>\r\n<p><strong>To manage Your Account:</strong> to manage Your registration as a user of the Service. The Personal Data You provide can give You access to different functionalities of the Service that are available to You as a registered user.</p>\r\n</li>\r\n<li>\r\n<p><strong>For the performance of a contract:</strong> the development, compliance and undertaking of the purchase contract for the products, items or services You have purchased or of any other contract with Us through the Service.</p>\r\n</li>\r\n<li>\r\n<p><strong>To contact You:</strong> To contact You by email, telephone calls, SMS, or other equivalent forms of electronic communication, such as a mobile application\\\'s push notifications regarding updates or informative communications related to the functionalities, products or contracted services, including the security updates, when necessary or reasonable for their implementation.</p>\r\n</li>\r\n<li>\r\n<p><strong>To provide You</strong> with news, special offers and general information about other goods, services and events which we offer that are similar to those that you have already purchased or enquired about unless You have opted not to receive such information.</p>\r\n</li>\r\n<li>\r\n<p><strong>To manage Your requests:</strong> To attend and manage Your requests to Us.</p>\r\n</li>\r\n<li>\r\n<p><strong>For business transfers:</strong> We may use Your information to evaluate or conduct a merger, divestiture, restructuring, reorganization, dissolution, or other sale or transfer of some or all of Our assets, whether as a going concern or as part of bankruptcy, liquidation, or similar proceeding, in which Personal Data held by Us about our Service users is among the assets transferred.</p>\r\n</li>\r\n<li>\r\n<p><strong>For other purposes</strong>: We may use Your information for other purposes, such as data analysis, identifying usage trends, determining the effectiveness of our promotional campaigns and to evaluate and improve our Service, products, services, marketing and your experience.</p>\r\n</li>\r\n</ul>\r\n<p>We may share Your personal information in the following situations:</p>\r\n<ul>\r\n<li><strong>With Service Providers:</strong> We may share Your personal information with Service Providers to monitor and analyze the use of our Service, to contact You.</li>\r\n<li><strong>For business transfers:</strong> We may share or transfer Your personal information in connection with, or during negotiations of, any merger, sale of Company assets, financing, or acquisition of all or a portion of Our business to another company.</li>\r\n<li><strong>With Affiliates:</strong> We may share Your information with Our affiliates, in which case we will require those affiliates to honor this Privacy Policy. Affiliates include Our parent company and any other subsidiaries, joint venture partners or other companies that We control or that are under common control with Us.</li>\r\n<li><strong>With business partners:</strong> We may share Your information with Our business partners to offer You certain products, services or promotions.</li>\r\n<li><strong>With other users:</strong> when You share personal information or otherwise interact in the public areas with other users, such information may be viewed by all users and may be publicly distributed outside.</li>\r\n<li><strong>With Your consent</strong>: We may disclose Your personal information for any other purpose with Your consent.</li>\r\n</ul>\r\n<h2><span style=\"font-size: 14pt;\">Retention of Your Personal Data</span></h2>\r\n<p>The Company will retain Your Personal Data only for as long as is necessary for the purposes set out in this Privacy Policy. We will retain and use Your Personal Data to the extent necessary to comply with our legal obligations (for example, if we are required to retain your data to comply with applicable laws), resolve disputes, and enforce our legal agreements and policies.</p>\r\n<p>The Company will also retain Usage Data for internal analysis purposes. Usage Data is generally retained for a shorter period of time, except when this data is used to strengthen the security or to improve the functionality of Our Service, or We are legally obligated to retain this data for longer time periods.</p>\r\n<h2><span style=\"font-size: 14pt;\">Transfer of Your Personal Data</span></h2>\r\n<p>Your information, including Personal Data, is processed at the Company\\\'s operating offices and in any other places where the parties involved in the processing are located. It means that this information may be transferred to &mdash; and maintained on &mdash; computers located outside of Your state, province, country or other governmental jurisdiction where the data protection laws may differ than those from Your jurisdiction.</p>\r\n<p>Your consent to this Privacy Policy followed by Your submission of such information represents Your agreement to that transfer.</p>\r\n<p>The Company will take all steps reasonably necessary to ensure that Your data is treated securely and in accordance with this Privacy Policy and no transfer of Your Personal Data will take place to an organization or a country unless there are adequate controls in place including the security of Your data and other personal information.</p>\r\n<h2><span style=\"font-size: 14pt;\">Delete Your Personal Data</span></h2>\r\n<p>You have the right to delete or request that We assist in deleting the Personal Data that We have collected about You.</p>\r\n<p>Our Service may give You the ability to delete certain information about You from within the Service.</p>\r\n<p>You may update, amend, or delete Your information at any time by signing in to Your Account, if you have one, and visiting the account settings section that allows you to manage Your personal information. You may also contact Us to request access to, correct, or delete any personal information that You have provided to Us.</p>\r\n<p>Please note, however, that We may need to retain certain information when we have a legal obligation or lawful basis to do so.</p>\r\n<h2><span style=\"font-size: 14pt;\">Disclosure of Your Personal Data</span></h2>\r\n<h3>Business Transactions</h3>\r\n<p>If the Company is involved in a merger, acquisition or asset sale, Your Personal Data may be transferred. We will provide notice before Your Personal Data is transferred and becomes subject to a different Privacy Policy.</p>\r\n<h3>Law enforcement</h3>\r\n<p>Under certain circumstances, the Company may be required to disclose Your Personal Data if required to do so by law or in response to valid requests by public authorities (e.g. a court or a government agency).</p>\r\n<h3>Other legal requirements</h3>\r\n<p>The Company may disclose Your Personal Data in the good faith belief that such action is necessary to:</p>\r\n<ul>\r\n<li>Comply with a legal obligation</li>\r\n<li>Protect and defend the rights or property of the Company</li>\r\n<li>Prevent or investigate possible wrongdoing in connection with the Service</li>\r\n<li>Protect the personal safety of Users of the Service or the public</li>\r\n<li>Protect against legal liability</li>\r\n</ul>\r\n<h2><span style=\"font-size: 14pt;\">Security of Your Personal Data</span></h2>\r\n<p>The security of Your Personal Data is important to Us, but remember that no method of transmission over the Internet, or method of electronic storage is 100% secure. While We strive to use commercially acceptable means to protect Your Personal Data, We cannot guarantee its absolute security.</p>\r\n<p><strong><span style=\"font-size: 18pt; color: #0989FF;\">Terms &amp; Conditions</span></strong></p>\r\n<p><strong>Overview</strong></p>\r\n<p>We aim to provide a simple and convenient online ordering facility to our customers. Our interactive menu allows customers to select and place orders online.</p>\r\n<p><strong>Our Availability</strong></p>\r\n<p>Our normal opening hours are from 04:45pm - 11:00pm. But this may change from time to time. We offer a delivery and collection service to most areas of the Tameside. If you live outside our delivery areas, a message will appear on screen notifying you that delivery to your area is not covered. This does not stop you placing the online order, you will just have to select &lsquo;Collection&rsquo; as an order type or phone us and order directly and collect your order.</p>\r\n<p><strong>How the orders are processed online</strong></p>\r\n<p>Once an order is successfully placed online, you will be notified with a message thanking you for your order and confirming your order number and approximate delivery time.</p>\r\n<p><strong>Delivery</strong></p>\r\n<p>We aim to provide best service in Denton. In unexpected conditions we will inform you if your order is delayed.</p>\r\n<p>For the safety of our drivers, a driver will only deliver to the main door/reception when delivering to apartment blocks, flats or hotels.</p>\r\n<p><strong>Food</strong></p>\r\n<p>Menu items are subject to availability.</p>\r\n<p>If you have an allergy please do not order online. Instead please call us and inform us of your allergies directly.</p>\r\n<p><strong>Cancellation &amp; Refund</strong></p>\r\n<p>You have the right to cancel an order if your order is not started to prepare. You will need to call us ASAP after you have placed an order.</p>\r\n<p>We reserve the right to cancel any order, even after it is successfully placed, and will notify you immediately of any such cancellation.</p>\r\n<p>Any order cancelled by the customer after the point it is authorised it will be charged to the customer and no refund will be due to the customer.</p>\r\n<p>In our sole discretion we will determine whether to issue a refund for all cancelled orders.</p>\r\n<p><strong>Termination</strong></p>\r\n<p>We reserve the right to decline a new registration, terminate your right to link to our site, remove you as a user of our site. If we terminate your right to link to our</p>\r\n<p>site you must cease linking to our site immediately.</p>\r\n<p><strong>Card Payments</strong></p>\r\n<p>Card payments are handled and managed by our solution providers.</p>\r\n<p><strong>Images</strong></p>\r\n<p>Images are for illustration purpose only. Actual items may look different.</p>\r\n<p><strong>General</strong></p>\r\n<p>We have the right to revise and amend these terms and conditions from time to time. Any changes we make to these terms and conditions will be posted on this page. You will be subject to the policies and terms and conditions in force at the time that you order with us.</p>\r\n</div>', '2024-08-22 07:44:23', '2024-08-22 07:44:23');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `blogs`
--
ALTER TABLE `blogs`
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
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cms_texts`
--
ALTER TABLE `cms_texts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `customer_details`
--
ALTER TABLE `customer_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `general_settings`
--
ALTER TABLE `general_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_numbers`
--
ALTER TABLE `order_numbers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_name` (`product_name`);

--
-- Indexes for table `products_gallery_img`
--
ALTER TABLE `products_gallery_img`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_additional_details`
--
ALTER TABLE `product_additional_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_features`
--
ALTER TABLE `product_features`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_newarrivals`
--
ALTER TABLE `product_newarrivals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_ratings`
--
ALTER TABLE `product_ratings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_topsellers`
--
ALTER TABLE `product_topsellers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `store_texts`
--
ALTER TABLE `store_texts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `blogs`
--
ALTER TABLE `blogs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `cms_texts`
--
ALTER TABLE `cms_texts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `customer_details`
--
ALTER TABLE `customer_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `general_settings`
--
ALTER TABLE `general_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `order_numbers`
--
ALTER TABLE `order_numbers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `products_gallery_img`
--
ALTER TABLE `products_gallery_img`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=205;

--
-- AUTO_INCREMENT for table `product_additional_details`
--
ALTER TABLE `product_additional_details`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=182;

--
-- AUTO_INCREMENT for table `product_features`
--
ALTER TABLE `product_features`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=72;

--
-- AUTO_INCREMENT for table `product_newarrivals`
--
ALTER TABLE `product_newarrivals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT for table `product_ratings`
--
ALTER TABLE `product_ratings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `product_topsellers`
--
ALTER TABLE `product_topsellers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `stock_transactions`
--
ALTER TABLE `stock_transactions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `store_texts`
--
ALTER TABLE `store_texts`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
