<?php
$access_token = 'token';

$api = 'https://api.telegram.org/bot' . $access_token;
$output = json_decode(file_get_contents('php://input'), TRUE);
$chat_id = $output['message']['chat']['id'];
$message = $output['message']['text'];
$callback_query = $output['callback_query'];
$data = $callback_query['data'];

$message_id = ['callback_query']['message']['message_id'];
$chat_id_in = $callback_query['message']['chat']['id'];

switch($message) {
    case '/test':  
    
    $inline_button1 = array("text"=>"Google url","url"=>"http://google.com");
    
    $inline_button2 = array("text"=>"work plz","callback_data"=>'/plz');
    
    $inline_button3 = array("text"=>"Kisa Button","callback_data"=>'/kisa');
    
    $inline_keyboard = [[$inline_button1,$inline_button2,$inline_button3]];
    
    $keyboard=array("inline_keyboard"=>$inline_keyboard);
    
    $replyMarkup = json_encode($keyboard); 
    
    sendMessage($chat_id, "Работает!!!!", $replyMarkup);
    
    break;
   
}
switch($data){
    case '/plz': 
        $inline_button1 = array("text"=>"Тут ссылка","url"=>"https://vk.com/zalarudo");
        $inline_button2 = array("text"=>"а теперь напиши plz","callback_data"=>'/plz');
        $inline_button3 = array("text"=>"Kisa Button","callback_data"=>'/kisa');
        $inline_keyboard = [[$inline_button1,$inline_button2,$inline_button3]];
        $keyboard=array("inline_keyboard"=>$inline_keyboard);
        $replyMarkup = json_encode($keyboard);
        sendMessage($chat_id_in, "Бронтозавр", $replyMarkup);
        break;
  
    case '/kisa': 
        $inline_button1 = array("text"=>"Тут ссылка","url"=>"https://vk.com/zalarudo");
        $inline_button2 = array("text"=>"а теперь напиши plz","callback_data"=>'/plz');
        $inline_button3 = array("text"=>"Kisa Button","callback_data"=>'/kisa');
        $inline_keyboard = [[$inline_button1,$inline_button2,$inline_button3]];
        $keyboard=array("inline_keyboard"=>$inline_keyboard);
        $replyMarkup = json_encode($keyboard);
        sendMessage($chat_id_in, "asdasd", $replyMarkup);
        break;
        
}
function sendMessage($chat_id, $message, $replyMarkup) {
    file_get_contents($GLOBALS['api'] . '/sendMessage?chat_id=' . $chat_id . '&text=' . urlencode($message) . '&reply_markup=' . $replyMarkup);
}
?>
