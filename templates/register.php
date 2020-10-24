<main class="content__main">
    <h2 class="content__main-heading">Account registration</h2>

    <?= isset($errors) ? '<p class="form__message">Please correct the errors in the form</p>' : ''; ?>

    <form class="form" action="register.php" method="post">
        <div class="form__row">
            <?php $classname = isset($errors['email']) ? 'form__input--error' : '';
            $value = $reg_data['email'] ?? ''; ?>

            <label class="form__label" for="email">E-mail <sup>*</sup></label>
            <input class="form__input <?= $classname; ?>" type="text" name="email" id="email" value="<?= $value; ?>"
                   placeholder="Enter e-mail">

            <?php if (isset($errors['email'])) : ?>
                <p class="form__message"><?= $errors['email']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <?php $classname = isset($errors['password']) ? 'form__input--error' : '';
            $value = $reg_data['password'] ?? ''; ?>

            <label class="form__label" for="password">Password <sup>*</sup></label>
            <input class="form__input <?= $classname; ?>" type="password" name="password" id="password"
                   value="<?= $value; ?>" placeholder="Enter password">

            <?php if (isset($errors['password'])) : ?>
                <p class="form__message"><?= $errors['password']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form__row">
            <?php $classname = isset($errors['name']) ? 'form__input--error' : '';
            $value = $reg_data['name'] ?? ''; ?>

            <label class="form__label" for="name">Name <sup>*</sup></label>
            <input class="form__input <?= $classname; ?>" type="text" name="name" id="name" value="<?= $value; ?>"
                   placeholder="Введите имя">

            <?php if (isset($errors['name'])) : ?>
                <p class="form__message"><?= $errors['name']; ?></p>
            <?php endif; ?>
        </div>

        <div class="form__row form__row--controls">

            <input class="button" type="submit" name="" value="Signup">
        </div>


    </form>
</main>
</div>
</div>

