<?php
/**
 * Created by PhpStorm.
 * User: sokolskih
 * Date: 11.08.2017
 * Time: 13:13
 */

class VkAPI
{
   public $user_id='';
   public $album_id='';
   public $image_path='';
   public static $config=array(
       'client_id'=>'6155983',
       'redirect_uri'=> 'https://oauth.vk.com/blank.html',
       'protectedKey'=>'5iAFDZE5WdOcBNUcTXOa',
       'scope'=>'messages,wall');

    public static $access=['messages','photos','friends','wall','offline'];

    public $accessToken='fab0b9cb851b44969168c766a06b4b7afd99ab081e8f05734fdd574932d10fe36522bbd539fcfc47119b6';



   public $code='c8942b02834d1cfa86';


    public static function autorization()
    {
        header('HTTP/1.1 301 Moved Permanently');
       //echo  'Location: https://oauth.vk.com/authorize?client_id='.VkAPI::$config["client_id"].'&redirect_uri='.VkAPI::$config["redirect_uri"].'&response_type=token&v=5.67&scope='.implode(',', VkAPI::$access);
        header('Location: https://oauth.vk.com/authorize?client_id='.VkAPI::$config["client_id"].'&redirect_uri='.VkAPI::$config["redirect_uri"].'&response_type=token&v=5.67&display=popup&scope='.implode(',', VkAPI::$access));
    }

    public function getAccessToken(){
        $ch = curl_init();

// 2. указываем параметры, включая url
        curl_setopt($ch, CURLOPT_URL, 'https://oauth.vk.com/access_token?client_id='.VkAPI::$config["client_id"].'&client_secret='.VkAPI::$config["protectedKey"].'&redirect_uri='.VkAPI::$config["redirect_uri"].'&code='.$this->code);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

// 3. получаем HTML в качестве результата
        $output = curl_exec($ch);
        $output=json_decode($output);

        echo '<br>    ';
        var_dump($output);

        $this->accessToken=$output->access_token;
        echo '<br>';

// 4. закрываем соединение
        curl_close($ch);

    }

    public function addNotes(){
        $ch = curl_init();

// 2. указываем параметры, включая url
        curl_setopt($ch, CURLOPT_URL, 'https://api.vk.com/method/messages.send?uid=374378008&message=ХабраХабр&title=Заголовок&access_token='.$this->accessToken);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);

        $output = curl_exec($ch);
        $output=json_decode($output);

// 4. закрываем соединение
        curl_close($ch);

    }

    public function addImage()
    {
       $server= json_decode(file_get_contents("https://api.vk.com/method/photos.getWallUploadServer?access_token=".$this->accessToken.'&v=5.67'));
      var_dump($server->response);


        $ch = curl_init();
// 2. указываем параметры, включая url
        curl_setopt($ch, CURLOPT_URL, $server->response->upload_url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       // curl_setopt($ch, CURLOPT_HEADER, 0);


        $post = array(
            "photo"=>new CURLFile($_SERVER['DOCUMENT_ROOT']."/img/12.jpg")
        );
        var_dump($post);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $output = curl_exec($ch);
        $output=json_decode($output);

        echo '<br><br>';
        var_dump($output);

// 4. закрываем соединение
        curl_close($ch);


        $server= json_decode(file_get_contents("https://api.vk.com/method/photos.saveWallPhoto?access_token=".$this->accessToken.'&v=5.67&user_id='.$this->user_id.'&photo='.$output->photo.'&server='.$output->server.'&hash='.$output->hash));

        echo '<br><br>';
        echo "https://api.vk.com/method/photos.saveWallPhoto?access_token=".$this->accessToken.'&v=5.67&user_id='.$this->user_id.'&photo='.$output->photo.'&server='.$output->server.'&hash='.$output->hash;
        echo '<br><br>';
        var_dump($server->response[0]->id);



        $server= json_decode(file_get_contents("https://api.vk.com/method/wall.post?access_token=".$this->accessToken.'&v=5.67&owner_id='.$this->user_id.'&attachments=photo'.$this->user_id.'_'.$server->response[0]->id));

        echo '<br><br>';
        echo '<br><br>';
        var_dump($server);

    }

}