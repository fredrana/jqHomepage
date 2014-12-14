-- phpMyAdmin SQL Dump
-- version 3.5.8.1
-- http://www.phpmyadmin.net
--
-- Generation Time: Dec 14, 2014 at 08:49 PM
-- Server version: 5.5.40-MariaDB-1~wheezy
-- PHP Version: 5.3.3-7+squeeze15

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `mystartpage`
--
CREATE DATABASE `mystartpage` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `mystartpage`;

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`mystartpage`@`%` PROCEDURE `sp_deleteTab`(IN `tabid` INT)
    NO SQL
BEGIN
	select @order := TAB_ORDER from TABS where TAB_ID = tabid;
        delete from TABS where TAB_ID = tabid;
        update TABS set TAB_ORDER = TAB_ORDER-1 where TAB_ORDER > @order;
END$$

CREATE DEFINER=`mystartpage`@`%` PROCEDURE `sp_newGroup`(IN `tabid` INT, IN `groupname` VARCHAR(255), OUT `groupid` INT)
    NO SQL
BEGIN
select @newgroupid := IFNULL(max(GROUP_ID),1) as groupid from GROUPS;
select @neworder := IFNULL(max(GROUP_ORDER)+1,1) as grouporder from GROUPS where TAB_ID = tabid;
insert into GROUPS (TAB_ID,GROUP_ID, GROUP_ORDER, GROUP_NAME) values (tabid,@newgroupid+1,@neworder,groupname);
select @newgroupid+1 into groupid;
END$$

CREATE DEFINER=`mystartpage`@`%` PROCEDURE `sp_newHotlink`(IN `groupid` INT, IN `link` VARCHAR(255), IN `image` VARCHAR(255), IN `title` VARCHAR(255), OUT `linkid` INT)
    NO SQL
BEGIN
select @newlinkid := IFNULL(max(link_id),1) from HOTLINKS where GROUP_ID = groupid;
insert into HOTLINKS (GROUP_ID, LINK_ID, LINK_PATH, ICON_PATH, LINK_TITLE) values (groupid,@newlinkid+1,link,image, title);
select @newlinkid+1 into linkid;
END$$

CREATE DEFINER=`mystartpage`@`%` PROCEDURE `sp_newTab`(IN `tabname` VARCHAR(255))
    NO SQL
BEGIN
select @maxtabid := IFNULL(max(TAB_ID),1) from TABS;
select @maxtaborder := IFNULL(max(TAB_ORDER),1) from TABS;
insert into TABS (TAB_ID,TAB_NAME,TAB_ORDER,TAB_ICON) values (@maxtabid+1,tabname,@maxtaborder+1,'ui-icon-blank');
END$$

CREATE DEFINER=`mystartpage`@`%` PROCEDURE `sp_updateGroupOrder`(IN `groupid` INT(11), IN `grouporder` INT(11))
    NO SQL
BEGIN
	select @tabid := TAB_ID, @upordown := case grouporder < GROUP_ORDER when 1 then 1 else -1 end, @oldorder := GROUP_ORDER from GROUPS where GROUP_ID = groupid;
	update GROUPS 
        set GROUP_ORDER = GROUP_ORDER+@upordown 
        where 
        TAB_ID = @tabid and 
        GROUP_ORDER between 
        	case @oldorder > grouporder when 1 then grouporder else @oldorder end 
                and
                case @oldorder > grouporder when 1 then @oldorder else grouporder end;
                
	update GROUPS set GROUP_ORDER = grouporder where GROUP_ID = groupid;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `GROUPS`
--

CREATE TABLE IF NOT EXISTS `GROUPS` (
  `TAB_ID` int(11) NOT NULL,
  `GROUP_ID` int(11) NOT NULL,
  `GROUP_ORDER` int(11) NOT NULL,
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
