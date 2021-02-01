/*
SQLyog Community v13.1.5  (64 bit)
MySQL - 8.0.21 : Database - lms
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`lms` /*!40100 DEFAULT CHARACTER SET utf8 */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `lms`;

/*Data for the table `permissions` */

insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (1,'role-list','web','2020-12-17 23:25:01','2020-12-17 23:25:01');
insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (2,'role-create','web','2020-12-17 23:25:01','2020-12-17 23:25:01');
insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (3,'role-edit','web','2020-12-17 23:25:01','2020-12-17 23:25:01');
insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (4,'role-delete','web','2020-12-17 23:25:01','2020-12-17 23:25:01');
insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (5,'product-list','web','2020-12-17 23:25:01','2020-12-17 23:25:01');
insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (6,'product-create','web','2020-12-17 23:25:01','2020-12-17 23:25:01');
insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (7,'product-edit','web','2020-12-17 23:25:01','2020-12-17 23:25:01');
insert  into `permissions`(`id`,`name`,`guard_name`,`created_at`,`updated_at`) values (8,'product-delete','web','2020-12-17 23:25:01','2020-12-17 23:25:01');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
