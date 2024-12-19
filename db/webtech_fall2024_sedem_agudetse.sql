-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Dec 19, 2024 at 04:05 AM
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
-- Table structure for table `activity_logs`
--

CREATE TABLE `activity_logs` (
  `log_id` int NOT NULL,
  `action` varchar(255) NOT NULL,
  `details` text,
  `log_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `comment_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `content_type` enum('training_tip','diy_idea','health_tip') NOT NULL,
  `content_id` int NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `diy_ideas`
--

CREATE TABLE `diy_ideas` (
  `idea_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `diy_ideas`
--

INSERT INTO `diy_ideas` (`idea_id`, `user_id`, `title`, `description`, `image_url`, `created_at`) VALUES
(1, 1, 'Distinctio Consequu', 'Aliquid facilis repu', 'image.jpg', '2024-12-19 02:51:19'),
(2, 1, 'Buy 1 get 1 free', 'Click bait! Puppy for sale fr though', 'images.jpg', '2024-12-19 03:49:26');

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `favorite_id` int NOT NULL,
  `user_id` int DEFAULT NULL,
  `content_type` enum('training_tip','diy_idea','health_tip') NOT NULL,
  `content_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `health_tips`
--

CREATE TABLE `health_tips` (
  `tip_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `health_tips`
--

INSERT INTO `health_tips` (`tip_id`, `title`, `description`, `category`, `image_path`, `created_by`, `created_at`) VALUES
(1, 'Dog Food For puppies', 'Magna voluptatem ma', 'Nutrition', 'uploads/health/676336299336b.jpg', 2, '2024-12-18 20:16:01');

-- --------------------------------------------------------

--
-- Table structure for table `training_comments`
--

CREATE TABLE `training_comments` (
  `comment_id` int NOT NULL,
  `tip_id` int NOT NULL,
  `user_id` int NOT NULL,
  `comment` text NOT NULL,
  `rating` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ;

--
-- Dumping data for table `training_comments`
--

INSERT INTO `training_comments` (`comment_id`, `tip_id`, `user_id`, `comment`, `rating`, `created_at`) VALUES
(1, 2, 1, 'Where the dog at?', 3, '2024-12-19 02:05:14'),
(2, 1, 1, 'Not a real dog. I bought it tho.', 5, '2024-12-19 02:05:47'),
(3, 3, 1, 'Hot food', 4, '2024-12-19 02:24:32');

-- --------------------------------------------------------

--
-- Table structure for table `training_tips`
--

CREATE TABLE `training_tips` (
  `tip_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `difficulty` varchar(50) NOT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_by` int DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `training_tips`
--

INSERT INTO `training_tips` (`tip_id`, `title`, `description`, `difficulty`, `image_path`, `status`, `created_by`, `created_at`) VALUES
(1, 'Train Dogs', 'Let it go!', 'Intermediate', 'uploads/training/676361168f7b3.webp', 'active', 1, '2024-12-18 23:56:06'),
(2, 'Just do It', 'Talk to the dog', 'Beginner', 'uploads/training/67637b0523190.webp', 'active', 1, '2024-12-19 01:46:45'),
(3, 'More food Monday', 'Feed the dog more. It helps.', 'Advanced', 'uploads/training/67637ff1420dd.jpg', 'active', 1, '2024-12-19 02:07:45');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `role` int NOT NULL DEFAULT '2'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password_hash`, `profile_image`, `created_at`, `role`) VALUES
(1, 'qabukahu', 'wimi@mailinator.com', '$2y$10$u9DRRltB00RBiLRZBnGQaO9f4dFt8lC9qmyaEPT6DRcAzFRFG/PiK', NULL, '2024-12-17 23:21:11', 2),
(2, 'admin', 'xefydoqy@mailinator.com', '$2y$10$iQCbGhkLeuGyd.wNOmVl5uqrDdPRX3oMFnkRTFl0/OX7/qrb2jzTW', NULL, '2024-12-18 18:10:25', 1),
(3, 'john_doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2024-12-18 13:23:22', 1),
(4, 'jane_smith', 'jane@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2024-12-18 14:23:22', 1),
(5, 'mike_wilson', 'mike@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2024-12-18 15:23:22', 1),
(6, 'sarah_jones', 'sarah@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2024-12-18 16:23:22', 1),
(9, 'robert_miller', 'robert@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2024-12-18 18:23:22', 1),
(11, 'james_wilson', 'james@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2024-12-18 18:23:22', 2),
(12, 'amy_johnson', 'amy@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NULL, '2024-12-18 18:23:22', 2),
(14, 'tityfol', 'juwelyvi@mailinator.com', '$2y$10$py80gyEKKy9MCRgouEMUQenbG8ZmcZRphY9RS.Eh.uAsE26zBhHW.', NULL, '2024-12-18 21:57:10', 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`log_id`);

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `diy_ideas`
--
ALTER TABLE `diy_ideas`
  ADD PRIMARY KEY (`idea_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`favorite_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `health_tips`
--
ALTER TABLE `health_tips`
  ADD PRIMARY KEY (`tip_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `training_comments`
--
ALTER TABLE `training_comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `tip_id` (`tip_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `training_tips`
--
ALTER TABLE `training_tips`
  ADD PRIMARY KEY (`tip_id`),
  ADD KEY `created_by` (`created_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `log_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `diy_ideas`
--
ALTER TABLE `diy_ideas`
  MODIFY `idea_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `favorite_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `health_tips`
--
ALTER TABLE `health_tips`
  MODIFY `tip_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `training_comments`
--
ALTER TABLE `training_comments`
  MODIFY `comment_id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `training_tips`
--
ALTER TABLE `training_tips`
  MODIFY `tip_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `diy_ideas`
--
ALTER TABLE `diy_ideas`
  ADD CONSTRAINT `diy_ideas_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `favorites`
--
ALTER TABLE `favorites`
  ADD CONSTRAINT `favorites_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `health_tips`
--
ALTER TABLE `health_tips`
  ADD CONSTRAINT `health_tips_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `training_comments`
--
ALTER TABLE `training_comments`
  ADD CONSTRAINT `training_comments_ibfk_1` FOREIGN KEY (`tip_id`) REFERENCES `training_tips` (`tip_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `training_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `training_tips`
--
ALTER TABLE `training_tips`
  ADD CONSTRAINT `training_tips_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
