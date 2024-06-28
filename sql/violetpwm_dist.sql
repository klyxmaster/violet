/*
Navicat MySQL Data Transfer

Source Server         : localhost
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : violetpwm

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2024-06-27 09:18:21
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `bankdetails`
-- ----------------------------
DROP TABLE IF EXISTS `bankdetails`;
CREATE TABLE `bankdetails` (
  `Bank_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Bank_Name` varchar(100) NOT NULL,
  `Bank_CardNum` varchar(255) NOT NULL,
  `Bank_ValidThru` varchar(255) NOT NULL,
  `Bank_CardHolder` varchar(255) NOT NULL,
  `Bank_Cvv` varchar(255) NOT NULL,
  `Bank_CardType` varchar(255) NOT NULL,
  `Bank_Pin` varchar(255) NOT NULL,
  PRIMARY KEY (`Bank_ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of bankdetails
-- ----------------------------

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `2fa` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of users
-- ----------------------------


-- ----------------------------
-- Table structure for `websitedetails`
-- ----------------------------
DROP TABLE IF EXISTS `websitedetails`;
CREATE TABLE `websitedetails` (
  `Web_ID` int(11) NOT NULL AUTO_INCREMENT,
  `Web_Address` varchar(255) NOT NULL,
  `Web_Name` varchar(255) NOT NULL,
  `Web_Login` varchar(255) NOT NULL,
  `Web_Password` varchar(255) NOT NULL,
  PRIMARY KEY (`Web_ID`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- ----------------------------
-- Records of websitedetails
-- ----------------------------
