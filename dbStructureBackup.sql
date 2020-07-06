-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Jul 07, 2020 at 01:32 AM
-- Server version: 10.1.40-MariaDB
-- PHP Version: 7.3.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `MainLand`
--

-- --------------------------------------------------------

--
-- Table structure for table `Action_log`
--

CREATE TABLE `Action_log` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admin_login`
--

CREATE TABLE `admin_login` (
  `id` int(11) NOT NULL,
  `token` text NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Houses`
--

CREATE TABLE `Houses` (
  `id` int(11) NOT NULL,
  `description` text NOT NULL,
  `fixed_price` varchar(50) NOT NULL,
  `onInstalment` tinyint(1) NOT NULL DEFAULT '0',
  `status` set('listed','unlisted','sold') NOT NULL DEFAULT 'listed',
  `size_measure_unit` set('sqft','sqm','sqkm','hectare','car park') NOT NULL DEFAULT 'car park',
  `size_measurement` int(11) NOT NULL,
  `category` set('new','distressed') NOT NULL,
  `address` varchar(255) NOT NULL,
  `Country` set('Nigeria') NOT NULL DEFAULT 'Nigeria',
  `State` set('Lagos') NOT NULL DEFAULT 'Lagos',
  `area_located` varchar(50) NOT NULL,
  `propType` set('detached','semi-detached','terraced') NOT NULL,
  `houseCategory` set('Duplex','Shopping Complex','bungalow') NOT NULL DEFAULT 'Duplex',
  `fixed_price_currency` set('NGN') NOT NULL DEFAULT 'NGN',
  `room` int(11) NOT NULL,
  `bath` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `last_updated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `amenities` text,
  `features` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `House_instalment_plan`
--

CREATE TABLE `House_instalment_plan` (
  `id` int(11) NOT NULL,
  `house_id` int(11) NOT NULL,
  `per` set('week','month','year') NOT NULL,
  `instalment` varchar(50) NOT NULL,
  `minPayTimes` int(11) NOT NULL,
  `maxPayTimes` int(11) NOT NULL,
  `currency` set('NGN') NOT NULL DEFAULT 'NGN'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `House_photo_gallery`
--

CREATE TABLE `House_photo_gallery` (
  `id` int(11) NOT NULL,
  `view` set('front','back','bath','dinning','right','left','kitchen','bed','palour') DEFAULT NULL,
  `house_id` int(11) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `ext` varchar(100) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `House_request`
--

CREATE TABLE `House_request` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `fullName` varchar(100) NOT NULL,
  `personal_note` varchar(255) DEFAULT NULL,
  `payment_duration` int(11) NOT NULL DEFAULT '1',
  `house_id` int(11) NOT NULL,
  `offer` set('full','installment') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `site_setting`
--

CREATE TABLE `site_setting` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `value` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Action_log`
--
ALTER TABLE `Action_log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `admin_login`
--
ALTER TABLE `admin_login`
  ADD UNIQUE KEY `id` (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `Houses`
--
ALTER TABLE `Houses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `House_instalment_plan`
--
ALTER TABLE `House_instalment_plan`
  ADD PRIMARY KEY (`id`),
  ADD KEY `house_id` (`house_id`);

--
-- Indexes for table `House_photo_gallery`
--
ALTER TABLE `House_photo_gallery`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `image` (`image`),
  ADD KEY `house_id` (`house_id`);

--
-- Indexes for table `House_request`
--
ALTER TABLE `House_request`
  ADD PRIMARY KEY (`id`),
  ADD KEY `house_id` (`house_id`);

--
-- Indexes for table `site_setting`
--
ALTER TABLE `site_setting`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Action_log`
--
ALTER TABLE `Action_log`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_login`
--
ALTER TABLE `admin_login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `Houses`
--
ALTER TABLE `Houses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `House_instalment_plan`
--
ALTER TABLE `House_instalment_plan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `House_photo_gallery`
--
ALTER TABLE `House_photo_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `House_request`
--
ALTER TABLE `House_request`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `site_setting`
--
ALTER TABLE `site_setting`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `House_instalment_plan`
--
ALTER TABLE `House_instalment_plan`
  ADD CONSTRAINT `House_instalment_plan_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `Houses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `House_photo_gallery`
--
ALTER TABLE `House_photo_gallery`
  ADD CONSTRAINT `House_photo_gallery_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `Houses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `House_request`
--
ALTER TABLE `House_request`
  ADD CONSTRAINT `House_request_ibfk_1` FOREIGN KEY (`house_id`) REFERENCES `Houses` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
