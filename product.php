<?php
session_start();
require_once 'db.php';

$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment']) && isset($_SESSION['username'])) {
    $comment = $_POST['comment'];
    $username = $_SESSION['username'];
    
    $stmt = $db->prepare("INSERT INTO comments (product_id, username, comment) VALUES (:pid, :user, :msg)");
    $stmt->bindValue(':pid', $product_id);
    $stmt->bindValue(':user', $username);
    $stmt->bindValue(':msg', $comment);
    $stmt->execute();
    header("Location: product.php?id=" . $product_id);
    exit;
}

$stmt = $db->prepare("SELECT * FROM products WHERE id = :id");
$stmt->bindValue(':id', $product_id);
$result = $stmt->execute();
$product = $result->fetchArray(SQLITE3_ASSOC);

if (!$product) {
    header("Location: index.php");
    exit;
}

$comments = [];
$stmt = $db->prepare("SELECT * FROM comments WHERE product_id = :id ORDER BY created_at DESC");
$stmt->bindValue(':id', $product_id);
$res = $stmt->execute();
while ($row = $res->fetchArray(SQLITE3_ASSOC)) {
    $comments[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $product['name']; ?> - Gadget Store</title>
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
        <div class="row">
            <div class="col-12">
                <!-- DOM-BASED -->
                <div id="promo-banner" class="mb-4"></div>
                <!-- VULNERABLE -->
                <script>
                    const urlParams = new URLSearchParams(window.location.search);
                    const promo = urlParams.get('promo');
                    if (promo) {
                        document.getElementById('promo-banner').innerHTML = '<div class="alert alert-warning"><strong>Special Offer:</strong> ' + promo + '</div>';
                        // FIX: document.getElementById('promo-banner').textContent = 'Special Offer: ' + promo;
                    }
                </script>
            </div>
        </div>

        <section class="product-detail bg-white p-3 p-md-5 rounded shadow-sm mb-5">
            <div class="row g-4 g-md-5 align-items-center">
                <div class="col-lg-6">
                    <img src="<?php echo $product['image_url']; ?>" alt="<?php echo $product['name']; ?>" class="img-fluid rounded shadow-sm w-100">
                </div>
                <div class="col-lg-6">
                    <h2 class="fw-bold mb-3"><?php echo $product['name']; ?></h2>
                    <p class="product-price display-6 mb-4 text-primary">MWK <?php echo number_format($product['price'], 2); ?></p>
                    <p class="lead text-muted mb-4"><?php echo $product['description']; ?></p>
                    <button class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-sm w-100 w-md-auto">Add to Cart</button>
                </div>
            </div>
        </section>

        <section class="comments-section">
            <h3 class="fw-bold mb-4">Customer Reviews</h3>
            
            <?php if (isset($_SESSION['username'])): ?>
                <div class="card border-0 shadow-sm mb-5">
                    <div class="card-body p-3 p-md-4">
                        <form method="POST">
                            <div class="mb-3">
                                <textarea name="comment" class="form-control" placeholder="Write your review..." rows="4" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary px-4">Post Review</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-info shadow-sm mb-5">
                    <a href="login.php" class="fw-bold text-decoration-none">Login</a> to leave a review.
                </div>
            <?php endif; ?>

            <div class="comments-list">
                <?php foreach ($comments as $c): ?>
                    <div class="card comment-card mb-4 border-0 shadow-sm">
                        <div class="card-body p-3 p-md-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold mb-0"><?php echo $c['username']; ?></h6>
                                <span class="text-muted small"><?php echo $c['created_at']; ?></span>
                            </div>
                            <!-- VULNERABLE -->
                            <p class="card-text mb-0"><?php echo $c['comment']; ?></p>
                            <!-- FIX: <p class="card-text mb-0"><?php echo htmlspecialchars($c['comment'], ENT_QUOTES, 'UTF-8'); ?></p> -->
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php if (empty($comments)): ?>
                    <div class="text-center py-5 text-muted">
                        <p class="fs-5 mb-0">No reviews yet.</p>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer class="mt-auto py-4">
        <div class="container text-center">
            <p class="mb-0 text-white-50">&copy; 2026 Gadget Store - Lilongwe, Malawi</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
