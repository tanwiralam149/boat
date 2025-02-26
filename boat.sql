-- Adminer 4.8.0 MySQL 8.0.26 dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `boat_availability`;
CREATE TABLE `boat_availability` (
  `id` int NOT NULL AUTO_INCREMENT,
  `boat_id` int NOT NULL,
  `availability_type` enum('weekend','weekdays') NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  PRIMARY KEY (`id`),
  KEY `boat_id` (`boat_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `boat_availability` (`id`, `boat_id`, `availability_type`, `start_time`, `end_time`) VALUES
(1,	1,	'weekdays',	'09:00:00',	'12:00:00'),
(2,	1,	'weekdays',	'14:00:00',	'18:00:00'),
(3,	2,	'weekdays',	'10:00:00',	'13:00:00');

DROP TABLE IF EXISTS `boat_bookings`;
CREATE TABLE `boat_bookings` (
  `id` int NOT NULL AUTO_INCREMENT,
  `boat_id` int NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_phone` varchar(15) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `booking_date` date NOT NULL,
  `availability_id` int NOT NULL,
  `booking_start_time` time NOT NULL,
  `booking_end_time` time NOT NULL,
  `booking_status` enum('pending','confirmed','cancelled') CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `boat_id` (`boat_id`),
  KEY `availability_id` (`availability_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `boat_bookings` (`id`, `boat_id`, `customer_name`, `customer_phone`, `customer_email`, `booking_date`, `availability_id`, `booking_start_time`, `booking_end_time`, `booking_status`, `created_at`, `updated_at`) VALUES
(13,	1,	'John Doe',	'1234567890',	'john@example.com',	'2024-03-01',	1,	'09:00:00',	'12:00:00',	'confirmed',	'2025-02-26 10:03:07',	'2025-02-26 10:03:07'),
(14,	2,	'Jane Smith',	'9876543210',	'jane@example.com',	'2024-03-05',	3,	'10:00:00',	'13:00:00',	'pending',	'2025-02-26 10:03:07',	'2025-02-26 10:03:07');

DROP TABLE IF EXISTS `boats`;
CREATE TABLE `boats` (
  `id` int NOT NULL AUTO_INCREMENT,
  `boat_name` varchar(255) NOT NULL,
  `status` int NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `boats` (`id`, `boat_name`, `status`, `created_at`, `updated_at`) VALUES
(1,	'Speedboat',	0,	NULL,	NULL),
(2,	'Yacht',	0,	NULL,	NULL);

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

INSERT INTO `users` (`id`, `name`, `username`, `password`, `status`) VALUES
(1,	'Admin',	'admin',	'admin',	0);

-- 2025-02-26 10:14:49
