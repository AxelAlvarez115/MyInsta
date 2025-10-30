<?php
    function createPhoto($userId, $description, $pdo) {
        $stmt = $pdo->prepare("INSERT INTO photos (user_id, description) VALUES (:user_id, :description)");
        $stmt->bindParam(':user_id', $userId);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }
?>