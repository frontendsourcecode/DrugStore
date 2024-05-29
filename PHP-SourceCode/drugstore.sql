-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: May 29, 2024 at 03:12 AM
-- Server version: 10.11.7-MariaDB-cll-lve
-- PHP Version: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u624665963_drugstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `UserName` varchar(100) NOT NULL,
  `Password` varchar(100) NOT NULL,
  `updationDate` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `UserName`, `Password`, `updationDate`) VALUES
(1, 'admin', '06d1108043ad13aebdca098c7e6bfe64', '2018-05-25 05:51:25');

-- --------------------------------------------------------

--
-- Table structure for table `banners`
--

CREATE TABLE `banners` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bill_payment`
--

CREATE TABLE `bill_payment` (
  `id` int(10) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `bill` text DEFAULT NULL,
  `receipt` text DEFAULT NULL,
  `amount` varchar(200) DEFAULT NULL,
  `user_id` int(10) NOT NULL,
  `payment_status` varchar(200) NOT NULL DEFAULT 'unpaid',
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `bill_payment`
--

INSERT INTO `bill_payment` (`id`, `name`, `email`, `mobile`, `title`, `bill`, `receipt`, `amount`, `user_id`, `payment_status`, `created_date`) VALUES
(1, 'Santosh', 'santosh@gmail.com', '9876542222', 'Electric Bill', 'assets/images/upload/bills/324/20220416060420000000.png', NULL, '450.00', 324, 'unpaid', '2022-04-16 09:36:20'),
(3, 'santosh', '', '9876543210', 'Electricity Bill', 'assets/images/upload/bills/324/20220416030426000000.png', 'assets/images/upload/receipt/324/20220416030444000000.png', '500', 324, 'paid', '2022-04-16 18:42:26'),
(4, 'Chinmaydeep ', '', '7259696822', 'Electricity Bill', 'assets/images/upload/bills/331/20220416040456000000.png', 'assets/images/upload/receipt/331/20220416040401000000.png', '1000', 331, 'paid', '2022-04-16 16:10:56'),
(5, 'Chinmaydeep ', '', '7259696822', 'DTH/Cable', 'assets/images/upload/bills/331/20220417070413000000.png', 'assets/images/upload/receipt/331/20220418040432000000.png', '100', 331, 'paid', '2022-04-17 19:54:13'),
(6, 'Chinmaydeep ', '', '7406077618', 'Electricity Bill', 'assets/images/upload/bills/336/20220502010515000000.png', NULL, '1000', 336, 'unpaid', '2022-05-02 13:08:15'),
(7, 'Pavan Kumar', '', '7349278500', 'Electricity Bill', 'assets/images/upload/bills/340/20220628060621000000.png', NULL, '600', 340, 'unpaid', '2022-06-28 06:58:21');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `category` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `cateimg` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=ucs2 COLLATE=ucs2_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `category`, `cateimg`, `created_date`) VALUES
(371, 'Че там', 'assets/images/ProductImage/category/20231213101214000000.png', '2023-12-03 13:27:09'),
(372, 'NULL', 'assets/images/ProductImage/category/20240525120556000000.png', '2023-12-05 15:43:39'),
(373, 'Витамины и минералы ', 'assets/images/ProductImage/category/20231207031219000000.png', '2023-12-07 15:45:19'),
(374, 'Мази и кремы ', 'assets/images/ProductImage/category/20231207031258000000.png', '2023-12-07 15:49:58'),
(375, 'Глазные капли и мази ', 'assets/images/ProductImage/category/20231207031213000000.png', '2023-12-07 15:51:13'),
(376, 'Уколы и системы ', 'assets/images/ProductImage/category/20231207041251000000.png', '2023-12-07 16:16:51'),
(377, 'hfbf', 'assets/images/ProductImage/category/20240129060134000000.png', '2024-01-29 06:22:39'),
(378, 'new', 'assets/images/ProductImage/category/20240329030326000000.png', '2024-03-29 15:41:26'),
(379, '11333333333333', 'assets/images/ProductImage/category/20240511120505000000.png', '2024-05-11 00:59:05'),
(380, '11333333333', 'assets/images/ProductImage/category/20240511010551000000.png', '2024-05-11 01:06:51');

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE `items` (
  `id` int(100) NOT NULL,
  `name` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `sub_category_id` int(10) DEFAULT NULL,
  `description` longtext DEFAULT NULL,
  `attribute` varchar(100) DEFAULT NULL,
  `currency` varchar(100) NOT NULL DEFAULT 'Rs.',
  `discount` varchar(100) DEFAULT NULL,
  `price` varchar(50) NOT NULL,
  `homepage` varchar(10) DEFAULT NULL,
  `prescription_required` tinyint(1) DEFAULT 0,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `items`
--

INSERT INTO `items` (`id`, `name`, `category_id`, `sub_category_id`, `description`, `attribute`, `currency`, `discount`, `price`, `homepage`, `prescription_required`, `active`, `created_date`) VALUES
(1132, 'Цетрин ', 371, 417, '<p>Противоаллергические таблетки Цетрин&nbsp;</p>', '10мг', 'Rs.', '', '2300', 'NO', 0, 1, '2023-12-07 17:09:13'),
(1137, 'Vitrum', 373, 420, 'Витаминный комплекс&nbsp;', '60таблеток ', 'Rs.', '', '5500', 'NO', 0, 1, '2023-12-07 17:23:11'),
(1138, 'Витамин С ', 373, 421, '<p>Витамин С&nbsp;</p>', '20таблеток', 'Rs.', '', '2600', 'NO', 0, 1, '2023-12-07 17:24:14'),
(1139, 'Витамин Д3', 373, 422, '<p>Д3 Витамины&nbsp;</p>', '60капсул', 'Rs.', '', '3500', 'NO', 0, 1, '2023-12-07 17:25:40'),
(1140, 'Адвантан', 374, 423, '<p>Адвантан мазь от аллергии&nbsp;</p>', '15г', 'Rs.', '', '3400', 'NO', 0, 1, '2023-12-07 17:27:16'),
(1141, 'Грибкосепт', 374, 424, 'Грибкосепт крем&nbsp;', '100мл', 'Rs.', '', '5000', 'YES', 0, 1, '2023-12-07 17:29:48'),
(1142, 'Парин Пос', 375, 425, '<p>Средство для глаз</p>', '50г', 'Rs.', '', '5000', 'NO', 0, 1, '2023-12-07 17:31:02'),
(1143, 'Тобрекс ', 375, 426, '<p>Для лечения глазных инфекций&nbsp;</p>', '5мл', 'Rs.', '', '5000', 'NO', 0, 1, '2023-12-07 17:33:39'),
(1144, 'Covid 19 ', 376, 427, '<p>Система от ковид&nbsp;</p>', '5мм', 'Rs.', '', '10000', 'NO', 0, 1, '2023-12-07 17:35:42');

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orderlist`
--

