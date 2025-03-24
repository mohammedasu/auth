<?php
declare(strict_types=1);
require_once '../helpers/session.php';
SessionManager::start();
if (!SessionManager::get('user')) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Dashboard</h2>
        <p>Welcome, <?= htmlspecialchars(SessionManager::get('user')['username']); ?>!</p>
        <p><img src="<?= htmlspecialchars(SessionManager::get('user')['profile_image']); ?>" alt="User Image"></p>
        <a href="../controllers/AuthController.php?action=logout">Logout</a>
    </div>
    <script src="../assets/js/script.js"></script>
</body>
</html>
