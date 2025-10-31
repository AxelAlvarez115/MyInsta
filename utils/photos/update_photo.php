<?php
    function updatePhotoDescription($id, $description, $pdo) {
        $stmt = $pdo->prepare("UPDATE photos SET description = :description WHERE id = :id");
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
?>