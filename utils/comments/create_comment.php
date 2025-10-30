<?php
    function createComment($photoId, $userId, $content, $pdo) {
        $stmt = $pdo->prepare("INSERT INTO comments (photo_id, user_id, content) VALUES (:photo_id, :user_id, :content)");
        $stmt->bindParam(':photo_id', $photoId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':content', $content);
        return $stmt->execute();
    }
?>