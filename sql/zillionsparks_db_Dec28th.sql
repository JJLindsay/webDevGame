-- phpMyAdmin SQL Dump
-- version 4.4.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2015 at 09:50 PM
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
-- Table structure for table `added_iterate_classes`
--

CREATE TABLE IF NOT EXISTS `added_iterate_classes` (
  `id` int(2) NOT NULL,
  `course` varchar(10) NOT NULL,
  `section` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `added_iterate_classes`
--

INSERT INTO `added_iterate_classes` (`id`, `course`, `section`) VALUES
(1, 'BIOL 1101K', 2),
(2, 'BIOL 1101K', 16),
(3, 'BIOL 2451K', 15);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE IF NOT EXISTS `course` (
  `id` int(2) NOT NULL,
  `course_and_number` varchar(10) NOT NULL,
  `section` int(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `course_and_number`, `section`) VALUES
(1, 'BIOL 1101K', 2),
(2, 'BIOL 1101K', 16),
(3, 'BIOL 2451K', 15);

-- --------------------------------------------------------

--
-- Table structure for table `games`
--

CREATE TABLE IF NOT EXISTS `games` (
  `id` int(255) NOT NULL,
  `player1` varchar(255) NOT NULL,
  `player2` varchar(255) NOT NULL,
  `time` int(50) NOT NULL,
  `round1` varchar(3) NOT NULL DEFAULT '0-0',
  `round2` varchar(3) NOT NULL DEFAULT '0-0',
  `round3` varchar(3) NOT NULL DEFAULT '0-0',
  `round4` varchar(3) NOT NULL DEFAULT '0-0',
  `round5` varchar(3) NOT NULL DEFAULT '0-0',
  `status` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `games`
--

INSERT INTO `games` (`id`, `player1`, `player2`, `time`, `round1`, `round2`, `round3`, `round4`, `round5`, `status`) VALUES
(1, '5', '3', 1451257559, '1-2', '1-1', '2-2', '2-1', '2-1', 6);

-- --------------------------------------------------------

--
-- Table structure for table `game_mode`
--

CREATE TABLE IF NOT EXISTS `game_mode` (
  `play_random` int(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `history`
--

INSERT INTO `history` (`id`, `player1`, `player2`, `player1_choice`, `player2_choice`) VALUES
(1, 'Blue-2', 'Yellow-3', 'coop', 'coop'),
(2, 'Blue-2', 'Yellow-3', 'coop', 'defect'),
(3, 'Blue-2', 'Yellow-3', 'defect', 'defect'),
(4, 'Blue-2', 'Yellow-3', 'coop', 'defect'),
(5, 'Blue-2', 'Yellow-3', 'defect', 'coop'),
(6, 'Blue-2', 'Yellow-3', 'coop', 'coop'),
(7, 'Blue-2', 'Yellow-3', 'defect', 'coop'),
(8, 'Blue-2', 'Yellow-3', 'defect', 'defect'),
(9, 'Blue-2', 'Yellow-3', 'defect', 'defect'),
(10, 'Blue-2', 'Yellow-3', 'coop', 'coop');

-- --------------------------------------------------------

--
-- Table structure for table `iterative_game`
--

CREATE TABLE IF NOT EXISTS `iterative_game` (
  `id` int(3) NOT NULL,
  `p1` varchar(12) NOT NULL,
  `p2` varchar(12) NOT NULL,
  `p1_choice` int(2) DEFAULT NULL,
  `p2_choice` int(2) DEFAULT NULL,
  `p1_score` int(3) DEFAULT '0',
  `p2_score` int(3) DEFAULT '0',
  `round_limit` int(2) NOT NULL DEFAULT '10'
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `iterative_game`
--

INSERT INTO `iterative_game` (`id`, `p1`, `p2`, `p1_choice`, `p2_choice`, `p1_score`, `p2_score`, `round_limit`) VALUES
(1, 'Blue-2', 'Yellow-3', NULL, NULL, 3, 3, 0),
(2, 'Blue-2', 'Red-4', NULL, NULL, 0, 0, 10),
(3, 'Blue-2', 'Blue-5', NULL, NULL, 0, 0, 10),
(4, 'Yellow-3', 'Red-4', 0, NULL, 0, 0, 10);

-- --------------------------------------------------------

--
-- Table structure for table `iterative_teams`
--

CREATE TABLE IF NOT EXISTS `iterative_teams` (
  `id` int(3) NOT NULL,
  `member1` varchar(12) DEFAULT NULL,
  `member2` varchar(12) DEFAULT NULL,
  `member3` varchar(12) DEFAULT NULL,
  `member4` varchar(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `iterative_teams`
--

INSERT INTO `iterative_teams` (`id`, `member1`, `member2`, `member3`, `member4`) VALUES
(1, 'Blue-2', 'Yellow-3', 'Red-4', 'Blue-5'),
(2, 'Yellow-3', 'Blue-2', 'Red-4', NULL),
(3, 'Red-4', 'Blue-2', 'Yellow-3', NULL),
(4, 'Blue-5', 'Blue-2', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `random_game`
--

CREATE TABLE IF NOT EXISTS `random_game` (
  `id` int(3) NOT NULL,
  `p1` text NOT NULL,
  `p2` text NOT NULL,
  `p1_choice` int(1) DEFAULT NULL,
  `p2_choice` int(1) DEFAULT NULL,
  `p1_score` int(4) DEFAULT '0',
  `p2_score` int(4) DEFAULT '0',
  `games_per_week` int(2) DEFAULT '10',
  `round_limit` int(2) NOT NULL DEFAULT '5'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `random_history`
--

CREATE TABLE IF NOT EXISTS `random_history` (
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
(1, 'Yellow-1', 'Yellow', 0, 0),
(2, 'Blue-2', 'blue', 0, 0),
(3, 'Yellow-3', 'Yellow', 0, 0),
(4, 'Red-4', 'Red', 0, 0),
(5, 'Blue-5', 'Blue', 0, 0),
(20, 'Yellow-20', 'Yellow', 0, 0);

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
(2, 22),
(3, 22),
(4, 0),
(5, 0),
(20, 0);

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
  `online_status` int(1) NOT NULL DEFAULT '0',
  `score` int(3) DEFAULT '0',
  `busy` tinyint(1) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rank` smallint(2) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `usernames`, `first_name`, `last_name`, `email`, `confirmed_email`, `pw`, `confirmed_pw`, `course`, `section`, `online_status`, `score`, `busy`, `time`, `rank`) VALUES
(1, 'aadmin', 'admin', 'admin', 'admin@hotmail.com', 'admin@hotmail.com', '123456', '123456', 'admin', 0, 1, 0, 0, '2015-12-27 22:05:05', 0),
(2, 'jdoe', 'jon', 'doe', 'jdoe@aol.com', 'jdoe@aol.com', '123', '123', 'BIOL 1101K', 16, 1, 0, 0, '2015-12-27 22:28:44', 0),
(3, 'kfrog', 'kermit', 'frog', 'kfrog@pbs.org', 'kfrog@pbs.org', '12356', '12356', 'BIOL 1101K', 2, 1, 11, 1, '2015-12-27 22:40:17', 0),
(4, 'hsimpson', 'homer', 'simpson', 'hsimpson@fox.com', 'hsimpson@fox.com', '456', '456', 'BIOL 2451K', 15, 0, 0, 0, '2015-12-27 22:42:27', 0),
(5, 'mburns', 'm', 'burns', 'mburns@fox.com', 'mburns@fox.com', 'abc1234', 'abc123', 'BIOL 2451K', 15, 1, 15, 1, '2015-12-27 22:43:29', 0),
(9, 'mtburns', 'monty', 'burns', 'mtburns@fox.com', 'mtburns@fox.com', '456123', '456123', 'BIOL 2451K', 15, 1, 0, 0, '2015-12-28 18:15:37', 0),
(20, 'nflanders', 'ned', 'flanders', 'nflanders@fox.com', 'nflanders@fox.com', '789', '789', 'BIOL 1101K', 15, 1, 0, 0, '2015-12-28 19:05:49', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `added_iterate_classes`
--
ALTER TABLE `added_iterate_classes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `course_n_number` (`course_and_number`,`section`);

--
-- Indexes for table `games`
--
ALTER TABLE `games`
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
-- Indexes for table `iterative_game`
--
ALTER TABLE `iterative_game`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `iterative_teams`
--
ALTER TABLE `iterative_teams`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `random_game`
--
ALTER TABLE `random_game`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `random_history`
--
ALTER TABLE `random_history`
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
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usernames` (`usernames`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(2) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `games`
--
ALTER TABLE `games`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `history`
--
ALTER TABLE `history`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT for table `iterative_game`
--
ALTER TABLE `iterative_game`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `random_game`
--
ALTER TABLE `random_game`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `random_history`
--
ALTER TABLE `random_history`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=21;
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
