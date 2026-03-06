-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 06, 2026 at 04:31 PM
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
-- Database: `military_unit`
--

-- --------------------------------------------------------

--
-- Table structure for table `civilian_applications`
--

CREATE TABLE `civilian_applications` (
  `application_ID` int(11) NOT NULL,
  `full_name` varchar(50) NOT NULL,
  `email` varchar(30) NOT NULL,
  `phone_number` varchar(10) DEFAULT NULL,
  `cv_document` varchar(1000) DEFAULT NULL,
  `application_date` date NOT NULL,
  `status` varchar(10) NOT NULL,
  `reviewed_by` int(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `civilian_applications`
--

INSERT INTO `civilian_applications` (`application_ID`, `full_name`, `email`, `phone_number`, `cv_document`, `application_date`, `status`, `reviewed_by`) VALUES
(1, 'Andreea Marinescu', 'andreea.marinescu@gmail.com', '0744556677', 'Experienced in field logistics with NATO deployment.', '2025-05-23', 'pending', NULL),
(2, 'Ionut Pavel', 'ionut.pavel@gmail.com', '0749988776', 'Mechanical engineer with 5 years experience in military vehicle repair.', '2025-05-23', 'pending', NULL),
(3, 'Mihaela Petrescu', 'mihaela.petrescu@gmail.com', '0755223344', 'Former military nurse with emergency response expertise.', '2025-05-23', 'pending', NULL),
(4, 'Bratian Melisa-Adriana', 'bratian.melisa@yahoo.com', '0752528691', 'I am a former high-performance athlete, disciplined and resilient. I believe I can add value to a military team and I wish to pursue an active career in the military.', '2025-05-27', 'accepted', 5005),
(11, 'Melisa Bratian', 'bratian.melisa@yahoo.com', '0752528691', 'fara experienta', '2025-05-30', 'accepted', 5005);

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `equipment_id` int(11) NOT NULL,
  `equipment_name` varchar(50) DEFAULT NULL,
  `category` varchar(30) DEFAULT NULL,
  `model` varchar(30) DEFAULT NULL,
  `serial_number` varchar(50) DEFAULT NULL,
  `status` enum('assigned') NOT NULL,
  `assigned_to` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipment_id`, `equipment_name`, `category`, `model`, `serial_number`, `status`, `assigned_to`) VALUES
(3, 'AK-47', 'Rifle', 'AKM', 'AKG3205', 'assigned', 3217),
(4, 'Beretta M9', 'Handgun', 'M9', 'BER3206', 'assigned', 3206),
(5, 'Colt M1911', 'Handgun', '1911A1', 'CLT1911X', 'assigned', 3202),
(6, 'HK MP5', 'SMG', 'MP5', 'HKM3209', 'assigned', 3209),
(7, 'Steyr AUG', 'Rifle', 'A3', 'STYRAUG07', 'assigned', 3203),
(8, 'Colt 1911', 'Handgun', '1911', 'CLT3213', 'assigned', 3215),
(9, 'Sig Sauer P320', 'Handgun', 'P320', 'SIG5004', 'assigned', 5004),
(10, 'Tavor X95', 'Rifle', 'X95', 'TAV5005', 'assigned', 5005),
(11, 'FN SCAR-L', 'Rifle', 'SCAR-L', 'SCAR1234', 'assigned', 3216),
(12, 'FN Five-seveN', 'Handgun', 'MK2', 'FNSN2024', 'assigned', 3208),
(13, 'Desert Eagle', 'Handgun', 'XIX', 'DEAG9012', 'assigned', 3203),
(14, 'Tavor TAR-21', 'Rifle', 'TAR-21', 'TAR2114', 'assigned', 3210),
(15, 'MP7', 'SMG', 'A1', 'MP70007', 'assigned', 3207);

-- --------------------------------------------------------

--
-- Table structure for table `equipment_management`
--

CREATE TABLE `equipment_management` (
  `id` int(11) NOT NULL,
  `equipment_ID` int(11) DEFAULT NULL,
  `user_ID` int(11) DEFAULT NULL,
  `status` enum('available','assigned','returned','damaged') NOT NULL,
  `allocation_date` date DEFAULT NULL,
  `return_date` date DEFAULT NULL,
  `leave_request_ID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment_management`
--

INSERT INTO `equipment_management` (`id`, `equipment_ID`, `user_ID`, `status`, `allocation_date`, `return_date`, `leave_request_ID`) VALUES
(40, 3, 3205, 'assigned', '2025-05-03', NULL, NULL),
(41, 4, 3206, 'assigned', '2025-05-04', NULL, NULL),
(42, 6, 3209, 'assigned', '2025-05-05', NULL, NULL),
(44, 8, 3213, 'assigned', '2025-05-07', NULL, NULL),
(45, 9, 5004, 'assigned', '2025-05-08', NULL, NULL),
(46, 10, 5005, 'assigned', '2025-05-09', NULL, NULL),
(55, 3, 3214, 'assigned', '2025-05-27', NULL, NULL),
(56, 3, 3217, 'assigned', '2025-05-29', NULL, NULL),
(65, 11, 3216, 'assigned', '2025-05-29', NULL, NULL),
(66, 13, 3203, 'assigned', '2025-05-28', NULL, NULL),
(67, 15, 3207, 'assigned', '2025-05-25', NULL, NULL),
(86, 3, NULL, 'available', '2025-05-31', NULL, NULL),
(87, 4, NULL, 'available', '2025-05-31', NULL, NULL),
(88, 5, NULL, 'available', '2025-05-31', NULL, NULL),
(89, 6, NULL, 'available', '2025-05-31', NULL, NULL),
(90, 7, NULL, 'available', '2025-05-31', NULL, NULL),
(91, 8, 3215, 'assigned', '2025-05-30', NULL, NULL),
(92, 9, NULL, 'available', '2025-05-31', NULL, NULL),
(93, 10, NULL, 'available', '2025-05-31', NULL, NULL),
(94, 11, NULL, 'available', '2025-05-31', NULL, NULL),
(95, 12, NULL, 'available', '2025-05-31', NULL, NULL),
(96, 13, NULL, 'available', '2025-05-31', NULL, NULL),
(97, 14, NULL, 'available', '2025-05-31', NULL, NULL),
(98, 15, NULL, 'available', '2025-05-31', NULL, NULL);

-- --------------------------------------------------------

--
-- Stand-in structure for view `history_leave`
-- (See below for the actual view)
--
CREATE TABLE `history_leave` (
`leave_request_ID` int(4)
,`user_ID` int(4)
,`start_date` date
,`end_date` date
,`reason` varchar(200)
,`status` varchar(20)
,`equipment_returned` varchar(10)
);

-- --------------------------------------------------------

--
-- Table structure for table `leave_requests`
--

CREATE TABLE `leave_requests` (
  `ID` int(4) NOT NULL,
  `user_ID` int(4) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `reason` varchar(200) NOT NULL,
  `status` varchar(20) NOT NULL,
  `equipment_returned` varchar(10) NOT NULL,
  `submission_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `leave_requests`
--

INSERT INTO `leave_requests` (`ID`, `user_ID`, `start_date`, `end_date`, `reason`, `status`, `equipment_returned`, `submission_date`) VALUES
(1, 3208, '2025-05-01', '2025-05-15', 'Medical recovery', 'approved', 'yes', '2025-04-10'),
(2, 3209, '2025-04-20', '2025-04-28', 'Family emergency', 'completed', 'yes', '2025-04-05'),
(4, 3211, '2025-05-01', '2025-09-01', 'Long-term medical treatment', 'approved', 'no', '2025-04-15'),
(16, 3215, '2025-06-03', '2025-06-06', 'medical', 'pending', 'no', '2025-05-30');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `task_ID` int(11) NOT NULL,
  `assigned_to` int(4) NOT NULL,
  `task_name` varchar(100) NOT NULL,
  `description` varchar(300) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`task_ID`, `assigned_to`, `task_name`, `description`, `start_date`, `end_date`, `status`) VALUES
(14, 3201, 'Patrol Border Area', 'Conduct a patrol in designated perimeter near checkpoint A5.', '2025-06-10', '2025-06-11', 'pending'),
(15, 3202, 'Inventory Weapons', 'Check and report status of all weapons in armory section 2.', '2025-06-20', '2025-06-20', 'pending'),
(16, 3205, 'Base Maintenance', 'Assist in cleaning and repairing barracks facilities.', '2025-06-18', '2025-06-18', 'pending'),
(17, 3206, 'Escort VIP', 'Escort and protect visiting NATO officials within base.', '2025-06-15', '2025-06-18', 'pending'),
(18, 3209, 'Guard Duty', 'Stand guard at northern base entrance, shift B.', '2025-06-01', '2025-06-02', 'pending'),
(19, 3210, 'Vehicle Inspection', 'Inspect and log technical status of all transport vehicles.', '2025-06-09', '2025-06-09', 'pending'),
(20, 3213, 'First Aid Training', 'Attend and assist with medical first aid field training.', '2025-06-06', '2025-06-06', 'pending'),
(21, 5004, 'Radio Communication Setup', 'Test and configure radios for upcoming mission.', '2025-06-07', '2025-06-07', 'pending'),
(22, 5005, 'Night Surveillance', 'Perform surveillance operations using thermal optics.', '2025-06-07', '2025-06-08', 'pending'),
(23, 3208, 'Urgent cleaning', 'Cleaning done in all main offices', '2025-05-28', '2025-05-29', 'in progress'),
(27, 3215, 'cleaning', 'genral cleaning', '2025-06-02', '2025-06-02', 'in progress');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `ID` int(4) NOT NULL,
  `Name` varchar(20) NOT NULL,
  `Surname` varchar(40) NOT NULL,
  `Email` varchar(40) NOT NULL,
  `Password` varchar(30) NOT NULL,
  `Rank` varchar(20) NOT NULL,
  `Position` varchar(20) NOT NULL,
  `Phone_Number` varchar(10) NOT NULL,
  `Date_of_Enrollement` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`ID`, `Name`, `Surname`, `Email`, `Password`, `Rank`, `Position`, `Phone_Number`, `Date_of_Enrollement`) VALUES
