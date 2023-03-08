<?php
// @php82 - @d666d6 //
ob_start();
$token = "5849683431:AAF9f5S4QZ7sNK1peNwo3knnj2TG_SB0pL8";
define('API_KEY', $token);
function bot($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/"
     .$method;
$ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}

$update = json_decode(file_get_contents('php://input'));
$message = $update->message;
$chat_id = $message->chat->id ?? $update->callback_query->message->chat->id;
$from_id = $message->from->id ?? $update->callback_query->from->id;
$text = $message->text;
$message_id = $message->message_id ?? $update->callback_query->message->message_id;
$name = $message->from->first_name ?? $update->callback_query->from->first_name;
$username = $message->from->username;
$data = $update->callback_query->data;
$php82 = file_get_contents("$from_id.txt");
if($text == "/start" or $text == "• رجوع ."){
	bot("sendmessage",[
	"chat_id"=>$chat_id,
	"text"=>"🎭┊ مرحبا عزيزي المطور العربي
⚙┊ انا بوت انشاء ويب هوك الحديث 💯
📫┊ فقط كل ماهو عليك التاكد من صحة المعلومات للملف المراد ربطه 
🔖┊ [@Abdalla94]",
        'parse_mode'=>'MarkDown',
	"reply_markup"=>json_encode([
	'keyboard'=>[
	[['text'=>"• عمل ويب هوك ."],['text'=>"• حذف ويب هوك ."]],
	[['text'=>"• معلومات التوكن ."]],
	],
	'resize_keyboard'=>true
	])
	]);
	}elseif($text == "• عمل ويب هوك ."){
					file_put_contents("$from_id.txt","url bot");
					bot("sendmessage",[
					"chat_id"=>$chat_id,
					"text"=>"• ارسل التوكن .",
					"reply_markup"=>json_encode([
					'keyboard'=>[
					[['text'=>"• رجوع ."]],
					],
					'resize_keyboard'=>true
					])
					]);
					}elseif($text and $php82 == "url bot"){
						file_put_contents("$from_id.txt","open url");
						file_put_contents("token".$from_id.".txt","$text");
						bot("sendmessage",[
						"chat_id"=>$chat_id,
						"text"=>"• ارسل رابط الملف .",
						"reply_markup"=>json_encode([
						'keyboard'=>[
						[['text'=>"• رجوع ."]],
						],
						'resize_keyboard'=>true
						])
						]);
						}elseif(preg_match("#http#",$text) and $php82 == "open url"){
							$tokenn = file_get_contents("token".$from_id.".txt");
							file_get_contents('https://api.telegram.org/bot'.$tokenn.'/setwebhook?url='.$text);
							bot("sendmessage",[
							"chat_id"=>$chat_id,
							"text"=>"• تم عمل ويب هوك .",
							"reply_markup"=>json_encode([
							'keyboard'=>[
							[['text'=>"• رجوع ."]],
							],
							'resize_keyboard'=>true
							])
							]);
							unlink("$from_id.txt");
							unlink("token".$from_id.".txt");
							}elseif($text == "• حذف ويب هوك ."){
								file_put_contents("$from_id.txt","del bot");
								bot("sendmessage",[
								"chat_id"=>$chat_id,
								"text"=>"• ارسل توكن بوت لحذفه ويب هوك .",
								"reply_markup"=>json_encode([
								'keyboard'=>[
								[['text'=>"• رجوع ."]],
								],
								'resize_keyboard'=>true
								])
								]);
								}elseif($text and $php82 == "del bot"){
									file_get_contents("https://api.telegram.org/bot$text/deletewebhook");
									bot("sendmessage",[
									"chat_id"=>$chat_id,
									"text"=>"• تم حذف ويب هوك",
									"reply_markup"=>json_encode([
									'keyboard'=>[
									[['text'=>"• رجوع ."]],
									],
									'resize_keyboard'=>true
									])
									]);unlink("$from_id.txt");
									}elseif($text == "• معلومات التوكن ."){
										file_put_contents("$from_id.txt","info token");
										bot("sendmessage",[
										"chat_id"=>$chat_id,
										"text"=>"• ارسل التوكن .",
										"reply_markup"=>json_encode([
										'keyboard'=>[
										[['text'=>"• رجوع ."]],
										],
										'resize_keyboard'=>true
										])
										]);
										}elseif($text and $php82 == "info token"){
											$json_info = json_decode(file_get_contents("https://api.telegram.org/bot".$text."/getMe"));
											$userr = $json_info->result->username;
											$nabot = $json_info->result->first_name;
											$idBot = $json_info->result->id;
											$botss = json_decode(file_get_contents("https://api.telegram.org/bot".$text."/getwebhookinfo"));
											if($botss->ok != 1){
												$Mohammed = "• توكن غير شغال .";
												}elseif($botss->ok == 1){
$Mohammed = "ℹ️•معلومات التوكن هي :\n™️• اسم البوت : ‹ $nabot › .\n🤖• يوزر البوت : ‹ @$userr › .\n🆔• ايدي البوت : ‹ $idBot › .\n🔗• رابط الملف : ".$botss->result->url."";             }
													bot("sendmessage",[
													"chat_id"=>$chat_id,
													"text"=> "$Mohammed",
													"reply_markup"=>json_encode([
													'keyboard'=>[
													[['text'=>"• رجوع ."]],
													],
													'resize_keyboard'=>true
													])
													]);
													unlink("$from_id.txt");
													}
?>