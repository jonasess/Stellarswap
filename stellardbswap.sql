-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 11, 2018 at 09:32 PM
-- Server version: 5.7.19
-- PHP Version: 5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stellardbswap`
--

-- --------------------------------------------------------

--
-- Table structure for table `stellarswapusers`
--

DROP TABLE IF EXISTS `stellarswapusers`;
CREATE TABLE IF NOT EXISTS `stellarswapusers` (
  `id` int(255) NOT NULL AUTO_INCREMENT,
  `swemail` varchar(255) NOT NULL,
  `swpassword` varchar(255) NOT NULL,
  `swsecretkey` varchar(255) NOT NULL,
  `swpublickey` varchar(255) NOT NULL,
  `swbtccoinkey` varchar(255) NOT NULL,
  `swgalaxycashcoinkey` varchar(255) NOT NULL,
  `swbitcoinatomkey` varchar(888) NOT NULL,
  PRIMARY KEY (`swemail`,`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `stellarswapusers`
--
-- --------------------------------------------------------

--
-- Table structure for table `swcoinvstokenaskstable`
--

DROP TABLE IF EXISTS `swcoinvstokenaskstable`;
CREATE TABLE IF NOT EXISTS `swcoinvstokenaskstable` (
  `swidasks` int(255) NOT NULL AUTO_INCREMENT,
  `stseckeyseller` varchar(900) NOT NULL,
  `stpubkeyseller` varchar(900) NOT NULL,
  `sellcoincode` varchar(900) NOT NULL,
  `buytokencode` varchar(900) NOT NULL,
  `buytokenissuer` varchar(255) NOT NULL,
  `coinkeyseller` varchar(900) NOT NULL,
  `sellcoinamount` double NOT NULL,
  `buytokenamoun` double NOT NULL,
  `pricewithcoin` double NOT NULL,
  PRIMARY KEY (`swidasks`)
) ENGINE=MyISAM AUTO_INCREMENT=63 DEFAULT CHARSET=latin1;

--
-- Table structure for table `swcoinvstokenbidstable`
--

DROP TABLE IF EXISTS `swcoinvstokenbidstable`;
CREATE TABLE IF NOT EXISTS `swcoinvstokenbidstable` (
  `swidbids` int(255) NOT NULL AUTO_INCREMENT,
  `stseckeyseller` varchar(900) NOT NULL,
  `stpubkeyseller` varchar(900) NOT NULL,
  `selltokencode` varchar(900) NOT NULL,
  `selltokenissuer` varchar(255) NOT NULL,
  `buycoincode` varchar(900) NOT NULL,
  `coinkeybuyer` varchar(900) NOT NULL,
  `selltokenamount` double NOT NULL,
  `buycoinmoun` double NOT NULL,
  `pricewithcoin` double NOT NULL,
  PRIMARY KEY (`swidbids`)
) ENGINE=MyISAM AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `swtradedhestory`
--

DROP TABLE IF EXISTS `swtradedhestory`;
CREATE TABLE IF NOT EXISTS `swtradedhestory` (
  `swidhistory` int(255) NOT NULL AUTO_INCREMENT,
  `swsctkeystellseller` varchar(955) NOT NULL,
  `swsctkeystellbuyer` varchar(955) NOT NULL,
  `swcodesell` varchar(955) NOT NULL,
  `swcodebuy` varchar(955) NOT NULL,
  `swtokenamount` double NOT NULL,
  `swcoinamount` double NOT NULL,
  `swpriceincoin` double NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`swidhistory`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `swtradedhestory`
--
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
