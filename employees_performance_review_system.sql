-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 19, 2021 at 05:10 PM
-- Server version: 10.4.20-MariaDB
-- PHP Version: 8.0.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `employees_performance_review_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `comment` longtext NOT NULL,
  `time` datetime NOT NULL,
  `employeesid` int(11) NOT NULL,
  `postid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `daily_work`
--

CREATE TABLE `daily_work` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `time` datetime NOT NULL,
  `deadline` datetime NOT NULL,
  `submission_time` datetime DEFAULT NULL,
  `project_point` int(11) NOT NULL,
  `employeesid` int(11) NOT NULL,
  `isSubmitted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `employees`
--

CREATE TABLE `employees` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(64) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `country` varchar(255) NOT NULL DEFAULT 'Bangladesh',
  `points` int(11) NOT NULL DEFAULT 0,
  `join_date` datetime NOT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'employee'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `employees`
--

INSERT INTO `employees` (`id`, `name`, `email`, `password`, `phone`, `country`, `points`, `join_date`, `type`) VALUES
(1, 'System User', 'systemuser@gmail.com', '$2y$10$TKGftWC3rMSoXakJnJpBJejuNHdFu10b1n75DQmKZewnNJropR1K.', '123123123123123', 'asd', 0, '2021-09-15 22:56:02', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `time` datetime NOT NULL,
  `point` int(11) DEFAULT NULL,
  `employeesid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `report`
--

CREATE TABLE `report` (
  `id` int(11) NOT NULL,
  `reported_to` int(11) DEFAULT NULL,
  `time` datetime NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `employeesid` int(11) NOT NULL,
  `admin_feedback` longtext DEFAULT NULL,
  `feedback_from_reported` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `task_by_others`
--

CREATE TABLE `task_by_others` (
  `id` int(11) NOT NULL,
  `submittedBy` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext NOT NULL,
  `deadline` datetime NOT NULL,
  `time` datetime NOT NULL,
  `submission_time` datetime DEFAULT NULL,
  `points` int(11) NOT NULL DEFAULT 0,
  `employeesid` int(11) DEFAULT NULL,
  `isSubmitted` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKcomment362862` (`employeesid`),
  ADD KEY `FKcomment601927` (`postid`);

--
-- Indexes for table `daily_work`
--
ALTER TABLE `daily_work`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKdaily_work185479` (`employeesid`);

--
-- Indexes for table `employees`
--
ALTER TABLE `employees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `phone` (`phone`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKpost589699` (`employeesid`);

--
-- Indexes for table `report`
--
ALTER TABLE `report`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FKreport559129` (`employeesid`);

--
-- Indexes for table `task_by_others`
--
ALTER TABLE `task_by_others`
  ADD UNIQUE KEY `id` (`id`),
  ADD KEY `employeesid` (`employeesid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `daily_work`
--
ALTER TABLE `daily_work`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `employees`
--
ALTER TABLE `employees`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `report`
--
ALTER TABLE `report`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `task_by_others`
--
ALTER TABLE `task_by_others`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `FKcomment362862` FOREIGN KEY (`employeesid`) REFERENCES `employees` (`id`),
  ADD CONSTRAINT `FKcomment601927` FOREIGN KEY (`postid`) REFERENCES `post` (`id`);

--
-- Constraints for table `daily_work`
--
ALTER TABLE `daily_work`
  ADD CONSTRAINT `FKdaily_work185479` FOREIGN KEY (`employeesid`) REFERENCES `employees` (`id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `FKpost589699` FOREIGN KEY (`employeesid`) REFERENCES `employees` (`id`);

--
-- Constraints for table `report`
--
ALTER TABLE `report`
  ADD CONSTRAINT `FKreport559129` FOREIGN KEY (`employeesid`) REFERENCES `employees` (`id`);

--
-- Constraints for table `task_by_others`
--
ALTER TABLE `task_by_others`
  ADD CONSTRAINT `task_by_others_ibfk_1` FOREIGN KEY (`employeesid`) REFERENCES `employees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
