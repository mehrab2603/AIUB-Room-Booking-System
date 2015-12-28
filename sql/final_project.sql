-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 28, 2015 at 09:34 AM
-- Server version: 5.5.46-0ubuntu0.14.04.2
-- PHP Version: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `final_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `booking`
--

CREATE TABLE IF NOT EXISTS `booking` (
  `id` bigint(25) unsigned NOT NULL AUTO_INCREMENT,
  `room` varchar(20) COLLATE utf8_bin NOT NULL,
  `user` varchar(100) COLLATE utf8_bin NOT NULL,
  `course` varchar(100) COLLATE utf8_bin NOT NULL,
  `start` int(20) NOT NULL,
  `end` int(20) NOT NULL,
  `date` date NOT NULL,
  `type` varchar(20) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `room` (`room`,`user`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_bin AUTO_INCREMENT=18 ;

--
-- Dumping data for table `booking`
--

INSERT INTO `booking` (`id`, `room`, `user`, `course`, `start`, `end`, `date`, `type`) VALUES
(11, '421', 'admin', 'CS Math', 1, 1, '2015-12-28', 'Make Up'),
(13, '421', 'admin', 'PL4', 1, 2, '2015-12-27', 'Advance Make Up'),
(14, '421', 'admin', 'PL3 B', 3, 4, '2015-12-27', 'Advance Make Up'),
(15, '421', 'admin', 'PL9', 2, 2, '2015-12-28', 'Make Up'),
(16, '422', 'admin', 'AOS', 1, 1, '2015-12-28', 'Make Up'),
(17, 'CL6', 'admin', 'Database', 1, 6, '2015-12-29', 'Advance Make Up');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE IF NOT EXISTS `login` (
  `username` varchar(100) COLLATE utf8_bin NOT NULL,
  `hash` varchar(200) COLLATE utf8_bin NOT NULL,
  `type` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `hash`, `type`) VALUES
('admin', '$2y$10$G5Q73mPFyeVjJ9JmHdSYK.Z2g9uAG9tgviM6.lindNWUm1yQ32qPm', 'admin'),
('test1', '$2y$10$.JgIwGWL4cVdqQHg8mdZTOhKq0WO6oHlppZKHXWLlYs91dhKjWtEi', 'admin'),
('test2', '$2y$10$jVgy11h2/TxlmVKPhRCNz.bXl9U4H.tBbMVBWsaIuC/RIue/I0aDO', 'user'),
('test3', '$2y$10$cUAqsi86tIuHU6GgtNfTy.lQiEIWOOullMlI7YiC0l2LXT6h7NeWG', 'user'),
('test4', '$2y$10$7ZwcLsxsYl/a3oOVplSx6.lwr50qxyr2sCKzlGO.V5qVzUeAz5mW2', 'user'),
('test5', '$2y$10$836v8tETocNC8PBwRO1eCefTPkiakgJmLULvg90uXRJCvXnFUo2IS', 'user'),
('test6', '$2y$10$K7TZoYMzicjVqsZ1/T25HOWRRVgtgadbqSV8NY/QwhCIbKjwVgfGS', 'user'),
('test7', '$2y$10$Avtw4zHoAd/qecyetDrxmOtvQK0n/V8ieRxff9xjMHgUB1nina9C.', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `room`
--

CREATE TABLE IF NOT EXISTS `room` (
  `id` varchar(20) COLLATE utf8_bin NOT NULL,
  `floor` varchar(10) COLLATE utf8_bin NOT NULL,
  `campus` varchar(10) COLLATE utf8_bin NOT NULL,
  `capacity` varchar(10) COLLATE utf8_bin NOT NULL,
  `type` varchar(50) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `room`
--

INSERT INTO `room` (`id`, `floor`, `campus`, `capacity`, `type`) VALUES
('421', '2', '4', '45', 'Theory'),
('422', '2', '4', '45', 'Theory'),
('423', '2', '4', '45', 'Theory'),
('424', '2', '4', '45', 'Theory'),
('431', '3', '4', '45', 'Theory'),
('432', '3', '4', '45', 'Theory'),
('433', '3', '4', '45', 'Theory'),
('434', '3', '4', '45', 'Theory'),
('441', '4', '4', '45', 'Theory'),
('442', '4', '4', '45', 'Theory'),
('443', '4', '4', '45', 'Theory'),
('444', '4', '4', '45', 'Theory'),
('CL1', '6', '4', '40', 'Lab(Computer)'),
('CL2', '6', '4', '40', 'Lab(Computer)'),
('CL3', '6', '4', '40', 'Lab(Computer)'),
('CL4', '6', '4', '40', 'Lab(Computer)'),
('CL5', '5', '4', '40', 'Lab(Computer)'),
('CL6', '5', '4', '40', 'Lab(Computer)'),
('CL7', '5', '4', '40', 'Lab(Computer)'),
('CL8', '5', '4', '40', 'Lab(Computer)');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE IF NOT EXISTS `schedule` (
  `room` varchar(20) COLLATE utf8_bin NOT NULL,
  `day` varchar(10) COLLATE utf8_bin NOT NULL,
  `1` varchar(100) COLLATE utf8_bin NOT NULL,
  `2` varchar(100) COLLATE utf8_bin NOT NULL,
  `3` varchar(100) COLLATE utf8_bin NOT NULL,
  `4` varchar(100) COLLATE utf8_bin NOT NULL,
  `5` varchar(100) COLLATE utf8_bin NOT NULL,
  `6` varchar(100) COLLATE utf8_bin NOT NULL,
  `7` varchar(100) COLLATE utf8_bin NOT NULL,
  `8` varchar(100) COLLATE utf8_bin NOT NULL,
  `9` varchar(100) COLLATE utf8_bin NOT NULL,
  `10` varchar(100) COLLATE utf8_bin NOT NULL,
  `11` varchar(100) COLLATE utf8_bin NOT NULL,
  `12` varchar(100) COLLATE utf8_bin NOT NULL,
  `13` varchar(100) COLLATE utf8_bin NOT NULL,
  `14` varchar(100) COLLATE utf8_bin NOT NULL,
  `15` varchar(100) COLLATE utf8_bin NOT NULL,
  `16` varchar(100) COLLATE utf8_bin NOT NULL,
  `17` varchar(100) COLLATE utf8_bin NOT NULL,
  `18` varchar(100) COLLATE utf8_bin NOT NULL,
  `19` varchar(100) COLLATE utf8_bin NOT NULL,
  `20` varchar(100) COLLATE utf8_bin NOT NULL,
  `21` varchar(100) COLLATE utf8_bin NOT NULL,
  `22` varchar(100) COLLATE utf8_bin NOT NULL,
  `23` varchar(100) COLLATE utf8_bin NOT NULL,
  `24` varchar(100) COLLATE utf8_bin NOT NULL,
  `25` varchar(100) COLLATE utf8_bin NOT NULL,
  `26` varchar(100) COLLATE utf8_bin NOT NULL,
  `27` varchar(100) COLLATE utf8_bin NOT NULL,
  `28` varchar(100) COLLATE utf8_bin NOT NULL,
  `29` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`room`,`day`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`room`, `day`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`, `9`, `10`, `11`, `12`, `13`, `14`, `15`, `16`, `17`, `18`, `19`, `20`, `21`, `22`, `23`, `24`, `25`, `26`, `27`, `28`, `29`) VALUES
