-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 01, 2020 at 05:22 PM
-- Server version: 10.1.30-MariaDB
-- PHP Version: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `qty` int(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `added_by` int(11) NOT NULL,
  `base_price` float DEFAULT NULL,
  `srp` float DEFAULT NULL,
  `lowstock_qty` int(11) DEFAULT NULL,
  `deleted` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `photo`, `qty`, `status`, `date_created`, `added_by`, `base_price`, `srp`, `lowstock_qty`, `deleted`) VALUES
(33, 'Soju', NULL, 20, 'active', '2020-07-19 03:37:01', 0, 19, 28, NULL, 1),
(34, 'Product 1', '26d1764e757a18bc2c2a1041a5c488fc.jpg', 1, 'active', '2020-08-10 12:21:54', 0, 0, 0, NULL, 0),
(35, 'Product 1', 'ca14a0a5a3d1a8eb13690f614b33f6dc.jpg', 1, 'active', '2020-08-10 12:21:58', 0, 0, 0, NULL, 0),
(36, 'asasddas', 'cb424a2f54ed050e9bde2ba1d7d30120.jpg', 1, 'active', '2020-08-10 12:54:59', 0, 0, 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `itemid` int(11) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `srp` float DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `transaction_id`, `itemid`, `qty`, `srp`, `date_created`) VALUES
(7, 15, 25, 3, 20, '2020-07-19 08:15:27'),
(8, 15, 24, 3, 2, '2020-07-19 08:15:27'),
(9, 15, 33, 50, 28, '2020-07-19 08:15:27'),
(10, 16, 33, 1, 28, '2020-07-19 08:18:09'),
(11, 16, 25, 1, 20, '2020-07-19 08:18:09'),
(12, 16, 24, 1, 2, '2020-07-19 08:18:09'),
(13, 17, 33, 1, 28, '2020-07-19 08:18:53'),
(14, 17, 25, 1, 20, '2020-07-19 08:18:53'),
(15, 17, 24, 1, 2, '2020-07-19 08:18:53'),
(16, 18, 25, 1, 20, '2020-07-19 11:24:39'),
(17, 18, 24, 1, 2, '2020-07-19 11:24:39'),
(18, 19, 25, 5, 20, '2020-07-19 11:25:04'),
(19, 19, 24, 12, 2, '2020-07-19 11:25:04'),
(20, 20, 25, 1, 20, '2020-07-19 12:23:29'),
(21, 20, 24, 1, 2, '2020-07-19 12:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `transaction`
--

CREATE TABLE `transaction` (
  `id` int(11) NOT NULL,
  `userid` int(11) NOT NULL,
  `total` float NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `transaction`
--

INSERT INTO `transaction` (`id`, `userid`, `total`, `date_created`) VALUES
(14, 8, 1466, '2020-07-19 08:14:35'),
(15, 8, 1466, '2020-07-19 08:15:27'),
(16, 8, 50, '2020-07-19 08:18:09'),
(17, 8, 50, '2020-07-19 08:18:53'),
(18, 8, 22, '2020-07-19 11:24:38'),
(19, 8, 124, '2020-07-19 11:25:03'),
(20, 8, 22, '2020-07-19 12:23:29');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT '"employee"',
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `password`, `type`, `date_created`) VALUES
(8, 'cyborg999', '5c07f19fdd6ce3b1a588f71d11ee2b23', '\"employee\"', '2020-07-03 06:11:39'),
(9, 'loki999', '5c07f19fdd6ce3b1a588f71d11ee2b23', '\"employee\"', '2020-07-03 06:12:39'),
(10, 'loki999', '5c07f19fdd6ce3b1a588f71d11ee2b23', '\"employee\"', '2020-07-03 06:12:45'),
(11, 'loki999', '5c07f19fdd6ce3b1a588f71d11ee2b23', '\"employee\"', '2020-07-03 06:13:15'),
(12, 'loki9999', '5c07f19fdd6ce3b1a588f71d11ee2b23', '\"employee\"', '2020-07-03 06:18:19'),
(13, 'loki99999', '76d7967608bd5411c6260d434d7fec6a', '\"employee\"', '2020-07-03 06:19:00'),
(14, 'lkadakjdh', '11a4128c5cc7b8bc080eb3a3d87ae5c7', '\"employee\"', '2020-07-03 06:19:42');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaction`
--
ALTER TABLE `transaction`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `transaction`
--
ALTER TABLE `transaction`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
