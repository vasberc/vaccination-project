-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 20, 2022 at 12:20 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.3.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `berkovits_ioannidis_ge3`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `vaccination_center_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `completed` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `surname` varchar(64) NOT NULL,
  `amka` varchar(11) NOT NULL,
  `afm` varchar(9) NOT NULL,
  `adt` varchar(10) NOT NULL,
  `sex` enum('male','female') DEFAULT NULL,
  `email` varchar(64) DEFAULT NULL,
  `age` int(3) NOT NULL,
  `mobile` varchar(10) NOT NULL,
  `isDoctor` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `vaccination-centers`
--

CREATE TABLE `vaccination-centers` (
  `vaccination_center_id` int(11) NOT NULL,
  `name` varchar(36) NOT NULL,
  `address` varchar(256) NOT NULL,
  `post_code` int(5) NOT NULL,
  `telephone_number` bigint(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vaccination-centers`
--

INSERT INTO `vaccination-centers` (`vaccination_center_id`, `name`, `address`, `post_code`, `telephone_number`) VALUES
(1, 'Εμβολιαστικό κέντρο Αθήνας', 'Εβεργέτου Γιάβαση, Αγία Παρασκευή', 15342, 2102102102),
(2, 'Εμβολιαστικό κέντρο Θεσσαλονίκης', 'Εγνατία 144', 54622, 2310231023);

-- --------------------------------------------------------

--
-- Table structure for table `vaccination_centers_doctors`
--

CREATE TABLE `vaccination_centers_doctors` (
  `vaccination_centers_doctors_id` int(11) NOT NULL,
  `vaccination_center_id` int(11) NOT NULL,
  `doctor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD UNIQUE KEY `unique_time_slot` (`vaccination_center_id`,`date`,`time`),
  ADD UNIQUE KEY `user_id` (`user_id`) USING BTREE;

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `amka` (`amka`),
  ADD UNIQUE KEY `afm` (`afm`);

--
-- Indexes for table `vaccination-centers`
--
ALTER TABLE `vaccination-centers`
  ADD PRIMARY KEY (`vaccination_center_id`);

--
-- Indexes for table `vaccination_centers_doctors`
--
ALTER TABLE `vaccination_centers_doctors`
  ADD PRIMARY KEY (`vaccination_centers_doctors_id`),
  ADD KEY `vaccination_center_id` (`vaccination_center_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `vaccination-centers`
--
ALTER TABLE `vaccination-centers`
  MODIFY `vaccination_center_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vaccination_centers_doctors`
--
ALTER TABLE `vaccination_centers_doctors`
  MODIFY `vaccination_centers_doctors_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`vaccination_center_id`) REFERENCES `vaccination-centers` (`vaccination_center_id`);

--
-- Constraints for table `vaccination_centers_doctors`
--
ALTER TABLE `vaccination_centers_doctors`
  ADD CONSTRAINT `vaccination_centers_doctors_ibfk_1` FOREIGN KEY (`vaccination_center_id`) REFERENCES `vaccination-centers` (`vaccination_center_id`),
  ADD CONSTRAINT `vaccination_centers_doctors_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
