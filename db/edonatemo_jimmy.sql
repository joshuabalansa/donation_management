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

-- Dumping structure for table edonatemo.messenger
CREATE TABLE IF NOT EXISTS `messenger` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sender_user_id` int(11) NOT NULL DEFAULT '0',
  `receiver_user_id` int(11) NOT NULL DEFAULT '0',
  `starred` tinyint(4) NOT NULL DEFAULT '0',
  `seen_at` datetime NOT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table edonatemo.messenger: ~0 rows (approximately)
/*!40000 ALTER TABLE `messenger` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger` ENABLE KEYS */;

-- Dumping structure for table edonatemo.messenger_messages
CREATE TABLE IF NOT EXISTS `messenger_messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `messenger_id` int(11) NOT NULL,
  `sender_user_id` int(11) NOT NULL,
  `receiver_user_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `seen_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `messenger_id` (`messenger_id`),
  KEY `sender_user_id` (`sender_user_id`),
  KEY `receiver_user_id` (`receiver_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table edonatemo.messenger_messages: ~0 rows (approximately)
/*!40000 ALTER TABLE `messenger_messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messenger_messages` ENABLE KEYS */;

-- Dumping structure for table edonatemo.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `token` varchar(255) NOT NULL DEFAULT '',
  `created_at` varchar(255) DEFAULT NULL,
  `access_type` varchar(50) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- Dumping data for table edonatemo.users: ~4 rows (approximately)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `email`, `name`, `password`, `contact`, `address`, `token`, `created_at`, `access_type`) VALUES
	(8, 'test@gmail.com', 'aso', '202cb962ac59075b964b07152d234b70', '123', '111', 'c9f0f895fb98ab9159f51fd0297e236d', '2023-11-27 22:50:16', 'user'),
	(9, 'tests@gmail.com', 'as2\\\'', '202cb962ac59075b964b07152d234b70', 'asdf\\\'', '\\\'', '', '2023-11-27 22:57:49', 'user'),
	(10, 'asdf', 'asdf', '202cb962ac59075b964b07152d234b70', '123', '123', '', '2023-12-06 20:59:11', 'user'),
	(11, 'asdf@g.com', 'asdf', '202cb962ac59075b964b07152d234b70', '123', '123', '', '2023-12-06 21:01:28', 'user'),
	(12, 'asdfg@g.com', 'asdf', '202cb962ac59075b964b07152d234b70', '123', '123', '', '2023-12-06 21:02:28', 'user');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
