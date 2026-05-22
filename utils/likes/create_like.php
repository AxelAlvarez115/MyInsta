<?php
function createLike($userId, $photoId, $pdo) {
    $stmt = $pdo->prepare("INSERT INTO likes (user_id, photo_id) VALUES (:user_id, :photo_id)");
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':photo_id', $photoId);
    return $stmt->execute();
}