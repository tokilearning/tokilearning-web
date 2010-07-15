-- phpMyAdmin SQL Dump
-- version 3.2.2.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 18, 2010 at 12:01 AM
-- Server version: 5.1.37
-- PHP Version: 5.2.10-2ubuntu6.4

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `lc3_db`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `announcements`
--


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
-- Table structure for table `AuthAssignment`
--

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
('administrator', '2', NULL, 'N;'),
('supervisor', '1', NULL, 'N;'),
('supervisor', '2', NULL, 'N;'),
('learner', '4', NULL, 'N;'),
('learner', '5', NULL, 'N;'),
('learner', '6', NULL, 'N;'),
('supervisor', '5', NULL, 'N;'),
('supervisor', '6', NULL, 'N;'),
('administrator', '6', NULL, 'N;'),
('administrator', '5', NULL, 'N;');

-- --------------------------------------------------------

--
-- Table structure for table `AuthItem`
--

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
-- Table structure for table `clarifications`
--

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
-- Table structure for table `contestnews`
--

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
) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `contests`
--


-- --------------------------------------------------------

--
-- Table structure for table `contests_problems`
--

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


-- --------------------------------------------------------

--
-- Table structure for table `contests_users`
--

CREATE TABLE IF NOT EXISTS `contests_users` (
  `contest_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  `status` int(11) unsigned NOT NULL,
  `role` int(11) NOT NULL,
  `last_activity` datetime DEFAULT NULL,
  `last_page` text,
  PRIMARY KEY (`contest_id`,`user_id`),
  KEY `contest_id` (`contest_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contests_users`
--


-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

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

CREATE TABLE IF NOT EXISTS `groups_users` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  KEY `group_id` (`group_id`,`user_id`),
  KEY `group_id_2` (`group_id`,`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups_users`
--

INSERT INTO `groups_users` (`group_id`, `user_id`) VALUES
(1, 1),
(1, 2),
(1, 5),
(1, 6),
(2, 5),
(2, 6),
(3, 4),
(3, 5),
(3, 6);

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

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

CREATE TABLE IF NOT EXISTS `pastebin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) NOT NULL,
  `type` varchar(64) NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `pastebin`
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
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Storing problems' AUTO_INCREMENT=2 ;

--
-- Dumping data for table `problems`
--

INSERT INTO `problems` (`id`, `title`, `author_id`, `comment`, `created_date`, `modified_date`, `problem_type_id`, `description`, `token`, `visibility`) VALUES
(1, 'Hello World!', 1, '', '2010-07-15 20:31:28', '2010-07-16 08:13:52', 1, 'Hello World!', 'YWFUNCZJTHAUJCQWVOQDVMQPODDC2B4B', 1);

-- --------------------------------------------------------

--
-- Table structure for table `problemsets`
--

CREATE TABLE IF NOT EXISTS `problemsets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_id` int(11) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `name` text NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `problemsets`
--

INSERT INTO `problemsets` (`id`, `parent_id`, `status`, `created_date`, `modified_date`, `name`, `description`) VALUES
(1, NULL, 1, '2010-07-15 15:49:24', '2010-07-15 20:31:07', 'Bundel Soal Perkenalan', 'Bundel Soal Perkenalan');

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

