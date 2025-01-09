<?php
$data = array_merge($_POST, $_GET);
$logFile = 'request_log.txt';
$logContent = date('Y-m-d H:i:s') . " - Request Data:\n";

foreach ($data as $key => $value) {
    if (is_array($value)) {
        $value = json_encode($value);
    }
    $logContent .= "$key: $value\n";
}

$logContent .= "------------------------\n";
file_put_contents($logFile, $logContent, FILE_APPEND);
