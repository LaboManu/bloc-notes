SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


-- --------------------------------------------------------

--
-- Table structure for table `blocnotes_items`
--

CREATE TABLE IF NOT EXISTS `blocnotes_items` (
  `serid` int(11) DEFAULT NULL,
  `filename` varchar(1024) NOT NULL,
  `user` varchar(128) NOT NULL,
  `id` int(11) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`id`),
  KEY `iditem` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=69 ;

--
-- Dumping data for table `blocnotes_items`
--

INSERT INTO `blocnotes_items` (`serid`, `filename`, `user`, `id`) VALUES
(NULL, 'IMG__101114_011539.emptycanvas-2014-11-006.jar', 'Manu', 2),
(NULL, 'IMG__101114_011538.emptycanvas-2014-11-004.jar', 'Manu', 3),
(NULL, 'IMG__101114_011538.emptycanvas-2014-11-004.jar', 'Manu', 4),
(NULL, 'IMG__101114_011538.emptycanvas-2014-11-004.jar', 'Manu', 5),
(NULL, 'IMG__101114_011538.emptycanvas-2014-11-004.jar', 'Manu', 6),
(NULL, 'IMG__101114_011538.emptycanvas-2014-11-004.jar', 'Manu', 7),
(NULL, 'IMG__101114_011538.emptycanvas-2014-11-004.jar', 'Manu', 8),
(NULL, 'IMG__101114_011538.emptycanvas-2014-11-004.jar', 'Manu', 9),
(NULL, 'Taches - Emptycanvas.TXT', 'Manu', 10),
(NULL, 'Tache Mary.TXT', 'Manu', 11),
(NULL, 'MOI.JPG', 'Manu', 12),
(NULL, 'Emptycanvas 24.TXT', 'Manu', 13),
(NULL, 'Emptycanvas 25.TXT', 'Manu', 14),
(NULL, 'Anniversaires', 'Manu', 15),
(NULL, 'Emptycanvas 25.TXT', 'Manu', 16),
(NULL, 'Emptycanvas 25.TXT', 'Manu', 17),
(NULL, 'Emptycanvas 25.TXT', 'Manu', 18),
(NULL, 'Anniversaires', 'Manu', 19),
(NULL, 'Emptycanvas 24.TXT', 'Manu', 20),
(NULL, 'Tache Mary.TXT', 'Manu', 21),
(NULL, 'Taches - Emptycanvas.TXT', 'Manu', 22),
(NULL, 'Taches - Emptycanvas.TXT', 'Manu', 23),
(NULL, '__SERID_0__frame1004982.jpg', 'Manu', 24),
(NULL, '__SERID_0__frame1004982.jpg', 'Manu', 25),
(NULL, '__SERID_0__frame1004982.jpg', 'Manu', 26),
(NULL, 'Emptycanvas 25.TXT', 'Manu', 27),
(NULL, '__SERID_0__frame1004982.jpg', 'Manu', 28),
(NULL, '__SERID_0__frame1000020.jpg', 'Manu', 29),
(NULL, '__SERID_0__frame1000020.jpg', 'Manu', 30),
(NULL, '__SERID_0__frame1004982.jpg', 'Manu', 31),
(NULL, '__SERID_0__frame1004982.jpg', 'Manu', 32),
(NULL, 'Emptycanvas 25.TXT', 'Manu', 33),
(NULL, '__SERID_0__frame1000020.jpg', 'Manu', 34),
(NULL, '__SERID_0__frame1001189.jpg', 'Manu', 35),
(NULL, 'Anniversaires', 'Manu', 36),
(NULL, 'note 1868444846.TXT', 'Manu', 37),
(NULL, 'Emptycanvas 24.TXT', 'Manu', 38),
(NULL, '__SERID_0__frame1000001 (6).jpg', 'Manu', 39),
(NULL, '__SERID_0__frame1000001 (2).jpg', 'Manu', 40),
(NULL, 'spheres.jpg', 'Manu', 41),
(NULL, '.', 'Manu', 42),
(NULL, '..', 'Manu', 43),
(NULL, '..', 'Manu', 44),
(NULL, '.', 'Manu', 45),
(NULL, '.', 'Manu', 46),
(NULL, '.', 'Manu', 47),
(NULL, '.', 'Manu', 48),
(NULL, '.', 'Manu', 49),
(NULL, '.', 'Manu', 50),
(NULL, '.', 'Manu', 51),
(NULL, 'somebody.txt', 'Manu', 52),
(NULL, '.picasa.ini', 'Manu', 53),
(NULL, '.picasa.ini', 'Manu', 54),
(NULL, '__SERID_0__frame1000027.png', 'Manu', 55),
(NULL, '__SERID_0__frame1000027.png', 'Manu', 56),
(NULL, '__SERID_0__frame1000027.png', 'Manu', 57),
(NULL, '__SERID_0__frame1000027.png', 'Manu', 58),
(NULL, '__SERID_0__frame1000027.png', 'Manu', 59),
(NULL, '__SERID_0__frame1000027.png', 'Manu', 60),
(NULL, '__SERID_0__frame1000027.png', 'Manu', 61),
(NULL, '__SERID_0__frame1000027.png', 'Manu', 62),
(NULL, '__SERID_0__frame1000027.png', 'Manu', 63),
(NULL, '.', 'Manu', 64),
(NULL, '.', 'Manu', 65),
(NULL, '__SERID_0__frame1000001 (4).jpg', 'Manu', 66),
(NULL, 'troisbandes.jpg', 'Manu', 67),
(NULL, '__SERID_0__frame1000001_2.jpg', 'Manu', 68);

-- --------------------------------------------------------

--
-- Table structure for table `blocnotes_item_type`
--

CREATE TABLE IF NOT EXISTS `blocnotes_item_type` (
  `type` int(11) NOT NULL DEFAULT '0',
  `name` varchar(256) DEFAULT NULL,
  `application` varchar(1024) DEFAULT NULL,
  PRIMARY KEY (`type`),
  UNIQUE KEY `type_2` (`type`),
  KEY `type` (`type`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `blocnotes_item_type`
--

INSERT INTO `blocnotes_item_type` (`type`, `name`, `application`) VALUES
(7, 'image/png', 'explorer'),
(6, 'image/jpg', 'explorer'),
(4, 'text/plain', 'notepad'),
(5, 'text/html', 'explorer'),
(9, 'video/mpg', 'explorer'),
(10, 'audio/mp3', 'explorer');

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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `blocnotes_users`
--

INSERT INTO `blocnotes_users` (`id_user`, `name`, `email`, `phone_number`, `username`, `salt`, `password`, `confirmcode`) VALUES
(1, 'Manu', 'manuel.dahmen@gmail.com', '', 'manu', 'e7babc505b', 'qMrXuaRAijf91JiWgL8Fdg6kVANlN2JhYmM1MDVi', 'y');

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

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

