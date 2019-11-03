<?php

// URL API LINE
$API_URL = 'https://api.line.me/v2/bot/message';

// ใส่ Channel access token (long-lived)
$ACCESS_TOKEN = 'aKzc5i23vX0F/tdW0RUCyZSmGKnka5zFPCY9BYfkEHGOlIGSmpNFUB3R8sO2/z5MDez25561rdxlKjxqxpv3hgmr0+sDt51YKpC4/14WYn6y9CyeqmgaTE7A/e4R1b/XP5kYTZPCsHBGex7pN2OeVAdB04t89/1O/w1cDnyilFU=';

// ใส่ Channel Secret
$CHANNEL_SECRET = 'e715cd2d91d334b3d06410951c5c544f';

// Set HEADER
$POST_HEADER = array('Content-Type: application/json', 'Authorization: Bearer ' . $ACCESS_TOKEN);

// Get request content
$request = file_get_contents('php://input');

// Decode JSON to Array
$request_array = json_decode($request, true);

function send_reply_message($url, $post_header, $post_body)
	{
	    $ch = curl_init($url);
	    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $post_header);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_body);
	    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	    $result = curl_exec($ch);
	    curl_close($ch);

	    return $result;
	}

if ( sizeof($request_array['events']) > 0 ) {
      foreach ($request_array['events'] as $event) {
      
	      $reply_message = '';
	      $reply_token = $event['replyToken'];
	      $data = [
	         'replyToken' => $reply_token,
	         'messages' => [
	            ['type' => 'text', 
	             'text' => json_encode($request_array)]
	         ]
	      ];
	      $post_body = json_encode($data, JSON_UNESCAPED_UNICODE);
	      $send_result = send_reply_message($API_URL.'/reply', $POST_HEADER, $post_body);
	      echo "Result: ".$send_result."\r\n";
   		}
	}
	
echo "OK";