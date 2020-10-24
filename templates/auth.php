<h2 class="content__main-heading">Login</h2>

<form class="form" action="auth.php" method="post">
    <div class="form__row">
        <?php $classname = isset($errors['email']) ? 'form__input--error' : '';
        $value = $auth_data['email'] ?? ''; ?>

        <label class="form__label" for="email">E-mail <sup>*</sup></label>
        <input class="form__input <?= $classname; ?>" type="text" name="email" id="email" value="<?= $value; ?>"
               placeholder="Enter e-mail">

        <?php if (isset($errors['email'])) : ?>
            <p class="form__message"><?= $errors['email']; ?></p>
        <?php endif; ?>
    </div>

    <div class="form__row">
        <?php $classname = isset($errors['password']) ? 'form__input--error' : '';
        $value = $auth_data['password'] ?? ''; ?>

        <label class="form__label" for="password">Password <sup>*</sup></label>
        <input class="form__input <?= $classname; ?>" type="password" name="password" id="password"
               value="<?= $value; ?>" placeholder="Enter password">

        <?php if (isset($errors['password'])) : ?>
            <p class="form__message"><?= $errors['password']; ?></p>
        <?php endif; ?>
    </div>

    <?php if (isset($errors)) : ?>
        <p class="form__message"><?= $form_message; ?></p>
    <?php endif; ?>

    <div class="form__row form__row--controls">
        <input class="button" type="submit" name="" value="Login">
    </div>
</form>
