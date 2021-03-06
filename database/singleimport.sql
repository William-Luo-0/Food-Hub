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
INSERT INTO `postalcode`(`PostalCode`, `Province`, `City`) VALUES ('V6T2G9', 'BC', 'Vancouver');
INSERT INTO `postalcode`(`PostalCode`, `Province`, `City`) VALUES ('V6T1Z4', 'BC', 'Vancouver');
INSERT INTO `postalcode`(`PostalCode`, `Province`, `City`) VALUES ('V6S0G6', 'BC', 'Vancouver');
INSERT INTO `postalcode`(`PostalCode`, `Province`, `City`) VALUES ('V6R2G7', 'BC', 'Vancouver');
INSERT INTO `postalcode`(`PostalCode`, `Province`, `City`) VALUES ('V6S2C2', 'BC', 'Vancouver');
INSERT INTO `postalcode`(`PostalCode`, `Province`, `City`) VALUES ('T5J0Y8', 'AB', 'Edmonton');
INSERT INTO `postalcode`(`PostalCode`, `Province`, `City`) VALUES ('T5J1M7', 'AB', 'Edmonton');
INSERT INTO `postalcode`(`PostalCode`, `Province`, `City`) VALUES ('T2R0K9', 'AB', 'Calgary');
INSERT INTO `postalcode`(`PostalCode`, `Province`, `City`) VALUES ('M5R1J2', 'ON', 'Toronto');
INSERT INTO `postalcode`(`PostalCode`, `Province`, `City`) VALUES ('V7E1X3', 'BC', 'Richmond');

INSERT INTO `address`(`AID`, `Street`, `HouseNumber`, `ApartmentNumber`, `PostalCode`) VALUES ('1', '6335 Thunderbird Crescent', '1005', '301', 'V6T2G9');
INSERT INTO `address`(`AID`, `Street`, `HouseNumber`, `ApartmentNumber`, `PostalCode`) VALUES ('2', '2205 Lower Mall', '1021', '614', 'V6T1Z4');
INSERT INTO `address`(`AID`, `Street`, `HouseNumber`, `PostalCode`) VALUES ('3', '3655 Wesbrook Mall', '6431', 'V6S0G6');
INSERT INTO `address`(`AID`, `Street`, `HouseNumber`, `PostalCode`) VALUES ('4', '3763 W 10th Ave', '257', 'V6R2G7');
INSERT INTO `address`(`AID`, `Street`, `HouseNumber`, `PostalCode`) VALUES ('5', '3446 Dunbar St', '144', 'V6S2C2');
INSERT INTO `address`(`AID`, `Street`, `HouseNumber`, `PostalCode`) VALUES ('6', '103 St NW', '10220', 'T5J0Y8');
INSERT INTO `address`(`AID`, `Street`, `HouseNumber`, `PostalCode`) VALUES ('7', '109 St NW', '10148', 'T5J1M7');
INSERT INTO `address`(`AID`, `Street`, `HouseNumber`, `PostalCode`) VALUES ('8', '13 Ave SW', '710', 'T2R0K9');
INSERT INTO `address`(`AID`, `Street`, `HouseNumber`, `PostalCode`) VALUES ('9', '202 Davenport Rd', '112', 'M5R1J2');
INSERT INTO `address`(`AID`, `Street`, `HouseNumber`, `PostalCode`) VALUES ('10', '3111 Springside Pl', '89', 'V7E1X3');

