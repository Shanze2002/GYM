-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 18, 2025 at 07:21 AM
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
-- Database: `fitgym`
--

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(100) NOT NULL,
  `title` varchar(250) NOT NULL,
  `content` varchar(700) NOT NULL,
  `image` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `title`, `content`, `image`) VALUES
(1, '5 Cardio Workouts That Burn Fat Fast', 'Cardio is a fantastic way to torch calories and boost endurance. At FitZone, we offer HIIT, Zumba, treadmill intervals, spinning, and jump rope sessions designed for all levels. Join our classes to sweat smarter and stay motivated!\r\n\r\n💡 Tip: Combine cardio with strength training for best results.', 'uploads/anas.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`email`, `password`, `role`) VALUES
('shanzeboy@gmail.com', '8810116', 'Customer'),
('shanze@gmail.com', '123456', 'Customer');

-- --------------------------------------------------------

--
-- Table structure for table `reg`
--

CREATE TABLE `reg` (
  `userId` int(100) NOT NULL,
  `firstname` varchar(100) NOT NULL,
  `lastname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `role` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reg`
--

INSERT INTO `reg` (`userId`, `firstname`, `lastname`, `email`, `password`, `role`) VALUES
(2, 'Anas', 'ana', 'shanze@gmail.com', '123456', 'Customer'),
(3, 'abc', 'abc', 'abc@gmail.com', '$2y$10$Ho0OBJIvtJWwLOI70DlDeeD.JNtTgkB/osTYnOWiYgo7FBQtmbnJK', 'admin'),
(4, 'fgh', 'fgh', 'fgh@gmail.com', '$2y$10$FrueyqY/tU5qQM8AWFBuc./aipEvSrALCNDJd7tEmjutEd.bf5.xe', 'staff'),
(5, 'saman', 'saman', 'saman@gamil.com', '$2y$10$/7mGpX2pQYmsDRv0KbHduO8T/cHvOckdvBl3zPGFyIPbLu.CHhGkS', 'customer');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `reg`
--
ALTER TABLE `reg`
  ADD PRIMARY KEY (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
