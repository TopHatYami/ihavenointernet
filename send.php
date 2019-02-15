<?php

$apiKey = "d9982ba0";
$apiSecret = "0fZtF4hqogcNNa50";
$text = "Tom+is+a+bumder";
$to = "447857084424";
$from = "NOINTERNET";

$url = 'https://rest.nexmo.com/sms/json?api_key='.$apiKey.'&api_secret='.$apiSecret.'&to='.$to.'&from='.$from.'&text='.$text;
$response = 'cake';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);

echo $response;
echo "$url";
echo "<br>EOF";
?>