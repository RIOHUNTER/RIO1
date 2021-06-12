<?php
date_default_timezone_set("Asia/Baghdad");
  if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
  }
  define('MADELINE_BRANCH', 'deprecated');
  include 'madeline.php';
  $settings['app_info']['api_id'] = 579315;
  $settings['app_info']['api_hash'] = '4ace69ed2f78cec268dc7483fd3d3424';
  $MadelineProto = new \danog\MadelineProto\API('c.madeline', $settings);
  $MadelineProto->start();
function bot($method, $datas = []) {
	$token = file_get_contents("token");
	$url = "https://api.telegram.org/bot$token/" . $method;
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $datas);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	$res = curl_exec($ch);
	curl_close($ch);
	return json_decode($res, true);
}
$type = file_get_contents("type");
if($type == "a"){
$x= 0;
while(1){
    $users = explode("\n",file_get_contents("user"));
    foreach($users as $user){
        if($user != ""){
            try{
            	$MadelineProto->messages->getPeerDialogs(['peers' => [$user], ]);
            	            	$x++;
            } catch (\danog\MadelineProto\Exception | \danog\MadelineProto\RPCErrorException $e) {
                    try{
                        $MadelineProto->account->updateUsername(['username'=>$user]);
bot('sendMessage', ['chat_id' => file_get_contents("ID"), 'text' => " @$user = $x ."]);
                        $data = str_replace("\n".$user,"", file_get_contents("user"));
                        file_put_contents("user", $data);
                        exit;
                            }catch(Exception $e){
                        echo $e->getMessage();
                            bot('sendMessage', ['chat_id' => file_get_contents("ID"), 'text' =>  "- @$user => ".$e->getMessage()
]);exit;
                        }

  
                    }
	        }
        }
    }
}
if($type == "old"){
    $o = file_get_contents("oldchannel");
    $x = 0;
while(1){
    $users = explode("\n",file_get_contents("user"));
    foreach($users as $user){
        if($user != ""){
            try{
            	$MadelineProto->messages->getPeerDialogs(['peers' => [$user]]);
                        	$x++;
            } catch (\danog\MadelineProto\Exception | \danog\MadelineProto\RPCErrorException $e) {
                    try{
                        $MadelineProto->channels->updateUsername(['channel' => $o, 'username' => $user]);
bot('sendMessage', ['chat_id' => file_get_contents("ID"), 'text' => "The username taken successfully ."]);
                        $MadelineProto->messages->sendMessage(['peer' => $o, 'message' => "Username Done : @$user
LooP's : $x "]);
                        $data = str_replace("\n".$user,"", file_get_contents("user"));
                        file_put_contents("user", $data);
                        exit;
                    }catch(Exception $e){
                            bot('sendMessage', ['chat_id' => file_get_contents("ID"), 'text' =>  "• ERROR - ".$e->getMessage()
]);exit;
                        }

  
                    }
	        }
        }
    }
}
