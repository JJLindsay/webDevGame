-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 14, 2015 at 09:45 PM
-- Server version: 5.6.26
-- PHP Version: 5.6.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zillionsparks_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `dilemmas`
--

CREATE TABLE IF NOT EXISTS `dilemmas` (
  `id` int(3) NOT NULL,
  `p1` text NOT NULL,
  `p2` text NOT NULL,
  `p1_choice` int(1) DEFAULT NULL,
  `p2_choice` int(1) DEFAULT NULL,
  `p1_score` int(4) NOT NULL DEFAULT '0',
  `p2_score` int(4) NOT NULL DEFAULT '0',
  `games_per_week` int(2) NOT NULL DEFAULT '10'
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dilemmas`
--

INSERT INTO `dilemmas` (`id`, `p1`, `p2`, `p1_choice`, `p2_choice`, `p1_score`, `p2_score`, `games_per_week`) VALUES
(1, 'A1', 'B1', NULL, NULL, 0, 0, 10),
(2, 'A1', 'C1', NULL, NULL, 0, 0, 10),
(3, 'B1', 'C1', NULL, NULL, 0, 0, 5151),
(4, 'A2', 'B3', 1, NULL, 0, 0, 10),
(5, 'A2', 'C4', NULL, 0, 0, 0, 10),
(6, 'A2', 'B4', NULL, NULL, 0, 0, 10),
(7, 'B3', 'C4', NULL, NULL, 0, 0, 10),
(8, 'B3', 'B4', NULL, NULL, 15, 0, 10),
(9, 'C4', 'B4', NULL, NULL, 0, 0, 10),
(10, 'B2', 'C2', NULL, NULL, 0, 0, 10),
(11, 'B2', 'C3', NULL, NULL, 0, 0, 10),
(12, 'B2', 'A3', NULL, NULL, 0, 0, 10),
(13, 'B2', 'A4', NULL, NULL, 0, 0, 10),
(14, 'C2', 'C3', NULL, NULL, 0, 0, 10),
(15, 'C2', 'A3', NULL, NULL, 0, 0, 10),
(16, 'C2', 'A4', NULL, NULL, 0, 0, 10),
(17, 'C3', 'A3', NULL, NULL, 0, 0, 10),
(18, 'C3', 'A4', NULL, NULL, 0, 0, 10),
(19, 'A3', 'A4', NULL, NULL, 0, 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `teamcode`
--

CREATE TABLE IF NOT EXISTS `teamcode` (
  `users_id` int(3) NOT NULL,
  `tag` varchar(4) NOT NULL,
  `user_group` varchar(13) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teamcode`
--

INSERT INTO `teamcode` (`users_id`, `tag`, `user_group`) VALUES
(1, 'A1', 'green'),
(2, 'B1', 'green'),
(3, 'C1', 'green'),
(4, 'A2', 'yellow'),
(5, 'B2', 'blue'),
(6, 'C2', 'blue'),
(7, 'B3', 'yellow'),
(8, 'C3', 'blue'),
(9, 'A3', 'blue'),
(10, 'C4', 'yellow'),
(11, 'A4', 'blue'),
(12, 'B4', 'yellow');

-- --------------------------------------------------------

--
-- Table structure for table `totals`
--

CREATE TABLE IF NOT EXISTS `totals` (
  `users_id` int(4) NOT NULL,
  `totalscore` int(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `totals`
--

INSERT INTO `totals` (`users_id`, `totalscore`) VALUES
(1, 0),
(2, 40),
(3, 0),
(4, 0),
(5, 43),
(6, 0),
(7, 0),
(8, 0),
(9, 0),
(10, 0),
(11, 0),
(12, 0);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL,
  `usernames` varchar(255) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `confirmed_email` varchar(255) NOT NULL,
  `pw` varchar(255) NOT NULL,
  `confirmed_pw` varchar(255) NOT NULL,
  `course` varchar(12) DEFAULT NULL,
  `section` int(2) DEFAULT NULL,
  `online_status` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `usernames`, `first_name`, `last_name`, `email`, `confirmed_email`, `pw`, `confirmed_pw`, `course`, `section`, `online_status`) VALUES
(1, 'mmodi26', 'Mitesh', 'Modi', 'mitesh.modi003@gmail.com', 'mitesh.modi003@gmail.com', 'nirmauni', 'nirmauni', NULL, NULL, 0),
(2, 'jpatel90', 'Jay', 'Patel', 'jpatel@gmail.com', 'jpatel@gmail.com', 'nirmauni', 'nirmauni', 'Biology', 4, 1),
(3, 'hpatel91', 'Harshal', 'Patel', 'hpatel91@gmail.com', 'hpatel91@gmail.com', 'nirmauni', 'nirmauni', NULL, NULL, 0),
(4, 'jdoe', 'john', 'doe', 'jdoe@aol.com', 'jdoe@aol.com', '123456', '123456', 'BIOL4800', 6, 1),
(5, 'aadmin', 'admin', 'admin', 'admin@hotmail.com', 'admin@hotmail.com', '123456', '123456', 'BIOL2111', 9, 1),
(6, 'test1', 'hobbit', 'Jon', 'test1@aol.com', 'test1@aol.com', '123456', '123456', 'Biology', 12, 0),
(7, 'test2', 'hobbo', 'Jane', 'test1@aol.com', 'test1@aol.com', '123456', '123456', 'Biology', 12, 0),
(8, 'test3', 'mac', 'Jon', 'test1@aol.com', 'test1@aol.com', '123456', '123456', 'Biology', 12, 0),
(9, 'test4', 'salsa', 'Jane', 'test1@aol.com', 'test1@aol.com', '123456', '123456', 'Biology', 12, 0),
(10, 'test5', 'fries', 'Jon', 'test1@aol.com', 'test1@aol.com', '123456', '123456', 'Biology', 12, 0),
(11, 'test6', 'shake', 'Jane', 'test1@aol.com', 'test1@aol.com', '123456', '123456', 'Biology', 12, 0),
(12, 'test7', 'nuggets', 'Jon', 'test1@aol.com', 'test1@aol.com', '123456', '123456', 'Biology', 12, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dilemmas`
--
ALTER TABLE `dilemmas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `teamcode`
--
ALTER TABLE `teamcode`
  ADD PRIMARY KEY (`users_id`);

--
-- Indexes for table `totals`
--
ALTER TABLE `totals`
  ADD PRIMARY KEY (`users_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `dilemmas`
--
ALTER TABLE `dilemmas`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=20;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `teamcode`
--
ALTER TABLE `teamcode`
  ADD CONSTRAINT `usersTeamCode_fk` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `totals`
--
ALTER TABLE `totals`
  ADD CONSTRAINT `totalsUsersID_fk` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
