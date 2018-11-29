CREATE DATABASE doingsdone
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE doingsdone;

CREATE TABLE users (
  id INT(11) NOT NULL AUTO_INCREMENT,
  create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  email VARCHAR(255) NOT NULL UNIQUE,
  name VARCHAR(255) NOT NULL,
  password VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
);

CREATE INDEX name_idx ON users(name);
CREATE INDEX create_time_idx ON users(create_time);

CREATE TABLE projects (
  id INT(11) NOT NULL AUTO_INCREMENT,
  name VARCHAR(64),
  user_id INT(11) NOT NULL,
  PRIMARY KEY (id)
);

CREATE INDEX name_idx ON projects(name);

ALTER TABLE projects
  ADD FOREIGN KEY (user_id)
    REFERENCES users(id);

ALTER TABLE projects
  ADD UNIQUE KEY user_id_name_udx (user_id, name);

CREATE TABLE tasks (
  id INT(11) NOT NULL AUTO_INCREMENT,
  create_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  complete_time TIMESTAMP NULL,
  is_completed TINYINT(1) DEFAULT 0,
  name VARCHAR(255),
  file VARCHAR(255),
  user_id INT(11) NOT NULL,
  project_id INT(11) NOT NULL,
  PRIMARY KEY (id)
);

CREATE INDEX create_time_idx ON tasks(create_time);
CREATE INDEX complete_time_idx ON tasks(complete_time);
CREATE INDEX is_completed_idx ON tasks(is_completed);

ALTER TABLE tasks
  ADD FOREIGN KEY (user_id)
    REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE tasks
  ADD FOREIGN KEY (project_id)
    REFERENCES projects(id) ON DELETE CASCADE ON UPDATE CASCADE;
