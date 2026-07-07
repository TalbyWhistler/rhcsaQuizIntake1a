-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2026 at 08:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `redhat0`
--
CREATE DATABASE IF NOT EXISTS `redhat0` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `redhat0`;

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `chapter` int(11) DEFAULT NULL,
  `questionNumber` int(11) DEFAULT NULL,
  `answerLetter` varchar(1) DEFAULT NULL,
  `answer` varchar(255) DEFAULT NULL,
  `secondAnswer` varchar(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chapterlabmeta`
--

CREATE TABLE `chapterlabmeta` (
  `uuid` int(11) NOT NULL,
  `chapter` int(11) DEFAULT NULL,
  `chaptertitle` varchar(100) DEFAULT NULL,
  `labintro` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `chapterlabsteps`
--

CREATE TABLE `chapterlabsteps` (
  `uuid` int(11) NOT NULL,
  `chapter` int(11) DEFAULT NULL,
  `stepnumber` int(11) DEFAULT NULL,
  `steptext` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exercises`
--

CREATE TABLE `exercises` (
  `uuid` int(11) NOT NULL,
  `figure` varchar(10) DEFAULT NULL,
  `stepnumber` int(11) DEFAULT NULL,
  `steptext` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exercisesmeta`
--

CREATE TABLE `exercisesmeta` (
  `uuid` int(11) NOT NULL,
  `figure` varchar(10) DEFAULT NULL,
  `title` varchar(100) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `optionalPicLocation` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `leaderboard`
--

CREATE TABLE `leaderboard` (
  `chapter` int(11) DEFAULT NULL,
  `figuretitle` varchar(100) DEFAULT NULL,
  `code` varchar(2) DEFAULT NULL,
  `score` int(11) DEFAULT NULL,
  `outof` int(11) DEFAULT NULL,
  `ip` varchar(20) DEFAULT NULL,
  `dateof` date DEFAULT NULL,
  `timeof` time DEFAULT NULL,
  `uuid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `memoryentries`
--

CREATE TABLE `memoryentries` (
  `uuid` int(11) NOT NULL,
  `figure` varchar(20) DEFAULT NULL,
  `value0` varchar(255) DEFAULT NULL,
  `value1` varchar(255) DEFAULT NULL,
  `value2` varchar(255) DEFAULT NULL,
  `value3` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `memorymeta`
--

CREATE TABLE `memorymeta` (
  `uuid` int(11) NOT NULL,
  `chapter` int(11) DEFAULT NULL,
  `figure` varchar(20) DEFAULT NULL,
  `description` varchar(150) DEFAULT NULL,
  `value0Label` varchar(20) DEFAULT NULL,
  `value1Label` varchar(20) DEFAULT NULL,
  `value2Label` varchar(20) DEFAULT NULL,
  `value3Label` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `memorytableentries`
--

CREATE TABLE `memorytableentries` (
  `chapter` int(11) DEFAULT NULL,
  `label` varchar(20) DEFAULT NULL,
  `tableKey` varchar(100) DEFAULT NULL,
  `value0` varchar(100) DEFAULT NULL,
  `value1` varchar(100) DEFAULT NULL,
  `value2` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `memorytablemeta`
--

CREATE TABLE `memorytablemeta` (
  `chapter` int(11) DEFAULT NULL,
  `label` varchar(20) DEFAULT NULL,
  `keyLabel` varchar(20) DEFAULT NULL,
  `value0Label` varchar(20) DEFAULT NULL,
  `value1Label` varchar(20) DEFAULT NULL,
  `value2Label` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `chapter` int(11) DEFAULT NULL,
  `questionNumber` int(11) DEFAULT NULL,
  `questionText` varchar(255) DEFAULT NULL,
  `a` varchar(100) DEFAULT NULL,
  `b` varchar(100) DEFAULT NULL,
  `c` varchar(100) DEFAULT NULL,
  `d` varchar(100) DEFAULT NULL,
  `hasTwoAnswers` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviewanswers`
--

CREATE TABLE `reviewanswers` (
  `uuid` int(11) NOT NULL,
  `chapter` int(11) DEFAULT NULL,
  `questionNo` int(11) DEFAULT NULL,
  `answerText` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reviewquestions`
--

CREATE TABLE `reviewquestions` (
  `uuid` int(11) NOT NULL,
  `chapter` int(11) DEFAULT NULL,
  `questionNo` int(11) DEFAULT NULL,
  `questionText` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `userlogin`
--

CREATE TABLE `userlogin` (
  `uuid` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `userlevel` varchar(2) DEFAULT NULL,
  `logintoken` varchar(50) DEFAULT NULL,
  `logindate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chapterlabmeta`
--
ALTER TABLE `chapterlabmeta`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `chapterlabsteps`
--
ALTER TABLE `chapterlabsteps`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `exercises`
--
ALTER TABLE `exercises`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `exercisesmeta`
--
ALTER TABLE `exercisesmeta`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `leaderboard`
--
ALTER TABLE `leaderboard`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `memoryentries`
--
ALTER TABLE `memoryentries`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `memorymeta`
--
ALTER TABLE `memorymeta`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `reviewanswers`
--
ALTER TABLE `reviewanswers`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `reviewquestions`
--
ALTER TABLE `reviewquestions`
  ADD PRIMARY KEY (`uuid`);

--
-- Indexes for table `userlogin`
--
ALTER TABLE `userlogin`
  ADD PRIMARY KEY (`uuid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chapterlabmeta`
--
ALTER TABLE `chapterlabmeta`
  MODIFY `uuid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `chapterlabsteps`
--
ALTER TABLE `chapterlabsteps`
  MODIFY `uuid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exercises`
--
ALTER TABLE `exercises`
  MODIFY `uuid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exercisesmeta`
--
ALTER TABLE `exercisesmeta`
  MODIFY `uuid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `leaderboard`
--
ALTER TABLE `leaderboard`
  MODIFY `uuid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `memoryentries`
--
ALTER TABLE `memoryentries`
  MODIFY `uuid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `memorymeta`
--
ALTER TABLE `memorymeta`
  MODIFY `uuid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviewanswers`
--
ALTER TABLE `reviewanswers`
  MODIFY `uuid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviewquestions`
--
ALTER TABLE `reviewquestions`
  MODIFY `uuid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `userlogin`
--
ALTER TABLE `userlogin`
  MODIFY `uuid` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
