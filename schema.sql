CREATE DATABASE doingsdone
 DEFAULT CHARACTER SET utf8
 DEFAULT COLLATE utf8_general_ci;

USE doingsdone;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(255) NOT NULL UNIQUE,
  `name` varchar(255) NOT NULL,
  `password` char(64) NOT NULL,
  PRIMARY KEY (`id`),
  KEY ind_email(email)
);

USE doingsdone;
CREATE TABLE `projects` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) UNIQUE,
  `user_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY ind_namel(name)
);

USE doingsdone;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_add` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_complete` timestamp,
  `status` tinyint(1) DEFAULT '0',
  `name` varchar(255),
  `file` varchar(255),
  `user_id` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY ind_status(status),
  KEY ind_datecomp(date_complete)
);