CREATE TABLE `orderlist` (
  `id` int(50) NOT NULL,
  `order_id` int(10) NOT NULL,
  `itemName` varchar(500) NOT NULL,
  `itemQuantity` varchar(100) NOT NULL,
  `attribute` varchar(100) NOT NULL,
  `currency` varchar(100) NOT NULL,
  `itemImage` varchar(250) DEFAULT NULL,
  `itemPrice` varchar(30) NOT NULL,
  `itemTotal` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `orderlist`
--

INSERT INTO `orderlist` (`id`, `order_id`, `itemName`, `itemQuantity`, `attribute`, `currency`, `itemImage`, `itemPrice`, `itemTotal`) VALUES
(464, 125, 'Супростин ', '1', '50мг', 'Rs.', 'assets/images/ProductImage/product/1131202312070512550000008686851751892.png', '2500', '2500.0'),
(465, 125, 'Цетрин ', '1', '10мг', 'Rs.', 'assets/images/ProductImage/product/113220231207051213000000376334835693.png', '2300', '2300.0'),
(466, 126, 'Супростин ', '4', '50мг', 'Rs.', 'assets/images/ProductImage/product/1131202312070512550000008686851751892.png', '2500', '10000.0'),
(467, 126, 'Ацыкловир', '1', '200мг', 'Rs.', 'assets/images/ProductImage/product/1130202312070512530000003116024234645.png', '2300', '2300.0'),
(468, 126, 'Амоксициллин', '1', '500мг', 'Rs.', 'assets/images/ProductImage/product/1129202312070412540000008820901110834.png', '1200', '1200.0'),
(469, 127, 'Амоксициллин', '1', '500мг', 'Rs.', 'assets/images/ProductImage/product/1129202312070412540000008820901110834.png', '1200', '1200.0'),
(470, 127, 'Ацыкловир', '1', '200мг', 'Rs.', 'assets/images/ProductImage/product/1130202312070512530000003116024234645.png', '2300', '2300.0'),
(471, 127, 'Доктор Мом ', '1', '100мл', 'Rs.', 'assets/images/ProductImage/product/1133202312070512430000009613479590758.png', '2800', '2800.0'),
(472, 128, 'Амоксициллин', '1', '500мг', 'Rs.', 'assets/images/ProductImage/product/1129202312070412540000008820901110834.png', '1200', '1200.0'),
(473, 128, 'Ацыкловир', '1', '200мг', 'Rs.', 'assets/images/ProductImage/product/1130202312070512530000003116024234645.png', '2300', '2300.0'),
(474, 128, 'Супростин ', '1', '50мг', 'Rs.', 'assets/images/ProductImage/product/1131202312070512550000008686851751892.png', '2500', '2500.0'),
(475, 128, 'Цетрин ', '1', '10мг', 'Rs.', 'assets/images/ProductImage/product/113220231207051213000000376334835693.png', '2300', '2300.0'),
(476, 128, 'Доктор Мом ', '1', '100мл', 'Rs.', 'assets/images/ProductImage/product/1133202312070512430000009613479590758.png', '2800', '2800.0'),
(477, 128, 'Лазолван ', '1', '100мл', 'Rs.', 'assets/images/ProductImage/product/1134202312070512420000008930024893245.png', '3000', '3000.0'),
(478, 128, 'Флунол ', '1', '75мл', 'Rs.', 'assets/images/ProductImage/product/1135202312070512230000008271455688294.png', '5000', '5000.0'),
(479, 129, 'Лазолван ', '1', '100мл', 'Rs.', 'assets/images/ProductImage/product/1134202312070512420000008930024893245.png', '3000', '3000.0'),
(480, 130, 'Test Product 01', '2', '100k', 'VND', 'assets/images/ProductImage/product/113120240406060445000000623065852999.png', '2500', '5000.0'),
(481, 131, 'Test Product 01', '5', '100k', 'VND', 'assets/images/ProductImage/product/113120240406060445000000623065852999.png', '2500', '12500.0'),
(482, 132, 'Test Product 01', '1', '100k', 'VND', 'assets/images/ProductImage/product/113120240406060445000000623065852999.png', '2500', '2500.0');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `total` varchar(20) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `phone` varchar(10) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `city` varchar(200) DEFAULT NULL,
  `state` varchar(200) DEFAULT NULL,
  `zip_code` varchar(6) DEFAULT NULL,
  `landmark` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `status`, `user_id`, `date`, `total`, `name`, `email`, `phone`, `address`, `city`, `state`, `zip_code`, `landmark`) VALUES
