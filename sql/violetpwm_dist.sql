-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.2.0 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.2.0.6576
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for violetpwm
CREATE DATABASE IF NOT EXISTS `violetpwm` /*!40100 DEFAULT CHARACTER SET utf8mb3 */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `violetpwm`;

-- Dumping structure for table violetpwm.bankdetails
CREATE TABLE IF NOT EXISTS `bankdetails` (
  `Bank_ID` int NOT NULL AUTO_INCREMENT,
  `Bank_Name` varchar(100) NOT NULL,
  `Bank_CardNum` varchar(255) NOT NULL,
  `Bank_ValidThru` varchar(255) NOT NULL,
  `Bank_CardHolder` varchar(255) NOT NULL,
  `Bank_Cvv` varchar(255) NOT NULL,
  `Bank_CardType` varchar(255) NOT NULL,
  `Bank_Pin` varchar(255) NOT NULL,
  `Bank_Date_Created` datetime DEFAULT NULL,
  `Bank_Date_Edited` datetime DEFAULT NULL,
  PRIMARY KEY (`Bank_ID`)
)  ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table violetpwm.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `2fa_str` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `2fa` tinyint DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

-- Data exporting was unselected.

-- Dumping structure for table violetpwm.websitedetails
CREATE TABLE IF NOT EXISTS `websitedetails` (
  `Web_ID` int NOT NULL AUTO_INCREMENT,
  `Web_Address` varchar(255) NOT NULL,
  `Web_Name` varchar(255) NOT NULL,
  `Web_Login` varchar(255) NOT NULL,
  `Web_Password` varchar(255) NOT NULL,
  `Web_Date_Created` datetime DEFAULT NULL,
  `Web_Date_Edited` datetime DEFAULT NULL,
  PRIMARY KEY (`Web_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE utf8mb4_general_ci;

-- Data exporting was unselected.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
