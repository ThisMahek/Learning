-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 24, 2023 at 03:34 PM
-- Server version: 10.3.28-MariaDB-cll-lve
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `gplplay_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `join_player`
--

CREATE TABLE `join_player` (
  `id` int(10) NOT NULL,
  `team_id` varchar(100) NOT NULL,
  `player_id` varchar(100) NOT NULL,
  `status` int(10) NOT NULL DEFAULT 0,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `join_player`
--

INSERT INTO `join_player` (`id`, `team_id`, `player_id`, `status`, `created_at`, `updated_at`) VALUES
(1, '78', '7', 0, '2023-01-23 17:16:11', '2023-01-23 17:16:11'),
(2, '74', '7', 0, '2023-01-23 17:16:51', '2023-01-23 17:16:51'),
(3, '70', '7', 0, '2023-01-23 17:16:56', '2023-01-23 17:16:56'),
(4, '6', '7', 1, '2023-01-23 17:35:45', '2023-01-24 13:04:09'),
(5, '6', '8', 2, '2023-01-23 17:36:29', '2023-01-24 13:03:59'),
(6, '82', '7', 0, '2023-01-24 12:35:41', '2023-01-24 12:35:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `join_player`
--
ALTER TABLE `join_player`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `join_player`
--
ALTER TABLE `join_player`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
