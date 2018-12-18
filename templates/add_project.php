<main class="content__main">
    <h2 class="content__main-heading">Добавление проекта</h2>

    <form class="form" action="add_project.php" method="post">
        <div class="form__row">
            <?php $classname = isset($errors['name']) ? 'form__input--error' : '';
            $value = $project_data['name'] ?? ''; ?>

            <label class="form__label" for="project_name">Название <sup>*</sup></label>
            <input class="form__input <?= $classname; ?>" type="text" name="name" id="project_name" value="<?= $value; ?>" placeholder="Введите название проекта">

            <?php if (isset($errors['name'])) : ?>
                <p class="form__message"><?= $errors['name']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="" value="Добавить">
        </div>
    </form>
</main>
