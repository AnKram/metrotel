/*
SQLyog Ultimate v12.5.1 (64 bit)
MySQL - 5.6.43-log : Database - test_database
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`test_database` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `test_database`;

/*Table structure for table `directory_entries` */

DROP TABLE IF EXISTS `directory_entries`;

CREATE TABLE `directory_entries` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `user_id` int(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `surname` varchar(128) DEFAULT NULL,
  `first_number` int(128) DEFAULT NULL,
  `second_number` int(128) DEFAULT NULL,
  `email` varchar(128) DEFAULT NULL,
  `image` varchar(128) DEFAULT NULL,
  `date_added` datetime DEFAULT NULL,
  `date_updated` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `directory_users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8;

/*Table structure for table `directory_users` */

DROP TABLE IF EXISTS `directory_users`;

CREATE TABLE `directory_users` (
  `id` int(64) NOT NULL AUTO_INCREMENT,
  `login` varchar(128) NOT NULL,
  `pass` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `date_added` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
