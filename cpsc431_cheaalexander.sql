-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2023 at 11:16 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `countmein`
--
CREATE DATABASE IF NOT EXISTS `countmein` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `countmein`;

-- --------------------------------------------------------

--
-- Table structure for table `cmi-users`
--

DROP TABLE IF EXISTS `cmi-users`;
CREATE TABLE `cmi-users` (
  `idx` int(11) NOT NULL,
  `id` varchar(36) NOT NULL,
  `first-name` varchar(255) NOT NULL,
  `last-name` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `addr1` varchar(255) NOT NULL,
  `addr2` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `zip` int(18) NOT NULL,
  `phone` varchar(18) NOT NULL,
  `email` varchar(255) NOT NULL,
  `image` mediumblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cmi-users`
--

INSERT INTO `cmi-users` (`idx`, `id`, `first-name`, `last-name`, `dob`, `addr1`, `addr2`, `city`, `state`, `zip`, `phone`, `email`, `image`) VALUES
(9, '88767c62-f3e8-11ed-acd5-244bfedee9a7', 'Alex', 'Not', '1999-09-13', '123', '', '1234', '1235', 1236, '1237', 'poop2@gmail.com', 0x7468756d622d3135323931392e706e67),
(14, '8dfd9071-f689-11ed-94aa-244bfedee9a7', 'Test', 'Person', '2018-01-19', '123 CSUF Lane', '', 'Fullerton', 'CA', 91770, '1231231234', 'myemail@gmail.com', 0x7468756d622d3135323931392e706e67);

--
-- Triggers `cmi-users`
--
DROP TRIGGER IF EXISTS `user-id`;
DELIMITER $$
CREATE TRIGGER `user-id` BEFORE INSERT ON `cmi-users` FOR EACH ROW SET NEW.id = UUID()
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cmi-users`
--
ALTER TABLE `cmi-users`
  ADD PRIMARY KEY (`idx`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cmi-users`
--
ALTER TABLE `cmi-users`
  MODIFY `idx` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
