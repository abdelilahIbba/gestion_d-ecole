-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2024 at 11:28 AM
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
-- Database: `gdecole`
--

-- --------------------------------------------------------

--
-- Table structure for table `departments`
--

CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `remarks` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `departments`
--

INSERT INTO `departments` (`id`, `name`, `remarks`) VALUES
(4, 'Amire El', 'Amire Hafd El Ibbawi'),
(5, 'Amire', 'Amire Hafd El Ibbawi'),
(6, 'fati', 'fatima zahra el ibbawi'),
(7, 'abdelilah', 'abdelilh el ibbawi'),
(8, 'yousra', 'hahkl'),
(9, 'walid', 'makash remak');

-- --------------------------------------------------------

--
-- Table structure for table `marks`
--

CREATE TABLE `marks` (
  `id` int(11) NOT NULL,
  `NStudent` varchar(255) NOT NULL,
  `Subject` varchar(255) NOT NULL,
  `Marks` varchar(255) NOT NULL,
  `Comment` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `marks`
--

INSERT INTO `marks` (`id`, `NStudent`, `Subject`, `Marks`, `Comment`) VALUES
(7, 'abdelilah el', 'jjjj', 'hhhhhh', 'jnec'),
(8, 'amire', 'abndj', 'djhk', 'ccccccccccc'),
(9, 'hfckujtc', 'mhfxhm', 'jyf,ykf', 'khkyfykfvh'),
(10, 'yes', 'kjhhd', 'jhwnjk', 'ghdjh cjsk'),
(11, 'yesjk', 'jjjj', 'djhk', 'popopopopopopopo'),
(12, 'walid', 'math', 'hhh', 'jjjj');

-- --------------------------------------------------------

--
-- Table structure for table `schedules`
--

CREATE TABLE `schedules` (
  `ScheduleID` int(11) NOT NULL,
  `DepartmentName` varchar(255) NOT NULL,
  `Day` varchar(255) NOT NULL,
  `FirstSlot` varchar(255) DEFAULT NULL,
  `SecondSlot` varchar(255) DEFAULT NULL,
  `ThirdSlot` varchar(255) DEFAULT NULL,
  `FourthSlot` varchar(255) DEFAULT NULL,
  `FifthSlot` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `schedules`
--

INSERT INTO `schedules` (`ScheduleID`, `DepartmentName`, `Day`, `FirstSlot`, `SecondSlot`, `ThirdSlot`, `FourthSlot`, `FifthSlot`) VALUES
(3, 'Sciences', 'Monday', 'Math', 'English', 'Arabic', 'Geography', 'History'),
(4, 'Arts', 'Tuesday', 'Networking', 'Cumputer', 'History', 'Geography', 'Arabic'),
(7, 'Sport', 'Wednesday', 'Cumputer', 'History', 'Geography', 'Arabic', 'English'),
(16, 'Select department', 'Select Day', 'Select Course', 'Select Course', 'Select Course', 'Select Course', 'Select Course'),
(20, 'Arts', 'Monday', 'English', 'Arabic', 'English', 'Networking', 'Geography');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `StudentID` int(11) NOT NULL,
  `StudentName` varchar(255) DEFAULT NULL,
  `StudentEmail` varchar(255) DEFAULT NULL,
  `StudentPhone` varchar(20) DEFAULT NULL,
  `StudentAddress` varchar(255) DEFAULT NULL,
  `StudentDOB` date DEFAULT NULL,
  `StudentGender` enum('Male','Female') DEFAULT NULL,
  `StudentPassword` varchar(255) DEFAULT NULL,
  `StudentDepartment` varchar(255) DEFAULT NULL,
  `StudentTeacher` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`StudentID`, `StudentName`, `StudentEmail`, `StudentPhone`, `StudentAddress`, `StudentDOB`, `StudentGender`, `StudentPassword`, `StudentDepartment`, `StudentTeacher`) VALUES
(10, 'Amire', 'amire@gmail.com', '0655238666', 'maarka zitoun meknes', '2024-03-07', 'Male', 'amireamire', 'Scince', 'Rachid'),
(11, 'abdelilah', 'elibbawiabdelilah@gmail.com', '0602767804', 'Riad Zitoun Meknes', '2010-03-09', 'Male', 'abdel', 'Scince', 'Ahmde'),
(12, 'fati', 'fati@gmail.com', '0667765512', 'zitoun meknes', '2024-03-11', 'Female', 'fati', 'Scince', 'Sami'),
(13, 'sami', 'sami@gmail.com', '1212121212', 'Tanger', '2024-03-12', 'Male', '1212', 'AP01', 'Rachid');

-- --------------------------------------------------------

--
-- Table structure for table `teachers`
--

CREATE TABLE `teachers` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `birth` date NOT NULL,
  `salary` decimal(10,2) NOT NULL,
  `pwd` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `teachers`
--

INSERT INTO `teachers` (`id`, `name`, `email`, `birth`, `salary`, `pwd`) VALUES
(28, 'abdelilah', 'elibbawiabdelilah@gmail.com', '2001-08-18', 7500.00, 'elibbawi321'),
(29, 'Fatima zahra', 'fati@gmail.com', '1999-08-23', 25000.00, 'fati.321'),
(30, 'soh', 'soh@gmail.com', '2024-03-11', 5500.00, 'ohsoh'),
(31, 'yoss', 'yoss@gmail.com', '2023-06-14', 5500.00, 'youss'),
(32, 'tar', 'tar@gmail.com', '2024-03-03', 5500.00, 'tartar'),
(33, 'abdel', 'abdel@gmail.com', '2015-06-09', 8000.00, 'abdek'),
(34, 'itoi', 'ito@gmail.com', '1994-04-20', 10000.00, 'itipoi'),
(36, 'mohamed', 'mohamed@gmail.com', '1976-11-28', 25000.00, 'molaymohamed'),
(37, 'azehhar', 'azehhar@gmail.com', '1999-08-23', 10000.00, 'azehhar321');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'Abdelilahh', '$2y$10$eKLvJEPBu/gJmayuzcLDnejaqdBKB37uXw7DDd58vwFs4VdLJeSwG');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `departments`
--
ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marks`
--
ALTER TABLE `marks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `schedules`
--
ALTER TABLE `schedules`
  ADD PRIMARY KEY (`ScheduleID`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`StudentID`);

--
-- Indexes for table `teachers`
--
ALTER TABLE `teachers`
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
-- AUTO_INCREMENT for table `departments`
--
ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `marks`
--
ALTER TABLE `marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `schedules`
--
ALTER TABLE `schedules`
  MODIFY `ScheduleID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `StudentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `teachers`
--
ALTER TABLE `teachers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
