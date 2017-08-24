<?php
/**
 * Created by PhpStorm.
 * User: sokolskih
 * Date: 11.08.2017
 * Time: 11:10
 */

include_once 'vkapi.php';



VkAPI::autorization();

/*$vk = new VkAPI();
//$vk->user_id=374378008;
$vk->user_id=17855170;

$vk ->addImage();
*/


?>

<html>
    <head></head>
    <body>
    <form action="" method="post" type="multipart/data" >
        <input type=file name=img>
        <input type=submit name=img_load>
    </form>
    </body>
</html>
