<main class="content__main">
    <h2 class="content__main-heading">Добавление задачи</h2>

    <form class="form" action="add_task.php" method="post" enctype="multipart/form-data">
        <div class="form__row">
            <?php $classname = isset($errors['name']) ? 'form__input--error' : '';
            $value = $task_data['name'] ?? ''; ?>

            <label class="form__label" for="name">Название <sup>*</sup></label>
            <input class="form__input <?= $classname; ?>" type="text" name="name" id="name" value="<?= $value; ?>"
                   placeholder="Введите название">
            <?php if (isset($errors['name'])) : ?>
                <p class="form__message"><?= $errors['name']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <?php $classname = isset($errors['project']) ? 'form__input--error' : ''; ?>


            <label class="form__label" for="project">Проект <sup>*</sup></label>
            <select class="form__input form__input--select <?= $classname; ?>" name="project" id="project">
                <option></option>
                <?php foreach ($list_projects as $project): ?>
                    <option
                        value="<?= $project['id']; ?>" <?= (isset($task_data['project']) and $task_data['project'] === $project['id']) ? 'selected' : ''; ?> ><?= $project['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <?php if (isset($errors['project'])) : ?>
                <p class="form__message"><?= $errors['project']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>
            <?php $classname = isset($errors['date']) ? 'form__input--error' : '';
            $value = $task_data['date'] ?? ''; ?>

            <input class="form__input form__input--date <?= $classname; ?>" type="date" name="date" id="date"
                   value="<?= $value; ?>"
                   placeholder="Введите дату в формате ДД.ММ.ГГГГ">
            <?php if (isset($errors['date'])) : ?>
                <p class="form__message"><?= $errors['date']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <label class="form__label" for="preview">Файл</label>

            <?php $classname = isset($errors['file']) ? 'form__input--error' : '';
            $value = $task_data['preview'] ?? ''; ?>

            <div class="form__input-file">
                <input class="visually-hidden <?= $classname; ?>" type="file" name="preview" id="preview"
                       value="<?= $value ?>">
                <label class="button button--transparent" for="preview">
                    <span>Выберите файл</span>
                </label>
                <?php if (isset($errors['preview'])) : ?>
                    <p class="form__message"><?= $errors['preview']; ?></p>
                <?php endif; ?>
            </div>
        </div>
        <?= isset($errors) ? '<p class="form__message">Пожалуйста, исправьте ошибки в форме</p>' : ''; ?>
        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</main>
