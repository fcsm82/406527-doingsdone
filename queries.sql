USE doingsdone;
INSERT INTO users (email, name, password) VALUES
('user1@gmail.com','Brendan Rice', 'password1'),
('user2@gmail.com','Ryan Andrews', 'password2'),
('user3@gmail.com','Tyr Webb', 'password3');

INSERT INTO projects (name, user_id) VALUES
('Inbox', '1'),
('Education', '2'),
('Work', '1'),
('Home', '1'),
('Auto', '1');

INSERT INTO tasks (name, complete_time, term_time, is_completed, project_id, user_id) VALUES
('Interview in IT company', STR_TO_DATE('01.12.2018', '%d.%m.%Y'), NULL, 0, 3, 1),
('Perform a test task', NULL, STR_TO_DATE('25.12.2018', '%d.%m.%Y'), 0, 3, 1),
('Make the task of the first section', NULL, STR_TO_DATE('21.12.2018', '%d.%m.%Y'), 1, 2, 2),
('Meeting with a friend', NULL, STR_TO_DATE('22.12.2018', '%d.%m.%Y'), 0, 1, 1),
('Buy cat food', NULL, STR_TO_DATE('22.12.2018', '%d.%m.%Y'), 0, 4,1),
('Order pizza', NULL, NULL, 0, 4, 1);


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
SET @end_day = TIMESTAMP(@start_day, '23:59:59');
SELECT t.id, t.create_time, complete_time, is_completed, t.name, file, u.name AS user_name, p.name AS project_name FROM tasks t
JOIN users u ON t.user_id = u.id
JOIN projects p ON t.project_id = p.id
WHERE complete_time BETWEEN @start_day AND @end_day;

UPDATE tasks SET name = 'Interview'
WHERE id = 1;
