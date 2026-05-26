<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Non connecté']);
    exit();
}

require_once __DIR__ . '/../db/connection.php';

$data    = json_decode(file_get_contents('php://input'), true);
$photoId = isset($data['photoId']) ? (int) $data['photoId'] : 0;
$content = isset($data['content'])  ? trim($data['content']) : '';

if ($photoId <= 0 || $content === '') {
    http_response_code(400);
    echo json_encode(['error' => 'Données invalides']);
    exit();
}

$userId = (int) $_SESSION['user']['id'];

$stmt = $pdo->prepare(
    "INSERT INTO comments (photo_id, user_id, content) VALUES (:photo_id, :user_id, :content)"
);
$stmt->bindParam(':photo_id', $photoId, PDO::PARAM_INT);
$stmt->bindParam(':user_id',  $userId,  PDO::PARAM_INT);
$stmt->bindParam(':content',  $content, PDO::PARAM_STR);

if ($stmt->execute()) {
    // Renvoie le nouveau commentaire avec le username
    $commentId = $pdo->lastInsertId();
    echo json_encode([
        'success'  => true,
        'comment'  => [
            'id'         => $commentId,
            'content'    => $content,
            'username'   => $_SESSION['user']['username'],
            'created_at' => date('Y-m-d H:i:s'),
        ]
    ]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur base de données']);
}
