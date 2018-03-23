CREATE DATABASE chat;
use chat;

CREATE TABLE `users` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(64) NOT NULL,
  `txtcolor` char(6) NOT NULL DEFAULT 'ABA319',
  `bckcolor` char(6) NOT NULL DEFAULT '1C1E06',
  `pending` text NOT NULL,
  `ip` varchar(45) NOT NULL,
  `laston` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `active` int(16) NOT NULL DEFAULT '-1',
  `lastactive` int(16) NOT NULL DEFAULT '-1',
  `prefix` varchar(16) NOT NULL DEFAULT '',
  `suffix` varchar(16) NOT NULL DEFAULT '',
  `quirks` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `chatroom` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `content` text NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `chatrooms` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `owner` varchar(16) NOT NULL,
  `users` text NOT NULL,
  `joinrestriction` int(2) NOT NULL,
  `name` varchar(32) NOT NULL,
  `passcode` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
ALTER TABLE `chat`.`chatrooms` AUTO_INCREMENT=2;
CREATE TABLE `privchatroom` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `content` text NOT NULL,
  `room` int(16) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE EVENT `cleaninactive` ON SCHEDULE EVERY 2 SECOND ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `chat`.`users` SET `active`=-1 WHERE TIMESTAMPDIFF(second, `laston`, CURRENT_TIMESTAMP)>1;
SET GLOBAL event_scheduler = ON;

GRANT ALL PRIVILEGES ON `chat`.* TO `chatter`@`localhost` IDENTIFIED BY 'GeArᛈᚨᛊᚹᚱᛥ';
GRANT ALL PRIVILEGES ON `chat`.* TO `chatadmin`@`localhost` IDENTIFIED BY 'autologicalis' WITH GRANT OPTION;
