-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 15, 2024 at 12:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ccs_events_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `student_id` int(11) NOT NULL,
  `event_code` varchar(255) NOT NULL,
  `attendance_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `student_id`, `event_code`, `attendance_time`) VALUES
(4, 210664256, '1011', '2024-06-15 09:41:09'),
(5, 210664256, '1011', '2024-06-15 09:43:03'),
(6, 3, '1011', '2024-06-15 09:45:46'),
(7, 212100, '1011', '2024-06-15 09:47:40');

-- --------------------------------------------------------

--
-- Table structure for table `ccsstudent_list`
--

CREATE TABLE `ccsstudent_list` (
  `id` int(11) NOT NULL,
  `student_id` varchar(255) NOT NULL,
  `student_firstname` varchar(255) NOT NULL,
  `student_lastname` varchar(255) NOT NULL,
  `student_yearlevel` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `ccsstudent_list`
--

INSERT INTO `ccsstudent_list` (`id`, `student_id`, `student_firstname`, `student_lastname`, `student_yearlevel`, `user_id`) VALUES
(1, '000001', 'FirstName', 'LastName', '2', 2),
(2, '000002', 'Jamesdenn', 'Lagrama', '4', 4),
(3, '000003', 'Firstname3', 'Lastname3', '1', 8),
(4, '210664256', 'Aaron', 'Salagubang', '3', 9),
(5, '212100', 'Angelo', 'Palma', '3', 10);

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `venue` text NOT NULL,
  `start_datetime` datetime NOT NULL,
  `end_datetime` datetime NOT NULL,
  `create_user_id` int(11) NOT NULL,
  `update_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `code`, `venue`, `start_datetime`, `end_datetime`, `create_user_id`, `update_user_id`, `created_at`, `updated_at`) VALUES
(1, 'Event 1', '1011', 'Event 1 Venu', '2024-06-10 14:01:40', '2024-06-10 14:01:40', 3, 3, '2024-06-10 22:02:33', '2024-06-10 22:02:33'),
(2, 'Event 2', '1012', 'Event 2 Venue', '2024-06-10 14:03:20', '2024-06-10 14:03:20', 3, 3, '2024-06-10 22:03:33', '2024-06-10 22:03:33'),
(3, '21', '2121', '21', '2024-06-15 00:21:00', '2024-06-15 11:18:45', 3, 3, '2024-06-15 17:18:56', '2024-06-15 17:19:40');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password_hash` text NOT NULL,
  `is_admin` int(11) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password_hash`, `is_admin`, `created_at`, `updated_at`) VALUES
(2, 'robin.correa21@gmail.com', '202cb962ac59075b964b07152d234b70', 0, '2024-05-11 21:11:44', '2024-05-11 21:20:49'),
(3, 'jamesden@gmail.com', '250cf8b51c773f3f8dc8b4be867a9a02', 1, '2024-05-11 21:16:38', '2024-05-11 21:20:33'),
(4, 'jamesden2@gmail.com', '250cf8b51c773f3f8dc8b4be867a9a02', 0, '2024-06-12 21:01:22', '2024-06-12 21:01:28'),
(8, 'jamesden3@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 0, '2024-06-12 21:28:55', '2024-06-12 21:28:55'),
(9, 'aaron21@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 0, '2024-06-13 22:34:52', '2024-06-13 22:34:52'),
(10, 'angelopalma@gmail.com', '5f4dcc3b5aa765d61d8327deb882cf99', 0, '2024-06-15 15:47:20', '2024-06-15 15:47:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ccsstudent_list`
--
ALTER TABLE `ccsstudent_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `ccsstudent_list`
--
ALTER TABLE `ccsstudent_list`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
