-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 06, 2023 at 09:48 PM
-- Server version: 8.0.31
-- PHP Version: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dulcesofia`
--

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `subject_id` int NOT NULL,
  `gross_total` decimal(10,0) NOT NULL,
  `net_total` decimal(10,0) NOT NULL,
  `creation_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `observation` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `subject_id`, `gross_total`, `net_total`, `creation_timestamp`, `observation`) VALUES
(1, 1, '47000', '31000', '2023-08-06 21:39:57', ''),
(2, 5, '62000', '40000', '2023-08-06 21:44:54', 'Llevar pasado mañana');

-- --------------------------------------------------------

--
-- Table structure for table `orders_detail`
--

DROP TABLE IF EXISTS `orders_detail`;
CREATE TABLE IF NOT EXISTS `orders_detail` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `product_id` int NOT NULL,
  `product_description` text NOT NULL,
  `quantity` int NOT NULL,
  `gross_amount` decimal(10,0) NOT NULL,
  `net_amount` decimal(10,0) NOT NULL,
  `creation_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `price` decimal(10,0) NOT NULL,
  `cost` decimal(10,0) NOT NULL,
  `orders_id` int NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `orders_detail`
--

INSERT INTO `orders_detail` (`id`, `product_id`, `product_description`, `quantity`, `gross_amount`, `net_amount`, `creation_timestamp`, `price`, `cost`, `orders_id`) VALUES
(1, 2, 'Alfajor 1', 2, '17000', '11000', '2023-08-06 21:39:57', '8500', '3000', 1),
(2, 3, 'Pastafrola', 1, '30000', '20000', '2023-08-06 21:39:57', '30000', '10000', 1),
(3, 2, 'Alfajor 1', 2, '17000', '11000', '2023-08-06 21:44:54', '8500', '3000', 2),
(4, 1, 'Pan 1', 3, '15000', '9000', '2023-08-06 21:44:54', '5000', '2000', 2),
(5, 3, 'Pastafrola', 1, '30000', '20000', '2023-08-06 21:44:54', '30000', '10000', 2);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `description` text NOT NULL,
  `price` decimal(10,0) NOT NULL,
  `cost` decimal(10,0) NOT NULL,
  `creation_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `description`, `price`, `cost`, `creation_timestamp`) VALUES
(1, 'Pan 1', '5000', '2000', '2023-08-06 21:39:16'),
(2, 'Alfajor 1', '8500', '3000', '2023-08-06 21:39:27'),
(3, 'Pastafrola', '30000', '10000', '2023-08-06 21:39:34');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

DROP TABLE IF EXISTS `subject`;
CREATE TABLE IF NOT EXISTS `subject` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `document_value` text,
  `address` text,
  `telephone` text,
  `cellphone` text,
  `creation_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`id`, `name`, `document_value`, `address`, `telephone`, `cellphone`, `creation_timestamp`) VALUES
(1, 'Cliente A', '4111222-5', 'Direccion ficticia 1234', '021 111 2223', '0991 222 333', '2023-08-06 21:37:09'),
(2, 'Cliente B', '2222333', 'Ficticia 2', '021 111 5555', '0991 222 555', '2023-08-06 21:38:20'),
(3, '1', '', '', '', '', '2023-08-06 21:38:26'),
(4, 'Cliente C', '2111333-9', 'Direccion ficticia 5', '021 444 5578', '0981 555 444', '2023-08-06 21:42:01'),
(5, 'Cliente D', '7888444-5', 'Dire 1', '021 777 5555', '0981 222 333', '2023-08-06 21:44:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_name` text NOT NULL,
  `user_password` text NOT NULL,
  `creation_timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_name`, `user_password`, `creation_timestamp`) VALUES
(1, 'admin', 'pandulce', '2023-08-06 21:36:20');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
