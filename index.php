<?php
session_start();
require_once 'db.php';

$products = [];
$res = $db->query("SELECT * FROM products");
while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
    $products[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gadget Store - Demo Lab</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Gadget Store</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li><a href="profile.php">Profile</a></li>
                        <li><a href="logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a></li>
                    <?php else: ?>
                        <li><a href="login.php">Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <h2>Find the latest gadgets!</h2>
            <form action="search.php" method="GET" class="search-form">
                <input type="text" name="query" placeholder="Search for products (e.g., iPhone, Laptop...)" required>
                <button type="submit">Search</button>
            </form>
        </section>

        <section class="featured">
            <h3>Featured Products</h3>
            <div class="product-grid">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                        <h4><?php echo $product['name']; ?></h4>
                        <p>$<?php echo $product['price']; ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 Gadget Store - Educational Demo Lab</p>
        </div>
    </footer>
    <script src="script.js"></script>
</body>
</html>
