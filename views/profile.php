<?php
session_start();
if(!isset($_SESSION['user'])){
    header("Location: ../index.php");
    exit();
}
require_once '../utils/db/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>MyInsta Profile</title>
</head>
<body class="bg-black text-white min-h-screen relative">
    <?php include '../partials/header.php'; ?>
    <main class="p-4">
        <h1 class="text-xl font-bold">Welcome to MyInsta</h1>
        <div>
            <?php
                require_once '../utils/photos/get_photo.php';
                $userId = $_SESSION['user']['id'];
                $photos = getUserPhotos($userId, $pdo);
                foreach ($photos as $photo) {
                    echo '<div class="mb-4">';
                    echo '<h2 class="text-lg font-semibold mt-4 mb-2">' . htmlspecialchars($photo['description']) . '</h2>';
                    echo '<img src="../assets/img/users/photos/' . htmlspecialchars($photo['link']) . '" alt="Photo" class="w-full rounded">';
                    echo '</div>';
                }
            ?>
        </div>
        <button onclick="location.href='../process/logout.php'">
            <img class="cursor-pointer h-10 w-10" src="../assets/img/icons/buttons/logout.svg" alt="logout">
        </button>
    </main>
    <?php include '../partials/phone_menu.php'; ?>
    <?php include '../partials/footer.php'; ?>
</body>
</html>