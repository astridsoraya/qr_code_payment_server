-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 15, 2018 at 04:32 PM
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
-- Database: `qrcode_payment`
--

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id_barang` varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `nama_barang` varchar(70) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `harga` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `id_merchant` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id_barang`, `nama_barang`, `harga`, `stok`, `id_merchant`) VALUES
('inf001', 'Ayam Geprek', 18000, 5, '1521021842');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id_customer` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(30) NOT NULL,
  `first_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(30) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email_address` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` char(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `handphone_number` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `digital_certificate` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`id_customer`, `username`, `first_name`, `last_name`, `email_address`, `password`, `handphone_number`, `digital_certificate`) VALUES
('1521091509', 'logitech', 'Logi', 'Tech', 'logitech@yahoo.com', '$2y$12$xmeSKxoMhaYg.82qWtrU7uCPccLqv1yZD/drlpxGGOj0RwkVBHgE6', '0816164661', 'logitech@yahoo.com.crt');

-- --------------------------------------------------------

--
-- Table structure for table `merchant`
--

CREATE TABLE `merchant` (
  `id_merchant` char(10) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `username` varchar(30) NOT NULL,
  `merchant_name` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `email_address` varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `password` char(64) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(75) NOT NULL,
  `handphone_number` varchar(16) CHARACTER SET utf8 COLLATE utf8_unicode_ci DEFAULT NULL,
  `digital_certificate` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `merchant`
--

INSERT INTO `merchant` (`id_merchant`, `username`, `merchant_name`, `email_address`, `password`, `address`, `handphone_number`, `digital_certificate`) VALUES
('1521021842', 'infinitystore', 'Infinite Store', 'infinite@gmail.com', '$2y$12$WlsJbGvd94ZuOVYu52NxBOMDPKuBbDvAtmx4rnd1aynDUcvogvrQ.', 'Jalan Kopo Bandung', '0816161661', 'infinite@gmail.com.crt');

-- --------------------------------------------------------

--
-- Table structure for table `order`
--

CREATE TABLE `order` (
  `id_order` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `waktu_order` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_merchant` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_customer` char(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id_order` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `id_barang` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `kuantitas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `id_payment` char(20) COLLATE utf8_unicode_ci NOT NULL,
  `waktu_bayar` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_customer` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `id_merchant` char(10) COLLATE utf8_unicode_ci NOT NULL,
  `id_order` char(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `wallet`
--

CREATE TABLE `wallet` (
  `id_wallet` char(16) COLLATE utf8_unicode_ci NOT NULL,
  `saldo` int(11) NOT NULL,
  `pin` char(64) COLLATE utf8_unicode_ci NOT NULL,
  `id_customer` char(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `id_merchant` char(10) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wallet`
--

INSERT INTO `wallet` (`id_wallet`, `saldo`, `pin`, `id_customer`, `id_merchant`) VALUES
('1803141104116964', 0, '$2y$12$CnxoBsZT.Yq1ySYbwy8SNeuZBg/8uz4qegmYuVl6J0Grd6LwI525m', NULL, '1521021842'),
('1803150625169620', 0, '$2y$12$hmgo1d0NZkFLpL18wotToO.FnWeb2mgXY5w6NDmSi0j1zO0dHxHCq', '1521091509', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `id_merchant` (`id_merchant`);

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id_customer`),
  ADD UNIQUE KEY `email_address` (`email_address`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `merchant`
--
ALTER TABLE `merchant`
  ADD PRIMARY KEY (`id_merchant`),
  ADD UNIQUE KEY `email_address` (`email_address`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`id_order`),
  ADD KEY `id_merchant` (`id_merchant`),
  ADD KEY `id_customer` (`id_customer`) USING BTREE;

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_barang` (`id_barang`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`id_payment`),
  ADD KEY `id_order` (`id_order`),
  ADD KEY `id_customer` (`id_customer`),
  ADD KEY `id_merchant` (`id_merchant`);

--
-- Indexes for table `wallet`
--
ALTER TABLE `wallet`
  ADD PRIMARY KEY (`id_wallet`),
  ADD KEY `id_user` (`id_customer`),
  ADD KEY `id_merchant` (`id_merchant`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `barang_ibfk_1` FOREIGN KEY (`id_merchant`) REFERENCES `merchant` (`id_merchant`);

--
-- Constraints for table `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`id_merchant`) REFERENCES `merchant` (`id_merchant`),
  ADD CONSTRAINT `order_ibfk_3` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`);

--
-- Constraints for table `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`),
  ADD CONSTRAINT `order_items_ibfk_3` FOREIGN KEY (`id_order`) REFERENCES `order` (`id_order`);

--
-- Constraints for table `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`),
  ADD CONSTRAINT `payment_ibfk_4` FOREIGN KEY (`id_order`) REFERENCES `order` (`id_order`),
  ADD CONSTRAINT `payment_ibfk_5` FOREIGN KEY (`id_merchant`) REFERENCES `merchant` (`id_merchant`);

--
-- Constraints for table `wallet`
--
ALTER TABLE `wallet`
  ADD CONSTRAINT `wallet_ibfk_1` FOREIGN KEY (`id_customer`) REFERENCES `customer` (`id_customer`),
  ADD CONSTRAINT `wallet_ibfk_2` FOREIGN KEY (`id_merchant`) REFERENCES `merchant` (`id_merchant`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
