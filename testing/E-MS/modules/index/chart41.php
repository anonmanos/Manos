<a href="index.php">กลับ</a>
<pre>
-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 27, 2012 at 04:54 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `nanoye`
--

-- --------------------------------------------------------

--
-- Table structure for table `ovst`
--

CREATE TABLE IF NOT EXISTS `ovst` (
  `vn` varchar(12) NOT NULL,
  `hn` int(7) unsigned zerofill NOT NULL,
  `vstdate` date NOT NULL,
  `vsttime` time NOT NULL,
  PRIMARY KEY (`vn`),
  KEY `hn` (`hn`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ovst`
--

INSERT INTO `ovst` (`vn`, `hn`, `vstdate`, `vsttime`) VALUES
('510801073215', 0000004, '2012-01-10', '07:32:15'),
('510801074045', 0000002, '2012-01-10', '07:40:45'),
('510801082045', 0000007, '2012-01-10', '09:20:45'),
('510801083045', 0000010, '2012-01-10', '08:30:45'),
('510801084555', 0000009, '2012-01-10', '08:45:55'),
('510801091005', 0000001, '2012-01-10', '09:10:05');

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE IF NOT EXISTS `patient` (
  `hn` int(7) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `pname` enum('เธเธฒเธข','เธเธฒเธเธชเธฒเธง','เธ”.เธ','เธ”.เธ','เธเธฒเธ') NOT NULL,
  `fname` varchar(100) NOT NULL,
  `lname` varchar(100) NOT NULL,
  `birddate` date NOT NULL,
  `sex` enum('เธ','เธ') NOT NULL,
  `addr_no` int(3) NOT NULL,
  `amp` int(2) unsigned zerofill NOT NULL,
  `tumb` int(2) unsigned zerofill NOT NULL,
  `province` int(2) unsigned zerofill NOT NULL,
  `pttype` int(2) unsigned zerofill NOT NULL,
  PRIMARY KEY (`hn`),
  KEY `pttype` (`pttype`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`hn`, `pname`, `fname`, `lname`, `birddate`, `sex`, `addr_no`, `amp`, `tumb`, `province`, `pttype`) VALUES
(0000001, 'เธเธฒเธข', 'เธชเธกเธเธฒเธข', 'เนเธเธ”เธต', '1956-12-01', 'เธ', 12, 06, 03, 55, 21),
(0000002, 'เธเธฒเธข', 'เธชเธกเธเธญเธ', 'เธ”เธตเนเธ', '1978-01-15', 'เธ', 4, 06, 01, 55, 22),
(0000003, 'เธเธฒเธเธชเธฒเธง', 'เธชเธกเนเธ', 'เนเธเธเธฒเธก', '1980-03-03', 'เธ', 3, 06, 03, 55, 73),
(0000004, 'เธเธฒเธเธชเธฒเธง', 'เธชเธกเธจเธฃเธต', 'เนเธเธเธทเนเธญ', '2007-04-09', 'เธ', 6, 06, 02, 55, 71),
(0000005, 'เธ”.เธ', 'เธชเธกเธเธดเธ”', 'เธเธฃเธดเธเนเธ', '2000-07-19', 'เธ', 8, 06, 03, 55, 21),
(0000006, 'เธ”.เธ', 'เธชเธกเธซเธเธดเธ', 'เธเธฃเธดเธเธเธฑเธ', '2006-12-29', 'เธ', 39, 06, 07, 55, 20),
(0000007, 'เธ”.เธ', 'เธชเธกเธซเธกเธฒเธข', 'เนเธเธ”เธต', '1980-03-03', 'เธ', 42, 05, 14, 55, 14),
(0000008, 'เธเธฒเธข', 'เธชเธกเน€เธ”เธ', 'เนเธเธเธฒเธก', '1956-12-01', 'เธ', 5, 06, 03, 55, 21),
(0000009, 'เธเธฒเธ', 'เธชเธกเธคเธ”เธต', 'เธเธดเธ•เนเธเธเธฒเธก', '1980-04-04', 'เธ', 9, 06, 11, 55, 21),
(0000010, 'เธเธฒเธ', 'เธชเธกเธชเธกเธฃ', 'เธเธฒเธกเธเธฃเธดเธ', '1962-11-07', 'เธ', 11, 06, 03, 55, 20);

-- --------------------------------------------------------

--
-- Table structure for table `pttype`
--

CREATE TABLE IF NOT EXISTS `pttype` (
  `code` int(2) unsigned zerofill NOT NULL AUTO_INCREMENT,
  `pttypename` varchar(100) NOT NULL,
  PRIMARY KEY (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=74 ;

--
-- Dumping data for table `pttype`
--

INSERT INTO `pttype` (`code`, `pttypename`) VALUES
(01, 'เธเธฑเธ•เธฃเธ—เธญเธ'),
(03, 'เน€เธ”เนเธ 0-12 เธเธต'),
(14, 'เธเธฃเธฐเธเธฑเธเธชเธฑเธเธเธก'),
(20, 'เน€เธเธดเธเนเธ”เน'),
(21, 'เธเนเธฒเธขเธ•เธฃเธ'),
(22, 'No'),
(71, 'เธเธนเนเธกเธตเธฃเธฒเธขเนเธ”เนเธเนเธญเธข'),
(73, 'เธเธนเนเธชเธนเธเธญเธฒเธขเธธ');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ovst`
--
ALTER TABLE `ovst`
  ADD CONSTRAINT `ovst_ibfk_1` FOREIGN KEY (`hn`) REFERENCES `patient` (`hn`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `patient`
--
ALTER TABLE `patient`
  ADD CONSTRAINT `patient_ibfk_1` FOREIGN KEY (`pttype`) REFERENCES `pttype` (`code`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

</pre>
<a href="index.php">กลับ</a>