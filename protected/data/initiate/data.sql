-- phpMyAdmin SQL Dump
-- version 3.3.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 23, 2010 at 10:54 AM
-- Server version: 5.1.37
-- PHP Version: 5.3.2-0.dotdeb.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `lc3_db`
--

--
-- Dumping data for table `announcements`
--

--
-- Dumping data for table `articles`
--


--
-- Dumping data for table `AuthAssignment`
--

INSERT INTO `AuthAssignment` VALUES('administrator', '1', NULL, 'N;');
INSERT INTO `AuthAssignment` VALUES('administrator', '2', NULL, 'N;');
INSERT INTO `AuthAssignment` VALUES('supervisor', '1', NULL, 'N;');
INSERT INTO `AuthAssignment` VALUES('supervisor', '2', NULL, 'N;');

--
-- Dumping data for table `AuthItem`
--

INSERT INTO `AuthItem` VALUES('administrator', 2, 'Administrator', NULL, 'N;');
INSERT INTO `AuthItem` VALUES('supervisor', 2, 'Supervisor', NULL, 'N;');
INSERT INTO `AuthItem` VALUES('learner', 2, 'Learner', NULL, 'N;');
INSERT INTO `AuthItem` VALUES('test', 2, 'test', NULL, 'N;');

--
-- Dumping data for table `AuthItemChild`
--

--
-- Dumping data for table `configurations`
--


--
-- Dumping data for table `contestnews`
--

--
-- Dumping data for table `contests`
--

--
-- Dumping data for table `contests_problems`
--

--
-- Dumping data for table `contests_users`
--

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` VALUES(1, 'administrator', 'Administrator');
INSERT INTO `groups` VALUES(2, 'supervisor', 'Supervisor');
INSERT INTO `groups` VALUES(3, 'learner', 'Learner');

--
-- Dumping data for table `groups_users`
--

INSERT INTO `groups_users` VALUES(1, 1);
INSERT INTO `groups_users` VALUES(1, 2);
INSERT INTO `groups_users` VALUES(2, 1);
INSERT INTO `groups_users` VALUES(2, 2);

--
-- Dumping data for table `logs`
--


--
-- Dumping data for table `pastebin`
--


--
-- Dumping data for table `privatemessages`
--


--
-- Dumping data for table `privatemessages_recipients`
--


--
-- Dumping data for table `problems`
--

--
-- Dumping data for table `problemsets`
--

INSERT INTO `problemsets` VALUES(1, NULL, 1, '2010-07-15 15:49:24', '2010-07-15 20:31:07', 'Bundel Soal Perkenalan', 'Bundel Soal Perkenalan');

--
-- Dumping data for table `problemsets_problems`
--

--
-- Dumping data for table `problem_types`
--

INSERT INTO `problem_types` VALUES(1, 'simplebatch', 'Batch');
INSERT INTO `problem_types` VALUES(5, 'simpletext', 'Simple text');
INSERT INTO `problem_types` VALUES(6, 'reactive1', 'Reactive1');
INSERT INTO `problem_types` VALUES(7, 'batchacm', 'ACM Type');

--
-- Dumping data for table `submissions`
--

--
-- Dumping data for table `users`
--

INSERT INTO `users` VALUES(1, 'petra.barus@gmail.com', 'admin', '97de756cf63b911dcb6d2600ddbe0d4dbd5a6913', 133, '2010-08-17 16:19:07', '202.146.253.4', 'Administrator', '2010-06-20 04:41:12', 'http://lc.toki.if.itb.ac.id/lx', 'Tim Olimpiade Komputer Indonesia', '', '', '', '', '', NULL, NULL, 1, NULL);
INSERT INTO `users` VALUES(2, 'me@van-odin.net', 'petra', '97de756cf63b911dcb6d2600ddbe0d4dbd5a6913', 27, '2010-07-29 16:38:26', '202.146.253.4', 'Petra Novandi', '2010-07-15 15:28:14', '', '', '', '', '', '', '', NULL, NULL, 1, NULL);


--
-- Dumping data for table `contest_types`
--

INSERT INTO `contest_types` (`id`, `name`, `description`) VALUES(1, 'ioi', 'Standard contest for International Olympiads in Informatics');
INSERT INTO `contest_types` (`id`, `name`, `description`) VALUES(2, 'acmicpc', 'Standard contest for ACM ICPC');