INSERT INTO `problemsets_problems` (`problemset_id`, `problem_id`, `status`) VALUES
(1, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `problem_types`
--

CREATE TABLE IF NOT EXISTS `problem_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COMMENT='Problem types' AUTO_INCREMENT=5 ;

--
-- Dumping data for table `problem_types`
--

INSERT INTO `problem_types` (`id`, `name`, `description`) VALUES
(1, 'simplebatch', 'Batch');

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE IF NOT EXISTS `submissions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) NOT NULL,
  `submitter_id` int(10) unsigned NOT NULL,
  `contest_id` int(10) unsigned DEFAULT NULL,
  `submitted_time` datetime NOT NULL,
  `submit_content` text NOT NULL,
  `grade_time` datetime DEFAULT NULL,
  `grade_content` text,
  `grade_output` longtext,
  `grade_status` int(11) DEFAULT NULL,
  `verdict` text,
  `score` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `submitter_id` (`submitter_id`,`contest_id`),
  KEY `contest_id` (`contest_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `submissions`
--

INSERT INTO `submissions` (`id`, `problem_id`, `submitter_id`, `contest_id`, `submitted_time`, `submit_content`, `grade_time`, `grade_content`, `grade_output`, `grade_status`, `verdict`, `score`) VALUES
(1, 1, 4, NULL, '2010-07-15 20:48:09', '{"source_lang":"c","original_name":"petra.c","source_content":"int main(){\\r\\n\\t\\r\\n}"}', '2010-07-16 08:20:21', '{"verdict":"Wrong Answer","output":"Testcase #1\\n\\tWrong Answer\\nTestcase #2\\n\\tWrong Answer\\n","total_testcase":2,"right_testcase":0}', NULL, 3, NULL, 0),
(2, 1, 1, NULL, '2010-07-16 07:45:32', '{"source_lang":"c","original_name":"petra2.c","source_content":"int main(){\\r\\n\\tint a, b;\\r\\n\\tscanf(\\"%d\\", &a);\\r\\n\\tfor(int b = 1; b <= a; b++){\\r\\n\\t\\tprintf(\\"Hello World!\\\\n\\");\\r\\n\\t}\\r\\n}"}', '2010-07-16 08:20:22', '{"verdict":"Accepted","output":"Testcase #1\\n\\tAccepted\\nTestcase #2\\n\\tAccepted\\n","total_testcase":2,"right_testcase":2}', NULL, 3, NULL, 0),
(3, 1, 4, NULL, '2010-07-16 08:21:28', '{"source_lang":"c","original_name":"petra2.c","source_content":"int main(){\\r\\n\\tint a, b;\\r\\n\\tscanf(\\"%d\\", &a);\\r\\n\\tfor(int b = 1; b <= a; b++){\\r\\n\\t\\tprintf(\\"Hello World!\\\\n\\");\\r\\n\\t}\\r\\n}"}', '2010-07-16 08:25:40', '{"verdict":"Accepted","output":"Testcase #1\\n\\tAccepted\\nTestcase #2\\n\\tAccepted\\n","total_testcase":2,"right_testcase":2}', NULL, 3, NULL, 0);

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
  UNIQUE KEY `uniq_email` (`email`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `password`, `logins`, `last_login`, `last_ip`, `full_name`, `join_time`, `site_url`, `institution`, `institution_address`, `institution_phone`, `address`, `postal_code`, `city`, `handphone`, `phone`, `active`, `activation_code`) VALUES
(1, 'petra.barus@gmail.com', 'admin', 'fc79b3bc1ff96ab45f5079e326c75e6cfc98dff4', 51, '2010-07-17 11:00:47', '202.146.253.4', 'Administrator', '2010-06-20 04:41:12', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 1, NULL),
(2, 'me@van-odin.net', 'petra', 'fc79b3bc1ff96ab45f5079e326c75e6cfc98dff4', 26, '2010-07-13 01:14:34', '127.0.0.1', 'Petra Novandi', '2010-07-15 15:28:14', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 1, NULL),
(4, 'van_odin@yahoo.com', 'petra2', '97de756cf63b911dcb6d2600ddbe0d4dbd5a6913', 4, '2010-07-16 16:38:09', '202.146.253.4', 'Petra Novandi', '2010-07-15 20:47:00', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, NULL),
(5, 'brian@microbrainx.net', 'microbrain', 'a844ba41e7957e42cbe8a08235c1679decfed6c3', 1, '2010-07-16 16:37:12', '202.70.54.139', 'Brian Marshal', '2010-07-16 16:37:11', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, NULL),
(6, 'hallucinogenplus@yahoo.co.id', 'hallucinogen', 'a868b12bb900a1aa62691f7835bf9941eae2876d', 2, '2010-07-17 10:36:17', '117.103.51.218', 'Listiarso Wastuargo', '2010-07-17 10:09:46', NULL, NULL, NULL, NULL, '', '', '', NULL, NULL, 0, NULL);
