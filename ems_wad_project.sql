-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 09, 2024 at 06:12 PM
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
-- Database: `ems_wad_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `event`
--

CREATE TABLE `event` (
  `event_id` int(11) NOT NULL,
  `event_title` varchar(500) NOT NULL,
  `event_description` mediumtext NOT NULL,
  `start_date` datetime NOT NULL DEFAULT current_timestamp(),
  `end_date` datetime NOT NULL DEFAULT current_timestamp(),
  `start_time` time NOT NULL DEFAULT '00:00:00',
  `end_time` time NOT NULL DEFAULT '00:00:00',
  `venue` varchar(1000) NOT NULL,
  `max_count` int(11) NOT NULL,
  `response_count` int(11) NOT NULL,
  `organizer_id` int(11) NOT NULL,
  `ticket_price` double NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'active',
  `img_url` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `event`
--

INSERT INTO `event` (`event_id`, `event_title`, `event_description`, `start_date`, `end_date`, `start_time`, `end_time`, `venue`, `max_count`, `response_count`, `organizer_id`, `ticket_price`, `status`, `img_url`) VALUES
(1, 'Tech Conference 2024', 'A conference on the latest in tech.', '2024-08-01 09:00:00', '2024-08-01 17:00:00', '09:00:00', '17:00:00', 'Convention Center', 300, 120, 5, 150, 'active', '4jkd9s82ksldf9a.jpg'),
(2, 'Art Exhibition', 'An exhibition showcasing modern art.', '2024-09-10 10:00:00', '2024-09-10 18:00:00', '10:00:00', '18:00:00', 'City Gallery', 150, 75, 6, 50, 'active', 'j82kf7a9d0slkfj.jpg'),
(3, 'Music Festival', 'A festival featuring live music from various genres.', '2024-07-20 14:00:00', '2024-07-20 22:00:00', '14:00:00', '22:00:00', 'Central Park', 500, 450, 125, 100, 'active', 'lskfj9e8w7s9kdf.jpg'),
(4, 'Science Fair', 'An event to explore scientific projects by students.', '2024-10-05 08:00:00', '2024-10-05 16:00:00', '08:00:00', '16:00:00', 'University Hall', 200, 160, 125, 0, 'active', '9fksl7d0as2j3fd.jpg'),
(5, 'Book Signing', 'A book signing event with a famous author.', '2024-07-15 11:00:00', '2024-07-15 13:00:00', '11:00:00', '13:00:00', 'Library', 100, 90, 6, 10, 'active', 'askd78s29dls9jf.jpg'),
(6, 'Charity Run', 'A 5K run to raise money for charity.', '2024-11-25 07:00:00', '2024-11-25 11:00:00', '07:00:00', '11:00:00', 'City Park', 1000, 800, 6, 25, 'active', '78sj9k2lskf0d2j.jpg'),
(7, 'Culinary Workshop', 'A workshop to learn gourmet cooking techniques.', '2024-08-12 13:00:00', '2024-08-12 17:00:00', '13:00:00', '17:00:00', 'Community Center', 50, 45, 7, 75, 'active', '0sdkjf89sl2a9fj.jpg'),
(8, 'Fitness Bootcamp', 'An intensive fitness bootcamp.', '2024-07-22 06:00:00', '2024-07-22 08:00:00', '06:00:00', '08:00:00', 'Gymnasium', 75, 70, 8, 30, 'active', 'klsd98fj72w9lsk.jpg'),
(9, 'Photography Contest', 'A contest for amateur photographers.', '2024-09-18 09:00:00', '2024-09-18 17:00:00', '09:00:00', '17:00:00', 'Art Studio', 100, 60, 9, 20, 'active', '9aslk2fjs7d8jf0.jpg'),
(10, 'Yoga Retreat', 'A weekend retreat focusing on yoga and meditation.', '2024-08-24 08:00:00', '2024-08-25 18:00:00', '08:00:00', '18:00:00', 'Mountain Resort', 30, 28, 10, 200, 'active', 's7d9kf8sl0ajf2d.jpg'),
(11, 'Entrepreneur Summit', 'A summit for aspiring entrepreneurs.', '2024-10-15 09:00:00', '2024-10-15 17:00:00', '09:00:00', '17:00:00', 'Business Center', 250, 230, 11, 120, 'active', 'fj9s0kd72l8sja9.jpg'),
(12, 'Film Festival', 'A festival featuring independent films.', '2024-09-01 14:00:00', '2024-09-01 22:00:00', '14:00:00', '22:00:00', 'Movie Theater', 200, 180, 12, 50, 'active', 'lks8d9fj02w7asj.jpg'),
(13, 'History Lecture', 'A lecture on ancient civilizations.', '2024-08-05 10:00:00', '2024-08-05 12:00:00', '10:00:00', '12:00:00', 'Museum', 100, 95, 5, 15, 'active', '7slk0f9jd8a2skf.jpg'),
(14, 'Dance Competition', 'A competition for amateur dancers.', '2024-07-28 16:00:00', '2024-07-28 20:00:00', '16:00:00', '20:00:00', 'Dance Studio', 100, 80, 14, 40, 'active', '82js9lk0f7dj3sl.jpg'),
(15, 'Gardening Workshop', 'A workshop on urban gardening.', '2024-10-10 09:00:00', '2024-10-10 12:00:00', '09:00:00', '12:00:00', 'Botanical Garden', 50, 45, 15, 20, 'active', '2djf7k9asl0s8fj.jpg'),
(16, 'Coding Bootcamp', 'An intensive coding bootcamp for beginners.', '2024-11-01 09:00:00', '2024-11-01 17:00:00', '09:00:00', '17:00:00', 'Tech Hub', 100, 95, 16, 100, 'active', 'js9k0f72d8lskaf.jpg'),
(17, 'Wine Tasting', 'A wine tasting event.', '2024-09-25 18:00:00', '2024-09-25 21:00:00', '18:00:00', '21:00:00', 'Winery', 75, 70, 17, 60, 'active', 's8d9jf7k0l2asj9.jpg'),
(18, 'Karaoke Night', 'A fun night of karaoke.', '2024-07-30 20:00:00', '2024-07-30 23:00:00', '20:00:00', '23:00:00', 'Bar', 50, 45, 18, 10, 'active', '9slk2fjd7a0s8jf.jpg'),
(19, 'Meditation Workshop', 'A workshop on mindfulness and meditation.', '2024-08-08 09:00:00', '2024-08-08 11:00:00', '09:00:00', '11:00:00', 'Wellness Center', 60, 55, 19, 25, 'active', '8fj9s0k2ld7a3sf.jpg'),
(20, 'Networking Event', 'An event for professionals to network.', '2024-10-20 18:00:00', '2024-10-20 21:00:00', '18:00:00', '21:00:00', 'Conference Hall', 150, 140, 20, 35, 'active', 'k72ls8djf9a0sf3.jpg'),
(21, 'Poetry Reading', 'A reading event featuring local poets.', '2024-11-05 17:00:00', '2024-11-05 19:00:00', '17:00:00', '19:00:00', 'Bookstore', 40, 35, 21, 15, 'active', 'j0as8d9fk72sl3f.jpg'),
(23, 'Fashion Show', 'A show featuring the latest fashion trends.', '2024-09-05 19:00:00', '2024-09-05 22:00:00', '19:00:00', '22:00:00', 'Hotel Ballroom', 100, 90, 23, 50, 'active', 'l9s0k7dfj8a2sf3.jpg'),
(24, 'Photography Workshop', 'A workshop on advanced photography techniques.', '2024-08-22 10:00:00', '2024-08-22 14:00:00', '10:00:00', '14:00:00', 'Photo Studio', 30, 25, 5, 75, 'active', '2j0s8k9dlf7a3sf.jpg'),
(25, 'Theater Performance', 'A performance of a classic play.', '2024-07-17 19:00:00', '2024-07-17 21:00:00', '19:00:00', '21:00:00', 'Theater', 150, 145, 25, 25, 'active', 's7djf9k0l2a8sf3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `eventshow`
--

CREATE TABLE `eventshow` (
  `id` int(11) NOT NULL,
  `price` double DEFAULT NULL,
  `category` varchar(255) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eventshow`
