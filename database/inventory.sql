-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2020 at 06:29 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `inventory`
--
CREATE DATABASE IF NOT EXISTS `inventory` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `inventory`;

-- --------------------------------------------------------

--
-- Table structure for table `address`
--

CREATE TABLE IF NOT EXISTS `address` (
  `AID` int(11) NOT NULL AUTO_INCREMENT,
  `Street` varchar(32) DEFAULT NULL,
  `HouseNumber` int(11) NOT NULL,
  `ApartmentNumber` int(11) NOT NULL DEFAULT '-1',
  `PostalCode` char(6) NOT NULL,
  PRIMARY KEY (`AID`),
  KEY `PostalCode` (`PostalCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `autorestock`
--

CREATE TABLE IF NOT EXISTS `autorestock` (
    `UID` int(11) NOT NULL,
    `AUID` int(11) NOT NULL,
    `WholesalerUID` int(11) NOT NULL,
    `IID` int(11) NOT NULL,
    `INID` int(11) NOT NULL,
    `Amount` int(11) NOT NULL,
    `Threshold` int(11) NOT NULL,
    PRIMARY KEY (`UID`,`AUID`,`INID`),
    KEY `INID` (`INID`),
    KEY `IID` (`IID`),
    KEY `WholesalerUID` (`WholesalerUID`),
    KEY `autorestock_ibfk_3` (`WholesalerUID`,`IID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `AID` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `PhoneNumber` varchar(11) NOT NULL,
  `EmailAddress` varchar(64) NOT NULL,
  `Password` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `EmailAddress` (`EmailAddress`),
  KEY `AID` (`AID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `foodorder`
--

CREATE TABLE IF NOT EXISTS `foodorder` (
  `OID` int(11) NOT NULL AUTO_INCREMENT,
  `CustomerUID` int(11) DEFAULT NULL,
  `RestaurantUID` int(11) DEFAULT NULL,
  `OrderDate` datetime NOT NULL,
  `FulfilledDate` datetime NOT NULL,
  PRIMARY KEY (`OID`),
  KEY `CustomerUID` (`CustomerUID`),
  KEY `RestaurantUID` (`RestaurantUID`),
  KEY `OrderDate` (`OrderDate`,`FulfilledDate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `foodorderitems`
--

CREATE TABLE IF NOT EXISTS `foodorderitems` (
  `OID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `IID` int(11) NOT NULL,
  `Amount` int(11) NOT NULL,
  PRIMARY KEY (`OID`,`UID`,`IID`),
  KEY `UID` (`UID`,`IID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `ingredient`
--

CREATE TABLE IF NOT EXISTS `ingredient` (
  `INID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(32) NOT NULL,
  PRIMARY KEY (`INID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventoryitem`
--

CREATE TABLE IF NOT EXISTS `inventoryitem` (
  `UID` int(11) NOT NULL,
  `IID` int(11) NOT NULL,
  `INID` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `Cost` decimal(10,2) NOT NULL,
  `Amount` int(11) NOT NULL,
  PRIMARY KEY (`UID`,`IID`),
  KEY `INID` (`INID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventoryorder`
--

CREATE TABLE IF NOT EXISTS `inventoryorder` (
  `OID` int(11) NOT NULL AUTO_INCREMENT,
  `RestaurantUID` int(11) DEFAULT NULL,
  `WholesalerUID` int(11) DEFAULT NULL,
  `OrderDate` datetime NOT NULL,
  `FulfilledDate` datetime NOT NULL,
  PRIMARY KEY (`OID`),
  KEY `WholesalerUID` (`WholesalerUID`),
  KEY `RestaurantUID` (`RestaurantUID`),
  KEY `OrderDate` (`OrderDate`,`FulfilledDate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `inventoryorderitems`
--

CREATE TABLE IF NOT EXISTS `inventoryorderitems` (
  `OID` int(11) NOT NULL,
  `UID` int(11) NOT NULL,
  `IID` int(11) NOT NULL,
  `Amount` int(11) NOT NULL,
  PRIMARY KEY (`OID`,`UID`,`IID`),
  KEY `UID` (`UID`,`IID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menuitem`
--

CREATE TABLE IF NOT EXISTS `menuitem` (
  `UID` int(11) NOT NULL,
  `IID` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `Price` decimal(10,2) DEFAULT NULL,
  `FoodType` enum('Dessert','Food','Drink') DEFAULT NULL,
  PRIMARY KEY (`UID`,`IID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `menuitemingredient`
--

CREATE TABLE IF NOT EXISTS `menuitemingredient` (
  `UID` int(11) NOT NULL,
  `IID` int(11) NOT NULL,
  `INID` int(11) NOT NULL,
  `Amount` int(11) NOT NULL,
  PRIMARY KEY (`UID`,`IID`,`INID`),
  KEY `INID` (`INID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `orderduration`
--

CREATE TABLE IF NOT EXISTS `orderduration` (
  `OrderDate` datetime NOT NULL,
  `FulfilledDate` datetime NOT NULL DEFAULT '1000-01-01 00:00:00',
  `OrderDuration` int(11) NOT NULL DEFAULT '-1',
  PRIMARY KEY (`OrderDate`,`FulfilledDate`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `postalcode`
--

CREATE TABLE IF NOT EXISTS `postalcode` (
  `PostalCode` char(6) NOT NULL,
  `Province` enum('BC','AB','SK','MB','ON','QC','NL','NS','PE','NB','NT','YT','NU') DEFAULT NULL,
  `City` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`PostalCode`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurant`
--

CREATE TABLE IF NOT EXISTS `restaurant` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `AID` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `PhoneNumber` varchar(11) NOT NULL,
  `EmailAddress` varchar(64) NOT NULL,
  `Password` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `EmailAddress` (`EmailAddress`),
  KEY `AID` (`AID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `restaurantstorage`
--

CREATE TABLE IF NOT EXISTS `restaurantstorage` (
  `UID` int(11) NOT NULL,
  `INID` int(11) NOT NULL,
  `Amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`UID`,`INID`),
  KEY `INID` (`INID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wholesaler`
--

CREATE TABLE IF NOT EXISTS `wholesaler` (
  `UID` int(11) NOT NULL AUTO_INCREMENT,
  `AID` int(11) NOT NULL,
  `Name` varchar(32) NOT NULL,
  `PhoneNumber` varchar(11) NOT NULL,
  `EmailAddress` varchar(64) NOT NULL,
  `Password` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`UID`),
  UNIQUE KEY `EmailAddress` (`EmailAddress`),
  KEY `AID` (`AID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `wholesalerstorage`
--

CREATE TABLE IF NOT EXISTS `wholesalerstorage` (
  `UID` int(11) NOT NULL,
  `INID` int(11) NOT NULL,
  `Amount` int(11) DEFAULT NULL,
  PRIMARY KEY (`UID`,`INID`),
  KEY `INID` (`INID`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


--
-- Constraints for dumped tables
--

--
-- Constraints for table `address`
--
ALTER TABLE `address`
  ADD CONSTRAINT `address_ibfk_1` FOREIGN KEY (`PostalCode`) REFERENCES `postalcode` (`PostalCode`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `autorestock`
--
ALTER TABLE `autorestock`
    ADD CONSTRAINT `autorestock_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `restaurant` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `autorestock_ibfk_2` FOREIGN KEY (`INID`) REFERENCES `ingredient` (`INID`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `autorestock_ibfk_3` FOREIGN KEY (`WholesalerUID`,`IID`) REFERENCES `inventoryitem` (`UID`, `IID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `customer`
--
ALTER TABLE `customer`
  ADD CONSTRAINT `customer_ibfk_1` FOREIGN KEY (`AID`) REFERENCES `address` (`AID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `foodorder`
--
ALTER TABLE `foodorder`
  ADD CONSTRAINT `foodorder_ibfk_1` FOREIGN KEY (`CustomerUID`) REFERENCES `customer` (`UID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `foodorder_ibfk_2` FOREIGN KEY (`RestaurantUID`) REFERENCES `restaurant` (`UID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `foodorder_ibfk_3` FOREIGN KEY (`OrderDate`,`FulfilledDate`) REFERENCES `orderduration` (`OrderDate`, `FulfilledDate`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `foodorderitems`
--
ALTER TABLE `foodorderitems`
  ADD CONSTRAINT `foodorderitems_ibfk_1` FOREIGN KEY (`OID`) REFERENCES `foodorder` (`OID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `foodorderitems_ibfk_2` FOREIGN KEY (`UID`,`IID`) REFERENCES `menuitem` (`UID`, `IID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `inventoryitem`
--
ALTER TABLE `inventoryitem`
  ADD CONSTRAINT `inventoryitem_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `wholesaler` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventoryitem_ibfk_2` FOREIGN KEY (`INID`) REFERENCES `ingredient` (`INID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `inventoryorder`
--
ALTER TABLE `inventoryorder`
  ADD CONSTRAINT `inventoryorder_ibfk_1` FOREIGN KEY (`WholesalerUID`) REFERENCES `wholesaler` (`UID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `inventoryorder_ibfk_2` FOREIGN KEY (`RestaurantUID`) REFERENCES `restaurant` (`UID`) ON DELETE NO ACTION ON UPDATE CASCADE,
  ADD CONSTRAINT `inventoryorder_ibfk_3` FOREIGN KEY (`OrderDate`,`FulfilledDate`) REFERENCES `orderduration` (`OrderDate`, `FulfilledDate`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `inventoryorderitems`
--
ALTER TABLE `inventoryorderitems`
  ADD CONSTRAINT `inventoryorderitems_ibfk_1` FOREIGN KEY (`OID`) REFERENCES `inventoryorder` (`OID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventoryorderitems_ibfk_2` FOREIGN KEY (`UID`,`IID`) REFERENCES `inventoryitem` (`UID`, `IID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `menuitem`
--
ALTER TABLE `menuitem`
  ADD CONSTRAINT `menuitem_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `restaurant` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `menuitemingredient`
--
ALTER TABLE `menuitemingredient`
  ADD CONSTRAINT `menuitemingredient_ibfk_1` FOREIGN KEY (`UID`,`IID`) REFERENCES `menuitem` (`UID`, `IID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `menuitemingredient_ibfk_2` FOREIGN KEY (`INID`) REFERENCES `ingredient` (`INID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `restaurant`
--
ALTER TABLE `restaurant`
  ADD CONSTRAINT `restaurant_ibfk_1` FOREIGN KEY (`AID`) REFERENCES `address` (`AID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `restaurantstorage`
--
ALTER TABLE `restaurantstorage`
  ADD CONSTRAINT `restaurantstorage_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `restaurant` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `restaurantstorage_ibfk_2` FOREIGN KEY (`INID`) REFERENCES `ingredient` (`INID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `wholesaler`
--
ALTER TABLE `wholesaler`
  ADD CONSTRAINT `wholesaler_ibfk_1` FOREIGN KEY (`AID`) REFERENCES `address` (`AID`) ON DELETE NO ACTION ON UPDATE CASCADE;

--
-- Constraints for table `wholesalerstorage`
--
ALTER TABLE `wholesalerstorage`
  ADD CONSTRAINT `wholesalerstorage_ibfk_1` FOREIGN KEY (`UID`) REFERENCES `wholesaler` (`UID`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `wholesalerstorage_ibfk_2` FOREIGN KEY (`INID`) REFERENCES `ingredient` (`INID`) ON DELETE NO ACTION ON UPDATE CASCADE;
