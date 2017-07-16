
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


--
-- Table structure for table `bots`
--

CREATE TABLE IF NOT EXISTS `bots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `online` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `steamid` varchar(17) NOT NULL,
  `shared_secret` varchar(28) NOT NULL,
  `identity_secret` varchar(28) NOT NULL,
  `accountName` varchar(32) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `items`
--

CREATE TABLE IF NOT EXISTS `items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `trade` bigint(20) NOT NULL,
  `market_hash_name` varchar(512) NOT NULL,
  `status` int(11) NOT NULL,
  `img` text NOT NULL,
  `botid` int(11) NOT NULL,
  `time` bigint(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf32 AUTO_INCREMENT=1324 ;

-- --------------------------------------------------------

--
-- Table structure for table `trades`
--

CREATE TABLE IF NOT EXISTS `trades` (
  `id` bigint(11) NOT NULL,
  `bot_id` int(11) NOT NULL,
  `status` int(11) NOT NULL,
  `user` varchar(17) NOT NULL,
  `summa` int(16) NOT NULL,
  `code` varchar(16) NOT NULL,
  `time` bigint(20) NOT NULL,
  UNIQUE KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE  `users` ADD  `canWithdraw` INT NOT NULL DEFAULT  '1';
ALTER TABLE  `users` ADD  `deposited` INT NOT NULL DEFAULT  '0';
ALTER TABLE  `users` ADD  `withdrawLimit` INT NOT NULL DEFAULT  '0';

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
