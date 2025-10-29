<?php
    if(isset($_POST['photo_link']) && isset($_POST['description'])){
        require_once '../utils/db/connection.php';

        $stmt = $pdo->prepare("INSERT INTO photos (link, description, user_id) VALUES (:link, :description, :user_id)");
        $stmt->bindParam(':link', $_POST['photo_link']);
        $stmt->bindParam(':description', $_POST['description']);
        $stmt->bindParam(':user_id', $_SESSION['user_id']);
        $stmt->execute();

        header("Location: ../views/profile.php?success=photoadded");
        exit();
    } else {
        header("Location: ../views/profile.php?error=invalidinput");
        exit();
    }

?>