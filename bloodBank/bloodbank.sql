-- phpMyAdmin SQL Dump
-- version 4.2.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Oct 18, 2015 at 06:50 PM
-- Server version: 5.6.21
-- PHP Version: 5.6.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `bloodbank`
--

-- --------------------------------------------------------


--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `custID` varchar(32) NOT NULL,
  `firstname` varchar(30) DEFAULT NULL,
  `lastname` varchar(30) DEFAULT NULL,
  `bloodGroup` varchar(3) NOT NULL,
  `addrLine1` varchar(40) DEFAULT NULL,
  `addrLine2` varchar(40) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `dob` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

/*INSERT INTO `customer` (`custID`, `firstname`, `lastname`,`bloodGroup`, `addrLine1`, `addrLine2`, `city`, `state`, `zip`, `phone`, `email`, `dob`) VALUES
('1', 'rahul', 'shukla', 'B+', 'line2','line1', 'Noida', 'UP', '201301', '9791037530', 'rahul@gmail.com', '1991-09-20');*/

-- --------------------------------------------------------

--
-- Table structure for table `login_master`
--

CREATE TABLE IF NOT EXISTS `login_master` (
  `userID` varchar(30) NOT NULL DEFAULT '',
  `passwd` varchar(32) DEFAULT NULL,
  `type` varchar(20) NOT NULL,
  `enabled` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login_master`
--

INSERT INTO `login_master` (`userID`, `passwd`, `type`, `enabled`) VALUES
('rahul181', '12345', 'Hospital', 'no');


-- --------------------------------------------------------

--
-- Table structure for table `orderdetails`
--

CREATE TABLE IF NOT EXISTS `orderdetails` (
`ODID` int(10) unsigned NOT NULL,
  `orderID` int(10) unsigned DEFAULT NULL,
  `productID` int(10) unsigned DEFAULT NULL,
  `qty` tinyint(3) unsigned DEFAULT NULL,
  `unitPrice` float(7,2) DEFAULT NULL,
  `price` float(7,2) DEFAULT NULL,
  `discount` float(7,2) DEFAULT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE IF NOT EXISTS `payment` (
`paymentID` int(10) unsigned NOT NULL,
  `amount` float(7,2) DEFAULT NULL,
  `cardNumber` varchar(25) DEFAULT NULL,
  `expDate` date DEFAULT NULL,
  `holder` varchar(50) DEFAULT NULL,
  `payDate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE IF NOT EXISTS `product` (
`productID` int(10) unsigned NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `code` varchar(20) DEFAULT NULL,
  `unitPrice` float(7,2) DEFAULT NULL,
  `description` tinytext,
  `packet` int(6),
  `status` tinyint(3) unsigned DEFAULT NULL,
  `suppDate` date NOT NULL,
  `supId` varchar(30) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `name`, `code`, `unitPrice`, `description`,`packet`,`status`, `suppDate`,`supId`) VALUES
(1, 'A+', NULL, 100, ' Ashoke Hospial', 10, NULL, '2017-08-4','rahul181'),
(2, 'b+', 'NULL', 100, ' Ashoke Hospial', 10, NULL, '2017-08-4','rahul181'),
(3, 'Ob+', 'NULL', 100, ' Ashoke Hospial', 10, NULL, '2017-08-4','rahul181');

-- --------------------------------------------------------

--
-- Table structure for table `productorder`
--

CREATE TABLE IF NOT EXISTS `productorder` (
`orderID` int(10) unsigned NOT NULL,
  `orderDate` datetime DEFAULT NULL,
  `customerID` varchar(32) DEFAULT NULL,
  `totalPrice` float(7,2) DEFAULT NULL,
  `shipID` int(10) unsigned DEFAULT NULL,
  `paymentID` int(10) unsigned DEFAULT NULL,
  `deliveryDate` date DEFAULT NULL,
  `statusID` tinyint(3) unsigned DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `shippingdetails`
--

CREATE TABLE IF NOT EXISTS `shippingdetails` (
`shipID` int(10) unsigned NOT NULL,
  `addrLine1` varchar(40) DEFAULT NULL,
  `addrLine2` varchar(40) DEFAULT NULL,
  `city` varchar(20) DEFAULT NULL,
  `state` varchar(20) DEFAULT NULL,
  `zip` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;


-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE IF NOT EXISTS `status` (
`statusID` tinyint(3) unsigned NOT NULL,
  `discription` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE IF NOT EXISTS `supplier` (
  `supId` varchar(30) NOT NULL,
  `name` varchar(30) NOT NULL,
  `address` varchar(60) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`supId`, `name`, `address`, `phone`, `email`) VALUES
('rahul181', 'Rahul Shukla', 'Noida', '9791037530', 'rahul.shu999@gmail.com');

--
-- Indexes for dumped tables
--


--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
 ADD PRIMARY KEY (`custID`);

--
-- Indexes for table `login_master`
--
ALTER TABLE `login_master`
 ADD PRIMARY KEY (`userID`);

--
-- Indexes for table `orderdetails`
--
ALTER TABLE `orderdetails`
 ADD PRIMARY KEY (`ODID`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
 ADD PRIMARY KEY (`paymentID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
 ADD PRIMARY KEY (`productID`), ADD KEY `status` (`status`), ADD KEY `suppDate` (`suppDate`);

--
-- Indexes for table `productorder`
--
ALTER TABLE `productorder`
 ADD PRIMARY KEY (`orderID`), ADD KEY `customerID` (`customerID`), ADD KEY `shipID` (`shipID`), ADD KEY `paymentID` (`paymentID`);

--
-- Indexes for table `shippingdetails`
--
ALTER TABLE `shippingdetails`
 ADD PRIMARY KEY (`shipID`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
 ADD PRIMARY KEY (`statusID`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
 ADD PRIMARY KEY (`supId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `orderdetails`
--
ALTER TABLE `orderdetails`
MODIFY `ODID` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
MODIFY `paymentID` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=31;
--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
MODIFY `productID` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `productorder`
--
ALTER TABLE `productorder`
MODIFY `orderID` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `shippingdetails`
--
ALTER TABLE `shippingdetails`
MODIFY `shipID` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=1;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
MODIFY `statusID` tinyint(3) unsigned NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `product`
--
ALTER TABLE `product`
ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`status`) REFERENCES `status` (`statusID`);

--
-- Constraints for table `productorder`
--
ALTER TABLE `productorder`
ADD CONSTRAINT `productOrder_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customer` (`custID`),
ADD CONSTRAINT `productOrder_ibfk_2` FOREIGN KEY (`shipID`) REFERENCES `shippingdetails` (`shipID`),
ADD CONSTRAINT `productOrder_ibfk_3` FOREIGN KEY (`paymentID`) REFERENCES `payment` (`paymentID`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
