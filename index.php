<?php
require __DIR__ . "/vendor/autoload.php";
use GuzzleHttp\Client;

//Routes
app()
->get("/", function () {
  response()->json(["message" => "Sepanodp BOT"]);
});
app()->get("/msg/{message}", function($message){
try {
    $client = new Client([
        // Base URI is used with relative requests
        "base_uri" => "https://api.telegram.org",
    ]);
 
    $bot_token = "6071884772:AAFGcE1FYhlVTOqN0sXyCaTvqUccpqQZrxA";
    $chat_id = "-365699282";
    $response = $client->request("GET", "/bot$bot_token/sendMessage", [
        "query" => [
            "chat_id" => $chat_id,
            "text" => $message
        ]
    ]);
 
    $body = $response->getBody();
    $arr_body = json_decode($body);
 
    if ($arr_body->ok) {
        echo "Message posted.";
    }
} catch(Exception $e) {
    echo $e->getMessage();
}
});

app()->get("/getList", function() {
$client = new Client([
        // Base URI is used with relative requests
        "base_uri" => "https://api.telegram.org",
]);
$bot_token = "6071884772:AAFGcE1FYhlVTOqN0sXyCaTvqUccpqQZrxA";


$response = $client->request("GET", "/bot$bot_token/getUpdates");
 
    $body = $response->getBody();
    $arr_body = json_decode($body);
 
    if (!($arr_body->ok)) {
        throw new Exception("The API token is invalid.");
    }
 
    if (empty($arr_body->result)) {
        throw new Exception("Please add this bot to a Telegram group or channel and promote as an admin.");
    }
 
    $arr_result = array();
    foreach ($arr_body->result as $result) {
        $arr_result[] = [
            'chat_id' => $result->message->chat->id,
            //'title' => $result->message->chat->title,
        ];
    }
 
    print_r($arr_result);
exit;	    
  response()->json(['message' => "Test OK"]);	
});


app()->run();
