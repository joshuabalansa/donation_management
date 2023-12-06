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

-- Dumping structure for table edonatemo.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `admin_ID` int NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  PRIMARY KEY (`admin_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edonatemo.admin: ~0 rows (approximately)
DELETE FROM `admin`;

-- Dumping structure for table edonatemo.cash_dono
CREATE TABLE IF NOT EXISTS `cash_dono` (
  `cash_dono_ID` int NOT NULL AUTO_INCREMENT,
  `org_ID` int DEFAULT NULL,
  `cash_donation_description` text,
  `cash_amount` decimal(10,2) DEFAULT NULL,
  `receipt_id` int DEFAULT NULL,
  `date_dono` date DEFAULT NULL,
  `status` varchar(20) DEFAULT 'PENDING',
  PRIMARY KEY (`cash_dono_ID`),
  KEY `org_ID` (`org_ID`),
  CONSTRAINT `cash_dono_ibfk_1` FOREIGN KEY (`org_ID`) REFERENCES `organization` (`org_ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edonatemo.cash_dono: ~4 rows (approximately)
DELETE FROM `cash_dono`;
INSERT INTO `cash_dono` (`cash_dono_ID`, `org_ID`, `cash_donation_description`, `cash_amount`, `receipt_id`, `date_dono`, `status`) VALUES
	(1, 1, 'asdasdasasd', 69420.00, 0, '2199-02-22', 'PENDING'),
	(2, 1, 'aaaaaa', 9999.00, 2, '2222-02-22', 'PENDING'),
	(3, 1, 'asdasdasdas', 0.00, 3, '2222-02-22', 'PENDING'),
	(4, 2, 'asdasda', 123123.00, 4, '9999-09-09', 'PENDING');

-- Dumping structure for table edonatemo.cash_receipt
CREATE TABLE IF NOT EXISTS `cash_receipt` (
  `receipt_id` int NOT NULL AUTO_INCREMENT,
  `receipt_url` varchar(255) NOT NULL,
  PRIMARY KEY (`receipt_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edonatemo.cash_receipt: ~4 rows (approximately)
DELETE FROM `cash_receipt`;
INSERT INTO `cash_receipt` (`receipt_id`, `receipt_url`) VALUES
	(1, 'asdasdasd.com'),
	(2, 'asdasd.com'),
	(3, 'asd'),
	(4, 'sdasda.com');

-- Dumping structure for table edonatemo.food_dono
CREATE TABLE IF NOT EXISTS `food_dono` (
  `food_dono_ID` int NOT NULL AUTO_INCREMENT,
  `org_ID` int DEFAULT NULL,
  `food_donation_description` text,
  `date_dono` date DEFAULT NULL,
  `status` varchar(20) DEFAULT 'PENDING',
  PRIMARY KEY (`food_dono_ID`),
  KEY `org_ID` (`org_ID`),
  CONSTRAINT `food_dono_ibfk_1` FOREIGN KEY (`org_ID`) REFERENCES `organization` (`org_ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edonatemo.food_dono: ~7 rows (approximately)
DELETE FROM `food_dono`;
INSERT INTO `food_dono` (`food_dono_ID`, `org_ID`, `food_donation_description`, `date_dono`, `status`) VALUES
	(2, 2, NULL, '0000-00-00', 'PENDING'),
	(3, 1, 'asdasdsadsa', '1992-02-22', 'PENDING'),
	(4, 1, 'asdasdas', '1111-02-22', 'PENDING'),
	(5, 1, 'asdasdasd', '3333-03-31', 'PENDING'),
	(6, 1, 'asdasd', '2222-02-22', 'PENDING'),
	(7, 1, 'asdasdsadasd', '4444-04-04', 'PENDING'),
	(8, 3, 'asdasdasdasd', '5555-05-05', 'PENDING');

-- Dumping structure for table edonatemo.goods_dono
CREATE TABLE IF NOT EXISTS `goods_dono` (
  `goods_dono_ID` int NOT NULL AUTO_INCREMENT,
  `org_ID` int DEFAULT NULL,
  `goods_donation_description` text,
  `date_dono` date DEFAULT NULL,
  `status` varchar(20) DEFAULT 'PENDING',
  PRIMARY KEY (`goods_dono_ID`),
  KEY `org_ID` (`org_ID`),
  CONSTRAINT `goods_dono_ibfk_1` FOREIGN KEY (`org_ID`) REFERENCES `organization` (`org_ID`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edonatemo.goods_dono: ~3 rows (approximately)
DELETE FROM `goods_dono`;
INSERT INTO `goods_dono` (`goods_dono_ID`, `org_ID`, `goods_donation_description`, `date_dono`, `status`) VALUES
	(1, 2, NULL, '0000-00-00', 'PENDING'),
	(2, 1, 'asdasdasdasd', '2002-02-19', 'PENDING'),
	(3, 1, 'asdasdsadasd', '4444-04-04', 'PENDING');

-- Dumping structure for table edonatemo.messages
CREATE TABLE IF NOT EXISTS `messages` (
  `message_id` int NOT NULL AUTO_INCREMENT,
  `org_ID` int DEFAULT NULL,
  `message_description` text,
  `date` date DEFAULT NULL,
  PRIMARY KEY (`message_id`),
  KEY `org_ID` (`org_ID`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`org_ID`) REFERENCES `organization` (`org_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edonatemo.messages: ~0 rows (approximately)
DELETE FROM `messages`;

-- Dumping structure for table edonatemo.organization
CREATE TABLE IF NOT EXISTS `organization` (
  `org_ID` int NOT NULL AUTO_INCREMENT,
  `org_username` varchar(255) NOT NULL,
  `org_password` varchar(255) NOT NULL,
  `org_name` varchar(255) NOT NULL,
  `org_description` text,
  `org_contact` varchar(20) DEFAULT NULL,
  `org_email` varchar(255) DEFAULT NULL,
  `org_address` text,
  PRIMARY KEY (`org_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edonatemo.organization: ~0 rows (approximately)
DELETE FROM `organization`;
INSERT INTO `organization` (`org_ID`, `org_username`, `org_password`, `org_name`, `org_description`, `org_contact`, `org_email`, `org_address`) VALUES
	(1, 'user123', '$2y$10$zedCYh3mR658WGvZ4sjjl.5Nze/PWOBM1vLV9pbme2srjOXaEdxLa', 'asdas', 'dasda', 'sdasdas', 'asda@gmail.com', 'asdasd'),
	(2, 'org', '$2y$10$6.35U07lpKYqeuYZuZ/tgOXua4LcynWh8LFhnxoyzjJnjdSbBg0E6', 'orgname', 'orgdesc', '09213957543', 'org@org.org', 'orgAddress'),
	(3, 'orgfinal', '$2y$10$51YS4IjY4z8OdDosllxWjOsPzwtm6OC/7kmdf6wGEmYTbOPHjX9C6', 'organization123', 'organizationdescription', '093949291', 'org@gmail.org', 'orgaddress69'),
	(4, 'org10', '$2y$10$kxyScRZUMxIRyz4sqbkR2OUHCwSfeyfIG1.t/kkwcjJLo0otPJeuK', 'org10', 'org10', '19219', 'org10@gmail.com', 'org10');

-- Dumping structure for table edonatemo.posts
CREATE TABLE IF NOT EXISTS `posts` (
  `post_id` int NOT NULL AUTO_INCREMENT,
  `org_ID` int DEFAULT NULL,
  `post_description` text,
  PRIMARY KEY (`post_id`),
  KEY `org_ID` (`org_ID`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`org_ID`) REFERENCES `organization` (`org_ID`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table edonatemo.posts: ~0 rows (approximately)
DELETE FROM `posts`;

CREATE TABLE donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    phone VARCHAR(10) NOT NULL,
    email VARCHAR(255) NOT NULL,
    donationType VARCHAR(255) NOT NULL,
    status VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL
);

-- Dumping structure for table edonatemo.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL DEFAULT '',
  `name` varchar(255) NOT NULL DEFAULT '',
  `password` varchar(255) NOT NULL DEFAULT '',
  `contact` varchar(255) NOT NULL DEFAULT '',
  `address` varchar(255) NOT NULL DEFAULT '',
  `token` varchar(255) NOT NULL DEFAULT '',
  `created_at` varchar(255) DEFAULT NULL,
  `access_type` varchar(50) NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Dumping data for table edonatemo.users: ~4 rows (approximately)
DELETE FROM `users`;
INSERT INTO `users` (`id`, `email`, `name`, `password`, `contact`, `address`, `token`, `created_at`, `access_type`) VALUES
	(8, 'test@gmail.com', 'as', '202cb962ac59075b964b07152d234b70', '123', '111', '', '2023-11-27 22:50:16', 'user'),
	(9, 'tests@gmail.com', 'as2\\\'', '202cb962ac59075b964b07152d234b70', 'asdf\\\'', '\\\'', '', '2023-11-27 22:57:49', 'user'),
	(10, 'jimmy@gmail.com', 'Jimmy', '202cb962ac59075b964b07152d234b70', '123', 'asdf', '', '2023-11-28 06:48:23', 'user'),
	(11, 'asdf@gmail.com', 'asdf', '202cb962ac59075b964b07152d234b70', '1234', 'sdfghjkl123456789 !@#$%^&*()_+{:"?><', '', '2023-11-28 06:49:23', 'user');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
