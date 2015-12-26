-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 26, 2015 at 06:34 AM
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
('admin', '$2y$10$idGEb9G8YxAlZ8yXJlFT1uyl2nh/KEZDlxlV315iDf284HL5ODCSK', 'admin'),
('test1', '$2y$10$jzlkua.I6BdRSNoWOkuh5ecSFRz6hgd6NXE3ibg8kXENt12dLMu5K', 'admin'),
('test2', '$2y$10$dr4ag1kK/pY1IyUhnet2fu9dUw.dy1270vposhQuNBqMyZGBvRegq', 'user'),
('test3', '$2y$10$cUAqsi86tIuHU6GgtNfTy.lQiEIWOOullMlI7YiC0l2LXT6h7NeWG', 'user'),
('test4', '$2y$10$7ZwcLsxsYl/a3oOVplSx6.lwr50qxyr2sCKzlGO.V5qVzUeAz5mW2', 'user'),
('test5', '$2y$10$836v8tETocNC8PBwRO1eCefTPkiakgJmLULvg90uXRJCvXnFUo2IS', 'user'),
('test6', '$2y$10$K7TZoYMzicjVqsZ1/T25HOWRRVgtgadbqSV8NY/QwhCIbKjwVgfGS', 'user');

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
('admin', 'Mehrab', '13-23396-1', 'Other', 'Other', '01752141395', 'mehrab2603@yahoo.com'),
('test1', 'Adnan', '13-20086-1', 'Other', 'Other', '01752141090', 'mehrab2603@ya0o2o.com'),
('test2', 'Hasan Tanvir', '13-23396-2', 'Part Timer', 'Arts and Social Sciences', '01752141397', 'mehrab2603@yahoo.com2'),
('test3', 'Ananta Jalil', '13-23396-4', 'Part Timer', 'Arts and Social Sciences', '12345234234', 'mehrab2603@b.c'),
('test4', 'Shabab', '13-23397-1', 'Part Timer', 'Arts and Social Sciences', '01752141325', 'mehrab2603@yahoo.com4'),
('test5', 'Ayon', '13-23396-5', 'Professor', 'Science and Information Technology', '123452342349', 'mehrab2603@yahoo.c8m'),
('test6', 'Kishor', '13-24396-1', 'Part Timer', 'Arts and Social Sciences', '01752141295', 'mehrab2603@yaho2.com');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user_info`
--
ALTER TABLE `user_info`
  ADD CONSTRAINT `user_info_ibfk_1` FOREIGN KEY (`username`) REFERENCES `login` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
