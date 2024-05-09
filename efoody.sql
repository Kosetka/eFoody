-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Maj 09, 2024 at 09:18 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `cargo`
--

TRUNCATE TABLE `cargo`;
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
(18, 1, 1, '2024-04-21 20:54:55', 1, 2),
(19, 1, 1, '2024-04-22 11:32:58', 1, 10),
(20, 1, 4, '2024-04-22 11:32:58', 1, 5),
(21, 1, 1, '2024-04-22 12:27:44', 1, 14),
(22, 1, 4, '2024-04-22 12:27:44', 1, 9),
(23, 1, 5, '2024-04-22 12:27:44', 1, 8),
(24, 1, 1, '2024-04-22 12:40:59', 1, 12),
(25, 1, 4, '2024-04-22 12:40:59', 1, 11),
(26, 1, 5, '2024-04-22 12:40:59', 1, 10),
(27, 1, 1, '2024-04-23 13:39:28', 1, 32),
(28, 1, 4, '2024-04-23 13:39:34', 1, 9),
(29, 1, 5, '2024-04-23 13:39:34', 1, 6),
(30, 1, 1, '2024-04-23 13:42:15', 1, 10),
(31, 1, 4, '2024-04-23 13:42:15', 1, 10),
(32, 1, 5, '2024-04-23 13:42:15', 1, 10),
(33, 1, 1, '2024-04-24 08:11:01', 1, 10),
(34, 1, 4, '2024-04-24 08:11:01', 1, 10),
(35, 1, 5, '2024-04-24 08:11:01', 1, 10),
(36, 2, 1, '2024-04-25 12:36:10', 1, 20),
(37, 2, 4, '2024-04-25 12:36:10', 1, 10),
(38, 2, 5, '2024-04-25 12:36:11', 1, 10),
(39, 2, 21, '2024-04-25 12:36:11', 1, 5),
(40, 2, 24, '2024-04-25 12:36:11', 1, 10),
(41, 1, 1, '2024-04-26 12:24:35', 1, 10),
(42, 1, 4, '2024-04-26 12:24:35', 1, 10),
(43, 1, 1, '2024-04-30 13:43:56', 1, 4);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `cargo_exchange`
--

CREATE TABLE IF NOT EXISTS `cargo_exchange` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id_init` int(11) NOT NULL,
  `u_id_target` int(11) NOT NULL,
  `result` int(11) NOT NULL COMMENT '0 - pending, 1 - accepted, 2 - declined, 3 - canceled, 4 - autodeclined',
  `date_init` timestamp NOT NULL DEFAULT current_timestamp(),
  `date_result` datetime NOT NULL,
  `p_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `cargo_exchange`
--

TRUNCATE TABLE `cargo_exchange`;
--
-- Dumping data for table `cargo_exchange`
--

INSERT INTO `cargo_exchange` (`id`, `u_id_init`, `u_id_target`, `result`, `date_init`, `date_result`, `p_id`, `amount`) VALUES
(1, 2, 1, 1, '2024-04-22 12:58:07', '0000-00-00 00:00:00', 1, 1),
(2, 2, 1, 2, '2024-04-22 12:58:07', '0000-00-00 00:00:00', 4, 2),
(3, 2, 1, 0, '2024-04-22 12:58:07', '0000-00-00 00:00:00', 5, 3),
(4, 1, 2, 0, '2024-04-22 13:39:27', '0000-00-00 00:00:00', 1, 3),
(5, 1, 2, 0, '2024-04-22 13:39:27', '0000-00-00 00:00:00', 4, 4),
(6, 1, 2, 0, '2024-04-22 13:39:27', '0000-00-00 00:00:00', 5, 4),
(7, 1, 2, 1, '2024-04-24 12:37:26', '0000-00-00 00:00:00', 1, 10),
(8, 2, 1, 1, '2024-04-24 13:38:03', '0000-00-00 00:00:00', 5, 6);

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
-- Tabela Truncate przed wstawieniem `cities`
--

TRUNCATE TABLE `cities`;
--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `c_name`, `c_fullname`, `c_description`, `c_active`) VALUES
(1, 'WR', 'Radom', '', 1),
(2, 'WRA', 'Pionki', '', 0),
(3, 'TOS', 'Ostrowiec Świętokrzyski', '', 0);

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
  `c_type` varchar(16) DEFAULT NULL,
  `workers` varchar(16) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=339 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `companies`
--

