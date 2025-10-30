<?php
    function deletePhoto($id, $pdo) {
        $stmt = $pdo->prepare("DELETE FROM photos WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
?>