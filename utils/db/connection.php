<?php
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=myinsta', "root", "");
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
?>