CREATE DATABASE doingsdone
 DEFAULT CHARACTER SET utf8
 DEFAULT COLLATE utf8_general_ci;

USE doingsdone;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '' UNIQUE,
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `password` char(64) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`)
);

USE doingsdone;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) CHARACTER SET utf8 DEFAULT NULL UNIQUE,
  `user_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`)
);

USE doingsdone;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_complete` timestamp NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `name` varchar(128) DEFAULT NULL,
  `file` varchar(128) COLLATE utf8_bin DEFAULT '',
  `term` timestamp,
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
);