(3201, 'Ion', 'Ionescu', 'ion.ionescu@army.ro', 'pass123', 'Soldier', 'Infantry', '0711000001', '2022-01-15'),
(3202, 'Mihai', 'Popa', 'mihai.popa@army.ro', 'pass123', 'Soldier', 'Logistics', '0711000002', '2023-03-20'),
(3203, 'Alexandru', 'Georgescu', 'alex.georgescu@army.ro', 'pass123', 'Soldier', 'Infantry', '0711000003', '2021-07-10'),
(3204, 'Vasile', 'Stan', 'vasile.stan@army.ro', 'pass123', 'Soldier', 'Communications', '0711000004', '2022-11-05'),
(3205, 'George', 'Enache', 'george.enache@army.ro', 'pass123', 'Soldier', 'Infantry', '0711000005', '2024-01-23'),
(3206, 'Cristian', 'Dumitru', 'cristian.dumitru@army.ro', 'pass123', 'Soldier', 'Infantry', '0711000006', '2023-05-14'),
(3207, 'Radu', 'Toma', 'radu.toma@army.ro', 'pass123', 'Soldier', 'Logistics', '0711000007', '2021-10-01'),
(3208, 'Andrei', 'Neagu', 'andrei.neagu@army.ro', 'pass123', 'Soldier', 'Infantry', '0711000008', '2022-06-18'),
(3209, 'Florin', 'Preda', 'florin.preda@army.ro', 'pass123', 'Soldier', 'Infantry', '0711000009', '2022-08-30'),
(3210, 'Daniel', 'Marin', 'daniel.marin@army.ro', 'pass123', 'Soldier', 'Mechanics', '0711000010', '2023-02-25'),
(3211, 'Sebastian', 'Ilie', 'sebastian.ilie@army.ro', 'pass123', 'Soldier', 'Infantry', '0711000011', '2023-04-19'),
(3212, 'Valentin', 'Pop', 'valentin.pop@army.ro', 'pass123', 'Soldier', 'Infantry', '0711000012', '2024-02-28'),
(3213, 'Bogdan', 'Mihail', 'bogdan.mihail@army.ro', 'pass123', 'Soldier', 'Logistics', '0711000013', '2021-12-03'),
(3214, 'Emil', 'Radulescu', 'emil.radulescu@army.ro', 'pass123', 'Soldier', 'Infantry', '0711000014', '2022-04-17'),
(3215, 'Dragos', 'Tudor', 'dragos.tudor@army.ro', 'pass123', 'Soldier', 'Infantry', '0711000015', '2022-09-08'),
(3216, 'Lucian', 'Stefan', 'lucian.stefan@army.ro', 'pass123', 'Soldier', 'Infantry', '0711000016', '2023-07-21'),
(3217, 'Silviu', 'Grigore', 'silviu.grigore@army.ro', 'pass123', 'Soldier', 'Infantry', '0711000017', '2023-11-30'),
(5003, 'Elena', 'Toma', 'elena.toma@army.ro', 'pass123', 'Lieutenant', 'Logistics', '0722000003', '2022-07-05'),
(5004, 'Dan', 'Voicu', 'dan.voicu@army.ro', 'pass123', 'Major', 'Commander', '0722000004', '2019-12-01'),
(5005, 'Irina', 'Nistor', 'irina.nistor@army.ro', 'pass123', 'Captain', 'Training', '0722000005', '2023-01-15');

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_assigned_equipment`
-- (See below for the actual view)
--
CREATE TABLE `view_assigned_equipment` (
`user_ID` int(11)
,`user_name` varchar(20)
,`user_surname` varchar(40)
,`equipment_name` varchar(50)
,`category` varchar(30)
,`model` varchar(30)
,`serial_number` varchar(50)
,`status` enum('available','assigned','returned','damaged')
,`return_date` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_current_leave`
-- (See below for the actual view)
--
CREATE TABLE `view_current_leave` (
`user_id` int(4)
,`Name` varchar(20)
,`Surname` varchar(40)
,`Start_Date` date
,`End_Date` date
);

