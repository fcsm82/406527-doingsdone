<?php

/**
 * Function to change status of task
 * @param string $task
 * @param integer $status
 * @param mysqli object $connection Object of connection to DB
 * @throws Exception
 */
function changeTaskStatus($task, $status, $connection)
{

    $sql =
        'UPDATE tasks SET is_completed = ?, complete_time = ? ' .
        'WHERE id = ?';

    if ($status === 0) {
        $status = 1;
        $complete_time = (new DateTime())->format('Y-m-d H:i:s');

        $values =
            [
                $status,
                $complete_time,
                $task['id']
            ];
    } else {
        $sql =
            'UPDATE tasks SET is_completed = ?, complete_time = NULL ' .
            'WHERE id = ?';

        $status = 0;

        $values =
            [
                $status,
                $task['id']
            ];
    }

    dbInsertData($connection, $sql, $values);
}

/**
 * Function  to  show completed tasks
 * @param string $show_complete_tasks
 * @return string
 */
function changeShowTasks($show_complete_tasks)
{
    if ($show_complete_tasks === '0') {
        return '1';
    }
    return '0';
}
