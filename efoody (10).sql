-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 21, 2024 at 11:09 PM
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
-- Database: `efoody`
--
CREATE DATABASE IF NOT EXISTS `efoody` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `efoody`;

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cargo`
--

CREATE TABLE IF NOT EXISTS `cargo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `w_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `u_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cargo`
--

INSERT INTO `cargo` (`id`, `w_id`, `p_id`, `date`, `u_id`, `amount`) VALUES
(1, 1, 1, '2024-04-13 21:45:45', 1, 2),
(2, 1, 4, '2024-04-13 21:45:47', 1, 1),
(3, 1, 1, '2024-04-13 21:45:28', 1, 5),
(4, 1, 1, '2024-04-13 21:45:36', 1, 4),
(5, 1, 4, '2024-04-14 10:16:31', 1, 1),
(6, 2, 1, '2024-04-14 10:16:33', 1, 3),
(7, 2, 4, '2024-04-13 21:45:51', 1, 1),
(8, 2, 1, '2024-04-14 10:38:35', 1, 20),
(9, 2, 4, '2024-04-14 10:38:35', 1, 10),
(10, 4, 1, '2024-04-15 18:49:30', 1, 10),
(11, 4, 4, '2024-04-15 18:49:30', 1, 2),
(12, 4, 5, '2024-04-15 18:49:30', 1, 3),
(13, 2, 1, '2024-04-15 18:49:36', 1, 5),
(14, 2, 4, '2024-04-15 18:49:36', 1, 4),
(15, 2, 5, '2024-04-15 18:49:36', 1, 3),
(16, 2, 1, '2024-04-17 19:07:42', 1, 2),
(17, 2, 1, '2024-04-17 19:08:06', 1, 2),
(18, 1, 1, '2024-04-21 20:54:55', 1, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `c_name` varchar(16) NOT NULL,
  `c_fullname` varchar(64) NOT NULL,
  `c_description` text NOT NULL,
  `c_active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `c_name`, `c_fullname`, `c_description`, `c_active`) VALUES
(1, 'WR', 'Radom', 'Siła w precyzji', 1),
(2, 'WRA', 'Pionki', 'Pionki i kurczaki', 1),
(3, 'TOS', 'Ostrowiec Świętokrzyski', '', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `companies`
--

CREATE TABLE IF NOT EXISTS `companies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `phone_number` varchar(16) NOT NULL,
  `full_name` varchar(128) NOT NULL,
  `contact_first_name` varchar(32) NOT NULL,
  `contact_last_name` varchar(32) NOT NULL,
  `city_id` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `guardian` int(11) NOT NULL,
  `address` varchar(64) NOT NULL,
  `postal_code` varchar(6) NOT NULL,
  `city` varchar(32) NOT NULL,
  `street` varchar(64) NOT NULL,
  `street_number` varchar(10) NOT NULL,
  `nip` varchar(16) NOT NULL,
  `company_type` int(11) NOT NULL COMMENT '0 - sprzedajemy, 1 - kupujemy',
  `date` datetime NOT NULL,
  `description` text NOT NULL,
  `latitude` varchar(16) NOT NULL,
  `longitude` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `email`, `phone_number`, `full_name`, `contact_first_name`, `contact_last_name`, `city_id`, `active`, `guardian`, `address`, `postal_code`, `city`, `street`, `street_number`, `nip`, `company_type`, `date`, `description`, `latitude`, `longitude`) VALUES
(1, 'kontakt@nutridome.pl', '546789456', 'Nutridome Sp. z o.o.', 'Katarzyna', 'Staszowska', 1, 1, 0, 'Gazowa 8, Radom 26-600', '26-600', 'Radom', 'Gazowa', '8', '5272825059', 0, '0000-00-00 00:00:00', 'Pierwsze piętro', '51.3831506671975', '21.1458715975217'),
(2, 'kontakt@abriga.com', '456456456', 'Abriga Polska', 'Abriga Imie', 'Abriga Nazwisko', 1, 1, 2, 'Staromiejska 8/12, Radom 26-600', '26-600', 'Radom', 'Staromiejska', '8/12', '9482609074', 0, '2024-04-12 22:40:31', 'Wejście od bramy, pierwsze piętro 2', '51.4026410792049', '21.1389443620357'),
(3, 'kontakt@gardenpharm.pl', '753758753', 'GARDENPHARM', 'Garden', 'Pharm', 2, 1, 0, 'Staromiejska 8/12, Radom 26-600', '26-600', 'Radom', 'Staromiejska', '8/12', '5272633466', 0, '2024-04-12 22:58:34', 'test', '51.4026710496112', '21.1390052312358'),
(4, 'maciej.jezierski@gmail.com', '456456456', 'DRUKPOINT', 'Maciej', 'Jezierski', 1, 1, 0, 'Wernera 20, Radom 26-600', '26-600', 'Radom', 'Wernera', '20', '1132686331', 0, '2024-04-21 22:10:46', '', '51.4101547083976', '21.1382379203433');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `products`
--

CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_name` varchar(32) NOT NULL,
  `ean` varchar(32) NOT NULL,
  `sku` varchar(32) NOT NULL,
  `p_description` varchar(128) NOT NULL,
  `p_unit` varchar(16) NOT NULL,
  `p_photo` text NOT NULL,
  `prod_type` int(11) NOT NULL COMMENT '0 - półprodukt, 1 - produkt gotowy',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `p_name`, `ean`, `sku`, `p_description`, `p_unit`, `p_photo`, `prod_type`) VALUES
