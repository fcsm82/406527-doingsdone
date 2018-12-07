<?php
/**
 * Функция валидации формы
 * @param array $fields Список полей формы
 * @return bool Возвращает True или False
 */
function isFormValidated($fields)
{
    foreach ($fields as $field) {
        if (!isFieldValidated($field)) {
            return false;
        }
    }
    return true;
}

/**
 * Функция валидации поля формы
 * @param string $field Имя поля в форме
 * @return bool Возвращает True или False
 */
function isFieldValidated ($field) {
    switch ($field) {
        case $field = 'name' :
            if (!isFieldFilled($field)) {
                return false;
            }
            elseif (isFieldLong($field, 255)) {
                return false;
            }

        #case $field = 'project' :
        /*case $field = 'date' :
            if (!isDateFormated()) {
                return false;
            }*/
        case $field = 'file' :
            if (!isFileGood($field)) {
                return false;
            }
    }
    return true;
}

/**
 * Фукция проверки заполнения поля формы
 * @param string $field Имя поля в форме
 * @return bool Возвращает True или False
 */
function isFieldFilled($field) {
    if (empty($_POST[$field])) {
        errorCollector($field, 'Обязательное к заполнению поле');
        return false;
    }
    return true;
}

/**
 * Функция проверки длины поля формы
 * @param string $field Имя поля в форме
 * @param int $len Количество символов, которым ограничено поле формы
 * @return bool Возвращает True или False
 */
function isFieldLong($field, $len) {
    if (strlen($_POST[$field]) > $len) {
        errorCollector($field, 'Количество символов не может быть более '.$len);
        return true;
    }
    return false;
}

/**
 * Функция проверки файла
 * @param string $field Имя поля в форме
 * @return bool Возвращает True или False
 */
function isFileGood($field) {
    if (isset($_FILES['preview']['name'])) {
        $tmp_name = $_FILES['preview']['tmp_name'];
        $path = $_FILES['preview']['name'];
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $file_type = finfo_file($finfo, $tmp_name);

        if ($file_type !== "image/png") {
            errorCollector($field, 'Изображение должно быть в формате PNG');
            return false;
        }
        else {
            move_uploaded_file($tmp_name, APP__DIR . $path);
        }
    }
    return true;
}

/**
 * Функция - сборщик ошибок при заполнении полей формы
 * @param string $field Имя поля в форме
 * @param string $error Сообщение об ошибке при заполнении поля формы
 * @return array/null $input_error Возвращает массив с ошибками или null
 */
function errorCollector ($field, $error)
{
    global $input_error;
    $input_error[$field] = $error;
    return $input_error;
}
