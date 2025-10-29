<?php
    if(isset($_POST['username']) && isset($_POST['password'])){
        require_once '../utils/db/connection.php';

        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $_POST['username']);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($_POST['password'], $user['password'])) {
            session_start();
            $_SESSION['user']['user_id'] = $user['id'];
            $_SESSION['user']['username'] = $user['username'];
            header("Location: ../index.php?success=loggedin");
        } else {
            header("Location: ../index.php?error=invalidcredentials");
        }

        exit();
    } else {
        header("Location: ../index.php?error=invalidinput");
        exit();
    }

?>