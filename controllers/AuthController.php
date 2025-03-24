<?php
declare(strict_types=1);

require_once '../config/database.php';
require_once '../helpers/functions.php';
require_once '../helpers/session.php';
require_once '../classes/Auth.php';

SessionManager::start();
$auth = new Auth();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])) {
    $action = $_POST["action"];

    if ($action === "register") {
        $username = $_POST["username"] ?? '';
        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';
        $profileImage = $_FILES["profile_image"] ?? null;
        echo json_encode($auth->register($username, $email, $password, $profileImage));
        exit;
    }

    if ($action === "login") {
        $email = $_POST["email"] ?? '';
        $password = $_POST["password"] ?? '';
        echo json_encode($auth->login($email, $password));
        exit;
    }
}
if ($_SERVER["REQUEST_METHOD"] === "GET") {
    if ($_GET["action"] === "logout") {
        $auth->logout();
        exit;
    }
}
?>