TRUNCATE TABLE `companies`;
--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`id`, `email`, `phone_number`, `full_name`, `contact_first_name`, `contact_last_name`, `city_id`, `active`, `guardian`, `address`, `postal_code`, `city`, `street`, `street_number`, `nip`, `company_type`, `date`, `description`, `latitude`, `longitude`, `c_type`, `workers`) VALUES
(1, 'kontakt@nutridome.pl', '546789456', 'Nutridome Sp. z o.o.', 'Katarzyna', 'Staszowska', 1, 1, 1, 'Gazowa 8, Radom 26-600', '26-600', 'Radom', 'Gazowa', '8', '5272825059', 0, '0000-00-00 00:00:00', 'Pierwsze piętro', '51.3831506671975', '21.1458715975217', 'building', '20'),
(2, 'kontakt@abriga.com', '456456456', 'Abriga Polska', 'Abriga Imie', 'Abriga Nazwisko', 1, 1, 1, 'Staromiejska 8/12, Radom 26-600', '26-600', 'Radom', 'Staromiejska', '8/12', '9482609074', 0, '2024-04-12 22:40:31', 'Wejście od bramy, pierwsze piętro 2', '51.4026410792049', '21.1389443620357', 'exclamation', '10-15'),
(3, 'kontakt@gardenpharm.pl', '753758753', 'GARDENPHARM', 'Garden', 'Pharm', 2, 1, 1, 'Staromiejska 8/12, Radom 26-600', '26-600', 'Radom', 'Staromiejska', '8/12', '5272633466', 0, '2024-04-12 22:58:34', 'test', '51.4026710496112', '21.1390052312358', 'shop', '30'),
(4, 'maciej.jezierski@gmail.com', '456456456', 'DRUKPOINT', 'Maciej', 'Jezierski', 1, 1, 1, 'Wernera 20, Radom 26-600', '26-600', 'Radom', 'Wernera', '20', '1132686331', 0, '2024-04-21 22:10:46', '', '51.4101547083976', '21.1382379203433', 'warehouse', '20'),
(5, '', '', 'Lotnisko jednostka wojskowa', '', '', 1, 0, 3, 'Sadków 9, Radom 26-603', '26-603', 'Radom', 'Sadków', '9', '', 0, '2024-05-06 15:22:39', '', '51.3964026837378', '21.2070246813311', 'warehouse', '20+'),
(6, '', '502293551', 'Urząd Celny', '', '', 1, 1, 3, 'Wrocławska 4, Radom 26-600', '26-600', 'Radom', 'Wrocławska', '4', '', 0, '2024-05-06 15:24:16', '502293551, 882111595, 882820653, 600909025, 605608400', '51.4011477717934', '21.1915835966740', 'warehouse', '20+'),
(7, '', '576199936', 'Auto Partner SA', '', '', 1, 1, 3, 'Aleja Wojska Polskiego 76, Radom 26-600', '26-600', 'Radom', 'Aleja Wojska Polskiego', '76', '', 0, '2024-05-06 15:25:46', '576199936, 695408644; zamówienie', '51.3942183717918', '21.1964396966736', 'shop', '10+'),
(8, '', '', 'Albo Sp. z o.o. Hurtownia drobiu, wędlin i mięsa', '', '', 1, 0, 3, 'Lubelska 65, Radom 26-600', '26-600', 'Radom', 'Lubelska', '65', '', 0, '2024-05-06 15:27:02', 'grupa WhatsApp', '51.3996994717930', '21.1879305390026', 'shop', '10+'),
(9, '', '732734023', 'Seliga', '', '', 1, 1, 3, 'Lubelsk 65, Radom 26-600', '26-600', 'Radom', 'Lubelsk', '65', '', 0, '2024-05-06 15:28:16', '732734023, 795098076, 665518431, 888726104, 882618250, 668758533, 573076810; zamówienie+podjechać', '51.4005423783714', '21.1878542678383', 'shop', '10+'),
(10, '', '', 'Apetyt. Wójcik S.', '', '', 1, 1, 3, 'Lubelska 65, Radom 26-600', '26-600', 'Radom', 'Lubelska', '65', '', 0, '2024-05-06 15:29:13', '507087447, 791567380; zamówienie', '51.3988915781294', '21.1859738390026', 'shop', '5+'),
(11, '', '667405549', 'Promocja. Hurtownia spożywcza', '', '', 1, 1, 3, 'Lubelska 65, Radom 26-603', '26-603', 'Radom', 'Lubelska', '65', '', 0, '2024-05-06 15:30:37', '', '51.3990195685456', '21.1858386555122', 'shop', '5+'),
(12, '', '668155356', 'DOMOSFERA', '', '', 1, 1, 3, 'Lubelska 39, Radom 26-603', '26-603', 'Radom', 'Lubelska', '39', '', 0, '2024-05-06 15:31:36', '', '51.3984713099586', '21.1819161355933', 'shop', '10+'),
(13, 'chg@chlodniegomar.pl', '', 'Chłodnie Gomar Sp. z o.o.', '', '', 1, 1, 3, 'Wrocławska 9b, Radom 26-603', '26-603', 'Radom', 'Wrocławska', '9b', '', 0, '2024-05-06 15:33:02', '', '51.4009762740858', '21.1846933147671', 'shop', '10+'),
(14, '', '502273515', 'Sklep spożywczo- monopolowy Teresa Kwietniewska', '', '', 1, 1, 3, 'Lubelska 48, Radom 26-603', '26-603', 'Radom', 'Lubelska', '48', '', 0, '2024-05-06 15:34:13', 'zamówienie', '51.3982601688567', '21.1805625507815', 'house', '1+'),
(15, '', '609844250', 'PPH Płomyk', '', '', 1, 1, 3, 'Lubelska 65, Radom 26-600', '26-600', 'Radom', 'Lubelska', '65', '', 0, '2024-05-06 15:35:15', 'podjechać codziennie', '51.3990126086109', '21.1858330122961', 'shop', '5+'),
(16, '', '516248549', 'Your Loft Design Sp. z o.o.', '', '', 1, 1, 3, 'Wrocławska 4b, Radom 26-615', '26-615', 'Radom', 'Wrocławska', '4b', '', 0, '2024-05-06 15:37:13', 'zamówienie', '51.4010207534575', '21.1920196419861', 'shop', '10+'),
(17, '', '', 'Komisariat Policji III KMP w Radomiu', '', '', 1, 1, 3, 'Batalionów Chłopskich 6/8, Radom 26-600', '26-600', 'Radom', 'Batalionów Chłopskich', '6/8', '', 0, '2024-05-06 15:38:02', '', '51.3881325979810', '21.1224743788821', 'exclamation', '20+'),
(18, '', '', 'Salon kosmetyczny Dominika Jagiełło', '', '', 1, 0, 3, 'Lotnicza 46, Radom 26-603', '26-603', 'Radom', 'Lotnicza', '46', '', 0, '2024-05-06 15:39:25', '', '51.3919766071503', '21.1957190768693', 'house', '1+'),
(19, '', '', 'Mazowiecki Wojewódzki Ośrodek Medycyny Pracy Oddział Radom', '', '', 1, 1, 3, 'Rodziny Winczewskich 5, Radom 26-600', '26-600', 'Radom', 'Rodziny Winczewskich', '5', '', 0, '2024-05-06 15:40:19', '', '51.4091735795841', '21.1476359147521', 'exclamation', '20+'),
(20, '', '', 'ART-SERVICE Okna, Drzwi, Bramy', '', '', 1, 1, 3, 'Chorzowska 14, Radom 26-600', '26-600', 'Radom', 'Chorzowska', '14', '', 0, '2024-05-06 15:41:23', 'grupa na messengerze; zamówienie, zawsze do 13', '51.4016791677925', '21.1965866721771', 'building', '20+'),
(21, '', '504044858', 'Budirem Zakład Budownictwa i Remontów J.R.A Wasita S.C.', '', '', 1, 1, 3, 'Lubelska 69/71, Radom 26-600', '26-600', 'Radom', 'Lubelska', '69/71', '', 0, '2024-05-06 15:42:07', 'zamówienie', '51.3988175667668', '21.1865184871974', 'shop', '10+'),
(22, '', '504425004', 'Biuro rachunkowe', '', '', 1, 1, 3, 'Lubelska 69, Radom 26-603', '26-603', 'Radom', 'Lubelska', '69', '', 0, '2024-05-06 15:43:00', 'zamówienie', '51.3981518168790', '21.1860818536384', 'house', '5+'),
(23, '', '', 'Radom Office Park', '', '', 1, 1, 3, 'Jacka Malczewskiego 24, Radom 26-600', '26-600', 'Radom', 'Jacka Malczewskiego', '24', '', 0, '2024-05-06 15:43:46', '', '51.4079903640609', '21.1533453062354', 'exclamation', '20+'),
(24, '', '600075251', 'MANEX Sp. z o.o.', '', '', 1, 1, 3, 'Lubelska 87, Radom 26-603', '26-603', 'Radom', 'Lubelska', '87', '', 0, '2024-05-06 15:44:34', 'zamówienie', '51.3978485125589', '21.1882976159194', 'shop', '10+'),
(25, '', '', 'Centrum Medyczne Koordynacja', '', '', 1, 1, 3, 'Kielecka 90/1, Radom 26-610', '26-610', 'Radom', 'Kielecka', '90/1', '', 0, '2024-05-06 15:45:08', '', '51.3962957670194', '21.1064724946806', 'exclamation', '20+'),
(26, '', '', 'Medycyna Estetyczna Radom Global Esthetic', '', '', 1, 1, 3, 'Gabriela Narutowicza 1, Radom 26-600', '26-600', 'Radom', 'Gabriela Narutowicza', '1', '', 0, '2024-05-06 15:46:29', '', '51.3964151792438', '21.1517637183818', 'shop', '5+'),
(27, '', '604623265', 'VeAn Tattoo and Piercing', '', '', 1, 1, 3, 'Gabriela Narutowicza 1, Radom 26-600', '26-600', 'Radom', 'Gabriela Narutowicza', '1', '', 0, '2024-05-06 15:47:31', 'zamówienie, warto podjechać', '51.3964025461329', '21.1520136257874', 'shop', '5+'),
(28, '', '', 'Studio Urody Radom Salon Fryzjerski Paznokcie Makijaż Zabiegi METAMORFOZA', '', '', 1, 1, 3, 'Romualda Traugutta 56, Radom 26-610', '26-610', 'Radom', 'Romualda Traugutta', '56', '', 0, '2024-05-06 15:48:22', '', '51.4002268340819', '21.1491955661051', 'shop', '5+'),
(29, '', '', 'Savarte', '', '', 1, 1, 3, 'Dzierzkowska 20/lok2, Radom 26-600', '26-600', 'Radom', 'Dzierzkowska', '20/lok2', '', 0, '2024-05-06 15:49:02', '', '51.3981145842382', '21.1658290684099', 'shop', '5+'),
(30, '', '', 'Radomski Szpital Specjalistyczny', '', '', 1, 1, 3, 'Adolfa Tochtermana 1, Radom 26-610', '26-610', 'Radom', 'Adolfa Tochtermana', '1', '', 0, '2024-05-06 15:49:42', '', '51.3998676635190', '21.1459470070310', 'exclamation', '50+'),
(31, '', '', 'Kasa Rolniczego Ubezpieczenia Społecznego. Placówka terenowa', '', '', 1, 1, 3, 'Gabriela Narutowicza 11/13, 26-610 Radom', 'Radom', '26-610', 'Gabriela Narutowicza', '11/13', '', 0, '2024-05-06 15:50:17', '', '51.3980415538269', '21.1437370861677', 'exclamation', '20+'),
(32, '', '600336144', 'Expelos radom', '', '', 1, 1, 3, 'Gabriela Narutowicza 1, Radom 26-600', '26-600', 'Radom', 'Gabriela Narutowicza', '1', '', 0, '2024-05-06 15:56:31', 'zamówienie', '51.3963867296228', '21.1522150000373', 'shop', '5+'),
(33, '', '530047870', 'Salon kosmetyczny Piękna Ja', '', '', 1, 1, 3, 'Jerzego Radomskiego 5, Radom 26-604', '26-604', 'Radom', 'Jerzego Radomskiego', '5', '', 0, '2024-05-06 15:57:40', '530047870, 516515162; zamówienie', '51.3778972652578', '21.1719759980922', 'house', '1+'),
(34, '', '509609892', 'iBlockFIRE - Spray Gaśniczy', '', '', 1, 1, 3, 'Wrocławska 9, Radom 26-600', '26-600', 'Radom', 'Wrocławska', '9', '', 0, '2024-05-06 15:58:27', '509609892, 504081511; zamówienie', '51.4017019785372', '21.1853307404218', 'shop', '5+'),
(35, '', '604459417', 'Radomskie Centrum Rodziny -Przychodnia Podstawowej Opieki Zdrowotnej', '', '', 1, 1, 3, 'Jerzego Radomskiego 5, Radom 26-604', '26-604', 'Radom', 'Jerzego Radomskiego', '5', '', 0, '2024-05-06 15:59:19', 'zamówienie', '51.3777550750279', '21.1720847980922', 'shop', '10+'),
(36, '', '501533148', 'Dom', '', '', 1, 1, 3, 'Milenijna 14, Radom 26-606', '26-606', 'Radom', 'Milenijna', '14', '', 0, '2024-05-06 16:00:22', 'zamówienie, codziennie max do 8', '51.3712434656545', '21.1662145056544', 'house', '1+'),
(37, '', '', 'Audi Select :plus Radom - salon i serwis samochodowy', '', '', 1, 1, 3, 'Juliana Ursyna Niemcewicza 2/4, Radom 26-604', '26-604', 'Radom', 'Juliana Ursyna Niemcewicza', '2/4', '', 0, '2024-05-07 08:26:18', 'WhatsApp; Podjechać rano', '51.3829227797861', '21.1651541845994', 'shop', '10+'),
(38, '', '518853767', 'Be Beauty Salon urody', '', '', 1, 1, 3, 'Romualda Traugutta 55, Radom 26-610', '26-610', 'Radom', 'Romualda Traugutta', '55', '', 0, '2024-05-07 08:27:11', 'Zamówienie ', '51.3989111924206', '21.1495771171954', 'house', '1+'),
(39, '', '669754084', 'DOZ Apteka dbam o zdrowie', '', '', 1, 1, 3, 'Cisowa 7, Radom 26-611', '26-611', 'Radom', 'Cisowa', '7', '', 0, '2024-05-07 08:27:57', 'Zamówienie ', '51.3785186784964', '21.1570215980922', 'shop', '5+'),
(40, '', '601071460', 'TEB Edukacja', '', '', 1, 1, 3, 'Juliusza Słowackiego 84, 26-600 Radom', 'Radom', '26-600', 'Juliusza Słowackiego', '84', '', 0, '2024-05-07 08:29:21', 'zamówienie', '51.3897457118849', '21.1716880287779', 'building', '20+'),
(41, '', '669296711', 'Meble Michalczewski', '', '', 1, 1, 3, 'Biznesowa  4, Radom 26-600', '26-600', 'Radom', 'Biznesowa ', '4', '', 0, '2024-05-07 08:30:07', 'dojazd', '51.3909257666171', '21.1469434404215', 'shop', '5+'),
(42, '', '510053451', 'Vestim Group Sp. zo.o.', '', '', 1, 1, 3, 'Biznesowa 9, Radom 26-600', '26-600', 'Radom', 'Biznesowa', '9', '', 0, '2024-05-07 08:31:03', 'dojazd', '51.3901833072429', '21.1476596404214', 'shop', '5+'),
(43, '', '694438354', 'OptiMed - optyk, okulista, optometrysta - Radom', '', '', 1, 1, 3, 'Bernardyńska 1/3, Radom 26-600', '26-600', 'Radom', 'Bernardyńska', '1/3', '', 0, '2024-05-07 08:31:43', 'dojazd', '51.4012341985125', '21.1460904404218', 'house', '5+'),
(44, '', '600038017', 'HADES Radom', '', '', 1, 1, 3, 'Bernardyńska 1/3, Radom 26-600', '26-600', 'Radom', 'Bernardyńska', '1/3', '', 0, '2024-05-07 08:33:37', 'zamówienie', '51.4012591518965', '21.1461101414889', 'shop', '5+'),
(45, '', '502244478', 'Pracownia Protetyki Stomatologicznej', '', '', 1, 1, 3, 'Stefana Żeromskiego 2, Radom 26-600', '26-600', 'Radom', 'Stefana Żeromskiego', '2', '', 0, '2024-05-07 08:35:20', 'zamówienie', '51.4016235125245', '21.1462608010522', 'house', '1+'),
(46, '', '887037804', 'Meble na wymiar- Meble Katrin', '', '', 1, 1, 3, 'Wałowa  3, Radom 26-600', '26-600', 'Radom', 'Wałowa ', '3', '', 0, '2024-05-07 08:36:15', 'zamówienie', '51.4016187052551', '21.1462218236915', 'house', '1+'),
(47, '', '505018180', 'Mikirad. Sklep medyczny', '', '', 1, 1, 3, 'Planty 13, Radom 26-610', '26-610', 'Radom', 'Planty', '13', '', 0, '2024-05-07 08:36:57', 'zamówienie', '51.3934907564943', '21.1484241855399', 'house', '5+'),
(48, '', '505015895', 'Angela', '', '', 1, 1, 3, 'Romualda Traugutta 1A, Radom 26-610', '26-610', 'Radom', 'Romualda Traugutta', '1A', '', 0, '2024-05-07 08:37:58', 'zamówienie', '51.3920666129603', '21.1538780380845', 'house', '1+'),
(49, '', '507955760', 'Biuro Urządzania Lasu i Geodezji Leśnej', '', '', 1, 1, 3, '25 Czerwca 68, Radom 26-610', '26-610', 'Radom', '25 Czerwca', '68', '', 0, '2024-05-07 08:38:48', 'podjechac', '51.4028887210883', '21.1645021853742', 'shop', '10+'),
(50, '', '', 'O.K. Serwis MPS', '', '', 1, 1, 3, 'Biznesowa 12, Radom 26-612', '26-612', 'Radom', 'Biznesowa', '12', '', 0, '2024-05-07 08:39:31', 'dojazd', '51.3883238908352', '21.1470750266476', 'shop', '5+'),
(51, '', '', 'Tolen - Przydomowe Oczyszczalnie Ścieków Radom, Szamba, Zbiorniki na deszczówkę, Zbiorniki na paliwo, Separatory', '', '', 1, 1, 3, 'Radomska 16, Makowiec 26-640', '26-640', 'Makowiec', 'Radomska', '16', '', 0, '2024-05-07 08:40:15', '', '51.3559087719300', '21.2083792395729', 'shop', '10+'),
(52, '', '', 'Salon Fryzjerski', '', '', 1, 1, 3, 'Juliusza Słowackiego 95, Radom 26-604', '26-604', 'Radom', 'Juliusza Słowackiego', '95', '', 0, '2024-05-07 08:41:33', '', '51.3901254497417', '21.1718440100805', 'house', '2+'),
(53, '', '500144384', 'Babymarket / Kimex', '', '', 1, 1, 3, 'Aleja Wojska Polskiego 22/24, Radom 26-600', '26-600', 'Radom', 'Aleja Wojska Polskiego', '22/24', '', 0, '2024-05-07 08:43:02', '', '51.3832742298429', '21.1845811765350', 'shop', '10+'),
(54, '', '503081578', 'Badpol secondhand -sklep z odzieżą używaną Radom', '', '', 1, 1, 3, 'Władysława Beliny-Prażmowskiego 13,   13, Radom 26-610', '26-610', 'Radom', 'Władysława Beliny-Prażmowskiego 13,  ', '13', '', 0, '2024-05-07 08:43:41', '', '51.3927724455230', '21.1564989769762', 'shop', '5+'),
(55, '', '502357159', 'Elite Salon Kosmetyki Profesjonalnej i Laserowej', '', '', 1, 1, 3, 'Ludwika Waryńskiego 9a, Radom 26-610', '26-610', 'Radom', 'Ludwika Waryńskiego', '9a', '', 0, '2024-05-07 08:44:27', '', '51.3952940983687', '21.1566855135205', 'shop', '5+'),
(56, '', '531590080', 'Korbank', '', '', 1, 1, 3, 'Stefana Żeromskiego 94, Radom 26-610', '26-610', 'Radom', 'Stefana Żeromskiego', '94', '', 0, '2024-05-07 08:45:09', '', '51.3995629642980', '21.1667265103413', 'shop', '5+'),
(57, '', '509770609', 'Przychodnia ŻAK', '', '', 1, 1, 3, 'Giserska 4, Radom 26-604', '26-604', 'Radom', 'Giserska', '4', '', 0, '2024-05-07 08:45:50', '', '51.3932185016949', '21.1687039537875', 'shop', '10+'),
(58, '', '731142768', 'Centrum Nauki i Biznesu Żak Sp. z o.o.', '', '', 1, 1, 3, 'Romualda Traugutta 17A, Radom 26-600', '26-600', 'Radom', 'Romualda Traugutta', '17A', '', 0, '2024-05-07 08:46:26', '', '51.3948857890459', '21.1545164255092', 'building', '10+'),
(59, '', '', 'Butik Doris', '', '', 1, 1, 3, 'Ludwika Waryńskiego 7, Radom 26-600', '26-600', 'Radom', 'Ludwika Waryńskiego', '7', '', 0, '2024-05-07 08:46:55', '', '51.3953296977380', '21.1564339922157', 'house', '1+'),
(60, '', '', 'Kantor Exchange', '', '', 1, 1, 3, 'Romualda Traugutta 28, Radom 26-610', '26-610', 'Radom', 'Romualda Traugutta', '28', '', 0, '2024-05-07 08:47:39', 'znajoma mam tylko numer prywatny trzeba zapytac', '51.3956590410867', '21.1546782261536', 'shop', '1+'),
(61, '', '', 'Warta S.A. Towarzystwo Ubezpieczeń i Reasekuracji', '', '', 1, 1, 3, 'Dionizego Czachowskiego 30, Radom 26-600', '26-600', 'Radom', 'Dionizego Czachowskiego', '30', '', 0, '2024-05-07 08:48:15', 'podjeżdżać ale do południa to wtedy czasami biora', '51.3979152392964', '21.1667791661603', 'shop', '5+'),
(62, '', '606103464', 'Pastel, artykuły plastyczne', '', '', 1, 1, 3, '25 Czerwca 26/32, Radom 26-600', '26-600', 'Radom', '25 Czerwca', '26/32', '', 0, '2024-05-07 08:48:55', '', '51.3962868417842', '21.1609542538273', 'house', '1+'),
(63, '', '', 'Assima. FPHU. Rokita D.', '', '', 1, 1, 3, '25 Czerwca 26/32, Radom 26-604', '26-604', 'Radom', '25 Czerwca', '26/32', '', 0, '2024-05-07 08:49:44', 'obok plastycznego podjeżdżać ', '51.3962266688010', '21.1609489977057', 'house', '1+'),
(64, '', '', 'Salon Fryzjerski', '', '', 1, 1, 3, 'Władysława Beliny-Prażmowskiego 17, Radom 26-600', '26-600', 'Radom', 'Władysława Beliny-Prażmowskiego', '17', '', 0, '2024-05-07 08:50:29', '', '51.3932022898825', '21.1574526525755', 'house', '1+'),
(65, '', '', 'Apteka Rodzinna', '', '', 1, 1, 3, 'Władysława Beliny-Prażmowskiego 15, Radom 26-610', '26-610', 'Radom', 'Władysława Beliny-Prażmowskiego', '15', '', 0, '2024-05-07 08:51:30', 'podjeżdżać o 13 wtedy są zmiany ', '51.3929168998518', '21.1568364328442', 'shop', '5+'),
(66, '', '', 'Salon Urody Jolanta Skąpska', '', '', 1, 1, 3, 'Juliusza Słowackiego 15A, Radom 26-610', '26-610', 'Radom', 'Juliusza Słowackiego', '15A', '', 0, '2024-05-07 08:52:06', '', '51.3987839695014', '21.1607460120882', 'house', '1+'),
(67, '', '505861062', 'Armani', '', '', 1, 1, 3, 'Juliusza Słowackiego 15A, Radom 26-604', '26-604', 'Radom', 'Juliusza Słowackiego', '15A', '', 0, '2024-05-07 08:53:02', '', '51.3987558717679', '21.1611653042656', 'house', '1+'),
(68, '', '536534370', 'Zeus Fryzjerstwo', '', '', 1, 1, 3, 'Romualda Traugutta 2/4, Radom 26-600', '26-600', 'Radom', 'Romualda Traugutta', '2/4', '', 0, '2024-05-07 08:53:54', 'dzwoni i wysyłać menu', '51.3931097748076', '21.1548971547585', 'shop', '5+'),
(69, '', '502602209', 'Solarium SUNRISE Katarzyna Żeromińska-Skorzyńska', '', '', 1, 1, 3, 'Stanisława Moniuszki 3/5, Radom 26-610', '26-610', 'Radom', 'Stanisława Moniuszki', '3/5', '', 0, '2024-05-07 08:54:38', '', '51.3970871587936', '21.1534470322478', 'house', '1+'),
(70, '', '604085582', 'Fryzjernia u Jacka - Barber Shop', '', '', 1, 1, 3, 'Młynarska 6, Radom 26-610', '26-610', 'Radom', 'Młynarska', '6', '', 0, '2024-05-07 08:55:18', '', '51.4010539584864', '21.1657134115862', 'shop', '5+'),
(71, '', '', 'ING Bank Śląski placówka bankowa w Radomiu', '', '', 1, 1, 3, 'Stefana Żeromskiego 40, Radom 26-610', '26-610', 'Radom', 'Stefana Żeromskiego', '40', '', 0, '2024-05-07 08:55:51', '', '51.4009513741908', '21.1547091636528', 'shop', '5+'),
(72, '', '500117074', 'Hurtownia Rybna MARK', '', '', 1, 1, 3, 'Lubelska 65, Radom 26-600', '26-600', 'Radom', 'Lubelska', '65', '', 0, '2024-05-07 08:56:44', '500117074, 880942818; zamówienie', '51.4001240543263', '21.1886056086366', 'shop', '5+'),
(73, '', '694701704', 'Bank Pekao', '', '', 1, 1, 3, 'Marszałka Józefa Piłsudskiego 15, Radom 26-600', '26-600', 'Radom', 'Marszałka Józefa Piłsudskiego', '15', '', 0, '2024-05-07 08:57:25', '', '51.3992845808513', '21.1524697171908', 'shop', '10+'),
(74, '', '602200201', 'M1 T-Mobile', '', '', 1, 1, 3, 'Aleja Józefa Grzecznarowskiego 28, Radom 26-600', '26-600', 'Radom', 'Aleja Józefa Grzecznarowskiego', '28', '', 0, '2024-05-07 08:58:48', '', '51.3821454764470', '21.1711233638286', 'shop', '5+'),
(75, '', '790499843', 'M1 Hebe', '', '', 1, 1, 3, 'Aleja Józefa Grzecznarowskiego 28, Radom 26-600', '26-600', 'Radom', 'Aleja Józefa Grzecznarowskiego', '28', '', 0, '2024-05-07 08:59:39', '', '51.3818638583055', '21.1707490013259', 'shop', '5+'),
(76, '', '792887740', 'M1 Vision Express', '', '', 1, 1, 3, 'Aleja Józefa Grzecznarowskiego 28, Radom 26-604', '26-604', 'Radom', 'Aleja Józefa Grzecznarowskiego', '28', '', 0, '2024-05-07 09:00:29', '', '51.3820237589702', '21.1695528759506', 'shop', '5+'),
(77, '', '734471098', 'M1 Big Star', '', '', 1, 1, 3, 'Aleja Józefa Grzecznarowskiego 28, Radom 26-604', '26-604', 'Radom', 'Aleja Józefa Grzecznarowskiego', '28', '', 0, '2024-05-07 09:01:23', '', '51.3821121430673', '21.1711304332502', 'shop', '5+'),
(78, '', '572172826', 'OptiMed - optyk, okulista, optometrysta - Radom', '', '', 1, 1, 3, 'Romualda Traugutta 31/33, Radom 26-600', '26-600', 'Radom', 'Romualda Traugutta', '31/33', '', 0, '2024-05-07 09:02:24', '', '51.3957432460801', '21.1532598740647', 'shop', '5+'),
(79, '', '729329990', 'Arthome outlet', '', '', 1, 1, 3, 'Chorzowska 12, Radom 26-600', '26-600', 'Radom', 'Chorzowska', '12', '', 0, '2024-05-07 09:03:00', '', '51.3993984551103', '21.1958429349031', 'shop', '5+'),
(80, '', '502973458', 'Salon kosmetyczny Piękna Ja', '', '', 1, 1, 3, 'Jerzego Radomskiego 5, Radom 26-604', '26-604', 'Radom', 'Jerzego Radomskiego', '5', '', 0, '2024-05-07 09:03:40', '', '51.3778816275018', '21.1719746891509', 'house', '1+'),
(81, '', '600366669', 'Brost - Usługi Pogrzebowe', '', '', 1, 1, 3, 'Wałowa 1B, Radom 26-610', '26-610', 'Radom', 'Wałowa', '1B', '', 0, '2024-05-07 09:04:11', '', '51.4016235852630', '21.1462715404217', 'shop', '5+'),
(82, '', '572172826', 'OptiMed - optyk, okulista, optometrysta', '', '', 1, 1, 3, 'Romualda Traugutta 31/33, Radom 26-600', '26-600', 'Radom', 'Romualda Traugutta', '31/33', '', 0, '2024-05-07 09:05:12', 'warto podjechać, nowy punkt', '51.3961173948459', '21.1533033888738', 'shop', '5+'),
(83, '', '', 'Tekom Technologia Sp. z o.o.', '', '', 1, 1, 4, 'Ludwikowska 17, Radom 26-600', '26-600', 'Radom', 'Ludwikowska', '17', '', 0, '2024-05-07 09:40:26', '', '51.3869892421419', '21.1780237001192', 'exclamation', '50+'),
(84, '', '', 'Miejski Ośrodek Pomocy Społecznej w Radomiu', '', '', 1, 1, 4, 'Bolesława Limanowskiego 134, Radom 26-612', '26-612', 'Radom', 'Bolesława Limanowskiego', '134', '', 0, '2024-05-07 09:40:56', '', '51.3840741129471', '21.1219388305418', 'exclamation', '50+'),
(85, '', '', 'Lotnisko Warszawa-Radom', '', '', 1, 1, 4, 'Lubelska 158, Radom 26-603', '26-603', 'Radom', 'Lubelska', '158', '', 0, '2024-05-07 09:41:46', '', '51.3934452953762', '21.1997104404870', 'exclamation', '50+'),
(86, '', '', 'Agencja Restrukturyzacji i Modernizacji Rolnictwa. Biuro powiatowe', '', '', 1, 1, 4, 'Lubelska 65, Radom 26-603', '26-603', 'Radom', 'Lubelska', '65', '', 0, '2024-05-07 09:42:27', '', '51.3997718040486', '21.1841239988091', 'exclamation', '50+'),
(87, '', '515978729', 'Salon Stylizacji - Luiza Matyjaszkiewicz', '', '', 1, 1, 5, 'Stanisława Wernera 5/15, Radom 26-610', '26-610', 'Radom', 'Stanisława Wernera', '5/15', '', 0, '2024-05-07 10:20:09', 'zamówienie+podjechać, do 11', '51.4061589745005', '21.1489831918399', 'house', '1+'),
(88, '', '600028583', 'Centrum Medyczne Terpiłowski', '', '', 1, 1, 5, 'Stanisława Wernera 5/20, Radom 26-610', '26-610', 'Radom', 'Stanisława Wernera', '5/20', '', 0, '2024-05-07 10:21:09', '600028583, 660951682, 603894583; zamówienie+podjechać, do 11', '51.4061639544450', '21.1489758356072', 'house', '5+'),
(89, '', '500415900', 'House of Beauty - Fryzjer Kosmetyczka Paznokcie Makijaż Solarium Radom', '', '', 1, 1, 5, 'Stanisława Wernera 5/5, Radom 26-600', '26-600', 'Radom', 'Stanisława Wernera', '5/5', '', 0, '2024-05-07 10:22:26', 'podjechać', '51.4060450862284', '21.1496286824304', 'house', '1+'),
(90, '', '505779288', 'Centrum zaopatrzenia kosmetycznego - KATEMOS', '', '', 1, 1, 5, 'Stanisława Wernera 5/9, Radom 26-600', '26-600', 'Radom', 'Stanisława Wernera', '5/9', '', 0, '2024-05-07 10:23:15', '505779288, 570035151; zamówienie+podjechać', '51.4060446272518', '21.1496259336929', 'house', '1+'),
(91, '', '790597070', 'Mach Bernadeta. Salon fryzjerski', '', '', 1, 1, 5, 'Stanisława Wernera 5 lok.16, Radom 26-600', '26-600', 'Radom', 'Stanisława Wernera', '5 lok.16', '', 0, '2024-05-07 10:24:25', 'podjechać', '51.4061598522311', '21.1489855203684', 'house', '1+'),
(92, '', '533323568', 'Biuro Podróży, Radom - Travelplanet.pl S.A.', '', '', 1, 1, 5, 'Koszarowa 1 lok. 1, Radom 26-600', '26-600', 'Radom', 'Koszarowa', '1 lok. 1', '', 0, '2024-05-07 10:25:17', '533323568, 609953989; zamówienie+podjechać', '51.4050028537942', '21.1499272706258', 'shop', '5+'),
(93, '', '519428487', 'Dom Pomocy Społecznej Nad Potokiem', '', '', 1, 1, 5, 'Andrzeja Struga 88, Radom 26-610', '26-610', 'Radom', 'Andrzeja Struga', '88', '', 0, '2024-05-07 10:26:05', 'zamówienie', '51.4096287408416', '21.1803043651134', 'building', '20+'),
(94, '', '884320120', 'Auto Arena', '', '', 1, 1, 5, 'Rajec Szlachecki 82, Rajec Szlachecki 26-613', '26-613', 'Rajec Szlachecki', 'Rajec Szlachecki', '82', '', 0, '2024-05-07 10:27:48', 'zamówienie', '51.4144340987309', '21.2274290680011', 'house', '1+'),
(95, '', '666255256', 'Radomskie Centrum Małych Zwierząt', '', '', 1, 1, 5, 'Bolesława Chrobrego 46/2, Radom 26-600', '26-600', 'Radom', 'Bolesława Chrobrego', '46/2', '', 0, '2024-05-07 10:28:39', 'zamówienie', '51.4201438906888', '21.1643105404226', 'house', '1+'),
(96, '', '731078777', 'M Park - Galeria ECHO', '', '', 1, 1, 5, 'Stanisława Żółkiewskiego 4, Radom 26-600', '26-600', 'Radom', 'Stanisława Żółkiewskiego', '4', '', 0, '2024-05-07 10:30:14', '731078777, 790030305, 570800591, 505273006, 885975387, 500820465; zamówienie', '51.4257963563819', '21.1543503744382', 'building', '50+'),
(97, '', '507138195', 'KM Group', '', '', 1, 1, 5, 'Jacka Malczewskiego 18a, Radom 26-600', '26-600', 'Radom', 'Jacka Malczewskiego', '18a', '', 0, '2024-05-07 10:31:09', 'zamówienie+podjechać', '51.4053412163951', '21.1511116582306', 'shop', '5+'),
(98, '', '501459110', 'AC Cortes - Mazda', '', '', 1, 1, 5, 'Jana III Sobieskiego 23, Radom 26-600', '26-600', 'Radom', 'Jana III Sobieskiego', '23', '', 0, '2024-05-07 10:32:04', 'WhatsApp, Zamówienie ', '51.4286091073786', '21.1502758892250', 'shop', '5+'),
(99, '', '693058317', 'Glam Room Radom', '', '', 1, 1, 5, 'Królowej Jadwigi 21, Radom 26-617', '26-617', 'Radom', 'Królowej Jadwigi', '21', '', 0, '2024-05-07 10:32:48', 'Zamówienie ', '51.4301628827097', '21.1541800738630', 'house', '1+'),
(100, '', '695264174', 'DOZ Apteka dbam o zdrowie', '', '', 1, 1, 5, 'Królowej Jadwigi 9, Radom 26-617', '26-617', 'Radom', 'Królowej Jadwigi', '9', '', 0, '2024-05-07 10:33:35', 'Zamówienie', '51.4293883578247', '21.1598403613543', 'shop', '5+'),
(101, '', '577379499', 'Apteka od Serca', '', '', 1, 1, 5, 'Orląt Lwowskich 7, Radom 26-600', '26-600', 'Radom', 'Orląt Lwowskich', '7', '', 0, '2024-05-07 10:34:16', 'Zamówienie ', '51.4145755208049', '21.1794923281690', 'shop', '5+'),
(102, '', '606679678', 'Przychodnia Weterynaryjna ZWIERZ nam się Jabłoński and Kowalczewski', '', '', 1, 1, 5, 'Orląt Lwowskich 7, Radom 26-615', '26-615', 'Radom', 'Orląt Lwowskich', '7', '', 0, '2024-05-07 10:35:56', 'Zamówienie ', '51.4145959192220', '21.1795164108401', 'shop', '5+'),
(103, '', '605227101', 'DOZ Apteka Dbam o Zdrowie / Punkt Szczepień', '', '', 1, 1, 5, 'Janusza Kusocińskiego 19, Radom 26-609', '26-609', 'Radom', 'Janusza Kusocińskiego', '19', '', 0, '2024-05-07 10:36:34', 'Zamówienie ', '51.4098902876846', '21.1629491404221', 'shop', '5+'),
(104, '', '534741313', 'Zoo Targ Sklep zoologiczno-akwarystyczny', '', '', 1, 1, 5, 'Królowej Jadwigi 5a, Radom 26-600', '26-600', 'Radom', 'Królowej Jadwigi', '5a', '', 0, '2024-05-07 10:37:21', 'Zamówienie ', '51.4292678684546', '21.1599998970715', 'shop', '5+'),
(105, '', '509057818', 'Optyk Sobolewscy - Optometrysta - Badanie Wzroku', '', '', 1, 1, 5, 'Królowej Jadwigi 5A, Radom 26-600', '26-600', 'Radom', 'Królowej Jadwigi', '5A', '', 0, '2024-05-07 10:38:07', 'Zamówienie ', '51.4292777473539', '21.1599979461750', 'house', '1+'),
(106, '', '607297781', 'DPD Polska - Oddział', '', '', 1, 1, 5, 'Janusza Kusocińskiego 21, Radom 26-600', '26-600', 'Radom', 'Janusza Kusocińskiego', '21', '', 0, '2024-05-07 10:39:04', 'Podjechać ', '51.4098325932279', '21.1637657039558', 'warehouse', '5+'),
(107, '', '537957422', 'Smart Relax SPA and Beauty', '', '', 1, 1, 5, 'Jacka Malczewskiego 18, Radom 26-600', '26-600', 'Radom', 'Jacka Malczewskiego', '18', '', 0, '2024-05-07 10:40:13', 'dojazd(hotel aviator)', '51.4044947826708', '21.1514300782111', 'shop', '5+'),
(108, '', '792539779', 'Met-pol', '', '', 1, 1, 5, 'Klejowa 24, Radom 26-617', '26-617', 'Radom', 'Klejowa', '24', '', 0, '2024-05-07 10:46:07', 'zamówienie', '51.4240363179799', '21.1480093686753', 'warehouse', '5+'),
(109, '', '606940943', 'VII Liceum Ogólnokształcące im. Krzysztofa Kamila Baczyńskiego', '', '', 1, 1, 5, 'Warszawska 12, Radom 26-600', '26-600', 'Radom', 'Warszawska', '12', '', 0, '2024-05-07 10:46:52', 'zamówienie', '51.4130819886879', '21.1557062947106', 'building', '20+'),
(110, '', '782919957', 'Firany Monika', '', '', 1, 1, 5, 'Królowej Jadwigi 16e, Radom 26-600', '26-600', 'Radom', 'Królowej Jadwigi', '16e', '', 0, '2024-05-07 10:48:20', 'zamówienie', '51.4307905441646', '21.1541695777992', 'shop', '5+'),
(111, '', '608360996', 'N.Z.O.Z. Specjalistyczna Pracownia Analiz Lekarskich mgr Krystyna Bałdys', '', '', 1, 1, 5, 'Andrzeja Struga 19/21, Radom 26-600', '26-600', 'Radom', 'Andrzeja Struga', '19/21', '', 0, '2024-05-07 11:11:17', '608360996, 513036165, 511135958; zamówienie', '51.4062049293789', '21.1581490750689', 'shop', '5+'),
(112, 't.budniak@uthrad.pl', '505651755', 'Uniwersytetu Technologiczno-Humanistycznego im. Kazimierza Pułaskiego w Radomiu', '', '', 1, 1, 5, 'Jacka Malczewskiego 29, Radom 26-609', '26-609', 'Radom', 'Jacka Malczewskiego', '29', '', 0, '2024-05-07 11:13:17', 'menu na maila: t.budniak@uthrad.pl; zamówienie', '51.4082141467148', '21.1517492644721', 'building', '20+'),
(113, '', '', 'Urząd Gminy w Jastrzębi', '', '', 1, 1, 5, 'Jastrzębia 110, Jastrzębia 26-631', '26-631', 'Jastrzębia', 'Jastrzębia', '110', '', 0, '2024-05-07 11:14:12', 'grupa na fb; tylko na zamówienie', '51.4963286640271', '21.2349191933194', 'building', '20+'),
(114, '', '', 'Salon Plus - Galeria Słoneczna', '', '', 1, 1, 5, 'Bolesława Chrobrego 1, Radom 26-609', '26-609', 'Radom', 'Bolesława Chrobrego', '1', '', 0, '2024-05-07 11:15:17', 'wspólna grupa na WhatsApp', '51.4060574151874', '21.1549863199768', 'shop', '2+'),
(115, '', '', 'Punkt sprzedaży Plus i Polsat Box', '', '', 1, 1, 5, 'Jacka Malczewskiego 13, Radom 26-600', '26-600', 'Radom', 'Jacka Malczewskiego', '13', '', 0, '2024-05-07 11:16:01', 'wspólna grupa na WhatsApp', '51.4047415643488', '21.1501523779366', 'shop', '2+'),
(116, '', '', 'Centrum Handlowe Korej', '', '', 1, 1, 5, 'Stanisława Wernera 10/B, Radom 26-600', '26-600', 'Radom', 'Stanisława Wernera', '10/B', '', 0, '2024-05-07 11:16:53', 'odżywki suplementy na siłownię itd', '51.4085510526178', '21.1462303151047', 'building', '20+'),
(117, '', '503081908', 'Beryl - Salon jubilerski', '', '', 1, 1, 5, 'Bolesława Chrobrego 22, Radom 26-609', '26-609', 'Radom', 'Bolesława Chrobrego', '22', '', 0, '2024-05-07 11:18:06', 'vege tylko', '51.4075883013002', '21.1587534169794', 'shop', '1+'),
(118, '', '501537594', 'Maggie\'s Butik', '', '', 1, 1, 5, 'Ignacego Daszyńskiego 3, Radom 26-605', '26-605', 'Radom', 'Ignacego Daszyńskiego', '3', '', 0, '2024-05-07 11:18:56', '', '51.4200708033512', '21.1655293825129', 'shop', '1+'),
(119, '', '722107160', 'RADENTAL Stomatologia, Medycyna Estetyczna, Kosmetologia', '', '', 1, 1, 5, 'Ignacego Daszyńskiego 3, Radom 26-600', '26-600', 'Radom', 'Ignacego Daszyńskiego', '3', '', 0, '2024-05-07 11:19:51', '', '51.4201228177432', '21.1658514863794', 'shop', '5+'),
(120, '', '721055055', 'HYUNDAI Radom - PRASEK Sp. z o.o. - Salon Serwis', '', '', 1, 1, 5, 'Kozienicka 1, Radom 26-600', '26-600', 'Radom', 'Kozienicka', '1', '', 0, '2024-05-07 11:21:01', 'wysyłam menu ale podjeżdżać', '51.4122777127730', '21.1886515328570', 'shop', '5+'),
(121, '', '732669327', 'PEUGEOT Radom - PRASEK Sp. z o.o. Salon i Serwis', '', '', 1, 1, 5, 'Kozienicka 1, Radom 26-600', '26-600', 'Radom', 'Kozienicka', '1', '', 0, '2024-05-07 11:28:36', 'podjezdzac', '51.4120690828787', '21.1886810779172', 'shop', '5+'),
(122, '', '508526594', 'Zakład fryzjerski Machnio Krzysztof', '', '', 1, 1, 5, 'Janusza Kusocińskiego 21, Radom 26-600', '26-600', 'Radom', 'Janusza Kusocińskiego', '21', '', 0, '2024-05-07 11:32:14', '', '51.4097756090086', '21.1638291531973', 'house', '1+'),
(123, '', '509532812', 'Mystic. Gabinet urody. Kosmetyka. Chmielnicka A.', '', '', 1, 1, 5, 'Janusza Kusocińskiego 23, Radom 26-615', '26-615', 'Radom', 'Janusza Kusocińskiego', '23', '', 0, '2024-05-07 11:33:55', '', '51.4099204370522', '21.1640633782907', 'house', '1+'),
(124, '', '512257620', 'Salon Fryzjerski Saloniq', '', '', 1, 1, 5, 'Rapackiego 13, Radom 26-605', '26-605', 'Radom', 'Rapackiego', '13', '', 0, '2024-05-07 11:35:05', 'Paznokcie', '51.4214747929870', '21.1714830814339', 'shop', '1+'),
(125, '', '795742413', 'BLASK I STYL - salon fryzjersko-kosmetyczny i solarium', '', '', 1, 1, 5, '11 Listopada 95B, Radom 26-605', '26-605', 'Radom', '11 Listopada', '95B', '', 0, '2024-05-07 11:36:01', '', '51.4113146695332', '21.1778701893620', 'shop', '1+'),
(126, '', '', 'Rewir Dzielnicowych Komisariatu Policji I KMP w Radomiu', '', '', 1, 1, 5, 'Mikołaja Reja 5, Radom 26-600', '26-600', 'Radom', 'Mikołaja Reja', '5', '', 0, '2024-05-07 11:36:48', '', '51.4031001036921', '21.1462125900829', 'building', '20+'),
(127, '', '601279044', 'Texman Radom', '', '', 1, 1, 5, '11 Listopada 85, Radom 26-600', '26-600', 'Radom', '11 Listopada', '85', '', 0, '2024-05-07 11:37:27', '', '51.4135563467625', '21.1730248084481', 'warehouse', '10+'),
(128, '', '', 'BHP-System. PW. Raszewska B.', '', '', 1, 1, 5, '11 Listopada 85, Radom 26-600', '26-600', 'Radom', '11 Listopada', '85', '', 0, '2024-05-07 11:38:13', '', '51.4135682038453', '21.1730187273984', 'shop', '5+'),
(129, '', '693560415', 'PRINT PARTNER FRYCZKOWSKI SP. J.', '', '', 1, 1, 5, '11 Listopada 85, Radom 26-600', '26-600', 'Radom', '11 Listopada', '85', '', 0, '2024-05-07 11:38:48', '', '51.4135615099161', '21.1730168994615', 'shop', '5+'),
(130, '', '', 'Salon fryzjerski KAMELEON', '', '', 1, 1, 5, 'Bolesława Chrobrego 30D, Radom 26-605', '26-605', 'Radom', 'Bolesława Chrobrego', '30D', '', 0, '2024-05-07 11:39:34', '', '51.4117516954610', '21.1603274881856', 'shop', '1+'),
(131, '', '572167636', 'Kancelaria Adwokacka Marcin Kaczmarek', '', '', 1, 1, 5, 'Janusza Kusocińskiego 1a, Radom 26-610', '26-610', 'Radom', 'Janusza Kusocińskiego', '1a', '', 0, '2024-05-07 11:40:24', '', '51.4116271774700', '21.1547682746537', 'building', '5+'),
(132, '', '508024167', 'Salon Luiza', '', '', 1, 1, 5, 'Janusza Kusocińskiego 1a, Radom 26-600', '26-600', 'Radom', 'Janusza Kusocińskiego', '1a', '', 0, '2024-05-07 11:41:49', '', '51.4116278572698', '21.1547685842593', 'shop', '1+'),
(133, '', '', 'Royal Dental Clinic lekarz dentysta Wojciech Żurek', '', '', 1, 1, 5, 'Janusza Kusocińskiego 1A/1, Radom 26-600', '26-600', 'Radom', 'Janusza Kusocińskiego', '1A/1', '', 0, '2024-05-07 11:42:35', '', '51.4116264964456', '21.1547676207141', 'shop', '5+'),
(134, '', '691099058', 'Pyrka-Med Rehabilitacja Sportowa Kamil Pyrka', '', '', 1, 1, 5, 'Janusza Kusocińskiego 1a, Radom 26-600', '26-600', 'Radom', 'Janusza Kusocińskiego', '1a', '', 0, '2024-05-07 11:43:11', '', '51.4116299680017', '21.1547702330509', 'shop', '1+'),
(135, '', '694960867', 'Moto Vibe Radom. Ośrodek szkolenia kierowców.', '', '', 1, 1, 5, 'Stanisława Wernera 9/11, Radom 26-600', '26-600', 'Radom', 'Stanisława Wernera', '9/11', '', 0, '2024-05-07 11:43:56', '', '51.4072970126511', '21.1471589151589', 'shop', '1+'),
(136, '', '608077733', 'Wielkodruk - agencja reklamowa', '', '', 1, 1, 5, 'Warszawska 14, Radom 26-617', '26-617', 'Radom', 'Warszawska', '14', '', 0, '2024-05-07 11:45:49', 'Marty punkt nie wiem wysyłam menu', '51.4149038608137', '21.1545726760347', 'shop', '1+'),
(137, '', '', 'SKP - Okręgowa Stacja Kontroli Pojazdów PUH CENTRUM Arkadiusz Gradowski', '', '', 1, 1, 5, 'Warszawska 35, Radom 26-600 ', '26-600', 'Radom', 'Warszawska', '35', '', 0, '2024-05-07 11:47:23', '', '51.4191651057427', '21.1507981537525', 'building', '5+'),
(138, '', '501379298', 'Studio Fryzjersko- Kosmetyczne Vena', '', '', 1, 1, 5, 'Rapackiego 12, Radom 26-605', '26-605', 'Radom', 'Rapackiego', '12', '', 0, '2024-05-07 11:48:10', '', '51.4213560049650', '21.1694526999428', 'shop', '1+'),
(139, '', '502241300', 'Dentamed. NZOZ. Dziedzic P.', '', '', 1, 1, 5, 'Ignacego Daszyńskiego 7, Radom 26-600', '26-600', 'Radom', 'Ignacego Daszyńskiego', '7', '', 0, '2024-05-07 11:49:31', 'jeździć bo pan jest niewidomy', '51.4204344736256', '21.1669218204692', 'house', '1+'),
(140, '', '536220120', 'NovaJa Salon Fryzjerski', '', '', 1, 1, 5, 'Stanisława Zbrowskiego 112, Radom 26-600', '26-600', 'Radom', 'Stanisława Zbrowskiego', '112', '', 0, '2024-05-07 11:50:31', 'menu wysyłać i zamówienia', '51.4157667852057', '21.1776303715112', 'shop', '1+'),
(141, '', '786170470', 'Barter Etiuda', '', '', 1, 1, 5, 'Stanisława Zbrowskiego 112, Radom 26-615', '26-615', 'Radom', 'Stanisława Zbrowskiego', '112', '', 0, '2024-05-07 11:51:13', 'menu wysyłać i zmaowienia', '51.4156666937009', '21.1777015960084', 'shop', '1+'),
(142, '', '604476430', 'Poradnia Rehabilitacji Synergia', '', '', 1, 1, 5, '11 Listopada 69/77, Radom 26-600', '26-600', 'Radom', '11 Listopada', '69/77', '', 0, '2024-05-07 11:52:51', 'podjeżdżać i menu wysyłać', '51.4127629654348', '21.1699969377246', 'shop', '5+'),
(143, '', '604246996', 'Salon fryzjersko-kosmetyczny KLEOPATRA', '', '', 1, 1, 5, 'Żwirki I Wigury 31, Radom 26-600', '26-600', 'Radom', 'Żwirki I Wigury', '31', '', 0, '2024-05-07 11:53:33', 'menu wysylac', '51.4144704100521', '21.1655087895011', 'shop', '1+'),
(144, '', '515282219', 'Mieszkanie', '', '', 1, 1, 5, 'Żwirki I Wigury 31, Radom 26-600', '26-600', 'Radom', 'Żwirki I Wigury', '31', '', 0, '2024-05-07 11:55:57', 'menu wysyłać', '51.4141760549199', '21.1657202654648', 'house', '1+'),
(145, '', '', 'Komenda Wojewódzka Policji zs. w Radomiu', '', '', 1, 1, 5, '11 Listopada 37/59, Radom 26-600', '26-600', 'Radom', '11 Listopada', '37/59', '', 0, '2024-05-07 11:56:50', 'mam prywatny numer i ja mogłam tam wjeżdżać i tylko na zamowienie', '51.4140875152141', '21.1630053218988', 'building', '50+'),
(146, '', '', 'Telbridge Sp. z o.o. Sp. k Oddział Radom', '', '', 1, 1, 5, 'Tarnobrzeska 8, Radom 26-615', '26-615', 'Radom', 'Tarnobrzeska', '8', '', 0, '2024-05-07 11:57:29', '', '51.4179794991866', '21.2032887980938', 'exclamation', '50+'),
(147, '', '791430530', 'Mieszkanie', '', '', 1, 1, 5, 'Rodziny Winczewskich 2, Radom 26-600', '26-600', 'Radom', 'Rodziny Winczewskich', '2', '', 0, '2024-05-07 11:58:08', '', '51.4095240566749', '21.1525534224598', 'house', '1+'),
(148, '', '606912915', 'Nagietek Sklep Zielarski', '', '', 1, 1, 5, 'Królowej Jadwigi 5a, Radom 26-600', '26-600', 'Radom', 'Królowej Jadwigi', '5a', '', 0, '2024-05-07 11:58:45', '', '51.4292597904650', '21.1600135696908', 'shop', '1+'),
(149, '', '790780028', 'Beauty Zone. Studio urody.', '', '', 1, 1, 5, 'Królowej Jadwigi 5a, Radom 26-617', '26-617', 'Radom', 'Królowej Jadwigi', '5a', '', 0, '2024-05-07 11:59:23', '', '51.4289821292518', '21.1598736918163', 'shop', '1+'),
(150, '', '505208521', 'BiuroCentrum Paweł Bator', '', '', 1, 1, 5, 'Janusza Kusocińskiego 23, Radom 26-600', '26-600', 'Radom', 'Janusza Kusocińskiego', '23', '', 0, '2024-05-07 12:00:18', '', '51.4098033142786', '21.1645492826926', 'shop', '1+'),
(151, '', '508343142', 'Dom', '', '', 1, 1, 5, 'Radosna 6, Radom 26-610', '26-610', 'Radom', 'Radosna', '6', '', 0, '2024-05-07 12:06:09', '', '51.4154491165827', '21.1505883587273', 'house', '1+'),
(152, '', '660483359', 'Wojewódzki Urząd Pracy w Warszawie. Filia Radom', 'Aneta', '', 1, 1, 6, 'Mokra 2, Radom 26-600 ', '26-600', 'Radom', 'Mokra', '2', '', 0, '2024-05-07 12:07:25', 'zamówienie', '51.4119596045907', '21.1411288179899', 'building', '10+'),
(153, '', '607106610', 'KAST - Hurtownia Szkła. Producent Luster. Szklarz', 'Justyna', '', 1, 1, 6, 'Juranda 17, Radom 26-600', '26-600', 'Radom', 'Juranda', '17', '', 0, '2024-05-07 12:08:22', 'zamówienie, dobrze podjechać', '51.4495766675598', '21.1396750906441', 'warehouse', '10+'),
(154, '', '661820394', 'Choroś Clinic - Makijaż permanentny, medycyna estetyczna, zabiegi na ciało', '', '', 1, 1, 6, 'Wiktora Gomulickiego 2, Radom 26-600', '26-600', 'Radom', 'Wiktora Gomulickiego', '2', '', 0, '2024-05-07 12:09:07', 'zamówienie, max do 11.30', '51.4104762526733', '21.1453061468391', 'shop', '1+'),
(155, '', '605571295', 'Gabinet Weterynaryjny Zielony Szpitalik', '', '', 1, 1, 6, 'Rodziny Winczewskich 18, Radom 26-610', '26-610', 'Radom', 'Rodziny Winczewskich', '18', '', 0, '2024-05-07 12:10:18', 'zamówienie', '51.4102364538438', '21.1449664388669', 'shop', '5+'),
(156, '', '', 'Radomskie Centrum Onkologii', '', '', 1, 1, 6, 'Uniwersytecka 6a, Radom 26-600', '26-600', 'Radom', 'Uniwersytecka', '6a', '', 0, '2024-05-07 12:11:09', '', '51.4128708222552', '21.1111535311740', 'exclamation', '20+'),
(157, '', '', 'Dealer BMW ZK Motors Radom', '', '', 1, 1, 6, 'Warszawska 234, Radom 26-617', '26-617', 'Radom', 'Warszawska', '234', '', 0, '2024-05-07 12:11:45', '', '51.4542385429260', '21.1421790115882', 'shop', '5+'),
(158, '', '', 'Rad Motors - Autoryzowany Dealer Ford', '', '', 1, 1, 6, 'Władysława Orkana 1, Radom 26-600', '26-600', 'Radom', 'Władysława Orkana', '1', '', 0, '2024-05-07 12:12:13', '', '51.4584885115659', '21.1396879594660', 'shop', '5+'),
(159, '', '', 'P.U.H. Rad-Mot. Części do aut dostawczych oraz osobowych Rejowski Radosław', '', '', 1, 1, 6, 'Władysława Orkana 2, Wielogóra 26-660', '26-660', 'Wielogóra', 'Władysława Orkana', '2', '', 0, '2024-05-07 12:12:50', '', '51.4593686566128', '21.1393520999450', 'shop', '5+'),
(160, '', '', 'InterCars S.A. - części do samochodów ciężarowych', '', '', 1, 1, 6, 'Kielecka 48/50, Radom 26-612', '26-612', 'Radom', 'Kielecka', '48/50', '', 0, '2024-05-07 12:13:26', '', '51.4022569237738', '21.1149500243956', 'shop', '5+'),
(161, '', '', 'Auto komis', '', '', 1, 1, 6, 'Warszawska 147, Radom 26-600', '26-600', 'Radom', 'Warszawska', '147', '', 0, '2024-05-07 12:14:16', '', '51.4392938883476', '21.1458459747468', 'shop', '5+'),
(162, '', '', 'Państwowa Inspekcja Pracy. Okręgowy Inspektorat Pracy', '', '', 1, 1, 6, 'Władysława Beliny-Prażmowskiego 15, Radom 26-610', '26-610', 'Radom', 'Władysława Beliny-Prażmowskiego', '15', '', 0, '2024-05-07 12:14:53', '', '51.3929193094662', '21.1568371461065', 'exclamation', '20+'),
(163, '', '', 'Distribev Sp. z o.o. Oddział Radom', '', '', 1, 1, 6, 'Wincentego Witosa 10, Radom 26-617', '26-617', 'Radom', 'Wincentego Witosa', '10', '', 0, '2024-05-07 12:15:28', '', '51.4526130002040', '21.1449082115881', 'building', '10+'),
(164, '', '', 'Starostwo Powiatowe w Radomiu', '', '', 1, 1, 6, 'Tadeusza Mazowieckiego 7, Radom 26-600', '26-600', 'Radom', 'Tadeusza Mazowieckiego', '7', '', 0, '2024-05-07 12:16:00', '', '51.3911373726000', '21.1609660436878', 'exclamation', '20+'),
(165, '', '', 'Powiatowy Urząd Pracy w Radomiu', '', '', 1, 1, 6, 'Księdza Andrzeja Łukasika 3, Radom 26-612', '26-612', 'Radom', 'Księdza Andrzeja Łukasika', '3', '', 0, '2024-05-07 12:16:30', '', '51.3877946812127', '21.1308148269282', 'exclamation', '20+'),
(166, '', '', 'Przychodnia Weterynaryjna Pankracy', '', '', 1, 1, 6, 'Mączna 1, Radom 26-612', '26-612', 'Radom', 'Mączna', '1', '', 0, '2024-05-07 12:17:06', '', '51.3925711609670', '21.1220613404214', 'exclamation', '10+'),
(167, '', '', 'Mechanik', '', '', 1, 1, 6, 'Wieżowa , Radom 26-600', '26-600', 'Radom', 'Wieżowa', '', '', 0, '2024-05-07 12:18:36', '', '51.4137092084214', '21.1189978981386', 'shop', '1+'),
(168, '', '', 'Centrum Piękna Monika Rejczak', '', '', 1, 1, 6, 'Generała Leopolda Okulickiego 58/70, Radom 26-600', '26-600', 'Radom', 'Generała Leopolda Okulickiego', '58/70', '', 0, '2024-05-07 12:19:12', '', '51.4062432956094', '21.1288448781367', 'shop', '1+'),
(169, '', '', 'Kaja. Salon kosmetyki i makijażu. Bukowska S.', '', '', 1, 1, 6, 'Generała Leopolda Okulickiego 58/70, Radom 26-610', '26-610', 'Radom', 'Generała Leopolda Okulickiego', '58/70', '', 0, '2024-05-07 12:20:52', '', '51.4062523604101', '21.1288039311469', 'shop', '1+'),
(170, '', '', 'MEDISTAR Sklep Medyczny', '', '', 1, 1, 6, 'Generała Leopolda Okulickiego 58/70, Radom 26-600', '26-600', 'Radom', 'Generała Leopolda Okulickiego', '58/70', '', 0, '2024-05-07 12:21:40', '', '51.4063388906716', '21.1283564506947', 'shop', '1+'),
(171, '', '', 'MebloSfera', '', '', 1, 1, 6, 'Warszawska 197, Radom 26-617', '26-617', 'Radom', 'Warszawska', '197', '', 0, '2024-05-07 12:22:17', '', '51.4484348125704', '21.1427538980950', 'shop', '5+'),
(172, '', '', 'Ceramika Primus Sp. z o.o.', '', '', 1, 1, 6, 'Warszawska 209/213, Radom 26-600', '26-600', 'Radom', 'Warszawska', '209/213', '', 0, '2024-05-07 12:22:56', '', '51.4498773304049', '21.1423366404237', 'shop', '5+'),
(173, '', '', 'DEMOPROJEKT RADOM - Podłogi Drewniane i Winylowe, Parkiety, Panele, Drzwi, Schody', '', '', 1, 1, 6, 'Warszawska 197, Radom 26-600', '26-600', 'Radom', 'Warszawska', '197', '', 0, '2024-05-07 12:23:25', '', '51.4484749310207', '21.1427860846020', 'shop', '5+'),
(174, '', '', 'RTBS Administrator Sp. z o.o.', '', '', 1, 1, 6, 'Ludwika Waryńskiego 16a, Radom 26-610', '26-610', 'Radom', 'Ludwika Waryńskiego', '16a', '', 0, '2024-05-07 12:24:03', '', '51.3947328359434', '21.1587359377950', 'exclamation', '10+'),
(175, '', '', 'Sklep PIMOtki', '', '', 1, 1, 6, 'Warszawska 183, Radom 26-600', '26-600', 'Radom', 'Warszawska', '183', '', 0, '2024-05-07 12:24:34', '', '51.4465091250340', '21.1435726269306', 'shop', '1+'),
(176, '', '', 'OHP', '', '', 1, 1, 6, 'Józefa Ignacego Kraszewskiego 1/7, Radom 26-639', '26-639', 'Radom', 'Józefa Ignacego Kraszewskiego', '1/7', '', 0, '2024-05-07 12:25:11', '', '51.4100573564130', '21.1398665779303', 'exclamation', '20+'),
(177, '', '', 'Mazowiecka Klinika Psychoterapii i Psychiatrii', '', '', 1, 1, 6, 'Zielona 48, Radom 26-610', '26-610', 'Radom', 'Zielona', '48', '', 0, '2024-05-07 12:25:46', '', '51.4118140800194', '21.1276183269292', 'building', '10+'),
(178, '', '', 'BORUCH DETAILING STUDIO', '', '', 1, 1, 6, 'Aleksego Grobickiego 18, Radom 26-600', '26-600', 'Radom', 'Aleksego Grobickiego', '18', '', 0, '2024-05-07 12:26:18', '', '51.4542264573650', '21.1392227846022', 'shop', '5+'),
(179, '', '', 'IMPERO OUTLET - płytki i łazienki', '', '', 1, 1, 6, 'Warszawska 193, Radom 26-600', '26-600', 'Radom', 'Warszawska', '193', '', 0, '2024-05-07 12:27:05', '', '51.4481433392531', '21.1424563748597', 'warehouse', '10+'),
(180, '', '', 'Gajda Truck Center Sp. z o.o.', '', '', 1, 1, 6, 'Warszawska 1, Wsola 26-660', '26-660', 'Wsola', 'Warszawska', '1', '', 0, '2024-05-07 12:27:38', '', '51.4759521773049', '21.1289245306310', 'warehouse', '10+'),
(181, '', '', 'Lofthouse', '', '', 1, 1, 6, 'Graniczna 17, Radom 26-604', '26-604', 'Radom', 'Graniczna', '17', '', 0, '2024-05-07 12:28:17', '', '51.3906062769111', '21.1636092115856', 'exclamation', '20+'),
(182, '', '694312272', 'Miejski Ośrodek Pomocy Społecznej. Zespół Pracy Socjalnej nr 8', 'Kamila', '', 1, 1, 6, 'Główna 10, Radom 26-601', '26-601', 'Radom', 'Główna', '10', '', 0, '2024-05-07 12:37:48', 'dojazd + zamówienie', '51.4050341554035', '21.1292410081991', 'building', '10+'),
(183, '', '602539543', 'Klinika Euromed', '', '', 1, 1, 6, 'Sebastiana Klonowica 8/1, Radom 26-601', '26-601', 'Radom', 'Sebastiana Klonowica', '8/1', '', 0, '2024-05-07 12:38:50', 'zamówienie', '51.4051690788543', '21.1284205418161', 'shop', '5+'),
(184, '', '', 'Spółka Lekarska Zamłynie', '', '', 1, 1, 6, 'Sebastiana Klonowica 10/12, Radom 26-600', '26-600', 'Radom', 'Sebastiana Klonowica', '10/12', '', 0, '2024-05-07 12:39:51', 'grupa; zamówienie', '51.4054228538863', '21.1279364994614', 'shop', '5+'),
(185, '', '', 'Mikirad sklep medyczny', '', '', 1, 1, 6, 'Generała Leopolda Okulickiego 59, Radom 26-600', '26-600', 'Radom', 'Generała Leopolda Okulickiego', '59', '', 0, '2024-05-07 12:40:48', 'podjechać', '51.4058788873497', '21.1284255366081', 'shop', '5+'),
(186, '', '539238234', 'epaka.pl - punkt nadań i odbioru przesyłek', '', '', 1, 1, 6, 'Mikołaja Reja 24, Radom 26-600', '26-600', 'Radom', 'Mikołaja Reja', '24', '', 0, '2024-05-07 12:41:34', 'zamówienie', '51.4045634053723', '21.1423794534309', 'shop', '5+'),
(187, 'yellowgarage@wp.pl', '', 'PPUH Yellow Garage', '', '', 1, 1, 6, 'Janiszewska 20, Radom 26-617', '26-617', 'Radom', 'Janiszewska', '20', '', 0, '2024-05-07 12:42:17', 'zmiana adresu', '51.4330927491140', '21.1448031269300', 'shop', '5+'),
(188, '', '513138310', 'Apteka Gemini', '', '', 1, 1, 6, 'Główna 12, Radom 26-600', '26-600', 'Radom', 'Główna', '12', '', 0, '2024-05-07 12:43:01', '12:00 przerwa', '51.4049977717416', '21.1278353946567', 'shop', '5+'),
(189, '', '729964764', 'PPL Poradnie Specjalistyczne MAGMED', '', '', 1, 1, 6, 'Główna 12, Radom 26-600', '26-600', 'Radom', 'Główna', '12', '', 0, '2024-05-07 12:43:49', '12:30-13:00', '51.4049724469564', '21.1276228288607', 'shop', '5+'),
(190, '', '536454123', 'Agencja nieruchomości homfi - oddział Radom', '', '', 1, 1, 6, 'Generała Leopolda Okulickiego 90, Radom 26-600', '26-600', 'Radom', 'Generała Leopolda Okulickiego', '90', '', 0, '2024-05-07 12:44:28', 'dojazd', '51.4068916642843', '21.1250903980934', 'building', '5+'),
(191, '', '607954084', 'Art.B.Logistic Sp. z o.o.', '', '', 1, 1, 6, 'Główna 9, Radom 26-601', '26-601', 'Radom', 'Główna', '9', '', 0, '2024-05-07 12:45:10', 'dojazd( z tyłu budynku)', '51.4047322333876', '21.1298369115862', 'building', '10+'),
(192, '', '782708883', 'Al.Capone', '', '', 1, 1, 6, 'Główna 9, Radom 26-601', '26-601', 'Radom', 'Główna', '9', '', 0, '2024-05-07 12:45:57', '782708883, 574523479; dojazd', '51.4047801494364', '21.1298886204924', 'building', '5+'),
(193, '', '575215289', 'Alibi', '', '', 1, 1, 6, 'Główna 9, Radom 26-601', '26-601', 'Radom', 'Główna', '9', '', 0, '2024-05-07 12:46:55', '575215289, 519476337; dojazd', '51.4047386487952', '21.1298704093586', 'building', '1+'),
(194, '', '517487759', 'Nina psi fryzjer', '', '', 1, 1, 6, 'Główna 5, Radom 26-600', '26-600', 'Radom', 'Główna', '5', '', 0, '2024-05-07 12:47:29', 'zamówienie', '51.4050622170314', '21.1301807423472', 'shop', '1+'),
(195, '', '572602882', 'Podolog Radom', '', '', 1, 1, 6, 'Główna 11, Radom 26-610', '26-610', 'Radom', 'Główna', '11', '', 0, '2024-05-07 12:48:24', '572602882, 722332825; dojazd', '51.4047473766943', '21.1292844871029', 'building', '5+'),
(196, '', '604313151', 'Ewar-med', '', '', 1, 1, 6, 'Główna 9, Radom 26-601', '26-601', 'Radom', 'Główna', '9', '', 0, '2024-05-07 12:49:25', '604313151, 606814053; dojazd', '51.4047368019318', '21.1298693435545', 'building', '1+');
INSERT INTO `companies` (`id`, `email`, `phone_number`, `full_name`, `contact_first_name`, `contact_last_name`, `city_id`, `active`, `guardian`, `address`, `postal_code`, `city`, `street`, `street_number`, `nip`, `company_type`, `date`, `description`, `latitude`, `longitude`, `c_type`, `workers`) VALUES
(197, '', '729847096', 'GYM', '', '', 1, 1, 6, 'Główna 9, Radom 26-601', '26-601', 'Radom', 'Główna', '9', '', 0, '2024-05-07 12:50:04', 'zamówienie+dojazd', '51.404740059093', '21.1298676735856', 'building', '1+'),
(198, '', '507213958', 'Glow', '', '', 1, 1, 6, 'Główna 11, Radom 26-600', '26-600', 'Radom', 'Główna', '11', '', 0, '2024-05-07 12:50:53', 'dojazd', '51.4047469250351', '21.1292784998439', 'building', '1+'),
(199, '', '728884400', 'Maro-Dent s.c. Laboratorium protetyki dentystycznej. Kobyłka I.R.', '', '', 1, 1, 6, 'Kołodziejska 8, Radom 26-601', '26-601', 'Radom', 'Kołodziejska', '8', '', 0, '2024-05-07 12:51:37', '728884400, 601251044 zamówienie', '51.4070609448610', '21.1291916998796', 'shop', '5+'),
(200, '', '505914232', 'Auto Myjnia Ręczna Wulkanizacja DG-System', '', '', 1, 1, 6, 'Dobra 21/25, Radom 26-600', '26-600', 'Radom', 'Dobra', '21/25', '', 0, '2024-05-07 12:52:31', 'zamówienie + dojazd', '51.4151210641939', '21.1548296586363', 'shop', '1+'),
(201, '', '502640266', 'JACKPOL PRZEDSIĘBIORSTWO HANDLOWE', '', '', 1, 1, 6, 'Zielona 8, Radom 26-600', '26-600', 'Radom', 'Zielona', '8', '', 0, '2024-05-07 12:55:06', 'zamówienie', '51.4070875013403', '21.1292641472925', 'shop', '1+'),
(202, '', '607381841', 'IRIS', '', '', 1, 1, 6, 'Krucza 3, Radom 26-610', '26-610', 'Radom', 'Krucza', '3', '', 0, '2024-05-07 12:55:46', 'zamówienie', '51.4028820481042', '21.1224556142907', 'house', '1+'),
(203, '', '', 'Kosmetyka', '', '', 1, 1, 6, 'Krucza 13, Radom 26-610', '26-610', 'Radom', 'Krucza', '13', '', 0, '2024-05-07 12:57:32', 'podjechać', '51.4019401802131', '21.1218718377556', 'shop', '1+'),
(204, '', '', 'CRL Sp. z o.o.', '', '', 1, 1, 6, 'Racławicka 8/10, Radom 26-600', '26-600', 'Radom', 'Racławicka', '8/10', '', 0, '2024-05-07 12:58:46', 'podjechać', '51.4014890571265', '21.1222897036630', 'building', '10+'),
(205, '', '509671961', 'Fizjopractic', '', '', 1, 1, 6, 'Szeroka 6, Radom 26-601', '26-601', 'Radom', 'Szeroka', '6', '', 0, '2024-05-07 13:01:02', 'zamówienie', '51.4047384143853', '21.1209075423286', 'house', '1+'),
(206, '', '667639313', 'ART-TOM zakuwanie przewodow hydraulicznych, remonty siłowników, serwis mobilny', '', '', 1, 1, 6, 'Kielecka 11, Radom 26-610', '26-610', 'Radom', 'Kielecka', '11', '', 0, '2024-05-07 13:01:54', 'podjechać', '51.4048273469745', '21.1208387157203', 'shop', '5+'),
(207, '', '606399645', 'AUTO NAPRAWA BIENIEK', '', '', 1, 1, 6, 'Wolanowska 158, Radom 26-600', '26-600', 'Radom', 'Wolanowska', '158', '', 0, '2024-05-07 13:02:36', 'podjechać', '51.4000593782965', '21.0809709980931', 'shop', '1+'),
(208, '', '604868998', 'AUTO-MAX-NESKA Stacja demontażu pojazdów', '', '', 1, 1, 6, 'Wolanowska 140, Radom 26-600', '26-600', 'Radom', 'Wolanowska', '140', '', 0, '2024-05-07 13:03:15', 'podjechać', '51.4010180983859', '21.0838389846001', 'shop', '1+'),
(209, '', '507064346', 'Dachy REGAMET', '', '', 1, 1, 6, 'Wolanowska 146, Radom 26-600', '26-600', 'Radom', 'Wolanowska', '146', '', 0, '2024-05-07 13:03:54', 'podjechać', '51.4006874625360', '21.0830619111440', 'shop', '1+'),
(210, '', '531844077', 'Kratki - produkcja', '', '', 1, 1, 6, 'Warszawska 120, Wsola 26-660', '26-660', 'Wsola', 'Warszawska', '120', '', 0, '2024-05-07 13:05:19', 'ok 8:30, menu na nr tel', '51.4949558401436', '21.1201540370545', 'warehouse', '20+'),
(211, '', '600005010', 'Kratki Hala A - magazyn', '', '', 1, 1, 6, 'Leśna 103, Wsola 26-660', '26-660', 'Wsola', 'Leśna', '103', '', 0, '2024-05-07 13:06:30', 'ok 9:00, menu na nr tel', '51.4944297579723', '21.1449446777223', 'warehouse', '20+'),
(212, '', '', 'Kratki.pl Marek Bal - Salon', '', '', 1, 1, 6, 'Warszawska 66, Wsola 26-660', '26-660', 'Wsola', 'Warszawska', '66', '', 0, '2024-05-07 13:07:33', 'grupa WhatsApp; ok 9:00, menu na grupie', '51.4826605042430', '21.1265461503044', 'building', '20+'),
(213, '', '508441818', 'Salon kosmetyczny', '', '', 1, 1, 6, 'Rynek 7, Jedlińsk 26-660', '26-660', 'Jedlińsk', 'Rynek', '7', '', 0, '2024-05-07 13:08:23', '508441818, 515879846; jeździliśmy tylko na zamówienie', '51.5118706148056', '21.1199661769725', 'shop', '2+'),
(214, '', '', 'Kontenery', '', '', 1, 1, 6, 'Mokra , Radom 26-600', '26-600', 'Radom', 'Mokra', '', '', 0, '2024-05-07 13:09:48', 'moi znajomi bliscy numery mam prywatne', '51.4120437538356', '21.1387719022759', 'house', '1+'),
(215, '', '608107210', 'Salon Aut Sport Cars', '', '', 1, 1, 6, 'Kielecka 16, Radom 26-612', '26-612', 'Radom', 'Kielecka', '16', '', 0, '2024-05-07 13:10:49', '608107210, 605302198; po Marcie punkt wysyłam menu', '51.4053143487958', '21.1198632178810', 'shop', '5+'),
(216, '', '', 'Miła Clinic - Gabinet Dentystyczny', '', '', 1, 1, 6, 'Miła 17, Radom 26-600', '26-600', 'Radom', 'Miła', '17', '', 0, '2024-05-07 13:11:24', '', '51.4073310192462', '21.1595121697975', 'exclamation', '5+'),
(217, '', '', 'PreZero Service Wschód sp. z o.o. - oddział Radom', '', '', 1, 1, 6, 'Energetyków 16, Radom 26-600', '26-600', 'Radom', 'Energetyków', '16', '', 0, '2024-05-07 13:12:00', '', '51.4416816843986', '21.1951096539163', 'exclamation', '5+'),
(218, '', '', 'Apteka Gemini', '', '', 1, 1, 6, 'Królowej Jadwigi 13, Radom 26-617', '26-617', 'Radom', 'Królowej Jadwigi', '13', '', 0, '2024-05-07 13:12:36', '', '51.429460612458', '21.1583761611457', 'exclamation', '5+'),
(219, '', '604852696', 'Biuro', '', '', 1, 1, 6, 'Ofiar Firleja 7/5, Radom 26-617', '26-617', 'Radom', 'Ofiar Firleja', '7/5', '', 0, '2024-05-07 13:13:24', 'podjechać', '51.4439573591666', '21.1478393105281', 'building', '10+'),
(220, '', '', 'Studio Fryzur Dorota Monika Pysiak', '', '', 1, 1, 6, 'Królowej Jadwigi 21/1B1, Radom 26-600', '26-600', 'Radom', 'Królowej Jadwigi', '21/1B1', '', 0, '2024-05-07 13:14:17', '', '51.4301671043848', '21.1540665310048', 'exclamation', '5+'),
(221, '', '508714518', 'Neria Kwiaty', '', '', 1, 1, 7, 'Bolesława Limanowskiego 63, Radom 26-616', '26-616', 'Radom', 'Bolesława Limanowskiego', '63', '', 0, '2024-05-07 13:17:18', 'zamówienie, zawsze z rana po 9', '51.3890019815664', '21.1279384980926', 'shop', '1+'),
(222, '', '607993851', 'Wojewódzki Ośrodek Ruchu Drogowego w Radomiu', '', '', 1, 1, 7, 'Sucha 13, Radom 26-600', '26-600', 'Radom', 'Sucha', '13', '', 0, '2024-05-07 13:18:06', '607993851, 669982117; zamówienie, max do 11:30', '51.3850629890436', '21.1221273980925', 'building', '10+'),
(223, '', '', 'Firma telemarketingowa', '', '', 1, 1, 7, 'Bolesława Limanowskiego 98, Radom 26-610', '26-610', 'Radom', 'Bolesława Limanowskiego', '98', '', 0, '2024-05-07 13:19:27', 'grupa na Messengerze; na 12 punktualnie, przerwa', '51.3885805592608', '21.1267189655409', 'building', '20+'),
(224, '', '883027717', 'Irina', '', '', 1, 1, 7, 'Maratońska 3, Radom 26-600', '26-600', 'Radom', 'Maratońska', '3', '', 0, '2024-05-07 13:20:15', 'podejść', '51.3905378766779', '21.1271836410033', 'shop', '1+'),
(225, '', '570955517', 'Salon fryzur Anna Froń', '', '', 1, 1, 7, 'Maratońska 3, Radom 26-600', '26-600', 'Radom', 'Maratońska', '3', '', 0, '2024-05-07 13:20:49', 'czasem zamówienie, zawsze podjechać', '51.3905391708925', '21.1271806684408', 'shop', '1+'),
(226, '', '698205806', 'Studio Urody Glamur', '', '', 1, 1, 7, 'Maratońska 3, Radom 26-600', '26-600', 'Radom', 'Maratońska', '3', '', 0, '2024-05-07 13:21:40', 'codziennie podjechać', '51.3905521794826', '21.1271780625891', 'shop', '1+'),
(227, '', '', 'Stowarzyszenie Pomocy Osobom Niepełnosprawnym Przyjaźni', '', '', 1, 1, 7, 'Maratońska 3, Radom 26-600', '26-600', 'Radom', 'Maratońska', '3', '', 0, '2024-05-07 13:22:18', 'podjechać max do 12.30', '51.3899179617430', '21.1265971404213', 'shop', '5+'),
(228, '', '505664796', 'Apteka Centrum Zdrowia', '', '', 1, 1, 7, 'Lekarska 2A, Radom 26-600', '26-600', 'Radom', 'Lekarska', '2A', '', 0, '2024-05-07 13:22:57', 'zamówienie', '51.4009055916860', '21.1455270269288', 'shop', '5+'),
(229, '', '600237007', 'Protor-Merkury', '', '', 1, 1, 7, 'Tartaczna 3c, Radom 26-600', '26-600', 'Radom', 'Tartaczna', '3c', '', 0, '2024-05-07 13:23:41', '600237007, 731284252; zamówienie', '51.3854677761581', '21.1418007557638', 'shop', '1+'),
(230, '', '794207095', 'Tekstylowo Sklep z odzieżą używaną', '', '', 1, 1, 7, 'Bolesława Limanowskiego 100, Radom 26-616', '26-616', 'Radom', 'Bolesława Limanowskiego', '100', '', 0, '2024-05-07 13:24:20', 'tylko czwartek i piątek, podejść po callcenter', '51.3882792765700', '21.1266649557639', 'shop', '1+'),
(231, '', '510515093', 'Gabinet Kosmetyczny Dom Urody', '', '', 1, 1, 7, 'Sucha 2/lok. 16, Radom 26-612', '26-612', 'Radom', 'Sucha', '2/lok. 16', '', 0, '2024-05-07 13:24:57', 'codziennie podjechać', '51.3861086985967', '21.1236937404211', 'shop', '5+'),
(232, '', '501868848', 'EM Studio', '', '', 1, 1, 7, 'Sucha 2/14, Radom 26-612', '26-612', 'Radom', 'Sucha', '2/14', '', 0, '2024-05-07 13:25:51', 'czasem zamówienie, codziennie podjechać', '51.3861879246306', '21.1236631876748', 'shop', '1+'),
(233, '', '', 'Salon fryzjerski Justyna', '', '', 1, 1, 7, 'Sucha 2, Radom 26-612', '26-612', 'Radom', 'Sucha', '2', '', 0, '2024-05-07 13:26:28', '', '51.3861335516324', '21.1237383124096', 'building', '1+'),
(234, '', '660447494', 'Radomski Szpital Specjalistyczny im. dr. Tytusa Chałubińskiego. Poradnia Alergologiczna', '', '', 1, 1, 7, 'Lekarska 4, Radom 26-610', '26-610', 'Radom', 'Lekarska', '4', '', 0, '2024-05-07 13:27:10', 'zamówienie', '51.4005613071720', '21.1453212493888', 'building', '10+'),
(235, '', '732626600', 'NZOZ Borki', '', '', 1, 1, 7, 'Harcmistrza Kapitana Eugeniusza Stasieckiego 1, Radom 26-612', '26-612', 'Radom', 'Harcmistrza Kapitana Eugeniusza Stasieckiego', '1', '', 0, '2024-05-07 13:27:56', 'zamówienie + podjechać codziennie max do 13', '51.3877782623688', '21.1256450422709', 'building', '10+'),
(236, '', '663245480', 'Manicure hybrydowy Impresja', '', '', 1, 1, 7, 'Maratońska 3, Radom 26-600', '26-600', 'Radom', 'Maratońska', '3', '', 0, '2024-05-07 13:29:04', 'zamówienie', '51.3905239135757', '21.1271684888182', 'shop', '1+'),
(237, '', '574389405', 'Pracownia krawiecka U Ani', '', '', 1, 1, 7, 'Maratońska 3, Radom 26-600', '26-600', 'Radom', 'Maratońska', '3', '', 0, '2024-05-07 13:29:43', 'codziennie podjechać', '51.3905373033506', '21.1271899464895', 'shop', '1+'),
(238, '', '517259215', 'Sklep kosmetyczny', '', '', 1, 1, 7, 'Sucha 2, Radom 26-612', '26-612', 'Radom', 'Sucha', '2', '', 0, '2024-05-07 13:32:40', '517259215, 881910181; codziennie podjechać', '51.3861687388502', '21.1236797450520', 'shop', '1+'),
(239, '', '506926023', 'Muzeum Wsi Radomskiej w Radomiu', 'Magda', '', 1, 1, 7, 'Szydłowiecka 30, Radom 26-616', '26-616', 'Radom', 'Szydłowiecka', '30', '', 0, '2024-05-07 13:33:50', 'kontakt na WhatsApp, zamówienie + często coś dobierają', '51.3613510865685', '21.0805188423973', 'building', '10+'),
(240, '', '519626519', 'Maxim Agencja Ubezpieczeń Jacek Piątek', '', '', 1, 1, 7, 'Wierzbicka 2a, Radom 26-600', '26-600', 'Radom', 'Wierzbicka', '2a', '', 0, '2024-05-07 13:34:30', 'zamówienie', '51.3888747912755', '21.1279914827500', 'shop', '1+'),
(241, '', '723669796', 'Apteka NOVA', '', '', 1, 1, 7, 'Bolesława Limanowskiego 98, Radom 26-610', '26-610', 'Radom', 'Bolesława Limanowskiego', '98', '', 0, '2024-05-07 13:35:04', 'zamówienie', '51.3887413863432', '21.1269463557640', 'shop', '5+'),
(242, 'dk.borki@op.pl', '', 'Dom Kultury Borki', '', '', 1, 1, 7, 'Sucha 2, Radom 26-612', '26-612', 'Radom', 'Sucha', '2', '', 0, '2024-05-07 13:35:46', 'zamówienie', '51.3863586040032', '21.1235688588515', 'building', '10+'),
(243, '', '698920306', 'Przychodnia Weterynaryjna Wojciech Ciszewski', '', '', 1, 1, 7, 'Sucha 2, Radom 26-600', '26-600', 'Radom', 'Sucha', '2', '', 0, '2024-05-07 13:36:23', 'podejść', '51.3861355055144', '21.1237083727722', 'shop', '1+'),
(244, '', '506276823', 'BIBLIOTEKA BORKI', '', '', 1, 1, 7, 'Sucha 2, Radom 26-600', '26-600', 'Radom', 'Sucha', '2', '', 0, '2024-05-07 13:37:07', 'czasem zamówienie, codziennie podjechać', '51.3860406018595', '21.1236662706256', 'building', '5+'),
(245, '', '512271600', 'Stolrad Sp. z o.o.', '', '', 1, 1, 7, 'Sadownicza 4, Radom 26-615 ', '26-615', 'Radom', 'Sadownicza', '4', '', 0, '2024-05-07 13:37:39', 'zamówienie', '51.3801265753755', '21.0809268980923', 'building', '10+'),
(246, '', '666466562', 'Galabeton', '', '', 1, 1, 7, 'Hodowlana 2a, Radom 26-601', '26-601', 'Radom', 'Hodowlana', '2a', '', 0, '2024-05-07 13:38:18', 'zamówienie, czasem biorą coś więcej', '51.3811846205538', '21.0824025115853', 'building', '10+'),
(247, '', '696182522', 'Salon fryzjerski Kinga Makowska', '', '', 1, 1, 7, 'Wierzbicka 1, Radom 26-612', '26-612', 'Radom', 'Wierzbicka', '1', '', 0, '2024-05-07 13:39:30', 'zamówienie', '51.3887681979673', '21.1287450144438', 'shop', '1+'),
(248, '', '534160282', 'Nitex sp.j. Hurtownia dodatków szewskich i krawieckich', '', '', 1, 1, 7, 'Marywilska 4D, Radom 26-612 ', '26-612', 'Radom', 'Marywilska', '4D', '', 0, '2024-05-07 13:40:20', 'podjechać, nowy', '51.3903445869818', '21.1405959229571', 'shop', '10+'),
(249, 'rejestracja@bat-med.pl', '', 'Klinika Bat-Med', '', '', 1, 1, 7, 'księdza profesora W. Sedlaka 4/6/8, Radom 26-600', '26-600', 'Radom', 'księdza profesora W. Sedlaka', '4/6/8', '', 0, '2024-05-07 13:41:10', 'podjechać, nowy', '51.3972174778799', '21.1423868557642', 'building', '10+'),
(250, '', '509838221', '\"Eva\" Studio Kosmetyczne Ewa Krawczyk', '', '', 1, 1, 7, '1905 Roku 19a, Radom 26-600', '26-600', 'Radom', '1905 Roku', '19a', '', 0, '2024-05-07 13:42:29', 'zamówienie', '51.3906231871696', '21.1398450980927', 'shop', '1+'),
(251, '', '503520544', 'Salon mody męskiej', '', '', 1, 1, 7, '1905 Roku 15, Radom 26-612', '26-612', 'Radom', '1905 Roku', '15', '', 0, '2024-05-07 13:44:14', 'zamówienie', '51.3916197860789', '21.1438239399973', 'shop', '1+'),
(252, '', '', 'MB Radom Sp. z o.o.', '', '', 1, 1, 7, 'Garbarska 79, Radom 26-610', '26-610', 'Radom', 'Garbarska', '79', '', 0, '2024-05-07 13:45:00', '10:00-10:30', '51.3989044464450', '21.1191149269287', 'shop', '5+'),
(253, '', '', 'Greg-Fin. Biuro rachunkowe. Gregorek M.', '', '', 1, 1, 7, 'Wierzbicka 26/44, Radom 26-600', '26-600', 'Radom', 'Wierzbicka', '26/44', '', 0, '2024-05-07 13:45:47', 'dojazd 9:00', '51.3821826558934', '21.1292373718008', 'building', '5+'),
(254, '', '', 'PRO VAN Samochody Użytkowe', '', '', 1, 1, 7, 'Maratońska 56, Radom 26-612', '26-612', 'Radom', 'Maratońska', '56', '', 0, '2024-05-07 13:46:21', 'zamówienie', '51.3961009836455', '21.1139643269286', 'shop', '5+'),
(255, '', '', 'Mularski Centrum Piotr Mularski', '', '', 1, 1, 7, 'Tartaczna 29, Radom 26-600', '26-600', 'Radom', 'Tartaczna', '29', '', 0, '2024-05-07 13:47:01', 'zamówienie', '51.3851199563550', '21.1341385467617', 'warehouse', '10+'),
(256, '', '', 'Humansoft - systemy informatyczne, Radom', '', '', 1, 1, 7, 'Grabowa 15, Radom 26-616', '26-616', 'Radom', 'Grabowa', '15', '', 0, '2024-05-07 13:47:40', 'dojazd', '51.3868908415895', '21.1272312982767', 'exclamation', '20+'),
(257, '', '', 'MOPS', '', '', 1, 1, 7, 'Grabowa 17, Radom 26-612', '26-612', 'Radom', 'Grabowa', '17', '', 0, '2024-05-07 13:49:41', '', '51.3867023637530', '21.1265574683924', 'building', '10+'),
(258, '', '', 'Karen Collection', '', '', 1, 1, 7, 'Bolesława Limanowskiego 95, Radom 26-600', '26-600', 'Radom', 'Bolesława Limanowskiego', '95', '', 0, '2024-05-07 13:50:18', 'dojazd', '51.3843231496493', '21.1235246865134', 'exclamation', '10+'),
(259, '', '', 'Top Gal', '', '', 1, 1, 7, 'Bolesława Limanowskiego 95M, Radom 26-600', '26-600', 'Radom', 'Bolesława Limanowskiego', '95M', '', 0, '2024-05-07 13:50:54', '', '51.3839377729777', '21.1228935814891', 'exclamation', '10+'),
(260, '', '', 'Intersnack', '', '', 1, 1, 7, 'Hodowlana 4, Radom 26-601', '26-601', 'Radom', 'Hodowlana', '4', '', 0, '2024-05-07 13:52:04', 'dojazd', '51.3820362679157', '21.0810522827497', 'building', '10+'),
(261, '', '', 'All-Trans', '', '', 1, 1, 7, 'Kielecka 159, Radom 26-600', '26-600', 'Radom', 'Kielecka', '159', '', 0, '2024-05-07 13:52:42', 'dojazd', '51.3866183899543', '21.0948589269283', 'exclamation', '10+'),
(262, '', '', 'Mat-Bud. Skład materiałów budowlanych, farb i lakierów', '', '', 1, 1, 7, 'Kielecka 89, Radom 26-600', '26-600', 'Radom', 'Kielecka', '89', '', 0, '2024-05-07 13:53:49', 'dojazd', '51.3949831063899', '21.1063327115859', 'warehouse', '10+'),
(263, '', '', 'Mal-Fur', '', '', 1, 1, 7, 'Podmokła 6, Radom 26-612', '26-612', 'Radom', 'Podmokła', '6', '', 0, '2024-05-07 13:54:24', 'dojazd', '51.3941392774288', '21.1216549980928', 'shop', '5+'),
(264, '', '', 'PKS Ratrans Sp. z o.o.', '', '', 1, 1, 7, '1905 Roku 49, Radom 26-600', '26-600', 'Radom', '1905 Roku', '49', '', 0, '2024-05-07 13:55:03', 'dojazd', '51.3897426017879', '21.1347826557640', 'building', '10+'),
(265, '', '', 'Zakład Usług Komunalnych w Radomiu', '', '', 1, 1, 7, 'Sucha 15, Radom 26-600', '26-600', 'Radom', 'Sucha', '15', '', 0, '2024-05-07 13:55:35', 'dojazd', '51.3854147630596', '21.1215737269282', 'building', '10+'),
(266, '', '', 'Mastercars Dusza s.c.', '', '', 1, 1, 7, 'Sucha 15, Radom 26-612', '26-612', 'Radom', 'Sucha', '15', '', 0, '2024-05-07 13:56:12', 'zamówienie', '51.3853748892263', '21.1209642404211', 'shop', '5+'),
(267, '', '', 'Drozapol-Profil S.A.', '', '', 1, 1, 7, 'Wałowa 17, Radom 26-610', '26-610', 'Radom', 'Wałowa', '17', '', 0, '2024-05-07 13:56:48', 'zamówienie', '51.4014182583798', '21.1437136422715', 'shop', '1+'),
(268, '', '', 'BNP Paribas Bank Polska S.A.', '', '', 1, 1, 7, 'Romualda Traugutta 29, Radom 26-600', '26-600', 'Radom', 'Romualda Traugutta', '29', '', 0, '2024-05-07 13:57:23', 'dojazd', '51.3953162066825', '21.1538062404215', 'exclamation', '10+'),
(269, '', '', 'S4GA World\'s Safest Runway Lighting', '', '', 1, 1, 7, 'Biznesowa 4, Radom 26-600', '26-600', 'Radom', 'Biznesowa', '4', '', 0, '2024-05-07 13:57:58', 'dojazd', '51.3906525266575', '21.1470569864494', 'exclamation', '20+'),
(270, '', '', 'Miejski Zarząd Lokalami w Radomiu', '', '', 1, 1, 7, 'Garbarska 55/57, Radom 26-600', '26-600', 'Radom', 'Garbarska', '55/57', '', 0, '2024-05-07 13:58:38', 'zamówienie + dojazd', '51.4002916437608', '21.1230029094839', 'building', '5+'),
(271, '', '', 'Korporacja Budowlana Darco Dariusz Żak', '', '', 1, 1, 7, 'Garbarska 53, Radom 26-600', '26-600', 'Radom', 'Garbarska', '53', '', 0, '2024-05-07 13:59:15', 'zamówienie + dojazd', '51.4005715849548', '21.1231221115861', 'building', '5+'),
(272, '', '', 'Saute Nails Sp. z o.o.', '', '', 1, 1, 7, 'Generała Leopolda Okulickiego 88, Radom 26-610', '26-610', 'Radom', 'Generała Leopolda Okulickiego', '88', '', 0, '2024-05-07 13:59:53', 'zamówienie + dojazd', '51.4069045018331', '21.1255385269290', 'exclamation', '5+'),
(273, '', '', 'Armed Ort Sklep Medyczny', '', '', 1, 1, 7, 'Bernardyńska 1, Radom 26-610', '26-610', 'Radom', 'Bernardyńska', '1', '', 0, '2024-05-07 14:00:33', 'zamówienie + dojazd', '51.4012760851612', '21.1459015980931', 'exclamation', '5+'),
(274, '', '', 'Stomatologia SMILE Jasińscy', '', '', 1, 1, 7, 'Kielecka 15, Radom 26-600', '26-600', 'Radom', 'Kielecka', '15', '', 0, '2024-05-07 14:01:04', 'dojazd', '51.4045294932778', '21.1202257422715', 'exclamation', '5+'),
(275, '', '', 'Okna i Drzwi - KOMFORT', '', '', 1, 1, 7, 'Kielecka 159a, Radom 26-600', '26-600', 'Radom', 'Kielecka', '159a', '', 0, '2024-05-07 14:01:42', 'dojazd', '51.3862948286666', '21.0945640886490', 'warehouse', '10+'),
(276, '', '', 'Yorgo - Autoryzowany Dealer SsangYong Isuzu', '', '', 1, 1, 7, 'Kielecka 159, Radom 26-600', '26-600', 'Radom', 'Kielecka', '159', '', 0, '2024-05-07 14:02:14', 'dojazd', '51.3867078808945', '21.0946394539142', 'warehouse', '10+'),
(277, '', '', 'Merida Sp. z o.o.', '', '', 1, 1, 7, 'Bolesława Limanowskiego 95, Radom 26-600', '26-600', 'Radom', 'Bolesława Limanowskiego', '95', '', 0, '2024-05-07 14:02:46', 'dojazd', '51.3848177017460', '21.1237435115854', 'shop', '5+'),
(278, '', '', 'Elit Polska - Filia Radom', '', '', 1, 1, 7, 'Tytoniowa 35, Radom 26-600', '26-600', 'Radom', 'Tytoniowa', '35', '', 0, '2024-05-07 14:03:48', 'dojazd', '51.3921909957965', '21.1399815919679', 'warehouse', '10+'),
(279, '', '', 'CAMERO design - Wyposażenie łazienek - wanny, płytki, armatura', '', '', 1, 1, 7, 'Dębowa 4, Radom 26-600', '26-600', 'Radom', 'Dębowa', '4', '', 0, '2024-05-07 14:04:21', 'dojazd', '51.3967047124548', '21.1344415735339', 'warehouse', '10+'),
(280, '', '', 'Serwis BMW Radom', '', '', 1, 1, 7, 'Dębowa 4, Radom 26-600', '26-600', 'Radom', 'Dębowa', '4', '', 0, '2024-05-07 14:04:49', 'dojazd', '51.3967403964702', '21.1341816002097', 'shop', '5+'),
(281, '', '', 'ARTIMET', '', '', 1, 1, 7, 'Dębowa 4, Radom 26-600', '26-600', 'Radom', 'Dębowa', '4', '', 0, '2024-05-07 14:05:35', 'dojazd', '51.3968236657555', '21.1343077115860', 'exclamation', '10+'),
(282, '', '', 'Hydro Truck', '', '', 1, 1, 7, 'Obrońców 36, Radom 26-612', '26-612', 'Radom', 'Obrońców', '36', '', 0, '2024-05-07 14:06:09', 'dojazd', '51.3892189691974', '21.1372434130859', 'warehouse', '10+'),
(283, '', '', 'Ismena-Hurtownia kwiatów i roślin Marczak Konrad', '', '', 1, 1, 7, 'Obrońców 36, Radom 26-200', '26-200', 'Radom', 'Obrońców', '36', '', 0, '2024-05-07 14:06:47', 'dojazd', '51.3895229869629', '21.1360662422526', 'exclamation', '10+'),
(284, '', '', 'Zibi Sp.k.', '', '', 1, 1, 7, 'Obrońców 36, Radom 26-612', '26-612', 'Radom', 'Obrońców', '36', '', 0, '2024-05-07 14:07:13', '', '51.3895207777333', '21.1359685247448', 'shop', '5+'),
(285, '', '', 'L-Dental Laboratory', '', '', 1, 1, 7, 'Pamięci Katynia 12A, Radom 26-610', '26-610', 'Radom', 'Pamięci Katynia', '12A', '', 0, '2024-05-07 14:07:53', 'zamówienie + dojazd', '51.3999551588076', '21.1149707404217', 'exclamation', '10+'),
(286, '', '', 'Dom', '', '', 1, 1, 7, 'Ślepowron 98, Ślepowron 26-625', '26-625', 'Ślepowron', 'Ślepowron', '98', '', 0, '2024-05-07 14:08:27', '', '51.3957922049292', '21.0562817722150', 'house', '1+'),
(287, '', '', 'Poradnia Rehabilitacyjna dla Dzieci im. Władysława Basiaka', '', '', 1, 1, 7, 'Mikołaja Reja 28, Radom 26-610', '26-610', 'Radom', 'Mikołaja Reja', '28', '', 0, '2024-05-07 14:08:58', 'dojazd', '51.4049272399957', '21.1416968885249', 'exclamation', '10+'),
(288, '', '', 'ICC Call Center Sp. z o.o.', '', '', 1, 1, 7, 'Główna 9, Radom 26-600', '26-600', 'Radom', 'Główna', '9', '', 0, '2024-05-07 14:09:30', 'dojazd', '51.4015767785189', '21.1287627980931', 'exclamation', '20+'),
(289, '', '', 'Salon Fryzjerski Małgorzata Kopycka', '', '', 1, 1, 7, 'Londyńska 8, Radom 26-616', '26-616', 'Radom', 'Londyńska', '8', '', 0, '2024-05-07 14:12:31', 'dojazd', '51.3796166828074', '21.0985673972473', 'shop', '1+'),
(290, '', '', 'Pneumatyka', '', '', 1, 0, 7, 'Londyńska 8, Radom 26-612', '26-612', 'Radom', 'Londyńska', '8', '', 0, '2024-05-07 14:13:09', 'dojazd', '51.3796161855869', '21.0986298178622', 'shop', '1+'),
(291, '', '', 'Grzybex Podnośniki, Dźwigi, Transport PPHU. Grzyb M.', '', '', 1, 0, 7, 'Czereśniowa 5, Radom 26-616', '26-616', 'Radom', 'Czereśniowa', '5', '', 0, '2024-05-07 14:13:42', 'dojazd', '51.3803917746259', '21.0995778684427', 'shop', '1+'),
(292, '', '', 'Salon fryzjersko-kosmetyczny Edyta', '', '', 1, 0, 7, 'Pośrednia 16A, Radom 26-616', '26-616', 'Radom', 'Pośrednia', '16A', '', 0, '2024-05-07 14:14:15', '', '51.3844406760076', '21.1052264269281', 'shop', '1+'),
(293, '', '', 'Apteka Wośniki', '', '', 1, 1, 7, 'Pośrednia 29, Radom 26-616', '26-616', 'Radom', 'Pośrednia', '29', '', 0, '2024-05-07 14:15:01', 'dojazd', '51.3844343308148', '21.1068560597179', 'shop', '2+'),
(294, '', '', 'Centrum Medyczne', '', '', 1, 1, 7, 'Wośnicka 28, Radom 26-612', '26-612', 'Radom', 'Wośnicka', '28', '', 0, '2024-05-07 14:15:39', 'dojazd', '51.3832763949118', '21.1067854755824', 'shop', '1+'),
(295, '', '', 'Elen. Salon kosmetyczny', '', '', 1, 1, 7, 'Wośnicka 28, Radom 26-612', '26-612', 'Radom', 'Wośnicka', '28', '', 0, '2024-05-07 14:16:15', '', '51.3830975007968', '21.1068383606022', 'shop', '1+'),
(296, '', '', 'Madagaskar - animacje dla dzieci- sala urodzinowa / warsztaty', '', '', 1, 0, 7, 'Wośnicka 28, Radom 26-612', '26-612', 'Radom', 'Wośnicka', '28', '', 0, '2024-05-07 14:16:44', 'dojazd', '51.3831791242458', '21.1067163710271', 'shop', '1+'),
(297, '', '', 'Wulkanizacja - Wymiana Opon - Serwis Opon', '', '', 1, 1, 7, 'Wośnicka 20, Radom 26-612', '26-612', 'Radom', 'Wośnicka', '20', '', 0, '2024-05-07 14:17:28', '', '51.3842208984789', '21.1090521164597', 'shop', '2+'),
(298, '', '', 'Mój Lekarz Radom Poradnia Specjalistyczna', '', '', 1, 1, 7, 'Skrajna 113, Radom 26-612', '26-612', 'Radom', 'Skrajna', '113', '', 0, '2024-05-07 14:17:54', 'dojazd', '51.3879929195558', '21.1079547243312', 'building', '5+'),
(299, '', '', 'Onninen hurtownia elektryczna, hydrauliczna i instalacyjna', '', '', 1, 1, 7, 'Maratońska 67, Radom 26-612', '26-612', 'Radom', 'Maratońska', '67', '', 0, '2024-05-07 14:18:29', 'dojazd', '51.3957394440857', '21.1104232822646', 'building', '10+'),
(300, '', '', 'Wydział Patrolowo-Interwencyjny KMP w Radomiu', '', '', 1, 1, 7, 'Młodzianowska 24, Radom 26-600', '26-600', 'Radom', 'Młodzianowska', '24', '', 0, '2024-05-07 14:18:59', 'dojazd', '51.3933457938932', '21.1416242999424', 'building', '5+'),
(301, '', '696002095', 'Falcon Garden', '', '', 1, 1, 7, '1905 Roku 21, Radom 26-610', '26-610', 'Radom', '1905 Roku', '21', '', 0, '2024-05-07 14:19:47', '696002095, 514492697; zamówienie', '51.3889390010820', '21.1402075980927', 'shop', '5+'),
(302, '', '600018521', 'M-Dent Staniszewscy. Przychodnia stomatologiczna', '', '', 1, 1, 7, 'Bolesława Limanowskiego 79, Radom 26-600', '26-600', 'Radom', 'Bolesława Limanowskiego', '79', '', 0, '2024-05-07 14:20:40', '600018521, 603869880; zamówienie + dojazd', '51.3867726672239', '21.1256397962430', 'shop', '5+'),
(303, '', '509110303', 'Zakład Kamieniarski KamBet', '', '', 1, 1, 7, 'Bolesława Limanowskiego 79, Radom 26-600', '26-600', 'Radom', 'Bolesława Limanowskiego', '79', '', 0, '2024-05-07 14:21:23', 'zamówienie + dojazd', '51.3868217431956', '21.1257241625077', 'shop', '5+'),
(304, '', '797742323', 'Biuro rachunkowe', '', '', 1, 1, 7, 'Kamienna 7a, Radom 26-600', '26-600', 'Radom', 'Kamienna', '7a', '', 0, '2024-05-07 14:22:39', 'zamówienie', '51.3883712497090', '21.1234621529159', 'house', '1+'),
(305, '', '603374825', 'Zakład Usług Technicznych Energetyki Cieplnej w Radomiu - ZUTEC Sp. z o.o.', '', '', 1, 1, 7, 'Żelazna 9, Radom 26-616', '26-616', 'Radom', 'Żelazna', '9', '', 0, '2024-05-07 14:23:17', 'dojazd', '51.3567580897629', '21.1051007066846', 'warehouse', '10+'),
(306, '', '', 'Dr Miele Cosmed Grup S.A.', '', '', 1, 1, 7, 'Wielkopolska 3, Radom 26-624', '26-624', 'Radom', 'Wielkopolska', '3', '', 0, '2024-05-07 14:23:53', 'WhatApp; dojazd', '51.3620091774383', '21.0930546404202', 'shop', '5+'),
(307, '', '', 'Dom', '', '', 1, 1, 7, 'Tartaczna 14, Radom 26-616', '26-616', 'Radom', 'Tartaczna', '14', '', 0, '2024-05-07 14:24:59', 'WhatApp; dojazd', '51.3854782383103', '21.1351742682315', 'house', '1+'),
(308, '', '693990855', 'GGG Sp. z o.o. CNC', '', '', 1, 1, 7, 'Wielkopolska 1a, Radom 26-600', '26-600', 'Radom', 'Wielkopolska', '1a', '', 0, '2024-05-07 14:25:51', '693990855, 605084185; zamówienie, codziennie max do 11', '51.3630060739544', '21.0921181827490', 'building', '20+'),
(309, '', '601828096', 'GMB DENTAL Pracownia Protetyki Dentystycznej mgr Marcin Bernatowicz', '', '', 1, 1, 7, 'Bolesława Limanowskiego 73/75/lokal 12, Radom 26-600', '26-600', 'Radom', 'Bolesława Limanowskiego', '73/75/loka', '', 0, '2024-05-07 14:27:00', 'zamówienie + dojazd', '51.3873405894079', '21.1263588735282', 'shop', '1+'),
(310, '', '887040020', 'MK STUDIO & ACADEMY', '', '', 1, 1, 7, 'Bolesława Limanowskiego 73/75, Radom 26-616', '26-616', 'Radom', 'Bolesława Limanowskiego', '73/75', '', 0, '2024-05-07 14:29:29', 'zamówienie', '51.3872413085256', '21.1262995658042', 'shop', '1+'),
(311, '', '', 'SOVITA Wyroby hutnicze, Usługi transportowe', '', '', 1, 1, 7, 'Stalowa 3, Radom 26-616', '26-616', 'Radom', 'Stalowa', '3', '', 0, '2024-05-07 14:30:16', 'grupa na Messengerze; codziennie do 9:00', '51.3562777716780', '21.0913500980914', 'warehouse', '20+'),
(312, '', '509501396', 'Dom', '', '', 1, 1, 7, 'Wośnicka 28A/m8, Radom 26-612', '26-612', 'Radom', 'Wośnicka', '28A/m8', '', 0, '2024-05-07 14:31:02', 'zamówienie', '51.3837303463214', '21.1079078184480', 'house', '1+'),
(313, '', '', 'Mechanik samochodowy', '', '', 1, 1, 7, 'Toruńska 12, Radom 26-616', '26-616', 'Radom', 'Toruńska', '12', '', 0, '2024-05-07 14:31:53', 'zamówienie', '51.3812689838522', '21.1219011272853', 'shop', '5+'),
(314, '', '512541870', 'Dzik and Szwed salon fryzjerski', '', '', 1, 1, 7, 'księdza profesora W. Sedlaka 4/6/8 lok. A3, Radom 26-600', '26-600', 'Radom', 'księdza profesora W. Sedlaka', '4/6/8 lok.', '', 0, '2024-05-07 14:32:35', '', '51.3970794960797', '21.1421951557643', 'shop', '1+'),
(315, '', '603645119', 'Pt Dental', '', '', 1, 1, 7, 'księdza profesora W. Sedlaka 4/6, Radom 26-610', '26-610', 'Radom', 'księdza profesora W. Sedlaka', '4/6', '', 0, '2024-05-07 14:33:18', '', '51.3976041779367', '21.1426506980930', 'shop', '1+'),
(316, '', '519134082', 'Ubezpieczenia', '', '', 1, 1, 7, 'ks. prof. Włodzimierza Sedlaka 6/8, Radom 26-600', '26-600', 'Radom', 'ks. prof. Włodzimierza Sedlaka', '6/8', '', 0, '2024-05-07 14:34:13', '', '51.3972702479191', '21.1424252953939', 'shop', '1+'),
(317, '', '', 'Eurocash Cash and Carry Radom - Hurtownia Spożywcza', '', '', 1, 1, 7, 'Wrocławska 8, Radom 26-600', '26-600', 'Radom', 'Wrocławska', '8', '', 0, '2024-05-07 14:34:48', '', '51.4030656509537', '21.1876956115862', 'exclamation', '20+'),
(318, '', '', 'Corten Medic', '', '', 1, 1, 7, 'Władysława Beliny-Prażmowskiego 33A, Radom 26-600', '26-600', 'Radom', 'Władysława Beliny-Prażmowskiego', '33A', '', 0, '2024-05-07 14:35:24', '', '51.3953450883497', '21.1619198220814', 'exclamation', '20+'),
(319, '', '', 'Oddział InPost Radom', '', '', 1, 1, 7, 'Wrocławska 5, Radom 26-600', '26-600', 'Radom', 'Wrocławska', '5', '', 0, '2024-05-07 14:35:51', '', '51.4001699927287', '21.1901587436493', 'exclamation', '20+'),
(320, 'spedycja@jarmus.pl', '', 'JARMUS Sp. z o.o.', '', '', 1, 1, 7, 'Kielecka 116/B, Radom 26-600', '26-600', 'Radom', 'Kielecka', '116/B', '', 0, '2024-05-07 14:36:26', '', '51.3863303852843', '21.0923887404212', 'warehouse', '10+'),
(321, '', '', 'Viper Sp. z o.o', '', '', 1, 1, 7, 'Kielecka 130, Radom 26-600', '26-600', 'Radom', 'Kielecka', '130', '', 0, '2024-05-07 14:37:18', '', '51.3771301938716', '21.0793369980922', 'shop', '5+'),
(322, '', '', 'Kado Polska', '', '', 1, 1, 7, 'Kielecka 175, Radom 26-600', '26-600', 'Radom', 'Kielecka', '175', '', 0, '2024-05-07 14:37:59', '', '51.3753002775540', '21.0786771422704', 'warehouse', '10+'),
(323, '', '', 'Sic Parvis Magna Sp. z o.o.', '', '', 1, 1, 7, 'Kończycka 2A/1, Radom 26-612', '26-612', 'Radom', 'Kończycka', '2A/1', '', 0, '2024-05-07 14:38:50', '', '51.3740964826236', '21.0759533269277', 'shop', '5+'),
(324, '', '', 'Gabinet Weterynaryjny PUPIL', '', '', 1, 1, 7, 'Szydłowiecka 20, Radom 26-600', '26-600', 'Radom', 'Szydłowiecka', '20', '', 0, '2024-05-07 14:39:20', '', '51.3684644755525', '21.0773514404205', 'shop', '5+'),
(325, '', '', 'Łuk-Chent', '', '', 1, 1, 7, 'Kielecka 138, Radom 26-600', '26-600', 'Radom', 'Kielecka', '138', '', 0, '2024-05-07 14:39:57', '', '51.3755041834476', '21.0778345557634', 'shop', '1+'),
(326, '', '607295322', 'Studio Kosmetyki Profesjonalnej', '', '', 1, 1, 7, 'ks. prof. Włodzimierza Sedlaka 4/6/8, Radom 26-600', '26-600', 'Radom', 'ks. prof. Włodzimierza Sedlaka', '4/6/8', '', 0, '2024-05-07 14:40:46', 'zamówienie', '51.3972918864577', '21.1423868787782', 'shop', '5+'),
(327, '', '668708932', 'VIP FASHION', '', '', 1, 1, 7, 'Bolesława Limanowskiego 86a, Radom 26-610', '26-610', 'Radom', 'Bolesława Limanowskiego', '86a', '', 0, '2024-05-07 14:41:41', 'zamówienie', '51.3891877160913', '21.1271251056713', 'shop', '1+'),
(328, 'feniks@abcanimal.pl', '', 'Centrum Zoologiczne', '', '', 1, 1, 3, 'Aleja Józefa Grzecznarowskiego 29/31, Radom 26-610', '26-610', 'Radom', 'Aleja Józefa Grzecznarowskiego', '29/31', '', 0, '2024-05-07 14:43:12', 'zamówienie', '51.3813217918119', '21.1752783864489', 'shop', '5+'),
(329, 'gabinet@globaldent.pl', '', 'Stomatolog Radom Dentysta GlobalDent', '', '', 1, 1, 3, 'Gabriela Narutowicza 1B, Radom 26-600', '26-600', 'Radom', 'Gabriela Narutowicza', '1B', '', 0, '2024-05-07 14:43:48', '', '51.3964079777613', '21.1517644980929', 'shop', '5+'),
(330, 'marzena.panek@abcanimal.pl', '', 'Centrum Zoologiczne', '', '', 1, 1, 5, 'Miła 17, Radom 26-600', '26-600', 'Radom', 'Miła', '17', '', 0, '2024-05-07 14:45:07', 'mila@abcanimal.pl, marzena.panek@abcanimal.pl; zamówienie', '51.4075994870135', '21.1584409115865', 'shop', '5+'),
(331, 'radom@pks-sa.com', '', 'PKS', '', '', 1, 1, 3, '25 Czerwca 68, Radom 26-610', '26-610', 'Radom', '25 Czerwca', '68', '', 0, '2024-05-07 15:38:43', '', '51.4030702761814', '21.1645229674130', 'building', '10+'),
(332, '', '', 'Centrum Medyczne PZU Zdrowie Radom Graniczna', '', '', 1, 1, 6, 'Graniczna 24, Radom 26-600', '26-600', 'Radom', 'Graniczna', '24', '', 0, '2024-05-09 08:16:08', '', '51.3911432151075', '21.1641884446490', 'exclamation', '20+'),
(333, '', '661909015', 'Akademia Handlowa Nauk Stosowanych', '', '', 1, 1, 3, 'Tadeusza Mazowieckiego 7A, Radom 26-610', '26-610', 'Radom', 'Tadeusza Mazowieckiego', '7A', '', 0, '2024-05-09 08:17:13', '', '51.3907543215454', '21.1595930612944', 'building', '20+'),
(334, '', '', 'Salon oświetleniowy Mirat', '', '', 1, 1, 7, 'Toruńska 9, Radom 26-600', '26-600', 'Radom', 'Toruńska', '9', '', 0, '2024-05-09 08:18:03', '', '51.3801146342306', '21.1206863925091', 'shop', '5+'),
(335, '', '', 'Metal-Kom sp.j. PPH', '', '', 1, 1, 7, 'Toruńska 9, Radom 26-616', '26-616', 'Radom', 'Toruńska', '9', '', 0, '2024-05-09 08:18:39', '', '51.3808636523534', '21.1209739263171', 'shop', '5+'),
(336, '', '', 'Straż Pożarna JRG 3', '', '', 1, 1, 7, 'Jana Józefa Lipskiego , Radom 26-616', '26-616', 'Radom', 'Jana Józefa Lipskiego', '', '', 0, '2024-05-09 08:19:24', '', '51.3587600745862', '21.1086225269271', 'building', '10+'),
(337, '', '', 'Laboratorium Kryminalistyczne KWP', '', '', 1, 1, 7, 'Bolesława Limanowskiego 95, Radom 26-612', '26-612', 'Radom', 'Bolesława Limanowskiego', '95', '', 0, '2024-05-09 08:20:06', '', '51.3833670282313', '21.1222382262742', 'building', '10+'),
(338, '', '', 'PPUH EGAZ', '', '', 1, 1, 7, 'Bolesława Limanowskiego 95K, Radom 26-600', '26-600', 'Radom', 'Bolesława Limanowskiego', '95K', '', 0, '2024-05-09 08:20:49', '', '51.3845960058183', '21.1254723015964', 'shop', '5+');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `places`
--

