-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2024 at 03:41 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dicms`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `image` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `first_name`, `last_name`, `phone_number`, `image`, `email`, `password`, `created_at`) VALUES
(1, 'Usman', 'Shehu', '09033445566', 'uploads/murja (2).jpg', 'mujanatu@gmail.com', '$2y$10$TGm2ZTOrO5J9dd02k0qpVOkq4MubBmgaY7LUFDDtkdBKx2VVAubhS', '2024-09-28 05:03:27');

-- --------------------------------------------------------

--
-- Table structure for table `ceo_profiles`
--

CREATE TABLE `ceo_profiles` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `passport` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` text NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `address` varchar(255) NOT NULL,
  `state_of_origin` varchar(50) NOT NULL,
  `lga_of_origin` varchar(50) NOT NULL,
  `identification_type` enum('National ID card','Driving License','International Passport','Voters Card') NOT NULL,
  `identification_file` varchar(255) NOT NULL,
  `submission_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `ceo_profiles`
--

INSERT INTO `ceo_profiles` (`id`, `first_name`, `last_name`, `middle_name`, `gender`, `passport`, `dob`, `email`, `password`, `phone_number`, `address`, `state_of_origin`, `lga_of_origin`, `identification_type`, `identification_file`, `submission_date`) VALUES
(9, 'Umar', 'Abubakar', 'Aliyu', 'Male', 'murja (2).jpg', '2024-09-26', 'mujanatu@gmail.com', '$2y$10$szdSs5RwSyDoIkdO1KzMIeM3Yrl5AEt7lnTUmbeICiDgTSWWX4C/e', '09160163222', 'YC5, HAKIMI STR MASALLACIN ,KES QTRS GIDA DUDU JIGAWA', 'Jigawa', '---', 'National ID card', '000web.PNG', '2024-09-26 12:45:23');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` int(1) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `user_id`, `title`, `message`, `status`, `created_at`) VALUES
(1, 9, 'Problem', 'Testing report...', 0, '2024-09-26 17:32:30');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reference` varchar(255) NOT NULL,
  `amount` float NOT NULL,
  `status` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `user_id`, `reference`, `amount`, `status`, `created_at`) VALUES
(1, 9, 'T536084948641594', 10000, 'success', '2024-09-28 12:58:47');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL,
  `shop_id` int(11) NOT NULL,
  `ceo_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `description`, `image`, `shop_id`, `ceo_id`, `created_at`) VALUES
(2, 'BULK Printing', 'We have DI printer for your problems', 'pic2.jpg', 2, 9, '2024-09-21 18:14:50');

-- --------------------------------------------------------

--
-- Table structure for table `shop_profiles`
--

CREATE TABLE `shop_profiles` (
  `id` int(11) NOT NULL,
  `ceo_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `motto` varchar(255) DEFAULT NULL,
  `address` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone_number` varchar(20) NOT NULL,
  `rc_number` varchar(50) NOT NULL,
  `verify` int(1) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `banner` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shop_profiles`
--

INSERT INTO `shop_profiles` (`id`, `ceo_id`, `name`, `motto`, `address`, `email`, `phone_number`, `rc_number`, `verify`, `logo`, `banner`, `created_at`) VALUES
(2, 9, 'F2 Compiter institute', 'The wold of Printing Press', 'Kano State', 'abubakar@gmail.com', '09160163113', '22447709', 0, 'logo.jpg', 'pic2.jpg', '2024-09-21 18:12:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `ceo_profiles`
--
ALTER TABLE `ceo_profiles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `shop_id` (`shop_id`),
  ADD KEY `ceo_id` (`ceo_id`);

--
-- Indexes for table `shop_profiles`
--
ALTER TABLE `shop_profiles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `ceo_profiles`
--
ALTER TABLE `ceo_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `shop_profiles`
--
ALTER TABLE `shop_profiles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `ceo_profiles` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`shop_id`) REFERENCES `shop_profiles` (`id`),
  ADD CONSTRAINT `products_ibfk_2` FOREIGN KEY (`ceo_id`) REFERENCES `ceo_profiles` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
