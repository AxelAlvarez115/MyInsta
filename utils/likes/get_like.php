<?php
function getLikesByPhotoId($photoId, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM likes WHERE photo_id = :photo_id");
    $stmt->bindParam(':photo_id', $photoId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getLikeByPhotoIdUserId($photoId, $userId, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM likes WHERE photo_id = :photo_id AND user_id = :user_id");
    $stmt->bindParam(':photo_id', $photoId);
    $stmt->bindParam(':user_id', $userId);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}