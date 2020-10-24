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
            <input class="checkbox__input visually-hidden show_completed"
                   type="checkbox" <?= ($show_complete_tasks === '1') ? 'checked' : ''; ?>>
            <span class="checkbox__text">Show completed</span>
        </a>
    </label>
</div>


<p>Nothing found on your request</p>
