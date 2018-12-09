<?php
/**
 * Функция валидации формы
 * @param array $fields Список полей формы
 * @return bool Возвращает True или False
 */
function isFormValid($fields)
{
    foreach ($fields as $field) {
        if (!isFieldValid($field)) {
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
function isFieldValid ($field)
{
    switch ($field) {
        case'name' :
            if (!isFieldFilled($field)) {
                return false;
            }

            if (isFieldLong($field, 255)) {
                return false;
            }

        /*case 'project' :
            if (!isProjectExist($field)) {
                return false;
            }*/

        /*case 'date' :
            if (!isDatevalid($field)) {
                return false;
            }*/

        case 'preview' :

//            $res = isFileUploaded($field);
//            var_dump($res);
//            die();

            if (isFileUploaded($field)) {
                $tmp_name = $_FILES[$field]['tmp_name'];
                $target = APP_DIR .'/'. basename($_FILES[$field]["name"]);
                move_uploaded_file($tmp_name, $target);

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

function isProjectExist ($field) {
    global $list_projects;
    foreach ($list_projects as $project) {
        if ($_POST[$field] === $project['id']) {
            return true;
        }
    }
    errorCollector($field, 'Проект сданным ID не существует');
    return false;
}

function isDateValid($field) {
    $format = 'd.m.Y';
    $d = date_create_from_format($format, $_POST[$field]);
    if (date_format($d, $format) !== $_POST[$field]) {
        errorCollector($field, 'Дата должна быть в формате "дд.мм.гггг" ');
        return false;
    }
    return true;
}

function isFileUploaded($field) {

    return isset($_FILES[$field]['name']) ? true : false;
}

function isFileTypeValid ($tmp_name, $type) {
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $file_type = finfo_file($finfo, $tmp_name);

    return ($file_type !== $type) ? false : true;
}

/**
 * Функция - сборщик ошибок при заполнении полей формы
 * @param string $field Имя поля в форме
 * @param string $text_error Сообщение об ошибке при заполнении поля формы
 * @return array/null $errors Возвращает массив с ошибками или null
 */
function errorCollector ($field, $text_error) {
    global $errors;
    $errors[$field] = $text_error;
    return $errors;
}
