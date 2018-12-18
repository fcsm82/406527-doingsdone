<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.php" method="get">
    <input class="search-form__input" type="text" name="search" value="" placeholder="Поиск по задачам">
    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="<?= buildUrlForFilter(); ?>"
           class="tasks-switch__item <?= !isset($filter) || $filter === 'all' ? 'tasks-switch__item--active' : '' ?>">Все задачи</a>
        <a href="<?= buildUrlForFilter('today'); ?>"
           class="tasks-switch__item <?= $filter === 'today' ? 'tasks-switch__item--active' : '' ?>">Повестка дня</a>
        <a href="<?= buildUrlForFilter('tomorrow'); ?>"
           class="tasks-switch__item <?= $filter === 'tomorrow' ? 'tasks-switch__item--active' : '' ?>">Завтра</a>
        <a href="<?= buildUrlForFilter('overdue'); ?>"
           class="tasks-switch__item <?= $filter === 'overdue' ? 'tasks-switch__item--active' : '' ?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <a href="<?= buildUrlForComplete($show_complete_tasks); ?>">
            <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
            <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?= ($show_complete_tasks ===  '1') ? 'checked' : ''; ?>>
            <span class="checkbox__text">Показывать выполненные</span>
        </a>
    </label>
</div>


<p>Ничего не найдено по вашему запросу</p>
