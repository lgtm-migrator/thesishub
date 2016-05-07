CREATE DATABASE  IF NOT EXISTS `thesis` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `thesis`;
-- MySQL dump 10.13  Distrib 5.5.49, for debian-linux-gnu (x86_64)
--
-- Host: 127.0.0.1    Database: thesis
-- ------------------------------------------------------
-- Server version	5.5.49-0ubuntu0.14.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `Attachment`
--

DROP TABLE IF EXISTS `Attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Attachment` (
  `attachment_id` int(250) NOT NULL AUTO_INCREMENT,
  `thesis_id` int(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` mediumtext,
  `type` varchar(25) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `limitation` varchar(250) DEFAULT NULL,
  `visible` smallint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`attachment_id`),
  KEY `thesis_id` (`thesis_id`),
  CONSTRAINT `Attachment_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `Thesis` (`thesis_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Attachment`
--

LOCK TABLES `Attachment` WRITE;
/*!40000 ALTER TABLE `Attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `Attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Comment`
--

DROP TABLE IF EXISTS `Comment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Comment` (
  `comment_id` int(250) NOT NULL AUTO_INCREMENT,
  `thesis_id` int(250) DEFAULT NULL,
  `user_id` int(250) DEFAULT NULL,
  `content` mediumtext,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`comment_id`),
  KEY `thesis_id` (`thesis_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `Thesis` (`thesis_id`),
  CONSTRAINT `Comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Comment`
--

LOCK TABLES `Comment` WRITE;
/*!40000 ALTER TABLE `Comment` DISABLE KEYS */;
/*!40000 ALTER TABLE `Comment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Department`
--

DROP TABLE IF EXISTS `Department`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Department` (
  `department_id` varchar(10) NOT NULL DEFAULT '',
  `department_name` varchar(45) DEFAULT NULL,
  `Department_description` text,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Department`
--

LOCK TABLES `Department` WRITE;
/*!40000 ALTER TABLE `Department` DISABLE KEYS */;
/*!40000 ALTER TABLE `Department` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Group`
--

DROP TABLE IF EXISTS `Group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Group` (
  `group_id` int(250) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Group`
--

LOCK TABLES `Group` WRITE;
/*!40000 ALTER TABLE `Group` DISABLE KEYS */;
/*!40000 ALTER TABLE `Group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `GroupRole`
--

DROP TABLE IF EXISTS `GroupRole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GroupRole` (
  `group_id` int(250) NOT NULL DEFAULT '0',
  `role_id` int(250) NOT NULL,
  PRIMARY KEY (`group_id`,`role_id`),
  KEY `role_id` (`role_id`),
  CONSTRAINT `GroupRole_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `Group` (`group_id`),
  CONSTRAINT `GroupRole_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `Role` (`role_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `GroupRole`
--

LOCK TABLES `GroupRole` WRITE;
/*!40000 ALTER TABLE `GroupRole` DISABLE KEYS */;
/*!40000 ALTER TABLE `GroupRole` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Rating`
--

DROP TABLE IF EXISTS `Rating`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Rating` (
  `rating_id` int(250) NOT NULL AUTO_INCREMENT,
  `thesis_id` int(250) DEFAULT NULL,
  `user_id` int(250) DEFAULT NULL,
  `star` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`rating_id`),
  KEY `thesis_id` (`thesis_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `Rating_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `Thesis` (`thesis_id`),
  CONSTRAINT `Rating_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Rating`
--

LOCK TABLES `Rating` WRITE;
/*!40000 ALTER TABLE `Rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `Rating` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Reference`
--

DROP TABLE IF EXISTS `Reference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Reference` (
  `ref_id` int(255) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `year` int(4) NOT NULL,
  `detail` text NOT NULL,
  PRIMARY KEY (`ref_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Reference`
--

LOCK TABLES `Reference` WRITE;
/*!40000 ALTER TABLE `Reference` DISABLE KEYS */;
/*!40000 ALTER TABLE `Reference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Role`
--

DROP TABLE IF EXISTS `Role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Role` (
  `role_id` int(250) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  `description` mediumtext,
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Danh sách quyền';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Role`
--

LOCK TABLES `Role` WRITE;
/*!40000 ALTER TABLE `Role` DISABLE KEYS */;
INSERT INTO `Role` VALUES (1,'admin',NULL),(2,'users',NULL);
/*!40000 ALTER TABLE `Role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `RoleMapping`
--

DROP TABLE IF EXISTS `RoleMapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `RoleMapping` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `principalType` varchar(512) DEFAULT NULL,
  `principalId` varchar(512) DEFAULT NULL,
  `roleId` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `RoleMapping`
--

LOCK TABLES `RoleMapping` WRITE;
/*!40000 ALTER TABLE `RoleMapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `RoleMapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Setting`
--

DROP TABLE IF EXISTS `Setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Setting` (
  `key` varchar(250) NOT NULL,
  `value` mediumtext,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Setting`
--

LOCK TABLES `Setting` WRITE;
/*!40000 ALTER TABLE `Setting` DISABLE KEYS */;
INSERT INTO `Setting` VALUES ('appLayout','fixed'),('appName','LoopBack Admin'),('appTheme','skin-blue'),('com.module.users.enable_registration','true'),('formInputSize','9'),('formLabelSize','3'),('formLayout','horizontal');
/*!40000 ALTER TABLE `Setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Tag`
--

DROP TABLE IF EXISTS `Tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) DEFAULT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Nhãn khóa luận';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Tag`
--

LOCK TABLES `Tag` WRITE;
/*!40000 ALTER TABLE `Tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `Tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Thesis`
--

DROP TABLE IF EXISTS `Thesis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Thesis` (
  `thesis_id` int(250) NOT NULL AUTO_INCREMENT,
  `thesis_name` varchar(250) DEFAULT NULL,
  `intro` mediumtext,
  `score_instructor` decimal(10,0) DEFAULT NULL,
  `score_reviewer` decimal(10,0) DEFAULT NULL,
  `score_council` decimal(10,0) DEFAULT NULL,
  `score_total` decimal(10,0) DEFAULT NULL,
  `have_disk` smallint(1) DEFAULT '0',
  `counter` int(11) DEFAULT '0',
  `created` datetime DEFAULT NULL,
  `status` varchar(25) DEFAULT NULL,
  `note` mediumtext,
  `department` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`thesis_id`),
  KEY `fk_Thesis_1_idx` (`department`),
  CONSTRAINT `fk_Thesis_1` FOREIGN KEY (`department`) REFERENCES `Department` (`department_id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Thesis`
--

LOCK TABLES `Thesis` WRITE;
/*!40000 ALTER TABLE `Thesis` DISABLE KEYS */;
INSERT INTO `Thesis` VALUES (2,'cdgdfgdfg','trytrtyrty',12,12,12,12,0,0,'0000-00-00 00:00:00','','',NULL),(3,'fghfgh fgh fgh','fghf gh fgh',12,45,4,32,0,0,'0000-00-00 00:00:00','','ertert',NULL);
/*!40000 ALTER TABLE `Thesis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ThesisMapping`
--

DROP TABLE IF EXISTS `ThesisMapping`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ThesisMapping` (
  `thesis_id` int(250) NOT NULL,
  `user_id` int(250) NOT NULL DEFAULT '0',
  `type` varchar(25) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`thesis_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `ThesisMapping_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `Thesis` (`thesis_id`),
  CONSTRAINT `ThesisMapping_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Thông tin sinh viên khóa luận, phân công';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ThesisMapping`
--

LOCK TABLES `ThesisMapping` WRITE;
/*!40000 ALTER TABLE `ThesisMapping` DISABLE KEYS */;
/*!40000 ALTER TABLE `ThesisMapping` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ThesisReference`
--

DROP TABLE IF EXISTS `ThesisReference`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ThesisReference` (
  `thesis_id` int(255) NOT NULL,
  `ref_id` int(255) NOT NULL,
  UNIQUE KEY `thesis_id` (`thesis_id`,`ref_id`),
  KEY `ref_id` (`ref_id`),
  CONSTRAINT `ThesisReference_ibfk_1` FOREIGN KEY (`ref_id`) REFERENCES `Reference` (`ref_id`),
  CONSTRAINT `ThesisReference_ibfk_2` FOREIGN KEY (`thesis_id`) REFERENCES `Thesis` (`thesis_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ThesisReference`
--

LOCK TABLES `ThesisReference` WRITE;
/*!40000 ALTER TABLE `ThesisReference` DISABLE KEYS */;
/*!40000 ALTER TABLE `ThesisReference` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ThesisTag`
--

DROP TABLE IF EXISTS `ThesisTag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ThesisTag` (
  `thesis_id` int(250) NOT NULL DEFAULT '0',
  `tag_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tag_id`,`thesis_id`),
  KEY `thesis_id` (`thesis_id`),
  CONSTRAINT `ThesisTag_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `Thesis` (`thesis_id`),
  CONSTRAINT `ThesisTag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `Tag` (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ThesisTag`
--

LOCK TABLES `ThesisTag` WRITE;
/*!40000 ALTER TABLE `ThesisTag` DISABLE KEYS */;
/*!40000 ALTER TABLE `ThesisTag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `User` (
  `user_id` int(250) NOT NULL AUTO_INCREMENT,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `subject` varchar(20) DEFAULT NULL,
  `is_lecture` smallint(1) DEFAULT '0',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Thành viên';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `User`
--

LOCK TABLES `User` WRITE;
/*!40000 ALTER TABLE `User` DISABLE KEYS */;
/*!40000 ALTER TABLE `User` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `UserRole`
--

DROP TABLE IF EXISTS `UserRole`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `UserRole` (
  `role_id` int(250) NOT NULL,
  `user_id` int(250) NOT NULL,
  PRIMARY KEY (`role_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `UserRole_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `Role` (`role_id`),
  CONSTRAINT `UserRole_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `UserRole`
--

LOCK TABLES `UserRole` WRITE;
/*!40000 ALTER TABLE `UserRole` DISABLE KEYS */;
/*!40000 ALTER TABLE `UserRole` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tbl_migration`
--

DROP TABLE IF EXISTS `tbl_migration`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tbl_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tbl_migration`
--

LOCK TABLES `tbl_migration` WRITE;
/*!40000 ALTER TABLE `tbl_migration` DISABLE KEYS */;
INSERT INTO `tbl_migration` VALUES ('m000000_000000_base',1456730192),('m160229_071123_create_user_table',1456730215);
/*!40000 ALTER TABLE `tbl_migration` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-05-07 12:17:45
