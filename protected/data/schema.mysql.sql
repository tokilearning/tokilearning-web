-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 20, 2010 at 08:52
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `lc3`
--

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) unsigned NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` text NOT NULL,
  `content` text NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `announcements`
--

INSERT INTO `announcements` (`id`, `author_id`, `created_date`, `title`, `content`, `status`) VALUES
(1, 1, '2010-06-17 15:04:57', 'Test', 'Test', 1),
(2, 1, '2010-06-17 16:49:13', 'Test', 'Test', 1),
(3, 1, '2010-06-17 18:43:55', 'Test', 'Test', 0);

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

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
-- Table structure for table `authassignment`
--

CREATE TABLE IF NOT EXISTS `authassignment` (
  `itemname` varchar(64) NOT NULL,
  `userid` varchar(64) NOT NULL,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authassignment`
--


-- --------------------------------------------------------

--
-- Table structure for table `authitem`
--

CREATE TABLE IF NOT EXISTS `authitem` (
  `name` varchar(64) NOT NULL,
  `type` int(11) NOT NULL,
  `description` text,
  `bizrule` text,
  `data` text,
  PRIMARY KEY (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authitem`
--


-- --------------------------------------------------------

--
-- Table structure for table `authitemchild`
--

CREATE TABLE IF NOT EXISTS `authitemchild` (
  `parent` varchar(64) NOT NULL,
  `child` varchar(64) NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `authitemchild`
--


-- --------------------------------------------------------

--
-- Table structure for table `clarifications`
--

CREATE TABLE IF NOT EXISTS `clarifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contest_id` int(10) unsigned NOT NULL,
  `problem_id` int(10) unsigned DEFAULT NULL,
  `questioner_id` int(11) unsigned NOT NULL,
  `questioned_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `question_subject` text COLLATE latin1_general_ci NOT NULL,
  `question_content` text COLLATE latin1_general_ci NOT NULL,
  `answerer_id` int(11) unsigned DEFAULT NULL,
  `answered_time` timestamp NULL DEFAULT NULL,
  `answered_content` text COLLATE latin1_general_ci,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci AUTO_INCREMENT=1 ;

--
-- Dumping data for table `clarifications`
--


-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

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
-- Table structure for table `contests`
--

CREATE TABLE IF NOT EXISTS `contests` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(10) unsigned NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'open, closed, hidden',
  `invitation_type` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `contests`
--

INSERT INTO `contests` (`id`, `owner_id`, `name`, `description`, `start_time`, `end_time`, `status`, `invitation_type`) VALUES
(1, 1, 'Pelatnas 3 2010', 'Pelatnas 3 2010', '2010-06-19 21:40:17', '2010-06-22 00:00:00', 0, 0),
(2, 1, 'Pelatnas 1 2010', 'Pelatnas 1 2010', '2010-06-21 20:55:07', '2010-06-23 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `contests_problems`
--

CREATE TABLE IF NOT EXISTS `contests_problems` (
  `contest_id` int(11) NOT NULL,
  `alias` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `visibility` int(11) NOT NULL,
  PRIMARY KEY (`contest_id`,`problem_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contests_problems`
--


-- --------------------------------------------------------

--
-- Table structure for table `contests_users`
--

CREATE TABLE IF NOT EXISTS `contests_users` (
  `contest_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  KEY `contest_id` (`contest_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contests_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `privatemessages`
--

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

CREATE TABLE IF NOT EXISTS `problems` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  `comment` text NOT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
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

CREATE TABLE IF NOT EXISTS `problemsets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `name` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `problemsets`
--

INSERT INTO `problemsets` (`id`, `parent_id`, `status`, `created_date`, `name`, `description`) VALUES
(1, NULL, 1, '2010-06-18 22:52:30', 'Bundel Soal Perkenalan', ''),
(2, NULL, 1, '2010-06-18 22:52:49', 'Bundel Soal 2008', ''),
(3, NULL, 1, '2010-06-18 22:52:59', 'Bundel Soal 2009', ''),
(4, NULL, 1, '2010-06-18 22:53:10', 'Bundel Soal 2010', ''),
(5, 3, 1, '2010-06-18 22:55:48', 'Bundel Soal OSN 2009', ''),
(6, 2, 1, '2010-06-18 22:56:08', 'Bundel Soal OSN 2008', '');

-- --------------------------------------------------------

--
-- Table structure for table `problemsets_problems`
--

CREATE TABLE IF NOT EXISTS `problemsets_problems` (
  `problemset_id` int(11) NOT NULL,
  `problem_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  KEY `problemset_id` (`problemset_id`,`problem_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `problemsets_problems`
--


-- --------------------------------------------------------

--
-- Table structure for table `problem_types`
--

CREATE TABLE IF NOT EXISTS `problem_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 COMMENT='Problem types' AUTO_INCREMENT=1 ;

--
-- Dumping data for table `problem_types`
--


-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_name` (`name`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `roles`
--


-- --------------------------------------------------------

--
-- Table structure for table `roles_users`
--

CREATE TABLE IF NOT EXISTS `roles_users` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `fk_role_id` (`role_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Dumping data for table `roles_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE IF NOT EXISTS `submissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `submitter_id` int(10) unsigned NOT NULL,
  `contest_id` int(10) unsigned DEFAULT NULL,
  `submit_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `submit_content` text NOT NULL,
  `grade_time` timestamp NULL DEFAULT NULL,
  `grade_content` text,
  `grade_output` longtext NOT NULL,
  `grade_status` int(11) NOT NULL,
  `verdict` text NOT NULL,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `submitter_id` (`submitter_id`,`contest_id`),
  KEY `contest_id` (`contest_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `submissions`
--


-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(127) NOT NULL,
  `username` varchar(32) NOT NULL DEFAULT '',
  `password` char(50) NOT NULL,
  `logins` int(10) unsigned NOT NULL DEFAULT '0',
  `last_login` datetime NOT NULL,
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
  `activation_code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=321 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `logins`, `last_login`, `full_name`, `join_time`, `site_url`, `institution`, `institution_address`, `institution_phone`, `address`, `postal_code`, `city`, `handphone`, `phone`, `active`, `activation_code`) VALUES
(1, 'petra.barus@gmail.com', 'admin', 'd033e22ae348aeb5660fc2140aec35850c4da997', 0, '2010-06-20 10:29:42', 'Administrator', '2010-06-19 14:41:12', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 1, ''),
(2, 'me@van-odin.net', 'petra', 'caaa416c106f2c8ffc391c663fbe19e8cf53eb22', 0, '2010-06-20 10:57:26', 'Petra Novandi', '2010-06-19 14:59:02', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 1, ''),
(13, 'miliknya_ronny@yahoo.co.id', 'PJJS0915', '43a8d7dd4634aa46413f242ffffaec129a6ea0f060ffa449e9', 5, '0000-00-00 00:00:00', 'Gregorius Ronny Kaluge', '2009-07-22 19:23:31', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(14, 'brian@microbrainx.net', 'microbrain', '647766879781841028c18ed07e807bb75dea52825edbbed310', 59, '0000-00-00 00:00:00', 'Brian Marshal', '2010-01-16 13:56:06', NULL, 'TOKI Pusat', '', '', '', '', '', '', NULL, 0, ''),
(15, 'hallucinogenplus@yahoo.co.id', 'hallucinogen', '51d7cecb38e5a0b1b711398af23566980039f233f8cd38b156', 46, '0000-00-00 00:00:00', 'Listiarso Wastuargo', '2010-05-10 14:47:36', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(16, 'hanson.prihantoro@gmail.com', 'hpputro', 'd68ff4f637f3cb30701b1b11cdbf5b852e7c83cf2deb87644f', 2, '0000-00-00 00:00:00', 'Hanson Prihantoro', '2009-06-14 14:07:57', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(17, 'karoldanutama@gmail.com', 'karol', 'b9d6459d535cd790da1fef40f75c33590876ad6fcd3875568e', 133, '0000-00-00 00:00:00', 'Karol Danutama', '2010-03-19 01:24:10', NULL, 'ITB', 'Jalan Ganesha 10 Bandung', 'petra', '', '', '', '08179851878', NULL, 0, ''),
(18, 'lennie_2nd@yahoo.com', 'lennie_2nd', 'e261769a49cb41ba5b66223a01e98e0ab038a4f606a6ad6491', 32, '0000-00-00 00:00:00', 'Angelina Veni', '2010-02-07 19:56:12', NULL, '', '', '', '', '', '', '', NULL, 0, ''),
(19, 'fuad@gmail.com', 'fuad', '51fd6318689fc27ff6ec8eb6d48f469b5e5f5b9e96bea0de7d', 33, '0000-00-00 00:00:00', 'fuad', '2009-08-06 10:30:55', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(20, 'test1@test1.com', 'test1', 'cb75e612fd151a21adfa2c5fea94fae2e7f84110d7c693920e', 2, '0000-00-00 00:00:00', 'Test', '2009-09-04 13:56:16', NULL, '', '', '', '', '', '', '', NULL, 0, ''),
(21, 'tiok_cek@yahoo.co.id', 'tiok_cek', '0b36e89a9d16fe316ff9f9cdc594b1c8f751622d918863f783', 7, '0000-00-00 00:00:00', 'Yudi Umar', '2009-11-14 18:03:47', NULL, '', '', '', '', '', '', '', NULL, 0, ''),
(22, 'ptrrsn_1@yahoo.co.id', 'ptrrsn', '7dd0f12e0772277f017d4059b85c7e1c10a0c363a4692d5586', 103, '0000-00-00 00:00:00', 'Risan', '2009-11-27 10:56:12', NULL, '', '', '', '', '', '', '', NULL, 0, ''),
(23, 'hw_stosa@yahoo.com', 'OOSN09004', '4f64a7ab48be14ddfee0e996da9ea462f786e8c6326aca6a2a', 4, '0000-00-00 00:00:00', 'Harta Wijaya', '2009-08-06 14:36:39', NULL, 'SMA St Thomas 1 Medan', 'Jln. D.I.Panjaitan No. 103 Medan', '(061)4561116', '', '', '', NULL, NULL, 0, ''),
(24, 'dieend@rocketmail.com', 'dieend', '8f2aad6da724f4f576ac1944d6145f8003239cbac4e3e769c8', 58, '0000-00-00 00:00:00', 'Muhammad Adinata', '2009-11-16 16:22:53', NULL, 'STEI 09 ITB', 'Ganesha 10', 'dieend', '', '', '', '', NULL, 0, ''),
(25, 'inter.jetaimo@yahoo.com', 'PJJ09001', 'c6130b4e8d9b9666a68d5fbc6767f3e1a3301eb3c8ca9fbf59', 11, '0000-00-00 00:00:00', 'AKBAR JUANG SAPUTRA', '2009-07-28 19:38:49', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(26, 'christianusfrederick@yahoo.co.id', 'PJJ09002', 'dca08cf5511ffa8986a2ccadfe9667462d31ce99e67d6c3628', 5, '0000-00-00 00:00:00', 'CHRISTIANUS FREDERICK HOTAMA PUTRA', '2009-08-02 13:29:56', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(27, 'martinbanget@plasa.com', 'PJJ09003', 'f6e44678ce40df756d8111d09d94936937fb3ec5ec95b819fc', 23, '0000-00-00 00:00:00', 'BERTY CHRISMARTIN LT', '2009-08-22 17:43:58', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(28, 'lusimail@yahoo.com', 'PJJ09004', 'f3d5179090d15076cf87d11feecde562640652d2c6c8f912d7', 4, '0000-00-00 00:00:00', 'Lusia Kristiana', '2009-07-28 10:16:08', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(29, 'a_n_d_r_i_11_09@yahoo.co.id', 'PJJ09005', '9e65dead40ba01b756c088afa7bd54ba2f1d7e512e33b0e95c', 3, '0000-00-00 00:00:00', 'ANDRI RAHMAD WIJAYA', '2009-07-22 22:26:16', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(30, 'njputra@yahoo.com', 'PJJ09006', 'fbb21a5933578a3c2b364854c598c04a8f693715adac871035', 10, '0000-00-00 00:00:00', 'PRAMANA PANANJA P', '2009-08-04 15:45:42', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(31, 'fakhri_flark@yahoo.com', 'PJJ09007', '78d9c3cac97973fba99334bf9b31704d4d1c934d5d6d69f150', 0, '0000-00-00 00:00:00', 'FAKHRI', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(32, 'valentin_rae@hotmail.com', 'PJJ09008', '1b1138f3eda3c17aee4edc0a31e74b865b7a41832af705c371', 10, '0000-00-00 00:00:00', 'DANIEL ROLANDI', '2009-07-30 13:00:58', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(33, 'unique_boyz_92@hotmail.com', 'PJJ09009', 'fe0291d82e779ec5450a60d74fa6dc57697e70bc4efb6fd0f1', 13, '0000-00-00 00:00:00', 'ERICKO YAPUTRO', '2009-07-30 11:41:51', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(34, 'jl.foronereconstruction@gmail.com', 'PJJ09010', '6dcb891726e1be700cee24b6676c688f08e3018b5981130803', 12, '0000-00-00 00:00:00', 'DIMAS JALALUDDIN AHMAD', '2009-08-18 15:00:01', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(35, 'gyosh_wv@hotmail.com', 'PJJ09011', '7c19eb68dbae46be3552053b6ba5d5836edb0c446d5a6dc4bd', 37, '0000-00-00 00:00:00', 'WILLIAM GOZALI', '2009-09-26 11:12:16', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(36, 'beatrice.nathania@gmail.com', 'PJJ09012', 'ff88ab6349b6b26e3c32b5ab54f5fa75ccbf7ca1646dd011eb', 22, '0000-00-00 00:00:00', 'BEATRICE NATHANIA H', '2009-08-02 16:17:41', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(37, 'didi_fredy@yahoo.com', 'PJJ09013', '6ed22a63972700f7fdb35de02b76b787e464f71b513b285f4f', 6, '0000-00-00 00:00:00', 'FREDERIKUS HUDI', '2009-08-04 15:30:38', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(38, 'yoza1404@gmail.com', 'PJJ09014', '6877a89bb9556705f8ed183abff9fe2edb70224fb99d2dbcdd', 7, '0000-00-00 00:00:00', 'ADRIANUS YOZA A', '2009-08-04 15:33:02', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(39, 'anak_bungsu_oke@yahoo.com', 'PJJ09015', '11d6bd1bafa3b6990e4c2bd08585c92c0fe8219a966e8df1f7', 7, '0000-00-00 00:00:00', 'RANDY TRIANZIL TAN', '2009-08-01 20:09:47', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(40, 'supari92@yahoo.com', 'PJJ09016', '69c0d509b448486cac7cd10bd35a3a8774fc3e7083f63c371b', 25, '0000-00-00 00:00:00', 'SUPARI CANDI', '2009-08-01 19:43:45', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(41, 'eathu_g-up_mojo@hotmail.com', 'PJJ09017', '7181fd8bf0de962dcf1b65c8364c23769ac5d67c9b50a9211c', 5, '0000-00-00 00:00:00', 'GERALDI KARIM', '2009-07-30 14:27:36', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(42, 'david_andika17123@hotmail.com', 'PJJ09018', 'b75e791e4a061be10bf021ff15a318c2693dbe7f357ea2ee46', 13, '0000-00-00 00:00:00', 'DAVID ANDIKA', '2009-07-30 13:55:46', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(43, 'mibv_online@yahoo.com', 'PJJ09019', 'ce440b242228fc02301610b3722e70ba2e597c2beab5ce2ca4', 9, '0000-00-00 00:00:00', 'EDRICK RUDY PUTRA', '2009-07-31 12:07:18', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(44, 'brianlie1991@yahoo.co.id', 'PJJ09020', 'f7d7d8008687c45f153ad849434ad10d12aff479e82aab4195', 12, '0000-00-00 00:00:00', 'BRIAN LIE', '2009-10-15 05:44:14', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(45, 'js_blessing@yahoo.com', 'PJJ09021', '2299bd29c96ea8ba53487f61eb0045821c34e74217fbeb68f9', 0, '0000-00-00 00:00:00', 'JEFFRI SIMATUPANG', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(46, 'harunalfat@gmail.com', 'PJJ09022', '7fb89e19a59e935f920f0eb134b2f6b450945d26afa9130d43', 15, '0000-00-00 00:00:00', 'ALFAT SAPUTRA HARUN', '2009-08-01 15:15:23', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(47, 'tezuka_vito@hotmail.com', 'PJJ09023', 'f74f588c5c27f4ef4ac33f7866e2c3cf10334fb8ff2cea632f', 46, '0000-00-00 00:00:00', 'VILBERTO AUSTIN NOERJANTO', '2009-08-31 15:22:10', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(48, 'ivan_he_1419@yahoo.com', 'PJJ09024', '327b13383e51406430faa872d1f8cd4cb3c84d3669e7e6c816', 13, '0000-00-00 00:00:00', 'IVAN HENDRAJAYA', '2009-08-07 22:18:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(49, 'wachidx@yahoo.co.id', 'PJJ09025', 'a7868f7b137d244bb8ecbdca3d956a532360758d3ae5ae2db5', 0, '0000-00-00 00:00:00', 'MUHAMMAD WACHID KUSUMA', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(50, 'dummy7@van-odin.net', 'PJJ09026', '0a76ac4df9b465be6c01e0575045e9de189614cc91c04e0ace', 16, '0000-00-00 00:00:00', 'GERRY SATYANEGARA', '2009-08-02 23:05:42', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(51, 't_mackz@yahoo.com', 'PJJ09027', '2e167a764a4e4af55ec213b0678aedb5a01c9f46294e48ec4c', 21, '0000-00-00 00:00:00', 'TRACY FILBERT RIDWAN', '2009-08-09 18:35:06', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(52, 'febrian.12@gmail.com', 'PJJ09028', '7337028aa48cb6e5cda422f116a93e20b9ea596cf78a1b3325', 14, '0000-00-00 00:00:00', 'MUHAMMAD FEBRIAN RAMADHANA', '2009-10-10 14:53:42', NULL, 'SMA Presiden', 'Jl. Ki Hajar Dewantara, Cikarang Baru, Bekasi 17550', '(021)89109765', '', '', '', NULL, NULL, 0, ''),
(53, 'hellokitty092@gmail.com', 'PJJ09029', 'd4d241de7576c0801a3170d2b7dabf1c5930c9a23505a602f1', 10, '0000-00-00 00:00:00', 'SHARON LOH', '2009-08-04 15:45:06', NULL, 'Xaverius 1', '', '', '', '', '', NULL, NULL, 0, ''),
(54, 'ika_monz_92@yahoo.com', 'PJJ09030', 'c61a52d771f3032e76e3ce71b2c0e539b5244c1299ed32727c', 10, '0000-00-00 00:00:00', 'MARTHA MONICA', '2009-08-04 15:51:37', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(55, 'rdy_peace@yahoo.com', 'PJJ09031', '0c9f5c0409588aaae377ef95b1a89cf406a4230f698bfd778c', 9, '0000-00-00 00:00:00', 'RANDY WIJAYA', '2009-08-02 12:45:06', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(56, 'cyanneond@yahoo.com', 'PJJ09032', '6162c30d82826327d0cb64af2cdf64c8df500073e7561ef271', 4, '0000-00-00 00:00:00', 'RAMDAN IZZULMAKIN', '2009-08-04 21:00:28', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(57, 'dinamo_3n66412@yahoo.com', 'PJJ09033', 'b4b539cd0e8b3d680995913641affc9192be3c0193f58cb20a', 1, '0000-00-00 00:00:00', 'DINARA ENGGAR P', '2009-07-29 10:48:20', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(58, 'yafithekid212@gmail.com', 'PJJ09034', '1da4f6e2345c558766cb03a309a7e90079cd64c78d3625fb71', 11, '0000-00-00 00:00:00', 'MUHAMMAD YAFI', '2009-08-28 17:43:09', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(59, 'spearman_ao@yahoo.com', 'PJJ09035', '74e05ea9828f4addce833cfd69fc457ff81ba0ed1232dc90dc', 19, '0000-00-00 00:00:00', 'TAN HENRY JONATHAN T', '2009-08-05 14:18:14', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(60, 'i_am_joe_seph@hotmail.com', 'PJJ09036', 'c656abbca0162c91ac16894825cd39e5868474d91359a07c37', 16, '0000-00-00 00:00:00', 'YOZEF G TJANDRA', '2009-08-09 17:54:07', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(61, 'r14ndy_06@yahoo.co.id', 'PJJ09037', '96999c8a03449e454954389ffc9151a468e05113d90abd9fd7', 0, '0000-00-00 00:00:00', 'RIANDY', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(62, 'akasumodo@yahoo.co.id', 'PJJ09038', 'c69c41dd114e1b5c8814fca2487d259eb8d2a209ad729ab859', 1, '0000-00-00 00:00:00', 'AARON MASLIM', '2009-08-01 14:43:05', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(63, 'ente.dx@gmail.com', 'PJJ09039', 'da5d4e33c88f9af160bf6474530f81c5a6c948f7c73c1ac0aa', 5, '0000-00-00 00:00:00', 'NANDA P H TUMANGGER', '2009-08-20 15:20:59', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(64, 'ossieleona@yahoo.co.id', 'PJJ09040', 'd12af42b6b66c47a49b187e47028011859ab4a86b78140c76c', 2, '0000-00-00 00:00:00', 'OSSIE LEONA', '2009-07-28 20:00:26', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(65, 'darkykrad@yahoo.com', 'PJJ09041', '7771ad6ecee4d899db7e2fbcc03eb67f2a70115f2b873b05af', 10, '0000-00-00 00:00:00', 'ALFITO HARLIM', '2009-08-04 06:58:39', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(66, 'hafatih_27@yahoo.com', 'PJJ09042', 'e0b6dbd20cdd6f5e574e1c278c590ed0efa58cb99e3b6447c4', 12, '0000-00-00 00:00:00', 'HAFIDZ ALHAQ FATIH', '2009-08-11 07:31:15', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(67, 'anime.boyz@yahoo.com', 'PJJ09043', 'f26ab6033f9dd777641cad35d34fb94fd58addc0ef463faa21', 2, '0000-00-00 00:00:00', 'ERIC PRAKARSA PUTRA', '2009-07-24 18:11:09', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(68, 'arrosyidbh@gmail.com', 'PJJ09044', '20e5f53a149780695bf10856da81b0413a5568873029e471f8', 17, '0000-00-00 00:00:00', 'ABDURROSYID BROTO H', '2009-10-07 04:04:11', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(69, 'christianumboh@yahoo.com', 'PJJ09045', '366c529041cf911531dce2937463ad6729041c1a427419aa60', 4, '0000-00-00 00:00:00', 'CHRISTIAN UMBOH', '2009-08-02 07:32:58', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(70, 'tesa_giovani@yahoo.com', 'PJJ09046', '9e5fd7e65c8eacd9e6ccdeb206faa6b8f02734a89dabda5efc', 47, '0000-00-00 00:00:00', 'TESA GIOVANI S', '2009-09-01 12:48:41', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(71, 'leonardhalim888@yahoo.com', 'PJJ09047', '63077b5ad30656b013cba035f3a8e163dfd184e3fe970d493e', 4, '0000-00-00 00:00:00', 'LEONARD HALIM', '2009-08-02 13:20:06', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(72, 'loogicskage@gmail.com', 'PJJ09048', '542237a8ee0f3209f476d5f5c157ea59d37905f5f9ef23f350', 9, '0000-00-00 00:00:00', 'ANGGA HADITA', '2009-07-28 11:56:54', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(73, 'yodipramudito@yahoo.com', 'PJJ09049', 'ff605c8e7e37dc5f55a5a1574dc430343239048665701c983e', 0, '0000-00-00 00:00:00', 'YODI PRAMUDITO', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(74, 'restricted_person@yahoo.com', 'PJJ09050', 'f692cd08ead91ac4eb7726233eed5dfef71273cb07c8eb6156', 2, '0000-00-00 00:00:00', 'PASKASIUS W W', '2009-08-01 23:38:36', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(75, 'arief_xxx@rocketmail.com', 'PJJ09051', 'b59c278e9d30d727d869837b5a86c76a0a4cd4ac94859f6d74', 7, '0000-00-00 00:00:00', 'MAULANA SYARIF', '2009-07-30 15:33:32', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(76, 'sidocewok@yahoo.com', 'PJJ09052', '9c852f70c8e928ae8dd686a94e3b2dea82f9e810089ce5b78c', 0, '0000-00-00 00:00:00', 'ADRIAN CHRISTOPHER', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(77, 'a_tama92@yahoo.com', 'PJJ09053', '63330b0550e990b32b3df413bfb69a133e15b13320ba899216', 0, '0000-00-00 00:00:00', 'ARIF WIDYATAMA', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(78, 'choco_lato@yahoo.co.id', 'PJJ09054', '4e120ed551da4d68c02ac59f67214f1c94d0ee02c4ade02fdf', 1, '0000-00-00 00:00:00', 'SYAFIRA FITRI A', '2009-07-14 13:08:25', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(79, 'atnanahidiw@yahoo.com', 'PJJ09055', 'fd1f7816d3a0a7f9cd885d555bd9917c0b947750946563f191', 12, '0000-00-00 00:00:00', 'MIRZA WIDIHANANTA', '2009-08-03 09:48:16', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(80, 'frredrric@gmail.com', 'PJJ09056', '4d225b21db31536f80ef8ab27f2ea34e747ac33d47448e216e', 12, '0000-00-00 00:00:00', 'FREDRIC SANJAYA', '2009-08-03 08:00:01', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(81, 'innocent_lion_31793@yahoo.com', 'PJJ09057', '7d5c81a36df222b5023dc51ba4848156d47fdb9c0c5e608c0c', 2, '0000-00-00 00:00:00', 'CHRISSANDY FERNANDO', '2009-08-01 06:36:40', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(82, 'dummy2@van-odin.net', 'PJJ09058', '2c75ca8f4b49fecb869f3c6d3757c13575a8e382419fe8ce27', 0, '0000-00-00 00:00:00', 'ADRIKAL AZHIM', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(83, 'nanochip.08@gmail.com', 'PJJ09059', 'a0732b617257f197f04c664275f919f5fe7a47eda057506c88', 14, '0000-00-00 00:00:00', 'TAUFIK ISMAIL', '2009-08-09 00:19:08', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(84, 'gloryusloka@yahoo.co.id', 'PJJ09060', '93a82bafc83b11eda407486c9fab9d3d8804f40348cf9372ee', 0, '0000-00-00 00:00:00', 'KAREL G L P', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(85, 'fm_alvino_aj@yahoo.com', 'PJJ09061', 'df70a53508c6ee053b2a3220cadc2485b15f1e35349d62922b', 1, '0000-00-00 00:00:00', 'ALVINO AUGUSTINUS J', '2009-07-14 15:26:31', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(86, 'kpa.karisma@yahoo.com', 'PJJ09062', '845ab022b05ec804704e54e2614239e82fffc325f3c98d372e', 10, '0000-00-00 00:00:00', 'KARISMA PRATAMA', '2009-08-01 21:17:47', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(87, 'af_blitz@yahoo.co.id', 'PJJ09063', 'd0b5edb588886d2629375abb92c22d7137e28027fb65b5a3fa', 8, '0000-00-00 00:00:00', 'AHMAD FAHMI SHIDQI', '2009-07-30 15:39:00', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(88, 'congkevin@yahoo.com', 'PJJ09064', '52a0afd65b6624aa08c3ca94a6a3f72ee4caa0243f3f281514', 12, '0000-00-00 00:00:00', 'KEVIN CONG', '2009-08-26 20:28:53', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(89, 'beyond.the.syntax@gmail.com', 'PJJ09065', 'd7c6f641f2f17a2a7607b08c6c16e2291444f4f3b28add40c1', 3, '0000-00-00 00:00:00', 'ABDURRAHMAN SHOFY A', '2009-08-05 21:17:23', NULL, '', '', 'pjj09065', '', '', '', NULL, NULL, 0, ''),
(90, 'erwin_pokemon_fanz@yahoo.co.id', 'PJJ09066', '2b1db4f31adb80e359dd18a1c48dc90e53df49ae0d5063b75f', 0, '0000-00-00 00:00:00', 'ERWIN FERNANDEZ', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(91, 'azon04@gmail.com', 'PJJ09067', '39a5978659186a3250eaf75205390f88847d5bba7531714241', 3, '0000-00-00 00:00:00', 'AHMAD FAUZAN', '2009-07-30 11:26:50', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(92, 'mr.aladin03@gmail.com', 'PJJ09068', '9cd03b944fcd369a6cd177a7bb84658aaf279acfc47a113c61', 10, '0000-00-00 00:00:00', 'BENEDICTUS ARYA B', '2009-08-02 20:03:29', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(93, 'degastz@gmail.com', 'PJJ09069', '7d96ec208a22ceae90750da3dffb285200a306f8df0a93a13f', 1, '0000-00-00 00:00:00', 'HARTONO', '2009-07-15 10:40:34', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(94, 'wigas.ak@gmail.com', 'PJJ09070', '7f9474ff752e02d0e8c1b24d14562639f843246802d6ae4d2e', 14, '0000-00-00 00:00:00', 'WIGAS ANGGA KALIFI', '2010-03-19 13:14:15', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(95, 'caladbolg_student@hotmail.com', 'PJJ09071', '0a76ed9dc48a58fcc11dccd18c68aa6185f73221943036165a', 7, '0000-00-00 00:00:00', 'TEDDY BUDIONO', '2009-11-10 15:20:03', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(96, 'hadyjanuar@windowslive.com', 'PJJ09072', 'b2d812e1a80c34f12bdaab7eec3f65503db01ce55fba5dd7f9', 0, '0000-00-00 00:00:00', 'HADY JANUAR', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(97, 'seanmcrayz@yahoo.com', 'PJJ09073', 'aef1bc92d516fa6e20291e8001ae6f71907d46a128acaa97d2', 6, '0000-00-00 00:00:00', 'BAYU SURYADANA', '2009-08-31 06:56:43', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(98, 'kristianes_g3n1u5@yahoo.co.id', 'PJJ09074', 'bcf6ae95c4594b6cd3b78bb505a3093468dbd690522d72d699', 15, '0000-00-00 00:00:00', 'KRISTIANES', '2009-08-02 18:34:38', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(99, 'tedkesgar65536@gmail.com', 'PJJ09075', 'f9cc6451c28118a61a489698f536df960e26e180866b5ef6f0', 0, '0000-00-00 00:00:00', 'TITO D KESUMO S', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(100, 'dummy3@van-odin.net', 'PJJ09076', 'd0b7401ddd0e55a5b994693b1197882330f313dc2d8888ca02', 2, '0000-00-00 00:00:00', 'DANIEL AGUSTA', '2009-07-31 14:20:57', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(101, 'budiluhurd@gmail.com', 'PJJ09077', 'cb1981b246633082b64a1c6b732732d6628563479dcddd7e87', 2, '0000-00-00 00:00:00', 'BUDI LUHUR DARMANTO', '2009-07-31 16:52:55', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(102, 'aerodactyl@gmail.com', 'PJJ09078', 'd7bfefbb27e9aac7869cb8d1c05a2bfbe6938a5eb8be6d323b', 6, '0000-00-00 00:00:00', 'AGUNG UTAMA PUTRA', '2010-04-02 18:07:36', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(103, 'ges_cha@yahoo.co.id', 'PJJ09079', 'dc23046d740aa2785435a2d8538bfd8d73ff0b6600fe6279f3', 1, '0000-00-00 00:00:00', 'GESCA SONARITA', '2009-07-29 15:23:57', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(104, 'ludovicusfernandoginting@yahoo.com', 'PJJ09080', '458619e486f0d769175fa9f9a3f4e4e088c865184d79867db5', 4, '0000-00-00 00:00:00', 'LUDOVICUS FERNANDO GINTING', '2009-08-04 15:51:10', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(105, 'gilang_ynwa@yahoo.co.id', 'PJJ09081', '9f10a5a0e051c3e720a6289d2079c2b3eba853dde84ea98930', 0, '0000-00-00 00:00:00', 'GILANG ADI PRADHANA', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(106, 'wijaya_cynthia@yahoo.com', 'PJJ09082', 'e11c822855f127e4886902b7a60d241f834806469ca2caf461', 0, '0000-00-00 00:00:00', 'CYNTHIA EVELINA WIJAYA', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(107, 'dwicahyo_star95@yahoo.co.id', 'PJJ09083', 'fb8e29961054ef48f3be00c2eeaf5b176b2197d2e7dd9b7ece', 0, '0000-00-00 00:00:00', 'DWICAHYO H P H', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(108, 'thie.moneylover@gmail.com', 'PJJ09084', '089fa19d8210cd4765b3180ee6e881985ee1c2d341dc3094c9', 0, '0000-00-00 00:00:00', 'PUTRI AULIYA BARUS', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(109, 'chairajaalmas@yahoo.com', 'PJJ09085', '1bba2ef787749e21e5fba46ae5bbbbcebf738244e265378f80', 0, '0000-00-00 00:00:00', 'CHAIRAJA ALMAS DJENI', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(110, 'hindhra@yahoo.com', 'PJJ09086', '94f23c4b72c52025a24d130a31d3b65b4872a73f19872f7a7f', 5, '0000-00-00 00:00:00', 'I MADE PRAWIRA I', '2009-08-04 15:30:17', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(111, 'zandhiez@yahoo.co.id', 'PJJ09087', 'b978514686735e0741d0357fc74313c96b56b9ce57fb00ad34', 0, '0000-00-00 00:00:00', 'DIMAS IRSANDI P', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(112, 'afryandi_c@yahoo.com', 'PJJ09088', '4c40540d89cef754ba5d0aea845ebead46a2010625aeb5ee6b', 0, '0000-00-00 00:00:00', 'AFRYANDI CHRISTIANTO', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(113, 'masyfuq@gmail.com', 'PJJ09089', '5449dc822c3e4d88e3a5df67e16278911c29cda60a89e78c3a', 4, '0000-00-00 00:00:00', 'AHMAD MASYFUQ KASIM', '2009-08-01 15:15:53', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(114, 'dummy4@van-odin.net', 'PJJ09090', 'f82714963f3407b9d8bcf8808cc46233929d8e1e6edc89dfde', 0, '0000-00-00 00:00:00', 'FANDI PRADHANA', '2009-07-13 17:26:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(115, 'kapoex.randoe@gmail.com', 'PJJ09091', 'f94465f0e0be10dd1dbecd759a0a5478254643763f379fb036', 9, '0000-00-00 00:00:00', 'MEIRIYAN SUSANTO', '2010-02-12 13:24:31', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(116, 'babbycundawah@gmail.com', 'PJJ09092', 'd5cebf1043689e0f1eae35f6940c8602a38de4d9f2c3e84aa7', 1, '0000-00-00 00:00:00', 'ANDREAS B CUNDAWAN', '2009-07-17 21:57:15', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(117, 'eta0_ag50@yahoo.com', 'PJJ09093', 'b00c92ce5e2dc255688de9d081340cc693e1c5db16d6be48f8', 0, '0000-00-00 00:00:00', 'MAYORIKHO', '2009-07-13 17:26:23', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(118, 'jensdavion777@gmail.com', 'PJJ09094', '53aaad5d13f6c8d5b3a46d5eef7d1f341b6ab9f16b4e61fb4b', 2, '0000-00-00 00:00:00', 'JENS NAKI', '2009-07-26 11:27:25', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(119, 'buzzdelta@yahoo.com', 'PJJ09095', 'af20416c4de1d3e1184dad934ad68b6a1e9f4adcf2c33cad07', 3, '0000-00-00 00:00:00', 'YOSUA MARTHIN', '2009-08-19 05:37:04', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(120, 'dummy5@van-odin.net', 'PJJ09096', 'fa09a9c317f1eda33d3679b3d251079ead3ff70de34e5d8429', 0, '0000-00-00 00:00:00', 'QURBI RAMADHAN', '2009-07-13 17:26:23', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(121, 'recycledyouth@yahoo.com', 'PJJ09097', '9c5b68f48ca4bd8313b15be5e1bfcb2f4920e0aac6b72be229', 0, '0000-00-00 00:00:00', 'TOMMY ARYO PRATAMA', '2009-07-13 17:26:23', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(122, 'paschack@ymail.com', 'PJJ09098', '9fe2fd1410fd571492a20d321fbfee86d51aadc68540ca12ca', 4, '0000-00-00 00:00:00', 'DHARMA SAPUTRA', '2009-07-31 15:47:27', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(123, 'dummy6@van-odin.net', 'PJJ09099', 'c3beef62864189bb2e6a10f6b484bda652d50e7aa0df4320f8', 0, '0000-00-00 00:00:00', 'TALIM AHMAD', '2009-07-13 17:26:23', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(124, 'regeneration_unlimited@yahoo.com', 'PJJ09100', '305234d6e9c2099bc7510308d2a795a93083c16a02f408f759', 1, '0000-00-00 00:00:00', 'SORAYA RIZKA KEUMALA', '2009-07-22 19:54:55', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(125, 'xkautzar@yahoo.com', 'PJJ09101', '0c9773840dfcf0bd5d9ac3829ca3b04fd522639510ecd76ca8', 1, '0000-00-00 00:00:00', 'KALIKAUTSAR', '2009-07-16 23:05:17', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(126, 'g34rslank@gmail.com', 'PJJ09102', 'd1a393238fbedf3ea488323221d86f4687257425d339469138', 0, '0000-00-00 00:00:00', 'ALDY SYAHDEINI', '2009-07-13 17:26:23', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(127, 'patrick_04_06@yahoo.co.id', 'PJJ09103', '241306385d582691b98dbe02fc3c51dc1e12c7e6e5c83548c6', 1, '0000-00-00 00:00:00', 'PATRICIUS ONGGARA C', '2009-08-01 22:11:28', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(128, 'dadang_bbc@yahoo.co.id', 'PJJ09104', '29c8221579c47c707f09cc6b7187148e79f8479c6d0ee6b646', 2, '0000-00-00 00:00:00', 'DADANG ZULIAN', '2009-08-01 04:59:41', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(129, 'joe_pard8@ymail.com', 'PJJ09105', '3b0328a67131fbc66303765c15fe2cc020018abdde56fcff97', 7, '0000-00-00 00:00:00', 'MUHAMMAD JUNDI ADILA', '2009-08-05 20:24:01', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(130, 'sergio_lawalata@yahoo.com', 'PJJ09106', '64e143a52acae30ee3d89b31adbba7dcb475b00d6c98a39d60', 0, '0000-00-00 00:00:00', 'SERGIO MARPHY JUNAN LAWALATA', '2009-07-13 17:26:23', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(131, 'icm_cinta@yahoo.com', 'PJJ09107', 'b3f14d63b7a1e3c04c6aef2287463b6f47196e431f5cf52434', 1, '0000-00-00 00:00:00', 'IMAM ALI YODA', '2009-08-05 20:35:14', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(132, 'ana_nihonjin@yahoo.com', 'PJJ09108', '5da54ebc34945e2e3908e5ab4f3e0f19f17c735da2e4642675', 1, '0000-00-00 00:00:00', 'MUCHRIANA BURHAN', '2009-07-19 18:36:05', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(133, 'athrun_zala02@yahoo.com', 'PJJ09109', '3e00288f72a98dd562215fb7f5caf24c87a773f773d5d32b03', 0, '0000-00-00 00:00:00', 'MUH IKRAM N', '2009-07-13 17:26:23', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(134, 'wiwiensweet@ymail.com', 'PJJ09110', '32d9be7a80881ae769a22bc6906d89d09633c609eab5cf9e9e', 0, '0000-00-00 00:00:00', 'RADIYAH', '2009-07-13 17:26:23', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(135, 'dummy@microbrainx.net', 'PJJ09116', 'df2eac0e57cce811f1b0b2c5adf664bbefab71865f804ee9d9', 32, '0000-00-00 00:00:00', 'DUMMY USER 6', '2009-09-08 09:32:16', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(136, 'sutaid@gmail.com', 'sutaid', 'ab02182480ba35b00d63f4dca9b7f7a34c6c3f8b162b1ecf0f', 1, '0000-00-00 00:00:00', 'Adrikal Azhim', '2009-07-14 11:02:21', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(137, 'anto2004@walla.com', 'anto', '61c601b702f7dad32901a81f50c77e563f8202098238e1f92e', 2, '0000-00-00 00:00:00', 'anto tangahu', '2009-07-14 14:35:29', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(138, 'alex_fs777@yahoo.com', 'whateva', '4cb20b4832f0b36cc97153bd3555d35637736101c87cbc293c', 2, '0000-00-00 00:00:00', 'whateva', '2009-08-12 18:21:04', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(139, 'eta0_aq50@yahoo.com', 'Mayo', '84e55096a5ffbc982b4d0a9eb4e4de1f83fadcae52401eff34', 2, '0000-00-00 00:00:00', 'Mayorikho', '2009-07-16 16:13:34', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(140, 'tommyjo112@gmail.com', 'tommyjo', '89d7722743051327ad1c203e6357c92933c5d3307394779cd2', 1, '0000-00-00 00:00:00', 'Tommy', '2009-07-16 08:20:51', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(141, 'edwin_devil_angel@yahoo.com', 'edhmw', '3150927aa730a3ab6e079bb41c621187cc33408e81530ae683', 1, '0000-00-00 00:00:00', 'Made Edwin Wira Putra', '2009-07-16 11:54:31', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(142, 'roberto.ea@gmail.com', 'roberto', 'c1bb5d2e4df4441ecdd139b782e3948bc447f3fe983bd4832a', 4, '0000-00-00 00:00:00', 'Roberto Eliantono Adiseputra', '2009-08-05 13:36:17', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(143, 'afaji321@yahoo.com', 'PJJS0901', 'f57bc21da449ab81b7082eaa35d7f237768859305c82e01128', 1, '0000-00-00 00:00:00', 'Alham Fikri A', '2009-07-26 13:10:53', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(144, 'dynamicduoaero@gmail.com', 'OOSN09002', '58e17474fe3f0ab08097ddcf89833bda5c1c0b1de25c81f02e', 59, '0000-00-00 00:00:00', 'Bagus Seto W', '2009-08-24 14:44:54', NULL, 'Universitas Gadjah Mada', 'Perumahan Nogotirto 2 Jalan Sumatera D-41 Gamping Sleman Yogyakarta', '(0274) 620815', '', '', '', NULL, NULL, 0, ''),
(145, 'eko.wibowo87@gmail.com', 'PJJS0903', '957c9035cc511d88545dc8f0ca79db8f1bd06a0216583835a8', 1, '0000-00-00 00:00:00', 'Eko Wibowo', '2009-07-22 08:52:48', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(146, 'fushar@gmail.com', 'OOSN09018', 'a355d37f122ff54e75968d7d1f0eeaf4731379791f2bd8d6f5', 5, '0000-00-00 00:00:00', 'Ashar Fuadi', '2009-08-08 17:28:07', NULL, 'SMA Negeri 1 Bogor', 'Dramaga Pratama B4 Ciampea Kab. Bogor', '(025)18625590', '', '', '', NULL, NULL, 0, ''),
(147, 'hover4phoenix@yahoo.com', 'PJJS0905', '5e8143a2c85817856c72ec500a5b17a3075aa5c50346288472', 3, '0000-00-00 00:00:00', 'Timotius Chandra', '2009-07-28 13:43:49', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(148, 'rickyj.ray@gmail.com', 'PJJS0907', '6fc7031c877642ed10bd9a2f78b04d12826f25ca0f8b324759', 20, '0000-00-00 00:00:00', 'Ricky Jeremiah', '2009-08-03 22:02:42', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(149, 'riza_on@yahoo.com', 'PJJS0908', '81f9c7fc924a2a3a3499dee08ec612e2ac74f51fa08f35f00f', 21, '0000-00-00 00:00:00', 'Riza Oktavian', '2009-08-14 11:20:00', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(150, 'dwika.putra@gmail.com', 'OOSN09020', 'a4a0875b3bae453bd35a22b8d0e76ede50807acc71a2407afb', 2, '0000-00-00 00:00:00', 'Dwika Putra Hendrawan', '2009-08-05 11:26:46', NULL, 'La Trobe University, Melbourne', 'Jalan Kemenangan 3 / 30 RT 011 RW 003', '+61425365053', '', '', '', NULL, NULL, 0, ''),
(151, 'kavinyudhitia@gmail.com', 'PJJS0913', '7b1c9c19fcc1ba9db92c97bbf509b953e7f0f9667f420172bd', 0, '0000-00-00 00:00:00', 'Kavin Yudhitia', '2009-07-16 19:13:51', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(152, 'ryusuke2005@hotmail.com', 'PJJS0917', '676bde7d0df72315735f827089581a58c0bc02b46ec97c29c2', 1, '0000-00-00 00:00:00', 'Ryan Elian', '2009-10-31 13:43:43', NULL, '', '', '', '', '', '', '', NULL, 0, ''),
(153, 'xeno_thom@yahoo.com', 'PJJS0918', '75879a8e6d663a71a5cd2b972640f4465a29bcd6ba3884dd5e', 0, '0000-00-00 00:00:00', 'Thomas Hendy', '2009-07-17 13:11:27', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(154, 'deriantok@gmail.com', 'derianto', 'c4dcf6c79359a324e194cd819e1c7905bdc3c312effb9b93df', 2, '0000-00-00 00:00:00', 'Derianto', '2009-07-17 13:40:23', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(155, 'setiawan@cs.ui.ac.id', 'setiawan', '2014e2c70eb8b75514fea58b568c2b1813ca4107d08405c855', 3, '0000-00-00 00:00:00', '', '2009-07-17 18:35:43', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(156, 'julio_adisantoso@yahoo.com', 'julio_adisantoso', 'ebda52fcfe21aeb8ada3694c8ec4a9b4944439e7049bfcde80', 2, '0000-00-00 00:00:00', 'JULIO ADISANTOSO', '2009-07-18 10:24:13', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(157, 'jansonhendryli@gmail.com', 'PJJS0920', 'f8e9f37f3116835fafce5b490474f2fb5947b1baeee363b57b', 6, '0000-00-00 00:00:00', 'Janson Hendryli', '2009-08-10 16:57:44', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(158, 'martin_sekata@yahoo.com', 'tobing', '3101f6dff68fe27a5e63071e805acda6c67f8787eea273a159', 1, '0000-00-00 00:00:00', 'Berty Chrismartin Lumban Tobing', '2009-07-21 21:33:23', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(159, 'sementara@yahoo.co.id', 'Brian Lie', 'c9c9ed8cc766d4d7b937bdff16954a9232bfa6e585b312229f', 8, '0000-00-00 00:00:00', 'sementara', '2009-07-31 01:06:55', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(160, 'shawn.phate@yahoo.com', 'seanmcrayz', 'cc3a694d518cee6638cb4a46f9bf23105763f02ddd732e8c73', 5, '0000-00-00 00:00:00', 'Bayu Suryadana', '2009-07-30 11:46:43', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(161, 'kd_of_recursion@yahoo.com', 'test_learner', '5b8b288ebbe01e1b37a5d14c9f353801f4283ebd73c4921730', 9, '0000-00-00 00:00:00', 'Oldark', '2009-07-26 15:40:59', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(162, 'irwtan9@yahoo.com', 'OOSN09010', '76c96e2052a73c9f955b8414bec3c647bbad7c4edfa83e23b3', 4, '0000-00-00 00:00:00', 'Irawan Tanudirdjo, SM', '2009-08-06 14:50:58', NULL, 'Pembina Olimpiade Komputer SMAN 9 Manado', 'Jl. Merpati Ranomut Lingkungan 2 no 132 Manado', '(0431)865948', '', '', '', NULL, NULL, 0, ''),
(163, 'chezzmas@yahoo.com', 'Edy Tanto', '1606f3b0e38b34974d3992cb928b8eca045757f617d142b984', 1, '0000-00-00 00:00:00', 'Edy Tanto', '2009-07-23 10:19:38', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(164, 'test@a.com', 'test_coach', 'c20a7a803cafff26d312200d0c2f7dfe3c41822f539556a0a3', 1, '0000-00-00 00:00:00', 'test', '2009-07-23 13:42:15', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(165, 'kokosip07@yahoo.co.id', 'kokosip', 'fc4d9065fd848e9a05aea4d5af1babe2230d2d9ef6ffa4c910', 2, '0000-00-00 00:00:00', 'Witarko', '2009-07-23 20:31:07', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(166, 'ivy_averina@yahoo.com', 'ivy', 'f2655df3fe684bc55ae6db2b70e2d039d69ed4b85cf3cfdda8', 1, '0000-00-00 00:00:00', 'Ivy Averina', '2009-07-23 20:42:03', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(167, 'fdahlan@yahoo.co.id', 'fdahlan', 'b3ba95ca9c0ff96f614be8ebce2ce6b42bb9c6d3d12cd877bd', 1, '0000-00-00 00:00:00', 'Faisal Dahlan', '2009-07-23 23:12:39', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(168, 'tesagiovani@gmail.com', 'tesa', 'f21e6cfbc2bf2c7862e4efe47d79c4188ca3c2aaf58a1bdd08', 2, '0000-00-00 00:00:00', 'Tesa Giovani S.', '2009-07-24 09:05:43', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(169, 'leontius@gmail.com', 'leon', '8e2054ba210440a3d8889e5f3d2101c55fa5c6fb102b737a60', 8, '0000-00-00 00:00:00', 'Leontius Adhika Pradhana', '2009-07-28 23:10:51', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(170, 'egypt.pharaoh@yahoo.com', 'egypt.pharaoh', 'b6abddb66f047439fad6def1c26e794001807a17575e1d109d', 1, '0000-00-00 00:00:00', 'Arief Setiawan', '2009-07-25 09:00:50', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(171, 'chan_jogie@yahoo.com', 'jogie', 'd5a7aa9b04e2d98953bca30debaa4db90baf7f42bf9b0db9ea', 7, '0000-00-00 00:00:00', 'jogie chandra', '2009-07-31 16:11:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(172, 'wahyurismawan@gmail.com', 'OOSN09014', '05259608132403b62dead4574d3b514d6afd2695b99df3f907', 1, '0000-00-00 00:00:00', 'Wahyu Rismawan', '2009-08-04 17:08:45', NULL, 'SMAN 1 Tangerang', 'Perumahan Pondok Alam Permai, Jatiuwung, Tangerang', '(021)59311058', '', '', '', NULL, NULL, 0, ''),
(173, 'wahyurismawan@ymail.com', 'wahyurismawan', 'fe865cd0651202029ba27d935d0359f265010293a8a8edcf30', 11, '0000-00-00 00:00:00', 'Wahyu Rismawan', '2009-11-02 21:20:34', NULL, 'SMAN 1 Tangerang', '', '', '', '', '', '085718681804', NULL, 0, ''),
(174, 'hawkchips@yahoo.com', 'hawkchips', '51d88a75b8b44626d1c6ccb1b2e67b20993835e9e4978da703', 3, '0000-00-00 00:00:00', 'Azlan Indra', '2009-08-29 12:48:12', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(175, 'riandy@windowslive.com', 'riandy', '3be8485596595ce744a1553480c326ea793a7b6e9d5d8726aa', 1, '0000-00-00 00:00:00', 'Riandy', '2009-07-28 20:14:22', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(176, 'saya_seorang_kapiten@yahoo.com', 'paul', '391765c7c2b72d88a9ad80917c24e8770ac9cd636e20493fda', 2, '0000-00-00 00:00:00', 'john doe', '2009-07-29 08:51:40', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(177, 'brianlie_1991@yahoo.co.id', 'brianlie', 'a6788faf39f9061a082b58501ba561a181fa3f22b436352642', 1, '0000-00-00 00:00:00', 'Brian Lie', '2009-07-30 13:58:51', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(178, 'zulfikar.hakim@hotmail.com', 'zulfikar.hakim', '5b56340aafaea0027c75a328ba31b59fc3bf8016244feabb87', 1, '0000-00-00 00:00:00', 'Zulfikar Hakim', '2009-08-03 13:14:05', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(179, 'felikjunvianto@yahoo.co.id', 'OOSN09015', '5e7f7637609704541bf22b69f558afc93fdb9008cbbeed5794', 60, '0000-00-00 00:00:00', 'Felik Junvianto', '2009-12-17 17:22:23', NULL, 'SMAK PENABUR Gading Serpong', 'Jl. Kelapa Gading Barat Raya, Gading Serpong, Tangerang', '(021) 54205137', '', '', '', NULL, NULL, 0, ''),
(180, 'gunsnrose1@gmail.com', 'OOSN09003', 'a4ab2b10c1d0a80091231abc383592808ad43393db5e738b45', 5, '0000-00-00 00:00:00', 'galih putera nugraha', '2009-08-06 10:56:28', NULL, 'SMAN 1 Pati', 'Perumahan muria indah B/373 Kudus, Jateng', '(0291)440221', '', '', '', NULL, NULL, 0, ''),
(181, 'ilham@cs.uni-kl.de', 'ilham', 'c740b2cf28d9bc4225e9d63110ee7bd7fbe53f733067def3dc', 10, '0000-00-00 00:00:00', 'Ilham Kurnia', '2009-11-15 00:54:17', NULL, 'Institusi pribadi', 'Bukan di Indonesia', '+123456789', '', '', '', '', NULL, 0, ''),
(182, 'ardiankp@telkom.net', 'ilhamilham', '786fb8fbdbdb21b2df95411bcccb65c4c9036b3ee8f399607f', 1, '0000-00-00 00:00:00', 'Ilham Kurnia', '2009-08-03 22:01:30', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(183, 'tommy_tanzil@yahoo.com', 'OOSN09001', '83af5e44630be8983f21fd8e25cfec86aa79d0d4174b6389d9', 19, '0000-00-00 00:00:00', 'Tommy Tanzil', '2009-08-11 19:33:33', NULL, 'SMA Dian Harapan Makassar', 'Gunung Merapi No. 50 Makassar', '(0411)312641', '', '', '', NULL, NULL, 0, ''),
(184, 'wilbertliu@gmail.com', 'OOSN09009', '5de0cfb74a71fade60f0d5534f59048984e37c3ee917d4094f', 9, '0000-00-00 00:00:00', 'Wilbert', '2009-08-07 12:55:09', NULL, 'Universitas Kristen Duta Wacana', 'Jl. Solo Km 10.5 Perumahan Griya Permata Hijau B9, Yogyakarta', '(0274)497763', '', '', '', NULL, NULL, 0, ''),
(185, ' ryusuke2005@hotmail.com', 'OOSN09005', 'c758a7877ca690e83f34cec66a0510de93e9c7f98362074cde', 0, '0000-00-00 00:00:00', 'Ryan Elian', '2009-08-04 01:37:23', NULL, 'Institut Teknologi Bandung', 'Jl. Kembang Murni 1 Blok L4 / 10 Puri Indah. Jakarta Barat 11610', '(021)5810 834', '', '', '', NULL, NULL, 0, ''),
(186, 'darkstallion0153@yahoo.com', 'OOSN09006', '36e1f04763838cc610eb2eaeae32666b6e2a68547e58072668', 10, '0000-00-00 00:00:00', 'Kelvin Valensius', '2009-08-06 23:38:44', NULL, 'SMAK 1 BPK Penabur', 'Jln HOS Cokroaminoto 157', '(022)5406914', '', '', '', NULL, NULL, 0, ''),
(187, 'timspapua@gmail.com', 'OOSN09008', '85506a9a823854d5476b6bf0083e94c1b2ddd03b959f78c72b', 1, '0000-00-00 00:00:00', 'Timotius Sangian', '2009-08-06 10:26:58', NULL, 'UNIVERSITAS KRISTEN SATYA WACANA SALATIGA', 'Jalan Sawo Sari 17 Salatiga 50711', '(0967)593041', '', '', '', NULL, NULL, 0, ''),
(188, 'ilhamwk@gmail.com', 'cobalain', '8a398c9e196b22f0a35802857d9b71a52c37e7f2160bcfe8c9', 1, '0000-00-00 00:00:00', 'coba lain', '2009-08-04 02:34:04', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(189, 'wahyono_doank@yahoo.com', 'wahyo', '13d33db75d1873b4f447079bfb332fe8a1f08d71e6914386b5', 6, '0000-00-00 00:00:00', 'Wahyono', '2009-08-06 15:08:12', NULL, 'UGM', 'Yogya', '', '', '', '', NULL, NULL, 0, ''),
(190, 'beno_rohman@hotmail.com', 'OOSN09012', '3bbfbfca32fce859eade77ed49f18fd56f8a65701c0cbc5164', 2, '0000-00-00 00:00:00', 'Beno Pinantau R', '2009-08-06 10:56:25', NULL, 'SMA N 1 PATI', 'DS TAMBAKROMO RT 2 RW 2 KAB. PATI', '085747757041', '', '', '', NULL, NULL, 0, ''),
(191, 'l3ed0e_paresxxi@yahoo.co.id', 'OOSN09013', '6410b2345640eece1a215f2faa79311cd6481df9717199d83d', 3, '0000-00-00 00:00:00', 'BAHRUL HALIMI', '2009-08-07 08:55:48', NULL, 'SMA N 1 PATI', 'ALAN KAPTEN YUSUF NO 1 WEDARIJAKSA, PATI', '(0295)393171', '', '', '', NULL, NULL, 0, ''),
(192, 'felix.halim@gmail.com', 'felix_halim', 'f0cdad9129feb67dafd0836505f1421a80b959fec1e4f83990', 1, '0000-00-00 00:00:00', 'Felix Halim', '2009-08-04 16:33:31', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(193, 'herdiansyah.eka@ui.edu', 'OOSN09017', '169a712f0664cf818f9dde69aa2bb96508134479ddc4e73415', 14, '0000-00-00 00:00:00', 'Herdiansyah Eka Putra', '2009-08-06 10:54:57', NULL, 'UI', 'Jl. Cempaka Putih Barat no. 19 Jakarta Pusat', '(021)7773333', '', '', '', NULL, NULL, 0, ''),
(194, 'budianto_1989@yahoo.co.id', 'OOSN09016', '4d8e3e05c4525a1d0aca8a5e700f62ef43b3e8a358cee70ca4', 0, '0000-00-00 00:00:00', 'Budianto', '2009-08-04 21:22:57', NULL, 'Universitas Indonesia', 'Jl. Duri Utara No 7', '(021)6301803', '', '', '', NULL, NULL, 0, ''),
(195, 'b0b_ch3m1st@live.com', 'OOSN09019', '7540207aa1b66847c87698d4f599ea7f37fc0f97df9d6d8e15', 8, '0000-00-00 00:00:00', 'Robertus Hudi', '2009-08-09 21:17:14', NULL, 'Universitas Pelita Harapan', 'Jl. Gn.Lingga Ia no.13', '0361-420945', '', '', '', NULL, NULL, 0, ''),
(196, 'felikjunvianto@hotmail.com', 'Felik Junvianto', '1f4517d0b4fddff62e454e9f30506bc588d0d688e362384af0', 3, '0000-00-00 00:00:00', 'Felik Junvianto', '2009-08-05 00:31:53', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(197, 'hallucinogenplus@gmail.com', 'dewadewi', '1c8a6568c217c351398ea66acb013c84c43dc139a4e1a1dabd', 7, '0000-00-00 00:00:00', 'Sakurako Tenmaku', '2009-08-06 14:36:11', NULL, 'ITB', 'Bandung', '', '', '', '', NULL, NULL, 0, ''),
(198, 'salvianreynaldi@gmail.com', 'OOSN09021', '4abed40f1b9f65cd36fbffe7ac0e6f61c5d11c643fdbac07ea', 17, '0000-00-00 00:00:00', 'Salvian Reynaldi', '2009-08-11 19:31:10', NULL, 'SMAK 1 BPK PENABUR BANDUNG', 'Jalan HOS Tjokroaminoto No 157 Bandung', '(022)5208981', '', '', '', NULL, NULL, 0, ''),
(199, 'nahtanoj_rebla@hotmail.com', 'OOSN09022', 'b9de63777ba90a48b120e90c5ff8236ee15fc040181a90178e', 21, '0000-00-00 00:00:00', 'Bojan Hart Lane', '2009-08-06 14:03:55', NULL, '(0411)447815', 'Adhyaksa Baru No. 46F', 'SMA Dian Harapan Makassar', '', '', '', NULL, NULL, 0, ''),
(200, 'iisnanr@gmail.com', 'OOSN09023', '7ab89c8a02c4bfa5403aad44cc767bb8d8d7612a6ed34ca84d', 2, '0000-00-00 00:00:00', 'Isna Noor Rakhmawati', '2009-08-06 09:37:45', NULL, 'SMAN 1 Pati', 'Karangmalang RT 04 /02 Gebog Kudus', '(0291) 434894', '', '', '', NULL, NULL, 0, ''),
(201, 'oscar.km@ui.ac.id', 'OOSN09024', 'e8a9500f232b7a7ae122b12e4ead11ae7833dd055bb0f7fa51', 3, '0000-00-00 00:00:00', 'Oscar Kurniawan Manule', '2009-08-06 09:29:38', NULL, 'UI', 'Jl. Pisang 114 Depok Utara Depok', '(021)7773333', '', '', '', NULL, NULL, 0, ''),
(202, 'ramacyber@gmail.com', 'OOSN09025', '99dc70e54a9431a32af0b91b42dd2677fc330582440f361a76', 1, '0000-00-00 00:00:00', 'Afief Yona Ramadhana', '2009-08-05 12:46:56', NULL, 'Kurikulum dan teknologi Pendidikan. Universitas Pendidikan Indonesia', 'Jl. Gegerarum Baru No.4 Isola Bandung', '085718394569', '', '', '', NULL, NULL, 0, ''),
(203, 'g_p22xx@yahoo.com', 'OOSN09026', '6f86842e9811e1dbed6b4aaf3d870bbd0b6d62548dada221f8', 4, '0000-00-00 00:00:00', 'IB Prawira Janottama, KN.', '2009-08-12 22:10:31', NULL, 'SMA Negeri 4 Denpasar', 'Jl. Patih Nambi VI/10 Ubung, Denpasar', '0361424475', '', '', '', NULL, NULL, 0, ''),
(204, 'rizky.syaiful@gmail.com', 'RizkySyaiful', 'fca727bd144899f5d0ccc6ca71030762d619547e5494aab69c', 1, '0000-00-00 00:00:00', 'Rizky Syaiful', '2009-08-05 20:34:55', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(205, 'cyberdwan@gmail.com', 'OOSN09027', '2bc644b7160da93bdd2d81b7300da6e4104d213e42146a79ae', 1, '0000-00-00 00:00:00', 'Danny Aguswahyudi', '2009-08-06 11:16:02', NULL, 'SMAN 4 Denpasar', 'Jalan Tunjung Sari, Gg, Menuri No 21', '03618444056', '', '', '', NULL, NULL, 0, ''),
(206, 'purnadi_winarno@yahoo.com', 'OOSN09028', '93e66b7b573574a96a004964fa19b6ae5474744af81d02f2ca', 1, '0000-00-00 00:00:00', 'Purnadi Winarno', '2009-08-06 10:25:39', NULL, 'UI', 'Desa raci RT=04 RW=V Pati, Jawa Tengah', '085717080114', '', '', '', NULL, NULL, 0, ''),
(207, 'adam.pahlevi@gmail.com', 'saveav', 'ee022359ae252cdba126ea5b6b00de89a0dbfcdc3199cabe46', 8, '0000-00-00 00:00:00', 'Adam Pahlevi', '2009-08-10 07:49:30', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(208, 'saveav@gmail.com', 'sinclair', 'f6829fe6435359a7ee4e50014eeae7e535d2b871e6f632e378', 4, '0000-00-00 00:00:00', 'Sinclair Xhalte', '2009-08-07 06:35:17', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(209, 'sulton@rocketmail.com', 'round robin', '22139820c85d6eedeee15aa86ebafdf2d6b29120d9b0623010', 2, '0000-00-00 00:00:00', 'Moh. Sulton Hasanuddin', '2009-08-07 14:35:37', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(210, 'aerodactyl6@gmail.com', 'penguin_ag', '99eae708e074bc2fe29f310c9488294209aa5a972fc5a33d70', 1, '0000-00-00 00:00:00', 'Agung Utama P', '2009-08-07 23:27:48', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(211, 'janson@jansonhendryli.net', 'jansonh', 'f16744c345b27c3401056dabfc89d3871e354b7bb6a129e621', 1, '0000-00-00 00:00:00', 'Janson Hendryli', '2009-08-10 16:57:22', NULL, 'Universitas Tarumanagara', 'Jln. Letjen S. Parman No.01 Jakarta Barat', '', '', '', '', NULL, NULL, 0, ''),
(212, 'dominikus.d.putranto@gmail.com', 'dominikus', '9659d55951f5cc90121f5a532dd48a6078feb56e9f0e52d2e0', 3, '0000-00-00 00:00:00', 'Dominikus D Putranto', '2010-04-30 20:26:18', NULL, 'Institut Teknologi Bandung', 'Jalan Ganesha 10', '', '', '', '', NULL, NULL, 0, ''),
(213, 'cyanneon@gmail.com', 'bergoyang', 'cce42acb528bf99fb1d1fe21a752135bdc4a73b9c7e9e6515f', 1, '0000-00-00 00:00:00', 'Muhammad Ramdan Izzulmakin', '2009-08-16 19:03:18', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(214, 'West.blizzardian@msn.com', 'Buzzdelta', '7c2ef772e8351486e421e54d31d6fdd8f385370318d3062caa', 1, '0000-00-00 00:00:00', 'Yosua Marthin', '2009-08-19 05:34:16', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(215, 'mrjtriton@gmail.com', 'mrjtriton', 'd4f4233828026b3c7ab92fc234bb61352b64fbdb7393c9e4d1', 1, '0000-00-00 00:00:00', 'Badrut Tamam Hikmawan Fauzi', '2009-08-20 17:43:19', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(216, 'niasih.kurniasih4@gmail.com', 'Niotzz', '162048b2bba163734d7c4e236c7531946636b030319bf49493', 1, '0000-00-00 00:00:00', 'Nafiah Kurniasih', '2009-08-21 12:07:06', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(217, 'ginan_raimei@yahoo.com', 'ginan', 'db95a485971acb03800e0b5c51dcdc3803cf72501cd33aca50', 1, '0000-00-00 00:00:00', 'Ginan', '2009-08-28 09:59:06', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(218, 'rully@is.its.ac.id', 'rully', 'e7e895789c080fba7019d5ca25ed47e32273093ff2b6d47f78', 1, '0000-00-00 00:00:00', 'Rully Soelaiman', '2009-09-01 12:38:43', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(219, 'PP109001@toki.if.itb.ac.id', 'PP109001', 'c1e5ad4cdc48d3d60738c295b614abc8f86d17db6b65cf975d', 0, '0000-00-00 00:00:00', 'DANIEL ROLANDI', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '081318176394', NULL, 0, ''),
(220, 'PP109002@toki.if.itb.ac.id', 'PP109002', '1918698a5b7914115f466029af0682e7971d74cd180141eea9', 0, '0000-00-00 00:00:00', 'EDRICK RUDY PUTRA', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '08568881993', NULL, 0, ''),
(221, 'PP109003@toki.if.itb.ac.id', 'PP109003', 'd83b3e12ecc010d5f83d2a87f04c77e66ed906c4c9f21f80af', 0, '0000-00-00 00:00:00', 'YOZEF G TJANDRA', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '081804597377', NULL, 0, ''),
(222, 'PP109004@toki.if.itb.ac.id', 'PP109004', '90e0fb35c1545a3dec1a3cc529c088a5c5089312e009cfddc5', 0, '0000-00-00 00:00:00', 'LUSIA KRISTIANA', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '081513103329', NULL, 0, ''),
(223, 'PP109005@toki.if.itb.ac.id', 'PP109005', '24d28b4c45f5b523067377f44be6970ac0c0f99ff1e5433828', 0, '0000-00-00 00:00:00', 'ABDURROSYID BROTO H', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085640417887', NULL, 0, ''),
(224, 'PP109006@toki.if.itb.ac.id', 'PP109006', '47edf895ec83db11f08d05dbe16d1c5ef42131ccbffbaf2c2d', 0, '0000-00-00 00:00:00', 'FREDRIC SANJAYA', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085266632999', NULL, 0, ''),
(225, 'PP109007@toki.if.itb.ac.id', 'PP109007', '5d09e6e19a7ba88256bbc78234bda3c1c21225f8525fbeaac3', 0, '0000-00-00 00:00:00', 'ALFITO HARLIM', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085299990835', NULL, 0, ''),
(226, 'PP109008@toki.if.itb.ac.id', 'PP109008', '811f85627e841f04d17a24983507f8161681f87469ea741046', 0, '0000-00-00 00:00:00', 'AHMAD FAHMI SHIDQI', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085655174020', NULL, 0, ''),
(227, 'PP109009@toki.if.itb.ac.id', 'PP109009', 'c17a1409b618a6d2af9cedc99a92c8d24d0ee84792b60fb6e4', 0, '0000-00-00 00:00:00', 'MIRZA WIDIHANANTA', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085729119022', NULL, 0, '');
INSERT INTO `users` (`id`, `email`, `username`, `password`, `logins`, `last_login`, `full_name`, `join_time`, `site_url`, `institution`, `institution_address`, `institution_phone`, `address`, `postal_code`, `city`, `handphone`, `phone`, `active`, `activation_code`) VALUES
(228, 'PP109010@toki.if.itb.ac.id', 'PP109010', '0245867ed00ef79531bb2f184bf00b7ff64470ac4ff6869dc2', 0, '0000-00-00 00:00:00', 'TEDDY BUDIONO HERMAWAN', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '08126072607', NULL, 0, ''),
(229, 'PP109011@toki.if.itb.ac.id', 'PP109011', 'a0bd4c66d0627b2430f04c455117a565a88a0b0d6f6b2f10f5', 0, '0000-00-00 00:00:00', 'GERALDI KARIM', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '081807359377', NULL, 0, ''),
(230, 'PP109012@toki.if.itb.ac.id', 'PP109012', 'd13c6dc8652ad37ca990e759d1b5a008e7485fe4f2b1c06270', 0, '0000-00-00 00:00:00', 'FAKHRI', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '08127505945', NULL, 0, ''),
(231, 'PP109013@toki.if.itb.ac.id', 'PP109013', '1a86bcb42a33b95d731432f03c32a1b55c04147669104e2a93', 0, '0000-00-00 00:00:00', 'FREDERIKUS HUDI', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '08563766714', NULL, 0, ''),
(232, 'PP109014@toki.if.itb.ac.id', 'PP109014', '080a29d419cb9c7e4c20514f81d7457bf2d73fd568e9581f7d', 0, '0000-00-00 00:00:00', 'AARON MASLIM', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '', NULL, 0, ''),
(233, 'PP109015@toki.if.itb.ac.id', 'PP109015', '21b7bf2c88dd17eb5829f4f6de22ab5f60eb4860d15c12dd3d', 0, '0000-00-00 00:00:00', 'WILLIAM GOZALI', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '081807479392', NULL, 0, ''),
(234, 'PP109016@toki.if.itb.ac.id', 'PP109016', '94e44221058d95a906f75088c62b879dc805cc688a89322440', 0, '0000-00-00 00:00:00', 'DINARA ENGGAR PRABAKTI', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085643322148', NULL, 0, ''),
(235, 'PP109017@toki.if.itb.ac.id', 'PP109017', '10aaa9f370bc85dd67edede0d45ef8ad02ecf357fbb42eb542', 0, '0000-00-00 00:00:00', 'MUHAMMAD YAFI', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085729592442', NULL, 0, ''),
(236, 'PP109018@toki.if.itb.ac.id', 'PP109018', '4b186b416effb8a2fe7e158c1daea192cd6976f33fa618151f', 0, '0000-00-00 00:00:00', 'TITO D KESUMO SIREGAR', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '', NULL, 0, ''),
(237, 'PP109019@toki.if.itb.ac.id', 'PP109019', '39f3898373bf43a65f7bd1a22d7dba3ef407f8506620883514', 0, '0000-00-00 00:00:00', 'ADRIAN CHRISTOPHER', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085648405403', NULL, 0, ''),
(238, 'PP109020@toki.if.itb.ac.id', 'PP109020', '792c696d55cb4d26bb476ddfc247ff9f6a77e8f8715fe09351', 0, '0000-00-00 00:00:00', 'TRACY FILBERT RIDWAN', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '08179060200', NULL, 0, ''),
(239, 'PP109021@toki.if.itb.ac.id', 'PP109021', '04ff8ade9dae65877b9d7a52a738f0ab103ff99d4881644783', 0, '0000-00-00 00:00:00', 'PRAMANA PANANJA PUTRA', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085726011116', NULL, 0, ''),
(240, 'PP109022@toki.if.itb.ac.id', 'PP109022', '80052e3bd51964544c13a15ef139deebfd9b64b4f7a3dcd03a', 0, '0000-00-00 00:00:00', 'ABDURRAHMAN SHOFY A', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '', NULL, 0, ''),
(241, 'PP109023@toki.if.itb.ac.id', 'PP109023', '691e6a9d287e3cdcdf304f29f0a4e8b40461ae0c2fa8bc282f', 0, '0000-00-00 00:00:00', 'ERICKO YAPUTRO', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '081807788992', NULL, 0, ''),
(242, 'PP109024@toki.if.itb.ac.id', 'PP109024', '3b91520e37e89f4c2a664f720af296794ace297a02ecebb6f2', 0, '0000-00-00 00:00:00', 'PASKASIUS WAHYU WIBISONO', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085743718406', NULL, 0, ''),
(243, 'PP109025@toki.if.itb.ac.id', 'PP109025', '8aba97d3840494729ac98a4a3af0ff2705a464b2f331556242', 0, '0000-00-00 00:00:00', 'MUHAMMAD FEBRIAN RAMADHANA', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '08388064261', NULL, 0, ''),
(244, 'PP109026@toki.if.itb.ac.id', 'PP109026', '0674833251e100db473ebf5d97969bc1c3c90cf0b087b74bee', 0, '0000-00-00 00:00:00', 'DANIEL AGUSTA', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085664202020', NULL, 0, ''),
(245, 'PP109027@toki.if.itb.ac.id', 'PP109027', '8a07c9dd03695756b01dc9ebcd9340f8fa977fff47f9dbc9d5', 0, '0000-00-00 00:00:00', 'BERTY CHRISMARTIN LUMBAN TOBING', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085697132368', NULL, 0, ''),
(246, 'PP109028@toki.if.itb.ac.id', 'PP109028', 'a3b85775c23c925d6183c4167ba963b2ff9bcd950f8e102ce8', 0, '0000-00-00 00:00:00', 'VILBERTO AUSTIN NOERJANTO', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '08179928428', NULL, 0, ''),
(247, 'PP109029@toki.if.itb.ac.id', 'PP109029', '5e2df6c28e47ca5acdd61a4bf3ae87627772bf24cada472fd7', 0, '0000-00-00 00:00:00', 'KEVIN CONG', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085275264105', NULL, 0, ''),
(248, 'PP109030@toki.if.itb.ac.id', 'PP109030', 'b27da2d022ed93720dbccd59e539e7d1f55c73fc7035534537', 0, '0000-00-00 00:00:00', 'MARTHA MONICA', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085266574500', NULL, 0, ''),
(249, 'PP109031@toki.if.itb.ac.id', 'PP109031', '6834dc8e76534d89bc9a78ee029347c0a26dbb7199681821c2', 0, '0000-00-00 00:00:00', 'EDWIN HUTOMO', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '08561488963', NULL, 0, ''),
(250, 'PP109032@toki.if.itb.ac.id', 'PP109032', 'c4bfa1b98be30c22a95b6dd12c6f03e08b62f2eec3e7d27e00', 0, '0000-00-00 00:00:00', 'ARIEF SETIAWAN', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '081803060333', NULL, 0, ''),
(251, 'PP109033@toki.if.itb.ac.id', 'PP109033', '9894812d2a080fc1ce4a4cf27b30f187b2dee5e8b873758fb5', 0, '0000-00-00 00:00:00', 'REINHART ABDIEL HERMANUS', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '', NULL, 0, ''),
(252, 'PP109034@toki.if.itb.ac.id', 'PP109034', '9ef9d80a18813dfad1fdbe73246b1ef746f6c4ad67408441bb', 0, '0000-00-00 00:00:00', 'TOMMY TANZIL', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085656270052', NULL, 0, ''),
(253, 'PP109035@toki.if.itb.ac.id', 'PP109035', '95ab2008bbb6bd79d4c07b1f28327a0f7fd4094725bee761f7', 0, '0000-00-00 00:00:00', 'ELLENSI REY CHANDRA', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '08568930888', NULL, 0, ''),
(254, 'PP109036@toki.if.itb.ac.id', 'PP109036', '7d99ca9dafbd22727963bc476269b2dc25895e720abebc47eb', 0, '0000-00-00 00:00:00', 'JORDAN FERNANDO', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085664387055', NULL, 0, ''),
(255, 'PP109037@toki.if.itb.ac.id', 'PP109037', '299b9daa298cc4aaa37982d1e47d78e1ce1b49935df41c0876', 0, '0000-00-00 00:00:00', 'ALFAT SAPUTRA HARUN', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '085657292812', NULL, 0, ''),
(256, 'PP109038@toki.if.itb.ac.id', 'PP109038', '0c8b397b986d1cf48de4c3cbac4731ac12e4f249559aa9998d', 0, '0000-00-00 00:00:00', 'TJIA KENNARD WICOADY', '2009-09-04 13:55:29', NULL, NULL, NULL, NULL, '', '', '', '081343939398', NULL, 0, ''),
(257, 'halo2@a.com', 'halo2', '16d4831906e9922e03e27b0e9b863aa26c9c99f4e15939daf9', 0, '0000-00-00 00:00:00', 'halo', '2009-09-14 09:41:56', NULL, '', '', '', '', '', '', NULL, NULL, 0, ''),
(258, 'squhart@gmail.com', 'squhart', 'd9dd3213cda500808f9b5261316347f79d0e25176dcc87cfd9', 1, '0000-00-00 00:00:00', 'muhamad salman', '2009-10-24 18:03:17', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(259, 'sbycrosz@yahoo.com', 'sambya', 'd2fdcc51dd531447c5fb600fa2b66a191598ad703f673430e7', 162, '0000-00-00 00:00:00', 'Sambya Aryasa', '2009-12-18 01:52:44', NULL, 'STEI ITB', 'Ganesha 10', 'sambya', '', '', '', '', NULL, 0, ''),
(260, 'PJJ10100@toki.if.itb.ac.id', 'PJJ10100', '66ed4e1fd784f4e74a2fddfb9a9557989f49663a72dcd92cb5', 67, '0000-00-00 00:00:00', 'Risan', '2009-11-27 15:08:48', NULL, 'Institut Teknologi Bandung', '', '', '', '', '', '', NULL, 0, ''),
(261, 'PJJ10101@lc.toki.if.itb.ac.id', 'PJJ10101', 'b74776992fe17e9014ee8ab9b4023ce2891fcf13d30701e499', 19, '0000-00-00 00:00:00', 'Daniel Rolandi', '2009-12-15 18:37:14', NULL, 'SMAK1 Penabur Jakarta', 'Jalan Tanjung Duren Raya Nomor 4 Jakarta Barat', '021-5666962', '', '', '', '+6281318176394', NULL, 0, ''),
(262, 'PJJ10102@toki.if.itb.ac.id', 'PJJ10102', '037d1fb1147ed6b606b370870b36c8242f9528dc4d2af43bbd', 43, '0000-00-00 00:00:00', 'Edrick Rudy Putra', '2010-02-16 17:44:41', NULL, 'SMAK IPEKA Tomang', 'Green Ville Blok D', '565 6034', '', '', '', '08568881993', NULL, 0, ''),
(263, 'PJJ10103@toki.if.itb.ac.id', 'PJJ10103', '67c58f942a3761182578c58f1b3d87c5008a885ecead37e4a3', 33, '0000-00-00 00:00:00', 'Yozef Giovanni Tjandra', '2010-01-16 15:54:44', NULL, 'SMA Regina Pacis Solo', 'Jln Adi Sucipto 45 Solo', '', '', '', '', '081804597377', NULL, 0, ''),
(264, 'PJJ10104@toki.if.itb.ac.id', 'PJJ10104', '4d208a19c2a4ad3dc1aeb709c0e57ec0f0b9fb4a9e6a0dc761', 26, '0000-00-00 00:00:00', 'Lusia Kristiana', '2009-11-21 23:22:39', NULL, 'SMAK Penabur Gading Serpong', 'Jl. Kelapa Gading Raya Barat', '021-54205137', '', '', '', '085693679765', NULL, 0, ''),
(265, 'PJJ10105@toki.if.itb.ac.id', 'PJJ10105', 'f6f9439adc631d04fdf1406ef686448c6fa546acf08b2ab899', 26, '0000-00-00 00:00:00', 'Abdurrosyid BH', '2009-12-18 18:42:08', NULL, 'SMAN 3 Semarang', 'Jl. Pemuda no.149', '081901272226', '', '', '', '081901272226', NULL, 0, ''),
(266, 'PJJ10106@toki.if.itb.ac.id', 'PJJ10106', '092b53e961f675ad3cfc1ab5d6ad414c11d54904c298243e55', 26, '0000-00-00 00:00:00', 'FREDRIC SANJAYA', '2009-11-20 13:28:21', NULL, 'SMA Xaverius 1 Jambi', 'Jalan Abdurahman Saleh 19', '0741574210', '', '', '', '085266632999', NULL, 0, ''),
(267, 'PJJ10107@toki.if.itb.ac.id', 'PJJ10107', '3861aff844263c950c90692e491ea008c6de221346309f0769', 45, '0000-00-00 00:00:00', 'ALFITO HARLIM', '2009-12-27 15:24:31', NULL, '', '', 'PJJ10107', '', '', '', '085299990835', NULL, 0, ''),
(268, 'PJJ10108@toki.if.itb.ac.id', 'PJJ10108', '98fbff35f03199fa097458f44c1b70956652ce1a0586c4c1db', 26, '0000-00-00 00:00:00', 'Ahmad Fahmi Shidqi', '2009-11-27 14:25:08', NULL, 'SMA Semesta', '', '', '', '', '', '+6285655174020', NULL, 0, ''),
(269, 'PJJ10109@toki.if.itb.ac.id', 'PJJ10109', '5200f5e7783dd89e6c4d6ba21b3ff52ec13fe46ff5627de510', 39, '0000-00-00 00:00:00', 'Mirza Widihananta', '2009-11-16 21:05:04', NULL, 'SMA N 3 Yogyakarta', 'Jalan Yos Sudarso 7 Yogyakarta', '', '', '', '', '085729119022', NULL, 0, ''),
(270, 'PJJ10110@toki.if.itb.ac.id', 'PJJ10110', '171b825376d1bfe952ad3a9e407b1e0f972ee20b69e8a0b455', 36, '0000-00-00 00:00:00', 'Teddy Budiono Hermawan', '2010-01-14 23:11:01', NULL, '', '', '', '', '', '', '08126072607', NULL, 0, ''),
(271, 'PJJ10111@toki.if.itb.ac.id', 'PJJ10111', 'cbfb956bc66df23cea70f6ed9ef8168096fa5219feaa34469e', 5, '0000-00-00 00:00:00', 'Dummy User', '2009-11-11 13:45:01', NULL, '', '', '', '', '', '', '', NULL, 0, ''),
(272, 'PJJ10112@toki.if.itb.ac.id', 'PJJ10112', '84da695bf26d4ddc8573eb19874b773f8e3546429b0c88a269', 18, '0000-00-00 00:00:00', 'Fakhri', '2009-11-14 08:38:12', NULL, '', '', '', '', '', '', '081365727975', NULL, 0, ''),
(273, 'PJJ10113@toki.if.itb.ac.id', 'PJJ10113', '564568a311fd2a886067438cb916b0c43cde6d7dcd25f50ad9', 25, '0000-00-00 00:00:00', 'Frederikus Hudi', '2009-11-15 20:54:39', NULL, 'SMAN 4 Denpasar', 'Jl. Gn. Rinjani, monang-maning', '', '', '', '', '08563766714', NULL, 0, ''),
(274, 'PJJ10114@toki.if.itb.ac.id', 'PJJ10114', '864075420d979804140018e739a6937b14ebb4fa8ca8cd123b', 19, '0000-00-00 00:00:00', 'Aaron Maslim', '2009-11-14 13:05:31', NULL, 'SMAS SUTOMO 1', 'Jl. Letkol Martinus Lubis no.7', '', '', '', '', '', NULL, 0, ''),
(275, 'PJJ10115@toki.if.itb.ac.id', 'PJJ10115', '88f9c6706383959a86e6793a7de0d1f4749c626e37e2bc0386', 21, '0000-00-00 00:00:00', 'William Gozali', '2009-12-24 17:01:51', NULL, '', '', '', '', '', '', '081807479392', NULL, 0, ''),
(276, 'PJJ10116@toki.if.itb.ac.id', 'PJJ10116', 'c6f5f5296180e99ea1f659f764c62262970ae0568fe5296cac', 20, '0000-00-00 00:00:00', 'Dinara Enggar Prabakti        (ディナラ)', '2009-11-14 08:35:46', NULL, '', '', '', '', '', '', '', NULL, 0, ''),
(277, 'PJJ10117@toki.if.itb.ac.id', 'PJJ10117', '0e75a8edd6e9d117c23a5cf760e3ad88f48130c4a57de96089', 26, '0000-00-00 00:00:00', 'Muhammad Yafi', '2009-11-22 18:50:17', NULL, 'SMAN 1 Yogyakarta', 'Jl. HOS Cokroaminoto 10', '', '', '', '', '085729592442', NULL, 0, ''),
(278, 'PJJ10118@toki.if.itb.ac.id', 'PJJ10118', 'daba55c570c7033988a056f100d8b482141fa9ce1b48eb77bf', 20, '0000-00-00 00:00:00', 'Tito D. Kesumo Siregar', '2009-11-14 08:37:49', NULL, 'SMAN Plus Provinsi Riau', 'Jl. Lingkar Kubang Raya Komp. SMAN Plus Riau', '', '', '', '', '081365381942', NULL, 0, ''),
(279, 'PJJ10119@toki.if.itb.ac.id', 'PJJ10119', '4664bafce8c1dc77172b05c5b885aca5deba0ebf174c2a7434', 17, '0000-00-00 00:00:00', 'Michael Jackson', '2009-11-14 09:46:27', NULL, '', '', 'PJJ10132', '', '', '', '', NULL, 0, ''),
(280, 'PJJ10120@toki.if.itb.ac.id', 'PJJ10120', 'aaf6aae62879d6d8faa67403cffa03e1ed5d12f48067e4617a', 23, '0000-00-00 00:00:00', 'tracy filbert ridwan', '2010-02-19 22:38:10', NULL, '', '', '', '', '', '', '08179060200', NULL, 0, ''),
(281, 'PJJ10121@toki.if.itb.ac.id', 'PJJ10121', '8869a344653b35534de7a43125833505590ea51eea382d0a99', 25, '0000-00-00 00:00:00', 'Pramana Pananja', '2009-11-25 21:42:03', NULL, 'SMA Taruna Nusantara', 'Jl. Raya Purworejo Km. 5 Magelang', 'PJJ10121', '', '', '', '085726011116', NULL, 0, ''),
(282, 'PJJ10122@toki.if.itb.ac.id', 'PJJ10122', '4261012cc27f34fbd43fb728855954f68ed02796abd2d90d6e', 29, '0000-00-00 00:00:00', 'Abdurrahman Shofy Adianto', '2009-11-15 08:04:45', NULL, 'HK Programmer Guild', 'PonPes Husnul Khotimah Ds. Maniskidul - Jalaksana - Jawa Barat 45554', '0232613808', '', '', '', '', NULL, 0, ''),
(283, 'PJJ10123@toki.if.itb.ac.id', 'PJJ10123', '4816395910abc7f59967ba9d27eea60adadd35308b8a962092', 21, '0000-00-00 00:00:00', 'Ericko Yaputro', '2009-11-14 08:40:13', NULL, 'SMAK IPEKA Sunter', 'Jalan Baru Sunter Agung', '', '', '', '', '081807788992', NULL, 0, ''),
(284, 'PJJ10124@toki.if.itb.ac.id', 'PJJ10124', '029abf46000bb883cc51bce5d7fec722282f11052f760654a9', 20, '0000-00-00 00:00:00', 'Paskasius Wahyu Wibisono', '2009-11-16 21:35:19', NULL, 'SMA N 1 Yogyakarta', 'Jl. HOS Cokroaminoto 10, Wirobrajan, Yogyakarta 55252', '', '', '', '', '085743718406', NULL, 0, ''),
(285, 'PJJ10125@toki.if.itb.ac.id', 'PJJ10125', 'd52fb5084e536eac68349a73ef8392063fac25cd79f035e229', 39, '0000-00-00 00:00:00', 'Muhammad Febrian Ramadhana', '2010-01-08 14:20:33', NULL, 'SMA Presiden', 'Jl. Ki Hajar Dewamtara, Kota Jababeka, Cikarang Baru, Bekasi 17550', '(021) 89109765', '', '', '', '08388064761', NULL, 0, ''),
(286, 'PJJ10126@toki.if.itb.ac.id', 'PJJ10126', 'b144e83b749e535170f3c4af1c02ffd00e04e697d9c1afefe2', 25, '0000-00-00 00:00:00', 'daniel agusta', '2009-11-17 18:31:57', NULL, '', '', '', '', '', '', '', NULL, 0, ''),
(287, 'PJJ10127@toki.if.itb.ac.id', 'PJJ10127', '5c1abfd9eea074a33ab63c0845a1f02178684eb8df0ad977ba', 34, '0000-00-00 00:00:00', 'Berty Chrismartin Lumban Tobing', '2010-01-16 15:07:00', NULL, '', '', '', '', '', '', '', NULL, 0, ''),
(288, 'PJJ10128@toki.if.itb.ac.id', 'PJJ10128', '4bec96c1d1c8d34478d6ecc7247e4ed441b27f99220c38e58c', 38, '0000-00-00 00:00:00', 'Vilberto Austin Noerjanto', '2009-11-17 17:20:24', NULL, 'SMAK IPEKA International Jakarta', 'Taman Meruya Ilir Blok K', '(021) 5890 5890', '', '', '', '08179928428', NULL, 0, ''),
(289, 'PJJ10129@toki.if.itb.ac.id', 'PJJ10129', 'ec28999e3708e74bc68a7b059155a4118e068061132b2baf64', 27, '0000-00-00 00:00:00', 'Martha Monica', '2009-11-18 21:04:17', NULL, 'SMA Xaverius 1 Jambi', 'Jl.Marsda Abddurahman Saleh No.19 Jambi', '0741-572410', '', '', '', '085266574500', NULL, 0, ''),
(290, 'PJJ10130@toki.if.itb.ac.id', 'PJJ10130', 'f4901c49b28228cd917d4f65eaef750473290ffdbb992b7b51', 47, '0000-00-00 00:00:00', 'Arief Setiawan', '2010-01-15 21:51:12', NULL, 'SMAK St. Louis 1 Surabaya', 'Jalan Polisi Istimewa 7', '', '', '', '', '081803060333', NULL, 0, ''),
(291, 'PJJ10131@toki.if.itb.ac.id', 'PJJ10131', '66bb70d21554d54dc4db9ca1c1d48e12a38eaf868b546984fc', 24, '0000-00-00 00:00:00', 'Jordan Fernando', '2009-11-17 14:29:27', NULL, 'SMA Xaverius 1 Jambi', 'Jalan Abdurahman Saleh 19', '0741574210', '', '', '', '085664387055', NULL, 0, ''),
(292, 'PJJ10132@toki.if.itb.ac.id', 'PJJ10132', 'c7ce0cd9f59ec1f95edee1b089ba467a44618ac98fdbf92e38', 92, '0000-00-00 00:00:00', 'Réinhãrd Âþdiél Hérmãnús™', '2010-01-16 14:17:47', NULL, '', '', 'PJJ10132', '', '', '', '', NULL, 0, ''),
(293, 'PJJ10133@toki.if.itb.ac.id', 'PJJ10133', '5626e7a055c4f5ac506fbbb9162793147461f01f043568e9b8', 1, '0000-00-00 00:00:00', 'PJJ10133', '2009-10-31 12:35:01', NULL, NULL, NULL, NULL, '', '', '', '', NULL, 0, ''),
(294, 'PJJ10134@toki.if.itb.ac.id', 'PJJ10134', '65824bfe8b21b4aa519fe8440117d58110f9a2fd8d27525537', 0, '0000-00-00 00:00:00', 'PJJ10134', '2009-10-25 12:27:18', NULL, NULL, NULL, NULL, '', '', '', '', NULL, 0, ''),
(295, 'PJJ10135@toki.if.itb.ac.id', 'PJJ10135', 'f30ca4eced6bd06ca230b3ee48e853188826ef15645319efdb', 1, '0000-00-00 00:00:00', 'PJJ10135', '2009-11-06 13:35:44', NULL, NULL, NULL, NULL, '', '', '', '', NULL, 0, ''),
(296, 'master_crusader20@hotmail.com', 'crusader20', '3483d33b7b8e1bc40727430fb033b03325de85a0c6450777f7', 2, '0000-00-00 00:00:00', 'Jordan Fernando', '2009-11-03 13:00:23', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(297, 'ardiankp@host.com', 'ardiankp', 'a0be54c67b8e65e1d697a0d0fcd463f54718a709f404f04ab5', 6, '0000-00-00 00:00:00', 'Ardian Kristanto Poernomo', '2009-11-13 21:12:00', NULL, 'NTU', '', '', '', '', '', NULL, NULL, 0, ''),
(306, 'alfafrazer@gmail.com', 'frazer', '53ad3583aa886b65dcfd4a591051c8b2a9511e89935cd1f971', 1, '0000-00-00 00:00:00', 'Frazer Saut Martua Sidauruk', '2009-11-11 11:15:28', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(298, 's_pradhitya@toki.if.itb.ac.id', 's_pradhitya', '99f938fbb2c20095e8af71160e81340029dfed5bf1afe4e857', 1, '0000-00-00 00:00:00', 'Reinardus Surya Pradhitya', '2009-10-30 22:11:56', NULL, 'NTU', '', '', '', '', '', NULL, NULL, 0, ''),
(299, 'dennis.reinhard@toki.if.itb.ac.id', 'dennis.reinhard', '3d6b4e64cf02e17824a2c931d9c11b5f71b5d6d1fa48227ef0', 12, '0000-00-00 00:00:00', '', '2009-12-12 19:31:02', NULL, '', '', '', '', '', '', NULL, NULL, 0, ''),
(300, 'dolphinigle@students.itb.ac.id', 'dolph', '0383cd4a1e74e082a7f291a8d166cf560fb2249dcaab2b8408', 50, '0000-00-00 00:00:00', 'Irvan', '2010-01-04 09:33:23', NULL, '', '', 'sambya', '', '', '', '', NULL, 0, ''),
(307, 'suhendry.effendy@gmail.com', 'suhendry', '34e1996cb1e279ccd4c3b913b11b01bd9b4ccd135ed3f2985d', 1, '0000-00-00 00:00:00', '', '2009-11-11 13:15:51', NULL, '', '', '', '', '', '', '', NULL, 0, ''),
(305, 'litorsia@gmail.com', 'litorsia', '21af6e15befb5424b99333abb54a3f84288cbf044bb07ba18e', 2, '0000-00-00 00:00:00', 'Litorsia', '2009-11-11 23:28:19', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(303, 'hw_pascal10@yahoo.co.id', 'harta01', 'f7a21212826351d2d25a6c0f31906089b6b7585c12e2ab563c', 1, '0000-00-00 00:00:00', 'Harta Wijaya', '2009-11-03 14:26:09', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(304, 'rendy.jr@gmail.com', 'rendy', '0dbb8e83676457e6a2eda936de632ffaa367171b3137ec8ee5', 3, '0000-00-00 00:00:00', 'Rendy Bambang Junior', '2009-11-14 22:40:08', NULL, 'Institut Teknologi Bandung', 'Jalan Ganesha 10', '', '', '', '', NULL, NULL, 0, ''),
(308, 'Rickywin@gmail.com', 'rickwin1', '96f89e342304dc2ce9f5798223cbcdf7102f86a3bc67796f27', 11, '0000-00-00 00:00:00', 'Ricky Winata', '2009-11-18 13:02:19', NULL, 'Binus', '', '', '', '', '', '', NULL, 0, ''),
(302, 'a.syahreza@yahoo.com', 'amsyah', '180835d9312d0bfd6e80fe2826fbe92c73bc0a6f558ce8ac81', 9, '0000-00-00 00:00:00', 'Amal Syahreza', '2009-11-15 18:49:10', NULL, 'STEI', 'G10', '', '', '', '', '', NULL, 0, ''),
(301, 'learner4@lc.toki.if.itb.ac.id', 'learner4', '46a0f98e24a2d7f20ed09f3ba7bac1e093253be10ea6a6df83', 1, '0000-00-00 00:00:00', 'Learner', '2009-11-03 11:42:04', NULL, '', '', '', '', '', '', '', NULL, 0, ''),
(309, 'ilcapitano3_7@yahoo.co.id', 'ilcapt', 'e703091a9952e19dc49c88a0ba6481930197da0d03219ac50a', 1, '0000-00-00 00:00:00', 'Anggakara Hendra N', '2009-11-14 09:07:43', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(310, 'darkstallion@windowslive.com', 'darkstallion', '2fc06797c646d3c72b6d4179c142f504fa303ac439a842c8be', 1, '0000-00-00 00:00:00', 'Kelvin Valensius', '2009-11-19 20:50:00', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(311, 'sepanyapasaribu@students.itb.ac.id', 'sepanyapasaribu', '05f103e0428b2daacd0fe462ec622192b11264c84f277836f5', 1, '0000-00-00 00:00:00', 'Sepanya Pasaribu', '2009-12-28 15:10:32', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(312, 'm2t_math@yahoo.co.id', 'Mamat Pribadi', 'eebdf66bfbe89c27502b17ead5f8701b1b2ee42d0df004d3bc', 1, '0000-00-00 00:00:00', 'Mamat Rahmat', '2009-12-29 07:19:00', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(313, 'helloworld@if.itb.ac.id', 'helloworld', '31c52b71126bb3aa2b3f182b9b6630f986053d32ed05aef329', 1, '0000-00-00 00:00:00', 'Petra', '2010-02-12 10:13:30', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(314, 'dikraprasetya@yahoo.co.id', 'dkr5894', 'c1ac2936eccfaea92a18122c76f081a066e25dc45e86778159', 8, '0000-00-00 00:00:00', 'Mochammad Dikra Prasetya', '2010-05-30 09:54:25', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(315, 'mage.goo@gmail.com', 'muntaha ilmi', 'a74de4840e025681fcb8376d4ec25e000f952d940e94d88d02', 2, '0000-00-00 00:00:00', 'Muntaha Ilmi', '2010-05-11 13:06:24', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(316, 'lost968@yahoo.com', 'Ikhsan8', '80f678ece03f69f7e07a11211e0e9ce36435802f8b0b08c8e0', 4, '0000-00-00 00:00:00', 'Muhammad Ikhsan', '2010-05-27 21:01:52', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, ''),
(320, 'halo1234@van-odin.net', 'halo1234', '1080b894867f3ec02f3cb2a1df1d5694b6879c02', 0, '0000-00-00 00:00:00', 'petra', '2010-06-20 19:51:47', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, NULL);
