<?php /** @noinspection PhpUndefinedClassInspection */

/**
 * Функция создания имени файла
 * @param $file_name
 * @return string
 */
function generateFileName($file_name)
{
    $info = new SplFileInfo($file_name);
    $ext = $info->getExtension();
    $name = $info->getBasename('.' . $ext);

    $count = 1;
    while (file_exists($file_name)) {
        $file_name = $name . $count . '.' . $ext;
        $count++;
    }

    return $file_name;
}

/**
 * Фнукция загрузки файла
 * @param string $file_name имя файла из массива $_FILES
 * @param $file_tmp_name временное имя файла из массива $_FILES
 */
function uploadFile($file_name, $file_tmp_name)
{
    $target = APP_DIR . '/' . $file_name;
    $result = move_uploaded_file($file_tmp_name, $target);
    if (!$result) {
        die('Ошибка загрузки файла');
    }
}

/**
 * Функция получения имени файла
 * @return string Имя файла
 */
function getFileName()
{
    if ((!isset($_FILES['preview']['name']) && !isset($_FILES['preview']['tmp_name'])) || !$_FILES['preview']['name']) {
        return '';
    }

    $file_tmp_name = $_FILES['preview']['tmp_name'];
    $file_name = generateFileName(basename($_FILES['preview']['name']));
    uploadFile($file_name, $file_tmp_name);

    return $file_name;
}
