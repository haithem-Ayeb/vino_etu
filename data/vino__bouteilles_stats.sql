-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 06, 2020 at 01:24 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.4.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vino_etu`
--

-- --------------------------------------------------------

--
-- Table structure for table `vino__bouteilles_stats`
--

CREATE TABLE `vino__bouteilles_stats` (
  `id` int(11) NOT NULL,
  `id_bouteille` int(11) NOT NULL,
  `date_changement` datetime NOT NULL,
  `actions` int(11) NOT NULL,
  `quantite` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `vino__bouteilles_stats`
--

INSERT INTO `vino__bouteilles_stats` (`id`, `id_bouteille`, `date_changement`, `actions`, `quantite`) VALUES
(7, 37, '2020-10-01 13:35:36', 1, 1),
(8, 37, '2020-10-01 13:35:37', 1, 1),
(9, 37, '2020-09-30 13:35:40', 1, 1),
(10, 37, '2020-10-04 15:15:22', 2, 1),
(11, 37, '2020-10-04 15:15:23', 2, 1),
(12, 37, '2020-10-04 15:15:23', 2, 1),
(13, 37, '2020-10-04 15:15:23', 2, 1),
(14, 37, '2020-10-04 15:15:26', 1, 1),
(15, 37, '2020-10-04 15:15:27', 1, 1),
(16, 37, '2020-10-04 15:15:27', 1, 1),
(17, 37, '2020-10-05 19:22:10', 2, 1),
(18, 37, '2020-10-05 19:22:11', 2, 1),
(19, 37, '2020-10-05 19:22:11', 1, 1),
(20, 37, '2020-10-05 19:22:12', 1, 1),
(21, 37, '2020-10-05 19:22:13', 2, 1),
(22, 37, '2020-10-05 19:22:13', 2, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `vino__bouteilles_stats`
--
ALTER TABLE `vino__bouteilles_stats`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vino__bouteilles_stats_ibfk` (`id_bouteille`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `vino__bouteilles_stats`
--
ALTER TABLE `vino__bouteilles_stats`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `vino__bouteilles_stats`
--
ALTER TABLE `vino__bouteilles_stats`
  ADD CONSTRAINT `vino__bouteilles_stats_ibfk` FOREIGN KEY (`id_bouteille`) REFERENCES `vino__bouteille` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
