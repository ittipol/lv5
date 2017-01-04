-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 04, 2017 at 04:20 PM
-- Server version: 10.1.16-MariaDB
-- PHP Version: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chonburi_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `place_name` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `district_id` int(11) NOT NULL,
  `sub_district_id` int(11) NOT NULL,
  `description` text,
  `lat` varchar(255) DEFAULT NULL,
  `lng` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `business_entities`
--

CREATE TABLE `business_entities` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `business_types`
--

CREATE TABLE `business_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `image` varchar(255) DEFAULT NULL,
  `top` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `parent_id`, `name`, `description`, `image`, `top`, `active`, `created`, `modified`) VALUES
(1, NULL, 'สินค้า', NULL, NULL, 0, 1, '2016-12-03 13:53:31', '2016-12-03 13:53:31'),
(2, NULL, 'อาหาร', NULL, NULL, 0, 1, '2016-12-03 13:53:31', '2016-12-03 13:53:31'),
(3, NULL, 'เครื่องดื่ม', NULL, NULL, 0, 1, '2016-12-03 13:53:51', '2016-12-03 13:53:51'),
(4, NULL, 'ร้านค้า', NULL, NULL, 0, 1, '2016-12-03 13:53:51', '2016-12-03 13:53:51'),
(5, NULL, 'บริการ', NULL, NULL, 0, 1, '2016-12-03 13:54:46', '2016-12-03 13:54:46'),
(6, NULL, 'อสังหาริมทรัพย์', NULL, NULL, 0, 1, '2016-12-03 13:54:46', '2016-12-03 13:54:46');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `brand_story` text,
  `business_entity_id` int(11) NOT NULL,
  `business_type` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_has_business_types`
--

CREATE TABLE `company_has_business_types` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `business_type_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_has_departments`
--

CREATE TABLE `company_has_departments` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `company_has_jobs`
--

