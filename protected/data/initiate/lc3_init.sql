-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 06, 2011 at 12:09 PM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lc3_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

DROP TABLE IF EXISTS `announcements`;
CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) unsigned NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `announcements`
--


-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

DROP TABLE IF EXISTS `articles`;
CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) unsigned NOT NULL,
  `contest_id` int(10) unsigned DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `contest_id` (`contest_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `articles`
--


-- --------------------------------------------------------

--
-- Table structure for table `AuthAssignment`
--

DROP TABLE IF EXISTS `AuthAssignment`;
CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `AuthAssignment`
--

INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('administrator', '1', NULL, 'N;'),
('learner', '1415', NULL, 'N;'),
('supervisor', '1', NULL, 'N;'),
('learner', '1416', NULL, 'N;'),
('learner', '4', NULL, 'N;'),
('learner', '259', NULL, 'N;'),
('learner', '6', NULL, 'N;'),
('supervisor', '5', NULL, 'N;'),
('supervisor', '6', NULL, 'N;'),
('administrator', '6', NULL, 'N;'),
('administrator', '5', NULL, 'N;'),
('learner', '7', NULL, 'N;'),
('administrator', '7', NULL, 'N;'),
('supervisor', '7', NULL, 'N;'),
('learner', '8', NULL, 'N;'),
('administrator', '8', NULL, 'N;'),
('supervisor', '8', NULL, 'N;'),
('learner', '9', NULL, 'N;'),
('administrator', '9', NULL, 'N;'),
('supervisor', '9', NULL, 'N;'),
('learner', '10', NULL, 'N;'),
('learner', '11', NULL, 'N;'),
('learner', '12', NULL, 'N;'),
('learner', '13', NULL, 'N;'),
('learner', '14', NULL, 'N;'),
('learner', '15', NULL, 'N;'),
('learner', '16', NULL, 'N;'),
('learner', '17', NULL, 'N;'),
('learner', '18', NULL, 'N;'),
('learner', '19', NULL, 'N;'),
('learner', '20', NULL, 'N;'),
('learner', '21', NULL, 'N;'),
('learner', '22', NULL, 'N;'),
('administrator', '22', NULL, 'N;'),
('learner', '23', NULL, 'N;'),
('learner', '24', NULL, 'N;'),
('learner', '25', NULL, 'N;'),
('learner', '26', NULL, 'N;'),
('learner', '27', NULL, 'N;'),
('learner', '28', NULL, 'N;'),
('learner', '29', NULL, 'N;'),
('learner', '30', NULL, 'N;'),
('learner', '31', NULL, 'N;'),
('learner', '32', NULL, 'N;'),
('learner', '33', NULL, 'N;'),
('learner', '34', NULL, 'N;'),
('learner', '35', NULL, 'N;'),
('learner', '36', NULL, 'N;'),
('learner', '37', NULL, 'N;'),
('learner', '38', NULL, 'N;'),
('learner', '39', NULL, 'N;'),
('learner', '40', NULL, 'N;'),
('learner', '41', NULL, 'N;'),
('learner', '42', NULL, 'N;'),
('learner', '43', NULL, 'N;'),
('learner', '44', NULL, 'N;'),
('learner', '45', NULL, 'N;'),
('learner', '46', NULL, 'N;'),
('learner', '47', NULL, 'N;'),
('learner', '48', NULL, 'N;'),
('learner', '49', NULL, 'N;'),
('learner', '50', NULL, 'N;'),
('learner', '51', NULL, 'N;'),
('learner', '52', NULL, 'N;'),
('learner', '53', NULL, 'N;'),
('learner', '54', NULL, 'N;'),
('learner', '55', NULL, 'N;'),
('learner', '56', NULL, 'N;'),
('learner', '57', NULL, 'N;'),
('learner', '58', NULL, 'N;'),
('learner', '59', NULL, 'N;'),
('learner', '60', NULL, 'N;'),
('learner', '61', NULL, 'N;'),
('learner', '62', NULL, 'N;'),
('learner', '63', NULL, 'N;'),
('learner', '64', NULL, 'N;'),
('learner', '65', NULL, 'N;'),
('learner', '66', NULL, 'N;'),
('learner', '67', NULL, 'N;'),
('learner', '68', NULL, 'N;'),
('learner', '69', NULL, 'N;'),
('learner', '70', NULL, 'N;'),
('learner', '71', NULL, 'N;'),
('learner', '72', NULL, 'N;'),
('learner', '73', NULL, 'N;'),
('learner', '74', NULL, 'N;'),
('learner', '75', NULL, 'N;'),
('learner', '76', NULL, 'N;'),
('learner', '77', NULL, 'N;'),
('learner', '78', NULL, 'N;'),
('learner', '79', NULL, 'N;'),
('learner', '80', NULL, 'N;'),
('learner', '81', NULL, 'N;'),
('learner', '82', NULL, 'N;'),
('learner', '83', NULL, 'N;'),
('learner', '84', NULL, 'N;'),
('learner', '85', NULL, 'N;'),
('learner', '86', NULL, 'N;'),
('learner', '87', NULL, 'N;'),
('learner', '88', NULL, 'N;'),
('learner', '89', NULL, 'N;'),
('learner', '90', NULL, 'N;'),
('learner', '91', NULL, 'N;'),
('learner', '92', NULL, 'N;'),
('learner', '93', NULL, 'N;'),
('learner', '94', NULL, 'N;'),
('learner', '95', NULL, 'N;'),
('learner', '96', NULL, 'N;'),
('learner', '97', NULL, 'N;'),
('learner', '98', NULL, 'N;'),
('learner', '99', NULL, 'N;'),
('learner', '100', NULL, 'N;'),
('learner', '101', NULL, 'N;'),
('learner', '102', NULL, 'N;'),
('learner', '103', NULL, 'N;'),
('learner', '104', NULL, 'N;'),
('learner', '105', NULL, 'N;'),
('learner', '106', NULL, 'N;'),
('learner', '107', NULL, 'N;'),
('learner', '108', NULL, 'N;'),
('learner', '109', NULL, 'N;'),
('learner', '110', NULL, 'N;'),
('learner', '111', NULL, 'N;'),
('learner', '112', NULL, 'N;'),
('learner', '113', NULL, 'N;'),
('learner', '114', NULL, 'N;'),
('learner', '115', NULL, 'N;'),
('learner', '116', NULL, 'N;'),
('learner', '117', NULL, 'N;'),
('learner', '118', NULL, 'N;'),
('learner', '119', NULL, 'N;'),
('learner', '120', NULL, 'N;'),
('learner', '121', NULL, 'N;'),
('learner', '122', NULL, 'N;'),
('learner', '123', NULL, 'N;'),
('learner', '124', NULL, 'N;'),
('learner', '125', NULL, 'N;'),
('learner', '126', NULL, 'N;'),
('learner', '127', NULL, 'N;'),
('learner', '128', NULL, 'N;'),
('learner', '129', NULL, 'N;'),
('learner', '130', NULL, 'N;'),
('learner', '131', NULL, 'N;'),
('learner', '132', NULL, 'N;'),
('learner', '133', NULL, 'N;'),
('learner', '134', NULL, 'N;'),
('learner', '135', NULL, 'N;'),
('learner', '136', NULL, 'N;'),
('learner', '137', NULL, 'N;'),
('learner', '138', NULL, 'N;'),
('learner', '139', NULL, 'N;'),
('learner', '140', NULL, 'N;'),
('learner', '141', NULL, 'N;'),
('learner', '142', NULL, 'N;'),
('learner', '143', NULL, 'N;'),
('learner', '144', NULL, 'N;'),
('learner', '145', NULL, 'N;'),
('learner', '146', NULL, 'N;'),
('learner', '147', NULL, 'N;'),
('learner', '148', NULL, 'N;'),
('learner', '149', NULL, 'N;'),
('learner', '150', NULL, 'N;'),
('learner', '151', NULL, 'N;'),
('learner', '152', NULL, 'N;'),
('learner', '153', NULL, 'N;'),
('learner', '154', NULL, 'N;'),
('learner', '155', NULL, 'N;'),
('learner', '156', NULL, 'N;'),
('learner', '157', NULL, 'N;'),
('learner', '158', NULL, 'N;'),
('learner', '159', NULL, 'N;'),
('learner', '160', NULL, 'N;'),
('learner', '161', NULL, 'N;'),
('learner', '162', NULL, 'N;'),
('learner', '163', NULL, 'N;'),
('learner', '164', NULL, 'N;'),
('learner', '165', NULL, 'N;'),
('learner', '166', NULL, 'N;'),
('learner', '167', NULL, 'N;'),
('learner', '168', NULL, 'N;'),
('learner', '169', NULL, 'N;'),
('learner', '170', NULL, 'N;'),
('learner', '171', NULL, 'N;'),
('learner', '172', NULL, 'N;'),
('learner', '173', NULL, 'N;'),
('learner', '174', NULL, 'N;'),
('learner', '175', NULL, 'N;'),
('learner', '176', NULL, 'N;'),
('learner', '177', NULL, 'N;'),
('learner', '178', NULL, 'N;'),
('learner', '179', NULL, 'N;'),
('learner', '180', NULL, 'N;'),
('learner', '181', NULL, 'N;'),
('learner', '182', NULL, 'N;'),
('learner', '183', NULL, 'N;'),
('learner', '184', NULL, 'N;'),
('learner', '185', NULL, 'N;'),
('learner', '186', NULL, 'N;'),
('learner', '187', NULL, 'N;'),
('learner', '188', NULL, 'N;'),
('learner', '189', NULL, 'N;'),
('learner', '190', NULL, 'N;'),
('learner', '191', NULL, 'N;'),
('learner', '192', NULL, 'N;'),
('learner', '193', NULL, 'N;'),
('learner', '194', NULL, 'N;'),
('learner', '195', NULL, 'N;'),
('learner', '196', NULL, 'N;'),
('learner', '197', NULL, 'N;'),
('learner', '198', NULL, 'N;'),
('learner', '199', NULL, 'N;'),
('learner', '200', NULL, 'N;'),
('learner', '201', NULL, 'N;'),
('learner', '202', NULL, 'N;'),
('learner', '203', NULL, 'N;'),
('learner', '204', NULL, 'N;'),
('learner', '205', NULL, 'N;'),
('learner', '206', NULL, 'N;'),
('learner', '207', NULL, 'N;'),
('learner', '208', NULL, 'N;'),
('learner', '209', NULL, 'N;'),
('learner', '210', NULL, 'N;'),
('learner', '211', NULL, 'N;'),
('learner', '212', NULL, 'N;'),
('learner', '213', NULL, 'N;'),
('learner', '214', NULL, 'N;'),
('learner', '215', NULL, 'N;'),
('learner', '216', NULL, 'N;'),
('learner', '217', NULL, 'N;'),
('learner', '218', NULL, 'N;'),
('learner', '219', NULL, 'N;'),
('learner', '220', NULL, 'N;'),
('learner', '221', NULL, 'N;'),
('learner', '222', NULL, 'N;'),
('learner', '223', NULL, 'N;'),
('learner', '224', NULL, 'N;'),
('learner', '225', NULL, 'N;'),
('learner', '226', NULL, 'N;'),
('learner', '227', NULL, 'N;'),
('learner', '228', NULL, 'N;'),
('learner', '229', NULL, 'N;'),
('supervisor', '22', NULL, 'N;'),
('learner', '230', NULL, 'N;'),
('learner', '231', NULL, 'N;'),
('learner', '232', NULL, 'N;'),
('learner', '233', NULL, 'N;'),
('learner', '234', NULL, 'N;'),
('learner', '235', NULL, 'N;'),
('learner', '236', NULL, 'N;'),
('learner', '237', NULL, 'N;'),
('learner', '238', NULL, 'N;'),
('learner', '239', NULL, 'N;'),
('learner', '240', NULL, 'N;'),
('learner', '241', NULL, 'N;'),
('learner', '242', NULL, 'N;'),
('learner', '243', NULL, 'N;'),
('learner', '244', NULL, 'N;'),
('learner', '245', NULL, 'N;'),
('learner', '246', NULL, 'N;'),
('learner', '247', NULL, 'N;'),
('learner', '248', NULL, 'N;'),
('learner', '249', NULL, 'N;'),
('learner', '250', NULL, 'N;'),
('learner', '251', NULL, 'N;'),
('learner', '252', NULL, 'N;'),
('learner', '253', NULL, 'N;'),
('learner', '254', NULL, 'N;'),
('learner', '255', NULL, 'N;'),
('learner', '256', NULL, 'N;'),
('learner', '257', NULL, 'N;'),
('learner', '258', NULL, 'N;'),
('learner', '260', NULL, 'N;'),
('learner', '261', NULL, 'N;'),
('learner', '262', NULL, 'N;'),
('learner', '263', NULL, 'N;'),
('learner', '264', NULL, 'N;'),
('learner', '265', NULL, 'N;'),
('learner', '266', NULL, 'N;'),
('learner', '267', NULL, 'N;'),
('learner', '268', NULL, 'N;'),
('learner', '269', NULL, 'N;'),
('learner', '270', NULL, 'N;'),
('learner', '271', NULL, 'N;'),
('learner', '272', NULL, 'N;'),
('learner', '273', NULL, 'N;'),
('learner', '274', NULL, 'N;'),
('learner', '275', NULL, 'N;'),
('learner', '276', NULL, 'N;'),
('learner', '277', NULL, 'N;'),
('learner', '278', NULL, 'N;'),
('learner', '279', NULL, 'N;'),
('learner', '280', NULL, 'N;'),
('learner', '281', NULL, 'N;'),
('learner', '282', NULL, 'N;'),
('learner', '283', NULL, 'N;'),
('learner', '284', NULL, 'N;'),
('learner', '285', NULL, 'N;'),
('learner', '286', NULL, 'N;'),
('learner', '287', NULL, 'N;'),
('learner', '288', NULL, 'N;'),
('learner', '289', NULL, 'N;'),
('learner', '290', NULL, 'N;'),
('learner', '291', NULL, 'N;'),
('learner', '292', NULL, 'N;'),
('learner', '293', NULL, 'N;'),
('learner', '294', NULL, 'N;'),
('learner', '295', NULL, 'N;'),
('learner', '296', NULL, 'N;'),
('learner', '297', NULL, 'N;'),
('learner', '298', NULL, 'N;'),
('learner', '299', NULL, 'N;'),
('learner', '300', NULL, 'N;'),
('learner', '301', NULL, 'N;'),
('learner', '302', NULL, 'N;'),
('learner', '303', NULL, 'N;'),
('learner', '304', NULL, 'N;'),
('learner', '305', NULL, 'N;'),
('learner', '306', NULL, 'N;'),
('learner', '307', NULL, 'N;'),
('learner', '308', NULL, 'N;'),
('learner', '309', NULL, 'N;'),
('learner', '310', NULL, 'N;'),
('learner', '311', NULL, 'N;'),
('learner', '312', NULL, 'N;'),
('learner', '313', NULL, 'N;'),
('learner', '314', NULL, 'N;'),
('learner', '315', NULL, 'N;'),
('learner', '316', NULL, 'N;'),
('learner', '317', NULL, 'N;'),
('learner', '318', NULL, 'N;'),
('learner', '319', NULL, 'N;'),
('learner', '320', NULL, 'N;'),
('learner', '321', NULL, 'N;'),
('learner', '322', NULL, 'N;'),
('learner', '323', NULL, 'N;'),
('learner', '324', NULL, 'N;'),
('learner', '325', NULL, 'N;'),
('learner', '326', NULL, 'N;'),
('learner', '327', NULL, 'N;'),
('learner', '328', NULL, 'N;'),
('learner', '329', NULL, 'N;'),
('learner', '330', NULL, 'N;'),
('learner', '331', NULL, 'N;'),
('learner', '332', NULL, 'N;'),
('learner', '333', NULL, 'N;'),
('learner', '334', NULL, 'N;'),
('learner', '335', NULL, 'N;'),
('learner', '336', NULL, 'N;'),
('learner', '337', NULL, 'N;'),
('learner', '338', NULL, 'N;'),
('learner', '339', NULL, 'N;'),
('learner', '340', NULL, 'N;'),
('learner', '341', NULL, 'N;'),
('learner', '342', NULL, 'N;'),
('learner', '343', NULL, 'N;'),
('learner', '344', NULL, 'N;'),
('learner', '345', NULL, 'N;'),
('learner', '346', NULL, 'N;'),
('learner', '347', NULL, 'N;'),
('learner', '348', NULL, 'N;'),
('learner', '349', NULL, 'N;'),
('learner', '350', NULL, 'N;'),
('learner', '351', NULL, 'N;'),
('learner', '352', NULL, 'N;'),
('learner', '353', NULL, 'N;'),
('learner', '354', NULL, 'N;'),
('learner', '355', NULL, 'N;'),
('learner', '356', NULL, 'N;'),
('learner', '357', NULL, 'N;'),
('learner', '358', NULL, 'N;'),
('learner', '359', NULL, 'N;'),
('learner', '360', NULL, 'N;'),
('learner', '361', NULL, 'N;'),
('learner', '362', NULL, 'N;'),
('learner', '363', NULL, 'N;'),
('learner', '364', NULL, 'N;'),
('learner', '365', NULL, 'N;'),
('learner', '366', NULL, 'N;'),
('learner', '367', NULL, 'N;'),
('learner', '368', NULL, 'N;'),
('learner', '369', NULL, 'N;'),
('learner', '370', NULL, 'N;'),
('learner', '371', NULL, 'N;'),
('learner', '372', NULL, 'N;'),
('learner', '373', NULL, 'N;'),
('learner', '374', NULL, 'N;'),
('learner', '375', NULL, 'N;'),
('learner', '376', NULL, 'N;'),
('learner', '377', NULL, 'N;'),
('learner', '378', NULL, 'N;'),
('learner', '379', NULL, 'N;'),
('learner', '380', NULL, 'N;'),
('learner', '381', NULL, 'N;'),
('learner', '382', NULL, 'N;'),
('learner', '383', NULL, 'N;'),
('learner', '384', NULL, 'N;'),
('learner', '385', NULL, 'N;'),
('learner', '386', NULL, 'N;'),
('learner', '387', NULL, 'N;'),
('learner', '388', NULL, 'N;'),
('learner', '389', NULL, 'N;'),
('learner', '390', NULL, 'N;'),
('learner', '391', NULL, 'N;'),
('learner', '392', NULL, 'N;'),
('learner', '393', NULL, 'N;'),
('learner', '394', NULL, 'N;'),
('learner', '395', NULL, 'N;'),
('learner', '396', NULL, 'N;'),
('learner', '397', NULL, 'N;'),
('learner', '398', NULL, 'N;'),
('learner', '399', NULL, 'N;'),
('learner', '400', NULL, 'N;'),
('learner', '401', NULL, 'N;'),
('learner', '402', NULL, 'N;'),
('learner', '403', NULL, 'N;'),
('learner', '404', NULL, 'N;'),
('learner', '405', NULL, 'N;'),
('learner', '406', NULL, 'N;'),
('learner', '407', NULL, 'N;'),
('learner', '408', NULL, 'N;'),
('learner', '409', NULL, 'N;'),
('learner', '410', NULL, 'N;'),
('learner', '411', NULL, 'N;'),
('learner', '412', NULL, 'N;'),
('learner', '413', NULL, 'N;'),
('learner', '414', NULL, 'N;'),
('learner', '415', NULL, 'N;'),
('learner', '416', NULL, 'N;'),
('learner', '417', NULL, 'N;'),
('learner', '418', NULL, 'N;'),
('learner', '419', NULL, 'N;'),
('learner', '420', NULL, 'N;'),
('learner', '421', NULL, 'N;'),
('learner', '422', NULL, 'N;'),
('learner', '423', NULL, 'N;'),
('learner', '424', NULL, 'N;'),
('learner', '425', NULL, 'N;'),
('learner', '426', NULL, 'N;'),
('learner', '427', NULL, 'N;'),
('learner', '428', NULL, 'N;'),
('learner', '429', NULL, 'N;'),
('learner', '430', NULL, 'N;'),
('learner', '431', NULL, 'N;'),
('learner', '432', NULL, 'N;'),
('learner', '433', NULL, 'N;'),
('learner', '434', NULL, 'N;'),
('learner', '435', NULL, 'N;'),
('learner', '436', NULL, 'N;'),
('learner', '437', NULL, 'N;'),
('learner', '438', NULL, 'N;'),
('learner', '439', NULL, 'N;'),
('learner', '440', NULL, 'N;'),
('learner', '441', NULL, 'N;'),
('learner', '442', NULL, 'N;'),
('learner', '443', NULL, 'N;'),
('learner', '444', NULL, 'N;'),
('learner', '445', NULL, 'N;'),
('learner', '446', NULL, 'N;'),
('learner', '447', NULL, 'N;'),
('learner', '448', NULL, 'N;'),
('learner', '449', NULL, 'N;'),
('learner', '450', NULL, 'N;'),
('learner', '451', NULL, 'N;'),
('learner', '452', NULL, 'N;'),
('learner', '453', NULL, 'N;'),
('learner', '454', NULL, 'N;'),
('learner', '455', NULL, 'N;'),
('learner', '456', NULL, 'N;'),
('learner', '457', NULL, 'N;'),
('learner', '458', NULL, 'N;'),
('learner', '459', NULL, 'N;'),
('learner', '460', NULL, 'N;'),
('learner', '461', NULL, 'N;'),
('learner', '462', NULL, 'N;'),
('learner', '463', NULL, 'N;'),
('learner', '464', NULL, 'N;'),
('learner', '465', NULL, 'N;'),
('learner', '466', NULL, 'N;'),
('learner', '467', NULL, 'N;'),
('learner', '468', NULL, 'N;'),
('learner', '469', NULL, 'N;'),
('learner', '470', NULL, 'N;'),
('learner', '471', NULL, 'N;'),
('learner', '472', NULL, 'N;'),
('learner', '473', NULL, 'N;'),
('learner', '474', NULL, 'N;'),
('learner', '475', NULL, 'N;'),
('learner', '476', NULL, 'N;'),
('learner', '477', NULL, 'N;'),
('learner', '478', NULL, 'N;'),
('learner', '479', NULL, 'N;'),
('learner', '480', NULL, 'N;'),
('learner', '481', NULL, 'N;'),
('learner', '482', NULL, 'N;'),
('learner', '483', NULL, 'N;'),
('learner', '484', NULL, 'N;'),
('learner', '485', NULL, 'N;'),
('learner', '486', NULL, 'N;'),
('learner', '487', NULL, 'N;'),
('learner', '488', NULL, 'N;'),
('learner', '489', NULL, 'N;'),
('learner', '490', NULL, 'N;'),
('learner', '491', NULL, 'N;'),
('learner', '492', NULL, 'N;'),
('learner', '493', NULL, 'N;'),
('learner', '494', NULL, 'N;'),
('learner', '495', NULL, 'N;'),
('learner', '496', NULL, 'N;'),
('learner', '497', NULL, 'N;'),
('learner', '498', NULL, 'N;'),
('learner', '499', NULL, 'N;'),
('learner', '500', NULL, 'N;'),
('learner', '501', NULL, 'N;'),
('learner', '502', NULL, 'N;'),
('learner', '503', NULL, 'N;'),
('learner', '504', NULL, 'N;'),
('learner', '505', NULL, 'N;'),
('learner', '506', NULL, 'N;'),
('learner', '507', NULL, 'N;'),
('learner', '508', NULL, 'N;'),
('learner', '509', NULL, 'N;'),
('learner', '510', NULL, 'N;'),
('learner', '511', NULL, 'N;'),
('learner', '512', NULL, 'N;'),
('learner', '513', NULL, 'N;'),
('learner', '514', NULL, 'N;'),
('learner', '515', NULL, 'N;'),
('learner', '516', NULL, 'N;'),
('learner', '517', NULL, 'N;'),
('learner', '518', NULL, 'N;'),
('learner', '519', NULL, 'N;'),
('learner', '520', NULL, 'N;'),
('learner', '521', NULL, 'N;'),
('learner', '522', NULL, 'N;'),
('learner', '523', NULL, 'N;'),
('learner', '524', NULL, 'N;'),
('learner', '525', NULL, 'N;'),
('learner', '526', NULL, 'N;'),
('learner', '527', NULL, 'N;'),
('learner', '528', NULL, 'N;'),
('learner', '529', NULL, 'N;'),
('learner', '530', NULL, 'N;'),
('learner', '531', NULL, 'N;'),
('learner', '532', NULL, 'N;'),
('learner', '533', NULL, 'N;'),
('learner', '534', NULL, 'N;'),
('learner', '535', NULL, 'N;'),
('learner', '536', NULL, 'N;'),
('learner', '537', NULL, 'N;'),
('learner', '538', NULL, 'N;'),
('learner', '539', NULL, 'N;'),
('learner', '540', NULL, 'N;'),
('learner', '541', NULL, 'N;'),
('learner', '542', NULL, 'N;'),
('learner', '543', NULL, 'N;'),
('learner', '544', NULL, 'N;'),
('learner', '545', NULL, 'N;'),
('learner', '546', NULL, 'N;'),
('learner', '547', NULL, 'N;'),
('learner', '548', NULL, 'N;'),
('learner', '549', NULL, 'N;'),
('learner', '550', NULL, 'N;'),
('learner', '551', NULL, 'N;'),
('learner', '552', NULL, 'N;'),
('learner', '553', NULL, 'N;'),
('learner', '554', NULL, 'N;'),
('learner', '555', NULL, 'N;'),
('learner', '556', NULL, 'N;'),
('learner', '557', NULL, 'N;'),
('learner', '558', NULL, 'N;'),
('learner', '559', NULL, 'N;'),
('learner', '560', NULL, 'N;'),
('learner', '561', NULL, 'N;'),
('learner', '562', NULL, 'N;'),
('learner', '563', NULL, 'N;'),
('learner', '564', NULL, 'N;'),
('learner', '565', NULL, 'N;'),
('learner', '566', NULL, 'N;'),
('learner', '567', NULL, 'N;'),
('learner', '568', NULL, 'N;'),
('learner', '569', NULL, 'N;'),
('learner', '570', NULL, 'N;'),
('learner', '571', NULL, 'N;'),
('learner', '572', NULL, 'N;'),
('learner', '573', NULL, 'N;'),
('learner', '574', NULL, 'N;'),
('learner', '575', NULL, 'N;'),
('learner', '576', NULL, 'N;'),
('learner', '577', NULL, 'N;'),
('learner', '578', NULL, 'N;'),
('learner', '579', NULL, 'N;'),
('learner', '580', NULL, 'N;'),
('learner', '581', NULL, 'N;'),
('learner', '582', NULL, 'N;'),
('learner', '583', NULL, 'N;'),
('learner', '584', NULL, 'N;'),
('learner', '585', NULL, 'N;'),
('learner', '586', NULL, 'N;'),
('learner', '587', NULL, 'N;'),
('learner', '588', NULL, 'N;'),
('learner', '589', NULL, 'N;'),
('learner', '590', NULL, 'N;'),
('learner', '591', NULL, 'N;'),
('learner', '592', NULL, 'N;'),
('learner', '593', NULL, 'N;'),
('learner', '594', NULL, 'N;'),
('learner', '595', NULL, 'N;'),
('learner', '596', NULL, 'N;'),
('learner', '597', NULL, 'N;'),
('learner', '598', NULL, 'N;'),
('learner', '599', NULL, 'N;'),
('learner', '600', NULL, 'N;'),
('learner', '601', NULL, 'N;'),
('learner', '602', NULL, 'N;'),
('learner', '603', NULL, 'N;'),
('learner', '604', NULL, 'N;'),
('learner', '605', NULL, 'N;'),
('learner', '606', NULL, 'N;'),
('learner', '607', NULL, 'N;'),
('learner', '608', NULL, 'N;'),
('learner', '609', NULL, 'N;'),
('learner', '610', NULL, 'N;'),
('learner', '611', NULL, 'N;'),
('learner', '612', NULL, 'N;'),
('learner', '613', NULL, 'N;'),
('learner', '614', NULL, 'N;'),
('learner', '615', NULL, 'N;'),
('learner', '616', NULL, 'N;'),
('learner', '617', NULL, 'N;'),
('learner', '618', NULL, 'N;'),
('learner', '619', NULL, 'N;'),
('learner', '620', NULL, 'N;'),
('learner', '621', NULL, 'N;'),
('learner', '622', NULL, 'N;'),
('learner', '623', NULL, 'N;'),
('learner', '624', NULL, 'N;'),
('learner', '625', NULL, 'N;'),
('learner', '626', NULL, 'N;'),
('learner', '627', NULL, 'N;'),
('learner', '628', NULL, 'N;'),
('learner', '629', NULL, 'N;'),
('learner', '630', NULL, 'N;'),
('learner', '631', NULL, 'N;'),
('learner', '632', NULL, 'N;'),
('learner', '633', NULL, 'N;'),
('learner', '634', NULL, 'N;'),
('learner', '635', NULL, 'N;'),
('learner', '636', NULL, 'N;'),
('learner', '637', NULL, 'N;'),
('learner', '638', NULL, 'N;'),
('learner', '639', NULL, 'N;'),
('learner', '640', NULL, 'N;'),
('learner', '641', NULL, 'N;'),
('learner', '642', NULL, 'N;'),
('learner', '643', NULL, 'N;'),
('learner', '644', NULL, 'N;'),
('learner', '645', NULL, 'N;'),
('learner', '646', NULL, 'N;'),
('learner', '647', NULL, 'N;'),
('learner', '648', NULL, 'N;'),
('learner', '649', NULL, 'N;'),
('learner', '650', NULL, 'N;'),
('learner', '651', NULL, 'N;'),
('learner', '652', NULL, 'N;'),
('learner', '653', NULL, 'N;'),
('learner', '654', NULL, 'N;'),
('learner', '655', NULL, 'N;'),
('learner', '656', NULL, 'N;'),
('learner', '657', NULL, 'N;'),
('learner', '658', NULL, 'N;'),
('learner', '659', NULL, 'N;'),
('learner', '660', NULL, 'N;'),
('learner', '661', NULL, 'N;'),
('learner', '662', NULL, 'N;'),
('learner', '663', NULL, 'N;'),
('learner', '664', NULL, 'N;'),
('learner', '665', NULL, 'N;'),
('learner', '666', NULL, 'N;'),
('learner', '667', NULL, 'N;'),
('learner', '668', NULL, 'N;'),
('learner', '669', NULL, 'N;'),
('learner', '670', NULL, 'N;'),
('learner', '671', NULL, 'N;'),
('learner', '672', NULL, 'N;'),
('learner', '673', NULL, 'N;'),
('learner', '674', NULL, 'N;'),
('learner', '675', NULL, 'N;'),
('learner', '676', NULL, 'N;'),
('learner', '677', NULL, 'N;'),
('learner', '678', NULL, 'N;'),
('learner', '679', NULL, 'N;'),
('supervisor', '680', NULL, 'N;'),
('supervisor', '681', NULL, 'N;'),
('supervisor', '682', NULL, 'N;'),
('supervisor', '683', NULL, 'N;'),
('supervisor', '684', NULL, 'N;'),
('supervisor', '685', NULL, 'N;'),
('supervisor', '686', NULL, 'N;'),
('supervisor', '687', NULL, 'N;'),
('supervisor', '688', NULL, 'N;'),
('supervisor', '689', NULL, 'N;'),
('supervisor', '690', NULL, 'N;'),
('supervisor', '691', NULL, 'N;'),
('supervisor', '692', NULL, 'N;'),
('supervisor', '693', NULL, 'N;'),
('supervisor', '694', NULL, 'N;'),
('supervisor', '695', NULL, 'N;'),
('supervisor', '696', NULL, 'N;'),
('supervisor', '697', NULL, 'N;'),
('supervisor', '698', NULL, 'N;'),
('supervisor', '699', NULL, 'N;'),
('supervisor', '700', NULL, 'N;'),
('supervisor', '701', NULL, 'N;'),
('supervisor', '702', NULL, 'N;'),
('supervisor', '703', NULL, 'N;'),
('supervisor', '704', NULL, 'N;'),
('supervisor', '705', NULL, 'N;'),
('supervisor', '706', NULL, 'N;'),
('supervisor', '707', NULL, 'N;'),
('supervisor', '708', NULL, 'N;'),
('learner', '709', NULL, 'N;'),
('learner', '710', NULL, 'N;'),
('learner', '711', NULL, 'N;'),
('learner', '712', NULL, 'N;'),
('learner', '713', NULL, 'N;'),
('learner', '714', NULL, 'N;'),
('learner', '715', NULL, 'N;'),
('learner', '716', NULL, 'N;'),
('learner', '717', NULL, 'N;'),
('learner', '718', NULL, 'N;'),
('learner', '719', NULL, 'N;'),
('learner', '720', NULL, 'N;'),
('learner', '721', NULL, 'N;'),
('learner', '722', NULL, 'N;'),
('learner', '723', NULL, 'N;'),
('learner', '724', NULL, 'N;'),
('learner', '725', NULL, 'N;'),
('learner', '726', NULL, 'N;'),
('learner', '727', NULL, 'N;'),
('learner', '728', NULL, 'N;'),
('learner', '729', NULL, 'N;'),
('learner', '730', NULL, 'N;'),
('learner', '731', NULL, 'N;'),
('learner', '732', NULL, 'N;'),
('learner', '733', NULL, 'N;'),
('learner', '734', NULL, 'N;'),
('learner', '735', NULL, 'N;'),
('learner', '736', NULL, 'N;'),
('learner', '737', NULL, 'N;'),
('learner', '738', NULL, 'N;'),
('learner', '739', NULL, 'N;'),
('learner', '740', NULL, 'N;'),
('learner', '741', NULL, 'N;'),
('learner', '742', NULL, 'N;'),
('learner', '743', NULL, 'N;'),
('learner', '744', NULL, 'N;'),
('learner', '745', NULL, 'N;'),
('learner', '746', NULL, 'N;'),
('learner', '747', NULL, 'N;'),
('learner', '748', NULL, 'N;'),
('learner', '749', NULL, 'N;'),
('learner', '750', NULL, 'N;'),
('learner', '751', NULL, 'N;'),
('learner', '752', NULL, 'N;'),
('learner', '753', NULL, 'N;'),
('learner', '754', NULL, 'N;'),
('learner', '755', NULL, 'N;'),
('learner', '756', NULL, 'N;'),
('learner', '757', NULL, 'N;'),
('learner', '758', NULL, 'N;'),
('learner', '759', NULL, 'N;'),
('learner', '760', NULL, 'N;'),
('learner', '761', NULL, 'N;'),
('learner', '762', NULL, 'N;'),
('learner', '763', NULL, 'N;'),
('learner', '764', NULL, 'N;'),
('learner', '765', NULL, 'N;'),
('learner', '766', NULL, 'N;'),
('learner', '767', NULL, 'N;'),
('learner', '768', NULL, 'N;'),
('learner', '769', NULL, 'N;'),
('learner', '770', NULL, 'N;'),
('learner', '771', NULL, 'N;'),
('learner', '772', NULL, 'N;'),
('learner', '773', NULL, 'N;'),
('learner', '774', NULL, 'N;'),
('learner', '775', NULL, 'N;'),
('learner', '776', NULL, 'N;'),
('learner', '777', NULL, 'N;'),
('learner', '778', NULL, 'N;'),
('learner', '779', NULL, 'N;'),
('learner', '780', NULL, 'N;'),
('learner', '781', NULL, 'N;'),
('learner', '782', NULL, 'N;'),
('learner', '783', NULL, 'N;'),
('learner', '784', NULL, 'N;'),
('learner', '785', NULL, 'N;'),
('learner', '786', NULL, 'N;'),
('learner', '787', NULL, 'N;'),
('learner', '788', NULL, 'N;'),
('learner', '789', NULL, 'N;'),
('learner', '790', NULL, 'N;'),
('learner', '791', NULL, 'N;'),
('learner', '792', NULL, 'N;'),
('learner', '793', NULL, 'N;'),
('learner', '794', NULL, 'N;'),
('learner', '795', NULL, 'N;'),
('learner', '796', NULL, 'N;'),
('learner', '797', NULL, 'N;'),
('learner', '798', NULL, 'N;'),
('learner', '799', NULL, 'N;'),
('learner', '800', NULL, 'N;'),
('learner', '801', NULL, 'N;'),
('learner', '802', NULL, 'N;'),
('learner', '803', NULL, 'N;'),
('learner', '804', NULL, 'N;'),
('learner', '805', NULL, 'N;'),
('learner', '806', NULL, 'N;'),
('learner', '807', NULL, 'N;'),
('learner', '808', NULL, 'N;'),
('learner', '809', NULL, 'N;'),
('learner', '810', NULL, 'N;'),
('learner', '811', NULL, 'N;'),
('learner', '812', NULL, 'N;'),
('learner', '813', NULL, 'N;'),
('learner', '814', NULL, 'N;'),
('learner', '815', NULL, 'N;'),
('learner', '816', NULL, 'N;'),
('learner', '817', NULL, 'N;'),
('learner', '818', NULL, 'N;'),
('learner', '819', NULL, 'N;'),
('learner', '820', NULL, 'N;'),
('learner', '821', NULL, 'N;'),
('learner', '822', NULL, 'N;'),
('learner', '823', NULL, 'N;'),
('learner', '824', NULL, 'N;'),
('learner', '825', NULL, 'N;'),
('learner', '826', NULL, 'N;'),
('learner', '827', NULL, 'N;'),
('learner', '828', NULL, 'N;'),
('learner', '829', NULL, 'N;'),
('learner', '830', NULL, 'N;'),
('learner', '831', NULL, 'N;'),
('learner', '832', NULL, 'N;'),
('learner', '833', NULL, 'N;'),
('learner', '834', NULL, 'N;'),
('learner', '835', NULL, 'N;'),
('learner', '836', NULL, 'N;'),
('learner', '837', NULL, 'N;'),
('learner', '838', NULL, 'N;'),
('learner', '839', NULL, 'N;'),
('learner', '840', NULL, 'N;'),
('learner', '841', NULL, 'N;'),
('learner', '842', NULL, 'N;'),
('learner', '843', NULL, 'N;'),
('learner', '844', NULL, 'N;'),
('learner', '845', NULL, 'N;'),
('learner', '846', NULL, 'N;'),
('learner', '847', NULL, 'N;'),
('learner', '848', NULL, 'N;'),
('learner', '849', NULL, 'N;'),
('learner', '850', NULL, 'N;'),
('learner', '851', NULL, 'N;'),
('learner', '852', NULL, 'N;'),
('learner', '853', NULL, 'N;'),
('learner', '854', NULL, 'N;'),
('learner', '855', NULL, 'N;'),
('learner', '856', NULL, 'N;'),
('learner', '857', NULL, 'N;'),
('learner', '858', NULL, 'N;'),
('learner', '859', NULL, 'N;'),
('learner', '860', NULL, 'N;'),
('learner', '861', NULL, 'N;'),
('learner', '862', NULL, 'N;'),
('learner', '863', NULL, 'N;'),
('learner', '864', NULL, 'N;'),
('learner', '865', NULL, 'N;'),
('learner', '866', NULL, 'N;'),
('learner', '867', NULL, 'N;'),
('learner', '868', NULL, 'N;'),
('learner', '869', NULL, 'N;'),
('learner', '870', NULL, 'N;'),
('learner', '871', NULL, 'N;'),
('learner', '872', NULL, 'N;'),
('learner', '873', NULL, 'N;'),
('learner', '874', NULL, 'N;'),
('learner', '875', NULL, 'N;'),
('learner', '876', NULL, 'N;'),
('learner', '877', NULL, 'N;'),
('learner', '878', NULL, 'N;'),
('learner', '879', NULL, 'N;'),
('learner', '880', NULL, 'N;'),
('learner', '881', NULL, 'N;'),
('learner', '882', NULL, 'N;'),
('learner', '883', NULL, 'N;'),
('learner', '884', NULL, 'N;'),
('learner', '885', NULL, 'N;'),
('learner', '886', NULL, 'N;'),
('learner', '887', NULL, 'N;'),
('learner', '888', NULL, 'N;'),
('learner', '889', NULL, 'N;'),
('learner', '890', NULL, 'N;'),
('learner', '891', NULL, 'N;'),
('learner', '892', NULL, 'N;'),
('learner', '893', NULL, 'N;'),
('learner', '894', NULL, 'N;'),
('learner', '895', NULL, 'N;'),
('learner', '896', NULL, 'N;'),
('learner', '897', NULL, 'N;'),
('learner', '898', NULL, 'N;'),
('learner', '899', NULL, 'N;'),
('learner', '900', NULL, 'N;'),
('learner', '901', NULL, 'N;'),
('learner', '902', NULL, 'N;'),
('learner', '903', NULL, 'N;'),
('learner', '904', NULL, 'N;'),
('learner', '905', NULL, 'N;'),
('learner', '906', NULL, 'N;'),
('learner', '907', NULL, 'N;'),
('learner', '908', NULL, 'N;'),
('learner', '909', NULL, 'N;'),
('learner', '910', NULL, 'N;'),
('learner', '911', NULL, 'N;'),
('learner', '912', NULL, 'N;'),
('learner', '913', NULL, 'N;'),
('learner', '914', NULL, 'N;'),
('learner', '915', NULL, 'N;'),
('learner', '916', NULL, 'N;'),
('learner', '917', NULL, 'N;'),
('learner', '918', NULL, 'N;'),
('learner', '919', NULL, 'N;'),
('learner', '920', NULL, 'N;'),
('learner', '921', NULL, 'N;'),
('learner', '922', NULL, 'N;'),
('learner', '923', NULL, 'N;'),
('learner', '924', NULL, 'N;'),
('learner', '925', NULL, 'N;'),
('learner', '926', NULL, 'N;'),
('learner', '927', NULL, 'N;'),
('learner', '928', NULL, 'N;'),
('learner', '929', NULL, 'N;'),
('learner', '930', NULL, 'N;'),
('learner', '931', NULL, 'N;'),
('learner', '932', NULL, 'N;'),
('learner', '933', NULL, 'N;'),
('learner', '934', NULL, 'N;'),
('learner', '935', NULL, 'N;'),
('learner', '936', NULL, 'N;'),
('learner', '937', NULL, 'N;'),
('learner', '938', NULL, 'N;'),
('learner', '939', NULL, 'N;'),
('learner', '940', NULL, 'N;'),
('learner', '941', NULL, 'N;'),
('learner', '942', NULL, 'N;'),
('learner', '943', NULL, 'N;'),
('learner', '944', NULL, 'N;'),
('learner', '945', NULL, 'N;'),
('learner', '946', NULL, 'N;'),
('learner', '947', NULL, 'N;'),
('learner', '948', NULL, 'N;'),
('learner', '949', NULL, 'N;'),
('learner', '950', NULL, 'N;'),
('learner', '951', NULL, 'N;'),
('learner', '952', NULL, 'N;'),
('learner', '953', NULL, 'N;'),
('learner', '954', NULL, 'N;'),
('learner', '955', NULL, 'N;'),
('learner', '956', NULL, 'N;'),
('learner', '957', NULL, 'N;'),
('learner', '958', NULL, 'N;'),
('learner', '959', NULL, 'N;'),
('learner', '960', NULL, 'N;'),
('learner', '961', NULL, 'N;'),
('learner', '962', NULL, 'N;'),
('learner', '963', NULL, 'N;'),
('learner', '964', NULL, 'N;'),
('learner', '965', NULL, 'N;'),
('learner', '966', NULL, 'N;'),
('learner', '967', NULL, 'N;'),
('learner', '968', NULL, 'N;'),
('learner', '969', NULL, 'N;'),
('learner', '970', NULL, 'N;'),
('learner', '971', NULL, 'N;'),
('learner', '972', NULL, 'N;'),
('learner', '973', NULL, 'N;'),
('learner', '974', NULL, 'N;'),
('learner', '975', NULL, 'N;'),
('learner', '976', NULL, 'N;'),
('learner', '977', NULL, 'N;'),
('learner', '978', NULL, 'N;'),
('learner', '979', NULL, 'N;'),
('learner', '980', NULL, 'N;'),
('learner', '981', NULL, 'N;'),
('learner', '982', NULL, 'N;'),
('learner', '983', NULL, 'N;'),
('learner', '984', NULL, 'N;'),
('learner', '985', NULL, 'N;'),
('learner', '986', NULL, 'N;'),
('learner', '987', NULL, 'N;'),
('learner', '988', NULL, 'N;'),
('learner', '989', NULL, 'N;'),
('learner', '990', NULL, 'N;'),
('learner', '1', NULL, 'N;'),
('supervisor', '991', NULL, 'N;'),
('learner', '992', NULL, 'N;'),
('learner', '993', NULL, 'N;'),
('learner', '994', NULL, 'N;'),
('learner', '995', NULL, 'N;'),
('learner', '996', NULL, 'N;'),
('learner', '997', NULL, 'N;'),
('supervisor', '11', NULL, 'N;'),
('learner', '998', NULL, 'N;'),
('learner', '999', NULL, 'N;'),
('administrator', '999', NULL, 'N;'),
('supervisor', '999', NULL, 'N;'),
('supervisor', '10', NULL, 'N;'),
('learner', '1001', NULL, 'N;'),
('learner', '1002', NULL, 'N;'),
('learner', '1003', NULL, 'N;'),
('learner', '1004', NULL, 'N;'),
('learner', '1005', NULL, 'N;'),
('learner', '1006', NULL, 'N;'),
('learner', '1007', NULL, 'N;'),
('learner', '1008', NULL, 'N;'),
('learner', '1009', NULL, 'N;'),
('learner', '1010', NULL, 'N;'),
('learner', '1011', NULL, 'N;'),
('learner', '1012', NULL, 'N;'),
('learner', '1013', NULL, 'N;'),
('learner', '1014', NULL, 'N;'),
('learner', '1015', NULL, 'N;'),
('learner', '1016', NULL, 'N;'),
('learner', '1017', NULL, 'N;'),
('learner', '1018', NULL, 'N;'),
('learner', '1019', NULL, 'N;'),
('learner', '1020', NULL, 'N;'),
('learner', '1021', NULL, 'N;'),
('learner', '1022', NULL, 'N;'),
('learner', '1023', NULL, 'N;'),
('learner', '1024', NULL, 'N;'),
('learner', '1025', NULL, 'N;'),
('learner', '1026', NULL, 'N;'),
('learner', '1027', NULL, 'N;'),
('learner', '1028', NULL, 'N;'),
('learner', '1029', NULL, 'N;'),
('learner', '1030', NULL, 'N;'),
('learner', '1031', NULL, 'N;'),
('learner', '1032', NULL, 'N;'),
('learner', '1033', NULL, 'N;'),
('learner', '1034', NULL, 'N;'),
('learner', '1035', NULL, 'N;'),
('learner', '1036', NULL, 'N;'),
('learner', '1037', NULL, 'N;'),
('learner', '1038', NULL, 'N;'),
('learner', '1039', NULL, 'N;'),
('learner', '1040', NULL, 'N;'),
('learner', '1041', NULL, 'N;'),
('learner', '1042', NULL, 'N;'),
('learner', '1043', NULL, 'N;'),
('learner', '1044', NULL, 'N;'),
('learner', '1045', NULL, 'N;'),
('learner', '1046', NULL, 'N;'),
('learner', '1047', NULL, 'N;'),
('learner', '1048', NULL, 'N;'),
('learner', '1049', NULL, 'N;'),
('learner', '1050', NULL, 'N;'),
('learner', '1051', NULL, 'N;'),
('learner', '1052', NULL, 'N;'),
('learner', '1053', NULL, 'N;'),
('learner', '1054', NULL, 'N;'),
('learner', '1055', NULL, 'N;'),
('learner', '1056', NULL, 'N;'),
('learner', '1057', NULL, 'N;'),
('learner', '1058', NULL, 'N;'),
('learner', '1059', NULL, 'N;'),
('learner', '1060', NULL, 'N;'),
('learner', '1061', NULL, 'N;'),
('learner', '1062', NULL, 'N;'),
('learner', '1063', NULL, 'N;'),
('learner', '1064', NULL, 'N;'),
('learner', '1065', NULL, 'N;'),
('learner', '1066', NULL, 'N;'),
('learner', '1067', NULL, 'N;'),
('learner', '1068', NULL, 'N;'),
('learner', '1069', NULL, 'N;'),
('learner', '1070', NULL, 'N;'),
('learner', '1071', NULL, 'N;'),
('learner', '1072', NULL, 'N;'),
('learner', '1073', NULL, 'N;'),
('learner', '1074', NULL, 'N;'),
('learner', '1075', NULL, 'N;'),
('learner', '1076', NULL, 'N;'),
('learner', '1077', NULL, 'N;'),
('learner', '1078', NULL, 'N;'),
('learner', '1079', NULL, 'N;'),
('learner', '1080', NULL, 'N;'),
('learner', '1081', NULL, 'N;'),
('learner', '1082', NULL, 'N;'),
('learner', '1083', NULL, 'N;'),
('learner', '1084', NULL, 'N;'),
('learner', '1085', NULL, 'N;'),
('learner', '1086', NULL, 'N;'),
('learner', '1087', NULL, 'N;'),
('learner', '1088', NULL, 'N;'),
('learner', '1089', NULL, 'N;'),
('learner', '1090', NULL, 'N;'),
('learner', '1091', NULL, 'N;'),
('learner', '1092', NULL, 'N;'),
('learner', '1093', NULL, 'N;'),
('learner', '1094', NULL, 'N;'),
('learner', '1095', NULL, 'N;'),
('learner', '1096', NULL, 'N;'),
('learner', '1097', NULL, 'N;'),
('learner', '1098', NULL, 'N;'),
('learner', '1099', NULL, 'N;'),
('learner', '1100', NULL, 'N;'),
('learner', '1101', NULL, 'N;'),
('learner', '1102', NULL, 'N;'),
('learner', '1103', NULL, 'N;'),
('learner', '1104', NULL, 'N;'),
('learner', '1105', NULL, 'N;'),
('learner', '1106', NULL, 'N;'),
('learner', '1107', NULL, 'N;'),
('learner', '1108', NULL, 'N;'),
('learner', '1109', NULL, 'N;'),
('learner', '1110', NULL, 'N;'),
('learner', '1111', NULL, 'N;'),
('learner', '1112', NULL, 'N;'),
('learner', '1113', NULL, 'N;'),
('learner', '1114', NULL, 'N;'),
('learner', '1115', NULL, 'N;'),
('learner', '1116', NULL, 'N;'),
('learner', '1117', NULL, 'N;'),
('learner', '1118', NULL, 'N;'),
('learner', '1119', NULL, 'N;'),
('learner', '1120', NULL, 'N;'),
('learner', '1121', NULL, 'N;'),
('learner', '1122', NULL, 'N;'),
('learner', '1123', NULL, 'N;'),
('learner', '1124', NULL, 'N;'),
('learner', '1125', NULL, 'N;'),
('learner', '1126', NULL, 'N;'),
('learner', '1127', NULL, 'N;'),
('learner', '1128', NULL, 'N;'),
('learner', '1129', NULL, 'N;'),
('learner', '1130', NULL, 'N;'),
('learner', '1131', NULL, 'N;'),
('learner', '1132', NULL, 'N;'),
('learner', '1133', NULL, 'N;'),
('learner', '1134', NULL, 'N;'),
('learner', '1135', NULL, 'N;'),
('learner', '1136', NULL, 'N;'),
('learner', '1137', NULL, 'N;'),
('learner', '1138', NULL, 'N;'),
('learner', '1139', NULL, 'N;'),
('learner', '1140', NULL, 'N;'),
('supervisor', '1139', NULL, 'N;'),
('supervisor', '1140', NULL, 'N;'),
('supervisor', '1138', NULL, 'N;'),
('supervisor', '1137', NULL, 'N;'),
('learner', '1141', NULL, 'N;'),
('learner', '1142', NULL, 'N;'),
('learner', '1143', NULL, 'N;'),
('learner', '1144', NULL, 'N;'),
('learner', '1145', NULL, 'N;'),
('learner', '1146', NULL, 'N;'),
('learner', '1147', NULL, 'N;'),
('learner', '1148', NULL, 'N;'),
('learner', '1149', NULL, 'N;'),
('learner', '1150', NULL, 'N;'),
('learner', '1151', NULL, 'N;'),
('learner', '1152', NULL, 'N;'),
('learner', '1153', NULL, 'N;'),
('learner', '1154', NULL, 'N;'),
('learner', '1155', NULL, 'N;'),
('learner', '1156', NULL, 'N;'),
('learner', '1157', NULL, 'N;'),
('learner', '1158', NULL, 'N;'),
('learner', '1159', NULL, 'N;'),
('learner', '1160', NULL, 'N;'),
('learner', '1161', NULL, 'N;'),
('learner', '1162', NULL, 'N;'),
('learner', '1163', NULL, 'N;'),
('learner', '1164', NULL, 'N;'),
('learner', '1165', NULL, 'N;'),
('learner', '1166', NULL, 'N;'),
('learner', '1167', NULL, 'N;'),
('learner', '1168', NULL, 'N;'),
('learner', '1169', NULL, 'N;'),
('learner', '1170', NULL, 'N;'),
('learner', '1171', NULL, 'N;'),
('learner', '1172', NULL, 'N;'),
('learner', '1173', NULL, 'N;'),
('learner', '1174', NULL, 'N;'),
('learner', '1175', NULL, 'N;'),
('learner', '1176', NULL, 'N;'),
('learner', '1177', NULL, 'N;'),
('learner', '1178', NULL, 'N;'),
('learner', '1179', NULL, 'N;'),
('learner', '1180', NULL, 'N;'),
('learner', '1181', NULL, 'N;'),
('learner', '1182', NULL, 'N;'),
('learner', '1183', NULL, 'N;'),
('learner', '1184', NULL, 'N;'),
('learner', '1185', NULL, 'N;'),
('learner', '1186', NULL, 'N;'),
('learner', '1187', NULL, 'N;'),
('learner', '1188', NULL, 'N;'),
('learner', '1189', NULL, 'N;'),
('learner', '1190', NULL, 'N;'),
('learner', '1191', NULL, 'N;'),
('learner', '1192', NULL, 'N;'),
('learner', '1193', NULL, 'N;'),
('learner', '1194', NULL, 'N;'),
('learner', '1195', NULL, 'N;'),
('learner', '1196', NULL, 'N;'),
('learner', '1197', NULL, 'N;'),
('learner', '1198', NULL, 'N;'),
('learner', '1199', NULL, 'N;'),
('learner', '1200', NULL, 'N;'),
('learner', '1201', NULL, 'N;'),
('learner', '1202', NULL, 'N;'),
('learner', '1203', NULL, 'N;'),
('learner', '1204', NULL, 'N;'),
('learner', '1205', NULL, 'N;'),
('learner', '1206', NULL, 'N;'),
('learner', '1207', NULL, 'N;'),
('learner', '1208', NULL, 'N;'),
('learner', '1209', NULL, 'N;'),
('learner', '1210', NULL, 'N;'),
('learner', '1211', NULL, 'N;'),
('learner', '1212', NULL, 'N;'),
('learner', '1213', NULL, 'N;'),
('learner', '1214', NULL, 'N;'),
('learner', '1215', NULL, 'N;'),
('learner', '1216', NULL, 'N;'),
('learner', '1217', NULL, 'N;'),
('supervisor', '1211', NULL, 'N;'),
('supervisor', '1212', NULL, 'N;'),
('supervisor', '1213', NULL, 'N;'),
('supervisor', '1214', NULL, 'N;'),
('supervisor', '1215', NULL, 'N;'),
('supervisor', '1217', NULL, 'N;'),
('learner', '1218', NULL, 'N;'),
('learner', '1219', NULL, 'N;'),
('learner', '1220', NULL, 'N;'),
('learner', '1221', NULL, 'N;'),
('learner', '1222', NULL, 'N;'),
('learner', '1223', NULL, 'N;'),
('supervisor', '1221', NULL, 'N;'),
('supervisor', '1222', NULL, 'N;'),
('supervisor', '1223', NULL, 'N;'),
('learner', '1224', NULL, 'N;'),
('learner', '1225', NULL, 'N;'),
('learner', '1226', NULL, 'N;'),
('learner', '1227', NULL, 'N;'),
('learner', '1228', NULL, 'N;'),
('learner', '1229', NULL, 'N;'),
('learner', '1230', NULL, 'N;'),
('learner', '1231', NULL, 'N;'),
('learner', '1232', NULL, 'N;'),
('learner', '1233', NULL, 'N;'),
('learner', '1234', NULL, 'N;'),
('learner', '1235', NULL, 'N;'),
('learner', '1236', NULL, 'N;'),
('learner', '1237', NULL, 'N;'),
('learner', '1238', NULL, 'N;'),
('learner', '1239', NULL, 'N;'),
('learner', '1240', NULL, 'N;'),
('learner', '1241', NULL, 'N;'),
('learner', '1242', NULL, 'N;'),
('learner', '1243', NULL, 'N;'),
('learner', '1244', NULL, 'N;'),
('learner', '1245', NULL, 'N;'),
('learner', '1246', NULL, 'N;'),
('learner', '1247', NULL, 'N;'),
('learner', '1248', NULL, 'N;'),
('learner', '1249', NULL, 'N;'),
('learner', '1250', NULL, 'N;'),
('learner', '1251', NULL, 'N;'),
('learner', '1252', NULL, 'N;'),
('learner', '1253', NULL, 'N;'),
('learner', '1254', NULL, 'N;'),
('learner', '1255', NULL, 'N;'),
('learner', '1256', NULL, 'N;'),
('learner', '1257', NULL, 'N;'),
('learner', '1258', NULL, 'N;'),
('learner', '1259', NULL, 'N;'),
('learner', '1260', NULL, 'N;'),
('learner', '1261', NULL, 'N;'),
('learner', '1262', NULL, 'N;'),
('learner', '1263', NULL, 'N;'),
('learner', '1264', NULL, 'N;'),
('learner', '1265', NULL, 'N;'),
('learner', '1266', NULL, 'N;'),
('learner', '1267', NULL, 'N;'),
('learner', '1268', NULL, 'N;'),
('learner', '1269', NULL, 'N;'),
('supervisor', '1267', NULL, 'N;'),
('learner', '1270', NULL, 'N;'),
('learner', '1271', NULL, 'N;'),
('learner', '1272', NULL, 'N;'),
('learner', '1273', NULL, 'N;'),
('learner', '1274', NULL, 'N;'),
('learner', '1275', NULL, 'N;'),
('learner', '1276', NULL, 'N;'),
('learner', '1277', NULL, 'N;'),
('learner', '1278', NULL, 'N;'),
('learner', '1279', NULL, 'N;'),
('learner', '1280', NULL, 'N;'),
('learner', '1281', NULL, 'N;'),
('learner', '1282', NULL, 'N;'),
('learner', '1283', NULL, 'N;'),
('learner', '1284', NULL, 'N;'),
('learner', '1285', NULL, 'N;'),
('learner', '1286', NULL, 'N;'),
('learner', '1287', NULL, 'N;'),
('learner', '1288', NULL, 'N;'),
('learner', '1289', NULL, 'N;'),
('learner', '1290', NULL, 'N;'),
('learner', '1291', NULL, 'N;'),
('learner', '1292', NULL, 'N;'),
('learner', '1293', NULL, 'N;'),
('supervisor', '1293', NULL, 'N;'),
('learner', '1294', NULL, 'N;'),
('learner', '1295', NULL, 'N;'),
('learner', '1296', NULL, 'N;'),
('learner', '1297', NULL, 'N;'),
('learner', '1298', NULL, 'N;'),
('learner', '1299', NULL, 'N;'),
('learner', '1300', NULL, 'N;'),
('learner', '1301', NULL, 'N;'),
('supervisor', '1264', NULL, 'N;'),
('supervisor', '1218', NULL, 'N;'),
('learner', '1302', NULL, 'N;'),
('learner', '1303', NULL, 'N;'),
('learner', '1304', NULL, 'N;'),
('learner', '1305', NULL, 'N;'),
('learner', '1306', NULL, 'N;'),
('learner', '1307', NULL, 'N;'),
('learner', '1308', NULL, 'N;'),
('learner', '1309', NULL, 'N;'),
('learner', '1310', NULL, 'N;'),
('learner', '1311', NULL, 'N;'),
('learner', '1312', NULL, 'N;'),
('learner', '1313', NULL, 'N;'),
('learner', '1314', NULL, 'N;'),
('learner', '1315', NULL, 'N;'),
('learner', '1316', NULL, 'N;'),
('learner', '1317', NULL, 'N;'),
('learner', '1318', NULL, 'N;'),
('supervisor', '1320', NULL, 'N;'),
('learner', '1321', NULL, 'N;'),
('learner', '1322', NULL, 'N;'),
('supervisor', '1321', NULL, 'N;'),
('learner', '1323', NULL, 'N;'),
('learner', '1324', NULL, 'N;'),
('learner', '1325', NULL, 'N;'),
('learner', '1326', NULL, 'N;'),
('learner', '1327', NULL, 'N;'),
('learner', '1328', NULL, 'N;'),
('learner', '1329', NULL, 'N;'),
('learner', '1330', NULL, 'N;'),
('learner', '1331', NULL, 'N;'),
('learner', '1332', NULL, 'N;'),
('learner', '1333', NULL, 'N;'),
('supervisor', '1011', NULL, 'N;'),
('learner', '1334', NULL, 'N;'),
('learner', '1335', NULL, 'N;'),
('learner', '1336', NULL, 'N;'),
('learner', '1337', NULL, 'N;'),
('learner', '1338', NULL, 'N;'),
('learner', '1339', NULL, 'N;'),
('learner', '1340', NULL, 'N;'),
('learner', '1341', NULL, 'N;'),
('learner', '1342', NULL, 'N;'),
('supervisor', '1342', NULL, 'N;'),
('learner', '1343', NULL, 'N;'),
('learner', '1344', NULL, 'N;'),
('learner', '1345', NULL, 'N;'),
('learner', '1346', NULL, 'N;'),
('learner', '1347', NULL, 'N;'),
('learner', '1348', NULL, 'N;'),
('supervisor', '1349', NULL, 'N;'),
('supervisor', '1350', NULL, 'N;'),
('learner', '1351', NULL, 'N;'),
('learner', '1352', NULL, 'N;'),
('learner', '1353', NULL, 'N;'),
('learner', '1354', NULL, 'N;'),
('learner', '1355', NULL, 'N;'),
('learner', '1356', NULL, 'N;'),
('learner', '1357', NULL, 'N;'),
('learner', '1358', NULL, 'N;'),
('learner', '1359', NULL, 'N;'),
('learner', '1360', NULL, 'N;'),
('learner', '1361', NULL, 'N;'),
('learner', '1362', NULL, 'N;'),
('learner', '1363', NULL, 'N;'),
('learner', '1364', NULL, 'N;'),
('learner', '1365', NULL, 'N;'),
('learner', '1366', NULL, 'N;'),
('learner', '1367', NULL, 'N;'),
('learner', '1368', NULL, 'N;'),
('learner', '1369', NULL, 'N;'),
('learner', '1370', NULL, 'N;'),
('learner', '1371', NULL, 'N;'),
('learner', '1372', NULL, 'N;'),
('learner', '1373', NULL, 'N;'),
('learner', '1374', NULL, 'N;'),
('learner', '1375', NULL, 'N;'),
('learner', '1376', NULL, 'N;'),
('learner', '1377', NULL, 'N;'),
('learner', '1378', NULL, 'N;'),
('learner', '1379', NULL, 'N;'),
('learner', '1380', NULL, 'N;'),
('learner', '1381', NULL, 'N;'),
('learner', '1382', NULL, 'N;'),
('learner', '1383', NULL, 'N;'),
('learner', '1384', NULL, 'N;'),
('learner', '1385', NULL, 'N;'),
('learner', '1386', NULL, 'N;'),
('learner', '1387', NULL, 'N;'),
('learner', '1388', NULL, 'N;'),
('learner', '1389', NULL, 'N;'),
('learner', '1390', NULL, 'N;'),
('learner', '1391', NULL, 'N;'),
('learner', '1392', NULL, 'N;'),
('learner', '1393', NULL, 'N;'),
('learner', '1394', NULL, 'N;'),
('learner', '1395', NULL, 'N;'),
('learner', '1396', NULL, 'N;'),
('learner', '1397', NULL, 'N;'),
('learner', '1398', NULL, 'N;'),
('learner', '1399', NULL, 'N;'),
('learner', '1400', NULL, 'N;'),
('learner', '1401', NULL, 'N;'),
('learner', '1402', NULL, 'N;'),
('learner', '1403', NULL, 'N;'),
('learner', '1404', NULL, 'N;'),
('learner', '1405', NULL, 'N;'),
('learner', '1406', NULL, 'N;'),
('learner', '1407', NULL, 'N;'),
('learner', '1408', NULL, 'N;'),
('learner', '1409', NULL, 'N;'),
('learner', '1410', NULL, 'N;'),
('learner', '1411', NULL, 'N;'),
('learner', '1412', NULL, 'N;'),
('learner', '1413', NULL, 'N;'),
('learner', '1414', NULL, 'N;'),
('learner', '1417', NULL, 'N;'),
('learner', '1418', NULL, 'N;'),
('learner', '1419', NULL, 'N;'),
('learner', '1420', NULL, 'N;'),
('learner', '1421', NULL, 'N;'),
('learner', '1422', NULL, 'N;'),
('learner', '1423', NULL, 'N;'),
('learner', '1424', NULL, 'N;'),
('learner', '1425', NULL, 'N;'),
('learner', '1426', NULL, 'N;'),
('learner', '1427', NULL, 'N;'),
('learner', '1428', NULL, 'N;'),
('learner', '1429', NULL, 'N;'),
('learner', '1430', NULL, 'N;'),
('learner', '1431', NULL, 'N;'),
('learner', '1432', NULL, 'N;'),
('learner', '1433', NULL, 'N;'),
('learner', '1434', NULL, 'N;'),
('learner', '1435', NULL, 'N;'),
('learner', '1436', NULL, 'N;'),
('learner', '1437', NULL, 'N;'),
('learner', '1438', NULL, 'N;'),
('learner', '1439', NULL, 'N;'),
('learner', '1440', NULL, 'N;'),
('learner', '1441', NULL, 'N;'),
('learner', '1442', NULL, 'N;'),
('learner', '1443', NULL, 'N;'),
('learner', '1444', NULL, 'N;'),
('learner', '1445', NULL, 'N;'),
('learner', '1446', NULL, 'N;'),
('learner', '1447', NULL, 'N;'),
('learner', '1448', NULL, 'N;'),
('learner', '1449', NULL, 'N;'),
('learner', '1450', NULL, 'N;'),
('learner', '1451', NULL, 'N;'),
('learner', '1452', NULL, 'N;'),
('learner', '1453', NULL, 'N;'),
('learner', '1454', NULL, 'N;'),
('learner', '1455', NULL, 'N;'),
('learner', '1456', NULL, 'N;'),
('learner', '1457', NULL, 'N;'),
('learner', '1458', NULL, 'N;'),
('learner', '1459', NULL, 'N;'),
('learner', '1460', NULL, 'N;'),
('learner', '1461', NULL, 'N;'),
('learner', '1462', NULL, 'N;'),
('learner', '1463', NULL, 'N;'),
('learner', '1464', NULL, 'N;'),
('learner', '1465', NULL, 'N;'),
('learner', '1466', NULL, 'N;'),
('learner', '1467', NULL, 'N;'),
('learner', '1468', NULL, 'N;'),
('learner', '1469', NULL, 'N;'),
('learner', '1470', NULL, 'N;'),
('learner', '1471', NULL, 'N;'),
('learner', '1472', NULL, 'N;'),
('learner', '1473', NULL, 'N;'),
('learner', '1474', NULL, 'N;'),
('learner', '1475', NULL, 'N;'),
('learner', '1476', NULL, 'N;'),
('learner', '1477', NULL, 'N;'),
('learner', '1478', NULL, 'N;'),
('learner', '1479', NULL, 'N;'),
('learner', '1480', NULL, 'N;'),
('learner', '1481', NULL, 'N;'),
('learner', '1482', NULL, 'N;'),
('learner', '1483', NULL, 'N;'),
('learner', '1484', NULL, 'N;'),
('learner', '1485', NULL, 'N;'),
('learner', '1486', NULL, 'N;'),
('learner', '1487', NULL, 'N;'),
('learner', '1488', NULL, 'N;'),
('learner', '1489', NULL, 'N;'),
('learner', '1490', NULL, 'N;'),
('learner', '1491', NULL, 'N;'),
('learner', '1492', NULL, 'N;'),
('learner', '1493', NULL, 'N;'),
('learner', '1494', NULL, 'N;'),
('learner', '1495', NULL, 'N;'),
('learner', '1496', NULL, 'N;'),
('learner', '1497', NULL, 'N;'),
('learner', '1498', NULL, 'N;'),
('learner', '1499', NULL, 'N;'),
('learner', '1500', NULL, 'N;'),
('learner', '1501', NULL, 'N;'),
('learner', '1502', NULL, 'N;'),
('learner', '1503', NULL, 'N;'),
('learner', '1504', NULL, 'N;'),
('learner', '1505', NULL, 'N;'),
('learner', '1506', NULL, 'N;'),
('learner', '1507', NULL, 'N;'),
('learner', '1508', NULL, 'N;'),
('learner', '1509', NULL, 'N;'),
('learner', '1510', NULL, 'N;'),
('learner', '1511', NULL, 'N;'),
('learner', '1512', NULL, 'N;'),
('learner', '1513', NULL, 'N;'),
('learner', '1514', NULL, 'N;'),
('learner', '1515', NULL, 'N;'),
('learner', '1516', NULL, 'N;'),
('learner', '1517', NULL, 'N;'),
('learner', '1518', NULL, 'N;'),
('learner', '1519', NULL, 'N;'),
('learner', '1520', NULL, 'N;'),
('learner', '1521', NULL, 'N;'),
('learner', '1522', NULL, 'N;'),
('learner', '1523', NULL, 'N;'),
('learner', '1524', NULL, 'N;'),
('learner', '1525', NULL, 'N;'),
('learner', '1526', NULL, 'N;'),
('learner', '1527', NULL, 'N;'),
('learner', '1528', NULL, 'N;'),
('learner', '1529', NULL, 'N;'),
('learner', '1530', NULL, 'N;'),
('learner', '1531', NULL, 'N;'),
('learner', '1532', NULL, 'N;'),
('learner', '1533', NULL, 'N;'),
('learner', '1534', NULL, 'N;'),
('learner', '1535', NULL, 'N;'),
('learner', '1536', NULL, 'N;'),
('learner', '1537', NULL, 'N;'),
('learner', '1538', NULL, 'N;'),
('learner', '1539', NULL, 'N;'),
('learner', '1540', NULL, 'N;'),
('learner', '1541', NULL, 'N;'),
('learner', '1542', NULL, 'N;'),
('administrator', '1214', NULL, 'N;'),
('learner', '1543', NULL, 'N;'),
('learner', '1544', NULL, 'N;'),
('learner', '1545', NULL, 'N;'),
('learner', '1546', NULL, 'N;'),
('learner', '1547', NULL, 'N;'),
('learner', '1548', NULL, 'N;'),
('learner', '1549', NULL, 'N;'),
('learner', '1550', NULL, 'N;'),
('learner', '1551', NULL, 'N;'),
('learner', '1552', NULL, 'N;'),
('learner', '1553', NULL, 'N;'),
('learner', '1554', NULL, 'N;'),
('learner', '1555', NULL, 'N;'),
('learner', '1556', NULL, 'N;'),
('learner', '1557', NULL, 'N;'),
('learner', '1558', NULL, 'N;'),
('administrator', '3', NULL, 'N;'),
('supervisor', '3', NULL, 'N;'),
('learner', '3', NULL, 'N;'),
('learner', '1560', NULL, 'N;'),
('learner', '1561', NULL, 'N;'),
('learner', '1562', NULL, 'N;'),
('learner', '1563', NULL, 'N;'),
('learner', '1564', NULL, 'N;'),
('learner', '1565', NULL, 'N;'),
('learner', '1566', NULL, 'N;'),
('learner', '1567', NULL, 'N;'),
('learner', '1568', NULL, 'N;'),
('learner', '1569', NULL, 'N;'),
('learner', '1570', NULL, 'N;'),
('learner', '1571', NULL, 'N;'),
('learner', '1572', NULL, 'N;'),
('learner', '1573', NULL, 'N;'),
('learner', '1574', NULL, 'N;'),
('learner', '1575', NULL, 'N;'),
('learner', '1576', NULL, 'N;'),
('learner', '1577', NULL, 'N;'),
('learner', '1578', NULL, 'N;'),
('learner', '1579', NULL, 'N;'),
('learner', '1580', NULL, 'N;'),
('learner', '1581', NULL, 'N;'),
('learner', '1582', NULL, 'N;'),
('learner', '1583', NULL, 'N;'),
('learner', '1584', NULL, 'N;'),
('learner', '1585', NULL, 'N;'),
('learner', '1586', NULL, 'N;'),
('learner', '1587', NULL, 'N;'),
('learner', '1588', NULL, 'N;'),
('learner', '1589', NULL, 'N;'),
('learner', '1590', NULL, 'N;'),
('learner', '1591', NULL, 'N;'),
('learner', '1592', NULL, 'N;'),
('learner', '1593', NULL, 'N;'),
('learner', '1594', NULL, 'N;'),
('learner', '1595', NULL, 'N;'),
('learner', '1596', NULL, 'N;'),
('learner', '1597', NULL, 'N;'),
('learner', '1598', NULL, 'N;'),
('learner', '1599', NULL, 'N;'),
('learner', '1600', NULL, 'N;'),
('learner', '1601', NULL, 'N;'),
('learner', '1602', NULL, 'N;'),
('supervisor', '245', NULL, 'N;');
INSERT INTO `AuthAssignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('learner', '1603', NULL, 'N;'),
('learner', '1604', NULL, 'N;'),
('learner', '1605', NULL, 'N;'),
('learner', '1606', NULL, 'N;'),
('learner', '1607', NULL, 'N;'),
('learner', '1608', NULL, 'N;'),
('learner', '1609', NULL, 'N;'),
('learner', '1610', NULL, 'N;'),
('learner', '1611', NULL, 'N;'),
('learner', '1612', NULL, 'N;'),
('learner', '1613', NULL, 'N;'),
('learner', '1614', NULL, 'N;'),
('learner', '1615', NULL, 'N;'),
('learner', '1616', NULL, 'N;'),
('learner', '1617', NULL, 'N;'),
('learner', '1618', NULL, 'N;'),
('learner', '1619', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `AuthItem`
--

DROP TABLE IF EXISTS `AuthItem`;
CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `AuthItem`
--

INSERT INTO `AuthItem` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('administrator', 2, 'Administrator', NULL, 'N;'),
('supervisor', 2, 'Supervisor', NULL, 'N;'),
('learner', 2, 'Learner', NULL, 'N;'),
('test', 2, 'test', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `AuthItemChild`
--

DROP TABLE IF EXISTS `AuthItemChild`;
CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `AuthItemChild`
--


-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

DROP TABLE IF EXISTS `chapters`;
CREATE TABLE IF NOT EXISTS `chapters` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_time` datetime NOT NULL,
  `next_chapter_id` int(10) DEFAULT NULL,
  `first_subchapter_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `next_chapter_id` (`next_chapter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `chapters`
--


-- --------------------------------------------------------

--
-- Table structure for table `chapters_problems`
--

DROP TABLE IF EXISTS `chapters_problems`;
CREATE TABLE IF NOT EXISTS `chapters_problems` (
  `chapter_id` int(10) unsigned NOT NULL,
  `problem_id` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chapters_problems`
--


-- --------------------------------------------------------

--
-- Table structure for table `chapters_users`
--

DROP TABLE IF EXISTS `chapters_users`;
CREATE TABLE IF NOT EXISTS `chapters_users` (
  `chapter_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `finish_time` datetime DEFAULT NULL,
  `status` int(10) unsigned NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `chapters_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `clarifications`
--

DROP TABLE IF EXISTS `clarifications`;
CREATE TABLE IF NOT EXISTS `clarifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contest_id` int(10) unsigned NOT NULL,
  `problem_id` int(10) unsigned DEFAULT NULL,
  `questioner_id` int(11) unsigned NOT NULL,
  `questioned_time` datetime NOT NULL,
  `subject` text COLLATE latin1_general_ci NOT NULL,
  `question` text COLLATE latin1_general_ci NOT NULL,
  `answerer_id` int(11) unsigned DEFAULT NULL,
  `answered_time` datetime DEFAULT NULL,
  `answer` text COLLATE latin1_general_ci,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contest_id` (`contest_id`),
  KEY `questioner_id` (`questioner_id`),
  KEY `answerer_id` (`answerer_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `clarifications`
--


-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

DROP TABLE IF EXISTS `configurations`;
CREATE TABLE IF NOT EXISTS `configurations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `value` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `configurations`
--


-- --------------------------------------------------------

--
-- Table structure for table `contestnews`
--

DROP TABLE IF EXISTS `contestnews`;
CREATE TABLE IF NOT EXISTS `contestnews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) unsigned NOT NULL,
  `contest_id` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `contest_id` (`contest_id`),
  KEY `author_id_2` (`author_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `contestnews`
--


-- --------------------------------------------------------

--
-- Table structure for table `contests`
--

DROP TABLE IF EXISTS `contests`;
CREATE TABLE IF NOT EXISTS `contests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(10) unsigned NOT NULL,
  `name` text NOT NULL,
  `contest_type_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'open, closed, hidden',
  `invitation_type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `contests`
--

INSERT INTO `contests` (`id`, `owner_id`, `name`, `contest_type_id`, `description`, `start_time`, `end_time`, `status`, `invitation_type`) VALUES
(1, 1, 'Test', 1, 'Test', '2011-02-05 00:00:00', '2011-02-05 23:59:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `contests_problems`
--

DROP TABLE IF EXISTS `contests_problems`;
CREATE TABLE IF NOT EXISTS `contests_problems` (
  `contest_id` int(11) NOT NULL,
  `alias` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `timestamp` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`contest_id`,`problem_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contests_problems`
--

INSERT INTO `contests_problems` (`contest_id`, `alias`, `problem_id`, `timestamp`, `status`) VALUES
(1, 1, 1, '2011-02-05 11:51:39', 1);

-- --------------------------------------------------------

--
-- Table structure for table `contests_users`
--

DROP TABLE IF EXISTS `contests_users`;
CREATE TABLE IF NOT EXISTS `contests_users` (
  `contest_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `status` int(11) unsigned NOT NULL,
  `role` int(11) NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `last_page` text,
  PRIMARY KEY (`contest_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contests_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `contest_types`
--

DROP TABLE IF EXISTS `contest_types`;
CREATE TABLE IF NOT EXISTS `contest_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `contest_types`
--

INSERT INTO `contest_types` (`id`, `name`, `description`) VALUES
(1, 'ioi', 'Standard contest for International Olympiads in Informatics'),
(2, 'acmicpc', 'Standard contest for ACM ICPC');

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'administrator', 'Administrator'),
(2, 'supervisor', 'Supervisor'),
(3, 'learner', 'Learner'),
(6, 'test', 'test');

-- --------------------------------------------------------

--
-- Table structure for table `groups_users`
--

DROP TABLE IF EXISTS `groups_users`;
CREATE TABLE IF NOT EXISTS `groups_users` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`group_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups_users`
--

INSERT INTO `groups_users` (`group_id`, `user_id`) VALUES
(1, 1),
(1, 3),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(2, 1),
(2, 3),
(2, 5),
(2, 6),
(2, 7),
(2, 8),
(3, 1),
(3, 3),
(3, 4),
(3, 6),
(3, 7),
(3, 8);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

DROP TABLE IF EXISTS `logs`;
CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(128) DEFAULT NULL,
  `category` varchar(128) DEFAULT NULL,
  `logtime` int(11) DEFAULT NULL,
  `message` text,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `logs`
--


-- --------------------------------------------------------

--
-- Table structure for table `pastebin`
--

DROP TABLE IF EXISTS `pastebin`;
CREATE TABLE IF NOT EXISTS `pastebin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `pastebin`
--


-- --------------------------------------------------------

--
-- Table structure for table `privatemessages`
--

DROP TABLE IF EXISTS `privatemessages`;
CREATE TABLE IF NOT EXISTS `privatemessages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) unsigned NOT NULL,
  `send_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `subject` text NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Storing private messaging' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `privatemessages`
--


-- --------------------------------------------------------

--
-- Table structure for table `privatemessages_recipients`
--

DROP TABLE IF EXISTS `privatemessages_recipients`;
CREATE TABLE IF NOT EXISTS `privatemessages_recipients` (
  `privatemessage_id` int(10) unsigned NOT NULL,
  `recipient_id` int(10) unsigned NOT NULL,
  `unread` tinyint(1) NOT NULL,
  KEY `recipient_id` (`recipient_id`),
  KEY `private_message_id` (`privatemessage_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Storing private messaging recipients';

--
-- Dumping data for table `privatemessages_recipients`
--


-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

DROP TABLE IF EXISTS `problems`;
CREATE TABLE IF NOT EXISTS `problems` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  `comment` text NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `problem_type_id` int(10) unsigned NOT NULL,
  `description` text,
  `token` varchar(32) NOT NULL,
  `visibility` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `token` (`token`),
  KEY `author_id` (`author_id`),
  KEY `problem_type_id` (`problem_type_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Storing problems' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `problems`
--


-- --------------------------------------------------------

--
-- Table structure for table `problemsets`
--

DROP TABLE IF EXISTS `problemsets`;
CREATE TABLE IF NOT EXISTS `problemsets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `problemsets`
--


-- --------------------------------------------------------

--
-- Table structure for table `problemsets_problems`
--

DROP TABLE IF EXISTS `problemsets_problems`;
CREATE TABLE IF NOT EXISTS `problemsets_problems` (
  `problemset_id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`problemset_id`,`problem_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `problemsets_problems`
--


-- --------------------------------------------------------

--
-- Table structure for table `problem_types`
--

DROP TABLE IF EXISTS `problem_types`;
CREATE TABLE IF NOT EXISTS `problem_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Problem types' AUTO_INCREMENT=10 ;

--
-- Dumping data for table `problem_types`
--

INSERT INTO `problem_types` (`id`, `name`, `description`) VALUES
(1, 'simplebatch', 'Batch'),
(5, 'simpletext', 'Simple text'),
(6, 'reactive1', 'Reactive1'),
(7, 'batchacm', 'ACM Type'),
(8, 'batchioi', ''),
(9, 'archive', 'archive');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

DROP TABLE IF EXISTS `submissions`;
CREATE TABLE IF NOT EXISTS `submissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `submitter_id` int(10) unsigned NOT NULL,
  `contest_id` int(10) unsigned DEFAULT NULL,
  `chapter_id` int(10) unsigned DEFAULT NULL,
  `submitted_time` datetime NOT NULL,
  `submit_content` text NOT NULL,
  `grade_time` datetime DEFAULT NULL,
  `grade_content` text,
  `grade_output` longtext,
  `grade_status` int(11) DEFAULT NULL,
  `verdict` text,
  `score` float NOT NULL,
  `comment` text NOT NULL,
  `file` longblob,
  PRIMARY KEY (`id`),
  KEY `submitter_id` (`submitter_id`,`contest_id`),
  KEY `contest_id` (`contest_id`),
  KEY `submitted_time` (`submitted_time`),
  KEY `grade_status` (`grade_status`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `submissions`
--


-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

DROP TABLE IF EXISTS `trainings`;
CREATE TABLE IF NOT EXISTS `trainings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `created_time` datetime NOT NULL,
  `creator_id` int(10) unsigned NOT NULL,
  `first_chapter_id` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `first_chapter_id` (`first_chapter_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `trainings`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(127) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` char(50) NOT NULL,
  `type` int(11) NOT NULL DEFAULT '0',
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `last_ip` text,
  `full_name` tinytext NOT NULL,
  `join_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `site_url` tinytext,
  `institution` tinytext,
  `institution_address` tinytext,
  `institution_phone` tinytext,
  `address` tinytext NOT NULL,
  `postal_code` tinytext NOT NULL,
  `city` tinytext NOT NULL,
  `handphone` tinytext,
  `phone` tinytext,
  `active` tinyint(1) NOT NULL,
  `activation_code` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`),
  KEY `last_activity` (`last_activity`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1620 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `type`, `logins`, `last_login`, `last_activity`, `last_ip`, `full_name`, `join_time`, `site_url`, `institution`, `institution_address`, `institution_phone`, `address`, `postal_code`, `city`, `handphone`, `phone`, `active`, `activation_code`) VALUES
(1, 'admin@tokilearning.org', 'admin', 'dd94709528bb1c83d08f3088d4043f4742891f4f', 0, 442, '2011-02-06 12:09:17', '2011-02-06 12:09:20', '::1', 'Administrator', '2011-02-06 12:09:20', '', '', '', '', '', '', '', NULL, NULL, 1, '0lnCGe3ZIrXWjTvb81SKzXBCTIgLwr6r');
