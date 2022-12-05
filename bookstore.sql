-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 22, 2022 at 05:42 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bookstore`
--

-- --------------------------------------------------------

--
-- Table structure for table `book`
--

CREATE TABLE `book` (
  `isbn` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `authors` varchar(255) NOT NULL,
  `genres` varchar(250) NOT NULL,
  `publisher_id` varchar(250) NOT NULL,
  `no_of_pages` varchar(100) NOT NULL,
  `b_price` varchar(100) NOT NULL,
  `price` varchar(100) NOT NULL,
  `quantity` varchar(100) NOT NULL,
  `publisher_share` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `book`
--

INSERT INTO `book` (`isbn`, `name`, `authors`, `genres`, `publisher_id`, `no_of_pages`, `b_price`, `price`, `quantity`, `publisher_share`) VALUES
('B001', 'The river', 'mac morgan', 'Literature', 'P001', '234', '80', '120', '10', '20'),
('B002', 'Psychology', 'Ngugi, Peter', 'Drama', 'P002', '34', '50', '70', '12', '12'),
('B003', 'chem', 'Jane Harrison', 'Action', 'P003', '54', '45', '65', '9', '31');

-- --------------------------------------------------------

--
-- Table structure for table `expenditure`
--

CREATE TABLE `expenditure` (
  `expenditure_id` int(11) NOT NULL,
  `publisher_id` varchar(250) NOT NULL,
  `isbn` varchar(255) NOT NULL,
  `quantity` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `expenditure`
--

INSERT INTO `expenditure` (`expenditure_id`, `publisher_id`, `isbn`, `quantity`) VALUES
(1, 'P001', 'B001', '1'),
(2, 'P003', 'B003', '3'),
(3, 'P001', 'B001', '5');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` varchar(250) NOT NULL,
  `books` text NOT NULL,
  `f_name` varchar(255) NOT NULL,
  `l_name` varchar(250) NOT NULL,
  `country` varchar(100) NOT NULL,
  `city` varchar(100) NOT NULL,
  `state` varchar(100) NOT NULL,
  `postal_code` varchar(100) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `shipping_address` text NOT NULL,
  `status` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `books`, `f_name`, `l_name`, `country`, `city`, `state`, `postal_code`, `phone`, `shipping_address`, `status`) VALUES
('WOVHEGTH', 'a:2:{i:0;a:4:{s:10:\"product_id\";s:4:\"B001\";s:16:\"product_quantity\";i:2;s:12:\"product_name\";s:9:\"The river\";s:13:\"product_price\";s:3:\"120\";}i:1;a:4:{s:10:\"product_id\";s:4:\"B002\";s:16:\"product_quantity\";i:1;s:12:\"product_name\";s:10:\"Psychology\";s:13:\"product_price\";s:2:\"70\";}}', 'lawrence', 'wawesh', 'Kenye', 'Nairobi', 'Machakos', '10900', '0745678987', 'katoloni kenye', 'Order Processed');

-- --------------------------------------------------------

--
-- Table structure for table `publisher`
--

CREATE TABLE `publisher` (
  `publisher_id` varchar(100) NOT NULL,
  `name` varchar(250) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` text NOT NULL,
  `phone` varchar(250) NOT NULL,
  `banking_account` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `publisher`
--

INSERT INTO `publisher` (`publisher_id`, `name`, `email`, `address`, `phone`, `banking_account`) VALUES
('P001', 'Jane Harrison', 'jane@gmail.com', 'London, England', '', '53468274878'),
('P002', 'Lawrence', 'lawrence@gmail.com', 'address 1', '54627828', '3556644346'),
('P003', 'John Terry', 'john@gmail.com', 'address 3', '4577333776', '884577563'),
('P004', 'Esther', 'esther@gmail.com', '123, califonia', '0799568786', '35374537');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `isbn` varchar(250) NOT NULL,
  `quantity` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `isbn`, `quantity`) VALUES
(1, 'B001', '6'),
(2, 'B002', '2');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `username` varchar(250) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(250) NOT NULL,
  `address` text NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_id`, `username`, `email`, `phone`, `address`, `password`, `role`) VALUES
(1, 'lawre', 'admin@gmail.com', '0745678987', 'kamakis', 'lawre', 'admin'),
(2, 'wawesh', 'oduor@gmail.com', '0718944365', 'kamakis', 'lawre', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `book`
--
ALTER TABLE `book`
  ADD PRIMARY KEY (`isbn`);

--
-- Indexes for table `expenditure`
--
ALTER TABLE `expenditure`
  ADD PRIMARY KEY (`expenditure_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `publisher`
--
ALTER TABLE `publisher`
  ADD PRIMARY KEY (`publisher_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `expenditure`
--
ALTER TABLE `expenditure`
  MODIFY `expenditure_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