CREATE TABLE IF NOT EXISTS `places` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `sold` int(11) NOT NULL,
  `c_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `places`
--

TRUNCATE TABLE `places`;
--
-- Dumping data for table `places`
--

INSERT INTO `places` (`id`, `u_id`, `date`, `sold`, `c_id`) VALUES
(1, 1, '2024-04-23 07:52:44', 0, 3),
(2, 1, '2024-04-23 10:12:40', 0, 1),
(3, 1, '2024-04-22 10:35:14', 1, 1),
(6, 1, '2024-04-22 10:39:34', 2, 3),
(7, 1, '2024-04-24 10:45:33', 1, 0),
(8, 1, '2024-04-21 10:45:56', 1, 1),
(9, 1, '2024-04-21 10:46:23', 0, 3),
(10, 1, '2024-04-24 20:21:50', 1, 1),
(11, 1, '2024-04-24 20:21:55', 2, 2),
(12, 1, '2024-04-24 20:22:07', 0, 3),
(13, 1, '2024-04-23 06:25:09', 1, 3),
(14, 1, '2024-04-23 10:46:10', 0, 2),
(15, 1, '2024-04-25 13:33:11', 1, 3),
(16, 1, '2024-04-26 12:25:13', 1, 0),
(17, 1, '2024-04-26 13:23:16', 1, 2),
(18, 1, '2024-04-30 13:43:10', 0, 2),
(19, 1, '2024-04-30 13:44:03', 1, 1);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `planner`
--

CREATE TABLE IF NOT EXISTS `planner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_plan` date NOT NULL,
  `w_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `planner`
