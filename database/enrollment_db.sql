-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2025 at 09:52 AM
-- Server version: 10.1.21-MariaDB
-- PHP Version: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `enrollment_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `adminaccount`
--

CREATE TABLE `adminaccount` (
  `admin_id` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `Role` varchar(255) NOT NULL,
  `TempPassword` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `profile_pic` varchar(255) NOT NULL,
  `otp` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `adminaccount`
--

INSERT INTO `adminaccount` (`admin_id`, `FirstName`, `LastName`, `email`, `username`, `PhoneNumber`, `Role`, `TempPassword`, `password`, `profile_pic`, `otp`) VALUES
(10001, 'Shanley', 'Galo', 'shanleygalo0000@gmail.com', 'ley', '09123456789', 'Admin', '', '$2y$10$qpr8C6jv4uX7xm4e6r3c/.CW/a3/dIcbA3nv/GTHp1oJ3gd6fVEgm', 'adminPic/admin_10001_1746455822.jpg', 0),
(10006, 'Meg', 'Fabian', 'megangeline08@gmail.com', 'meggy', '09124312567', 'Admin', '', '$2y$10$JEXbxWuZZWdzO07cvLfIb.ipahZ0BgkxWxwkyeDP/6oESH.Bb8YgO', 'adminPic/admin_10006_1747577150.jpg', 891702);

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `CourseID` int(11) NOT NULL,
  `CourseName` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `TotalUnits` int(11) NOT NULL,
  `NumOfStudents` int(11) NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_archived` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci ROW_FORMAT=COMPACT;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`CourseID`, `CourseName`, `TotalUnits`, `NumOfStudents`, `description`, `is_archived`) VALUES
(3001, 'Bachelor of Science in Information Technology', 15, 0, 'Covers IT fundamentals, programming, and systems design.', 0),
(3002, 'Bachelor of Science in Psychology', 15, 0, 'Studies human behavior, mental processes, and psychological assessment.', 0),
(3003, 'Bachelor of Science in Education', 15, 0, 'Prepares students for teaching careers with pedagogy and curriculum development.', 0),
(3004, 'Bachelor of Science in Human Resource', 15, 0, 'Focuses on managing personnel, labor laws, and organizational behavior.', 0),
(3005, 'Bachelor of Science in Nursing', 18, 0, 'Develops skills in patient care, health assessment, and clinical practice.', 0),
(3006, 'Bachelor of Science in Law', 15, 0, 'Introduces legal principles, criminal and civil law, and constitutional studies.', 0),
(3007, 'Bachelor of Science in Criminology', 15, 0, 'Focuses on crime, criminal justice system, and law enforcement strategies.', 0),
(3008, 'Bachelor of Science in Tourism', 15, 0, 'Explores hospitality, tourism planning, and destination management.', 0);

-- --------------------------------------------------------

--
-- Table structure for table `enrolled_subjects`
--

