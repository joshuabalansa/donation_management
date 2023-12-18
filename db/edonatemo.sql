-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               5.7.33 - MySQL Community Server (GPL)
-- Server OS:                    Win64
-- HeidiSQL Version:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Dumping structure for table edonatemo.donations
CREATE TABLE IF NOT EXISTS `donations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `donation_type` varchar(255) NOT NULL,
  `donation` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table edonatemo.donations: ~5 rows (approximately)
/*!40000 ALTER TABLE `donations` DISABLE KEYS */;
INSERT INTO `donations` (`id`, `donation_type`, `donation`, `image`, `post_id`, `user_id`, `created_at`) VALUES
	(35, 'monetary', '1222', 'uploads/images.jpeg', 14, 8, '2023-12-18 14:38:12'),
	(36, 'goods', 'rice', 'uploads/images.jpeg', 14, 8, '2023-12-18 14:38:29'),
	(37, 'monetary', '1234', 'uploads/images.jpeg', 14, 8, '2023-12-18 15:17:20'),
	(38, 'monetary', '1234', 'uploads/images.jpeg', 14, 8, '2023-12-18 15:19:40'),
	(39, 'monetary', '5555', 'uploads/images.jpeg', 14, 8, '2023-12-18 15:20:03');
/*!40000 ALTER TABLE `donations` ENABLE KEYS */;

-- Dumping structure for table edonatemo.messenger
CREATE TABLE IF NOT EXISTS `messenger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_user_id` int(11) NOT NULL DEFAULT '0',
  `receiver_user_id` int(11) NOT NULL DEFAULT '0',
  `starred` tinyint(4) NOT NULL DEFAULT '0',
  `seen_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- Dumping data for table edonatemo.messenger: ~1 rows (approximately)
/*!40000 ALTER TABLE `messenger` DISABLE KEYS */;
INSERT INTO `messenger` (`id`, `sender_user_id`, `receiver_user_id`, `starred`, `seen_at`, `deleted_at`, `created_at`) VALUES
	(5, 8, 18, 0, NULL, NULL, '2023-12-18 14:31:11');
/*!40000 ALTER TABLE `messenger` ENABLE KEYS */;

-- Dumping structure for table edonatemo.messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `messenger_id` int(11) NOT NULL,
  `sender_user_id` int(11) NOT NULL,
  `receiver_user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `seen_at` datetime DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `messenger_id` (`messenger_id`) USING BTREE,
  KEY `sender_user_id` (`sender_user_id`) USING BTREE,
  KEY `receiver_user_id` (`receiver_user_id`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- Dumping data for table edonatemo.messenger_messages: ~1 rows (approximately)
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
INSERT INTO `messenger_messages` (`id`, `messenger_id`, `sender_user_id`, `receiver_user_id`, `message`, `seen_at`, `deleted_at`, `created_at`) VALUES
	(21, 5, 8, 18, 'ei', NULL, NULL, '2023-12-18 22:31:11');
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;

-- Dumping structure for table edonatemo.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `address` varchar(50) NOT NULL,
  `brgy` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `province` varchar(255) DEFAULT NULL,
  `image` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- Dumping data for table edonatemo.posts: ~1 rows (approximately)
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` (`id`, `title`, `description`, `phone`, `address`, `brgy`, `city`, `province`, `image`, `user_id`, `status`, `created_at`) VALUES
	(14, 'Sample Post', 'This is a Sample Post', '1234', 'bacolod', 'abc', 'bacolod', 'negros', 'uploads/images.jpeg', 8, 'pending', '2023-12-18 00:00:00');
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;

-- Dumping structure for table edonatemo.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `token` varchar(255) NOT NULL DEFAULT '',
  `created_at` datetime DEFAULT NULL,
  `access_type` varchar(50) NOT NULL DEFAULT 'user',
  `mission` text,
  `vision` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Dumping data for table edonatemo.users: ~3 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `name`, `password`, `contact`, `address`, `token`, `created_at`, `access_type`, `mission`, `vision`) VALUES
	(8, 'test@gmail.com', 'Joe John', '202cb962ac59075b964b07152d234b70', '123', '111', '', '2023-12-18 21:14:17', 'admin', NULL, NULL),
	(16, 'asdf@gmail.com', 'asdfs', '', '1234', 'asdf', '', '2023-12-18 21:14:18', 'user', NULL, NULL),
	(18, 'tests@gmail.com', 'Juan Dela Cruz', '202cb962ac59075b964b07152d234b70', '1234567890', 'bacolod', '', '2023-12-18 22:04:57', 'user', NULL, NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
