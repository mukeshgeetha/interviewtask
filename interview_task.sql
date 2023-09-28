-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 28, 2023 at 11:09 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `interview_task`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `Insert_users` (IN `username` VARCHAR(255), IN `usermobile` VARCHAR(255), IN `useremail` VARCHAR(255), IN `userdob` DATE, IN `usergio_location` VARCHAR(255))   BEGIN
    INSERT INTO users (name, mobile, email, dob,gio_location) VALUES (username, usermobile, useremail, userdob, usergio_location);
END$$

--
-- Functions
--
CREATE DEFINER=`root`@`localhost` FUNCTION `GenerateRandomPassword` (`length` INT) RETURNS VARCHAR(255) CHARSET utf8mb4  BEGIN
    DECLARE characters VARCHAR(255) DEFAULT 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    DECLARE password_r VARCHAR(255) DEFAULT '';
    DECLARE i INT DEFAULT 1;

    WHILE i <= length DO
        SET password_r = CONCAT(password_r, SUBSTRING(characters, FLOOR(1 + RAND() * LENGTH(characters)), 1));
        SET i = i + 1;
    END WHILE;

    RETURN password_r;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `mobile` varchar(30) NOT NULL,
  `email` varchar(500) NOT NULL,
  `dob` date NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `gio_location` varchar(200) NOT NULL,
  `password` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `mobile`, `email`, `dob`, `created_at`, `gio_location`, `password`) VALUES
(57, 'mukeshkanna', '6673477346', 'msmukeshofficial26@gmail.com', '2023-09-28', '2023-09-28 14:36:40', 'Chennai,Tamil Nadu', '$2y$10$v9U6ZITHlCEbA2Lg0QzHzeKeF6Y9qtHFEXOxyTQn66w530XYUPVdm');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
