<?php
session_start();
require_once 'db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];

    if (empty($username) || empty($password) || empty($full_name) || empty($email)) {
        $error = "All fields are required.";
    } else {
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = :user");
        $stmt->bindValue(':user', $username);
        $count = $stmt->execute()->fetchArray()[0];

        if ($count > 0) {
            $error = "Username already exists.";
        } else {
            $stmt = $db->prepare("INSERT INTO users (username, password, full_name, email) VALUES (:user, :pass, :name, :email)");
            $stmt->bindValue(':user', $username);
            $stmt->bindValue(':pass', $password);
            $stmt->bindValue(':name', $full_name);
            $stmt->bindValue(':email', $email);
            
            if ($stmt->execute()) {
                $success = "Account created successfully! <a href='login.php'>Login here</a>.";
            } else {
                $error = "Registration failed.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Gadget Store</title>
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
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-3">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Create Account</h2>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="full_name" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" name="username" class="form-control" required>
                            </div>
                            <div class="mb-4">
                                <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2">Register</button>
                        </form>
                        <div class="text-center mt-4">
                            <p>Already have an account? <a href="login.php" class="text-decoration-none">Login here</a></p>
                        </div>
                    </div>
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
