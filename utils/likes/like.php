<?php
header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/../db/connection.php';
require_once __DIR__ . '/get_like.php';
require_once __DIR__ . '/create_like.php';
require_once __DIR__ . '/delete_like.php';

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Non connecté']);
    exit();
}

$data    = json_decode(file_get_contents('php://input'), true);
$photoId = isset($data['photoId']) ? (int) $data['photoId'] : 0;

if ($photoId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Photo invalide']);
    exit();
}

$userId      = (int) $_SESSION['user']['id'];
$existingLike = getLikeByPhotoIdUserId($photoId, $userId, $pdo);

if ($existingLike) {
    deleteLike($userId, $photoId, $pdo);
    $liked = false;
} else {
    createLike($userId, $photoId, $pdo);
    $liked = true;
}

// Renvoie le nouveau compteur + l'état liked
$count = count(getLikesByPhotoId($photoId, $pdo));
echo json_encode(['liked' => $liked, 'count' => $count]);
