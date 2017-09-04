<?php
/**
 * Created by PhpStorm.
 * User: sokolskih
 * Date: 11.08.2017
 * Time: 11:10
 */

include_once 'vkapi.php';

//размещает

//VkAPI::autorization();

;

// Проверяем загружен ли файл
if (is_uploaded_file($_FILES["img"]["tmp_name"])) {
    // Если файл загружен успешно, перемещаем его
    // из временной директории в конечную
    $randomName = rand(1000, 9999) . date('U') . ".jpg";
    move_uploaded_file($_FILES["img"]["tmp_name"], "img/" . $randomName);
} else {
    echo("Ошибка загрузки файла");
}


echo '<br>' . $randomName . '<br>';

$vk = new VkAPI();
$vk->user_id = 374378008;

$vk->addImage($randomName);


?>

<html>
<head></head>
<body>
<form action="/" method="post" enctype="multipart/form-data">

    <input type="file" name="img">
    <input type="submit">
</form>
</body>
</html>