('421', 'Saturday', '', '', 'PL1 B', 'PL1 B', '', '', 'PL2 A', 'PL2 A', 'PL2 A', 'PL2 A', 'PL2 A', 'PL2 A', 'PL2 B', 'PL2 B', 'PL2 B', 'PL2 B', 'PL2 B', 'PL2 B', '', '', 'CS Math', 'CS Math', 'CS Math', 'CS Math', '', '', '', '', ''),
('422', 'Saturday', '', '', 'CS Math', 'CS Math', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_info`
--

CREATE TABLE IF NOT EXISTS `user_info` (
  `username` varchar(100) COLLATE utf8_bin NOT NULL,
  `fullname` varchar(200) COLLATE utf8_bin NOT NULL,
  `id` varchar(100) COLLATE utf8_bin NOT NULL,
  `position` varchar(200) COLLATE utf8_bin NOT NULL,
  `department` varchar(100) COLLATE utf8_bin NOT NULL,
  `phone` varchar(50) COLLATE utf8_bin NOT NULL,
  `email` varchar(100) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`username`),
  UNIQUE KEY `id` (`id`,`phone`,`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_info`
--

INSERT INTO `user_info` (`username`, `fullname`, `id`, `position`, `department`, `phone`, `email`) VALUES
('admin', 'HM Mehrab', '13-23396-1', 'Other', 'Other', '01752141395', 'mehrab2603@yahoo.com'),
('test1', 'Adnan', '13-20086-1', 'Other', 'Other', '01752141090', 'mehrab2603@ya0o2o.com'),
('test2', 'Hasan Tanvir', '13-23396-2', 'Part Timer', 'Arts and Social Sciences', '01752141397', 'mehrab2603@yahoo.com2'),
('test3', 'Ananta Jalil', '13-23396-4', 'Part Timer', 'Arts and Social Sciences', '12345234234', 'mehrab2603@b.c'),
('test4', 'Shabab', '13-23397-1', 'Part Timer', 'Arts and Social Sciences', '01752141325', 'mehrab2603@yahoo.com4'),
('test5', 'Ayon', '13-23396-5', 'Professor', 'Science and Information Technology', '123452342349', 'mehrab2603@yahoo.c8m'),
('test6', 'Kishor', '13-24396-1', 'Part Timer', 'Arts and Social Sciences', '01752141295', 'mehrab2603@yaho2.com'),
('test7', 'Sadiqul Amin', '13-23385-1', 'Other', 'Other', '01752141396', 'mehrab2603@yahoo.comasddas');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `booking`
--
ALTER TABLE `booking`
  ADD CONSTRAINT `booking_ibfk_2` FOREIGN KEY (`room`) REFERENCES `room` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `booking_ibfk_3` FOREIGN KEY (`user`) REFERENCES `login` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`room`) REFERENCES `room` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `user_info_ibfk_1` FOREIGN KEY (`username`) REFERENCES `login` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
