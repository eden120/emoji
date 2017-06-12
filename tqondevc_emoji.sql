-- phpMyAdmin SQL Dump
-- version 4.3.8
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 20, 2016 at 10:09 AM
-- Server version: 5.5.51-38.1-log
-- PHP Version: 5.4.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `tqondevc_emoji`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` bigint(20) NOT NULL,
  `name` varchar(30) NOT NULL,
  `image` varchar(100) NOT NULL,
  `deleted` enum('1','2') NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=64 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`, `deleted`, `created`, `modified`) VALUES
(58, 'flag', '1474306900flag.png', '1', '2016-09-19 23:11:40', '0000-00-00 00:00:00'),
(59, 'food', '1474306907food.png', '1', '2016-09-19 23:11:47', '0000-00-00 00:00:00'),
(52, 'chracters', '1474306872chracters.png', '1', '2016-09-10 02:26:04', '2016-09-19 17:41:12'),
(51, 'building', '1474306858building.png', '1', '2016-09-10 02:25:32', '2016-09-19 17:40:58'),
(57, 'face', '1474306889face.png', '1', '2016-09-19 23:11:29', '0000-00-00 00:00:00'),
(56, 'animal', '1474306844animal.png', '1', '2016-09-17 16:57:05', '2016-09-19 17:40:44'),
(60, 'smiley', '1474306920smiley.png', '1', '2016-09-19 23:12:00', '0000-00-00 00:00:00'),
(61, 'sports', '1474306928sports.png', '1', '2016-09-19 23:12:08', '0000-00-00 00:00:00'),
(62, 'vehicles', '1474306937vehicles.png', '1', '2016-09-19 23:12:17', '0000-00-00 00:00:00'),
(63, 'weather', '1474306946weather.png', '1', '2016-09-19 23:12:26', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `images`
--

CREATE TABLE IF NOT EXISTS `images` (
  `id` bigint(20) NOT NULL,
  `image` varchar(100) NOT NULL,
  `category_id` bigint(20) NOT NULL,
  `deleted` enum('1','2') NOT NULL DEFAULT '1',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=48 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `images`
--

INSERT INTO `images` (`id`, `image`, `category_id`, `deleted`, `created`, `modified`) VALUES
(38, '1473456588logo5.png', 52, '1', '2016-09-10 02:59:48', '0000-00-00 00:00:00'),
(39, '1473807486logo5.png', 51, '1', '2016-09-14 04:28:06', '0000-00-00 00:00:00'),
(40, '1473807495Tears_of_Joy_Emoji_8afc0e22-e3d4-4b07-be7f-77296331c687_large.png', 51, '1', '2016-09-14 04:28:15', '0000-00-00 00:00:00'),
(36, '1473455079logo5.png', 52, '1', '2016-09-10 02:34:39', '0000-00-00 00:00:00'),
(34, '1473455020images.jpg', 53, '1', '2016-09-10 02:33:40', '0000-00-00 00:00:00'),
(35, '1473455047PT_hero_42_153645159.jpg', 53, '1', '2016-09-10 02:34:07', '0000-00-00 00:00:00'),
(33, '1473454698unnamed.png', 52, '1', '2016-09-10 02:28:18', '0000-00-00 00:00:00'),
(32, '1473454688Heart_Eyes_Emoji_large.png', 52, '1', '2016-09-10 02:28:08', '0000-00-00 00:00:00'),
(31, '1473454678Tears_of_Joy_Emoji_8afc0e22-e3d4-4b07-be7f-77296331c687_large.png', 52, '1', '2016-09-10 02:27:58', '0000-00-00 00:00:00'),
(30, '1473454667logo5.png', 52, '1', '2016-09-10 02:27:47', '0000-00-00 00:00:00'),
(29, '1473454649PT_hero_42_153645159.jpg', 51, '1', '2016-09-10 02:27:29', '0000-00-00 00:00:00'),
(28, '147345463314203176_1231560736866784_6874077036155816780_n.jpg', 51, '1', '2016-09-10 02:27:13', '0000-00-00 00:00:00'),
(27, '147345461514191989_1211372202238987_1006414670511866605_n.jpg', 51, '1', '2016-09-10 02:26:55', '0000-00-00 00:00:00'),
(41, '1473807510Heart_Eyes_Emoji_large.png', 51, '1', '2016-09-14 04:28:30', '0000-00-00 00:00:00'),
(42, '1473807520unnamed.png', 51, '1', '2016-09-14 04:28:40', '0000-00-00 00:00:00'),
(43, '1473807533images.jpg', 51, '1', '2016-09-14 04:28:53', '0000-00-00 00:00:00'),
(44, '1473807546images.jpg', 51, '1', '2016-09-14 04:29:06', '0000-00-00 00:00:00'),
(45, '147380760914191989_1211372202238987_1006414670511866605_n.jpg', 51, '1', '2016-09-14 04:30:09', '0000-00-00 00:00:00'),
(46, '147380761714203176_1231560736866784_6874077036155816780_n.jpg', 51, '1', '2016-09-14 04:30:17', '0000-00-00 00:00:00'),
(47, '1473807626unnamed.png', 51, '1', '2016-09-14 04:30:26', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_type` enum('1','2') NOT NULL DEFAULT '2' COMMENT '''1-Admin'',''2-User''',
  `deleted` enum('1','2') NOT NULL DEFAULT '1' COMMENT '1 undeleted 2 Deleted',
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `user_type`, `deleted`, `created`, `modified`) VALUES
(1, 'admin@gmail.com', '21232f297a57a5a743894a0e4a801fc3', '1', '1', '0000-00-00 00:00:00', '2016-09-12 17:35:49');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `images`
--
ALTER TABLE `images`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=64;
--
-- AUTO_INCREMENT for table `images`
--
ALTER TABLE `images`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=48;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
