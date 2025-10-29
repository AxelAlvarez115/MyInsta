<?php
if(!isset($_POST['username']) && !isset($_POST['password']) && !isset($_POST['confirm_password'])){
    header('Location: index.php?error=invalidinput');
    exit();
}

$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];

if ($password !== $confirm_password) {
    header('Location: index.php?error=passwordmismatch');
    exit();
}

$password = password_hash($password, PASSWORD_BCRYPT);
require_once '../utils/db/connection.php';

$checkUser = $pdo->prepare("SELECT id FROM users WHERE username = ?");
$checkUser->execute([$username]);

if ($checkUser->fetch()) {
    header('Location: index.php?error=userexists');
    exit();
}

$sql = "INSERT INTO users (username, password) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$username, $password])) {
    session_start();
    $_SESSION['user_id'] = $pdo->lastInsertId();
    $_SESSION['username'] = $username;
    header('Location: ../index.php?success=registered');
    exit();
} else {
    header('Location: ../index.php?error=registrationfailed');
    exit();
}
?>
