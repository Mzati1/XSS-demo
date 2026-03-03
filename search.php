<?php
// Fake product data for the lab
$products = [
    ['name' => 'Smart Watch X', 'price' => '$199.99', 'description' => 'Advanced fitness tracker and notifications.'],
    ['name' => 'Noise Cancelling Headphones', 'price' => '$299.99', 'description' => 'Immersive sound with active noise cancellation.'],
    ['name' => 'Ultra Laptop Pro', 'price' => '$1299.99', 'description' => 'High performance for creators and pros.'],
    ['name' => 'Wireless Gaming Mouse', 'price' => '$79.99', 'description' => 'Precision and speed for gaming enthusiasts.'],
    ['name' => 'Mechanical Keyboard RGB', 'price' => '$149.99', 'description' => 'Customizable switches and backlighting.'],
    ['name' => '4K Ultra HD Monitor', 'price' => '$499.99', 'description' => 'Stunning visuals for your workspace.'],
    ['name' => 'Portable Power Bank', 'price' => '$49.99', 'description' => 'Fast charging on the go for all devices.'],
    ['name' => 'Smart Home Speaker', 'price' => '$99.99', 'description' => 'Voice assistant for your connected home.'],
];

// Get search query from the URL parameter
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Function to filter products based on query
$results = [];
if (!empty($query)) {
    foreach ($products as $product) {
        if (stripos($product['name'], $query) !== false || stripos($product['description'], $query) !== false) {
            $results[] = $product;
        }
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
                    <li><a href="#">Products</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="search-results">
            <div class="results-header">
                <!-- VULNERABLE POINT: The search query is reflected directly back without sanitization -->
                <h2>Search results for: <?php echo $query; ?></h2>
            </div>

            <div class="product-grid">
                <?php if (!empty($results)): ?>
                    <?php foreach ($results as $product): ?>
                        <div class="product-card">
                            <img src="https://via.placeholder.com/150" alt="<?php echo $product['name']; ?>">
                            <h4><?php echo $product['name']; ?></h4>
                            <p><?php echo $product['price']; ?></p>
                            <small><?php echo $product['description']; ?></small>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p class="no-results">No products found matching your search. Try another query.</p>
                <?php endif; ?>
            </div>
            
            <div style="margin-top: 40px; text-align: center;">
                <a href="index.php" class="btn">Back to Home</a>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 Gadget Store - Educational Demo Lab</p>
        </div>
    </footer>
</body>
</html>
