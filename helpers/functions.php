<?php
declare(strict_types=1);
function sanitizeInput($input): string 
{
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

function validateUsername(string $username): string
{
    if (!preg_match('/^[a-zA-Z0-9_]{3,20}$/', $username)) {
        return "Username must be 3-20 characters long and contain only letters, numbers, and underscores.";
    }
    return '';
}

function validateEmail(string $email): string
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return "Invalid email format.";
    }
    return '';
}
function validatePassword(string $password): string
{
    if (strlen($password) < 8 || !preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password)) {
        return "Password must be at least 8 characters long, contain one uppercase letter, and one number.";
    }
    return '';
}
?>