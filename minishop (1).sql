-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1:3306
-- Tid vid skapande: 26 jun 2018 kl 17:51
-- Serverversion: 5.7.11
-- PHP-version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `minishop`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `permissions`
--

DROP TABLE IF EXISTS `permissions`;
CREATE TABLE IF NOT EXISTS `permissions` (
  `PermID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Permdesc` varchar(50) COLLATE utf8mb4_swedish_ci NOT NULL,
  `Updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`PermID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumpning av Data i tabell `permissions`
--

INSERT INTO `permissions` (`PermID`, `Permdesc`, `Updated_at`, `Created_at`) VALUES
(1, 'adminsettings', '2018-06-21 19:21:44', '2018-06-21 19:21:44');

-- --------------------------------------------------------

--
-- Tabellstruktur `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `ID` int(10) NOT NULL AUTO_INCREMENT,
  `Name` varchar(191) COLLATE utf8mb4_swedish_ci NOT NULL,
  `Price` float NOT NULL,
  `Stock` int(11) NOT NULL,
  `Productumber` int(11) NOT NULL,
  `Description` text COLLATE utf8mb4_swedish_ci NOT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumpning av Data i tabell `product`
--

INSERT INTO `product` (`ID`, `Name`, `Price`, `Stock`, `Productumber`, `Description`) VALUES
(4, 'Bugsprey', 1337, 4, 222, 'Sprejas på skärmen och alla buggar försvinner'),
(6, 'Tidsmaskin', 1, 4, 11, 'Defekt resar bara bakåt i tiden'),
(7, 'Svart låda', 666, 2, 999, 'Input: Allt möjligt Utput: 42');;

-- --------------------------------------------------------

--
-- Tabellstruktur `roles`
--

DROP TABLE IF EXISTS `roles`;
CREATE TABLE IF NOT EXISTS `roles` (
  `RoleID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `RoleName` varchar(50) COLLATE utf8mb4_swedish_ci NOT NULL,
  `Updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`RoleID`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumpning av Data i tabell `roles`
--

INSERT INTO `roles` (`RoleID`, `RoleName`, `Updated_at`, `Created_at`) VALUES
(1, 'Admin', '2018-06-21 19:20:56', '2018-06-21 19:20:56');

-- --------------------------------------------------------

--
-- Tabellstruktur `role_perm`
--

DROP TABLE IF EXISTS `role_perm`;
CREATE TABLE IF NOT EXISTS `role_perm` (
  `RoleID` int(10) UNSIGNED NOT NULL,
  `PermID` int(10) UNSIGNED NOT NULL,
  `Updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  KEY `RoleID` (`RoleID`),
  KEY `PermID` (`PermID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumpning av Data i tabell `role_perm`
--

INSERT INTO `role_perm` (`RoleID`, `PermID`, `Updated_at`, `Created_at`) VALUES
(1, 1, '2018-06-21 19:22:02', '2018-06-21 19:22:02');

-- --------------------------------------------------------

--
-- Tabellstruktur `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `Username` varchar(191) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `Pass` varchar(191) COLLATE utf8mb4_swedish_ci DEFAULT NULL,
  `IsBlocked` tinyint(1) DEFAULT '0',
  `NumberOfLoginAttempt` tinyint(1) DEFAULT '0',
  `Updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Username` (`Username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumpning av Data i tabell `users`
--

INSERT INTO `users` (`ID`, `Username`, `Pass`, `IsBlocked`, `NumberOfLoginAttempt`, `Updated_at`, `Created_at`) VALUES
(1, 'minishop@vadman.nu', '$argon2i$v=19$m=131072,t=8,p=3$UTNCdHh0cTZ4ZnQ0RHMwLw$8wzXWzCGB6wqzesCMsAXjHAqOxtIztlOYGrK8HAsgcQ', 0, 0, '2018-06-21 19:18:48', '2018-06-21 19:18:48');

-- --------------------------------------------------------

--
-- Tabellstruktur `user_role`
--

DROP TABLE IF EXISTS `user_role`;
CREATE TABLE IF NOT EXISTS `user_role` (
  `UserID` int(10) UNSIGNED NOT NULL,
  `RoleID` int(10) UNSIGNED NOT NULL,
  `Updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`UserID`,`RoleID`),
  KEY `RoleID` (`RoleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_swedish_ci;

--
-- Dumpning av Data i tabell `user_role`
--

INSERT INTO `user_role` (`UserID`, `RoleID`, `Updated_at`, `Created_at`) VALUES
(1, 1, '2018-06-21 19:22:11', '2018-06-21 19:22:11');

--
-- Restriktioner för dumpade tabeller
--

--
-- Restriktioner för tabell `role_perm`
--
ALTER TABLE `role_perm`
  ADD CONSTRAINT `role_perm_ibfk_1` FOREIGN KEY (`RoleID`) REFERENCES `roles` (`RoleID`),
  ADD CONSTRAINT `role_perm_ibfk_2` FOREIGN KEY (`PermID`) REFERENCES `permissions` (`PermID`);

--
-- Restriktioner för tabell `user_role`
--
ALTER TABLE `user_role`
  ADD CONSTRAINT `user_role_ibfk_1` FOREIGN KEY (`UserID`) REFERENCES `users` (`ID`),
  ADD CONSTRAINT `user_role_ibfk_2` FOREIGN KEY (`RoleID`) REFERENCES `roles` (`RoleID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
