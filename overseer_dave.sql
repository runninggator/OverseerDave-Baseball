-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2016 at 07:19 AM
-- Server version: 10.1.13-MariaDB
-- PHP Version: 5.6.21

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `overseer_dave`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE `game` (
  `gid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `opponent` int(11) DEFAULT NULL,
  `winner` int(11) DEFAULT NULL,
  `start` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `person`
--

CREATE TABLE `person` (
  `pid` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  `surname` varchar(32) DEFAULT NULL,
  `forename` varchar(32) DEFAULT NULL,
  `experience` int(11) NOT NULL DEFAULT '0',
  `money` double DEFAULT '0',
  `wins` int(11) NOT NULL DEFAULT '0',
  `losses` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `person`
--

INSERT INTO `person` (`pid`, `username`, `password`, `surname`, `forename`, `experience`, `money`, `wins`, `losses`) VALUES
(26, 'Mike McMike', 'password', NULL, NULL, 55, 75, 5, 12),
(27, 'Runninggator', 'password', NULL, NULL, 905, 1040, 35, 27),
(28, 'Dave', 'password', NULL, NULL, 985, 1567, 55, 16),
(30, 'Snowflake', 'password', NULL, NULL, 164, 46, 9, 8);

-- --------------------------------------------------------

--
-- Table structure for table `player`
--

CREATE TABLE `player` (
  `plid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `first` varchar(32) NOT NULL,
  `last` varchar(32) NOT NULL,
  `hitting` float NOT NULL,
  `catching` float NOT NULL,
  `throwing` float NOT NULL,
  `running` float NOT NULL,
  `stamina` int(11) NOT NULL,
  `position` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `player`
--

INSERT INTO `player` (`plid`, `tid`, `first`, `last`, `hitting`, `catching`, `throwing`, `running`, `stamina`, `position`) VALUES
(136, 22, 'Jay', 'Bacanli', 0.038, 0.042, 0.04, 0.044, 50, 1),
(137, 22, 'Marcus', 'Squarepants', 0.051, 0.071, 0.045, 0.05, 50, 2),
(138, 22, 'Lucas', 'Plager', 0.055, 0.048, 0.061, 0.041, 50, 3),
(139, 22, 'Mike', 'Erickson', 0.041, 0.07, 0.039, 0.049, 50, 4),
(140, 22, 'Jorge', 'Brady', 0.039, 0.045, 0.075, 0.057, 50, 5),
(141, 22, 'Jerry', 'Squarepants', 0.053, 0.057, 0.041, 0.058, 50, 6),
(142, 22, 'Lucas', 'Abichar', 0.054, 0.04, 0.064, 0.04, 50, 7),
(143, 22, 'Jackie', 'Finkle', 0.054, 0.052, 0.064, 0.068, 50, 8),
(144, 22, 'Kyle', 'Dave', 0.05, 0.049, 0.07, 0.046, 50, 9),
(145, 22, 'Jackie', 'Ossa', 0.046, 0.057, 0.05, 0.044, 50, 10),
(146, 22, 'Carlos', 'Trump', 0.043, 0.044, 0.049, 0.04, 50, 11),
(147, 22, 'Austin', 'TheTiger', 0.074, 0.057, 0.066, 0.069, 50, 12),
(148, 22, 'Steven', 'Turgut', 0.054, 0.059, 0.073, 0.046, 50, 13),
(149, 22, 'Jimmy', 'Gomez', 0.07, 0.067, 0.067, 0.042, 50, 14),
(150, 22, 'Mike', 'TheTiger', 0.069, 0.053, 0.048, 0.038, 50, 15),
(151, 23, 'Kanye', 'Squarepants', 0.293, 0.301, 0.199212, 0.1108, 50, 5),
(152, 23, 'Jorge', 'Bacanli', 0.278, 0.223, 0.204356, 0.0899, 50, 1),
(153, 23, 'Jay', 'King', 0.362, 0.343, 0.203498, 0.1184, 50, 4),
(154, 23, 'Patrick', 'Dave', 0.36, 0.343, 0.156163, 0.134503, 50, 3),
(155, 23, 'Saintiago', 'Mosbey', 0.395, 0.255, 0.148943, 0.134503, 50, 2),
(156, 23, 'Kanye', 'TheTiger', 0.401, 0.34, 0.14082, 0.09655, 50, 6),
(157, 23, 'Saintiago', 'Duke', 0.389, 0.376, 0.377, 0.391, 50, 7),
(158, 23, 'Tony', 'Dave', 0.335, 0.217, 0.1089, 0.185494, 50, 8),
(159, 23, 'Babe', 'Finkle', 0.298, 0.253, 0.10225, 0.198355, 50, 9),
(160, 23, 'Jay', 'Suboh', 0.381, 0.359, 0.10795, 0.15887, 50, 10),
(161, 23, 'Marcus', 'Suboh', 0.251, 0.229, 0.0975, 0.142625, 50, 11),
(162, 23, 'George', 'Ossa', 0.235, 0.212, 0.0994, 0.10225, 50, 12),
(163, 23, 'Marcus', 'Turgut', 0.226, 0.221, 0.08705, 0.10605, 50, 13),
(164, 23, 'Tony', 'Turgut', 0.232, 0.402, 0.11365, 0.14082, 50, 14),
(165, 23, 'Jerry', 'Plaza', 0.343, 0.258, 0.11175, 0.165187, 50, 15),
(166, 24, 'Jerry', 'Abichar', 0.104, 0.077, 0.051, 0.063, 50, 10),
(167, 24, 'Suboh', 'Gomez', 0.065, 0.087, 0.043, 0.041, 50, 1),
(168, 24, 'Jorge', 'Duke', 0.066, 0.059, 0.052, 0.072, 50, 3),
(169, 24, 'Carlos', 'Gomez', 0.086, 0.065, 0.046, 0.045, 50, 4),
(170, 24, 'Jorge', 'Erickson', 0.09, 0.098, 0.056, 0.055, 50, 5),
(171, 24, 'Mike', 'Dave', 0.083, 0.064, 0.047, 0.044, 50, 6),
(172, 24, 'Tony', 'Dave', 0.093, 0.107, 0.06, 0.054, 50, 7),
(173, 24, 'Lucas', 'Star', 0.112, 0.1, 0.039, 0.056, 50, 8),
(174, 24, 'Tony', 'Plager', 0.064, 0.098, 0.06, 0.039, 50, 9),
(175, 24, 'Saintiago', 'TheTiger', 0.114, 0.108, 0.07, 0.055, 50, 2),
(176, 24, 'Kevin', 'Star', 0.103, 0.063, 0.049, 0.041, 50, 11),
(177, 24, 'Mike', 'Marx', 0.077, 0.112, 0.05, 0.049, 50, 12),
(178, 24, 'Mike', 'Escobar', 0.09, 0.115, 0.062, 0.045, 50, 13),
(179, 24, 'Beyonce', 'Gomez', 0.073, 0.094, 0.05, 0.057, 50, 14),
(180, 24, 'Donny', 'Plaza', 0.066, 0.069, 0.041, 0.039, 50, 15),
(181, 25, 'Spongebob', 'TheTiger', 0.116, 0.097, 0.0975, 0.038, 50, 1),
(182, 25, 'Mike', 'King', 0.069, 0.084, 0.10035, 0.038, 50, 2),
(183, 25, 'Patrick', 'Jeter', 0.069, 0.095, 0.1089, 0.045, 50, 3),
(184, 25, 'Mike', 'Gomez', 0.101, 0.112, 0.1032, 0.071, 50, 4),
(185, 25, 'Kanye', 'Finkle', 0.064, 0.111, 0.1051, 0.073, 50, 5),
(186, 25, 'Donny', 'Finkle', 0.065, 0.104, 0.1127, 0.05, 50, 6),
(187, 25, 'Saintiago', 'Escobar', 0.115, 0.078, 0.073, 0.045, 50, 7),
(188, 25, 'Suboh', 'Squarepants', 0.069, 0.097, 0.054, 0.074, 50, 8),
(189, 25, 'James', 'Escobar', 0.111, 0.101, 0.058, 0.055, 50, 9),
(190, 25, 'Donny', 'Bobby', 0.117, 0.062, 0.04, 0.058, 50, 10),
(191, 25, 'Patrick', 'Erickson', 0.108, 0.071, 0.051, 0.042, 50, 11),
(192, 25, 'Morimoto', 'Plager', 0.094, 0.086, 0.055, 0.05, 50, 12),
(193, 25, 'Spongebob', 'King', 0.119, 0.082, 0.068, 0.051, 50, 13),
(194, 25, 'Beyonce', 'Dave', 0.118, 0.067, 0.043, 0.073, 50, 14),
(195, 25, 'Kanye', 'Bacanli', 0.075, 0.106, 0.069, 0.055, 50, 15);

-- --------------------------------------------------------

--
-- Table structure for table `standard`
--

CREATE TABLE `standard` (
  `pid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `team`
--

CREATE TABLE `team` (
  `tid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `rank` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `team`
--

INSERT INTO `team` (`tid`, `pid`, `name`, `rank`) VALUES
(22, 26, 'Blue Ligers', NULL),
(23, 27, 'Swamp People', NULL),
(24, 28, 'The Overseers', NULL),
(25, 30, 'White Lightning', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `game`
--
ALTER TABLE `game`
  ADD PRIMARY KEY (`gid`),
  ADD KEY `opponent` (`opponent`),
  ADD KEY `winner` (`winner`),
  ADD KEY `pid` (`pid`);

--
-- Indexes for table `person`
--
ALTER TABLE `person`
  ADD PRIMARY KEY (`pid`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`plid`),
  ADD KEY `tid` (`tid`);

--
-- Indexes for table `standard`
--
ALTER TABLE `standard`
  ADD PRIMARY KEY (`pid`);

--
-- Indexes for table `team`
--
ALTER TABLE `team`
  ADD PRIMARY KEY (`tid`),
  ADD KEY `pid` (`pid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
  MODIFY `gid` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `person`
--
ALTER TABLE `person`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `player`
--
ALTER TABLE `player`
  MODIFY `plid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=196;
--
-- AUTO_INCREMENT for table `team`
--
ALTER TABLE `team`
  MODIFY `tid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `admin`
--
ALTER TABLE `admin`
  ADD CONSTRAINT `admin_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `game_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `player_ibfk_1` FOREIGN KEY (`tid`) REFERENCES `team` (`tid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `standard`
--
ALTER TABLE `standard`
  ADD CONSTRAINT `standard_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `team`
--
ALTER TABLE `team`
  ADD CONSTRAINT `team_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `person` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
