-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 08 Gru 2021, 13:25
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 8.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `wypozyczalnia`
--

CREATE DATABASE wypozyczalnia;
USE wypozyczalnia;

-- --------------------------------------------------------

--
-- Zastąpiona struktura widoku `admins`
-- (Zobacz poniżej rzeczywisty widok)
--
CREATE TABLE `admins` (
`id` int(11)
,`login` text
,`email` text
);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `newsletter`
--

CREATE TABLE `newsletter` (
  `id` int(11) NOT NULL,
  `email` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `newsletter`
--

INSERT INTO `newsletter` (`id`, `email`) VALUES
(1, 'asdasd@asdas.pl');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `rezerwacja`
--

CREATE TABLE `rezerwacja` (
  `id` int(11) NOT NULL,
  `id_pojazdu` int(11) NOT NULL,
  `id_klienta` int(11) NOT NULL,
  `data_rezerwacji` date NOT NULL,
  `na_ile` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `rezerwacja`
--

INSERT INTO `rezerwacja` (`id`, `id_pojazdu`, `id_klienta`, `data_rezerwacji`, `na_ile`) VALUES
(1, 1, 2, '2021-11-28', 2),
(2, 6, 1, '2021-12-03', 2),
(4, 8, 1, '2021-12-01', 3),
(5, 6, 1, '2021-12-05', 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` text NOT NULL,
  `email` text NOT NULL,
  `password` varchar(255) NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `rented_vehicles` int(11) NOT NULL DEFAULT 0,
  `change_passwd` tinyint(1) NOT NULL DEFAULT 0,
  `imie` text DEFAULT NULL,
  `nazwisko` text DEFAULT NULL,
  `telefon` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `users`
--

INSERT INTO `users` (`id`, `login`, `email`, `password`, `is_admin`, `rented_vehicles`, `change_passwd`, `imie`, `nazwisko`, `telefon`) VALUES
(1, 'admin', 'admin123@mail.pl', '$2y$10$BMXpq02kOPqN0igKe/siAetNZEov36VpSAqdU4ETDx4KHvqFQ2x/6', 1, 7, 0, 'Brak danych', 'Brak danych', 0),
(2, 'user', 'user123@mail.pl', '$2y$10$5MQjW2EgT45/FUMl4VcH5uHpUJrrf20jczoCL4BD0RnwEhMqgK9DO', 0, 1, 1, NULL, NULL, NULL),
(3, 'andrzej', '', '$2y$10$vjoCMD1b0.As0tqD/8cx5.jqe2fGj6yOeOxd4BeZdWxsBRKNrsyzm', 0, 0, 0, 'test', 'asdasd', NULL);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `vehicles`
--

CREATE TABLE `vehicles` (
  `id` int(11) NOT NULL,
  `marka` text NOT NULL,
  `model` text NOT NULL,
  `cena` decimal(30,2) NOT NULL,
  `img_url` text DEFAULT NULL,
  `is_available` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `vehicles`
--

INSERT INTO `vehicles` (`id`, `marka`, `model`, `cena`, `img_url`, `is_available`) VALUES
(1, 'Toyota', 'Yaris', '65.00', 'https://ireland.apollo.olxcdn.com/v1/files/eyJmbiI6IjByc3gyc3BrZzQ4YjMtT1RPTU9UT1BMIiwidyI6W3siZm4iOiJ3ZzRnbnFwNnkxZi1PVE9NT1RPUEwiLCJzIjoiMTYiLCJwIjoiMTAsLTEwIiwiYSI6IjAifV19.hXuoemts_h7soE7DwcsvGnYuHhVCV0y0sCWXJ0ZzIVE/image;s=732x488', 1),
(2, 'Ford', 'Fusion', '55.00', 'https://i.wpimg.pl/600x0/m.autokult.pl/ford-fusion-4-3ddb5b2d153e08d106.jpg', 0),
(3, 'Volkswagen', 'Golf', '65.00', 'https://www.auto-gazda.pl/application/files/8816/2861/3097/1.jpg', 1),
(4, 'Mercedes', 'Sprinter', '80.00', 'https://image.ceneostatic.pl/data/products/95699167/i-mercedes-sprinter-313-2013-r.jpg', 1),
(5, 'Lamborghini', 'Urus', '100.00', 'https://thumbs.img-sprzedajemy.pl/1000x901c/c4/6d/d5/lamborghini-urus-lamborghini-urus-white-2020-8-slaskie-mikolow-sprzedam-541825189.jpg', 1),
(6, 'Volkswagen', 'Passat B8', '83.00', 'https://www.autocentrum.pl/ac-file/car-version/5d13d13d57502a5ea36e8f85/volkswagen-passat-b8.jpg', 1),
(7, 'Mazda', 'RX-7', '80.00', 'https://upload.wikimedia.org/wikipedia/commons/a/a6/Mazda-rx7-3rd-generation01.jpg', 1),
(8, 'Ford', 'Focus', '71.99', 'https://ocs-pl.oktawave.com/v1/AUTH_2887234e-384a-4873-8bc5-405211db13a2/autoblog/2021/08/ford-focus-sedan-test-202116.jpg', 1);

-- --------------------------------------------------------

--
-- Struktura widoku `admins`
--
DROP TABLE IF EXISTS `admins`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `admins`  AS SELECT `users`.`id` AS `id`, `users`.`login` AS `login`, `users`.`email` AS `email` FROM `users` WHERE `users`.`is_admin` = 1 ;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `newsletter`
--
ALTER TABLE `newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `rezerwacja`
--
ALTER TABLE `rezerwacja`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_pojazdu` (`id_pojazdu`),
  ADD KEY `id_klienta` (`id_klienta`);

--
-- Indeksy dla tabeli `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`) USING HASH,
  ADD UNIQUE KEY `login_2` (`login`,`email`) USING HASH,
  ADD UNIQUE KEY `email_2` (`email`) USING HASH,
  ADD UNIQUE KEY `email_3` (`email`) USING HASH;

--
-- Indeksy dla tabeli `vehicles`
--
ALTER TABLE `vehicles`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `newsletter`
--
ALTER TABLE `newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT dla tabeli `rezerwacja`
--
ALTER TABLE `rezerwacja`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `rezerwacja`
--
ALTER TABLE `rezerwacja`
  ADD CONSTRAINT `rezerwacja_ibfk_1` FOREIGN KEY (`id_pojazdu`) REFERENCES `vehicles` (`id`),
  ADD CONSTRAINT `rezerwacja_ibfk_2` FOREIGN KEY (`id_klienta`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
