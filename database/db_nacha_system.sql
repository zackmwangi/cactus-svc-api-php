-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 23, 2023 at 06:52 AM
-- Server version: 5.7.43
-- PHP Version: 8.2.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nacha_lifedb`
--

-- --------------------------------------------------------

--
-- Table structure for table `guardians_badlist_by_email`
--

CREATE TABLE `guardians_badlist_by_email` (
  `guardian_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `remarks` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `guardians_by_email`
--

CREATE TABLE `guardians_by_email` (
  `email` varchar(255) NOT NULL,
  `guardian_uuid` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `primary_gender` enum('Male','Female') NOT NULL,
  `picture_url` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL,
  `recent_logins` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `guardians_by_uuid`
--

CREATE TABLE `guardians_by_uuid` (
  `guardian_uuid` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `nationality` varchar(255) NOT NULL,
  `birthday` date NOT NULL,
  `primary_gender` enum('Male','Female') NOT NULL,
  `picture_url` text NOT NULL,
  `location` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_login` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `registrant_flyby`
--

CREATE TABLE `registrant_flyby` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `flyby_at` datetime NOT NULL,
  `flyby_count` int(4) UNSIGNED NOT NULL DEFAULT '1',
  `reminder_1_schedule_for` datetime NOT NULL,
  `reminder_1_sent` tinyint(1) DEFAULT '0',
  `reminder_1_sent_time` datetime DEFAULT NULL,
  `reminder_1_template_id` varchar(255) DEFAULT NULL,
  `reminder_2_schedule_for` datetime NOT NULL,
  `reminder_2_sent` tinyint(1) DEFAULT '0',
  `reminder_2_sent_time` datetime DEFAULT NULL,
  `reminder_2_template_id` varchar(255) DEFAULT NULL,
  `valid_until` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `registrant_whitelist_by_email`
--

CREATE TABLE `registrant_whitelist_by_email` (
  `guardian_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `remarks` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `guardians_badlist_by_email`
--
ALTER TABLE `guardians_badlist_by_email`
  ADD PRIMARY KEY (`guardian_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `guardians_by_email`
--
ALTER TABLE `guardians_by_email`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `guardian_uuid` (`guardian_uuid`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `guardian_uuid_2` (`guardian_uuid`);

--
-- Indexes for table `guardians_by_uuid`
--
ALTER TABLE `guardians_by_uuid`
  ADD PRIMARY KEY (`guardian_uuid`),
  ADD UNIQUE KEY `guardian_uuid` (`guardian_uuid`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `guardian_uuid_2` (`guardian_uuid`);

--
-- Indexes for table `registrant_flyby`
--
ALTER TABLE `registrant_flyby`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `registrant_whitelist_by_email`
--
ALTER TABLE `registrant_whitelist_by_email`
  ADD PRIMARY KEY (`guardian_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `email_2` (`email`),
  ADD UNIQUE KEY `email_3` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `guardians_badlist_by_email`
--
ALTER TABLE `guardians_badlist_by_email`
  MODIFY `guardian_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrant_flyby`
--
ALTER TABLE `registrant_flyby`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `registrant_whitelist_by_email`
--
ALTER TABLE `registrant_whitelist_by_email`
  MODIFY `guardian_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
