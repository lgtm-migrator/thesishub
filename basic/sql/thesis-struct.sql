-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u1build0.15.04.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: May 07, 2016 at 01:50 PM
-- Server version: 5.6.27-0ubuntu0.15.04.1
-- PHP Version: 5.6.4-4ubuntu6.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `thesis-utf8`
--

-- --------------------------------------------------------

--
-- Table structure for table `Attachment`
--

DROP TABLE IF EXISTS `Attachment`;
CREATE TABLE IF NOT EXISTS `Attachment` (
`attachment_id` int(250) NOT NULL,
  `thesis_id` int(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` mediumtext,
  `type` varchar(25) DEFAULT NULL,
  `url` varchar(250) DEFAULT NULL,
  `limitation` varchar(250) DEFAULT NULL,
  `visible` smallint(1) DEFAULT '1',
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Comment`
--

DROP TABLE IF EXISTS `Comment`;
CREATE TABLE IF NOT EXISTS `Comment` (
`comment_id` int(250) NOT NULL,
  `thesis_id` int(250) DEFAULT NULL,
  `user_id` int(250) DEFAULT NULL,
  `content` mediumtext,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Department`
--

DROP TABLE IF EXISTS `Department`;
CREATE TABLE IF NOT EXISTS `Department` (
  `department_id` varchar(10) NOT NULL,
  `department_name` varchar(45) DEFAULT NULL,
  `department_description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Group`
--

DROP TABLE IF EXISTS `Group`;
CREATE TABLE IF NOT EXISTS `Group` (
`group_id` int(250) NOT NULL,
  `group_name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `GroupRole`
--

DROP TABLE IF EXISTS `GroupRole`;
CREATE TABLE IF NOT EXISTS `GroupRole` (
  `group_id` int(250) NOT NULL DEFAULT '0',
  `role_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `migration`
--

DROP TABLE IF EXISTS `migration`;
CREATE TABLE IF NOT EXISTS `migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migration`
--

INSERT INTO `migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1462603573),
('m160507_051608_add_is_admin_fields_to_user', 1462603576),
('m160507_061314_create_department_table', 1462603578);

-- --------------------------------------------------------

--
-- Table structure for table `Rating`
--

DROP TABLE IF EXISTS `Rating`;
CREATE TABLE IF NOT EXISTS `Rating` (
`rating_id` int(250) NOT NULL,
  `thesis_id` int(250) DEFAULT NULL,
  `user_id` int(250) DEFAULT NULL,
  `star` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Reference`
--

DROP TABLE IF EXISTS `Reference`;
CREATE TABLE IF NOT EXISTS `Reference` (
`ref_id` int(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `year` int(4) NOT NULL,
  `detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

DROP TABLE IF EXISTS `Role`;
CREATE TABLE IF NOT EXISTS `Role` (
`role_id` int(250) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` mediumtext
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='Danh sách quyền';

--
-- Dumping data for table `Role`
--

INSERT INTO `Role` (`role_id`, `name`, `description`) VALUES
(1, 'admin', NULL),
(2, 'users', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `RoleMapping`
--

DROP TABLE IF EXISTS `RoleMapping`;
CREATE TABLE IF NOT EXISTS `RoleMapping` (
`id` int(11) NOT NULL,
  `principalType` varchar(512) DEFAULT NULL,
  `principalId` varchar(512) DEFAULT NULL,
  `roleId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `Setting`
--

DROP TABLE IF EXISTS `Setting`;
CREATE TABLE IF NOT EXISTS `Setting` (
  `key` varchar(250) NOT NULL,
  `value` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `Setting`
--

INSERT INTO `Setting` (`key`, `value`) VALUES
('appLayout', 'fixed'),
('appName', 'LoopBack Admin'),
('appTheme', 'skin-blue'),
('com.module.users.enable_registration', 'true'),
('formInputSize', '9'),
('formLabelSize', '3'),
('formLayout', 'horizontal');

-- --------------------------------------------------------

--
-- Table structure for table `Tag`
--

DROP TABLE IF EXISTS `Tag`;
CREATE TABLE IF NOT EXISTS `Tag` (
`tag_id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Nhãn khóa luận';

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

DROP TABLE IF EXISTS `tbl_migration`;
CREATE TABLE IF NOT EXISTS `tbl_migration` (
  `version` varchar(180) NOT NULL,
  `apply_time` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `tbl_migration`
--

INSERT INTO `tbl_migration` (`version`, `apply_time`) VALUES
('m000000_000000_base', 1456730192),
('m160229_071123_create_user_table', 1456730215);

-- --------------------------------------------------------

--
-- Table structure for table `Thesis`
--

DROP TABLE IF EXISTS `Thesis`;
CREATE TABLE IF NOT EXISTS `Thesis` (
`thesis_id` int(250) NOT NULL,
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
  `department_id` varchar(10) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ThesisMapping`
--

DROP TABLE IF EXISTS `ThesisMapping`;
CREATE TABLE IF NOT EXISTS `ThesisMapping` (
  `thesis_id` int(250) NOT NULL,
  `user_id` int(250) NOT NULL DEFAULT '0',
  `type` varchar(25) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Thông tin sinh viên khóa luận, phân công';

-- --------------------------------------------------------

--
-- Table structure for table `ThesisReference`
--

DROP TABLE IF EXISTS `ThesisReference`;
CREATE TABLE IF NOT EXISTS `ThesisReference` (
  `thesis_id` int(255) NOT NULL,
  `ref_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ThesisTag`
--

DROP TABLE IF EXISTS `ThesisTag`;
CREATE TABLE IF NOT EXISTS `ThesisTag` (
  `thesis_id` int(250) NOT NULL DEFAULT '0',
  `tag_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

DROP TABLE IF EXISTS `User`;
CREATE TABLE IF NOT EXISTS `User` (
`user_id` int(250) NOT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `subject` varchar(20) DEFAULT NULL,
  `is_lecture` smallint(1) DEFAULT '0',
  `is_admin` int(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='Thành viên';

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`user_id`, `username`, `password`, `name`, `subject`, `is_lecture`, `is_admin`) VALUES
(1, 'admin', '49fbed9663411053919ce1923670715c', 'Abcc', 'ccccccccccc', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `UserRole`
--

DROP TABLE IF EXISTS `UserRole`;
CREATE TABLE IF NOT EXISTS `UserRole` (
  `role_id` int(250) NOT NULL,
  `user_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Attachment`
--
ALTER TABLE `Attachment`
 ADD PRIMARY KEY (`attachment_id`), ADD KEY `thesis_id` (`thesis_id`);

--
-- Indexes for table `Comment`
--
ALTER TABLE `Comment`
 ADD PRIMARY KEY (`comment_id`), ADD KEY `thesis_id` (`thesis_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Department`
--
ALTER TABLE `Department`
 ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `Group`
--
ALTER TABLE `Group`
 ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `GroupRole`
--
ALTER TABLE `GroupRole`
 ADD PRIMARY KEY (`group_id`,`role_id`), ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `migration`
--
ALTER TABLE `migration`
 ADD PRIMARY KEY (`version`);

--
-- Indexes for table `Rating`
--
ALTER TABLE `Rating`
 ADD PRIMARY KEY (`rating_id`), ADD KEY `thesis_id` (`thesis_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Reference`
--
ALTER TABLE `Reference`
 ADD PRIMARY KEY (`ref_id`);

--
-- Indexes for table `Role`
--
ALTER TABLE `Role`
 ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `RoleMapping`
--
ALTER TABLE `RoleMapping`
 ADD PRIMARY KEY (`id`);

--
-- Indexes for table `Setting`
--
ALTER TABLE `Setting`
 ADD PRIMARY KEY (`key`);

--
-- Indexes for table `Tag`
--
ALTER TABLE `Tag`
 ADD PRIMARY KEY (`tag_id`);

--
-- Indexes for table `tbl_migration`
--
ALTER TABLE `tbl_migration`
 ADD PRIMARY KEY (`version`);

--
-- Indexes for table `Thesis`
--
ALTER TABLE `Thesis`
 ADD PRIMARY KEY (`thesis_id`), ADD KEY `idx-thesis-department_id` (`department_id`);

--
-- Indexes for table `ThesisMapping`
--
ALTER TABLE `ThesisMapping`
 ADD PRIMARY KEY (`thesis_id`,`user_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ThesisReference`
--
ALTER TABLE `ThesisReference`
 ADD UNIQUE KEY `thesis_id` (`thesis_id`,`ref_id`), ADD KEY `ref_id` (`ref_id`);

--
-- Indexes for table `ThesisTag`
--
ALTER TABLE `ThesisTag`
 ADD PRIMARY KEY (`tag_id`,`thesis_id`), ADD KEY `thesis_id` (`thesis_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
 ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `UserRole`
--
ALTER TABLE `UserRole`
 ADD PRIMARY KEY (`role_id`,`user_id`), ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Attachment`
--
ALTER TABLE `Attachment`
MODIFY `attachment_id` int(250) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Comment`
--
ALTER TABLE `Comment`
MODIFY `comment_id` int(250) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Group`
--
ALTER TABLE `Group`
MODIFY `group_id` int(250) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Rating`
--
ALTER TABLE `Rating`
MODIFY `rating_id` int(250) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Reference`
--
ALTER TABLE `Reference`
MODIFY `ref_id` int(255) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Role`
--
ALTER TABLE `Role`
MODIFY `role_id` int(250) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `RoleMapping`
--
ALTER TABLE `RoleMapping`
MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Tag`
--
ALTER TABLE `Tag`
MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `Thesis`
--
ALTER TABLE `Thesis`
MODIFY `thesis_id` int(250) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `User`
--
ALTER TABLE `User`
MODIFY `user_id` int(250) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `Attachment`
--
ALTER TABLE `Attachment`
ADD CONSTRAINT `Attachment_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `Thesis` (`thesis_id`);

--
-- Constraints for table `Comment`
--
ALTER TABLE `Comment`
ADD CONSTRAINT `Comment_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `Thesis` (`thesis_id`),
ADD CONSTRAINT `Comment_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

--
-- Constraints for table `GroupRole`
--
ALTER TABLE `GroupRole`
ADD CONSTRAINT `GroupRole_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `Group` (`group_id`),
ADD CONSTRAINT `GroupRole_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `Role` (`role_id`);

--
-- Constraints for table `Rating`
--
ALTER TABLE `Rating`
ADD CONSTRAINT `Rating_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `Thesis` (`thesis_id`),
ADD CONSTRAINT `Rating_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

--
-- Constraints for table `Thesis`
--
ALTER TABLE `Thesis`
ADD CONSTRAINT `fk_Thesis_1_Department` FOREIGN KEY (`department_id`) REFERENCES `Department` (`department_id`) ON DELETE CASCADE;

--
-- Constraints for table `ThesisMapping`
--
ALTER TABLE `ThesisMapping`
ADD CONSTRAINT `ThesisMapping_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `Thesis` (`thesis_id`),
ADD CONSTRAINT `ThesisMapping_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

--
-- Constraints for table `ThesisReference`
--
ALTER TABLE `ThesisReference`
ADD CONSTRAINT `ThesisReference_ibfk_1` FOREIGN KEY (`ref_id`) REFERENCES `Reference` (`ref_id`),
ADD CONSTRAINT `ThesisReference_ibfk_2` FOREIGN KEY (`thesis_id`) REFERENCES `Thesis` (`thesis_id`);

--
-- Constraints for table `ThesisTag`
--
ALTER TABLE `ThesisTag`
ADD CONSTRAINT `ThesisTag_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `Thesis` (`thesis_id`),
ADD CONSTRAINT `ThesisTag_ibfk_2` FOREIGN KEY (`tag_id`) REFERENCES `Tag` (`tag_id`);

--
-- Constraints for table `UserRole`
--
ALTER TABLE `UserRole`
ADD CONSTRAINT `UserRole_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `Role` (`role_id`),
ADD CONSTRAINT `UserRole_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
