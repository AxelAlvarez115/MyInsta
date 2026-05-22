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

    function createComment($photoId, $userId, $content, $pdo) {
        $stmt = $pdo->prepare("INSERT INTO comments (photo_id, user_id, content) VALUES (:photo_id, :user_id, :content)");
        $stmt->bindParam(':photo_id', $photoId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':content', $content);
        return $stmt->execute();
    }

    function updateCommentContent($id, $content, $pdo) {
        $stmt = $pdo->prepare("UPDATE comments SET content = :content WHERE id = :id");
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    function deleteComment($id, $pdo) {
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
?>