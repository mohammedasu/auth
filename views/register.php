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
    <title>Register</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Register</h2>
        <div id="registerMessage"></div>
        <form id="registerForm" enctype="multipart/form-data">
            <div class="input-group">
                <input type="text" name="username" id="username" placeholder="Username" required>
                <small class="error-message"></small>
            </div>
            <div class="input-group">
                <input type="email" name="email" id="email" placeholder="Email" required>
                <small class="error-message"></small>
            </div>
            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <small class="error-message"></small>
            </div>
            <div class="input-group">
                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
                <small class="error-message"></small>
            </div>
            <div class="input-group">
                <input type="file" id="profile_image" name="profile_image" accept="image/*" required>
                <small class="error-message"></small>
            </div>
            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
    <script src="../assets/js/script.js"></script>
</body>
</html>
