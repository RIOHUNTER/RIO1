<?php 
$info = json_decode(file_get_contents('info.json'),true);
$t = $info["token"];
define('API_KEY',$t);
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res,true);
    }
}
if (!file_exists('madeline.php')){
copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}
define('MADELINE_BRANCH', 'deprecated');
include 'madeline.php';
$settings['app_info']['api_id'] = 579315;
$settings['app_info']['api_hash'] = '4ace69ed2f78cec268dc7483fd3d3424';
$MadelineProto = new \danog\MadelineProto\API('c.madeline', $settings);
$lastupdid = 1; 
while(true){ 
 $upd = bot("getUpdates", ["offset" => $lastupdid]); 
 if(isset($upd['result'][0])){ 
  $text = $upd['result'][0]['message']['text']; 
  $chat_id = $upd['result'][0]['message']['chat']['id']; 
$from_id = $upd['result'][0]['message']['from']['id']; 
$message = $upd['result'][0]['message']; 

try{
if(file_get_contents("step") == "2"){
if($text !== "login"){
$MadelineProto->phone_login($text);
bot('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"Send Code Now ",
]);
file_put_contents("step","3");
}
}elseif(file_get_contents("step") == "3"){
if($text){
$authorization = $MadelineProto->complete_phone_login($text);
if ($authorization['_'] === 'account.password') {
bot('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"Send Account password",
]);
file_put_contents("step","4");
}else{
bot('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"Login Done",
]);
file_put_contents("step","");
exit;
}
}
}elseif(file_get_contents("step") == "4"){
if($text){
$authorization = $MadelineProto->complete_2fa_login($text);
bot('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"Login Done",
]);
file_put_contents("step","");
exit;
}
}
}catch(Exception $e) {
  bot('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"Try Again",
]);
exit;
}
$lastupdid = $upd['result'][0]['update_id'] + 1; 
} 
}
