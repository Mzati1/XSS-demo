<?php
$db = new SQLite3('database.db');

$db->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE,
    password TEXT,
    full_name TEXT,
    email TEXT
)");

$db->exec("CREATE TABLE IF NOT EXISTS products (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT,
    price REAL,
    description TEXT,
    image_url TEXT
)");

$db->exec("CREATE TABLE IF NOT EXISTS comments (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    product_id INTEGER,
    username TEXT,
    comment TEXT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(product_id) REFERENCES products(id)
)");

$res = $db->querySingle("SELECT COUNT(*) FROM users");
if ($res == 0) {
    $db->exec("INSERT INTO users (username, password, full_name, email) VALUES 
        ('admin', 'admin123', 'System Administrator', 'admin@gadgetstore.lab'),
        ('victim', 'password123', 'John Doe', 'john@example.lab')");
}

$res = $db->querySingle("SELECT COUNT(*) FROM products");
if ($res == 0) {
    $db->exec("INSERT INTO products (name, price, description, image_url) VALUES 
        ('Smart Watch X', 199.99, 'Advanced fitness tracker and notifications.', 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=300'),
        ('Noise Cancelling Headphones', 299.99, 'Immersive sound with active noise cancellation.', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=300'),
        ('Ultra Laptop Pro', 1299.99, 'High performance for creators and pros.', 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=300'),
        ('Wireless Gaming Mouse', 79.99, 'Precision and speed for gaming enthusiasts.', 'https://images.unsplash.com/photo-1527814050087-379371549a18?w=300'),
        ('Mechanical Keyboard RGB', 149.99, 'Customizable switches and backlighting.', 'https://images.unsplash.com/photo-1511467687858-23d96c32e4ae?w=300'),
        ('4K Ultra HD Monitor', 499.99, 'Stunning visuals for your workspace.', 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=300')");
}
?>
