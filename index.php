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
                    <li><a href="#">Products</a></li>
                    <li><a href="#">Contact</a></li>
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
                <div class="product-card">
                    <img src="https://via.placeholder.com/150" alt="Product 1">
                    <h4>Smart Watch X</h4>
                    <p>$199.99</p>
                </div>
                <div class="product-card">
                    <img src="https://via.placeholder.com/150" alt="Product 2">
                    <h4>Noise Cancelling Headphones</h4>
                    <p>$299.99</p>
                </div>
                <div class="product-card">
                    <img src="https://via.placeholder.com/150" alt="Product 3">
                    <h4>Ultra Laptop Pro</h4>
                    <p>$1299.99</p>
                </div>
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