INSERT INTO `customer`(`UID`, `AID`, `Name`, `PhoneNumber`, `EmailAddress`, `Password`) VALUES ('1', '1', 'Sally', '6046447180', 'sally@mail.com', 'gold');
INSERT INTO `customer`(`UID`, `AID`, `Name`, `PhoneNumber`, `EmailAddress`, `Password`) VALUES ('2', '2', 'John', '6046489001', 'john@mail.com', 'silver');
INSERT INTO `customer`(`UID`, `AID`, `Name`, `PhoneNumber`, `EmailAddress`, `Password`) VALUES ('3', '3', 'Frank', '6047568921', 'frank@mail.com', 'bronze');
INSERT INTO `restaurant`(`UID`, `AID`, `Name`, `PhoneNumber`, `EmailAddress`, `Password`) VALUES ('1', '4', 'Japanese Ramen and Sushi Bar', '6047418500', 'japanese@mail.com', 'miso');
INSERT INTO `restaurant`(`UID`, `AID`, `Name`, `PhoneNumber`, `EmailAddress`, `Password`) VALUES ('2', '5', 'Italy Pasta Cafe', '4037765542', 'italy@mail.com', 'tomato');
INSERT INTO `restaurant`(`UID`, `AID`, `Name`, `PhoneNumber`, `EmailAddress`, `Password`) VALUES ('3', '6', 'Burger Shack', '6048905505', 'burger@mail.com', 'cheese');
INSERT INTO `restaurant`(`UID`, `AID`, `Name`, `PhoneNumber`, `EmailAddress`, `Password`) VALUES ('4', '7', 'Bison Steakhouse', '4035345532', 'steak@mail.com', 'beef');
INSERT INTO `wholesaler`(`UID`, `AID`, `Name`, `PhoneNumber`, `EmailAddress`, `Password`) VALUES ('1', '8', 'Canadian Butcher Store', '4031346767', 'butcher@mail.com', 'raw');
INSERT INTO `wholesaler`(`UID`, `AID`, `Name`, `PhoneNumber`, `EmailAddress`, `Password`) VALUES ('2', '9', 'Food Mart', '9054312202', 'food@mail.com', 'eat');
INSERT INTO `wholesaler`(`UID`, `AID`, `Name`, `PhoneNumber`, `EmailAddress`, `Password`) VALUES ('3', '10', 'Richmond Seafood Wholesale', '6042553998', 'seafood@mail.com', 'fish');

INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('1', 'Ribeye Steak');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('2', 'New York Strip Loin');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('3', 'Ground Beef');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('4', 'Pork Chop');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('5', 'Lamb Chop');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('6', 'Whole Chicken');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('7', 'Beef Ribs');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('8', 'Pork Tenderloin');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('9', 'Fillet Mignon');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('10', 'Prime Rib');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('11', 'Chicken Wing');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('12', 'Chicken Breast');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('13', 'Pork Belly');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('14', 'Beef Bone');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('15', 'Tuna');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('16', 'Salmon');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('17', 'Crab');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('18', 'Lobster');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('19', 'Shrimp');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('20', 'Squid');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('21', 'Octopus');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('22', 'Halibut');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('23', 'Sea Bass');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('24', 'Salmon Roe');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('25', 'Rice');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('26', 'Seaweed');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('27', 'White Egg');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('28', 'Brown Egg');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('29', 'Tofu Skin');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('30', 'Avocado');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('31', 'Cucumber');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('32', 'Flour');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('33', 'Miso');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('34', 'Soy Sauce');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('35', 'Ramen Noodle');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('36', 'Matcha');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('37', 'Vanilla Ice Cream');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('38', 'Matcha Ice Cream');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('39', 'Mochi');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('40', 'Tomato Sauce');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('41', 'Spaghetti');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('42', 'Fettuccine');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('43', 'Parmesan');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('44', 'Mozzarella');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('45', 'Asiago');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('46', 'Cream');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('47', 'Bread');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('48', 'Lettuce');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('49', 'Croutons');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('50', 'Ranch Dressing');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('51', 'Garlic');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('52', 'Basil');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('53', 'Lasagna');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('54', 'Penne');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('55', 'Ricotta');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('56', 'Coca Cola');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('57', 'Pepsi');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('58', 'Sprite');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('59', 'Root Beer');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('60', 'Ginger Ale');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('61', 'Butter');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('62', 'Vegetable Oil');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('63', 'Burger Bun');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('64', 'Tomato');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('65', 'Potato');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('66', 'Sweet Potato');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('67', 'Onion');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('68', 'Strawberry Ice Cream');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('69', 'Chocolate Ice Cream');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('70', 'Apple');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('71', 'Honey');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('72', 'Ice Cream Sandwich');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('73', 'Beef Broth');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('74', 'Pork Broth');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('75', 'Cheesecake');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('76', 'Cocktail Sauce');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('77', 'Carrot');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('78', 'Green Pepper');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('79', 'Red Pepper');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('80', 'Asparagus');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('81', 'Chocolate Cake');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('82', 'Cheddar');
INSERT INTO `ingredient`(`INID`, `Name`) VALUES ('83', 'Hot Sauce');

INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('1', '1', '1', 'Ribeye Steak 0.5lb', '16.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('1', '2', '2', 'New York Strip Loin 0.5lb', '18.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('1', '3', '3', 'Ground Beef 1lb', '2.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('1', '4', '4', 'Pork Chop 0.5lb', '1.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('1', '5', '5', 'Lamb Chop', '23.99', '16');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('1', '6', '6', 'Whole Chicken', '6.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('1', '7', '7', 'Beef Ribs 2lb', '15.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('1', '8', '8', 'Pork Tenderloin 1lb', '6.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('1', '9', '9', 'Fillet Mignon 0.5lb', '22.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('1', '10', '10', 'Prime Rib 1lb', '24.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('1', '11', '11', 'Chicken Wings', '16.99', '20');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('1', '12', '12', 'Chicken Breast', '1.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('1', '13', '13', 'Pork Belly 1lb', '6.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('1', '14', '14', 'Beef Bones 1lb', '2.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('3', '1', '15', 'Whole Tuna', '18.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('3', '2', '16', 'Whole Salmon', '16.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('3', '3', '17', 'Atlantic Crab', '10.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('3', '4', '18', 'Atlantic Lobster', '14.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('3', '5', '19', 'Pacific Shrimp', '12.99', '20');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('3', '6', '20', 'Whole Squid', '6.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('3', '7', '21', 'Whole Octopus', '17.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('3', '8', '22', 'Whole Halibut', '11.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('3', '9', '23', 'Whole Sea Bass', '12.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('3', '10', '24', 'Salmon Roe 0.5lb', '5.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '1', '25', 'Sushi Rice 5lb', '28.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '2', '26', 'Nori Sheet', '7.99', '50');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '3', '27', 'White Eggs', '4.99', '12');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '4', '28', 'Brown Eggs', '4.99', '12');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '5', '29', 'Tofu Skin', '7.99', '20');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '6', '30', 'Hass Avocado', '1.79', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '7', '31', 'Field Cucumber', '0.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '8', '32', 'All Purpose Flour 2lb', '6.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '9', '33', 'Miso Paste 0.5lb', '5.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '10', '34', 'Soy Sauce 2L', '6.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '11', '35', 'Ramen Noodles 1lb', '6.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '12', '36', 'Matcha Powder 0.5lb', '3.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '13', '37', 'Vanilla Ice Cream 2lb', '5.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '14', '38', 'Matcha Ice Cream 2lb', '5.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '15', '39', 'Mochi Ball', '12.99', '50');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '16', '40', 'Tomato Sauce 1L', '3.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '17', '41', 'Spaghetti Pasta 2lb', '2.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '18', '42', 'Fettuccine Pasta 2lb', '2.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '19', '43', 'Parmigiano Reggiano 800g', '15.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '20', '44', 'Mozzarella Cheese 800g', '8.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '21', '45', 'Asiago Cheese 800g', '8.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '22', '46', 'Heavy Cream 1L', '5.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '23', '47', 'Calabrese Bread', '1.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '24', '48', 'Iceberg Lettuce', '0.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '25', '49', 'Croutons 1lb', '3.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '26', '50', 'Ranch Dressing 1L', '1.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '27', '51', 'Garlic', '0.99', '10');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '28', '52', 'Basil 250g', '0.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '29', '53', 'Lasagna Pasta 2lb', '2.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '30', '54', 'Penne Pasta 2lb', '2.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '31', '55', 'Ricotta Chese 800g', '6.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '32', '56', 'Coca Cola 2L', '1.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '33', '57', 'Pepsi 2L', '1.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '34', '58', 'Sprite 2L', '1.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '35', '59', 'A&W Root Beer 2L', '1.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '36', '60', 'Ginger Ale 2L', '1.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '37', '61', 'Butter 1lb', '4.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '38', '62', 'Vegetable Oil 5L', '18.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '39', '63', 'Burger Bun', '4.99', '12');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '40', '64', 'H&H Tomato', '0.39', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '41', '65', 'Russet Potato', '0.59', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '42', '66', 'Sweet Potato', '0.59', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '43', '67', 'White Onion', '0.89', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '44', '68', 'Strawberry Ice Cream 2lb', '5.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '45', '69', 'Chocolate Ice Cream 2lb', '5.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '46', '70', 'Red Apple', '0.69', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '47', '71', 'Honey 1L', '8.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '48', '72', 'Ice Cream Sandwich', '12.99', '20');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '49', '73', 'Beef Broth 5L', '8.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '50', '74', 'Pork Broth 5L', '8.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '51', '75', 'Cheesecake', '12.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '52', '76', 'Cocktail Sauce', '2.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '53', '77', 'Carrot', '0.39', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '54', '78', 'Green Pepper', '1.39', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '55', '79', 'Red Pepper', '1.39', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '56', '80', 'Asparagus', '3.99', '12');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '57', '81', 'Chocolate Cake', '12.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '58', '82', 'Cheddar Cheese 800g', '5.99', '1');
INSERT INTO `inventoryitem`(`UID`, `IID`, `INID`, `Name`, `Cost`, `Amount`) VALUES ('2', '59', '83', 'Hot Sauce 1L', '6.99', '1');

INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '1', 'Tuna Nigiri', '2.00', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '2', 'Tuna Sashimi', '3.00', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '3', 'Salmon Nigiri', '2.00', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '4', 'Salmon Sashimi', '3.00', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '5', 'Ebi Nigiri', '2.50', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '6', 'Tamago Nigiri', '1.75', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '7', 'Inari Nigiri', '1.75', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '8', 'California Roll', '3.75', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '9', 'Dragon Roll', '8.50', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '10', 'Miso Ramen', '9.50', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '11', 'Tonkatsu Ramen', '9.50', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '12', 'Shoyu Ramen', '9.50', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '13', 'Miso Soup', '1.50', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '14', 'Green Tea', '1.50', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '15', 'Matcha Ice Cream', '2.00', 'Dessert');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '16', 'Mochi', '2.00', 'Dessert');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('1', '17', 'Vanilla Ice Cream', '2.00', 'Dessert');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('2', '1', 'Pepsi', '1.50', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('2', '2', 'Coca Cola', '1.50', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('2', '3', 'Sprite', '1.50', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('2', '4', 'A&W Root Beer', '1.50', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('2', '5', 'Ginger Ale', '1.50', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('2', '6', 'Spaghetti with Meatballs', '12.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('2', '7', 'Spaghetti with Tomato Sauce', '10.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('2', '8', 'Fettuccine Alfredo', '10.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('2', '9', 'Chicken Parmigiana', '12.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('2', '10', 'Margherita Pizza', '8.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('2', '11', '3 Cheese Lasagna', '10.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('2', '12', 'Penne with Ricotta', '10.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('2', '13', 'Caesar Salad', '4.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('2', '14', 'Garlic Bread', '3.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '1', 'Pepsi', '1.99', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '2', 'Coca Cola', '1.99', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '3', 'Sprite', '1.99', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '4', 'A&W Root Beer', '1.99', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '5', 'Ginger Ale', '1.99', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '6', 'Original Hamburger', '6.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '7', 'Cheeseburger', '6.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '8', 'Original Wings', '7.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '9', 'Hot Wings', '7.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '10', 'Honey Garlic Wings', '7.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '11', 'Original Fries', '2.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '12', 'Curly Fries', '3.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '13', 'Onion Rings', '4.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '14', 'Sweet Potato Fries', '3.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '15', 'Vanilla Ice Cream', '2.00', 'Dessert');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '16', 'Chocolate Ice Cream', '2.00', 'Dessert');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '17', 'Strawberry Ice Cream', '2.00', 'Dessert');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '18', 'Ice Cream Sandwich', '2.00', 'Dessert');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('3', '19', 'Apple Pie', '2.99', 'Dessert');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '1', 'Pepsi', '1.50', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '2', 'Coca Cola', '1.50', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '3', 'Sprite', '1.50', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '4', 'A&W Root Beer', '1.50', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '5', 'Ginger Ale', '1.50', 'Drink');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '6', 'Caesar Salad', '3.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '7', 'Baked Potato', '2.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '8', 'Garlic Mashed Potato', '3.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '9', 'Shrimp Cocktail', '6.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '10', 'French Onion Soup', '4.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '11', 'Roast Vegetables', '2.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '12', 'Ribeye Steak', '32.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '13', 'NY Striploin', '36.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '14', 'Atlantic Lobster', '38.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '15', 'Lamb Chops', '24.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '16', 'Prime Rib', '24.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '17', 'Fillet Mignon', '42.99', 'Food');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '18', 'Chocolate Cake', '5.99', 'Dessert');
INSERT INTO `menuitem`(`UID`, `IID`, `Name`, `Price`, `FoodType`) VALUES ('4', '19', 'CheeseCake', '5.99', 'Dessert');

INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '1', '15', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '1', '25', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '2', '15', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '3', '16', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '3', '25', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '4', '16', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '5', '19', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '5', '25', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '6', '27', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '6', '25', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '7', '29', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '7', '25', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '8', '25', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '8', '26', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '8', '17', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '8', '30', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '8', '31', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '9', '25', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '9', '26', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '9', '30', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '9', '31', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '9', '19', '2');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '9', '24', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '10', '74', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '10', '35', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '10', '33', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '11', '74', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '11', '35', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '11', '13', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '12', '74', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '12', '35', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '12', '34', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '13', '33', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '14', '36', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '15', '38', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '16', '39', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('1', '17', '37', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '1', '57', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '2', '56', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '3', '58', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '4', '59', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '5', '60', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '6', '41', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '6', '40', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '6', '43', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '6', '3', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '7', '41', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '7', '40', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '7', '43', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '8', '43', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '8', '44', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '8', '45', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '8', '46', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '8', '42', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '9', '40', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '9', '12', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '9', '43', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '10', '62', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '10', '27', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '10', '40', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '10', '32', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '10', '52', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '10', '44', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '11', '43', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '11', '44', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '11', '45', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '11', '53', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '11', '40', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '12', '54', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '12', '55', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '12', '40', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '13', '48', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '13', '49', '8');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '13', '50', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '13', '43', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '14', '51', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '14', '47', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('2', '14', '61', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '1', '57', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '2', '56', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '3', '58', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '4', '59', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '5', '60', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '6', '63', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '6', '64', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '6', '48', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '6', '3', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '7', '63', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '7', '3', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '7', '82', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '8', '11', '8');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '9', '11', '8');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '9', '83', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '10', '11', '8');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '10', '51', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '10', '71', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '11', '65', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '12', '65', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '13', '67', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '14', '66', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '15', '37', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '16', '69', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '17', '68', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '18', '72', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '19', '70', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '19', '27', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '19', '32', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('3', '19', '62', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '1', '57', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '2', '56', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '3', '58', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '4', '59', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '5', '60', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '6', '48', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '6', '49', '8');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '6', '50', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '6', '43', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '7', '65', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '7', '61', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '8', '65', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '8', '61', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '8', '51', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '9', '19', '5');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '9', '76', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '10', '73', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '10', '67', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '11', '77', '2');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '11', '78', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '11', '79', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '11', '80', '5');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '12', '1', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '13', '2', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '14', '18', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '15', '5', '5');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '16', '10', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '17', '9', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '18', '81', '1');
INSERT INTO `menuitemingredient`(`UID`, `IID`, `INID`, `Amount`) VALUES ('4', '19', '75', '1');

