SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;


CREATE TABLE `gift` (
  `ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `bemerkung` text NOT NULL,
  `betrag` varchar(12) NOT NULL,
  `randomid` int(4) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `guestbook` (
  `ID` int(11) NOT NULL,
  `name` varchar(35) CHARACTER SET utf8 NOT NULL,
  `email` varchar(35) CHARACTER SET utf8 NOT NULL,
  `datum` datetime NOT NULL,
  `nachricht` text CHARACTER SET utf8 NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `guest_register` (
  `ID` int(10) UNSIGNED NOT NULL,
  `teilnahme` enum('Ja','Nein') NOT NULL,
  `vorname` varchar(50) CHARACTER SET utf8 NOT NULL,
  `firma_verein` varchar(50) NOT NULL,
  `name` varchar(50) CHARACTER SET utf8 NOT NULL,
  `email` varchar(200) CHARACTER SET utf8 NOT NULL,
  `bemerkung` text CHARACTER SET utf8 NOT NULL,
  `anz_erwachsene` int(2) DEFAULT NULL,
  `anz_kinder` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
ALTER TABLE `guestbook`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;
ALTER TABLE `guest_register`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
ALTER TABLE `photo_album`
  MODIFY `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'Identifikationsnummer des Datensatzes', AUTO_INCREMENT=19;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;