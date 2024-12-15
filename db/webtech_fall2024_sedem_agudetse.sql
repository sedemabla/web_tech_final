-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 15, 2024 at 05:03 PM
-- Server version: 8.0.40-0ubuntu0.24.04.1
-- PHP Version: 8.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `webtech_fall2024_sedem_agudetse`
--

-- --------------------------------------------------------

--
-- Table structure for table `activities`
--

CREATE TABLE `activities` (
  `id` int NOT NULL,
  `activity` varchar(255) DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_categories`
--

CREATE TABLE `pet_categories` (
  `category_id` int NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_diy_projects`
--

CREATE TABLE `pet_diy_projects` (
  `diy_id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `materials` text NOT NULL,
  `steps` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_health_tips`
--

CREATE TABLE `pet_health_tips` (
  `health_id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `health_category` enum('Nutrition','Exercise','Medical Care') NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_media`
--

CREATE TABLE `pet_media` (
  `media_id` int NOT NULL,
  `post_type` enum('DIY','Training','Health') NOT NULL,
  `post_id` int NOT NULL,
  `media_url` varchar(255) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_training_tips`
--

CREATE TABLE `pet_training_tips` (
  `training_id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `techniques` text NOT NULL,
  `difficulty_level` enum('Beginner','Intermediate','Advanced') DEFAULT 'Beginner',
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pet_users`
--

CREATE TABLE `pet_users` (
  `user_id` int NOT NULL,
  `first_name` varchar(50) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` tinyint(1) NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `pet_users`
--

INSERT INTO `pet_users` (`user_id`, `first_name`, `last_name`, `username`, `email`, `password`, `created_at`, `role`) VALUES
(1, 'Zeph', 'Cabrera', 'dizujygemu', 'jala@mailinator.com', '$2y$10$Xu7NU.jaIHW1DzJ5w5kiwu8e/mOKqc81s7luqGFg1UGDV9B40V8cm', '2024-12-15 16:09:03', 2),
(2, 'Noel', 'Sparks', 'pizoloc', 'goryvyzuf@mailinator.com', '$2y$10$wHRwu7n3Q/wDoTGIHIqyqexD0oUtMXJxJKveH0b1YH/tdwiCxbImS', '2024-12-15 16:28:40', 1),
(3, 'TaShya', 'Mcbride', 'qykok', 'lohofax@mailinator.com', '$2y$10$EADUTaXdbrrSwDkpFRzdcexu.NszAHgiFzlMjaGd9aT820XAkG.bK', '2024-12-15 16:49:01', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activities`
--
ALTER TABLE `activities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pet_categories`
--
ALTER TABLE `pet_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- Indexes for table `pet_diy_projects`
--
ALTER TABLE `pet_diy_projects`
  ADD PRIMARY KEY (`diy_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pet_health_tips`
--
ALTER TABLE `pet_health_tips`
  ADD PRIMARY KEY (`health_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pet_media`
--
ALTER TABLE `pet_media`
  ADD PRIMARY KEY (`media_id`),
  ADD KEY `post_id` (`post_id`);

--
-- Indexes for table `pet_training_tips`
--
ALTER TABLE `pet_training_tips`
  ADD PRIMARY KEY (`training_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pet_users`
--
ALTER TABLE `pet_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activities`
--
ALTER TABLE `activities`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_categories`
--
ALTER TABLE `pet_categories`
  MODIFY `category_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_diy_projects`
--
ALTER TABLE `pet_diy_projects`
  MODIFY `diy_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_health_tips`
--
ALTER TABLE `pet_health_tips`
  MODIFY `health_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_media`
--
ALTER TABLE `pet_media`
  MODIFY `media_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_training_tips`
--
ALTER TABLE `pet_training_tips`
  MODIFY `training_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pet_users`
--
ALTER TABLE `pet_users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `pet_diy_projects`
--
ALTER TABLE `pet_diy_projects`
  ADD CONSTRAINT `pet_diy_projects_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `pet_users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `pet_health_tips`
--
ALTER TABLE `pet_health_tips`
  ADD CONSTRAINT `pet_health_tips_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `pet_users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `pet_media`
--
ALTER TABLE `pet_media`
  ADD CONSTRAINT `pet_media_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `pet_diy_projects` (`diy_id`) ON DELETE CASCADE;

--
-- Constraints for table `pet_training_tips`
--
ALTER TABLE `pet_training_tips`
  ADD CONSTRAINT `pet_training_tips_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `pet_users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
