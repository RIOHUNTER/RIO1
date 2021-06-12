<?php 
$info = json_decode(file_get_contents('info.json'),true);
if(!file_exists('info.json')) { 
$token =  readline("- Enter Token : ");
$id = readline("- Enter Id Sudo : ");
$info["token"] = "$token";
file_put_contents('info.json', json_encode($info));
$info["id"] = "$id";
file_put_contents('info.json', json_encode($info));
if (!file_exists("token")) {
$token =  readline("- Enter Token : ");
file_put_contents("token", $token);
if (!file_exists("ID")) {
$id = readline("- Enter iD : ");
file_put_contents("ID", $id);
}
$token = $info["token"];
define('API_KEY',$token);
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
function stats($nn) {
$st = "";
$x = shell_exec("pm2 show $nn");
if(preg_match("/online/", $x)) {
$st = "run";
}else{
$st = "stop";
}
return $st;
}
$lastupdid = 1; 
while(true){ 
 $upd = bot("getUpdates", ["offset" => $lastupdid]); 
 if(isset($upd['result'][0])){ 
  $text = $upd['result'][0]['message']['text']; 
  $chat_id = $upd['result'][0]['message']['chat']['id']; 
$from_id = $upd['result'][0]['message']['from']['id']; 
$message = $upd['result'][0]['message']; 
$nn = bot('getme', ['bot']) ["result"]["username"];
$date = $update['callback_query']['data'];
$info = json_decode(file_get_contents('info.json'),true);
$value = "";
$admin = $info["id"];
if ($chat_id == $admin) {
if ($text == "/start") {
bot('sendMessage', [
'chat_id' => $chat_id,
'text' => "hi :)",
 'reply_markup' => json_encode(['resize_keyboard' => true, 'keyboard' => [
[["text" => "Run"], 
["text" => "Stop"]],
[["text" => "turbo info"]], 
[["text" => "Take in Account"], 
["text" => "Take in old channel"]], 
[["text" => "Pin User"], 
["text" => "unpin"]], 
[["text" => "login"]]
],
])
]);
}
if($text == "login") {
system('rm -rf *ma*');
file_put_contents("step","");
if(file_get_contents("step") == ""){
bot('sendmessage',[
'chat_id'=>$chat_id, 
'text'=>"Send me Number Phone\n ex +**",
]);
file_put_contents("step","2");
  system('php ph.php');
}
}
if ($text == "Take in Account") {
$type = file_get_contents("type");
file_put_contents("type", "a");
bot('sendMessage', [
'chat_id' => $chat_id, 
'text' => "Done Set Take in Account "]);
system("pm2 stop $nn");
system("pm2 start turbo.php --name $nn");
}
if($text == "Take in old channel") {
$type = file_get_contents("type");
file_put_contents("type", "old");
bot('sendMessage', [
'chat_id' => $chat_id, 
'text' => "Done Set Take in Old Channel .\n- Put old channel user  Ex => /old @user"]);
system("pm2 stop $nn");
system("pm2 start turbo.php --name $nn");
}
if($text == "turbo info") {
$type = file_get_contents("type");
$username = file_get_contents('user');
$st = stats($nn);
bot('sendMessage', [
'chat_id' => $chat_id, 
'text' => "Turbo Status : $st\ntype : $type\nusername : @$username .", 
]);
}
if (preg_match("/\/old @(.*)/", $text)) {
      $o = explode("@", $text) [1];
        file_put_contents("oldchannel", $o);
        bot('sendMessage', ['chat_id' => $chat_id, 'text' => "- Old channel : @$o ."]);
}
}
if($text == "Pin User"){
bot('sendMessage', [
'chat_id' => $chat_id, 
'text' =>" - Send Ex : /pin @R_3_O \n For pinned",
]);
}
if(preg_match("/\/pin(.*)/", $text)) {
$str = str_replace("@","",$text);
$ex = explode('/pin ',$str)[1];
file_put_contents("user",$ex);
bot('sendmessage',[
'chat_id'=>$chat_id,
'text'=>"done pin on @$ex",
]);
}
if($text == "unpin"){
	file_put_contents("user","");
bot('sendMessage', [
'chat_id' => $chat_id, 
'text' =>" Done unpin user",
]);
}
if ($text == "Run") {
system("pm2 stop $nn");
system("pm2 start turbo.php --name $nn");
bot('sendMessage', [
'chat_id' => $chat_id, 
'text' => "i'm Running"]);
}
if ($text == "Stop") {
system("pm2 stop $nn");
bot('sendMessage', [
'chat_id' => $chat_id, 
'text' => "Done stoped"]);
			}
		}
$lastupdid = $upd['result'][0]['update_id'] + 1; 
} 
}
}
