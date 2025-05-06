-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 12, 2024 at 07:59 AM
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
-- Database: `colorpix_randion`
--

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `person_id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `number` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `upi` varchar(20) DEFAULT NULL,
  `balance` varchar(255) DEFAULT NULL,
  `photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`person_id`, `name`, `number`, `password`, `email`, `upi`, `balance`, `photo`) VALUES
(1, 'Avengert', '6252361360', '123', 'avenger@gmail.com', '', '64', 'photos/Cashback.png'),
(2, 'Vector', '123', '123', 'earningaswin@gmail.com1', '21312', '9731', 'https://ui-avatars.com/api/?name=User&format=svg&background=random'),
(3, 'Prince Bhai', '6299411626', 'Bhaijaan007', 'ashokstm7258@gmail.com', 'Prince-k09@paytm', '0.00', 'https://ui-avatars.com/api/?name=User&format=svg&background=random');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int NOT NULL,
  `user` varchar(255) NOT NULL,
  `merchant` varchar(255) DEFAULT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `type` varchar(10) DEFAULT NULL,
  `date_time` varchar(255) DEFAULT NULL,
  `pic` varchar(255) DEFAULT NULL,
  `trx` varchar(255) NOT NULL,
  `com` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`id`, `user`, `merchant`, `amount`, `type`, `date_time`, `pic`, `trx`, `com`) VALUES
(4, '123', 'Rahul Gateway', 3.00, 'credit', '28 Dec 23 09:30 PM', 'https://ui-avatars.com/api/?name=Rahul+Gateway&format=svg&background=random', '87088f152', ''),
(5, '6252361360', 'Op Gateway', 3.00, 'credit', '28 Dec 23 09:31 PM', 'https://ui-avatars.com/api/?name=Op+Gateway&format=svg&background=random', '226935cf4', ''),
(6, '6252361360', 'Op Gateway', 3.00, 'credit', '28 Dec 23 09:31 PM', 'https://ui-avatars.com/api/?name=Op+Gateway&format=svg&background=random', '6a0454661', ''),
(7, '6252361360', 'Op Gateway', 3.00, 'credit', '28 Dec 23 09:37 PM', 'https://ui-avatars.com/api/?name=Op+Gateway&format=svg&background=random', 'c144700cb', 'Campaign Payment'),
(8, '123', 'Op Gateway', 3.00, 'credit', '28 Dec 23 09:40 PM', 'https://ui-avatars.com/api/?name=Op+Gateway&format=svg&background=random', 'bb9bd4ae4', 'Campaign Payment'),
(9, '123', 'Op Gateway', 3.00, 'credit', '28 Dec 23 09:40 PM', 'https://ui-avatars.com/api/?name=Op+Gateway&format=svg&background=random', '7bec334ff', 'Campaign Payment'),
(10, '123', 'Avenger', 1.00, 'credit', '08-Jan-24 03:01:40', 'nil', '89keicfn7z', 'giveaway'),
(11, '123', 'Avenger', 1.00, 'credit', '08-Jan-24 03:08:16', 'nil', 'swmblv8fjd', 'giveaway'),
(12, '123', 'Avenger', 1.00, 'credit', '08-Jan-24 08:38:56', 'nil', '7vuc8jw9rm', 'giveaway'),
(13, '123', 'Avenger', 1.00, 'credit', '08-Jan-24 08:42:56', 'nil', 'n8awhjx5v9', 'giveaway'),
(14, '123', 'Avenger', 1.00, 'credit', '08-Jan-24 12:46:55', 'nil', '8a7eu2xfjb', '{comment}'),
(15, '123', 'Avenger', 1.00, 'credit', '12-Jan-24 08:40:38', 'https://ui-avatars.com/api/?name=Avenger&format=svg&baqckground=random', 'u5qnl9b0de', 'test'),
(16, '123', 'Avenger', 1.00, 'credit', '12-Jan-24 08:43:06', 'https://ui-avatars.com/api/?name=Avenger&format=svg&baqckground=random', 'k026ue5mln', 'test'),
(17, '123', 'Avenger', 1.00, 'credit', '12-Jan-24 08:44:35', 'https://ui-avatars.com/api/?name=Avenger&format=svg&baqckground=random', 'fb85yvj1z7', 'test'),
(18, '123', 'Avenger', 1.00, 'credit', '12-Jan-24 08:45:17', 'https://ui-avatars.com/api/?name=Avenger&format=svg&baqckground=random', 'oxqvurl9nj', 'test'),
(19, '123', 'Avenger', 1.00, 'credit', '12-Jan-24 08:46:41', 'https://ui-avatars.com/api/?name=Avenger&format=svg&baqckground=random', 'w0fqylontu', 'test'),
(20, '123', 'Avenger', 1.00, 'credit', '12-Jan-24 08:46:47', 'https://ui-avatars.com/api/?name=Avenger&format=svg&baqckground=random', 'ig1o698c4n', 'test'),
(21, '123', 'Avenger', 1.00, 'credit', '12-Jan-24 08:47:09', 'https://ui-avatars.com/api/?name=Avenger&format=svg&baqckground=random', 'em1rlaxscw', 'test'),
(22, '123', 'Avenger', 1.00, 'credit', '12-Jan-24 08:47:48', 'https://ui-avatars.com/api/?name=Avenger&format=svg&baqckground=random', 'yjb0loitf3', 'test'),
(23, '123', 'Avenger', 0.00, 'credit', '12-Jan-24 08:48:18', 'https://ui-avatars.com/api/?name=Avenger&format=svg&baqckground=random', '2qcl7syu4n', 'test'),
(24, '123', 'Avenger', 0.00, 'credit', '12-Jan-24 08:48:22', 'https://ui-avatars.com/api/?name=Avenger&format=svg&baqckground=random', '87iqulkh93', 'test'),
(25, '123', 'Avenger', 0.00, 'credit', '12-Jan-24 08:48:48', 'https://ui-avatars.com/api/?name=Avenger&format=svg&baqckground=random', 'gb0z43xoat', 'test'),
(26, '123', 'Avenger', 1.00, 'credit', '12-Jan-24 08:50:29', 'https://ui-avatars.com/api/?name=Avenger&format=svg&baqckground=random', 'sx6mfuq7vd', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `withdraw`
--

CREATE TABLE `withdraw` (
  `id` int NOT NULL,
  `user` varchar(255) DEFAULT NULL,
  `time` varchar(255) DEFAULT NULL,
  `type` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `trxid` varchar(255) DEFAULT NULL,
  `amount` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `withdraw`
--

INSERT INTO `withdraw` (`id`, `user`, `time`, `type`, `status`, `trxid`, `amount`) VALUES
(1, '123', '29-Dec-23 04:33 PM', 'paytm', 'pending', '7a1324', '20'),
(2, '123', '30-Dec-23 10:12 AM', 'paytm', 'pending', '851473', '20'),
(3, '123', '30-Dec-23 08:21 PM', 'paytm', 'pending', '2e9360', '11'),
(4, '123', '30-Dec-23 08:22 PM', 'paytm', 'pending', 'd65467', '120'),
(5, '123', '30-Dec-23 08:22 PM', 'paytm', 'pending', 'beed1d', '11');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`person_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `withdraw`
--
ALTER TABLE `withdraw`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `person_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `withdraw`
--
ALTER TABLE `withdraw`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
