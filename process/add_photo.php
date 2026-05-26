<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php?error=notloggedin");
    exit();
}

if (!isset($_FILES['image']) || !isset($_POST['description'])) {
    header("Location: ../index.php?error=invalidinput");
    exit();
}

$file        = $_FILES['image'];
$description = trim($_POST['description']);

// Vérifications fichier
if ($file['error'] !== UPLOAD_ERR_OK) {
    header("Location: ../index.php?error=uploadfailed");
    exit();
}

$allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
$mime         = mime_content_type($file['tmp_name']);

if (!in_array($mime, $allowedMimes)) {
    header("Location: ../index.php?error=invalidfiletype");
    exit();
}

// Taille max : 5 Mo
if ($file['size'] > 5 * 1024 * 1024) {
    header("Location: ../index.php?error=filetoolarge");
    exit();
}

// Génération d'un nom unique
$extension = pathinfo($file['name'], PATHINFO_EXTENSION);
$fileName  = md5(uniqid('', true)) . '.' . strtolower($extension);
$uploadDir = __DIR__ . '/../assets/img/users/photos/';
$uploadPath = $uploadDir . $fileName;

if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
    header("Location: ../index.php?error=movefailed");
    exit();
}

// Insertion en base
require_once '../utils/db/connection.php';

$stmt = $pdo->prepare(
    "INSERT INTO photos (link, description, user_id) VALUES (:link, :description, :user_id)"
);
$stmt->bindParam(':link',        $fileName,                      PDO::PARAM_STR);
$stmt->bindParam(':description', $description,                   PDO::PARAM_STR);
$stmt->bindParam(':user_id',     $_SESSION['user']['id'],        PDO::PARAM_INT);

if ($stmt->execute()) {
    header("Location: ../views/profile.php?success=photoadded");
} else {
    // Supprime le fichier si l'insertion échoue
    unlink($uploadPath);
    header("Location: ../index.php?error=dberror");
}
exit();
