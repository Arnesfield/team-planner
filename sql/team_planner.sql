-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 16, 2017 at 09:00 AM
-- Server version: 10.1.25-MariaDB
-- PHP Version: 7.1.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `team_planner`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int(11) NOT NULL,
  `remarks` text NOT NULL,
  `type` tinyint(4) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `activities`
--

INSERT INTO `activities` (`id`, `remarks`, `type`, `date`) VALUES
(1, 'Somebody created an account with email \"rylee.jeff385@gmail.com\".', 3, 1510812865),
(2, 'User 1 account verified.', 4, 1510812873),
(3, 'Logged in User 1.', 1, 1510812877),
(4, 'Logged out User 1.', 2, 1510812889),
(5, 'Somebody created an account with email \"rylee.jeff385@gmail.com\".', 3, 1510812967),
(6, 'User 2 unverified account login attempt.', 1, 1510812987),
(7, 'User 2 account verified.', 4, 1510812997),
(8, 'Logged in User 2.', 1, 1510813006),
(9, 'User 2 created a group. Group 1.', 6, 1510813050),
(10, 'User 2 joined in Group 1.', 8, 1510813051),
(11, 'User 1 added in Group 1.', 8, 1510813051),
(12, 'Logged out User 2.', 2, 1510813059),
(13, 'Logged in User 1.', 1, 1510813062),
(14, 'Logged out User 1.', 2, 1510813095),
(15, 'Logged in User 1.', 1, 1510813097),
(16, 'User 1 updated Member 2 status information.', 16, 1510813109),
(17, 'User 1 updated Member 2 type information.', 16, 1510813133),
(18, 'Logged out User 1.', 2, 1510813148),
(19, 'Logged in User 1.', 1, 1510813151),
(20, 'User 1 updated profile information.', 5, 1510813167),
(21, 'User 1 updated profile information.', 5, 1510813190),
(22, 'User 1 updated Member 2 type information.', 16, 1510813324),
(23, 'User 1 created a task for User 1.', 10, 1510813359),
(24, 'User 1 updated Task 1 status to Ongoing.', 11, 1510813405),
(25, 'Logged out User 1.', 2, 1510817746);

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `title` varchar(32) NOT NULL,
  `content` text NOT NULL,
  `type` tinyint(4) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `title`, `content`, `type`, `status`) VALUES
(1, 'Home', 'Hello World', 1, 1),
(2, 'About', 'About page', 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` text NOT NULL,
  `g_image` varchar(32) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`, `g_image`, `status`) VALUES
(1, 'Rylee\'s Group', 'Rylee\'s Group of \"Awesomenezz\"', 'IMG_161117141730.png', 1);

-- --------------------------------------------------------

--
-- Table structure for table `memberships`
--

CREATE TABLE `memberships` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `memberships`
--

INSERT INTO `memberships` (`id`, `user_id`, `group_id`, `type`, `status`) VALUES
(1, 2, 1, 1, 1),
(2, 1, 1, 2, 1);

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `group_id` int(11) NOT NULL,
  `created_by_user_id` int(11) NOT NULL,
  `taken_by_user_id` int(11) NOT NULL,
  `created_at` int(11) NOT NULL,
  `deadline_at` int(11) NOT NULL,
  `started_at` int(11) NOT NULL,
  `ended_at` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `name`, `description`, `group_id`, `created_by_user_id`, `taken_by_user_id`, `created_at`, `deadline_at`, `started_at`, `ended_at`, `status`) VALUES
(1, 'Finish assignment', 'Hi', 1, 1, 1, 1510813359, 1510848000, 1510813405, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(32) NOT NULL,
  `password` varchar(255) NOT NULL,
  `fname` varchar(128) NOT NULL,
  `lname` varchar(128) NOT NULL,
  `email` varchar(128) NOT NULL,
  `bio` text NOT NULL,
  `u_image` varchar(32) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `verification_code` varchar(32) NOT NULL,
  `reset_code` varchar(32) NOT NULL,
  `reset_expiration` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `fname`, `lname`, `email`, `bio`, `u_image`, `type`, `verification_code`, `reset_code`, `reset_expiration`, `status`) VALUES
(1, 'charlyn', '$2y$10$d/46JkJivDqU9Bh7v0f6YOi4C5nXZDQEngMaE4OEl2AGm7ykViqHC', 'Charlyn', 'Ann', 'charlyn@test.com', 'Some bio here', 'IMG_161117141950.png', 1, '', '', 0, 1),
(2, 'rylee', '$2y$10$v4FBG3fw9MvpdfcReAs3sesbiHZKgTNyoJ6VqnEMGGSKMcMJ5Gbu.', 'Jefferson', 'Rylee', 'rylee.jeff385@gmail.com', 'Some rylee bio', 'IMG_161117141551.png', 2, '', '', 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `memberships`
--
ALTER TABLE `memberships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
