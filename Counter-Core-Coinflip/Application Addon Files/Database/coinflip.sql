-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Nov 06, 2016 at 03:50 AM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `csgonetwork`
--

-- --------------------------------------------------------

--
-- Table structure for table `cflobbies`
--

CREATE TABLE IF NOT EXISTS `cflobbies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hid` varchar(100) NOT NULL,
  `hside` int(2) NOT NULL,
  `cid` varchar(70) NOT NULL,
  `value` int(100) NOT NULL,
  `win` text NOT NULL,
  `ended` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Dumping data for table `cflobbies`
--

INSERT INTO `cflobbies` (`id`, `hid`, `hside`, `cid`, `value`, `win`, `ended`) VALUES
(26, '76561198060680631', 1, '', 200, '', 0);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