--

TRUNCATE TABLE `planner`;
--
-- Dumping data for table `planner`
--

INSERT INTO `planner` (`id`, `date_plan`, `w_id`, `p_id`, `amount`, `u_id`, `date`) VALUES
(4, '2024-04-28', 1, 1, 0, 1, '2024-04-26 07:46:28'),
(5, '2024-04-28', 1, 8, 0, 1, '2024-04-26 07:53:21'),
(6, '2024-04-28', 2, 8, 0, 1, '2024-04-26 07:55:59'),
(7, '2024-04-18', 1, 1, 1, 1, '2024-04-26 09:44:50'),
(8, '2024-04-18', 1, 8, 3, 1, '2024-04-26 09:44:52'),
(9, '2024-04-25', 1, 1, 1, 1, '2024-04-26 09:45:02'),
(10, '2024-04-25', 1, 8, 3, 1, '2024-04-26 09:45:03'),
(11, '2024-04-25', 2, 8, 2, 1, '2024-04-26 09:45:05'),
(12, '2024-04-24', 1, 1, 1, 1, '2024-04-26 10:09:00'),
(13, '0000-00-00', 1, 8, 4, 2, '2024-05-08 10:18:49'),
(14, '2024-05-07', 1, 8, 3, 2, '2024-05-08 10:19:02'),
(15, '2024-05-07', 1, 1, 1, 2, '2024-05-08 10:19:14');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `prices`
--

