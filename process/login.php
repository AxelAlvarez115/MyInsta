<?php
session_start();

if (!isset($_POST['username'])) {
    header("Location: ../index.php?error=invalidinput");
    exit();
}

$username = trim($_POST['username']);

if (empty($username)) {
    header("Location: ../index.php?error=emptyusername");
    exit();
}

require_once '../utils/db/connection.php';

// Recherche de l'utilisateur par son pseudo
$stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
$stmt->bindParam(':username', $username);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    // Pseudo inconnu → on crée le compte automatiquement
    $stmt = $pdo->prepare("INSERT INTO users (username) VALUES (:username)");
    $stmt->bindParam(':username', $username);
    if (!$stmt->execute()) {
        header("Location: ../index.php?error=registrationfailed");
        exit();
    }
    $userId = $pdo->lastInsertId();
    $_SESSION['user']['id']       = $userId;
    $_SESSION['user']['username'] = $username;
    $_SESSION['user']['avatar']   = null;
    header("Location: ../index.php?success=registered");
} else {
    // Pseudo connu → connexion directe
    $_SESSION['user']['id']       = $user['id'];
    $_SESSION['user']['username'] = $user['username'];
    $_SESSION['user']['avatar']   = $user['avatar'] ?? null;
    header("Location: ../index.php?success=loggedin");
}

exit();
