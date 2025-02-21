-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 21, 2025 at 08:17 AM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `child_appointment`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointment_tbl`
--

CREATE TABLE `appointment_tbl` (
  `appointment_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`appointment_time`)),
  `child_name` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`child_name`)),
  `guardian_name` varchar(255) NOT NULL,
  `reason_for_visit` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`reason_for_visit`)),
  `status` varchar(255) NOT NULL,
  `date_requested` date NOT NULL,
  `time_requested` time NOT NULL,
  `resched_reason` varchar(255) NOT NULL,
  `reject_reason` varchar(255) NOT NULL,
  `cancel_reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointment_tbl`
--

INSERT INTO `appointment_tbl` (`appointment_id`, `parent_id`, `appointment_date`, `appointment_time`, `child_name`, `guardian_name`, `reason_for_visit`, `status`, `date_requested`, `time_requested`, `resched_reason`, `reject_reason`, `cancel_reason`) VALUES
(156, 27, '2024-10-24', '[\"8:00 AM\"]', '[\"Jane C. Cruda\"]', 'Jackielyn C. Cruda', '[\"Checkup\"]', 'Done', '2024-10-23', '10:54:18', 'N/A', 'N/A', 'N/A'),
(160, 46, '2024-10-24', '[\"9:30 AM\",\"10:00 AM\"]', '[\"Biron M. Sison\"]', 'Bruce Daine M. Sison', '[\"Vaccination\",\"Checkup\"]', 'Done', '2024-10-23', '14:25:23', 'N/A', 'N/A', 'N/A'),
(163, 27, '2024-10-28', '[\"8:00 AM\",\"8:30 AM\"]', '[\"Jane C. Cruda\",\"Jhon C. Cruda\"]', 'Jackielyn C. Cruda', '[\"Vaccination\",\"Checkup\"]', 'Rejected', '2024-10-25', '13:24:24', 'N/A', 'Emergency', 'N/A'),
(170, 29, '2024-10-28', '[\"9:00 AM\"]', '[\"Gojo C. Cruda\"]', 'Jennilyn C. Cruda', '[\"Checkup\"]', 'Cancelled', '2024-10-25', '17:20:17', 'N/A', 'N/A', ''),
(172, 46, '2025-02-24', '[\"1:30 PM\"]', '[\"Eve M. Sison\"]', 'Bruce Daine M. Sison', '[\"Checkup\"]', 'Cancelled', '2024-11-23', '06:10:04', 'Only available in that date', 'N/A', ''),
(174, 46, '2025-02-24', '[\"8:00 AM\",\"8:30 AM\"]', '[\"Biron M. Sison\",\"Eve M. Sison\"]', 'Bruce Daine M. ', '[\"Vaccination\"]', 'Upcoming', '2025-02-21', '07:52:22', 'N/A', 'N/A', 'N/A');

-- --------------------------------------------------------

--
-- Table structure for table `break_tbl`
--

