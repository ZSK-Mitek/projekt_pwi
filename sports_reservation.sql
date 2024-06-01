-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Cze 01, 2024 at 01:59 AM
-- Wersja serwera: 10.4.32-MariaDB
-- Wersja PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sports_reservation`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `contact_messages`
--

CREATE TABLE `contact_messages` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contact_messages`
--

INSERT INTO `contact_messages` (`id`, `user_id`, `email`, `message`, `created_at`) VALUES
(1, 3, 'elastyczny@maciek.pl', 'Chciałbym dodać swój kort tenisowy na strone', '2024-05-31 23:59:17');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `facilities`
--

CREATE TABLE `facilities` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `hourly_rate` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `facilities`
--

INSERT INTO `facilities` (`id`, `name`, `description`, `image_path`, `hourly_rate`) VALUES
(21, 'Basen Posnania', 'Basen 25-metrowy, 6 torów (szerokość 2,25 m każdy), głębokość maksymalna 180 cm, minimalna 90 cm', '../uploads/basen1.jpg', 20.00),
(22, 'Bilard', 'Stoły bilardowe, szeroka oferta baru, transmisje sportowe – to wszystko czego szukasz.', '../uploads/unnamed.jpg', 60.00),
(23, 'Kręgielnia', 'Nasz klub bowlingowy to więcej niż tylko miejsce do gry – to przestrzeń, która staje się areną dla niezapomnianych spotkań, budowania relacji i tworzenia wspaniałych wspomnień.', '../uploads/fd24c19b-892e-4fd8-81e9-dc15a08c638f.jpg', 100.00),
(24, 'Ścianka wspinaczkowa', 'Nasza ścianka wspinaczkowa to świetna zabawa dla każdego!', '../uploads/scianka.jpg.pagespeed.ce_.ZcpEpPu930.jpg', 35.00),
(25, 'Squash park', 'Squash to sport dla każdego, kto ma pozytywne nastawienie oraz pragnienie spędzania czasu w miły i aktywny sposób.', '../uploads/squash-poznan.jpg', 65.00),
(26, 'Mini Golf', 'To jedyny tego typu obiekt w Poznaniu!', '../uploads/images.jpeg', 15.00);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reservations`
--

CREATE TABLE `reservations` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `sector_id` int(11) NOT NULL,
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservations`
--

INSERT INTO `reservations` (`id`, `user_id`, `sector_id`, `start_time`, `end_time`, `date`) VALUES
(22, 2, 43, '16:50:00', '17:50:00', '2024-07-17'),
(23, 2, 50, '10:00:00', '11:30:00', '2024-07-22'),
(24, 3, 48, '10:00:00', '11:00:00', '2024-07-01'),
(25, 3, 52, '12:00:00', '13:00:00', '2024-07-03');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `reviews`
--

CREATE TABLE `reviews` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `facility_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`id`, `user_id`, `facility_id`, `rating`, `comment`, `created_at`) VALUES
(25, 2, 21, 7, 'Ładne szatnie i ciepła woda.', '2024-05-31 23:51:49'),
(26, 2, 22, 10, 'Dobre piwo', '2024-05-31 23:54:05'),
(27, 2, 26, 6, 'prawie żółta trawa', '2024-05-31 23:54:31'),
(28, 3, 23, 4, 'dostalem zimne nachosy', '2024-05-31 23:56:25'),
(29, 3, 22, 8, 'Potwierdzam dobre piwo, ale pytali mnie czy z sokiem', '2024-05-31 23:56:53'),
(30, 3, 25, 8, 'calkiem fajnie', '2024-05-31 23:57:51');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sectors`
--

CREATE TABLE `sectors` (
  `id` int(11) NOT NULL,
  `facility_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sectors`
--

INSERT INTO `sectors` (`id`, `facility_id`, `name`) VALUES
(22, 21, 'Tor 1'),
(23, 21, 'Tor 2'),
(24, 21, 'Tor 3'),
(25, 21, 'Tor 4'),
(26, 21, 'Tor 5'),
(27, 21, 'Tor 6'),
(28, 22, 'Stół 1'),
(29, 22, 'Stół 2'),
(30, 22, 'Stół 3'),
(34, 22, 'Stół 4'),
(35, 22, 'Stół 5'),
(36, 23, 'Tor 1'),
(42, 23, 'Tor 2'),
(43, 23, 'Tor 3'),
(44, 23, 'Tor 4'),
(45, 23, 'Tor 5'),
(46, 23, 'Tor 6'),
(47, 24, 'Ścianka 1'),
(48, 24, 'Ścianka 2'),
(49, 24, 'Ścianka 3'),
(50, 25, 'Kort 1'),
(52, 25, 'Kort 2'),
(53, 25, 'Kort 3'),
(54, 26, 'Tor łatwy'),
(55, 26, 'Tor średni'),
(57, 26, 'Tor trudny');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `dark_mode` tinyint(1) DEFAULT 0,
  `user_role` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password`, `dark_mode`, `user_role`) VALUES
(1, 'admin', 'admin@admin.pl', '$2y$10$aPVRohHuF7ja4PeMsZWxreZWsN8JCy4am9pWsOIYMH48adGM71Wom', 1, 'admin'),
(2, 'Twardy', 'gibki123@wojtus.pl', '$2y$10$dZ7sqhBNCVqgTz7yqJ.AReatDEQ1VjAZJR/0XJ.ZMOV8aQCEeQfYm', 0, NULL),
(3, 'Miekki', 'elastyczny@maciek.pl', '$2y$10$Kf6nMeKSlgvboA.b8DDL/eEuCLtSWnOt5OxsNjPBddwRh47wTshd.', 0, NULL);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `contact_messages`
--
ALTER TABLE `contact_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `facilities`
--
ALTER TABLE `facilities`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `reservations`
--
ALTER TABLE `reservations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `sector_id` (`sector_id`);

--
-- Indeksy dla tabeli `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `facility_id` (`facility_id`);

--
-- Indeksy dla tabeli `sectors`
--
ALTER TABLE `sectors`
  ADD PRIMARY KEY (`id`),
  ADD KEY `facility_id` (`facility_id`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `contact_messages`
--
ALTER TABLE `contact_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `facilities`
--
ALTER TABLE `facilities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `reservations`
--
ALTER TABLE `reservations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `sectors`
--
ALTER TABLE `sectors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `reservations`
--
ALTER TABLE `reservations`
  ADD CONSTRAINT `reservations_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reservations_ibfk_2` FOREIGN KEY (`sector_id`) REFERENCES `sectors` (`id`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`);

--
-- Constraints for table `sectors`
--
ALTER TABLE `sectors`
  ADD CONSTRAINT `sectors_ibfk_1` FOREIGN KEY (`facility_id`) REFERENCES `facilities` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
