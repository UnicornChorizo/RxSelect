-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 04, 2023 at 09:44 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `code-review`
--

-- --------------------------------------------------------

--
-- Table structure for table `patient`
--

CREATE TABLE `patient` (
  `id` bigint(20) NOT NULL,
  `date_of_birth` date DEFAULT NULL,
  `first_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patient`
--

INSERT INTO `patient` (`id`, `date_of_birth`, `first_name`, `last_name`, `username`) VALUES
(1, '1994-09-27', 'Phil', 'Smith', 'psmith94'),
(2, '1972-05-03', 'Jason', 'Sharp', 'jsharp72'),
(3, '1982-12-15', 'Maria', 'Little', 'mlittle82'),
(4, '2001-02-01', 'Sarah', 'Hopkins', 'shopkins01'),
(5, '1995-08-13', 'Joshua', 'Roberts', 'jroberts95');

-- --------------------------------------------------------

--
-- Table structure for table `treatment`
--

CREATE TABLE `treatment` (
  `id` bigint(20) NOT NULL,
  `completed` bit(1) DEFAULT NULL,
  `patient_id` bigint(20) NOT NULL,
  `presc_date` date DEFAULT NULL,
  `rx_name` varchar(255) DEFAULT NULL,
  `treatment_notes` varchar(2000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `treatment`
--

INSERT INTO `treatment` (`id`, `completed`, `patient_id`, `presc_date`, `rx_name`, `treatment_notes`) VALUES
(1, b'1', 1, '2022-01-09', 'Amoxicillin', 'Take 2 tablets with food twice per day for nine days.'),
(2, b'1', 1, '2022-09-12', 'Ibubrofen', 'Take as needed to relieve pain associated with knee injury.'),
(3, b'0', 1, '2023-01-20', 'None', 'Get plenty of rest and fluids. No Rx needed at this time. Follow up appointment if needed.'),
(4, b'1', 1, '2023-09-09', 'Albuterol', 'Use inhaler as needed to alleviate asthmatic symptoms. Follow up visit in 6 months.'),
(8, b'1', 3, '2023-05-09', 'Prednisone', 'Take two 30mg tablets twice per day to combat inflammation.'),
(9, b'0', 3, '2023-11-12', 'Vicodin', 'Take no more than 10mg (two tablets) every 12 hours or as needed for pain management and dispose of any remaining tablets.'),
(10, b'1', 2, '2023-05-10', 'None', 'Keep off of injured leg for 2 weeks.'),
(11, b'1', 4, '2023-07-11', 'Ibuprofen', 'Take as needed for pain, avoid strenuous activity for 2-3 days.'),
(12, b'0', 5, '2023-11-01', 'Lisinopril', 'Take one 10mg tablet once per day for high blood pressure. Schedule a follow up visit in 6 months.'),
(21, b'0', 1, '2023-12-01', 'Ofloxacin', 'Administer 4 drops per ear twice daily for one month.');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `patient`
--
ALTER TABLE `patient`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `treatment`
--
ALTER TABLE `treatment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `patient_id` (`patient_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `patient`
--
ALTER TABLE `patient`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `treatment`
--
ALTER TABLE `treatment`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `treatment`
--
ALTER TABLE `treatment`
  ADD CONSTRAINT `patient_id` FOREIGN KEY (`patient_id`) REFERENCES `patient` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