INSERT INTO `restaurantstorage`(`UID`, `INID`, `Amount`) VALUES ('1', '5', '95');
INSERT INTO `restaurantstorage`(`UID`, `INID`, `Amount`) VALUES ('1', '6', '95');
INSERT INTO `restaurantstorage`(`UID`, `INID`, `Amount`) VALUES ('1', '7', '200');
INSERT INTO `restaurantstorage`(`UID`, `INID`, `Amount`) VALUES ('1', '8', '50');
INSERT INTO `restaurantstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '9', '120');
INSERT INTO `restaurantstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '10', '75');
INSERT INTO `restaurantstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '11', '75');
INSERT INTO `restaurantstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '12', '80');
INSERT INTO `restaurantstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '13', '400');
INSERT INTO `restaurantstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '14', '75');
INSERT INTO `restaurantstorage`(`UID`, `INID`, `Amount`) VALUES ('3', '1', '90');
INSERT INTO `restaurantstorage`(`UID`, `INID`, `Amount`) VALUES ('3', '2', '90');
INSERT INTO `restaurantstorage`(`UID`, `INID`, `Amount`) VALUES ('3', '3', '45');

INSERT INTO `wholesalerstorage`(`UID`, `INID`, `Amount`) VALUES ('1', '4', '500');
INSERT INTO `wholesalerstorage`(`UID`, `INID`, `Amount`) VALUES ('1', '5', '400');
INSERT INTO `wholesalerstorage`(`UID`, `INID`, `Amount`) VALUES ('1', '6', '750');
INSERT INTO `wholesalerstorage`(`UID`, `INID`, `Amount`) VALUES ('1', '12', '750');
INSERT INTO `wholesalerstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '1', '800');
INSERT INTO `wholesalerstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '2', '1000');
INSERT INTO `wholesalerstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '3', '1200');
INSERT INTO `wholesalerstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '7', '1200');
INSERT INTO `wholesalerstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '8', '1000');
INSERT INTO `wholesalerstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '9', '1200');
INSERT INTO `wholesalerstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '10', '600');
INSERT INTO `wholesalerstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '11', '800');
INSERT INTO `wholesalerstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '13', '1200');
INSERT INTO `wholesalerstorage`(`UID`, `INID`, `Amount`) VALUES ('2', '14', '1500');

INSERT INTO `autorestock`(`UID`, `AUID`, `WholesalerUID`, `IID`, `INID`, `Amount`, `Threshold`) VALUES ('2', '1', '2', '6', '30', '50', '25');
INSERT INTO `autorestock`(`UID`, `AUID`, `WholesalerUID`, `IID`, `INID`, `Amount`, `Threshold`) VALUES ('2', '2', '2', '7', '31', '50', '25');
INSERT INTO `autorestock`(`UID`, `AUID`, `WholesalerUID`, `IID`, `INID`, `Amount`, `Threshold`) VALUES ('2', '3', '2', '8', '32', '50', '25');
INSERT INTO `autorestock`(`UID`, `AUID`, `WholesalerUID`, `IID`, `INID`, `Amount`, `Threshold`) VALUES ('2', '4', '1', '4', '4', '50', '25');

INSERT INTO `orderduration`(`OrderDate`, `FulfilledDate`, `OrderDuration`) VALUES ('2020-03-25 08:00:00', '2020-03-25 08:20:00', '1200');
INSERT INTO `orderduration`(`OrderDate`, `FulfilledDate`, `OrderDuration`) VALUES ('2020-03-25 08:30:00', '2020-03-25 08:40:00', '600');
INSERT INTO `orderduration`(`OrderDate`, `FulfilledDate`, `OrderDuration`) VALUES ('2020-03-25 15:00:00', '2020-03-25 15:20:00', '1200');
INSERT INTO `orderduration`(`OrderDate`, `FulfilledDate`, `OrderDuration`) VALUES ('2020-03-25 15:30:00', '2020-03-25 19:30:00', '14400');
INSERT INTO `orderduration`(`OrderDate`, `FulfilledDate`, `OrderDuration`) VALUES ('2020-03-26 05:00:00', '2020-03-26 08:40:00', '13200');
INSERT INTO `orderduration`(`OrderDate`, `FulfilledDate`, `OrderDuration`) VALUES ('2020-03-26 05:30:00', '2020-03-26 09:10:00', '13200');
INSERT INTO `orderduration`(`OrderDate`, `FulfilledDate`, `OrderDuration`) VALUES ('2020-03-26 10:00:00', '2020-03-26 10:10:00', '600');
INSERT INTO `orderduration`(`OrderDate`, `FulfilledDate`, `OrderDuration`) VALUES ('2020-03-26 10:30:00', '2020-03-26 10:35:00', '300');
INSERT INTO `orderduration`(`OrderDate`) VALUES ('2020-03-27 02:00:00');
INSERT INTO `orderduration`(`OrderDate`) VALUES ('2020-03-27 03:00:00');
INSERT INTO `orderduration`(`OrderDate`) VALUES ('2020-03-27 04:00:00');
INSERT INTO `orderduration`(`OrderDate`) VALUES ('2020-03-27 05:00:00');
INSERT INTO `orderduration`(`OrderDate`) VALUES ('2020-03-27 06:00:00');
INSERT INTO `orderduration`(`OrderDate`) VALUES ('2020-03-27 07:00:00');
INSERT INTO `orderduration`(`OrderDate`) VALUES ('2020-03-27 08:00:00');
INSERT INTO `orderduration`(`OrderDate`) VALUES ('2020-03-27 09:00:00');

INSERT INTO `foodorder`(`CustomerUID`, `RestaurantUID`, `OrderDate`, `FulfilledDate`) VALUES ('1', '1', '2020-03-25 08:00:00', '2020-03-25 08:20:00');
INSERT INTO `foodorder`(`CustomerUID`, `RestaurantUID`, `OrderDate`, `FulfilledDate`) VALUES ('1', '2', '2020-03-26 10:00:00', '2020-03-26 10:10:00');
INSERT INTO `foodorder`(`CustomerUID`, `RestaurantUID`, `OrderDate`, `FulfilledDate`) VALUES ('1', '3', '2020-03-27 02:00:00', '1000-01-01 00:00:00');
INSERT INTO `foodorder`(`CustomerUID`, `RestaurantUID`, `OrderDate`, `FulfilledDate`) VALUES ('1', '2', '2020-03-27 06:00:00', '1000-01-01 00:00:00');
INSERT INTO `foodorder`(`CustomerUID`, `RestaurantUID`, `OrderDate`, `FulfilledDate`) VALUES ('1', '3', '2020-03-27 07:00:00', '1000-01-01 00:00:00');
INSERT INTO `foodorder`(`CustomerUID`, `RestaurantUID`, `OrderDate`, `FulfilledDate`) VALUES ('2', '2', '2020-03-25 08:30:00', '2020-03-25 08:40:00');
INSERT INTO `foodorder`(`CustomerUID`, `RestaurantUID`, `OrderDate`, `FulfilledDate`) VALUES ('2', '3', '2020-03-26 10:30:00', '2020-03-26 10:35:00');
INSERT INTO `foodorder`(`CustomerUID`, `RestaurantUID`, `OrderDate`, `FulfilledDate`) VALUES ('2', '4', '2020-03-27 03:00:00', '1000-01-01 00:00:00');
INSERT INTO `foodorder`(`CustomerUID`, `RestaurantUID`, `OrderDate`, `FulfilledDate`) VALUES ('3', '1', '2020-03-25 15:00:00', '2020-03-25 15:20:00');
INSERT INTO `foodorder`(`CustomerUID`, `RestaurantUID`, `OrderDate`, `FulfilledDate`) VALUES ('3', '1', '2020-03-27 04:00:00', '1000-01-01 00:00:00');
INSERT INTO `foodorder`(`CustomerUID`, `RestaurantUID`, `OrderDate`, `FulfilledDate`) VALUES ('3', '4', '2020-03-27 05:00:00', '1000-01-01 00:00:00');

INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('1', '1', '1', '3');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('1', '1', '2', '2');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('1', '1', '3', '3');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('2', '2', '6', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('2', '2', '1', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('3', '3', '5', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('3', '3', '9', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('3', '3', '11', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('4', '2', '11', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('4', '2', '13', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('4', '2', '2', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('5', '3', '6', '3');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('5', '3', '12', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('5', '3', '13', '2');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('5', '3', '15', '2');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('5', '3', '16', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('6', '2', '3', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('6', '2', '8', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('6', '2', '14', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('7', '3', '1', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('7', '3', '8', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('7', '3', '9', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('7', '3', '10', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('7', '3', '19', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('8', '4', '4', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('8', '4', '8', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('8', '4', '9', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('8', '4', '12', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('8', '4', '18', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('9', '1', '9', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('9', '1', '10', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('9', '1', '11', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('9', '1', '16', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('10', '1', '1', '2');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('10', '1', '3', '2');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('10', '1', '5', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('10', '1', '6', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('10', '1', '7', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('10', '1', '8', '2');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('11', '4', '3', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('11', '4', '6', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('11', '4', '14', '1');
INSERT INTO `foodorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('11', '4', '19', '1');

