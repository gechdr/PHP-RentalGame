-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 06, 2022 at 03:44 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `t6_6958`
--

CREATE DATABASE IF NOT EXISTS `T6_6958` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `T6_6958`;

--
-- Table structure for table `rents`
--

DROP TABLE IF EXISTS `rents`;

CREATE TABLE `rents` (
  `id_rent` varchar(10) NOT NULL,
  `nomor_ruangan` varchar(10) NOT NULL,
  `jumlah_customer` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `rents`
--

INSERT INTO `rents` (`id_rent`, `nomor_ruangan`, `jumlah_customer`) VALUES
('RE101', '101', 1),
('RE201', '201', 1),
('RE203', '203', 1),
('RE301', '301', 2),
('RE302', '302', 1),
('RE505', '505', 4);

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;

CREATE TABLE `room` (
  `nomor_ruangan` varchar(10) NOT NULL,
  `nama_ruangan` varchar(50) NOT NULL,
  `console` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`nomor_ruangan`, `nama_ruangan`, `console`) VALUES
('101', 'Caspian Sea', 'Switch'),
('201', 'Niflheim', 'PS4'),
('202', 'Jotunheim', 'PS4'),
('203', 'Valhalla', 'PS5'),
('301', 'Chaoscrawlers', 'PS5'),
('302', 'Primorye', 'XBOX'),
('303', 'New Guinea', 'XBOX'),
('501', 'Post Heaven', 'XBOX'),
('505', 'Heaven', 'PS5');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `username` varchar(50) NOT NULL,
  `nama` varchar(64) NOT NULL,
  `email` varchar(64) NOT NULL,
  `password` varchar(25) NOT NULL,
  `id_rents` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`username`, `nama`, `email`, `password`, `id_rents`) VALUES
('aponia', 'Aponia', 'aponia@hoyoverse.com', 'conviction', NULL),
('bronya', 'Bronya', 'bronya.zaychik@hoyoverse.com', 'silverwing', 'RE301'),
('carole', 'Carole', 'carole.pepper@hoyoverse.com', 'sweetnspicy', 'RE505'),
('durandal', 'Durandal', 'durandal@hoyoverse.com', 'equinox', NULL),
('eden', 'Eden', 'eden@hoyoverse.com', 'goldendiva', NULL),
('elysia', 'Elysia', 'elysia.ego@hoyoverse.com', 'humanego', 'RE201'),
('fuhua', 'Fu Hua', 'fu.hua@hoyoverse.com', 'firemoth', 'RE203'),
('griseo', 'Griseo', 'griseo@hoyoverse.com', 'elysianastra', NULL),
('himeko', 'Himeko', 'murata.himeko@hoyoverse.com', 'vermilion', NULL),
('kallen', 'Kallen', 'kallen.kaslana@hoyoverse.com', 'serenade', NULL),
('kiana', 'Kiana', 'kiana.kaslana@hoyoverse.com', 'flamescion', 'RE301'),
('liliya', 'Liliya', 'liliya.olenyeva@hoyoverse.com', 'blueberry', 'RE505'),
('lisushang', 'Li Sushang', 'sushang.li@hoyoverse.com', 'taixuan', 'RE101'),
('mobius', 'Mobius', 'mobius@hoyoverse.com', 'uoroboros', NULL),
('pardofelis', 'Pardofelis', 'pardofelis@hoyoverse.com', 'calico', NULL),
('raidenmei', 'Raiden Mei', 'raiden.mei@hoyoverse.com', 'thunder', 'RE302'),
('raven', 'Natasha Cioara', 'natasha.cioara@hoyoverse.com', 'midnight', NULL),
('rita', 'Rita', 'rita.rossweisse@hoyoverse.com', 'rosemary', NULL),
('rozalia', 'Rozaliya', 'rozalia.olenyeva@hoyoverse.com', 'cherry', 'RE505'),
('seele', 'Seele', 'seele.vollerei@hoyoverse.com', 'nymph', 'RE505'),
('theresa', 'Theresa', 'theresa.apocalypse@hoyoverse.com', 'teriteri', NULL),
('vill-v', 'Vill-V', 'vill-v@hoyoverse.com', 'quantum', NULL),
('yae', 'Yae', 'yae.sakura@hoyoverse.com', 'memento', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `rents`
--
ALTER TABLE `rents`
  ADD PRIMARY KEY (`id_rent`),
  ADD KEY `nomor_ruangan` (`nomor_ruangan`);

--
-- Indexes for table `room`
--
ALTER TABLE `room`
  ADD PRIMARY KEY (`nomor_ruangan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `id_rents` (`id_rents`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `rents`
--
ALTER TABLE `rents`
  ADD CONSTRAINT `nomor_ruangan` FOREIGN KEY (`nomor_ruangan`) REFERENCES `room` (`nomor_ruangan`);

--
-- Constraints for table `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `id_rents` FOREIGN KEY (`id_rents`) REFERENCES `rents` (`id_rent`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
