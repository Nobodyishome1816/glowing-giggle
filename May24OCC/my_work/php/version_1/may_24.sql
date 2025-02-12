-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Feb 12, 2025 at 08:30 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

-- Create the database
CREATE DATABASE IF NOT EXISTS may_24;
USE may_24;

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `may_24`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `admin_user_id` int NOT NULL,
  `password` text NOT NULL,
  `email` text NOT NULL,
  `f_name` text NOT NULL,
  `s_name` text NOT NULL,
  `signup_date` int NOT NULL,
  `privl` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`admin_user_id`, `password`, `email`, `f_name`, `s_name`, `signup_date`, `privl`) VALUES
(1, '$2y$10$obDOhhIVKFQpfQ4274P53e6QBeRKuV8z2ziEtcHghN4b91TjAY0R2', 'tomishere@hello.com', 'Tom', 'McAllister', 1739276789, 'SUPER');

-- --------------------------------------------------------

--
-- Table structure for table `hotel_booking`
--

CREATE TABLE `hotel_booking` (
  `Hbooking_id` int NOT NULL,
  `date_created` int NOT NULL,
  `date_of_arrival` int NOT NULL,
  `no_of_nights` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_room`
--

CREATE TABLE `hotel_room` (
  `hroom_id` int NOT NULL,
  `room_type` int NOT NULL,
  `capacity` int NOT NULL,
  `price` int NOT NULL,
  `no_of_rooms` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `loyalty`
--

CREATE TABLE `loyalty` (
  `loyalty_id` int NOT NULL,
  `points` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staying_in`
--

CREATE TABLE `staying_in` (
  `stay_id` int NOT NULL,
  `hroom_id` int NOT NULL,
  `no_of_people` int NOT NULL,
  `Hbooking_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `ticket_id` int NOT NULL,
  `ticket_type` text NOT NULL,
  `no_of_tickets` int NOT NULL,
  `price` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_booking`
--

CREATE TABLE `ticket_booking` (
  `Tbooking_id` int NOT NULL,
  `date_booked` int NOT NULL,
  `date` int NOT NULL,
  `user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `userid` int NOT NULL,
  `email` text NOT NULL,
  `password` text NOT NULL,
  `signup_date` int NOT NULL,
  `utype_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`userid`, `email`, `password`, `signup_date`, `utype_id`) VALUES
(11, 'tom.mcallister@utcleeds.co.uk', '$2y$10$2YQX2IoyNTzkm4Rfp84./OtRhUszpQW9ACuKbFqp9OVbYLp/6LuO6', 1739279690, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_type`
--

CREATE TABLE `user_type` (
  `utype_id` int NOT NULL,
  `type` text NOT NULL,
  `discount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_type`
--

INSERT INTO `user_type` (`utype_id`, `type`, `discount`) VALUES
(1, 'consumer', 1),
(2, 'commercial', 0.8),
(3, 'education', 0.9);

-- --------------------------------------------------------

--
-- Table structure for table `visits`
--

CREATE TABLE `visits` (
  `visit_id` int NOT NULL,
  `Tbooking_id` int NOT NULL,
  `ticket_id` int NOT NULL,
  `no_of_tickets` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`admin_user_id`);

--
-- Indexes for table `hotel_booking`
--
ALTER TABLE `hotel_booking`
  ADD PRIMARY KEY (`Hbooking_id`),
  ADD KEY `Hbooking_id` (`Hbooking_id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `hotel_room`
--
ALTER TABLE `hotel_room`
  ADD PRIMARY KEY (`hroom_id`),
  ADD KEY `hroom_id` (`hroom_id`),
  ADD KEY `hroom_id_2` (`hroom_id`);

--
-- Indexes for table `loyalty`
--
ALTER TABLE `loyalty`
  ADD PRIMARY KEY (`loyalty_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `staying_in`
--
ALTER TABLE `staying_in`
  ADD PRIMARY KEY (`stay_id`),
  ADD KEY `Hbooking_id` (`Hbooking_id`),
  ADD KEY `hroom_id` (`hroom_id`);

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`ticket_id`),
  ADD KEY `ticket_id` (`ticket_id`),
  ADD KEY `ticket_id_2` (`ticket_id`);

--
-- Indexes for table `ticket_booking`
--
ALTER TABLE `ticket_booking`
  ADD PRIMARY KEY (`Tbooking_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`userid`),
  ADD KEY `userid` (`userid`),
  ADD KEY `utype_id` (`utype_id`);

--
-- Indexes for table `user_type`
--
ALTER TABLE `user_type`
  ADD PRIMARY KEY (`utype_id`),
  ADD KEY `utype_id` (`utype_id`);

--
-- Indexes for table `visits`
--
ALTER TABLE `visits`
  ADD PRIMARY KEY (`visit_id`),
  ADD KEY `Tbooking_id` (`Tbooking_id`,`ticket_id`),
  ADD KEY `ticket_id` (`ticket_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `admin_user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `hotel_booking`
--
ALTER TABLE `hotel_booking`
  MODIFY `Hbooking_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hotel_room`
--
ALTER TABLE `hotel_room`
  MODIFY `hroom_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `loyalty`
--
ALTER TABLE `loyalty`
  MODIFY `loyalty_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `staying_in`
--
ALTER TABLE `staying_in`
  MODIFY `stay_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `ticket_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_booking`
--
ALTER TABLE `ticket_booking`
  MODIFY `Tbooking_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `userid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `user_type`
--
ALTER TABLE `user_type`
  MODIFY `utype_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `visits`
--
ALTER TABLE `visits`
  MODIFY `visit_id` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hotel_booking`
--
ALTER TABLE `hotel_booking`
  ADD CONSTRAINT `hotel_booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `staying_in`
--
ALTER TABLE `staying_in`
  ADD CONSTRAINT `staying_in_ibfk_1` FOREIGN KEY (`Hbooking_id`) REFERENCES `hotel_booking` (`Hbooking_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `staying_in_ibfk_2` FOREIGN KEY (`hroom_id`) REFERENCES `hotel_room` (`hroom_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `ticket_booking`
--
ALTER TABLE `ticket_booking`
  ADD CONSTRAINT `ticket_booking_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`userid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`utype_id`) REFERENCES `user_type` (`utype_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `visits`
--
ALTER TABLE `visits`
  ADD CONSTRAINT `visits_ibfk_1` FOREIGN KEY (`Tbooking_id`) REFERENCES `ticket_booking` (`Tbooking_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `visits_ibfk_2` FOREIGN KEY (`ticket_id`) REFERENCES `ticket` (`ticket_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
