-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 21, 2018 at 04:25 PM
-- Server version: 5.7.21
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `chat`
--

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(16) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(64) NOT NULL,
  `txtcolor` char(6) NOT NULL DEFAULT 'ABA319',
  `bckcolor` char(6) NOT NULL DEFAULT '1C1E06',
  `pending` text NOT NULL,
  `ip` varchar(45) NOT NULL,
  `laston` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` int(16) NOT NULL,
  `quirks` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `txtcolor`, `bckcolor`, `pending`, `ip`, `laston`, `active`, `quirks`) VALUES
(4, 'Sam', '$2y$10$D2zdjbNqBrdN3UzhVWcTTOxefGeQrKOOcrlgtSqOEyGzpHmoN8u3m', '4000ff', 'c0ff00', '', '172.23.28.198', '2018-03-21 16:25:04', 0, 'E'),
(5, 'Oliver', '$2y$10$Hw5uCVGgtB4ZGv1zCyscXez38YD73afsB9pqrt0oLU7pyAdlAhe9C', 'ABA319', '1C1E06', '', '', '2018-03-21 16:25:04', 0, 'P\"and\"=\"&\";P\"at\"=\"@\";P\"as\"=\"42\";P\"s\"=\"§\";P\"u\"=\"U\";E'),
(6, 'tester', '$2y$10$SeZIRhXZvUkyU0.oFbch2uAq2LOnKTIjczW0X2P1RIwzmrv7V9x4u', 'ABA319', '1C1E06', '', '', '2018-03-21 16:25:04', 0, 'E'),
(7, 'tester2', '$2y$10$IEJtlbqMaDastV5juhGtWuSe3YSrlXDDtMVYAfKzM7nbUqzXA20/y', 'ABA319', '1C1E06', '', '', '2018-03-21 16:25:04', 0, 'E');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(16) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
