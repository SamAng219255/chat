CREATE TABLE `users` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `password` varchar(64) NOT NULL,
  `quirks` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;
CREATE TABLE `chatroom` (
  `id` int(16) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4;

GRANT ALL PRIVILEGES ON `chat`.* TO `chatter`@`localhost` IDENTIFIED BY 'GeArᛈᚨᛊᚹᚱᛥ';
GRANT ALL PRIVILEGES ON `chat`.* TO `chatadmin`@`localhost` IDENTIFIED BY 'autologicalis' WITH GRANT OPTION;
