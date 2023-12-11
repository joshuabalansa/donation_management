-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for edonatemo
CREATE DATABASE IF NOT EXISTS `edonatemo` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `edonatemo`;

-- Dumping structure for table edonatemo.donations
CREATE TABLE IF NOT EXISTS `donations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `description` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `phone` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email` varchar(255) NOT NULL,
  `donationType` varchar(255) NOT NULL,
  `donation` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edonatemo.donations: ~0 rows (approximately)
DELETE FROM `donations`;

-- Dumping structure for table edonatemo.messenger
CREATE TABLE IF NOT EXISTS `messenger` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_user_id` int NOT NULL DEFAULT '0',
  `receiver_user_id` int NOT NULL DEFAULT '0',
  `starred` tinyint NOT NULL DEFAULT '0',
  `seen_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Dumping data for table edonatemo.messenger: ~1 rows (approximately)
DELETE FROM `messenger`;
INSERT INTO `messenger` (`id`, `sender_user_id`, `receiver_user_id`, `starred`, `seen_at`, `deleted_at`, `created_at`) VALUES
	(1, 8, 9, 0, NULL, NULL, NULL);

-- Dumping structure for table edonatemo.messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `messenger_id` int NOT NULL,
  `sender_user_id` int NOT NULL,
  `receiver_user_id` int NOT NULL,
  `message` text NOT NULL,
  `seen_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messenger_id` (`messenger_id`),
  KEY `sender_user_id` (`sender_user_id`),
  KEY `receiver_user_id` (`receiver_user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table edonatemo.messenger_messages: ~12 rows (approximately)
DELETE FROM `messenger_messages`;
INSERT INTO `messenger_messages` (`id`, `messenger_id`, `sender_user_id`, `receiver_user_id`, `message`, `seen_at`, `deleted_at`, `created_at`) VALUES
	(1, 1, 8, 9, 'test', NULL, NULL, '2023-12-11 08:58:53'),
	(2, 1, 8, 9, 'taek', NULL, NULL, '2023-12-11 08:59:02'),
	(3, 1, 8, 9, 'taek', NULL, NULL, '2023-12-11 09:10:49'),
	(4, 1, 9, 8, 'ssss', NULL, NULL, '2023-12-11 10:01:28'),
	(5, 1, 8, 9, 'asdf', NULL, NULL, '2023-12-11 10:02:50'),
	(6, 1, 8, 9, 'weee', NULL, NULL, '2023-12-11 10:03:54'),
	(7, 1, 8, 9, 'sadfasdf', NULL, NULL, '2023-12-11 10:04:07'),
	(8, 1, 9, 8, 'asdfasdfasdfsdf', NULL, NULL, '2023-12-11 10:06:00'),
	(9, 1, 8, 9, 'test', NULL, NULL, '2023-12-11 10:06:03'),
	(10, 1, 8, 9, '123', NULL, NULL, '2023-12-11 10:07:02'),
	(11, 1, 8, 9, 'waaa', NULL, NULL, '2023-12-11 10:10:38'),
	(12, 1, 8, 9, 'tes', NULL, NULL, '2023-12-11 10:10:47');

-- Dumping structure for table edonatemo.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `phone` varchar(10) NOT NULL,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edonatemo.posts: ~0 rows (approximately)
DELETE FROM `posts`;

-- Dumping structure for table edonatemo.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `token` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `access_type` varchar(50) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table edonatemo.users: ~5 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `email`, `name`, `password`, `contact`, `address`, `token`, `created_at`, `access_type`) VALUES
	(8, 'test@gmail.com', 'Joe John', '202cb962ac59075b964b07152d234b70', '123', '111', 'c9f0f895fb98ab9159f51fd0297e236d', '2023-11-27 22:50:16', 'user'),
	(9, 'tests@gmail.com', 'Axelle Coura', '202cb962ac59075b964b07152d234b70', 'asdf\\\'', '\\\'', '', '2023-11-27 22:57:49', 'user'),
	(10, 'asdf', 'Skibidi Toilet', '202cb962ac59075b964b07152d234b70', '123', '123', '', '2023-12-06 20:59:11', 'user'),
	(11, 'asdf@g.com', 'Ben TUlfo', '202cb962ac59075b964b07152d234b70', '123', '123', '', '2023-12-06 21:01:28', 'user'),
	(12, 'asdfg@g.com', 'Raffy Tulfo', '202cb962ac59075b964b07152d234b70', '123', '123', '', '2023-12-06 21:02:28', 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
