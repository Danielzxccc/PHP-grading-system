-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 11, 2023 at 04:30 PM
-- Server version: 8.0.31
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `grading`
--

-- --------------------------------------------------------

--
-- Table structure for table `professor`
--

CREATE TABLE `professor` (
  `id` int NOT NULL,
  `userid` int NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `professor`
--

INSERT INTO `professor` (`id`, `userid`, `firstname`, `lastname`) VALUES
(1, 1, 'Lebron', 'James'),
(2, 1, 'Lebron', 'James');

-- --------------------------------------------------------

--
-- Table structure for table `studentgrade`
--

CREATE TABLE `studentgrade` (
  `id` int NOT NULL,
  `studentsubjectid` int NOT NULL,
  `monthly` double NOT NULL,
  `profid` int NOT NULL,
  `firstprelim` double NOT NULL,
  `secondpremlim` double NOT NULL,
  `midterm` double NOT NULL,
  `prefinal` double NOT NULL,
  `final` double NOT NULL,
  `schoolyear` varchar(255) DEFAULT '2022-2023',
  `semester` int NOT NULL,
  `section` int NOT NULL,
  `status` int DEFAULT '0',
  `graderemark` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `studentgrade`
--

INSERT INTO `studentgrade` (`id`, `studentsubjectid`, `monthly`, `profid`, `firstprelim`, `secondpremlim`, `midterm`, `prefinal`, `final`, `schoolyear`, `semester`, `section`, `status`, `graderemark`) VALUES
(5, 10, 90, 1, 90, 90.6, 90, 90, 93.5, '2022-2023', 1, 0, 1, 'INC'),
(10, 17, 90, 1, 90, 90, 90, 90, 90, '2022-2023', 1, 0, 1, ''),
(11, 19, 76, 1, 77, 70, 70, 70, 70, '2022-2023', 1, 0, 1, ''),
(12, 21, 98, 1, 98, 98, 98, 98, 98.78, '2022-2023', 1, 0, 1, ''),
(15, 5, 80, 1, 80, 80, 80, 80, 79.99, '2022-2023', 1, 0, 1, ''),
(16, 25, 90, 1, 90, 90, 90, 90, 90.7, '2022-2023', 1, 0, 1, '');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` int NOT NULL,
  `userid` int NOT NULL,
  `studentid` varchar(50) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `middlename` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `number` varchar(255) NOT NULL,
  `age` int NOT NULL,
  `dateofbirth` date NOT NULL,
  `sex` varchar(255) NOT NULL,
  `typeofscholarship` varchar(255) NOT NULL,
  `course` varchar(50) NOT NULL,
  `yearlevel` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `userid`, `studentid`, `firstname`, `middlename`, `lastname`, `address`, `number`, `age`, `dateofbirth`, `sex`, `typeofscholarship`, `course`, `yearlevel`) VALUES
(1, 2, '20220012', 'PRINCESS', '', 'MARISCOTES', 'San Francisco, New York, Cavite City', '0909876623', 21, '2002-03-07', 'Female', 'ATHELETIC SCHOLARSHIP', 'Information Technology', 1),
(7, 8, '20220016', 'RAFAEL', 'PEKE', 'REBADULLA', 'San Francisco Cavite Caloocan', '0992334567', 25, '2023-03-19', 'Male', 'CAPIS SCHOLARSHIP', 'Information Technology', 1),
(8, 9, '20220206', 'KATRINA JANE', 'PEYN', 'BAJEN', 'San Francisco, New York, Cavite City', '0992334567', 18, '2023-03-22', 'Female', 'CAPIS SCHOLARSHIP', 'Information Technology', 1),
(9, 11, '20220070', 'Miles', 'Dwayne', 'Bridges', 'San Francisco Cavite Caloocan', '09094737765', 21, '2002-01-02', 'Male', 'CAPIS SCHOLARSHIP', 'BACHELOR OF ARTS IN POLITICAL SCIENCE', 1),
(10, 12, '202210215', 'ALLAN', 'C', 'GUINTO', 'San Francisco Cavite Caloocan', '09094737765', 21, '2001-04-10', 'Male', 'MAHARLIKA SCHOLARSHIP', 'BACHELOR OF ARTS IN POLITICAL SCIENCE', 1),
(11, 13, '00898293', 'JABBAR', 'LEBRON', 'ABDUL', 'San Francisco, New York, Cavite City', '09094737765', 20, '2002-04-26', 'Female', 'NONE', 'BACHELOR OF SCIENCE IN HOSPITALITY MANAGEMENT', 1);

-- --------------------------------------------------------

--
-- Table structure for table `studentsubjects`
--

CREATE TABLE `studentsubjects` (
  `id` int NOT NULL,
  `studentid` int NOT NULL,
  `subjectid` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `studentsubjects`
--

INSERT INTO `studentsubjects` (`id`, `studentid`, `subjectid`) VALUES
(4, 8, 5),
(5, 8, 6),
(6, 8, 2),
(9, 8, 15),
(10, 1, 7),
(12, 8, 13),
(14, 7, 1),
(15, 7, 2),
(16, 7, 3),
(17, 1, 2),
(19, 1, 9),
(20, 1, 16),
(21, 9, 2),
(22, 9, 4),
(23, 9, 6),
(24, 9, 8),
(25, 9, 9);

-- --------------------------------------------------------

--
-- Table structure for table `subjects`
--

CREATE TABLE `subjects` (
  `id` int NOT NULL,
  `coursecode` varchar(20) NOT NULL,
  `description` varchar(255) NOT NULL,
  `semester` int NOT NULL,
  `units` int NOT NULL DEFAULT '3'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `subjects`
--

INSERT INTO `subjects` (`id`, `coursecode`, `description`, `semester`, `units`) VALUES
(1, 'CC101 ', 'Introduction to Computing ', 1, 3),
(2, 'CC102 ', 'Fundamentals of  Programming ', 1, 3),
(3, 'GE1 ', 'Communications Skill 1 ', 1, 3),
(4, 'GE2 ', 'Komunikasyon sa Akademikong Filipino', 1, 3),
(5, 'GE3 ', 'College Algebra ', 1, 3),
(6, 'NSTP 1 ', 'National Service Training  Program 1', 1, 3),
(7, 'PE 1 ', 'Physical Fitness ', 1, 3),
(8, 'PDP 1 ', 'Professional Development  Program 1 ', 1, 2),
(9, 'CC103 ', 'Intermediate Programming ', 2, 3),
(10, 'GE4 ', 'Communication Skills2 ', 2, 3),
(11, 'GE5 ', 'Pagbasa at Pagsulat Tungo sa  Pananaliksik ', 2, 3),
(12, 'GE6 ', 'Art Appreciation ', 2, 3),
(13, 'DS101 ', 'Discrete Structures 1 ', 2, 3),
(14, 'NSTP 2 ', 'National Service Training  Program 1', 2, 3),
(15, 'PE 2 ', 'Physical Fitness ', 2, 3),
(16, 'PDP 2 ', 'Professional Development  Program 2', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT '1',
  `role` varchar(255) NOT NULL,
  `isApproved` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `status`, `role`, `isApproved`) VALUES
(1, 'prof1', '200820e3227815ed1756a6b531e7e0d2', 'daniel@email.com', '1', 'professor', 1),
(2, 'stud1', '200820e3227815ed1756a6b531e7e0d2', 'stephcurry@email.com', '1', 'student', 1),
(8, 'stud2', '200820e3227815ed1756a6b531e7e0d2', 'draymond@gmail.com', '1', 'student', 0),
(9, 'stud3', '200820e3227815ed1756a6b531e7e0d2', 'kevindurant@email.com', '1', 'student', 0),
(10, 'admin1', '200820e3227815ed1756a6b531e7e0d2', 'emailnilebron@gmail.com', '1', 'admin', 1),
(11, 'stud4', '200820e3227815ed1756a6b531e7e0d2', 'test34@gmail.com', '1', 'student', 1),
(12, 'stud5', '200820e3227815ed1756a6b531e7e0d2', 'test345@gmail.com', '1', 'student', 1),
(13, 'stud6', '200820e3227815ed1756a6b531e7e0d2', 'test34@gmail.com', '1', 'student', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `professor`
--
ALTER TABLE `professor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_professor_userid` (`userid`);

--
-- Indexes for table `studentgrade`
--
ALTER TABLE `studentgrade`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `studentsubjectid` (`studentsubjectid`),
  ADD KEY `fk_professor_id` (`profid`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `studentid` (`studentid`),
  ADD KEY `fk_student_userid` (`userid`);

--
-- Indexes for table `studentsubjects`
--
ALTER TABLE `studentsubjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_student_id_subject` (`studentid`),
  ADD KEY `fk_student_subjectid_subject` (`subjectid`);

--
-- Indexes for table `subjects`
--
ALTER TABLE `subjects`
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
-- AUTO_INCREMENT for table `professor`
--
ALTER TABLE `professor`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `studentgrade`
--
ALTER TABLE `studentgrade`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `studentsubjects`
--
ALTER TABLE `studentsubjects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `professor`
--
ALTER TABLE `professor`
  ADD CONSTRAINT `fk_professor_userid` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `studentgrade`
--
ALTER TABLE `studentgrade`
  ADD CONSTRAINT `fk_professor_id` FOREIGN KEY (`profid`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `fk_student_grade_subject` FOREIGN KEY (`studentsubjectid`) REFERENCES `studentsubjects` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `students`
--
ALTER TABLE `students`
  ADD CONSTRAINT `fk_student_userid` FOREIGN KEY (`userid`) REFERENCES `users` (`id`);

--
-- Constraints for table `studentsubjects`
--
ALTER TABLE `studentsubjects`
  ADD CONSTRAINT `fk_student_id_subject` FOREIGN KEY (`studentid`) REFERENCES `students` (`id`),
  ADD CONSTRAINT `fk_student_subjectid_subject` FOREIGN KEY (`subjectid`) REFERENCES `subjects` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
