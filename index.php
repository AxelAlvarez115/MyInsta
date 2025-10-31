<?php
    require_once './utils/db/connection.php';
    session_start();
?>
<?php
    require_once './utils/db/connection.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>MyInsta</title>
</head>
<body class="bg-black text-white min-h-screen relative">
    <?php require_once './partials/header.php'; ?>
    <main class="p-4">
        <?php include './views/profile.php'; ?>
        <h1 class="text-xl font-bold">Welcome to MyInsta</h1>
        <?php
            require_once './utils/photos/get_photo.php';
            $photos = getAllPhotos($pdo);
            foreach ($photos as $photo) {
                echo '<div class="mb-4">';
                echo '<img src="./assets/img/users/photos/' . htmlspecialchars($photo['link']) . '" alt="Photo" class="w-full rounded">';
                echo '</div>';
            }
        ?>
    </main>
    <?php require_once './partials/phone_menu.php'; ?>
    <?php require_once './partials/footer.php'; ?>
</body>
</html>