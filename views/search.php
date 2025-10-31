<?php
session_start();
require_once '../utils/db/connection.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>MyInsta Search</title>
</head>
<body class="bg-black text-white min-h-screen relative">
    <?php include '../partials/header.php'; ?>
    <main class="p-4">
        <h1 class="text-xl font-bold">Search photos</h1>
        <form action="../process/search_photos.php" method="POST" class="mt-4">
            <input type="text" name="search_query" placeholder="Search..." class="p-2 rounded bg-gray-800 border border-gray-700">
            <button type="submit" class="p-2 bg-blue-600 rounded">Search</button>
        </form>
        <div class="mt-4">
            <?php
            if (isset($_SESSION['search_results'])) {
                include_once '../utils/users/get_user.php';
                $results = $_SESSION['search_results'];
                if (count($results) > 0) {
                    foreach ($results as $photo) {
                        $user = getUserById($photo['user_id'], $pdo);
                        echo '<div class="mb-4">';
                        echo '<img src="../assets/img/users/photos/' . htmlspecialchars($photo['link']) . '" alt="Photo" class="w-full rounded">';
                        echo '<p class="mt-2">Uploaded by: ' . htmlspecialchars($user['username']) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>No results found.</p>';
                }
                unset($_SESSION['search_results']);
            } else {
                echo '<p>No search performed yet.</p>';
            }
            ?>
        </div>
    </main>
    <?php include '../partials/phone_menu.php'; ?>
    <?php include '../partials/footer.php'; ?>
</body>
</html>