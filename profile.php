<?php
session_start();
require_once 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$stmt = $db->prepare("SELECT * FROM users WHERE id = :id");
$stmt->bindValue(':id', $user_id);
$result = $stmt->execute();
$user = $result->fetchArray(SQLITE3_ASSOC);

$msg = isset($_GET['msg']) ? $_GET['msg'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Gadget Store</title>
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
                    <li class="nav-item"><a class="nav-link active" href="profile.php">Profile</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <?php if ($msg): ?>
                    <!-- VULNERABLE -->
                    <div class="alert alert-success shadow-sm mb-4"><?php echo $msg; ?></div>
                    <!-- FIX: <div class="alert alert-success shadow-sm mb-4"><?php echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); ?></div> -->
                <?php endif; ?>

                <div class="card shadow-sm border-0 rounded-3 overflow-hidden">
                    <div class="card-header bg-primary py-3">
                        <h4 class="mb-0 text-white fw-bold">User Profile</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-sm-4 text-muted">Username</div>
                            <div class="col-sm-8 fw-bold"><?php echo $user['username']; ?></div>
                        </div>
                        <div class="row mb-3 border-top pt-3">
                            <div class="col-sm-4 text-muted">Full Name</div>
                            <div class="col-sm-8 fw-bold"><?php echo $user['full_name']; ?></div>
                        </div>
                        <div class="row mb-3 border-top pt-3">
                            <div class="col-sm-4 text-muted">Email Address</div>
                            <div class="col-sm-8 fw-bold"><?php echo $user['email']; ?></div>
                        </div>
                    </div>
                    <div class="card-footer bg-light p-4 border-0 text-center">
                        <a href="profile.php?msg=Profile%20refreshed%20successfully!" class="btn btn-outline-primary rounded-pill px-4">Refresh Status</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; 2026 Gadget Store</p>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
