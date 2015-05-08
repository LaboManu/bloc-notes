-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: 10.246.16.55:3306
-- Generation Time: May 08, 2015 at 11:07 PM
-- Server version: 5.5.43-MariaDB-1~wheezy
-- PHP Version: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `manudahmen_be`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocnotes_data`
--
-- Creation: May 03, 2015 at 11:48 AM
-- Last update: May 04, 2015 at 04:04 PM
--

CREATE TABLE IF NOT EXISTS `blocnotes_data` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `filename_id` int(11) DEFAULT NULL,
  `hachset_filename` varchar(1024) DEFAULT NULL,
  `hash_key` varchar(2048) DEFAULT NULL,
  `filename` varchar(1024) DEFAULT NULL,
  `folder_name` varchar(1024) DEFAULT NULL,
  `content_file` longblob,
  `isHach` tinyint(1) DEFAULT '1',
  `isClear` tinyint(1) DEFAULT '1',
  `isCrypted` tinyint(1) DEFAULT '0',
  `username` varchar(1024) NOT NULL,
  `mime` varchar(1024) NOT NULL,
  `isDirectory` int(11) NOT NULL DEFAULT '0',
  `quand` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=127 ;

-- --------------------------------------------------------

--
-- Table structure for table `blocnotes_items`
--
-- Creation: Apr 21, 2015 at 06:15 AM
-- Last update: Apr 21, 2015 at 06:15 AM
-- Last check: Apr 21, 2015 at 06:15 AM
--

CREATE TABLE IF NOT EXISTS `blocnotes_items` (
  `serid` int(11) NOT NULL,
  `filename` varchar(1024) NOT NULL,
  `user` varchar(128) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moment` datetime NOT NULL,
  `type` varchar(10000) NOT NULL,
  `contenu` mediumtext NOT NULL,
  `classeur` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `iditem` (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blocnotes_item_type`
--
-- Creation: Feb 12, 2015 at 02:12 PM
-- Last update: Feb 12, 2015 at 02:15 PM
--

CREATE TABLE IF NOT EXISTS `blocnotes_item_type` (
  `type` int(11) NOT NULL DEFAULT '0',
  `name` varchar(256) DEFAULT NULL,
  `application` varchar(1024) DEFAULT NULL,
  `extension` varchar(100) NOT NULL,
  PRIMARY KEY (`type`),
  UNIQUE KEY `type_2` (`type`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `blocnotes_link`
--
-- Creation: Apr 30, 2015 at 11:52 PM
-- Last update: Apr 30, 2015 at 11:52 PM
--

CREATE TABLE IF NOT EXISTS `blocnotes_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_element_porteur` varchar(1024) DEFAULT NULL,
  `nom_element_dependant` varchar(1024) DEFAULT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blocnotes_login`
--
-- Creation: Feb 11, 2015 at 01:18 AM
-- Last update: Feb 11, 2015 at 01:18 AM
--

CREATE TABLE IF NOT EXISTS `blocnotes_login` (
  `app_wordpress_u` varchar(256) NOT NULL,
  `app_wordpress_p` varchar(256) NOT NULL,
  `app_wordpress_e` varchar(256) NOT NULL,
  `app_mediawiki_u` varchar(256) NOT NULL,
  `app_mediawiki_p` varchar(256) NOT NULL,
  `app_mediawiki_e` varchar(256) NOT NULL,
  `with_google_e` varchar(256) NOT NULL,
  `with_facebook_e` varchar(256) NOT NULL,
  `with_yahoo_e` varchar(256) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blocnotes_relations`
--
-- Creation: May 04, 2015 at 02:46 AM
--

CREATE TABLE IF NOT EXISTS `blocnotes_relations` (
  `idblocnotes_relations` int(11) NOT NULL AUTO_INCREMENT,
  `blocnotes_items_idblocnotes_items` int(11) NOT NULL,
  `blocnotes_items_idblocnotes_items1` int(11) NOT NULL,
  PRIMARY KEY (`idblocnotes_relations`,`blocnotes_items_idblocnotes_items`,`blocnotes_items_idblocnotes_items1`),
  KEY `fk_blocnotes_relations_blocnotes_items` (`blocnotes_items_idblocnotes_items`),
  KEY `fk_blocnotes_relations_blocnotes_items1` (`blocnotes_items_idblocnotes_items1`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blocnotes_revisions`
--
-- Creation: Nov 22, 2014 at 10:20 AM
-- Last update: Nov 22, 2014 at 10:20 AM
--

CREATE TABLE IF NOT EXISTS `blocnotes_revisions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `serid` int(11) NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `path` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blocnotes_users`
--
-- Creation: Nov 09, 2014 at 06:37 AM
-- Last update: Apr 06, 2015 at 09:23 PM
--

CREATE TABLE IF NOT EXISTS `blocnotes_users` (
  `id_user` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `email` varchar(64) NOT NULL,
  `phone_number` varchar(16) NOT NULL,
  `username` varchar(16) NOT NULL,
  `salt` varchar(50) NOT NULL,
  `password` varchar(80) NOT NULL,
  `confirmcode` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `blocnotes_version`
--
-- Creation: Nov 13, 2014 at 08:47 AM
-- Last update: Nov 13, 2014 at 08:47 AM
--

CREATE TABLE IF NOT EXISTS `blocnotes_version` (
  `idversion` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(1024) DEFAULT NULL,
  `original` varchar(1024) NOT NULL,
  `revision_no` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  PRIMARY KEY (`idversion`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `blocnotes_relations`
--
ALTER TABLE `blocnotes_relations`
  ADD CONSTRAINT `fk_blocnotes_relations_blocnotes_items` FOREIGN KEY (`blocnotes_items_idblocnotes_items`) REFERENCES `blocnotes`.`blocnotes_items` (`idblocnotes_items`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_blocnotes_relations_blocnotes_items1` FOREIGN KEY (`blocnotes_items_idblocnotes_items1`) REFERENCES `blocnotes`.`blocnotes_items` (`idblocnotes_items`) ON DELETE NO ACTION ON UPDATE NO ACTION;

