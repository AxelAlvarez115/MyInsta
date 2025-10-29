<?php
    function getAllPhotos($pdo) {

        $stmt = $pdo->prepare("SELECT * FROM photos");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
?>