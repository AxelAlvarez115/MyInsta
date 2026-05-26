<?php
header('Content-Type: application/json');
session_start();

require_once __DIR__ . '/../db/connection.php';

$photoId = isset($_GET['photo_id']) ? (int) $_GET['photo_id'] : 0;

if ($photoId <= 0) {
    http_response_code(400);
    echo json_encode(['error' => 'Photo invalide']);
    exit();
}

$stmt = $pdo->prepare(
    "SELECT c.id, c.content, c.created_at, u.username
     FROM comments c
     JOIN users u ON u.id = c.user_id
     WHERE c.photo_id = :photo_id
     ORDER BY c.created_at ASC"
);
$stmt->bindParam(':photo_id', $photoId, PDO::PARAM_INT);
$stmt->execute();
$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode(['comments' => $comments]);