-- --------------------------------------------------------

--
-- Stand-in structure for view `view_upcoming_tasks`
-- (See below for the actual view)
--
CREATE TABLE `view_upcoming_tasks` (
`task_name` varchar(100)
,`status` varchar(20)
,`description` varchar(300)
,`start_date` date
,`end_date` date
,`Name` varchar(20)
,`Surname` varchar(40)
);

-- --------------------------------------------------------

--
-- Structure for view `history_leave`
--
DROP TABLE IF EXISTS `history_leave`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `history_leave`  AS SELECT `leave_requests`.`ID` AS `leave_request_ID`, `leave_requests`.`user_ID` AS `user_ID`, `leave_requests`.`start_date` AS `start_date`, `leave_requests`.`end_date` AS `end_date`, `leave_requests`.`reason` AS `reason`, `leave_requests`.`status` AS `status`, `leave_requests`.`equipment_returned` AS `equipment_returned` FROM `leave_requests` WHERE `leave_requests`.`end_date` < curdate() ;

-- --------------------------------------------------------

--
-- Structure for view `view_assigned_equipment`
--
DROP TABLE IF EXISTS `view_assigned_equipment`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_assigned_equipment`  AS SELECT `em`.`user_ID` AS `user_ID`, `u`.`Name` AS `user_name`, `u`.`Surname` AS `user_surname`, `e`.`equipment_name` AS `equipment_name`, `e`.`category` AS `category`, `e`.`model` AS `model`, `e`.`serial_number` AS `serial_number`, `em`.`status` AS `status`, `em`.`return_date` AS `return_date` FROM ((`equipment_management` `em` join `equipment` `e` on(`em`.`equipment_ID` = `e`.`equipment_id`)) join `users` `u` on(`em`.`user_ID` = `u`.`ID`)) WHERE `em`.`status` = 'assigned' ;

-- --------------------------------------------------------

--
-- Structure for view `view_current_leave`
--
DROP TABLE IF EXISTS `view_current_leave`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_current_leave`  AS SELECT `u`.`ID` AS `user_id`, `u`.`Name` AS `Name`, `u`.`Surname` AS `Surname`, `l`.`start_date` AS `Start_Date`, `l`.`end_date` AS `End_Date` FROM (`leave_requests` `l` join `users` `u` on(`l`.`user_ID` = `u`.`ID`)) WHERE `l`.`status` = 'approved' AND curdate() between `l`.`start_date` and `l`.`end_date` ;

