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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">Gadget Store</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li class="nav-item"><a class="nav-link" href="profile.php">Profile</a></li>
                        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link" href="register.php">Register</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <section class="search-results p-4 bg-white rounded shadow-sm">
            <div class="results-header mb-4 pb-3 border-bottom">
                <!-- VULNERABLE -->
                <h2 class="fw-bold">Search results for: <?php echo $query; ?></h2>
                <!-- FIX: <h2 class="fw-bold">Search results for: <?php echo htmlspecialchars($query, ENT_QUOTES, 'UTF-8'); ?></h2> -->
            </div>

            <div class="row g-4">
                <?php if (!empty($results)): ?>
                    <?php foreach ($results as $product): ?>
                        <div class="col-md-4">
                            <a href="product.php?id=<?php echo $product['id']; ?>" class="text-decoration-none text-dark">
                                <div class="card product-card h-100 shadow-sm border-0">
                                    <img src="<?php echo $product['image_url']; ?>" class="card-img-top" alt="<?php echo $product['name']; ?>">
                                    <div class="card-body text-center">
                                        <h5 class="card-title fw-bold"><?php echo $product['name']; ?></h5>
                                        <p class="product-price mb-2">$<?php echo $product['price']; ?></p>
                                        <p class="small text-muted mb-0"><?php echo $product['description']; ?></p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12 text-center py-5">
                        <p class="text-danger fw-bold fs-5">No products found matching your search. Try another query.</p>
                        <a href="index.php" class="btn btn-primary">Back to Home</a>
                    </div>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($results)): ?>
                <div class="text-center mt-5">
                    <a href="index.php" class="btn btn-outline-secondary">Back to Home</a>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <footer class="mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; 2026 Gadget Store</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
