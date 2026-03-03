<?php
session_start();
require_once 'db.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';

$results = [];
if (!empty($query)) {
    $stmt = $db->prepare("SELECT * FROM products WHERE name LIKE :q OR description LIKE :q");
    $stmt->bindValue(':q', '%' . $query . '%');
    $res = $stmt->execute();
    while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
        $results[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Gadget Store</title>
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
        <section class="search-results">
            <div class="results-header">
                <!-- VULNERABLE: $query is echoed without htmlspecialchars() -->
                <!-- FIX: echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); -->
                <h2>Search results for: <?php echo $query; ?></h2>
            </div>

            <div class="product-grid">
                <?php if (!empty($results)): ?>
                    <?php foreach ($results as $product): ?>
                        <div class="product-card">
                            <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>">
                            <h4><?php echo $product['name']; ?></h4>
                            <p>$<?php echo $product['price']; ?></p>
                            <small><?php echo $product['description']; ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-results">No products found matching your search. Try another query.</p>
                <?php endif; ?>
            </div>
            
            <div style="margin-top: 40px; text-align: center;">
                <a href="index.php">Back to Home</a>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 Gadget Store</p>
        </div>
    </footer>
</body>
</html>
