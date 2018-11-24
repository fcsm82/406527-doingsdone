CREATE DATABASE doingsdone
 DEFAULT CHARACTER SET utf8
 DEFAULT COLLATE utf8_general_ci;

CREATE TABLE `projects` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `project` varchar(64) CHARACTER SET utf8 DEFAULT NULL,
  `user_id` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `project` (`project`),
  KEY `project-user` (`user_id`),
  CONSTRAINT `project-user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
)

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_complete` timestamp NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `task` varchar(128) COLLATE utf8_bin DEFAULT NULL,
  `file` varchar(128) COLLATE utf8_bin DEFAULT '',
  `term` timestamp NULL DEFAULT NULL,
  `user_id` mediumint(8) NOT NULL,
  `project_id` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `date_complete` (`date_complete`,`status`,`term`),
  KEY `task-user` (`user_id`),
  KEY `task-project` (`project_id`),
  CONSTRAINT `task-project` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`),
  CONSTRAINT `task-user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
)

CREATE TABLE `users` (
  `id` mediumint(8) NOT NULL AUTO_INCREMENT,
  `date_create` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE utf8_bin NOT NULL DEFAULT '',
  `password` char(64) COLLATE utf8_bin NOT NULL,
  `task_name` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
)