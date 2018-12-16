<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
        <a href="/" class="tasks-switch__item">Повестка дня</a>
        <a href="/" class="tasks-switch__item">Завтра</a>
        <a href="/" class="tasks-switch__item">Просроченные</a>
    </nav>

    <label class="checkbox">
        <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
        <input class="checkbox__input visually-hidden show_completed" type="checkbox"
            <?php ($show_complete_tasks === 1) ? 'checked' : ''; ?>
        >
        <span class="checkbox__text">Показывать выполненные</span>
    </label>
</div>


<table class="tasks">
    <tr class="th__tasks">
        <th class="th__task">Задача</th>
        <th class="th__file">Файл</th>
        <th class="th__date">Дата создания</th>
        <th class="th__date">Срок выполнения</th>
        <th class="th__date">Дата выполнения</th>
        <th class="th__category">Категория</th>
    </tr>
    <?php foreach ($list_tasks as $task) : ?>
        <?php if ($task['is_completed'] === 0) : ?>
            <tr class="tasks__item tasks
            <?= isImportant($task['term_time']) ? 'task--important' : '' ?>
            ">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="1">
                        <span class="checkbox__text">
                            <?= $task['name']; ?>
                        </span>
                    </label>
                </td>
                <td class="task__file">
                     <a class="download-link" href="<?= $task['file']; ?>"><?= $task['file']; ?></a>
                </td>
                <td class="task__date"><?= formatTime($task['create_time']); ?></td>
                <td class="task__date"><?= formatTime($task['term_time']); ?></td>
                <td class="task__date"><?= formatTime($task['complete_time']); ?></td>
                <td class="task__category"><?= $task['project_name']; ?></td>
            </tr>
        <?php elseif ($show_complete_tasks === 1) : ?>
            <tr class="tasks__item task task--completed">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden" type="checkbox" checked>
                        <span class="checkbox__text"><?= $task['name']; ?></span>
                    </label>
                </td>
                <td class="task__file"><?= $task['file']; ?></td>
                <td class="task__date"><?= formatTime($task['create_time']); ?></td>
                <td class="task__date"><?= formatTime($task['term_time']); ?></td>
                <td class="task__date"><?= formatTime($task['complete_time']); ?></td>
                <td class="task__category"><?= $task['project_name']; ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>
