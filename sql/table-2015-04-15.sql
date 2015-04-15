-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Host: 10.246.16.55:3306
-- Generation Time: Apr 15, 2015 at 02:12 PM
-- Server version: 5.5.42-MariaDB-1~wheezy
-- PHP Version: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `manudahmen_be`
--

-- --------------------------------------------------------

--
-- Table structure for table `blocnotes_items`
--

CREATE TABLE IF NOT EXISTS `blocnotes_items` (
  `serid` int(11) DEFAULT NULL,
  `filename` varchar(1024) NOT NULL,
  `user` varchar(128) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `moment` datetime NOT NULL,
  `type` varchar(10000) NOT NULL,
  `contenu` mediumtext NOT NULL,
  PRIMARY KEY (`id`),
  KEY `iditem` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=287 ;

-- --------------------------------------------------------

--
-- Table structure for table `blocnotes_item_type`
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

CREATE TABLE IF NOT EXISTS `blocnotes_link` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom_element_porteur` varchar(1024) DEFAULT NULL,
  `nom_element_dependant` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `blocnotes_login`
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

