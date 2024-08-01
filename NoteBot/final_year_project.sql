-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2024 at 08:25 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `final_year_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL DEFAULT 0,
  `name` varchar(200) NOT NULL,
  `image` varchar(200) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `user_id`, `name`, `image`, `created_at`, `updated_at`) VALUES
(13, 11, 'Car Collection', 'uploads/books/1713166840-IMG_7904.jpg', '2024-04-15 02:40:40', '2024-04-15 02:40:40'),
(14, 14, 'Book 1', '', '2024-04-18 13:20:25', '2024-04-18 13:20:25'),
(15, 14, 'Book 2', 'uploads/books/1713464439-IMG_8004.jpg', '2024-04-18 13:20:39', '2024-04-18 13:20:39');

-- --------------------------------------------------------

--
-- Table structure for table `content`
--

CREATE TABLE `content` (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL DEFAULT 0,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `content`
--

INSERT INTO `content` (`id`, `book_id`, `content`, `created_at`, `updated_at`) VALUES
(8, 13, '<p>&nbsp;</p>\n<p>hallo hallo hallo</p>\n<p>&nbsp;</p>', '2024-04-15 02:40:41', '2024-04-15 02:44:18'),
(9, 14, '<p>ہیلو بک 1</p>\n<p>ہیلو بک ون وائس ٹیسٹنگ</p>\n<p>&nbsp;</p>\n<p><small style=\"background: #302d42; padding: 7px; color: white; width: max-content; border-radius: 5px;\">جاوا اسکرپٹ کوڈ</small></p>\n<pre>console.log(\'NotBot یہاں ہے\')</pre>\n<p>&nbsp;</p>\n<pre><!--?php\ndie();</pre--></pre>\n<p><small style=\"background: #302d42; padding: 7px; color: white; width: max-content; border-radius: 5px;\">پی ایچ پی کوڈ</small></p>\n<pre>مرنا ()؛</pre>\n<p>&nbsp;</p>\n<p><br><audio controls=\"controls\">\n                        <source src=\"uploads/audio/1713464564-blob.ogg\" type=\"audio/ogg\">آپ کا براؤزر آڈیو عنصر کو سپورٹ نہیں کرتا ہے۔</audio></p>', '2024-04-18 13:20:25', '2024-04-18 13:22:58'),
(10, 15, '<p>hi book 2</p>', '2024-04-18 13:20:40', '2024-04-18 13:23:26'),
(11, 16, '', '2024-04-18 13:20:55', '2024-04-18 13:20:55');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phonenumber` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `fullname`, `email`, `phonenumber`, `password`, `created_at`, `updated_at`) VALUES
(6, 'Hammad Shams', 'hammad@gmail.com', '923453998012', '$2y$10$k3o9dUd5fVc3qicnAHxZZ.r0a5ZUj6HM8L2loomG.dC.VBkS5e6rq', '2024-04-13 05:54:39', '2024-04-13 05:54:39'),
(7, 'Erich Garcia', 'lefog@mailinator.com', '283', '$2y$10$vyZUiiPrBPLI6C8qvjctme7rL3SBIhu8LXUrjrvCkLwQRJQ7Di.zy', '2024-04-13 05:57:57', '2024-04-13 05:57:57'),
(8, 'Felicia Fletcher', 'mygosado@mailinator.com', '847', '$2y$10$VYEI3uwZNghsDy7qVKh1vezI9hOLsMmZA9NrtNOfOdsqIujFc44pe', '2024-04-13 06:08:24', '2024-04-13 06:08:24'),
(9, 'Naveed Khan', 'naveed@gmail.com', '923453998013', '$2y$10$Sf9UT77x2SNghikmt8B9XelQahlVWHCQQ9t5SzzDjzVaIZVsd/M7a', '2024-04-13 14:23:35', '2024-04-13 14:23:35'),
(10, 'Basia Vega', 'kodoxages@mailinator.com', '396', '$2y$10$sctjjdu8qaZgr1RTbLs8peAD.LtnVnHpWC88Bh.0VG7MS/yFo9/OO', '2024-04-15 01:44:00', '2024-04-15 01:44:00'),
(11, 'Jerry Harvey', 'zozyx@mailinator.com', '79', '$2y$10$WoTvlG0yS4hjzrVjPUtmq.oOX7tvH7w3oyVsb1xI2UfCXTH183upG', '2024-04-15 02:35:24', '2024-04-15 02:35:24'),
(12, 'Germaine Casey', 'bilekid@mailinator.com', '922', '$2y$10$ArghzkF9eJTaWzrs1XfRxemakYB5N28ZCPiyjNCo3fQsV/lcswBKC', '2024-04-18 13:16:03', '2024-04-18 13:16:03'),
(13, 'Tucker Barr', 'suwosuvub@mailinator.com', '611', '$2y$10$T8zXuk0mVa5IhhG.AErZPenT.Av9OPFgiKiCoUbO09/hPMmI9mIBa', '2024-04-18 13:16:59', '2024-04-18 13:16:59'),
(14, 'Hammad Khan', 'hammadkhan@yahoo.com', '1234567890', '$2y$10$5ENUPPBq7B/VSoSKQuqZme/nbZu0aV5Tlqndy6FjdNV5QnPl63n5i', '2024-04-18 13:19:31', '2024-04-18 13:19:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `content`
--
ALTER TABLE `content`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `content`
--
ALTER TABLE `content`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
