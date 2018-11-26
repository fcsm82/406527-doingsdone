USE doingsdone;
INSERT INTO users (email, name, password) VALUES
('user1@gmail.com','Brendan Rice', 'password1'),
('user2@gmail.com','Ryan Andrews', 'password2'),
('user3@gmail.com','Tyr Webb', 'password3');

INSERT INTO projects (name, user_id) VALUES
('Входящие', '1'),
('Учеба', '1'),
('Работа', '1'),
('Домашние дела', '1'),
('Авто', '1');

INSERT INTO tasks (name, term_time, is_completed, project_id, user_id) VALUES
('Собеседование в IT компании', STR_TO_DATE('01.12.2018', '%d.%m.%Y'), 0, 3, 1),
('Выполнить тестовое задание', STR_TO_DATE('25.12.2018', '%d.%m.%Y'), 0, 3, 1),
('Сделать задание первого раздела', STR_TO_DATE('21.12.2018', '%d.%m.%Y'), 1, 2, 1),
('Встреча с другом', STR_TO_DATE('22.12.2018', '%d.%m.%Y'), 0, 1, 1),
('Купить корм для кота', STR_TO_DATE('22.12.2018', '%d.%m.%Y'), 0, 4,1),
('Заказать пиццу', NULL, 0, 4, 1);


SELECT p.id, p.name, user_id, u.name FROM projects p
JOIN users u ON p.user_id = u.id
WHERE user_id = 1;

SELECT t.* FROM tasks t
JOIN users u ON t.user_id = u.id
JOIN projects p ON t.project_id = p.id
WHERE project_id = 3;

UPDATE tasks SET is_completed = 1
WHERE id = 1;

SET @start_day = TIMESTAMPADD(DAY, 1, CURDATE());
SET @end_day = TIMESTAMPADD(DAY, 1, @start_day);
SELECT t.id, t.create_time, complete_time, term_time, is_completed, t.name, file, u.name, p.name FROM tasks t
JOIN users u ON t.user_id = u.id
JOIN projects p ON t.project_id = p.id
WHERE term_time BETWEEN @start_day AND @end_day;

UPDATE tasks SET name = 'Собеседование'
WHERE id = 1;