(125, 'Delivered', 454, '2024-04-17 22:01:07', '4800', 'Test User', 'p@gmail.con', '9876598765', 'Jama Masjid, Dehuroad,New Delhi,Delhi,412104', 'New Delhi', 'Delhi', '412104', NULL),
(126, 'Delivered', 454, '2024-04-17 22:01:18', '13500', 'Test User', 'p@gmail.con', '9876598765', 'Jama Masjid, Dehuroad,Delhi,Delhi,412104', 'Delhi', 'Delhi', '412104', NULL),
(127, 'Delivered', 454, '2024-04-17 22:01:52', '6300', 'Test User', 'p@gmail.con', '9876598765', 'Jama Masjid, Dehuroad,Delhi,Delhi,412104', 'Delhi', 'Delhi', '412104', NULL),
(128, 'Confirmed', 454, '2024-02-03 17:24:39', '19100', 'Test User', 'p@gmail.com', '9876598765', 'Jama Masjid, Dehuroad,Delhi,Delhi,412104', 'Delhi', 'Delhi', '412104', NULL),
(129, 'Confirmed', 454, '2024-03-21 09:35:19', '3000', 'Test User', 'p@gmail.com', '9876598765', 'Jama Masjid, Dehuroad,Delhi,Delhi,412104', 'Delhi', 'Delhi', '412104', NULL),
(130, 'Pending', 477, '2024-05-27 08:17:01', '5000', 'David Nguyen', 'hahsg@gmail.com', '0312345678', '5172 ,Marmagao,Goa,0333', 'Marmagao', 'Goa', '0333', NULL),
(131, 'Pending', 477, '2024-05-27 08:22:58', '12500', 'David Nguyen', 'hahsg@gmail.com', '0312345678', '5555,Marmagao,Goa,0333', 'Marmagao', 'Goa', '0333', NULL),
(132, 'Pending', 477, '2024-05-27 08:24:04', '2500', 'David Nguyen', 'hahsg@gmail.com', '0312345678', '5555,Nongstoin,Meghalaya,0333', 'Nongstoin', 'Meghalaya', '0333', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id` int(11) NOT NULL,
  `paymentMode` varchar(100) DEFAULT NULL,
  `amount` varchar(10) DEFAULT NULL,
  `paymentId` text DEFAULT NULL,
  `paymentStatus` varchar(100) DEFAULT NULL,
  `paymentDetails` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`paymentDetails`)),
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `prescription`
--

CREATE TABLE `prescription` (
  `id` int(10) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `mobile` varchar(11) DEFAULT NULL,
  `remark` text DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `user_id` int(10) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_image`
--

CREATE TABLE `product_image` (
  `id` int(10) NOT NULL,
  `image` text DEFAULT NULL,
  `item_id` int(10) DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `product_image`
--

INSERT INTO `product_image` (`id`, `image`, `item_id`, `created_date`) VALUES
(79, 'assets/images/ProductImage/product/113220231207051213000000376334835693.png', 1132, '2023-12-07 17:09:13'),
(84, 'assets/images/ProductImage/product/1137202312070512110000004529032986744.png', 1137, '2023-12-07 17:23:11'),
(85, 'assets/images/ProductImage/product/1138202312070512140000009804421205945.png', 1138, '2023-12-07 17:24:14'),
(86, 'assets/images/ProductImage/product/1139202312070512400000009653616038530.png', 1139, '2023-12-07 17:25:40'),
(87, 'assets/images/ProductImage/product/114020231207051216000000929908435970.png', 1140, '2023-12-07 17:27:16'),
(88, 'assets/images/ProductImage/product/1141202312070512480000009450919297201.png', 1141, '2023-12-07 17:29:48'),
(89, 'assets/images/ProductImage/product/1142202312070512020000002803202429736.png', 1142, '2023-12-07 17:31:02'),
(90, 'assets/images/ProductImage/product/1143202312070512390000006671028459196.png', 1143, '2023-12-07 17:33:39'),
(91, 'assets/images/ProductImage/product/1144202312070512420000009257785878360.png', 1144, '2023-12-07 17:35:42');

-- --------------------------------------------------------

--
-- Table structure for table `sub_categories`
--

CREATE TABLE `sub_categories` (
  `id` int(11) NOT NULL,
  `category_id` int(10) DEFAULT NULL,
  `sub_category_title` varchar(200) DEFAULT NULL,
  `sub_category_img` text CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci DEFAULT NULL,
  `created_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=ucs2 COLLATE=ucs2_general_ci;

--
-- Dumping data for table `sub_categories`
--

INSERT INTO `sub_categories` (`id`, `category_id`, `sub_category_title`, `sub_category_img`, `created_date`) VALUES
(417, 371, 'Противоаллергические таблетки ', 'assets/images/ProductImage/category/20231207041242000000.png', '2023-12-07 16:30:42'),
(420, 373, 'Мультивитаминные Комплексы ', 'assets/images/ProductImage/category/20231207041227000000.png', '2023-12-07 16:35:51'),
(421, 373, 'Витамин С ', 'assets/images/ProductImage/category/20231207041221000000.png', '2023-12-07 16:37:21'),
(422, 373, 'Витамин Д ', 'assets/images/ProductImage/category/20231207041234000000.png', '2023-12-07 16:37:34'),
(423, 374, 'Мази от Аллергии ', 'assets/images/ProductImage/category/20231207041257000000.png', '2023-12-07 16:39:57'),
(424, 374, 'Противогрибковые Кремы ', 'assets/images/ProductImage/category/20231207041249000000.png', '2023-12-07 16:40:49'),
(425, 375, 'Капли для Улучшения Зрения  ', 'assets/images/ProductImage/category/20231207041243000000.png', '2023-12-07 16:42:43'),
(426, 375, 'Капли для Лечения Глазных Инфекций ', 'assets/images/ProductImage/category/20231207041257000000.png', '2023-12-07 16:45:57'),
(427, 376, 'Вакцинационные Уколы', 'assets/images/ProductImage/category/20231207041238000000.png', '2023-12-07 16:47:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `area` varchar(100) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `state` varchar(100) DEFAULT NULL,
  `city` varchar(100) DEFAULT NULL,
  `zip` varchar(11) DEFAULT NULL,
  `mobile` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` text NOT NULL,
  `reset_code` varchar(6) DEFAULT NULL,
  `firebase_token` text DEFAULT NULL,
  `otp` int(6) DEFAULT NULL,
  `verified` tinyint(1) NOT NULL DEFAULT 0,
  `token` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `area`, `address`, `state`, `city`, `zip`, `mobile`, `email`, `password`, `reset_code`, `firebase_token`, `otp`, `verified`, `token`) VALUES
(435, 'P', NULL, NULL, NULL, NULL, NULL, '888', NULL, '46b09f79db8c6c5531756e39860cfd41fa1b311104f1a416e0c6397a93e63059', NULL, NULL, 526895, 0, '79ad52a93fbb139178cb6c1afbecc6b1'),
(436, 'P', NULL, NULL, NULL, NULL, NULL, '0378507207', NULL, '891e12e156d8c6609c6d5f3e04b2fc8da6d9ff3d7e9f906314c0909da69637eb', NULL, NULL, 382742, 0, '8f6e1b92320ceb28176ba750d174e5da'),
(437, 'phong đang code', NULL, NULL, NULL, NULL, NULL, '84378507207', NULL, '1c20e554c167a011867d10fc75fe04c246c7f5ba8b38386de8625bbb247dd905', NULL, NULL, 265180, 0, '9ab91ed4436aa50ca568b3ff2ac2ac97'),
(438, 'code', NULL, NULL, NULL, NULL, NULL, '84378507205', NULL, '1c20e554c167a011867d10fc75fe04c246c7f5ba8b38386de8625bbb247dd905', NULL, NULL, 596949, 0, '6a52a7e9b4c1d5587f637eae7aa06bf2'),
(439, 'test', NULL, NULL, NULL, NULL, NULL, '+84342473443', NULL, '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, NULL, 911776, 0, '9322146799289da446aa5700b9c50919'),
(440, 'wl', NULL, NULL, NULL, NULL, NULL, '0342473443', NULL, '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, NULL, NULL, 1, '144d1b7baec791b78b662b460b841936'),
(441, 'Edilberto ', NULL, NULL, NULL, NULL, NULL, '964040652', NULL, '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, 'f46d_JMnQ26LbQVyo1IcdB:APA91bEHIaVXwUlYinGwrdp0wK2O4cpjHzIQDcliTAYfpzTy8Y5Z_BljeLJZ19X7D_BrAHKwzRAgUAkgC1l8QpzvXJlkizF2prlntEjPNQcwD90N017UO5jbkibYUHAV94iLpnBHuGjz', 493722, 0, '79f962c67d57e1e8458f0a2229db125e'),
(442, 'Duong Nguyen', NULL, NULL, NULL, NULL, NULL, '0975962538', NULL, '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414', NULL, 'd1vyKqQRQJ6mF1nOcEWHr1:APA91bGyBcRCKRBTAhTFux214xBVdJJ_mFHEVccyu2MXtybrq8TTglu93eST1XPXDoS6KCNluv88hhkR-60DW2FeRXWnMgXqg-_bIACgwJBnrACcD3B4rLRROnp5d_jEugydxXrkZKGS', 341812, 0, 'f91bc1ee30a230e5a9f6fe1024ff69df'),
(443, 'dương', NULL, NULL, NULL, NULL, NULL, '0968659255', NULL, '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414', NULL, NULL, 566358, 0, 'c9346949dbea7ac32a03a220fff550eb'),
(444, 'Riya Solanki', NULL, NULL, NULL, NULL, NULL, '6352639252', NULL, 'bdba1d66e01f601b5fbb4cc0e0480d31fee9888e30ffbed3b7e024af29255ed7', NULL, 'dU7cpCobSPKwoxoobj0UP0:APA91bHZevzWXevoE-8ryV0EGEVlCr_On5wSc3nLKVpQCzOaTA9X3WQAIW3UmVKydCGirsNy_5gwYgoiS6CvCgCcMiKomLnzmNREswmVTgjCJjAxwWy-sxLn_4vpUwyWtlWv0IUi_tMf', 724918, 0, '8e293c3b57b08fc433941e2ccc3183ef'),
(445, 'Shweta', NULL, NULL, NULL, NULL, NULL, '7600199913', NULL, 'ddac0a0f3b960ec55a9eb2487d27a3f143a4bdad85fd069effe18cf4a65c4375', '215000', 'f1cbMWmpQuamke5HviOzkf:APA91bFDxA9sSfYdc8aXxCOMd1-muhZ7MmIASh3KIChh4GAFUYkoBujowRVHrDNomVpi2wPc0ltCkxB4iCZuPNJFY7oJpRHXzAQTQvJKgYyj84KEoH6HD4L3OBaolLu8FpnqM4p-tE4x', NULL, 1, '8a480ce31871eccc9d8a21ae01aa08c8'),
(446, 'Ratilal Vachhani', NULL, NULL, NULL, NULL, NULL, '9898297753', NULL, 'dd565468526aab70fa72dcf1930bc5d8dea3c6ed82700f1d60d815b57212d576', NULL, 'c4Hj5Q7NQq6hy3neD8DMkI:APA91bGI2PROknkla7A97BqOtlZUMnwlQK439IfeiHEjgEw9okqZs5staXyfgMhh9HA-CE1BSFkBvZ-sS3-gi0_5vnE5ijgFiQjJ9DBxnrPmNbVQ-bwOGwtaKiMDdLsBHl64_OxJN4aF', NULL, 1, '0f71da62dee4b23d88d05659cf824b1d'),
(447, 'Meet Vachhani', NULL, NULL, NULL, NULL, NULL, '7096454457', NULL, '9119b4fd5801f27d28b72f8efd3c51cf3341f47bf46ca6774d4bc1b5374582b3', NULL, 'f1cbMWmpQuamke5HviOzkf:APA91bFDxA9sSfYdc8aXxCOMd1-muhZ7MmIASh3KIChh4GAFUYkoBujowRVHrDNomVpi2wPc0ltCkxB4iCZuPNJFY7oJpRHXzAQTQvJKgYyj84KEoH6HD4L3OBaolLu8FpnqM4p-tE4x', NULL, 1, 'bad7c5599826f7a0f894f02c25ef7da2'),
(448, 'Alikhan Zhumagulov', NULL, NULL, NULL, NULL, NULL, '7777777', NULL, '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414', NULL, 'cCyMpA05SE-JwbnalFTooD:APA91bHBsn9jh_nFMcbICGyZrWMO_HzLAZJxHKn1JC2Vx7fKh1eciPeZ-tNIXLdesy0nuR9-yWlQ3xWaLSUMtWNBEJXvoqmDYYmQq6HuS4jXPFuUMcNLrO5jZuMc4-da6s4zZ4pQBsOV', 674915, 0, '37c3add53fa43ab314936dd42e9a440b'),
(449, 'Likh', NULL, NULL, NULL, NULL, NULL, '8708375033', NULL, '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414', NULL, 'cCyMpA05SE-JwbnalFTooD:APA91bHBsn9jh_nFMcbICGyZrWMO_HzLAZJxHKn1JC2Vx7fKh1eciPeZ-tNIXLdesy0nuR9-yWlQ3xWaLSUMtWNBEJXvoqmDYYmQq6HuS4jXPFuUMcNLrO5jZuMc4-da6s4zZ4pQBsOV', 700507, 0, 'df006083f6c1cfbf80a8b0f929943235'),
(450, 'Alikhan', NULL, NULL, NULL, NULL, NULL, '1234567', NULL, '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414', NULL, 'cCyMpA05SE-JwbnalFTooD:APA91bHBsn9jh_nFMcbICGyZrWMO_HzLAZJxHKn1JC2Vx7fKh1eciPeZ-tNIXLdesy0nuR9-yWlQ3xWaLSUMtWNBEJXvoqmDYYmQq6HuS4jXPFuUMcNLrO5jZuMc4-da6s4zZ4pQBsOV', 822829, 0, '54a4cc04c1bbfc00081dbe02fb3df2d3'),
(451, 'Alikhan Zhumagulov', NULL, NULL, NULL, NULL, NULL, '7083750334', NULL, '5a7a02a266337be44882432e52527e45d0eedd0637d363e09b3bb4a2cca90d73', NULL, 'cCyMpA05SE-JwbnalFTooD:APA91bHBsn9jh_nFMcbICGyZrWMO_HzLAZJxHKn1JC2Vx7fKh1eciPeZ-tNIXLdesy0nuR9-yWlQ3xWaLSUMtWNBEJXvoqmDYYmQq6HuS4jXPFuUMcNLrO5jZuMc4-da6s4zZ4pQBsOV', NULL, 1, '48dab6c2878f6b7b5cc0f6d2889ac0c7'),
(452, 'Alikhan Zhumagulov', NULL, '1234', 'Andaman and Nicobar Islands', 'Port Blair', '8458', '7083750337', NULL, '8bb0cf6eb9b17d0f7d22b456f121257dc1254e1f01665370476383ea776df414', NULL, 'cCyMpA05SE-JwbnalFTooD:APA91bHBsn9jh_nFMcbICGyZrWMO_HzLAZJxHKn1JC2Vx7fKh1eciPeZ-tNIXLdesy0nuR9-yWlQ3xWaLSUMtWNBEJXvoqmDYYmQq6HuS4jXPFuUMcNLrO5jZuMc4-da6s4zZ4pQBsOV', NULL, 1, 'f72b175dd9de1881446ccbb6dae58641'),
(453, 'phong đang demo', NULL, NULL, NULL, NULL, NULL, '+17605178389', NULL, '8d969eef6ecad3c29a3a629280e686cf0c3f5d5a86aff3ca12020c923adc6c92', NULL, NULL, 868428, 0, 'd2d6053c43056dec66a723d1646badf5'),
(454, 'Test User', NULL, 'Jama Masjid, Dehuroad', 'Delhi', 'Delhi', '412104', '9876598765', NULL, '5e884898da28047151d0e56f8dc6292773603d0d6aabbdd62a11ef721d1542d8', NULL, NULL, NULL, 1, '3c82755ecf927001f9c66378477d6b7b'),
(455, '2', NULL, NULL, NULL, NULL, NULL, '1301', NULL, '8de0b3c47f112c59745f717a626932264c422a7563954872e237b223af4ad643', NULL, NULL, 995763, 0, '05f880c4397f004c2de1e366cb30ca7b'),
(456, 'Ganesh Santosh Bhagat', NULL, NULL, NULL, NULL, NULL, '7028480455', NULL, 'e86f78a8a3caf0b60d8e74e5942aa6d86dc150cd3c03338aef25b7d2d7e3acc7', NULL, 'd_AmL-NURDa3XaC5NmOE8U:APA91bG4fnPveTBMQYGPJp8ZMUYIyWmh9_j58mmpscIr4K_Q6sSeZDX0vuFah6HpqSFO0bwnmJL5SDw3JslpiXr3_LOWlIUJMtio6Y-xtU1c0lbo8dIfXZNLtxoUeLIYnbPrHDBdZhwo', NULL, 1, '042aebd8f04225e011a108be246bbfb3'),
(457, 'Najim Ahmed', NULL, 'aaa', 'West Bengal', 'Kolkata', '2222', '1829304414', NULL, 'ef797c8118f02dfb649607dd5d3f8c7623048c9c063d532cc95c5ed7a898a64f', NULL, 'eJ2PiUOhSha9jGpIUQzLWs:APA91bFRlU30fRpsRvO8WUhCn-eV1qUcmaA2lxY7GXjf1vy6yclTow30rsnB4XvigIsGWcbT9jTUfa7l0jOCSwZIU4XK7KxelBNyJCokuDWXHVPIMyvVoIKkCdo-yUeNz9aA5umdjkFg', NULL, 1, '95deef750a0efb9441d9c10d3acb4d9c'),
(458, 'Admin', NULL, NULL, NULL, NULL, NULL, '7471373002', NULL, '5fd088669bf323fc8b39b6bca1e75620b0784e7626b22e56bd4358083461b747', NULL, 'esn52Rw5QU67EWd28FTe_F:APA91bGj_qVHwB83w4mCSh4W1NNTCec7VTQ1COb2ePlG3Ileh3ETciT6V_FbCLGeVuousCuARa_OTS7VZ3z-umnR-4yHXhcalvFsIxhdwN1wyTg36NMTzm_TPfW1pOxx-HkmR3wQlT-d', 896105, 0, 'c66988bb024a80a7d0959751aa1ac71a'),
(459, 'Zhandos', NULL, NULL, NULL, NULL, NULL, '7478518903', NULL, '5fd088669bf323fc8b39b6bca1e75620b0784e7626b22e56bd4358083461b747', NULL, 'esn52Rw5QU67EWd28FTe_F:APA91bGj_qVHwB83w4mCSh4W1NNTCec7VTQ1COb2ePlG3Ileh3ETciT6V_FbCLGeVuousCuARa_OTS7VZ3z-umnR-4yHXhcalvFsIxhdwN1wyTg36NMTzm_TPfW1pOxx-HkmR3wQlT-d', 517846, 0, '4668037b324df428676471106f6ae44b'),
(460, 'Zhandoss', NULL, NULL, NULL, NULL, NULL, '7473738747', NULL, '6ae9c6789a5bb44a43a8bb1f88a6974d02c216cb1ef0b87a52a3106e15bfc153', NULL, 'esn52Rw5QU67EWd28FTe_F:APA91bGj_qVHwB83w4mCSh4W1NNTCec7VTQ1COb2ePlG3Ileh3ETciT6V_FbCLGeVuousCuARa_OTS7VZ3z-umnR-4yHXhcalvFsIxhdwN1wyTg36NMTzm_TPfW1pOxx-HkmR3wQlT-d', NULL, 1, '3a15ae0a9bc8576eedf9f7e3f0487ff2'),
(461, 'ayat BD24', NULL, NULL, NULL, NULL, NULL, '01329564921', NULL, '971335240057a222d2c160e56d7be712531be806aac6010f444c922abdd8ebeb', NULL, 'cVX8eQ-7RmauMVkCABF9zk:APA91bF8TH5BqQ8qe7H0Oot0j4_JUZqWXQhI90aIDcgdw4dWJ2e2J7_fnvzj7T1Vb_i3Ny83Py2grSFJThyHiE_IHefvixtHAmzvHFJ_xUiaLM0o1E7InPIWgAGNTaIpuR3xSMW1ppPD', 797130, 0, 'f13bc68194a36539629c4527bd72abf7'),
(462, 'Mdsahine', NULL, NULL, NULL, NULL, NULL, '01928223032', NULL, '971335240057a222d2c160e56d7be712531be806aac6010f444c922abdd8ebeb', NULL, 'fsfhyzDARkmk_EXWZARoRs:APA91bHj7I03aRaGlnTrexvz0UnbDtFzIyk_dLSyppCmNJJf9-T0VG1bCZ7bME8rB-gM2lKRR6zX752GuBmgW6Cb8uND_d8x3X5t_0eNEq1RdUphjJFZpSyJ1BOCaAviMV1v6zCbj3Sk', 346213, 0, '69807efe51e99ef32ffad2e8c0d1e704'),
(463, 'test', NULL, NULL, NULL, NULL, NULL, '98885555', NULL, 'ecd71870d1963316a97e3ac3408c9835ad8cf0f3c1bc703527c30265534f75ae', NULL, NULL, 837281, 0, '8cbaf4fadea4fbf2561b771379d8d717'),
(464, 'test', NULL, NULL, NULL, NULL, NULL, '3213415064', NULL, 'ecd71870d1963316a97e3ac3408c9835ad8cf0f3c1bc703527c30265534f75ae', NULL, NULL, NULL, 1, '58f75c9bb612a052855b9b12e76bc72a'),
(465, 'frequent actions', NULL, NULL, NULL, NULL, NULL, '0606060606', NULL, '708e3b91facc265a61b405cdf48f51368d4fd94c597e11acfce8e76c0b093b5a', NULL, NULL, 710116, 0, 'e6f2921ae6a359b164ca3fb1626f706a'),
(466, 'Frequent ACTIONS ', NULL, NULL, NULL, NULL, NULL, '0632771881', NULL, 'e606c5c703f66f269e085b70c458e062b394e9750de7b6622d23196a2ccb831a', NULL, NULL, 467000, 0, '29caaf33735f9aecd7a7af82bb72f75e'),
(467, NULL, NULL, NULL, NULL, NULL, NULL, '0772267021', NULL, 'e654ea3b4386e6422ff003dc3238a3c44693c1bb5ba954ba16767dd34658aee5', NULL, 'fTmBFQ5OTqaEjtrw4ThpD5:APA91bGoWlxt_ROv5p4820OeeUMNEg7viP_un3NYWnyLBUFo4iE-uN7zgfqs6Za0hfqfWcukiyitifNjkS5l6OZlI8Hg6qB7-5JDJxGokMc8LLQ1luXgaIrIKLeLp7RsipsTS5tbpk-R', 144149, 0, '248deb468891f66d26363b2f54199317'),
(468, 'Nhan', NULL, NULL, NULL, NULL, NULL, '0375539897', NULL, '6460662e217c7a9f899208dd70a2c28abdea42f128666a9b78e6c0c064846493', NULL, NULL, NULL, 1, 'cc6ffdcf91784956a2dcad7a6dc9f1de'),
(469, 'Huu Nhan', NULL, NULL, NULL, NULL, NULL, '0358788246', NULL, '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', NULL, 'fCQawUnkTsSGmNiEBBTbda:APA91bHasp0tJqcJh3JWv3yoipYt6d_qfFRRWwKscAGWfszGlcuO-2Lr9qu8sYbqBEQ6iI8XSBZZ8qgijkjti4lkbZrxDnC47M0LpjVjt1f2evpYO2ndKA4VpIeDcXNUJjnOrbHvRkeO', 321040, 0, 'c94a94ed08ec454a47a373554fa14494'),
(470, 'Huu Nhan', NULL, NULL, NULL, NULL, NULL, '8458788246', NULL, '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', NULL, 'fCQawUnkTsSGmNiEBBTbda:APA91bHasp0tJqcJh3JWv3yoipYt6d_qfFRRWwKscAGWfszGlcuO-2Lr9qu8sYbqBEQ6iI8XSBZZ8qgijkjti4lkbZrxDnC47M0LpjVjt1f2evpYO2ndKA4VpIeDcXNUJjnOrbHvRkeO', 794902, 0, '74446eab19ab481d0a566637f4ba6980'),
(471, 'Register', NULL, NULL, NULL, NULL, NULL, '0632778118', NULL, 'b427f6595a00964aac8310674d27fe1822565ab8b5a3b9ad253d7644a4e1fd77', NULL, NULL, 448072, 0, 'a9bc61947d94ee94e6fa2f8ab3197976'),
(472, 'nhan', NULL, NULL, NULL, NULL, NULL, '113', NULL, '9e4633d8746b59a6aec1c82f2f7c49fc3e49ac70b6b3803f96752dff8c481af2', NULL, 'c2RaVqk7SGil50RqI8rOLY:APA91bHnVbMsOdfbeUHoUYbZ08_3bi9LyzKGIh0LIGBzzrDrD4rP7_CqhnK6ulkyZU46EW9Nc2_rBMC6f2TTxkGdKCHmQVl8UFsTI5l5Wz_Qgkos_zNNdC-LU1l8ZFDnFrkVP0_9fq6K', 162630, 0, '1703eb2365a968f120d90be95b9a70d0'),
(473, 'nhan', NULL, NULL, NULL, NULL, NULL, '0764450235', NULL, '0def43e1863f87ecc97904cd6b67c6f6db92b49244b6953b35b2a3a368ae8cc1', NULL, 'euxAKwwcQeuT4ztJUyXFP_:APA91bFFUtyPfVnZpGSO-1dSsZQ1B185VCH7Jtu8J1rAcphiYir4d4C3xWPyPjxGQIMx12ccogz8gGKJVQmoTI8naI6xsWfX5K0isnAY66ccA3tE1sgw49U4uAOD7yWJcpjKnyGOs31p', NULL, 1, '05376ee659bc63cef35f45d74f6459fa'),
(474, 'Sumeet Gurupadappa Bangarkinagi', NULL, 'zfrw', 'Delhi', 'Delhi', '122', '6362625797', NULL, 'c7bd6c48d5a3f27aa0162745d59a441c6a04e3262c6080ba368426684e38e31b', NULL, NULL, NULL, 1, 'd2116a35893aac0f7aaa4e5bcd810ea6'),
(475, 'Kiddo', NULL, NULL, NULL, NULL, NULL, '012345798', NULL, '15e2b0d3c33891ebb0f1ef609ec419420c20e320ce94c65fbc8c3312448eb225', NULL, 'dIzCODwGSLGu-8W8JdVuah:APA91bHSkztGv77Ovvdlsf6kVjl7JnW0u0kddc4My0lGl4NLXfDFzQmX-7fjLqhaRCPOB-Co7NcDLgAd_1BTv5NNYyEldyPieScnxPFEE0cSE-Q5g946v2-IxVCHWuHfDFf72qfp2IqY', 294891, 0, 'c7f8c40236cb7f09430ec52a9bac0c58'),
(476, 'Kiddo', NULL, '555', 'Andaman and Nicobar Islands', 'Port Blair', '555', '0123456789', NULL, '84d89877f0d4041efb6bf91a16f0248f2fd573e6af05c19f96bedb9f882f7882', NULL, 'f3AikuZlRi2VYfhFzwEFsZ:APA91bGdRxO-6G0s5QciaHOyfuXwQDhYDxZwc0EDFEVVvRq1dsBibt3dGD3GdPecun1I_f7cDq2p3xQ1eH7k5NKAXcsqchsbCOt8Qhh6Kx7w4T4c5AbEN2wORvAf6Ku9eB-T-58rRJ6J', NULL, 1, '75c43c000ceb63872c2615c396235a40'),
(477, 'David Nguyen', NULL, '5555', 'Meghalaya', 'Nongstoin', '0333', '0312345678', NULL, '8234087075ee36465f289ee759ba6e4a497629efa40817741faacc56e766d265', NULL, 'f3AikuZlRi2VYfhFzwEFsZ:APA91bGdRxO-6G0s5QciaHOyfuXwQDhYDxZwc0EDFEVVvRq1dsBibt3dGD3GdPecun1I_f7cDq2p3xQ1eH7k5NKAXcsqchsbCOt8Qhh6Kx7w4T4c5AbEN2wORvAf6Ku9eB-T-58rRJ6J', NULL, 1, '6928c37dc3c1c75e9aedad3a3c6e452e');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banners`
--
ALTER TABLE `banners`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bill_payment`
--
ALTER TABLE `bill_payment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `items`
--
ALTER TABLE `items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`),
  ADD KEY `sub_category_id` (`sub_category_id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orderlist`
--
ALTER TABLE `orderlist`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `orders_ibfk_1` (`user_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `prescription`
--
ALTER TABLE `prescription`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `product_image`
--
ALTER TABLE `product_image`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_image_ibfk_1` (`item_id`);

--
-- Indexes for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `mobile` (`mobile`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `mobile_2` (`mobile`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `banners`
--
ALTER TABLE `banners`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `bill_payment`
--
ALTER TABLE `bill_payment`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=381;

--
-- AUTO_INCREMENT for table `items`
--
ALTER TABLE `items`
  MODIFY `id` int(100) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1145;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=84;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `orderlist`
--
ALTER TABLE `orderlist`
  MODIFY `id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=483;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `prescription`
--
ALTER TABLE `prescription`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `product_image`
--
ALTER TABLE `product_image`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=93;

--
-- AUTO_INCREMENT for table `sub_categories`
--
ALTER TABLE `sub_categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=431;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=478;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `cart_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `items`
--
ALTER TABLE `items`
  ADD CONSTRAINT `items_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `items_ibfk_2` FOREIGN KEY (`sub_category_id`) REFERENCES `sub_categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orderlist`
--
ALTER TABLE `orderlist`
  ADD CONSTRAINT `orderlist_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `prescription`
--
ALTER TABLE `prescription`
  ADD CONSTRAINT `prescription_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `product_image`
--
ALTER TABLE `product_image`
  ADD CONSTRAINT `product_image_ibfk_1` FOREIGN KEY (`item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sub_categories`
--
ALTER TABLE `sub_categories`
  ADD CONSTRAINT `sub_categories_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
