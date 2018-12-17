<?php

function changeTaskStatus($task, $status, $connection)
{
    $sql =
        "UPDATE tasks SET is_completed = ?, complete_time = ? ".
        "WHERE id = ?";

    if ($status == 0) {
        $status = 1;
        $complete_time = (new DateTime())->format('Y-m-d H:i:s');
    } else {
        $status = 0;

        // Необходимо записать в БД null! Не работает!
        $complete_time = (new DateTime('12.12.2012'))->format('Y-m-d H:i:s');
    }

    $values =
        [
            $status,
            $complete_time,
            $task['id']
        ];


    dbInsertData($connection, $sql, $values);
}

function changeShowTasks($show_complete_tasks)
{
    if ($show_complete_tasks === '0') {
        return '1';
    }
    return '0';
}
