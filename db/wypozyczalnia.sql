-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 15 Sie 2022, 09:37
-- Wersja serwera: 10.4.24-MariaDB
-- Wersja PHP: 7.4.29

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
-- Struktura tabeli dla tabeli `mailboxes`
--

CREATE TABLE `mailboxes` (
  `id` int(11) NOT NULL,
  `message_id` int(11) NOT NULL,
  `user` text NOT NULL,
  `direction` enum('in','out') NOT NULL,
  `unread` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `mailboxes`
--

INSERT INTO `mailboxes` (`id`, `message_id`, `user`, `direction`, `unread`) VALUES
(1, 1, 'admin', 'in', 0),
(2, 2, 'admin', 'in', 0),
(3, 3, 'admin', 'in', 0),
(4, 4, 'admin', 'in', 0),
(9, 5, 'admin', 'in', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `imie` text NOT NULL,
  `nazwisko` text NOT NULL,
  `email` text NOT NULL,
  `tel` int(11) DEFAULT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Zrzut danych tabeli `messages`
--

INSERT INTO `messages` (`id`, `message`, `imie`, `nazwisko`, `email`, `tel`, `date`) VALUES
(1, 'asdasdasdasdasdasdasd', 'test', 'test', 'testttt123@asdasd.pl', 0, '2021-12-13 00:17:12'),
(2, 'asdasdasdasfvcxvcxv', 'ts=est2', 'aushdbuasd', 'asdasdas@asdasd.dfasdsa', 0, '2021-12-13 00:19:53'),
(3, 'asldaskdasd', 'test3', 'aytsvdysa', 'yavsdygvasyd@asd.pl', 1241324, '2021-12-13 00:24:14'),
(4, '3214v324b', 'test4', 'asdasd', 'asdasd@a.gfh', 0, '2021-12-13 00:27:38'),
(5, 'Użytkownik o loginie lub adresie e-mail: <span style=\"font-weight: bold;\">andrzej</span> prosi o zresetowanie hasła.', ' ', ' ', 'noreply@wyposamochodow.localhost', 0, '2022-08-15 09:22:46');

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
-- Zastąpiona struktura widoku `profiles`
-- (Zobacz poniżej rzeczywisty widok)
--
CREATE TABLE `profiles` (
`id` int(11)
,`login` text
,`rented_vehicles` int(11)
,`name` text
,`unread` bigint(21)
);

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
(1, 'admin', 'admin123@mail.pl', '$2y$10$BMXpq02kOPqN0igKe/siAetNZEov36VpSAqdU4ETDx4KHvqFQ2x/6', 1, 7, 0, NULL, 'Brak danych', 0),
(2, 'user', 'user123@mail.pl', '$2y$10$SZGlDAHLa0HJvEnsW/K5oetE2zgSO73rp5/m1IlneMH168s.BAB9.', 0, 1, 0, NULL, NULL, NULL),
(3, 'andrzej', '', '$2y$10$LG0fZURS20/BC9L6ZHUfIOyGbTbfKNOEYimk9btLjXXDF0NhCkVI.', 0, 0, 0, 'Włodzimierz', 'Kowalski', NULL);

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
(5, 'Lamborghini', 'Urus', '100.00', 'https://bi.im-g.pl/im/90/ae/15/z22736272AMP,Lamborghini-Urus-2017.jpg', 1),
(6, 'Volkswagen', 'Passat B8', '83.00', 'https://www.autocentrum.pl/ac-file/car-version/5d13d13d57502a5ea36e8f85/volkswagen-passat-b8.jpg', 1),
(7, 'Mazda', 'RX-7', '80.00', 'https://upload.wikimedia.org/wikipedia/commons/a/a6/Mazda-rx7-3rd-generation01.jpg', 1),
(8, 'Ford', 'Focus', '71.99', 'https://ocs-pl.oktawave.com/v1/AUTH_2887234e-384a-4873-8bc5-405211db13a2/autoblog/2021/08/ford-focus-sedan-test-202116.jpg', 1),
(9, 'Lamborghini', 'Huracan', '120.00', 'img/lambo.jpg', 1);

-- --------------------------------------------------------

--
-- Struktura widoku `admins`
--
DROP TABLE IF EXISTS `admins`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `admins`  AS SELECT `users`.`id` AS `id`, `users`.`login` AS `login`, `users`.`email` AS `email` FROM `users` WHERE `users`.`is_admin` = 11  ;

-- --------------------------------------------------------

--
-- Struktura widoku `profiles`
--
DROP TABLE IF EXISTS `profiles`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `profiles`  AS SELECT `users`.`id` AS `id`, `users`.`login` AS `login`, `users`.`rented_vehicles` AS `rented_vehicles`, `users`.`imie` AS `name`, (select count(0) from `mailboxes` where `mailboxes`.`unread` = 0 and `mailboxes`.`user` = `users`.`login`) AS `unread` FROM `users``users`  ;

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `mailboxes`
--
ALTER TABLE `mailboxes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `message_id` (`message_id`);

--
-- Indeksy dla tabeli `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

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
-- AUTO_INCREMENT dla tabeli `mailboxes`
--
ALTER TABLE `mailboxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

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
-- Ograniczenia dla tabeli `mailboxes`
--
ALTER TABLE `mailboxes`
  ADD CONSTRAINT `mailboxes_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`id`);

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
