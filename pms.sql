-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 07, 2025 at 02:52 PM
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
-- Database: `pms`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(10) NOT NULL,
  `name` text NOT NULL,
  `description` varchar(100) NOT NULL,
  `price` int(9) NOT NULL,
  `img` varchar(255) NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `mdescription` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `description`, `price`, `img`, `status`, `mdescription`) VALUES
(26, 'hi', 'hell', 2147483647, 'product_1762500103.png', 'active', 'mkmklllllllmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmmm'),
(28, 'mkmklklk', 'mmmmmmm', 983953987, 'product_1762509392.png', 'active', 'sdfkkk'),
(29, 'sdfgdfsdfcasaf', 'oiscdscsdc', 453647, 'product_1762510591.png', 'active', 'ldfsadksdfksdf'),
(30, 'jncscsjd', 'sadjnasdjasdj', 2147, 'product_1762510846.png', 'active', 'jsdaan'),
(31, 'n', 'lmmmmmmmmmmmmmmmmmmmmmmmmmknnn', 909099, 'product_1762520602.jpg', 'inactive', 'knnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn'),
(32, 'Admin', 'jsdjsdcjscsdd', 9889, 'product_1762522862.jpg', 'active', 'okokoko');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `email` varchar(20) NOT NULL,
  `password` varchar(10) NOT NULL,
  `name` text NOT NULL,
  `mobile` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`email`, `password`, `name`, `mobile`) VALUES
('admin@gmail.com', '11111', 'admin', '989832423432');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
