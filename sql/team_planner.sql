-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2017 at 02:20 AM
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
(1, 'Charlyn\'s Group', 'Hello friends!', '', 1),
(2, 'Test\'s Group', 'Hello test', '', 0),
(3, 'Rylee\'s Group', 'Awesome', '', 1),
(4, 'New', 'Test lol hi xD', '', 1),
(6, 'Awesome Group XD', 'XD lol', '', 1);

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
(1, 3, 1, 1, 1),
(2, 1, 1, 1, 1),
(3, 2, 1, 2, 0),
(4, 1, 2, 1, 1),
(5, 3, 2, 2, 1),
(6, 2, 2, 2, 1),
(7, 2, 3, 1, 1),
(8, 3, 3, 2, 1),
(9, 1, 3, 2, 1),
(10, 3, 4, 1, 1),
(11, 1, 4, 2, 2),
(12, 2, 4, 2, 1),
(13, 2, 6, 1, 1),
(14, 1, 6, 2, 2),
(15, 3, 6, 2, 1);

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
(1, 'Sleep', 'Sleep well', 1, 3, 3, 1510574960, 1510576200, 1510579713, 1510579720, 9),
(2, 'Code', 'Finish projects', 1, 3, 2, 1510579184, 1510588740, 0, 1510595520, 8),
(3, 'Apple', 'Red', 2, 2, 2, 1510594773, 1510603380, 1510595046, 1510595070, 9),
(4, 'Apple', 'test', 1, 2, 2, 1510595501, 1510675200, 0, 1510595754, 9),
(5, 'Wow', 'Ok', 6, 3, 3, 1510596047, 1510804800, 0, 0, 2),
(7, 'test', 'new', 2, 1, 1, 1510597803, 1510761600, 1510597807, 0, 3),
(8, 'Finish assignment', 'Finish psych', 1, 3, 3, 1510631976, 1510675200, 1510631990, 1510632000, 9);

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
(1, 'test', '$2y$10$GPgXJJDOMuFNiR6T82SkYutSgWclTA0ELcjUqBDnivcj/0Vj8kIfG', 'Jefferson', 'Rylee', 'test@email.com', '', '', 2, '', '', 0, 1),
(2, 'rylee', '$2y$10$GPgXJJDOMuFNiR6T82SkYutSgWclTA0ELcjUqBDnivcj/0Vj8kIfG', 'Test', 'User', 'test@sample.com', '', '', 2, '', '', 0, 1),
(3, 'charlyn', '$2y$10$ico/hoXQ9ywrfhyEFk2yGudL1UC.s2xkqsDSyhxwT3ExjaDgrzoZS', 'Charlyn', 'Ann', 'rylee.jeff385@gmail.com', 'Hi new bio here', '', 2, '', '', 0, 1);

--
-- Indexes for dumped tables
--

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
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
