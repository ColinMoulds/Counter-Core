-- phpMyAdmin SQL Dump
-- version 4.5.0.2
-- http://www.phpmyadmin.net
--
-- Gép: 127.0.0.1
-- Létrehozás ideje: 2016. Okt 07. 19:28
-- Kiszolgáló verziója: 10.0.17-MariaDB
-- PHP verzió: 5.6.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Adatbázis: `v3`
--

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `chat`
--

CREATE TABLE `chat` (
  `id` int(11) NOT NULL,
  `room` int(11) NOT NULL,
  `badge` int(11) NOT NULL,
  `name` varchar(70) CHARACTER SET utf8 NOT NULL,
  `steamid` varchar(70) NOT NULL,
  `avatar` varchar(500) CHARACTER SET utf8 NOT NULL,
  `msg` varchar(300) CHARACTER SET utf8 NOT NULL,
  `time` int(11) NOT NULL,
  `nc` varchar(20) NOT NULL,
  `mc` varchar(20) NOT NULL,
  `type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jackpotdeposits`
--

CREATE TABLE `jackpotdeposits` (
  `id` int(11) NOT NULL,
  `gameid` int(11) NOT NULL,
  `userid` varchar(70) NOT NULL,
  `username` varchar(100) NOT NULL,
  `useravatar` varchar(500) NOT NULL,
  `skin` varchar(300) NOT NULL,
  `assetid` varchar(70) NOT NULL,
  `offerid` varchar(70) NOT NULL,
  `color` varchar(20) NOT NULL,
  `cost` float NOT NULL,
  `image` varchar(500) NOT NULL,
  `rake` int(11) NOT NULL,
  `date` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `jackpotgames`
--

CREATE TABLE `jackpotgames` (
  `id` int(11) NOT NULL,
  `ostarttime` int(11) NOT NULL,
  `starttime` int(11) NOT NULL,
  `winnername` varchar(200) NOT NULL,
  `winnerid` varchar(70) NOT NULL,
  `percent` text NOT NULL,
  `value` text NOT NULL,
  `skins` int(11) NOT NULL,
  `module` varchar(100) NOT NULL,
  `endtime` int(11) NOT NULL,
  `rake` int(11) NOT NULL,
  `rakes` int(11) NOT NULL,
  `rakec` int(11) NOT NULL,
  `rakel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- A tábla adatainak kiíratása `jackpotgames`
--

INSERT INTO `jackpotgames` (`id`, `ostarttime`, `starttime`, `winnername`, `winnerid`, `percent`, `value`, `skins`, `module`, `endtime`, `rake`, `rakes`, `rakec`, `rakel`) VALUES
(1, 0, 2147483647, '', '', '', '', 0, '', 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `messages`
--

CREATE TABLE `messages` (
  `ID` int(11) NOT NULL,
  `type` varchar(300) NOT NULL,
  `app` int(11) NOT NULL,
  `userid` varchar(300) NOT NULL,
  `title` varchar(150) NOT NULL,
  `msg` varchar(300) CHARACTER SET utf8 NOT NULL,
  `time` int(11) NOT NULL,
  `active` int(11) NOT NULL,
  `delay` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `online_users`
--

CREATE TABLE `online_users` (
  `session` char(100) NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `steamid` varchar(70) NOT NULL,
  `credits` int(11) NOT NULL,
  `tlink` varchar(255) DEFAULT NULL,
  `email` varchar(150) NOT NULL,
  `won` float DEFAULT '0',
  `admin` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `games` int(11) NOT NULL,
  `gameswon` int(11) NOT NULL,
  `premium` int(11) NOT NULL,
  `puntil` int(11) NOT NULL,
  `reg` varchar(70) NOT NULL,
  `login` varchar(70) NOT NULL,
  `ban` int(11) NOT NULL,
  `banby` varchar(300) NOT NULL,
  `bandate` int(11) NOT NULL,
  `banend` int(11) NOT NULL,
  `banreason` varchar(300) NOT NULL,
  `cban` int(11) NOT NULL,
  `cbanby` varchar(300) NOT NULL,
  `cbandate` int(11) NOT NULL,
  `cbanend` int(11) NOT NULL,
  `cbanreason` varchar(300) NOT NULL,
  `profile` int(11) NOT NULL DEFAULT '1',
  `lastmsg` int(11) NOT NULL,
  `skinssent` int(11) NOT NULL,
  `profit` float NOT NULL,
  `lastseen` int(11) NOT NULL,
  `account_secret` varchar(30) NOT NULL,
  `lastaction` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tábla szerkezet ehhez a táblához `user_online`
--

CREATE TABLE `user_online` (
  `session` char(100) NOT NULL DEFAULT '',
  `time` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

--
-- Indexek a kiírt táblákhoz
--

--
-- A tábla indexei `chat`
--
ALTER TABLE `chat`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `jackpotdeposits`
--
ALTER TABLE `jackpotdeposits`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `jackpotgames`
--
ALTER TABLE `jackpotgames`
  ADD PRIMARY KEY (`id`);

--
-- A tábla indexei `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`ID`);

--
-- A tábla indexei `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- A kiírt táblák AUTO_INCREMENT értéke
--

--
-- AUTO_INCREMENT a táblához `chat`
--
ALTER TABLE `chat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT a táblához `jackpotdeposits`
--
ALTER TABLE `jackpotdeposits`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT a táblához `jackpotgames`
--
ALTER TABLE `jackpotgames`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT a táblához `messages`
--
ALTER TABLE `messages`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT a táblához `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
