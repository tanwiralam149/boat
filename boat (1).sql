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
(8,	1,	'weekdays',	'09:00:00',	'20:00:00'),
(7,	1,	'weekend',	'08:00:00',	'18:00:00'),
(3,	2,	'weekend',	'10:00:00',	'22:00:00'),
(4,	2,	'weekdays',	'11:00:00',	'23:00:00'),
(5,	3,	'weekend',	'06:00:00',	'15:00:00'),
(6,	3,	'weekdays',	'07:00:00',	'17:00:00'),
(14,	4,	'weekend',	'06:30:00',	'16:00:00'),
(13,	4,	'weekdays',	'10:30:00',	'18:00:00'),
(22,	5,	'weekdays',	'16:00:00',	'20:00:00'),
(21,	5,	'weekend',	'12:00:00',	'16:00:00');

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
(1,	1,	'Tanwir',	'9955117755',	'tanwir@gmail.com',	'2025-02-27',	8,	'09:00:00',	'11:00:00',	'pending',	'2025-02-27 12:13:06',	'2025-02-27 12:13:06'),
(2,	1,	'Alam',	'9955117755',	'alam@gmail.com',	'2025-02-27',	8,	'13:00:00',	'15:00:00',	'pending',	'2025-02-27 12:16:13',	'2025-02-27 12:16:13'),
(3,	2,	'Hussain',	'9955117755',	'hussain@gmail.com',	'2025-02-27',	4,	'14:00:00',	'16:00:00',	'pending',	'2025-02-27 12:17:39',	'2025-02-27 12:17:39'),
(4,	3,	'Zahid',	'9966332211',	'zahid@gmail.com',	'2025-02-28',	6,	'08:00:00',	'10:00:00',	'pending',	'2025-02-27 12:18:41',	'2025-02-27 12:18:41'),
(5,	3,	'Zakir',	'8855996633',	'zakir@gmail.com',	'2025-02-28',	6,	'12:00:00',	'14:00:00',	'pending',	'2025-02-27 12:19:31',	'2025-02-27 12:19:31');

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
(1,	'Speed Boat',	0,	NULL,	NULL),
(2,	'Luxury Yacht',	0,	NULL,	NULL),
(3,	'Fishing Vessel',	0,	NULL,	NULL),
(4,	'Del Mar',	0,	NULL,	NULL),
(5,	'Ciao Bella.',	0,	NULL,	NULL);

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

-- 2025-02-27 13:08:13
