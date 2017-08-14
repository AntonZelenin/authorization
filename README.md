# authorization

CREATE TABLE `user_cookies` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `token` varchar(65) NOT NULL,
  `user_id` int(11) NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
)

CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(45) NOT NULL,
  `password` varchar(65) NOT NULL,
  `last_visit` datetime DEFAULT NULL,
  `last_attempt` datetime DEFAULT NULL,
  `attempts_count` int(11) DEFAULT '0',
  PRIMARY KEY (`id`)
)
