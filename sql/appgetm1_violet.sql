-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 27, 2024 at 04:55 PM
-- Server version: 10.5.17-MariaDB-cll-lve
-- PHP Version: 8.1.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appgetm1_violet`
--

-- --------------------------------------------------------

--
-- Table structure for table `bankdetails`
--

CREATE TABLE `bankdetails` (
  `Bank_ID` int(11) NOT NULL,
  `Bank_Name` varchar(100) NOT NULL,
  `Bank_CardNum` varchar(255) NOT NULL,
  `Bank_ValidThru` varchar(255) NOT NULL,
  `Bank_CardHolder` varchar(255) NOT NULL,
  `Bank_Cvv` varchar(255) NOT NULL,
  `Bank_CardType` varchar(255) NOT NULL,
  `Bank_Pin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `create_datetime` datetime NOT NULL,
  `2fa_str` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `create_datetime`, `2fa_str`) VALUES
(2, 'ra7en1911', 'rickscorpio@proton.me', '664bd41e6e4c1ce046b2d7939907debfeae025fc', '2024-06-26 10:00:28', '176225,201699,702767,225419,893859,128032,795285,217741,846464,034554,791750,189022,824715,248422,414785,225482,356847,808894,370479,916188,522689,502865,020114,574819,414552,823942,302185,502145,970548,094823,139114,840');

-- --------------------------------------------------------

--
-- Table structure for table `websitedetails`
--

CREATE TABLE `websitedetails` (
  `Web_ID` int(11) NOT NULL,
  `Web_Address` varchar(255) NOT NULL,
  `Web_Name` varchar(255) NOT NULL,
  `Web_Login` varchar(255) NOT NULL,
  `Web_Password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `websitedetails`
--

INSERT INTO `websitedetails` (`Web_ID`, `Web_Address`, `Web_Name`, `Web_Login`, `Web_Password`) VALUES
(5, 'www.paypal.com', 'PayPal', 'rickscorpio@proton.me', 'a3N5SE95bGQ1cnJpOXRyWEdVZkMyUT09Ojr6gJU/+KFSDAeu6bo706gu'),
(6, 'https://sourceforge.net/', 'Sourceforge', 'klyxmaster', 'M1crSjZMbXVxWWY1SHpTUjZPTi9FT0hiU3diZjJ1SGN5WVJvWjhZb1FoTT06Oj+xSAh06gyvwLtOYAx/D6E='),
(7, 'https://dnsexit.com/Login.sv', 'DNS Exit', 'klyxmaster', 'VzFIOEsvNy80QzhoUC83N1AxVkxQUT09Ojqlj7ruoZX/T9K8cK0C/tNA'),
(8, 'https://www.target.com', 'Target', '6122316689', 'OFNmOGttTUxWRXVxYWRZcnA3c1dqSkpkdStHd2RqMEdXS1VCZTBocDNTWT06Ojk4cVJ0+81b2nvm31hjn/c='),
(9, 'https://www.amazon.com', 'Amazon', 'rickscorpio@proton.me', 'MXNXTk0xdnQ2WEtDSThua2I1KzVhZz09OjoSI3j6CkEgCfTyKZmtqqC2'),
(10, 'https://capitalone.com', 'Capital One', 'rscorpio64', 'ZEpJOGVsU2pGZmFHTU94ZklNaXVkWC93L2ljekxsaDBDT21teDF5WUJWST06Oll1PMVhwAlAsMU2nJXwpS0='),
(11, 'https://www.ally.com', 'Ally Online Banking', 'rscorpio64', 'c1VXUkpZSys2cDRaN0U3SVlvanY2Zz09OjpVmWkXnDQNCWXwbTjz3sPT');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bankdetails`
--
ALTER TABLE `bankdetails`
  ADD PRIMARY KEY (`Bank_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `websitedetails`
--
ALTER TABLE `websitedetails`
  ADD PRIMARY KEY (`Web_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bankdetails`
--
ALTER TABLE `bankdetails`
  MODIFY `Bank_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `websitedetails`
--
ALTER TABLE `websitedetails`
  MODIFY `Web_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
