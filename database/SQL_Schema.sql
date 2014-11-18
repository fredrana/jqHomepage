-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Generation Time: Nov 18, 2014 at 09:00 PM
-- Server version: 5.5.38-MariaDB-1~wheezy
-- PHP Version: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `mystartpage`
--
CREATE DATABASE `mystartpage` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mystartpage`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`mystarpage`@`%` PROCEDURE `sp_deleteTab`(IN `tabid` INT)
    NO SQL
BEGIN
	select @order := TAB_ORDER from TABS where TAB_ID = tabid;
        delete from TABS where TAB_ID = tabid;
        update TABS set TAB_ORDER = TAB_ORDER-1 where TAB_ORDER > @order;
END$$

CREATE DEFINER=`mystartpage`@`%` PROCEDURE `sp_newGroup`(IN `tabid` INT, IN `groupname` VARCHAR(255))
    NO SQL
BEGIN
select @newgroupid := IFNULL(max(GROUP_ID),1) from GROUPS;
insert into GROUPS (TAB_ID,GROUP_ID, GROUP_NAME) values (tabid,@newgroupid+1,groupname);
END$$

CREATE DEFINER=`mystartpage`@`%` PROCEDURE `sp_newHotlink`(IN `groupid` INT, IN `link` VARCHAR(255), IN `image` VARCHAR(255), IN `title` VARCHAR(255))
    NO SQL
BEGIN
select @newlinkid := IFNULL(max(link_id),1) from HOTLINKS where GROUP_ID = groupid;
insert into HOTLINKS (GROUP_ID, LINK_ID, LINK_PATH, ICON_PATH, LINK_TITLE) values (groupid,@newlinkid+1,link,image, title);
END$$

CREATE DEFINER=`mystartpage`@`%` PROCEDURE `sp_newTab`(IN `tabname` VARCHAR(255))
    NO SQL
BEGIN
select @maxtabid := IFNULL(max(TAB_ID),1) from TABS;
select @maxtaborder := IFNULL(max(TAB_ORDER),1) from TABS;
insert into TABS (TAB_ID,TAB_NAME,TAB_ORDER,TAB_ICON) values (@maxtabid+1,tabname,@maxtaborder+1,'ui-icon-blank');
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `GROUPS`
--

CREATE TABLE IF NOT EXISTS `GROUPS` (
  `TAB_ID` int(11) NOT NULL,
  `GROUP_ID` int(11) NOT NULL,
  `GROUP_NAME` varchar(50) NOT NULL,
  PRIMARY KEY (`GROUP_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `HOTLINKS`
--

CREATE TABLE IF NOT EXISTS `HOTLINKS` (
  `LINK_ID` int(11) NOT NULL,
  `GROUP_ID` int(11) NOT NULL,
  `LINK_PATH` varchar(255) NOT NULL,
  `ICON_PATH` varchar(255) NOT NULL,
  `LINK_TITLE` varchar(255) NOT NULL,
  PRIMARY KEY (`GROUP_ID`,`LINK_ID`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `TABS`
--

CREATE TABLE IF NOT EXISTS `TABS` (
  `TAB_ID` int(11) NOT NULL,
  `TAB_NAME` varchar(255) DEFAULT NULL,
  `TAB_ORDER` int(11) NOT NULL,
  `TAB_ICON` varchar(30) NOT NULL,
  PRIMARY KEY (`TAB_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
