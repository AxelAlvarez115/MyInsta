<?php
function deleteLike($userId, $photoId, $pdo) {
    $stmt = $pdo->prepare("DELETE FROM likes WHERE user_id = :user_id AND photo_id = :photo_id");
    $stmt->bindParam(':user_id', $userId);
    $stmt->bindParam(':photo_id', $photoId);
    return $stmt->execute();
}