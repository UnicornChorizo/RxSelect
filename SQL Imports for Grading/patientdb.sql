-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 06, 2023 at 12:10 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.0.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `patientdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(11) NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `last_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `doctor_name` varchar(255) NOT NULL,
  `appointment_date` date NOT NULL,
  `appointment_time` time DEFAULT NULL,
  `message` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`id`, `first_name`, `last_name`, `email`, `phone`, `doctor_name`, `appointment_date`, `appointment_time`, `message`, `created_at`) VALUES
(86, 'Romario', 'Barahona', 'romario.barahona@gmail.com', '19196720333', 'Alice Johnson', '2023-11-23', '12:15:00', 'back pain', '2023-11-14 23:04:29');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `id` int(11) NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `specialty` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`id`, `first_name`, `last_name`, `specialty`) VALUES
(1, 'John', 'Smith', 'Cardiologist'),
(2, 'Alice', 'Johnson', 'Dermatologist'),
(3, 'David', 'Wilson', 'Orthopedic Surgeon'),
(4, 'Sarah', 'Clark', 'Pediatrician'),
(5, 'Michael', 'Brown', 'Gastroenterologist'),
(6, 'Emily', 'Davis', 'Ophthalmologist');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `phonenumber` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `reset_token` varchar(255) NOT NULL,
  `reset_token_expires_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`id`, `fullname`, `phonenumber`, `email`, `password`, `reset_token`, `reset_token_expires_at`, `created_at`) VALUES
(1, 'Romario Barahona', '9196720333', 'romario.barahona@gmail.com', '$2y$10$SvcoO5YN52TEa3CxCiwn5eRZ55cFE4FGHB9o2we9WcHCTTcpNqFJO', '', NULL, '2023-12-04 21:12:34'),
(2, 'Jason Sharp', '9191112222', 'jsharp72@email.com', '$2y$10$8sF6z0ovl6JHBGCYgxqlh.W.fNgkdRyEEjGq80ItSWzZUgWmj/t0q', '', NULL, '2023-12-05 19:38:01'),
(3, 'Maria Little', '9192223333', 'mlittle82@email.com', '$2y$10$88m7DqjAv9Nj.M9LDAIaguwTWr/6w6LrxK3sjoc9.ejaAPQrdLpe6', '', NULL, '2023-12-05 19:38:41'),
(4, 'Sarah Hopkins', '9193334444', 'shopkins01@email.com', '$2y$10$MwSmq/WUdNwB3tI24fLxLuwiLpc8tSTaIZh7palyeJzabFYU89e7a', '', NULL, '2023-12-05 19:39:40'),
(5, 'Joshua Roberts', '9194445555', 'jroberts95@email.com', '$2y$10$raG6v.gBcnnxHt0ptcl/GupBkt/q8w.etKTeZT7XL6MNRa0/zqBIq', '', NULL, '2023-12-05 19:40:06'),
(6, 'Dr. John Smith', '1239999123', 'jsmith@doctors.rxselect.com', '$2y$10$y6HNtKsRQBMP3bZOruIilecw34w5UDqW9NQsbnaQeFQ33bk9iWDKG', '', NULL, '2023-12-05 21:32:47'),
(7, 'Admin Jane Doe', '0980980098', 'jdoe@admin.rxselect.com', '$2y$10$la4kFmWCFdXzxfPoYE0td.adFjJlJgzZNWBa1/MjFXQhhiUF4T4OW', '', NULL, '2023-12-05 21:43:27');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
