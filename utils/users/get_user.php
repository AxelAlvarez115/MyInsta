<?php
    function getUserByUsername($username, $pdo) {
        $stmt = $pdo->prepare("SELECT id, username FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    function getUserById($id, $pdo) {
        $stmt = $pdo->prepare("SELECT id, username FROM users WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
?>