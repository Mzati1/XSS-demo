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
    <title>Profile - Gadget Store</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Gadget Store</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="hero">
            <?php if ($msg): ?>
                <!-- VULNERABLE: $msg is echoed without sanitization -->
                <!-- FIX: echo htmlspecialchars($msg, ENT_QUOTES, 'UTF-8'); -->
                <div style="background: #e8f5e9; padding: 10px; margin-bottom: 20px; border-radius: 5px;">
                    <?php echo $msg; ?>
                </div>
            <?php endif; ?>

            <h2>User Profile</h2>
            <div style="text-align: left; max-width: 400px; margin: 0 auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <p><strong>Username:</strong> <?php echo $user['username']; ?></p>
                <p><strong>Full Name:</strong> <?php echo $user['full_name']; ?></p>
                <p><strong>Email:</strong> <?php echo $user['email']; ?></p>
            </div>
            
            <p style="margin-top: 20px;">
                <a href="profile.php?msg=Profile%20refreshed%20at%20<?php echo date('H:i:s'); ?>">Refresh Profile Status</a>
            </p>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2026 Gadget Store</p>
        </div>
    </footer>
</body>
</html>
