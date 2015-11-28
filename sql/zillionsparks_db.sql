-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 28, 2015 at 08:34 PM
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
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(2) NOT NULL,
  `course_and_number` varchar(10) NOT NULL,
  `section` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `course_and_number`, `section`) VALUES
(5, 'BIOL 1101K', 6),
(6, 'BIOL 1101K', 9),
(7, 'BIOL 3400K', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `dilemmas`
--

INSERT INTO `dilemmas` (`id`, `p1`, `p2`, `p1_choice`, `p2_choice`, `p1_score`, `p2_score`, `games_per_week`) VALUES
(1, 'Red-1', 'Green-1', NULL, NULL, 0, 0, 10),
(2, 'Red-1', 'Blue-1', NULL, NULL, 0, 0, 10),
(3, 'Green-1', 'Blue-1', NULL, NULL, 0, 0, 10),
(4, 'Red-2', 'Green-2', 0, 1, 0, 5, 10),
(5, 'Red-2', 'Green-4', 1, 0, 5, 0, 10),
(6, 'Green-2', 'Green-4', NULL, NULL, 0, 0, 10),
(7, 'Blue-3', 'Green-3', NULL, NULL, 0, 0, 10),
(8, 'Blue-3', 'Red-3', NULL, NULL, 0, 0, 10),
(9, 'Green-3', 'Red-3', NULL, NULL, 0, 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `game_mode`
--

CREATE TABLE IF NOT EXISTS `game_mode` (
  `play_random` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `game_mode`
--

INSERT INTO `game_mode` (`play_random`) VALUES
(0);

-- --------------------------------------------------------

--
-- Table structure for table `history`
--

CREATE TABLE IF NOT EXISTS `history` (
  `id` int(3) NOT NULL,
  `player1` varchar(12) NOT NULL,
  `player2` varchar(12) NOT NULL,
  `player1_choice` varchar(12) NOT NULL,
  `player2_choice` varchar(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `teamcode`
--

CREATE TABLE IF NOT EXISTS `teamcode` (
  `users_id` int(3) NOT NULL,
  `tag` varchar(12) NOT NULL,
  `user_group` varchar(13) NOT NULL,
  `random_group` int(3) DEFAULT '0',
  `fixed_group` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `teamcode`
--

INSERT INTO `teamcode` (`users_id`, `tag`, `user_group`, `random_group`, `fixed_group`) VALUES
(1, 'Red-1', 'red', 3, 1),
(2, 'Green-1', 'green', 2, 1),
(3, 'Blue-1', 'blue', 4, 1),
(4, 'Red-2', 'red', 1, 2),
(6, 'Green-2', 'green', 3, 2),
(7, 'Blue-3', 'blue', 2, 3),
(8, 'Green-3', 'green', 2, 3),
(9, 'Red-3', 'red', 3, 3),
(10, 'Green-4', 'green', 4, 2),
(11, 'Red-4', 'red', 1, 4);

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
(11, 0);

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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `usernames`, `first_name`, `last_name`, `email`, `confirmed_email`, `pw`, `confirmed_pw`, `course`, `section`, `online_status`) VALUES
(1, 'mmodi26', 'Mitesh', 'Modi', 'mitesh.modi003@gmail.com', 'mitesh.modi003@gmail.com', 'nirmauni', 'nirmauni', NULL, NULL, 1),
(2, 'jpatel90', 'Jay', 'Patel', 'jpatel@gmail.com', 'jpatel@gmail.com', 'nirmauni', 'nirmauni', 'Biology', 4, 1),
(3, 'hpatel91', 'Harshal', 'Patel', 'hpatel91@gmail.com', 'hpatel91@gmail.com', 'nirmauni', 'nirmauni', NULL, NULL, 1),
(4, 'jdoe', 'john', 'doe', 'jdoe@aol.com', 'jdoe@aol.com', '123456', '123456', 'BIOL4800', 6, 1),
(5, 'aadmin', 'admin', 'admin', 'admin@hotmail.com', 'admin@hotmail.com', '123456', '123456', 'BIOL2111', 9, 1),
(6, 'test1', 'hobbit', 'Jon', 'test1@aol.com', 'test1@aol.com', '123456', '123456', 'Biology', 12, 1),
(7, 'test2', 'hobbo', 'Jane', 'test1@aol.com', 'test1@aol.com', '123456', '123456', 'Biology', 12, 0),
(8, 'test3', 'mac', 'Jon', 'test1@aol.com', 'test1@aol.com', '123456', '123456', 'Biology', 12, 0),
(9, 'test4', 'salsa', 'Jane', 'test1@aol.com', 'test1@aol.com', '123456', '123456', 'Biology', 12, 0),
(10, 'test5', 'fries', 'Jon', 'test1@aol.com', 'test1@aol.com', '123456', '123456', 'Biology', 12, 1),
(11, 'test6', 'shake', 'Jane', 'test1@aol.com', 'test1@aol.com', '123456', '123456', 'Biology', 12, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_n_number` (`course_and_number`,`section`);

--
-- Indexes for table `dilemmas`
--
ALTER TABLE `dilemmas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `game_mode`
--
ALTER TABLE `game_mode`
  ADD PRIMARY KEY (`play_random`);

--
-- Indexes for table `history`
--
ALTER TABLE `history`
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
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT for table `dilemmas`
--
ALTER TABLE `dilemmas`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
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