(1, 'Produkt 1', '111111111111111', '1-01-01-1', 'opis 1', 'Szt.', 'kanapka-1.png', 1),
(2, 'Produkt 2', '2222222222222222', '1-01-01-12', 'opis produktu 2', 'l', 'jagiellonka.png', 0),
(3, 'Produkt 3', '33333333333333333', '1-01-01-33', 'opis produktu 3', 'kg', 'bulka-wroclawska.jpg', 0),
(4, 'Gotowa kanapka', '2134432423423', '1-02-01-1', 'Gotowy produkt Kanapkowy', 'Szt.', 'kanapka-2.png', 1),
(5, 'Kanapka 2', '44444444444444', '1-01-01-45', 'Kanapka 2', 'Szt.', 'kanapka-3.png', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_quantity`
--

CREATE TABLE IF NOT EXISTS `product_quantity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `w_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `old_amount` int(11) NOT NULL,
  `transaction_type` varchar(6) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product_quantity`
--

INSERT INTO `product_quantity` (`id`, `w_id`, `p_id`, `u_id`, `amount`, `date`, `old_amount`, `transaction_type`) VALUES
(1, 1, 2, 1, 100, '2024-04-15 13:27:50', 0, 'set'),
(2, 1, 2, 1, 50, '2024-04-16 20:27:50', 100, 'set'),
(3, 1, 4, 1, 5, '2024-04-16 21:18:13', 0, 'add'),
(4, 1, 2, 1, 5, '2024-04-16 21:18:13', 0, 'add'),
(5, 1, 2, 1, 5, '2024-04-16 21:18:15', 0, 'sub'),
(6, 1, 1, 1, 20, '2024-04-17 18:56:11', -6, 'set'),
(7, 1, 2, 1, 40, '2024-04-17 18:56:11', 50, 'set'),
(8, 1, 3, 1, 8, '2024-04-17 18:56:11', 5, 'set'),
(9, 1, 4, 1, 10, '2024-04-17 18:56:11', 3, 'set'),
(10, 1, 5, 1, 8, '2024-04-17 18:56:11', 0, 'set'),
(11, 1, 1, 1, 22, '2024-04-17 19:38:44', 20, 'set'),
(12, 1, 2, 1, 40, '2024-04-17 19:38:44', 40, 'set'),
(13, 1, 3, 1, 8, '2024-04-17 19:38:44', 8, 'set'),
(14, 1, 4, 1, 10, '2024-04-17 19:38:44', 10, 'set'),
(15, 1, 5, 1, 8, '2024-04-17 19:38:44', 8, 'set'),
(16, 2, 1, 1, 0, '2024-04-17 20:02:43', -32, 'set'),
(17, 2, 2, 1, 0, '2024-04-17 20:02:43', 0, 'set'),
(18, 2, 3, 1, 0, '2024-04-17 20:02:43', 0, 'set'),
(19, 2, 4, 1, 0, '2024-04-17 20:02:43', -15, 'set'),
(20, 2, 5, 1, 0, '2024-04-17 20:02:43', -3, 'set'),
(21, 4, 1, 1, 0, '2024-04-18 18:13:23', -10, 'set'),
(22, 1, 1, 1, 5, '2024-04-18 18:13:40', 0, 'add'),
(23, 1, 1, 1, 2, '2024-04-18 18:15:16', 30, 'add'),
(24, 1, 4, 1, 2, '2024-04-18 18:21:01', 10, 'sub');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_scans`
--

CREATE TABLE IF NOT EXISTS `product_scans` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `sku` varchar(32) NOT NULL,
  `ean` varchar(32) NOT NULL,
  `s_warehouse` int(11) NOT NULL,
  `ps_active` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `product_scans`
--

INSERT INTO `product_scans` (`id`, `p_id`, `u_id`, `sku`, `ean`, `s_warehouse`, `ps_active`, `date`) VALUES
(1, 3, 1, '1-01-01-33', '33333333333333333', 1, 1, '2024-04-10 19:18:43'),
(2, 2, 1, '1-01-01-12', '2222222222222222', 1, 0, '2024-04-10 19:18:59'),
(3, 1, 1, '1-01-01-1', '111111111111111', 1, 1, '2024-04-10 19:18:49'),
(4, 3, 1, '1-01-01-33', '33333333333333333', 1, 1, '2024-04-10 20:42:55'),
(5, 3, 1, '1-01-01-33', '33333333333333333', 1, 1, '2024-04-10 20:42:56'),
(6, 3, 1, '1-01-01-33', '33333333333333333', 1, 1, '2024-04-10 20:42:57'),
(7, 3, 1, '1-01-01-33', '33333333333333333', 1, 1, '2024-04-10 20:42:58'),
(8, 3, 1, '1-01-01-33', '33333333333333333', 3, 1, '2024-04-10 20:43:00'),
(9, 3, 1, '1-01-01-33', '33333333333333333', 3, 1, '2024-04-10 20:43:01'),
(10, 3, 1, '1-01-01-33', '33333333333333333', 3, 1, '2024-04-10 20:43:01'),
(11, 3, 1, '1-01-01-33', '33333333333333333', 3, 1, '2024-04-10 20:43:02'),
(12, 3, 1, '1-01-01-33', '33333333333333333', 3, 1, '2024-04-10 20:43:03'),
(13, 3, 1, '1-01-01-33', '33333333333333333', 4, 1, '2024-04-10 20:43:06'),
(14, 3, 1, '1-01-01-33', '33333333333333333', 4, 1, '2024-04-10 20:43:07'),
(15, 3, 1, '1-01-01-33', '33333333333333333', 4, 1, '2024-04-10 20:43:09'),
(16, 3, 1, '1-01-01-33', '33333333333333333', 4, 1, '2024-04-10 20:43:09'),
(17, 2, 1, '1-01-01-12', '2222222222222222', 4, 1, '2024-04-10 20:43:19'),
(18, 2, 1, '1-01-01-12', '2222222222222222', 4, 1, '2024-04-10 20:43:20'),
(19, 2, 1, '1-01-01-12', '2222222222222222', 3, 1, '2024-04-10 20:43:23'),
(20, 2, 1, '1-01-01-12', '2222222222222222', 3, 1, '2024-04-10 20:43:24'),
(21, 2, 1, '1-01-01-12', '2222222222222222', 3, 1, '2024-04-10 20:43:24'),
(22, 2, 1, '1-01-01-12', '2222222222222222', 3, 1, '2024-04-10 20:43:25'),
(23, 2, 1, '1-01-01-12', '2222222222222222', 3, 1, '2024-04-10 20:43:28'),
(24, 1, 1, '1-01-01-1', '111111111111111', 1, 1, '2024-04-10 20:43:32'),
(25, 1, 1, '1-01-01-1', '111111111111111', 1, 1, '2024-04-10 20:43:33'),
(26, 1, 1, '1-01-01-1', '111111111111111', 1, 0, '2024-04-10 20:43:34'),
(27, 1, 1, '1-01-01-1', '111111111111111', 1, 1, '2024-04-10 20:43:35'),
(28, 1, 1, '1-01-01-1', '111111111111111', 1, 0, '2024-04-17 20:07:26'),
(29, 1, 1, '1-01-01-1', '111111111111111', 1, 1, '2024-04-17 20:07:26'),
(30, 1, 1, '1-01-01-1', '111111111111111', 1, 1, '2024-04-17 20:07:27'),
(31, 1, 1, '1-01-01-1', '111111111111111', 1, 1, '2024-04-20 20:07:28'),
(32, 1, 1, '1-01-01-1', '111111111111111', 1, 1, '2024-04-21 20:32:05'),
(33, 1, 1, '1-01-01-1', '111111111111111', 1, 1, '2024-04-21 20:32:06');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `recipes`
--

CREATE TABLE IF NOT EXISTS `recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `description` text NOT NULL,
  `r_name` varchar(64) NOT NULL,
  `u_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `p_id`, `active`, `description`, `r_name`, `u_id`, `date`) VALUES
(1, 4, 1, 'Przepis na przygotowanie Produkt 1', 'Recepta Produkt 11111', 1, '2024-04-20 20:30:57'),
(2, 1, 1, 'Receptura druga testowa', 'Druga receptura', 1, '2024-04-20 21:20:20');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `recipe_details`
--

CREATE TABLE IF NOT EXISTS `recipe_details` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `r_id` int(11) NOT NULL,
  `sub_prod` int(11) NOT NULL,
  `amount` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `recipe_details`
--

INSERT INTO `recipe_details` (`id`, `r_id`, `sub_prod`, `amount`) VALUES
(13, 2, 2, 4),
(14, 1, 2, 1),
(15, 1, 3, 0.001);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `returns`
--

CREATE TABLE IF NOT EXISTS `returns` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `w_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `u_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `w_id`, `p_id`, `date`, `u_id`, `amount`) VALUES
(1, 1, 2, '2024-04-15 19:09:13', 1, 4),
(2, 1, 5, '2024-04-15 19:10:04', 1, 2),
(3, 1, 5, '2024-04-15 19:10:35', 1, 1),
(4, 2, 1, '2024-04-17 19:08:09', 1, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `roles_name`
--

CREATE TABLE IF NOT EXISTS `roles_name` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(32) NOT NULL,
  `role_description` varchar(128) NOT NULL,
  `r_active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `roles_name`
--

INSERT INTO `roles_name` (`id`, `role_name`, `role_description`, `r_active`) VALUES
(1, 'Superadmin', 'Super administrator', 1),
(2, 'Administrator', 'Administrator', 1),
(3, 'Handlowiec', 'Handlowiec', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `sales`
--

CREATE TABLE IF NOT EXISTS `sales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  `sale_description` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `p_id` int(11) NOT NULL,
  `s_amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`id`, `u_id`, `c_id`, `sale_description`, `date`, `p_id`, `s_amount`) VALUES
(1, 1, 3, 'sprzedane gardenpharm', '2024-04-13 10:43:24', 1, 5),
(2, 1, 3, 'sprzedane gardenpharm', '2024-04-14 10:43:20', 4, 3),
(3, 1, 1, '', '2024-04-21 10:33:05', 1, 4),
(4, 1, 1, '', '2024-04-15 10:33:05', 4, 2),
(5, 1, 0, '', '2024-04-15 18:21:35', 1, 2),
(6, 1, 0, '', '2024-04-20 19:14:49', 1, 1),
(7, 1, 2, '', '2024-04-20 19:25:35', 1, 3),
(8, 1, 2, '', '2024-04-21 19:25:35', 5, 1),
(9, 1, 0, '', '2024-04-21 19:07:50', 1, 2),
(10, 1, 0, '', '2024-04-21 20:54:57', 1, 2);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `first_name` varchar(32) NOT NULL,
  `last_name` varchar(32) NOT NULL,
  `password` varchar(64) NOT NULL,
  `u_role` int(11) NOT NULL,
  `u_warehouse` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `password`, `u_role`, `u_warehouse`, `active`, `date`) VALUES
