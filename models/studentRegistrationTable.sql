-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 10, 2025 at 03:40 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `attendancesystem`
--

-- --------------------------------------------------------

--
-- Table structure for table `fingerprint_data`
--

CREATE TABLE `fingerprint_data` (
  `id` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `lastFingerId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fingerprint_data`
--

INSERT INTO `fingerprint_data` (`id`, `status`, `lastFingerId`) VALUES
(1, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `student_info`
--

CREATE TABLE `student_info` (
  `id` int(11) NOT NULL,
  `student_name` varchar(191) NOT NULL,
  `student_roll` varchar(50) NOT NULL,
  `student_reg` varchar(50) NOT NULL,
  `student_session` varchar(50) NOT NULL,
  `student_email` varchar(191) NOT NULL,
  `student_phone` varchar(191) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fingerId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_info`
--

INSERT INTO `student_info` (`id`, `student_name`, `student_roll`, `student_reg`, `student_session`, `student_email`, `student_phone`, `password`, `fingerId`) VALUES
(132, 'Prantic Paul', '21102042', '9909', '2020-21', 'pranticpaulshimul@gmail.com', '+8801739509014', '$2y$10$PJR3RhcG.O9R19BXzVi1PuzwOrkF.Q4L2VQK9ah68lqIlkIpPg/r6', 1),
(133, 'Tuhin', '21102023', '9896', '2020-21', 'shimulpranticpaul@gmail.com', '+8801739509033', '$2y$10$6L2dmrL2QJFo9eT4soypSO85oZv9.3/8FS9bbMuQpmKDLngSkKvOK', 2);

-- --------------------------------------------------------

--
-- Table structure for table `temp_registrations`
--

CREATE TABLE `temp_registrations` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `roll` varchar(50) NOT NULL,
  `reg` varchar(50) NOT NULL,
  `session` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `password` varchar(255) NOT NULL,
  `verification_token` varchar(64) NOT NULL,
  `is_verified` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `fingerprint_data`
--
ALTER TABLE `fingerprint_data`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_info`
--
ALTER TABLE `student_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `student_email` (`student_email`);

--
-- Indexes for table `temp_registrations`
--
ALTER TABLE `temp_registrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `fingerprint_data`
--
ALTER TABLE `fingerprint_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `student_info`
--
ALTER TABLE `student_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;

--
-- AUTO_INCREMENT for table `temp_registrations`
--
ALTER TABLE `temp_registrations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