CREATE TABLE IF NOT EXISTS `prices` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `p_id` int(11) NOT NULL,
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL,
  `active` int(11) NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `u_id` int(11) NOT NULL,
  `production_cost` float NOT NULL,
  `price` float NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `prices`
--

TRUNCATE TABLE `prices`;
--
-- Dumping data for table `prices`
--

INSERT INTO `prices` (`id`, `p_id`, `date_from`, `date_to`, `active`, `date`, `u_id`, `production_cost`, `price`) VALUES
(1, 1, '2024-04-24 00:00:00', '2024-04-24 23:59:00', 1, '2024-04-24 06:10:07', 1, 10, 20),
(2, 4, '2024-04-24 00:00:00', '2024-04-24 23:59:00', 1, '2024-04-24 06:10:55', 1, 5, 15),
(3, 5, '2024-04-24 00:00:00', '2024-04-24 23:59:00', 1, '2024-04-24 06:10:07', 1, 20, 30);

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
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `products`
--

TRUNCATE TABLE `products`;
--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `p_name`, `ean`, `sku`, `p_description`, `p_unit`, `p_photo`, `prod_type`) VALUES
(1, 'Sałatka cezar', '', '1-01-01-1', '', 'Szt.', 'cezar.jpg', 1),
(2, 'Bagietka', '', '2-01-01-1', '', 'Szt.', 'bagietka.jpg', 0),
(3, 'Tortilla', '', '2-01-02-1', '', 'Szt.', 'tortilla.jpg', 0),
(4, 'Sałatka nugetsy', '', '1-01-02-1', '', 'Szt.', 'nugetsy.jpg', 1),
(5, 'Sałatka grecka', '', '1-01-03-1', '', 'Szt.', 'grecka.jpg', 1),
(6, 'Sałatka włoska', '', '1-01-04-1', '', 'Szt.', 'wloska.jpg', 1),
(7, 'Sałatka ananas', '', '1-01-05-1', '', 'Szt.', 'ananas.jpg', 1),
(8, 'Kanapka z wieprzowiną', '', '1-02-01-1', '', 'Szt.', 'kanapkawieprzowina.jpg', 1),
(9, 'Kanapka z kurczakiem', '', '1-02-02-1', '', 'Szt.', 'kanapkakurczak.jpg', 1),
(10, 'Kanapka z tuńczykiem', '', '1-02-03-1', '', 'Szt.', 'kanapkagalantyna.jpg', 1),
(11, 'Grzanka łososiowa', '', '1-02-04-1', '', 'Szt.', 'grzankalosos.jpg', 1),
(12, 'Granola', '', '1-05-01-1', '', 'Szt.', 'granola.jpg', 1),
(13, 'Racuchy', '', '1-05-02-1', '3 sztuki', 'Szt.', 'racuchy.jpg', 1),
(14, 'Naleśniki', '', '1-05-03-1', '2 naleśniki', 'Szt.', 'nalesniki.jpg', 1),
(15, 'Wrap tajski', '', '1-04-01-1', '', 'Szt.', 'wrapytajskie.jpg', 1),
(16, 'Ciasto czekoladowe', '', '1-05-04-1', '', 'Szt.', 'ciastoczekoladowe.jpg', 1),
(17, 'Zalewajka', '', '1-03-01-1', '', 'Szt.', 'zalewajka.jpg', 1),
(18, 'Pulpety w sosie', '', '1-04-02-1', '3 pulpety', 'Szt.', 'pulpetywsosie.jpg', 1),
(19, 'Polędwiczki drobiowe', '', '1-04-03-1', '2 polędwiczki', 'Szt.', 'poledwiczkidrobiowe.jpg', 1),
(20, 'Kopytka ze szpinakiem', '', '1-06-01-1', '', 'Szt.', 'kopytkaszpinak.jpg', 1),
(21, 'Sałatka meksykańska', '', '1-01-06-1', '', 'Szt.', 'salatkameksykanska.jpg', 1),
(22, 'Sałatka z jajkiem', '', '1-01-07-1', '', 'Szt.', 'salatkajajko.jpg', 1),
(23, 'Sałatka z burakiem', '', '1-01-08-1', '', 'Szt.', 'salatkaburak.jpg', 1),
(24, 'Kanapka z łososiem', '', '1-02-05-1', '', 'Szt.', 'kanapkalosos.jpg', 1),
(25, 'Deser ryżowy', '', '1-05-05-1', '', 'Szt.', 'deserryzowy.jpg', 1),
(26, 'Jabłecznik', '', '1-05-06-1', '', 'Szt.', 'jablecznik.jpg', 1),
(27, 'Grochówka', '', '1-03-02-1', '', 'Szt.', 'grochowka.jpg', 1),
(28, 'Dorsz', '', '1-04-04-1', '', 'Szt.', 'dorsz.jpg', 1),
(29, 'Roladka schabowa', '', '1-04-05-1', '', 'Szt.', 'roladkaschabowa.jpg', 1),
(30, 'Sałatka królewska', '', '1-01-09-1', '', 'Szt.', 'salatkakrolewska.jpg', 1),
(31, 'Pierogi z serem', '', '1-04-06-1', '3 pierogi', 'Szt.', 'pierogizserem.jpg', 1),
(32, 'Pierogi ruskie', '', '1-04-07-1', '3 pierogi', 'Szt.', 'pierogiruskie.jpg', 1),
(33, 'Kanapka wiejska', '', '1-02-06-1', '', 'Szt.', 'wiejska.jpg', 1),
(34, 'Rolada biszkoptowa', '', '1-05-07-1', '', 'Szt.', 'rolada.jpg', 1),
(35, 'Sznycelki', '', '1-04-08-1', '', 'Szt.', 'sznycelki.jpg', 1),
(36, 'Makaron', '', '1-04-09-1', '', 'Szt.', 'makaron.jpg', 1),
(37, 'Filet z kopytkami', '', '1-04-10-1', '', 'Szt.', 'filetkopytka.jpg', 1),
(38, 'Zupa Brokułowa', '', '1-03-03-1', '', 'Szt.', 'brokulowa.jpg', 1),
(39, 'Kanapka z jajkiem', '', '1-02-07-1', '', 'Szt.', 'pastajajeczna.jpg', 1),
(40, 'Granola owocowa', '', '1-05-08-1', '', 'Szt.', 'granolaowoc.jpg', 1),
(41, 'Granola Toffi', '', '1-05-09-1', '', 'Szt.', 'granolatoffi.jpg', 1),
(42, 'Granola czekoladowa', '', '1-05-10-1', '', 'Szt.', 'granolaczekoladowa.jpg', 1),
(43, 'Szarlotka', '', '1-05-11-1', '', 'Szt.', 'szarlotka.jpg', 1),
(44, 'Barszcz czerwony', '', '1-03-04-1', '', 'Szt.', 'barszczczerwony.jpg', 1),
(45, 'Barszcz biały', '', '1-03-05-1', '', 'Szt.', 'barszczbialy.jpg', 1),
(46, 'Zupa curry', '', '1-03-06-1', '', 'Szt.', 'zupacurry.jpg', 1),
(47, 'Sałatka z krewetkami', '', '1-01-10-1', '', 'Szt.', 'salatkakrewetki.jpg', 1),
(48, 'Owsianka', '', '1-03-07-1', '', 'Szt.', 'owsianka.jpg', 1),
(49, 'Ciastka kokosowe', '', '1-05-12-1', '', 'Szt.', 'ciastkakokosowe.jpg', 1),
(50, 'Pancake', '', '1-05-13-1', '', 'Szt.', 'pancake.jpg', 1),
(51, 'Kartacze', '', '1-04-11-1', '', 'Szt.', 'kartacze.jpg', 1),
(52, 'Zupa krem pomidorowy', '', '1-03-08-1', '', 'Szt.', 'krempomidorowy.jpg', 1),
(53, 'Mąka', '', '2-08-01-1', '', 'kg', '', 0),
(54, 'Drożdże', '', '2-10-01-1', 'Kostka', 'kg', '', 0),
(55, 'Mleko', '', '2-02-01-1', '', 'l', '', 0),
(56, 'Jajko', '', '2-02-02-1', '', 'Szt.', '', 0),
(57, 'Cukier wanilinowy', '', '2-09-01-1', 'Saszetka', 'kg', '', 0),
(58, 'Twaróg', '', '2-02-03-1', '', 'kg', '', 0),
(59, 'Cukier biały', '', '2-09-02-1', '', 'kg', '', 0),
(60, 'Śmietana 18% kwaśna', '', '2-02-04-1', '', 'kg', '', 0),
(61, 'Masło', '', '2-02-05-1', '', 'kg', '', 0),
(62, 'Śmietana 36%', '', '2-02-06-1', '', 'l', '', 0),
(63, 'Cytryna', '', '2-06-01-1', '', 'Szt.', '', 0),
(64, 'Proszek do pieczenia', '', '2-10-02-1', '', 'kg', '', 0),
(65, 'Budyń śmietankowy 100g', '', '2-10-03-1', '', 'Szt.', '', 0),
(66, 'Mascarpone', '', '2-02-07-1', '', 'kg', '', 0),
(67, 'Woda niegazowana', '', '2-11-01-1', '', 'l', '', 0),
(68, 'Płatki owsiane', '', '2-08-02-1', '', 'kg', '', 0),
(69, 'Kakao', '', '2-09-03-1', '', 'kg', '', 0),
(70, 'Oponki', '', '1-05-14-1', '3 sztuki', 'Szt.', 'oponki.jpg', 1),
(71, 'Lemon posett', '', '1-05-15-1', '', 'Szt.', 'lemonposett.jpg', 1),
(72, 'Sos', '', '2-11-02-1', '', 'l', '', 0),
(73, 'Ser feta', '', '2-02-08-1', '', 'kg', '', 0),
(74, 'Oliwki czarne', '', '2-06-02-1', '', 'kg', '', 0),
(75, 'Pomidorki cherry', '', '2-07-01-1', '', 'kg', '', 0),
(76, 'Cebula czerwona', '', '2-07-02-1', '', 'kg', '', 0),
(77, 'Ogórek', '', '2-07-03-1', '', 'kg', '', 0),
(78, 'Papryka', '', '2-07-04-1', '', 'kg', '', 0),
(79, 'Grzanka drobna', '', '2-01-03-1', '', 'kg', '', 0),
(80, 'Sałata', '', '2-07-05-1', '', 'kg', '', 0),
(81, 'Pomidor', '', '2-07-06-1', '', 'kg', '', 0),
(82, 'Bekon', '', '2-05-01-1', '', 'kg', '', 0),
(83, 'Burak', '', '2-07-07-1', '', 'kg', '', 0),
(84, 'Camembert', '', '2-02-09-1', '', 'kg', '', 0),
(85, 'Orzechy włoskie', '', '2-12-01-1', '', 'kg', '', 0),
(86, 'Orzeszki ziemne', '', '2-12-02-1', '', 'kg', '', 0),
(87, 'Pierś z kurczaka', '', '2-05-02-1', '', 'kg', '', 0),
(88, 'Ziemniaki', '', '2-07-08-1', '', 'kg', '', 0),
(89, 'Parmezan', '', '2-02-10-1', '', 'kg', '', 0),
(90, 'Pomidor suszony', '', '2-07-09-1', '', 'kg', '', 0),
(91, 'Mozarella', '', '2-02-11-1', '', 'kg', '', 0),
(92, 'Ananas', '', '2-06-03-1', '', 'kg', '', 0),
(93, 'Kukurydza', '', '2-07-10-1', '', 'kg', '', 0),
(94, 'Szynka', '', '2-05-03-1', '', 'kg', '', 0),
(95, 'Ser żółty', '', '2-02-12-1', '', 'kg', '', 0),
(96, 'Sałata szwedzka', '', '2-07-11-1', '', 'kg', '', 0),
(97, 'Sos BBQ', '', '2-11-03-1', '', 'kg', '', 0),
(98, 'Wieprzowina', '', '2-05-04-1', '', 'kg', '', 0),
(99, 'Ogórek kiszony', '', '2-07-12-1', '', 'kg', '', 0),
(100, 'Szczypiorek', '', '2-07-13-1', '', 'kg', '', 0),
(101, 'Rzodkiewka', '', '2-07-14-1', '', 'kg', '', 0),
(102, 'Majonez', '', '2-11-04-1', '', 'kg', '', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `product_quantity`
--

CREATE TABLE IF NOT EXISTS `product_quantity` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `w_id` int(11) NOT NULL,
  `p_id` int(11) NOT NULL,
  `u_id` int(11) NOT NULL,
  `amount` float NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp(),
  `old_amount` int(11) NOT NULL,
  `transaction_type` varchar(6) NOT NULL,
  `scan_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `product_quantity`
--

TRUNCATE TABLE `product_quantity`;
--
-- Dumping data for table `product_quantity`
--

INSERT INTO `product_quantity` (`id`, `w_id`, `p_id`, `u_id`, `amount`, `date`, `old_amount`, `transaction_type`, `scan_id`) VALUES
(1, 1, 2, 1, 100, '2024-04-15 13:27:50', 0, 'set', NULL),
(2, 1, 2, 1, 50, '2024-04-16 20:27:50', 100, 'set', NULL),
(3, 1, 4, 1, 5, '2024-04-16 21:18:13', 0, 'add', NULL),
(4, 1, 2, 1, 5, '2024-04-16 21:18:13', 0, 'add', NULL),
(5, 1, 2, 1, 5, '2024-04-16 21:18:15', 0, 'sub', NULL),
(6, 1, 1, 1, 20, '2024-04-17 18:56:11', -6, 'set', NULL),
(7, 1, 2, 1, 40, '2024-04-17 18:56:11', 50, 'set', NULL),
(8, 1, 3, 1, 8, '2024-04-17 18:56:11', 5, 'set', NULL),
(9, 1, 4, 1, 10, '2024-04-17 18:56:11', 3, 'set', NULL),
(10, 1, 5, 1, 8, '2024-04-17 18:56:11', 0, 'set', NULL),
(11, 1, 1, 1, 22, '2024-04-17 19:38:44', 20, 'set', NULL),
(12, 1, 2, 1, 40, '2024-04-17 19:38:44', 40, 'set', NULL),
(13, 1, 3, 1, 8, '2024-04-17 19:38:44', 8, 'set', NULL),
(14, 1, 4, 1, 10, '2024-04-17 19:38:44', 10, 'set', NULL),
(15, 1, 5, 1, 8, '2024-04-17 19:38:44', 8, 'set', NULL),
(16, 2, 1, 1, 0, '2024-04-17 20:02:43', -32, 'set', NULL),
(17, 2, 2, 1, 0, '2024-04-17 20:02:43', 0, 'set', NULL),
(18, 2, 3, 1, 0, '2024-04-17 20:02:43', 0, 'set', NULL),
(19, 2, 4, 1, 0, '2024-04-17 20:02:43', -15, 'set', NULL),
(20, 2, 5, 1, 0, '2024-04-17 20:02:43', -3, 'set', NULL),
(21, 4, 1, 1, 0, '2024-04-18 18:13:23', -10, 'set', NULL),
(22, 1, 1, 1, 5, '2024-04-18 18:13:40', 0, 'add', NULL),
(23, 1, 1, 1, 2, '2024-04-18 18:15:16', 30, 'add', NULL),
(24, 1, 4, 1, 2, '2024-04-18 18:21:01', 10, 'sub', NULL),
(25, 1, 1, 1, 0, '2024-04-25 08:34:35', -56, 'set', NULL),
(26, 1, 2, 1, 0, '2024-04-25 08:34:35', 40, 'set', NULL),
(27, 1, 4, 1, 0, '2024-04-25 08:34:35', -46, 'set', NULL),
(28, 1, 5, 1, 0, '2024-04-25 08:34:35', -36, 'set', NULL),
(29, 1, 3, 1, 0, '2024-04-25 08:34:41', 8, 'set', NULL),
(30, 3, 2, 1, 0, '2024-04-25 08:35:17', 5, 'set', NULL),
(31, 3, 3, 1, 0, '2024-04-25 08:35:17', 5, 'set', NULL),
(32, 1, 2, 1, 10, '2024-04-25 08:35:41', 0, 'set', NULL),
(33, 1, 3, 1, 1, '2024-04-25 08:35:41', 0, 'set', NULL),
(34, 1, 2, 1, 2, '2024-04-25 09:35:21', 10, 'sub', NULL),
(35, 1, 3, 1, 2, '2024-04-25 09:35:44', 1, 'add', NULL),
(36, 2, 2, 1, 2, '2024-04-25 09:35:54', 0, 'add', NULL),
(37, 2, 3, 1, 1, '2024-04-25 09:35:54', 0, 'add', NULL),
(64, 1, 2, 1, 1, '2024-04-26 09:14:20', 0, 'sub', 55),
(65, 1, 3, 1, 0.001, '2024-04-26 09:14:20', 0, 'sub', 55),
(66, 3, 2, 1, 20, '2024-04-26 09:48:01', 0, 'set', NULL),
(67, 3, 3, 1, 20, '2024-04-26 09:48:01', 0, 'set', NULL),
(68, 1, 1, 2, 0, '2024-05-08 12:40:17', -12, 'set', NULL),
(69, 1, 2, 2, 0, '2024-05-08 12:40:17', 7, 'set', NULL),
(70, 1, 4, 2, 0, '2024-05-08 12:40:17', -10, 'set', NULL),
(71, 1, 8, 2, 0, '2024-05-08 12:40:17', 1, 'set', NULL),
(72, 1, 3, 2, 0, '2024-05-08 12:40:59', 3, 'set', NULL),
(73, 1, 2, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(74, 1, 3, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(75, 1, 53, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(76, 1, 54, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(77, 1, 55, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(78, 1, 56, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(79, 1, 57, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(80, 1, 58, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(81, 1, 59, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(82, 1, 60, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(83, 1, 61, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(84, 1, 62, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(85, 1, 63, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(86, 1, 64, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(87, 1, 65, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(88, 1, 66, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(89, 1, 67, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(90, 1, 68, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(91, 1, 69, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(92, 1, 72, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(93, 1, 73, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(94, 1, 74, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(95, 1, 75, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(96, 1, 76, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(97, 1, 77, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(98, 1, 78, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(99, 1, 79, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(100, 1, 80, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(101, 1, 81, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(102, 1, 82, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(103, 1, 83, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(104, 1, 84, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(105, 1, 85, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(106, 1, 86, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(107, 1, 87, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(108, 1, 88, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(109, 1, 89, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(110, 1, 90, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(111, 1, 91, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(112, 1, 92, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(113, 1, 93, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(114, 1, 94, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL),
(115, 1, 95, 2, 100, '2024-05-08 12:42:25', 0, 'set', NULL);

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
) ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `product_scans`
--

TRUNCATE TABLE `product_scans`;
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
(32, 1, 1, '1-01-01-1', '111111111111111', 1, 1, '2024-04-25 20:32:05'),
(33, 1, 1, '1-01-01-1', '111111111111111', 1, 1, '2024-04-25 20:32:06'),
(49, 8, 1, '1-02-01-1', '', 2, 1, '2024-04-25 09:09:06'),
(50, 8, 1, '1-02-01-1', '', 1, 0, '2024-04-26 09:10:44'),
(51, 8, 1, '1-02-01-1', '', 1, 0, '2024-04-26 09:10:58'),
(52, 8, 1, '1-02-01-1', '', 1, 0, '2024-04-26 09:12:24'),
(53, 8, 1, '1-02-01-1', '', 1, 0, '2024-04-26 09:12:26'),
(54, 8, 1, '1-02-01-1', '', 1, 0, '2024-04-26 09:12:27'),
(55, 8, 1, '1-02-01-1', '', 1, 1, '2024-04-25 09:14:20');

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `recipes`
--

TRUNCATE TABLE `recipes`;
--
-- Dumping data for table `recipes`
--

INSERT INTO `recipes` (`id`, `p_id`, `active`, `description`, `r_name`, `u_id`, `date`) VALUES
(1, 13, 1, 'Przepis przewiduje 20 porcji', 'Racuchy 3 sztuki', 2, '2024-04-20 20:30:57'),
(2, 70, 1, 'Przepis przewiduje 15 porcji', 'Oponki 3 sztuki', 2, '2024-04-20 21:20:20'),
(3, 34, 1, 'Przepis przewiduje 3 porcje', 'Rolada biszkoptowa 3 plastry', 2, '2024-05-08 11:49:54'),
(4, 71, 1, 'Przepis przewiduje 18 porcji', 'Lemon posett', 2, '2024-05-08 11:54:07'),
(5, 5, 1, '', 'Sałatka grecka', 2, '2024-05-08 12:18:16'),
(6, 22, 1, '', 'Sałatka z jajkiem', 2, '2024-05-08 12:18:29'),
(7, 23, 1, '', 'Sałatka z burakiem', 2, '2024-05-08 12:18:46'),
(8, 4, 1, '', 'Sałatka pieczone nugetsy', 2, '2024-05-08 12:19:01'),
(9, 1, 1, '', 'Sałatka cezar', 2, '2024-05-08 12:19:08'),
(10, 6, 1, '', 'Sałatka włoska', 2, '2024-05-08 12:19:16'),
(11, 7, 1, '', 'Sałatka ser, szynka, ananas', 2, '2024-05-08 12:19:45'),
(12, 9, 1, '', 'Kanapka kurczak', 2, '2024-05-08 13:06:00'),
(13, 39, 1, 'Brakuje pasty', '[!] Kanapka z jajkiem', 2, '2024-05-08 13:06:29'),
(14, 8, 1, '', 'Kanapka BBQ', 2, '2024-05-08 13:06:36'),
(15, 10, 1, 'Brakuje pasty', '[!] Pasta tuńczyk', 2, '2024-05-08 13:06:48'),
(16, 15, 1, '', 'Kanapka tortilla', 2, '2024-05-08 13:06:58'),
(17, 24, 1, 'Brakuje pasty', '[!] Kanapka łosoś', 2, '2024-05-08 13:07:27'),
(18, 33, 1, '', 'Kanapka twaróg', 2, '2024-05-08 13:07:40');

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
) ENGINE=InnoDB AUTO_INCREMENT=129 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `recipe_details`
--

TRUNCATE TABLE `recipe_details`;
--
-- Dumping data for table `recipe_details`
--

INSERT INTO `recipe_details` (`id`, `r_id`, `sub_prod`, `amount`) VALUES
(21, 1, 53, 0.1),
(22, 1, 54, 0.01),
(23, 1, 55, 0.1),
(24, 1, 56, 0.2),
(25, 1, 57, 0.002),
(26, 2, 53, 0.067),
(27, 2, 54, 0.0067),
(28, 2, 56, 0.33),
(29, 2, 58, 0.067),
(30, 2, 59, 0.01467),
(31, 2, 60, 0.002),
(32, 2, 61, 0.0167),
(33, 3, 53, 0.25),
(34, 3, 56, 1.67),
(35, 3, 59, 0.25),
(36, 3, 64, 0.005),
(37, 4, 59, 0.0278),
(38, 4, 62, 0.67),
(39, 4, 63, 0.89),
(40, 5, 72, 0.05),
(41, 5, 73, 0.04),
(42, 5, 74, 0.015),
(43, 5, 75, 0.04),
(44, 5, 76, 0.02),
(45, 5, 77, 0.06),
(46, 5, 78, 0.03),
(47, 5, 79, 0.01),
(48, 5, 80, 0.16),
(49, 6, 56, 1.5),
(50, 6, 72, 0.05),
(51, 6, 77, 0.04),
(52, 6, 79, 0.01),
(53, 6, 80, 0.16),
(54, 6, 81, 0.04),
(55, 6, 82, 0.015),
(56, 7, 72, 0.05),
(57, 7, 75, 0.04),
(58, 7, 80, 0.16),
(59, 7, 83, 0.05),
(60, 7, 84, 0.07),
(61, 7, 85, 0.015),
(62, 8, 72, 0.05),
(63, 8, 77, 0.06),
(64, 8, 80, 0.16),
(65, 8, 81, 0.04),
(66, 8, 87, 0.08),
(67, 8, 88, 0.06),
(68, 9, 72, 0.05),
(69, 9, 77, 0.06),
(70, 9, 79, 0.015),
(71, 9, 80, 0.16),
(72, 9, 81, 0.04),
(73, 9, 82, 0.015),
(74, 9, 89, 0.01),
(75, 10, 72, 0.05),
(76, 10, 75, 0.04),
(77, 10, 77, 0.04),
(78, 10, 79, 0.015),
(79, 10, 80, 0.16),
(80, 10, 90, 0.01),
(81, 10, 91, 0.06),
(82, 11, 77, 0.04),
(83, 11, 79, 0.01),
(84, 11, 80, 0.16),
(85, 11, 92, 0.04),
(86, 11, 93, 0.04),
(87, 11, 94, 0.04),
(88, 11, 95, 0.04),
(89, 12, 2, 0.5),
(90, 12, 72, 0.01),
(91, 12, 80, 0.015),
(92, 12, 81, 0.03),
(93, 12, 87, 0.08),
(94, 12, 96, 0.03),
(98, 13, 2, 0.5),
(99, 13, 80, 0.015),
(100, 13, 99, 0.015),
(101, 13, 102, 0.015),
(102, 14, 2, 0.5),
(103, 14, 76, 0.01),
(104, 14, 80, 0.015),
(105, 14, 96, 0.02),
(106, 14, 97, 0.015),
(107, 14, 98, 0.1),
(108, 15, 2, 0.5),
(109, 15, 76, 0.01),
(110, 15, 80, 0.015),
(116, 16, 3, 1),
(117, 16, 72, 0.02),
(118, 16, 80, 0.05),
(119, 16, 81, 0.04),
(120, 16, 87, 0.08),
(121, 16, 96, 0.04),
(122, 17, 2, 0.5),
(123, 17, 80, 0.015),
(124, 17, 100, 0.01),
(125, 18, 2, 0.5),
(126, 18, 58, 0.1),
(127, 18, 80, 0.015),
(128, 18, 101, 0.01);

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
-- Tabela Truncate przed wstawieniem `returns`
--

TRUNCATE TABLE `returns`;
--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `w_id`, `p_id`, `date`, `u_id`, `amount`) VALUES
(1, 1, 2, '2024-04-15 19:09:13', 1, 4),
(2, 1, 5, '2024-04-15 19:10:04', 1, 2),
(3, 1, 5, '2024-04-15 19:10:35', 1, 1),
(4, 2, 1, '2024-04-24 19:08:09', 1, 2);

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
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `roles_name`
--

TRUNCATE TABLE `roles_name`;
--
-- Dumping data for table `roles_name`
--

INSERT INTO `roles_name` (`id`, `role_name`, `role_description`, `r_active`) VALUES
(1, 'Superadmin', 'Super administrator', 1),
(2, 'Administrator', 'Administrator', 1),
(3, 'Handlowiec', 'Handlowiec', 1),
(4, 'Administracja', '', 1),
(5, 'Kierowca', '', 1),
(6, 'Magazynier', '', 1),
(7, 'Zaopatrzeniowiec', '', 1),
(8, 'Konserwator', '', 1),
(9, 'Kucharz', '', 1);

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
) ENGINE=InnoDB AUTO_INCREMENT=93 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `sales`
--

TRUNCATE TABLE `sales`;
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
(10, 1, 0, '', '2024-04-21 20:54:57', 1, 2),
(11, 1, 4, '', '2024-04-22 11:33:35', 1, 5),
(12, 1, 4, '', '2024-04-22 11:33:35', 4, 2),
(13, 1, 2, '', '2024-04-22 11:33:50', 1, 5),
(14, 1, 2, '', '2024-04-22 11:33:50', 4, 2),
(15, 1, 1, 'scan', '2024-04-23 11:55:08', 1, 1),
(16, 1, 1, 'scan', '2024-04-23 11:59:28', 1, 1),
(17, 1, 1, 'scan', '2024-04-23 11:59:47', 1, 1),
(18, 1, 2, 'scan', '2024-04-23 12:00:00', 1, 1),
(19, 1, 2, 'scan', '2024-04-23 12:00:34', 1, 1),
(20, 1, 4, 'scan', '2024-04-23 12:03:53', 1, 1),
(21, 1, 4, 'scan', '2024-04-23 12:04:14', 1, 1),
(22, 1, 4, 'scan', '2024-04-23 12:04:44', 1, 1),
(23, 1, 3, 'scan', '2024-04-23 12:15:34', 1, 1),
(24, 1, 0, 'scan', '2024-04-23 12:15:49', 1, 1),
(25, 1, 3, 'scan', '2024-04-23 12:16:03', 1, 1),
(26, 1, 0, 'scan', '2024-04-23 12:16:12', 1, 1),
(27, 1, 3, 'scan', '2024-04-23 12:18:49', 1, 1),
(28, 1, 0, 'scan', '2024-04-23 12:19:58', 1, 1),
(29, 1, 0, 'scan', '2024-04-23 12:20:21', 1, 1),
(30, 1, 1, 'scan', '2024-04-23 12:20:34', 1, 1),
(31, 1, 1, 'scan', '2024-04-23 12:22:53', 1, 1),
(32, 1, 3, 'scan', '2024-04-23 12:23:02', 1, 1),
(33, 1, 3, 'scan', '2024-04-23 12:23:11', 1, 1),
(34, 1, 3, 'scan', '2024-04-23 12:24:43', 1, 1),
(35, 1, 3, 'scan', '2024-04-23 12:24:48', 1, 1),
(36, 1, 2, 'scan', '2024-04-23 13:10:18', 1, 1),
(37, 1, 2, 'scan', '2024-04-23 13:10:29', 1, 1),
(38, 1, 2, 'scan', '2024-04-23 13:13:12', 1, 1),
(39, 1, 2, 'scan', '2024-04-23 13:16:18', 5, 1),
(40, 1, 2, 'scan', '2024-04-23 13:16:22', 4, 1),
(41, 1, 2, 'scan', '2024-04-23 13:16:27', 1, 1),
(42, 1, 2, 'scan', '2024-04-23 13:16:31', 1, 1),
(43, 1, 2, 'scan', '2024-04-23 13:16:35', 1, 1),
(44, 1, 2, 'scan', '2024-04-23 13:16:39', 1, 1),
(45, 1, 2, 'scan', '2024-04-23 13:16:45', 4, 1),
(46, 1, 2, 'scan', '2024-04-23 13:16:49', 5, 1),
(47, 1, 2, 'scan', '2024-04-23 13:16:53', 4, 1),
(48, 1, 2, 'scan', '2024-04-23 13:17:00', 1, 1),
(49, 1, 2, 'scan', '2024-04-23 13:17:04', 4, 1),
(50, 1, 2, 'scan', '2024-04-23 13:17:09', 4, 1),
(51, 1, 2, 'scan', '2024-04-23 13:17:16', 4, 1),
(52, 1, 2, 'scan', '2024-04-23 13:17:20', 5, 1),
(53, 1, 2, 'scan', '2024-04-23 13:18:03', 4, 1),
(54, 1, 2, 'scan', '2024-04-23 13:18:44', 5, 1),
(55, 1, 2, 'scan', '2024-04-23 13:20:06', 5, 1),
(56, 1, 3, 'scan', '2024-04-23 13:22:07', 5, 1),
(57, 1, 3, 'scan', '2024-04-23 13:22:12', 4, 1),
(58, 1, 3, 'scan', '2024-04-23 13:22:18', 1, 1),
(59, 1, 3, 'scan', '2024-04-23 13:22:24', 4, 1),
(60, 1, 0, '', '2024-04-23 13:41:49', 1, 1),
(61, 1, 0, 'gratis', '2024-04-23 13:42:03', 1, 1),
(62, 1, 0, 'gratis', '2024-04-23 13:42:21', 1, 5),
(63, 1, 0, 'gratis', '2024-04-23 13:42:21', 4, 5),
(64, 1, 0, 'gratis', '2024-04-23 13:42:21', 5, 5),
(65, 1, 0, '', '2024-04-23 13:42:33', 1, 5),
(66, 1, 0, '', '2024-04-23 13:42:33', 4, 5),
(67, 1, 0, '', '2024-04-23 13:42:33', 5, 5),
(68, 1, 2, 'scan', '2024-04-24 08:02:55', 1, 1),
(69, 1, 2, 'scan', '2024-04-24 08:03:36', 5, 1),
(70, 1, 3, 'scan', '2024-04-24 08:03:53', 5, 1),
(71, 1, 1, 'scan', '2024-04-24 08:04:03', 5, 1),
(72, 1, 4, 'gratis', '2024-04-24 10:30:33', 5, 1),
(73, 1, 1, '', '2024-04-24 10:30:46', 5, 1),
(74, 1, 0, 'scan', '2024-04-24 10:45:33', 5, 1),
(75, 1, 1, 'scan', '2024-04-24 10:45:56', 5, 1),
(76, 1, 0, 'gratis', '2024-04-24 20:00:17', 4, 2),
(77, 1, 1, '', '2024-04-24 20:21:50', 1, 1),
(78, 1, 2, 'gratis', '2024-04-24 20:21:55', 4, 1),
(79, 1, 3, 'scan', '2024-04-25 06:25:09', 1, 1),
(80, 1, 3, 'scan', '2024-04-25 06:25:23', 8, 1),
(81, 1, 2, 'scan', '2024-04-25 12:28:07', 1, 1),
(82, 1, 2, 'scan', '2024-04-25 12:28:21', 1, 1),
(83, 1, 2, 'scan', '2024-04-25 12:28:24', 1, 1),
(84, 1, 3, 'scan', '2024-04-25 13:33:11', 1, 1),
(85, 1, 3, 'scan', '2024-04-25 13:33:29', 1, 1),
(86, 1, 0, '', '2024-04-26 12:25:13', 1, 1),
(87, 1, 0, '', '2024-04-26 12:25:13', 4, 2),
(88, 1, 0, 'destroy', '2024-04-26 12:25:19', 1, 1),
(89, 1, 0, 'destroy', '2024-04-26 12:25:19', 4, 2),
(90, 1, 0, 'gratis', '2024-04-26 12:25:24', 1, 1),
(91, 1, 0, 'gratis', '2024-04-26 12:25:24', 4, 2),
(92, 1, 1, '', '2024-04-30 13:44:03', 1, 1);

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
  `phone_business` varchar(13) DEFAULT NULL,
  `phone_private` varchar(13) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `users`
--

TRUNCATE TABLE `users`;
--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `first_name`, `last_name`, `password`, `u_role`, `u_warehouse`, `active`, `date`, `phone_business`, `phone_private`) VALUES
(1, 'test@test.pl', 'Imię', 'Nazwisko', 'test', 3, 1, 1, '2024-05-07 13:27:33', '', ''),
(2, 'mateusz.zybura@gmail.com', 'Mateusz', 'Zybura', '#Verona123', 1, 1, 1, '2024-05-07 13:27:38', '', '609713824'),
(3, 'mateusz.budniak@radluks.pl', 'Mateusz', 'Budniak', 'hgo6pEXf9$MS$^#B@%Nz', 3, 1, 1, '2024-05-06 13:18:07', '', NULL),
(4, 'eliza.malek@radluks.pl', 'Eliza', 'Małek', 'qhWWKjKKVTy*PVn$TRV9', 3, 1, 1, '2024-05-07 07:07:11', '', NULL),
(5, 'magdalena.majcherek@radluks.pl', 'Magdalena', 'Majcherek', '%U%ti9JpoSDgGmkc7o2y', 3, 1, 1, '2024-05-07 08:15:32', '', NULL),
(6, 'kamila.sliwinska@radluks.pl', 'Kamila', 'Śliwińska', 's^9fMmVZMT29KnypqP5f', 3, 1, 1, '2024-05-07 10:02:41', '', NULL),
(7, 'andrzej.slomski@radluks.pl', 'Andrzej', 'Słomski', 'MA^HyiacZHghQexzP9ep', 3, 1, 1, '2024-05-07 11:15:34', '', NULL);

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
-- Tabela Truncate przed wstawieniem `warehouses`
--

TRUNCATE TABLE `warehouses`;
--
-- Dumping data for table `warehouses`
--

INSERT INTO `warehouses` (`id`, `id_city`, `wh_name`, `wh_fullname`, `wh_description`, `w_active`) VALUES
(1, 1, 'MAIN', 'Główna siedziba', 'Wernera 33/37', 1),
(2, 1, 'PR1', 'Produkcja 1', 'Adres 1', 1),
(3, 1, 'PR2', 'Produkcja 2', 'Adres 2', 1),
(4, 3, 'GO', 'Galeria Ostrowiec', '', 0);

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `warehouse_access`
--

CREATE TABLE IF NOT EXISTS `warehouse_access` (
  `wa_id` int(11) NOT NULL AUTO_INCREMENT,
  `u_id` int(11) NOT NULL,
  `w_id` int(11) NOT NULL,
  PRIMARY KEY (`wa_id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Tabela Truncate przed wstawieniem `warehouse_access`
--

TRUNCATE TABLE `warehouse_access`;
--
-- Dumping data for table `warehouse_access`
--

INSERT INTO `warehouse_access` (`wa_id`, `u_id`, `w_id`) VALUES
(9, 1, 1),
(10, 1, 2),
(11, 1, 3),
(12, 2, 1),
(13, 2, 2),
(14, 2, 3),
(15, 3, 1),
(16, 4, 1),
(17, 5, 1),
(18, 6, 1),
(19, 7, 1);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
