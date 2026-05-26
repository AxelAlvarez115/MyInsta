<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: ../index.php?error=notloggedin");
    exit();
}

require_once '../utils/db/connection.php';

$userId   = (int) $_SESSION['user']['id'];
$username = trim($_POST['username'] ?? '');
$bio      = trim($_POST['bio']      ?? '');

/* ── Validation du pseudo ── */
if ($username === '') {
    header("Location: ../views/profile.php?error=emptyusername");
    exit();
}
if (mb_strlen($username) > 50) {
    header("Location: ../views/profile.php?error=usernametoolong");
    exit();
}

// Vérifier l'unicité si le pseudo a changé
if ($username !== $_SESSION['user']['username']) {
    $check = $pdo->prepare("SELECT id FROM users WHERE username = :u AND id != :id");
    $check->execute([':u' => $username, ':id' => $userId]);
    if ($check->fetch()) {
        header("Location: ../views/profile.php?error=usernametaken");
        exit();
    }
}

/* ── Upload avatar (optionnel) ── */
$newAvatar = null; // null = pas de changement

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] !== UPLOAD_ERR_NO_FILE) {

    $file = $_FILES['avatar'];

    if ($file['error'] !== UPLOAD_ERR_OK) {
        header("Location: ../views/profile.php?error=uploadfailed");
        exit();
    }

    $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $mime         = mime_content_type($file['tmp_name']);
    if (!in_array($mime, $allowedMimes)) {
        header("Location: ../views/profile.php?error=invalidfiletype");
        exit();
    }
    if ($file['size'] > 2 * 1024 * 1024) {
        header("Location: ../views/profile.php?error=filetoolarge");
        exit();
    }

    // Supprimer l'ancien avatar s'il existe
    if (!empty($_SESSION['user']['avatar'])) {
        $old = __DIR__ . '/../assets/img/users/avatars/' . $_SESSION['user']['avatar'];
        if (file_exists($old)) unlink($old);
    }

    // Enregistrer le nouveau fichier
    $ext       = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $newAvatar = 'avatar_' . $userId . '_' . md5(uniqid('', true)) . '.' . $ext;
    $dest      = __DIR__ . '/../assets/img/users/avatars/' . $newAvatar;

    if (!move_uploaded_file($file['tmp_name'], $dest)) {
        header("Location: ../views/profile.php?error=uploadfailed");
        exit();
    }
}

/* ── Mise à jour en base ── */
if ($newAvatar !== null) {
    $stmt = $pdo->prepare(
        "UPDATE users SET username = :username, bio = :bio, avatar = :avatar WHERE id = :id"
    );
    $stmt->execute([':username' => $username, ':bio' => $bio,
                    ':avatar'   => $newAvatar, ':id'  => $userId]);
    $_SESSION['user']['avatar'] = $newAvatar;
} else {
    $stmt = $pdo->prepare(
        "UPDATE users SET username = :username, bio = :bio WHERE id = :id"
    );
    $stmt->execute([':username' => $username, ':bio' => $bio, ':id' => $userId]);
}

/* ── Mise à jour de la session ── */
$_SESSION['user']['username'] = $username;

header("Location: ../views/profile.php?success=profileupdated");
exit();
