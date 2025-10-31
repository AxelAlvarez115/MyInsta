<?php
$host = 'localhost';
$db   = 'myinsta';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    try {
        $pdo = new PDO('mysql:host=localhost;dbname=myinsta', "root", "");
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
?>