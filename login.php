<?php
session_start();
require_once 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $db->prepare("SELECT * FROM users WHERE username = :user AND password = :pass");
    $stmt->bindValue(':user', $username);
    $stmt->bindValue(':pass', $password);
    $result = $stmt->execute();
    $user = $result->fetchArray(SQLITE3_ASSOC);

    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['full_name'] = $user['full_name'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Gadget Store</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="index.php">Gadget Store</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Login</h2>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">Login</button>
                        </form>
                        <div class="text-center mt-4">
                            <p>Don't have an account? <a href="register.php" class="text-decoration-none">Register here</a></p>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-4 text-muted small">
                    <p>Try admin/admin123 or victim/password123</p>
                </div>
            </div>
        </div>
    </div>

    <footer class="mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; 2026 Gadget Store</p>
        </div>
    </footer>
</body>
</html>
