<?php

/**
 * Фнукция загрузки файла
 * @param string $file_name имя файла из массива $_FILES
 * @param $file_tmp_name временное имя файла из массива $_FILES
 * @return bool Возращает true
 */
function uploadFile($file_name, $file_tmp_name)
{
    $target = APP_DIR .'/'. basename($file_name);
    move_uploaded_file($file_tmp_name, $target);
    return true;
}