CREATE TABLE `break_tbl` (
  `break_id` int(11) NOT NULL,
  `break_date` date NOT NULL,
  `reason` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `break_tbl`
--

INSERT INTO `break_tbl` (`break_id`, `break_date`, `reason`) VALUES
(13, '2024-12-25', 'Christmas Day'),
(14, '2024-12-30', 'Rizal Day');

-- --------------------------------------------------------

--
-- Table structure for table `checkup_findings_tbl`
--

CREATE TABLE `checkup_findings_tbl` (
  `checkup_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `checkup_date` date NOT NULL,
  `weight` varchar(5) NOT NULL,
  `height` varchar(5) NOT NULL,
  `head_circumference` varchar(5) NOT NULL,
  `chest_circumference` varchar(5) NOT NULL,
  `developmental_milestones` varchar(255) NOT NULL,
  `physical_exam` varchar(255) NOT NULL,
  `immunization_status` varchar(255) NOT NULL,
  `medical_history` varchar(255) NOT NULL,
  `assessment_recommendations` varchar(255) NOT NULL,
  `notes` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `checkup_findings_tbl`
--

INSERT INTO `checkup_findings_tbl` (`checkup_id`, `child_id`, `checkup_date`, `weight`, `height`, `head_circumference`, `chest_circumference`, `developmental_milestones`, `physical_exam`, `immunization_status`, `medical_history`, `assessment_recommendations`, `notes`) VALUES
(15, 31, '2024-10-16', '12', '11', '12', '21', 'N/A', 'N/A', 'Up to date on all vaccines.', 'Diabetis', 'Prescribe amoxicillin for ear infection; dosage: 250 mg twice daily for 7 days.', ''),
(16, 30, '2024-10-11', '12', '11', '12', '12', 'N/A', 'N/A', '12', 'None', 'Prescribe amoxicillin for ear infection; dosage: 250 mg twice daily for 7 days.', 'N/A'),
(19, 30, '2024-10-22', '26', '12', '21', '13', 'Clapping hands', 'Normal findings', 'Completed', 'None', 'Need regular checkup', 'Do not feed to much salty foods.'),
(20, 47, '2024-10-23', '13.3', '46', '35', '30', 'Clapping hands', 'Normal findings', 'Completed', 'None', 'Need regular checkup', ''),
(24, 47, '2024-10-23', '26', '23', '35', '30', 'Eating Alone', 'Rashes In Arms', 'Up To Date On All Vaccines', 'Alergy In Peanuts', 'Consult A Specialist For Skin Condition', ''),
(25, 47, '2024-10-23', '12', '23', '35', '30', 'Clapping Hands', 'Normal Findings', 'Completed', 'None', 'Need Regular Checkup', ''),
(26, 47, '2024-10-24', '26', '23', '35', '30', 'Clapping Hands', 'Normal Findings', 'Up To Date On All Vaccines', 'None', 'Need Regular Checkup', ''),
(27, 38, '2024-10-24', '26', '23', '35', '30', 'Clapping Hands', 'Normal Findings', 'Missed One Immunization, Follow-up Scheduled', 'None', 'Need Regular Checkup', '');

-- --------------------------------------------------------

--
-- Table structure for table `child_tbl`
--

CREATE TABLE `child_tbl` (
  `child_id` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL,
  `c_fname` varchar(255) NOT NULL,
  `c_m_name` varchar(255) NOT NULL,
  `c_lname` varchar(255) NOT NULL,
  `birth_date` date NOT NULL,
  `birth_time` time NOT NULL,
  `gender` varchar(255) NOT NULL,
  `m_fname` varchar(255) NOT NULL,
  `m_m_name` varchar(255) NOT NULL,
  `m_lname` varchar(255) NOT NULL,
  `f_fname` varchar(255) NOT NULL,
  `f_m_name` varchar(255) NOT NULL,
  `f_lname` varchar(255) NOT NULL,
  `g_fname` varchar(255) NOT NULL,
  `g_m_name` varchar(255) NOT NULL,
  `g_lname` varchar(255) NOT NULL,
  `mother_contact` varchar(10) NOT NULL,
  `father_contact` varchar(10) NOT NULL,
  `guardian_contact` varchar(10) NOT NULL,
  `hospital` varchar(255) NOT NULL,
  `obstretician` varchar(255) NOT NULL,
  `pediatrician` varchar(255) NOT NULL,
  `type_of_delivery` varchar(255) NOT NULL,
  `weight` varchar(10) NOT NULL,
  `height` varchar(10) NOT NULL,
  `head` varchar(10) NOT NULL,
  `chest` varchar(10) NOT NULL,
  `apgar` varchar(255) NOT NULL,
  `blood_type` varchar(255) NOT NULL,
  `eye_color` varchar(255) NOT NULL,
  `hair_color` varchar(255) NOT NULL,
  `marks` varchar(255) NOT NULL,
  `child_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `child_tbl`
--

INSERT INTO `child_tbl` (`child_id`, `parent_id`, `c_fname`, `c_m_name`, `c_lname`, `birth_date`, `birth_time`, `gender`, `m_fname`, `m_m_name`, `m_lname`, `f_fname`, `f_m_name`, `f_lname`, `g_fname`, `g_m_name`, `g_lname`, `mother_contact`, `father_contact`, `guardian_contact`, `hospital`, `obstretician`, `pediatrician`, `type_of_delivery`, `weight`, `height`, `head`, `chest`, `apgar`, `blood_type`, `eye_color`, `hair_color`, `marks`, `child_pic`) VALUES
(29, 37, 'Vince Arkin', 'Dela Cruz', 'Maclang', '2023-07-12', '19:45:00', 'Male', 'Marichelle ', 'Dela Cruz', 'Maclang', 'Marvic ', 'Dela Cruz', 'Maclang', 'Marichelle', 'Dela Cruz', 'Marvic ', '9151168318', '9362926144', '9151168318', 'Gonzales Aguilar Clinic', 'Dra. Milgrace Santos', 'Dra. Daysie Ray', 'Normal', '12', '11', '12', '23', '7', 'A', 'Black', 'Black', 'None', '../uploads/d123d43d2d3d554495e21002aee8a7a9.jpg'),
(30, 40, 'Clyde Aaron', 'Dizon', 'Cruda', '2023-09-18', '03:57:00', 'Male', 'Cherry Lou', 'Dizon', 'Cruda', 'Christian', 'Dizon', 'Cruda', 'Cherry Lou', 'Dizon', 'Cruda', '9235314698', '9169222328', '9235314690', 'Pjg Cabanatuan City', 'Dr. Tam', 'Dr Daniel Parker', 'Cs', '26', '48', '33', '32', '28', 'A', 'Black', 'Black', 'None', '../uploads/efda581dda22258ee58de7fff8a2cfc5.jpg'),
(31, 42, 'Lian Faith', 'Dela Cruz', 'Cayton', '2014-03-03', '13:00:00', 'Female', 'Jheng', 'Dela Cruz', 'Vicente', 'Ernani', 'Dela Cruz', 'Cayton', 'Jeng', 'Dela Cruz', 'Vicente', '9912367859', '9012345675', '9912367859', 'Cabanatuan', 'Dr. Tam', 'Dra. Daysie', 'Normal', '26', '11', '12', '20', '7', 'A', 'Black', 'Black', 'None', '../uploads/5c53d4a0a267c7df0c713a11a7a0e538.jpg'),
(32, 43, 'Prince ', 'Cayton', 'Ramos', '2024-10-01', '16:36:00', 'Male', 'Jamie', 'Cayton', 'Ramos', 'Jomar', 'Cayton', 'Ramos', 'Jamie', 'Cayton', 'Ramos', '9283746374', '9123421342', '9912367858', 'Pjg Cabanatuan City', 'Dr. Tan', 'Dra. Daysie', 'Normal', '26', '48', '32', '33', '28', 'A', 'Black', 'Black', 'None', '../uploads/c1371fe36204f7442e4d7e3bbdb5336e.jpg'),
(35, 40, 'Jane', 'Cruz', 'Doe', '2024-06-12', '19:47:00', 'Female', 'Cherry Lou', 'Cruz', 'Cruda', 'Eren', 'Cruz', 'Yeager', 'Cherry Lou', 'Cruz', 'Cruda', '9235314690', '9124123421', '9235314690', 'Pjg Cabanatuan City', 'Dra. Milgrace Santos', 'Dr. Daysie', 'Normal', '26', '48', '32', '33', '28', 'A', 'Black', 'Black', 'None', '../uploads/f2d3dbd92d8dda7947b5942858110692.jpg'),
(38, 27, 'Jane', 'Cayton', 'Cruda', '2024-07-10', '10:34:00', 'Female', 'Jackielyn', 'Cayton', 'Cruda', 'Eren', 'Cayton', 'Cruda', 'Jackielyn', 'Cayton', 'Cruda', '9940292778', '9124123421', '9940292778', 'Pjg Cabanatuan City', 'Dr. Jhon Doe', 'Dra. Daysie', 'Normal', '12', '11', '12', '20', '7', 'A', 'Red', 'Black', 'None', '../uploads/d7963853c8f21bd36f35c9bee582c8cf.jpg'),
(40, 29, 'Jhane', 'Cayton', 'Doe', '2024-08-08', '10:49:00', 'Female', 'Jennilyn', 'Cayton', 'Cruda', 'Ryan', 'Cayton', 'Cruda', 'Jennilyn', 'Cayton', 'Cruda', '9676692095', '9124123421', '9676692095', 'Pjg Cabanatuan City', 'Dr. Jhon Doe', 'Dra. Cayton', 'Normal', '12', '23', '32', '23', '23', 'A', 'Black', 'Black', 'None', '../uploads/5123b4338a6bbee40396e2546f03dc4a.jpg'),
(46, 46, 'Harley', 'Martinez', 'Sison', '2024-10-01', '21:51:00', 'Male', 'Mikasa', 'Martinez', 'Sison', 'Bruce Daine', 'Martinez', 'Sison', 'Bruce Daine', 'Martinez', 'Sison', '9132141343', '9912367858', '9912367858', 'Pjg Cabanatuan City', 'Dra. Milgrace Santos', 'Dra. Daysie Ray', 'Normal', '12', '23', '33', '23', '23', 'A', 'Black', 'Black', 'D', '../uploads/4b050ec77d119d370c786891c8714488.jpg'),
(47, 46, 'Biron', 'Martinez', 'Sison', '2024-10-03', '12:23:00', 'Male', 'Mikasa', 'Martinez', 'Sison', 'Bruce Daine', 'Martinez', 'Sison', 'Bruce Daine', 'Martinez', 'Sison', '9992345672', '9912367858', '9912367858', 'Pjg Cabanatuan City', 'Dra. Milgrace Santos', 'Dr. Daniel Parker', 'Normal', '13.3', '23', '32', '23', '23', 'A', 'Black', 'Black', 'None', '../uploads/0c67b8ac40beb54fbbaf1c303d5caf8e.jpg'),
(50, 46, 'Eve', 'Martinez', 'Sison', '2024-10-01', '21:46:00', 'Male', 'Mikasa', 'Martinez', 'Sison', 'Bruce Daine', 'Martinez', 'Sison', 'Bruce Daine', 'Martinez', 'Sison', '9132141343', '9912367858', '9912367858', 'Pjg Cabanatuan City', 'Dra. Milgrace Santos', 'Dra. Daysie Ray', 'Normal', '12', '12', '32', '23', '23', 'A', 'Black', 'Black', 'None', '../uploads/27f6777fa527d05799babb7eb829e78b.jpg'),
(53, 27, 'Jhon', 'Cayton', 'Cruda', '2024-10-02', '00:38:00', 'Female', 'Jackielyn', 'Cayton', 'Cruda', 'Eren', 'Cayton', 'Cruda', 'Jackielyn', 'Cayton', 'Cruda', '9912367853', '9912367858', '9912367853', 'Pjg Cabanatuan City', 'Dra. Milgrace Santos', 'Dr. Daniel Parker', 'Normal', '26', '48', '32', '23', '23', 'A', 'Black', 'Black', 'None', '../uploads/c85b0df815b231143f769a4d46040e75.jpg'),
(56, 29, 'Gojo', 'Cayton', 'Cruda', '2024-10-01', '13:15:00', 'Male', 'Jennilyn', 'Cayton', 'Cruda', 'Alden', 'Cayton', 'Cruda', 'Jennilyn', 'Cayton', 'Cruda', '9676692095', '9123421342', '9676692095', 'Pjg Cabanatuan City', 'Dra. Milgrace Santos', 'Dr. Daniel Parker', 'Normal', '26', '48', '32', '23', '23', 'A', 'Brown', 'Black', 'None', '../uploads/d3a433b131d9c1a807274d1bd797d4de.jpg'),
(59, 96, 'Jhony', 'Sison', 'Does', '2024-12-01', '20:42:00', 'Male', 'Kristine', 'Sison', 'Does', 'Jhon', 'Sison', 'Does', 'Jhon', 'Sison', 'Does', '9132141343', '9912367852', '9912367852', 'Pjg Cabanatuan City', 'Dr. Milgrace Santos', 'Dr. Daniel Parker', 'Normal', '12', '23', '32', '23', '23', 'A', 'Red', 'Black', 'None', '../uploads/b9dd0c2831b4850a7aea3307990fa62c.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `immunization_tbl`
--

CREATE TABLE `immunization_tbl` (
  `immunization_id` int(11) NOT NULL,
  `child_id` int(11) NOT NULL,
  `vaccine` varchar(255) NOT NULL,
  `dose` varchar(255) NOT NULL,
  `pediatrician` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `reaction` varchar(255) NOT NULL,
  `next_appointment` date NOT NULL,
  `next_vaccine` varchar(255) NOT NULL,
  `record_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `immunization_tbl`
--

INSERT INTO `immunization_tbl` (`immunization_id`, `child_id`, `vaccine`, `dose`, `pediatrician`, `date`, `reaction`, `next_appointment`, `next_vaccine`, `record_type`) VALUES
(16, 30, 'BCG', '1', 'Dra. Daysie', '2023-09-18', 'None', '0000-00-00', 'N/A', 'past'),
(17, 30, 'Heptasis B', '1', 'Dra. Daysie', '2023-09-18', 'None', '0000-00-00', 'N/A', 'past'),
(19, 30, 'DPT PENTA', '1', 'Dra. Daysie', '2023-11-08', 'None', '0000-00-00', 'N/A', 'past'),
(20, 30, 'DPT PENTA', '2', 'Dra. Daysie', '2023-12-13', 'None', '0000-00-00', 'N/A', 'past'),
(21, 30, 'Polio', '2', 'Dra. Daysie', '2023-12-13', 'None', '0000-00-00', 'N/A', 'past'),
(22, 30, 'DPT PENTA', '3', 'Dra. Daysie', '2024-01-26', 'None', '0000-00-00', 'N/A', 'past'),
(23, 30, 'Polio', '1', 'Dra. Daysie', '2023-11-08', 'None', '0000-00-00', 'N/A', 'past'),
(24, 30, 'Polio', '3', 'Dra. Daysie', '2024-01-26', 'None', '0000-00-00', 'N/A', 'past'),
(25, 30, 'IPV1', '1', 'Dra. Daysie', '2024-01-26', 'None', '0000-00-00', 'N/A', 'past'),
(26, 30, 'IPV2', '2', 'Dra. Daysie', '2024-09-26', 'None', '0000-00-00', 'N/A', 'past'),
(27, 30, 'Measles', '1', 'Dra. Daysie', '2024-06-26', 'None', '0000-00-00', 'N/A', 'past'),
(28, 30, 'Measles', '2', 'Dra. Daysie', '2024-09-26', 'None', '0000-00-00', 'N/A', 'past'),
(29, 30, 'PCV1', '1', 'Dra. Daysie', '2023-11-08', 'None', '0000-00-00', 'N/A', 'past'),
(30, 30, 'PCV2', '2', 'Dra. Daysie', '2023-12-13', 'None', '0000-00-00', 'N/A', 'past'),
(31, 30, 'PCV3', '3', 'Dra. Daysie', '2024-01-26', 'None', '0000-00-00', 'N/A', 'past'),
(32, 31, 'BCG', '1', 'Dr. Yagami Light', '2014-06-11', 'None', '2014-12-10', 'DTwP/DTaP', 'new'),
(38, 47, 'DTwP/DTaP', '2', 'Dr. Riloy C. Dizon', '2024-10-23', 'None', '2024-11-28', 'Heptasis B', 'new'),
(43, 47, 'OPV/IPV', '2', 'Dr. Light L. Yagami', '2024-10-24', 'None', '2024-11-25', 'PPV', 'new'),
(44, 47, 'DTwP/DTaP', '1', 'Dr. Rendon S. Labador', '2024-12-06', 'None', '2024-12-10', 'OPV/IPV', 'new');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `msg_id` int(11) NOT NULL,
  `incoming_msg_id` int(255) NOT NULL,
  `outgoing_msg_id` int(255) NOT NULL,
  `msg` varchar(1000) NOT NULL,
  `time_stamp` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`msg_id`, `incoming_msg_id`, `outgoing_msg_id`, `msg`, `time_stamp`, `status`) VALUES
(100, 1574146021, 618593766, 'Hi', '2024-09-27 02:51:50', 'seen'),
(101, 1574146021, 618593766, 'Hi Jennilyn', '2024-09-27 03:02:55', 'seen'),
(102, 1128570792, 661661948, 'hi', '2024-10-19 10:50:15', 'seen'),
(103, 618593766, 661661948, 'hi doc', '2024-10-06 06:40:57', 'seen'),
(104, 618593766, 1509855895, 'hi doc please cancel my appointment', '2024-10-13 09:08:11', 'seen'),
(105, 618593766, 1434802832, 'hi doc', '2024-10-14 11:40:15', 'seen'),
(106, 1128570792, 1434802832, 'Hi doc', '2024-10-19 13:55:18', 'seen'),
(107, 1434802832, 1128570792, 'why', '2024-10-20 02:54:18', 'seen'),
(108, 1128570792, 1434802832, '.', '2024-10-20 02:54:48', 'seen'),
(109, 618593766, 1434802832, 'hi', '2024-10-19 20:54:28', 'not seen'),
(110, 1128570792, 1434802832, 'hi', '2024-10-20 02:54:48', 'seen'),
(111, 1434802832, 1128570792, 'hello', '2024-10-20 02:56:03', 'seen'),
(112, 215308781, 1434802832, 'Hi po sec', '2024-10-22 03:39:40', 'not seen'),
(133, 1619499514, 1434802832, 'hi boss', '2024-12-02 01:58:45', 'not seen'),
(140, 1619499514, 1434802832, 'hi doc', '2024-12-13 05:09:43', 'not seen'),
(141, 1650696887, 1434802832, 'hi po', '2024-12-13 05:09:56', 'not seen'),
(142, 1128570792, 1434802832, 'sf', '2025-02-13 19:19:14', 'not seen');

-- --------------------------------------------------------

--
-- Table structure for table `staff_tbl`
--

CREATE TABLE `staff_tbl` (
  `staff_id` int(11) NOT NULL,
  `unique_id` int(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `s_fname` varchar(255) NOT NULL,
  `s_m_initial` varchar(255) NOT NULL,
  `s_lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `staff_pic` varchar(255) NOT NULL,
  `code` mediumint(50) NOT NULL,
  `session_status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `staff_tbl`
--

INSERT INTO `staff_tbl` (`staff_id`, `unique_id`, `user_type`, `s_fname`, `s_m_initial`, `s_lname`, `email`, `contact_no`, `pass`, `staff_pic`, `code`, `session_status`) VALUES
(6, 1128570792, 'super_admin', 'Light', 'Boss', 'Yagami', 'admin@gmail.com', '9912367850', '04c8e47afc6018ef7a013d465d397dfe', '../uploads/609803bfe96f89db764d7a15fbe81a2d.jpg', 0, 'Active now'),
(17, 1650696887, 'secretary', 'Kristian', 'Martinez', 'Martinez', 'secretary@gmail.com', '9912367851', '740f8874e28db5cb5a4480e76eda12db', '../uploads/dec5c76bafd5808f25ca349a1c46abba.jpg', 0, 'Offline now'),
(19, 1619499514, 'doctor', 'Rendon', 'Santos', 'Labador', 'doctor@gmail.com', '9776542456', '740f8874e28db5cb5a4480e76eda12db', '../uploads/aa9bd4e3a0622f6716220e77e2735947.jpg', 0, 'Offline now');

-- --------------------------------------------------------

--
-- Table structure for table `user_tbl`
--

CREATE TABLE `user_tbl` (
  `user_id` int(11) NOT NULL,
  `unique_id` int(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `u_fname` varchar(255) NOT NULL,
  `u_m_name` varchar(255) NOT NULL,
  `u_lname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `contact_no` varchar(10) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `barangay` varchar(255) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `zipcode` varchar(255) NOT NULL,
  `relationship` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `session_status` varchar(255) NOT NULL,
  `profile_image` varchar(255) NOT NULL,
  `id_front` varchar(255) NOT NULL,
  `id_back` varchar(255) NOT NULL,
  `code` mediumint(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_tbl`
--

INSERT INTO `user_tbl` (`user_id`, `unique_id`, `user_type`, `u_fname`, `u_m_name`, `u_lname`, `email`, `contact_no`, `pass`, `barangay`, `street`, `city`, `state`, `zipcode`, `relationship`, `status`, `session_status`, `profile_image`, `id_front`, `id_back`, `code`) VALUES
(27, 1698898018, 'user', 'Jackielyn', 'Cay', 'Cruda', 'jackiecruda7@gmail.com', '9912367853', '2db709114b281a3c829eeaef71e2043a', 'San Jose', 'Purok 3', 'Jaen', 'Nueva Ecija', '3109', 'Mother', 'verified', 'Offline now', '../uploads/cc5263bb60ec3d3392654cc24883f946.jpg', '../uploads/7e453442193002fc47d048c904290377.png', '../uploads/70bb2a6b9c64fc88d1e87581ebe310b3.png', 0),
(29, 1574146021, 'user', 'Jennilyn', 'Cayton', 'Cruda', 'crudajennilyn@gmail.com', '9676692095', '20a70918be4540026bf4e8e903d6d29a', 'San Nicolas', 'Pinagpala Street', 'Gapan City', 'Nueva Ecija', '3105', 'Mother', 'verified', 'Offline now', '../uploads/e118adc553571dbd8c752c1bbd7a5b79.jpg', '../uploads/c5fccfe34fc93f14816c360dc4b65e26.png', '../uploads/271e98a40c6b1e8584450fd28edd382c.png', 0),
(37, 1214921392, 'user', 'Marichelle', 'Dela Cruz', 'Maclang', 'marichelle@gmail.com', '9151168318', 'f813a481bfc109fc45577adf629ca8de', 'Langla', 'Papua', 'Jaen', 'Nueva Ecija', '3109', 'Mother', 'verified', 'Offline now', '../uploads/c63e7337b4e3bd0a73c4d40aa7bcecc6.jpg', '../uploads/9b531d462fcc9a6cc58a4aed31b4c4c5.png', '../uploads/e18ec6fa9245f5d9ecd62769facc3dd4.png', 0),
(38, 671011088, 'user', 'Rowena', 'Reyes', 'Dela Cruz', 'rowena@gmail.com', '9353616963', '1af4eea75d5d725638ce839e81fee284', 'San Jose', 'Purok 3', 'Jaen', 'Nueva Ecija', '3109', 'Grandmother', 'verified', 'Offline now', '../uploads/9a723d5314d4ad2922a464ebe7a9f46d.jpg', '../uploads/01799f54cadd855d01b85c71e3bf3084.png', '../uploads/b77ba5fd9263a64c2253094eea9daa38.png', 0),
(40, 929599764, 'user', 'Cherry Lou', 'Azarcon', 'Cruda', 'cherryloucruda08@gmail.com', '9235314690', 'aae0d4a16ddb0ea36eb8aeb390343aac', 'San Jose', 'Purok 2', 'Jaen', 'Nueva Ecija', '3109', 'Mother', 'verified', 'Active now', '../uploads/2f8bdc639ff4b43075e1ae27b4472db7.jpg', '../uploads/86cd3059a118cd86a4338cce2f369975.png', '../uploads/ae81ad1c8b27b0a9d2e3a3389b283e47.png', 0),
(41, 1373896732, 'user', 'Ermelita', 'Azarcon', 'Cruz', 'emerlita15@gmail.com', '9682746094', 'bb39709b512261949d1e8e62ccf13df7', 'Putlod', 'Purok 6', 'Jaen', 'Nueva Ecija', '3109', 'Mother', 'verified', 'Offline now', '../uploads/16d6ba3a9cec2de78afcc1ed73a94b27.jpg', '../uploads/ea67d571b9731913a61d1b83566fa8ee.png', '../uploads/4078806efc21cd84c4dec813bdcd9447.png', 0),
(42, 1077552780, 'user', 'Jeng', 'Azarcon', 'Vicente', 'jhengvicente@gmail.com', '9912367859', 'e7a84c754a4bb2677fb6772c24da25f5', 'San Jose', 'Purok 3', 'Jaen', 'Nueva Ecija', '3109', 'Mother', 'verified', 'Offline now', '../uploads/8e1928ddbf4bf7c1fe010f35eba8dbc9.jpg', '../uploads/9cc134b3b80d6c97896280d434a10c26.png', '../uploads/98f36791571553805e7bfe352337829b.png', 0),
(43, 165284662, 'user', 'Jasmine', 'Reyes', 'Ramos', 'ramosjasmine327@gmail.com', '9005876543', '87989ac9f29cb99b8d9ee78660008fee', 'San Jose', 'Purok 2', 'Jaen', 'Nueva Ecija', '3105', 'Sibling', 'verified', 'Offline now', '../uploads/bd9eecd9f72a7ad56210c3d2aa4aa200.jpg', '../uploads/a31f5f46f9e36c45f4b5cc1574514c21.png', '../uploads/86d0bf93767f76ec536555de9a8973a2.png', 0),
(46, 1434802832, 'user', 'Bruce Daine', 'Martinez', 'Sison', 'sisonbruce224@gmail.com', '9912367858', '2fe2dc0ac062823930bada0a5b0a2c17', 'San Nicolas', 'Pinagpala Street', 'Gapan City', 'Nueva Ecija', '3105', 'Father', 'verified', 'Offline now', '../uploads/91ffc74977db688892040a99d799c074.jpg', '../uploads/02046b1263725d1a2beca98cd44fd473.png', '../uploads/b5107315152eba9dcdfe380807220c98.png', 0),
(96, 264982372, 'user', 'Jhon', 'Sison', 'Does', 'jhondoe@gmail.com', '9912367852', '2fe2dc0ac062823930bada0a5b0a2c17', 'San Nicolas', 'Pinagpala Street', 'Gapan City', 'Nueva Ecija', '3105', 'Father', 'verified', 'Offline now', '../uploads/865e8d035ddba8a8063f25f8e9b8f501.jpg', '../uploads/22c3040a7386109e571fc5a5117ac9f1.png', '../uploads/81710f1697f2b684c95ac3d1cd68c0e4.png', 0),
(97, 720596851, 'user', 'Jhone', 'Martinez', 'Doe', 'user@gmail.com', '9912367855', '51b73493f6c4c0636c4eaa6f320d0a71', 'San Nicolas', 'Pinagpala Street', 'Gapan City', 'Nueva Ecija', '3105', 'Father', 'verified', 'Offline now', '../uploads/8849c1e54ee59df44fbda564f95a6fb9.png', 'N/A', 'N/A', 0);

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_tbl`
--

CREATE TABLE `vaccine_tbl` (
  `vaccine_id` int(11) NOT NULL,
  `vaccine_name` varchar(255) NOT NULL,
  `quantity` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vaccine_tbl`
--

INSERT INTO `vaccine_tbl` (`vaccine_id`, `vaccine_name`, `quantity`) VALUES
(3, 'DTwP/DTaP', 11),
(4, 'OPV/IPV', 14),
(5, 'HiB', 13),
(6, 'Rotavirus', 20),
(7, 'PCV 10/12', 14),
(8, 'PPV', 15),
(9, 'Measles', 15),
(10, 'Influenza', 10),
(11, 'MMR', 5),
(12, 'Varicella', 10),
(13, 'Tyhpoid', 19),
(14, 'Heptasis A', 12),
(15, 'HPV', 11),
(17, 'BCG', 11);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointment_tbl`
--
ALTER TABLE `appointment_tbl`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `break_tbl`
--
ALTER TABLE `break_tbl`
  ADD PRIMARY KEY (`break_id`);

--
-- Indexes for table `checkup_findings_tbl`
--
ALTER TABLE `checkup_findings_tbl`
  ADD PRIMARY KEY (`checkup_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Indexes for table `child_tbl`
--
ALTER TABLE `child_tbl`
  ADD PRIMARY KEY (`child_id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `immunization_tbl`
--
ALTER TABLE `immunization_tbl`
  ADD PRIMARY KEY (`immunization_id`),
  ADD KEY `child_id` (`child_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`msg_id`);

--
-- Indexes for table `staff_tbl`
--
ALTER TABLE `staff_tbl`
  ADD PRIMARY KEY (`staff_id`);

--
-- Indexes for table `user_tbl`
--
ALTER TABLE `user_tbl`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vaccine_tbl`
--
ALTER TABLE `vaccine_tbl`
  ADD PRIMARY KEY (`vaccine_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointment_tbl`
--
ALTER TABLE `appointment_tbl`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=175;

--
-- AUTO_INCREMENT for table `break_tbl`
--
ALTER TABLE `break_tbl`
  MODIFY `break_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `checkup_findings_tbl`
--
ALTER TABLE `checkup_findings_tbl`
  MODIFY `checkup_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `child_tbl`
--
ALTER TABLE `child_tbl`
  MODIFY `child_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT for table `immunization_tbl`
--
ALTER TABLE `immunization_tbl`
  MODIFY `immunization_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `msg_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `staff_tbl`
--
ALTER TABLE `staff_tbl`
  MODIFY `staff_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `user_tbl`
--
ALTER TABLE `user_tbl`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `vaccine_tbl`
--
ALTER TABLE `vaccine_tbl`
  MODIFY `vaccine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointment_tbl`
--
ALTER TABLE `appointment_tbl`
  ADD CONSTRAINT `appointment_tbl_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `user_tbl` (`user_id`);

--
-- Constraints for table `checkup_findings_tbl`
--
ALTER TABLE `checkup_findings_tbl`
  ADD CONSTRAINT `checkup_findings_tbl_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `child_tbl` (`child_id`);

--
-- Constraints for table `child_tbl`
--
ALTER TABLE `child_tbl`
  ADD CONSTRAINT `child_tbl_ibfk_1` FOREIGN KEY (`parent_id`) REFERENCES `user_tbl` (`user_id`);

--
-- Constraints for table `immunization_tbl`
--
ALTER TABLE `immunization_tbl`
  ADD CONSTRAINT `immunization_tbl_ibfk_1` FOREIGN KEY (`child_id`) REFERENCES `child_tbl` (`child_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
