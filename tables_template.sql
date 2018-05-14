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
  `seemove` BOOLEAN NOT NULL DEFAULT 0,
  `quirks` text NOT NULL,
  `pendingpms` varchar(256) NOT NULL DEFAULT '',
  `permissions` INT NOT NULL DEFAULT '0',
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
CREATE TABLE `userchatroom` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `content` text NOT NULL,
  `recipient` varchar(16) NOT NULL,
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE `bots` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `type` varchar(16) NOT NULL,
  `room` int(16) NOT NULL,
  `data` text NOT NULL,
  `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/*DELIMITER $$
CREATE DEFINER=`chatadmin`@`localhost` PROCEDURE `detectMove` () BEGIN
    DECLARE u varchar(16) DEFAULT "";
    DECLARE old INT DEFAULT -1;
    DECLARE new INT DEFAULT -1;
    DECLARE n INT DEFAULT 0;
    DECLARE i INT DEFAULT 0;
    UPDATE `chat`.`users` SET `active`=-1 WHERE TIMESTAMPDIFF(second, `laston`, CURRENT_TIMESTAMP)>1;
    SELECT MAX(id) FROM `chat`.`users` INTO n;
    SET i=0;
    SET n=n+1;
    WHILE i<n DO
        IF EXISTS(SELECT `id` FROM `users` WHERE `id`=i) THEN
            SELECT `username`,`lastactive`,`active` INTO u,old,new FROM `users` WHERE `id`=i;
            IF new!=old THEN
                IF old=1 THEN
                    INSERT INTO `chat`.`chatroom` (`id`,`username`,`content`) VALUES (0,'left',CONCAT(u,' has left the chat room.'));
                ELSEIF old>1 THEN
                    INSERT INTO `chat`.`privchatroom` (`id`,`username`,`content`,`room`) VALUES (0,'left',CONCAT(u,' has left the chat room.'),old);
                ELSE INSERT INTO `chat`.`errors` (`id`,`data`) VALUES (0,CONCAT('line 18 ',u,' ',new,' ',old));
                END IF;
                IF new=1 THEN
                    INSERT INTO `chat`.`chatroom` (`id`,`username`,`content`) VALUES (0,'join',CONCAT(u,' has joined the chat room.'));
                ELSEIF new>1 THEN
                    INSERT INTO `chat`.`privchatroom` (`id`,`username`,`content`,`room`) VALUES (0,'join',CONCAT(u,' has joined the chat room.'),new);
                ELSE INSERT INTO `chat`.`errors` (`id`,`data`) VALUES (0,CONCAT('line 24 ',u,' ',new,' ',old));
                END IF;
            ELSE INSERT INTO `chat`.`errors` (`id`,`data`) VALUES (0,CONCAT('line 26 ',u,' ',new,' ',old));
            END IF;
        END IF;
        SET i = i + 1;
    END WHILE;
    UPDATE `chat`.`users` SET `lastactive`=`active`;
END $$
DELIMITER ;

CREATE DEFINER=`chatadmin`@`localhost` EVENT `moveroombot` ON SCHEDULE EVERY 1 SECOND STARTS '2018-03-26 09:36:34' ON COMPLETION NOT PRESERVE ENABLE DO CALL detectMove();*/
CREATE DEFINER=`chatadmin`@`localhost` EVENT `moveroombot` ON SCHEDULE EVERY 1 SECOND STARTS '2018-03-26 09:36:34' ON COMPLETION NOT PRESERVE ENABLE DO UPDATE `chat`.`users` SET `active`=-1 WHERE TIMESTAMPDIFF(second, `laston`, CURRENT_TIMESTAMP)>1;
SET GLOBAL event_scheduler = ON;

GRANT ALL PRIVILEGES ON `chat`.* TO `username`@`localhost` IDENTIFIED BY 'password';

INSERT INTO `chat`.`users` (`id`,`username`,`password`,`quirks`,`pending`,`ip`) VALUES (0,'INFO','no','E','','');
INSERT INTO `chat`.`users` (`id`,`username`,`password`,`quirks`,`pending`,`ip`) VALUES (0,'join','no','E','','');
INSERT INTO `chat`.`users` (`id`,`username`,`password`,`quirks`,`pending`,`ip`) VALUES (0,'left','no','E','','');
