-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 18, 2020 at 09:49 PM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `andonovs_ssp`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_game`
--

CREATE TABLE `t_game` (
  `game_id` int(40) NOT NULL,
  `date_time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `is_won_by_player` int(10) NOT NULL,
  `rounds_num` int(10) NOT NULL,
  `nickname_id` int(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_game`
--

INSERT INTO `t_game` (`game_id`, `date_time`, `is_won_by_player`, `rounds_num`, `nickname_id`) VALUES
(1, '2020-03-18 20:40:16', 1, 3, 1),
(2, '2020-03-18 20:40:34', 1, 3, 3),
(3, '2020-03-18 20:40:54', 1, 3, 4),
(4, '2020-03-18 20:41:06', 1, 3, 4),
(5, '2020-03-18 20:41:25', 1, 3, 2),
(6, '2020-03-18 20:41:45', 1, 3, 7),
(7, '2020-03-18 20:42:01', 1, 3, 6),
(8, '2020-03-18 20:42:37', 1, 3, 6),
(9, '2020-03-18 20:42:47', 1, 3, 6),
(10, '2020-03-18 20:43:37', 1, 3, 1),
(11, '2020-03-18 20:44:40', 1, 3, 6),
(12, '2020-03-18 20:47:07', 1, 3, 6),
(13, '2020-03-18 20:48:18', 1, 3, 2);

-- --------------------------------------------------------

--
-- Table structure for table `t_nickname`
--

CREATE TABLE `t_nickname` (
  `nickname_id` int(40) NOT NULL,
  `nickname` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_nickname`
--

INSERT INTO `t_nickname` (`nickname_id`, `nickname`) VALUES
(1, 'Pesho'),
(2, 'Nikodim'),
(3, 'Gichka'),
(4, 'Stamat'),
(5, 'Pena'),
(6, 'Vute'),
(7, 'Nane'),
(8, 'Yanka');

-- --------------------------------------------------------

--
-- Table structure for table `t_round`
--

CREATE TABLE `t_round` (
  `rec_id` int(40) NOT NULL,
  `game_id` int(40) NOT NULL,
  `player_choice` varchar(40) NOT NULL,
  `pc_choice` varchar(40) NOT NULL,
  `player_point` int(40) NOT NULL,
  `pc_point` int(40) NOT NULL,
  `round_num` int(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_round`
--

INSERT INTO `t_round` (`rec_id`, `game_id`, `player_choice`, `pc_choice`, `player_point`, `pc_point`, `round_num`) VALUES
(1, 1, 'stone', 'scisors', 1, 0, 1),
(2, 1, 'stone', 'scisors', 1, 0, 2),
(3, 1, 'stone', 'scisors', 1, 0, 3),
(4, 2, 'stone', 'scisors', 1, 0, 1),
(5, 2, 'stone', 'scisors', 1, 0, 2),
(6, 2, 'paper', 'scisors', 0, 1, 3),
(7, 3, 'scisors', 'stone', 0, 1, 1),
(8, 3, 'paper', 'stone', 1, 0, 2),
(9, 3, 'paper', 'scisors', 0, 1, 3),
(10, 4, 'stone', 'scisors', 1, 0, 1),
(11, 4, 'stone', 'scisors', 1, 0, 2),
(12, 4, 'stone', 'scisors', 1, 0, 3),
(13, 5, 'stone', 'scisors', 1, 0, 1),
(14, 5, 'scisors', 'stone', 0, 1, 2),
(15, 5, 'paper', 'stone', 1, 0, 3),
(16, 6, 'stone', 'scisors', 1, 0, 1),
(17, 6, 'paper', 'stone', 1, 0, 2),
(18, 6, 'paper', 'scisors', 0, 1, 3),
(19, 7, 'stone', 'scisors', 1, 0, 1),
(20, 7, 'paper', 'stone', 1, 0, 2),
(21, 7, 'scisors', 'stone', 0, 1, 3),
(22, 8, 'stone', 'scisors', 1, 0, 1),
(23, 8, 'scisors', 'stone', 0, 1, 2),
(24, 8, 'paper', 'scisors', 0, 1, 3),
(25, 9, 'stone', 'scisors', 1, 0, 1),
(26, 9, 'stone', 'scisors', 1, 0, 2),
(27, 9, 'paper', 'scisors', 0, 1, 3),
(28, 10, 'stone', 'scisors', 1, 0, 1),
(29, 10, 'stone', 'scisors', 1, 0, 2),
(30, 10, 'paper', 'stone', 1, 0, 3),
(31, 11, 'stone', 'scisors', 1, 0, 1),
(32, 11, 'paper', 'scisors', 0, 1, 2),
(33, 11, 'paper', 'stone', 1, 0, 3),
(34, 12, 'stone', 'scisors', 1, 0, 1),
(35, 12, 'scisors', 'stone', 0, 1, 2),
(36, 12, 'paper', 'scisors', 0, 1, 3),
(37, 13, 'stone', 'scisors', 1, 0, 1),
(38, 13, 'stone', 'scisors', 1, 0, 2),
(39, 13, 'paper', 'stone', 1, 0, 3);

-- --------------------------------------------------------

--
-- Table structure for table `t_winner`
--

CREATE TABLE `t_winner` (
  `winner_id` int(40) NOT NULL,
  `winner` varchar(100) NOT NULL,
  `games_won_num` int(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `t_winner`
--

INSERT INTO `t_winner` (`winner_id`, `winner`, `games_won_num`) VALUES
(1, 'Pesho', 2),
(2, 'Gichka', 1),
(3, 'Computer', 1),
(4, 'Stamat', 1),
(5, 'Nikodim', 2),
(6, 'Nane', 1),
(7, 'Vute', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `t_game`
--
ALTER TABLE `t_game`
  ADD PRIMARY KEY (`game_id`);

--
-- Indexes for table `t_nickname`
--
ALTER TABLE `t_nickname`
  ADD PRIMARY KEY (`nickname_id`);

--
-- Indexes for table `t_round`
--
ALTER TABLE `t_round`
  ADD PRIMARY KEY (`rec_id`);

--
-- Indexes for table `t_winner`
--
ALTER TABLE `t_winner`
  ADD PRIMARY KEY (`winner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `t_game`
--
ALTER TABLE `t_game`
  MODIFY `game_id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `t_nickname`
--
ALTER TABLE `t_nickname`
  MODIFY `nickname_id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `t_round`
--
ALTER TABLE `t_round`
  MODIFY `rec_id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `t_winner`
--
ALTER TABLE `t_winner`
  MODIFY `winner_id` int(40) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
