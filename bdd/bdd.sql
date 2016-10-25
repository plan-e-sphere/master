-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 18, 2015 at 08:43 AM
-- Server version: 5.6.17
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `juntos`
--

-- --------------------------------------------------------

--
-- Table structure for table `amities`
--

CREATE TABLE IF NOT EXISTS `amities` (
  `amities_id` int(11) NOT NULL AUTO_INCREMENT,
  `amities_users_principal` int(11) DEFAULT NULL,
  `amities_users_secondaire` int(11) DEFAULT NULL,
  `amities_validation` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`amities_id`),
  KEY `fk_users_has_users_users2_idx` (`amities_users_secondaire`),
  KEY `fk_users_has_users_users1_idx` (`amities_users_principal`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE IF NOT EXISTS `events` (
  `events_id` int(11) NOT NULL AUTO_INCREMENT,
  `events_libelle` varchar(45) DEFAULT NULL,
  `events_date_debut` datetime DEFAULT NULL,
  `events_date_fin` datetime DEFAULT NULL,
  `events_nb_participants_max` int(11) DEFAULT NULL,
  `events_keyword` varchar(255) DEFAULT NULL,
  `events_validation` tinyint(1) DEFAULT NULL,
  `events_publication` enum('Private','Public') DEFAULT NULL,
  PRIMARY KEY (`events_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Table structure for table `fournitures`
--

CREATE TABLE IF NOT EXISTS `fournitures` (
  `fournitures_id` int(11) NOT NULL AUTO_INCREMENT,
  `fournitures_libelle` varchar(255) DEFAULT NULL,
  `fournitures_quantite` int(11) DEFAULT NULL,
  `fournitures_unite` varchar(45) DEFAULT NULL,
  `fournitures_requis` tinyint(1) DEFAULT NULL,
  `events_events_id` int(11) NOT NULL,
  PRIMARY KEY (`fournitures_id`,`events_events_id`),
  KEY `fk_fournitures_events1_idx` (`events_events_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Table structure for table `ln_users_events`
--

CREATE TABLE IF NOT EXISTS `ln_users_events` (
  `ln_users_events_id` varchar(45) NOT NULL,
  `users_users_id` int(11) NOT NULL,
  `events_events_id` int(11) NOT NULL,
  `ln_users_events_role` enum('createur','moderateur','participant') NOT NULL,
  `ln_users_events_accepted` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`ln_users_events_id`),
  KEY `fk_users_has_events_events1_idx` (`events_events_id`),
  KEY `fk_users_has_events_users_idx` (`users_users_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ln_users_fourniture`
--

CREATE TABLE IF NOT EXISTS `ln_users_fourniture` (
  `fournitures_fournitures_id` int(11) NOT NULL,
  `users_users_id` int(11) NOT NULL,
  `ln_users_fourniture_qte` decimal(2,0) NOT NULL,
  `ln_users_fourniture_detail` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`fournitures_fournitures_id`,`users_users_id`),
  KEY `fk_fournitures_has_users_users1_idx` (`users_users_id`),
  KEY `fk_fournitures_has_users_fournitures1_idx` (`fournitures_fournitures_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE IF NOT EXISTS `notifications` (
  `notifications_id` int(11) NOT NULL AUTO_INCREMENT,
  `notifications_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `notifications_users_id` int(11) NOT NULL,
  `notifications_users_emetteur_id` int(11) NOT NULL,
  `notifications_events_id` int(11) DEFAULT NULL,
  `notifications_type` varchar(45) NOT NULL,
  `notifications_lu` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`notifications_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `users_id` int(11) NOT NULL AUTO_INCREMENT,
  `users_nom` varchar(45) DEFAULT NULL,
  `users_prenom` varchar(45) DEFAULT NULL,
  `users_mail` varchar(45) DEFAULT NULL,
  `users_pseudo` varchar(45) DEFAULT NULL,
  `users_password` varchar(45) DEFAULT NULL,
  `users_photo` varchar(255) NOT NULL,
  PRIMARY KEY (`users_id`),
  UNIQUE KEY `users_mail` (`users_mail`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=0 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `amities`
--
ALTER TABLE `amities`
  ADD CONSTRAINT `fk_users_has_users_users1` FOREIGN KEY (`amities_users_principal`) REFERENCES `users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_users_users2` FOREIGN KEY (`amities_users_secondaire`) REFERENCES `users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `fournitures`
--
ALTER TABLE `fournitures`
  ADD CONSTRAINT `fk_fournitures_events1` FOREIGN KEY (`events_events_id`) REFERENCES `events` (`events_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ln_users_events`
--
ALTER TABLE `ln_users_events`
  ADD CONSTRAINT `fk_users_has_events_events1` FOREIGN KEY (`events_events_id`) REFERENCES `events` (`events_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_users_has_events_users` FOREIGN KEY (`users_users_id`) REFERENCES `users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `ln_users_fourniture`
--
ALTER TABLE `ln_users_fourniture`
  ADD CONSTRAINT `fk_fournitures_has_users_fournitures1` FOREIGN KEY (`fournitures_fournitures_id`) REFERENCES `fournitures` (`fournitures_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_fournitures_has_users_users1` FOREIGN KEY (`users_users_id`) REFERENCES `users` (`users_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