-- --------------------------------------------------------

--
-- Structure for view `view_upcoming_tasks`
--
DROP TABLE IF EXISTS `view_upcoming_tasks`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `view_upcoming_tasks`  AS SELECT `t`.`task_name` AS `task_name`, `t`.`status` AS `status`, `t`.`description` AS `description`, `t`.`start_date` AS `start_date`, `t`.`end_date` AS `end_date`, `u`.`Name` AS `Name`, `u`.`Surname` AS `Surname` FROM (`tasks` `t` join `users` `u` on(`t`.`assigned_to` = `u`.`ID`)) WHERE `t`.`start_date` >= curdate() ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `civilian_applications`
--
ALTER TABLE `civilian_applications`
  ADD PRIMARY KEY (`application_ID`),
  ADD KEY `reviewed_by` (`reviewed_by`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equipment_id`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `equipment_management`
--
ALTER TABLE `equipment_management`
  ADD PRIMARY KEY (`id`),
  ADD KEY `equipment_management_ibfk_1` (`equipment_ID`),
  ADD KEY `equipment_management_ibfk_2` (`leave_request_ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `user_ID` (`user_ID`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`task_ID`),
  ADD KEY `assigned_to` (`assigned_to`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `civilian_applications`
--
ALTER TABLE `civilian_applications`
  MODIFY `application_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `equipment_management`
--
ALTER TABLE `equipment_management`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT for table `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `ID` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `task_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `civilian_applications`
--
ALTER TABLE `civilian_applications`
  ADD CONSTRAINT `civilian_applications_ibfk_1` FOREIGN KEY (`reviewed_by`) REFERENCES `users` (`ID`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`ID`);

--
-- Constraints for table `equipment_management`
--
ALTER TABLE `equipment_management`
  ADD CONSTRAINT `equipment_management` FOREIGN KEY (`leave_request_ID`) REFERENCES `leave_requests` (`ID`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `equipment_management_ibfk_1` FOREIGN KEY (`equipment_ID`) REFERENCES `equipment` (`equipment_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipment_management_ibfk_2` FOREIGN KEY (`leave_request_ID`) REFERENCES `leave_requests` (`ID`) ON DELETE CASCADE,
  ADD CONSTRAINT `equipment_management_ibfk_3` FOREIGN KEY (`user_ID`) REFERENCES `users` (`ID`);

--
-- Constraints for table `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`user_ID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `tasks`
--
ALTER TABLE `tasks`
  ADD CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`assigned_to`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
