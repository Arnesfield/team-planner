-- phpMyAdmin SQL Dump
-- version 4.7.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 17, 2017 at 04:21 PM
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
(25, 'Logged out User 1.', 2, 1510817746),
(26, 'Logged in User 1.', 1, 1510819820),
(27, 'Logged out User 1.', 2, 1510826472),
(28, 'Logged in User 1.', 1, 1510828700),
(29, 'User 1 updated Content 2 type information.', 17, 1510830254),
(30, 'User 1 updated Content 1 type information.', 17, 1510830254),
(31, 'User 1 updated Content 1 type information.', 17, 1510830288),
(32, 'User 1 updated Content 2 type information.', 17, 1510830288),
(33, 'User 1 updated Content 2 type information.', 17, 1510830313),
(34, 'User 1 updated Content 1 type information.', 17, 1510830313),
(35, 'User 1 updated Content 1 type information.', 17, 1510830315),
(36, 'User 1 updated Content 2 type information.', 17, 1510830315),
(37, 'User 1 updated Content 2 type information.', 17, 1510830698),
(38, 'User 1 updated Content 1 type information.', 17, 1510830698),
(39, 'User 1 updated Content 1 type information.', 17, 1510830698),
(40, 'User 1 updated Content 2 type information.', 17, 1510830699),
(41, 'User 1 updated Content  status information.', 17, 1510830838),
(42, 'User 1 updated Content  status information.', 17, 1510830841),
(43, 'User 1 updated Content  status information.', 17, 1510830868),
(44, 'User 1 updated Content  status information.', 17, 1510830941),
(45, 'User 1 updated Content  status information.', 17, 1510830960),
(46, 'User 1 updated Content  status information.', 17, 1510831000),
(47, 'User 1 updated Content  status information.', 17, 1510831006),
(48, 'User 1 updated Content 2 type information.', 17, 1510831112),
(49, 'User 1 updated Content 1 type information.', 17, 1510831113),
(50, 'User 1 updated Content 1 type information.', 17, 1510831114),
(51, 'User 1 updated Content 2 type information.', 17, 1510831114),
(52, 'User 1 updated Content  status information.', 17, 1510831116),
(53, 'User 1 updated Content 1 status information.', 17, 1510831141),
(54, 'User 1 updated Content 1 status information.', 17, 1510831157),
(55, 'User 1 updated Content 1 status information.', 17, 1510831162),
(56, 'User 1 updated Content 1 status information.', 17, 1510831163),
(57, 'User 1 updated Content 2 status information.', 17, 1510831163),
(58, 'User 1 updated Content 2 status information.', 17, 1510831164),
(59, 'User 1 updated Content 1 status information.', 17, 1510832012),
(60, 'Logged out User 1.', 2, 1510832020),
(61, 'Logged in User 1.', 1, 1510832064),
(62, 'User 1 updated Content 1 status information.', 17, 1510832070),
(63, 'User 1 updated Content 2 type information.', 17, 1510832072),
(64, 'User 1 updated Content 1 type information.', 17, 1510832072),
(65, 'Logged out User 1.', 2, 1510832073),
(66, 'Logged in User 1.', 1, 1510832114),
(67, 'User 1 updated Content 1 status information.', 17, 1510832121),
(68, 'Logged out User 1.', 2, 1510832122),
(69, 'Logged in User 1.', 1, 1510832135),
(70, 'User 1 updated Content 1 type information.', 17, 1510832141),
(71, 'User 1 updated Content 2 type information.', 17, 1510832141),
(72, 'User 1 updated Content 1 status information.', 17, 1510832142),
(73, 'User 1 updated Content 2 information.', 18, 1510832157),
(74, 'User 1 updated Content 1 information.', 18, 1510832157),
(75, 'User 1 added Content  information.', 18, 1510832157),
(76, 'User 1 updated Content 3 information.', 18, 1510832757),
(77, 'User 1 updated Content 4 status information.', 17, 1510832809),
(78, 'User 1 updated Content 4 status information.', 17, 1510832810),
(79, 'User 1 updated Content 4 status information.', 17, 1510832869),
(80, 'User 1 updated Content 4 type information.', 17, 1510832871),
(81, 'User 1 updated Content 1 type information.', 17, 1510832871),
(82, 'User 1 added Content 4 information.', 18, 1510832881),
(83, 'User 1 updated Content 4 status information.', 17, 1510832888),
(84, 'User 1 added Content 2 information.', 18, 1510832950),
(85, 'Logged out User 1.', 2, 1510832952),
(86, 'Logged in User 1.', 1, 1510833020),
(87, 'User 1 added Content 3 information.', 18, 1510833024),
(88, 'Logged out User 1.', 2, 1510833030),
(89, 'Logged in User 1.', 1, 1510833036),
(90, 'User 1 updated Content 3 status information.', 17, 1510833041),
(91, 'Logged out User 1.', 2, 1510833045),
(92, 'Logged in User 1.', 1, 1510833051),
(93, 'User 1 updated Content 1 information.', 18, 1510835633),
(94, 'Logged out User 1.', 2, 1510835643),
(95, 'Logged in User 1.', 1, 1510835651),
(96, 'User 1 updated Content 1 information.', 18, 1510835671),
(97, 'Logged out User 1.', 2, 1510835673),
(98, 'Logged in User 1.', 1, 1510835684),
(99, 'User 1 updated Content 1 information.', 18, 1510835768),
(100, 'Logged out User 1.', 2, 1510835773),
(101, 'Logged in User 1.', 1, 1510835777),
(102, 'User 1 updated Content 1 information.', 18, 1510835824),
(103, 'Logged out User 1.', 2, 1510835827),
(104, 'Logged in User 1.', 1, 1510845636),
(105, 'Logged out User 1.', 2, 1510845754),
(106, 'Logged in User 2.', 1, 1510845775),
(107, 'Logged out User 2.', 2, 1510848834),
(108, 'Logged in User 1.', 1, 1510848839),
(109, 'User 1 created a group. Group 2.', 6, 1510849251),
(110, 'User 1 joined in Group 2.', 8, 1510849251),
(111, 'User 2 added in Group 2.', 8, 1510849251),
(112, 'Logged out User 1.', 2, 1510849807),
(113, 'Logged in User 2.', 1, 1510849844),
(114, 'Logged out User 2.', 2, 1510849869),
(115, 'Logged in User 1.', 1, 1510850571),
(116, 'User 1 updated Group 2 information and/or members.', 7, 1510852355),
(117, 'User 1 updated Group 2 information and/or members.', 7, 1510852360),
(118, 'User 1 updated Group 2 information and/or members.', 7, 1510853354),
(119, 'User 2 updated/added in Group 2 by User 1.', 8, 1510855128),
(120, 'User 1 created a group. Group 3.', 6, 1510855187),
(121, 'User 1 joined in Group 3.', 8, 1510855187),
(122, 'User 1 created a task for User 1.', 10, 1510856076),
(123, 'User 1 created a task for User 1.', 10, 1510857354),
(124, 'User 1 updated Task 3 status to Ongoing.', 11, 1510857762),
(125, 'User 1 created a task for User 2.', 10, 1510858229),
(126, 'Logged out User 1.', 2, 1510858245),
(127, 'Logged in User 2.', 1, 1510858249),
(128, 'Logged out User 2.', 2, 1510858483),
(129, 'Logged in User 1.', 1, 1510858486),
(130, 'User 1 created a group. Group 4.', 6, 1510858511),
(131, 'User 1 joined in Group 4.', 8, 1510858511),
(132, 'User 2 added in Group 4.', 8, 1510858511),
(133, 'User 1 created a group. Group 5.', 6, 1510858535),
(134, 'User 1 joined in Group 5.', 8, 1510858535),
(135, 'User 2 added in Group 5.', 8, 1510858535),
(136, 'User 1 updated Group 2 information and/or members.', 7, 1510858547),
(137, 'User 2 updated/added in Group 2 by User 1.', 8, 1510858553),
(138, 'Logged out User 1.', 2, 1510858554),
(139, 'Logged in User 2.', 1, 1510858557),
(140, 'User 2 joined in Group 5.', 8, 1510858724),
(141, 'User 2 joined in Group 4.', 8, 1510858727),
(142, 'User 2 joined in Group 2.', 8, 1510858729),
(143, 'Logged out User 2.', 2, 1510859752),
(144, 'Logged in User 1.', 1, 1510859754),
(145, 'User 1 updated Content 1 information.', 18, 1510859825),
(146, 'User 1 updated Content 2 information.', 18, 1510859825),
(147, 'Logged out User 1.', 2, 1510859863),
(148, 'Logged in User 1.', 1, 1510859871),
(149, 'User 1 updated Content 1 information.', 18, 1510859898),
(150, 'User 1 updated Content 2 information.', 18, 1510859899),
(151, 'Logged out User 1.', 2, 1510859906),
(152, 'Logged in User 1.', 1, 1510859919),
(153, 'User 1 created a task for User 1.', 10, 1510860011),
(154, 'Logged out User 1.', 2, 1510860087),
(155, 'Logged in User 1.', 1, 1510860109),
(156, 'User 1 updated Content 2 status information.', 17, 1510860357),
(157, 'User 1 updated Content 2 status information.', 17, 1510860359),
(158, 'User 1 updated Content 2 status information.', 17, 1510860360),
(159, 'User 1 updated Content 2 status information.', 17, 1510860361),
(160, 'User 1 updated Content 2 status information.', 17, 1510860375),
(161, 'User 1 updated Content 2 status information.', 17, 1510860385),
(162, 'User 1 updated Content 2 status information.', 17, 1510860386),
(163, 'User 1 updated Content 2 status information.', 17, 1510860409),
(164, 'User 1 updated Content 2 status information.', 17, 1510860410),
(165, 'User 1 updated Content 1 status information.', 17, 1510860411),
(166, 'User 1 updated Content 1 status information.', 17, 1510860412),
(167, 'User 1 updated Content 2 status information.', 17, 1510860413),
(168, 'User 1 updated Content 2 type information.', 17, 1510860498),
(169, 'User 1 updated Content 1 type information.', 17, 1510860498),
(170, 'User 1 updated Content 1 type information.', 17, 1510860500),
(171, 'User 1 updated Content 2 type information.', 17, 1510860500),
(172, 'User 1 updated Content 2 type information.', 17, 1510860501),
(173, 'User 1 updated Content 1 type information.', 17, 1510860501),
(174, 'User 1 updated Content 1 type information.', 17, 1510860502),
(175, 'User 1 updated Content 2 type information.', 17, 1510860502),
(176, 'User 1 updated Content 2 type information.', 17, 1510860508),
(177, 'User 1 updated Content 1 type information.', 17, 1510860508),
(178, 'Logged out User 1.', 2, 1510860513),
(179, 'Logged in User 1.', 1, 1510860519),
(180, 'User 1 updated Content 1 type information.', 17, 1510860530),
(181, 'User 1 updated Content 2 type information.', 17, 1510860530),
(182, 'User 1 updated User 2 type information.', 14, 1510860625),
(183, 'User 1 updated User 2 type information.', 14, 1510860625),
(184, 'User 1 updated User 2 type information.', 14, 1510860733),
(185, 'User 1 updated User 2 type information.', 14, 1510860733),
(186, 'User 1 updated User 2 type information.', 14, 1510860841),
(187, 'User 1 updated User 2 type information.', 14, 1510860841),
(188, 'User 1 updated User 2 status information.', 14, 1510860842),
(189, 'User 1 updated User 2 status information.', 14, 1510860843),
(190, 'Logged out User 1.', 2, 1510861614),
(191, 'Logged in User 1.', 1, 1510881924),
(192, 'User 1 updated User 2 type information.', 14, 1510882139),
(193, 'User 1 updated User 2 type information.', 14, 1510882144),
(194, 'Logged out User 1.', 2, 1510882280),
(195, 'Logged in User 1.', 1, 1510882287),
(196, 'Logged out User 1.', 2, 1510882291),
(197, 'Logged in User 3.', 1, 1510882297),
(198, 'Logged out User 3.', 2, 1510882304),
(199, 'Logged in User 1.', 1, 1510882309),
(200, 'Logged in User 1.', 1, 1510883475),
(201, 'User 2 asked for password reset link using email \"rylee.jeff385@gmail.com\".', 5, 1510917475),
(202, 'User 2 account reset password.', 5, 1510918155),
(203, 'Logged in User 1.', 1, 1510918166),
(204, 'Logged out User 1.', 2, 1510918168),
(205, 'Logged in User 2.', 1, 1510918175),
(206, 'User 2 updated Task 4 status to Ongoing.', 11, 1510918267),
(207, 'User 2 updated Task 4 status to Discontinued.', 13, 1510918275),
(208, 'Logged out User 2.', 2, 1510918287),
(209, 'Logged in User 1.', 1, 1510918291),
(210, 'Logged out User 1.', 2, 1510918310),
(211, 'Logged in User 1.', 1, 1510919029),
(212, 'User 1 updated profile information.', 5, 1510919179),
(213, 'Logged out User 1.', 2, 1510919366),
(214, 'Logged in User 1.', 1, 1510919689),
(215, 'User 1 updated User 2 status information.', 14, 1510920348),
(216, 'User 1 updated User 2 status information.', 14, 1510920348),
(217, 'User 1 updated User 2 status information.', 14, 1510920351),
(218, 'User 1 updated User 2 status information.', 14, 1510920354),
(219, 'User 1 updated User 2 status information.', 14, 1510920357),
(220, 'User 1 updated User 2 status information.', 14, 1510920410),
(221, 'User 1 updated Member 4 status information.', 16, 1510920431),
(222, 'User 2 updated/added in Group 2 by User 1.', 8, 1510921513),
(223, 'User 2 updated/added in Group 2 by User 1.', 8, 1510921997),
(224, 'User 3 added in Group 2 by User 1.', 8, 1510921997),
(225, 'Logged out User 1.', 2, 1510922062),
(226, 'Logged in User 1.', 1, 1510922082),
(227, 'User 1 updated Group 2 information and/or members.', 7, 1510922154),
(228, 'User 1 updated Member 10 status information.', 16, 1510922235),
(229, 'User 1 updated Group 2 information and/or members.', 7, 1510922283),
(230, 'User 1 updated Group 2 information and/or members.', 7, 1510922479),
(231, 'Logged out User 1.', 2, 1510926564),
(232, 'User 2 asked for password reset link using email \"rylee.jeff385@gmail.com\".', 5, 1510927673),
(233, 'User 2 asked for password reset link using email \"rylee.jeff385@gmail.com\".', 5, 1510927816),
(234, 'User 2 asked for password reset link using email \"rylee.jeff385@gmail.com\".', 5, 1510929027),
(235, 'User 2 asked for password reset link using email \"rylee.jeff385@gmail.com\".', 5, 1510929519),
(236, 'User 2 asked for password reset link using email \"rylee.jeff385@gmail.com\".', 5, 1510930405),
(237, 'Logged in User 3.', 1, 1510931062),
(238, 'Logged out User 3.', 2, 1510931068),
(239, 'Logged in User 1.', 1, 1510931071),
(240, 'Logged out User 1.', 2, 1510931709),
(241, 'Logged in User 1.', 1, 1510931814),
(242, 'User 1 updated Content 1 information.', 18, 1510932027),
(243, 'Logged out User 1.', 2, 1510932034);

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
(1, 'Home', '<h1 style=\"text-align: center; \">Welcome to Team-Planner!</h1><h5 style=\"text-align: center; \">Welcome!&nbsp; Team planner allows you to:</h5><p style=\"text-align: center; \"><br></p><h4 style=\"text-align: center; \">1.&nbsp;<span style=\"font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</span></h4><h4 style=\"text-align: center; \"><span style=\"font-family: &quot;Open Sans&quot;, Arial, sans-serif; text-align: justify;\">2.&nbsp;</span>Sed eget consequat nisl, vel scelerisque leo.</h4><h4 style=\"color: rgb(0, 0, 0); text-align: center;\">3. Aenean ac convallis nibh, id accumsan lectus.</h4><p style=\"color: rgb(0, 0, 0); text-align: center;\"><br></p><p style=\"color: rgb(0, 0, 0); text-align: center;\">Enjoy!</p>', 1, 1),
(2, 'About', '<h1>Hello about page</h1><p><br></p><ol><li>We are awesome</li><li>So cool</li><li>Ok</li></ol>', 2, 1),
(3, '', '', 2, 0);

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
(1, 'Rylee\'s Group', 'Rylee\'s Group of \"Awesomenezz\"', 'IMG_161117141730.png', 1),
(2, 'Charlyn Ann', 'Charlyn\'s Group of Awesome', 'IMG_171117002049.png', 1),
(3, 'Strawberry', 'Straw', 'IMG_171117015947.png', 1),
(4, 'New Group xD', 'Lol', 'IMG_171117025511.jpg', 1),
(5, 'Other Group', 'xD', 'IMG_171117025534.png', 1);

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
(2, 1, 1, 2, 1),
(3, 1, 2, 1, 1),
(4, 2, 2, 2, 0),
(5, 1, 3, 1, 1),
(6, 1, 4, 1, 1),
(7, 2, 4, 2, 1),
(8, 1, 5, 1, 1),
(9, 2, 5, 2, 1),
(10, 3, 2, 1, 1);

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
(1, 'Finish assignment', 'Hi', 1, 1, 1, 1510813359, 1510848000, 1510813405, 0, 3),
(2, 'Finish assignment', 'Test', 3, 1, 1, 1510856076, 1511280000, 0, 0, 2),
(3, 'Something', 'Task', 1, 1, 1, 1510857354, 1511456400, 1510857762, 0, 3),
(4, 'New', 'Tast', 1, 1, 2, 1510858229, 1511971200, 1510918266, 1510918274, 8),
(5, 'Psych Hw of Rylee', 'Hehe', 1, 1, 1, 1510860011, 1510966800, 0, 0, 2);

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
(1, 'charlyn', '$2y$10$d/46JkJivDqU9Bh7v0f6YOi4C5nXZDQEngMaE4OEl2AGm7ykViqHC', 'Charlyn', 'Ann', 'charlyn@test.com', 'Some bio here', '', 1, '', '', 0, 1),
(2, 'rylee', '$2y$10$xU9ECURnRCthbq8/6D2g9u4B8KOM2OIHcCR.g8DDRlbb17iL9yVHy', 'Jefferson', 'Rylee', 'rylee.jeff385@gmail.com', 'Some rylee bio', 'IMG_161117141551.png', 2, '', 'eafdc0efaa12151d', 1510932200, 1),
(3, 'test', '$2y$10$v4FBG3fw9MvpdfcReAs3sesbiHZKgTNyoJ6VqnEMGGSKMcMJ5Gbu.', 'John', 'Smith', 'jsmith@email.com', 'Some bio of smith', '', 2, '', '', 0, 1);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=244;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `memberships`
--
ALTER TABLE `memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
