<?php
    require_once './utils/db/connection.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en" class="bg-black">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <title>MyInsta</title>
</head>
<body class="bg-black text-white min-h-screen relative">
    <?php require_once './partials/header.php'; ?>
    <main class="p-4">
       <form action="/action_page.php">
        <h1 class="flex gap-4 items-center justify-center mt-[2%] md-[5%] w-full
        text-[5vh] font-bold text-white">Hello, who are you?</h1>
            <div class="flex gap-4 items-center justify-center mt-[2%] md-[5%] w-full">
                <input
                class="bg-blue-50 rounded-[12px] text-black text-xl font-semibold text-[5vh]"
                type="text"
                id="uname"
                name="name"
                placeholder="Connection..." />
            </div>
       </form>
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