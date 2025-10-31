<?php
    function deleteComment($id, $pdo) {
        $stmt = $pdo->prepare("DELETE FROM comments WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
?>