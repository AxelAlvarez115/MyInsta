<?php
    if(isset($_POST['search_query'])){
        require_once '../utils/db/connection.php';

        $stmt = $pdo->prepare("SELECT * FROM photos WHERE description LIKE :query");
        $query = '%' . $_POST['search_query'] . '%';
        $stmt->bindParam(':query', $query);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($results) {
            session_start();
            $_SESSION['search_results'] = $results;
            header("Location: ../views/search.php?success=found");
        } else {
            session_start();
            $_SESSION['search_results'] = [];
            header("Location: ../views/search.php?error=nophotosfound");
        }

        exit();
    } else {
        header("Location: ../views/search.php?error=invalidinput");
        exit();
    }

?>