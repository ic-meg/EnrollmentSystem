-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 08, 2025 at 02:19 PM
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
  `UserID` int(11) NOT NULL,
  `FirstName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Username` varchar(255) NOT NULL,
  `PhoneNumber` varchar(15) NOT NULL,
  `Role` varchar(255) NOT NULL,
  `TempPassword` text NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `admission`
--

CREATE TABLE `admission` (
  `admissionID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(11) NOT NULL,
  `application_status` varchar(255) NOT NULL,
  `document_status` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admission`
--

INSERT INTO `admission` (`admissionID`, `user_id`, `name`, `application_status`, `document_status`) VALUES
(1, 1, 'Meg', 'Pending', '4');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `CourseID` int(11) NOT NULL,
  `CourseName` varchar(255) NOT NULL,
  `LinkSubject` varchar(100) NOT NULL,
  `TotalUnits` int(11) NOT NULL,
  `NumOfStudents` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `enrollee`
--

CREATE TABLE `enrollee` (
  `EnrolleeID` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Status` varchar(255) NOT NULL,
  `enrollment_type` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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
  `PreferredStartDate` date NOT NULL,
  `ModeOfStudy` enum('Online','On-Campus','','') NOT NULL,
  `GoodMoral` text NOT NULL,
  `TOR` text NOT NULL
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
  `IDPhoto` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

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

-- --------------------------------------------------------

--
-- Table structure for table `subject`
--

CREATE TABLE `subject` (
  `SubjID` int(11) NOT NULL,
  `SubCode` varchar(20) NOT NULL,
  `SubName` varchar(255) NOT NULL,
  `LinkProgram` varchar(255) NOT NULL,
  `Units` int(11) NOT NULL,
  `PreRequisites` varchar(100) NOT NULL,
  `Fee` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 ROW_FORMAT=COMPACT;

-- --------------------------------------------------------

--
-- Table structure for table `supportinbox`
--

CREATE TABLE `supportinbox` (
  `supportID` int(11) NOT NULL,
  `UserID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Topic` varchar(255) NOT NULL,
  `Date` date NOT NULL,
  `Status` varchar(100) NOT NULL,
  `AdminAssigned` varchar(255) NOT NULL,
  `ResponseMessage` text NOT NULL,
  `updatedAt` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `supportpage`
--

CREATE TABLE `supportpage` (
  `SupportID` int(11) NOT NULL,
  `Name` varchar(255) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Topic` varchar(255) NOT NULL,
  `Message` text NOT NULL,
  `DateSubmitted` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  `GoodMoral` text NOT NULL
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
(1, 'megangeline08@gmail.com', 'meg', '$2y$10$LRtrNrJI.dKpTAdtwRzm/OXc.UO0G1XHpwA3AoSysF.bRIUHhebKe', 0),
(2, 'gil@gmail.com', 'gil', '$2y$10$SdIBe.mxLpERmA6CQSA2i.aveNaTvece4LeItVxBCmKzIPxQIQhgy', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adminaccount`
--
ALTER TABLE `adminaccount`
  ADD PRIMARY KEY (`UserID`);

--
-- Indexes for table `admission`
--
ALTER TABLE `admission`
  ADD PRIMARY KEY (`admissionID`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`CourseID`);

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
-- Indexes for table `subject`
--
ALTER TABLE `subject`
  ADD PRIMARY KEY (`SubjID`);

--
-- Indexes for table `supportinbox`
--
ALTER TABLE `supportinbox`
  ADD PRIMARY KEY (`supportID`),
  ADD KEY `supportID` (`supportID`),
  ADD KEY `AdminAssigned` (`AdminAssigned`),
  ADD KEY `UserID` (`UserID`),
  ADD KEY `UserID_2` (`UserID`);

--
-- Indexes for table `supportpage`
--
ALTER TABLE `supportpage`
  ADD PRIMARY KEY (`SupportID`);

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
  MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `admission`
--
ALTER TABLE `admission`
  MODIFY `admissionID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `CourseID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `enrollee`
--
ALTER TABLE `enrollee`
  MODIFY `EnrolleeID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `freshmen`
--
ALTER TABLE `freshmen`
  MODIFY `FreshID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `nonsequential`
--
ALTER TABLE `nonsequential`
  MODIFY `NonID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `paymentinfo`
--
ALTER TABLE `paymentinfo`
  MODIFY `PaymentID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `returnee`
--
ALTER TABLE `returnee`
  MODIFY `ReturneeID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `schedule`
--
ALTER TABLE `schedule`
  MODIFY `SchedID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `subject`
--
ALTER TABLE `subject`
  MODIFY `SubjID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supportinbox`
--
ALTER TABLE `supportinbox`
  MODIFY `supportID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `supportpage`
--
ALTER TABLE `supportpage`
  MODIFY `SupportID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `transferee`
--
ALTER TABLE `transferee`
  MODIFY `TransID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `useraccount`
--
ALTER TABLE `useraccount`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `admission`
--
ALTER TABLE `admission`
  ADD CONSTRAINT `admission_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useraccount` (`user_id`);

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
-- Constraints for table `supportinbox`
--
ALTER TABLE `supportinbox`
  ADD CONSTRAINT `supportinbox_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `adminaccount` (`UserID`);

--
-- Constraints for table `transferee`
--
ALTER TABLE `transferee`
  ADD CONSTRAINT `transferee_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `useraccount` (`user_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
