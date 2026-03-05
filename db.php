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
        ('admin', 'admin123', 'System Administrator', 'admin@gadgetstore.mw'),
        ('victim', 'password123', 'John Doe', 'john@example.mw')");
}

$res = $db->querySingle("SELECT COUNT(*) FROM products");
if ($res == 0) {
    $db->exec("INSERT INTO products (name, price, description, image_url) VALUES 
        ('Smart Watch X', 150000, 'Advanced fitness tracker and notifications.', 'https://images.unsplash.com/photo-1508685096489-7aacd43bd3b1?w=600&auto=format&fit=crop'),
        ('Noise Cancelling Headphones', 250000, 'Immersive sound with active noise cancellation.', 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=600&auto=format&fit=crop'),
        ('Ultra Laptop Pro', 1200000, 'High performance for creators and pros.', 'https://images.unsplash.com/photo-1496181133206-80ce9b88a853?w=600&auto=format&fit=crop'),
        ('Wireless Gaming Mouse', 45000, 'Precision and speed for gaming enthusiasts.', 'https://images.unsplash.com/photo-1615663248861-2446a855502a?w=600&auto=format&fit=crop'),
        ('Mechanical Keyboard RGB', 95000, 'Customizable switches and backlighting.', 'https://images.unsplash.com/photo-1511467687858-23d96c32e4ae?w=600&auto=format&fit=crop'),
        ('4K Ultra HD Monitor', 400000, 'Stunning visuals for your workspace.', 'https://images.unsplash.com/photo-1527443224154-c4a3942d3acf?w=600&auto=format&fit=crop')");
}
?>