CREATE TABLE `enrolled_subjects` (
  `id` int(11) NOT NULL,
  `enrollee_id` int(11) NOT NULL,
  `subj_id` int(11) NOT NULL,
  `sub_code` varchar(50) DEFAULT NULL,
  `sub_name` varchar(150) DEFAULT NULL,
  `units` int(11) DEFAULT NULL,
  `fee` decimal(10,2) DEFAULT NULL,
  `section` varchar(10) DEFAULT NULL,
  `schedule_day` varchar(20) DEFAULT NULL,
  `schedule_time` varchar(50) DEFAULT NULL,
  `room` varchar(50) DEFAULT NULL,
  `added_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `enrolled_subjects`
--

INSERT INTO `enrolled_subjects` (`id`, `enrollee_id`, `subj_id`, `sub_code`, `sub_name`, `units`, `fee`, `section`, `schedule_day`, `schedule_time`, `room`, `added_at`) VALUES
(12, 1, 2011, 'FACI01', 'Facilitating Learning', 3, '1200.00', 'B', 'Friday', '09:00:00 - 11:00:00', '104', '2025-05-18 22:06:49'),
(13, 1, 2012, 'CHIL02', 'Child and Adolescent Development', 3, '1200.00', 'B', 'Thursday', '10:00:00 - 12:00:00', '102', '2025-05-18 22:06:49'),
(14, 1, 2013, 'CURR03', 'Curriculum Development', 3, '1200.00', 'B', 'Thursday', '09:00:00 - 11:00:00', '101', '2025-05-18 22:06:49'),
(15, 1, 2014, 'ASSE04', 'Assessment', 3, '1200.00', 'B', 'Monday', '08:00:00 - 10:00:00', '104', '2025-05-18 22:06:49'),
(16, 1, 2015, 'TECH05', 'Technology for Teaching', 3, '1200.00', 'B', 'Friday', '09:00:00 - 11:00:00', '102', '2025-05-18 22:06:49'),
(17, 2, 2001, 'INTR01', 'Introduction to Computing', 3, '1200.00', 'B', 'Wednesday', '09:00:00 - 11:00:00', '105', '2025-05-28 10:30:42'),
(18, 2, 2002, 'WEB 02', 'Web Development', 3, '1200.00', 'B', 'Tuesday', '09:00:00 - 11:00:00', '105', '2025-05-28 10:30:42'),
(19, 2, 2003, 'PROG03', 'Programming 1', 3, '1200.00', 'B', 'Thursday', '10:00:00 - 12:00:00', '101', '2025-05-28 10:30:42'),
(20, 2, 2004, 'DATA04', 'Data Structures', 3, '1200.00', 'B', 'Friday', '10:00:00 - 12:00:00', '103', '2025-05-28 10:30:42'),
(34, 6, 2002, 'WEB 02', 'Web Development', 3, '1200.00', 'B', 'Tuesday', '09:00:00 - 11:00:00', '105', '2025-06-01 18:43:48'),
(35, 6, 2003, 'PROG03', 'Programming 1', 3, '1200.00', 'B', 'Thursday', '10:00:00 - 12:00:00', '101', '2025-06-01 18:43:48');

-- --------------------------------------------------------

--
-- Table structure for table `enrollee`
--

CREATE TABLE `enrollee` (
  `EnrolleeID` int(11) NOT NULL,
  `section` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `enrollment_type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `documents_uploaded` int(11) NOT NULL,
  `dateSubmitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rejectReason` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `enrollee`
--

INSERT INTO `enrollee` (`EnrolleeID`, `section`, `user_id`, `Status`, `enrollment_type`, `name`, `program`, `documents_uploaded`, `dateSubmitted`, `rejectReason`) VALUES
(1, 'B', 5, 'Approved', 'Freshmen', 'Pamela Murillo', 'Bachelor of Science in Education', 3, '2025-05-18 14:06:49', ''),
(3, 'B', 2, 'Pending', 'Returnee', 'Giuliani Calais ', 'Bachelor of Science in Information Technology', 3, '2025-06-01 10:24:31', ''),
(6, 'B', 12, 'Approved', 'Returnee', 'Meg Angeline  Fabian', 'Bachelor of Science in Information Technology', 3, '2025-06-01 10:43:48', '');

-- --------------------------------------------------------

--
-- Table structure for table `freshmen`
--

CREATE TABLE `freshmen` (
  `FreshID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `FirstName` varchar(50) NOT NULL,
  `MiddleInitial` varchar(5) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Suffix` varchar(10) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Sex` varchar(255) NOT NULL,
  `Phone` varchar(15) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `StreetAddress` text NOT NULL,
  `City` varchar(255) NOT NULL,
  `Province` varchar(255) NOT NULL,
  `ZipCode` varchar(10) NOT NULL,
  `Program` varchar(100) NOT NULL,
  `Form137` text NOT NULL,
  `Form138` text NOT NULL,
  `Picture` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `freshmen`
--

INSERT INTO `freshmen` (`FreshID`, `user_id`, `FirstName`, `MiddleInitial`, `LastName`, `Suffix`, `DateOfBirth`, `Sex`, `Phone`, `Email`, `StreetAddress`, `City`, `Province`, `ZipCode`, `Program`, `Form137`, `Form138`, `Picture`) VALUES
(1, 5, 'Pamela', '', 'Murillo', '', '2003-10-09', 'female', '09124312567', 'pam@gmail.com', 'Blk 2', 'Imus', 'Cavite', '4103', 'Bachelor of Science in Education', '6829e960ada0a-form137-sample.png', '6829e960add10-form-138.png', '6829e960adfaf-1x1-sample.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `nonsequential`
--

CREATE TABLE `nonsequential` (
  `NonID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `MiddleInitial` varchar(5) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `PhoneNum` varchar(15) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Sex` enum('Male','Female','','') NOT NULL,
  `LastAttendedSchool` varchar(100) NOT NULL,
  `YearGraduatedLeft` varchar(10) NOT NULL,
  `IntendedCourse` varchar(245) NOT NULL,
  `ReasonForApplication` text NOT NULL,
  `PreferredStartDate` varchar(255) NOT NULL,
  `ModeOfStudy` enum('Online','On-Campus','','') NOT NULL,
  `GoodMoral` text NOT NULL,
  `TOR` text NOT NULL,
  `yearLevel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `paymentinfo`
--

CREATE TABLE `paymentinfo` (
  `PaymentID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Program` varchar(255) NOT NULL,
  `TuitionFee` decimal(10,2) NOT NULL,
  `MiscellanousFee` decimal(10,2) NOT NULL,
  `TotalFees` decimal(10,2) NOT NULL,
  `AmountPaid` decimal(10,2) NOT NULL,
  `PaymentDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `PaymentMethod` varchar(100) NOT NULL,
  `PaymentStatus` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `paymentinfo`
--

INSERT INTO `paymentinfo` (`PaymentID`, `user_id`, `Name`, `Program`, `TuitionFee`, `MiscellanousFee`, `TotalFees`, `AmountPaid`, `PaymentDate`, `PaymentMethod`, `PaymentStatus`) VALUES
(2, 5, 'Pamela Murillo', 'Bachelor of Science in Education', '15000.00', '3000.00', '18000.00', '18000.00', '2025-05-18 08:08:08', 'Card (Test)', 'Paid'),
(4, 6, 'Meg Angeline  Fabian', 'Bachelor of Science in Information Technology', '18000.00', '3000.00', '21000.00', '21000.00', '2025-06-01 02:34:46', 'Card (Test)', 'Paid'),
(5, 12, 'Meg Angeline  Fabian', 'Bachelor of Science in Information Technology', '6000.00', '3000.00', '9000.00', '9000.00', '2025-06-01 04:45:25', 'Card (Test)', 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `returnee`
--

CREATE TABLE `returnee` (
  `ReturneeID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `MiddleInitial` varchar(5) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Sex` enum('Male','Female','','') NOT NULL,
  `LastEnrollmentDate` date NOT NULL,
  `ReasonForReturning` text NOT NULL,
  `PreviousProgram` varchar(100) NOT NULL,
  `ExpectedGraduationDate` date NOT NULL,
  `TOR` text NOT NULL,
  `MedCert` text NOT NULL,
  `IDPhoto` text NOT NULL,
  `yearLevel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `returnee`
--

INSERT INTO `returnee` (`ReturneeID`, `user_id`, `FirstName`, `MiddleInitial`, `LastName`, `DateOfBirth`, `Sex`, `LastEnrollmentDate`, `ReasonForReturning`, `PreviousProgram`, `ExpectedGraduationDate`, `TOR`, `MedCert`, `IDPhoto`, `yearLevel`) VALUES
(1, 2, 'Giuliani', '', 'Calais ', '2004-08-04', 'Male', '2024-06-01', 'Reason for returning', 'Bachelor of Science in Information Technology', '2026-07-01', '683c0df5c5ca3-tor-sample.png', '683c0df5c62d3-med-cert-sample.jpg', '683c0df5c6575-1x1-sample.jpg', '2nd Year'),
(3, 12, 'Meg Angeline ', '', 'Fabian', '2003-12-08', 'Female', '2024-01-09', 'Reason for returning', 'Bachelor of Science in Information Technology', '0000-00-00', '683c160cbd178-tor-sample.png', '683c160cbd666-med-cert-sample.jpg', '683c160cbd8c0-1x1-sample.jpg', '3rd Year'),
(4, 12, 'Meg Angeline ', '', 'Fabian', '2003-12-08', 'Female', '2024-08-01', 'Reason for returning', 'Bachelor of Science in Information Technology', '0000-00-00', '683c2d6f5745d-tor-sample.png', '683c2d6f57a19-med-cert-sample.jpg', '683c2d6f57da7-1x1-sample.jpg', '3rd Year');

-- --------------------------------------------------------

--
-- Table structure for table `schedule`
--

CREATE TABLE `schedule` (
  `SchedID` int(11) NOT NULL,
  `SubID` int(11) NOT NULL,
  `Section` varchar(255) NOT NULL,
  `Day` enum('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday') NOT NULL,
  `TimeStart` time NOT NULL,
  `TimeEnd` time NOT NULL,
  `Room` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `schedule`
--

INSERT INTO `schedule` (`SchedID`, `SubID`, `Section`, `Day`, `TimeStart`, `TimeEnd`, `Room`) VALUES
(4001, 2001, 'A', 'Wednesday', '09:00:00', '11:00:00', '105'),
(4002, 2002, 'E', 'Tuesday', '09:00:00', '11:00:00', '105'),
(4003, 2003, 'D', 'Thursday', '10:00:00', '12:00:00', '101'),
(4004, 2004, 'C', 'Friday', '10:00:00', '12:00:00', '103'),
(4005, 2005, 'C', 'Wednesday', '09:00:00', '11:00:00', '104'),
(4006, 2006, 'E', 'Tuesday', '09:00:00', '11:00:00', '104'),
(4007, 2007, 'A', 'Wednesday', '08:00:00', '10:00:00', '102'),
(4008, 2008, 'B', 'Friday', '10:00:00', '12:00:00', '101'),
(4009, 2009, 'D', 'Tuesday', '09:00:00', '11:00:00', '103'),
(4010, 2010, 'E', 'Friday', '09:00:00', '11:00:00', '104'),
(4011, 2011, 'A', 'Friday', '09:00:00', '11:00:00', '104'),
(4012, 2012, 'A', 'Thursday', '10:00:00', '12:00:00', '102'),
(4013, 2013, 'C', 'Thursday', '09:00:00', '11:00:00', '101'),
(4014, 2014, 'D', 'Monday', '08:00:00', '10:00:00', '104'),
(4015, 2015, 'B', 'Friday', '09:00:00', '11:00:00', '102'),
(4016, 2016, 'B', 'Monday', '09:00:00', '11:00:00', '103'),
(4017, 2017, 'C', 'Wednesday', '09:00:00', '11:00:00', '105'),
(4018, 2018, 'E', 'Friday', '10:00:00', '12:00:00', '105'),
(4019, 2019, 'C', 'Friday', '10:00:00', '12:00:00', '103'),
(4020, 2020, 'C', 'Wednesday', '10:00:00', '12:00:00', '105'),
(4021, 2021, 'C', 'Friday', '10:00:00', '12:00:00', '105'),
(4022, 2022, 'C', 'Friday', '08:00:00', '10:00:00', '102'),
(4023, 2023, 'E', 'Tuesday', '10:00:00', '12:00:00', '104'),
(4024, 2024, 'B', 'Thursday', '08:00:00', '10:00:00', '102'),
(4025, 2025, 'B', 'Wednesday', '10:00:00', '12:00:00', '105'),
(4026, 2026, 'C', 'Friday', '09:00:00', '11:00:00', '104'),
(4027, 2027, 'B', 'Tuesday', '10:00:00', '12:00:00', '105'),
(4028, 2028, 'B', 'Thursday', '10:00:00', '12:00:00', '104'),
(4029, 2029, 'D', 'Tuesday', '08:00:00', '10:00:00', '104'),
(4030, 2030, 'C', 'Wednesday', '09:00:00', '11:00:00', '104'),
(4031, 2031, 'E', 'Monday', '08:00:00', '10:00:00', '102'),
(4032, 2032, 'A', 'Thursday', '10:00:00', '12:00:00', '101'),
(4033, 2033, 'D', 'Monday', '08:00:00', '10:00:00', '104'),
(4034, 2034, 'E', 'Thursday', '09:00:00', '11:00:00', '104'),
(4035, 2035, 'E', 'Monday', '08:00:00', '10:00:00', '105'),
(4036, 2036, 'E', 'Monday', '08:00:00', '10:00:00', '102'),
(4037, 2037, 'A', 'Monday', '09:00:00', '11:00:00', '101'),
(4038, 2038, 'E', 'Wednesday', '09:00:00', '11:00:00', '105'),
(4039, 2039, 'A', 'Thursday', '09:00:00', '11:00:00', '102'),
(4040, 2040, 'D', 'Monday', '09:00:00', '11:00:00', '105');

-- --------------------------------------------------------

--
-- Table structure for table `studentprofile`
--

CREATE TABLE `studentprofile` (
  `profile_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) NOT NULL,
  `birthdate` date NOT NULL,
  `birthplace` varchar(100) NOT NULL,
  `age` int(11) NOT NULL,
  `phone` varchar(11) NOT NULL,
  `guardian_name` varchar(100) NOT NULL,
  `guardian_contact` varchar(11) NOT NULL,
  `relationship` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `studentprofile`
--

INSERT INTO `studentprofile` (`profile_id`, `user_id`, `first_name`, `middle_name`, `last_name`, `birthdate`, `birthplace`, `age`, `phone`, `guardian_name`, `guardian_contact`, `relationship`, `created_at`) VALUES
(4, 3, 'Meg', '', 'Fabian', '2003-12-08', 'Mnl', 21, '09124312567', 'Julieta', '09123467890', 'Grandma', '2025-05-06 02:50:20'),
(5, 2, 'Giuliani', '', 'Calais ', '2004-08-04', 'Bacoor', 20, '09124312567', 'Calais', '09123467890', 'Parent', '2025-05-12 11:33:03'),
(9, 5, 'Pamela', '', 'Murillo', '2003-10-09', 'Imus', 21, '09124312567', 'Maloi', '09123467890', 'Other', '2025-05-18 12:03:22'),
(10, 6, 'Meg Angeline ', '', 'Fabian', '2003-12-08', 'Manila', 21, '09124312567', 'Julieta', '09123467890', 'Guardian', '2025-06-01 08:30:56'),
(11, 12, 'Meg Angeline ', '', 'Fabian', '2003-12-08', 'Mnl', 21, '09124312567', 'Julieta', '09123467890', 'Guardian', '2025-06-01 08:56:57');

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `SubjID` int(11) NOT NULL,
  `SubCode` varchar(20) NOT NULL,
  `SubName` varchar(255) NOT NULL,
  `CourseID` int(255) DEFAULT NULL,
  `Units` int(11) NOT NULL,
  `PreRequisites` varchar(100) NOT NULL,
  `Fee` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

--
-- Dumping data for table `subject`
--

INSERT INTO `subject` (`SubjID`, `SubCode`, `SubName`, `CourseID`, `Units`, `PreRequisites`, `Fee`) VALUES
(2001, 'INTR01', 'Introduction to Computing', 3001, 3, 'None', '1200.00'),
(2002, 'WEB 02', 'Web Development', 3001, 3, 'None', '1200.00'),
(2003, 'PROG03', 'Programming 1', 3001, 3, 'None', '1200.00'),
(2004, 'DATA04', 'Data Structures', 3001, 3, 'None', '1200.00'),
(2005, 'NETW05', 'Networks', 3001, 3, 'None', '1200.00'),
(2006, 'GENE01', 'General Psychology', 3002, 3, 'None', '1200.00'),
(2007, 'DEVE02', 'Developmental Psychology', 3002, 3, 'None', '1200.00'),
(2008, 'ABNO03', 'Abnormal Psychology', 3002, 3, 'None', '1200.00'),
(2009, 'SOCI04', 'Social Psychology', 3002, 3, 'None', '1200.00'),
(2010, 'PSYC05', 'Psychological Testing', 3002, 3, 'None', '1200.00'),
(2011, 'FACI01', 'Facilitating Learning', 3003, 3, 'None', '1200.00'),
(2012, 'CHIL02', 'Child and Adolescent Development', 3003, 3, 'None', '1200.00'),
(2013, 'CURR03', 'Curriculum Development', 3003, 3, 'None', '1200.00'),
(2014, 'ASSE04', 'Assessment', 3003, 3, 'None', '1200.00'),
(2015, 'TECH05', 'Technology for Teaching', 3003, 3, 'None', '1200.00'),
(2016, 'ORGA01', 'Organizational Behavior', 3004, 3, 'None', '1200.00'),
(2017, 'LABO02', 'Labor Laws', 3004, 3, 'None', '1200.00'),
(2018, 'RECR03', 'Recruitment and Selection', 3004, 3, 'None', '1200.00'),
(2019, 'TRAI04', 'Training and Development', 3004, 3, 'None', '1200.00'),
(2020, 'COMP05', 'Compensation Management', 3004, 3, 'None', '1200.00'),
(2021, 'ANAT01', 'Anatomy and Physiology', 3005, 3, 'None', '1200.00'),
(2022, 'FUND02', 'Fundamentals of Nursing', 3005, 3, 'None', '1200.00'),
(2023, 'HEAL03', 'Health Assessment', 3005, 3, 'None', '1200.00'),
(2024, 'PHAR04', 'Pharmacology', 3005, 3, 'None', '1200.00'),
(2025, 'NURS05', 'Nursing Ethics', 3005, 3, 'None', '1200.00'),
(2026, 'INTR01', 'Introduction to Law', 3006, 3, 'None', '1200.00'),
(2027, 'PHIL02', 'Philippine Constitution', 3006, 3, 'None', '1200.00'),
(2028, 'CRIM03', 'Criminal Law', 3006, 3, 'None', '1200.00'),
(2029, 'CIVI04', 'Civil Law', 3006, 3, 'None', '1200.00'),
(2030, 'LEGA05', 'Legal Ethics', 3006, 3, 'None', '1200.00'),
(2031, 'INTR01', 'Introduction to Criminology', 3007, 3, 'None', '1200.00'),
(2032, 'POLI02', 'Police Organization', 3007, 3, 'None', '1200.00'),
(2033, 'CRIM03', 'Criminal Law', 3007, 3, 'None', '1200.00'),
(2034, 'LAW 04', 'Law Enforcement', 3007, 3, 'None', '1200.00'),
(2035, 'FORE05', 'Forensics', 3007, 3, 'None', '1200.00'),
(2036, 'TOUR01', 'Tourism Planning', 3008, 3, 'None', '1200.00'),
(2037, 'PHIL02', 'Philippine Culture', 3008, 3, 'None', '1200.00'),
(2038, 'TOUR03', 'Tourism Management', 3008, 3, 'None', '1200.00'),
(2039, 'ECOT04', 'Ecotourism', 3008, 3, 'None', '1200.00'),
(2040, 'HOSP05', 'Hospitality Management', 3008, 3, 'None', '1200.00');

-- --------------------------------------------------------

--
-- Table structure for table `supportpage`
--

CREATE TABLE `supportpage` (
  `SupportID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) DEFAULT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Topic` varchar(255) NOT NULL,
  `userMessage` text NOT NULL,
  `DateSubmitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(255) NOT NULL,
  `adminResponse` text NOT NULL,
  `responseDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `supportpage`
--

INSERT INTO `supportpage` (`SupportID`, `user_id`, `admin_id`, `Name`, `Email`, `Topic`, `userMessage`, `DateSubmitted`, `status`, `adminResponse`, `responseDate`) VALUES
(1, 2, 10001, 'gil', 'gil@gmail.com', 'Application Inquiry', 'HEwsadawdadsada', '2025-05-12 16:55:49', 'Resolved', 'gawe', '2025-05-12'),
(2, 3, NULL, 'meg', 'fabian.megangeline2003@gmail.com', 'Application Inquiry', 'Hello, Paano ito?', '2025-05-15 08:18:13', 'Pending', '', '0000-00-00');

-- --------------------------------------------------------

--
-- Table structure for table `transferee`
--

CREATE TABLE `transferee` (
  `TransID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `MiddleInitial` varchar(5) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `ContactNum` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `DateOfBirth` date NOT NULL,
  `Sex` enum('Male','Female','','') NOT NULL,
  `PreviousSchool` varchar(255) NOT NULL,
  `PreviousProgram` varchar(255) NOT NULL,
  `IntendedCourse` varchar(255) NOT NULL,
  `GuardiansName` varchar(255) NOT NULL,
  `GuardiansContact` varchar(255) NOT NULL,
  `TOR` text NOT NULL,
  `GoodMoral` text NOT NULL,
  `yearLevel` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `useraccount`
--

CREATE TABLE `useraccount` (
  `user_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `OTP` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `useraccount`
--

INSERT INTO `useraccount` (`user_id`, `email`, `username`, `password`, `OTP`) VALUES
(2, 'gil@gmail.com', 'gil', '$2y$10$SdIBe.mxLpERmA6CQSA2i.aveNaTvece4LeItVxBCmKzIPxQIQhgy', 0),
(5, 'pam@gmail.com', 'pam', '$2y$10$p4H5rAEZYFeG.sUhWD.DROyIeD8Q8G5tRzfU2sLeX4Neusf9jfi9W', 0),
(6, 'fabian.megangeline2003@gmail.com', 'megan', '$2y$10$xrW3yttDnvJ0Yq72fn/6YemY07dfEDsAgRA6kfmXaweKmKytkxPhK', 0),
(12, 'fabianmeg74@gmail.com', 'fab', '$2y$10$AEjGlB4PKoET3W7ZyTGkz.QfI4/rXrAjQG/Nn3TgkFrbiMfxh0.ne', 0),
(13, 'kate@gmail.com', 'kate', '$2y$10$MEsNeqz9a16nqkgsVPFL7uNNQWJdjeNEMMxIhak1rnUXk./SVHexe', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminaccount`
--
ALTER TABLE `adminaccount`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`CourseID`);

--
-- Indexes for table `enrolled_subjects`
--
ALTER TABLE `enrolled_subjects`
  ADD PRIMARY KEY (`id`),
  ADD KEY `enrollee_id` (`enrollee_id`),
  ADD KEY `subj_id` (`subj_id`);

--
-- Indexes for table `enrollee`
--
ALTER TABLE `enrollee`
  ADD PRIMARY KEY (`EnrolleeID`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `user_id_2` (`user_id`);

--
-- Indexes for table `freshmen`
--
ALTER TABLE `freshmen`
  ADD PRIMARY KEY (`FreshID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `nonsequential`
--
ALTER TABLE `nonsequential`
  ADD PRIMARY KEY (`NonID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `paymentinfo`
--
ALTER TABLE `paymentinfo`
  ADD PRIMARY KEY (`PaymentID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `returnee`
--
ALTER TABLE `returnee`
  ADD PRIMARY KEY (`ReturneeID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `schedule`
--
ALTER TABLE `schedule`
  ADD PRIMARY KEY (`SchedID`),
  ADD KEY `SubID` (`SubID`);

--
-- Indexes for table `studentprofile`
--
ALTER TABLE `studentprofile`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`SubjID`),
  ADD KEY `CourseID` (`CourseID`);

--
-- Indexes for table `supportpage`
--
ALTER TABLE `supportpage`
  ADD PRIMARY KEY (`SupportID`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `admin_id` (`admin_id`);

--
-- Indexes for table `transferee`
--
ALTER TABLE `transferee`
  ADD PRIMARY KEY (`TransID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `useraccount`
--
ALTER TABLE `useraccount`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adminaccount`
--
ALTER TABLE `adminaccount`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10007;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3009;
--
-- AUTO_INCREMENT for table `enrolled_subjects`
--
ALTER TABLE `enrolled_subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;
--
-- AUTO_INCREMENT for table `enrollee`
--
ALTER TABLE `enrollee`
  MODIFY `EnrolleeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT for table `freshmen`
--
ALTER TABLE `freshmen`
  MODIFY `FreshID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `nonsequential`
--
ALTER TABLE `nonsequential`
  MODIFY `NonID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `paymentinfo`
--
ALTER TABLE `paymentinfo`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `returnee`
--
ALTER TABLE `returnee`
  MODIFY `ReturneeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `SchedID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4041;
--
-- AUTO_INCREMENT for table `studentprofile`
--
ALTER TABLE `studentprofile`
  MODIFY `profile_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `SubjID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2041;
--
-- AUTO_INCREMENT for table `supportpage`
--
ALTER TABLE `supportpage`
  MODIFY `SupportID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `transferee`
--
ALTER TABLE `transferee`
  MODIFY `TransID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `useraccount`
--
ALTER TABLE `useraccount`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `enrolled_subjects`
--
ALTER TABLE `enrolled_subjects`
  ADD CONSTRAINT `enrolled_subjects_ibfk_1` FOREIGN KEY (`enrollee_id`) REFERENCES `enrollee` (`EnrolleeID`),
  ADD CONSTRAINT `enrolled_subjects_ibfk_2` FOREIGN KEY (`subj_id`) REFERENCES `subject` (`SubjID`);

--
-- Constraints for table `enrollee`
--
ALTER TABLE `enrollee`
  ADD CONSTRAINT `enrollee_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useraccount` (`user_id`);

--
-- Constraints for table `freshmen`
--
ALTER TABLE `freshmen`
  ADD CONSTRAINT `freshmen_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useraccount` (`user_id`);

--
-- Constraints for table `nonsequential`
--
ALTER TABLE `nonsequential`
  ADD CONSTRAINT `nonsequential_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useraccount` (`user_id`);

--
-- Constraints for table `paymentinfo`
--
ALTER TABLE `paymentinfo`
  ADD CONSTRAINT `paymentinfo_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useraccount` (`user_id`);

--
-- Constraints for table `returnee`
--
ALTER TABLE `returnee`
  ADD CONSTRAINT `returnee_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useraccount` (`user_id`);

--
-- Constraints for table `schedule`
--
ALTER TABLE `schedule`
  ADD CONSTRAINT `schedule_ibfk_1` FOREIGN KEY (`SubID`) REFERENCES `subject` (`SubjID`);

--
-- Constraints for table `studentprofile`
--
ALTER TABLE `studentprofile`
  ADD CONSTRAINT `studentprofile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useraccount` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `subject`
--
ALTER TABLE `subject`
  ADD CONSTRAINT `subject_ibfk_1` FOREIGN KEY (`CourseID`) REFERENCES `course` (`CourseID`);

--
-- Constraints for table `supportpage`
--
ALTER TABLE `supportpage`
  ADD CONSTRAINT `supportpage_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useraccount` (`user_id`),
  ADD CONSTRAINT `supportpage_ibfk_2` FOREIGN KEY (`admin_id`) REFERENCES `adminaccount` (`admin_id`);

--
-- Constraints for table `transferee`
--
ALTER TABLE `transferee`
  ADD CONSTRAINT `transferee_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useraccount` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
