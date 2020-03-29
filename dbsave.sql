-- Adminer 4.7.1 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE `bache` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `bache`;

DROP TABLE IF EXISTS `crowd`;
CREATE TABLE `crowd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` point NOT NULL,
  `reports_count` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `active` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `crowd` (`id`, `location`, `reports_count`, `created_at`, `active`) VALUES
(9,	GeomFromText('POINT(23.0916096 -82.382848)'),	2,	'2019-08-28 08:21:51',	1);

DROP TABLE IF EXISTS `report`;
CREATE TABLE `report` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `location` point NOT NULL,
  `device_uuid` varchar(255) DEFAULT NULL,
  `crowd_id` int(11) NOT NULL,
  `additional_data` longtext,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `crowd_id` (`crowd_id`),
  CONSTRAINT `report_ibfk_1` FOREIGN KEY (`crowd_id`) REFERENCES `crowd` (`id`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `report` (`id`, `location`, `device_uuid`, `crowd_id`, `additional_data`, `created_at`) VALUES
(44,	GeomFromText('POINT(23.0916096 -82.382848)'),	NULL,	9,	'{\"platform\":null,\"model\":null,\"os_version\":null,\"manufacturer\":null,\"serial\":null}',	'2019-08-28 08:21:51'),
(45,	GeomFromText('POINT(23.0916096 -82.382848)'),	NULL,	9,	'{\"platform\":null,\"model\":null,\"os_version\":null,\"manufacturer\":null,\"serial\":null}',	'2019-08-28 08:24:30');

-- 2019-08-29 03:53:19

