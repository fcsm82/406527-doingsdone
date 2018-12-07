<main class="content__main">
    <h2 class="content__main-heading">Добавление задачи</h2>

    <form class="form" action="add.php" method="post" formenctype="multipart/form-data">
        <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>
            <input class="form__input <?= $classname?>" type="text" name="name" id="name" value="" placeholder="Введите название">
            <p class="form__message"><?= $input_error['name'];?></p>
        </div>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>
            <select class="form__input form__input--select" name="project" id="project">
                <option value="<?= null; ?>"></option>
                <?php foreach ($list_projects as $project): ?>

                    <option value="<?= $project['id']; ?>"><?= $project['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date" type="date" name="date" id="date" value=""
                   placeholder="Введите дату в формате ДД.ММ.ГГГГ">
            <p class="form__message"><?= $input_error['date'];?></p>
        </div>

        <div class="form__row">
            <label class="form__label" for="preview">Файл</label>

            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="preview" id="preview" value="">

                <label class="button button--transparent" for="preview">
                    <span>Выберите файл</span>
                </label>
                <p class="form__message"><?= $input_error['preview'];?></p>
            </div>
        </div>
        <?= $error; ?>
        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</main>
