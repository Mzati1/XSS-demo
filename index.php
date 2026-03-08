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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body class="d-flex flex-column min-vh-100">
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">Gadget Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout (<?php echo $_SESSION['username']; ?>)</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-4 py-md-5">
        <section class="hero-section text-center p-4 p-md-5 mb-5">
            <h2 class="display-5 fw-bold mb-4">Find the latest gadgets!</h2>
            <div class="row justify-content-center">
                <div class="col-12 col-md-8">
                    <form action="search.php" method="GET" class="d-flex shadow-sm">
                        <input type="text" name="query" class="form-control form-control-lg border-end-0 rounded-start" placeholder="Search (e.g., iPhone, Laptop...)" required>
                        <button type="submit" class="btn btn-primary btn-lg rounded-end">Search</button>
                    </form>
                </div>
            </div>
        </section>

        <section>
            <h3 class="mb-4 fw-bold">Featured Products</h3>
            <div class="row g-3 g-md-4">
                <?php foreach ($products as $product): ?>
                    <div class="col-6 col-md-4">
                        <a href="product.php?id=<?php echo $product['id']; ?>" class="text-decoration-none text-dark">
                            <div class="card product-card h-100 shadow-sm border-0">
                                <img src="<?php echo $product['image_url']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                                <div class="card-body text-center p-2 p-md-3">
                                    <h6 class="card-title fw-bold mb-1"><?php echo $product['name']; ?></h6>
                                    <p class="product-price mb-0 small text-primary">MWK <?php echo number_format($product['price'], 0); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <footer class="mt-auto py-4">
        <div class="container text-center">
            <p class="mb-0 text-white-50">&copy; 2026 Gadget Store</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
