-- phpMyAdmin SQL Dump
-- version 4.0.4.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jan 30, 2015 at 02:10 PM
-- Server version: 5.6.11
-- PHP Version: 5.5.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `aerc_opss`
--
CREATE DATABASE IF NOT EXISTS `aerc_opss` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `aerc_opss`;

-- --------------------------------------------------------

--
-- Table structure for table `co_authors`
--

CREATE TABLE IF NOT EXISTS `co_authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Table structure for table `email_activation`
--

CREATE TABLE IF NOT EXISTS `email_activation` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(256) DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `activated` tinyint(4) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=40 ;

-- --------------------------------------------------------

--
-- Table structure for table `files`
--

CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `inner_filename` varchar(255) DEFAULT NULL,
  `filetype` varchar(255) DEFAULT NULL,
  `directory` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=75 ;

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE IF NOT EXISTS `messages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `subject` varchar(255) DEFAULT NULL,
  `is_read` tinyint(4) DEFAULT NULL,
  `sender_type` varchar(50) DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `message` text,
  `other_parts` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=101 ;

-- --------------------------------------------------------

--
-- Table structure for table `message_boxes`
--

CREATE TABLE IF NOT EXISTS `message_boxes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `last_query_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=108 ;

-- --------------------------------------------------------

--
-- Table structure for table `papers`
--

CREATE TABLE IF NOT EXISTS `papers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `identifier` varchar(100) DEFAULT NULL,
  `revision` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `date_submitted` datetime DEFAULT NULL,
  `country` varchar(255) DEFAULT NULL,
  `language` varchar(255) DEFAULT NULL,
  `file_id` int(11) DEFAULT NULL,
  `cover_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `level` int(11) DEFAULT NULL,
  `editable` tinyint(4) DEFAULT NULL,
  `recallable` tinyint(4) DEFAULT NULL,
  `end_recallable_date` datetime DEFAULT NULL,
  `researcher_id` int(11) DEFAULT NULL,
  `other_parts` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

-- --------------------------------------------------------

--
-- Table structure for table `paper_authors`
--

CREATE TABLE IF NOT EXISTS `paper_authors` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paper_id` int(11) DEFAULT NULL,
  `author_id` int(11) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `paper_changes`
--

CREATE TABLE IF NOT EXISTS `paper_changes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action` varchar(255) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  `revision` int(11) DEFAULT NULL,
  `args` text,
  `paper_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

-- --------------------------------------------------------

--
-- Table structure for table `reg_invitations`
--

CREATE TABLE IF NOT EXISTS `reg_invitations` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `paper_id` int(11) DEFAULT NULL,
  `user_type` int(11) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `date_sent` datetime DEFAULT NULL,
  `date_registered` datetime DEFAULT NULL,
  `expiry_date` datetime DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `registration_code` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paper_id` int(11) DEFAULT NULL,
  `reviewer_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `status` int(11) DEFAULT NULL,
  `recommendation` varchar(100) DEFAULT NULL,
  `comments` text,
  `researcher_comments` text,
  `file_id` int(11) DEFAULT NULL,
  `researcher_file_id` int(11) DEFAULT NULL,
  `date_submitted` datetime DEFAULT NULL,
  `permanent` tinyint(4) DEFAULT NULL,
  `due_date` datetime DEFAULT NULL,
  `posted` tinyint(4) DEFAULT NULL,
  `date_posted` datetime DEFAULT NULL,
  `date_initiated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(80) DEFAULT NULL,
  `email` varchar(200) DEFAULT NULL,
  `title` varchar(20) DEFAULT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `type` tinyint(4) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `email_activated` tinyint(4) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `residence` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) DEFAULT NULL,
  `gender` tinyint(4) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=53 ;

-- --------------------------------------------------------

--
-- Table structure for table `user_research_areas`
--

CREATE TABLE IF NOT EXISTS `user_research_areas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `paper_group` int(11) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

-- --------------------------------------------------------

--
-- Table structure for table `vet_reviews`
--

CREATE TABLE IF NOT EXISTS `vet_reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `paper_id` int(11) DEFAULT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `status` varchar(100) DEFAULT NULL,
  `date_initiated` datetime DEFAULT NULL,
  `date_submitted` datetime DEFAULT NULL,
  `comments` text,
  `verdict` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=18 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
