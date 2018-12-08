SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


DROP TABLE IF EXISTS `gift`;
CREATE TABLE `gift` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `bemerkung` text NOT NULL,
  `betrag` varchar(12) NOT NULL,
  `randomid` int(4) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

DROP TABLE IF EXISTS `guestbook`;
CREATE TABLE `guestbook` (
  `ID` int(11) NOT NULL,
  `name` varchar(35) CHARACTER SET utf8 NOT NULL,
  `email` varchar(35) CHARACTER SET utf8 NOT NULL,
  `datum` datetime NOT NULL,
  `nachricht` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `guest_register`;
CREATE TABLE `guest_register` (
  `ID` int(10) UNSIGNED NOT NULL,
  `teilnahme` enum('Ja','Nein') NOT NULL,
  `anrede` enum('Frau','Herr','Familie','Firma','Verein') NOT NULL,
  `vorname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `firma_verein` varchar(50) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `strasse` varchar(50) CHARACTER SET utf8 NOT NULL,
  `postleitzahl` int(4) NOT NULL,
  `ort` varchar(27) CHARACTER SET utf8 NOT NULL,
  `email` varchar(200) CHARACTER SET utf8 NOT NULL,
  `bemerkung` text CHARACTER SET utf8 NOT NULL,
  `erw_apero` int(2) NOT NULL,
  `erw_kleineportion` int(2) NOT NULL,
  `erw_vegetarisch` int(2) NOT NULL,
  `erw_fleisch` int(2) NOT NULL,
  `kind_apero` int(2) NOT NULL,
  `kind_kleineportion` int(2) NOT NULL,
  `kind_vegetarisch` int(2) NOT NULL,
  `kind_fleisch` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

DROP TABLE IF EXISTS `photo_album`;
CREATE TABLE `photo_album` (
  `ID` int(10) UNSIGNED NOT NULL COMMENT 'Identifikationsnummer des Datensatzes',
  `bildpfad` varchar(250) NOT NULL,
  `originalname` varchar(250) NOT NULL,
  `datum` datetime NOT NULL,
  `userid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


ALTER TABLE `gift`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `guestbook`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `guest_register`
  ADD PRIMARY KEY (`ID`);

ALTER TABLE `photo_album`
  ADD PRIMARY KEY (`ID`);


ALTER TABLE `gift`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `guestbook`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
ALTER TABLE `guest_register`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;
ALTER TABLE `photo_album`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifikationsnummer des Datensatzes';
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;