INSERT INTO `inventoryorder`(`RestaurantUID`, `WholesalerUID`, `OrderDate`, `FulfilledDate`) VALUES ('1', '3', '2020-03-25 15:30:00', '2020-03-25 19:30:00');
INSERT INTO `inventoryorder`(`RestaurantUID`, `WholesalerUID`, `OrderDate`, `FulfilledDate`) VALUES ('2', '2', '2020-03-26 05:00:00', '2020-03-26 08:40:00');
INSERT INTO `inventoryorder`(`RestaurantUID`, `WholesalerUID`, `OrderDate`, `FulfilledDate`) VALUES ('3', '2', '2020-03-27 08:00:00', '1000-01-01 00:00:00');
INSERT INTO `inventoryorder`(`RestaurantUID`, `WholesalerUID`, `OrderDate`, `FulfilledDate`) VALUES ('4', '1', '2020-03-26 05:30:00', '2020-03-26 09:10:00');
INSERT INTO `inventoryorder`(`RestaurantUID`, `WholesalerUID`, `OrderDate`, `FulfilledDate`) VALUES ('4', '1', '2020-03-27 09:00:00', '1000-01-01 00:00:00');

INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('1', '3', '1', '8');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('1', '3', '2', '8');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('1', '3', '3', '4');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('1', '3', '5', '2');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('2', '2', '16', '60');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('2', '2', '17', '40');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('2', '2', '19', '15');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('2', '2', '56', '10');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('3', '2', '39', '35');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('3', '2', '40', '80');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('3', '2', '41', '120');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('3', '2', '45', '10');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('4', '1', '1', '35');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('4', '1', '2', '46');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('4', '1', '5', '5');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('4', '1', '6', '65');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('4', '1', '9', '22');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('5', '1', '10', '12');
INSERT INTO `inventoryorderitems`(`OID`, `UID`, `IID`, `Amount`) VALUES ('5', '1', '2', '24');