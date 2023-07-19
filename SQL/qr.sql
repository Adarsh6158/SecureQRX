-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 19, 2023 at 09:13 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `qr`
--

-- --------------------------------------------------------

--
-- Table structure for table `color`
--

CREATE TABLE `color` (
  `id` int(11) NOT NULL,
  `color` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `color`
--

INSERT INTO `color` (`id`, `color`, `status`) VALUES
(1, 'FFFFFF', 1),
(2, 'ff0000', 1),
(3, '1ab2ff', 1),
(4, '00ff00', 1),
(5, 'ff00ff', 1),
(6, 'ffa500', 1),
(7, '0000ff', 1),
(8, 'ffff00', 1);

-- --------------------------------------------------------

--
-- Table structure for table `qr_code`
--

CREATE TABLE `qr_code` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `link` varchar(255) NOT NULL,
  `color` varchar(255) DEFAULT NULL,
  `size` varchar(255) DEFAULT NULL,
  `added_by` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `qr_code`
--

INSERT INTO `qr_code` (`id`, `name`, `link`, `color`, `size`, `added_by`, `status`, `added_on`) VALUES
(1, 'Adarsh', 'https://adarshkm.000webhostapp.com/', 'ff0000', '250x250', 2, 1, '2023-07-17 02:15:56'),
(2, 'yash', 'https://www.youtube.com/watch?v=7THTzZ3nA9M', '1ab2ff', '200x200', 2, 1, '2023-07-17 02:18:47'),
(3, 'hvsa', 'https://adarshkm.000webhostapp.com/', '1ab2ff', '300x300', 1, 1, '2023-07-17 04:00:19');

-- --------------------------------------------------------

--
-- Table structure for table `qr_traffic`
--

CREATE TABLE `qr_traffic` (
  `id` int(11) NOT NULL,
  `qr_code_id` int(11) NOT NULL,
  `device` varchar(50) DEFAULT NULL,
  `os` varchar(100) NOT NULL,
  `browser` varchar(50) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(50) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `added_on` datetime NOT NULL,
  `added_on_str` date NOT NULL,
  `ip_address` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `qr_traffic`
--

INSERT INTO `qr_traffic` (`id`, `qr_code_id`, `device`, `os`, `browser`, `city`, `state`, `country`, `added_on`, `added_on_str`, `ip_address`) VALUES
(1, 1, 'PC', 'Window', 'Chrome', 'Bengaluru', 'Karnataka', 'India', '2023-07-17 06:37:09', '2023-07-17', '152.58.230.186');

-- --------------------------------------------------------

--
-- Table structure for table `size`
--

CREATE TABLE `size` (
  `id` int(11) NOT NULL,
  `size` varchar(255) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `size`
--

INSERT INTO `size` (`id`, `size`, `status`) VALUES
(1, '100x100', 1),
(2, '200x200', 1),
(3, '300x300', 1),
(4, '250x250', 1),
(5, '500x500', 1);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `total_qr` int(11) NOT NULL,
  `total_hit` int(11) NOT NULL,
  `role` enum('0','1') NOT NULL COMMENT '0=>"Admin",1=>"User"',
  `status` int(11) NOT NULL,
  `added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `total_qr`, `total_hit`, `role`, `status`, `added_on`) VALUES
(1, 'SecureQRX Master', 'admin@gmail.com', '$2y$10$qfqAzwe5GUUO49FD5CW0lez7hjZEwwUF5klPye427GbWZ09HWU2nK', 0, 0, '0', 1, '2021-03-18 01:14:55'),
(2, 'Adarsh', 'adarshkumar6158@gmail.com', '$2y$10$QVkeIxXXlXjxYRa/tNW4dOTpKbQud7STkDCMd96xsNwkj.k0Y4Tnm', 2, 3, '1', 1, '2023-07-17 02:14:36'),
(4, 'Addy abc', 'projectmail6158@gmail.com', '$2y$10$XwijBLEYMslVe0ZsN5S.y.NIA98ZhBIBb299PG9vMqXDT9shqRO1m', 2, 3, '1', 1, '2023-07-19 08:24:39');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qr_code`
--
ALTER TABLE `qr_code`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `qr_traffic`
--
ALTER TABLE `qr_traffic`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `size`
--
ALTER TABLE `size`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `color`
--
ALTER TABLE `color`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `qr_code`
--
ALTER TABLE `qr_code`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `qr_traffic`
--
ALTER TABLE `qr_traffic`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `size`
--
ALTER TABLE `size`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
