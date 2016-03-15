-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Czas wygenerowania: 15 Mar 2016, 09:58
-- Wersja serwera: 5.5.47-0ubuntu0.14.04.1
-- Wersja PHP: 5.5.9-1ubuntu4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Baza danych: `blog`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Admins`
--

CREATE TABLE IF NOT EXISTS `Admins` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(80) NOT NULL,
  `password` varchar(80) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=2 ;

--
-- Zrzut danych tabeli `Admins`
--

INSERT INTO `Admins` (`id`, `email`, `password`) VALUES
(1, 'admin@admin.pl', '$2y$11$0Yzn35IZjEgJP.GlcpvDk.jVVnbG/F/PK1bp/IeoPMhSvGBUxRvT2');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Comments`
--

CREATE TABLE IF NOT EXISTS `Comments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `comment_text` varchar(80) NOT NULL,
  `comment_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=9 ;

--
-- Zrzut danych tabeli `Comments`
--

INSERT INTO `Comments` (`id`, `post_id`, `user_id`, `comment_text`, `comment_date`) VALUES
(2, 1, 1, 'test2', '2016-03-14 20:28:42'),
(3, 1, 1, 'hbgvhbj', '2016-03-14 20:30:41'),
(4, 1, 2, 'gvf', '2016-03-14 21:58:42'),
(5, 1, 2, 'admintest', '2016-03-14 21:58:47'),
(7, 2, 1, 'bum  bum', '2016-03-15 09:04:30');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Posts`
--

CREATE TABLE IF NOT EXISTS `Posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `title` varchar(160) NOT NULL,
  `post_text` text NOT NULL,
  `post_date` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=15 ;

--
-- Zrzut danych tabeli `Posts`
--

INSERT INTO `Posts` (`id`, `user_id`, `title`, `post_text`, `post_date`) VALUES
(1, 1, 'horse', 'jnhbgvfcgvbhjn', '2016-03-11 12:58:33'),
(2, 1, 'test3', 'bum bum', '2016-03-11 19:17:35'),
(3, 1, 'test4', 'bgvfcdxfcgvhbjn', '2016-03-11 19:17:49'),
(4, 1, 'koohorse', 'gvfcdcgvbhjn', '2016-03-11 19:17:53'),
(6, 1, 'bumbumtest6', 'bbbbbb', '2016-03-11 19:18:34'),
(7, 1, 'testtest', 'b gvfcvhbj', '2016-03-11 19:19:10'),
(11, 1, '', '<h1>jbhbh</h1>);', '2016-03-14 19:12:59'),
(12, 2, '', 'hbgvfcgvhbjn', '2016-03-14 19:39:36');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `Users`
--

CREATE TABLE IF NOT EXISTS `Users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `email` varchar(90) NOT NULL,
  `password` char(60) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8mb4 AUTO_INCREMENT=4 ;

--
-- Zrzut danych tabeli `Users`
--

INSERT INTO `Users` (`id`, `name`, `email`, `password`, `description`) VALUES
(1, 'sara', 'sara@wp.pl', '$2y$11$Cw7bTl1ibMf.zxOFTQg7uuypTCZJXwOz5qtKWscuJW2thrAJ2KLnC', 'hjbhbjhbjhbjh'),
(2, 'ola', 'ola@wp.pl', '$2y$11$jPSQZ.TWYKRkQkU4iCgoZui6FeID/jgfiLqq04h7JntpFSPQ/Rmf2', 'j kjnkjnjnj');

--
-- Ograniczenia dla zrzutów tabel
--

--
-- Ograniczenia dla tabeli `Comments`
--
ALTER TABLE `Comments`
  ADD CONSTRAINT `Comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `Posts` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `Comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE;

--
-- Ograniczenia dla tabeli `Posts`
--
ALTER TABLE `Posts`
  ADD CONSTRAINT `Posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `Users` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
