
    <main class="content__main">
        <h2 class="content__main-heading">Регистрация аккаунта</h2>

        <?= isset($errors) ? '<p class="form__message">Пожалуйста, исправьте ошибки в форме</p>' : ""; ?>

        <form class="form" action="register.php" method="post">
            <div class="form__row">
                <?php $classname = isset($errors['email']) ? "form__input--error" : "";
                $value = isset($reg_data['email']) ? $reg_data['email'] : ""; ?>

                <label class="form__label" for="email">E-mail <sup>*</sup></label>
                <input class="form__input <?= $classname; ?>" type="text" name="email" id="email" value="<?= $value; ?>" placeholder="Введите e-mail">

                <?php if (isset($errors['email'])) : ?>
                    <p class="form__message"><?= $errors["email"]; ?></p>
                <?php endif; ?>
            </div>

            <div class="form__row">
                <?php $classname = isset($errors['password']) ? "form__input--error" : "";
                $value = isset($reg_data['password']) ? $reg_data['password'] : ""; ?>

                <label class="form__label" for="password">Пароль <sup>*</sup></label>
                <input class="form__input <?php $classname; ?>" type="password" name="password" id="password" value="<?= $value; ?>" placeholder="Введите пароль">

                <?php if (isset($errors['password'])) : ?>
                    <p class="form__message"><?= $errors["password"]; ?></p>
                <?php endif; ?>
            </div>

            <div class="form__row">
                <?php $classname = isset($errors['name']) ? "form__input--error" : "";
                $value = isset($reg_data['name']) ? $reg_data['name'] : ""; ?>

                <label class="form__label" for="name">Имя <sup>*</sup></label>
                <input class="form__input <?php $classname; ?>" type="text" name="name" id="name" value="<?= $value; ?>" placeholder="Введите имя">

                <?php if (isset($errors['name'])) : ?>
                    <p class="form__message"><?= $errors["name"]; ?></p>
                <?php endif; ?>
            </div>

            <div class="form__row form__row--controls">

                <input class="button" type="submit" name="" value="Зарегистрироваться">
            </div>


        </form>
    </main>
</div>
</div>

