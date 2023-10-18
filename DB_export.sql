SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
CREATE DATABASE IF NOT EXISTS `toucantech` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `toucantech`;

CREATE TABLE `emails` (
  `UserRefID` int(6) UNSIGNED NOT NULL,
  `emailID` int(3) UNSIGNED NOT NULL,
  `emailaddress` varchar(20) NOT NULL,
  `Default` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `emails` VALUES
(100567, 567, 'j.smith@zmail.com', 0),
(100567, 568, 'j.smithh@zmail.com', 0),
(100567, 569, 'j.smithh@zmail.com', 1),
(100567, 570, 'j.smith@zmail.com', 0),
(100568, 571, 'johanna@zmail.com', 1);

CREATE TABLE `members` (
  `id` int(2) UNSIGNED NOT NULL,
  `Name` varchar(20) NOT NULL,
  `emailaddress` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `members` VALUES
(5, 'asd', 'asd@asd.com'),
(6, 'qwe', 'qwe@qwe.com'),
(7, 'zxcz', 'zxcz@zxcz.com');

CREATE TABLE `memberships` (
  `memberId` int(2) UNSIGNED NOT NULL,
  `schoolId` int(2) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `memberships` VALUES
(5, 1),
(5, 3),
(6, 1),
(6, 2),
(7, 1),
(7, 2),
(7, 3);

CREATE TABLE `profiles` (
  `UserRefID` int(6) UNSIGNED NOT NULL,
  `Firstname` varchar(10) NOT NULL,
  `Surname` varchar(10) NOT NULL,
  `Deceased` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `profiles` VALUES
(100567, 'John', 'Smith', 0),
(100568, 'Johnna', 'Smith', 1);

CREATE TABLE `schools` (
  `id` int(2) UNSIGNED NOT NULL,
  `Name` varchar(15) NOT NULL,
  `Country` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

INSERT INTO `schools` VALUES
(1, 'First school', 'uk'),
(2, 'Second school', 'usa'),
(3, 'Third school', 'uk');


ALTER TABLE `emails`
  ADD PRIMARY KEY (`UserRefID`,`emailID`);

ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `memberships`
  ADD PRIMARY KEY (`memberId`,`schoolId`);

ALTER TABLE `profiles`
  ADD PRIMARY KEY (`UserRefID`);

ALTER TABLE `schools`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Country` (`Country`);


ALTER TABLE `members`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

ALTER TABLE `profiles`
  MODIFY `UserRefID` int(6) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=100569;

ALTER TABLE `schools`
  MODIFY `id` int(2) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;