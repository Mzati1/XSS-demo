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
    <title>Login - Gadget Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Gadget Store</h1>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <h2>Login to your Account</h2>
            <?php if ($error): ?>
                <p style="color: red;"><?php echo $error; ?></p>
            <?php endif; ?>
            <form method="POST" class="login-form">
                <input type="text" name="username" placeholder="Username" required style="display: block; margin: 10px auto; padding: 10px; width: 300px;">
                <input type="password" name="password" placeholder="Password" required style="display: block; margin: 10px auto; padding: 10px; width: 300px;">
                <button type="submit">Login</button>
            </form>
            <p>Try admin/admin123 or victim/password123</p>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 Gadget Store</p>
        </div>
    </footer>
</body>
</html>
