-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: mysql-shadowmilo.alwaysdata.net
-- Generation Time: Sep 06, 2026 at 04:20 PM
-- Server version: 11.4.13-MariaDB
-- PHP Version: 8.4.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shadowmilo_gdps`
--
CREATE DATABASE IF NOT EXISTS `shadowmilo_gdps` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `shadowmilo_gdps`;

-- --------------------------------------------------------

--
-- Table structure for table `levels`
--

CREATE TABLE `levels` (
  `levelID` int(11) NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `username` text NOT NULL,
  `userID` int(11) NOT NULL,
  `udid` text NOT NULL,
  `likes` int(11) NOT NULL,
  `downloads` int(11) NOT NULL,
  `gameVersion` int(11) NOT NULL,
  `version` int(11) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `length` int(11) NOT NULL,
  `diff` int(11) NOT NULL,
  `stars` int(11) NOT NULL,
  `featureType` int(11) NOT NULL,
  `featureScore` int(11) NOT NULL,
  `song` int(11) NOT NULL,
  `trendingScore` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `levels`
--

INSERT INTO `levels` (`levelID`, `name`, `description`, `username`, `userID`, `udid`, `likes`, `downloads`, `gameVersion`, `version`, `timestamp`, `length`, `diff`, `stars`, `featureType`, `featureScore`, `song`, `trendingScore`) VALUES
(100, 'test', '', 'ShadowMilo', 1, 'ffffff-a23-cg3-hgdmasj', 0, 3, 1, 1, 213640, 1, 10, 5, 1, 10, 0, -17),
(101, 'shadow hello', 'hellothere', 'test', 71, 'ffffff-a23-cg2-hgddbei', 10, 1001, 1, 2, 173018, 3, 30, 3, 0, 0, 2, -19),
(102, 'you a poopie pants', '', 'Player', 0, '', 1, 0, 1, 1, 0, 0, 20, 3, 1, 100, 0, -14),
(103, 'triple t god', '', 'Player', 0, '', 1, 0, 1, 1, 0, 0, 40, 3, 1, 1, 0, -10),
(104, 'p', '', 'Player', 0, '', 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, -10),
(105, 'p', '', 'Player', 0, '', 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, -2),
(106, 'hey poop', '', 'hi', 0, '', 1, 1, 1, 1, 0, 0, 40, 7, 0, 50, 0, 6);

-- --------------------------------------------------------

--
-- Table structure for table `nonModSends`
--

CREATE TABLE `nonModSends` (
  `levelID` int(11) NOT NULL,
  `rating` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `name` text NOT NULL,
  `rateLevels` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `rateLevels`) VALUES
(1, 'admin', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `username` text NOT NULL,
  `udid` text NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `udid`, `role`) VALUES
('Player', 'ffffffff-f086-89f7-0033-c5870033c587', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `levels`
--
ALTER TABLE `levels`
  ADD PRIMARY KEY (`levelID`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `levels`
--
ALTER TABLE `levels`
  MODIFY `levelID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=107;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
