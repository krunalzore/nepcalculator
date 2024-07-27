-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 24, 2024 at 06:17 AM
-- Server version: 5.5.53-0ubuntu0.14.04.1
-- PHP Version: 5.6.29-1+deb.sury.org~trusty+1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `NEP_Calculator`
--

-- --------------------------------------------------------

--
-- Table structure for table `subjectmaster`
--

CREATE TABLE IF NOT EXISTS `subjectmaster` (
  `PROG_NO` varchar(10) DEFAULT NULL,
  `PROG_NAME` varchar(6) DEFAULT NULL,
  `SEM` int(1) DEFAULT NULL,
  `MAJOR_NAME` varchar(7) DEFAULT NULL,
  `COURSE_NO` varchar(10) DEFAULT NULL,
  `COURSE_NAME` varchar(56) DEFAULT NULL,
  `NAME_OF_BOS` varchar(64) DEFAULT NULL,
  `CREDIT` int(1) DEFAULT NULL,
  `VERTICAL_NO` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `subjectmaster`
--

INSERT INTO `subjectmaster` (`PROG_NO`, `PROG_NAME`, `SEM`, `MAJOR_NAME`, `COURSE_NO`, `COURSE_NAME`, `NAME_OF_BOS`, `CREDIT`, `VERTICAL_NO`) VALUES
('', 'B.Com.', 1, 'IKS', '', 'Indian Knowledge System', '', 2, 5),
('', 'B.Com.', 1, 'Major 1', '', 'Commerce-I(Introduction To Business)', 'B Com', 2, 1),
('', 'B.Com.', 1, 'Major 2', '', 'Accountancy', 'B Com', 2, 1),
('', 'B.Com.', 1, 'Major 3', '', 'Bussiness Economics', 'B Com', 2, 1),
('', 'B.Com.', 1, 'Major 4', '', 'Bussiness Management', 'B Com', 2, 1),
('', 'B.Com.', 1, 'OE', '', 'Introduction to Commerce (OE)', 'B Com', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Entrepreneurship Management (OE)', 'B Com', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Open Elective in Accounting Paper: I ', 'Accountancy', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Open Elective in Accounting Paper: II', 'Accountancy', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Elementary Statistical Techniques for Economics     ', 'Bussiness economics', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Business Economics for Banking and Insurance', 'Bussiness economics', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Introduction of Economics to Demography     ', 'Bussiness economics', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Introduction to Banking', 'Bussiness Management', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Introduction to Export Marketing', 'Bussiness Management', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Marketing Mix I', 'B Com (Management studies)', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Case Studies in Management', 'B Com (Management studies)', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Open Elective in Accounting & Finance    Paper - I', 'B. Com (Accounting and Finance) (BAF) ', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Open Elective in Accounting & Finance    Paper - II', 'B. Com (Accounting and Finance) (BAF) ', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Basics of Fintech (2)', 'B. Com (Banking & Insurance) (BBI)', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Credit Rating (2)', 'B. Com (Banking & Insurance) (BBI)', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Introduction to Management (2)', 'B.Com. (Investment Management) (BIM)', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Basics of Fintech (2 )', 'B.Com. (Investment Management) (BIM)', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Introduction To Financial Markets', 'B.Com. (Financial Markets) (BFM)', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Managerial Skill Development', 'B. Com. (Transport Management) (BTM) Trade, Transport & Industry', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Open Elective in Financial Management Paper- I', 'B. Com. (Financial Management) (BFM) ', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Open Elective in Financial Management Paper- II', 'B. Com. (Financial Management) (BFM) ', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Introduction to Marketing', 'B.Com. (Travel & Tourism)', 2, 3),
('', 'B.Com.', 1, 'OE', '', 'Service Marketing', 'B.Com. (Travel & Tourism)', 2, 3),
('', 'B.Com.', 1, 'VSC', '', 'Fundamentals of Start ups', '', 2, 4),
('', 'B.Com.', 1, 'VSC', '', 'Business Etiquettes & Corporate Grooming', '', 2, 4),
('', 'B.Com.', 1, 'SEC', '', ' Negotiation Skills', '', 2, 4),
('', 'B.Com.', 1, 'AEC', '', 'Introduction to Communication Skills (B.Sc)', 'English', 2, 5),
('', 'B.Com.', 1, 'AEC', '', 'Business Communication Skills I (B.M.S.)', 'English', 2, 5),
('', 'B.Com.', 1, 'AEC', '', 'Business Communication Skills I (B.A.F)', 'English', 2, 5),
('', 'B.Com.', 1, 'AEC', '', 'Business Communication Skills I (B.Com.)', 'English', 2, 5),
('', 'B.Com.', 1, 'AEC', '', 'Communication Skills in English I (BA)', 'English', 2, 5),
('', 'B.Com.', 1, 'VEC', '', 'Indian Constitution', '', 2, 5),
('', 'B.Com.', 1, 'VEC', '', 'Introduction to Law of Torts and Consumer protection Act', '', 2, 5),
('', 'B.Com.', 1, 'VEC', '', 'Law related to Intellectual Property Rights', '', 2, 5),
('', 'B.Com.', 1, 'VEC', '', 'Fundamental of People', '', 2, 5),
('', 'B.Com.', 1, 'VEC', '', 'Foundation of Behavioral Skills- Basic Level', '', 2, 5),
('', 'B.Com.', 1, 'IKS', '', 'Indian Knowledge System', '', 2, 5),
('', 'B.Com.', 1, 'CC', '', 'Introduction to Cultural Activities', '', 2, 6);

-- --------------------------------------------------------

--
-- Table structure for table `totalverticalcredits`
--

CREATE TABLE IF NOT EXISTS `totalverticalcredits` (
  `VERTICAL_NAME` varchar(50) NOT NULL,
  `CREDITS` int(1) DEFAULT NULL,
  PRIMARY KEY (`VERTICAL_NAME`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `totalverticalcredits`
--

INSERT INTO `totalverticalcredits` (`VERTICAL_NAME`, `CREDITS`) VALUES
('Vertical1', 6),
('Vertical3', 4);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