--

INSERT INTO `eventshow` (`id`, `price`, `category`, `title`, `description`) VALUES
(1, 2500, 'Party', 'Galena', 'Lorem asdg asdkjh sdfkdshfkhd sd.');

-- --------------------------------------------------------

--
-- Table structure for table `register`
--

CREATE TABLE `register` (
  `userId` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `password1` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `register`
--

INSERT INTO `register` (`userId`, `username`, `email`, `phone`, `password1`) VALUES
(4, 'kasun', 'rkcp854@gmail.com', '', '$2y$10$oykdUkcGVUNUTbRHP0YmZuJGFGr8jk8CnHer4Zy9NIhzywYA31Vze'),
(5, 'kasun', 'kasun@gmail.com', '0765907934', '$2y$10$2PU8TaxJZQF7EbhJwEDfV.dW6djLlMBdsczwdB6ki0V575mIZZD2W'),
(6, 'gopal', 'gopal@gmail.com', '', '$2y$10$kxsqDahAEwIMlDz6QwzE4OlW9T3QjA3cV1.NaDCBCPHQruz9Bye.a'),
(7, 'kasun', 'k@gmail.com', '0756321451', '$2y$10$8Fss/PBtVMjqMFd4zEpx4eSQBQLMhzokkJ/6Qhx/.XEYK3zTMdsRO'),
(8, 'chamika', 'chamika@gmail.com', '0765907934', '$2y$10$LYSLLRjk4tj3PAdhMMdSFeZW7YRuy2Z0TjR6cueGbvIKcU35DynYm'),
(9, 'joyson', 'joy@gmail.com', '0548974569', '$2y$10$wkWtTTGc5mwhqf/RD9ukn.BRVyAsF7jnVFrsxRsAl7w30zCDNSLh2'),
(10, 'joy', 'joyy@gmail.com', '045879652', '$2y$10$Terg7pCbTKMWnG8TRRgcCOEjliiOP/VOnL7tPeaRNAbLIi8KozE2.');

-- --------------------------------------------------------

--
-- Table structure for table `user_purchase_event`
--

CREATE TABLE `user_purchase_event` (
  `purchase_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_purchase_event`
--

INSERT INTO `user_purchase_event` (`purchase_id`, `user_id`, `event_id`) VALUES
(1, 5, 3),
(2, 10, 3),
(3, 5, 1),
(4, 5, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_save_events`
--

CREATE TABLE `user_save_events` (
  `user_id` int(11) NOT NULL,
  `event_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_save_events`
--

INSERT INTO `user_save_events` (`user_id`, `event_id`) VALUES
(5, 1),
(5, 2),
(9, 2),
(10, 3);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `event`
--
ALTER TABLE `event`
  ADD PRIMARY KEY (`event_id`);

--
-- Indexes for table `eventshow`
--
ALTER TABLE `eventshow`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `register`
--
ALTER TABLE `register`
  ADD PRIMARY KEY (`userId`);

--
-- Indexes for table `user_purchase_event`
--
ALTER TABLE `user_purchase_event`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `user_save_events`
--
ALTER TABLE `user_save_events`
  ADD PRIMARY KEY (`user_id`,`event_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `event`
--
ALTER TABLE `event`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `eventshow`
--
ALTER TABLE `eventshow`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `register`
--
ALTER TABLE `register`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `user_purchase_event`
--
ALTER TABLE `user_purchase_event`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
