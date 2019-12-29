<?php
require "telegrammbot.php";

$source = file_get_contents('php://input');
$requestBody = json_decode($source, true);
//writeToLog($source);
writeToLog($requestBody);

if(isset($_GET['cron']) && $_GET['cron'] == 'true'){

    writeToLog('СОБЫТИЕ ИЗ ПЛАНИРОВЩИКА - ОБРАТИТЬ ВНИМАНИЕ !');

}

function writeToLog($data, $title = '')
{
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
    $log .= print_r($data, 1);
    $log .= "\n------------------------\n";
    file_put_contents(getcwd() . '/hooktelg.log', $log, FILE_APPEND);
    return true;
}


$datakonv = file_get_contents("https://konverbot.net/chatbot/konverbot-new-2/?skey=b929a3af31a2c4d3ab72be8706f2ab46&test_export_json");
$decdata = json_decode($datakonv);
//echo "<pre>";
//print_r($decdata);
$quest = $decdata -> konverbot_questions;



$bot = new BOT();

$output = json_decode(file_get_contents('php://input'),true);
$chat_id = @$output['message']['chat']['id'];
$user_id = @$output['message']['from']['id'];
$username = @$output['message']['from']['username'];
$first_name = @$output['message']['chat']['first_name'];
$last_name = @$output['message']['chat']['last_name'];
$chat_time = @$output['message']['date'];
$message = @$output['message']['text'];
$msg = mb_strtolower(@$output['message']['text'], "utf8");

$callback_query = @$output["callvback_query"];
$data = $callback_query['data'];

$message_id = $callback_query['message']['message_id'];
$chat_id_in = $callback_query['message']['chat']['id'];






switch ($message){

//    case '/start' : $bot->sendMessage($user_id, "Привет " . $first_name); break;

    case '/start' : $bot->sendMessage($user_id, strip_tags($quest[0]->wpchatbot_question), [[$quest[0]->wpchatbot_answers[0]->wpchatbot_answer, 'Как меня зовут?'], ['Случайное число', 'Сотри кнопки']], ['keyboard', false, true], ['html', true]); break;


    case 'Привет бот' : $bot->sendMessage($user_id, "Привет " . $first_name, []); break;

    case 'Как меня зовут?' : $bot->sendMessage($user_id, "Тебя нарекли, как " . $first_name, []); break;

    case 'Случайное число' : $bot->sendMessage($user_id, "Число " . rand(1, 24444444), []); break;

    case 'Сотри кнопки' : $bot->sendMessage($user_id, "Пока кнопки", [0]); break;

    case $quest[0]->wpchatbot_answers[0]->wpchatbot_answer : $bot->sendMessage($user_id, strip_tags($quest[1]->wpchatbot_question), []); break;

    default: $bot->sendMessage($user_id, "Я хз что на это ответить");


}
