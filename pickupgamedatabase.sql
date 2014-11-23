-- phpMyAdmin SQL Dump
-- version 4.2.7.1
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Nov 23, 2014 at 01:36 AM
-- Server version: 5.6.20
-- PHP Version: 5.5.15

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `pickupgamedatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `game`
--

CREATE TABLE IF NOT EXISTS `game` (
`Game_ID` int(11) NOT NULL,
  `GameName` varchar(50) NOT NULL,
  `Sport` varchar(50) NOT NULL,
  `MaxPlayersNum` int(11) NOT NULL,
  `DateAndTime` datetime NOT NULL,
  `Password` varchar(50) DEFAULT NULL,
  `Private` tinyint(1) NOT NULL,
  `Host_ID` int(11) NOT NULL,
  `Description` text,
  `Latitude` double NOT NULL,
  `Longitude` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `gameplayer`
--

CREATE TABLE IF NOT EXISTS `gameplayer` (
  `PlayerID` int(11) NOT NULL,
  `GameID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `hostratinggame`
--

CREATE TABLE IF NOT EXISTS `hostratinggame` (
  `PlayerEvaluated` int(11) NOT NULL,
  `PlayerRater` int(11) NOT NULL,
  `Rating` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `playerratinggame`
--

CREATE TABLE IF NOT EXISTS `playerratinggame` (
  `PlayerEvaluated` int(11) NOT NULL,
  `PlayerRater` int(11) NOT NULL,
  `Rating` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `sport`
--

CREATE TABLE IF NOT EXISTS `sport` (
  `SportName` varchar(50) NOT NULL,
  `Description` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `sport`
--

INSERT INTO `sport` (`SportName`, `Description`) VALUES
('Basketball', 'Throw a ball into the hoop');

-- --------------------------------------------------------

--
-- Table structure for table `userprofile`
--

CREATE TABLE IF NOT EXISTS `userprofile` (
`UserID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Age` int(11) NOT NULL,
  `UserName` varchar(50) NOT NULL,
  `Password` varchar(50) NOT NULL,
  `SecurityQuestion` varchar(150) NOT NULL,
  `SecurityAnswer` varchar(150) NOT NULL,
  `ImageLocation` varchar(200) DEFAULT NULL,
  `FavoriteSport1` varchar(50) DEFAULT NULL,
  `FavoriteSport2` varchar(50) DEFAULT NULL,
  `FavoriteSport3` varchar(50) DEFAULT NULL,
  `FavoriteSport4` varchar(50) DEFAULT NULL
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `userprofile`
--

INSERT INTO `userprofile` (`UserID`, `Name`, `Age`, `UserName`, `Password`, `SecurityQuestion`, `SecurityAnswer`, `ImageLocation`, `FavoriteSport1`, `FavoriteSport2`, `FavoriteSport3`, `FavoriteSport4`) VALUES
(1, 'Jason', 25, 'jrussr', '12345678', 'Test', 'Test', '', NULL, NULL, NULL, NULL),
(3, 'Jason Russell', 62, 'jrussr42', '234591', 'Test', 'Test', '', NULL, NULL, NULL, NULL),
(4, 'Tom', 63, 'hello', '13579', 'y', 'y', 'TestingURL', NULL, NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `game`
--
ALTER TABLE `game`
 ADD PRIMARY KEY (`Game_ID`), ADD KEY `Sport` (`Sport`), ADD KEY `Host_ID` (`Host_ID`);

--
-- Indexes for table `gameplayer`
--
ALTER TABLE `gameplayer`
 ADD PRIMARY KEY (`PlayerID`,`GameID`), ADD KEY `GameID` (`GameID`);

--
-- Indexes for table `hostratinggame`
--
ALTER TABLE `hostratinggame`
 ADD PRIMARY KEY (`PlayerEvaluated`,`PlayerRater`,`Rating`), ADD KEY `PlayerRater` (`PlayerRater`);

--
-- Indexes for table `playerratinggame`
--
ALTER TABLE `playerratinggame`
 ADD PRIMARY KEY (`PlayerEvaluated`,`PlayerRater`,`Rating`), ADD KEY `PlayerRater` (`PlayerRater`), ADD KEY `GameID` (`Rating`);

--
-- Indexes for table `sport`
--
ALTER TABLE `sport`
 ADD PRIMARY KEY (`SportName`);

--
-- Indexes for table `userprofile`
--
ALTER TABLE `userprofile`
 ADD PRIMARY KEY (`UserID`), ADD KEY `FavoriteSport1` (`FavoriteSport1`), ADD KEY `FavoriteSport2` (`FavoriteSport2`), ADD KEY `FavoriteSport3` (`FavoriteSport3`), ADD KEY `FavoriteSport4` (`FavoriteSport4`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `game`
--
ALTER TABLE `game`
MODIFY `Game_ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `userprofile`
--
ALTER TABLE `userprofile`
MODIFY `UserID` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `game`
--
ALTER TABLE `game`
ADD CONSTRAINT `game_ibfk_1` FOREIGN KEY (`Sport`) REFERENCES `sport` (`SportName`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `userprofile`
--
ALTER TABLE `userprofile`
ADD CONSTRAINT `userprofile_ibfk_1` FOREIGN KEY (`FavoriteSport1`) REFERENCES `sport` (`SportName`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `userprofile_ibfk_2` FOREIGN KEY (`FavoriteSport2`) REFERENCES `sport` (`SportName`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `userprofile_ibfk_3` FOREIGN KEY (`FavoriteSport3`) REFERENCES `sport` (`SportName`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `userprofile_ibfk_4` FOREIGN KEY (`FavoriteSport4`) REFERENCES `sport` (`SportName`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