(1, 'test@test.pl', 'Imię', 'Nazwisko', 'test', 1, 1, 1, '2024-04-21 19:44:20'),
(2, 'mateusz.zybura@gmail.com', 'Mateusz', 'Zybura', 'test', 3, 4, 1, '2024-04-12 20:33:15');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `warehouses`
--

CREATE TABLE IF NOT EXISTS `warehouses` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_city` int(11) NOT NULL,
  `wh_name` varchar(16) NOT NULL,
  `wh_fullname` varchar(32) NOT NULL,
  `wh_description` text NOT NULL,
  `w_active` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `id_city`, `wh_name`, `wh_fullname`, `wh_description`, `w_active`) VALUES
(1, 1, 'G1', 'Gołębiów', 'Rapackiego 1', 1),
(2, 1, 'FEN', 'Galeria Feniks', 'Grzecznarowskiego 29/31', 1),
(3, 2, 'CH', 'Kurczaki KPS', 'Przemysłowa 31', 1),
(4, 3, 'GO', 'Galeria Ostrowiec', 'Mickiewicza 30', 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `warehouse_access`
--

CREATE TABLE IF NOT EXISTS `warehouse_access` (
  `wa_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `w_id` int(11) NOT NULL,
  PRIMARY KEY (`wa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `warehouse_access`
--

INSERT INTO `warehouse_access` (`wa_id`, `u_id`, `w_id`) VALUES
(5, 2, 4),
(6, 1, 1),
(7, 1, 2),
(8, 1, 4);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
