<h2 class="content__main-heading">List of tasks</h2>

<form class="search-form" action="index.php" method="get">
    <input class="search-form__input" type="text" name="search" value="" placeholder="Search by tasks">
    <input class="search-form__submit" type="submit" name="" value="Search">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="<?= buildUrlForFilter(); ?>"
           class="tasks-switch__item <?= !isset($filter) || $filter === 'all' ? 'tasks-switch__item--active' : '' ?>">All tasks</a>
        <a href="<?= buildUrlForFilter('today'); ?>"
           class="tasks-switch__item <?= $filter === 'today' ? 'tasks-switch__item--active' : '' ?>">Agenda</a>
        <a href="<?= buildUrlForFilter('tomorrow'); ?>"
           class="tasks-switch__item <?= $filter === 'tomorrow' ? 'tasks-switch__item--active' : '' ?>">Tomorrow</a>
        <a href="<?= buildUrlForFilter('overdue'); ?>"
           class="tasks-switch__item <?= $filter === 'overdue' ? 'tasks-switch__item--active' : '' ?>">Overdue</a>
    </nav>

    <label class="checkbox">
        <a href="<?= buildUrlForComplete($show_complete_tasks); ?>">
            <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
            <input class="checkbox__input visually-hidden show_completed"
                   type="checkbox" <?= ($show_complete_tasks === '1') ? 'checked' : ''; ?>>
            <span class="checkbox__text">Show completed</span>
        </a>
    </label>
</div>


<table class="tasks">
    <?php foreach ($list_tasks as $task) : ?>
        <?php if ($task['is_completed'] === 0 || $show_complete_tasks === '1') : ?>
            <tr class="tasks__item task
                <?= isImportant($task['term_time']) && $task['is_completed'] === 0 ? 'task--important' : '' ?>
                <?= $task['is_completed'] === 1 ? 'task--completed' : ''; ?>
            ">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <a href="<?= buildUrlForTasks($task['id'], $task['is_completed'], 'change-status.php'); ?>">
                            <input class="checkbox__input visually-hidden"
                                   type="checkbox" <?= $task['is_completed'] === 1 ? 'checked' : ''; ?>>
                            <span class="checkbox__text"><?= $task['name']; ?></span>
                        </a>
                    </label>
                </td>

                <td class="task__file">
                    <a href="<?= $task['file']; ?>"><?= $task['file']; ?></a>
                </td>

                <td class="task__date"><?= formatTime($task['term_time']); ?></td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>
