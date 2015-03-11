-- phpMyAdmin SQL Dump
-- version 4.0.10.8
-- http://www.phpmyadmin.net
--
-- Host: 127.12.154.2:3306
-- Generation Time: Mar 11, 2015 at 03:46 PM
-- Server version: 5.5.41
-- PHP Version: 5.3.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `survey`
--

-- --------------------------------------------------------

--
-- Table structure for table `PotentialAnswers`
--

CREATE TABLE IF NOT EXISTS `PotentialAnswers` (
  `id_answer` int(11) NOT NULL AUTO_INCREMENT,
  `id_question` int(11) NOT NULL,
  `text` varchar(255) NOT NULL,
  `num_answers` int(11) NOT NULL,
  `type` int(11) NOT NULL COMMENT '0 - bullet, 1 - checkbox, 2 - text',
  PRIMARY KEY (`id_answer`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=18 ;

-- --------------------------------------------------------

--
-- Table structure for table `Questions`
--

CREATE TABLE IF NOT EXISTS `Questions` (
  `id_question` int(11) NOT NULL AUTO_INCREMENT,
  `question_text` varchar(500) NOT NULL,
  `question_img` varchar(255) NOT NULL,
  `url` varchar(655) NOT NULL,
  `url_text` varchar(255) NOT NULL,
  `id_survay` int(11) NOT NULL,
  `num_answers` int(11) NOT NULL,
  PRIMARY KEY (`id_question`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Table structure for table `Survay`
--

CREATE TABLE IF NOT EXISTS `Survay` (
  `id_survay` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `text` varchar(3000) NOT NULL,
  `random` int(11) NOT NULL,
  `max_ans` int(11) NOT NULL,
  `num_of_questions_for_user` int(11) NOT NULL,
  PRIMARY KEY (`id_survay`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
