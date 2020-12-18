-- phpMyAdmin SQL Dump
-- version 3.2.0.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 07, 2012 at 01:28 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.2-1ubuntu4.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `webcam`
--

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category` text NOT NULL,
  `tags` text NOT NULL,
  `filename` text NOT NULL,
  `width` varchar(255) NOT NULL,
  `height` varchar(255) NOT NULL,
  `path` text NOT NULL,
  `contents` longblob NOT NULL,
  `extension` varchar(255) NOT NULL,
  `length` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `checksum` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `image_details`
--

CREATE TABLE IF NOT EXISTS `image_details` (
  `id` int(11) NOT NULL,
  `category` text NOT NULL,
  `tags` text NOT NULL,
  `filename` text NOT NULL,
  `width` varchar(255) NOT NULL,
  `height` varchar(255) NOT NULL,
  `path` text NOT NULL,
  `thumb` text NOT NULL,
  `full` text NOT NULL,
  `extension` varchar(255) NOT NULL,
  `length` varchar(255) NOT NULL,
  `date` datetime NOT NULL,
  `contents` longblob NOT NULL,
  `checksum` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
