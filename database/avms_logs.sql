-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 20, 2024 at 04:35 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `avms_logs`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_logs`
--

CREATE TABLE `admin_logs` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activity_type` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_logs`
--

INSERT INTO `admin_logs` (`id`, `email`, `activity_type`, `user_type`, `timestamp`) VALUES
(1, 'admin@gmail.com', 'Login', 'admin', '2024-11-19 10:25:48'),
(2, 'admin@gmail.com', 'Logout', 'admin', '2024-11-19 10:25:51'),
(3, 'admin@gmail.com', 'Login', 'admin', '2024-11-19 17:35:36'),
(4, 'admin@gmail.com', 'Logout', 'admin', '2024-11-19 18:40:33'),
(5, 'admin@gmail.com', 'Login', 'admin', '2024-11-19 19:03:33'),
(6, 'admin@gmail.com', 'Logout', 'admin', '2024-11-19 19:05:09'),
(7, 'admin@gmail.com', 'Login', 'admin', '2024-11-19 19:12:06'),
(8, 'admin@gmail.com', 'Logout', 'admin', '2024-11-19 19:42:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_logs`
--

CREATE TABLE `user_logs` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `activity_type` varchar(50) NOT NULL,
  `user_type` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_logs`
--

INSERT INTO `user_logs` (`id`, `email`, `activity_type`, `user_type`, `timestamp`) VALUES
(1, 'user@gmail.com', 'Login', 'user', '2024-11-19 10:26:02'),
(2, 'user@gmail.com', 'Logout', 'user', '2024-11-19 10:26:05'),
(3, 'user@gmail.com', 'Login', 'user', '2024-11-19 18:40:41'),
(4, 'user@gmail.com', 'Logout', 'user', '2024-11-19 19:03:21'),
(5, 'user@gmail.com', 'Login', 'user', '2024-11-19 19:05:16'),
(6, 'user@gmail.com', 'Logout', 'user', '2024-11-19 19:12:00'),
(7, 'user@gmail.com', 'Login', 'user', '2024-11-19 19:43:01'),
(8, 'user@gmail.com', 'Logout', 'user', '2024-11-19 19:43:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_logs`
--
ALTER TABLE `admin_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_logs`
--
ALTER TABLE `user_logs`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_logs`
--
ALTER TABLE `admin_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `user_logs`
--
ALTER TABLE `user_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
