-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 12, 2024 at 07:56 AM
-- Server version: 8.0.35
-- PHP Version: 8.1.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `colorpix_merchant`
--

-- --------------------------------------------------------

--
-- Table structure for table `balance`
--

CREATE TABLE `balance` (
  `id` int NOT NULL,
  `number` varchar(15) NOT NULL,
  `balance` decimal(10,2) DEFAULT '0.00',
  `totalpayout` decimal(10,2) DEFAULT '0.00',
  `status` varchar(20) DEFAULT 'Active',
  `freeze` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `balance`
--

INSERT INTO `balance` (`id`, `number`, `balance`, `totalpayout`, `status`, `freeze`) VALUES
(1, '123', 191.40, 0.00, 'normal', 0);

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `number` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `mid` varchar(10) NOT NULL,
  `tgid` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`id`, `name`, `number`, `email`, `password`, `photo`, `mid`, `tgid`) VALUES
(1, 'Avenger', '123', 'avenger@gmail.com', 'avenger', 'https://ui-avatars.com/api/?name=Avenger&format=svg&background=random', 'f0o4fh6d8l', '1320785887');

-- --------------------------------------------------------

--
-- Table structure for table `recharge`
--

CREATE TABLE `recharge` (
  `id` int NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `number` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `trxid` varchar(255) NOT NULL,
  `date` varchar(20) NOT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `recharge`
--

INSERT INTO `recharge` (`id`, `amount`, `number`, `trxid`, `date`, `status`) VALUES
(7, 100.00, '123', 'trx659a38c259a1d', '2024-01-07 05:38:10', 'reject'),
(8, 10.00, '123', 'trx659a41f4dc079', '2024-01-07 06:17:24', 'pending'),
(9, 10.00, '123', 'trx659a430d59a05', '2024-01-07 06:22:05', 'pending'),
(10, 12.00, '123', 'trx659a437147d21', '2024-01-07 06:23:45', 'pending'),
(11, 10.00, '123', 'trx659aa26b48412', '2024-01-07 13:08:59', 'paid');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_merchant`
--

CREATE TABLE `transaction_merchant` (
  `id` int NOT NULL,
  `date` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(255) NOT NULL,
  `usernumber` varchar(20) NOT NULL,
  `merchant` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaction_merchant`
--

INSERT INTO `transaction_merchant` (`id`, `date`, `amount`, `status`, `usernumber`, `merchant`) VALUES
(1, '08-Jan-24 03:08:16', 1.00, 'success', '123', ''),
(2, '08-Jan-24 08:38:56', 1.00, 'success', '123', ''),
(3, '08-Jan-24 08:42:56', 1.00, 'success', '123', '123'),
(4, '08-Jan-24 12:46:55', 1.00, 'success', '123', '123'),
(5, '12-Jan-24 08:40:38', 1.00, 'success', '123', '123'),
(6, '12-Jan-24 08:43:06', 1.00, 'success', '123', '123'),
(7, '12-Jan-24 08:44:35', 1.00, 'success', '123', '123'),
(8, '12-Jan-24 08:45:17', 1.00, 'success', '123', '123'),
(9, '12-Jan-24 08:46:41', 1.00, 'success', '123', '123'),
(10, '12-Jan-24 08:46:47', 1.00, 'success', '123', '123'),
(11, '12-Jan-24 08:47:09', 1.00, 'success', '123', '123'),
(12, '12-Jan-24 08:47:48', 1.00, 'success', '123', '123'),
(13, '12-Jan-24 08:48:18', 0.00, 'success', '123', '123'),
(14, '12-Jan-24 08:48:22', 0.00, 'success', '123', '123'),
(15, '12-Jan-24 08:48:48', 0.00, 'success', '123', '123'),
(16, '12-Jan-24 08:50:29', 1.00, 'success', '123', '123');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `balance`
--
ALTER TABLE `balance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `recharge`
--
ALTER TABLE `recharge`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction_merchant`
--
ALTER TABLE `transaction_merchant`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `balance`
--
ALTER TABLE `balance`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `merchant`
--
ALTER TABLE `merchant`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `recharge`
--
ALTER TABLE `recharge`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `transaction_merchant`
--
ALTER TABLE `transaction_merchant`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
