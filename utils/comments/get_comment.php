<?php
    function getCommentsByPhotoId($photoId, $pdo) {
        $stmt = $pdo->prepare("SELECT * FROM comments WHERE photo_id = :photo_id ORDER BY created_at DESC");
        $stmt->bindParam(':photo_id', $photoId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getCommentsCountByPhotoId($photoId, $pdo) {
        $stmt = $pdo->prepare("SELECT * FROM comments WHERE photo_id = :photo_id");
        $stmt->bindParam(':photo_id', $photoId);
        $stmt->execute();
        $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $stmt->rowCount();
    }
?>