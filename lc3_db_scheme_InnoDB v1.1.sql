-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 12, 2012 at 04:19 PM
-- Server version: 5.5.22
-- PHP Version: 5.3.10-1ubuntu3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


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

CREATE TABLE IF NOT EXISTS `announcements` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) unsigned NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` text CHARACTER SET latin1 NOT NULL,
  `content` text CHARACTER SET latin1 NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `arenas`
--

CREATE TABLE IF NOT EXISTS `arenas` (
  `id` int(14) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `status` int(11) NOT NULL DEFAULT '0',
  `creator_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `creator_id` (`creator_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `arenas_problems`
--

CREATE TABLE IF NOT EXISTS `arenas_problems` (
  `arena_id` int(14) unsigned NOT NULL,
  `problem_id` int(14) unsigned NOT NULL,
  PRIMARY KEY (`arena_id`,`problem_id`),
  KEY `problem_id` (`problem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `arenas_users`
--

CREATE TABLE IF NOT EXISTS `arenas_users` (
  `arena_id` int(14) unsigned NOT NULL,
  `user_id` int(14) unsigned NOT NULL,
  PRIMARY KEY (`arena_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) unsigned NOT NULL,
  `contest_id` int(10) unsigned DEFAULT NULL,
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `title` text CHARACTER SET latin1 NOT NULL,
  `content` text CHARACTER SET latin1 NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `contest_id` (`contest_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `AuthAssignment`
--

CREATE TABLE IF NOT EXISTS `AuthAssignment` (
  `itemname` varchar(64) CHARACTER SET latin1 NOT NULL,
  `userid` varchar(64) CHARACTER SET latin1 NOT NULL,
  `bizrule` text CHARACTER SET latin1,
  `data` text CHARACTER SET latin1,
  PRIMARY KEY (`itemname`,`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AuthItem`
--

CREATE TABLE IF NOT EXISTS `AuthItem` (
  `name` varchar(64) CHARACTER SET latin1 NOT NULL,
  `type` int(11) NOT NULL,
  `description` text CHARACTER SET latin1,
  `bizrule` text CHARACTER SET latin1,
  `data` text CHARACTER SET latin1,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `AuthItemChild`
--

CREATE TABLE IF NOT EXISTS `AuthItemChild` (
  `parent` varchar(64) CHARACTER SET latin1 NOT NULL,
  `child` varchar(64) CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`parent`,`child`),
  KEY `child` (`child`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chapters`
--

CREATE TABLE IF NOT EXISTS `chapters` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  `created_time` datetime NOT NULL,
  `next_chapter_id` int(11) unsigned DEFAULT NULL,
  `first_subchapter_id` int(11) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `next_chapter_id` (`next_chapter_id`),
  KEY `first_subchapter_id` (`first_subchapter_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `chapters_problems`
--

CREATE TABLE IF NOT EXISTS `chapters_problems` (
  `chapter_id` int(10) unsigned NOT NULL,
  `problem_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`chapter_id`,`problem_id`),
  KEY `problem_id` (`problem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `chapters_users`
--

CREATE TABLE IF NOT EXISTS `chapters_users` (
  `chapter_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  `start_time` datetime DEFAULT NULL,
  `finish_time` datetime DEFAULT NULL,
  `status` int(10) unsigned NOT NULL,
  PRIMARY KEY (`chapter_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `clarifications`
--

CREATE TABLE IF NOT EXISTS `clarifications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contest_id` int(10) unsigned DEFAULT NULL,
  `chapter_id` int(14) unsigned DEFAULT NULL,
  `problem_id` int(10) unsigned DEFAULT NULL,
  `questioner_id` int(11) unsigned NOT NULL,
  `questioned_time` datetime NOT NULL,
  `subject` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `question` text CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL,
  `answerer_id` int(11) unsigned DEFAULT NULL,
  `answered_time` datetime DEFAULT NULL,
  `answer` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contest_id` (`contest_id`),
  KEY `questioner_id` (`questioner_id`),
  KEY `answerer_id` (`answerer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `configurations`
--

CREATE TABLE IF NOT EXISTS `configurations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET latin1 NOT NULL,
  `value` text CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contestnews`
--

CREATE TABLE IF NOT EXISTS `contestnews` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `author_id` int(10) unsigned NOT NULL,
  `contest_id` int(11) unsigned NOT NULL,
  `created_date` datetime NOT NULL,
  `title` text CHARACTER SET latin1 NOT NULL,
  `content` text CHARACTER SET latin1 NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `contest_id` (`contest_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- Table structure for table `contests`
--

CREATE TABLE IF NOT EXISTS `contests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) unsigned NOT NULL,
  `name` text CHARACTER SET latin1 NOT NULL,
  `contest_type_id` int(11) unsigned NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `end_time` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `status` int(11) NOT NULL DEFAULT '0' COMMENT 'open, closed, hidden',
  `invitation_type` int(11) NOT NULL DEFAULT '0',
  `configuration` text CHARACTER SET latin1,
  `span_type` int(5) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`),
  KEY `contest_type_id` (`contest_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Table structure for table `contests_problems`
--

CREATE TABLE IF NOT EXISTS `contests_problems` (
  `contest_id` int(11) unsigned NOT NULL,
  `alias` int(11) NOT NULL,
  `problem_id` int(11) unsigned NOT NULL,
  `timestamp` datetime NOT NULL,
  `status` int(11) NOT NULL,
  PRIMARY KEY (`contest_id`,`problem_id`),
  KEY `problem_id` (`problem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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
  `register_date` datetime DEFAULT NULL,
  `last_page` text CHARACTER SET latin1,
  PRIMARY KEY (`contest_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contest_logs`
--

CREATE TABLE IF NOT EXISTS `contest_logs` (
  `id` int(14) unsigned NOT NULL AUTO_INCREMENT,
  `contest_id` int(14) unsigned NOT NULL,
  `actor_id` int(11) unsigned NOT NULL,
  `action_type` int(11) NOT NULL,
  `time` int(20) NOT NULL,
  `log_content` text CHARACTER SET latin1,
  PRIMARY KEY (`id`),
  KEY `contest_id` (`contest_id`),
  KEY `actor_id` (`actor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `contest_types`
--

CREATE TABLE IF NOT EXISTS `contest_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Table structure for table `groups_users`
--

CREATE TABLE IF NOT EXISTS `groups_users` (
  `group_id` int(11) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`group_id`,`user_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `logs`
--

CREATE TABLE IF NOT EXISTS `logs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `level` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
  `category` varchar(128) CHARACTER SET latin1 DEFAULT NULL,
  `logtime` int(11) DEFAULT NULL,
  `message` text CHARACTER SET latin1,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `multiplesourcearchives`
--

CREATE TABLE IF NOT EXISTS `multiplesourcearchives` (
  `id` int(14) NOT NULL AUTO_INCREMENT,
  `submission_id` int(11) unsigned NOT NULL,
  `file` longblob,
  PRIMARY KEY (`id`),
  KEY `submission_id` (`submission_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pastebin`
--

CREATE TABLE IF NOT EXISTS `pastebin` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `owner_id` int(11) unsigned NOT NULL,
  `type` varchar(64) CHARACTER SET latin1 NOT NULL,
  `status` int(11) NOT NULL,
  `created_date` datetime NOT NULL,
  `content` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `owner_id` (`owner_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `privatemessages`
--

CREATE TABLE IF NOT EXISTS `privatemessages` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `sender_id` int(10) unsigned NOT NULL,
  `send_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `subject` text CHARACTER SET latin1 NOT NULL,
  `content` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sender_id` (`sender_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Storing private messaging' AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `privatemessages_recipients`
--

CREATE TABLE IF NOT EXISTS `privatemessages_recipients` (
  `privatemessage_id` int(10) unsigned NOT NULL,
  `recipient_id` int(10) unsigned NOT NULL,
  `unread` tinyint(1) NOT NULL,
  PRIMARY KEY (`recipient_id`,`privatemessage_id`),
  KEY `private_message_id` (`recipient_id`),
  KEY `privatemessage_id` (`privatemessage_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Storing private messaging recipients';

-- --------------------------------------------------------

--
-- Table structure for table `problems`
--

CREATE TABLE IF NOT EXISTS `problems` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` text CHARACTER SET latin1 NOT NULL,
  `author_id` int(10) unsigned NOT NULL,
  `comment` text CHARACTER SET latin1 NOT NULL,
  `created_date` datetime NOT NULL,
  `modified_date` datetime NOT NULL,
  `problem_type_id` int(10) unsigned NOT NULL,
  `description` text CHARACTER SET latin1,
  `token` varchar(32) CHARACTER SET latin1 NOT NULL,
  `visibility` int(11) NOT NULL,
  `available_languages` text CHARACTER SET latin1,
  PRIMARY KEY (`id`),
  KEY `author_id` (`author_id`),
  KEY `problem_type_id` (`problem_type_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Storing problems' AUTO_INCREMENT=150 ;

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
  `name` text CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

-- --------------------------------------------------------

--
-- Table structure for table `problemsets_problems`
--

CREATE TABLE IF NOT EXISTS `problemsets_problems` (
  `problemset_id` int(11) NOT NULL,
  `problem_id` int(11) unsigned NOT NULL,
  `status` int(11) NOT NULL,
  `rank` int(11) DEFAULT NULL,
  PRIMARY KEY (`problemset_id`,`problem_id`),
  KEY `problem_id` (`problem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `problem_privileges`
--

CREATE TABLE IF NOT EXISTS `problem_privileges` (
  `problem_id` int(11) unsigned NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  KEY `problem_id` (`problem_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `problem_types`
--

CREATE TABLE IF NOT EXISTS `problem_types` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='Problem types' AUTO_INCREMENT=13 ;

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

CREATE TABLE IF NOT EXISTS `submissions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `problem_id` int(11) unsigned NOT NULL,
  `submitter_id` int(10) unsigned NOT NULL,
  `contest_id` int(10) unsigned DEFAULT NULL,
  `chapter_id` int(10) unsigned DEFAULT NULL,
  `submitted_time` datetime NOT NULL,
  `submit_content` text CHARACTER SET latin1 NOT NULL,
  `grade_time` datetime DEFAULT NULL,
  `grade_content` text CHARACTER SET latin1,
  `grade_output` longtext CHARACTER SET latin1,
  `grade_status` int(11) DEFAULT NULL,
  `verdict` text CHARACTER SET latin1,
  `score` float NOT NULL,
  `comment` text CHARACTER SET latin1 NOT NULL,
  `file` longblob,
  PRIMARY KEY (`id`),
  KEY `submitter_id` (`submitter_id`,`contest_id`),
  KEY `contest_id` (`contest_id`),
  KEY `chapter_id` (`chapter_id`),
  KEY `problem_id` (`problem_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `trainings`
--

CREATE TABLE IF NOT EXISTS `trainings` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `description` text CHARACTER SET latin1 NOT NULL,
  `created_time` datetime NOT NULL,
  `creator_id` int(10) unsigned NOT NULL,
  `first_chapter_id` int(10) unsigned NOT NULL,
  `status` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `first_chapter_id` (`first_chapter_id`),
  KEY `creator_id` (`creator_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

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
  `additional_information` text,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uniq_username` (`username`),
  UNIQUE KEY `uniq_email` (`email`),
  KEY `last_activity` (`last_activity`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3219 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `arenas`
--
ALTER TABLE `arenas`
  ADD CONSTRAINT `arenas_ibfk_1` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `arenas_problems`
--
ALTER TABLE `arenas_problems`
  ADD CONSTRAINT `arenas_problems_ibfk_1` FOREIGN KEY (`arena_id`) REFERENCES `arenas` (`id`),
  ADD CONSTRAINT `arenas_problems_ibfk_2` FOREIGN KEY (`problem_id`) REFERENCES `problems` (`id`);

--
-- Constraints for table `arenas_users`
--
ALTER TABLE `arenas_users`
  ADD CONSTRAINT `arenas_users_ibfk_1` FOREIGN KEY (`arena_id`) REFERENCES `arenas` (`id`),
  ADD CONSTRAINT `arenas_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_2` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`),
  ADD CONSTRAINT `articles_ibfk_3` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `chapters`
--
ALTER TABLE `chapters`
  ADD CONSTRAINT `chapters_ibfk_1` FOREIGN KEY (`next_chapter_id`) REFERENCES `chapters` (`id`),
  ADD CONSTRAINT `chapters_ibfk_2` FOREIGN KEY (`first_subchapter_id`) REFERENCES `chapters` (`id`);

--
-- Constraints for table `chapters_problems`
--
ALTER TABLE `chapters_problems`
  ADD CONSTRAINT `chapters_problems_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`),
  ADD CONSTRAINT `chapters_problems_ibfk_2` FOREIGN KEY (`problem_id`) REFERENCES `problems` (`id`);

--
-- Constraints for table `chapters_users`
--
ALTER TABLE `chapters_users`
  ADD CONSTRAINT `chapters_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `chapters_users_ibfk_1` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`);

--
-- Constraints for table `clarifications`
--
ALTER TABLE `clarifications`
  ADD CONSTRAINT `clarifications_ibfk_4` FOREIGN KEY (`questioner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `clarifications_ibfk_1` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`),
  ADD CONSTRAINT `clarifications_ibfk_3` FOREIGN KEY (`answerer_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `contestnews`
--
ALTER TABLE `contestnews`
  ADD CONSTRAINT `contestnews_ibfk_3` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `contestnews_ibfk_2` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`);

--
-- Constraints for table `contests`
--
ALTER TABLE `contests`
  ADD CONSTRAINT `contests_ibfk_3` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `contests_ibfk_2` FOREIGN KEY (`contest_type_id`) REFERENCES `contest_types` (`id`);

--
-- Constraints for table `contests_problems`
--
ALTER TABLE `contests_problems`
  ADD CONSTRAINT `contests_problems_ibfk_2` FOREIGN KEY (`problem_id`) REFERENCES `problems` (`id`),
  ADD CONSTRAINT `contests_problems_ibfk_1` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`);

--
-- Constraints for table `contests_users`
--
ALTER TABLE `contests_users`
  ADD CONSTRAINT `contests_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `contests_users_ibfk_1` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`);

--
-- Constraints for table `contest_logs`
--
ALTER TABLE `contest_logs`
  ADD CONSTRAINT `contest_logs_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `contest_logs_ibfk_1` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`);

--
-- Constraints for table `groups_users`
--
ALTER TABLE `groups_users`
  ADD CONSTRAINT `groups_users_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `groups_users_ibfk_1` FOREIGN KEY (`group_id`) REFERENCES `groups` (`id`);

--
-- Constraints for table `multiplesourcearchives`
--
ALTER TABLE `multiplesourcearchives`
  ADD CONSTRAINT `multiplesourcearchives_ibfk_1` FOREIGN KEY (`submission_id`) REFERENCES `submissions` (`id`);

--
-- Constraints for table `pastebin`
--
ALTER TABLE `pastebin`
  ADD CONSTRAINT `pastebin_ibfk_1` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `privatemessages`
--
ALTER TABLE `privatemessages`
  ADD CONSTRAINT `privatemessages_ibfk_1` FOREIGN KEY (`sender_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `privatemessages_recipients`
--
ALTER TABLE `privatemessages_recipients`
  ADD CONSTRAINT `privatemessages_recipients_ibfk_2` FOREIGN KEY (`recipient_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `privatemessages_recipients_ibfk_1` FOREIGN KEY (`privatemessage_id`) REFERENCES `privatemessages` (`id`);

--
-- Constraints for table `problems`
--
ALTER TABLE `problems`
  ADD CONSTRAINT `problems_ibfk_3` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `problems_ibfk_2` FOREIGN KEY (`problem_type_id`) REFERENCES `problem_types` (`id`);

--
-- Constraints for table `problemsets`
--
ALTER TABLE `problemsets`
  ADD CONSTRAINT `problemsets_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `problemsets` (`id`);

--
-- Constraints for table `problemsets_problems`
--
ALTER TABLE `problemsets_problems`
  ADD CONSTRAINT `problemsets_problems_ibfk_2` FOREIGN KEY (`problem_id`) REFERENCES `problems` (`id`),
  ADD CONSTRAINT `problemsets_problems_ibfk_1` FOREIGN KEY (`problemset_id`) REFERENCES `problemsets` (`id`);

--
-- Constraints for table `problem_privileges`
--
ALTER TABLE `problem_privileges`
  ADD CONSTRAINT `problem_privileges_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `problem_privileges_ibfk_1` FOREIGN KEY (`problem_id`) REFERENCES `problems` (`id`);

--
-- Constraints for table `submissions`
--
ALTER TABLE `submissions`
  ADD CONSTRAINT `submissions_ibfk_5` FOREIGN KEY (`submitter_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `submissions_ibfk_2` FOREIGN KEY (`contest_id`) REFERENCES `contests` (`id`),
  ADD CONSTRAINT `submissions_ibfk_3` FOREIGN KEY (`chapter_id`) REFERENCES `chapters` (`id`),
  ADD CONSTRAINT `submissions_ibfk_4` FOREIGN KEY (`problem_id`) REFERENCES `problems` (`id`);

--
-- Constraints for table `trainings`
--
ALTER TABLE `trainings`
  ADD CONSTRAINT `trainings_ibfk_3` FOREIGN KEY (`creator_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `trainings_ibfk_2` FOREIGN KEY (`first_chapter_id`) REFERENCES `chapters` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
