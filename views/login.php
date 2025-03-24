<?php
declare(strict_types=1);
require_once '../helpers/session.php';
SessionManager::start();
if (SessionManager::get('user')) {
    header('Location: dashboard.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <div id="loginMessage"></div>
        <form id="loginForm">
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <small class="error-message"></small>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <small class="error-message"></small>
            </div>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register</a></p>
    </div>
    <script src="../assets/js/script.js"></script>
</body>
</html>
