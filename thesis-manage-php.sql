-- phpMyAdmin SQL Dump
-- version 4.4.13.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 29, 2016 at 03:25 PM
-- Server version: 5.6.28-0ubuntu0.15.10.1
-- PHP Version: 5.6.11-1ubuntu3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `thesis-manage-php`
--

-- --------------------------------------------------------

--
-- Table structure for table `Attachment`
--

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Comment`
--

CREATE TABLE IF NOT EXISTS `Comment` (
  `comment_id` int(250) NOT NULL,
  `thesis_id` int(250) DEFAULT NULL,
  `user_id` int(250) DEFAULT NULL,
  `content` mediumtext,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Group`
--

CREATE TABLE IF NOT EXISTS `Group` (
  `group_id` int(250) NOT NULL,
  `group_name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `GroupRole`
--

CREATE TABLE IF NOT EXISTS `GroupRole` (
  `group_id` int(250) NOT NULL DEFAULT '0',
  `role_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Rating`
--

CREATE TABLE IF NOT EXISTS `Rating` (
  `rating_id` int(250) NOT NULL,
  `thesis_id` int(250) DEFAULT NULL,
  `user_id` int(250) DEFAULT NULL,
  `star` int(11) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

CREATE TABLE IF NOT EXISTS `Role` (
  `role_id` int(250) NOT NULL,
  `name` varchar(250) DEFAULT NULL,
  `description` mediumtext
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1 COMMENT='Danh sách quyền';

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

CREATE TABLE IF NOT EXISTS `RoleMapping` (
  `id` int(11) NOT NULL,
  `principalType` varchar(512) DEFAULT NULL,
  `principalId` varchar(512) DEFAULT NULL,
  `roleId` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `Setting`
--

CREATE TABLE IF NOT EXISTS `Setting` (
  `key` varchar(250) NOT NULL,
  `value` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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

CREATE TABLE IF NOT EXISTS `Tag` (
  `tag_id` int(11) NOT NULL,
  `name` varchar(250) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Nhãn khóa luận';

-- --------------------------------------------------------

--
-- Table structure for table `tbl_migration`
--

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
  `note` mediumtext
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `Thesis`
--

INSERT INTO `Thesis` (`thesis_id`, `thesis_name`, `intro`, `score_instructor`, `score_reviewer`, `score_council`, `score_total`, `have_disk`, `counter`, `created`, `status`, `note`) VALUES
(2, 'cdgdfgdfg', 'trytrtyrty', '12', '12', '12', '12', 0, 0, '0000-00-00 00:00:00', '', ''),
(3, 'fghfgh fgh fgh', 'fghf gh fgh', '12', '45', '4', '32', 0, 0, '0000-00-00 00:00:00', '', 'ertert');

-- --------------------------------------------------------

--
-- Table structure for table `ThesisMapping`
--

CREATE TABLE IF NOT EXISTS `ThesisMapping` (
  `thesis_id` int(250) NOT NULL,
  `user_id` int(250) NOT NULL DEFAULT '0',
  `type` varchar(25) DEFAULT NULL,
  `created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Thông tin sinh viên khóa luận, phân công';

-- --------------------------------------------------------

--
-- Table structure for table `ThesisTag`
--

CREATE TABLE IF NOT EXISTS `ThesisTag` (
  `thesis_id` int(250) NOT NULL DEFAULT '0',
  `tag_id` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE IF NOT EXISTS `User` (
  `user_id` int(250) NOT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `name` varchar(250) DEFAULT NULL,
  `subject` varchar(20) DEFAULT NULL,
  `is_lecture` smallint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Thành viên';

-- --------------------------------------------------------

--
-- Table structure for table `UserRole`
--

CREATE TABLE IF NOT EXISTS `UserRole` (
  `role_id` int(250) NOT NULL,
  `user_id` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `Attachment`
--
ALTER TABLE `Attachment`
  ADD PRIMARY KEY (`attachment_id`),
  ADD KEY `thesis_id` (`thesis_id`);

--
-- Indexes for table `Comment`
--
ALTER TABLE `Comment`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `thesis_id` (`thesis_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `Group`
--
ALTER TABLE `Group`
  ADD PRIMARY KEY (`group_id`);

--
-- Indexes for table `GroupRole`
--
ALTER TABLE `GroupRole`
  ADD PRIMARY KEY (`group_id`,`role_id`),
  ADD KEY `role_id` (`role_id`);

--
-- Indexes for table `Rating`
--
ALTER TABLE `Rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `thesis_id` (`thesis_id`),
  ADD KEY `user_id` (`user_id`);

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
  ADD PRIMARY KEY (`thesis_id`);

--
-- Indexes for table `ThesisMapping`
--
ALTER TABLE `ThesisMapping`
  ADD PRIMARY KEY (`thesis_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `ThesisTag`
--
ALTER TABLE `ThesisTag`
  ADD PRIMARY KEY (`tag_id`,`thesis_id`),
  ADD KEY `thesis_id` (`thesis_id`);

--
-- Indexes for table `User`
--
ALTER TABLE `User`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `UserRole`
--
ALTER TABLE `UserRole`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

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
  MODIFY `user_id` int(250) NOT NULL AUTO_INCREMENT;
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
-- Constraints for table `ThesisMapping`
--
ALTER TABLE `ThesisMapping`
  ADD CONSTRAINT `ThesisMapping_ibfk_1` FOREIGN KEY (`thesis_id`) REFERENCES `Thesis` (`thesis_id`),
  ADD CONSTRAINT `ThesisMapping_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `User` (`user_id`);

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
