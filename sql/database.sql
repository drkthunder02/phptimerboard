/**
 * Author:  Chris Mancuso
 * Created: February 21, 2017
 */

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00"

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `timerboard`
--

--
-- Table structure for `sessions`
--

CREATE TABLE IF NOT EXISTS `sessions` (
    `id` varchar(32) NOT NULL,
    `access` int(10) unsigned DEFAULT NULL,
    `data` text,
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for `Timers`
--

CREATE TABLE IF NOT EXISTS `Timers` (
    `id` int(20) AUTO_INCREMENT,
    `Type` varchar(50),
    `Stage` varchar(50),
    `Region` varchar(50),
    `System` varchar(50),
    `Planet` varchar(50),
    `Moon` varchar(50),
    `Owner` varchar(50),
    `EVETime` int(20),
    `Notes` text,
    `User` varchar(100),
    `Controls` varchar(100)
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for `Characters`
--

CREATE TABLE IF NOT EXISTS `Characters` (
    `id` int(20) AUTO_INCREMENT,
    `CharacterID` varchar(12),
    `Name` varchar(100),
    `CorporationID` varchar(12),
    `AccessLevel` int(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for `Corporations`
--

CREATE TABLE IF NOT EXISTS `Corporations` (
    `id` int(20) AUTO_INCREMENT,
    `CorporationID` varchar(12),
    `Name` varchar(100),
    `AccessLevel` int(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for `Alliances`
--

CREATE TABLE IF NOT EXISTS `Alliances` (
    `id` int(20) AUTO_INCREMENT,
    `AllianceID` varchar(12),
    `Name` varchar(100),
    `AccessLevel` int(1) DEFAULT 0,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for `AllianceNames`
--

CREATE TABLE IF NOT EXISTS `AllianceNames` (
    `AllianceID` varchar(12),
    `Name` varchar(100),
    PRIMARY KEY (`AllianceID`),
    UNIQUE KEY `AllianceID` (`AllianceID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Table structure for `CorporationNames`
--

CREATE TABLE IF NOT EXISTS `CorporationNames` (
    `CorporationID` varchar(12),
    `Name` varchar(100),
    PRIMARY KEY (`CorporationID`),
    UNIQUE KEY `CorporationID` (`CorporationID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
