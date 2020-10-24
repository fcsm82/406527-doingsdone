<?php /** @noinspection PhpUndefinedClassInspection */

/**
 * Function to create file name
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
 * Function to load file
 * @param string $file_name file name from array $_FILES
 * @param $file_tmp_name temporary fie name from array $_FILES
 */
function uploadFile($file_name, $file_tmp_name)
{
    $target = APP_DIR . '/' . $file_name;
    $result = move_uploaded_file($file_tmp_name, $target);
    if (!$result) {
        die('Faied to load file');
    }
}

/**
 * Function to retrieve file name
 * @return string file name
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
