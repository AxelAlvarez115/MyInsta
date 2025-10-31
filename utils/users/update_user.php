<?php
    function updateUsername($id, $newUsername, $pdo) {
        $stmt = $pdo->prepare("UPDATE users SET username = :username WHERE id = :id");
        $stmt->bindParam(':username', $newUsername);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    function updatePassword($id, $newPassword, $pdo) {
        $stmt = $pdo->prepare("UPDATE users SET password = :password WHERE id = :id");
        $stmt->bindParam(':password', password_hash($newPassword, PASSWORD_BCRYPT));
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
?>