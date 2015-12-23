-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Dec 24, 2015 at 03:08 AM
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
('admin', '$2y$10$AGIRuW3W/.31GKk.YDXbhuqXCSS69q4xknWHFxVXO.5wO7KSSRaf2', 'admin'),
('test1', '$2y$10$udNmaTIv4v5IzwgTAGAvOuUPm.MkOkITR5PzHf0K.tQevszYSKYDe', 'user');

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
('test1', 'hgjhgjgjhgkjhg', 'hghgjhgjjkghj', 'Other', 'Arts and Social Sciences', '5657657865758', 'jhjgj@fhg.m');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
