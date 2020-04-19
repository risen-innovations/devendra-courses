-- phpMyAdmin SQL Dump
-- version 4.9.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 10, 2020 at 11:43 AM
-- Server version: 10.4.8-MariaDB
-- PHP Version: 7.3.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tms`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(10) UNSIGNED NOT NULL,
  `course_code` smallint(5) UNSIGNED NOT NULL,
  `short_form` varchar(5) NOT NULL,
  `course_name` varchar(128) NOT NULL,
  `course_description` varchar(256) DEFAULT NULL,
  `trade_type` tinyint(3) UNSIGNED NOT NULL,
  `trade_category` tinyint(3) UNSIGNED NOT NULL,
  `trade_level` tinyint(1) UNSIGNED NOT NULL COMMENT '1:tradesman,2:foreman,3:upgrade',
  `course_mode` tinyint(1) UNSIGNED NOT NULL COMMENT '1:FC+SA,2:SA,3:SECK,4:WSQ',
  `assessment_mode` tinyint(1) UNSIGNED NOT NULL COMMENT '1:written,2:practical,3:both',
  `course_duration_theory` tinyint(2) UNSIGNED DEFAULT NULL,
  `course_duration_practical` tinyint(2) UNSIGNED DEFAULT NULL,
  `training_fees` decimal(10,0) UNSIGNED DEFAULT NULL,
  `test_fees` decimal(10,0) UNSIGNED DEFAULT NULL,
  `language` tinyint(2) UNSIGNED NOT NULL COMMENT '1:English, 2:Bengali, 3:Tamil, 4:Chinese, 5:Burmese, 6:Thai, 7:Hindi, 8:Malay',
  `datetime_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `datetime_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_code`, `short_form`, `course_name`, `course_description`, `trade_type`, `trade_category`, `trade_level`, `course_mode`, `assessment_mode`, `course_duration_theory`, `course_duration_practical`, `training_fees`, `test_fees`, `language`, `datetime_created`, `datetime_updated`) VALUES
(1, 1, 'CS101', 'Computer Science', 'Computer Science', 1, 1, 1, 1, 1, 1, 1, '5000', '3000', 1, '2020-03-10 07:41:41', '2020-03-10 07:41:41'),
(2, 2, 'CT101', 'Computer Technology', 'Computer Technology', 1, 1, 1, 1, 1, 1, 1, '5000', '3000', 1, '2020-03-10 07:42:31', '2020-03-10 07:42:31'),
(3, 3, 'CS102', 'Database Management', 'DBM', 1, 1, 1, 1, 1, 1, 1, '4000', '2000', 1, '2020-03-10 08:02:59', '2020-03-10 08:12:33');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
