-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Feb 04, 2022 at 10:02 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.0.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `swos`
--

-- --------------------------------------------------------

--
-- Table structure for table `backupBiodata`
--

CREATE TABLE `backupBiodata` (
  `MatricNumber` varchar(16) NOT NULL,
  `Surname` tinytext NOT NULL,
  `FirstName` tinytext NOT NULL,
  `OtherNames` tinytext NOT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `ModeOfEntry` text NOT NULL,
  `YearOfEntry` decimal(8,0) NOT NULL,
  `FacultyName` text NOT NULL,
  `Discipline` text NOT NULL,
  `Sex` char(1) NOT NULL,
  `ClassOfDegree` varchar(32) NOT NULL,
  `DateOfPresentation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `backupScores`
--

CREATE TABLE `backupScores` (
  `ID` int(10) UNSIGNED NOT NULL,
  `CourseCode` varchar(7) NOT NULL,
  `MatricNumber` varchar(16) NOT NULL,
  `Session` decimal(8,0) NOT NULL,
  `Semester` tinytext NOT NULL,
  `TotalMark` tinyint(2) NOT NULL,
  `GP` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Biodata`
--

CREATE TABLE `Biodata` (
  `MatricNumber` varchar(16) NOT NULL,
  `Surname` tinytext NOT NULL,
  `FirstName` tinytext NOT NULL,
  `OtherNames` tinytext NOT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `ModeOfEntry` text NOT NULL,
  `YearOfEntry` decimal(8,0) NOT NULL,
  `FacultyName` text NOT NULL,
  `Discipline` text NOT NULL,
  `Sex` char(1) NOT NULL,
  `ClassOfDegree` varchar(32) NOT NULL,
  `DateOfPresentation` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `Scores`
--

CREATE TABLE `Scores` (
  `ID` int(10) UNSIGNED NOT NULL,
  `CourseCode` varchar(7) NOT NULL,
  `MatricNumber` varchar(16) NOT NULL,
  `Session` decimal(8,0) NOT NULL,
  `Semester` tinytext NOT NULL,
  `TotalMark` tinyint(2) NOT NULL,
  `GP` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `backupBiodata`
--
ALTER TABLE `backupBiodata`
  ADD PRIMARY KEY (`MatricNumber`);

--
-- Indexes for table `backupScores`
--
ALTER TABLE `backupScores`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `Biodata`
--
ALTER TABLE `Biodata`
  ADD PRIMARY KEY (`MatricNumber`);

--
-- Indexes for table `Scores`
--
ALTER TABLE `Scores`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `Scores`
--
ALTER TABLE `Scores`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
