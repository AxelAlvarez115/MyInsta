<?php
    function getPhotoByDescription($description, $pdo) {
        $stmt = $pdo->prepare("SELECT * FROM photos WHERE description = :description");
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    function getUserPhotos($userId, $pdo) {
        $stmt = $pdo->prepare("SELECT * FROM photos WHERE user_id = :user_id");
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getAllPhotos($pdo) {
        $stmt = $pdo->prepare("SELECT * FROM photos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>