CREATE TABLE `company_has_jobs` (
  `id` int(11) NOT NULL,
  `company_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `instagram` varchar(255) DEFAULT NULL,
  `line` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `days`
--

CREATE TABLE `days` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `days`
--

INSERT INTO `days` (`id`, `name`) VALUES
(1, 'วันจันทร์'),
(2, 'วันอังคาร'),
(3, 'วันพุธ'),
(4, 'วันพฤหัสบดี'),
(5, 'วันศุกร์'),
(6, 'วันเสาร์'),
(7, 'วันอาทิตย์');

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `phone_number` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL,
  `facebook` varchar(255) DEFAULT NULL,
  `line` varchar(255) DEFAULT NULL,
  `company_address` tinyint(1) NOT NULL DEFAULT '0',
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `department_has_jobs`
--

CREATE TABLE `department_has_jobs` (
  `id` int(11) NOT NULL,
  `company_has_job_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `districts`
--

CREATE TABLE `districts` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `description` text,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `districts`
--

INSERT INTO `districts` (`id`, `name`, `name_en`, `description`, `created`, `modified`) VALUES
(1, 'เมืองชลบุรี', NULL, NULL, '2016-11-26 07:34:14', '2016-11-26 07:34:14'),
(2, 'เกาะสีชัง', NULL, NULL, '2016-11-26 07:34:14', '2016-11-26 07:34:14'),
(3, 'บ่อทอง', NULL, NULL, '2016-11-26 07:34:55', '2016-11-26 07:34:55'),
(4, 'บางละมุง', NULL, NULL, '2016-11-26 07:34:55', '2016-11-26 07:34:55'),
(5, 'บ้านบึง', NULL, NULL, '2016-11-26 07:35:19', '2016-11-26 07:35:19'),
(6, 'พานทอง', NULL, NULL, '2016-11-26 07:35:19', '2016-11-26 07:35:19'),
(7, 'พนัสนิคม', NULL, NULL, '2016-11-26 07:35:53', '2016-11-26 07:35:53'),
(8, 'ศรีราชา', NULL, NULL, '2016-11-26 07:35:53', '2016-11-26 07:35:53'),
(9, 'สัตหีบ', NULL, NULL, '2016-11-26 07:36:09', '2016-11-26 07:36:09'),
(10, 'หนองใหญ่', NULL, NULL, '2016-11-26 07:36:09', '2016-11-26 07:36:09'),
(11, 'เกาะจันทร์', NULL, NULL, '2016-11-26 07:36:26', '2016-11-26 07:36:26'),
(12, 'เมืองพัทยา', NULL, NULL, '2016-11-26 07:41:01', '2016-11-26 07:41:01');

-- --------------------------------------------------------

--
-- Table structure for table `employment_types`
--

CREATE TABLE `employment_types` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE `images` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `item_sells`
--

CREATE TABLE `item_sells` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `word_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `salary` varchar(255) NOT NULL,
  `employment_type_id` int(11) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `age` varchar(255) NOT NULL,
  `gender` varchar(2) NOT NULL,
  `educational_level` varchar(255) NOT NULL,
  `experience` varchar(255) NOT NULL,
  `number_of_position` varchar(255) DEFAULT NULL,
  `welfare` text,
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lookups`
--

CREATE TABLE `lookups` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `keyword` varchar(255) DEFAULT NULL,
  `description` text,
  `keyword_1` varchar(255) DEFAULT NULL,
  `keyword_2` varchar(255) DEFAULT NULL,
  `keyword_3` varchar(255) DEFAULT NULL,
  `keyword_4` varchar(255) DEFAULT NULL,
  `description_1` text,
  `address` text,
  `tags` text,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `office_hours`
--

CREATE TABLE `office_hours` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `same_time` tinyint(1) NOT NULL,
  `time` text NOT NULL,
  `display` tinyint(1) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `online_shops`
--

CREATE TABLE `online_shops` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `created_by` int(11) NOT NULL,
  `ip_address` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `people`
--

CREATE TABLE `people` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `profile_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `person_has_entities`
--

CREATE TABLE `person_has_entities` (
  `id` int(11) NOT NULL,
  `parent_person_has_entity_id` int(11) DEFAULT NULL,
  `person_id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `person_interests`
--

CREATE TABLE `person_interests` (
  `id` int(11) NOT NULL,
  `person_id` int(11) NOT NULL,
  `word_id` int(11) NOT NULL,
  `created_by_system` tinyint(1) NOT NULL DEFAULT '0',
  `interested_times` int(255) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `profiles`
--

CREATE TABLE `profiles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `gender` varchar(25) NOT NULL,
  `birth_date` date NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `adding_permission` tinyint(1) NOT NULL,
  `editing_permission` tinyint(1) NOT NULL,
  `deleting_permission` tinyint(1) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `alias`, `adding_permission`, `editing_permission`, `deleting_permission`, `created`, `modified`) VALUES
(1, 'admin', 'admin', 1, 1, 1, '2016-12-06 10:44:05', '2016-12-31 17:36:42');

-- --------------------------------------------------------

--
-- Table structure for table `slugs`
--

CREATE TABLE `slugs` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `alias` varchar(255) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `stories`
--

CREATE TABLE `stories` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `place_name` varchar(255) DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `sub_districts`
--

CREATE TABLE `sub_districts` (
  `id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `description` text,
  `zip_code` varchar(5) DEFAULT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sub_districts`
--

INSERT INTO `sub_districts` (`id`, `district_id`, `name`, `name_en`, `description`, `zip_code`, `created`, `modified`) VALUES
(1, 1, 'เสม็ด', NULL, NULL, NULL, '2016-11-26 07:43:37', '2016-11-26 07:43:37'),
(2, 1, 'เหมือง', NULL, NULL, NULL, '2016-11-26 07:43:37', '2016-11-26 07:43:37'),
(3, 1, 'แสนสุข', NULL, NULL, NULL, '2016-11-26 07:44:21', '2016-11-26 07:44:21'),
(4, 1, 'คลองตำหรุ', NULL, NULL, NULL, '2016-11-26 07:44:21', '2016-11-26 07:44:21'),
(5, 1, 'ดอนหัวฬ่อ', NULL, NULL, NULL, '2016-11-26 07:44:53', '2016-11-26 07:44:53'),
(6, 1, 'นาป่า', NULL, NULL, NULL, '2016-11-26 07:44:53', '2016-11-26 07:44:53'),
(7, 1, 'บางทราย', NULL, NULL, NULL, '2016-11-26 07:45:45', '2016-11-26 07:45:45'),
(8, 1, 'บางปลาสร้อย', NULL, NULL, NULL, '2016-11-26 07:45:45', '2016-11-26 07:45:45'),
(9, 1, 'บ้านโขด', NULL, NULL, NULL, '2016-11-26 07:46:18', '2016-11-26 07:46:18'),
(10, 1, 'บ้านปึก', NULL, NULL, NULL, '2016-11-26 07:46:18', '2016-11-26 07:46:18'),
(11, 1, 'บ้านสวน', NULL, NULL, NULL, '2016-11-26 07:46:59', '2016-11-26 07:46:59'),
(12, 1, 'มะขามหย่ง', NULL, NULL, NULL, '2016-11-26 07:46:59', '2016-11-26 07:46:59'),
(13, 1, 'สำนักบก', NULL, NULL, NULL, '2016-11-26 07:47:33', '2016-11-26 07:47:33'),
(14, 1, 'หนองไม้แดง', NULL, NULL, NULL, '2016-11-26 07:47:33', '2016-11-26 07:47:33'),
(15, 1, 'หนองข้างคอก', NULL, NULL, NULL, '2016-11-26 07:48:06', '2016-11-26 07:48:06'),
(16, 1, 'หนองรี', NULL, NULL, NULL, '2016-11-26 07:48:06', '2016-11-26 07:48:06'),
(17, 1, 'ห้วยกะปิ', NULL, NULL, NULL, '2016-11-26 07:48:27', '2016-11-26 07:48:27'),
(18, 1, 'อ่างศิลา', NULL, NULL, NULL, '2016-11-26 07:48:27', '2016-11-26 07:48:27'),
(19, 2, 'ท่าเทววงษ์', NULL, NULL, NULL, '2016-11-26 07:49:01', '2016-11-26 07:49:01'),
(20, 3, 'เกษตรสุวรรณ', NULL, NULL, NULL, '2016-11-26 07:49:38', '2016-11-26 07:49:38'),
(21, 3, 'ธาตุทอง', NULL, NULL, NULL, '2016-11-26 07:49:38', '2016-11-26 07:49:38'),
(22, 3, 'บ่อกวางทอง', NULL, NULL, NULL, '2016-11-26 07:49:57', '2016-11-26 07:49:57'),
(23, 3, 'บ่อทอง', NULL, NULL, NULL, '2016-11-26 07:49:57', '2016-11-26 07:49:57'),
(24, 3, 'พลวงทอง', NULL, NULL, NULL, '2016-11-26 07:50:28', '2016-11-26 07:50:28'),
(25, 3, 'วัดสุวรรณ', NULL, NULL, NULL, '2016-11-26 07:50:28', '2016-11-26 07:50:28'),
(26, 4, 'เขาไม้แก้ว', NULL, NULL, NULL, '2016-11-26 07:51:42', '2016-11-26 07:51:42'),
(27, 4, 'โป่ง', NULL, NULL, NULL, '2016-11-26 07:51:42', '2016-11-26 07:51:42'),
(28, 4, 'ตะเคียนเตี้ย', NULL, NULL, NULL, '2016-11-26 07:52:12', '2016-11-26 07:52:12'),
(29, 4, 'นาเกลือ', NULL, NULL, NULL, '2016-11-26 07:52:12', '2016-11-26 07:52:12'),
(30, 4, 'บางละมุง', NULL, NULL, NULL, '2016-11-26 07:52:38', '2016-11-26 07:52:38'),
(31, 4, 'หนองปรือ', NULL, NULL, NULL, '2016-11-26 07:52:38', '2016-11-26 07:52:38'),
(32, 4, 'หนองปลาไหล', NULL, NULL, NULL, '2016-11-26 07:53:24', '2016-11-26 07:53:24'),
(33, 4, 'ห้วยใหญ่', NULL, NULL, NULL, '2016-11-26 07:53:24', '2016-11-26 07:53:24'),
(34, 5, 'คลองกิ่ว', NULL, NULL, NULL, '2016-11-26 07:54:07', '2016-11-26 07:54:07'),
(35, 5, 'บ้านบึง', NULL, NULL, NULL, '2016-11-26 07:54:07', '2016-11-26 07:54:07'),
(36, 5, 'มาบไผ่', NULL, NULL, NULL, '2016-11-26 07:55:20', '2016-11-26 07:55:20'),
(37, 5, 'หนองไผ่แก้ว', NULL, NULL, NULL, '2016-11-26 07:55:20', '2016-11-26 07:55:20'),
(38, 5, 'หนองชาก', NULL, NULL, NULL, '2016-11-26 07:55:52', '2016-11-26 07:55:52'),
(39, 5, 'หนองซ้ำซาก', NULL, NULL, NULL, '2016-11-26 07:55:52', '2016-11-26 07:55:52'),
(40, 5, 'หนองบอนแดง', NULL, NULL, NULL, '2016-11-26 07:56:25', '2016-11-26 07:56:25'),
(41, 5, 'หนองอิรุณ', NULL, NULL, NULL, '2016-11-26 07:56:25', '2016-11-26 07:56:25'),
(42, 6, 'เกาะลอย', NULL, NULL, NULL, '2016-11-26 07:57:40', '2016-11-26 07:57:40'),
(43, 6, 'โคกขี้หนอน', NULL, NULL, NULL, '2016-11-26 07:57:40', '2016-11-26 07:57:40'),
(44, 6, 'บางนาง', NULL, NULL, NULL, '2016-11-26 07:58:15', '2016-11-26 07:58:15'),
(45, 6, 'บางหัก', NULL, NULL, NULL, '2016-11-26 07:58:15', '2016-11-26 07:58:15'),
(46, 6, 'บ้านเก่า', NULL, NULL, NULL, '2016-11-26 07:58:42', '2016-11-26 07:58:42'),
(47, 6, 'พานทอง', NULL, NULL, NULL, '2016-11-26 07:58:42', '2016-11-26 07:58:42'),
(48, 6, 'มาบโป่ง', NULL, NULL, NULL, '2016-11-26 07:59:20', '2016-11-26 07:59:20'),
(49, 6, 'หนองกะขะ', NULL, NULL, NULL, '2016-11-26 07:59:20', '2016-11-26 07:59:20'),
(50, 6, 'หนองตำลึง', NULL, NULL, NULL, '2016-11-26 07:59:56', '2016-11-26 07:59:56'),
(51, 6, 'หนองหงษ์', NULL, NULL, NULL, '2016-11-26 07:59:56', '2016-11-26 07:59:56'),
(52, 6, 'หน้าประดู่', NULL, NULL, NULL, '2016-11-26 08:00:08', '2016-11-26 08:00:08'),
(53, 7, 'โคกเพลาะ', NULL, NULL, NULL, '2016-11-26 08:00:53', '2016-11-26 08:00:53'),
(54, 7, 'ไร่หลักทอง', NULL, NULL, NULL, '2016-11-26 08:00:53', '2016-11-26 08:00:53'),
(55, 7, 'กุฎโง้ง', NULL, NULL, NULL, '2016-11-26 08:01:20', '2016-11-26 08:01:20'),
(56, 7, 'ท่าข้าม', NULL, NULL, NULL, '2016-11-26 08:01:20', '2016-11-26 08:01:20'),
(57, 7, 'ทุ่งขวาง', NULL, NULL, NULL, '2016-11-26 08:02:30', '2016-11-26 08:02:30'),
(58, 7, 'นาเริก', NULL, NULL, NULL, '2016-11-26 08:02:30', '2016-11-26 08:02:30'),
(59, 7, 'นามะตูม', NULL, NULL, NULL, '2016-11-26 08:03:37', '2016-11-26 08:03:37'),
(60, 7, 'นาวังหิน', NULL, NULL, NULL, '2016-11-26 08:03:37', '2016-11-26 08:03:37'),
(61, 7, 'บ้านเซิด', NULL, NULL, NULL, '2016-11-26 08:04:32', '2016-11-26 08:04:32'),
(62, 7, 'บ้านช้าง', NULL, NULL, NULL, '2016-11-26 08:04:32', '2016-11-26 08:04:32'),
(63, 7, 'พนัสนิคม', NULL, NULL, NULL, '2016-11-26 08:05:23', '2016-11-26 08:05:23'),
(64, 7, 'วัดโบสถ์', NULL, NULL, NULL, '2016-11-26 08:05:23', '2016-11-26 08:05:23'),
(65, 7, 'วัดหลวง', NULL, NULL, NULL, '2016-11-26 08:06:35', '2016-11-26 08:06:35'),
(66, 7, 'สระสี่เหลี่ยม', NULL, NULL, NULL, '2016-11-26 08:06:35', '2016-11-26 08:06:35'),
(67, 7, 'หนองเหียง', NULL, NULL, NULL, '2016-11-26 08:07:08', '2016-11-26 08:07:08'),
(68, 7, 'หนองขยาด', NULL, NULL, NULL, '2016-11-26 08:07:08', '2016-11-26 08:07:08'),
(69, 7, 'หนองปรือ', NULL, NULL, NULL, '2016-11-26 08:07:49', '2016-11-26 08:07:49'),
(70, 7, 'หน้าพระธาตุ', NULL, NULL, NULL, '2016-11-26 08:07:49', '2016-11-26 08:07:49'),
(71, 7, 'หมอนนาง', NULL, NULL, NULL, '2016-11-26 08:08:12', '2016-11-26 08:08:12'),
(72, 7, 'หัวถนน', NULL, NULL, NULL, '2016-11-26 08:08:12', '2016-11-26 08:08:12'),
(73, 8, 'เขาคันทรง', NULL, NULL, NULL, '2016-11-26 08:09:44', '2016-11-26 08:09:44'),
(74, 8, 'ทุ่งสุขลา', NULL, NULL, NULL, '2016-11-26 08:09:44', '2016-11-26 08:09:44'),
(75, 8, 'บ่อวิน', NULL, NULL, NULL, '2016-11-26 08:10:15', '2016-11-26 08:10:15'),
(76, 8, 'บางพระ', NULL, NULL, NULL, '2016-11-26 08:10:15', '2016-11-26 08:10:15'),
(77, 8, 'บึง', NULL, NULL, NULL, '2016-11-26 08:10:38', '2016-11-26 08:10:38'),
(78, 8, 'ศรีราชา', NULL, NULL, NULL, '2016-11-26 08:10:38', '2016-11-26 08:10:38'),
(79, 8, 'สุรศักดิ์', NULL, NULL, NULL, '2016-11-26 08:11:05', '2016-11-26 08:11:05'),
(80, 8, 'หนองขาม', NULL, NULL, NULL, '2016-11-26 08:11:05', '2016-11-26 08:11:05'),
(81, 9, 'แสมสาร', NULL, NULL, NULL, '2016-11-26 08:11:49', '2016-11-26 08:11:49'),
(82, 9, 'นาจอมเทียน', NULL, NULL, NULL, '2016-11-26 08:11:49', '2016-11-26 08:11:49'),
(83, 9, 'บางเสร่', NULL, NULL, NULL, '2016-11-26 08:12:16', '2016-11-26 08:12:16'),
(84, 9, 'พลูตาหลวง', NULL, NULL, NULL, '2016-11-26 08:12:16', '2016-11-26 08:12:16'),
(85, 9, 'สัตหีบ', NULL, NULL, NULL, '2016-11-26 08:12:29', '2016-11-26 08:12:29'),
(86, 10, 'เขาซก', NULL, NULL, NULL, '2016-11-26 08:13:37', '2016-11-26 08:13:37'),
(87, 10, 'คลองพลู', NULL, NULL, NULL, '2016-11-26 08:13:37', '2016-11-26 08:13:37'),
(88, 10, 'หนองเสือช้าง', NULL, NULL, NULL, '2016-11-26 08:13:58', '2016-11-26 08:13:58'),
(89, 10, 'หนองใหญ่', NULL, NULL, NULL, '2016-11-26 08:13:58', '2016-11-26 08:13:58'),
(90, 10, 'ห้างสูง', NULL, NULL, NULL, '2016-11-26 08:14:09', '2016-11-26 08:14:09'),
(91, 11, 'เกาะจันทร์', NULL, NULL, NULL, '2016-11-26 08:14:57', '2016-11-26 08:14:57'),
(92, 11, 'ท่าบุญมี', NULL, NULL, NULL, '2016-11-26 08:14:57', '2016-11-26 08:14:57'),
(93, 12, 'พัทยาเหนือ', NULL, NULL, NULL, '2016-12-04 13:17:12', '2016-12-04 13:17:12'),
(94, 12, 'พัทยากลาง', NULL, NULL, NULL, '2016-12-04 13:17:12', '2016-12-04 13:17:12'),
(95, 12, 'พัทยาใต้', NULL, NULL, NULL, '2016-12-04 13:17:24', '2016-12-04 13:17:24');

-- --------------------------------------------------------

--
-- Table structure for table `synonyms`
--

CREATE TABLE `synonyms` (
  `id` int(11) NOT NULL,
  `word_1` varchar(255) NOT NULL,
  `word_2` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `taggings`
--

CREATE TABLE `taggings` (
  `id` int(11) NOT NULL,
  `model` varchar(25) NOT NULL,
  `model_id` int(11) NOT NULL,
  `word_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `temp_files`
--

CREATE TABLE `temp_files` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `created_by` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `receive_email` tinyint(1) DEFAULT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `api_token` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `villages`
--

CREATE TABLE `villages` (
  `id` int(11) NOT NULL,
  `district_id` int(11) NOT NULL,
  `sub_district_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `name_en` varchar(255) DEFAULT NULL,
  `description` text,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `villages`
--

INSERT INTO `villages` (`id`, `district_id`, `sub_district_id`, `name`, `name_en`, `description`, `created`, `modified`) VALUES
(1, 1, 1, 'ห้วยแหลม', NULL, NULL, '2016-11-26 11:28:31', '2016-11-26 11:28:31'),
(2, 1, 1, 'กระโดน', NULL, NULL, '2016-11-26 11:28:31', '2016-11-26 11:28:31'),
(3, 1, 1, 'ไร่ถั่ว', NULL, NULL, '2016-11-26 11:28:31', '2016-11-26 11:28:31'),
(4, 1, 1, 'เสม็ดใน', NULL, NULL, '2016-11-26 11:28:31', '2016-11-26 11:28:31'),
(5, 1, 1, 'หัวโพรง', NULL, NULL, '2016-11-26 11:28:32', '2016-11-26 11:28:32'),
(6, 1, 1, 'เสม็ดนอก', NULL, NULL, '2016-11-26 11:28:32', '2016-11-26 11:28:32'),
(7, 1, 1, 'เนินมะกอกใน', NULL, NULL, '2016-11-26 11:28:32', '2016-11-26 11:28:32'),
(8, 1, 1, 'เนินมะกอกนอก', NULL, NULL, '2016-11-26 11:28:32', '2016-11-26 11:28:32'),
(9, 1, 2, 'ดอนล่าง', NULL, NULL, '2016-11-26 11:32:17', '2016-11-26 11:32:17'),
(10, 1, 2, 'ดอนกลาง', NULL, NULL, '2016-11-26 11:32:17', '2016-11-26 11:32:17'),
(11, 1, 2, 'ท้ายดอน', NULL, NULL, '2016-11-26 11:32:17', '2016-11-26 11:32:17'),
(12, 1, 2, 'ดอนบน', NULL, NULL, '2016-11-26 11:32:17', '2016-11-26 11:32:17'),
(13, 1, 2, 'ไร่ไหหลำ', NULL, NULL, '2016-11-26 11:32:17', '2016-11-26 11:32:17'),
(14, 1, 4, 'บน', NULL, NULL, '2016-11-26 11:33:44', '2016-11-26 11:33:44'),
(15, 1, 4, 'ล่าง', NULL, NULL, '2016-11-26 11:33:44', '2016-11-26 11:33:44'),
(16, 1, 4, 'กลางเหนือ', NULL, NULL, '2016-11-26 11:33:44', '2016-11-26 11:33:44'),
(17, 1, 4, 'กลาง', NULL, NULL, '2016-11-26 11:33:44', '2016-11-26 11:33:44'),
(18, 1, 4, 'บน', NULL, NULL, '2016-11-26 11:33:44', '2016-11-26 11:33:44'),
(19, 1, 4, 'ปากคลอง', NULL, NULL, '2016-11-26 11:33:44', '2016-11-26 11:33:44'),
(20, 1, 5, 'ชากสมอ', NULL, NULL, '2016-11-26 11:35:00', '2016-11-26 11:35:00'),
(21, 1, 5, 'หนองไผ่กลางดอน', NULL, NULL, '2016-11-26 11:35:00', '2016-11-26 11:35:00'),
(22, 1, 5, 'หนองกงฉาก', NULL, NULL, '2016-11-26 11:35:00', '2016-11-26 11:35:00'),
(23, 1, 5, 'ดอนบน', NULL, NULL, '2016-11-26 11:35:00', '2016-11-26 11:35:00'),
(24, 1, 5, 'หนองหัวฬ่อ', NULL, NULL, '2016-11-26 11:35:00', '2016-11-26 11:35:00'),
(25, 1, 5, 'ดอนล่าง', NULL, NULL, '2016-11-26 11:35:00', '2016-11-26 11:35:00'),
(26, 1, 5, 'สามเกลียว', NULL, NULL, '2016-11-26 11:35:00', '2016-11-26 11:35:00'),
(27, 1, 6, 'นาล่าง', NULL, NULL, '2016-11-26 11:35:42', '2016-11-26 11:35:42'),
(28, 1, 6, 'ท้องคุ้ง', NULL, NULL, '2016-11-26 11:35:42', '2016-11-26 11:35:42'),
(29, 1, 6, 'นาขัดแตะ', NULL, NULL, '2016-11-26 11:35:42', '2016-11-26 11:35:42'),
(30, 1, 6, 'นานอก', NULL, NULL, '2016-11-26 11:35:42', '2016-11-26 11:35:42'),
(31, 1, 6, 'ทุ่งบางกระแพง', NULL, NULL, '2016-11-26 11:35:42', '2016-11-26 11:35:42'),
(32, 1, 6, 'นาเขื่อน', NULL, NULL, '2016-11-26 11:35:42', '2016-11-26 11:35:42'),
(33, 1, 6, 'หนองพะเนียง', NULL, NULL, '2016-11-26 11:35:42', '2016-11-26 11:35:42'),
(34, 1, 6, 'หนองทราย', NULL, NULL, '2016-11-26 11:35:42', '2016-11-26 11:35:42'),
(35, 1, 6, 'บ่อมอญ', NULL, NULL, '2016-11-26 11:35:42', '2016-11-26 11:35:42'),
(36, 1, 6, 'ไร่บน', NULL, NULL, '2016-11-26 11:35:42', '2016-11-26 11:35:42'),
(37, 1, 6, 'หนองบอน', NULL, NULL, '2016-11-26 11:35:42', '2016-11-26 11:35:42'),
(38, 1, 6, 'หนองยายรัก', NULL, NULL, '2016-11-26 11:35:42', '2016-11-26 11:35:42'),
(39, 1, 7, 'บางทราย', NULL, NULL, '2016-11-26 11:36:25', '2016-11-26 11:36:25'),
(40, 1, 7, 'ถ่านล่าง', NULL, NULL, '2016-11-26 11:36:25', '2016-11-26 11:36:25'),
(41, 1, 7, 'ถ่านบน', NULL, NULL, '2016-11-26 11:36:25', '2016-11-26 11:36:25'),
(42, 1, 7, 'ท่าถ่านบน', NULL, NULL, '2016-11-26 11:36:25', '2016-11-26 11:36:25'),
(43, 1, 7, 'หัวหิน', NULL, NULL, '2016-11-26 11:36:25', '2016-11-26 11:36:25'),
(44, 1, 7, 'หน้าวัดเขา', NULL, NULL, '2016-11-26 11:36:25', '2016-11-26 11:36:25'),
(45, 1, 10, 'ปึก', NULL, NULL, '2016-11-26 11:37:44', '2016-11-26 11:37:44'),
(46, 1, 10, 'สวนมะม่วง', NULL, NULL, '2016-11-26 11:37:44', '2016-11-26 11:37:44'),
(47, 1, 10, 'ปึก', NULL, NULL, '2016-11-26 11:37:44', '2016-11-26 11:37:44'),
(48, 1, 10, 'หนองยีม้า', NULL, NULL, '2016-11-26 11:37:44', '2016-11-26 11:37:44'),
(49, 1, 10, 'สวนมาก', NULL, NULL, '2016-11-26 11:37:44', '2016-11-26 11:37:44'),
(50, 1, 10, 'หนองเพรช', NULL, NULL, '2016-11-26 11:37:44', '2016-11-26 11:37:44'),
(51, 1, 10, 'มาบหม้อ', NULL, NULL, '2016-11-26 11:37:44', '2016-11-26 11:37:44'),
(52, 1, 11, 'หนองตะโก', NULL, NULL, '2016-11-26 11:38:35', '2016-11-26 11:38:35'),
(53, 1, 11, 'หนองตาท้วม', NULL, NULL, '2016-11-26 11:38:35', '2016-11-26 11:38:35'),
(54, 1, 11, 'ห้วยทวน', NULL, NULL, '2016-11-26 11:38:35', '2016-11-26 11:38:35'),
(55, 1, 11, 'สวนแขก', NULL, NULL, '2016-11-26 11:38:35', '2016-11-26 11:38:35'),
(56, 1, 11, 'หนองกระทุ่ม', NULL, NULL, '2016-11-26 11:38:35', '2016-11-26 11:38:35'),
(57, 1, 11, 'หนองแทน', NULL, NULL, '2016-11-26 11:38:35', '2016-11-26 11:38:35'),
(58, 1, 11, 'เขามยุรา', NULL, NULL, '2016-11-26 11:38:35', '2016-11-26 11:38:35'),
(59, 1, 11, 'เขาน้อย', NULL, NULL, '2016-11-26 11:38:35', '2016-11-26 11:38:35'),
(60, 1, 11, 'บ่อบุญทอง', NULL, NULL, '2016-11-26 11:38:36', '2016-11-26 11:38:36'),
(61, 1, 11, 'ศาลาคู่', NULL, NULL, '2016-11-26 11:38:36', '2016-11-26 11:38:36'),
(62, 1, 13, 'ห้วย', NULL, NULL, '2016-11-26 11:39:50', '2016-11-26 11:39:50'),
(63, 1, 13, 'บน', NULL, NULL, '2016-11-26 11:39:50', '2016-11-26 11:39:50'),
(64, 1, 13, 'หนองน้ำร้อน', NULL, NULL, '2016-11-26 11:39:50', '2016-11-26 11:39:50'),
(65, 1, 13, 'ท้วยตะคุก', NULL, NULL, '2016-11-26 11:39:50', '2016-11-26 11:39:50'),
(66, 1, 13, 'ไร่', NULL, NULL, '2016-11-26 11:39:50', '2016-11-26 11:39:50'),
(67, 1, 13, 'หนองกระต่าย', NULL, NULL, '2016-11-26 11:39:50', '2016-11-26 11:39:50'),
(68, 1, 14, 'ศรีพโล', NULL, NULL, '2016-11-26 11:40:30', '2016-11-26 11:40:30'),
(69, 1, 14, 'ตีนเขา', NULL, NULL, '2016-11-26 11:40:30', '2016-11-26 11:40:30'),
(70, 1, 14, 'ห้วยสาริกา', NULL, NULL, '2016-11-26 11:40:30', '2016-11-26 11:40:30'),
(71, 1, 14, 'ก้นทุ่ง', NULL, NULL, '2016-11-26 11:40:30', '2016-11-26 11:40:30'),
(72, 1, 14, 'สมอกาฝาก', NULL, NULL, '2016-11-26 11:40:30', '2016-11-26 11:40:30'),
(73, 1, 14, 'อู่ตะเภา', NULL, NULL, '2016-11-26 11:40:30', '2016-11-26 11:40:30'),
(74, 1, 14, 'หนองไม้แดง', NULL, NULL, '2016-11-26 11:40:30', '2016-11-26 11:40:30'),
(75, 1, 15, 'ห้วยทวน', NULL, NULL, '2016-11-26 11:41:11', '2016-11-26 11:41:11'),
(76, 1, 15, 'มาบหวาย', NULL, NULL, '2016-11-26 11:41:11', '2016-11-26 11:41:11'),
(77, 1, 15, 'หนองข้างคอก', NULL, NULL, '2016-11-26 11:41:11', '2016-11-26 11:41:11'),
(78, 1, 15, 'บ่อน้ำจืด', NULL, NULL, '2016-11-26 11:41:11', '2016-11-26 11:41:11'),
(79, 1, 15, 'สวนมะพร้าว', NULL, NULL, '2016-11-26 11:41:11', '2016-11-26 11:41:11'),
(80, 1, 15, 'สวนน้ำตก', NULL, NULL, '2016-11-26 11:41:11', '2016-11-26 11:41:11'),
(81, 1, 15, 'วังตะโก', NULL, NULL, '2016-11-26 11:41:11', '2016-11-26 11:41:11'),
(82, 1, 16, 'หนองไข่เน่า', NULL, NULL, '2016-11-26 11:42:11', '2016-11-26 11:42:11'),
(83, 1, 16, 'เขาดิน', NULL, NULL, '2016-11-26 11:42:11', '2016-11-26 11:42:11'),
(84, 1, 16, 'หนองปึกนก', NULL, NULL, '2016-11-26 11:42:11', '2016-11-26 11:42:11'),
(85, 1, 16, 'ทุ่งตีนเป็ด', NULL, NULL, '2016-11-26 11:42:11', '2016-11-26 11:42:11'),
(86, 1, 16, 'หัวโกรก', NULL, NULL, '2016-11-26 11:42:11', '2016-11-26 11:42:11'),
(87, 1, 16, 'หัวโกรกบน', NULL, NULL, '2016-11-26 11:42:12', '2016-11-26 11:42:12'),
(88, 1, 16, 'หนองรี', NULL, NULL, '2016-11-26 11:42:12', '2016-11-26 11:42:12'),
(89, 1, 16, 'หนองแพงพวย', NULL, NULL, '2016-11-26 11:42:12', '2016-11-26 11:42:12'),
(90, 1, 16, 'หนองฉนาก', NULL, NULL, '2016-11-26 11:42:12', '2016-11-26 11:42:12'),
(91, 1, 16, 'หนองกลางดง', NULL, NULL, '2016-11-26 11:42:12', '2016-11-26 11:42:12'),
(92, 1, 16, 'เขาหินถ่าง', NULL, NULL, '2016-11-26 11:42:12', '2016-11-26 11:42:12'),
(93, 1, 16, 'ช่องมะเฟือง', NULL, NULL, '2016-11-26 11:42:12', '2016-11-26 11:42:12'),
(94, 1, 16, 'หนองค้อ', NULL, NULL, '2016-11-26 11:42:12', '2016-11-26 11:42:12'),
(95, 1, 16, 'หนองหญ้าแห้ง', NULL, NULL, '2016-11-26 11:42:12', '2016-11-26 11:42:12'),
(96, 1, 17, 'ทุ่งสระ', NULL, NULL, '2016-11-26 11:43:11', '2016-11-26 11:43:11'),
(97, 1, 17, 'ห้วยกะปิ', NULL, NULL, '2016-11-26 11:43:11', '2016-11-26 11:43:11'),
(98, 1, 17, 'หนองสมอ', NULL, NULL, '2016-11-26 11:43:11', '2016-11-26 11:43:11'),
(99, 1, 17, 'ซากพุดซา', NULL, NULL, '2016-11-26 11:43:11', '2016-11-26 11:43:11'),
(100, 1, 17, 'หนองกระเสริม', NULL, NULL, '2016-11-26 11:43:11', '2016-11-26 11:43:11'),
(101, 1, 17, 'ไร่ไหหลำ', NULL, NULL, '2016-11-26 11:43:11', '2016-11-26 11:43:11'),
(102, 1, 17, 'มาบหวาย', NULL, NULL, '2016-11-26 11:43:11', '2016-11-26 11:43:11'),
(103, 1, 18, 'อ่างศิลา', NULL, NULL, '2016-11-26 11:43:54', '2016-11-26 11:43:54'),
(104, 1, 18, 'มะเกลือ', NULL, NULL, '2016-11-26 11:43:54', '2016-11-26 11:43:54'),
(105, 1, 18, 'โพรง', NULL, NULL, '2016-11-26 11:43:54', '2016-11-26 11:43:54'),
(106, 1, 18, 'โรงหาด', NULL, NULL, '2016-11-26 11:43:54', '2016-11-26 11:43:54'),
(107, 1, 18, 'โรงหาด', NULL, NULL, '2016-11-26 11:43:54', '2016-11-26 11:43:54'),
(108, 2, 19, 'ท่าเทววงษ์', NULL, NULL, '2016-11-26 11:44:50', '2016-11-26 11:44:50'),
(109, 2, 19, 'ศาลเจ้าเก๋ง', NULL, NULL, '2016-11-26 11:44:50', '2016-11-26 11:44:50'),
(110, 2, 19, 'ท่าวัง', NULL, NULL, '2016-11-26 11:44:50', '2016-11-26 11:44:50'),
(111, 2, 19, 'ตรอกด่านภาษี', NULL, NULL, '2016-11-26 11:44:50', '2016-11-26 11:44:50'),
(112, 2, 19, 'สะพานคู่', NULL, NULL, '2016-11-26 11:44:50', '2016-11-26 11:44:50'),
(113, 2, 19, 'ท่าภาณุรังษี', NULL, NULL, '2016-11-26 11:44:50', '2016-11-26 11:44:50'),
(114, 2, 19, 'เกาะขามใหญ่', NULL, NULL, '2016-11-26 11:44:50', '2016-11-26 11:44:50'),
(115, 3, 20, 'ธรรมรัตน์', NULL, NULL, '2016-11-26 11:47:01', '2016-11-26 11:47:01'),
(116, 3, 20, 'ขุนชำนาญ', NULL, NULL, '2016-11-26 11:47:01', '2016-11-26 11:47:01'),
(117, 3, 20, 'อ่างกระพงศ์', NULL, NULL, '2016-11-26 11:47:01', '2016-11-26 11:47:01'),
(118, 3, 20, 'บึงเจริญ', NULL, NULL, '2016-11-26 11:47:01', '2016-11-26 11:47:01'),
(119, 3, 20, 'คลองปริง', NULL, NULL, '2016-11-26 11:47:01', '2016-11-26 11:47:01'),
(120, 3, 20, 'คลองโค', NULL, NULL, '2016-11-26 11:47:01', '2016-11-26 11:47:01'),
(121, 3, 20, 'ไม้หอม', NULL, NULL, '2016-11-26 11:47:01', '2016-11-26 11:47:01'),
(122, 3, 21, 'เนินหิน', NULL, NULL, '2016-11-26 11:48:22', '2016-11-26 11:48:22'),
(123, 3, 21, 'เนินดินแดน', NULL, NULL, '2016-11-26 11:48:22', '2016-11-26 11:48:22'),
(124, 3, 21, 'โปร่งเกตุ', NULL, NULL, '2016-11-26 11:48:22', '2016-11-26 11:48:22'),
(125, 3, 21, 'บึงตะกู', NULL, NULL, '2016-11-26 11:48:22', '2016-11-26 11:48:22'),
(126, 3, 21, 'คลองมือไทร', NULL, NULL, '2016-11-26 11:48:22', '2016-11-26 11:48:22'),
(127, 3, 21, 'เขากระถิน', NULL, NULL, '2016-11-26 11:48:22', '2016-11-26 11:48:22'),
(128, 3, 21, 'หนองเสือช่อ', NULL, NULL, '2016-11-26 11:48:22', '2016-11-26 11:48:22'),
(129, 3, 21, 'ห้วยซุง', NULL, NULL, '2016-11-26 11:48:22', '2016-11-26 11:48:22'),
(130, 3, 21, 'หนองน้ำขาว', NULL, NULL, '2016-11-26 11:48:22', '2016-11-26 11:48:22'),
(131, 3, 22, 'หนองเสม็ด', NULL, NULL, '2016-11-26 11:49:03', '2016-11-26 11:49:03'),
(132, 3, 22, 'หนองยายเภา', NULL, NULL, '2016-11-26 11:49:03', '2016-11-26 11:49:03'),
(133, 3, 22, 'โปร่งไม้ไร่', NULL, NULL, '2016-11-26 11:49:03', '2016-11-26 11:49:03'),
(134, 3, 22, 'บ่อกวางทอง', NULL, NULL, '2016-11-26 11:49:04', '2016-11-26 11:49:04'),
(135, 3, 22, 'หนองเกตุ', NULL, NULL, '2016-11-26 11:49:04', '2016-11-26 11:49:04'),
(136, 3, 22, 'เนินสูง', NULL, NULL, '2016-11-26 11:49:04', '2016-11-26 11:49:04'),
(137, 3, 22, 'หนองบอน', NULL, NULL, '2016-11-26 11:49:04', '2016-11-26 11:49:04'),
(138, 3, 22, 'สำเภาทอง', NULL, NULL, '2016-11-26 11:49:04', '2016-11-26 11:49:04'),
(139, 3, 23, 'อมพนม', NULL, NULL, '2016-11-26 11:50:06', '2016-11-26 11:50:06'),
(140, 3, 23, 'วังรี', NULL, NULL, '2016-11-26 11:50:06', '2016-11-26 11:50:06'),
(141, 3, 23, 'เขาสามชั้น', NULL, NULL, '2016-11-26 11:50:06', '2016-11-26 11:50:06'),
(142, 3, 23, 'หนองจรเข้', NULL, NULL, '2016-11-26 11:50:06', '2016-11-26 11:50:06'),
(143, 3, 23, 'ทับเจริญ', NULL, NULL, '2016-11-26 11:50:06', '2016-11-26 11:50:06'),
(144, 3, 23, 'ทับสูง', NULL, NULL, '2016-11-26 11:50:06', '2016-11-26 11:50:06'),
(145, 3, 23, 'หนองใหญ่', NULL, NULL, '2016-11-26 11:50:06', '2016-11-26 11:50:06'),
(146, 3, 23, 'คลองใหญ่', NULL, NULL, '2016-11-26 11:50:06', '2016-11-26 11:50:06'),
(147, 3, 23, 'ทับเจ็ก', NULL, NULL, '2016-11-26 11:50:06', '2016-11-26 11:50:06'),
(148, 3, 24, 'เขาห้ายอด', NULL, NULL, '2016-11-26 11:51:43', '2016-11-26 11:51:43'),
(149, 3, 24, 'เขาซะอางค์', NULL, NULL, '2016-11-26 11:51:43', '2016-11-26 11:51:43'),
(150, 3, 24, 'คลองตาเพชร', NULL, NULL, '2016-11-26 11:51:43', '2016-11-26 11:51:43'),
(151, 3, 24, 'เขาใหญ่', NULL, NULL, '2016-11-26 11:51:43', '2016-11-26 11:51:43'),
(152, 3, 24, 'เขาพริก', NULL, NULL, '2016-11-26 11:51:43', '2016-11-26 11:51:43'),
(153, 3, 24, 'อ่างผักหนาม', NULL, NULL, '2016-11-26 11:51:43', '2016-11-26 11:51:43'),
(154, 3, 24, 'หลุมมะนาว', NULL, NULL, '2016-11-26 11:51:43', '2016-11-26 11:51:43'),
(155, 3, 25, 'ซ่อง', NULL, NULL, '2016-11-26 11:52:21', '2016-11-26 11:52:21'),
(156, 3, 25, 'หนองลุมพุก', NULL, NULL, '2016-11-26 11:52:21', '2016-11-26 11:52:21'),
(157, 3, 25, 'ทุ่งศาลา', NULL, NULL, '2016-11-26 11:52:21', '2016-11-26 11:52:21'),
(158, 3, 25, 'ทุ่งน้อย', NULL, NULL, '2016-11-26 11:52:21', '2016-11-26 11:52:21'),
(159, 3, 25, 'คลองโอ่ง', NULL, NULL, '2016-11-26 11:52:21', '2016-11-26 11:52:21'),
(160, 3, 25, 'คลองหลวง', NULL, NULL, '2016-11-26 11:52:21', '2016-11-26 11:52:21'),
(161, 3, 25, 'หนองกระพ้อ', NULL, NULL, '2016-11-26 11:52:21', '2016-11-26 11:52:21'),
(162, 4, 26, 'ห้วยลึก', NULL, NULL, '2016-11-26 11:53:33', '2016-11-26 11:53:33'),
(163, 4, 26, 'มาบข่าหวาน', NULL, NULL, '2016-11-26 11:53:33', '2016-11-26 11:53:33'),
(164, 4, 26, 'หนองยาง', NULL, NULL, '2016-11-26 11:53:34', '2016-11-26 11:53:34'),
(165, 4, 26, 'ห้วยไข่เน่า', NULL, NULL, '2016-11-26 11:53:34', '2016-11-26 11:53:34'),
(166, 4, 26, 'ภูไทร', NULL, NULL, '2016-11-26 11:53:34', '2016-11-26 11:53:34'),
(167, 4, 27, 'หนองน้ำเต้าลอย', NULL, NULL, '2016-11-26 11:54:53', '2016-11-26 11:54:53'),
(168, 4, 27, 'โป่ง', NULL, NULL, '2016-11-26 11:54:53', '2016-11-26 11:54:53'),
(169, 4, 27, 'โป่งล่าง', NULL, NULL, '2016-11-26 11:54:53', '2016-11-26 11:54:53'),
(170, 4, 27, 'มาบประชันล่าง', NULL, NULL, '2016-11-26 11:54:53', '2016-11-26 11:54:53'),
(171, 4, 27, 'มาบประชันบน', NULL, NULL, '2016-11-26 11:54:53', '2016-11-26 11:54:53'),
(172, 4, 27, 'โป่ง', NULL, NULL, '2016-11-26 11:54:53', '2016-11-26 11:54:53'),
(173, 4, 27, 'โป่ง', NULL, NULL, '2016-11-26 11:54:53', '2016-11-26 11:54:53'),
(174, 4, 27, 'สำนักตะแบก', NULL, NULL, '2016-11-26 11:54:53', '2016-11-26 11:54:53'),
(175, 4, 27, 'หนองตาอุ่น', NULL, NULL, '2016-11-26 11:54:54', '2016-11-26 11:54:54'),
(176, 4, 27, 'คลองใหญ่', NULL, NULL, '2016-11-26 11:54:54', '2016-11-26 11:54:54'),
(177, 4, 28, 'สังกะเปี๋ยว', NULL, NULL, '2016-11-26 11:56:18', '2016-11-26 11:56:18'),
(178, 4, 28, 'ตะเคียนเตี้ย', NULL, NULL, '2016-11-26 11:56:18', '2016-11-26 11:56:18'),
(179, 4, 28, 'หนองพลับ', NULL, NULL, '2016-11-26 11:56:18', '2016-11-26 11:56:18'),
(180, 4, 28, 'นาวัง', NULL, NULL, '2016-11-26 11:56:18', '2016-11-26 11:56:18'),
(181, 4, 28, 'โป่งสะเก็ด', NULL, NULL, '2016-11-26 11:56:18', '2016-11-26 11:56:18'),
(182, 4, 30, 'โรงโป๊ะ', NULL, NULL, '2016-11-26 11:57:11', '2016-11-26 11:57:11'),
(183, 4, 30, 'เนินตาเบี่ยง', NULL, NULL, '2016-11-26 11:57:11', '2016-11-26 11:57:11'),
(184, 4, 30, 'โรงโป๊ะ', NULL, NULL, '2016-11-26 11:57:11', '2016-11-26 11:57:11'),
(185, 4, 30, 'บางละมุง', NULL, NULL, '2016-11-26 11:57:12', '2016-11-26 11:57:12'),
(186, 4, 30, 'นากลาง', NULL, NULL, '2016-11-26 11:57:12', '2016-11-26 11:57:12'),
(187, 4, 31, 'หนองปรือ', NULL, NULL, '2016-11-26 11:57:53', '2016-11-26 11:57:53'),
(188, 4, 31, 'กลาง', NULL, NULL, '2016-11-26 11:57:53', '2016-11-26 11:57:53'),
(189, 4, 31, 'ห้วยรวม', NULL, NULL, '2016-11-26 11:57:53', '2016-11-26 11:57:53'),
(190, 4, 31, 'ห้วยตาหนู', NULL, NULL, '2016-11-26 11:57:53', '2016-11-26 11:57:53'),
(191, 4, 31, 'มาบตาโต้', NULL, NULL, '2016-11-26 11:57:53', '2016-11-26 11:57:53'),
(192, 4, 31, 'หนองสมอ', NULL, NULL, '2016-11-26 11:57:53', '2016-11-26 11:57:53'),
(193, 4, 31, 'มาบยายเลีย', NULL, NULL, '2016-11-26 11:57:53', '2016-11-26 11:57:53'),
(194, 4, 31, 'ตาลหมัน', NULL, NULL, '2016-11-26 11:57:53', '2016-11-26 11:57:53'),
(195, 4, 31, 'หนองกระบอก', NULL, NULL, '2016-11-26 11:57:53', '2016-11-26 11:57:53'),
(196, 4, 31, 'เขาน้อย', NULL, NULL, '2016-11-26 11:57:53', '2016-11-26 11:57:53'),
(197, 4, 31, 'หนองใหญ่', NULL, NULL, '2016-11-26 11:57:53', '2016-11-26 11:57:53'),
(198, 4, 31, 'นาเกลือ', NULL, NULL, '2016-11-26 11:57:53', '2016-11-26 11:57:53'),
(199, 4, 31, 'มาบตาโต้', NULL, NULL, '2016-11-26 11:57:53', '2016-11-26 11:57:53'),
(200, 4, 31, 'ทุ่งกลม', NULL, NULL, '2016-11-26 11:57:53', '2016-11-26 11:57:53'),
(201, 4, 32, 'หนองเกตุใหญ่', NULL, NULL, '2016-11-26 11:58:34', '2016-11-26 11:58:34'),
(202, 4, 32, 'หนองปลาไหล', NULL, NULL, '2016-11-26 11:58:34', '2016-11-26 11:58:34'),
(203, 4, 32, 'มาบบอน', NULL, NULL, '2016-11-26 11:58:34', '2016-11-26 11:58:34'),
(204, 4, 32, 'แกรก', NULL, NULL, '2016-11-26 11:58:34', '2016-11-26 11:58:34'),
(205, 4, 32, 'หนองหัวแรด', NULL, NULL, '2016-11-26 11:58:34', '2016-11-26 11:58:34'),
(206, 4, 32, 'หนองเกตุน้อย', NULL, NULL, '2016-11-26 11:58:35', '2016-11-26 11:58:35'),
(207, 4, 32, 'หนองเกตุ', NULL, NULL, '2016-11-26 11:58:35', '2016-11-26 11:58:35'),
(208, 4, 32, 'หนองเกตุใหญ่ใน', NULL, NULL, '2016-11-26 11:58:35', '2016-11-26 11:58:35'),
(209, 4, 32, 'หนองเกตุใหญ่', NULL, NULL, '2016-11-26 11:58:35', '2016-11-26 11:58:35'),
(210, 4, 33, 'ทุ่งคา', NULL, NULL, '2016-11-26 11:59:20', '2016-11-26 11:59:20'),
(211, 4, 33, 'ทุ่งคา', NULL, NULL, '2016-11-26 11:59:20', '2016-11-26 11:59:20'),
(212, 4, 33, 'ห้วยใหญ่', NULL, NULL, '2016-11-26 11:59:20', '2016-11-26 11:59:20'),
(213, 4, 33, 'ชากนอก', NULL, NULL, '2016-11-26 11:59:20', '2016-11-26 11:59:20'),
(214, 4, 33, 'นา', NULL, NULL, '2016-11-26 11:59:20', '2016-11-26 11:59:20'),
(215, 4, 33, 'บึง', NULL, NULL, '2016-11-26 11:59:20', '2016-11-26 11:59:20'),
(216, 4, 33, 'ห้วยขวาง', NULL, NULL, '2016-11-26 11:59:20', '2016-11-26 11:59:20'),
(217, 4, 33, 'ทุ่งละหาน', NULL, NULL, '2016-11-26 11:59:20', '2016-11-26 11:59:20'),
(218, 4, 33, 'เนินทราย', NULL, NULL, '2016-11-26 11:59:20', '2016-11-26 11:59:20'),
(219, 4, 33, 'ชากแง้ว', NULL, NULL, '2016-11-26 11:59:20', '2016-11-26 11:59:20'),
(220, 4, 33, 'มาบฟักทอง', NULL, NULL, '2016-11-26 11:59:21', '2016-11-26 11:59:21'),
(221, 4, 33, 'นอก', NULL, NULL, '2016-11-26 11:59:21', '2016-11-26 11:59:21'),
(222, 4, 33, 'หนองผักกูด', NULL, NULL, '2016-11-26 11:59:21', '2016-11-26 11:59:21'),
(223, 5, 34, 'หัวกุญแจ', NULL, NULL, '2016-11-26 12:06:42', '2016-11-26 12:06:42'),
(224, 5, 34, 'หนองน้ำเขียว', NULL, NULL, '2016-11-26 12:06:42', '2016-11-26 12:06:42'),
(225, 5, 34, 'ท่าน้ำ', NULL, NULL, '2016-11-26 12:06:42', '2016-11-26 12:06:42'),
(226, 5, 34, 'มาบคล้า', NULL, NULL, '2016-11-26 12:06:42', '2016-11-26 12:06:42'),
(227, 5, 34, 'หมื่นจิตต์', NULL, NULL, '2016-11-26 12:06:42', '2016-11-26 12:06:42'),
(228, 5, 34, 'โสม', NULL, NULL, '2016-11-26 12:06:42', '2016-11-26 12:06:42'),
(229, 5, 34, 'มาบลำปิด', NULL, NULL, '2016-11-26 12:06:42', '2016-11-26 12:06:42'),
(230, 5, 34, 'มาบเตย', NULL, NULL, '2016-11-26 12:06:43', '2016-11-26 12:06:43'),
(231, 5, 34, 'หนองกลางดอน', NULL, NULL, '2016-11-26 12:06:43', '2016-11-26 12:06:43'),
(232, 5, 35, 'บึง', NULL, NULL, '2016-11-26 12:09:17', '2016-11-26 12:09:17'),
(233, 5, 35, 'เชิดน้อย', NULL, NULL, '2016-11-26 12:09:17', '2016-11-26 12:09:17'),
(234, 5, 35, 'หนองปลาไหล', NULL, NULL, '2016-11-26 12:09:17', '2016-11-26 12:09:17'),
(235, 5, 35, 'ห้วยมะไฟ', NULL, NULL, '2016-11-26 12:09:17', '2016-11-26 12:09:17'),
(236, 5, 35, 'มาบกรูด', NULL, NULL, '2016-11-26 12:09:17', '2016-11-26 12:09:17'),
(237, 5, 36, 'ยี่กงษี', NULL, NULL, '2016-11-26 12:10:13', '2016-11-26 12:10:13'),
(238, 5, 36, 'มาบไผ่', NULL, NULL, '2016-11-26 12:10:13', '2016-11-26 12:10:13'),
(239, 5, 36, 'เขาแรด', NULL, NULL, '2016-11-26 12:10:13', '2016-11-26 12:10:13'),
(240, 5, 36, 'ไร่กลาง', NULL, NULL, '2016-11-26 12:10:13', '2016-11-26 12:10:13'),
(241, 5, 36, 'ห้วยยาง', NULL, NULL, '2016-11-26 12:10:13', '2016-11-26 12:10:13'),
(242, 5, 36, 'เกาะไม้แหลม', NULL, NULL, '2016-11-26 12:10:13', '2016-11-26 12:10:13'),
(243, 5, 37, 'หนองปรือ', NULL, NULL, '2016-11-26 12:11:22', '2016-11-26 12:11:22'),
(244, 5, 37, 'หินดาษ', NULL, NULL, '2016-11-26 12:11:22', '2016-11-26 12:11:22'),
(245, 5, 37, 'ป่ายุบ', NULL, NULL, '2016-11-26 12:11:22', '2016-11-26 12:11:22'),
(246, 5, 37, 'หนองใหญ่', NULL, NULL, '2016-11-26 12:11:22', '2016-11-26 12:11:22'),
(247, 5, 37, 'หนองไผ่แก้ว', NULL, NULL, '2016-11-26 12:11:22', '2016-11-26 12:11:22'),
(248, 5, 38, 'หนองสำราญ', NULL, NULL, '2016-11-26 12:12:08', '2016-11-26 12:12:08'),
(249, 5, 38, 'หนองซาก', NULL, NULL, '2016-11-26 12:12:08', '2016-11-26 12:12:08'),
(250, 5, 38, 'หนองเขิน', NULL, NULL, '2016-11-26 12:12:08', '2016-11-26 12:12:08'),
(251, 5, 39, 'โป่ง', NULL, NULL, '2016-11-26 12:12:59', '2016-11-26 12:12:59'),
(252, 5, 39, 'หนองซ้ำซาก', NULL, NULL, '2016-11-26 12:12:59', '2016-11-26 12:12:59'),
(253, 5, 39, 'หนองบึง', NULL, NULL, '2016-11-26 12:12:59', '2016-11-26 12:12:59'),
(254, 5, 39, 'เขาดิน', NULL, NULL, '2016-11-26 12:12:59', '2016-11-26 12:12:59'),
(255, 5, 39, 'เขาทุ่งนา', NULL, NULL, '2016-11-26 12:12:59', '2016-11-26 12:12:59'),
(256, 5, 40, 'หนองพยอม', NULL, NULL, '2016-11-26 12:13:41', '2016-11-26 12:13:41'),
(257, 5, 40, 'หนองบอนแดง', NULL, NULL, '2016-11-26 12:13:41', '2016-11-26 12:13:41'),
(258, 5, 40, 'หนองยาง', NULL, NULL, '2016-11-26 12:13:41', '2016-11-26 12:13:41'),
(259, 5, 40, 'วังน้ำคำ', NULL, NULL, '2016-11-26 12:13:41', '2016-11-26 12:13:41'),
(260, 5, 40, 'หนองน้ำขาว', NULL, NULL, '2016-11-26 12:13:41', '2016-11-26 12:13:41'),
(261, 5, 40, 'ทุ่งโปร่ง', NULL, NULL, '2016-11-26 12:13:41', '2016-11-26 12:13:41'),
(262, 5, 40, 'สำนักตอ', NULL, NULL, '2016-11-26 12:13:41', '2016-11-26 12:13:41'),
(263, 5, 41, 'หนองขนุน', NULL, NULL, '2016-11-26 12:14:14', '2016-11-26 12:14:14'),
(264, 5, 41, 'อ่างเวียน', NULL, NULL, '2016-11-26 12:14:14', '2016-11-26 12:14:14'),
(265, 5, 41, 'หนองสรวง', NULL, NULL, '2016-11-26 12:14:14', '2016-11-26 12:14:14'),
(266, 5, 41, 'เนินโมก', NULL, NULL, '2016-11-26 12:14:14', '2016-11-26 12:14:14'),
(267, 5, 41, 'หนองขัน', NULL, NULL, '2016-11-26 12:14:14', '2016-11-26 12:14:14'),
(268, 5, 41, 'ป่าแดง', NULL, NULL, '2016-11-26 12:14:14', '2016-11-26 12:14:14'),
(269, 5, 41, 'หนองวงษ์', NULL, NULL, '2016-11-26 12:14:14', '2016-11-26 12:14:14'),
(270, 5, 41, 'เนินโมก', NULL, NULL, '2016-11-26 12:14:14', '2016-11-26 12:14:14'),
(271, 5, 41, 'ท่อใหญ่', NULL, NULL, '2016-11-26 12:14:14', '2016-11-26 12:14:14'),
(272, 5, 41, 'สามแยกอ่างเกวียน', NULL, NULL, '2016-11-26 12:14:14', '2016-11-26 12:14:14'),
(273, 5, 41, 'บึงไม้แก่น', NULL, NULL, '2016-11-26 12:14:14', '2016-11-26 12:14:14'),
(274, 5, 41, 'หนองชัน', NULL, NULL, '2016-11-26 12:14:14', '2016-11-26 12:14:14'),
(275, 6, 42, 'เกาะลอย', NULL, NULL, '2016-11-26 12:15:46', '2016-11-26 12:15:46'),
(276, 6, 42, 'แคโดด', NULL, NULL, '2016-11-26 12:15:46', '2016-11-26 12:15:46'),
(277, 6, 42, 'ยุคลราษฎรสามัคคี', NULL, NULL, '2016-11-26 12:15:46', '2016-11-26 12:15:46'),
(278, 6, 42, 'ตลาดควาย', NULL, NULL, '2016-11-26 12:15:46', '2016-11-26 12:15:46'),
(279, 6, 42, 'หนองอ้อ', NULL, NULL, '2016-11-26 12:15:46', '2016-11-26 12:15:46'),
(280, 6, 43, 'หัวไผ่', NULL, NULL, '2016-11-26 12:16:46', '2016-11-26 12:16:46'),
(281, 6, 43, 'หนองกระทุ่ม', NULL, NULL, '2016-11-26 12:16:46', '2016-11-26 12:16:46'),
(282, 6, 43, 'โคกขี้หนอน', NULL, NULL, '2016-11-26 12:16:46', '2016-11-26 12:16:46'),
(283, 6, 43, 'โคกชี้หนอน', NULL, NULL, '2016-11-26 12:16:46', '2016-11-26 12:16:46'),
(284, 6, 43, 'เนินไผ่', NULL, NULL, '2016-11-26 12:16:46', '2016-11-26 12:16:46'),
(285, 6, 44, 'หัวไผ่', NULL, NULL, '2016-11-26 12:18:46', '2016-11-26 12:18:46'),
(286, 6, 44, 'หนองกระทุ่ม', NULL, NULL, '2016-11-26 12:18:46', '2016-11-26 12:18:46'),
(287, 6, 44, 'โคกขี้หนอน', NULL, NULL, '2016-11-26 12:18:46', '2016-11-26 12:18:46'),
(288, 6, 44, 'โคกชี้หนอน', NULL, NULL, '2016-11-26 12:18:46', '2016-11-26 12:18:46'),
(289, 6, 44, 'เนินไผ่', NULL, NULL, '2016-11-26 12:18:46', '2016-11-26 12:18:46'),
(290, 6, 45, 'บางหัก', NULL, NULL, '2016-11-26 12:19:10', '2016-11-26 12:19:10'),
(291, 6, 45, 'หนองสองห้อง', NULL, NULL, '2016-11-26 12:19:10', '2016-11-26 12:19:10'),
(292, 6, 45, 'หนองฝาแฝด', NULL, NULL, '2016-11-26 12:19:10', '2016-11-26 12:19:10'),
(293, 6, 45, 'เกาะกลาง', NULL, NULL, '2016-11-26 12:19:10', '2016-11-26 12:19:10'),
(294, 6, 46, 'สัตตพงษ์', NULL, NULL, '2016-11-26 12:20:27', '2016-11-26 12:20:27'),
(295, 6, 46, 'ย่านซื่อ', NULL, NULL, '2016-11-26 12:20:27', '2016-11-26 12:20:27'),
(296, 6, 46, 'เก่าบน', NULL, NULL, '2016-11-26 12:20:27', '2016-11-26 12:20:27'),
(297, 6, 46, 'เก่า', NULL, NULL, '2016-11-26 12:20:27', '2016-11-26 12:20:27'),
(298, 6, 46, 'เก่า', NULL, NULL, '2016-11-26 12:20:27', '2016-11-26 12:20:27'),
(299, 6, 46, 'เก่า', NULL, NULL, '2016-11-26 12:20:27', '2016-11-26 12:20:27'),
(300, 6, 46, 'สัตตพงษ์เหนือ', NULL, NULL, '2016-11-26 12:20:27', '2016-11-26 12:20:27'),
(301, 6, 47, 'เนินตาลเด่น', NULL, NULL, '2016-11-26 12:20:54', '2016-11-26 12:20:54'),
(302, 6, 47, 'ล่าง', NULL, NULL, '2016-11-26 12:20:54', '2016-11-26 12:20:54'),
(303, 6, 47, 'ท่าพลับพลา', NULL, NULL, '2016-11-26 12:20:54', '2016-11-26 12:20:54'),
(304, 6, 47, 'ตลาดใหม่', NULL, NULL, '2016-11-26 12:20:54', '2016-11-26 12:20:54'),
(305, 6, 47, 'เนินสะแก', NULL, NULL, '2016-11-26 12:20:54', '2016-11-26 12:20:54'),
(306, 6, 47, 'ท่าตะกูด', NULL, NULL, '2016-11-26 12:20:54', '2016-11-26 12:20:54'),
(307, 6, 47, 'ตลาดเก่า', NULL, NULL, '2016-11-26 12:20:54', '2016-11-26 12:20:54'),
(308, 6, 47, 'บ้านหลังวัดโคก', NULL, NULL, '2016-11-26 12:20:54', '2016-11-26 12:20:54'),
(309, 6, 47, 'โรงนา', NULL, NULL, '2016-11-26 12:20:54', '2016-11-26 12:20:54'),
(310, 6, 47, 'บน', NULL, NULL, '2016-11-26 12:20:54', '2016-11-26 12:20:54'),
(311, 6, 48, 'มาบโป่ง', NULL, NULL, '2016-11-26 12:21:18', '2016-11-26 12:21:18'),
(312, 6, 48, 'หนองแช่แว่น', NULL, NULL, '2016-11-26 12:21:18', '2016-11-26 12:21:18'),
(313, 6, 48, 'ท้ายเชิด', NULL, NULL, '2016-11-26 12:21:18', '2016-11-26 12:21:18'),
(314, 6, 48, 'หนองกระดี่', NULL, NULL, '2016-11-26 12:21:18', '2016-11-26 12:21:18'),
(315, 6, 48, 'หนองกระทุ่มนอก', NULL, NULL, '2016-11-26 12:21:18', '2016-11-26 12:21:18'),
(316, 6, 48, 'ไร่', NULL, NULL, '2016-11-26 12:21:18', '2016-11-26 12:21:18'),
(317, 6, 48, 'ฟากห้วย', NULL, NULL, '2016-11-26 12:21:18', '2016-11-26 12:21:18'),
(318, 6, 48, 'หนองนกฮูก', NULL, NULL, '2016-11-26 12:21:18', '2016-11-26 12:21:18'),
(319, 6, 48, 'อ้อมแก้ว', NULL, NULL, '2016-11-26 12:21:18', '2016-11-26 12:21:18'),
(320, 6, 48, 'ป่า', NULL, NULL, '2016-11-26 12:21:18', '2016-11-26 12:21:18'),
(321, 6, 49, 'หนองกะขะ', NULL, NULL, '2016-11-26 12:21:52', '2016-11-26 12:21:52'),
(322, 6, 49, 'หนองกระทุ่ม', NULL, NULL, '2016-11-26 12:21:52', '2016-11-26 12:21:52'),
(323, 6, 49, 'หนองกะขะล่าง', NULL, NULL, '2016-11-26 12:21:52', '2016-11-26 12:21:52'),
(324, 6, 49, 'กระโดน', NULL, NULL, '2016-11-26 12:21:52', '2016-11-26 12:21:52'),
(325, 6, 49, 'ปุนเถ้าม้า', NULL, NULL, '2016-11-26 12:21:52', '2016-11-26 12:21:52'),
(326, 6, 50, 'หนองจับอึ่ง', NULL, NULL, '2016-11-26 12:22:18', '2016-11-26 12:22:18'),
(327, 6, 50, 'แสนแสบ', NULL, NULL, '2016-11-26 12:22:18', '2016-11-26 12:22:18'),
(328, 6, 50, 'ตลาดหนองตำลึง', NULL, NULL, '2016-11-26 12:22:18', '2016-11-26 12:22:18'),
(329, 6, 50, 'มะเขือ', NULL, NULL, '2016-11-26 12:22:19', '2016-11-26 12:22:19'),
(330, 6, 50, 'ซอยพัฒนา 3', NULL, NULL, '2016-11-26 12:22:19', '2016-11-26 12:22:19'),
(331, 6, 50, 'บ่อ', NULL, NULL, '2016-11-26 12:22:19', '2016-11-26 12:22:19'),
(332, 6, 50, 'กระบก', NULL, NULL, '2016-11-26 12:22:19', '2016-11-26 12:22:19'),
(333, 6, 50, 'ห้วยตากด้านบน', NULL, NULL, '2016-11-26 12:22:19', '2016-11-26 12:22:19'),
(334, 6, 50, 'ห้วยตากด้านล่าง', NULL, NULL, '2016-11-26 12:22:19', '2016-11-26 12:22:19'),
(335, 6, 51, 'โป่งตามุข', NULL, NULL, '2016-11-26 12:22:59', '2016-11-26 12:22:59'),
(336, 6, 51, 'หนองหงษ์', NULL, NULL, '2016-11-26 12:22:59', '2016-11-26 12:22:59'),
(337, 6, 51, 'กุฎน้ำใส', NULL, NULL, '2016-11-26 12:22:59', '2016-11-26 12:22:59'),
(338, 6, 51, 'หนองกะขะ (บ้านใหม่)', NULL, NULL, '2016-11-26 12:22:59', '2016-11-26 12:22:59'),
(339, 6, 51, 'ห้วยยาง', NULL, NULL, '2016-11-26 12:22:59', '2016-11-26 12:22:59'),
(340, 6, 51, 'หนองกาน้ำ', NULL, NULL, '2016-11-26 12:22:59', '2016-11-26 12:22:59'),
(341, 6, 52, 'เนินถั่ว', NULL, NULL, '2016-11-26 12:23:41', '2016-11-26 12:23:41'),
(342, 6, 52, 'เนินถ่อน', NULL, NULL, '2016-11-26 12:23:41', '2016-11-26 12:23:41'),
(343, 6, 52, 'แหลมแค', NULL, NULL, '2016-11-26 12:23:41', '2016-11-26 12:23:41'),
(344, 6, 52, 'โคกระกา', NULL, NULL, '2016-11-26 12:23:41', '2016-11-26 12:23:41'),
(345, 6, 52, 'หน้าประดู่', NULL, NULL, '2016-11-26 12:23:41', '2016-11-26 12:23:41'),
(346, 7, 53, 'เนินพุด', NULL, NULL, '2016-11-26 12:24:51', '2016-11-26 12:24:51'),
(347, 7, 53, 'โคกเพลาะ', NULL, NULL, '2016-11-26 12:24:51', '2016-11-26 12:24:51'),
(348, 7, 53, 'อ้อขาด', NULL, NULL, '2016-11-26 12:24:51', '2016-11-26 12:24:51'),
(349, 7, 53, 'หมอสอ', NULL, NULL, '2016-11-26 12:24:51', '2016-11-26 12:24:51'),
(350, 7, 53, 'โคกกลุ่ม', NULL, NULL, '2016-11-26 12:24:51', '2016-11-26 12:24:51'),
(351, 7, 53, 'เนินแฝก', NULL, NULL, '2016-11-26 12:24:51', '2016-11-26 12:24:51'),
(352, 7, 53, 'เนินตามาก', NULL, NULL, '2016-11-26 12:24:51', '2016-11-26 12:24:51'),
(353, 7, 53, 'โรงหมู่', NULL, NULL, '2016-11-26 12:24:51', '2016-11-26 12:24:51'),
(354, 7, 54, 'ริมคลอง', NULL, NULL, '2016-11-26 12:27:25', '2016-11-26 12:27:25'),
(355, 7, 54, 'ไร่หลักทอง', NULL, NULL, '2016-11-26 12:27:25', '2016-11-26 12:27:25'),
(356, 7, 54, 'นา', NULL, NULL, '2016-11-26 12:27:25', '2016-11-26 12:27:25'),
(357, 7, 54, 'สวนตาล', NULL, NULL, '2016-11-26 12:27:25', '2016-11-26 12:27:25'),
(358, 7, 54, 'ใน', NULL, NULL, '2016-11-26 12:27:25', '2016-11-26 12:27:25'),
(359, 7, 54, 'กลางคลองหลวง', NULL, NULL, '2016-11-26 12:27:25', '2016-11-26 12:27:25'),
(360, 7, 54, 'นากลาง', NULL, NULL, '2016-11-26 12:27:25', '2016-11-26 12:27:25'),
(361, 7, 54, 'คลองหนองเถร', NULL, NULL, '2016-11-26 12:27:25', '2016-11-26 12:27:25'),
(362, 7, 54, 'ใต้', NULL, NULL, '2016-11-26 12:27:25', '2016-11-26 12:27:25'),
(363, 7, 54, 'เหนือคลองหลวง', NULL, NULL, '2016-11-26 12:27:25', '2016-11-26 12:27:25'),
(364, 7, 54, 'คลองแบ่ง', NULL, NULL, '2016-11-26 12:27:25', '2016-11-26 12:27:25'),
(365, 7, 55, 'ช้าง', NULL, NULL, '2016-11-26 12:28:03', '2016-11-26 12:28:03'),
(366, 7, 55, 'โพธิ์ตาก', NULL, NULL, '2016-11-26 12:28:03', '2016-11-26 12:28:03'),
(367, 7, 55, 'เนินพลับ', NULL, NULL, '2016-11-26 12:28:03', '2016-11-26 12:28:03'),
(368, 7, 55, 'ลิงงอย', NULL, NULL, '2016-11-26 12:28:03', '2016-11-26 12:28:03'),
(369, 7, 55, 'กุฎโง้ง', NULL, NULL, '2016-11-26 12:28:03', '2016-11-26 12:28:03'),
(370, 7, 55, 'นางู', NULL, NULL, '2016-11-26 12:28:03', '2016-11-26 12:28:03'),
(371, 7, 56, 'ท่าข้าม', NULL, NULL, '2016-11-26 12:29:52', '2016-11-26 12:29:52'),
(372, 7, 56, 'สะแกลาย', NULL, NULL, '2016-11-26 12:29:52', '2016-11-26 12:29:52'),
(373, 7, 56, 'ดอนกลุ่ม', NULL, NULL, '2016-11-26 12:29:52', '2016-11-26 12:29:52'),
(374, 7, 56, 'หมอสอ', NULL, NULL, '2016-11-26 12:29:52', '2016-11-26 12:29:52'),
(375, 7, 56, 'มาบใหญ่', NULL, NULL, '2016-11-26 12:29:52', '2016-11-26 12:29:52'),
(376, 7, 56, 'ไผ่แถว', NULL, NULL, '2016-11-26 12:29:52', '2016-11-26 12:29:52'),
(377, 7, 56, 'หัวไผ่', NULL, NULL, '2016-11-26 12:29:52', '2016-11-26 12:29:52'),
(378, 7, 57, 'ใหม่', NULL, NULL, '2016-11-26 12:30:31', '2016-11-26 12:30:31'),
(379, 7, 57, 'หนองกระดูกควาย', NULL, NULL, '2016-11-26 12:30:31', '2016-11-26 12:30:31'),
(380, 7, 57, 'หนองศาลา', NULL, NULL, '2016-11-26 12:30:31', '2016-11-26 12:30:31'),
(381, 7, 57, 'นาตาทอก', NULL, NULL, '2016-11-26 12:30:31', '2016-11-26 12:30:31'),
(382, 7, 57, 'หนองกุมภัณฑ์', NULL, NULL, '2016-11-26 12:30:31', '2016-11-26 12:30:31'),
(383, 7, 57, 'หนองหัวหมู', NULL, NULL, '2016-11-26 12:30:31', '2016-11-26 12:30:31'),
(384, 7, 57, 'ทุ่งขวาง', NULL, NULL, '2016-11-26 12:30:31', '2016-11-26 12:30:31'),
(385, 7, 57, 'นากระรอก', NULL, NULL, '2016-11-26 12:30:31', '2016-11-26 12:30:31'),
(386, 7, 57, 'หนองปรือ', NULL, NULL, '2016-11-26 12:30:32', '2016-11-26 12:30:32'),
(387, 7, 57, 'หนองซองแมว', NULL, NULL, '2016-11-26 12:30:32', '2016-11-26 12:30:32'),
(388, 7, 58, 'ดอนไร่', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(389, 7, 58, 'เนินสำโรง', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(390, 7, 58, 'หนองกะพง', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(391, 7, 58, 'เนิน', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(392, 7, 58, 'หนองผักปอด', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(393, 7, 58, 'ยาง', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(394, 7, 58, 'เนินค้า', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(395, 7, 58, 'ดอนกอด', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(396, 7, 58, 'เนินไทร', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(397, 7, 58, 'เนินแร่', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(398, 7, 58, 'หนองปลาไหล', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(399, 7, 58, 'เกาะกลาง', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(400, 7, 58, 'หนองโมกข์', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(401, 7, 58, 'หนองโคลน', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(402, 7, 58, 'หนองแก', NULL, NULL, '2016-11-26 12:30:56', '2016-11-26 12:30:56'),
(403, 7, 59, 'เนินไร่หลวง', NULL, NULL, '2016-11-26 12:31:31', '2016-11-26 12:31:31'),
(404, 7, 59, 'ล่าง', NULL, NULL, '2016-11-26 12:31:31', '2016-11-26 12:31:31'),
(405, 7, 59, 'เนินมะกอก', NULL, NULL, '2016-11-26 12:31:31', '2016-11-26 12:31:31'),
(406, 7, 59, 'โป่งแดงห้วยสูบ', NULL, NULL, '2016-11-26 12:31:31', '2016-11-26 12:31:31'),
(407, 7, 59, 'ท่าโพธิ์', NULL, NULL, '2016-11-26 12:31:31', '2016-11-26 12:31:31'),
(408, 7, 59, 'นามะตูม', NULL, NULL, '2016-11-26 12:31:31', '2016-11-26 12:31:31'),
(409, 7, 59, 'เนินหลังเต่า', NULL, NULL, '2016-11-26 12:31:31', '2016-11-26 12:31:31'),
(410, 7, 60, 'นาวังหิน', NULL, NULL, '2016-11-26 12:32:02', '2016-11-26 12:32:02'),
(411, 7, 60, 'ยางเอน', NULL, NULL, '2016-11-26 12:32:02', '2016-11-26 12:32:02'),
(412, 7, 60, 'ทุ่งแฝก', NULL, NULL, '2016-11-26 12:32:02', '2016-11-26 12:32:02'),
(413, 7, 60, 'อีโค้', NULL, NULL, '2016-11-26 12:32:02', '2016-11-26 12:32:02'),
(414, 7, 60, 'สระนา', NULL, NULL, '2016-11-26 12:32:02', '2016-11-26 12:32:02'),
(415, 7, 60, 'โป่งเอือด', NULL, NULL, '2016-11-26 12:32:02', '2016-11-26 12:32:02'),
(416, 7, 60, 'สวนกล้วย', NULL, NULL, '2016-11-26 12:32:02', '2016-11-26 12:32:02'),
(417, 7, 60, 'หนองครก', NULL, NULL, '2016-11-26 12:32:02', '2016-11-26 12:32:02'),
(418, 7, 60, 'นา', NULL, NULL, '2016-11-26 12:32:02', '2016-11-26 12:32:02'),
(419, 7, 60, 'น้ำซับ', NULL, NULL, '2016-11-26 12:32:02', '2016-11-26 12:32:02'),
(420, 7, 60, 'หนองสองห้อง', NULL, NULL, '2016-11-26 12:32:02', '2016-11-26 12:32:02'),
(421, 7, 61, 'โดน', NULL, NULL, '2016-11-26 12:32:31', '2016-11-26 12:32:31'),
(422, 7, 61, 'ส่วนป่านตะวันออก', NULL, NULL, '2016-11-26 12:32:31', '2016-11-26 12:32:31'),
(423, 7, 61, 'ส่วนป่าน', NULL, NULL, '2016-11-26 12:32:31', '2016-11-26 12:32:31'),
(424, 7, 61, 'ปอ', NULL, NULL, '2016-11-26 12:32:31', '2016-11-26 12:32:31'),
(425, 7, 61, 'ศาลา', NULL, NULL, '2016-11-26 12:32:32', '2016-11-26 12:32:32'),
(426, 7, 61, 'สวนหมาก', NULL, NULL, '2016-11-26 12:32:32', '2016-11-26 12:32:32'),
(427, 7, 61, 'ไผ่ล้อม', NULL, NULL, '2016-11-26 12:32:32', '2016-11-26 12:32:32'),
(428, 7, 61, 'โพธิ์งาม', NULL, NULL, '2016-11-26 12:32:32', '2016-11-26 12:32:32'),
(429, 7, 62, 'หนองพลับ', NULL, NULL, '2016-11-26 12:32:58', '2016-11-26 12:32:58'),
(430, 7, 62, 'เตาเหล็ก', NULL, NULL, '2016-11-26 12:32:58', '2016-11-26 12:32:58'),
(431, 7, 62, 'เหล่าบน', NULL, NULL, '2016-11-26 12:32:59', '2016-11-26 12:32:59'),
(432, 7, 62, 'เนินดินแดง', NULL, NULL, '2016-11-26 12:32:59', '2016-11-26 12:32:59'),
(433, 7, 62, 'ป่าไร่', NULL, NULL, '2016-11-26 12:32:59', '2016-11-26 12:32:59'),
(434, 7, 62, 'สวนผัก', NULL, NULL, '2016-11-26 12:32:59', '2016-11-26 12:32:59'),
(435, 7, 62, 'เหล่าใต้', NULL, NULL, '2016-11-26 12:32:59', '2016-11-26 12:32:59'),
(436, 7, 63, 'หนองพลับ', NULL, NULL, '2016-11-26 12:33:34', '2016-11-26 12:33:34'),
(437, 7, 64, 'วัดโบสถ์', NULL, NULL, '2016-11-26 12:34:03', '2016-11-26 12:34:03'),
(438, 7, 64, 'คลองกว้าง', NULL, NULL, '2016-11-26 12:34:03', '2016-11-26 12:34:03'),
(439, 7, 64, 'ดอนทอง', NULL, NULL, '2016-11-26 12:34:03', '2016-11-26 12:34:03'),
(440, 7, 64, 'คลองกว้าง', NULL, NULL, '2016-11-26 12:34:03', '2016-11-26 12:34:03'),
(441, 7, 64, 'โคกสำราญ', NULL, NULL, '2016-11-26 12:34:03', '2016-11-26 12:34:03'),
(442, 7, 64, 'วัดโบสถ์', NULL, NULL, '2016-11-26 12:34:03', '2016-11-26 12:34:03'),
(443, 7, 64, 'เนินตั้ว', NULL, NULL, '2016-11-26 12:34:03', '2016-11-26 12:34:03'),
(444, 7, 64, 'ศาลาแดง', NULL, NULL, '2016-11-26 12:34:03', '2016-11-26 12:34:03'),
(445, 7, 64, 'คลองสะพาน', NULL, NULL, '2016-11-26 12:34:03', '2016-11-26 12:34:03'),
(446, 7, 64, 'ท้ายบ้าน', NULL, NULL, '2016-11-26 12:34:03', '2016-11-26 12:34:03'),
(447, 7, 64, 'โคกสำราญ', NULL, NULL, '2016-11-26 12:34:03', '2016-11-26 12:34:03'),
(448, 7, 65, 'คลองนอกทุ่ง', NULL, NULL, '2016-11-26 12:34:33', '2016-11-26 12:34:33'),
(449, 7, 65, 'ต้นโพธิ์', NULL, NULL, '2016-11-26 12:34:33', '2016-11-26 12:34:33'),
(450, 7, 65, 'ไร่ยายชี', NULL, NULL, '2016-11-26 12:34:33', '2016-11-26 12:34:33'),
(451, 7, 65, 'หัวโขด', NULL, NULL, '2016-11-26 12:34:33', '2016-11-26 12:34:33'),
(452, 7, 65, 'ดอนพระพราหมณ์', NULL, NULL, '2016-11-26 12:34:33', '2016-11-26 12:34:33'),
(453, 7, 65, 'ดอนตาอุ้ย', NULL, NULL, '2016-11-26 12:34:33', '2016-11-26 12:34:33'),
(454, 7, 65, 'ดอนสะแก', NULL, NULL, '2016-11-26 12:34:33', '2016-11-26 12:34:33'),
(455, 7, 66, 'ใน', NULL, NULL, '2016-11-26 12:35:14', '2016-11-26 12:35:14'),
(456, 7, 66, 'นอก', NULL, NULL, '2016-11-26 12:35:14', '2016-11-26 12:35:14'),
(457, 7, 66, 'หินดาด', NULL, NULL, '2016-11-26 12:35:14', '2016-11-26 12:35:14'),
(458, 7, 66, 'เนินแพง', NULL, NULL, '2016-11-26 12:35:14', '2016-11-26 12:35:14'),
(459, 7, 66, 'หนองขวาง', NULL, NULL, '2016-11-26 12:35:14', '2016-11-26 12:35:14'),
(460, 7, 66, 'ตม', NULL, NULL, '2016-11-26 12:35:14', '2016-11-26 12:35:14'),
(461, 7, 66, 'ไร่', NULL, NULL, '2016-11-26 12:35:14', '2016-11-26 12:35:14'),
(462, 7, 66, 'ในไร่', NULL, NULL, '2016-11-26 12:35:14', '2016-11-26 12:35:14'),
(463, 7, 66, 'โคก', NULL, NULL, '2016-11-26 12:35:14', '2016-11-26 12:35:14'),
(464, 7, 66, 'ไร่บน', NULL, NULL, '2016-11-26 12:35:14', '2016-11-26 12:35:14'),
(465, 7, 66, 'เขาดินวังตาสี', NULL, NULL, '2016-11-26 12:35:14', '2016-11-26 12:35:14'),
(466, 7, 67, 'หนองเหียง', NULL, NULL, '2016-11-26 12:35:37', '2016-11-26 12:35:37'),
(467, 7, 67, 'หนองสำโรง', NULL, NULL, '2016-11-26 12:35:37', '2016-11-26 12:35:37'),
(468, 7, 67, 'หนองประดู่', NULL, NULL, '2016-11-26 12:35:37', '2016-11-26 12:35:37'),
(469, 7, 67, 'แปลงเกตุ', NULL, NULL, '2016-11-26 12:35:37', '2016-11-26 12:35:37'),
(470, 7, 67, 'หนองยาง', NULL, NULL, '2016-11-26 12:35:37', '2016-11-26 12:35:37'),
(471, 7, 67, 'โพธิ์สำเภา', NULL, NULL, '2016-11-26 12:35:37', '2016-11-26 12:35:37'),
(472, 7, 67, 'หนองตามิตร', NULL, NULL, '2016-11-26 12:35:37', '2016-11-26 12:35:37'),
(473, 7, 67, 'หนองข่า', NULL, NULL, '2016-11-26 12:35:37', '2016-11-26 12:35:37'),
(474, 7, 67, 'สระคลอง', NULL, NULL, '2016-11-26 12:35:38', '2016-11-26 12:35:38'),
(475, 7, 67, 'หนองไผ่แก้ว', NULL, NULL, '2016-11-26 12:35:38', '2016-11-26 12:35:38'),
(476, 7, 67, 'เนินหิน', NULL, NULL, '2016-11-26 12:35:38', '2016-11-26 12:35:38'),
(477, 7, 67, 'หนองสังข์', NULL, NULL, '2016-11-26 12:35:38', '2016-11-26 12:35:38'),
(478, 7, 67, 'ไร่เสธ์', NULL, NULL, '2016-11-26 12:35:38', '2016-11-26 12:35:38'),
(479, 7, 67, 'เขาอำนวยสุข', NULL, NULL, '2016-11-26 12:35:38', '2016-11-26 12:35:38'),
(480, 7, 67, 'หนองเม็ก', NULL, NULL, '2016-11-26 12:35:38', '2016-11-26 12:35:38'),
(481, 7, 67, 'แปลงเสือครูด', NULL, NULL, '2016-11-26 12:35:38', '2016-11-26 12:35:38'),
(482, 7, 68, 'หนองโสน', NULL, NULL, '2016-11-26 12:36:06', '2016-11-26 12:36:06'),
(483, 7, 68, 'หนองช้าง', NULL, NULL, '2016-11-26 12:36:06', '2016-11-26 12:36:06'),
(484, 7, 68, 'หนองขนวน', NULL, NULL, '2016-11-26 12:36:06', '2016-11-26 12:36:06'),
(485, 7, 68, 'หนองโคลน', NULL, NULL, '2016-11-26 12:36:06', '2016-11-26 12:36:06'),
(486, 7, 68, 'หนองม่วงใหม่', NULL, NULL, '2016-11-26 12:36:06', '2016-11-26 12:36:06'),
(487, 7, 68, 'หนองม่วงเก่า', NULL, NULL, '2016-11-26 12:36:06', '2016-11-26 12:36:06'),
(488, 7, 68, 'หนองขยาด', NULL, NULL, '2016-11-26 12:36:06', '2016-11-26 12:36:06'),
(489, 7, 68, 'หนองเหียง', NULL, NULL, '2016-11-26 12:36:06', '2016-11-26 12:36:06'),
(490, 7, 69, 'หนองปรือ', NULL, NULL, '2016-11-26 12:36:34', '2016-11-26 12:36:34'),
(491, 7, 69, 'ทรงธรรม', NULL, NULL, '2016-11-26 12:36:34', '2016-11-26 12:36:34'),
(492, 7, 69, 'เกาะกลาง', NULL, NULL, '2016-11-26 12:36:34', '2016-11-26 12:36:34'),
(493, 7, 69, 'เกาะกระบก', NULL, NULL, '2016-11-26 12:36:34', '2016-11-26 12:36:34'),
(494, 7, 69, 'เหนือบ่อกรุ', NULL, NULL, '2016-11-26 12:36:34', '2016-11-26 12:36:34'),
(495, 7, 69, 'เนินตูม', NULL, NULL, '2016-11-26 12:36:34', '2016-11-26 12:36:34'),
(496, 7, 69, 'หนองไผ่', NULL, NULL, '2016-11-26 12:36:34', '2016-11-26 12:36:34'),
(497, 7, 69, 'หนองไก่เถื่อน', NULL, NULL, '2016-11-26 12:36:34', '2016-11-26 12:36:34'),
(498, 7, 69, 'ทรายมูล', NULL, NULL, '2016-11-26 12:36:34', '2016-11-26 12:36:34'),
(499, 7, 69, 'หนองเซ่ง', NULL, NULL, '2016-11-26 12:36:34', '2016-11-26 12:36:34'),
(500, 7, 70, 'ไร่', NULL, NULL, '2016-11-26 12:37:07', '2016-11-26 12:37:07'),
(501, 7, 70, 'กลาง', NULL, NULL, '2016-11-26 12:37:07', '2016-11-26 12:37:07'),
(502, 7, 70, 'ใหม่', NULL, NULL, '2016-11-26 12:37:07', '2016-11-26 12:37:07'),
(503, 7, 70, 'โก่ย', NULL, NULL, '2016-11-26 12:37:07', '2016-11-26 12:37:07'),
(504, 7, 70, 'บ่อขิง', NULL, NULL, '2016-11-26 12:37:07', '2016-11-26 12:37:07'),
(505, 7, 70, 'เชิงเนิน', NULL, NULL, '2016-11-26 12:37:07', '2016-11-26 12:37:07'),
(506, 7, 70, 'บ่อขิงใต้', NULL, NULL, '2016-11-26 12:37:07', '2016-11-26 12:37:07'),
(507, 7, 70, 'หนองจอก', NULL, NULL, '2016-11-26 12:37:07', '2016-11-26 12:37:07'),
(508, 7, 70, 'โคก', NULL, NULL, '2016-11-26 12:37:07', '2016-11-26 12:37:07'),
(509, 7, 70, 'ปอ', NULL, NULL, '2016-11-26 12:37:07', '2016-11-26 12:37:07'),
(510, 7, 70, 'กลาง', NULL, NULL, '2016-11-26 12:37:07', '2016-11-26 12:37:07'),
(511, 7, 71, 'สวนใหม่', NULL, NULL, '2016-11-26 12:39:00', '2016-11-26 12:39:00'),
(512, 7, 71, 'หนองไทร', NULL, NULL, '2016-11-26 12:39:00', '2016-11-26 12:39:00'),
(513, 7, 71, 'หนองพร้าว', NULL, NULL, '2016-11-26 12:39:00', '2016-11-26 12:39:00'),
(514, 7, 71, 'ทุ่งเหียง', NULL, NULL, '2016-11-26 12:39:00', '2016-11-26 12:39:00'),
(515, 7, 71, 'เหนือ', NULL, NULL, '2016-11-26 12:39:00', '2016-11-26 12:39:00'),
(516, 7, 71, 'หนองยาง', NULL, NULL, '2016-11-26 12:39:00', '2016-11-26 12:39:00'),
(517, 7, 71, 'ดอนกระบาก', NULL, NULL, '2016-11-26 12:39:00', '2016-11-26 12:39:00'),
(518, 7, 71, 'ดงไม้ลาย', NULL, NULL, '2016-11-26 12:39:00', '2016-11-26 12:39:00'),
(519, 7, 71, 'หมอนนาง', NULL, NULL, '2016-11-26 12:39:00', '2016-11-26 12:39:00'),
(520, 7, 71, 'ชุมแสง', NULL, NULL, '2016-11-26 12:39:00', '2016-11-26 12:39:00'),
(521, 7, 71, 'หนองผักบุ้งขัน', NULL, NULL, '2016-11-26 12:39:00', '2016-11-26 12:39:00'),
(522, 7, 71, 'หนองแหน', NULL, NULL, '2016-11-26 12:39:00', '2016-11-26 12:39:00'),
(523, 7, 72, 'กลาง', NULL, NULL, '2016-11-26 12:39:27', '2016-11-26 12:39:27'),
(524, 7, 72, 'หนองบก', NULL, NULL, '2016-11-26 12:39:27', '2016-11-26 12:39:27'),
(525, 7, 72, 'แหลมเขา', NULL, NULL, '2016-11-26 12:39:27', '2016-11-26 12:39:27'),
(526, 7, 72, 'กลางในตลาด', NULL, NULL, '2016-11-26 12:39:27', '2016-11-26 12:39:27'),
(527, 7, 72, 'หนองคู', NULL, NULL, '2016-11-26 12:39:27', '2016-11-26 12:39:27'),
(528, 7, 72, 'หนองคู', NULL, NULL, '2016-11-26 12:39:27', '2016-11-26 12:39:27'),
(529, 7, 72, 'ใต้', NULL, NULL, '2016-11-26 12:39:27', '2016-11-26 12:39:27'),
(530, 7, 72, 'ป่าแก้ว', NULL, NULL, '2016-11-26 12:39:27', '2016-11-26 12:39:27'),
(531, 7, 72, 'แปลงกระถิน', NULL, NULL, '2016-11-26 12:39:27', '2016-11-26 12:39:27'),
(532, 8, 73, 'หุบบอน', NULL, NULL, '2016-11-26 12:41:07', '2016-11-26 12:41:07'),
(533, 8, 73, 'ศิริอนุสรณ์', NULL, NULL, '2016-11-26 12:41:07', '2016-11-26 12:41:07'),
(534, 8, 73, 'มาบเอียง', NULL, NULL, '2016-11-26 12:41:07', '2016-11-26 12:41:07'),
(535, 8, 73, 'เขาคันทรง', NULL, NULL, '2016-11-26 12:41:07', '2016-11-26 12:41:07'),
(536, 8, 73, 'สุรศักดิ์มนตรี', NULL, NULL, '2016-11-26 12:41:07', '2016-11-26 12:41:07'),
(537, 8, 73, 'เขาช่องลม', NULL, NULL, '2016-11-26 12:41:07', '2016-11-26 12:41:07'),
(538, 8, 73, 'ระเวิง', NULL, NULL, '2016-11-26 12:41:07', '2016-11-26 12:41:07'),
(539, 8, 73, 'มาบแสนสุข', NULL, NULL, '2016-11-26 12:41:07', '2016-11-26 12:41:07'),
(540, 8, 73, 'ห้วยตาเกล้า', NULL, NULL, '2016-11-26 12:41:07', '2016-11-26 12:41:07'),
(541, 8, 73, 'เจ้าพระยา', NULL, NULL, '2016-11-26 12:41:07', '2016-11-26 12:41:07'),
(542, 8, 75, 'ห้วยเหียน', NULL, NULL, '2016-11-26 12:42:01', '2016-11-26 12:42:01'),
(543, 8, 75, 'ยางเอน', NULL, NULL, '2016-11-26 12:42:01', '2016-11-26 12:42:01'),
(544, 8, 75, 'บ่อวิน', NULL, NULL, '2016-11-26 12:42:01', '2016-11-26 12:42:01'),
(545, 8, 75, 'พันเสด็จ', NULL, NULL, '2016-11-26 12:42:01', '2016-11-26 12:42:01'),
(546, 8, 75, 'เขาขยาย', NULL, NULL, '2016-11-26 12:42:01', '2016-11-26 12:42:01'),
(547, 8, 75, 'เขาหิน', NULL, NULL, '2016-11-26 12:42:01', '2016-11-26 12:42:01'),
(548, 8, 75, 'เขาก้างปลา', NULL, NULL, '2016-11-26 12:42:01', '2016-11-26 12:42:01'),
(549, 8, 75, 'มาบเสมอ', NULL, NULL, '2016-11-26 12:42:01', '2016-11-26 12:42:01'),
(550, 8, 76, 'ท้ายบ้าน', NULL, NULL, '2016-11-26 12:42:31', '2016-11-26 12:42:31'),
(551, 8, 76, 'ตลาดใหม่', NULL, NULL, '2016-11-26 12:42:31', '2016-11-26 12:42:31'),
(552, 8, 76, 'บางพระ', NULL, NULL, '2016-11-26 12:42:31', '2016-11-26 12:42:31'),
(553, 8, 76, 'เอสอาร์', NULL, NULL, '2016-11-26 12:42:31', '2016-11-26 12:42:31'),
(554, 8, 76, 'ห้วยกุ่ม', NULL, NULL, '2016-11-26 12:42:31', '2016-11-26 12:42:31'),
(555, 8, 76, 'ทุ่งนาพรุ', NULL, NULL, '2016-11-26 12:42:31', '2016-11-26 12:42:31'),
(556, 8, 76, 'ห้วยกรุ', NULL, NULL, '2016-11-26 12:42:31', '2016-11-26 12:42:31'),
(557, 8, 76, 'ทางตรง', NULL, NULL, '2016-11-26 12:42:31', '2016-11-26 12:42:31'),
(558, 8, 76, 'ไร่ดินแดง', NULL, NULL, '2016-11-26 12:42:31', '2016-11-26 12:42:31'),
(559, 8, 76, 'หินเพลิง', NULL, NULL, '2016-11-26 12:42:31', '2016-11-26 12:42:31'),
(560, 8, 76, 'หนองข่า', NULL, NULL, '2016-11-26 12:42:31', '2016-11-26 12:42:31'),
(561, 8, 76, 'โป่งดินดำ', NULL, NULL, '2016-11-26 12:42:31', '2016-11-26 12:42:31'),
(562, 8, 77, 'จุกเฌอ', NULL, NULL, '2016-11-26 12:43:13', '2016-11-26 12:43:13'),
(563, 8, 77, 'หนองปรือ', NULL, NULL, '2016-11-26 12:43:13', '2016-11-26 12:43:13'),
(564, 8, 77, 'ตลาดบึง', NULL, NULL, '2016-11-26 12:43:13', '2016-11-26 12:43:13'),
(565, 8, 77, 'หนองแขวะ', NULL, NULL, '2016-11-26 12:43:13', '2016-11-26 12:43:13'),
(566, 8, 77, 'ไร่หนึ่ง', NULL, NULL, '2016-11-26 12:43:13', '2016-11-26 12:43:13'),
(567, 8, 77, 'ด้านสี่', NULL, NULL, '2016-11-26 12:43:13', '2016-11-26 12:43:13'),
(568, 8, 77, 'ตลาดบึงบน', NULL, NULL, '2016-11-26 12:43:13', '2016-11-26 12:43:13'),
(569, 8, 77, 'ตลาดบึงฝั่งใต้', NULL, NULL, '2016-11-26 12:43:13', '2016-11-26 12:43:13'),
(570, 8, 77, 'บนเนิน', NULL, NULL, '2016-11-26 12:43:13', '2016-11-26 12:43:13'),
(571, 8, 79, 'ห้วยยายพรหม', NULL, NULL, '2016-11-26 12:44:45', '2016-11-26 12:44:45'),
(572, 8, 79, 'ไร่กล้วย', NULL, NULL, '2016-11-26 12:44:45', '2016-11-26 12:44:45'),
(573, 8, 79, 'หัวคันทด', NULL, NULL, '2016-11-26 12:44:45', '2016-11-26 12:44:45'),
(574, 8, 79, 'ไร่', NULL, NULL, '2016-11-26 12:44:45', '2016-11-26 12:44:45'),
(575, 8, 79, 'นาพร้าว', NULL, NULL, '2016-11-26 12:44:45', '2016-11-26 12:44:45'),
(576, 8, 79, 'เขาน้อย', NULL, NULL, '2016-11-26 12:44:45', '2016-11-26 12:44:45'),
(577, 8, 79, 'ซากค้อ', NULL, NULL, '2016-11-26 12:44:45', '2016-11-26 12:44:45'),
(578, 8, 79, 'หัวโกรก', NULL, NULL, '2016-11-26 12:44:45', '2016-11-26 12:44:45'),
(579, 8, 79, 'บ่อยาง', NULL, NULL, '2016-11-26 12:44:45', '2016-11-26 12:44:45'),
(580, 8, 79, 'บุญปราโมทย์', NULL, NULL, '2016-11-26 12:44:45', '2016-11-26 12:44:45'),
(581, 8, 80, 'หนองขาม', NULL, NULL, '2016-11-26 12:46:01', '2016-11-26 12:46:01'),
(582, 8, 80, 'หนองฆ้อ', NULL, NULL, '2016-11-26 12:46:01', '2016-11-26 12:46:01'),
(583, 8, 80, 'เขาดิน', NULL, NULL, '2016-11-26 12:46:01', '2016-11-26 12:46:01'),
(584, 8, 80, 'เขาตะแบก', NULL, NULL, '2016-11-26 12:46:01', '2016-11-26 12:46:01'),
(585, 8, 80, 'บ่อหิน', NULL, NULL, '2016-11-26 12:46:01', '2016-11-26 12:46:01'),
(586, 8, 80, 'โค้งดารา', NULL, NULL, '2016-11-26 12:46:01', '2016-11-26 12:46:01'),
(587, 8, 80, 'เนินแสนสุข', NULL, NULL, '2016-11-26 12:46:01', '2016-11-26 12:46:01'),
(588, 8, 80, 'หินกอง', NULL, NULL, '2016-11-26 12:46:01', '2016-11-26 12:46:01'),
(589, 8, 80, 'เนินตอง', NULL, NULL, '2016-11-26 12:46:01', '2016-11-26 12:46:01'),
(590, 8, 80, 'หนองยายบู่', NULL, NULL, '2016-11-26 12:46:01', '2016-11-26 12:46:01'),
(591, 8, 80, 'หนองเลง', NULL, NULL, '2016-11-26 12:46:01', '2016-11-26 12:46:01'),
(592, 8, 81, 'ช่องแสมสาร', NULL, NULL, '2016-11-26 12:46:40', '2016-11-26 12:46:40'),
(593, 8, 81, 'หนองน้ำเค็ม', NULL, NULL, '2016-11-26 12:46:40', '2016-11-26 12:46:40'),
(594, 8, 81, 'หัวแหลม', NULL, NULL, '2016-11-26 12:46:40', '2016-11-26 12:46:40'),
(595, 8, 81, 'หนองกระจง', NULL, NULL, '2016-11-26 12:46:40', '2016-11-26 12:46:40'),
(596, 8, 82, 'นาจอมเทียน', NULL, NULL, '2016-11-26 12:47:56', '2016-11-26 12:47:56'),
(597, 8, 82, 'น้ำเมา', NULL, NULL, '2016-11-26 12:47:56', '2016-11-26 12:47:56'),
(598, 8, 82, 'หินวง', NULL, NULL, '2016-11-26 12:47:57', '2016-11-26 12:47:57'),
(599, 8, 82, 'อำเภอ', NULL, NULL, '2016-11-26 12:47:57', '2016-11-26 12:47:57'),
(600, 8, 82, 'หนองจับเต่า', NULL, NULL, '2016-11-26 12:47:57', '2016-11-26 12:47:57'),
(601, 8, 82, 'โรงสี', NULL, NULL, '2016-11-26 12:47:57', '2016-11-26 12:47:57'),
(602, 8, 82, 'เขาชีจันทร์', NULL, NULL, '2016-11-26 12:47:57', '2016-11-26 12:47:57'),
(603, 8, 82, 'วัดเขาบำเพ็ญบุญ', NULL, NULL, '2016-11-26 12:47:57', '2016-11-26 12:47:57'),
(604, 8, 82, 'คลองน้ำชัย', NULL, NULL, '2016-11-26 12:47:57', '2016-11-26 12:47:57'),
(605, 8, 83, 'บางเสร่', NULL, NULL, '2016-11-26 12:48:32', '2016-11-26 12:48:32'),
(606, 8, 83, 'เนินบรรพต', NULL, NULL, '2016-11-26 12:48:32', '2016-11-26 12:48:32'),
(607, 8, 83, 'เนินสามัคคี', NULL, NULL, '2016-11-26 12:48:32', '2016-11-26 12:48:32'),
(608, 8, 83, 'ตลาดบางเสร่', NULL, NULL, '2016-11-26 12:48:32', '2016-11-26 12:48:32'),
(609, 8, 83, 'เกล็ดแก้ว', NULL, NULL, '2016-11-26 12:48:32', '2016-11-26 12:48:32'),
(610, 8, 83, 'เขากระทิง', NULL, NULL, '2016-11-26 12:48:32', '2016-11-26 12:48:32');
INSERT INTO `villages` (`id`, `district_id`, `sub_district_id`, `name`, `name_en`, `description`, `created`, `modified`) VALUES
(611, 8, 83, 'หนองหิน', NULL, NULL, '2016-11-26 12:48:32', '2016-11-26 12:48:32'),
(612, 8, 83, 'ชุมชนบางเสร่', NULL, NULL, '2016-11-26 12:48:32', '2016-11-26 12:48:32'),
(613, 8, 83, 'ศาลพ่อแก่', NULL, NULL, '2016-11-26 12:48:32', '2016-11-26 12:48:32'),
(614, 8, 83, 'ห้วยลึก', NULL, NULL, '2016-11-26 12:48:32', '2016-11-26 12:48:32'),
(615, 8, 83, 'โค้งวันเพ็ญ', NULL, NULL, '2016-11-26 12:48:32', '2016-11-26 12:48:32'),
(616, 8, 84, 'พลูตาหลวง', NULL, NULL, '2016-11-26 12:48:52', '2016-11-26 12:48:52'),
(617, 8, 84, 'ขลอด', NULL, NULL, '2016-11-26 12:48:52', '2016-11-26 12:48:52'),
(618, 8, 84, 'คลองไผ่', NULL, NULL, '2016-11-26 12:48:52', '2016-11-26 12:48:52'),
(619, 8, 84, 'คลองพลูตาหลวง', NULL, NULL, '2016-11-26 12:48:52', '2016-11-26 12:48:52'),
(620, 8, 84, 'เขาบายศรี', NULL, NULL, '2016-11-26 12:48:52', '2016-11-26 12:48:52'),
(621, 8, 84, 'เขาตะแบก', NULL, NULL, '2016-11-26 12:48:52', '2016-11-26 12:48:52'),
(622, 8, 84, 'หนองหญ้าน้อย', NULL, NULL, '2016-11-26 12:48:52', '2016-11-26 12:48:52'),
(623, 8, 84, 'หนองหญ้า', NULL, NULL, '2016-11-26 12:48:52', '2016-11-26 12:48:52'),
(624, 8, 85, 'ตลาดสัตหีบ', NULL, NULL, '2016-11-26 12:49:49', '2016-11-26 12:49:49'),
(625, 8, 85, 'ยางงาม', NULL, NULL, '2016-11-26 12:49:49', '2016-11-26 12:49:49'),
(626, 8, 85, 'เตาถ่าน', NULL, NULL, '2016-11-26 12:49:49', '2016-11-26 12:49:49'),
(627, 8, 85, 'ป่ายุบ', NULL, NULL, '2016-11-26 12:49:49', '2016-11-26 12:49:49'),
(628, 8, 85, 'หนองระกำ', NULL, NULL, '2016-11-26 12:49:49', '2016-11-26 12:49:49'),
(629, 8, 85, 'ร่มฤดี', NULL, NULL, '2016-11-26 12:49:49', '2016-11-26 12:49:49'),
(630, 8, 85, 'คลองกานดา', NULL, NULL, '2016-11-26 12:49:49', '2016-11-26 12:49:49'),
(631, 8, 85, 'เขาคันธมาศน์', NULL, NULL, '2016-11-26 12:49:49', '2016-11-26 12:49:49'),
(632, 8, 86, 'คลองพลูล่าง', NULL, NULL, '2016-11-26 12:50:32', '2016-11-26 12:50:32'),
(633, 8, 86, 'เขาซก', NULL, NULL, '2016-11-26 12:50:32', '2016-11-26 12:50:32'),
(634, 8, 86, 'บึงสามง่าม', NULL, NULL, '2016-11-26 12:50:32', '2016-11-26 12:50:32'),
(635, 8, 86, 'ชากนา', NULL, NULL, '2016-11-26 12:50:32', '2016-11-26 12:50:32'),
(636, 8, 87, 'คลองพลู', NULL, NULL, '2016-11-26 12:50:55', '2016-11-26 12:50:55'),
(637, 8, 87, 'เนินดินแดง', NULL, NULL, '2016-11-26 12:50:55', '2016-11-26 12:50:55'),
(638, 8, 87, 'คลองตะเคียน', NULL, NULL, '2016-11-26 12:50:55', '2016-11-26 12:50:55'),
(639, 8, 87, 'เขามดง่าม', NULL, NULL, '2016-11-26 12:50:55', '2016-11-26 12:50:55'),
(640, 8, 88, 'ห้วยมะระ', NULL, NULL, '2016-11-26 12:51:24', '2016-11-26 12:51:24'),
(641, 8, 88, 'หนองเสือช้าง', NULL, NULL, '2016-11-26 12:51:24', '2016-11-26 12:51:24'),
(642, 8, 88, 'หลังเขา', NULL, NULL, '2016-11-26 12:51:24', '2016-11-26 12:51:24'),
(643, 8, 88, 'ท่าจาม', NULL, NULL, '2016-11-26 12:51:24', '2016-11-26 12:51:24'),
(644, 8, 88, 'เฉลิมลาภ', NULL, NULL, '2016-11-26 12:51:24', '2016-11-26 12:51:24'),
(645, 8, 89, 'หนองใหญ่', NULL, NULL, '2016-11-26 12:51:57', '2016-11-26 12:51:57'),
(646, 8, 89, 'วังใหญ่', NULL, NULL, '2016-11-26 12:51:57', '2016-11-26 12:51:57'),
(647, 8, 89, 'หนองผักหนาม', NULL, NULL, '2016-11-26 12:51:57', '2016-11-26 12:51:57'),
(648, 8, 89, 'อ่างแก้ว', NULL, NULL, '2016-11-26 12:51:57', '2016-11-26 12:51:57'),
(649, 8, 89, 'หนองตะเคียนทอง', NULL, NULL, '2016-11-26 12:51:57', '2016-11-26 12:51:57'),
(650, 8, 89, 'มาบยาง', NULL, NULL, '2016-11-26 12:51:57', '2016-11-26 12:51:57'),
(651, 8, 90, 'หนองประดู่', NULL, NULL, '2016-11-26 12:52:34', '2016-11-26 12:52:34'),
(652, 8, 90, 'เนินสี่', NULL, NULL, '2016-11-26 12:52:34', '2016-11-26 12:52:34'),
(653, 8, 90, 'ห้างสูง', NULL, NULL, '2016-11-26 12:52:34', '2016-11-26 12:52:34'),
(654, 8, 90, 'หลุมกลาง', NULL, NULL, '2016-11-26 12:52:34', '2016-11-26 12:52:34'),
(655, 8, 90, 'หนองประดู่', NULL, NULL, '2016-11-26 12:52:34', '2016-11-26 12:52:34'),
(656, 8, 91, 'เกาะจันทร์', NULL, NULL, '2016-11-26 12:54:24', '2016-11-26 12:54:24'),
(657, 8, 91, 'หนองชุมเห็ด', NULL, NULL, '2016-11-26 12:54:24', '2016-11-26 12:54:24'),
(658, 8, 91, 'สระตาพรม', NULL, NULL, '2016-11-26 12:54:25', '2016-11-26 12:54:25'),
(659, 8, 91, 'เจ็ดเนิน', NULL, NULL, '2016-11-26 12:54:25', '2016-11-26 12:54:25'),
(660, 8, 91, 'โป่งหิน', NULL, NULL, '2016-11-26 12:54:25', '2016-11-26 12:54:25'),
(661, 8, 91, 'ทับบริบูรณ์', NULL, NULL, '2016-11-26 12:54:25', '2016-11-26 12:54:25'),
(662, 8, 91, 'ปรกฟ้า', NULL, NULL, '2016-11-26 12:54:25', '2016-11-26 12:54:25'),
(663, 8, 91, 'หนองแฟบ', NULL, NULL, '2016-11-26 12:54:25', '2016-11-26 12:54:25'),
(664, 8, 91, 'หนองยายหมาด', NULL, NULL, '2016-11-26 12:54:25', '2016-11-26 12:54:25'),
(665, 8, 91, 'หนองมะนาว', NULL, NULL, '2016-11-26 12:54:25', '2016-11-26 12:54:25'),
(666, 8, 91, 'แปลง', NULL, NULL, '2016-11-26 12:54:25', '2016-11-26 12:54:25'),
(667, 8, 91, 'เขาวังแก้ว', NULL, NULL, '2016-11-26 12:54:25', '2016-11-26 12:54:25'),
(668, 8, 91, 'เนินตะแบก', NULL, NULL, '2016-11-26 12:54:25', '2016-11-26 12:54:25'),
(669, 8, 91, 'หนองหูช้าง', NULL, NULL, '2016-11-26 12:54:25', '2016-11-26 12:54:25'),
(670, 8, 91, 'คลอง', NULL, NULL, '2016-11-26 12:54:25', '2016-11-26 12:54:25'),
(671, 8, 92, 'ท่าบุญมี', NULL, NULL, '2016-11-26 12:54:44', '2016-11-26 12:54:44'),
(672, 8, 92, 'หนองแขนนาง', NULL, NULL, '2016-11-26 12:54:44', '2016-11-26 12:54:44'),
(673, 8, 92, 'นาม่วง', NULL, NULL, '2016-11-26 12:54:44', '2016-11-26 12:54:44'),
(674, 8, 92, 'เกาะโพธิ์', NULL, NULL, '2016-11-26 12:54:44', '2016-11-26 12:54:44'),
(675, 8, 92, 'สามแยก', NULL, NULL, '2016-11-26 12:54:45', '2016-11-26 12:54:45'),
(676, 8, 92, 'ทับจุฬา', NULL, NULL, '2016-11-26 12:54:45', '2016-11-26 12:54:45'),
(677, 8, 92, 'หนองงูเหลือม', NULL, NULL, '2016-11-26 12:54:45', '2016-11-26 12:54:45'),
(678, 8, 92, 'ห้วยหวาย', NULL, NULL, '2016-11-26 12:54:45', '2016-11-26 12:54:45'),
(679, 8, 92, 'คลองม่วง', NULL, NULL, '2016-11-26 12:54:45', '2016-11-26 12:54:45'),
(680, 8, 92, 'หนองพังพอน', NULL, NULL, '2016-11-26 12:54:45', '2016-11-26 12:54:45'),
(681, 8, 92, 'เนินกระบก', NULL, NULL, '2016-11-26 12:54:45', '2016-11-26 12:54:45'),
(682, 8, 92, 'หนองลำดวน', NULL, NULL, '2016-11-26 12:54:45', '2016-11-26 12:54:45');

-- --------------------------------------------------------

--
-- Table structure for table `wikis`
--

CREATE TABLE `wikis` (
  `id` int(11) NOT NULL,
  `model` varchar(255) DEFAULT NULL,
  `model_id` int(11) DEFAULT NULL,
  `subject` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wording_relations`
--

CREATE TABLE `wording_relations` (
  `id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL,
  `relate_to_word` varchar(255) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `wording_relation_relates`
--

CREATE TABLE `wording_relation_relates` (
  `id` int(11) NOT NULL,
  `model` varchar(255) NOT NULL,
  `model_id` int(11) NOT NULL,
  `wording_relation_id` int(11) NOT NULL,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `words`
--

CREATE TABLE `words` (
  `id` int(11) NOT NULL,
  `word` varchar(255) NOT NULL,
  `description` text,
  `created` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_entities`
--
ALTER TABLE `business_entities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `business_types`
--
ALTER TABLE `business_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `company_has_business_types`
--
ALTER TABLE `company_has_business_types`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_id` (`company_id`,`business_type_id`);

--
-- Indexes for table `company_has_departments`
--
ALTER TABLE `company_has_departments`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `company_id` (`company_id`,`department_id`);

--
-- Indexes for table `company_has_jobs`
--
ALTER TABLE `company_has_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `days`
--
ALTER TABLE `days`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `department_has_jobs`
--
ALTER TABLE `department_has_jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `districts`
--
ALTER TABLE `districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employment_types`
--
ALTER TABLE `employment_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `item_sells`
--
ALTER TABLE `item_sells`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lookups`
--
ALTER TABLE `lookups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `model` (`model`,`model_id`);

--
-- Indexes for table `office_hours`
--
ALTER TABLE `office_hours`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `online_shops`
--
ALTER TABLE `online_shops`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `people`
--
ALTER TABLE `people`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `person_has_entities`
--
ALTER TABLE `person_has_entities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `person_interests`
--
ALTER TABLE `person_interests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profiles`
--
ALTER TABLE `profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `slugs`
--
ALTER TABLE `slugs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `model` (`model`,`model_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `stories`
--
ALTER TABLE `stories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_districts`
--
ALTER TABLE `sub_districts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `synonyms`
--
ALTER TABLE `synonyms`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taggings`
--
ALTER TABLE `taggings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `temp_files`
--
ALTER TABLE `temp_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `villages`
--
ALTER TABLE `villages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wikis`
--
ALTER TABLE `wikis`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wording_relations`
--
ALTER TABLE `wording_relations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `wording_relation_relates`
--
ALTER TABLE `wording_relation_relates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `words`
--
ALTER TABLE `words`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `business_entities`
--
ALTER TABLE `business_entities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `business_types`
--
ALTER TABLE `business_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;
--
-- AUTO_INCREMENT for table `company_has_business_types`
--
ALTER TABLE `company_has_business_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `company_has_departments`
--
ALTER TABLE `company_has_departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `company_has_jobs`
--
ALTER TABLE `company_has_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
--
-- AUTO_INCREMENT for table `days`
--
ALTER TABLE `days`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `department_has_jobs`
--
ALTER TABLE `department_has_jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `districts`
--
ALTER TABLE `districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT for table `employment_types`
--
ALTER TABLE `employment_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT for table `item_sells`
--
ALTER TABLE `item_sells`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `lookups`
--
ALTER TABLE `lookups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT for table `office_hours`
--
ALTER TABLE `office_hours`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `online_shops`
--
ALTER TABLE `online_shops`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;
--
-- AUTO_INCREMENT for table `people`
--
ALTER TABLE `people`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `person_has_entities`
--
ALTER TABLE `person_has_entities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `person_interests`
--
ALTER TABLE `person_interests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `profiles`
--
ALTER TABLE `profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `slugs`
--
ALTER TABLE `slugs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `stories`
--
ALTER TABLE `stories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `sub_districts`
--
ALTER TABLE `sub_districts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;
--
-- AUTO_INCREMENT for table `synonyms`
--
ALTER TABLE `synonyms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `taggings`
--
ALTER TABLE `taggings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;
--
-- AUTO_INCREMENT for table `temp_files`
--
ALTER TABLE `temp_files`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `villages`
--
ALTER TABLE `villages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=683;
--
-- AUTO_INCREMENT for table `wikis`
--
ALTER TABLE `wikis`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;
--
-- AUTO_INCREMENT for table `wording_relations`
--
ALTER TABLE `wording_relations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `wording_relation_relates`
--
ALTER TABLE `wording_relation_relates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `words`
--
ALTER TABLE `words`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
