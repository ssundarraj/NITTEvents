-- phpMyAdmin SQL Dump
-- version 3.5.8.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 24, 2013 at 03:51 PM
-- Server version: 5.5.31-0ubuntu0.13.04.1
-- PHP Version: 5.4.9-4ubuntu2.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `eventnotif`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `eid` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `ename` varchar(100) DEFAULT NULL,
  `edesc` varchar(1000) DEFAULT NULL,
  `edate` date DEFAULT NULL,
  `etime` char(5) DEFAULT NULL,
  `lat` double DEFAULT NULL,
  `lng` double DEFAULT NULL,
  `evenue` char(100) DEFAULT NULL,
  `pic` char(250) DEFAULT NULL,
  `ver` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`eid`),
  KEY `uid` (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`eid`, `uid`, `ename`, `edesc`, `edate`, `etime`, `lat`, `lng`, `evenue`, `pic`, `ver`) VALUES
(6, 2, 'Python workshop', 'Workshop for python enthuisasts.', '2014-01-11', '24:09', 10.76294852843969, 78.81396532058716, 'Ilab', NULL, 0),
(30, 1, 'event', 'desc									', '2014-09-19', '12:09', 10.762295041734166, 78.81500601768494, 'Octagon', NULL, 1),
(31, 1, 'Soemthing', 'Somethwe', NULL, '12:09', 0, 0, 'Octa', NULL, 0),
(32, 1, 'Something', 'lkjlkj', '2013-09-20', '12:00', 10.762716646222472, 78.81472706794739, 'hello', NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE IF NOT EXISTS `tokens` (
  `token` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tokens`
--

INSERT INTO `tokens` (`token`) VALUES
('60ae136e5d49fbdf037fab5f1d805634');

-- --------------------------------------------------------

--
-- Table structure for table `updatetime`
--

CREATE TABLE IF NOT EXISTS `updatetime` (
  `lasttime` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `updatetime`
--

INSERT INTO `updatetime` (`lasttime`) VALUES
('2013-09-22:13:18:44');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `uid` int(10) NOT NULL AUTO_INCREMENT,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `upic` char(250) DEFAULT NULL,
  `pic` char(250) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`uid`, `username`, `password`, `upic`, `pic`) VALUES
(1, 'festember', '1a1dc91c907325c69271ddf0c944bc72', NULL, NULL),
(2, 'thespi', '1a1dc91c907325c69271ddf0c944bc72', NULL, NULL),
(3, 'spider', '76a2173be6393254e72ffa4d6df1030a', NULL, NULL);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `users` (`uid`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
